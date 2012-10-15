<div class="category-gallery">
<?php $count = 0; ?>
<?php foreach ($data as $id => $item) { ?>
<div class="category-gallery-item category-gallery-item-<?= !empty($item['image_url'])?'image':'text'; ?>">
<a href="<?= $item['article_url']; ?>" title="<?= htmlspecialchars($item['title']);?>">
<?php if (!empty($item['image_url'])) {?>
<img src="<?= $item['image_url']; ?>" alt="<?= htmlspecialchars($item['title']); ?>" width="<?= $item['image_width'] ?>" height="<?= $item['image_height'] ?>" />
<?php } else { ?>
<div class="snippet"><span class="quote">&#x201C;</span><span class="text"><?= $item['snippet']; ?></span></div>
<?php } ?>
<span class="details"><?= htmlspecialchars($item['title']); ?></span>
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