<?php

#
#CSV¥ե¡¥¤¥ëÆ¤߹þ¤ó¢ÇÎ¤Ëþ¤ì½è
#

$zip = file_get_contents('http://www.post.japanpost.jp/zipcode/dl/kogaki/zip/ken_all.zip');
//¶õip¥ե¡¥¤¥ëºî¤·¡¢¥%¦¥ó¼¥ɤ·¤Ƥ­¤¿ÆÍ¤ò­¹þ¤ßfile_put_contents('./ken_all.zip', $zip);
exec("unzip ken_all.zip");
$csv = file_get_contents('KEN_ALL.CSV');
//¥µ¡¼¥ФÎ¸»�����¥ɤˤè¤ÆSV¤Î¸»�����¥ɤò¹
if (mb_internal_encoding() == 'UTF-8') {
    $encoded_csv = mb_convert_encoding($csv, 'UTF-8', 'SJIS');
}elseif ($encode == 'EUC-JP') {
    $encoded_csv = mb_convert_encoding($csv, 'EUC-JP', 'SJIS');
}
$fp = tmpfile();
fwrite($fp, $encoded_csv);
rewind($fp);
while (!feof($fp)) {
    $data = fgetcsv($fp);
    //DB¤ËNSERT¤¹¤ë¡¼¥¿¤$±Ã½Ð    if ($data[8] == '°ʲ¼¤˷Ǻܤ¬¤ʤ¤¾ì') {
        $zipcode_csv[] = array($data[2], $data[6], $data[7], '');
    }else{
        $zipcode_csv[] = array($data[2], $data[6], $data[7], $data[8]);
    }
}
fclose($fp);

#
#DB connect
#

$dbconn = pg_connect("host=$argv[1] dbname=$argv[2] user=$argv[3] password=")
    or die('Could not connect: ' . pg_last_error());//À³¾ðϥ³¥ޥó饤¥󤫤é¤¹

//ºï¤¹¤ë¤˥쥳¡¼¥ɿôÎ§
if ($argv[2] == 'heiwajima' || $argv[2] == 'mileclub' || $argv[2] == 'kojima' || $argv[2] == 'five') { //ʿÏÅ, ´ݵµ, »ù°ìÆ²ñ  $table = 'public.t_zip_addr';
} else { //ÅÄ
    $table = 'public.addresses';
}
$query = "SELECT count(*) FROM $table";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    foreach ($line as $a) {
        echo 'Rows Before DELETE:'.$a."\n";
    }
}
pg_free_result($result);

//t·ïLETE
pg_query("BEGIN");
$query = "DELETE FROM $table";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
if (!$result) {
    pg_query("ROLLBACK");
} else {
    pg_query("COMMIT");
}
pg_free_result($result);

//ºï¤·¤¿¸å¥쥳¡¼¥ɿôÎ§
$query = "SELECT count(*) FROM $table";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    foreach ($line as $a) {
        echo 'Rows After DELETE:'.$a."\n";
    }
}
pg_free_result($result);

//t·ïSERT
pg_query("BEGIN");
//ºǽéCSV¥ե¡¥¤¥뤫¤é¤߹þ¤óÛóþ¤줿¤â¤òERT
foreach ($zipcode_csv as $csv) {
    $result = pg_query_params($dbconn, "INSERT INTO $table (zip7, addr1, addr2, addr3) VALUES ($1, $2, $3, $4)", array($csv[0], $csv[1], $csv[2], $csv[3]));
}
if (!$result) {
    pg_query("ROLLBACK");
} else {
    pg_query("COMMIT");
}
pg_free_result($result);

//INSERT¤·¤¿¸å¥쥳¡¼¥ɿôÎ§
$query = "SELECT count(*) FROM $table";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    foreach ($line as $a) {
        echo 'Rows After INSERT:'.$a."\n";
    }
}
pg_free_result($result);

pg_close($dbconn);


