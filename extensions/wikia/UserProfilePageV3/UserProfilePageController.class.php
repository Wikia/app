<?php

use Wikia\Factory\ServiceFactory;

class UserProfilePageController extends WikiaController {
	const AVATAR_DEFAULT_SIZE = 150;
	const AVATAR_MAX_SIZE = 512000;
	const MAX_TOP_WIKIS = 4;

	const FBPAGE_BASE_URL = 'https://www.facebook.com/';

	/**
	 * @var string CLEAR_USER_PROFILE_RIGHT
	 * MediaWiki user right required for clearing user profile data in 1 click
	 */
	const CLEAR_USER_PROFILE_RIGHT = 'clearuserprofile';

	protected $allowedNamespaces = null;
	protected $title = null;

	protected $defaultAvatars = null;
	protected $defaultAvatarPath = 'https://vignette.wikia.nocookie.net/messaging/images/';

	public function __construct() {
		parent::__construct();
		global $UPPNamespaces;
		$this->allowedNamespaces = $UPPNamespaces;
		$this->title = $this->wg->Title;
	}

	/**
	 * @brief main entry point
	 */
	public function index() {
		if ( !$this->app->checkSkin( 'wikiamobile' ) ) {
			$this->skipRendering();
		}

		$this->overrideTemplate( 'WikiaMobileIndex' );
	}

	/**
	 * @brief Renders new user identity box
	 *
	 * @desc Creates array of user's data and passes it to the template
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function renderUserIdentityBox() {
		wfProfileIn( __METHOD__ );

		$this->setVal( 'wgBlankImgUrl', $this->wg->BlankImgUrl );

		$this->response->addAsset( 'extensions/wikia/UserProfilePageV3/css/UserProfilePage.scss' );
		$this->response->addAsset( 'extensions/wikia/UserProfilePageV3/js/ext.wikia.userProfile.avatarManager.js' );
		$this->response->addAsset( 'extensions/wikia/UserProfilePageV3/js/UserProfilePage.js' );
		$this->response->addAsset( 'extensions/wikia/UserProfilePageV3/js/BioModal.js' );

		$sessionUser = $this->wg->User;

		$this->setRequest( new WikiaRequest( $this->wg->Request->getValues() ) );
		$user = UserProfilePageHelper::getUserFromTitle();
		/**
		 * @var $userIdentityBox UserIdentityBox
		 */
		$userIdentityBox = new UserIdentityBox( $user );
		$isOwner = $this->isOwner( $user );

		if ( $isOwner ) {
			// this is a small trick to remove some
			// probably cache/session lag. before, I used
			// phalanx to block my user globally. but just
			// after I blocked him the session user object
			// still returned false when I called on it getBlockedStatus()
			// in the same time user object retrieved from title
			// returned id of user block. after more or less an hour
			// both instances of User object returned me id of user block
			// when I called getBlockedStatus() on them
			$sessionUser = $user;
		}

		$userData = $userIdentityBox->getFullData();

		$this->setVal( 'isBlocked', ( $user->isBlocked( true, false ) || $user->isBlockedGlobally() ) );
		$this->setVal( 'zeroStateCssClass', ( $userData[ 'showZeroStates' ] ) ? 'zero-state' : '' );

		$this->setVal( 'user', $userData );
		$this->setVal( 'deleteAvatarLink', SpecialPage::getTitleFor( 'RemoveUserAvatar' )->getFullURL( 'av_user=' . $userData[ 'name' ] ) );
		$this->setVal( 'canRemoveAvatar', $sessionUser->isAllowed( 'removeavatar' ) );
		$this->setVal( 'isUserPageOwner', $isOwner );

		$this->setVal( 'canEditProfile', $this->canEdit( $user ) );
		$this->setVal( 'isWikiStaff', $sessionUser->isStaff() );
		$this->setVal( 'canClearProfile', $sessionUser->isAllowed( static::CLEAR_USER_PROFILE_RIGHT ) );

