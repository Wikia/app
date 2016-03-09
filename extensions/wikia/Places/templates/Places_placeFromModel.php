<?php
	if ($rteData !== false) {
		// render placeholder for visual editor
?>
	<img<?=$rteData;?>class="thumb t<?=$align;?> src="<?=$url;?>" width="<?=$width;?>" height="<?=$height;?>" />
<?php
	} else {
		// render map for view mode
?>
<figure class="article-thumb t<?=$align;?> placemap" style="width: <?=$width;?>px" itemscope itemtype="http://schema.org/Place">
	<img class="thumbimage" src="<?=$url;?>" width="<?=$width;?>" height="<?=$height;?>" data-categories="<?=$categories?>" data-zoom="<?=$zoom;?>" data-lat="<?=$lat;?>" data-lon="<?=$lon;?>" />
	<figcaption class="thumbcaption" itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
		<p class="caption"><?= $caption ?></p>
		<meta itemprop="latitude" content="<?= $lat ?>">
		<meta itemprop="longitude" content="<?= $lon ?>">
	</figcaption>
</figure>
<?php
	}
