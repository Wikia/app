<li class="feature" data-name="<?= $feature['name'] ?>" data-heading="<?= wfMessage( 'wikifeatures-feature-heading-' . $feature['name'] )->escaped(); ?>">
	<h3>
		<?= wfMessage( 'wikifeatures-feature-heading-' . $feature['name'] )->escaped(); ?>
		<? if ( isset( $feature['active'] ) ): ?>
			<span class="active-on">
				<?= wfMessage( 'wikifeatures-active-on', $feature['active'] )->escaped(); ?>
			</span>
		<? endif; ?>
	</h3>

	<div class="representation<?= !empty( $feature['new'] ) ? ' promotion' : '' ?>">
		<div class="feature-image-wrapper">
			<img src="<?= $wg->ExtensionsPath ?>/wikia/WikiFeatures/images/<?= $feature['name'] . $feature['imageExtension'] ?>" >
		</div>
		<? if ( !empty( $feature['new'] ) ): ?>
			<span class="promo-text"><?= wfMessage( 'wikifeatures-promotion-new' )->escaped(); ?></span>
		<? endif; ?>
	</div>
	<div class="details">
		<p>
			<?= wfMessage( 'wikifeatures-feature-description-' . $feature['name'] )->parse() ?>
		</p>
	</div>
	<div class="actions">
		<? if ( $editable && isset( $feature['enabled'] ) ): ?>
			<span class="slider<?= $feature['enabled'] ? ' on' : '' ?>">
				<span class="button"></span>
				<span class="textoff"><?= wfMessage( 'wikifeatures-toggle-inactive' )->escaped(); ?></span>
				<span class="texton"><?= wfMessage( 'wikifeatures-toggle-active' )->escaped(); ?></span>
				<span class="loading"></span>
			</span>
		<? endif; ?>
		<? if ( isset( $feature['active'] ) ): ?>
			<button class="secondary feedback">
				<img height="10" width="10" src="<?= $wg->ExtensionsPath ?>/wikia/WikiFeatures/images/star-inactive.png">
				<?= wfMessage( 'wikifeatures-feedback' )->escaped(); ?>
			</button>
		<? endif; ?>
	</div>
</li>
