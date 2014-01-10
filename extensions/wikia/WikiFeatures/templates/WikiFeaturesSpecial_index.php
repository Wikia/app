<section class="WikiFeatures" id="WikiFeatures">
	<h2 class="heading-features">
		<?= wfMsg('wikifeatures-heading') ?>
	</h2>
	<p class="creative">
		<?= wfMsg('wikifeatures-creative') ?>
	</p>
	
	<ul class="features">
		<? foreach ($features as $feature) { ?>
			<?= F::app()->getView( 'WikiFeaturesSpecial', 'feature', array('feature' => $feature, 'editable' => $editable ) ) ?>
		<? } ?>
	</ul>
	
	<h2 class="heading-labs">
		<?= wfMsg('wikifeatures-labs-heading') ?>
	</h2>
	<p class="creative">
		<?= wfMsg('wikifeatures-labs-creative') ?>
	</p>
	
	<ul class="features">
		<? if (!empty($labsFeatures)) { ?>
			<? foreach ($labsFeatures as $feature) { ?>
				<?= F::app()->getView( 'WikiFeaturesSpecial', 'feature', array('feature' => $feature, 'editable' => $editable ) ) ?>
			<? } ?>
		<? } else { ?>
		<? 
			$feature = array(
				"name" => "emptylabs"
			); 
		?>
			<?= F::app()->getView( 'WikiFeaturesSpecial', 'feature', array('feature' => $feature, 'editable' => $editable ) ) ?>
		<? } ?>
	</ul>
</section>
