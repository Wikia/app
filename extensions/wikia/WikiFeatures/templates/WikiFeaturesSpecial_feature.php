<li class="feature" data-name="<?= $feature['name'] ?>">
	<div class="representation<?= !empty($feature['new']) ? ' promotion' : '' ?>">
		<?php 
			$featureName = $feature['name'];
			$imageExt = $featureName == 'wgEnableVisualEditorExt' ? 'gif' : 'png';
		?>
		<img height="100" width="150" src="<?= $wg->ExtensionsPath ?>/wikia/WikiFeatures/images/<?= $featureName . '.' . $imageExt ?>" >
		<? if(!empty($feature['new'])) { ?>
			<span class="promo-text"><?= wfMsg('wikifeatures-promotion-new') ?></span>
		<? } ?>
	</div>
	<div class="actions">
		<? if ($editable && isset($feature['enabled'])) { ?>
			<span class="slider<?= $feature['enabled'] ? ' on' : '' ?>">
				<span class="button"></span>
				<span class="textoff"><?= wfMsg('wikifeatures-toggle-inactive') ?></span>
				<span class="texton"><?= wfMsg('wikifeatures-toggle-active') ?></span>
				<span class="loading"></span>
			</span>
		<? } ?>
		<? if (isset($feature['active'])) { ?>
			<button class="secondary feedback">
				<img height="10" width="10" src="<?= $wg->ExtensionsPath ?>/wikia/WikiFeatures/images/star-inactive.png">
				<?php echo wfMsg('wikifeatures-feedback'); ?>
			</button>
			<div class="active-on">
				<?= wfMsg('wikifeatures-active-on', $feature['active']) ?>
			</div>
		<? } ?>
	</div>
	<div class="details">
		<h3>
			<?= wfMsg('wikifeatures-feature-heading-'.$feature['name']) ?>
		</h3>
		<p>
			<?= wfMsgExt('wikifeatures-feature-description-'.$feature['name'], 'parseinline') ?>
		</p>
	</div>
</li>
