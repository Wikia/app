<?php
/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) )
	die( "This is not a valid entry point.\n" );

require_once("QueryPage.php"); //sigh, this line has to be there so that the extension works

class RefreshSpecial extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'RefreshSpecial'/*class*/, 'refreshspecial'/*restriction*/ );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser, $wgRequest;

		wfLoadExtensionMessages( 'RefreshSpecial' );

		$wgOut->setPageTitle( wfMsg( 'refreshspecial-title' ) );

		# If the user doesn't have the required permission, display an error
		if( !$wgUser->isAllowed( 'refreshspecial' ) ) {
			$wgOut->permissionRequired( 'refreshspecial' );
			return;
		}

		# Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		# If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		$cSF = new RefreshSpecialForm();

		$action = $wgRequest->getVal( 'action' );
		if( 'success' == $action ) {
			/* do something */
		} else if( 'failure' == $action ) {
			$cSF->showForm( wfMsg('refreshspecial-fail') );
		} else if( $wgRequest->wasPosted() && 'submit' == $action &&
			$wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
			$cSF->doSubmit();
		} else {
			$cSF->showForm( '' );
		}
	}
}

/**
 * RefreshSpecialForm class
 * Constructs and displays the form
 */
class RefreshSpecialForm {
	var $mMode, $mLink;

