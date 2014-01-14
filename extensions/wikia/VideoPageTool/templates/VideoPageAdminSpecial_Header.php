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
			<p><?= wfMessage( 'videopagetool-header-right-last-saved', $wg->lang->timeanddate( $lastSavedOn, true ) )->parse() ?></p>
		<? endif ?>

		<? if ( !empty( $savedBy ) ): ?>
			<p><?= wfMessage( 'videopagetool-header-right-saved-by', $savedBy )->parse() ?></p>
		<? endif ?>

		<? if ( !empty( $publishDate ) ): ?>
			<p><?= wfMessage( 'videopagetool-header-right-publish-date', $wg->lang->date( $publishDate ) )->parse() ?></p>
		<? elseif ( !empty( $lastSavedOn ) ): // Make sure we're on a program page ?>
			<p><?= wfMessage( 'videopagetool-header-right-not-published' )->parse() ?></p>
		<? endif ?>

		<? if ( !empty( $publishedBy ) ): ?>
			<p><?= wfMessage( 'videopagetool-header-right-published-by', $publishedBy )->parse() ?></p>
		<? endif ?>
	</aside>
</header>
<div class="VideoPageToolHeaderGradient"></div>
