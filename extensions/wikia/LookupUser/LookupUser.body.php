<?php
/**
 * Provides the special page to look up user info
 *
 * @file
 */
class LookupUserPage extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'LookupUser'/*class*/, 'lookupuser'/*restriction*/ );
	}

	function getDescription() {
		return wfMessage( 'lookupuser' )->text();
	}

	/**
	 * Show the special page
	 *
	 * @param $subpage Mixed: parameter passed to the page or null
	 */
	public function execute( $subpage ) {
		global $wgRequest, $wgUser, $wgExternalAuthType;

		$this->setHeaders();

		# If the user doesn't have the required 'lookupuser' permission, display an error
		if ( !$wgUser->isAllowed( 'lookupuser' ) ) {
			$this->displayRestrictionError();
			return;
		}

		if ( $subpage ) {
			$target = $subpage;
		} else {
			$target = $wgRequest->getText( 'target' );
		}

		$id = '';
		$byIdInvalidUser = false;
		if( $wgRequest->getText( 'mode' ) == 'by_id' ) {
			$id = $target;
			if ( $wgExternalAuthType == 'ExternalUser_Wikia' ) {
				$u = ExternalUser::newFromId( $id );
				if ( is_object( $u ) && ( $u->getId() != 0 ) ) {
					#overwrite text
					$target = $u->getName();
				} else {
					// User with that ID doesn't exist, notify user
					// Stops trying to display form with a user by that name which is confusing
					$byIdInvalidUser = true;
				}
			} else {
				$u = User::newFromId($id); #create
				if ( $u->loadFromId() ) {
					#overwrite text
					$target = $u->getName();
				} else {
					// User with that ID doesn't exist, notify user
					// Stops trying to display form with a user by that name which is confusing
					$byIdInvalidUser = true;
				}
			}
		}

		$emailUser = $wgRequest->getText( 'email_user' );
		if ( $emailUser ) {
			$this->showForm( $emailUser, $id, $target, $byIdInvalidUser );
		} else {
			$this->showForm( $target, $id, '', $byIdInvalidUser );
		}

		if ( $target && !$byIdInvalidUser ) {
			$this->showInfo( $target, $emailUser );
		}
	}

	/**
	 * Show the LookupUser form
	 * @param $target Mixed: user whose info we're about to look up
	 */
	function showForm( $target, $id = '', $email = '', $invalidUser = false ) {
		global $wgScript, $wgOut;
		$title = htmlspecialchars( $this->getTitle()->getPrefixedText() );
		$action = htmlspecialchars( $wgScript );
		$target = htmlspecialchars( $target );
		$ok = wfMessage( 'go' )->escaped();
		$username_label = wfMessage( 'username' )->escaped();
		$email_label = wfMessage( 'email' )->escaped();
		$inputformtop = wfMessage( 'lookupuser' )->escaped();

		if ( $invalidUser ) {
			$wgOut->addWikiText( '<span class="error">' . wfMessage( 'lookupuser-nonexistent-id', $id )->text() . '</span>' );
		}

		$wgOut->addWikiMsg('lookupuser-intro');

		$wgOut->addHTML( <<<EOT
<fieldset>
<legend>{$inputformtop}</legend>
<form method="get" action="$action">
<input type="hidden" name="title" value="{$title}" />
<table border="0">
<tr>
<td align="right">{$email_label} or {$username_label}</td>
<td align="left"><input type="text" size="30" name="target" value="$target" /></td>
<td align="center"><input type="submit" value="$ok" /></td>
</tr>
</table>
</form>
EOT
		);

		$wgOut->addHTML( <<<EOT
<form method="get" action="$action">
<input type="hidden" name="title" value="{$title}" />
<input type="hidden" name="mode" value="by_id" />
<table border="0">
<tr>
<td align="right">ID</td>
<td align="left"><input type="text" size="10" name="target" value="$id" /></td>
<td align="center"><input type="submit" value="$ok" /></td>
</tr>
</table>
</form>
</fieldset>
EOT
		);
	}

	/**
	 * Retrieves and shows the gathered info to the user
	 * @param $target Mixed: user whose info we're looking up
	 */
	function showInfo( $target, $emailUser = "" ) {
		global $wgOut, $wgLang, $wgScript, $wgEnableWallExt, $wgEnableUserLoginExt, $wgExternalSharedDB, $wgExternalAuthType;
		//Small Stuff Week - adding table from Special:LookupContribs --nAndy
		global $wgExtensionsPath, $wgJsMimeType, $wgResourceBasePath, $wgEnableLookupContribsExt;

		/**
		 * look for @ in username
		 */
		$count = 0; $aUsers = array(); $userTarget = "";
		if( strpos( $target, '@' ) !== false ) {
			/**
			 * find username by email
			 */
			$emailUser = htmlspecialchars( $emailUser );
			$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

			$oRes = $dbr->select( '`user`', 'user_name', array( 'user_email' => $target ), __METHOD__ );

			$loop = 0;
			while( $oRow = $dbr->fetchObject( $oRes ) ) {
				if ($loop === 0) {
					$userTarget = $oRow->user_name;
				}
				if (!empty($emailUser) && ($emailUser == $oRow->user_name)) {
					$userTarget = $emailUser;
				}
				$aUsers[] = $oRow->user_name;
				$loop++;
			}
			$count = $loop;
		}

		$targetUserName = ( !empty($userTarget) ? $userTarget : $target );
		$extUser = null;
		$user = null;
		if ( $wgExternalAuthType == 'ExternalUser_Wikia' ) {
			$extUser = ExternalUser::newFromName( $targetUserName );
		} else {
			$user = User::newFromName( $targetUserName );
		}
		//@TODO get rid of TempUser handling when it will be globally disabled
		$tempUser = false;
		if ( is_object( $extUser ) && ( $extUser->getId() != 0 ) ) {
			$user = $extUser->mapToUser();
		} elseif ( $user == null || $user->getId() == 0 ) {
			// Check if a temporary user is at this name
			if ( !empty( $wgEnableUserLoginExt ) ) {
				$tempUser = TempUser::getTempUserFromName( $targetUserName );
			}
			if ( $tempUser ) {
				$user = $tempUser->mapTempUserToUser( false );
			} else {
				$wgOut->addWikiText( '<span class="error">' . wfMessage( 'lookupuser-nonexistent', $target )->text() . '</span>' );
				return;
			}
		}
		if ( $count > 1 ) {
			$options = array();
			if (!empty($aUsers) && is_array($aUsers)) {
				foreach ($aUsers as $id => $userName) {
					$options[] = Xml::option( $userName, $userName, ($userName == $userTarget) );
				}
			}
			$selectForm = Xml::openElement( 'select', array( 'id' => 'email_user', 'name' => "email_user" ) );
			$selectForm .= "\n" . implode( "\n", $options ) . "\n";
			$selectForm .= Xml::closeElement( 'select' );
			$selectForm .= "({$count})";

			$wgOut->addHTML(
				Xml::openElement( 'fieldset' ) . "\n" .
				Xml::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript ) ) . "\n" .
				Html::hidden( 'title', $this->getTitle()->getPrefixedText() ) . "\n" .
				Html::hidden( 'target', $target ) . "\n" .
				Xml::openElement( 'table', array( 'border' => '0' ) ) . "\n" .
				Xml::openElement( 'tr' ) . "\n" .
				Xml::openElement( 'td', array( 'align' => 'right' ) ) .
				wfMessage( 'lookupuser-foundmoreusers' )->escaped() .
				Xml::closeElement( 'td' ) . "\n" .
				Xml::openElement( 'td', array( 'align' => 'left' ) ) . "\n" .
				$selectForm . Xml::closeElement( 'td' ) . "\n" .
				Xml::openElement( 'td', array( 'colspan' => '2', 'align' => 'center' ) ) .
				Xml::submitButton( wfMessage( 'go' )->escaped() ) .
				Xml::closeElement( 'td' ) . "\n" .
				Xml::closeElement( 'tr' ) . "\n" .
				Xml::closeElement( 'table' ) . "\n" .
				Xml::closeElement( 'form' ) . "\n" .
				Xml::closeElement( 'fieldset' )
			);
		}

		$authTs = $user->getEmailAuthenticationTimestamp();
		if ( $authTs ) {
			$authenticated = wfMessage( 'lookupuser-authenticated', $wgLang->timeanddate( $authTs, true ) )->text();
		} else {
			$authenticated = wfMessage( 'lookupuser-not-authenticated' )->text();
		}
		$optionsString = '';
		foreach ( $user->getOptions() as $name => $value ) {
			$optionsString .= "$name = $value <br />";
		}
		$name = $user->getName();
		if( $user->getEmail() ) {
			$email = $user->getEmail();
			$email_output = wfMessage( 'lookupuser-email', $email, $name )->text();
		} else {
			$email_output = wfMessage( 'lookupuser-no-email' )->text();
		}
		if( $user->getRegistration() ) {
			$registration = $wgLang->timeanddate( $user->getRegistration(), true );
		} else {
			$registration = wfMessage( 'lookupuser-no-registration' )->text();
		}
		$wgOut->addWikiText( '*' . wfMessage( 'username' )->text() . ' [[User:' . $name . '|' . $name . ']] (' .
			$wgLang->pipeList( array(
				'<span id="lu-tools">[[' . ( !empty( $wgEnableWallExt ) ?
				'Message Wall:' . $name . '|' . wfMessage( 'wall-message-wall-shorten' )->text() :
				'User talk:' . $name . '|' . wfMessage( 'talkpagelinktext' )->text() ) . ']]',
				'[[Special:Contributions/' . $name . '|' . wfMessage( 'contribslink' )->text() . ']]</span>)'
			) ) );

		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-toollinks', $name, urlencode($name) )->inContentLanguage()->text() );
		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-id', $user->getId() )->text() );
		if ( !empty( $tempUser ) ) {
			$userStatus = wfMessage( 'lookupuser-account-status-tempuser' )->text();
		} else {
			$userStatus = wfMessage( 'lookupuser-account-status-realuser' )->text();
		}
		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-account-status' )->text() . $userStatus );
		$wgOut->addWikiText( '*' . $email_output );
		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-realname', $user->getRealName() )->text() );
		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-registration', $registration )->text() );
		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-touched', $wgLang->timeanddate( $user->mTouched, true ) )->text() );
		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-info-authenticated', $authenticated )->text() );

		$allowedAdoption = $user->getOption( 'AllowAdoption', true );
		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-user' . ( !$allowedAdoption ? '-not' : '' ) . '-allowed-adoption' )->plain() );

		//Begin: Small Stuff Week - adding table from Special:LookupContribs --nAndy
		if( !empty($wgEnableLookupContribsExt) ) {
			$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/LookupContribs/css/table.css");
			$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/LookupUser/css/lookupuser.css");
			$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgResourceBasePath}/resources/wikia/libraries/jquery/datatables/jquery.dataTables.min.js\"></script>\n");

			//checking and setting User::mBlockedGlobally if needed
			//only for this instance of class User
			wfRunHooks( 'GetBlockedStatus', array( &$user ) );

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars(array(
				'username' => $name,
				'isUsernameGloballyBlocked' => $user->isBlockedGlobally(),
			));
			$wgOut->addHTML( $oTmpl->render('contribution.table') );
		} else {
			$wgOut->addWikiText( '*' . wfMessage('lookupuser-table-cannot-be-displayed')->text() );
		}
		//End: Small Stuff Week

		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-useroptions' )->text() . '<br />' . $optionsString );
	}

	/**
	 * @brief: Returns memc key
	 *
	 * @param string $userName name of a use
	 * @param integer $wikiId id of a wiki
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 *
	 * @return string
	 */
	public static function getUserLookupMemcKey($userName, $wikiId) {
		return 'lookupUser'.'user'.$userName.'on'.$wikiId;
	}

	/**
	 * @brief: Returns data for jQuery.table plugin used by ajax call LookupContribsAjax::axData()
	 *
	 * @param string $userName name of a use
	 * @param integer $wikiId id of a wiki
	 * @param string $wikiUrl url address of a wiki
	 * @param boolean $checkingBlocks a flag which says if we're checking user groups or block information
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 *
	 * @return string
	 */
	public static function getUserData($userName, $wikiId, $wikiUrl, $checkingBlocks = false) {
		wfProfileIn( __METHOD__ );

		global $wgMemc, $wgStylePath;

		$cachedData = $wgMemc->get( LookupUserPage::getUserLookupMemcKey($userName, $wikiId) );
		if( !empty($cachedData) ) {
			if( $checkingBlocks === false ) {
				if( $cachedData['groups'] === false ) {
					$result = '-';
				} else {
					$result = implode(', ', $cachedData['groups']);
				}
			} else {
				$result = ( $cachedData['blocked'] === true ) ? '<span class="user-blocked">Y</span>' : 'N';
			}
		} else {
			if( $checkingBlocks === false ) {
				$result = '<span class="user-groups-placeholder">'.
							'<img src="' . $wgStylePath . '/common/images/ajax.gif" />'.
							'<input type="hidden" class="name" value="'.$userName.'" />'.
							'<input type="hidden" class="wikiId" value="'.$wikiId.'" />'.
							'<input type="hidden" class="wikiUrl" value="'.$wikiUrl.'" />'.
							'</span>';
			} else {
				$result = '<span class="user-blocked-placeholder-'.$wikiId.'">'.
							'<img src="' . $wgStylePath .'/common/images/ajax.gif" />'.
							'</span>';
			}
		}
		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * @brief: Ajax call loads data for two new columns: user rights and blocked
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function requestApiAboutUser() {
		wfProfileIn( __METHOD__ );

		global $wgRequest, $wgMemc;

		$userName = $wgRequest->getVal('username');
		$wikiUrl = $wgRequest->getVal('url');
		$wikiId = $wgRequest->getVal('id');
		$apiUrl = $wikiUrl.'api.php?action=query&list=users&ususers=' . urlencode( $userName ) .'&usprop=blockinfo|groups|editcount&format=php';

		$cachedData = $wgMemc->get( LookupUserPage::getUserLookupMemcKey($userName, $wikiId) );
		if( !empty($cachedData) ) {
			$result = array('success' => true, 'data' => $cachedData);
		} else {
			$result = Http::get($apiUrl);

			if( $result !== false ) {
				$result = @unserialize($result);

				if( isset($result['query']['users'][0]) ) {
					$userData = $result['query']['users'][0];

					if( !isset($userData['groups']) ) {
						$userData['groups'] = false;
					} else {
						$userData['groups'] = LookupUserPage::selectGroups($userData['groups']);
					}

					if( true === LookupUserPage::isUserFounder($userName, $wikiId) ) {
						$userData['groups'][] = wfMessage('lookupuser-founder')->text();
					}

					if( !isset($userData['blockedby']) ) {
						$userData['blocked'] = false;
					} else {
						$userData['blocked'] = true;
					}

					$result = array('success' => true, 'data' => $userData);
					$wgMemc->set( LookupUserPage::getUserLookupMemcKey($userName, $wikiId), $userData, 3600 ); //1h
				} else {
					$result = array('success' => false);
				}
			} else {
				$result = array('success' => false);
			}
		}

		wfProfileOut( __METHOD__ );
		return json_encode($result);
	}

	/**
	 * @brief: Returns only selected user groups/rights
	 *
	 * @param array $groups array with wiki names of groups like: sysop, bureaucrat, chatmoderator
	 *
	 * @return array
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public static function selectGroups($groups) {
		wfProfileIn( __METHOD__ );

		$userGroups = array();

		foreach($groups as $group) {
			if( $group == 'sysop') {
				$userGroups[] = wfMessage('lookupuser-admin')->text();
			}

			if( $group == 'bureaucrat') {
				$userGroups[] = wfMessage('lookupuser-bureaucrat')->text();
			}

			if( $group == 'chatmoderator') {
				$userGroups[] = wfMessage('lookupuser-chatmoderator')->text();
			}
		}

		wfProfileOut( __METHOD__ );
		return $userGroups;
	}

	/**
	 * @brief Returns true if a user is founder of a wiki
	 *
	 * @param integer $userId user's id
	 * @param integer $wikiId wiki's id
	 *
	 * @return boolean
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public static function isUserFounder($userName, $wikiId) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );

		$memcKey = 'lookupUser'.'user'.'isUserFounder'.$userName.'on'.$wikiId;
		$result = $cachedData = $wgMemc->get( $memcKey );

		if( $result !== true && $result !== false ) {
			$result = false;

			$user = User::newFromName($userName);
			$wiki = WikiFactory::getWikiById($wikiId);

			if( intval($wiki->city_founding_user) === intval($user->getId()) ) {
				$result = true;
			}

			$wgMemc->set( $memcKey, $result, 3600 ); //1h
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}
}
