<div class="home-top-right-ads">
	<?php
		if (in_array('leaderboard', $wg->ABTests)) {
			echo $app->renderView('Ad', 'Index', array('slotname' => 'TEST_HOME_TOP_RIGHT_BOXAD'));
		} else {
			echo $app->renderView('Ad', 'Index', array('slotname' => 'HOME_TOP_RIGHT_BOXAD'));
		}

		echo $app->renderView('Ad', 'Index', array('slotname' => 'HOME_TOP_RIGHT_BUTTON'));
	?>
</div>
