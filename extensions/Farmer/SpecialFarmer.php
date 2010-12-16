<?php
/**
 * Created on Jul 20, 2006
 *
 * @file
 * @ingroup Extensions
 * @author Gregory Szorc <gregory.szorc@gmail.com>
 */

/**
 *
 * @todo Move presentation text into MW messages
 */
class SpecialFarmer extends SpecialPage {
	/**
	 * Class constructor
	 */
	public function __construct() {
		parent::__construct( 'Farmer' );
		wfLoadExtensionMessages( 'MediaWikiFarmer' );
	}

	/**
	 * Executes special page
	 */
	public function execute( $par ) {
		global $wgRequest;
		$wgFarmer = MediaWikiFarmer::getInstance();

		$this->setHeaders();

		$request = $par !== null ? $par : $wgRequest->getText( 'request' );

		$arr = explode( '/', $request );

		if ( count( $arr ) && $arr[0] ) {
			if ( $arr[0] == 'create' ) {
				$this->_executeCreate( $wgFarmer, isset( $arr[1] ) ? $arr[1] : null );
			} elseif ( $arr[0] == 'manageExtensions' ) {
				$this->_executeManageExtensions( $wgFarmer );
			} elseif ( $arr[0] == 'updateList' ) {
				$this->_executeUpdateList( $wgFarmer );
			} elseif ( $arr[0] == 'list' ) {
				$this->_executeList( $wgFarmer );
			} elseif ( $arr[0] == 'admin' ) {
				$this->_executeAdminister( $wgFarmer );
			} elseif ( $arr[0] == 'delete' ) {
				$this->_executeDelete( $wgFarmer );
			}
		} else {
			// no parameters were given
			// display the main page

			$this->_executeMainPage( $wgFarmer );
		}
	}

	/**
	 * Displays the main page
	 */
	protected function _executeMainPage( $wgFarmer ) {
		global $wgOut, $wgUser;

		$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-about' );
		$wgOut->addWikiMsg( 'farmer-about-text' );

		$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-list-wiki' );
		$wgOut->wrapWikiMsg( '* $1', array( 'farmer-list-wiki-text', 'Special:Farmer/list' ) );

		if ( $wgFarmer->getActiveWiki()->isDefaultWiki() ) {

			if ( MediaWikiFarmer::userCanCreateWiki( $wgUser ) ) {
				$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-createwiki' );
				$wgOut->wrapWikiMsg( '* $1', array( 'farmer-createwiki-text', 'Special:Farmer/create' ) );
			}

			// if the user is a farmer admin, give them a menu of cool admin tools
			if ( MediaWikiFarmer::userIsFarmerAdmin( $wgUser ) ) {
				$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-administration' );
				$wgOut->wrapWikiMsg( '=== $1 ===', 'farmer-administration-extension' );
				$wgOut->wrapWikiMsg( '* $1', array( 'farmer-administration-extension-text', 'Special:Farmer/manageExtensions' ) );

				$wgOut->wrapWikiMsg( '=== $1 ===', 'farmer-admimistration-listupdate' );
				$wgOut->wrapWikiMsg( '* $1', array( 'farmer-admimistration-listupdate-text', 'Special:Farmer/updateList' ) );

				$wgOut->wrapWikiMsg( '=== $1 ===', 'farmer-administration-delete' );
				$wgOut->wrapWikiMsg( '* $1', array( 'farmer-administration-delete-text', 'Special:Farmer/delete' ) );
			}
		}

		$wiki = $wgFarmer->getActiveWiki();

		if ( MediaWikiFarmer::userIsFarmerAdmin( $wgUser ) || $wiki->userIsAdmin( $wgUser ) ) {
			$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-administer-thiswiki' );
			$wgOut->wrapWikiMsg( '* $1', array( 'farmer-administer-thiswiki-text', 'Special:Farmer/admin' ) );
		}
	}

