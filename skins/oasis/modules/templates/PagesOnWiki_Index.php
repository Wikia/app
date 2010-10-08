<section class="WikiaPagesOnWikiModule">
	<? if (!$wgSingleH1) { ?>
		<h1><?= wfMsg('oasis-pages-on-wiki-header', $wgSitename) ?></h1>
	<? } ?>
	<?= View::specialPageLink('CreatePage', 'button-createpage', 'wikia-button createpage', 'blank.gif', 'oasis-create-page', 'sprite new'); ?>
	<details class="tally">
		<?= wfMsgExt('oasis-total-articles-mainpage', array( 'parsemag' ), $total ) ?>
	</details>
</section>
