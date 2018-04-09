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
$array = [0];
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
for ($i=0; $i <= 72; $i++) {
    if ($i == 1 || $i <=6 ) {
       $race1[] = $array[$i];
    } elseif ($i == 7 || $i <=12 ) {
       $race2[] = $array[$i];
    } elseif ($i == 13 || $i <=18 ) {
       $race3[] = $array[$i];
    } elseif ($i == 19 || $i <=24 ) {
       $race4[] = $array[$i];
    } elseif ($i == 25 || $i <=30 ) {
       $race5[] = $array[$i];
    } elseif ($i == 31 || $i <=36 ) {
       $race6[] = $array[$i];
    } elseif ($i == 37 || $i <=42 ) {
       $race7[] = $array[$i];
    } elseif ($i == 43 || $i <=48 ) {
       $race8[] = $array[$i];
    } elseif ($i == 49 || $i <=54 ) {
       $race9[] = $array[$i];
    } elseif ($i == 55 || $i <=60 ) {
       $race10[] = $array[$i];
    } elseif ($i == 61 || $i <=66 ) {
       $race11[] = $array[$i];
    } elseif ($i == 67 || $i <=72 ) {
       $race12[] = $array[$i];
    }
}
//asort($race1);
//echo($race1[1][1]);exit;
$div1_second = null;
$div2_second = null;
$div3_second = null;
$div4_second = null;
$div5_second = null;
$div6_second = null;
$div7_second = null;
$div1_third = null;
$div2_third = null;
$div3_third = null;
$div4_third = null;
$div5_third = null;
$div6_third = null;
$div7_third = null;
print_r($race1);
$count = 0;
foreach ($race1 as $div){
//    echo $div[1]."\n";

    if (!isset($div1_first)) {
        $div1_first = $div[1];
    echo $count.'div_first :'.$div1_first."\n";
    }
    if ($div[1] > $div1_first) {
        $div1_second = $div1_first;
        $div1_first = $div[1];
    echo $count.'div_second :'.$div1_second."\n";
    echo $count.'div_first :'.$div1_first."\n";
    }
    if ($div[1] > $div1_second && $div[1] < $div1_first) {
        $div1_third = $div1_second;
        $div1_second = $div[1];
    echo $count.'div_third :'.$div1_third."\n";
    echo $count.'div_second :'.$div1_second."\n";
    }

    if (!isset($div2_first)) {
        $div2_first = $div[2];
//    echo $count.'div2_first :'.$div2_first."\n";
    }
    if ($div[2] > $div2_first) {
        $div2_second = $div2_first;
        $div2_first = $div[2];
//    echo $count.'div2_second :'.$div2_second."\n";
//    echo $count.'div2_first :'.$div2_first."\n";
    }
    if ($div[2] > $div2_second && $div[2] < $div2_first) {
        $div2_third = $div2_second;
        $div2_second = $div[2];
//    echo $count.'div2_third :'.$div2_third."\n";
//    echo $count.'div2_second :'.$div2_second."\n";
    }

    if (!isset($div3_first)) {
        $div3_first = $div[3];
    }
    if ($div[3] > $div3_first) {
        $div3_second = $div3_first;
        $div3_first = $div[3];
    }
    if ($div[3] > $div3_second && $div[3] < $div3_first) {
        $div3_third = $div3_second;
        $div3_second = $div[3];
    }

    if (!isset($div4_first)) {
        $div4_first = $div[4];
    }
    if ($div[4] > $div4_first) {
        $div4_second = $div4_first;
        $div4_first = $div[4];
    }
    if ($div[4] > $div4_second && $div[4] < $div4_first) {
        $div4_third = $div4_second;
        $div4_second = $div[4];
    }

    if (!isset($div5_first)) {
        $div5_first = $div[5];
    }
    if ($div[5] > $div5_first) {
        $div5_second = $div5_first;
        $div5_first = $div[5];
    }
    if ($div[5] > $div5_second && $div[5] < $div5_first) {
        $div5_third = $div5_second;
        $div5_second = $div[5];
    }

    if (!isset($div6_first)) {
        $div6_first = $div[6];
    }
    if ($div[6] > $div6_first) {
        $div6_second = $div6_first;
        $div6_first = $div[6];
    }
    if ($div[6] > $div6_second && $div[6] < $div6_first) {
        $div6_third = $div6_second;
        $div6_second = $div[6];
    }

    if (!isset($div7_first)) {
        $div7_first = $div[7];
    }
    if ($div[7] > $div7_first) {
        $div7_second = $div7_first;
        $div7_first = $div[7];
    }
    if ($div[7] > $div7_second && $div[7] < $div7_first) {
        $div7_third = $div7_second;
        $div7_second = $div[7];
    }

$count += 1;
//    echo 'div7 :'.$div[7]."\n";
}
echo 'div: '.$div1_first."\n";
echo 'div: '.$div1_second."\n";
echo 'div: '.$div1_third."\n";
echo 'div2: '.$div2_first."\n";
echo 'div2: '.$div2_second."\n";
echo 'div2: '.$div2_third."\n";
echo 'div3: '.$div3_first."\n";
echo 'div3: '.$div3_second."\n";
echo 'div3: '.$div3_third."\n";
echo 'div4: '.$div4_first."\n";
echo 'div4: '.$div4_second."\n";
echo 'div4: '.$div4_third."\n";
echo 'div5: '.$div5_first."\n";
echo 'div5: '.$div5_second."\n";
echo 'div5: '.$div5_third."\n";
echo 'div6: '.$div6_first."\n";
echo 'div6: '.$div6_second."\n";
echo 'div6: '.$div6_third."\n";
echo 'div7: '.$div7_first."\n";
echo 'div7: '.$div7_second."\n";
echo 'div7: '.$div7_third."\n";
exit;
//foreach ($race1 as $race)
//for ($waku=1; $waku < 6; $waku++) {
//    echo($race1[$waku][1]);
//    if ($race1[$waku])
//}
exit;
$i = 0; //max71
foreach ($array as $speed) {
    $raceNumberVar = $i / 6; // 1以下だったら1R,　1以上2以下だったら2R...
    $res = $i % 6; // 0だったら1枠...
    switch (floor($raceNumberVar)){
        case 0:
        $raceNumber = 1;
        break;

        case 1:
        $raceNumber = 2;
        break;

        case 2:
        $raceNumber = 3;
        break;

        case 3:
        $raceNumber = 4;
        break;

        case 4:
        $raceNumber = 5;
        break;

        case 5:
        $raceNumber = 6;
        break;

        case 6:
        $raceNumber = 7;
        break;

        case 7:
        $raceNumber = 8;
        break;

        case 8:
        $raceNumber = 9;
        break;

        case 9:
        $racerumber = 10;
        break;

        case 10:
        $raceNumber = 11;
        break;

        case 11:
        $raceNumber = 12;
        break;

    }
    switch ($res) {
        case 0: // waku1
            $waku1_kubun1[$raceNumber] = $array[$i][1];// 区分1
            break;

        case 1: // waku2
            $waku2_kubun1[$raceNumber] = $array[$i][1];
            break;

        case 2: // waku3
            $waku3_kubun1[$raceNumber] = $array[$i][1];
            break;

        case 3: // waku4
            $waku4_kubun1[$raceNumber] = $array[$i][1];
            break;

        case 4: // waku5
            $waku5_kubun1[$raceNumber] = $array[$i][1];
            break;

        case 5: // waku6
            $waku6_kubun1[$raceNumber] = $array[$i][1];
            break;

    }
   $i++;
}
print_r($waku1_kubun1);//."\n");
print_r($waku2_kubun1);//."\n");
print_r($waku3_kubun1);//."\n");
print_r($waku4_kubun1);//."\n");
print_r($waku5_kubun1);//."\n");
print_r($waku6_kubun1);//."\n");

for ($raceNumber=1; $raceNumber <= 12; $raceNumber++) {
    if (max($waku1_kubun1[$raceNumber], $waku2_kubun1[$raceNumber], $waku3_kubun1[$raceNumber], $waku4_kubun1[$raceNumber], $waku5_kubun1[$raceNumber], $waku6_kubun1[$raceNumber])) {
        echo 'aaa';
    } else {
        echo 'bbb';
    }
}
