<?php
	$app = F::app();
?>
<div id="mw-content-text" lang="<?= $app->wg->contLang->getCode(); ?>">
	<script>var wgWikiaHubType = '<?= htmlspecialchars($wgWikiaHubType); ?>' || '';</script>

	<div class="WikiaGrid WikiaHubs" id="WikiaHubs">
		<div class="grid-3 alpha">
			<?php foreach ($modulesOnGrid3 as $module): ?>
				<?= $module; ?>
			<?php endforeach; ?>
		</div>
		<?php foreach ($modulesOutsideGrid as $module): ?>
			<?= $module; ?>
		<?php endforeach; ?>
		<div class="grid-2 alpha wikiahubs-rail">
			<?php foreach ($modulesOnGrid2 as $module): ?>
				<?= $module; ?>
			<?php endforeach; ?>
		</div>
		<?php foreach ($modulesOnGrid4 as $module): ?>
			<?= $module; ?>
		<?php endforeach; ?>
	</div>
</div>
