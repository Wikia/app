<?php
/**
 * See docs/skin.txt
 *
 * @todo document
 * @file
 * @ingroup Skins
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/**
 * @todo document
 * @ingroup Skins
 */

require_once(dirname( __FILE__ )."/CorporateBase.php");
require_once(dirname( __FILE__ )."/../extensions/wikia/CorporatePage/CorporatePageHelper.class.php");

class SkinCorporate extends SkinCorporateBase {
	function initPage( OutputPage $out ) {
		parent::initPage( $out );
		$this->skinname  = 'Corporate';
		$this->stylename = 'Corporate';
		$this->template  = 'CorporateTemplate';
	}
}

class CorporateTemplate extends CorporateBaseTemplate {
	var $skin;
	/**
	 * Template filter callback for MonoBook skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 *
	 * @access private
	 */
	function execute() {
		global $wgRequest, $wgOut, $wgUser, $wgStylePath;
		$this->skin = $skin = $this->data['skin'];
		$action = $wgRequest->getText( 'action' );
		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

?><!doctype html>
<html lang="<?php $this->text('lang'); ?>">
	<?php $this->htmlHead() ?>
	<body<?php if($this->data['body_ondblclick']) { ?> ondblclick="<?php $this->text('body_ondblclick') ?>"<?php } ?>
<?php if($this->data['body_onload']) { ?> onload="<?php $this->text('body_onload') ?>"<?php } ?>
 class="<?php echo $this->data['body_class_attribute'] ?>">

<?php
	global $wgEnableAdInvisibleTop, $wgOut;
	if (!empty($wgEnableAdInvisibleTop) && $wgOut->isArticle()){
		echo '<script type="text/javascript" src="/extensions/wikia/AdEngine/AdEngine.js"></script>' . "\n";
		echo AdEngine::getInstance()->getAd('INVISIBLE_TOP');
	}
?>

<?php print $this->htmlGlobalHeader(); ?>
		<!-- DEV NOTE: This is the dark navigation strip at the top. -->
<?php print $this->htmlGlobalNav(); ?>

		<div id="MainContent">
			<!-- DEV NOTE: This area has the blue-striped background.  -->
			<?php AdEngine::getInstance()->getSetupHtml(); ?>

			<article id="MainArticle" class="MainArticle clearfix">
				<div class="shrinkwrap">
					<?php echo $this->getTopAdCode() ?>
					<?php print $this->htmlMainArticleContents();?>


					<?php if (!$wgUser->isAnon() && $wgOut->isArticleRelated()) {
						global $wgBlankImgUrl; ?>
						<p>
							<img src="<?php print $wgBlankImgUrl; ?>" class="sprite watch"> <?= $this->skin->watchThisPage(); ?>
						</p>
					<?php } ?>
				</div>
			</article>

			<!-- DEV NOTE: These spotlights only show up on non-"homepage" pages. -->
			<section id="wikia-spotlights">
				<?php echo AdEngine::getInstance()->getAd('FOOTER_SPOTLIGHT_LEFT'); ?>
				<?php echo AdEngine::getInstance()->getAd('FOOTER_SPOTLIGHT_MIDDLE_LEFT'); ?>
				<?php echo AdEngine::getInstance()->getAd('FOOTER_SPOTLIGHT_MIDDLE_RIGHT'); ?>
				<?php echo AdEngine::getInstance()->getAd('FOOTER_SPOTLIGHT_RIGHT'); ?>
			</section>
		</div><!-- END: #MainContent -->

		<?php print $this->htmlCompanyInfo();?>
		<?php print $this->htmlGlobalFooter();?>

	</body>
</html>

<?php
	}

	function getTopAdCode() {
		global $wgOut;
		$topAdCode = '';
		if (ArticleAdLogic::isMainPage()){
			return $topAdCode;
		} elseif (ArticleAdLogic::isSearch()) {
			$topAdCode .= "<div id='CORP_TOP_LEADERBOARD' style='width:728px; margin-left: auto; margin-right:auto; padding-bottom: 30px; margin-top: -30px'>" . AdEngine::getInstance()->getAd('CORP_TOP_LEADERBOARD') . "</div>"; 
			$topAdCode .= "<div id='CORP_TOP_RIGHT_BOXAD' style='margin-top:-15px; float: right'>" . AdEngine::getInstance()->getAd('CORP_TOP_RIGHT_BOXAD') . "</div>";
		} elseif (!$wgOut->isArticle()){
			return $topAdCode;
		} else {
			// move to AdEngine, use hooks
			if (AutoHubsPagesHelper::showAds()) {
			$topAdCode .= "<div id='CORP_TOP_LEADERBOARD' style='width:728px; margin-left: auto; margin-right:auto; padding-bottom: 10px'>" . AdEngine::getInstance()->getAd('CORP_TOP_LEADERBOARD') . "</div>"; 
			}
		}
		return $topAdCode;
	}
} // end of class

