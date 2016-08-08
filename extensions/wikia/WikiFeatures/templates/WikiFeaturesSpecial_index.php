<section class="WikiFeatures" id="WikiFeatures">
	<h2 class="heading-features">
		<?= wfMessage( 'wikifeatures-heading' )->escaped(); ?>
	</h2>
	<p class="creative">
		<?= wfMessage( 'wikifeatures-creative' )->escaped(); ?>
	</p>

	<ul class="features">
		<? foreach ( $features as $feature ): ?>
			<?= $app->renderView( 'WikiFeaturesSpecial', 'feature', [ 'feature' => $feature, 'editable' => $editable ] ) ?>
		<? endforeach; ?>
	</ul>

	<h2 class="heading-labs">
		<?= wfMessage( 'wikifeatures-labs-heading' )->escaped(); ?>
	</h2>
	<p class="creative">
		<?= wfMessage( 'wikifeatures-labs-creative' )->escaped(); ?>
	</p>

	<ul class="features">
		<? if ( !empty( $labsFeatures ) ): ?>
			<? foreach ( $labsFeatures as $feature ): ?>
				<?= $app->renderView( 'WikiFeaturesSpecial', 'feature', [ 'feature' => $feature, 'editable' => $editable ] ) ?>
			<? endforeach; ?>
		<? else: ?>
			<?
			$feature = [
				"name" => "emptylabs",
			];
			?>
			<?= $app->renderView( 'WikiFeaturesSpecial', 'feature', [ 'feature' => $feature, 'editable' => $editable ] ) ?>
		<? endif; ?>
	</ul>
</section>
