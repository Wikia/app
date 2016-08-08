<?php
class WikiaMapsPermissionException extends ForbiddenException {
	protected $message = "No Permissions";

	public function __construct() {
		parent::__construct(wfMessage( 'badaccess-group0' )->plain());
	}
}
