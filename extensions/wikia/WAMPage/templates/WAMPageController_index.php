<div class="wam-header">
	<h2><?= wfMessage('wampage-header')->text(); ?></h2>
</div>

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

<div class="wam-content">
	<?= wfMessage(
		'wampage-content',
		$faqPage
	)->parse(); ?>
</div>

<? var_dump($visualizationWikis); ?>
