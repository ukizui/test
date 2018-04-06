<?php

define('URL_TEMPLATE', 'tenji/%08d_%02d_tenji.csv');
$date = null;
if ($argc >= 2) { // 実際に存在する日付かどうか
    if (preg_match('/\A(?<y>[0-9]{4})(?<m>[0-9]{2})(?<d>[0-9]{2})\z/', $argv[1], $matches) === 1) {
        if (checkdate($matches['m'], $matches['d'], $matches['y'])) {
            $date = $argv[1];
        }
    }
}

if (is_null($date)) { // 引数エラーで終了
    echo "Error: Please enter the date argument correctly. \n";
    echo "Usage: php test.php [YYYYMMDD] [jid]\n";
    exit;
}

if ($argc >= 3) { // 実際に存在する場IDかどうか
    if (preg_match('/\d{2}/', $argv[2])) {
        $jid = $argv[2];
    }
}

if (is_null($jid)) { // 引数エラーで終了
    echo "Error: Please enter the jid argument correctly. \n";
    echo "Usage: php test.php [YYYYMMDD] [jid]\n";
    exit;
}

switch ($jid) {
case 01:
    $var = [0.06, 1.9, 0.14, 1.95, 1.9, 2.0, 0.15];
    break;

case 04:
    $var = [0.08, 1.9, 0.13, 1.95, 1.9, 2.0, 0.15];

case 06:
    $var = [0.08, 2.0, 0.14, 2.0, 1.9, 2.0, 0.15];
    break;

case 10:
    $var = [0.08, 2.0, 0.12, 2.0, 2.0, 2.0, 0.15];
    break;

case 20:
    $var = [0.16, 1.93, 0.12, 1.95, 1.93, 0.15];
    break;

case 21:
    $var = [0.12, 1.9, 0.135, 1.95, 1.9, 2.0, 0.15];
    break;

case 24:
    $var = [0.08, 2.0, 0.14, 2.0, 1.9, 2.0, 0.15];
    break;

default:
    break;
}
//print_r($var);exit;

$file = sprintf(URL_TEMPLATE, $date, $jid);

//echo $file;exit;
$array = [];
$segment = [];

if ($jid == '01') {
    if (($handle = fopen($file, "r")) !== FALSE) {
        while($data = fgetcsv($handle)) {
            $segment[1] = $var[0] / $data[10] * 3600;               // 係数/まわり足
            $segment[3] = $var[2] / $data[11] * 3600;               // 係数/直線
            $segment[2] = ($segment[1] + $segment[3]) / $var[1];    // (区分１+区分3)/係数
            $segment[4] = ($segment[3] + 80) / $var[3];             // 係数/直線
            $segment[7] = $var[6] / $data[8] * 3600;                // 係数/展示
            $segment[5] = ($segment[3] + $segment[7]) / $var[4];    // (区分3+区分7)/係数
            $segment[6] = ($segment[5] + 80) / $var[5];             // (区分5+80)/係数
            $array[] = $segment;
        }
    }
}
//print_r($array);exit;
//print_r($array[0]);
//print_r($array[1]);
//print_r($array[2]);
//print_r($array[3]);
//print_r($array[4]);exit;
//$arrayの0から5で１レースなので,6で割ったときのあまり

foreach ($array as $a => $speed) {
    $i = 0;
    $raceNumberVar = $i / 6; // 1以下だったら1R,　1以上2以下だったら2R...
    $res = $i % 6; // 0だったら1枠...
    switch (floor($raceNumberVar)){
        case 1:
        $raceNumber = 1;
    }
    switch ($res) {
        case 0: // waku1
            echo($array[$i][$i+1]."\n");
            $waku1 = $speed[$i+1];
            //echo($i.$speed[$i+1]."\n");
            break;

        case 1: // waku2
            $waku2 = $speed[$i+1];
            break;

        case 2: // waku2
            $waku2 = $speed[$i+1];
            break;

        case 3: // waku2
            $waku2 = $speed[$i+1];
            break;

        case 4: // waku2
            $waku2 = $speed[$i+1];
            break;

        case 5: // waku2
            $waku2 = $speed[$i+1];
            break;

        case 6: // waku2
            $waku2 = $speed[$i+1];
            break;

    }
    $i++;
}
//print_r($array2);
//print_r($segment);

//$contents = file_get_contents('tenji/20180301_01_tenji.csv');

