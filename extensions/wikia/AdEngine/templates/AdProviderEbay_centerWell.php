<style>
	#ebay-ads {
		text-align: left;
	}
	#ebay-ads li {
		list-style: disc inside;
	}
</style>
<section id="ebay-ads">
<h1>Ebay products:</h1>
<ul>
	<? foreach ($products as $product): ?>
		<li>
			<a href="<?= $product['link'] ?>">
				<?= htmlspecialchars($product['title']) ?></a>
				<?= $product['description'] ?>
		</li>
	<? endforeach; ?>
</ul>
</section>
