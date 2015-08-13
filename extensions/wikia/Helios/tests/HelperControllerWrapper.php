<?php
namespace Wikia\Helios;

/**
 * A helper controller to provide end points exposing MediaWiki functionality to Helios.
 */
class HelperControllerWrapper extends HelperController {

	public function authenticateViaTheSchwartz() {
		return parent::authenticateViaTheSchwartz();
	}
}