		$this->fetchDiscussionPostsNumberFrom($user);

		if ( !empty( $this->title ) ) {
			$this->setVal( 'reloadUrl', htmlentities( $this->title->getFullURL(), ENT_COMPAT, 'UTF-8' ) );
		} else {
			$this->setVal( 'reloadUrl', '' );
		}

		$this->response->addAsset( 'resources/wikia/modules/aim.js' );

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$this->overrideTemplate( 'WikiaMobileRenderUserIdentityBox' );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief Renders new action button
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function renderActionButton() {
		wfProfileIn( __METHOD__ );

		$namespace = $this->title->getNamespace();

		$this->setRequest( new WikiaRequest( $this->wg->Request->getValues() ) );
		$user = UserProfilePageHelper::getUserFromTitle();

		/**
		 * @var $sessionUser User
		 */
		$sessionUser = $this->wg->User;
		$canRename = $sessionUser->isAllowed( 'renameprofilev3' );
		$canProtect = $sessionUser->isAllowed( 'protect' );
		$canDelete = $sessionUser->isAllowed( 'deleteprofilev3' );
		$isOwner = $user instanceof User && $this->isOwner( $user );

		$editQuery = [ 'action' => 'edit' ];

		// check if this is an older version of the page
		$oldid = $this->wg->Request->getInt( 'oldid', 0 );
		if ( $oldid ) {
			$editQuery[ 'oldid' ] = $oldid;
		}

		$actionButtonArray = [ ];
		$canSessionUserEdit = $this->title->userCan( 'edit', $sessionUser );
		if ( $namespace == NS_USER ) {
			// profile page
			$actionButtonArray = [
				'action' => [
					'href'      => $this->title->getLocalURL( $editQuery ),
					'text'      => $canSessionUserEdit ? wfMessage( 'user-action-menu-edit-profile' )->escaped() : wfMessage( 'viewsource' )->escaped(),
					'id'        => 'ca-edit',
					'accesskey' => $canSessionUserEdit ? wfMessage( 'accesskey-ca-edit' )->escaped() : wfMessage( 'accesskey-ca-viewsource' )->escaped(),
				],
				'image'  => $canSessionUserEdit ? MenuButtonController::EDIT_ICON : MenuButtonController::LOCK_ICON,
				'name'   => 'editprofile',
			];
		} else {
			if ( $namespace == NS_USER_TALK && empty( $this->wg->EnableWallExt ) ) {
				// talk page
				/**
				 * @var $title Title
				 */
				$title = Title::newFromText( $user->getName(), NS_USER_TALK );

				if ( $title instanceof Title ) {
					// sometimes title isn't created, I've tried to reproduce it on my devbox and I couldn't
					// checking if $title is instance of Title is a quick fix -- if it isn't no action button will be shown
					if ( $isOwner || $this->wg->Request->getVal( 'oldid' ) ) {
						$actionButtonArray = [
							'action' => [
								'href'      => $this->title->getLocalURL( $editQuery ),
								'text'      => $canSessionUserEdit ? wfMessage( 'user-action-menu-edit' )->escaped() : wfMessage( 'viewsource' )->escaped(),
								'id'        => 'ca-edit',
								'accesskey' => $canSessionUserEdit ? wfMessage( 'accesskey-ca-edit' )->escaped() : wfMessage( 'accesskey-ca-viewsource' )->escaped(),
							],
							'image'  => $canSessionUserEdit ? MenuButtonController::EDIT_ICON : MenuButtonController::LOCK_ICON,
							'name'   => 'editprofile',
						];
					} else {
						$actionButtonArray = [
							'action'   => [
								'href'      => $title->getLocalURL( array_merge( $editQuery, [ 'section' => 'new' ] ) ),
								'text'      => $canSessionUserEdit ? wfMessage( 'user-action-menu-leave-message' )->escaped() : wfMessage( 'viewsource' )->escaped(),
								'id'        => 'ca-addsection',
								'accesskey' => $canSessionUserEdit ? wfMessage( 'accesskey-ca-addsection' )->escaped() : wfMessage( 'accesskey-ca-viewsource' )->escaped(),
							],
							'image'    => $canSessionUserEdit ? MenuButtonController::MESSAGE_ICON :MenuButtonController::LOCK_ICON,
							'name'     => 'leavemessage',
							'dropdown' => [
								'edit' => [
									'href'      => $this->title->getFullURL( $editQuery ),
									'text'      => wfMessage( 'user-action-menu-edit' )->escaped(),
									'id'        => 'ca-edit',
									'accesskey' => wfMessage( 'accesskey-ca-edit' )->escaped(),
								],
							],
						];
					}
				}
			} else {
				if ( defined( 'NS_BLOG_ARTICLE' ) && $namespace == NS_BLOG_ARTICLE && $isOwner ) {
					// blog page

					$actionButtonArray = [
						'action' => [
							'href' => SpecialPage::getTitleFor( 'CreateBlogPage' )->getLocalURL( !empty( $this->wg->CreateBlogPagePreload ) ? 'preload=$wgCreateBlogPagePreload' : '' ),
							'text' => wfMessage( 'blog-create-post-label' )->escaped(),
						],
						'image'  => MenuButtonController::BLOG_ICON,
						'name'   => 'createblogpost',
					];
				}
			}
		}

		if ( in_array( $namespace, [ NS_USER, NS_USER_TALK ] ) ) {
			// profile & talk page
			if ( $canRename ) {
				/**
				 * @var $specialMovePage Title
				 */
				$specialMovePage = SpecialPage::getTitleFor( 'MovePage' );
				$renameUrl = $specialMovePage->getLocalURL() . '/' . $this->title->__toString();
				$actionButtonArray[ 'dropdown' ][ 'rename' ] = [
					'href'      => $renameUrl,
					'text'      => wfMessage( 'user-action-menu-rename' )->escaped(),
					'id'        => 'ca-move',
					'accesskey' => wfMessage( 'accesskey-ca-move' )->escaped(),
				];
			}

			if ( $canProtect ) {
				$protectStatus = $this->title->isProtected() ? 'unprotect' : 'protect';

				$actionButtonArray[ 'dropdown' ][ 'protect' ] = [
					'href'      => $this->title->getLocalURL( [ 'action' => $protectStatus ] ),
					'text'      => wfMessage( 'user-action-menu-' . $protectStatus )->escaped(),
					'id'        => 'ca-protect',
					'accesskey' => wfMessage( 'accesskey-ca-protect' )->escaped(),
				];
			}

			if ( $canDelete ) {
				$actionButtonArray[ 'dropdown' ][ 'delete' ] = [
					'href'      => $this->title->getLocalURL( [ 'action' => 'delete' ] ),
					'text'      => wfMessage( 'user-action-menu-delete' )->escaped(),
					'id'        => 'ca-delete',
					'accesskey' => wfMessage( 'accesskey-ca-delete' )->escaped(),
				];
			}

			$actionButtonArray[ 'dropdown' ][ 'history' ] = [
				'href'      => $this->title->getLocalURL( [ 'action' => 'history' ] ),
				'text'      => wfMessage( 'user-action-menu-history' )->escaped(),
				'id'        => 'ca-history',
				'accesskey' => wfMessage( 'accesskey-ca-history' )->escaped(),
			];
		}

		Hooks::run( 'UserProfilePageAfterGetActionButtonData', [ &$actionButtonArray, $namespace, $canRename, $canProtect, $canDelete, $isOwner ] );

		$actionButton = F::app()->renderView( 'MenuButton', 'Index', $actionButtonArray );
		$this->setVal( 'actionButton', $actionButton );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief Gets lightbox data
	 *
	 * @requestParam string $userId user's unique id
	 * @requestParam string $tab current tab
	 *
	 * @author ADi
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getLightboxData() {
		wfProfileIn( __METHOD__ );

		$selectedTab = $this->getVal( 'tab' );
		$userId = $this->getVal( 'userId' );
		$sessionUser = $this->wg->User;

		if ( $sessionUser->isAnon() || ! $this->canEdit( $sessionUser ) ) {
			throw new WikiaException( wfMessage( 'userprofilepage-invalid-user' )->escaped() );
		} else {
			$this->setVal( 'body', ( string )$this->sendSelfRequest( 'renderLightbox', [ 'tab' => $selectedTab, 'userId' => $userId ] ) );

			if ( !empty( $this->wg->AvatarsMaintenance ) ) {
				$this->setVal( 'avatarsDisabled', true );
				$this->setVal( 'avatarsDisabledMsg', wfMessage( 'user-identity-avatars-maintenance' )->text() );
			}
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief Renders lightbox
	 *
	 * @requestParam string $userId user's unique id
	 * @requestParam string $tab current tab
	 *
	 * @desc Mainly passes two variables to the template: tabs, selectedTab but also if it's about tab or avatar uses private method to pass more data
	 */
	public function renderLightbox() {
		wfProfileIn( __METHOD__ );

		$selectedTab = $this->getVal( 'tab' );
		$userId = $this->getVal( 'userId' );

		$tabs = [
			[ 'id' => 'avatar', 'name' => wfMessage( 'user-identity-box-avatar' )->escaped() ],
			[ 'id' => 'about', 'name' => wfMessage( 'user-identity-box-about-me' )->escaped() ],
		];

		$this->renderAvatarLightbox( $userId );
		$this->renderAboutLightbox( $userId );

		$this->setVal( 'tabs', $tabs );
		$this->setVal( 'selectedTab', $selectedTab );

		$this->setVal( 'wgBlankImgUrl', $this->wg->BlankImgUrl );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Sets user's avatar to one of the available defaults provided by us
	 * @requestParam string avatar file name of default avatar
	 */
	public function saveDefaultAvatar() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		try {
			$this->checkWriteRequest();
		} catch ( \BadRequestException $bre ) {
			$this->setTokenMismatchError();
			return;
		}

		$context = $this->getContext();
		$user = $context->getUser();

		$avatar = Masthead::getDefaultAvatarUrl( $context->getRequest()->getVal( 'avatar' ), '' );

		// remove old avatar file
		$masthead = Masthead::newFromUser( $user );
		if ( !$masthead->isDefault() ) {
			$service = new UserAvatarsService( $user->getId() );
			$service->remove();
		}

		// store the full URL of the predefined avatar and skip an upload via service (PLATFORM-1494)
		$user->setGlobalAttribute( AVATAR_USER_OPTION_NAME, $avatar );
		$user->saveAttributes();
		$user->invalidateCache();
	}

	/**
	 * @brief Receives data from AJAX call, validates and saves new user data
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function saveUserData() {
		wfProfileIn( __METHOD__ );

		try {
			$this->checkWriteRequest();
		} catch ( \BadRequestException $bre ) {
			$this->setTokenMismatchError();
			wfProfileOut( __METHOD__ );
			return;
		}

		$user = User::newFromId( $this->getVal( 'userId' ) );
		$isAllowed = $this->canEdit( $user );

		$userData = json_decode( $this->getVal( 'data' ) );

		$status = 'error';
		$errorMsg = wfMessage( 'user-identity-box-saving-internal-error' )->escaped();

		if ( $isAllowed && is_object( $userData ) ) {
			/**
			 * @var $userIdentityBox UserIdentityBox
			 */
			$userIdentityBox = new UserIdentityBox( $user );

			if ( !empty( $userData->website ) && strpos( $userData->website, 'http' ) !== 0 ) {
				$userData->website = 'http://' . $userData->website;
			}

			if ( !empty( $userData->fbPage ) && strpos( $userData->fbPage, self::FBPAGE_BASE_URL ) !== 0 ) {
				$userData->fbPage = self::FBPAGE_BASE_URL . $userData->fbPage;
			}

			if ( !$userIdentityBox->saveUserData( $userData ) ) {
				$status = 'error';
				$errorMsg = wfMessage( 'userprofilepage-interview-save-internal-error' )->escaped();
			} else {
				$status = 'ok';
			}
		}

		if ( $isAllowed && is_null( $userData ) ) {
			$errorMsg = wfMessage( 'user-identity-box-saving-error' )->escaped();
		}

		$this->setVal( 'status', $status );
		if ( $status === 'error' ) {
			$this->setVal( 'errorMsg', $errorMsg );
			wfProfileOut( __METHOD__ );
			return;
		}

		wfProfileOut( __METHOD__ );
		return;
	}

	private function clearAttributeCache( $userId ) {
		$attributeService = ServiceFactory::instance()->attributesFactory()->userAttributes();
		$attributeService->clearCache( $userId );
	}

	/**
	 * @brief Passes more data to the template to render avatar modal box
	 *
	 * @param int $userId
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function renderAvatarLightbox( $userId ) {
		wfProfileIn( __METHOD__ );

		$user = User::newFromId( $userId );

		$this->setVal( 'defaultAvatars', $this->getDefaultAvatars() );

		$this->setVal( 'avatarName', $user->getGlobalAttribute( AVATAR_USER_OPTION_NAME ) );
		$this->setVal( 'userId', $userId );
		$this->setVal( 'avatarMaxSize', self::AVATAR_MAX_SIZE );
		$this->setVal( 'avatar', AvatarService::renderAvatar( $user->getName(), self::AVATAR_DEFAULT_SIZE, 'avatar avatar-preview' ) );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief Gets an array of sample avatars
	 *
	 * @desc Method based on Masthead::getDefaultAvatars()
	 *
	 * @param string $thumb a thumb
	 *
	 * @return array multidimensional array with default avatars defined on messaging.wikia.com
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getDefaultAvatars( $thumb = '' ) {
		wfProfileIn( __METHOD__ );

		// parse message only once per request
		if ( empty( $thumb ) && is_array( $this->defaultAvatars ) && count( $this->defaultAvatars ) > 0 ) {
			wfProfileOut( __METHOD__ );
			return $this->defaultAvatars;
		}

		$this->defaultAvatars = [ ];
		$images = getMessageForContentAsArray( 'blog-avatar-defaults' );

		if ( is_array( $images ) ) {
			foreach ( $images as $image ) {
				$avatarUrl = Masthead::getDefaultAvatarUrl( $image );
				$this->defaultAvatars[] = [
					'url' => ImagesService::getThumbUrlFromFileUrl( $avatarUrl, self::AVATAR_DEFAULT_SIZE ),
					'name' => $image,
				];
			}
		}

		wfProfileOut( __METHOD__ );
		return $this->defaultAvatars;
	}

	/**
	 * @brief Passes more data to the template to render about modal box
	 *
	 * @param int $userId
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function renderAboutLightbox( $userId ) {
		$user = User::newFromId( $userId );

		/**
		 * @var $userIdentityBox UserIdentityBox
		 */
		$userIdentityBox = new UserIdentityBox( $user );

		$userData = $userIdentityBox->getFullData();

		if ( !empty( $userData[ 'fbPage' ] ) ) {
			$userData[ 'fbPage' ] = str_replace( self::FBPAGE_BASE_URL, '', $userData[ 'fbPage' ] );
		}

		$this->setVal( 'user', $userData );

		$this->setVal( 'charLimits', [
			'name'       => UserIdentityBox::USER_NAME_CHAR_LIMIT,
			'location'   => UserIdentityBox::USER_LOCATION_CHAR_LIMIT,
			'occupation' => UserIdentityBox::USER_OCCUPATION_CHAR_LIMIT,
			'gender'     => UserIdentityBox::USER_GENDER_CHAR_LIMIT,
		] );

		if ( !empty( $userData[ 'birthday' ][ 'month' ] ) ) {
			$daysPerMonth = [ 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];
			$this->setVal( 'days', $daysPerMonth[intval( $userData['birthday']['month'] ) - 1] );
		}
	}

