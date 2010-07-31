<?php
/**
 * @author Nick O'Neill
 * This extension provides a generic way for users to add feature sliders to any wiki
*/
if ( !defined( 'MEDIAWIKI' ) ) {
  die( 1 );
}

$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'SliderTag',
	'author'         => "Nick O'Neill",
	'descriptionmsg' => 'slidertag-desc',
);

global $IP;
require_once( "$IP/extensions/wikia/CorporatePage/CorporatePageHelper.class.php" );

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['SliderTag'] = $dir . 'SliderTag.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'wfSliderTag';
$wgHooks['BeforePageDisplay'][] = 'wfSliderExtras';

function wfSliderExtras( &$out ) {
	global $wgScriptPath, $wgStyleVersion;

	$out->addStyle( "$wgScriptPath/extensions/wikia/SliderTag/slidertag.css?$wgStyleVersion" );
	$out->addScript( "<script type=\"text/javascript\" src=\"$wgScriptPath/extensions/wikia/SliderTag/slidertag.js?$wgStyleVersion\"></script>\n" );

	return true;
}

function wfSliderTag( &$parser ) {
	$parser->setHook( 'slider', 'wfSlider' );

	return true;
}

function wfSlider( $input, $args, $parser ) {
	$article = $args['id'];
	$data = CorporatePageHelper::parseMsgImg( $article, true );
	$html = '';

	if ( $data ) {
		wfLoadExtensionMessages( 'SliderTag' );

		$html = '<div id="spotlight-slider"><h1 id="featured-wikis-headline">' . wfMsg( 'slidertag-featured-wikis' ) . '</h1><ul>';

		foreach ( $data as $key => $value ) {
			$msg = wfMsg( 'corporatepage-go-to-wiki', $value['title'] );
			$html .= <<<SLIDERITEM
			<li id="spotlight-slider-$key">
				<a href="{$value['href']}">
					<img width="620" height="250" src="{$value['imagename']}" class="spotlight-slider">
				</a>
				<div class="description">
					<h2>{$value['title']}</h2>
					<p>{$value['desc']}</p>
					<a href="{$value['href']}" class="wikia-button secondary">
						<span>$msg</span>
					</a>
				</div>
				<p class="nav">
					<img width="50" height="25" alt="" src="{$value['imagethumb']}">
				</p>
			</li>
SLIDERITEM;
		}
		$html .= '</ul></div>';
	}

	return $html;
}
