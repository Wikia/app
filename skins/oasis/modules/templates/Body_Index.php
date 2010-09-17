<h1>Wikia</h1>
<div class="skiplinkcontainer">
<a class="skiplink" rel="nofollow" href="#WikiaArticle">Skip to Content</a>
<a class="skiplink wikinav" rel="nofollow" href="#WikiHeader">Skip to Wiki Navigation</a>
<a class="skiplink sitenav" rel="nofollow" href="#GlobalNavigation">Skip to Site Navigation</a>
</div>
<?= $afterBodyHtml ?>

<?= wfRenderModule('Ad', 'Index', array('slotname' => 'INVISIBLE_TOP')) ?>
<?= wfRenderModule('Ad', 'Index', array('slotname' => 'HOME_INVISIBLE_TOP')) ?>
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
			<?= $bodytext ?>
		</div>

		<?= wfRenderModule('RelatedPages'); ?>

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

	</article><!-- WikiaMainContent -->

<?php
	if (count($railModuleList) > 0) {
		echo wfRenderModule('Rail', 'Index', array('railModuleList' => $railModuleList));
	}
?>

	<?= wfRenderModule('Footer') ?>

</section><!--WikiaPage-->

<?php
	if (empty($wgNoExternals)) {
		echo wfRenderModule('Feedback');
	}
?>
<?= wfRenderModule('Ad', 'Index', array('slotname' => 'INVISIBLE_1')) ?>
<?= wfRenderModule('Ad', 'Index', array('slotname' => 'INVISIBLE_2')) ?>
