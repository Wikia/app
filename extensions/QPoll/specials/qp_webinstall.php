<?php

/**
 * Installs/updates DB schema for the people who do not have shell access
 * (not being able to run maintenance scripts)
 */
class qp_WebInstall extends qp_SpecialPage {
	private $allowed_groups = array( 'sysop', 'bureaucrat' );

	public function __construct() {
		parent::__construct( 'QPollWebInstall', 'read' );
	}

	/**
	 * Checks if the given user (identified by an object) can execute this special page
	 * @param $user User: the user to check
	 * @return Boolean: does the user have permission to view the page?
	 */
	public function userCanExecute( $user ) {
		return count( array_intersect( $this->allowed_groups, $user->getEffectiveGroups() ) ) > 0;
	}

	public function execute( $par ) {
		global $wgOut, $wgUser;

		# only sysops and bureaucrats can update the DB
		if ( !$this->userCanExecute( $wgUser ) ) {
			// @todo FIXME: i18n missing.
			$wgOut->addHTML( 'You have to be a member of the following group(s) to perform web install:' . implode( ', ', $this->allowed_groups ) );
			return;
		}
		# display update result
		$wgOut->addHTML( qp_SchemaUpdater::checkAndUpdate() );
	}
}
