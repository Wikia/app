<?php
header("Content-type: text/html; charset=UTF-8");
$dc="umls";

define('MEDIAWIKI', true );
include_once("../../../../LocalSettings.php");
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

/*
$result = mysql_query("SELECT 
{$dc}_defined_meaning.defined_meaning_id , {$dc}_expression.spelling
FROM {$dc}_defined_meaning, {$dc}_expression
where {$dc}_defined_meaning.defined_meaning_id=1446
and {$dc}_defined_meaning.expression_id={$dc}_expression.expression_id
limit 0,40")or die ("error ".mysql_error());

*/

$start=stopwatch();

$collection_id=$_REQUEST['collection'];

$result = mysql_query(
"SELECT spelling 
FROM {$dc}_collection, {$dc}_defined_meaning, {$dc}_expression
WHERE collection_id=$collection_id
AND collection_mid=defined_meaning_id 
AND {$dc}_defined_meaning.expression_id={$dc}_expression.expression_id
")or die ("error ".mysql_error());

$row= mysql_fetch_array($result, MYSQL_NUM);
$collection= $row[0];

echo"<center>
<h1> $collection </h1>
<h2> Number of Expressions per language in this collection </h2>
<hr width=950 size=1 noshade><br />
";


$result = mysql_query("SELECT *
FROM language_names 
where name_language_id = 85
")or die ("error ".mysql_error());

while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
//echo $row[0]." - ".$row[1]." - ".$row[2]."<br />";
$lang[$row[0]]=$row[2];
}


////////////////////////////////////////////////////////
$collection_esc=mysql_real_escape_string( $collection_id);
$result = mysql_query("SELECT 
language_id, COUNT(DISTINCT defined_meaning_id) as counts
FROM {$dc}_collection_contents, {$dc}_syntrans, {$dc}_expression
WHERE  collection_id = $collection_esc
AND  {$dc}_syntrans.defined_meaning_id= {$dc}_collection_contents.member_mid
AND {$dc}_expression.expression_id = {$dc}_syntrans.expression_id
AND {$dc}_expression.remove_transaction_id IS NULL
AND {$dc}_syntrans.remove_transaction_id IS NULL
AND {$dc}_collection_contents.remove_transaction_id is NULL
GROUP BY language_id
ORDER BY counts DESC
 ")or die ("error ".mysql_error());

echo ' 
<table cellpadding=0 width=950><tr><td width=200><b>Language</b></td><td align=right><b>Expressions</b></td><td width=30></td><td></td></tr>';
$width=500;
$limit=0;
$max=0;
$limit_percent=10;

while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
$language_id=$row[0];
$count=$row[1];
if($max<$row[1]) {
	$max=$row[1];
	$limit=(int) ($max*($limit_percent/100)+0.5); # 10% cutoff, note that ORDER BY ... DESC   should have first row = max ;-)
}
$wi=ceil((($row[1]/$max)*$width));
$per=ceil((($row[1]/$max)*100));
$language_link="<a href=\"missing.php?collection=$collection_id&language=$language_id\">".$lang[$language_id]."</a>";
if($row[1]>$limit)echo "<tr><td >".$language_link.'</td><td align="right">'.$row[1]."</td><td width=30></td><td><img src=sc1.png width=\"$wi\" height=20> $per %</td></tr>";
else $tx.=$language_link." (".$row[1]."/ $per%), ";
//$ar[$row[0]].=$row[1]."	".$row[2]."\n";
//filewrite("out/".$row[0].".txt",$row[1]."	".$row[2]);
}
echo "
<tr><td colspan=4>
<div align=justify>

<h3>Languages with $limit entries or less ( / cutoff at $limit_percent% or less)</h3>
$tx
</div>
</td>
</table><center>";
/*
for($i=0;$i<250;$i++){
if(strlen($ar[$i])>20)filewrite("out/".$lang[$i].".txt",$ar[$i]);

}
*/
////////////////////////////////////////////////////////


//echo "<pre>".$ar[85]."</pre>";

echo "
<br />
<hr size=1 noshade width=950>
<table width=950><tr><td>
<small>Page time: ".substr((stopwatch()-$start),0,5)." seconds</small>
<td align=right>

<small>Script based on work contributed by <a href=http://www.dicts.info/>Zdenek Broz</a>
</small>
</td>
</tr></table>
<br />";


function filewrite($file,$txt){
$fw=fopen($file,"w+");
fwrite($fw,$txt."\n");
fclose($fw);
}



echo"
</center></center>
<hr>\n";
?>
Notes:
<ul>
<li>Languages link to lists of words that are still missing for this collection. </li>
<li>Especially for large collections, <b>it might take a minute or two to get all the missing words</b></li>
</ul>
<hr>
<p align="left">
<h3> see also</h3>
<ul>
<li><a href="collections.php">Other collections</a></li>
<li><a href="stats.php">Overview, expressions per language</a></li>
<li><a href="../../..">return to Omegawiki proper</li></a>
</p>
