<? if(!empty($fileList)): ?>
	<section class="page-listings" data-listing-type="<?= $type ?>">
		<h2>
			<?= $heading ?>
			<div class="page-list-pagination">
				<img src="<?= wfBlankImgUrl() ?>" class="arrow left disabled">
				<?= wfMessage('video-page-file-list-pagination', '<span class="page-list-current"></span>', '<span class="page-list-total"></span>')->text() ?>
				<img src="<?= wfBlankImgUrl() ?>" class="arrow right">
			</div>
		</h2>
		<ul class="page-list-content WikiaGrid">
			<?= F::app()->renderPartial('VideoPageController', 'fileList', array('fileList' => $fileList, 'type' => $type)) ?>
		</ul>
	</section>
	<script>
		var VideoPageSummary = VideoPageSummary || {};
		VideoPageSummary['<?= $type ?>'] = <?= json_encode($summary) ?>;
	</script>
<? endif; ?>