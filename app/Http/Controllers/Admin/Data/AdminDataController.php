<?php

namespace App\Http\Controllers\Admin\Data;

//use Carbon\Carbon;
//use App\Utils;
//use App\AdminUtils;
use App\Consts;     // 定数
//use App\Models\Item;
//use App\Models\ProductHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use Log;

class AdminDataController extends Controller
{
    protected $hash;        // 画面出力内容

    protected $item;
    private $table;
    private $key_columns = ['id'];
    private $encode_flg = false;  // 文字エンコードの変更を行ったかどうかのフラグ

    // csv管理
    public function index(Request $request)
    {
        $this->hash = $request->all();

        // DBテーブル一覧取得
        $tables = DB::select('SHOW TABLES');
        $this->hash['tables'] = [];
        foreach ($tables as $table) {
            array_push($this->hash['tables'], $table->{'Tables_in_'.env('DB_DATABASE')});
        }

        // ダウンロード
        if(@$this->hash['btn_download'] && @$this->hash['table']) {

            // 対象テーブルを配列で取得
            $tblobj = DB::table($this->hash['table'])->get();
            $tblArray = json_decode(json_encode($tblobj), true);

            $stream = fopen('php://temp', 'wb');

            // BOM書き込み(Excelで開くこともあるため)
            fwrite($stream, pack('C*',0xEF,0xBB,0xBF));

            // 環境をセット(local, staging, production...)
            fputcsv($stream, [config('app.env')]);

            // テーブル名のセット
            fputcsv($stream, [$this->hash['table']]);

            // カラム名セット
            $columns = DB::getSchemaBuilder()->getColumnListing($this->hash['table']);
            fputcsv($stream, $columns);

            // レコード取得
            foreach ($tblArray as $record) {
                fputcsv($stream, $record);
            }

            rewind($stream);
            $csv = str_replace(PHP_EOL, "\r\n", stream_get_contents($stream));
            $filename = config('app.env').'_'.$this->hash['table'].'_'.date('YmdHis').'.csv';
            return response($csv, 200, [
                'Content-Type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"'
            ]);

        // アップロード
        } elseif(@$this->hash['btn_upload']) {

            // request からファイル情報と更新処理を取得
            $file  = $request->file;
    
            // ファイル名からテーブル名取得
            $tmp = explode('_', $request->file->getClientOriginalName());
            array_pop($tmp); array_shift($tmp); 
            $this->table = join('_', $tmp);

            if(!$this->table) {
                $this->hash['complete_mess'] = "ファイル名の形式が正しくありません。(DBテーブル名を取得できませんでした。)";
                return view('admin.data.index')->with($this->hash);
            }

            // 処理対象テーブルのカラムを取得
            $tbl_columns = DB::getSchemaBuilder()->getColumnListing($this->table);

      /**
       * そのまま保存：utf-8 ¥t cr > SplFileObjectに食わせると文字列中のカンマだけ認識して分割する
       * csv 指定なし：sjis , crlf > 文字コード以外は正常
       * csv utf指定：utf-8 , cr > 細々と分解され1つの配列に並列で突っ込まれるが、文中のカンマはダブルクォートにより保護される
       */
      // タブ区切りになっていたらそのまま保存しているので別処理でファイルを取得して分解する
      $file_data = file_get_contents($file->getRealPath());
      preg_match_all('/\t/', $file_data, $match);
      // 閾値を(カラム数-1)*2で想定して、それより検出したタブ数が多ければそのまま保存したと判断する
      if (count($match[0]) >= ((count($tbl_columns)-1)*2)) {
        // 他処理と配列の深度を揃えておく
        $lines[][] = $file_data;
      } else {
        // csvファイル読み込み
        $fobj = new \SplFileObject($file->getRealPath());
        $fobj->setFlags(\SplFileObject::READ_CSV);
        $lines = [];
        // レコード単位で配列に格納（データがあれば）
        foreach ($fobj as $num => $line) {
          if (! is_null($line[0])) {
              $lines[] = $line;
          }
        }
      }

      // csvの改行コードがぶっ壊れる事があるので確認
      $lines = $this->checkUploadFile($lines, $tbl_columns);

      // bom付きだと保存先指定の判定で不正扱いになるので1レコード目の状態を判定し、必要に応じて削る
      if (count($lines) > 3) {
        if (!strcmp(ord($lines[0][0][0]),0xEF) &&
            !strcmp(ord($lines[0][0][1]),0xBB) &&
            !strcmp(ord($lines[0][0][2]),0xBF)) {
              $lines[0][0] = substr($lines[0][0], 3);
        }
      }

      // 1: 保存先の指定（ローカル、開発、本番、etc...）本処理対象と不一致の場合エラー
      $csv_env = array_shift($lines);
      if (trim($csv_env[0]) != config('app.env')) {
          $this->hash['complete_mess'] = "record 1 : 保存先DBの指定が不正です。"." env=" . config('app.env');
          return view('admin.data.index')->with($this->hash);
      }

      // 2: 指定テーブルと処理対象テーブルの比較 違うテーブルを対象にしたデータの場合エラー
      $csv_table = array_shift($lines);
      if (trim($csv_table[0]) != $this->table) {
          $this->hash['complete_mess'] = "record 2 : 保存先テーブルの指定が不正です。"." request=".$this->table;
          return view('admin.data.index')->with($this->hash);
      }

      // 3: カラム比較 指定テーブルと処理対象テーブルのカラムを比較し、違うカラムがあればエラー
      $csv_columns = array_shift($lines);
      if (array_diff($csv_columns, $tbl_columns)) {
          $error = json_encode([
              'csv_columns' => $csv_columns,
              'tbl_columns' => $tbl_columns
          ]);
          $this->hash['complete_mess'] = "record 3 : カラム名称が一致しません。".$error;
          return view('admin.data.index')->with($this->hash);
      }

      // 4: ファイルエンコードチェック
      // 内部定義をこの処理中変更する
      $ini_encode = mb_detect_order("UTF-8,SJIS-win,eucJP-win,jis");

      // 登録が発生する(かもしれない)ので文字コードチェックを実施する
      $lines = $this->checkEncode($lines,1);


//!!!
            // 処理対象データを元に戻す
            $records = $lines;

            // 5: records
            try {
                // トランザクション開始
                DB::beginTransaction();

                // 各種処理実施
                if ($this->hash['mode'] == 'delete') {
                    $this->deleteTable($records);
                } else {
                    $tbl_columns = DB::getSchemaBuilder()->getColumnListing($this->table);
                    $this->mergeTable($tbl_columns, $records);
                }
/*
                // 正式実装されるまでの回避としてセッションが存在しなければ「1」を入れる
                $regist_data = ['admins_id' => $request->session()->get('adminId', 1), 'action' => $this->hash['mode'], 'target' => $this->hash['table'], 'env' => env('APP_ENV', 'staging')];
                ProductHistory::registProductHistories($regist_data);
*/
                // コミット
                DB::commit();

            } catch (\Exception $e) {
                // ロールバック実施
                DB::rollback();
                Log::error($e->getMessage());
                $this->hash['complete_mess'] = "csvアップロード失敗しました。<br>".$e->getMessage();
                return view('admin.data.index')->with($this->hash);
            }
        }

        // メッセージ表示
        $this->hash['complete_mess'] = "csvアップロード処理が完了しました。";

        return view('admin.data.index')->with($this->hash);
    }


