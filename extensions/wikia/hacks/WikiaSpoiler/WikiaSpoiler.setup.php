<?php
/**
 * WikiaSpoiler
 * 
 * A system for hiding/showing spoilers, respecting a user-specified level of knowledge.
 *
 * <spoilercontrol source="mediawiki-message" />
 * <spoiler level="2"> spoiler text </spoiler>
 * 
 * @author William Lee <wlee@wikia-inc.com>
 */
$wgExtensionCredits['other'][] = array(
    'name'        => 'WikiaSpoiler',
    'description' => 'A system for hiding/showing spoilers, respecting a user-specified level of knowledge.',
    'version'     => '1.0',
    'author'      => array( 'William Lee' )
);

$dir = dirname( __FILE__ ) . '/';
$app = F::app();

$wgHooks['ParserFirstCallInit'][] = "wfWikiaSpoilerExtension";
$wgExtensionMessagesFiles['WikiaSpoiler'] = dirname(__FILE__) . '/WikiaSpoiler.i18n.php';

function wfWikiaSpoilerExtension( $parser ) {
	# register the extension with the WikiText parser
	# the first parameter is the name of the new tag.
	# the second parameter is the callback function for
	# processing the text between the tags
	$parser->setHook( "spoiler", "renderSpoiler" );
	$parser->setHook( "spoilercontrol", "renderSpoilerControl" );
	return true;
}

/*
 *  The callback function for converting the input text for <spoiler></spoiler>
 *  to HTML output
 */
function renderSpoiler( $input, $argv, $parser ) {
	# $argv is an array containing any arguments passed to the
	# extension like <example argument="foo" bar>..
	# Put this on the sandbox page:  (works in MediaWiki 1.5.5)
	#   <example argument="foo" argument2="bar">Testing text **example** in between the new tags</example>

	$localParser = new Parser();
	$outputObj = $localParser->parse($input, $parser->mTitle, $parser->mOptions);

	// quick hack to get rid of 'undefined index' notices...
	foreach (array('collapsed', 'contentstyle', 'footwarningtext', 'headwarningtext', 'linkstyle', 'linktext', 'spoilerstyle', 'warningstyle') as $a)
	{
		if (!isset($argv[$a])) $argv[$a] = '';
	}
	
	// check args
	
	// if level isn't set, return text in between tags
	if (empty($argv['level']) || !is_numeric($argv['level']) || $argv['level'] < 1) {
		return $outputObj->getText();
	}
	
	$output = '<div class="wikiaspoiler wikiaspoiler-' .$argv['level'] . ' wikiaspoilerhidden">';
	$output .= $outputObj->getText();
	$output .= '</div>';

	return $output;
}

/*
 *  The callback function for converting input text for <spoilercontrol></spoilercontrol> 
 *  to HTML output
 */
function renderSpoilerControl( $input, $argv, $parser ) {
	// check arguments
	if (empty($argv['source'])) {
		return;
	}
	
	$controlOptionsStr = wfMsg('wikiaspoiler-' . $argv['source']);
	willdebug($controlOptionsStr);
	if (empty($controlOptionsStr)) {
		return;
	}
	$controlOptions = explode("\n", $controlOptionsStr);
	$numOptions = sizeof($controlOptions);

        // load assets
        $extPath = F::app()->wg->extensionsPath;
        F::app()->wg->out->addScript( "<script src=\"{$extPath}/wikia/WikiaSpoiler/js/WikiaSpoiler.js\"></script>" );
        F::app()->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/WikiaSpoiler/css/WikiaSpoiler.scss' ) );

	$output = '<form id="wikiaspoilercontrol" action="" onsubmit="return false;"><p>';
	$output .= wfMsg('wikiaspoiler-control-heading');
	$output .= '<select class="wikiaspoilerselect">';
	$output .= '<option value="0">none</option>';
	for ($i=0; $i < $numOptions; $i++) {
		$output .= '<option value="'.($i+1).'">'.$controlOptions[$i].'</option>';
	}
	willdebug($output);
	$output .= '</select></p></form>';
	
	return $output;
}