	/**
	 * Displays form to create wiki
	 */
	protected function _executeCreate( $wgFarmer, $wiki ) {
		global $wgOut, $wgUser, $wgRequest;

		if ( !$wgFarmer->getActiveWiki()->isDefaultWiki() ) {
			$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-notavailable' );
			$wgOut->addWikiMsg( 'farmer-notavailable-text' );
			return;
		}

		if ( !MediaWikiFarmer::userCanCreateWiki( $wgUser, $wiki ) ) {
			$wgOut->addWikiMsg( 'farmercantcreatewikis' );
			return;
		}

		$name = MediaWikiFarmer_Wiki::sanitizeName( $wgRequest->getVal( 'wpName', $wiki ) );
		$title = MediaWikiFarmer_Wiki::sanitizeTitle( $wgRequest->getVal( 'wpTitle' ) );
		$description = $wgRequest->getVal( 'wpDescription', '' );
		$reason = $wgRequest->getVal( 'wpReason' );
		$action = $this->getTitle( 'create' )->escapeLocalURL();

		// if something was POST'd
		if ( $wgRequest->wasPosted() ) {
			// we create the wiki if the user pressed 'Confirm'
			if ( $wgRequest->getCheck( 'wpConfirm' ) ) {
				$wikiObj = MediaWikiFarmer_Wiki::newFromParams( $name, $title, $description, $wgUser->getName() );
				$wikiObj->create();

				$log = new LogPage( 'farmer' );
				$log->addEntry( 'create', $this->getTitle(), $reason, array( $name ) );

				$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-wikicreated' );
				$wgOut->addWikiMsg( 'farmer-wikicreated-text', $wikiObj->getUrl( wfUrlencode( wfMsgNoDB( 'mainpage' ) ) ) );
				$wgOut->addWikiMsg( 'farmer-default', '[[' . $title . ':Special:Farmer|Special:Farmer]]' );
				return;
			}

			if ( $name && $title && $description ) {
				$wiki = new MediaWikiFarmer_Wiki( $name );

				if ( $wiki->exists() || $wiki->databaseExists() ) {
					$wgOut->wrapWikiMsg( "== $1 ==\n\n$2", 'farmer-wikiexists', array( 'farmer-wikiexists-text', $name ) );
					return;
				}

				$url = $wiki->getUrl( '' );
				$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-confirmsetting' );

				$wgOut->addHtml( Xml::openElement( 'table', array( 'class' => 'wikitable' ) ) . "\n" .
					Xml::tags( 'tr', array(), Xml::tags( 'th', array(),
						wfMsgExt( 'farmer-confirmsetting-name', 'parseinline' ) ) . Xml::element( 'td', array(), $name ) ) . "\n" .
					Xml::tags( 'tr', array(), Xml::tags( 'th', array(),
						wfMsgExt( 'farmer-confirmsetting-title', 'parseinline' ) ) . Xml::element( 'td', array(), $title ) ) . "\n" .
					Xml::tags( 'tr', array(), Xml::tags( 'th', array(),
						wfMsgExt( 'farmer-confirmsetting-description', 'parseinline' ) ) . Xml::element( 'td', array(), $description ) ) . "\n" .
					Xml::tags( 'tr', array(), Xml::tags( 'th', array(),
						wfMsgExt( 'farmer-confirmsetting-reason', 'parseinline' ) ) . Xml::element( 'td', array(), $reason ) ) . "\n" .
					Xml::closeElement( 'table' )
				);
				$wgOut->addWikiMsg( 'farmer-confirmsetting-text', $name, $title, $url );

				$nameaccount = htmlspecialchars( $name );
				$nametitle = htmlspecialchars( $title );
				$namedescript = htmlspecialchars( $description );
				$confirmaccount = wfMsgHtml( 'farmer-button-confirm' );
				$wgOut->addHTML( "

<form id=\"farmercreate2\" method=\"post\" action=\"$action\">
<input type=\"hidden\" name=\"wpName\" value=\"{$nameaccount}\" />
<input type=\"hidden\" name=\"wpTitle\" value=\"{$nametitle}\" />
<input type=\"hidden\" name=\"wpDescription\" value=\"{$namedescript}\" />
<input type=\"hidden\" name=\"wpReason\" value=\"{$reason}\" />
<input type=\"submit\" name=\"wpConfirm\" value=\"{$confirmaccount}\" />
</form>"
				);

				return;
			}
		}

		if ( $wiki && !$name ) {
			$name = $wiki;
		}

		$wgOut->wrapWikiMsg(
			"== $1 ==\n$2\n== $3 ==\n$4\n$5\n$6",
			'farmer-createwiki-form-title',
			'farmer-createwiki-form-text1',
			'farmer-createwiki-form-help',
			'farmer-createwiki-form-text2',
			'farmer-createwiki-form-text3',
			'farmer-createwiki-form-text4'
		);

		$formURL = wfMsgHTML( 'farmercreateurl' );
		$formSitename = wfMsgHTML( 'farmercreatesitename' );
		$formNextStep = wfMsgHTML( 'farmercreatenextstep' );

		$token = htmlspecialchars( $wgUser->editToken() );

		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'method' => 'post', 'action' => $action ) ) . "\n" .
			Xml::buildForm(
				array(
					'farmer-createwiki-user' => Xml::element( 'b', array(), $wgUser->getName() ),
					'farmer-createwiki-name' => Xml::input( 'wpName', 20, $name ),
					'farmer-createwiki-title' => Xml::input( 'wpTitle', 20, $title ),
					'farmer-createwiki-description' => Xml::textarea( 'wpDescription', $description ),
					'farmer-createwiki-reason' => Xml::input( 'wpReason', 20, $reason ),
				), 'farmer-button-submit'
			) . "\n" .
			Xml::hidden( 'token', $token ) . "\n" .
			Xml::closeElement( 'form' )
		);
	}

	protected function _executeUpdateList( $wgFarmer ) {
		global $wgUser, $wgOut;

		if ( !MediaWikiFarmer::userIsFarmerAdmin( $wgUser ) ) {
			$wgOut->permissionRequired( 'farmeradmin' );
			return;
		}

		$wgFarmer->updateFarmList();
		$wgFarmer->updateInterwikiTable();
		$wgOut->wrapWikiMsg( '<div class="successbox">$1</div><br clear="all" />', 'farmer-updatedlist' );
		$wgOut->returnToMain( null, $this->getTitle() );
	}

	protected function _executeDelete( $wgFarmer ) {
		global $wgOut, $wgUser, $wgRequest;

		if ( !$wgFarmer->getActiveWiki()->isDefaultWiki() ) {
			$wgOut->wrapWikiMsg( "== $1 ==\n$2", 'farmer-notaccessible', 'farmer-notaccessible-test' );
			return;
		}

		if ( !MediaWikiFarmer::userIsFarmerAdmin( $wgUser ) ) {
			$wgOut->wrapWikiMsg( "== $1 ==\n$2", 'farmer-permissiondenied', 'farmer-permissiondenied-text' );
			return;
		}

		if ( $wgRequest->wasPosted() && ( $wiki = $wgRequest->getVal( 'wpWiki' ) ) && $wiki != '-1' ) {
			if ( $wgRequest->getCheck( 'wpConfirm' ) ) {
				$wgOut->wrapWikiMsg( '<div class="successbox">$1</div>', array( 'farmer-deleting', $wiki ) );

				$log = new LogPage( 'farmer' );
				$log->addEntry( 'delete', $this->getTitle(), $wgRequest->getVal( 'wpReason' ), array( $wiki ) );

				$deleteWiki = MediaWikiFarmer_Wiki::factory( $wiki );
				$deleteWiki->deleteWiki();
			} else {
				$wgOut->addWikiMsg( 'farmer-delete-confirm-wiki', $wiki );
				$wgOut->addHTML(
					Xml::openElement( 'form', array( 'method' => 'post', 'name' => 'deleteWiki' ) ) . "\n" .
					Xml::buildForm( array(
							'farmer-delete-reason' => Xml::input( 'wpReason', false, $wgRequest->getVal( 'wpReason' ) ),
							'farmer-delete-confirm' => Xml::check( 'wpConfirm' )
						), 'farmer-delete-form-submit' ) . "\n" .
					Xml::hidden( 'wpWiki', $wiki ) . "\n" .
					Xml::closeElement( 'form' )
				);
			}
			return;
		}

		$list = $wgFarmer->getFarmList();

		$wgOut->wrapWikiMsg( "== $1 ==\n$2", 'farmer-delete-title', 'farmer-delete-text' );

		$select = new XmlSelect( 'wpWiki', false, $wgRequest->getVal( 'wpWiki' ) );
		$select->addOption( wfMsg( 'farmer-delete-form' ), '-1' );
		foreach ( $list as $wiki ) {
			if ( $wiki['name'] != $wgFarmer->getDefaultWiki() ) {
				$name = $wiki['name'];
				$title = $wiki['title'];
				$select->addOption( "$name - $title", $name );
			}
		}

		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'method' => 'post', 'name' => 'deleteWiki' ) ) . "\n" .
			$select->getHTML() . "\n" .
			Xml::submitButton( wfMsg( 'farmer-delete-form-submit' ) ) . "\n" .
			Xml::closeElement( 'form' )
		);
	}

	protected function _executeList( $wgFarmer ) {
		global $wgOut;

		$list = $wgFarmer->getFarmList();

		$wgOut->wrapWikiMsg( "== $1 ==", 'farmer-listofwikis' );
		$current = $wgFarmer->getActiveWiki()->name;

		foreach ( $list as $wiki ) {
			$link = ( $current == $wiki['name'] ? wfMsgForContent( 'mainpage' ) : $wiki['name'] . ':' );
			$wgOut->addWikiText( '; [[' . $link . '|' . $wiki['title'] . ']] : ' . $wiki['description'] );
		}
	}

	protected function _executeAdminister( $wgFarmer ) {
		global $wgOut, $wgUser, $wgRequest;

		$currentWiki = MediaWikiFarmer_Wiki::factory( $wgFarmer->getActiveWiki() );

		$action = $this->getTitle( 'admin' )->escapeLocalURL();

		if ( !( MediaWikiFarmer::userIsFarmerAdmin( $wgUser ) || $currentWiki->userIsAdmin( $wgUser ) ) ) {
			$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-permissiondenied' );
			$wgOut->addWikiMsg( 'farmer-permissiondenied-text1' );
			return;
		}

		$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-basic-title' );

		$wiki = $wgFarmer->getActiveWiki();

		if ( $title = $wgRequest->getVal( 'wikiTitle' ) ) {
			$wiki->title = MediaWikiFarmer_Wiki::sanitizeTitle( $title );
			$wiki->save();
			$wgFarmer->updateFarmList();
		}

		if ( $description = $wgRequest->getVal( 'wikiDescription' ) ) {
			$wiki->description = $description;
			$wiki->save();
			$wgFarmer->updateFarmList();
		}

		if ( !$wiki->title ) {
			$wgOut->wrapWikiMsg( '=== $1 ===', 'farmer-basic-title1' );
			$wgOut->addWikiMsg( 'farmer-basic-title1-text' );

			$wgOut->addHTML(
				'<form method="post" name="wikiTitle" action="' . $action . '">' .
				'<input name="wikiTitle" size="30" value="' . $wiki->title . '" />' .
				'<input type="submit" name="submit" value="' . wfMsgHtml( 'farmer-button-submit' ) . '" />' .
				'</form>'
			);
		}

		$wgOut->wrapWikiMsg( '=== $1 ===', 'farmer-basic-description' );
		$wgOut->addWikiMsg( 'farmer-basic-description-text' );

		$wgOut->addHTML(
			'<form method="post" name="wikiDescription" action="' . $action . '">' .
			'<textarea name="wikiDescription" rows="5" cols="30">' . htmlspecialchars( $wiki->description ) . '</textarea>' .
			'<input type="submit" name="submit" value="' . wfMsgHtml( 'farmer-button-submit' ) . '" />' .
			'</form>'
		);

		# Permissions stuff
		if ( wfRunHooks( 'FarmerAdminPermissions', array( $wgFarmer ) ) ) {

			# Import
			if ( $wgRequest->wasPosted() && $permissions = $wgRequest->getArray( 'permission' ) ) {
				foreach ( $permissions['*'] as $k => $v ) {
					$wiki->setPermissionForAll( $k, $v );
				}

				foreach ( $permissions['user'] as $k => $v ) {
					$wiki->setPermissionForUsers( $k, $v );
				}

				$wiki->save();
			}

			# Form
			$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-basic-permission' );
			$wgOut->addWikiMsg( 'farmer-basic-permission-text' );

			$wgOut->addHTML( '<form method="post" name="permissions" action="' . $action . '">' );

			$wgOut->wrapWikiMsg( '=== $1 ===', 'farmer-basic-permission-visitor' );
			$wgOut->addWikiMsg( 'farmer-basic-permission-visitor-text' );

			$doArray = array(
				array( 'read', wfMsg( 'right-read' ) ),
				array( 'edit', wfMsg( 'right-edit' ) ),
				array( 'createpage', wfMsg( 'right-createpage' ) ),
				array( 'createtalk', wfMsg( 'right-createtalk' ) )
			);

			foreach ( $doArray as $arr ) {
				$this->_doPermissionInput( $wgOut, $wiki, '*', $arr[0], $arr[1] );
			}

			$wgOut->wrapWikiMsg( '=== $1 ===', 'farmer-basic-permission-user' );
			$wgOut->addWikiMsg( 'farmer-basic-permission-user-text' );

			$doArray = array(
				array( 'read', wfMsg( 'right-read' ) ),
				array( 'edit', wfMsg( 'right-edit' ) ),
				array( 'createpage', wfMsg( 'right-createpage' ) ),
				array( 'createtalk', wfMsg( 'right-createtalk' ) ),
				array( 'move', wfMsg( 'right-move' ) ),
				array( 'upload', wfMsg( 'right-upload' ) ),
				array( 'reupload', wfMsg( 'right-reupload' ) ),
				array( 'minoredit', wfMsg( 'right-minoredit' ) )
			);

			foreach ( $doArray as $arr ) {
				$this->_doPermissionInput( $wgOut, $wiki, 'user', $arr[0], $arr[1] );
			}

			$wgOut->addHTML( '<input type="submit" name="setPermissions" value="' . wfMsg( 'farmer-setpermission' ) . '" />' );
			$wgOut->addHTML( "</form>\n\n\n" );
		}

		# Default skin
		if ( wfRunHooks( 'FarmerAdminSkin', array( $wgFarmer ) ) ) {

			# Import
			if ( $wgRequest->wasPosted() && $newSkin = $wgRequest->getVal( 'defaultSkin' ) ) {
				$wiki->wgDefaultSkin = $newSkin;
				$wiki->save();
			}

			# Form
			$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-defaultskin' );

			$defaultSkin = $wgFarmer->getActiveWiki()->wgDefaultSkin;

			if ( !$defaultSkin ) {
				$defaultSkin = 'MonoBook';
			}

			$skins = Skin::getSkinNames();
			global $wgSkipSkins;

			foreach ( $wgSkipSkins as $skin ) {
				if ( array_key_exists( $skin, $skins ) ) {
					unset( $skins[$skin] );
				}
			}

			$wgOut->addHTML( '<form method="post" name="formDefaultSkin" action="' . $action . '">' );

			foreach ( $skins as $k => $skin ) {
				$toAdd = '<input type="radio" name="defaultSkin" value="' . $k . '"';
				if ( $k == $defaultSkin ) {
					$toAdd .= ' checked="checked" ';
				}
				$toAdd .= '/>' . $skin;
				$wgOut->addHTML( $toAdd . "<br />\n" );
			}

			$wgOut->addHTML( '<input type="submit" name="submitDefaultSkin" value="' . wfMsgHtml( 'farmer-defaultskin-button' ) . '" />' );
			$wgOut->addHTML( '</form>' );
		}

		# Manage active extensions
		if ( wfRunHooks( 'FarmerAdminExtensions', array( $wgFarmer ) ) ) {

			$extensions = $wgFarmer->getExtensions();

			// if we post a list of new extensions, wipe the old list from the wiki
			if ( $wgRequest->wasPosted() && $wgRequest->getCheck( 'submitExtension' ) ) {
				$wiki->extensions = array();

				// go through all posted extensions and add the appropriate ones
				foreach ( (array)$wgRequest->getArray( 'extension' ) as $k => $e ) {
					if ( array_key_exists( $k, $extensions ) ) {
						$wiki->addExtension( $extensions[$k] );
					}
				}

				$wiki->save();
			}

			# Form
			$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-extensions' );
			$wgOut->addHTML( '<form method="post" name="formActiveExtensions" action="' . $action . '">' );

			foreach ( $extensions as $extension ) {
				$toAdd = '<input type="checkbox" name="extension[' . $extension->name . ']" ';
				if ( $wiki->hasExtension( $extension ) ) {
					$toAdd .= 'checked="checked" ';
				}
				$toAdd .= ' /><strong>' . htmlspecialchars( $extension->name ) . '</strong> - ' . htmlspecialchars( $extension->description ) . "<br />\n";
				$wgOut->addHTML( $toAdd );
			}

			$wgOut->addHTML( '<input type="submit" name="submitExtension" value="' . wfMsgHtml( 'farmer-extensions-button' ) . '" />' );
			$wgOut->addHTML( '</form>' );
		}
	}

	/**
	 * Handles page to manage extensions
	 */
	protected function _executeManageExtensions( $wgFarmer ) {
		global $wgOut, $wgUser, $wgRequest;

		if ( !wfRunHooks( 'FarmerManageExtensions', array( $wgFarmer ) ) ) {
			return;
		}

		// quick security check
		if ( !MediaWikiFarmer::userIsFarmerAdmin( $wgUser ) ) {
			$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-permissiondenied' );
			$wgOut->addWikiMsg( 'farmer-extensions-extension-denied' );
			return;
		}

		// look and see if a new extension was registered

		if ( $wgRequest->wasPosted() ) {
			$name = $wgRequest->getVal( 'name' );
			$description = $wgRequest->getVal( 'description' );
			$include = $wgRequest->getVal( 'include' );

			$extension = new MediaWikiFarmer_Extension( $name, $description, $include );

			if ( !$extension->isValid() ) {
				$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-extensions-invalid' );
				$wgOut->addWikiMsg( 'farmer-extensions-invalid-text' );
			} else {
				$wgFarmer->registerExtension( $extension );
			}
		}

		$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-extensions-available' );

		$extensions = $wgFarmer->getExtensions();

		if ( count( $extensions ) === 0 ) {
			$wgOut->addWikiMsg( 'farmer-extensions-noavailable' );
		} else {
			foreach ( $wgFarmer->getExtensions() as $extension ) {
				$wgOut->addWikiText( '; ' . htmlspecialchars( $extension->name ) . ' : ' . htmlspecialchars( $extension->description ) );
			}
		}

		$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-extensions-register' );
		$wgOut->addWikiMsg( 'farmer-extensions-register-text1' );
		$wgOut->addWikiMsg( 'farmer-extensions-register-text2' );
		$wgOut->addWikiMsg( 'farmer-extensions-register-text3' );
		$wgOut->addWikiMsg( 'farmer-extensions-register-text4' );

		foreach ( explode( PATH_SEPARATOR, get_include_path() ) as $path ) {
			$wgOut->addWikiText( '*' . $path );
		}

		$wgOut->addHTML( "
<form id=\"registerExtension\" method=\"post\">
	<table>
		<tr>
			<td align=\"right\">" . wfMsgHtml( 'farmer-extensions-register-name' ) . "</td>
			<td align=\"left\"><input type=\"text\" size=\"20\" name=\"name\" value=\"\" /></td>
		</tr>
		<tr>
			<td align=\"right\">" . wfMsgHtml( 'farmer-description' ) . "</td>
			<td align=\"left\"><input type=\"text\" size=\"50\" name=\"description\" value=\"\" /></td>
		</tr>
		<tr>
			<td align=\"right\">" . wfMsgHtml( 'farmer-extensions-register-includefile' ) . "</td>
			<td align=\"left\"><input type=\"text\" size=\"50\" name=\"include\" value=\"\" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align=\"right\"><input type=\"submit\" name=\"submit\" value=\"" . wfMsgHtml( 'farmer-button-submit' ) . "\" /></td>
		</tr>
	</table>
</form>" );
	}

	/**
	 * Creates form element representing an individual permission
	 */
	protected function _doPermissionInput( $wgOut, &$wiki, $group, $permission, $description ) {
		$value = $wiki->getPermission( $group, $permission );

		$wgOut->addHTML( '<p>' . $description . wfMsgExt( 'colon-separator', array( 'escapenoentities' ) ) );

		$input = "<input type=\"radio\" name=\"permission[$group][$permission]\" value=\"1\" ";

		if ( $wiki->getPermission( $group, $permission ) ) {
			$input .= 'checked="checked" ';
		}

		$input .= ' />' . wfMsgHtml( 'farmer-yes' ) . '&nbsp;&nbsp;';

		$wgOut->addHTML( $input );

		$input = "<input type=\"radio\" name=\"permission[$group][$permission]\" value=\"0\" ";

		if ( !$wiki->getPermission( $group, $permission ) ) {
			$input .= 'checked="checked" ';
		}

		$input .= ' />' . wfMsgHtml( 'farmer-no' );

		$wgOut->addHTML( $input . '</p>' );
	}
}