    /**
     * 更新、もしくは新規登録を行う
     * データの存在確認を行い、なければ新規、あれば更新
     */
    private function mergeTable($tbl_columns, $lines)
    {
//        $notnull_columns = AdminUtils::getNotNullColumns($this->table);
        $descs = DB::select('DESC '.'users');
        $notnull_columns = [];
        foreach ($descs as $desc) {
            if ($desc->Null == 'NO') {
                $notnull_columns[] = $desc->Field;
            }
        }

        foreach ($lines as $line) {
        if (count($tbl_columns) != count($line)) {
          throw new \Exception('invalid col length.' . json_encode($line));
        }
        $data = array_combine($tbl_columns, $line);

        // '' を  null に変換 (数値カラムに0が入ってしまうので)
        foreach ($data as $k => &$v) {
          if ($v == '' && ! in_array($k, $notnull_columns)) {
            $v = null;
          }
        }
        unset($v);

        // 取得用にキーをまとめる
        $where_arr = [];
        foreach ($this->key_columns as $column_name) {
          $where_arr[] = [$column_name, '=', $data[$column_name]];
        }
        $record = DB::table($this->table)->where($where_arr)->first();

        // 主キー指定OKになるので、空の場合のみサクるように変更
        if (isset($data['id']) && empty($data['id'])) {
            array_shift($data);
        }

        // データがなかったので新規
        if (is_null($record)) {
          // insert
          DB::table($this->table)->insert($data);

        // 更新
        } else {

         // update (変化無しでも1が返る)
         DB::table($this->table)->where($where_arr)->update($data);
/*
          if (DB::table($this->table)->where($where_arr)->update($data) != 1) {
              $view_data = join(", ", $data);
              throw new \Exception('update failed. ' . $view_data);
          }
*/
        }
        }
        return true;
    }
    /**
     * 削除処理（物理）
     * 論理の場合、カラム追加、各所フラグを見るように修正などが発生するので物理で行うこととなった。
     */
    private function deleteTable($lines)
    {
        foreach ($lines as $line) {
            // 取得用にキーをまとめる
            $where_arr = [];
            foreach ($this->key_columns as $key => $column_name) {
                $where_arr[] = [$column_name, '=', $line[$key]];
            }
            DB::table($this->table)->where($where_arr)->delete();
        }
        return true;
    }


