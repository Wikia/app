<section class="ebs-container">
	<p class="ebs-count"><?= $nonPortableCount ?></p>
	<div class="ebs-content">
		<h3><?= wfMessage( 'ebs-heading' )->parse() ?></h3>
		<p><?= wfMessage( 'ebs-content' )->parse() ?></p>
	</div>
	<div class="ebs-actions">
		<a class="ebs-secondary-action" href="<?= $surveyUrl ?>" target="_blank"><?= wfMessage( 'ebs-no' )->parse() ?></a>
		<a class="ebs-primary-action" href="<?= $specialPageUrl ?>" target="_blank"><?= wfMessage( 'ebs-yes' )->parse() ?></a>
	</div>
</section>
