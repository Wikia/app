<style>
	#ebay-ads li {
		list-style: disc inside;
	}
</style>
<section id="ebay-ads">
<h1>Ebay products:</h1>
<ul>
	<? foreach ($products as $product): ?>
		<li><?= htmlspecialchars($product) ?></li>
	<? endforeach; ?>
</ul>
</section>
