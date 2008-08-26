<?php
die("Unsafe script -- no error checking, may be vulnerable to attacks.");
header("Content-type: text/html; charset=UTF-8");

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
<h1>Collections</h1>
<hr width=950 size=1 noshade><br />
";

$collection_esc=mysql_real_escape_string( $collection_id);
$result = mysql_query(" 
	SELECT spellings.id, spelling, counts.total FROM
	(
		SELECT collection_id as id, spelling 
		FROM  uw_collection, uw_defined_meaning, uw_expression
		WHERE collection_mid=defined_meaning_id
		AND uw_defined_meaning.expression_id=uw_expression.expression_id
	) AS spellings JOIN
	( 
		SELECT uw_collection.collection_id AS id ,count(*) AS total
		FROM  uw_collection_contents, uw_collection
		WHERE uw_collection.collection_id=uw_collection_contents.collection_id
		AND uw_collection_contents.remove_transaction_id is NULL
		AND uw_collection.remove_transaction_id is NULL
		GROUP BY uw_collection.collection_id
	) AS counts
		ON spellings.id=counts.id
		ORDER BY spelling
")or die ("error ".mysql_error());



print "<ul>";
while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
	$id=$row[0];
	$spelling=$row[1];
	$total=$row[2];
	print "<li><a href=\"collection.php?collection=$id\">$spelling</a> ($total defined meanings) </li>";
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
