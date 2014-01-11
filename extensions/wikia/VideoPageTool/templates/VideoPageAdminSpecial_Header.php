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
			<p><strong><?= wfMessage( 'videopagetool-header-right-last-saved', "<span class='reg-text'>".$wg->lang->timeanddate( $lastSavedOn, true )."</span>" )->text() ?></strong></p>
		<? endif ?>

		<? if ( !empty( $savedBy ) ): ?>
			<p><strong><?= wfMessage( 'videopagetool-header-right-saved-by', "<span class='reg-text'>".$savedBy."</span>" )->text() ?></strong></p>
		<? endif ?>

		<? if ( !empty( $publishDate ) ): ?>
			<p><strong><?= wfMessage( 'videopagetool-header-right-publish-date', "<span class='reg-text'>".$wg->lang->date( $publishDate )."</span>" )->text() ?></strong></p>
		<? elseif ( !empty( $lastSavedOn ) ): // Make sure we're on a program page ?>
			<p><strong><?= wfMessage( 'videopagetool-header-right-not-published' )->text() ?></strong></p>
		<? endif ?>

		<? if ( !empty( $publishedBy ) ): ?>
			<p><strong><?= wfMessage( 'videopagetool-header-right-published-by', "<span class='reg-text'>".$publishedBy."</span>" )->text() ?></strong></p>
		<? endif ?>
	</aside>
</header>
<div class="VideoPageToolHeaderGradient"></div>
