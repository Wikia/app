<div class="wam-header">
	<h2><?= wfMessage('wampage-header')->text(); ?></h2>
</div>
<div class="wam-content">
	<?= wfMessage(
		'wampage-content',
		$faqPage
	)->parse(); ?>
</div>