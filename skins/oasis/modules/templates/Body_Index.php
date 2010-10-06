<? if (!$wgSingleH1) { ?>
<h1>Wikia</h1>
<? } ?>
<div class="skiplinkcontainer">
<a class="skiplink" rel="nofollow" href="#WikiaArticle">Skip to Content</a>
<a class="skiplink wikinav" rel="nofollow" href="#WikiHeader">Skip to Wiki Navigation</a>
<a class="skiplink sitenav" rel="nofollow" href="#GlobalNavigation">Skip to Site Navigation</a>
</div>
<?= $afterBodyHtml ?>

<? if ($showTestAds) { echo wfRenderModule('Ad', 'Index', array('slotname' => 'INVISIBLE_TOP')); } ?>
<? if ($showTestAds) { echo wfRenderModule('Ad', 'Index', array('slotname' => 'HOME_INVISIBLE_TOP')); } ?>
<?= wfRenderModule('GlobalHeader') ?>

<section id="WikiaPage" class="WikiaPage">


	<?= wfRenderModule('Notifications', 'Confirmation') ?>

	<?
	if ($isMainPage) {
		echo '<div class="WikiaMainPageBanner">';
	}
	?>

	<?= wfRenderModule('Ad', 'Index', array('slotname' => 'TOP_LEADERBOARD')) ?>
	<?= wfRenderModule('Ad', 'Index', array('slotname' => 'HOME_TOP_LEADERBOARD')) ?>

	<?
	if ($isMainPage) {
		echo '</div>';
	}
	?>

	<?php
		if (empty($wgSuppressWikiHeader)) {
			echo wfRenderModule('WikiHeader');
		}
	?>

	<article id="WikiaMainContent" class="WikiaMainContent">
		<?php
			// render UserPagesHeader or PageHeader or nothing...
			if (empty($wgSuppressPageHeader) && $headerModuleName) {
				echo wfRenderModule($headerModuleName, $headerModuleAction, $headerModuleParams);
			}
		?>
		<div id="WikiaArticle" class="WikiaArticle">
			<?= wfRenderModule('Ad', 'Index', array('slotname' => 'HOME_TOP_RIGHT_BOXAD')) ?>

			<?php
			if ($wgEnableCorporatePageExt) {
				echo wfRenderModule('CorporateSite', 'Slider');
			} ?>

			<?= $bodytext ?>
		</div>

		<?= wfRenderModule('RelatedPages'); ?>

		<?php
		if (empty($wgSuppressArticleCategories)) {
			echo wfRenderModule('ArticleCategories');
		} ?>
		<?= wfRenderModule('ArticleInterlang') ?>

		<div id="WikiaArticleBottomAd" class="noprint">
			<?= wfRenderModule('Ad', 'Index', array('slotname' => 'PREFOOTER_LEFT_BOXAD')) ?>
			<?= wfRenderModule('Ad', 'Index', array('slotname' => 'PREFOOTER_RIGHT_BOXAD')) ?>
		</div>

<?php
	if ($displayComments) {
		echo wfRenderModule('ArticleComments');
	}
?>

	</article><!-- WikiaMainContent -->

<?php
	if (count($railModuleList) > 0) {
		echo wfRenderModule('Rail', 'Index', array('railModuleList' => $railModuleList));
	}
?>

	<?= empty($wgSuppressFooter) ? wfRenderModule('Footer') : '' ?>
	
	<?= wfRenderModule('CorporateFooter') ?>

</section><!--WikiaPage-->

<?php
	/* tmp turned off
	if (empty($wgSuppressAds)) {
		echo wfRenderModule('Ad', 'Index', array('slotname' => 'INVISIBLE_1'));
		echo wfRenderModule('Ad', 'Index', array('slotname' => 'INVISIBLE_2'));
	}
	*/
?>