	/**
	 * @brief Gets wikiId from request and hides from faviorites wikis
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onHideWiki() {
		$result = [ 'success' => false ];
		$userId = intval( $this->getVal( 'userId' ) );
		$wikiId = intval( $this->getVal( 'wikiId' ) );

		$user = User::newFromId( $userId );
		$isAllowed = $this->canEdit( $user );

		if ( $isAllowed && $wikiId > 0 ) {
			/**
			 * @var $userIdentityBox UserIdentityBox
			 */
			$userIdentityBox = new UserIdentityBox( $user );
			$success = $userIdentityBox->hideWiki( $wikiId );

			$result = [ 'success' => $success, 'wikis' => $userIdentityBox->getTopWikis() ];
		}

		$this->setVal( 'result', $result );
	}

	/**
	 * @brief Gets fav wikis information and passes it as JSON
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onRefreshFavWikis() {
		$result = [ 'success' => false ];
		$userId = intval( $this->getVal( 'userId' ) );
		$user = User::newFromId( $userId );

		if ( $this->canEdit( $user ) && $this->request->wasPosted() ) {
			$userIdentityBox = new UserIdentityBox( $user );
			$result = [ 'success' => true, 'wikis' => $userIdentityBox->getTopWikis( true ) ];
		}

		$this->setVal( 'result', $result );
	}

	public function getClosingModal() {
		wfProfileIn( __METHOD__ );

		$userId = $this->getVal( 'userId' );
		$user = $this->wg->User;

		if ( !$user->isAnon() ) {
			$this->setVal( 'body', ( string )$this->sendSelfRequest( 'renderClosingModal', [ 'userId' => $userId ] ) );
		} else {
			throw new WikiaException( 'User not logged in' );
		}

		wfProfileOut( __METHOD__ );
	}

	public function renderClosingModal() {
		wfProfileIn( __METHOD__ );

		// we want only the template for now...

		wfProfileOut( __METHOD__ );
	}

	public function fetchDiscussionPostsNumberFrom( $targetUser ) {
		global $wgEnableDiscussions;

		$this->setVal( 'discussionPostsCountInUserIdentityBoxEnabled', $wgEnableDiscussions );
		if ( $wgEnableDiscussions && !$targetUser->isAnon() ) {
			$discussionInfo = UserIdentityBoxDiscussionInfo::createFor( $targetUser );

			$this->setVal( 'discussionActive', $discussionInfo->isDiscussionActive() );
			$this->setVal( 'discussionPostsCount', $discussionInfo->getDiscussionPostsCount() );
			$this->setVal( 'discussionAllPostsByUserLink',
				$discussionInfo->getDiscussionAllPostsByUserLink() );
		} else {
			$this->setVal( 'discussionActive', false );
			$this->setVal( 'discussionPostsCount', 0 );
			$this->setVal( 'discussionAllPostsByUserLink', '' );
		}
	}

	/**
	 * @throws BadRequestException
	 * @return bool
	 */
	public function removeavatar() {
		wfProfileIn( __METHOD__ );
		$this->checkWriteRequest();

		$this->setVal( 'status', false );

		// macbre: avatars operations are disabled during maintenance
		global $wgAvatarsMaintenance;
		if ( !empty( $wgAvatarsMaintenance ) ) {
			$this->setVal( 'error', wfMessage( 'user-identity-avatars-maintenance' )->escaped() );
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( !$this->wg->User->isAllowed( 'removeavatar' ) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( $this->request->getVal( 'avUser' ) ) {
			$avUser = User::newFromName( $this->request->getVal( 'avUser' ) );
			if ( $avUser->getId() !== 0 ) {
				$avatar = Masthead::newFromUser( $avUser );
				if ( $avatar->removeFile( true ) ) {
					$this->clearCaches( $avUser );
					$this->setVal( 'status', 'ok' );
					wfProfileOut( __METHOD__ );
					return true;
				}
			}
		}

		$this->setVal( 'error', wfMessage( 'user-identity-remove-fail' )->escaped() );

		wfProfileOut( __METHOD__ );
		return true;
	}

	private function clearCaches( User $user ) {
		$this->clearAttributeCache( $user->getId() );
		$this->bustETagsForUserPage( $user );
		$this->bustETagsForAllPagesIfNecessary( $user );
	}

	/**
	 *
	 * @param User $user
	 */
	private function bustETagsForUserPage( User $user ) {
		$user->getUserPage()->invalidateCache();
	}

	/**
	 * Call invalidateCache for the current user if the user is removing their own avatar. This is necessary
	 * because the global header (which contains the avatar) is cached along with the page, so any article page
	 * the user has in browser cache will contain their stale avatar value. invalidateCache updates the
	 * user's last_touched value which is used when validating ETags, effectively busting all pages the user
	 * has in their browser cache.
	 */
	private function bustETagsForAllPagesIfNecessary( User $user ) {
		if ( $this->isOwner( $user ) ) {
			$user->invalidateCache();
		}
	}

	/**
	 * Clears contents of user profile masthead
	 * @requestParam string token valid MediaWiki edit token
	 * @requestParam string target user name of user whose masthead we want to clear
	 * @responseParam string error [optional] error message, if any
	 * @responseParam string success [optional] success confirmation message if action was successful
	 */
	public function clearMastheadContents() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );

		try {
			$this->checkWriteRequest();
		} catch ( BadRequestException $bre ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			$this->response->setVal( 'error', wfMessage( 'sessionfailure' )->escaped() );
			return;
		}

		if ( !$this->wg->User->isAllowed( static::CLEAR_USER_PROFILE_RIGHT ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			$this->response->setVal( 'error', wfMessage( 'permissionserrors' )->escaped() );
			return;
		}

		$targetUser = User::newFromName( $this->request->getVal( 'target' ) );
		if ( $targetUser && $targetUser->getId() !== 0 ) {
			$userIdentityBox = new UserIdentityBox( $targetUser );
			$userIdentityBox->clearMastheadContents();
			$this->clearCaches( $targetUser );

			$this->response->setVal( 'success', wfMessage( 'user-identity-box-clear-success' )->escaped() );
			BannerNotificationsController::addConfirmation( wfMessage( 'user-identity-box-clear-success' )->escaped() );
		} else {
			// this user does not exist or is an anon - can't clear masthead contents
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_NOT_FOUND );
			$this->response->setVal( 'error', wfMessage( 'user-identity-box-clear-notarget' )->escaped() );
		}
	}

	/**
	 * Checks whether the current user is the owner of the specified user's
	 * profile
	 * @param User $user
	 * @returns boolean
	 */
	private function isOwner( User $user ) : bool {
		return !$user->isAnon() && $user->getId() == $this->wg->User->getId();
	}

	/**
	 * Checks whether the current user can edit a specified user's profile
	 * @param User $user
	 * @returns boolean
	 */
	private function canEdit( User $user ) : bool {
		$sessionUser = $this->wg->User;

		// Staff users bypass further checks.
		if ( $sessionUser->isStaff() ) {
			return true;
		}

		// Users with elevated privileges bypass further checks.
		if ( $sessionUser->isAllowed( 'editprofilev3' ) ) {
			return true;
		}

		// Blocked users are... blocked...
		if ( $sessionUser->isBlocked( true, false ) || $sessionUser->isBlockedGlobally() ) {
			return false;
		}

		// Check for revoked edit rights.
		if ( ! $sessionUser->isAllowed( 'edit' ) ) {
			return false;
		}

		// And finally, limit profile editing to the owners.
		return $this->isOwner( $user );
	}
}
