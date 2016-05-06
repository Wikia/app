<? if ( $isAside ): ?>
	<aside>
<? endif; ?>
	<div id="WikiaRail" class="WikiaRail<?= !empty($isGridLayoutEnabled) ? ' grid-2' : '' ?>">

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

		<?= !empty( $wg->AdDriverUseRevcontent ) ? $app->renderView( 'Ad', 'Index', ['slotName' => 'REVCONTENT_RIGHT_RAIL'] ) : '' ?>

	</div>
<? if ( $isAside ): ?>
	</aside>
<? endif; ?>
