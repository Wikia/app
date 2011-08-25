<section class="WikiFeatures" id="WikiFeatures">
	<h2>
		<?= wfMsg('wikifeatures-heading') ?>
	</h2>
	<p>
		<?= wfMsg('wikifeatures-creative') ?>
	</p>
	
	<ul class="features">
		<? foreach ($features as $feature) { ?>
			<?= F::app()->getView( 'WikiFeaturesSpecial', 'feature', array('feature' => $feature ) ) ?>
		<? } ?>
	</ul>
	
	<h2>
		<?= wfMsg('wikifeatures-labs-heading') ?>
	</h2>
	<p>
		<?= wfMsg('wikifeatures-labs-creative') ?>
	</p>
	
	<ul class="features">
		<? foreach ($labsFeatures as $feature) { ?>
			<?= F::app()->getView( 'WikiFeaturesSpecial', 'feature', array('feature' => $feature ) ) ?>
		<? } ?>
	</ul>
</section>