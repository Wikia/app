<div class="clearfix">
	<ul class="search-images" id="image-one-box-search-results">
		<div class="search-images-title">
			<?php echo wfMsg( 'wikiasearch-image-results', array( $searchTerm ) ); ?>
		</div>
		<?php $count = 0; ?>
		<?php foreach ($images as $info): ?>
			<?php $count++; ?>
			<li class="search-images-result" id="image-one-box-search-result-<?= $count; ?>">
				<div>
					<a<?= $info['lightBox'] ? ' class="lightbox"' : '' ?> href="<?= $info['mainImageLink'] ?>">
						<img class="search-image" src="<?= $info['thumbUrl'] ?>" /></a><br />
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
<script type="text/javascript">
//<![CDATA[
$(".search-images-result").click(function() {
	WET.byStr('search/imageResults/click/' + $(this).attr('id') );
});
//]]>
</script>
