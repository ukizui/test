<?php

mb_http_output('EUC-JP');

#
#CSV
#

$zip = file_get_contents('http://www.post.japanpost.jp/zipcode/dl/kogaki/zip/ken_all.zip');
//
touch('ken_all.zip');
$fp = fopen('ken_all.zip', "w");
//
fclose($fp);
exec("unzip ken_all.zip");
$csv = file_get_contents('KEN_ALL.CSV');
//
if(mb_internal_encoding() == 'UTF-8') {
    $encoded_csv = mb_convert_encoding($csv, 'UTF-8', 'SJIS');
}elseif(mb_internal_encoding() == 'EUC-JP'){
    $encoded_csv = mb_convert_encoding($csv, 'EUC-JP', 'SJIS');
}

$fp = tmpfile();
fwrite($fp, $encoded_csv);
rewind($fp);
while (!feof($fp)) {
    $data = fgetcsv($fp, 1000);
    //
        $zipcode_csv[] = array($data[2], $data[6], $data[7], '');
    } else {
        $zipcode_csv[] = array($data[2], $data[6], $data[7], $data[8]);
    }
}
fclose($fp);

#
#DB connect
#

$dbconn = pg_connect("host=$argv[1] dbname=$argv[2] user=$argv[3] password=")
    or die('Could not connect: ' . pg_last_error());//À³¾ðϥ³¥ޥó饤¥󤫤é¤¹

//
if ($argv[2] == 'mileclub' || $argv[2] == 'ashimem') {
    $table = 'public.t_zip_addr';
} else {
    $table = 'public.t_postal_code';
}
$query = "SELECT count(*) FROM $table";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    foreach ($line as $a) {
        echo 'Rows Before DELETE:'.$a."\n";
    }
}
pg_free_result($result);

//
pg_query("BEGIN");
$query = "DELETE FROM $table";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
if (!$result) {
    pg_query("ROLLBACK");
} else {
    pg_query("COMMIT");
}
pg_free_result($result);

//
$query = "SELECT count(*) FROM $table";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    foreach ($line as $a) {
        echo 'Rows After DELETE:'.$a."\n";
    }
}
pg_free_result($result);

//
pg_query("BEGIN");
foreach($zipcode_csv as $csv){
    $query = "INSERT INTO $table (zip7, addr1, addr2, addr3) VALUES ('$csv[0]', '$csv[1]', '$csv[2]', '$csv[3]')";
    $result = pg_query($dbconn, $query);
}
if (!$result) {
    pg_query("ROLLBACK");
} else {
    pg_query("COMMIT");
}
pg_free_result($result);

//
$query = "SELECT count(*) FROM $table";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    foreach ($line as $a) {
        echo 'Rows After INSERT:'.$a."\n";
    }
}
pg_free_result($result);

pg_close($dbconn);


