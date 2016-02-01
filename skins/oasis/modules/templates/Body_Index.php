<?php if ( $displayHeader ) { ?>
	<h2><?= wfMessage( 'oasis-global-page-header' )->escaped() ?></h2>
<?php } ?>
<div class="skiplinkcontainer">
	<a class="skiplink" rel="nofollow" href="#WikiaArticle">
		<?= wfMessage( 'oasis-skip-to-content' )->escaped() ?>
	</a>
	<a class="skiplink wikinav" rel="nofollow" href="#WikiHeader">
		<?= wfMessage( 'oasis-skip-to-wiki-navigation' )->escaped() ?>
	</a>
	<a class="skiplink sitenav" rel="nofollow" href="#GlobalNavigation">
		<?= wfMessage( 'oasis-skip-to-site-navigation' )->escaped() ?>
	</a>
</div>

<?= $afterBodyHtml ?>

<div id="ad-skin" class="wikia-ad noprint"></div>

<?= $app->renderView( 'GlobalNavigation', 'index' ) ?>

<?php if ( !empty( $wg->EnableEBS ) ) {
	echo $app->renderView( 'EmergencyBroadcastSystem', 'index' );
} ?>

<?= $app->renderView( 'Ad', 'Top' ) ?>

<?php if ( !empty( $wg->WikiaSeasonsPencilUnit ) ) {
	echo $app->renderView( 'WikiaSeasons', 'pencilUnit', [] );
} ?>

