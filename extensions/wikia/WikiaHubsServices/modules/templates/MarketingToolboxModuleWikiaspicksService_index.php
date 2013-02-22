<h2>
	<?= $title ?>
	<? if (!is_null($sponsoredImageUrl)): ?>
		<img class="floatright sponsored-image" src="<?= $sponsoredImageUrl ?>" alt="<?= $sponsoredImageAlt ?>" />
	<? endif; ?>
</h2>
<p>
	<?php if( !is_null($imageLink) ): ?>
		<a href="<?= $imageLink ?>">
	<?php endif; ?>
	
	<img class="floatright" src="<?= $imageUrl ?>" alt="<?= $imageAlt ?>" />
	
	<?php if( !is_null($imageLink) ): ?>
		</a>
	<?php endif; ?>
	
	<?= $text ?>
</p>

