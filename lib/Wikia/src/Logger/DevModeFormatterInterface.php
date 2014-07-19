<?php

namespace Wikia\Logger;

interface DevModeFormatterInterface {

	public function enableDevMode();
	public function disableDevMode();
	public function isInDevMode();

}
