<?php
/** @var $displayHeader bool */
/** @var $afterBodyHtml string */
/** @var $beforeWikiaPageHtml string */
/** @var $headerModuleName string */
/** @var $headerModuleAction string */
?>

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

<?= $app->renderView( 'Ad', 'Top' ) ?>
<?= $app->renderView( 'GlobalNavigation', 'index' ) ?>
<?= empty( $wg->EnableEBS ) ? '' : $app->renderView( 'EmergencyBroadcastSystem', 'index' ); ?>

<?= $app->renderView('AdEmptyContainer', 'Index', ['slotName' => 'TOP_LEADERBOARD_AB']); ?>

<?= empty( $wg->WikiaSeasonsPencilUnit ) ? '' : $app->renderView( 'WikiaSeasons', 'pencilUnit', array() ); ?>

<?= $beforeWikiaPageHtml ?>

<section id="WikiaPage" class="WikiaPage<?= empty( $wg->OasisNavV2 ) ? '' : ' V2' ?><?= !empty( $isGridLayoutEnabled ) ? ' WikiaGrid' : '' ?>">
	<div id="WikiaPageBackground" class="WikiaPageBackground"></div>
	<div class="WikiaPageContentWrapper">
		<?= $app->renderView( 'BannerNotifications', 'Confirmation' ) ?>
		<?php
			$runNjord = ( !empty( $wg->EnableNjordExt ) && WikiaPageType::isMainPage() );

			if ( $runNjord ) {
				echo $app->renderView( 'Njord', 'Index' );

			}

			if ( empty( $wg->SuppressWikiHeader ) ) {
				echo $app->renderView( 'WikiHeader', 'Index' );
			}
		?>
		<?php
			if ( !empty( $wg->EnableWikiAnswers ) ) {
				echo $app->renderView( 'WikiAnswers', 'QuestionBox' );
			}
		?>

		<?php
		if ( !empty( $wg->InterlangOnTop ) ) {
			echo $app->renderView( 'ArticleInterlang', 'Index' );
		}
		?>

		<?php
		if ( $headerModuleName == 'UserPagesHeader' && ( $headerModuleAction != 'BlogPost' && $headerModuleAction != 'BlogListing' ) ) {
			echo $app->renderView( $headerModuleName, $headerModuleAction, $headerModuleParams );
		}
		?>

		<?php
			// Needs to be above page header so it can suppress page header
			if ( $displayAdminDashboard ) {
				echo $app->renderView( 'AdminDashboard', 'Chrome' );
			}
		?>

		<article id="WikiaMainContent" class="WikiaMainContent<?= !empty( $isGridLayoutEnabled ) ? $railModulesExist ? ' grid-4' : ' grid-6' : '' ?>">
			<?php
			if ( !empty( $wg->EnableMomModulesExt ) && WikiaPageType::isMainPage() ) {
				echo $app->renderView( 'Njord', 'mom' );
			}
			?>
			<div id="WikiaMainContentContainer" class="WikiaMainContentContainer">
				<?php
					if ( !empty( $wg->EnableForumExt ) && ForumHelper::isForum() ) {
						echo $app->renderView( 'ForumController', 'header' );
					}

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
							if ( !$runNjord ) {
								echo $app->renderView( $headerModuleName, $headerModuleAction, $headerModuleParams );
							}
						}
					}
				?>


				<?php if ( $subtitle != '' && $headerModuleName == 'UserPagesHeader' ) { ?>
					<div id="contentSub"><?= $subtitle ?></div>
				<?php } ?>
				<?php if ( ARecoveryModule::isLockEnabled() ) { ?>
					<div id="WikiaArticleMsg">
						<h2><?= wfMessage('arecovery-blocked-message-headline')->escaped() ?></h2>
						<br />
						<h3><?= wfMessage('arecovery-blocked-message-part-one')->escaped() ?>
							<br /><br />
							<?= wfMessage('arecovery-blocked-message-part-two')->escaped() ?></h3>
					</div>
				<?php } ?>
				<div id="WikiaArticle" class="WikiaArticle">
					<div class="home-top-right-ads">
					<?php
						if ( !WikiaPageType::isCorporatePage() && !$wg->EnableVideoPageToolExt && WikiaPageType::isMainPage() ) {
							echo $app->renderView( 'Ad', 'Index', [
								'slotName' => 'HOME_TOP_RIGHT_BOXAD',
								'pageTypes' => ['homepage_logged', 'corporate', 'all_ads']
							] );
						}
					?>
					</div>
					<?php
					if ( $runNjord ) {
						echo $app->renderView( 'Njord', 'Summary' );
						echo $app->renderView( $headerModuleName, $headerModuleAction, $headerModuleParams );

					}
					?>
					<?php
					// for InfoBox-Testing
					if ( $wg->EnableInfoBoxTest ) {
						echo $app->renderView( 'ArticleInfoBox', 'Index' );
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
				if ( empty( $wg->InterlangOnTop ) ) {
					 echo $app->renderView( 'ArticleInterlang', 'Index' );
				}
				?>

				<?php
				if ( !empty( $wg->EnableMonetizationModuleExt ) && !empty( $monetizationModules[MonetizationModuleHelper::SLOT_TYPE_BELOW_CATEGORY] ) ) {
					echo $monetizationModules[MonetizationModuleHelper::SLOT_TYPE_BELOW_CATEGORY];
				}
				?>

				<?php if ( !empty( $afterContentHookText ) ) { ?>
					<div id="WikiaArticleFooter" class="WikiaArticleFooter">
						<?= $afterContentHookText ?>
					</div>
				<?php } ?>

				<?php
				if ( !empty( $wg->EnableMonetizationModuleExt ) ) {
					if ( !empty( $wg->AdDriverUseMonetizationService ) ) {
						echo $app->renderView( 'Ad', 'Index', ['slotName' => 'MON_ABOVE_FOOTER'] );
					} else if ( !empty( $monetizationModules[MonetizationModuleHelper::SLOT_TYPE_ABOVE_FOOTER] ) ) {
						echo $monetizationModules[MonetizationModuleHelper::SLOT_TYPE_ABOVE_FOOTER];
					}
				}
				?>
				<div id="WikiaArticleBottomAd" class="noprint">
					<?= $app->renderView( 'Ad', 'Index', ['slotName' => 'PREFOOTER_LEFT_BOXAD', 'onLoad' => true] ) ?>
					<?php
					if ( WikiaPageType::isMainPage() ) {
						echo $app->renderView( 'Ad', 'Index', ['slotName' => 'PREFOOTER_MIDDLE_BOXAD', 'onLoad' => true] );
					}
					?>
					<?= $app->renderView( 'Ad', 'Index', ['slotName' => 'PREFOOTER_RIGHT_BOXAD', 'onLoad' => true] ) ?>
				</div>
			</div>
		</article><!-- WikiaMainContent -->

		<?php if( $railModulesExist ): ?>
			<?= $app->renderView( 'Rail', 'Index', array( 'railModuleList' => $railModuleList ) ); ?>
		<?php endif; ?>

		<?php
		if ( $displayAdminDashboard ) {
			echo $app->renderView( 'AdminDashboard', 'Rail' );
		}
		?>

		<?= empty( $wg->SuppressFooter ) ? $app->renderView( 'Footer', 'Index' ) : '' ?>
		<? if ( !empty( $wg->EnableCorporateFooterExt ) && empty( $wg->EnableDesignSystem ) ) echo $app->renderView( 'CorporateFooter', 'index' ) ?>
		<? if ( empty( $wg->EnableDesignSystem ) ) echo $app->renderView( 'GlobalFooter', 'index' ); ?>
	</div>
</section><!--WikiaPage-->

<? if ( !empty( $wg->EnableDesignSystem ) ) echo $app->renderView( 'DesignSystemGlobalFooterService', 'index' ); ?>

<?php if ( $wg->EnableWikiaBarExt ): ?>
	<?= $app->renderView( 'WikiaBar', 'Index' ); ?>
<?php endif; ?>
