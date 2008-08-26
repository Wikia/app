<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

/**
 * Special page allows stewards to block users on other wiki
 */
class SpecialCrosswikiBlock extends SpecialPage {
	var $mUserProxy, $mUsername, $mDatabase;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'Crosswikiblock', 'crosswikiblock' );
	}

	/**
	 * Show the special page
	 *
	 * @param mixed $par Parameter passed to the page
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser, $wgTitle, $wgRequest, $wgContLang, $wgLang;
		global $wgVersion, $wgMaxNameChars, $wgCapitalLinks;

		# Add messages
		wfLoadExtensionMessages( 'CrosswikiBlock' );

		$this->setHeaders();

		if ( !$wgUser->isAllowed( 'crosswikiblock' ) ) {
			$wgOut->permissionRequired( 'crosswikiblock' );
			return;
		}

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		$action = $wgRequest->getVal( 'action' );
		if( $action == 'submit' ) {
			$blockAddress = $wgRequest->getVal( 'wpBlockAddress' );
			$expiryStr = $wgRequest->getVal( 'wpBlockExpiry' );
			$reason = $wgRequest->getVal( 'wpBlockReason' );
			$options = array(
				'anononly'  => $wgRequest->getCheck( 'wpAnonOnly' ),
				'nocreate'  => $wgRequest->getCheck( 'wpCreateAccount' ),
				'autoblock' => $wgRequest->getCheck( 'wpEnableAutoblock' ),
				'noemail'   => $wgRequest->getCheck( 'wpEmailBan' ),
			);
			if( !$blockAddress ) {
				$this->showForm( wfMsgWikiHtml( 'crosswikiblock-nousername' ) );
			} else if( $this->checkUser( $blockAddress, true ) ) {
			} else if( !( $expiry = $this->convertExpiry( $expiryStr ) ) ) {
				$this->showForm( wfMsgWikiHtml( 'crosswikiblock-noexpiry', htmlspecialchars( $expiryStr ) ) );
			} else if( !$reason ) {
				$this->showForm( wfMsgWikiHtml( 'crosswikiblock-noreason', htmlspecialchars( $reason ) ) );
			} else if( !$wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
				$this->showForm( wfMsgWikiHtml( 'crosswikiblock-notoken' ) );
			} else {
				CrosswikiBlock::normalizeOptions( $this->mUsername, $options );
				$block = new CrosswikiBlock( $this->mDatabase, $this->mUsername, $this->mUserProxy,
					$wgUser, $expiry, $reason, wfTimestampNow(), 0, $options );
				$affected = $block->commit();
				if( $affected ) {
					$wgOut->addHTML( wfMsgWikiHtml( 'crosswikiblock-success',
						htmlspecialchars( $this->mUsername ),
						htmlspecialchars( $this->mDatabase ),
						htmlspecialchars( $blockAddress ),
						htmlspecialchars( Title::newMainPage()->getFullText() ) ) );
					$block->log( $expiryStr );
				} else {
					$this->showForm( wfMsgWikiHtml( 'crosswikiblock-alreadyblocked',
						htmlspecialchars( $this->mUsername ),
						htmlspecialchars( $this->mDatabase ),
						htmlspecialchars( $blockAddress ) ) );
				}
			}
		} else {
			$this->showForm();
		}
	}

	public function checkUser( $username, $output = false ) {
		global $wgOut;
		$bits = explode( '@', $username, 2 );
		if( count( $bits ) == 1 ) {
			if( $output )
				$this->showForm( wfMsgWikiHtml( 'crosswikiblock-local' ) );
			return array( 'local' );
		}

		list( $name, $db ) = $bits;
		if( !UserRightsProxy::validDatabase( $db ) ) {
			if( $output )
				$this->showForm( wfMsgWikiHtml( 'crosswikiblock-dbnotfound', htmlspecialchars( $db ) ) );
			return array( 'dbnotfound', $db );
		}
		if( !User::isIP( $name ) && !User::isCreatableName( $name ) ) {
			if( $output )
				$this->showForm( wfMsgWikiHtml( 'crosswikiblock-noname', htmlspecialchars( $name ) ) );
			return array( 'invalidname', $name );
		}

		if( !User::isIP( $name ) ) {
			$userProxy = UserRightsProxy::newFromName( $db, $name );
			$this->mUserProxy = $userProxy;
			if( !$userProxy ) {
				if( $output )
					$this->showForm( wfMsgWikiHtml( 'crosswikiblock-nouser',
						htmlspecialchars( $name ), htmlspecialchars( $db ), htmlspecialchars( $username ) ) );
				return array( 'usernotfound', $name, $db, $username );
			}
		}

		$this->mUsername = $name;
		$this->mDatabase = $db;
		return false;
	}

	public function convertExpiry( $str ) {
		if ( strlen( $str ) == 0 ) {
			return;
		}

		if ( $str == 'infinite' || $str == 'indefinite' ) {
			return Block::infinity();
		} else {
			# Convert GNU-style date, on error returns -1 for PHP <5.1 and false for PHP >=5.1
			$expiry = strtotime( $str );

			if ( $expiry < 0 || $expiry === false ) {
				return;
			}

			return wfTimestamp( TS_MW, $expiry );
		}
	}

	public function showForm( $err = '' ) {
		global $wgOut, $wgContLang, $wgRequest, $wgUser;
		global $wgStylePath, $wgStyleVersion;

		$titleObj = $this->getTitle();
		$action = $titleObj->escapeLocalURL( "action=submit" );
		$alignRight = $wgContLang->isRtl() ? 'left' : 'right';

		$mIpaddress = Xml::label( wfMsg( 'crosswikiblock-target' ), 'mw-bi-target' );
		$mIpbexpiry = Xml::label( wfMsg( 'crosswikiblock-expiry' ), 'mw-bi-target' );
		$mIpbreason = Xml::label( wfMsg( 'crosswikiblock-reason' ), 'mw-bi-target' );

		if ( "" != $err ) {
			$wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
			$wgOut->addHTML( "<strong class='error'>{$err}</strong>\n" );
		}

		$wgOut->addHTML( wfMsgWikiHtml( 'crosswikiblock-header' ) );
		$wgOut->addHTML( "<form id=\"blockip\" method=\"post\" action=\"{$action}\">
	<table border='0'>
		<tr>
			<td align=\"$alignRight\">{$mIpaddress}</td>
			<td>
				" . Xml::input( 'wpBlockAddress', 45, htmlspecialchars( strval( $wgRequest->getVal( 'wpBlockAddress' ) ) ),
					array(
						'tabindex' => '1',
						'id' => 'mw-bi-target', ) ) . "
			</td>
		</tr>
		<tr id='wpBlockExpiry'>
			<td align=\"$alignRight\">{$mIpbexpiry}</td>
			<td>
				" . Xml::input( 'wpBlockExpiry', 45, htmlspecialchars( strval( $wgRequest->getVal( 'wpBlockExpiry' ) ) ),
					array( 'tabindex' => '3', 'id' => 'mw-bi-other' ) ) . "
			</td>
		</tr>
		<tr id=\"wpBlockReason\">
			<td align=\"$alignRight\">{$mIpbreason}</td>
			<td>
				" . Xml::input( 'wpBlockReason', 45, htmlspecialchars( strval( $wgRequest->getVal( 'wpBlockReason' ) ) ),
					array( 'tabindex' => '5', 'id' => 'mw-bi-reason',
			       		       'maxlength'=> '200' ) ) . "
			</td>
		</tr>
		<tr id='wpAnonOnlyRow'>
			<td>&nbsp;</td>
			<td>
				" . wfCheckLabel( wfMsgHtml( 'crosswikiblock-anononly' ),
					'wpAnonOnly', 'wpAnonOnly', $wgRequest->getCheck( 'wpAnonOnly' ),
					array( 'tabindex' => '6' ) ) . "
			</td>
		</tr>
		<tr id='wpCreateAccountRow'>
			<td>&nbsp;</td>
			<td>
				" . wfCheckLabel( wfMsgHtml( 'crosswikiblock-nocreate' ),
					'wpCreateAccount', 'wpCreateAccount', $wgRequest->getCheck( 'wpAnonOnly' ),
					array( 'tabindex' => '7' ) ) . "
			</td>
		</tr>
		<tr id='wpEnableAutoblockRow'>
			<td>&nbsp;</td>
			<td>
				" . wfCheckLabel( wfMsgHtml( 'crosswikiblock-autoblock' ),
						'wpEnableAutoblock', 'wpEnableAutoblock', $wgRequest->getCheck( 'wpAnonOnly' ),
							array( 'tabindex' => '8' ) ) . "
			</td>
		</tr>" );

		global $wgSysopEmailBans;
		if ( $wgSysopEmailBans && $wgUser->isAllowed( 'blockemail' ) ) {
			$wgOut->addHTML("
			<tr id='wpEnableEmailBan'>
			<td>&nbsp;</td>
				<td>
					" . wfCheckLabel( wfMsgHtml( 'crosswikiblock-noemail' ),
							'wpEmailBan', 'wpEmailBan', $wgRequest->getCheck( 'wpEmailBan' ),
								array( 'tabindex' => '10' )) . "
				</td>
			</tr>
			");
		}

		$wgOut->addHTML("
		<tr>
			<td style='padding-top: 1em'>&nbsp;</td>
			<td style='padding-top: 1em'>
				" . Xml::submitButton( wfMsg( 'crosswikiblock-submit' ),
							array( 'name' => 'wpBlock', 'tabindex' => '11' ) ) . "
			</td>
		</tr>" );

		$token = $wgUser->editToken();
		$wgOut->addHTML( Xml::hidden( 'wpEditToken', $token ) );

		$wgOut->addHTML( '</table></form>' );
	}
}

class SpecialCrosswikiUnblock extends SpecialPage {
	var $mUserProxy, $mUsername, $mDatabase;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'Crosswikiunblock', 'crosswikiblock' );
	}

	/**
	 * Show the special page
	 *
	 * @param mixed $par Parameter passed to the page
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser, $wgTitle, $wgRequest, $wgContLang, $wgLang;
		global $wgVersion, $wgMaxNameChars, $wgCapitalLinks;

		# Add messages
		wfLoadExtensionMessages( 'CrosswikiBlock' );

		$this->setHeaders();

		if ( !$wgUser->isAllowed( 'crosswikiblock' ) ) {
			$wgOut->permissionRequired( 'crosswikiblock' );
			return;
		}

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		$action = $wgRequest->getVal( 'action' );
		if( $action == 'submit' ) {
			$target = $wgRequest->getVal( 'wpUnblockTarget' );
			$reason = $wgRequest->getVal( 'wpUnblockReason' );
			$parsedUsername = CrosswikiBlock::parseBlockAddress( $target );
			if( isset( $parsedUsername['error'] ) ) {
				switch( $parsedUsername['error'] ) {
					case 'nowiki':
						$this->showForm( wfMsgWikiHtml( 'crosswikiunblock-local' ) );
						break;
					case 'invalidwiki':
						$this->showForm( wfMsgWikiHtml( 'crosswikiblock-dbnotfound', $parsedUsername['wiki'] ) );
						break;
					case 'invalidusername':
						$this->showForm( wfMsgWikiHtml( 'crosswikiblock-noname', $parsedUsername['username'] ) );
						break;
					default:
						$this->showForm( wfMsgWikiHtml( 'unknownerror' ) );
				}
			} else {
				$blockRow = CrosswikiBlock::getBlockRow( $parsedUsername );
				if( !$blockRow ) {
					$this->showForm( wfMsgWikiHtml( 'crosswikiblock-noblock' ) );
					return;
				}
				$block = CrosswikiBlock::newFromRow( $blockRow, $parsedUsername['wiki'] );
				$result = $block->remove();
				if( !$result ) {
					$this->showForm( wfMsgWikiHtml( 'crosswikiblock-noblock' ) );
				} else {
					$block->logUnblock( $reason );
					$wgOut->addHTML( wfMsgWikiHtml( 'crosswikiunblock-success', htmlspecialchars($target),
						Title::newMainPage()->getFullText() ) );
				}
			}
		} else {
			$this->showForm();
		}
	}

	public function showForm( $err = '' ) {
		global $wgOut, $wgContLang, $wgRequest, $wgUser;
		global $wgStylePath, $wgStyleVersion;

		$titleObj = $this->getTitle();
		$action = $titleObj->escapeLocalURL( "action=submit" );
		$alignRight = $wgContLang->isRtl() ? 'left' : 'right';

		$mIpbuser = Xml::label( wfMsg( 'crosswikiunblock-user' ), 'mw-bi-target' );
		$mIpbreason = Xml::label( wfMsg( 'crosswikiunblock-reason' ), 'mw-bi-target' );

		if ( "" != $err ) {
			$wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
			$wgOut->addHTML( "<strong class='error'>{$err}</strong>\n" );
		}

		$wgOut->addHTML( wfMsgWikiHtml( 'crosswikiunblock-header' ) );
		$wgOut->addHTML( "<form id=\"crosswikiunblock\" method=\"post\" action=\"{$action}\">
	<table border='0'>
		<tr>
			<td align=\"$alignRight\">{$mIpbuser}</td>
			<td>
				" . Xml::input( 'wpUnblockTarget', 45, htmlspecialchars( strval( $wgRequest->getVal( 'wpUnblockTarget' ) ) ),
					array(
						'tabindex' => '1',
						'id' => 'mw-bi-target', ) ) . "
			</td>
		</tr>
		<tr id=\"wpBlockReason\">
			<td align=\"$alignRight\">{$mIpbreason}</td>
			<td>
				" . Xml::input( 'wpUnblockReason', 45, htmlspecialchars( strval( $wgRequest->getVal( 'wpUnblockReason' ) ) ),
					array( 'tabindex' => '5', 'id' => 'mw-bi-reason',
			       		       'maxlength'=> '200' ) ) . "
			</td>
		</tr>" );

		$wgOut->addHTML("
		<tr>
			<td style='padding-top: 1em'>&nbsp;</td>
			<td style='padding-top: 1em'>
				" . Xml::submitButton( wfMsg( 'crosswikiunblock-submit' ),
							array( 'name' => 'wpBlock', 'tabindex' => '11' ) ) . "
			</td>
		</tr>" );

		$token = $wgUser->editToken();
		$wgOut->addHTML( Xml::hidden( 'wpEditToken', $token ) );

		$wgOut->addHTML( '</table></form>' );
	}
}
