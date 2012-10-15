<?php
	if ($rteData !== false) {
		// render placeholder for visual editor
?>
	<img<?=$rteData;?>class="thumb t<?=$align;?> src="<?=$url;?>" width="<?=$width;?>" height="<?=$height;?>" />
<?php
	} else {
		// render map for view mode
?>
<figure class="thumb t<?=$align;?> thumbinner placemap" style="width:<?=$width+2;?>px;" itemscope itemtype="http://schema.org/Place">
	<img class="thumbimage" src="<?=$url;?>" width="<?=$width;?>" height="<?=$height;?>" data-categories="<?=$categories?>" data-zoom="<?=$zoom;?>" data-lat="<?=$lat;?>" data-lon="<?=$lon;?>" />
	<figcaption class="thumbcaption">
		<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates"><?= htmlspecialchars($caption) ?>
			<meta itemprop="latitude" content="<?= $lat ?>">
			<meta itemprop="longitude" content="<?= $lon ?>">
		</span>
	</figcaption>
</figure>
<?php
	}
