<?php
namespace Wikia\Helios;

/**
 * This is a wrapper that allows protected methods to be tested. By default,
 * Nirvana exposes all methods via the API. If you don't want the exposed they
 * need to be something other than public.
 */
class HelperControllerWrapper extends HelperController {

	public function authenticateViaTheSchwartz() {
		return parent::authenticateViaTheSchwartz();
	}
}
