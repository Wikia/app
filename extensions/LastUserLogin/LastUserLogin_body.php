<?php

class LastUserLogin extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'LastUserLogin'/*class*/, 'lastlogin'/*restriction*/ );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgLang, $wgRequest;
		

		# If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		# If the user doesn't have the required 'lastlogin' permission, display an error
		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->setHeaders();
		$skin = $wgUser->getSkin();

		$dbr = wfGetDB( DB_SLAVE );
		$fields = array(
			'user_name' => 'lastuserlogin_userid',
			'user_real_name' => 'lastuserlogin_username',
			'user_email' => 'lastuserlogin_useremail',
			'user_touched' => 'lastuserlogin_lastlogin'
		);


		# Get order by and check it
		$orderby = $wgRequest->getVal('order_by', 'user_name');

		# Only field names are acceptable
		if ( !isset( $fields[ $orderby ] ) ) {
			$orderby = 'user_name';
		}


		# Get order type and check it
		$ordertype = $wgRequest->getVal('order_type', 'ASC');

		# $ordertype must be ASC or DESC
		if ( $ordertype != 'DESC' ) {
			$ordertype = 'ASC';
		}
 		/* This will get ALL users. Should be paginated. */

		$result = $dbr->select( 'user', array_keys($fields) , '', __METHOD__, array( 'ORDER BY' => $orderby  . " " . $ordertype ) );
		if ( $result !== false ) {
			$ordertype = ($ordertype == 'ASC') ? 'DESC' : 'ASC'; # Invert the order

			$out = '<table class="wikitable mw-lastuserlogin-table"><tr>';

			$title = $this->getTitle();

			foreach ( $fields as $key => $value ) {
				$out .= '<th><a href="' . $title->escapeLocalURL( array("order_by"=>$key, "order_type"=>$ordertype) ) . '">' . wfMsg( $value ) . '</a></th>';
			}
			$out .= "<th>" . wfMsg( 'lastuserlogin_daysago' ) . "</th>";

			$out .= '</tr>';

			while ( $row = $dbr->fetchRow( $result ) ) {
				$out .= '<tr>';
				foreach ( $fields as $key => $value ) {
					if ( $key == 'user_touched' ) {
						$out .= "<td>" . $wgLang->timeanddate( wfTimestamp( TS_MW, $row[$key] ), true ) .
								'</td><td style="text-align:right;">' .
								$wgLang->formatNum( round( ( time() - wfTimestamp( TS_UNIX, $row[$key] ) ) / 3600 / 24, 2 ), 2 ) . "</td>";
					} else {
						if ( $key == 'user_name' ) {
							$userPage = Title::makeTitle( NS_USER, $row[$key] );
							$name = $skin->makeLinkObj( $userPage, htmlspecialchars( $userPage->getText() ) );
							$out .= '<td>' . $name . '</a></td>';
						} else {
							$out .= '<td>' . htmlspecialchars( $row[$key] ) . '&#160;</td>';
						}
					}
				}
				$out .= '</tr>';
			}
		}

		$out .= '</table>';
		$wgOut->addHTML( $out );

	}
}
