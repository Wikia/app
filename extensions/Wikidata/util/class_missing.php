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

$class_id=$_REQUEST['class'];
$language_id=$_REQUEST['language'];
$class_esc=mysql_real_escape_string($class_id);
$language_esc=mysql_real_escape_string( $language_id);

$result = mysql_query(
"SELECT spelling
FROM  ${dc}_defined_meaning, ${dc}_expression
WHERE defined_meaning_id=$class_id
AND ${dc}_defined_meaning.expression_id=${dc}_expression.expression_id
AND ${dc}_expression.remove_transaction_id is NULL
")or die ("error ".mysql_error());


$row= mysql_fetch_array($result, MYSQL_NUM);
$class_name= $row[0];

$result = mysql_query("SELECT language_name
FROM language_names 
where name_language_id = 85
and language_id=$language_id
")or die ("error ".mysql_error());

$row= mysql_fetch_array($result, MYSQL_NUM);
$language=$row[0];

echo"
<h1>$class_name</h1>
<h2>$language</h2>
<small><i>For large classes, this query might take up to a minute. Please be patient</i></small>
<hr width=950 size=1 noshade><br />
<h3> Missing defined meanings </h3>

";

$result = mysql_query("
		SELECT member.id, translation_dm.spelling_dm
		FROM
		(
		 SELECT class_member_mid as id
		 FROM ${dc}_class_membership WHERE
		 class_mid = $class_esc
		 AND remove_transaction_id IS NULL
		) as member
 		LEFT JOIN
		(
		 SELECT spelling, defined_meaning_id
		 FROM ${dc}_syntrans, ${dc}_expression WHERE
		 ${dc}_expression.expression_id = ${dc}_syntrans.expression_id
		 AND ${dc}_syntrans.remove_transaction_id IS NULL
		 AND language_id = $language_esc
		 AND defined_meaning_id IN
	 	(
			SELECT class_member_mid as id
			FROM ${dc}_class_membership WHERE
			class_mid = $class_esc
			AND remove_transaction_id IS NULL
		)
		) as translation
		ON
		translation.defined_meaning_id = member.id
		LEFT JOIN
		(
			 SELECT COALESCE(translation_en.spelling_en, translation_dm1.spelling_dm ) as spelling_dm, translation_dm1.defined_meaning_id as defined_meaning_id
			 FROM 
			 (
				 SELECT spelling as spelling_dm, defined_meaning_id
				 FROM ${dc}_defined_meaning,  ${dc}_expression WHERE
				 ${dc}_expression.expression_id = ${dc}_defined_meaning.expression_id
				 AND ${dc}_defined_meaning.remove_transaction_id IS NULL
				 AND ${dc}_expression.remove_transaction_id IS NULL
				 AND defined_meaning_id IN
				(
					SELECT class_member_mid as id
					FROM ${dc}_class_membership WHERE
					class_mid = $class_esc
					AND remove_transaction_id IS NULL
				)
			) as translation_dm1
			LEFT JOIN
			(
				 SELECT spelling as spelling_en, defined_meaning_id
				 FROM ${dc}_syntrans, ${dc}_expression WHERE
				 ${dc}_expression.expression_id = ${dc}_syntrans.expression_id
				 AND ${dc}_syntrans.remove_transaction_id IS NULL
				 AND language_id = 85
				 AND defined_meaning_id IN
				(
					SELECT class_member_mid as id
					FROM ${dc}_class_membership WHERE
					class_mid = $class_esc
					AND remove_transaction_id IS NULL
				)
			) as translation_en
			ON translation_dm1.defined_meaning_id=translation_en.defined_meaning_id
		) as translation_dm
		ON
		translation_dm.defined_meaning_id = member.id
		WHERE translation.spelling IS NULL
		ORDER BY spelling_dm
")or die ("error ".mysql_error());


while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
	$id=$row[0];
	$spelling_dm=$row[1];
	
	# Malafaya: Not translated to target language
	if ($spelling_dm == null)
		# Malafaya: Not translated to English either; use a placeholder expression
		print "<a href=\"../../../index.php?title=DefinedMeaning:(untranslated)_($id)\">(untranslated)</a>;\n";
	else
		# Malafaya: English translation exists; use it
		print "<a href=\"../../../index.php?title=DefinedMeaning:".$spelling_dm."_($id)\">$spelling_dm</a>;\n";
}
print "<br />\n";


print "<hr>\n
<h3>Already present</h3>\n";


# Malafaya: my new query, not counting deleted stuff; just select target language expression for DMs in collection (whether translated to English or not, it's not relevant)

$result = mysql_query(" 
		SELECT defined_meaning_id, spelling
		FROM ${dc}_syntrans, ${dc}_expression WHERE
		${dc}_expression.expression_id = ${dc}_syntrans.expression_id 
		AND ${dc}_syntrans.remove_transaction_id IS NULL 
		AND language_id = $language_esc 
		AND ${dc}_syntrans.defined_meaning_id IN
		(
		 SELECT class_member_mid as id
		 FROM ${dc}_class_membership WHERE
		 class_mid = $class_esc
		 AND remove_transaction_id IS NULL
		)
		ORDER BY spelling
")or die ("error ".mysql_error());


while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
	$id=$row[0];
	$spelling=$row[1];
	print "<a href=\"../../../index.php?title=DefinedMeaning:".$spelling."_($id)\">$spelling</a>;\n";
}



echo"
<hr>
<div align=\"right\">
<small>Page time: ".substr((stopwatch()-$start),0,5)." seconds</small>
</div>
Notes:
<ul>
<li>Particular (typically common) words occur multiple times. This is because these words have multiple (defined) meanings.</li>
</ul>
<hr>
<p align=\"left\">
<h3> see also</h3>
<ul>
<li><a href=\"class.php?class=$class_id\">Return to  Number of Expressions per language in this class</a></li>
<li><a href=\"stats.php\">Overview, expressions per language</a></li>
<li><a href=\"../../..\">return to Omegawiki proper</li></a>
</p>
"

?>
