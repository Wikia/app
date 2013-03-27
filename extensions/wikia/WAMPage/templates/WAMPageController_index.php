<div class="wam-header">
	<ul class="wam-tabs">
		<li>
			<a href="#">1</a>
		</li>
		<li>
			<a href="#">2</a>
		</li>
		<li>
			<a href="#">3</a>
		</li>
		<li>
			<a href="#">4</a>
		</li>
		<li>
			<a href="#">5</a>
		</li>
		<li>
			<a href="#">6</a>
		</li>
	</ul>

	<div class="wam-cards">
		<? foreach($visualizationWikis as $wiki) { ?>
			<a href="<?= $wiki['url'] ?>" class="wam-card">
				<figure class="wam-img">
					<img src="<?= $wiki['wiki_image'] ?>" alt="<?= $wiki['title'] ?>" title="<?= $wiki['title'] ?>" />
					<span class="wam-img-info"><?= $wiki['title'] ?></span>
				</figure>
				<div class="wam-score"><?= $wiki['wam'] ?></div>
				<span class="wam-vertical"><?= $wiki['hub_id'] ?></span>
			</a>
		<? } // end foreach ?>
	</div>
	
    <h2><?= wfMessage('wampage-header')->text(); ?></h2>
</div>

<div class="wam-progressbar"></div>
<div class="wam-content">
	<?= wfMessage(
		'wampage-content',
		$faqPage
	)->parse(); ?>
</div>

<? var_dump($visualizationWikis); ?>
