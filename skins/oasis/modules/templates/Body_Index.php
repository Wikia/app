<?php
/** @var $displayHeader bool */
/** @var $afterBodyHtml string */
/** @var $beforeWikiaPageHtml string */
/** @var $headerModuleName string */
/** @var $headerModuleAction string */
/** @var $isEditPage bool */
?>

<? if ( !empty( $wg->InContextTranslationsProject ) ): ?>
	<script type="text/javascript">
		var _jipt = [['project', '<?= addslashes($wg->InContextTranslationsProject) ?>' ]];
	</script>
	<script type="text/javascript" src="//cdn.crowdin.com/jipt/jipt.js"></script>
<? endif; ?>

<? if ( $displayHeader ): ?>
	<h2><?= wfMessage( 'oasis-global-page-header' )->escaped(); ?></h2>
<? endif; ?>
<div class="skiplinkcontainer">
<a class="skiplink" rel="nofollow" href="#WikiaArticle"><?= wfMessage( 'oasis-skip-to-content' )->escaped(); ?></a>
<a class="skiplink wikinav" rel="nofollow" href="#WikiHeader"><?= wfMessage( 'oasis-skip-to-wiki-navigation' )->escaped(); ?></a>
<a class="skiplink sitenav" rel="nofollow" href="#GlobalNavigation"><?= wfMessage( 'oasis-skip-to-site-navigation' )->escaped(); ?></a>
</div>
<?= $afterBodyHtml ?>

<div id="ad-skin" class="wikia-ad noprint"></div>

<?= $app->renderView( 'DesignSystemGlobalNavigationService', 'index' ) ?>
<? if ( !empty( $wg->EnablePremiumPageHeader ) && empty( $wg->SuppressWikiHeader ) ): ?>
	<div class="banner-notifications-placeholder">
		<?= $app->renderView( 'BannerNotifications', 'Confirmation' ) ?>
	</div>
<? endif; ?>
<?= $app->renderView( 'Ad', 'Top' ) ?>
<?= empty( $wg->EnableEBS ) ? '' : $app->renderView( 'EmergencyBroadcastSystem', 'index' ); ?>

<?= $app->renderView('AdEmptyContainer', 'Index', ['slotName' => 'TOP_LEADERBOARD_AB']); ?>

<?= empty( $wg->WikiaSeasonsPencilUnit ) ? '' : $app->renderView( 'WikiaSeasons', 'pencilUnit', array() ); ?>

<?= $beforeWikiaPageHtml ?>

