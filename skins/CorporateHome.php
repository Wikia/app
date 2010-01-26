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

class SkinCorporateHome extends SkinCorporateBase {
	function initPage( OutputPage $out ) {
		parent::initPage( $out );
		$this->skinname  = 'CorporateHome';
		$this->stylename = 'CorporateHome';
		$this->template  = 'CorporateHomeTemplate';
	}
}

class CorporateHomeTemplate extends CorporateBaseTemplate {
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
		global $wgRequest, $wgStylePath, $wgUser, $wgExtensionsPath;
		$this->skin = $skin = $this->data['skin'];
		$action = $wgRequest->getText( 'action' );
		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();
?><!doctype html>
<html lang="<?php $this->text('lang'); ?>">
	<?php $this->htmlHead() ?>
	<!--
		DEV NOTE:
		At the end of this body tag, there is a hardcoded value to determine whether
		or not this is the homepage. As this template file is ONLY used for the
		homepage, this seems safe. However, I'd much rather figure out how to use the
		$isMainpage variable, and use that instead. When that is discovered, all the
		CSS in skins/corporate/css/main.css needs to be adjusted to use that value.
	-->
	<body<?php if($this->data['body_ondblclick']) { ?> ondblclick="<?php $this->text('body_ondblclick') ?>"<?php } ?>
<?php if($this->data['body_onload']) { ?> onload="<?php $this->text('body_onload') ?>"<?php } ?>
 class="<?php print $this->htmlBodyClassAttributeValues(); ?> isMainpage">

<?php print $this->htmlGlobalHeader();?>
		<!-- DEV NOTE: This is the dark navigation strip at the top. -->
<?php print $this->htmlGlobalNav();?>

		<div id="MainContent">
			<!-- DEV NOTE: This area has the blue-striped background.  -->

			<section id="HomepageFeature">
				<h1 id="homepage-feature-headline"><?php print wfMsg('home2-homepage-feature-headline'); ?></h1>
				<div class="shrinkwrap">
					<div id="homepage-feature-box">
						<section id="homepage-feature-sidebar">
							<?php echo wfMsg('home2-homepageintro'); ?>
							<div class="create-wiki-container">
								<a href="<?php echo $this->data['personal_urls']['createwiki']['href']; ?>" class="wikia_button"><span><?php echo $this->data['personal_urls']['createwiki']['text']; ?></span></a>
							</div>
						</section>
						<section id="homepage-feature-spotlight">
						<h1 id="featured-wikis-headline"><?php print wfMsg('home2-featured-wikis-headline'); ?></h1>
						<ul>
							<?php foreach($this->getSpotlight() as $key => $value): ?>
							<li id="homepage-feature-spotlight-<?php echo $key; ?>">
								<a href="<?php echo $value['href'] ?>">
								<img width="700" height="310" src="<?php echo $value['imagename'] ?>" class="homepage-spotlight"></a>
								<div class="description">
									<h2><?php echo $value['title'] ?></h2>
									<p><?php echo $value['desc'] ?></p>
									<a href="<?php echo $value['href'] ?>" class="wikia_button secondary">
										<span><?php echo wfMsg('home2-go-to-wiki',$value['title']); ?></span>
									</a>
								</div>
								<p class="nav">
									<img width="50" height="25" alt="" src="<?php echo $value['imagethumb'] ?>">
								</p>
							</li>
							<?php endforeach;?>
						</ul>
						</section>
					</div>
				</div>
			</section>

			<section id="MainArticle">
				<div class="shrinkwrap">
					<h1 id="wikia-overview-headline"><?php print wfMsg('home2-wikia-overview-headline'); ?></h1>
					<section id="wikia-global-stats">
						<h1 id="wikia-wide-stats-headline"><?php print wfMsg('home2-wikia-wide-stats-headline'); ?></h1>
						<ul>
							<li id="wikia-global-stats-0"><span><?php echo HomePageStatistic::getWordsInLastHour(); ?></span> words added in the last hour</li>
							<li id="wikia-global-stats-1"><span><?php echo HomePageStatistic::getEditsThisWeek(); ?></span> edits made this week</li>
							<li id="wikia-global-stats-2"><span><?php echo HomePageStatistic::getAddedThisMonth(); ?></span> pages added this month</li>
						</ul>
						<p><?php echo wfMsg('home2-update-fqr'); ?></p>
					</section><!-- END #wikia-global-stats -->

					<section id="wikia-global-hot-spots">
						<h1><?php print wfMsg( 'home2-wikia-hot-spots' ); ?></h1>
						<p><?php print wfMsg( 'home2-wikia-hot-spots-desc' ); ?></p>
						<ol>
						<?php foreach(HomePageStatistic::getMostEditArticles72() as $key => $value ): ?>
							<li<?php echo ($key == 0 ? ' class="hilite"':''); ?>>
								<div class="page-activity-badge">
									<div class="page-activity-level-<?php echo $value['level']; ?>">
										<strong><?php echo $value['count']; ?></strong>
										<span><?php echo wfMsg( 'home2-wikia-editors' ); ?></span>
									</div>
								</div>
								<span class="page-activity-sources">
									<a href="<?php echo $value['page_url']; ?>" class="wikia-page-link"><?php echo $value['page_name']; ?></a>
									<span>
										<span><?php print wfMsg('home2-from'); ?></span>
										<a href="<?php echo $value['wikia_url']; ?>" class="wikia-wiki-link"><?php echo $value['wikia']; ?></a>
										<?php if ($this->isManager()):?>
										<a class="wikia-page-link staff-hide-link" href="<?php echo $wgExtensionsPath; ?>/wikia/CorporatePage/CorporatePageHelper.php?wiki=<?php echo $value['db']; ?>&name=<?php echo $value['page_name']; ?>"><img src="<?php print $wgStylePath?>/corporate/images/icon.delete.png" alt="<?php print wfMsg('home2-hide'); ?>" title"<?php print wfMsg('home2-hide'); ?>"></a>
										<?php endif;?>
									</span>
								</span>
							</li>
						<?php endforeach; ?>
						</ol>
					</section>

					<section id="wikia-whats-up">
						<?php //print $this->htmlMainArticleContents();?>
						<div class="shrinkwrap">
						<!--
							DEV NOTE:
							This will be text from a message, not from an article.
							Moreover, the message MUST begin with an <h1> followed
							immediately by an <h2> in order to function correctly.
						-->
							<?php echo $this->getWikiaWhatsUp(); ?>
						</div>
					</section>

				</div>
			</section>
		</div><!-- END: #MainContent -->

		<?php print $this->htmlCompanyInfo();?>
		<?php print $this->htmlGlobalFooter();?>

	</body>
</html>

<?php
	}

	private function getSpotlight(){
		return $this->parseMsgImg('home2-slider',true);
	}

	private function getWikiaWhatsUp(){
		global $wgMemc,$wgLang;
		$msg = "home2-wikia-whats-up";
		$key = wfMemcKey( "hp_msg_parser", $msg, $wgLang->getCode());
		$out = $wgMemc->get($key ,null);
		if ($this->memc && $out != null){
			return $out;
		}
		$out = wfMsgExt($msg,array("parsemag"));
		$wgMemc->set($key, $out, 60*60);
		return $out;
	}
} // end of class
