<header class="VideoPageToolHeader">
	<div class="VideoPageToolTitle">
		<h1><a href="<?= $dashboardHref ?>"><?= wfMsg( 'videopagetool-header-dashboard' ) ?></a></h1>
		<? if ( !empty( $section ) ): ?>
			<h2><?= $section ?></h2>
		<? endif ?>

		<? if ( !empty( $publishDate ) ): ?>
			<p class="alternative"><?= $publishDate ?></p>
		<? endif?>

		<? if ( !empty( $language ) && !empty( $section ) ): ?>
			<p class="alternative"><?= $language ?> / <?= $section ?></p>
		<? endif ?>
	</div>

	<aside class="right">
		<? if ( !empty( $lastEditTime ) ): ?>
		<p><strong><?= wfMsg( 'videopagetool-header-right-last-saved' ) ?></strong> <?= $wg->lang->timeanddate( $lastEditTime, true ) ?></p>
		<? endif ?>

		<? if ( !empty( $lastEditor ) ): ?>
		<p><strong><?= wfMsg( 'videopagetool-header-right-by' ) ?></strong> <?= $lastEditor ?></p>
		<? endif ?>
	</aside>
</header>
<div class="VideoPageToolHeaderGradient"></div>