<section id="WikiaPage" class="WikiaPage<?= empty( $wg->OasisNavV2 ) ? '' : ' V2' ?><?= !empty( $isGridLayoutEnabled ) ? ' WikiaGrid' : '' ?>">
	<div id="WikiaPageBackground" class="WikiaPageBackground"></div>
	<div class="WikiaPageContentWrapper">

		<? if ( !empty( $wg->EnablePremiumPageHeader ) && empty( $wg->SuppressWikiHeader ) ) : ?>
			<div class="PremiumPageHeader">
				<?= $app->renderView( 'PremiumPageHeader', 'wikiHeader' ) ?>
			</div>
		<? else: ?>
			<?= $app->renderView( 'BannerNotifications', 'Confirmation' ) ?>
		<? endif; ?>

		<? if ( empty( $wg->SuppressWikiHeader ) ) : ?>
			<?= $app->renderView( 'WikiHeader', 'Index' ) ?>
		<? endif; ?>

		<? if ( !empty( $wg->EnableWikiAnswers ) ) : ?>
			<?= $app->renderView( 'WikiAnswers', 'QuestionBox' ) ?>
		<? endif; ?>

		<? if ( !empty( $wg->InterlangOnTop ) ) : ?>
			<?= $app->renderView( 'ArticleInterlang', 'Index' ) ?>
		<? endif; ?>

		<? if ( $headerModuleName == 'UserPagesHeader' && ( $headerModuleAction != 'BlogPost' && $headerModuleAction != 'BlogListing' ) ) : ?>
			<?= $app->renderView( $headerModuleName, $headerModuleAction, $headerModuleParams ) ?>
		<? endif; ?>

		<? if ( $displayAdminDashboard ) : ?>
			<!--Needs to be above page header so it can suppress page header-->
			<?= $app->renderView( 'AdminDashboard', 'Chrome' ) ?>
		<? endif; ?>

		<? if ( !empty( $wg->EnablePremiumPageHeader ) ) : ?>
			<div class="PremiumPageArticleHeader">
				<?= $app->renderView( 'PremiumPageHeader', 'articleHeader' ) ?>
			</div>
		<? endif; ?>

		<? if ( empty( $wg->SuppressPageHeader ) ) : ?>
			<?= $app->renderView('PageHeader', 'index') ?>
		<? endif; ?>

		<article id="WikiaMainContent" class="WikiaMainContent<?= !empty( $isGridLayoutEnabled ) ? $railModulesExist ? ' grid-4' : ' grid-6' : '' ?>">
			<div id="WikiaMainContentContainer" class="WikiaMainContentContainer">
				<?php
					// render UserPagesHeader or PageHeader or nothing...
					if ( empty( $wg->SuppressPageHeader ) && $headerModuleName ) {
						if ( $headerModuleName == 'UserPagesHeader' ) {
							if ( $headerModuleAction == 'BlogPost' || $headerModuleAction == 'BlogListing' ) {
								// Show blog post header
								echo $app->renderView( $headerModuleName, $headerModuleAction, $headerModuleParams );
							} else {
								// Show just the edit button
								echo $app->renderView( 'UserProfilePage', 'renderActionButton', array() );
							}
						} else {
							//Todo: remove
//							var_dump($headerModuleName);
//							if ($headerModuleName !== 'PageHeader' && $headerModuleName !== 'Forum') {
//								echo $app->renderView( $headerModuleName, $headerModuleAction, $headerModuleParams );
//
//							}
						}
					}
				?>

				<? if ( $wg->enableArticleFeaturedVideo ) : ?>
					<?= $app->renderView( 'ArticleVideo', 'featured' ) ?>
				<? endif; ?>

				<? if ( $wg->enableArticleRelatedVideo ) : ?>
					<?= $app->renderView( 'ArticleVideo', 'related' ) ?>
				<? endif; ?>

				<? if ( $subtitle != '' && $headerModuleName == 'UserPagesHeader' ) : ?>
					<div id="contentSub"><?= $subtitle ?></div>
				<? endif; ?>

				<div id="WikiaArticle" class="WikiaArticle">
					<div class="home-top-right-ads">
					<?php
						if ( !WikiaPageType::isCorporatePage() && !$wg->EnableVideoPageToolExt && WikiaPageType::isMainPage() ) {
							echo $app->renderView( 'Ad', 'Index', [
								'slotName' => 'TOP_RIGHT_BOXAD',
								'pageTypes' => ['homepage_logged', 'corporate', 'all_ads']
							] );
						}
					?>
					</div>

					<?php
					// for InfoBox-Testing
					if ( $wg->EnableInfoBoxTest ) {
						echo $app->renderView( 'ArticleInfoBox', 'Index' );
					} ?>

					<?= $bodytext ?>

				</div>

				<? if ( ARecoveryModule::isSourcePointRecoveryEnabled() ) : ?>
					<!--googleoff: all-->
					<div id="WikiaArticleMsg">
						<h2><?= wfMessage('arecovery-blocked-message-headline')->escaped() ?></h2>
						<br />
						<h3><?= wfMessage('arecovery-blocked-message-part-one')->escaped() ?>
							<br /><br />
							<?= wfMessage('arecovery-blocked-message-part-two')->escaped() ?>
						</h3>
					</div>
					<!--googleon: all-->
				<? endif; ?>

				<? if ( empty( $wg->SuppressArticleCategories ) ): ?>
					<? if ( !empty( $wg->EnableCategorySelectExt ) && CategorySelectHelper::isEnabled() ): ?>
						<?= $app->renderView( 'CategorySelect', 'articlePage' ) ?>
					<? else: ?>
						<?= $app->renderView( 'ArticleCategories', 'Index' ) ?>
					<? endif; ?>
				<? endif; ?>

				<? if ( empty( $wg->InterlangOnTop ) ) : ?>
					<?= $app->renderView( 'ArticleInterlang', 'Index' ) ?>
				<? endif; ?>

				<? if ( !empty( $afterContentHookText ) ) : ?>
					<div id="WikiaArticleFooter" class="WikiaArticleFooter">
						<?= $afterContentHookText ?>
					</div>
				<? endif; ?>

				<div id="WikiaArticleBottomAd" class="noprint">
					<?= $app->renderView( 'Ad', 'Index', ['slotName' => 'PREFOOTER_LEFT_BOXAD', 'onLoad' => true] ) ?>

					<? if ( WikiaPageType::isMainPage() ) : ?>
						<?= $app->renderView( 'Ad', 'Index', ['slotName' => 'PREFOOTER_MIDDLE_BOXAD', 'onLoad' => true] ) ?>
					<? endif; ?>

					<?= $app->renderView( 'Ad', 'Index', ['slotName' => 'PREFOOTER_RIGHT_BOXAD', 'onLoad' => true] ) ?>
				</div>
			</div>
		</article><!-- WikiaMainContent -->

		<? if ( $railModulesExist ) : ?>
			<?= $app->renderView( 'Rail', 'Index', array( 'railModuleList' => $railModuleList, 'isEditPage' => $isEditPage ) ); ?>
		<? endif; ?>

		<? if ( $displayAdminDashboard ) : ?>
			<?= $app->renderView( 'AdminDashboard', 'Rail' ) ?>
		<? endif; ?>

		<?= empty( $wg->SuppressFooter ) ? $app->renderView( 'Footer', 'Index' ) : '' ?>
	</div>
</section><!--WikiaPage-->

<?= $app->renderView( 'DesignSystemGlobalFooterService', 'index' ); ?>

<? if ( $wg->EnableWikiaBarExt ): ?>
	<?= $app->renderView( 'WikiaBar', 'Index' ); ?>
<? endif; ?>
