<?php
	if ($rteData !== false) {
?>
	<img<?=$rteData;?>class="thumb t<?=$align;?> src="<?=$url;?>" width="<?=$width;?>" height="<?=$height;?>" />
<?php
	} else {
?>
<figure class="thumb t<?=$align;?> thumbinner placemap" style="width:<?=$width+2;?>px;">
	<a><img src="<?=$url;?>" width="<?=$width;?>" height="<?=$height;?>" data-zoom="<?=$zoom;?>" data-lat="<?=$lat;?>" data-lon="<?=$lon;?>" /></a>
	<figcaption class="thumbcaption">
		<span class="geo"><?=$lat;?>; <?=$lon;?></span>
	</figcaption>
</figure>
<?php
	}
?>