<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "RenameUser extension\n";
	exit( 1 );
}

/**
 * Special page allows authorised users to rename
 * user accounts
 */
class SpecialRenameuser extends SpecialPage {
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'UserRenameTool', 'renameuser', true );
	}

	/**
	 * Show the special page
	 * @param mixed $par Parameter passed to the page
	 * @throws Exception
	 */
	public function execute( $par ) {
		global $wgCentralWikiId;

		$query = $this->getQuery( $par );
		$title = GlobalTitle::newFromText( 'UserRenameTool', NS_SPECIAL, $wgCentralWikiId );

		$this->getOutput()->redirect( $title->getFullURL( $query ) );
	}

	private function getQuery( $par ): array {
		$username = $this->getRequest()->getText( 'username', $par );
		if ( empty( $username ) ) {
			return [];
		} else {
			return [ 'username' => $username ];
		}
	}
}
