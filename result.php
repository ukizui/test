<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);

$jid  = $_GET['jid'];
$date = $_GET['date'];

exec("/usr/bin/php /var/www/dev1.ne-plus.co.jp/hirano/tenji.php -f /tmp/tenji/ -d $date -j $jid");

define('URL_TEMPLATE', '/tmp/tenji/%08d_%02d_tenji.csv');
define('URL_TEMPLATE2', 'http://boatapi.macour.jp/race/result/date/%s/jo/%02d');


function readCsv($date, $jid) {
    // 場ごとの係数の取得
    $vars = [
        '01' => [0.06, 1.9 , 0.14 , 1.95, 1.9 , 2.0, 0.15],
        '04' => [0.08, 1.9 , 0.13 , 1.95, 1.9 , 2.0, 0.15],
        '06' => [0.08, 2.0 , 0.14 , 2.00, 1.9 , 2.0, 0.15],
        '10' => [0.06, 1.9 , 0.14 , 1.95, 1.9 , 2.0, 0.15],
        '17' => [0.08, 1.9 , 0.13 , 1.95, 1.9 , 2.0, 0.15],
        '20' => [0.16, 1.93, 0.12 , 1.95, 1.93, 0.15],
        '21' => [0.12, 1.95, 0.135, 1.95, 2.0 , 2.0, 0.15],
        '24' => [0.08, 2.0 , 0.14 , 2.0 , 1.9 , 2.0, 0.15],
    ];
    if (!isset($vars[$jid])) {
        die('係数が取得できません');
        return;
    }
    $var = $vars[$jid];

    $array = [];
    // ファイルを開く
    $file = sprintf(URL_TEMPLATE, $date, $jid);
    if (($handle = fopen($file, "r")) === FALSE) {
        die('本日非開催か、まだ始まっていません');
        return ;
    }


    while($data = fgetcsv($handle)) {
        // 場別
        if ($jid == '17') {
            $segment[0] = $data[6];                                           // 選手名
            $segment[1] = round($var[0] / $data[12] * 3600, 1);               // 係数/まわり足
            $segment[3] = round($var[2] / $data[7]  * 3600, 1);               // 係数/直線
            $segment[2] = round(($segment[1] + $segment[3]) / $var[1], 1);    // (区分１+区分3)/係数
            $segment[4] = round(($segment[3] + 80) / $var[3], 1);             // (区分3+80)/係数
            $segment[7] = round($var[6] / $data[10] * 3600, 1);                // 係数/展示
            $segment[5] = round(($segment[3] + $segment[7]) / $var[4], 1);    // (区分3+区分7)/係数
            $segment[6] = round(($segment[5] + 80) / $var[5], 1);             // (区分5+80)/係数
        }
        elseif ($jid == '21') {
            $segment[0] = $data[5];                                                 // 選手名
            $segment[1] = round($var[0] / $data[11] * 3600,                    1);  // 係数/まわり足
            $segment[3] = round($var[2] / $data[12] * 3600,                    1);  // 係数/直線
            $segment[2] = round(($segment[1] + $segment[3]) / $var[1],         1);  // (区分１+区分3)/係数
            $segment[7] = round($var[6] / $data[9] * 3600,                     1);  // 係数/展示
            $segment[4] = round($segment[3] + ($segment[7]* 0.08),             1);  // (区分3+80)/係数
            $segment[5] = round(($segment[4] + $segment[6]) / $var[4],         1);  // (区分3+区分7)/係数
            $segment[6] = round((($segment[7] + ($segment[3] * 0.01)) * 0.97), 1);  // (区分5+80)/係数
        }
        // その他共通
        else {
            $segment[0] = $data[5];                                           // 選手名
            $segment[1] = round($var[0] / $data[11] * 3600, 1);               // 係数/まわり足
            $segment[3] = round($var[2] / $data[12] * 3600, 1);               // 係数/直線
            $segment[2] = round(($segment[1] + $segment[3]) / $var[1], 1);    // (区分１+区分3)/係数
            $segment[4] = round(($segment[3] + 80) / $var[3], 1);             // (区分3+80)/係数
            $segment[7] = round($var[6] / $data[9] * 3600, 1);                // 係数/展示
            $segment[5] = round(($segment[3] + $segment[7]) / $var[4], 1);    // (区分3+区分7)/係数
            $segment[6] = round(($segment[5] + 80) / $var[5], 1);             // (区分5+80)/係数
        }

        $race_number = $data[2];
        $waku        = $data[3];

        ksort($segment);
        $array[ $race_number ][ $waku ] = $segment;
    }
    return $array;
}

$array = readCsv($date, $jid);

//var_dump($array);

// 順位データ作成
$jun = [];
foreach ( $array as $race_num => $race_data ) {
	// 選手の区分ごとのデータを取り込み
	foreach ( $race_data as $waku => $sensyu ) {
		// 区分でループ
		for ($div=1; $div <=7; $div++){
			if (!isset($sensyu[$div])) continue;
			$jun[ $race_num ][ $div ][ $waku ] = $sensyu[$div];
		}
	}

	// 区分ごとにソート
	arsort($jun[ $race_num ][1]);
	arsort($jun[ $race_num ][2]);
	arsort($jun[ $race_num ][3]);
	arsort($jun[ $race_num ][4]);
	arsort($jun[ $race_num ][5]);
	arsort($jun[ $race_num ][6]);
	arsort($jun[ $race_num ][7]);
}

var_dump($jun);
