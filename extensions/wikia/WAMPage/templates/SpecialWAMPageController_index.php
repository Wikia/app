<div class="wam-header">
	<h2><?= wfMessage('wampage-header')->text(); ?></h2>
</div>

<ul class="wam-tabs">
	<li>
		<a href="#"></a>
	</li>
	<li>
		<a href="#"></a>
	</li>
	<li>
		<a href="#"></a>
	</li>
</ul>

<div class="wam-content">
	<?= wfMessage(
		'wampage-content',
		$faqPage
	)->parse(); ?>
</div>