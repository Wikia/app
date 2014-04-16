<!-- eBay center well list unit. -->
<style>
#ebay-ads {
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	padding: 10px;
	text-align: center;
}
#ebay-ads h1 {
	font-weight: bold;
	text-align: left;
	margin-bottom: 15px;
}
#ebay-ads ul {
	display: block;
	padding: 0;
	margin: 0;
	overflow: hidden;
}
#ebay-ads li {
	display: block;
	height: 50px;
	width: 100%;
	margin-bottom: 10px;
}
#ebay-ads .image {
	display: block;
	height: 50px;
	float: left;
	width: 100px;
	overflow: hidden;
}
#ebay-ads .image img {
	height: 50px;
	max-height: 100px;
}

#ebay-ads .info .title {
	display: block;
	text-align: left;
}

#ebay-ads .info .price {
	display: block;
	text-align: left;
}

#ebay-ads li:before,
#ebay-ads li:after {
	content: " "; /* 1 */
	display: table; /* 2 */
}

#ebay-ads li:after {
	clear: both;
}


</style>
<section id="ebay-ads">
<h1>Ebay products:</h1>
<? if ($products): ?>
	<ul>
		<? foreach ($products as $product): ?>
			<li>
				<a class="image" href="<?= $product['link'] ?>">
					<? if ($product['image']): ?>
							<img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>">
					<? endif ?>
				</a>
				<div class="info">
					<a class="title" href="<?= $product['link'] ?>">
						<?= htmlspecialchars($product['title']) ?>
					</a>
					<div class="price">
						<?= $product['BuyItNowPrice'] ? $product['BuyItNowPrice'] : $product['CurrentPrice'] ?> $
					</div>
				</div>
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
