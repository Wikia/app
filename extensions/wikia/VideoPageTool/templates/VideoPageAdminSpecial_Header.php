<header class="VideoPageToolHeader">
	<div class="VideoPageToolTitle">
		<h1><a href="<?= $dashboardHref ?>"><?= wfMessage( 'videopagetool-header-dashboard' )->text() ?></a></h1>
		<? if ( !empty( $section ) ): ?>
			<h2><?= $section ?></h2>
		<? endif ?>

		<p class="alternative"><?= $wg->lang->date( time() ) ?></p>

		<? if ( !empty( $language ) && !empty( $section ) ): ?>
			<p class="alternative"><?= $language ?> / <?= $section ?></p>
		<? endif ?>
	</div>

	<aside class="right">
		<? if ( !empty( $lastSavedOn ) ): ?>
			<p><strong><?= wfMessage( 'videopagetool-header-right-last-saved' )->text() ?></strong><?= $wg->lang->timeanddate( $lastSavedOn, true ) ?></p>
		<? endif ?>

		<? if ( !empty( $savedBy ) ): ?>
			<p><strong><?= wfMessage( 'videopagetool-header-right-saved-by' )->text() ?></strong> <?= $savedBy ?></p>
		<? endif ?>

		<? if ( !empty( $publishDate ) ): ?>
			<p><strong><?= wfMessage( 'videopagetool-header-right-publish-date' )->text() ?></strong><?= $wg->lang->date( $publishDate ) ?></p>
		<? else: ?>
			<p><strong><?= wfMessage( 'videopagetool-header-right-not-published' )->text() ?></strong></p>
		<? endif?>
	</aside>
</header>
<div class="VideoPageToolHeaderGradient"></div>
