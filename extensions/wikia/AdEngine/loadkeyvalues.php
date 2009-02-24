<?php
// Simple script for loading key values from excel, intended as a one-time script.
ini_set('display_errors', true);
if (empty($argv[1])){
  echo "Usage: php " . basename(__FILE__) . " <inputfile>\n";
  exit;
}

require_once '/usr/wikia/source/wiki/extensions/wikia/AdEngine/AdEngine.php';
require_once '/usr/wikia/source/wiki/extensions/wikia/AdEngine/AdProviderDART.php';

$fh=fopen($argv[1], 'r');
if (!$fh){
  echo "Error opening input file\n";
  exit;
}

// $db=mysql_connect('sayid.sjc.wikia-inc.com', 'wikicities', 'w1k14u');
$db=mysql_connect('db4', 'wikicities', 'w1k14u');
if (!$db){
  echo "Error connecting to database: " . mysql_error();
  exit;
}
mysql_select_db('wikicities');

mysql_query("TRUNCATE TABLE ad_provider_value");
echo mysql_error();

$lineNum=0;
$rowsInserted=0;
while ($line=fgetcsv($fh)){
  $lineNum++;
  if ($lineNum==1){
    // Header. Use it to get the key names
    $keynames = array_values($line);
    continue;
  }

  // Get the city_id
  $hostname=str_replace('/', '', $line[0]);
  $hostname=str_replace('http:', '', $hostname);

  $dbname=preg_replace('/.wikia.com/', '', $hostname);

  // Try city_url
  $res=mysql_query("SELECT city_id FROM city_list where city_url='http://$hostname/'");
  //echo "SELECT city_id FROM city_list where city_url='http://$hostname/';\n";
  $row=mysql_fetch_row($res);
  mysql_free_result($res);
  $city_id=$row[0];

  if (empty($city_id)){
    $res=mysql_query("SELECT city_id FROM city_list where city_dbname='$dbname'");
   // echo "SELECT city_id FROM city_list where city_dbname='$dbname';\n";
    $row=mysql_fetch_row($res);
    mysql_free_result($res);
    $city_id=$row[0];
  }

  
  // Hard code. Yeah, it's a hack, but this is a one-time script.
  switch ($line[0]){
    case 'wowwiki.com': $city_id = 490; break;
    case 'smashwiki': $city_id=2714; break;
    case 'http://memory-alpha.org/en/': $city_id = 113; break;
  }

  // Get the city id from city_list
  if (empty($city_id)){
    echo "Could not get city_id from {$line[0]}\n";
    echo "dbname=$dbname, hostname=$hostname\n";
    continue;
  }

  // get all the values on the line 
  for ($i = 3; $i < sizeof ($line); $i++){
    if ($line[$i] == ''){
	continue;
    }
    if ($keynames[$i] == 'sgenre'){
       // This is invalid
       continue;
    }

    $key =  AdProviderDART::sanitizeKeyname(strtolower($keynames[$i]));
    $value =  AdProviderDART::sanitizeKeyvalue(strtolower($line[$i]));

	
    $rowsInserted+=insertProviderValue($city_id, 1, $key, $value);
  }
  
}

function insertProviderValue($city_id, $providerid, $keyname, $keyvalue){
  global $db;
  $sql="INSERT IGNORE INTO ad_provider_value VALUES (NULL, $providerid, $city_id, '" . 
	mysql_escape_string($keyname) . "', '" .
	mysql_escape_string($keyvalue) . "');";
  //echo "$sql\n"; 
  $res=mysql_query($sql);
  if ($res){
    return mysql_affected_rows();
  } else {
    echo mysql_error() . "\n";
    return false;
  }
}

echo "Done, $lineNum lines processed, $rowsInserted rows inserted\n";



?>
