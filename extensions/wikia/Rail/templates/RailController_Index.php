<div
  id="WikiaRailWrapper"
  class="WikiaRail<?= !empty($isGridLayoutEnabled) ? ' grid-2' : '' ?>"
  <?= $isEditPage ? 'style="display: none;"' : '' ?>
>
	<div id="WikiaRail" class="wikia-rail-inner">

		<?php
		// sort in reverse order (highest priority displays first)
		krsort($railModuleList);

		// render all our rail modules here
		foreach ($railModuleList as $priority => $callSpec) {
			echo F::app()->renderView(
				$callSpec[0], // controller
				$callSpec[1], // method
				$callSpec[2]  // method's params
			);
		}
		?>
		<? if ($loadLazyRail): ?>
			<div class="loading"></div>
		<? endif ?>

	</div>
</div>
