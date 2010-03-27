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
	

	private function getSpotlight(){
		return CorporatePageHelper::parseMsgImg('corporatepage-slider',true);
	}
	
	public function prepareData($self,$tpl){
		parent::prepareData($self,$tpl);
		$tpl->set('slider', CorporatePageHelper::parseMsgImg('corporatepage-slider',true));
		$tpl->set('wikia_whats_up', wfMsgExt("corporatepage-wikia-whats-up",array("parsemag"))); 
		return true;
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
 class="<?php echo $this->data['body_class_attribute'] ?> isMainpage">

<?php print $this->htmlGlobalHeader();?>
		<!-- DEV NOTE: This is the dark navigation strip at the top. -->
<?php print $this->htmlGlobalNav();?>

		<div id="MainContent">
			<!-- DEV NOTE: This area has the blue-striped background.  -->

			<section id="HomepageFeature">
				<h1 id="homepage-feature-headline"><?php print wfMsg('corporatepage-homepage-feature-headline'); ?></h1>
				<div class="shrinkwrap">
					<div id="homepage-feature-box">
						<section id="homepage-feature-sidebar">
							<?php echo wfMsg('corporatepage-homepageintro'); ?>
							<div class="create-wiki-container">
								<a href="<?php echo $this->data['personal_urls']['createwiki']['href']; ?>" class="wikia-button big"><?php echo $this->data['personal_urls']['createwiki']['text']; ?></a>
							</div>
						</section>

						<section id="spotlight-slider">
						<h1 id="featured-wikis-headline"><?php print wfMsg('corporatepage-featured-wikis-headline'); ?></h1>
						<ul>
							<?php 
										$wiki_featured_images = array();
										foreach($this->data['slider'] as $key => $value): 
							?>
							<li id="spotlight-slider-<?php echo $key; ?>">
								<a href="<?php echo $value['href'] ?>">
									<img width="620" height="250" src="<?php echo $value['imagename'] ?>" class="spotlight-slider">
								</a>
								<div class="description">
									<h2><?php echo $value['title'] ?></h2>
									<p><?php echo $value['desc'] ?></p>
									<a href="<?php echo $value['href'] ?>" class="wikia-button secondary">
										<?php echo wfMsg('corporatepage-go-to-wiki',$value['title']); ?>
									</a>
								</div>
								<p class="nav">
									<img width="50" height="25" alt="" src="<?php echo $value['imagethumb'] ?>">
								</p>
							</li>
							<?php array_push($wiki_featured_images, $value['imagename']);
										endforeach;?>
						</ul>
						</section>
					</div>
				</div>
			</section>
			
			<script>
			<?php 
				$i = 0;
				foreach ($wiki_featured_images as $image) {
					echo 'var feature_image_'.$i.' = "'.$image.'";';
					$i++;
				}
			?>
			</script>

			<section id="MainArticle">
				<div class="shrinkwrap">
					<h1 id="wikia-overview-headline"><?php print wfMsg('corporatepage-wikia-overview-headline'); ?></h1>
					<section id="wikia-global-stats">
						<h1 id="wikia-wide-stats-headline"><?php print wfMsg('corporatepage-wikia-wide-stats-headline'); ?></h1>
						<ul>
							<li id="wikia-global-stats-0"><span><?php echo HomePageStatistic::getPagesAddedInLastHour() ?></span> <?php print wfMsg('corporatepage-pages-added'); ?></li>
							<li id="wikia-global-stats-1"><span><?php echo HomePageStatistic::getEditsThisDay(); ?></span> <?php print wfMsg('corporatepage-edits-made'); ?></li>
							<li id="wikia-global-stats-2"><span><?php echo HomePageStatistic::getWordsAddedLastWeek(); ?></span> <?php print wfMsg('corporatepage-words-added'); ?></li>
						</ul>
						<p><?php echo wfMsg('corporatepage-update-fqr'); ?></p>
					</section><!-- END #wikia-global-stats -->

					<section id="wikia-global-hot-spots">
						<h1><?php print wfMsg( 'corporatepage-wikia-hot-spots' ); ?></h1>
						<p><?php print wfMsg( 'corporatepage-wikia-hot-spots-desc' ); ?></p>
						<ol>
						<?php foreach(HomePageStatistic::getMostEditArticles72() as $key => $value ): ?>
							<li<?php echo ($key == 0 ? ' class="hilite"':''); ?>>
								<div class="page-activity-badge">
									<div class="page-activity-level-<?php echo $value['level']; ?>">
										<strong><?php echo $value['count']; ?></strong>
										<span><?php echo wfMsg( 'corporatepage-wikia-editors' ); ?></span>
									</div>
								</div>
								<span class="page-activity-sources">
									<a href="<?php echo $value['page_url']; ?>" class="wikia-page-link"><?php echo $value['page_name']; ?></a>
									<span>
										<span><?php print wfMsg('corporatepage-from'); ?></span>
										<a href="<?php echo $value['wikia_url']; ?>" class="wikia-wiki-link"><?php echo $value['wikia']; ?></a>
										<?php if ($this->data['is_manager']):?>
											(<?php echo $value['hub']; ?>)
											<a class="wikia-page-link staff-hide-link" href="<?php echo $wgExtensionsPath; ?>/wikia/CorporatePage/CorporatePageHelper.php?wiki=<?php echo $value['db']; ?>&name=<?php echo $value['real_pagename']; ?>"><img src="<?php print $wgStylePath?>/corporate/images/icon.delete.png" alt="<?php print wfMsg('corporatepage-hide'); ?>" title"<?php print wfMsg('corporatepage-hide'); ?>"></a>
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
							<?php echo $this->html('wikia_whats_up'); ?>
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
} // end of class
