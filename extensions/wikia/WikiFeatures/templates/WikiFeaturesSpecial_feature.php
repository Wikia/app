<li class="feature" data-name="<?= $feature['name'] ?>">
	<img class="representation" height="100" width="150" src="<?= $wg->ExtensionsPath ?>/wikia/WikiFeatures/images/<?= $feature['name'] ?>.png" >
	<div class="actions">
		<? if ($editable) { ?>
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
			<?= wfMsg('wikifeatures-feature-description-'.$feature['name']) ?>
		</p>
	</div>
</li>