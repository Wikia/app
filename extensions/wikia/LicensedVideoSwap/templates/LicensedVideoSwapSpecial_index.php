<? global $wgStylePath ?>

<section class="lvs-callout">
	<button class="close wikia-chiclet-button">
		<img src="<?= $wgStylePath ?>/oasis/images/icon_close.png">
	</button>
	<h1><?= wfMessage('lvs-callout-header')->plain() ?></h1>
	<ul>
		<li>- <?= wfMessage('lvs-callout-reason-licensed')->plain() ?></li>
		<li>- <?= wfMessage('lvs-callout-reason-quality')->plain() ?></li>
		<li>- <?= wfMessage('lvs-callout-reason-collaborative')->plain() ?></li>
		<li>- <?= wfMessage('lvs-callout-reason-more')->plain() ?></li>
	</ul>
</section>

<p><?= wfMessage('lvs-instructions')->plain() ?></p>

<?= $app->renderView('WikiaStyleGuideElementsController', 'contentHeaderSort', $contentHeaderSortOptions ) ?>

<div class="WikiaGrid LVSGrid" id="LVSGrid">

	<?= $app->renderPartial('LicensedVideoSwapSpecial', 'row', array( 'videoList' => $videoList, 'thumbWidth' => $thumbWidth, 'thumbHeight' => $thumbHeight ) ) ?>

</div>

<?= $pagination ?>