<!-- eBay center well list unit. -->
<section id="ebay-ads">
<?php if ($isMobile) { ?>
<h2> <?= $title ?>:</h2>
<div class="powered-by">Powered by
	<?= $app->renderPartial('AdProviderEbay', 'ebayLogo', array('width' => '80px', 'height' => '30px', 'viewBox' => '20 75 270 120') ); ?>
</div>
<?php } else { ?>
<div class="powered-by">Powered by
<?= $app->renderPartial('AdProviderEbay', 'ebayLogo', array('width' => '80px', 'height' => '30px', 'viewBox' => '20 75 270 120') ); ?>
</div>
<h1> <?= $title ?>:</h1>
<?php } ?>
<? if ($products): ?>
	<ul>
		<? foreach ($products as $product): ?>
			<li>
				<a target="_blank" class="image" href="<?= $product['link'] ?>">
					<? if ($product['image']): ?>
							<img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>">
					<? endif ?>
				</a>
				<div class="info">
					<a target="_blank" class="title" href="<?= $product['link'] ?>">
						<?= htmlspecialchars($product['title']) ?>
					</a>
					<a target="_blank" href="<?= $product['link'] ?>" class="price">
						<span>
							<?= $product['price_tag']?>
						</span><span>
							<?= wfMessage('adengine-ebay-buy-it-now') ?>
						</span>
					</a>
				</div>
			</li>
		<? endforeach ?>
	</ul>
<? else: ?>
	<p><?= wfMessage('adengine-ebay-empty') ?></p>
<? endif ?>
<div class="debug">
	DEBUG: Query: <?= htmlspecialchars(json_encode($query)) ?> | <a href="<?= htmlspecialchars($rssUrl) ?>">RSS</a>
</div>
</section>
