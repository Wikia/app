<li class="feature" data-name="<?= $feature['name'] ?>" data-heading="<?= wfMessage('wikifeatures-feature-heading-'.$feature['name'])->plain() ?>">
	<h3>
		<?= wfMsg('wikifeatures-feature-heading-'.$feature['name']) ?>
		<? if (isset($feature['active'])): ?>
			<span class="active-on">
				<?= wfMsg('wikifeatures-active-on', $feature['active']) ?>
			</span>
		<? endif; ?>
	</h3>

	<div class="representation<?= !empty($feature['new']) ? ' promotion' : '' ?>">
		<div class="feature-image-wrapper">
			<img src="<?= $wg->ExtensionsPath ?>/wikia/WikiFeatures/images/<?= $feature['name'] . $feature['imageExtension'] ?>" >
		</div>
		<? if(!empty($feature['new'])): ?>
			<span class="promo-text"><?= wfMessage('wikifeatures-promotion-new')->plain() ?></span>
		<? endif; ?>
	</div>
	<div class="details">
		<p>
			<?= wfMessage('wikifeatures-feature-description-'.$feature['name'])->parse() ?>
		</p>
	</div>
	<div class="actions">
		<? if ($editable && isset($feature['enabled'])): ?>
			<span class="slider<?= $feature['enabled'] ? ' on' : '' ?>">
				<span class="button"></span>
				<span class="textoff"><?= wfMsg('wikifeatures-toggle-inactive') ?></span>
				<span class="texton"><?= wfMsg('wikifeatures-toggle-active') ?></span>
				<span class="loading"></span>
			</span>
		<? endif; ?>
		<? if (isset($feature['active'])): ?>
			<button class="secondary feedback">
				<img height="10" width="10" src="<?= $wg->ExtensionsPath ?>/wikia/WikiFeatures/images/star-inactive.png">
				<?php echo wfMsg('wikifeatures-feedback'); ?>
			</button>
		<? endif; ?>
	</div>
</li>
