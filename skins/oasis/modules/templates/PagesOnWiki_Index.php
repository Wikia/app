<section class="WikiaPagesOnWikiModule module">
	<h1><?= wfMsg('oasis-pages-on-wiki-header', $wg->Sitename) ?></h1>
	<?php if( empty( $wg->EnableWikiAnswers ) ) {
		$loginClass = empty($wg->DisableAnonymousEditing) ? '' : ' require-login';
		echo Wikia::specialPageLink('CreatePage', 'oasis-add-page', 'wikia-button createpage' . $loginClass, 'blank.gif', 'oasis-create-page', 'sprite new');
	} ?>
	<div class="tally">
		<?= wfMsgExt('oasis-total-articles-mainpage', array( 'parsemag' ), $total, ($total < 100000 ? 'fixedwidth' : '') ) ?>
	</div>
</section>
