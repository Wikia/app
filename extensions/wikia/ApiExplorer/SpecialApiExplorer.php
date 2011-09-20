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

if (!defined('MEDIAWIKI')) die();

$wgExtensionFunctions[] = 'wfSpecialApiExplorer';
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'API Explorer',
	//'url' => 'http://www.mediawiki.org/wiki/Extension:ApiExplorer', // TODO: Put into MediaWiki Extensions repo
	'description' => 'Extension for interactively viewing live API documentation', // TODO: Update this if we have forms for each function.
	'descriptionmsg' => 'apiexplorer-desc',
	'author' => '[http://seancolombo.com Sean Colombo]'
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['ApiExplorer'] = $dir . 'ApiExplorer.i18n.php';

function wfSpecialApiExplorer () {
	global $IP;
	require_once "$IP/includes/SpecialPage.php";
	class SpecialApiExplorer extends SpecialPage {
		/**
		 * Constructor
		 */
		function SpecialApiExplorer() {
			SpecialPage::SpecialPage( 'ApiExplorer' );
			$this->includable( false );
		}

		/**
		 * Main function of the special page. Basically serves as a wrapper which loads
		 * the main functionality (which is in Javascript).
		 *
		 * @param $par - parameters for SpecialPage. Ignored.
		 */
		function execute( $par = null ) {
			global $wgOut, $wgExtensionsPath;
			wfProfileIn( __METHOD__ );

			wfLoadExtensionMessages( "AutoCreateWiki" ); // TODO: This isn't needed anymore, even in Wikia code (which is 2 versions back at the moment), is it?

			// TODO: Make this work for ResourceLoader (Wikia isn't using RL yet at the time of this writing).
			// Note that this should have ?{$wgStyleVersion} at the end for non-wikia MediaWikis. We have the cachebuster in our wgExtensionsPath (we rewrite that in varnish because many proxies won't cache things that have "?" in the URL).
			$wgOut->addScript( "<script type=\"text/javascript\" src=\"{$wgExtensionsPath}/wikia/JavascriptAPI/Mediawiki.js\"></script>" );
			$wgOut->addScript( "<script type=\"text/javascript\" src=\"{$wgExtensionsPath}/wikia/ApiExplorer/apiExplorer.js\"></script>" );
			$wgOut->addScript( "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgExtensionsPath}/wikia/ApiExplorer/apiExplorer.css\" />" );

			ob_start();

				?><div id='apEx_intro'>
					<?= wfMsg('apiexplorer-intro') ?>
				</div>
				<div id='apEx_loading'><?= wfMsg('apiexplorer-loading') ?></div>
				<div id='apEx_main'>
					<?php
					$params = array("modules", "querymodules", "formatmodules");
					foreach($params as $param){
						?><div id='<?= $param ?> collapsible'>
							<h2 class='name'></h2>
							<div class='collapsed'>
								<div class='description'></div>
								<ul>
								</ul>
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
	}

	SpecialPage::addPage( new SpecialApiExplorer );
} // end wfSpecialApiExplorer()
