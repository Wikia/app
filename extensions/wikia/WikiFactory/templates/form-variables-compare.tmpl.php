<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
abbr {
	border-bottom: 1px dotted black;
	cursor: help;
}

.cant_print {
	background-color: aqua;
	color: blue;
}

td.no_cell { /* gray */
	background-color: #ccc;
}

td.no_left { /* orange ish */
	background-color: gold;
}

td.same_left { /* green ish, will be used on left too */
	background-color: #CCFFCC;
}

td.diff_left { /* red ish */
	background-color: #FFCCCC;
}
/*]]>*/
</style>

<h2>Variable Compare</h2>
<div id="wfCompareContainer">

<?php
$to = null;

global $wgRequest;
$byid = $wgRequest->getInt('id', '');
$bydb = $wgRequest->getText('db', '');
$byurl = $wgRequest->getText('url', '');
	
Wikia::log('WikiFactory', 'compare', 'byid='. $byid );
Wikia::log('WikiFactory', 'compare', 'bydb='. $bydb );
Wikia::log('WikiFactory', 'compare', 'byurl='. $byurl );

if( !empty($byid) && $byid > 0)
{	
	Wikia::log('WikiFactory', 'compare', 'detected a byid, using it' );
	$to = (int)$byid;
}
elseif( !empty($bydb) )
{
	Wikia::log('WikiFactory', 'compare', 'detected a bydb, using it' );
	$to = WikiFactory::DBtoID($bydb);
	Wikia::log('WikiFactory', 'compare', 'DBtoID says:' . $to );

	if($to == false){
		Wikia::log('WikiFactory', 'compare', 'found false, failing' );
		$to = null;
	}
}
elseif( !empty($byurl) )
{
	Wikia::log('WikiFactory', 'compare', 'detected a byurl, using it' );
	if( strpos($byurl, '.') == false ) {
		Wikia::log('WikiFactory', 'compare', 'no . found in input, adding .wikia.com' );
		#no
		$byurl .= '.wikia.com';
	}

	$to = WikiFactory::DomainToID($byurl);
	Wikia::log('WikiFactory', 'compare', 'DomainToID says:' . $to );

	if($to == false){
		Wikia::log('WikiFactory', 'compare', 'found false, failing' );
		$to = null;
	}
	
}
else
{
	#no inputs were valid or supplied
}

?>
<fieldset>
<legend>Target Wiki</legend>
<form name="wfCompareFormID" method="get">
<label for="comp-by-id">By ID:</label><input type="text" id="comp-by-id" name="id" size="3" value="<?php if($byid){print $byid;} ?>" /><input type="submit" value="compare" />
</form>

<form name="wfCompareFormDB" method="get">
<label for="comp-by-db">By DB:</label><input type="text" id="comp-by-db" name="db" size="10" value="<?php print $bydb; ?>" /><input type="submit" value="compare" />
</form>

<form name="wfCompareFormURL" method="get">
<label for="comp-by-url">By URL:</label><input type="text" id="comp-by-url" name="url" size="20" value="<?php print $byurl; ?>" /><input type="submit" value="compare" />
</form>
</fieldset>

<?php

$vars = array();
$vars['L'] = array('city' => 0, '*' => null);

/****************************************************/
/*
get left stuff
*/
/****************************************************/
	$vars['L']['city'] = $wiki->city_id;
	$vars['L']['*'] = WikiFactory::getVariables( "cv_id", $vars['L']['city'], 0 /*group*/, true /*defined*/);

if($to && $to == $wiki->city_id)
{
	$to = null;
	print Wikia::errorbox("cant compare to self");
}

#do we still have a R side?
if($to) {
/****************************************************/
/*
get right stuff
*/
/****************************************************/
	$vars['R']['city'] = $to;
	$vars['R']['*'] = WikiFactory::getVariables( "cv_id", $vars['R']['city'], 0 /*group*/, true /*defined*/);
}

