<?php

class Tenji {
    protected $save_dir ='./';
    const URL_LIST = [
        '01' => [ // 桐生
            'format' => 'http://www.kiryu-kyotei.com/modules/yosou/cyokuzen.php?&day=%d&race=%d&if=1',
            'regex'  => 'class="teiban com-val imp-num(\d+)".*?<li class="toban">(\d+)</li>.*?</ul></td><td class="com-val">([0-9]+[.]?[0-9]+|.*?)</td><td class="com-val">([0-9]+[.]?[0-9]+|.*?)</td><td class="com-val">([0-9]+[.]?[0-9]+|.*?)</td><td class="com-val">([0-9]+[.]?[0-9]+|.*?)</td><td class="com-val.*?">.*?</td><td class="com-val">([+-]?[0-9]+[.]?[0-9]|.*?)</td>',
        ],
        '02' => [], // 戸田
        #'03' => [], // 江戸川
        '04' => [ // 平和島
            'format' => 'http://www.heiwajima.gr.jp/asp/tbk/textvision/text/04%dsttenji.htm',
            'regex'  => '',
        ],
        #'05' => [], // 多摩川
        '06' => [ // 浜名湖(2018-01-13～)
            'format' => 'http://www.boatrace-hamanako.jp/modules/yosou/cyokuzen.php?page=cyokuzen&button=3&day=%s&race=%d',
            'regex'  => "class='col1 imp-num\d+ waku'>(\d+)</td>.*?<li class='com-toban'>(\d+)</li>.*?<td class='col-data'>.*?</td>.*?<td class='col-data'>.*?</td>.*?<td class='col-data'>(\d*?)</td>.*?<td class='col-data'>(.*?)</td>.*?<td class='col-data'>([+-]?[0-9]+[.]?[0-9]|.*?)</td>.*?<td class='col-data.color-rank\d*?' rowspan='2'>([0-9]+[.]?[0-9]+|.*?)</td>.*?<td class='col-data.color-rank\d*?' rowspan='2'>([0-9]+[.]?[0-9]+|.*?)</td><td class='col-data.color-rank\d*?' rowspan='2'>([0-9]+[.]?[0-9]+|.*?)</td><td class='col-data.color-rank\d*?' rowspan='2'>([0-9]+[.]?[0-9]+|.*?)</td>.*?<td class='col-data' rowspan='2'>.*?</td>",
        ],
        #'07' => [], // 蒲郡
        #'08' => [], // 常滑
        #'09' => [], // 津
        '10' => [ // 三国(2017-12-02～)
            'format' => 'http://www.boatrace-mikuni.jp/modules/yosou/group-cyokuzen.php?day=%s&race=%d&if=1&kind=2',
            'regex'  => '<td class="col1 tei_color\d+ waku .*?" rowspan="2">(\d+)</td>[\s\S]*?<li class=\'com-toban\'>(\d+)</li>[\s\S]*?<td class="col4" rowspan="2">([+-]?[0-9]+[.]?[0-9]|.*?)</td>[\s\S]*?<td class="col5.*?" rowspan="2">([0-9]+[.]?[0-9]+|.*?)</td>[\s\S]*?<td class="col6.*?" rowspan="2">([0-9]+[.]?[0-9]+|.*?)</td>[\s\S]*?<td class="col7.*?" rowspan="2">([0-9]+[.]?[0-9]+|.*?)</td>[\s\S]*?<td class="col8.*?" rowspan="2">([0-9]+[.]?[0-9]+|.*?)</td>',
        ],
        #'11' => [], // 琵琶湖
        #'12' => [], // 住之江
        #'13' => [], // 尼崎
        #'14' => [], // 鳴門
        '15' => [ // 丸亀
            'format' => 'http://www.br-special.jp/tenji-keisoku15/pc/?day=%s&race=%02d',
            'regex'  => "<th class='cel1 col(\d+)' rowspan='2'>.*?<span class='kyu'>(\d+)</span>.*?<td class='weight' '>(\d*)</td>.*?<td class='cel6' rowspan='2'>([+-]?[0-9]+[.]?[0-9]|.*?)</td><td class='cel9 \w*?' rowspan='2'>([0-9]+[.]?[0-9]+|.*?)</td><td class='cel7 \w*?' rowspan='2'>([0-9]+[.]?[0-9]+|.*?)</td><td class='cel8 \w*?' rowspan='2'>([0-9]+[.]?[0-9]+|.*?)</td><td class='cel9 \w*?' rowspan='2'>([0-9]+[.]?[0-9]+|.*?)</td></tr><tr><td class='weight'>([0-9]+[.]?[0-9]+%|.*?)</td>",
        ],

        #'16' => [], // 児島
        '17' => [ // 宮島(2017-02-28～)
            'format' => 'http://www.br-special.jp/tenji-keisoku17/pc/?day=%s&race=%02d',
            'regex'  => "<th class='cel1 col(\d+)' rowspan='2'>.*?<span class='kyu'>(\d+)</span>.*?<td class='weight' '>(\d*)</td>.*?<td class='cel6' rowspan='2'>([+-]?[0-9]+[.]?[0-9]|.*?)</td><td class='cel9 \w*?' rowspan='2'>([0-9]+[.]?[0-9]+|.*?)</td><td class='cel7 \w*?' rowspan='2'>([0-9]+[.]?[0-9]+|.*?)</td><td class='cel8 \w*?' rowspan='2'>([0-9]+[.]?[0-9]+|.*?)</td><td class='cel9 \w*?' rowspan='2'>([0-9]+[.]?[0-9]+|.*?)</td></tr><tr><td class='weight'>([0-9]+[.]?[0-9]+%|.*?)</td>",
        ],
        #'18' => [ // 徳山(直線なし)
        #    'format' => 'http://www.boatrace-tokuyama.jp/tenji-keisoku/pc/?day=%s&race=%02d',
        #    'regex'  => '',
        #],
        '19' => [ // 下関(json)
            'format' => 'http://next-site.net/shimonoseki/next_index.php?race_id=19%s%02d&target=original',
            'regex'  => '',
        ],
        '20' => [ // 若松(直線2017-04-19～)
            'format' => 'http://www.wmb.jp/?d=%s&r=%d',
            'regex'  => '<em class="f110">.*?</em></td>[\s\S]*?<td class="tei\d">(\d)</td>.*?toban=(\d+).*?</td>[\s\S]*?<td>.*?</td>[\s\S]*?<td>(.*?)</td>[\s\S]*?<td><strong>(.*?)</strong><br><span style="font-weight:bold;color:#00F;">(.*?)</span><br>(.*?)</td>',
        ],
        '21' => [ // 芦屋(2017-03-01～)
            'format' => 'http://www.boatrace-ashiya.com/tenji-keisoku/pc/?&day=%s&race=%02d',
            'regex'  => "<th class='cel1 col(\d+)' rowspan='2'>.*?<span class='kyu'>(\d+)</span>.*?<td class='weight' '>(\d*)</td>.*?<td class='cel6' rowspan='2'>([+-]?[0-9]+[.]?[0-9]|.*?)</td><td class='cel9 \w*?' rowspan='2'>([0-9]+[.]?[0-9]+|.*?)</td><td class='cel7 \w*?' rowspan='2'>([0-9]+[.]?[0-9]+|.*?)</td><td class='cel8 \w*?' rowspan='2'>([0-9]+[.]?[0-9]+|.*?)</td><td class='cel9 \w*?' rowspan='2'>([0-9]+[.]?[0-9]+|.*?)</td></tr><tr><td class='weight'>([0-9]+[.]?[0-9]+%|.*?)</td>",
        ],
        #'22' => [], // 福岡
        #'23' => [], // 唐津
        '24' => [ // 大村(2017-09-26～?, 2017/7/1と8/12だけ飛び石で存在)
            'format' => 'http://omurakyotei.jp/yosou/include/new_top_iframe_chokuzen.php?day=%s&race=%02d',
            'regex'  => '<th class="tei\d">(\d+)</th><td class="tei\d">.+?</td><td class="tei\d.*?">.*?</td><td class="tei\d.*?">(.*?)</td><td class="tei\d.*?">(.*?)</td><td class="tei\d.*?">(.*?)</td><td class="tei\d.*?">(.*?)</td><td class="tei\d.*?">(.*?)</td>',
        ],
    ];