	/**
	 * Show the actual form
	 *
	 * @param $err string Error message if there was an error, otherwise null
	 */
	function showForm( $err ) {
		global $wgOut, $wgUser, $wgRequest, $wgScriptPath, $wgQueryPages;

		$token = htmlspecialchars( $wgUser->editToken() );
		$titleObj = SpecialPage::getTitleFor( 'RefreshSpecial' );
		$action = $titleObj->escapeLocalURL( 'action=submit' );

		if ( '' != $err ) {
			$wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
			$wgOut->addHTML( "<p class='error'>{$err}</p>\n" );
		}

		$wgOut->addWikiMsg( 'refreshspecial-help' );

		( 'submit' == $wgRequest->getVal( 'action' ) ) ? $scLink = htmlspecialchars( $this->mLink ) : $scLink = '';

		$wgOut->addScriptFile( $wgScriptPath . '/extensions/RefreshSpecial/RefreshSpecial.js' );
		$wgOut->addHTML( "<form name=\"RefreshSpecial\" method=\"post\" action=\"{$action}\">
						<ul>\n" );

		/**
		 * List pages right here
		 *
		 * @todo Display a time estimate or a raw factor
		 * I guess it's not that important, since we have a 1000 rows limit on refresh?
		 * that brings up an interesting question - do we need that limit or not?
		 */
		foreach ( $wgQueryPages as $page ) {
			@list( $class, $special, $limit ) = $page;

			$specialObj = SpecialPage::getPage( $special );
			if ( !$specialObj ) {
		  		$wgOut->addWikiText( wfMsg( 'refreshspecial-no-page' ) . " $special\n" );
				exit;
			}
			$file = $specialObj->getFile();
			if ( $file ) {
				require_once( $file );
			}
			$queryPage = new $class;
			$checked = '';
			if ( $queryPage->isExpensive() ) {
				$checked = 'checked="checked"';
				$wgOut->addHTML("\t\t\t\t\t<li>
						<input type=\"checkbox\" name=\"wpSpecial[]\" value=\"$special\" $checked />
						<b>$special</b>
					</li>\n");
			}
		}

			$wgOut->addHTML( "\t\t\t\t\t" . '<li>
						<input type="checkbox" name="check_all" id="refreshSpecialCheckAll" onclick="refreshSpecialCheck(this.form);" />
						<label for="refreshSpecialCheckAll">&#160;' . wfMsg( 'refreshspecial-select-all-pages' ) . '
							<noscript>' . wfMsg( 'refreshspecial-js-disabled' ) . '</noscript>
						</label>
					</li>
				</ul>
				<input tabindex="5" name="wpRefreshSpecialSubmit" type="submit" value="'. wfMsg( 'refreshspecial-button' ). '" />
				<input type="hidden" name="wpEditToken" value="'. $token .'" />
			</form>' . "\n" );
	}

	/**
	 * Take amount of elapsed time, produce hours (hopefully never needed...), minutes, seconds
	 *
	 * @param $amount int
	 * @return array Amount of elapsed time
	 */
	function computeTime( $amount ) {
		$return_array = array();
		$return_array['hours'] = intval( $amount / 3600 );
		$return_array['minutes'] = intval( $amount % 3600 / 60 );
		$return_array['seconds'] = $amount - $return_array['hours'] * 3600 - $return_array['minutes'] * 60;
		return $return_array;
	}

	/**
	 * Format the time message
	 *
	 * @param $time mixed Amount of time, with h, m or s appended to it
	 * @param $message mixed Message displayed to the user containing the elapsed time
	 * @return true
	 */
	function formatTimeMessage( $time, &$message ) {
		if ( $time['hours'] ) {
			$message .= $time['hours'] . 'h ';
		}
		if ( $time['minutes'] ) {
			$message .= $time['minutes'] . 'm ';
		}
		$message .= $time['seconds'] . 's';
		return true;
	}

	/**
	 * This actually refreshes the special pages
	 * Will need to be modified further
	 */
	function refreshSpecial() {
		global $wgRequest, $wgQueryPages, $wgOut;
		$dbw = wfGetDB( DB_MASTER );
		$to_refresh = $wgRequest->getArray( 'wpSpecial' );
		$total = array(
			'pages' => 0,
			'rows' => 0,
			'elapsed' => 0,
			'total_elapsed' => 0
		);

		foreach ( $wgQueryPages as $page ) {
			@list( $class, $special, $limit ) = $page;
			if ( !in_array( $special, $to_refresh ) ) {
				continue;
			}

			$specialObj = SpecialPage::getPage( $special );
			if ( !$specialObj ) {
			 	$wgOut->addWikiText( wfMsg( 'refreshspecial-no-page' ).": $special\n" );
				exit;
			}
			$file = $specialObj->getFile();
			if ( $file ) {
				require_once( $file );
			}
			$queryPage = new $class;

			$message = '';
			if( !( isset( $options['only'] ) ) or ( $options['only'] == $queryPage->getName() ) ) {
				$wgOut->addHTML( "<b>$special</b>: " );

				if ( $queryPage->isExpensive() ) {
					$t1 = explode( ' ', microtime() );
					# Do the query
					$num = $queryPage->recache( $limit === null ? REFRESHSPECIAL_ROW_LIMIT : $limit );
					$t2 = explode( ' ', microtime() );

			  		if ( $num === false ) {
						$wgOut->addHTML( wfMsg( 'refreshspecial-db-error' ) . '<br />' );
					} else {
			  			$message = wfMsgExt( 'refreshspecial-page-result', array( 'escape', 'parsemag' ), $num ) . '&#160;';
						$elapsed = ( $t2[0] - $t1[0] ) + ( $t2[1] - $t1[1] );
						$total['elapsed'] += $elapsed;
						$total['rows'] += $num;
						$total['pages']++;
						$ftime = $this->computeTime( $elapsed );
						$this->formatTimeMessage( $ftime, $message );
						$wgOut->addHTML( "$message<br />" );
					}

					$t1 = explode( ' ', microtime() );

					# Reopen any connections that have closed
					if ( !wfGetLB()->pingAll() ) {
						$wgOut->addHTML( '<br />' );
						do {
							$wgOut->addHTML( wfMsg( 'refreshspecial-reconnecting' ) . '<br />' );
							sleep( REFRESHSPECIAL_RECONNECTION_SLEEP );
						} while ( !wfGetLB()->pingAll() );
						$wgOut->addHTML( wfMsg( 'refreshspecial-reconnected' ) . '<br /><br />' );
					} else {
						# Commit the results
						$dbw->commit();
					}

					# Wait for the slave to catch up
					$slaveDB = wfGetDB( DB_SLAVE, array( 'QueryPage::recache', 'vslow' ) );
					while( $slaveDB->getLag() > REFRESHSPECIAL_SLAVE_LAG_LIMIT ) {
						$wgOut->addHTML( wfMsg( 'refreshspecial-slave-lagged' ) . '<br />' );
						sleep( REFRESHSPECIAL_SLAVE_LAG_SLEEP );
					}

					$t2 = explode( ' ', microtime() );
					$elapsed_total = ($t2[0] - $t1[0]) + ($t2[1] - $t1[1]);
					$total['total_elapsed'] += $elapsed + $elapsed_total;
				} else {
					$wgOut->addHTML( wfMsg( 'refreshspecial-skipped' ) . '<br />' );
				}
			}
		}
		/* display all stats */
		$elapsed_message = '';
		$total_elapsed_message = '';
		$this->formatTimeMessage( $this->computeTime( $total['elapsed'] ), $elapsed_message );
		$this->formatTimeMessage( $this->computeTime( $total['total_elapsed'] ), $total_elapsed_message );
		$wgOut->addHTML( '<br />' .
			wfMsgExt( 'refreshspecial-total-display',
				array( 'escape', 'parsemag' ),
				$total['pages'],
				$total['rows'],
				$elapsed_message,
				$total_elapsed_message
			)
		);
		$wgOut->addHTML( '</ul></form>' );
	}

	/**
	 * On submit
	 */
	function doSubmit() {
		global $wgOut, $wgUser, $wgRequest;
		/* guard against an empty array */
		$array = $wgRequest->getArray( 'wpSpecial' );
		if ( !is_array( $array ) || empty( $array ) || is_null( $array ) ) {
			$this->showForm( wfMsg( 'refreshspecial-none-selected' ) );
			return;
		}

		$wgOut->setSubTitle( wfMsg( 'refreshspecial-choice', wfMsg( 'refreshspecial-refreshing' ) ) );
		$this->refreshSpecial();
		$sk = $wgUser->getSkin();
		$titleObj = SpecialPage::getTitleFor( 'RefreshSpecial' );
		$link_back = $sk->makeKnownLinkObj( $titleObj, wfMsg( 'refreshspecial-link-back' ) );
		$wgOut->addHTML( '<br /><b>' . $link_back . '</b>' );
	}
}