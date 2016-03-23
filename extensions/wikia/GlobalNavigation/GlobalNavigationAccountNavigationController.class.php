<?php

/**
 * Renders anon/user menu at top right corner of the page.
 *
 * @author Mateusz "Warkot" Warkocki based on work of Maciej Brencz
 */
class GlobalNavigationAccountNavigationController extends WikiaController {

	var $personalUrls;

	public function index() {
		wfProfileIn( __METHOD__ );

		global $wgUser;

		$wgEnableNewAuthModal = $this->app->wg->EnableNewAuthModal;

		$this->isAnon = $wgUser->isAnon();
		$this->enableNewAuthModal = $wgEnableNewAuthModal;
		$this->username = $wgUser->getName();
		$this->avatarContainerAdditionalClass = '';
		$this->profileAvatar = '';

		$this->setupPersonalUrls();

		if ( $this->isAnon ) {
			$this->navItemLinkOpeningTag = $this->renderPersonalUrl( 'login', true );
			$this->avatarContainerAdditionalClass = ' anon-avatar-placeholder';
			$this->loginDropdown = F::app()->renderView( 'UserLoginSpecial', 'dropdown', [ 'template' => 'globalNavigationDropdown', 'registerLink' => $this->renderPersonalUrl( 'register' ) ] );

			if ($wgEnableNewAuthModal) {
				$this->authOptions = $this->getAuthOptions();
			}

		} else {
			$this->navItemLinkOpeningTag = $this->renderPersonalUrl( 'userpage', true );

			if ( AvatarService::isEmptyOrFirstDefault( $this->username ) ) {
				$this->avatarContainerAdditionalClass = ' logged-avatar-placeholder';
			} else {
				$this->avatarContainerAdditionalClass = ' logged-avatar';
				$this->profileAvatar = AvatarService::renderAvatar( $this->username, AvatarService::AVATAR_SIZE_SMALL_PLUS - 2 ); //2px css border
			}

			$possibleItems = [ 'mytalk', 'following', 'preferences' ];
			$dropdownItems = [];

			// Allow hooks to modify the dropdown items.
			wfRunHooks( 'AccountNavigationModuleAfterDropdownItems', [ &$possibleItems, &$this->personalUrls ] );

			foreach ( $possibleItems as $item ) {
				if ( isset( $this->personalUrls[ $item ] ) ) {
					$dropdownItems[] = $this->renderPersonalUrl( $item );
				}
			}

			// link to Help:Content ('known' -> never render as redlink)
			$helpLang = array_key_exists( $this->wg->LanguageCode, $this->wg->AvailableHelpLang ) ? $this->wg->LanguageCode : 'en';
			$dropdownItems[] = Wikia::link(
				Title::newFromText( wfMessage( 'helppage' )->inLanguage( $helpLang )->text() ),
				wfMessage( 'help' )->text(),
				[ 'data-id' => 'help' ],
				'',
				[ 'known' ]
			);

			$dropdownItems[] = $this->renderPersonalUrl( 'logout', false );
			$this->userDropdown = $dropdownItems;
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Checks whether provided string is on blacklist.
	 *
	 * @param string $pageName Redirectto page name to be checked against blacklist
	 * @return bool
	 */
	private static function isBlacklisted( $pageName ) {
		$returntoForbiddenList = [ 'Special:UserLogout', 'Special:UserSignup', 'Special:WikiaConfirmEmail', 'Special:Badtitle' ];
		foreach ( $returntoForbiddenList as $forbiddenPage ) {
			if ( strpos( $pageName, $forbiddenPage ) === 0 ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Render personal URLs item as HTML link.
	 *
	 * @param string $id
	 * @param bool $openingTagOnly If set to true, renders just the <a> tag with appropriate attributes but no content
	 * @return string
	 */
	private function renderPersonalUrl( $id, $openingTagOnly = false ) {
		wfProfileIn( __METHOD__ );

		$personalUrl = $this->personalUrls[ $id ];

		$attributes = [ 'data-id' => $id, 'href' => $personalUrl[ 'href' ] ];

		if ( in_array( $id, [ 'login', 'register' ] ) ) {
			$attributes[ 'rel' ] = 'nofollow';
		}

		if ( isset( $personalUrl[ 'title' ] ) ) {
			$attributes[ 'title' ] = $personalUrl[ 'title' ];
		}

		if ( isset( $personalUrl[ 'class' ] ) ) {
			$attributes[ 'class' ] = $personalUrl[ 'class' ];
		}

		switch ( $id ) {
			case 'mytalk':
				$attributes[ 'accesskey' ] = 'n';
				break;
			case 'login':
				$attributes[ 'accesskey' ] = 'o';
				break;
			case 'userpage':
				$attributes[ 'accesskey' ] = '.';
				break;
		}

		$linkContents = null;
		if ( !$openingTagOnly ) {
			$linkContents = $personalUrl[ 'text' ];
		}

		$markup = Xml::element( 'a', $attributes, $linkContents );

		wfProfileOut( __METHOD__ );
		return $markup;
	}

	public function getAuthOptions() {
		$loginMarkupObj = $this->personalUrls['login'];
		$registerMarkupObj = $this->personalUrls['register'];
		return wfMessage( 'global-navigation-account-navigation-options', [
			Xml::element( 'a', [
				'class' => $loginMarkupObj['class'], 'href' => $loginMarkupObj['href']
			], $loginMarkupObj['text'] ),
			Xml::element( 'a',[
				'class' => $registerMarkupObj['class'], 'href' => $registerMarkupObj['href']
			], $registerMarkupObj['text'] )
		] )->text();
	}

	/**
	 * Modify personal URLs list.
	 */
	private function setupPersonalUrls() {
		$this->personalUrls = F::app()->getSkinTemplateObj()->data[ 'personal_urls' ];

		if ( $this->isAnon ) {
			$query = F::app()->wg->Request->getValues();
			if ( isset( $query[ 'title' ] ) && !self::isBlacklisted( $query[ 'title' ] ) ) {
				$returnto = wfUrlencode( $query[ 'title' ] );
			} else {
				$returnto = Title::newMainPage()->getPartialURL();
			}
			$returnto = wfGetReturntoParam( $returnto );

			if ($this->enableNewAuthModal) {
				$userLoginHelper = new UserLoginHelper();
				$this->personalUrls['login'] = [
					'text' => wfMessage( 'global-navigation-sign-in' )->text(),
					'title' => wfMessage( 'global-navigation-sign-in' )->text(),
					'href' => $userLoginHelper->getNewAuthUrl('/signin'),
					'class' => 'auth-link sign-in'
				];
				$this->personalUrls['register'] = [
					'text' => wfMessage( 'global-navigation-register' )->text(),
					'title' => wfMessage( 'global-navigation-register' )->text(),
					'href' => $userLoginHelper->getNewAuthUrl('/register'),
					'class' => 'auth-link register'
				];
			} else {
				$this->personalUrls['login'] = [
					'text' => wfMessage( 'login' )->text(),
					'title' => wfMessage( 'login' )->text(),
					'href' => Skin::makeSpecialUrl( 'UserLogin', $returnto ),
					'class' => 'ajaxLogin table-cell'
				];
				$this->personalUrls['register'] = [
					'text' => wfMessage( 'global-navigation-register' )->text(),
					'title' => wfMessage( 'global-navigation-register' )->text(),
					'href' => Skin::makeSpecialUrl( 'UserSignup' ),
					'class' => 'ajaxRegister'
				];
			}
		} else {
			$this->personalUrls[ 'userpage' ] = [
				'text' => $this->username . ' - ' . wfMessage( 'mypage' )->text(),
				'title' => $this->username . ' - ' . wfMessage( 'mypage' )->text(),
				'href' => AvatarService::getUrl( $this->username ),
				'class' => 'ajaxLogin table-cell'
			];
		}
	}
}
