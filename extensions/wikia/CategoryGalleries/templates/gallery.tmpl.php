<div class="category-gallery">
<?php $count = 0; ?>
<?php foreach ($data as $id => $item) { ?>
<div class="category-gallery-item category-gallery-item-<?= !empty($item['image_url'])?'image':'text'; ?>">
<a href="<?= $item['article_url']; ?>" title="<?= $item['title'];?>">
<?php if (!empty($item['image_url'])) {?>
<img src="<?= $item['image_url']; ?>" alt="<?= $item['title']; ?>"/>
<?php } else { ?>
<div class="snippet"><span class="quote">&#x201C;</span><span class="text"><?= $item['snippet']; ?></span></div>
<?php } ?>
<span class="details"><?= $item['title']; ?></span>
</a>
</div>
<?php 	$count++;?>
<?php 	if ($count%4 == 0) {?>
<!--<br />-->
<?php 	}?>
<?php }?>
<?php 	if ($count%4 != 0) {?>
<!-- <br style="clear:both;" />
<br />-->
<?php 	}?>
</div>