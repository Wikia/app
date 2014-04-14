<!-- eBay center well list unit. -->
<style>
#ebay-ads {
	height: 250px;
	overflow: hidden;
	text-align: center;
}
#ebay-ads h1 {
	font-size: 150%;
	font-weight: bold;
	margin: 10px 0;
	text-align: left;
}
#ebay-ads ul {
	overflow: hidden;
}
#ebay-ads li {
	float: left;
	margin-left: 4%;
	width: 22%;
}
#ebay-ads li:first-child {
	margin-left: 0;
}
#ebay-ads .image {
	height: 100px;
	margin: 10px 0;
}
#ebay-ads .image img {
	max-height: 100px;
}
</style>
<section id="ebay-ads">
<h1>Ebay products:</h1>
<? if ($products): ?>
	<ul>
		<? foreach ($products as $product): ?>
			<li>
				<a href="<?= $product['link'] ?>">
					<? if ($product['image']): ?>
						<div class="image">
							<img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>">
						</div>
					<? endif ?>
					<?= htmlspecialchars($product['title']) ?>
				</a>
			</li>
		<? endforeach ?>
	</ul>
<? else: ?>
	<p>No matching products</p>
<? endif ?>
<div>
	DEBUG: Query: <?= htmlspecialchars(json_encode($query)) ?> | <a href="<?= htmlspecialchars($rssUrl) ?>">RSS</a>
</div>
</section>
