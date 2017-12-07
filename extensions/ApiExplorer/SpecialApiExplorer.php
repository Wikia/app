<?php
/**
 * A Special Page for interactively exploring the documentation of the specific
 * version of the MediaWiki API running on this MediaWiki installation.
 *
 * @author Sean Colombo <firstname>@<firstname><lastname>.com
 * @addtogroup Extensions
 *
 * TODO: LATER: Auto-create forms (like Flickr's API Explorer) so that
 * the user can do test-runs of all of the API calls.  Should show the final URL
 * similar to Special:CategoryIntersection, but should be generic so that it can
 * handle all functions.
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

$wgSpecialPages[ "ApiExplorer" ] = "SpecialApiExplorer";
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'API Explorer',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ApiExplorer',
	'descriptionmsg' => 'apiexplorer-desc',
	'author' => '[http://seancolombo.com Sean Colombo]'
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['ApiExplorer'] = $dir . 'ApiExplorer.i18n.php';
$wgExtensionMessagesFiles['ApiExplorerAlias'] = $dir . 'ApiExplorer.alias.php';

/**
 * @ingroup SpecialPage
 */
class SpecialApiExplorer extends SpecialPage {
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'ApiExplorer' );
		$this->includable( false );
	}

	/**
	 * Main function of the special page. Basically serves as a wrapper which loads
	 * the main functionality (which is in Javascript).
	 *
	 * @param $par - parameters for SpecialPage. Ignored.
	 */
	public function execute( $par = null ) {
		global $wgOut, $wgExtensionsPath, $wgCityId, $wgStyleVersion;
		wfProfileIn( __METHOD__ );

		// TODO: Make this work for ResourceLoader (Wikia isn't using RL yet at the time of this writing).
		// Wikia interpolates wgStyleVersion in the wgExtensionPath (we rewrite that in varnish because many proxies won't cache things that have "?" in the URL), but other MediaWikis need the style-version in the querystring.
		$wgOut->addScript( "<script type=\"text/javascript\" src=\"{$wgExtensionsPath}/wikia/JavascriptAPI/Mediawiki.js{$wgStyleVersion}\"></script>" );
		$wgOut->addScript( "<script type=\"text/javascript\" src=\"{$wgExtensionsPath}/ApiExplorer/apiExplorer.js{$wgStyleVersion}\"></script>" );
		$wgOut->addScript( "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgExtensionsPath}/ApiExplorer/apiExplorer.css{$wgStyleVersion}\" />" );

		ob_start();
			$buttonHeight = 15;
			$collapseSrc = "$wgExtensionsPath/ApiExplorer/collapse.png$wgStyleVersion";
			$expandSrc = "$wgExtensionsPath/ApiExplorer/collapse.png$wgStyleVersion";
			?><style>
				.collapsible h2 span, .collapsible h3 span{
					width:<?= $buttonHeight ?>px;
					height:1em;
					float:right;
					display:inline-block;

					background-repeat:no-repeat;
					background-position:right center;
					background-image: url(<?= "$wgExtensionsPath/ApiExplorer/collapse.png$wgStyleVersion"; ?>);
				}
				.collapsed h2 span, .collapsed h3 span{
					background-image: url(<?= "$wgExtensionsPath/ApiExplorer/expand.png$wgStyleVersion"; ?>);
				}
			</style>
			<div id='apEx_intro'>
				<?= wfMsgExt('apiexplorer-intro', array('parse', 'content') ) ?>
			</div>
			<div id='apEx_loading'><?= wfMsg('apiexplorer-loading') ?></div>
			<div id='apEx'>
				<?php
				$params = array( "modules", "querymodules", "formatmodules" );
				foreach ( $params as $param ) {
					?><div class='<?= $param ?> collapsible collapsed paramName' data-param-name='<?= $param ?>'>
						<h2 class='name'><span class='toggleIcon'></span></h2>
						<div class='paramContent'>
							<div class='description'></div>
							<dl>
								<!-- Filled by a call to the API -->
							</dl>
						</div>
					</div><?php
				} ?>
			</div>
		<?php
		$outHtml = ob_get_clean();

		$this->setHeaders();
		$wgOut->addHTML( $outHtml );
		wfProfileOut( __METHOD__ );
	} // end execute()
} // end class SpecialApiExplorer
