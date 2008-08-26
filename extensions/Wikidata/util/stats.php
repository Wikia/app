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

/*
$result = mysql_query("SELECT 
uw_defined_meaning.defined_meaning_id , uw_expression.spelling
FROM uw_defined_meaning, uw_expression
where uw_defined_meaning.defined_meaning_id=1446
and uw_defined_meaning.expression_id=uw_expression.expression_id
limit 0,40")or die ("error ".mysql_error());

*/

$start=stopwatch();

echo"<center>
<h1>Number of Expressions per language</h1>
<hr width=950 size=1 noshade><br />
";

$expressions_r=mysql_query("SELECT  COUNT(*) FROM uw_expression WHERE remove_transaction_id IS NULL");
$expressions_a=mysql_fetch_row($expressions_r);
$expressions=$expressions_a[0];

$defined_meanings_r=mysql_query("SELECT  COUNT(*) FROM uw_defined_meaning WHERE remove_transaction_id IS NULL");
$defined_meanings_a=mysql_fetch_row($defined_meanings_r);
$defined_meanings=$defined_meanings_a[0];
echo"<br />\n";
echo"Total <b>$defined_meanings</b> DefinedMeanings in database, linking together <b>$expressions</b> Expressions. Broken down per language:\n";
echo"</br>\n";
echo"<hr>\n";

$result = mysql_query("SELECT *
FROM language_names 
where name_language_id = 85
")or die ("error ".mysql_error());

while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
//echo $row[0]." - ".$row[1]." - ".$row[2]."<br />";
$lang[$row[0]]=$row[2];
}


////////////////////////////////////////////////////////
$result = mysql_query("
SELECT 
language_id, count(*) as tot
FROM uw_expression
WHERE expression_id IN
(
	SELECT DISTINCT expression_id
	FROM uw_syntrans
	WHERE remove_transaction_id IS NULL
)
AND remove_transaction_id IS NULL
group by language_id
order by tot desc
 ")or die ("error ".mysql_error());

echo ' 
<table cellpadding=0 width=950><tr><td width=200><b>Language</b></td><td align=right><b>Expressions</b></td><td width=30></td><td></td></tr>';
$width=500;
$limit=500;
$max=0;
while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
if($max<$row[1])$max=$row[1];
$wi=ceil((($row[1]/$max)*$width));
$per=ceil((($row[1]/$max)*100));
if($row[1]>$limit)echo "<tr><td >".$lang[$row[0]].'</td><td align="right">'.$row[1]."</td><td width=30></td><td><img src=sc1.png width=\"$wi\" height=20> $per %</td></tr>";
else $tx.=$lang[$row[0]]." (".$row[1]."), ";
//$ar[$row[0]].=$row[1]."	".$row[2]."\n";
//filewrite("out/".$row[0].".txt",$row[1]."	".$row[2]);
}
echo "
<tr><td colspan=4>
<div align=justify>

<h3>Languages with less than $limit entries:</h3>
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

<small>Script contributed by <a href=http://www.dicts.info/>Zdenek Broz</a>
</small>
</td>
</tr></table>
<br />";


function filewrite($file,$txt){
$fw=fopen($file,"w+");
fwrite($fw,$txt."\n");
fclose($fw);
}




?>
</center></center>
<p align="left">
<h3> see also</h3>
<ul>
<li><a href="collections.php">Collections</a></li>
<li><a href="../../..">return to Omegawiki proper</li></a>
</p>
