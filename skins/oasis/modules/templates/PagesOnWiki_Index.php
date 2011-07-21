<section class="WikiaPagesOnWikiModule module">
	<h1><?= wfMsg('oasis-pages-on-wiki-header', $wgSitename) ?></h1>
	<?php if( empty( $wgEnableWikiAnswers ) ) {
		echo Wikia::specialPageLink('CreatePage', 'oasis-add-page', 'wikia-button createpage require-login', 'blank.gif', 'oasis-create-page', 'sprite new');
	} ?>
	<div class="tally">
		<?= wfMsgExt('oasis-total-articles-mainpage', array( 'parsemag' ), $total, ($total < 100000 ? 'fixedwidth' : '') ) ?>
	</div>
</section>
