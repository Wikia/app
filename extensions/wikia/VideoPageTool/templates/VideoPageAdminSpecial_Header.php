<header class="VideoPageToolHeader">
	<div class="VideoPageToolTitle">
		<h1><a href="<?= Sanitizer::encodeAttribute( $dashboardHref ); ?>"><?= wfMessage( 'videopagetool-header-dashboard' )
					->escaped() ?></a></h1>
		<? if ( !empty( $section ) ): ?>
			<h2><?= htmlspecialchars( $section ); ?></h2>
		<? endif ?>

		<p class="alternative"><?= htmlspecialchars( $programDate ); ?></p>

		<? if ( !empty( $language ) && !empty( $section ) ): ?>
			<p class="alternative"><?= htmlspecialchars( $language ); ?> / <?= htmlspecialchars( $section ); ?></p>
		<? endif ?>
	</div>

	<aside class="right">
		<? if ( !empty( $lastSavedOn ) ): ?>
			<p><?= wfMessage( 'videopagetool-header-last-saved', $wg->lang->timeanddate( $lastSavedOn, true ) )->parse() ?></p>
		<? endif ?>

		<? if ( !empty( $savedBy ) ): ?>
			<p><?= wfMessage( 'videopagetool-header-saved-by', $savedBy )->parse() ?></p>
		<? endif ?>

		<? if ( !empty( $publishDate ) ): ?>
			<p><?= wfMessage( 'videopagetool-header-publish-date', $wg->lang->date( $publishDate ) )->parse() ?></p>
		<? elseif ( !empty( $lastSavedOn ) ): // Make sure we're on a program page ?>
			<p><?= wfMessage( 'videopagetool-header-not-published' )->parse() ?></p>
		<? endif ?>

		<? if ( !empty( $publishedBy ) ): ?>
			<p><?= wfMessage( 'videopagetool-header-published-by', $publishedBy )->parse() ?></p>
		<? endif ?>
	</aside>
</header>
<div class="VideoPageToolHeaderGradient"></div>