    /**
     * 編集方法によってファイルが想定されていない形式でPOSTされて来るので確認、変更を行う
     * 問題が起こるパターン
     * パターン１：DLしたファイルをExcelで開き、編集して普通に保存しちゃった
     *      > カンマが消滅して保存される。$lineには区切りなしで1レコードになったデータが格納されて来る（はず）
     *      > これは excelとして保存されてしまっているらしいのでタブ区切りになっている
     *      > タブでバラして改行コード「CR」でレコードに分けて処理する
     * パターン２：DLしたファイルを「別名保存」で保存したが文字コードを変え忘れた
     *      > SJISになっている（MACでも）これはデータの形式としては正しいので文字コード判別処理でNG判定になる
     * パターン３：DLしたファイルを「別名保存」でUTF-8を指定して保存した
     *      > 改行コードが「CR」になって保存されている。一つの配列にデータが全て並列に格納されて来る
     *      > カンマ区切りではあるので「CR」でレコードに分けて処理する
     *
     * $lines array CSV全データ
     * $tbl_columns array 処理対象テーブルのカラム一覧
     */
    private function checkUploadFile($lines, $tbl_columns) {
      $line_cnt = 0;
      $new_lines = [];
      $new_line = [];
      foreach ($lines as $num => $line) {
        // 1レコード目はアップ先の環境指定なので、カラム数相当のカンマが入っていたとしてもカラム数を超えることはない
        if (count($tbl_columns) < count($line)) {
          // 一個ずつ置き換えが必要か判別して格納していく
          foreach ($line as $k => $v) {
            // 改行コードがぶっ壊れている可能性があるので改行コード「CR」を探して環境に合わせて置き直す
            if (!preg_match('/\r/', $v) && !preg_match('/\r\n/', $v)) {
              // 個別レコード用配列に格納
              $new_lines[$line_cnt][] = $this->actTrim($v);
            } else {
              if (preg_match('/\r/', $v) && !preg_match('/\r\n/', $v)) {
                // データ分割 最終列にはカンマが付かないので、次のレコードの先頭とデータがくっついている状態になっている
                $exp_v = preg_split('/\r/', $v);
              } elseif(preg_match('/\r\n/', $v)) {
                // データ分割 最終列にはカンマが付かないので、次のレコードの先頭とデータがくっついている状態になっている
                $exp_v = preg_split('/\r/', $v);
              }
              // 最終列の格納
              $new_lines[$line_cnt][] = $this->actTrim($exp_v[0]);
              // 全レコード用配列に格納
              if ($num > 3 && count($new_lines[$line_cnt]) != count($tbl_columns)) {
                unset($new_lines[$line_cnt]);
                continue;
              }
              // 格納先の変更
              $line_cnt++;
              // 先頭列の格納
              $new_lines[$line_cnt][] = $this->actTrim($exp_v[1]);
            }
          }
          // 1レコードになってるパターン
        } elseif (count($line) == 1) {
          // 「CR」にマッチすれば分解
          if (preg_match('/\r/', $line[0]) && !preg_match('/\r\n/', $line[0])) {
            $exp_v = preg_split('/\r/', $line[0]);
          } else if (preg_match('/\r\n/', $line[0])) {
            $exp_v = preg_split('/\r\n/', $line[0]);
          } else {
            continue;
          }
          // タブで分解して処理できる形式に直す
          foreach ($exp_v as $key => $value) {
            $exp_line = preg_split('/\t/', $value) ?? [];
            if ($key > 3 && count($exp_line) <= 1 && empty($exp_line[0])) {
              continue;
            }
            // trim
            foreach ($exp_line as $k => $v) {
              $exp_line[$k] = $this->actTrim($v);
            }
            $new_lines[] = $exp_line;
          }
        }
      }

      // 基本設定（対象環境、対象テーブル、対象テーブルカラムの３行）よりも多くデータを持っている場合は置き換え処理を行う
      if (count($new_lines) > 3) {
        unset($lines);
        $lines = $new_lines;
      }
      return $lines;
    }

