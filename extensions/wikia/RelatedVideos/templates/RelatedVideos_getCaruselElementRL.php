<?
	$maxDescriptionLength = 50;
?>
<div class="item">
	<?= $videoThumb ?>
	<div class="description">
		<a class="lightbox" href="<?=$video['fullUrl'];?>" data-ref="<?=$video['prefixedUrl'];?>" data-external="<?=$video['external'];?>" data-video-name="<?=htmlspecialchars($video['title']);?>" >
		<?=( strlen( $video['title'] ) > $maxDescriptionLength )
			? substr( $video['title'], 0, $maxDescriptionLength).'&#8230;'
			: $video['title'];
		?>
		</a>
		<span class="video-views"><?= wfMsg('related-videos-video-views', $wg->ContLang->formatNum($video['views'])) ?></span>
	</div>
</div>