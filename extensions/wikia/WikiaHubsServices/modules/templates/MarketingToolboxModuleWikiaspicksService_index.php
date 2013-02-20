<h2>
	<?= $title ?>
	<? if (!is_null($sponsoredImageUrl)): ?>
		<img class="floatright sponsored-image" src="<?= $sponsoredImageUrl ?>" alt="<?= $sponsoredImageAlt ?>" />
	<? endif; ?>
</h2>
<p>
	<img class="floatright" src="<?= $imageUrl ?>" alt="<?= $imageAlt ?>" />
	<?= $text ?>
</p>

