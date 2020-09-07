<?php

/**
 * Provides the special page to look up user info
 *
 * @file
 */
class LookupUserPage extends SpecialPage {

	const FOUNDER_CACHE_TTL = 3600;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'LookupUser'/*class*/, 'lookupuser'/*restriction*/ );
	}

	/**
	 * @param string $userName
	 * @param int $wikiId
	 * @return string
	 */
	private static function getLookupUserNameKey( string $userName, int $wikiId ): string {
		$cacheKeys = new UserNameCacheKeys( $userName );
		return $cacheKeys->forLookupUser( $wikiId );
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
		$this->setHeaders();
		$request = $this->getRequest();

		# If the user doesn't have the required 'lookupuser' permission, display an error
		if ( !$this->getUser()->isAllowed( 'lookupuser' ) ) {
			$this->displayRestrictionError();
			return;
		}

		if ( $subpage ) {
			$target = $subpage;
		} else {
			$target = $request->getText( 'target' );
		}

		$id = '';
		$byIdInvalidUser = false;
		if ( $request->getText( 'mode' ) == 'by_id' ) {
			$id = (int)$target;

			$u = User::newFromId( $id );
			if ( $u->loadFromId() ) {
				# overwrite text
				$target = $u->getName();
			} else {
				// User with that ID doesn't exist, notify user
				// Stops trying to display form with a user by that name which is confusing
				$byIdInvalidUser = true;
			}
		}

		$emailUser = $request->getText( 'email_user' );
		if ( $emailUser ) {
			$this->showForm( $emailUser, $id, $byIdInvalidUser );
		} else {
			$this->showForm( $target, $id, $byIdInvalidUser );
		}

		if ( $target && !$byIdInvalidUser ) {
			$this->showInfo( $target, $emailUser );
		}
	}

	/**
	 * Show the LookupUser form
	 *
	 * @param $target Mixed: user whose info we're about to look up
	 * @param string $id
	 * @param bool $invalidUser
	 */
	function showForm( $target, $id = '', $invalidUser = false ) {
		global $wgScript, $wgOut;
		$title = Sanitizer::encodeAttribute( $this->getTitle()->getPrefixedText() );
		$action = Sanitizer::encodeAttribute( $wgScript );
		$target = Sanitizer::encodeAttribute( $target );
		$id = Sanitizer::encodeAttribute( $id );
		$ok = wfMessage( 'go' )->escaped();
		$username_label = wfMessage( 'username' )->escaped();
		$email_label = wfMessage( 'email' )->escaped();
		$inputformtop = wfMessage( 'lookupuser' )->escaped();

		if ( $invalidUser ) {
			$wgOut->addWikiText( '<span class="error">' . wfMessage( 'lookupuser-nonexistent-id', $id )->text() . '</span>' );
		}

		$wgOut->addWikiMsg( 'lookupuser-intro' );

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
	 *
	 * @param string $target User whose info we're looking up
	 * @param string $emailUser
	 */
	function showInfo( $target, $emailUser = "" ) {
		global $wgOut, $wgScript, $wgEnableWallExt, $wgExternalSharedDB;
		// Small Stuff Week - adding table from Special:LookupContribs --nAndy
		global $wgExtensionsPath, $wgJsMimeType, $wgResourceBasePath, $wgEnableLookupContribsExt;

		$wg = F::app()->wg;

		/**
		 * look for @ in username
		 */
		$count = 0; $aUsers = array(); $userTarget = "";
		if ( strpos( $target, '@' ) !== false ) {
			/**
			 * find username by email
			 */
			$emailUser = htmlspecialchars( $emailUser );
			$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

			$oRes = $dbr->select( '`user`', 'user_name', array( 'user_email' => $target ), __METHOD__ );

			$loop = 0;
			while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				if ( $loop === 0 ) {
					$userTarget = $oRow->user_name;
				}
				if ( !empty( $emailUser ) && ( $emailUser == $oRow->user_name ) ) {
					$userTarget = $emailUser;
				}
				$aUsers[] = $oRow->user_name;
				$loop++;
			}

			// Check for disabled accounts where we kept the email
			$userIds = $dbr->selectFieldValues(
				'user_properties',
				'up_user',
				[
					'up_property' => 'disabled-user-email',
					'up_value' => $target,
				],
				__METHOD__
			);

			foreach ( User::whoAre( $userIds ) as $user_id => $user_name ) {
				// User::whoAre return an entry for anons (under '0' key), skip it here
				if ( $user_id === 0 ) continue;

				if ( $loop === 0 ) {
					$userTarget = $user_name;
				}
				if ( !empty( $emailUser ) && ( $emailUser == $user_name ) ) {
					$userTarget = $emailUser;
				}
				$aUsers[] = $user_name;
				$loop++;
			}

			$count = $loop;
		}

		$targetUserName = ( !empty( $userTarget ) ? $userTarget : $target );
		$user = User::newFromName( $targetUserName );
		if ( $user == null || $user->getId() == 0 ) {
			$wgOut->addWikiText( '<span class="error">' . wfMessage( 'lookupuser-nonexistent', $target )->text() . '</span>' );
			return;
		}
		if ( $count > 1 ) {
			$options = array();
			if ( !empty( $aUsers ) && is_array( $aUsers ) ) {
				foreach ( $aUsers as $id => $userName ) {
					$options[] = Xml::option( $userName, $userName, ( $userName == $userTarget ) );
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
			$authenticated = wfMessage( 'lookupuser-authenticated', $wg->Lang->timeanddate( $authTs, true ) )->text();
		} else {
			$authenticated = wfMessage( 'lookupuser-not-authenticated' )->text();
		}
		$optionsString = '';
		foreach ( $user->getOptions() as $name => $value ) {
			$optionsString .= "$name = ".htmlspecialchars($value)." <br />";
		}
		$name = $user->getName();
		$email = $user->getEmail() ?: $user->getGlobalAttribute( 'disabled-user-email' );
		if ( !empty( $email ) ) {
			$email_output = wfMessage( 'lookupuser-email', $email, urlencode( $email ) )->text();
		} else {
			$email_output = wfMessage( 'lookupuser-no-email' )->text();
		}
		if ( $user->getRegistration() ) {
			$registration = $wg->Lang->timeanddate( $user->getRegistration(), true );
		} else {
			$registration = wfMessage( 'lookupuser-no-registration' )->text();
		}
		$wgOut->addWikiText( '*' . wfMessage( 'username' )->text() . ' [[User:' . $name . '|' . $name . ']] (' .
			$wg->Lang->pipeList( array(
				'<span id="lu-tools">[[' . ( !empty( $wgEnableWallExt ) ?
				'Message Wall:' . $name . '|' . wfMessage( 'wall-message-wall-shorten' )->text() :
				'User talk:' . $name . '|' . wfMessage( 'talkpagelinktext' )->text() ) . ']]',
				'[[Special:Contributions/' . $name . '|' . wfMessage( 'contribslink' )->text() . ']]</span>)'
			) ) );

		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-toollinks', $name, urlencode( $name ) )->inContentLanguage()->text() );
		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-id', $user->getId() )->text() );
		$userStatus = wfMessage( 'lookupuser-account-status-realuser' )->text();
		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-account-status' )->text() . $userStatus );
		$wgOut->addWikiText( '*' . $email_output );
		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-realname', $user->getRealName() )->text() );
		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-registration', $registration )->text() );
		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-touched', $wg->Lang->timeanddate( $user->mTouched, true ) )->text() );
		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-info-authenticated', $authenticated )->text() );
		if ( isset( $user->mBirthDate ) ) {
			$birthDate = $wg->Lang->date( date( 'Y-m-d H:i:s', strtotime( $user->mBirthDate ) ) );
		} else {
			$birthDate = wfMessage( 'lookupuser-no-birthdate' )->text();
		}
		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-birthdate', $birthDate )->text() );


		$newEmail = $user->getNewEmail();
		if ( !empty( $newEmail ) ) {
			$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-email-change-requested', $newEmail )->plain() );
		}

		// Begin: Small Stuff Week - adding table from Special:LookupContribs --nAndy
		if ( !empty( $wgEnableLookupContribsExt ) ) {
			$wgOut->addExtensionStyle( "{$wgExtensionsPath}/wikia/LookupContribs/css/table.css" );
			$wgOut->addExtensionStyle( "{$wgExtensionsPath}/wikia/LookupUser/css/lookupuser.css" );
			$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgResourceBasePath}/resources/wikia/libraries/jquery/datatables/jquery.dataTables.min.js\"></script>\n" );

			// checking and setting User::mBlockedGlobally if needed
			// only for this instance of class User

			// SUS-423: Don't log user lookup in Phalanx stats
			Hooks::run( 'GetBlockedStatus', [ $user, false /* don't log in Phalanx stats */ ] );

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				'username' => $name,
				'isUsernameGloballyBlocked' => $user->isBlockedGlobally(),
			) );
			$wgOut->addHTML( $oTmpl->render( 'contribution.table' ) );
		} else {
			$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-table-cannot-be-displayed' )->text() );
		}
		// End: Small Stuff Week

		$wgOut->addWikiText( '*' . wfMessage( 'lookupuser-useroptions' )->text() . '<br />' . $optionsString );
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
	public static function getUserData( $userName, $wikiId, $wikiUrl, $checkingBlocks = false ) {
		wfProfileIn( __METHOD__ );

		global $wgMemc, $wgStylePath;

		$cachedData = $wgMemc->get( self::getLookupUserNameKey( $userName, $wikiId ) );
		if ( !empty( $cachedData ) ) {
			if ( $checkingBlocks === false ) {
				if ( $cachedData['groups'] === false ) {
					$result = '-';
				} else {
					$result = implode( ', ', $cachedData['groups'] );
				}
			} else {
				$result = ( $cachedData['blocked'] === true ) ? '<span class="user-blocked">Y</span>' : 'N';
			}
		} else {
			if ( $checkingBlocks === false ) {
				$result = '<span class="user-groups-placeholder">' .
							'<img src="' . $wgStylePath . '/common/images/ajax.gif" />' .
							'<input type="hidden" class="name" value="' . $userName . '" />' .
							'<input type="hidden" class="wikiId" value="' . $wikiId . '" />' .
							'<input type="hidden" class="wikiUrl" value="' . $wikiUrl . '" />' .
							'</span>';
			} else {
				$result = '<span class="user-blocked-placeholder-' . $wikiId . '">' .
							'<img src="' . $wgStylePath . '/common/images/ajax.gif" />' .
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

		$userName = $wgRequest->getVal( 'username' );
		$wikiId = $wgRequest->getVal( 'id' );

		$wiki = WikiFactory::getWikiByID( $wikiId );
		if ( empty( $wiki ) ) {
			return json_encode( [ 'success' => false ] );
		}

		$apiUrl = $wiki->city_url . 'api.php?action=query&list=users&ususers=' . urlencode( $userName ) . '&usprop=localblockinfo|groups|editcount&format=json';

		$cacheKey = self::getLookupUserNameKey( $userName, $wikiId );
		$cachedData = $wgMemc->get( $cacheKey );
		if ( !empty( $cachedData ) ) {
			$result = array( 'success' => true, 'data' => $cachedData );
		} else {
			$result = Http::get( $apiUrl );

			if ( $result !== false ) {
				$result = json_decode( $result, true );

				if ( isset( $result['query']['users'][0] ) ) {
					$userData = $result['query']['users'][0];

					if ( !isset( $userData['groups'] ) ) {
						$userData['groups'] = false;
					} else {
						$userData['groups'] = LookupUserPage::selectGroups( $userData['groups'] );
					}

					if ( true === LookupUserPage::isUserFounder( $userName, $wikiId ) ) {
						$userData['groups'][] = wfMessage( 'lookupuser-founder' )->text();
					}

					if ( !isset( $userData['blockedby'] ) ) {
						$userData['blocked'] = false;
					} else {
						$userData['blocked'] = true;
					}

					$result = array( 'success' => true, 'data' => $userData );
					$wgMemc->set( $cacheKey, $userData, 3600 ); // 1h
				} else {
					$result = array( 'success' => false );
				}
			} else {
				$result = array( 'success' => false );
			}
		}

		wfProfileOut( __METHOD__ );
		return json_encode( $result );
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
	public static function selectGroups( $groups ) {
		wfProfileIn( __METHOD__ );

		$userGroups = array();

		foreach ( $groups as $group ) {
			if ( $group == 'sysop' ) {
				$userGroups[] = wfMessage( 'lookupuser-admin' )->text();
			}

			if ( $group == 'bureaucrat' ) {
				$userGroups[] = wfMessage( 'lookupuser-bureaucrat' )->text();
			}

			if ( $group == 'chatmoderator' ) {
				$userGroups[] = wfMessage( 'lookupuser-chatmoderator' )->text();
			}
		}

		wfProfileOut( __METHOD__ );
		return $userGroups;
	}

	/**
	 * Returns true if a user is founder of a wiki
	 *
	 * @param string $userName
	 * @param integer $wikiId wiki's id
	 *
	 * @return bool
	 */
	public static function isUserFounder( $userName, $wikiId ) {
		global $wgMemc;

		$memcKey = self::getFounderMemKey( $userName, $wikiId );
		$result = $cachedData = $wgMemc->get( $memcKey );

		if ( $result !== true && $result !== false ) {
			$result = false;

			$user = User::newFromName( $userName );
			$wiki = WikiFactory::getWikiById( $wikiId );

			if ( intval( $wiki->city_founding_user ) === intval( $user->getId() ) ) {
				$result = true;
			}

			$wgMemc->set( $memcKey, $result, self::FOUNDER_CACHE_TTL );
		}

		return $result;
	}

	private static function getFounderMemKey( $userName, $wikiId ) {
		return wfSharedMemcKey( 'lookupUser', 'isUserFounder', $userName, $wikiId );
	}


}
