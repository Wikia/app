<h1><?= wfMsg('oasis-global-page-header'); ?></h1>
<div class="skiplinkcontainer">
<a class="skiplink" rel="nofollow" href="#WikiaArticle"><?= wfMsg( 'oasis-skip-to-content' ); ?></a>
<a class="skiplink wikinav" rel="nofollow" href="#WikiHeader"><?= wfMsg( 'oasis-skip-to-wiki-navigation' ); ?></a>
<a class="skiplink sitenav" rel="nofollow" href="#GlobalNavigation"><?= wfMsg( 'oasis-skip-to-site-navigation' ); ?></a>
</div>
<?= $afterBodyHtml ?>

<div id="ad-skin" class="wikia-ad noprint"></div>
<?= F::app()->renderView('Ad', 'Index', array('slotname' => 'INVISIBLE_TOP')) ?>
<?= F::app()->renderView('Ad', 'Index', array('slotname' => 'HOME_INVISIBLE_TOP')) ?>
<?= F::app()->renderView('GlobalHeader', 'Index') ?>

<?= empty($wg->GlobalHeaderFullWidth) ? '' : F::app()->renderView('Notifications', 'Confirmation') ?>

<?= empty($wg->GlobalHeaderFullWidth) ? '' : F::app()->renderView('Ad', 'Top') ?>

<section id="WikiaPage" class="WikiaPage<?= empty( $wg->OasisNavV2 ) ? '' : ' V2' ?><?= !empty($isGridLayoutEnabled) ? ' WikiaGrid' : '' ?>">
	<div id="WikiaPageBackground" class="WikiaPageBackground"></div>
	<div class="WikiaPageContentWrapper">
		<?= empty($wg->GlobalHeaderFullWidth) ? F::app()->renderView('Notifications', 'Confirmation') : '' ?>

		<?= empty($wg->GlobalHeaderFullWidth) ? F::app()->renderView('Ad', 'Top') : '' ?>

		<?php
			if ( empty( $wg->SuppressWikiHeader ) ) {
				echo empty( $wg->OasisNavV2  )
					? F::app()->renderView( 'WikiHeader', 'Index' )
					: F::app()->renderView( 'WikiHeaderV2', 'Index' );
			}
		?>

		<?php
			if (!empty($wg->EnableWikiAnswers)) {
				echo F::app()->renderView('WikiAnswers', 'QuestionBox');
			}
		?>

		<?php
		if (!empty( $wg->InterlangOnTop ) ) {
			echo F::app()->renderView('ArticleInterlang', 'Index');
		}
		?>

		<?php
		if ($headerModuleName == 'UserPagesHeader' && ($headerModuleAction != 'BlogPost' && $headerModuleAction != 'BlogListing') ) {
			echo F::app()->renderView($headerModuleName, $headerModuleAction, $headerModuleParams);
		}
		?>
		
		<?php
			// Needs to be above page header so it can suppress page header
			if ($displayAdminDashboard) {
				echo F::app()->renderView('AdminDashboard', 'Chrome');
			}
		?>

		<article id="WikiaMainContent" class="WikiaMainContent<?= !empty($isGridLayoutEnabled) ? $railModulesExist ? ' grid-4' : ' grid-6' : '' ?>">
			<?php
				if (!empty($wg->EnableForumExt) && !empty($wg->IsForum)) {
					echo F::app()->renderView( 'ForumController', 'header' );
				}
				
				// render UserPagesHeader or PageHeader or nothing...
				if (empty($wg->SuppressPageHeader) && $headerModuleName) {
					if ($headerModuleName == 'UserPagesHeader') {
						if ($headerModuleAction == 'BlogPost' || $headerModuleAction == 'BlogListing') {
							// Show blog post header
							echo F::app()->renderView( $headerModuleName, $headerModuleAction, $headerModuleParams );
						} else {
							// Show just the edit button
							echo F::app()->renderView( 'UserProfilePage', 'renderActionButton', array() );
						}
					} else {
						echo F::app()->renderView($headerModuleName, $headerModuleAction, $headerModuleParams);
					}
				}
			?>


			<?php if ($subtitle != '' && $headerModuleName == 'UserPagesHeader' ) { ?>
				<div id="contentSub"><?= $subtitle ?></div>
			<?php } ?>

			<div id="WikiaArticle" class="WikiaArticle<?= $displayAdminDashboardChromedArticle ? ' AdminDashboardChromedArticle' : '' ?>"<?= $body_ondblclick ? ' ondblclick="' . htmlspecialchars($body_ondblclick) . '"' : '' ?>>
				<? if($displayAdminDashboardChromedArticle) { ?>
					<?= (string)F::app()->sendRequest( 'AdminDashboardSpecialPage', 'chromedArticleHeader', array('headerText' => $wg->Title->getText() )) ?>
				<? } ?>
				<div class="home-top-right-ads">
				<?php
					if (in_array('leaderboard', $wg->ABTests)) {
						echo F::app()->renderView('Ad', 'Index', array('slotname' => 'TEST_HOME_TOP_RIGHT_BOXAD'));
					} else {
						echo F::app()->renderView('Ad', 'Index', array('slotname' => 'HOME_TOP_RIGHT_BOXAD'));
					}

					echo F::app()->renderView('Ad', 'Index', array('slotname' => 'HOME_TOP_RIGHT_BUTTON'));
				?>
				</div>


				<?php
				// for InfoBox-Testing
				if ($wg->EnableInfoBoxTest) {
					echo F::app()->renderView('ArticleInfoBox', 'Index');
				}

				if ($wg->EnableCorporatePageExt && empty($wg->SuppressSlider)) {
					echo F::app()->renderView('CorporateSite', 'Slider');
				} ?>

				<?= $bodytext ?>

			</div>

			<?php
			if (empty($wg->SuppressArticleCategories)) {
				echo F::app()->renderView('ArticleCategories', 'Index');
			} ?>
			<?php
			if (empty( $wg->InterlangOnTop ) ) {
				 echo F::app()->renderView('ArticleInterlang', 'Index');
			}
			?>

			<?php if (!empty($afterContentHookText)) { ?>
				<div id="WikiaArticleFooter" class="WikiaArticleFooter">
					<?= $afterContentHookText ?>
				</div>
			<?php } ?>

			<div id="WikiaArticleBottomAd" class="noprint">
				<?= F::app()->renderView('Ad', 'Index', array('slotname' => 'PREFOOTER_LEFT_BOXAD')) ?>
				<?= F::app()->renderView('Ad', 'Index', array('slotname' => 'PREFOOTER_RIGHT_BOXAD')) ?>
			</div>

		</article><!-- WikiaMainContent -->

		<?php if( $railModulesExist ): ?>
			<?= F::app()->renderView('Rail', 'Index', array('railModuleList' => $railModuleList)); ?>
		<?php endif; ?>

		<?= empty($wg->SuppressFooter) ? F::app()->renderView('Footer', 'Index') : '' ?>
		<? if(!empty($wg->EnableWikiaHomePageExt)) echo F::App()->renderView('WikiaHomePage', 'footer') ?>
		<?= F::app()->renderView('CorporateFooter', 'Index') ?>
	</div>
</section><!--WikiaPage-->

<?php if( $wg->EnableWikiaBarExt ): ?>
	<?= F::app()->renderView('WikiaBar', 'Index'); ?>
<?php endif; ?>
