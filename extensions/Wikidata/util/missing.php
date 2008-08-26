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

$collection_id=$_REQUEST['collection'];
$language_id=$_REQUEST['language'];
$collection_esc=mysql_real_escape_string($collection_id);
$language_esc=mysql_real_escape_string( $language_id);

$result = mysql_query(
"SELECT spelling 
FROM uw_collection, uw_defined_meaning, uw_expression
WHERE collection_id=$collection_id
AND collection_mid=defined_meaning_id 
AND uw_defined_meaning.expression_id=uw_expression.expression_id
")or die ("error ".mysql_error());

$row= mysql_fetch_array($result, MYSQL_NUM);
$collection= $row[0];

$result = mysql_query("SELECT language_name
FROM language_names 
where name_language_id = 85
and language_id=$language_id
")or die ("error ".mysql_error());

$row= mysql_fetch_array($result, MYSQL_NUM);
$language=$row[0];

echo"
<h1>$collection</h1>
<h2>$language</h2>
<small><i>For large collections, this query might take up to a minute. Please be patient</i></small>
<hr width=950 size=1 noshade><br />
<h3> Missing defined meanings </h3>

";

# Malafaya: Here lies the old query, assuming there's always an English expression for the DM
/*
$result = mysql_query(" 
	SELECT en.id, en.spelling 
	FROM 
	(
		SELECT member_mid as id, spelling
		FROM uw_collection_contents, uw_syntrans, uw_expression 
		WHERE collection_id = $collection_esc 
		AND uw_syntrans.defined_meaning_id= uw_collection_contents.member_mid 
		AND uw_expression.expression_id = uw_syntrans.expression_id 
		AND language_id=85 
		AND uw_syntrans.remove_transaction_id IS NULL 
		ORDER BY spelling
	) as en 
	LEFT JOIN 
	(
		SELECT member_mid as id, spelling 
		FROM uw_collection_contents, uw_syntrans, uw_expression WHERE
		collection_id = $collection_esc 
		AND uw_syntrans.defined_meaning_id= uw_collection_contents.member_mid 
		AND uw_expression.expression_id = uw_syntrans.expression_id 
		AND language_id = $language_esc 
		AND uw_syntrans.remove_transaction_id IS NULL 
		ORDER BY spelling
	) as actual 
	ON en.id=actual.id 
	WHERE actual.id IS NULL
")or die ("error ".mysql_error());
*/

# Malafaya: This is my query (performance must be checked live) for missing expressions based on
#                       * don't count deleted stuff (old query did)
#                       * do 2 joins: between members of collection and target language, and then with english for default, but only for elements having target language expression as NULL (non-existing)
#                       * this gives us the DM id, the spelling in target language (or NULL, if none), the spelling in English (or NULL, if none)
#			(+Kim) Alternately, just try the actual defining expression, which should never be NULL in the first place.
#                    Warning: some DMs came up in OLPC and Swadesh collections belonging to those collections but having no expressions associated... These are visible in this query

$result = mysql_query("
		SELECT member.id, translation_dm.spelling_dm
		FROM
		(
		 SELECT member_mid as id
		 FROM uw_collection_contents WHERE
		 collection_id = $collection_esc 
		 AND remove_transaction_id IS NULL
		) as member
		LEFT JOIN
		(
		 SELECT spelling, defined_meaning_id
		 FROM uw_syntrans, uw_expression WHERE
		 uw_expression.expression_id = uw_syntrans.expression_id 
		 AND uw_syntrans.remove_transaction_id IS NULL 
		 AND language_id = $language_esc 
		 AND defined_meaning_id IN
	 	(
			SELECT member_mid as id
			FROM uw_collection_contents WHERE
			collection_id = $collection_esc 
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
				 FROM uw_defined_meaning,  uw_expression WHERE
				 uw_expression.expression_id = uw_defined_meaning.expression_id
				 AND uw_defined_meaning.remove_transaction_id IS NULL
				 AND uw_expression.remove_transaction_id IS NULL
				 AND defined_meaning_id IN
				(
					SELECT member_mid as id
					FROM uw_collection_contents WHERE
					collection_id = $collection_esc 
					AND remove_transaction_id IS NULL
				)
			) as translation_dm1
			LEFT JOIN
			(
				 SELECT spelling as spelling_en, defined_meaning_id
				 FROM uw_syntrans, uw_expression WHERE
				 uw_expression.expression_id = uw_syntrans.expression_id
				 AND uw_syntrans.remove_transaction_id IS NULL
				 AND language_id = 85
				 AND defined_meaning_id IN
				(
					SELECT member_mid as id
					FROM uw_collection_contents WHERE
					collection_id = $collection_esc 
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

# Malafaya: Old query with same caveats as the one above

/*
$result = mysql_query(" 
	SELECT actual.id, actual.spelling 
	FROM 
	(
		SELECT member_mid as id, spelling
		FROM uw_collection_contents, uw_syntrans, uw_expression 
		WHERE collection_id = $collection_esc 
		AND uw_syntrans.defined_meaning_id= uw_collection_contents.member_mid 
		AND uw_expression.expression_id = uw_syntrans.expression_id 
		AND language_id=85 
		AND uw_syntrans.remove_transaction_id IS NULL 
		ORDER BY spelling
	) as en 
	LEFT JOIN 
	(
		SELECT member_mid as id, spelling 
		FROM uw_collection_contents, uw_syntrans, uw_expression WHERE
		collection_id = $collection_esc 
		AND uw_syntrans.defined_meaning_id= uw_collection_contents.member_mid 
		AND uw_expression.expression_id = uw_syntrans.expression_id 
		AND language_id = $language_esc 
		AND uw_syntrans.remove_transaction_id IS NULL 
		ORDER BY spelling
	) as actual 
	ON en.id=actual.id 
	WHERE actual.id IS NOT NULL
")or die ("error ".mysql_error());
*/

# Malafaya: my new query, not counting deleted stuff; just select target language expression for DMs in collection (whether translated to English or not, it's not relevant)

$result = mysql_query(" 
		SELECT defined_meaning_id, spelling
		FROM uw_syntrans, uw_expression WHERE
		uw_expression.expression_id = uw_syntrans.expression_id 
		AND uw_syntrans.remove_transaction_id IS NULL 
		AND language_id = $language_esc 
		AND uw_syntrans.defined_meaning_id IN
		(
		 SELECT member_mid as id
		 FROM uw_collection_contents WHERE
		 collection_id = $collection_esc 
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
<li><a href=\"collection.php?collection=$collection_id\">Return to  Number of Expressions per language in this collection</a></li>
<li><a href=\"stats.php\">Overview, expressions per language</a></li>
<li><a href=\"../../..\">return to Omegawiki proper</li></a>
</p>
"

?>
