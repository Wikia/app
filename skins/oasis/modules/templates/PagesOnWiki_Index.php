<section class="WikiaPagesOnWikiModule">
	<? if (!$wgSingleH1) { ?>
		<h1><?= wfMsg('oasis-pages-on-wiki-header', $wgSitename) ?></h1>
	<? } ?>
	<?= View::specialPageLink('CreatePage', 'button-createpage', 'wikia-button createpage', 'blank.gif', 'oasis-create-page', 'osprite icon-add'); ?>
	<details class="tally">
		<em><?= $total ?></em> <?= wfMsg('oasis-total-articles-mainpage') ?>
	</details>
</section>