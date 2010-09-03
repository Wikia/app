<aside class="skiplinkcontainer">
<a class="skiplink" rel="nofollow" href="#WikiaArticle">Skip to Content</a>
<a class="skiplink wikinav" rel="nofollow" href="#WikiHeader">Skip to Wiki Navigation</a>
<a class="skiplink sitenav" rel="nofollow" href="#GlobalNavigation">Skip to Site Navigation</a>
</aside>
<?= $afterBodyHtml ?>

<?= wfRenderModule('Ad', 'Index', array('slotname' => 'INVISIBLE_TOP')) ?>
<?= wfRenderModule('Ad', 'Index', array('slotname' => 'HOME_INVISIBLE_TOP')) ?>
<?= wfRenderModule('GlobalHeader') ?>

<section id="WikiaPage" class="WikiaPage">
	<h1><?=$wgSitename?></h1>

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

	<?= wfRenderModule('WikiHeader') ?>

	<div id="WikiaMainContent" class="WikiaMainContent">

<?php
	// render UserPagesHeader or PageHeader or nothing...
	if ($headerModuleName) {
		echo wfRenderModule($headerModuleName, $headerModuleAction, $headerModuleParams);
	}
?>

		<article id="WikiaArticle" class="WikiaArticle">
			<?= $bodytext ?>
		</article>

		<?// turned off to avoid mess with live code = wfRenderModule('RelatedPages'); ?>

		<?= wfRenderModule('ArticleCategories') ?>

		<div id="WikiaArticleBottomAd" class="noprint">
			<?= wfRenderModule('Ad', 'Index', array('slotname' => 'PREFOOTER_LEFT_BOXAD')) ?>
			<?= wfRenderModule('Ad', 'Index', array('slotname' => 'PREFOOTER_RIGHT_BOXAD')) ?>
		</div>

<?php
	if ($displayComments) {
		echo wfRenderModule('ArticleComments');
	}
?>

	</div><!-- WikiaMainContent -->

<?php
	if (count($railModuleList) > 0) {
		echo wfRenderModule('Rail', 'Index', array('railModuleList' => $railModuleList));
	}
?>

	<?= wfRenderModule('Footer') ?>

</section><!--WikiaPage-->

<?= wfRenderModule('CorporateFooter') ?>
<?= wfRenderModule('Feedback') ?>
<?= wfRenderModule('Ad', 'Index', array('slotname' => 'INVISIBLE_1')) ?>
<?= wfRenderModule('Ad', 'Index', array('slotname' => 'INVISIBLE_2')) ?>