    function setSaveDir($dir) {
        $this->save_dir = $dir . '/';
    }

    function main($date, $target_jid=null) {
        foreach ( self::URL_LIST as $jid => $v ) {
            if ( !empty($target_jid) && ($jid != $target_jid) ) continue; // 場の指定があったとき
            if ( empty($v) || empty($v['format']) || empty($v['regex']) ) continue; // データの取得に必要な情報が揃っていない

            #echo "getTenjiData $date, $jid". PHP_EOL;

            // 12Rまでのデータ取得
            $rows = $this->getTenjiData($v, $date, $jid);

            // データがないときは出力しない
            if ( count($rows) == 0 ) continue;

            // 保存
            if ( !file_exists($this->save_dir) ) {
                mkdir($this->save_dir, 0777);
            }

            $filename = $this->save_dir . sprintf('%s_%02d_tenji.csv', $date, $jid);
            if ( $fp = fopen($filename, 'w') ) {
                foreach( $rows as $row ) {
                    fputcsv($fp, $row);
                }
                fclose($fp);
            }
            else {
                echo "fopen error {$filename}". PHP_EOL;
            }
        }
    }

    /**
     * 
     */
    function getTenjiData($v, $date, $jid) {
        $rows = [];
        $format = $v['format'];
        $regex  = str_replace('/', '\/', $v['regex']); // エスケープ

        for ($rno = 1 ; $rno <= 12 ; $rno++ ) {
            // データ取得先URL生成
            $url;
            if ($jid == '04') {
                $url = sprintf( $format, $rno );
            } else {
                $url = sprintf( $format, $date, $rno );
            }

            try {
                // データ取得
                $contents = file_get_contents( $url );
                if ( $contents === false ) throw new Exception("file_get_contents データ取得失敗 url=\"{$url}\"");

                // 文字コードがUTFかどうかチェックする
                if ( ($contents_encoding = mb_detect_encoding($contents)) != 'UTF-8') {
                    $contents = mb_convert_encoding($contents, 'UTF-8', $contents_encoding);
                }

                // 正規表現でデータ抽出
                $ret = preg_match_all("/{$regex}/s", $contents, $matches);
                // エラー
                if ( $ret === false ) {
                    $err_code = preg_last_error();
                    echo "match error url=\"{$url}\" preg_last_error={$err_code}" . PHP_EOL;
                }
                // マッチ０件
                elseif ($ret === 0) {
                    echo "No match url=\"{$url}\"" . PHP_EOL;
                }
                // マッチしたとき
                else {
                    $arr_waku          = []; // 枠番
                    $arr_toban         = []; // 登番
                    $arr_mno           = []; // モーター番号
                    $arr_m2ren         = []; // モーター2連率
                    $arr_tilt          = []; // チルト
                    $arr_time_tenji    = []; // 展示
                    $arr_time_round    = []; // 一周
                    $arr_time_corner   = []; // まわり足
                    $arr_time_straight = []; // 直線

                    // 項目の並び順は場ごとに違うのでマッチ順に合わせて調整
                    switch ($jid) {
                    case 1:
                        $arr_waku          = $matches[1];
                        $arr_toban         = $matches[2];
                        $arr_mno           = [];
                        $arr_m2ren         = [];
                        $arr_tilt          = $matches[7];
                        $arr_time_tenji    = $matches[6];
                        $arr_time_round    = $matches[3]; // 桐生は一周ではなく半周ラップ。格納先は一周のところ。
                        $arr_time_corner   = $matches[4]; // 欠場のときは「欠　場」が入る
                        $arr_time_straight = $matches[5];
                        break;

                    case 6:
                        $arr_waku          = $matches[1];
                        $arr_toban         = $matches[2];
                        $arr_mno           = $matches[3];
                        $arr_m2ren         = $matches[4];
                        $arr_tilt          = $matches[5];
                        $arr_time_tenji    = $matches[6];
                        $arr_time_round    = $matches[7];
                        $arr_time_corner   = $matches[8];
                        $arr_time_straight = $matches[9];
                        break;

                    case 10:
                        $arr_waku          = $matches[1];
                        $arr_toban         = $matches[2];
                        $arr_mno           = [];
                        $arr_m2ren         = [];
                        $arr_tilt          = $matches[3];
                        $arr_time_tenji    = $matches[4];
                        $arr_time_round    = $matches[5];
                        $arr_time_corner   = $matches[6];
                        $arr_time_straight = $matches[7];
                        break;

                    case 20:
                        $arr_waku          = $matches[1];
                        $arr_toban         = $matches[2];
                        $arr_mno           = [];
                        $arr_m2ren         = [];
                        $arr_tilt          = $matches[3];
                        $arr_time_tenji    = $matches[6];
                        $arr_time_round    = $matches[4];
                        $arr_time_corner   = [];          // まわり足なし
                        $arr_time_straight = $matches[5];
                        break;

                    case 24:
                        $arr_waku          = $matches[1];
                        $arr_toban         = [];
                        $arr_mno           = [];
                        $arr_m2ren         = [];
                        $arr_tilt          = $matches[6]; // 欠場のときは「欠場」が入る
                        $arr_time_tenji    = $matches[2]; // 欠場のときは「欠場」が入る
                        $arr_time_round    = $matches[3]; // 欠場のときは「欠場」が入る
                        $arr_time_corner   = $matches[4]; // 欠場のときは「欠場」が入る
                        $arr_time_straight = $matches[5]; // 欠場のときは「欠場」が入る
                        break;

                    case 15:
                    case 17:
                    case 21:
                        $arr_waku          = $matches[1];
                        $arr_toban         = $matches[2];
                        $arr_mno           = $matches[3];
                        $arr_m2ren         = $matches[9]; // 順番は最後なので注意
                        $arr_tilt          = $matches[4];
                        $arr_time_tenji    = $matches[5]; 
                        $arr_time_round    = $matches[6];
                        $arr_time_corner   = $matches[7];
                        $arr_time_straight = $matches[8];
                        break;
                    default:
                        break;
                    }

                    // モータ2連率に%が入っていたら消す
                    foreach( $arr_m2ren as &$v ) {
                        $v = str_replace('%', '', $v);
                    } unset($v);

                    // 出力用データ格納
                    foreach ($arr_waku as $key => $waku) {
                        $rows[] = [
                            date('Y-m-d', strtotime($date)),
                            $jid,
                            $rno,
                            $waku,
                            isset($arr_toban[$key]        ) ? trim($arr_toban[$key])         : '',
                            isset($arr_mno[$key]          ) ? trim($arr_mno[$key])           : '',
                            isset($arr_m2ren[$key]        ) ? trim($arr_m2ren[$key])         : '',
                            isset($arr_tilt[$key]         ) ? trim($arr_tilt[$key])          : '',
                            isset($arr_time_tenji[$key]   ) ? trim($arr_time_tenji[$key])    : '',
                            isset($arr_time_round[$key]   ) ? trim($arr_time_round[$key])    : '',
                            isset($arr_time_corner[$key]  ) ? trim($arr_time_corner[$key])   : '',
                            isset($arr_time_straight[$key]) ? trim($arr_time_straight[$key]) : '',
                        ];
                    }
                }

            } catch (Exception $e) {
                echo "ERROR! " . $e->getMessage() . PHP_EOL;
            }
            #usleep(100 * 1000); // 100ms遅延
        }
        return $rows;
    }

}

// =============================
// 初期化
// =============================
$tenji = new Tenji;

// =============================
// 渡されたオプションに対する処理
// =============================
$opt = getopt('f:d:j:');

// 出力先ディレクトリ
if (isset($opt['f'])) {
    $tenji->setSaveDir($opt['f']);
}

// 日付
$date = date('Ymd');
if ( isset($opt['d']) && strtotime($opt['d']) ) {
    $date = date('Ymd', strtotime($opt['d']));
}
// 場番号
$jid = isset($opt['j']) ? sprintf('%02d', $opt['j']) : null;

// =============================
// 処理実行
// =============================
$tenji->main($date, $jid);

