<?php
class WikiaMapsPermissionException extends ForbiddenException {
	protected $message = "No Permissions";

	public function __construct() {
		$this->details = wfMessage( 'wikia-interactive-maps-permission-error' )->plain();
	}
}
