<? if ( $isAside ): ?>
<aside>
<? endif; ?>
<div id="WikiaRail" class="WikiaRail<?= !empty($isGridLayoutEnabled) ? ' grid-2' : '' ?>">

	<?php
		// sort in reverse order (highest priority displays first)
		krsort($railModuleList);

		// render all our rail modules here
		foreach ($railModuleList as $priority => $callSpec) {
			echo F::app()->renderView($callSpec[0], $callSpec[1], $callSpec[2]);
		}
	?>
	<div id="WikiaAdInContentPlaceHolder"></div>

</div>
<? if ( $isAside ): ?>
</aside>
<? endif; ?>