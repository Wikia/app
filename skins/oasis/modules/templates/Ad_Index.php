<?php

if ($wg->EnableAdEngineExt && isset($slotname)) {
	echo F::app()->renderView('AdEngine2', 'Ad', ['slotname' => $slotname]);
}
