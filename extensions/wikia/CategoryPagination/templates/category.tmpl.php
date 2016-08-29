<? if ( $empty ): ?>
	<?= wfMsgExt( 'category-empty', array( 'parse' ) ); ?>
<? else: ?>
	<?= $categoryGallery; ?>

	<div lang="<?= htmlspecialchars( $lang->getCode() ); ?> dir="<?= htmlspecialchars( $lang->getDir() ); ?>">
	<? if ( $content['subcat'] ): ?>
		<div id="mw-subcategories">
			<h2><?= wfMsg( 'subcategories' ); ?></h2>
			<?= wfMessage( 'category-subcat-count' )->numParams( $numberShown['subcat'], $counts['subcat'] )->parseAsBlock(); ?>
			<?= $content['subcat']; ?>
			<?= $paginator['subcat']->getBarHtml(); ?>
		</div>
	<? endif; ?>

	<? if ( $content['page'] ): ?>
		<div id="mw-pages">
			<h2><?= wfMsg( 'category_header', $titleEscaped ); ?></h2>
			<?= wfMessage( 'category-article-count' )->numParams( $numberShown['page'], $counts['page'] )->parseAsBlock(); ?>
			<?= $content['page']; ?>
			<?= $paginator['page']->getBarHtml(); ?>
		</div>
	<? endif; ?>

	<? if ( $content['file'] ): ?>
		<div id="mw-category-media">
			<h2><?= wfMsg( 'category-media-header', $titleEscaped ); ?></h2>
			<?= wfMessage( 'category-file-count' )->numParams( $numberShown['file'], $counts['file'] )->parseAsBlock(); ?>
			<?= $content['file']; ?>
			<?= $paginator['file']->getBarHtml(); ?>
		</div>
	<? endif; ?>

	<?= $answersSection; ?>
	</div>
<? endif; ?>
