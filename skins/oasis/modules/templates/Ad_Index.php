<?php

if ($wg->EnableAdEngineExt) {
	echo F::app()->renderView('AdEngine2', 'Ad', ['slotname' => $slotname]);
}
