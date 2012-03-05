<h1>Wikia</h1>
<div class="skiplinkcontainer">
<a class="skiplink" rel="nofollow" href="#WikiaArticle">Skip to Content</a>
<a class="skiplink wikinav" rel="nofollow" href="#WikiHeader">Skip to Wiki Navigation</a>
<a class="skiplink sitenav" rel="nofollow" href="#GlobalNavigation">Skip to Site Navigation</a>
</div>
<?= $afterBodyHtml ?>

<div id="ad-skin" class="wikia-ad noprint"></div>
<?// Skins can be served out of TOP_LEADERBOARD with dcopt=ist option. Turning off INVISIBLE_TOP ?>
<?//= wfRenderModule('Ad', 'Index', array('slotname' => 'INVISIBLE_TOP')) ?>
<?//= wfRenderModule('Ad', 'Index', array('slotname' => 'HOME_INVISIBLE_TOP')) ?>
<?= wfRenderModule('GlobalHeader') ?>

<section id="WikiaPage" class="WikiaPage">


	<?= wfRenderModule('Notifications', 'Confirmation') ?>

	<?
	if ($isMainPage) {
		echo '<div class="WikiaMainPageBanner">';
	}
	if ($wgEnableCorporatePageExt) {
		echo wfRenderModule('Ad', 'Index', array('slotname' => 'CORP_TOP_LEADERBOARD'));
	} else {
		if (in_array('leaderboard', $wgABTests)) {
			// no leaderboard ads
		} else {
			echo wfRenderModule('Ad', 'Index', array('slotname' => 'TOP_LEADERBOARD'));
			echo wfRenderModule('Ad', 'Index', array('slotname' => 'HOME_TOP_LEADERBOARD'));
		}
	}
	if ($isMainPage) {
		echo '</div>';
	}
	?>
	

	<?php
		if (empty($wgSuppressWikiHeader)) {
			echo wfRenderModule('WikiHeader');
		}
	?>

	<?php
		echo wfRenderModule('WikiAnswers', 'QuestionBox');
	?>
	<article id="WikiaMainContent" class="WikiaMainContent">
		<?php
			// render UserPagesHeader or PageHeader or nothing...
			if (empty($wgSuppressPageHeader) && $headerModuleName) {
				echo wfRenderModule($headerModuleName, $headerModuleAction, $headerModuleParams);
			}
		?>
		<div id="WikiaArticle" class="WikiaArticle">
			<div class="home-top-right-ads">
			<?php 
				if (in_array('leaderboard', $wgABTests)) {
					echo wfRenderModule('Ad', 'Index', array('slotname' => 'TEST_HOME_TOP_RIGHT_BOXAD'));
				} else {
					echo wfRenderModule('Ad', 'Index', array('slotname' => 'HOME_TOP_RIGHT_BOXAD'));
				}

				echo wfRenderModule('Ad', 'Index', array('slotname' => 'HOME_TOP_RIGHT_BUTTON'));
			?>
			</div>


			<?php
			// for InfoBox-Testing
			if ($wgEnableInfoBoxTest) {
				echo wfRenderModule('ArticleInfoBox');
			}

			if ($wgEnableCorporatePageExt) {
				echo wfRenderModule('CorporateSite', 'Slider');
			} ?>

			<?php
			if ($displayComments) {
				echo wfRenderModule('ArticleComments');
			}
			if (empty($wgSuppressArticleCategories)) {
				echo wfRenderModule('ArticleCategories');
			} ?>
			<?= wfRenderModule('ArticleInterlang') ?>

			<?php if($displaySponsoredLinks): ?>
			<?= wfMsg('sponsor-header'); ?>
			<div class="sponsormsg">
			<ul>
			</ul>
			</div>
			<?php endif; ?>

		</div>

		<div id="WikiaArticleBottomAd" class="noprint">
			<?= wfRenderModule('Ad', 'Index', array('slotname' => 'PREFOOTER_LEFT_BOXAD')) ?>
			<?= wfRenderModule('Ad', 'Index', array('slotname' => 'PREFOOTER_RIGHT_BOXAD')) ?>
		</div>

	</article><!-- WikiaMainContent -->

<?php
	if (count($railModuleList) > 0) {
		echo wfRenderModule('Rail', 'Index', array('railModuleList' => $railModuleList));
	}
?>

	<?= empty($wgSuppressFooter) ? wfRenderModule('Footer') : '' ?>
	<?= wfRenderModule('CorporateFooter') ?>

</section><!--WikiaPage-->
