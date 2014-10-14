<article id="WikiaMainContent" class="WikiaMainContent<?= !empty($isGridLayoutEnabled) ? $railModulesExist ? ' grid-4' : ' grid-6' : '' ?>">
	<div id="WikiaMainContentContainer" class="WikiaMainContentContainer">
		<?php
			if (!empty($wg->EnableForumExt) && ForumHelper::isForum()) {
				echo $app->renderView( 'ForumController', 'header' );
			}

			// render UserPagesHeader or PageHeader or nothing...
			if (empty($wg->SuppressPageHeader) && $headerModuleName) {
				if ($headerModuleName == 'UserPagesHeader') {
					if ($headerModuleAction == 'BlogPost' || $headerModuleAction == 'BlogListing') {
						// Show blog post header
						echo $app->renderView( $headerModuleName, $headerModuleAction, $headerModuleParams );
					} else {
						// Show just the edit button
						echo $app->renderView( 'UserProfilePage', 'renderActionButton', array() );
					}
				} else {
					echo $app->renderView($headerModuleName, $headerModuleAction, $headerModuleParams);
				}
			}
			?>


			<?php if ($subtitle != '' && $headerModuleName == 'UserPagesHeader' ) { ?>
				<div id="contentSub"><?= $subtitle ?></div>
			<?php } ?>

			<div id="WikiaArticle" class="WikiaArticle<?= $displayAdminDashboardChromedArticle ? ' AdminDashboardChromedArticle' : '' ?>"<?= $body_ondblclick ? ' ondblclick="' . htmlspecialchars($body_ondblclick) . '"' : '' ?>>
				<? if($displayAdminDashboardChromedArticle) { ?>
					<?= (string)$app->sendRequest( 'AdminDashboardSpecialPage', 'chromedArticleHeader', array('headerText' => $wg->Title->getText() )) ?>
				<? } ?>

				<div class="home-top-right-ads">
					<?php
					if ( !WikiaPageType::isCorporatePage() && !$wg->EnableVideoPageToolExt && WikiaPageType::isMainPage() ) {
						echo $app->renderView('Ad', 'Index', ['slotName' => 'HOME_TOP_RIGHT_BOXAD', 'pageTypes' => ['homepage_logged', 'corporate', 'all_ads']]);
					}
					?>
				</div>

				<?php
				// for InfoBox-Testing
				if ($wg->EnableInfoBoxTest) {
					echo $app->renderView('ArticleInfoBox', 'Index');
				} ?>

				<?= $bodytext ?>

			</div>

			<? if ( empty( $wg->SuppressArticleCategories ) ): ?>
				<? if ( !empty( $wg->EnableCategorySelectExt ) && CategorySelectHelper::isEnabled() ): ?>
					<?= $app->renderView( 'CategorySelect', 'articlePage' ) ?>
				<? else: ?>
					<?= $app->renderView( 'ArticleCategories', 'Index' ) ?>
				<? endif ?>
			<? endif ?>

			<?php
			if (empty( $wg->InterlangOnTop ) ) {
				echo $app->renderView('ArticleInterlang', 'Index');
			}
			?>

			<?php if (!empty($afterContentHookText)) { ?>
				<div id="WikiaArticleFooter" class="WikiaArticleFooter">
					<?= $afterContentHookText ?>
				</div>
			<?php } ?>

			<div id="WikiaArticleBottomAd" class="noprint">
				<?= $app->renderView('Ad', 'Index', ['slotName' => 'PREFOOTER_LEFT_BOXAD']) ?>
				<?= $app->renderView('Ad', 'Index', ['slotName' => 'PREFOOTER_RIGHT_BOXAD']) ?>
			</div>
	</div>
</article><!-- WikiaMainContent -->

<?php if( $railModulesExist ): ?>
	<?= $app->renderView('Rail', 'Index', array('railModuleList' => $railModuleList)); ?>
<?php endif; ?>

<?php
if ($displayAdminDashboard) {
	echo $app->renderView('AdminDashboard', 'Rail');
}
?>
