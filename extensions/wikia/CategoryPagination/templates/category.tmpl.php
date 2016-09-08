<? if ( $empty ): ?>
	<?= wfMessage( 'category-empty' )->parse(); ?>
<? else: ?>
	<div lang="<?= htmlspecialchars( $lang->getCode() ); ?> dir="<?= htmlspecialchars( $lang->getDir() ); ?>">
	<?= $categoryGallery; ?>

	<? if ( !empty( $content['subcat'] ) ): ?>
		<div id="mw-subcategories">
			<h2><?= wfMessage( 'subcategories' )->parse(); ?></h2>
			<?= wfMessage( 'category-subcat-count' )->numParams( $numberShown['subcat'], $counts['subcat'] )->parseAsBlock(); ?>
			<?= $content['subcat']; ?>
			<?= $paginator['subcat']->getBarHTML(); ?>
		</div>
	<? endif; ?>

	<? if ( !empty( $content['page'] ) ): ?>
		<div id="mw-pages">
			<h2><?= wfMessage( 'category_header' )->params( $titleEscaped )->parse(); ?></h2>
			<?= wfMessage( 'category-article-count' )->numParams( $numberShown['page'], $counts['page'] )->parseAsBlock(); ?>
			<?= $content['page']; ?>
			<?= $paginator['page']->getBarHTML(); ?>
		</div>
	<? endif; ?>

	<? if ( !empty( $content['file'] ) ): ?>
		<div id="mw-category-media">
			<h2><?= wfMessage( 'category-media-header' )->params( $titleEscaped )->parse(); ?></h2>
			<?= wfMessage( 'category-file-count' )->numParams( $numberShown['file'], $counts['file'] )->parseAsBlock(); ?>
			<?= $content['file']; ?>
			<?= $paginator['file']->getBarHTML(); ?>
		</div>
	<? endif; ?>

	<?= $answersSection; ?>
	</div>
<? endif; ?>
