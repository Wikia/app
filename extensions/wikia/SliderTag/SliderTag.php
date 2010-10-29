<?php
/**
 * @author Nick O'Neill
 * @author Krzysztof Krzyżaniak (eloy) - Hook routine, purging support
 * This extension provides a generic way for users to add feature sliders to any wiki
*/
if ( !defined( 'MEDIAWIKI' ) ) {
  die( 1 );
}

$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'SliderTag',
	'author'         => array( "Nick O'Neill", "Krzysztof Krzyżaniak (eloy)" ),
	'descriptionmsg' => 'slidertag-desc',
);

global $IP;
require_once( "$IP/extensions/wikia/CorporatePage/CorporatePageHelper.class.php" );

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['SliderTag'] = $dir . 'SliderTag.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'wfSliderTag';
$wgHooks['MessageCacheReplace'][] = 'wfSliderTagMessageCacheReplace';

function wfSliderTag( &$parser ) {
	$parser->setHook( 'slider', 'wfSlider' );

	return true;
}

function wfSlider( $input, $args, $parser ) {
	global $wgOut, $wgScriptPath, $wgStyleVersion, $wgTitle;

	$article = $args['id'];

	/**
	 * store keys used in tag, it will be used for invalidation later
	 */
	$solidCache = wfGetSolidCacheStorage();
	$tags = $solidCache->get( wfMemcKey( "SliderTags" ) );
	$page_id = $wgTitle->getArticleID();
	if( $page_id && is_array( $tags ) ) {
		if( isset( $tags[ $article ] ) && is_array( $tags[ $article ] ) ) {
			/**
			 * remove duplicates
			 */
			array_push( $tags[ $article ], $page_id );
			$tags[ $article ] = array_unique( $tags[ $article ] );
		}
		else {
			$tags[ $article ] = array( $page_id );
		}
	}
	else {
		$tags = array();
		$tags[ $article ] = array( $page_id );
	}

	$solidCache->set( wfMemcKey( "SliderTags" ), $tags );

	$data = CorporatePageHelper::parseMsgImg( $article, true );
	$html = '';

	if ( $data ) {
		wfLoadExtensionMessages( 'SliderTag' );
		$html = "<script type=\"text/javascript\" src=\"{$wgScriptPath}/extensions/wikia/SliderTag/slidertag.js?{$wgStyleVersion}\"></script>";

		$html .= '<div id="spotlight-slider"><ul>';

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

/**
 * Hook
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 */
function wfSliderTagMessageCacheReplace( $title, $text ) {

	wfProfileIn( __METHOD__ );

	$solidCache = wfGetSolidCacheStorage();
	$tags = $solidCache->get( wfMemcKey( "SliderTags" ) );
	if( is_array( $tags ) ) {
		foreach( $tags as $tag => $pages ) {
			if( $tag == $title && is_array( $pages ) ) {
				foreach( $pages as $page ) {
					$title = Title::newFromID( $page );
					if( $title ) {
						wfDebug( __METHOD__ . ": purging article {$title->getLocalUrl()} which contains slider tag.\n" );
						$title->invalidateCache();
						$title->purgeSquid();
					}
				}
			}
		}
	}

	wfProfileOut( __METHOD__ );

	return true;
}
