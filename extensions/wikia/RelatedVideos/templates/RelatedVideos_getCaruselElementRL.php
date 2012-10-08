<div class="item">
	<?= $videoThumb ?>
	<div class="description">
		<a class="lightbox" href="<?=$video['fullUrl'];?>" data-ref="<?=$video['prefixedUrl'];?>" data-external="<?=$video['external'];?>" data-video-name="<?= $escapedTitle ?>" >
		<?= $truncatedTitle ?>
		</a>
		<span class="video-views"><?= $videoViewsMsg ?></span>
	</div>
</div>