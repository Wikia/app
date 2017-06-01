<? if(!empty($fileList)): ?>
	<section class="page-listings" data-listing-type="<?= $type ?>">
		<h2>
			<?= $heading ?>
			<div class="page-list-pagination">
				<img src="<?= wfBlankImgUrl() ?>" class="arrow left disabled">
				<?= wfMessage( 'video-page-file-list-pagination' )->rawParams( '<span class="page-list-current"></span>', '<span class="page-list-total"></span>')->escaped(); ?>
				<img src="<?= wfBlankImgUrl() ?>" class="arrow right">
			</div>
		</h2>
		<ul class="page-list-content WikiaGrid">
			<?= F::app()->renderPartial('FilePageController', 'fileList', array('fileList' => $fileList, 'type' => $type)) ?>
		</ul>
		<? if ( !empty( $seeMoreLink ) ): ?>
			<a class="see-more-link" href="<?= Sanitizer::encodeAttribute( $seeMoreLink ) ?>"><?= $seeMoreText ?> &gt;</a>
		<? endif; ?>
	</section>
	<script>
		var FilePageSummary = FilePageSummary || {};
		FilePageSummary["<?= Xml::escapeJsString( $type ); ?>"] = <?= Xml::encodeJsVar( $summary ); ?>;
	</script>
<? endif; ?>