     /**
      * csvで邪魔になりそうなダブルクォートを外す
      * 前後のダブルクォートの取り外しと文中にある連続したダブルクォートの置き換えを行う
      * 連続したダブルクォートはエクセルの仕様で保存時にダブルクォートが増えてしまう現象らしい
      * $data str or int 1セル分のデータ
      */
     private function actTrim($data)
     {
       // 前後のダブルクォートを外す
       $data = ltrim(rtrim($data, '"'), '"');
       // 文中で連続するダブルクォートがある場合はエクセルの仕様で増えちゃったやつなので削り取る
       $data = str_replace('""', '"', $data);

       return $data;
     }

     /**
      * 文字エンコードを判定して必要に応じて置き換える
      * $datas array csvの全データ
      * $mode int 0:判定のみ実施 1:コンバート実施
      */
     private function checkEncode($datas, $mode=0) {
       foreach ($datas as $key => $value) {
        // 処理対象が配列の場合、再帰的に分解して変換に掛ける
        if (is_array($value)) {
          // 中身を自身に投げ直して結果を格納する
          $datas[$key] = self::checkEncode($value, $mode);
        } else {
          // UTF-8にマッチしないエンコードが検出されたら置き換える
          if (strcmp(mb_detect_encoding($value), "UTF-8")) {
            // フラグを立てておく
            $this->encode_flg = true;
            // コンバートするなら
            if ($mode) {
              $convert_val = mb_convert_encoding($value, "UTF-8", mb_detect_encoding($value));
              $datas[$key] = $convert_val;
            }
          }
        }
      }
      return $datas;
    }

    /**
     * 登録済みデータと更新データの比較
     */
    private function checkChangeColumn($parentData, $updateData)
    {
    //getConnection
      // 親データを回しながら比較する
      $cnt = 0;
      // 結果格納
      $res_arr = [];
      // 差分があるかの確認フラグ
      $change_flg = false;

      foreach ($parentData as $key => $value) {
        if (!isset($updateData[$cnt])) return false;

        // datetime型は エクセルで開くと秒が欠落し全て差分になる、なので秒を除外して比較する
        if (($key == 'stg_view_daytime' || $key == 'prod_view_daytime')) {
          if (strcmp(date('Y-m-d H:i', strtotime($value)), date('Y-m-d H:i', strtotime($updateData[$cnt]))) ) {
              $res_arr[$cnt] = "change";
              $change_flg = true;
          }
        // 0:差分なし それ以外:差分あり
        } elseif (strcmp($value, $updateData[$cnt])) {
          // 差分がある場合、型チェック ...あとで
          $res_arr[$cnt] = "change";
          $change_flg = true;
        } else {
          $res_arr[$cnt] = "";
        }
        $cnt++;
      }
      // 変更ありなら配列を返す
      if ($change_flg) {
        return $res_arr;
      // 変更がなければfalseを返しておく
      } else {
        return false;
      }
    }

    /**
     * 処理するデータの中で同じレコードを更新しようとしているデータがないか確認する
     * $datas array 全レコード
     * $data array 個別レコード
     * 重複がなければfalse, 重複があればtrueを返す
     */
    private function duplicateEntryCheck($datas, $data)
    {
      // 出現回数カウント
      $cnt = 0;
      foreach ($datas as $key => $value) {
        if ($value[0] == $data[0]) {
          $cnt++;
        }
      }

      if ($cnt > 1) {
        return true;
      }
      return false;
    }

    /**
     * 登録内容に{{ }} が含まれていると画面が白くなるので事前にエスケープする
     */
     public function escapeBladeTag($obj)
     {
       // アクセス用にカラム取得
       $tbl_columns = DB::getSchemaBuilder()->getColumnListing($this->table);
       foreach ($obj as $key => $index) {
         foreach ($tbl_columns as $colmun) {
           $index->$colmun = str_ireplace('{{', '&#123;&nbsp;&#123;', $index->$colmun);
           $index->$colmun = str_ireplace('}}', '&#125;&nbsp;&#125;', $index->$colmun);
         }
       }
       return $obj;
     }

    /**
     * 本番へのデータ反映
     *  Stagingに登録されているデータを本番環境にコピーする
     *
     */
    public function updatePrdTable ()
    {
        $res = AdminUtils::copyToProduction($this->item);
        if($res['status'] == 'NG') {
          return AdminUtils::errRedirect($res['error_mess']);
        }
        return redirect()->route('admin.products.items')->with($res);
    }

}