$combined = array();
foreach($vars as $side=>$data)
{
	foreach($data['*'] as $item)
	{
		$combined[ $item->cv_id ]['*'] = $item->cv_name;
		
		$var = WikiFactory::getVarById($item->cv_id, $data['city']);
		$combined[ $item->cv_id ]['type'] = $var->cv_variable_type;
		$combined[ $item->cv_id ][ '_' ] = true;

		$val = unserialize($var->cv_value);
		switch($var->cv_variable_type)
		{
			case "string":  /*use as is*/ break;
			case "integer": /*use as is*/ break;
			case "boolean":
				$val = ($val)?('true'):('false');
				$val = "<abbr title='boolean'><i>{$val}</i></abbr>";
				break;
			default:
				$val = '<abbr class="cant_print" title="cant display, use edit link">' . $var->cv_variable_type . '</abbr>';
				$combined[ $item->cv_id ][ '_' ] = false;
		}
		
		if($val === null) {
			$val = '<abbr title="===null"><i>null</i></abbr>';
		}
		
		$combined[ $item->cv_id ][ $side ] = $val;
	}
}

ksort($combined);

print "<table class='WikiaTable'>\n";
	print "<tr>\n";
		print "<th colspan=2>name</th>\n";
		print "<th colspan=2>" . WikiFactory::IDtoDB( $wiki->city_id ) . "</th>\n";
		if($to){
			print "<th colspan=2>" . WikiFactory::IDtoDB( $to ) . "</th>\n";
		}
	print "</tr>\n";

global $wgServer;
$WF_base = Title::newFromText('WikiFactory', NS_SPECIAL)->getLocalURL();
$wfURL_L = $WF_base . "/{$vars['L']['city']}/variables/";
if( $to ) {
$wfURL_R = $WF_base . "/{$vars['R']['city']}/variables/";
}
$blankImg = wfBlankImgUrl();
$editSprite = "<img src='{$blankImg}' class='sprite edit-pencil' alt='Edit'>";
$findSprite = "<img src='{$blankImg}' class='sprite details' alt='Find more'>";
$WF_find = Title::newFromText('WikiFactoryReporter', NS_SPECIAL)->getLocalURL();

foreach($combined as $var_id=>$var)
{
	/* var has:
		* => the name
		_ => if its printable (and compariable)
		L => value of source wiki
		R => value of target wiki
	*/
	print "<tr>\n";
		/*************************************************************************/
		print "<td><abbr title='{$var_id}' >{$var['*']}</abbr></td>\n";
		print "<td><a href='{$WF_find}?varid={$var_id}' >{$findSprite}</a></td>\n";
		
		/*****************************************/
		$hasL = isset($var['L']);
		$hasR = isset($var['R']);
		$hasSame = false;
		if($hasL && $hasR) { $hasSame = ($var['R'] === $var['L'] && $var['_'] ); }
		
		if( $hasL ) {
			$classes = array();
			if( $hasSame ) {
				$classes[] = 'same_left';
			}
			
			if( count($classes) ) { $classes = 'class="' . implode(" ", $classes) . '" '; }
			else { $classes = ''; }
			
			print "<td {$classes}>{$var['L']}</td>\n";
		}
		else {
			print "<td class='no_cell'></td>\n";
		}
			print "<td><a href='{$wfURL_L}{$var['*']}'>{$editSprite}</a></td>\n";

		/*****************************************/
		if( $to ) {
			if( $hasR ) {
				$classes = array();
				if( !$hasL ) { $classes[] = 'no_left'; }
				else {
					if($hasSame) { $classes[] = 'same_left'; }
					else { $classes[] = 'diff_left'; }
				}
				
				if( count($classes) ) { $classes = 'class="' . implode(" ", $classes) . '" '; }
				else { $classes = ''; }
				
				print "<td {$classes}>{$var['R']}</td>\n";
			}
			else {
				print "<td class='no_cell'></td>\n";
			}
				print "<td><a href='{$wfURL_R}{$var['*']}'>{$editSprite}</a></td>\n";
		}
		/*************************************************************************/
	print "</tr>\n";
}
print "</table>\n";

?>

</div>

<script type="text/javascript"> 
</script>
<!-- e:<?= __FILE__ ?> -->