<section id="WikiaPage" class="WikiaPage<?= empty( $wg->OasisNavV2 ) ? '' : ' V2' ?><?= !empty( $isGridLayoutEnabled ) ? ' WikiaGrid' : '' ?>">
	<div id="WikiaPageBackground" class="WikiaPageBackground"></div>
	<div class="WikiaPageContentWrapper">
		<?= $app->renderView( 'BannerNotifications', 'Confirmation' ) ?>

		<?php $runNjord = ( !empty( $wg->EnableNjordExt ) && WikiaPageType::isMainPage() );

		if ( $runNjord ) {
			echo $app->renderView( 'Njord', 'Index' );
		}

		if ( empty( $wg->SuppressWikiHeader ) ) {
			echo $app->renderView( 'WikiHeader', 'Index' );
		}

		if ( !empty( $wg->EnableWikiAnswers ) ) {
			echo $app->renderView( 'WikiAnswers', 'QuestionBox' );
		}

		if ( !empty( $wg->InterlangOnTop ) ) {
			echo $app->renderView( 'ArticleInterlang', 'Index' );
		}

		if (
			$headerModuleName == 'UserPagesHeader' && (
				$headerModuleAction != 'BlogPost' &&
				$headerModuleAction != 'BlogListing'
			)
		) {
			echo $app->renderView( $headerModuleName, $headerModuleAction, $headerModuleParams );
		}

		// Needs to be above page header so it can suppress page header
		if ( $displayAdminDashboard ) {
			echo $app->renderView( 'AdminDashboard', 'Chrome' );
		} ?>
		<article id="WikiaMainContent" class="WikiaMainContent<?= !empty( $isGridLayoutEnabled ) ? $railModulesExist ? ' grid-4' : ' grid-6' : '' ?>">
			<?php if ( !empty( $wg->EnableMomModulesExt ) && WikiaPageType::isMainPage() ) {
				echo $app->renderView( 'Njord', 'mom' );
			} ?>

			<div id="WikiaMainContentContainer" class="WikiaMainContentContainer">
				<?php if ( !empty( $wg->EnableForumExt ) && ForumHelper::isForum() ) {
					echo $app->renderView( 'ForumController', 'header' );
				}

				// render UserPagesHeader or PageHeader or nothing...
				if ( empty( $wg->SuppressPageHeader ) && $headerModuleName ) {
					if ( $headerModuleName == 'UserPagesHeader' ) {
						if (
							$headerModuleAction == 'BlogPost' ||
							$headerModuleAction == 'BlogListing'
						) {
							// Show blog post header
							echo $app->renderView( $headerModuleName, $headerModuleAction, $headerModuleParams );
						} else {
							// Show just the edit button
							echo $app->renderView( 'UserProfilePage', 'renderActionButton', [] );
						}
					} else {
						if ( !$runNjord ) {
							echo $app->renderView( $headerModuleName, $headerModuleAction, $headerModuleParams );
						}
					}
				}

				if ( $subtitle != '' && $headerModuleName == 'UserPagesHeader' ) { ?>
					<div id="contentSub"><?= $subtitle ?></div>
				<?php } ?>

				<div id="WikiaArticle" class="WikiaArticle<?= $displayAdminDashboardChromedArticle ? ' AdminDashboardChromedArticle' : '' ?>"<?= $body_ondblclick ? ' ondblclick="' . htmlspecialchars( $body_ondblclick ) . '"' : '' ?>>
					<?php if ( $displayAdminDashboardChromedArticle ) {
						echo $app->sendRequest(
							'AdminDashboardSpecialPage',
							'chromedArticleHeader',
							[ 'headerText' => $wg->Title->getText() ]
						);
					} ?>

					<div class="home-top-right-ads">
						<?php if (
							!WikiaPageType::isCorporatePage() &&
							!$wg->EnableVideoPageToolExt &&
							WikiaPageType::isMainPage()
						) {
							echo $app->renderView( 'Ad', 'Index', [
								'slotName' => 'HOME_TOP_RIGHT_BOXAD',
								'pageTypes' => [ 'homepage_logged', 'corporate', 'all_ads' ]
							] );
						} ?>
					</div>
					<?php if ( $runNjord ) {
						echo $app->renderView( 'Njord', 'Summary' );
						echo $app->renderView( $headerModuleName, $headerModuleAction, $headerModuleParams );
					}

					// for InfoBox-Testing
					if ( $wg->EnableInfoBoxTest ) {
						echo $app->renderView( 'ArticleInfoBox', 'Index' );
					} ?>

					<?= $bodytext ?>
				</div>

				<?php if ( empty( $wg->SuppressArticleCategories ) ) {
					if (
						!empty( $wg->EnableCategorySelectExt ) &&
						CategorySelectHelper::isEnabled()
					) {
						echo $app->renderView( 'CategorySelect', 'articlePage' );
					} else {
						echo $app->renderView( 'ArticleCategories', 'Index' );
					}
				}

				if ( empty( $wg->InterlangOnTop ) ) {
					 echo $app->renderView( 'ArticleInterlang', 'Index' );
				}

				if (
					!empty( $wg->EnableMonetizationModuleExt ) &&
					!empty( $monetizationModules[MonetizationModuleHelper::SLOT_TYPE_BELOW_CATEGORY] )
				) {
					echo $monetizationModules[MonetizationModuleHelper::SLOT_TYPE_BELOW_CATEGORY];
				}

				if ( !empty( $afterContentHookText ) ) { ?>
					<div id="WikiaArticleFooter" class="WikiaArticleFooter">
						<?= $afterContentHookText ?>
					</div>
				<?php } ?>

				<?php if ( !empty( $wg->EnableMonetizationModuleExt ) ) {
					if ( !empty( $wg->AdDriverUseMonetizationService ) ) {
						echo $app->renderView(
							'Ad',
							'Index',
							[ 'slotName' => 'MON_ABOVE_FOOTER' ]
						);
					} elseif ( !empty( $monetizationModules[MonetizationModuleHelper::SLOT_TYPE_ABOVE_FOOTER] ) ) {
						echo $monetizationModules[MonetizationModuleHelper::SLOT_TYPE_ABOVE_FOOTER];
					}
				} ?>
				<div id="WikiaArticleBottomAd" class="noprint">
					<?php
					echo $app->renderView( 'Ad', 'Index', [
						'slotName' => 'PREFOOTER_LEFT_BOXAD',
						'onLoad' => true
					] );

					if ( WikiaPageType::isMainPage() ) {
						echo $app->renderView( 'Ad', 'Index', [
							'slotName' => 'PREFOOTER_MIDDLE_BOXAD',
							'onLoad' => true
						] );
					}

					echo $app->renderView( 'Ad', 'Index', [
						'slotName' => 'PREFOOTER_RIGHT_BOXAD',
						'onLoad' => true
					] );
					?>
				</div>
			</div>
		</article><!-- WikiaMainContent -->

		<?php if( $railModulesExist ) {
			echo $app->renderView(
				'Rail',
				'Index',
				[ 'railModuleList' => $railModuleList ]
			);
		}

		if ( $displayAdminDashboard ) {
			echo $app->renderView( 'AdminDashboard', 'Rail' );
		}

		if ( empty( $wg->SuppressFooter ) ) {
			echo $app->renderView( 'Footer', 'Index' );
		}

		if ( !empty( $wg->EnableCorporateFooterExt ) ) {
			echo $app->renderView( 'CorporateFooter', 'index' );
		}

		echo $app->renderView( 'GlobalFooter', 'index' );
		?>
	</div>
</section><!--WikiaPage-->

<?php if ( $wg->EnableWikiaBarExt ) {
	echo $app->renderView( 'WikiaBar', 'Index' );
}
