<?php
die("Unsafe script -- no error checking, may be vulnerable to attacks.");
header("Content-type: text/html; charset=UTF-8");
$dc="uw";

define('MEDIAWIKI', true );


include_once("../../../includes/Defines.php");
include_once("../../../LocalSettings.php");
global $wgDBserver, $wgDBuser, $wgDBpassword, $wgDBname;

$db1=$wgDBserver;  # hostname
$db2=$wgDBuser;  # user
$db3=$wgDBpassword;  # pass
$db4=$wgDBname;  # db-name

$connection=MySQL_connect($db1,$db2,$db3);
if (!$connection)die("Cannot connect to SQL server. Try again later.");
MySQL_select_db($db4)or die("Cannot open database");
mysql_query("SET NAMES 'utf8'");

echo "
<style type=\"text/css\"><!--
body {font-family:arial,sans-serif}
--></style>
";

function stopwatch(){
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}


$start=stopwatch();


echo"
<h1>Classes</h1>
<hr width=950 size=1 noshade><br />
";

$collection_esc=mysql_real_escape_string( $collection_id);
$result = mysql_query("
  SELECT classes.id, spelling, counts.total FROM
  (
    SELECT defined_meaning_id as id, spelling
    FROM ${dc}_collection_contents, ${dc}_defined_meaning, ${dc}_expression
    WHERE collection_id=725304
    AND ${dc}_collection_contents.remove_transaction_id is NULL
    AND member_mid=defined_meaning_id 
    AND ${dc}_defined_meaning.expression_id=${dc}_expression.expression_id
  ) AS classes JOIN
  ( 
    SELECT defined_meaning_id AS id ,count(*) AS total
    FROM  ${dc}_defined_meaning, ${dc}_class_membership
    WHERE class_mid=defined_meaning_id
    AND ${dc}_class_membership.remove_transaction_id is NULL
    GROUP BY defined_meaning_id
  ) AS counts
    ON classes.id=counts.id
    ORDER BY spelling

")or die ("error ".mysql_error());



print "<ul>";
while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
	$id=$row[0];
	$spelling=$row[1];
	$total=$row[2];
	print "<li><a href=\"class.php?class=$id\">$spelling</a> ($total defined meanings) </li>";
}
print "</ul>";

echo"<hr><div align=\"right\"><small>Page time: ".substr((stopwatch()-$start),0,5)." seconds</small></div>";
?>

<p align="left">
<h3> see also</h3>
<ul>
<li><a href="stats.php">Overview, expressions per language</a></li>
<li><a href="../../..">return to Omegawiki proper</li></a>
</p>
