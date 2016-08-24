<?php
use \Wikia\DependencyInjection\Injector;
use \Wikia\Service\User\Permissions\PermissionsService;

/**
 * Class for handling user "tags" logic in user masthead
 * @class UserTagsStrategy
 */
class UserTagsStrategy extends WikiaObject {

	/** @var int MAX_USER_TAGS Positive even integer indicating at most how many user tags can be shown */
	const MAX_USER_TAGS = 2;

	/** @var array GLOBAL_GROUPS_RANK Global groups that should be shown in masthead, in order of importance  */
	const GLOBAL_GROUPS_RANK = [
		'staff',
		'helper',
		'vstf',
		'voldev',
		'wikiastars',
		'vanguard',
		'council',
	];

	/** @var array LOCAL_GROUPS_RANK Local groups that should be shown in masthead, in order of importance  */
	const LOCAL_GROUPS_RANK = [
		'bureaucrat',
		'sysop',
		'content-moderator',
		'threadmoderator',
		'chatmoderator',
	];

	/** @var string[] List of explicit global groups this user belongs to */
	protected $usersGlobalGroups = [];

	/** @var string[] List of explicit local groups this user belongs to */
	protected $usersLocalGroups = [];

	/** @var array $globalGroupsWithTags Global groups of this user that have an associated user tag */
	protected $globalGroupsWithTags = [];

	/** @var array $localGroupsWithTags Local groups of this user that have an associated user tag */
	protected $localGroupsWithTags = [];

	/** @var User $user The user whose masthead we are rendering */
	protected $user = null;

	/**
	 * UserTagsStrategy constructor.
	 * @param User $user The user whose masthead we are rendering
	 */
	public function __construct( User $user ) {
		parent::__construct();
		/** @var PermissionsService $permissionsService */
		$permissionsService = Injector::getInjector()->get( PermissionsService::class );

		$this->usersGlobalGroups = $permissionsService->getExplicitGlobalGroups( $user );
		$this->usersLocalGroups = $permissionsService->getExplicitLocalGroups( $user );
		$this->globalGroupsWithTags = array_intersect( static::GLOBAL_GROUPS_RANK, $this->usersGlobalGroups );
		$this->localGroupsWithTags = array_intersect( static::LOCAL_GROUPS_RANK, $this->usersLocalGroups );
		$this->user = $user;
	}

	/**
	 * Returns if the "BLOCKED" tag should be shown
	 * i.e. if the user is blocked globally or locally, and isn't a staff member
	 * @return bool Whether to display the tag
	 */
	protected function shouldShowBlockedTag() {
		if ( in_array( 'staff', $this->usersGlobalGroups ) ) {
			return false;
		}

		// check if the user is blocked locally, if not, also check if they're blocked globally (via Phalanx)
		if ( $this->user->isBlocked( true /* use slave DB */, false /* don't log in PhalanxStats */ ) ||
			$this->user->isBlockedGlobally()
		) {
			return true;
		}

		return false;
	}

	/**
	 * Returns if the "FOUNDER" tag should be displayed
	 * i.e. if the user founded the wiki and is still a bureaucrat or admin
	 * @return boolean
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	protected function shouldShowFounderTag() {
		$wiki = WikiFactory::getWikiByID( $this->wg->CityId );
		if ( intval( $wiki->city_founding_user ) === $this->user->getId() ) {
			// mech: BugId 18248
			return !empty( array_intersect( [ 'bureaucrat', 'sysop' ], $this->usersLocalGroups ) );
		}

		return false;
	}

	/**
	 * Returns if the "BANNED FROM CHAT" tag should be displayed
	 * i.e. if the user is banned from chat
	 * @return boolean
	 */
	protected function shouldShowBannedFromChatTag() {
		return $this->wg->EnableChat && ( new ChatUser( $this->user ) )->isBanned();
	}

	/**
	 * Tries to get at most $requested user tags for this user's global groups
	 * @param int $requested Display at most this many global tags
	 * @return array Text of the tags, safe for HTML output
	 */
	protected function getGlobalTags( $requested = 1 ) {
		$tags = [];
		// Don't try to show too many tags
		$count = min( $requested, static::MAX_USER_TAGS, count( $this->globalGroupsWithTags ) );
		for ( $i = 0; $i < $count; $i++ ) {
			switch ( array_shift( $this->globalGroupsWithTags ) ) {
				case 'staff':
					$tags[] = wfMessage( 'user-identity-box-group-staff' )->escaped();
					break;
				case 'helper':
					$tags[] = wfMessage( 'user-identity-box-group-helper' )->escaped();
					break;
				case 'vstf':
					$tags[] = wfMessage( 'user-identity-box-group-vstf' )->escaped();
					break;
				case 'voldev':
					$tags[] = wfMessage( 'user-identity-box-group-voldev' )->escaped();
					break;
				case 'wikiastars':
					$tags[] = wfMessage( 'user-identity-box-group-wikiastars' )->escaped();
					break;
				case 'vanguard':
					$tags[] = wfMessage( 'user-identity-box-group-vanguard' )->escaped();
					break;
				case 'council':
					$tags[] = wfMessage( 'user-identity-box-group-council' )->escaped();
					break;
			}
		}

		return $tags;
	}

	/**
	 * Tries to get at most $requested user tags for this user's local groups
	 * @param int $requested Display at most this many local tags
	 * @return string Text of the tag, safe for HTML output
	 */
	protected function getLocalTags( $requested = 1 ) {
		$tags = [];
		// Don't try to show too many tags
		$count = min( $requested, static::MAX_USER_TAGS, count( $this->localGroupsWithTags ) );
		for ( $i = 0; $i < $count; $i++ ) {
			switch ( array_shift( $this->localGroupsWithTags ) ) {
				case 'bureaucrat':
					$tags[] = wfMessage( 'user-identity-box-group-bureaucrat' )->escaped();
					break;
				case 'sysop':
					$tags[] = wfMessage( 'user-identity-box-group-sysop' )->escaped();
					break;
				case 'content-moderator':
					$tags[] = wfMessage( 'user-identity-box-group-content-moderator' )->escaped();
					break;
				case 'threadmoderator':
					$tags[] = wfMessage( 'user-identity-box-group-threadmoderator' )->escaped();
					break;
				case 'chatmoderator':
					$tags[] = wfMessage( 'user-identity-box-group-chatmoderator' )->escaped();
					break;
			}
		}

		// The founder tag overrides the least important local tag,
		// since it is not an user group but a wiki setting
		if ( $this->shouldShowFounderTag() ) {
			$tags[$count - 1] = wfMessage( 'user-identity-box-founder' )->escaped();
		}

		if ( $this->shouldShowBannedFromChatTag() ) {
			// If we have enough tags, overwrite the last one, otherwise append
			$index = $count === $requested ? $count - 1 : $count;
			$tags[$index] = wfMessage( 'user-identity-box-banned-from-chat' )->escaped();
		}

		return $tags;
	}

	/**
	 * Returns the user tags that should be displayed
	 * @return array The list of user tags to be shown
	 */
	public function getUserTags() {
		if ( $this->shouldShowBlockedTag() ) {
			return [
				wfMessage( 'user-identity-box-blocked' )->escaped()
			];
		}

		$allGlobalTags = count( $this->globalGroupsWithTags );
		$allLocalTags = count( $this->localGroupsWithTags );
		// If there are enough local tags, try to distribute global and local tags evenly
		if ( $allLocalTags >= static::MAX_USER_TAGS / 2 ) {
			$globalTagCount = static::MAX_USER_TAGS / 2;
		} else {
			// If there aren't enough local tags, try to render more global tags
			$globalTagCount = static::MAX_USER_TAGS - $allLocalTags;
		}

		// If there are enough global tags, try to distribute global and local tags evenly
		if ( $allGlobalTags >= static::MAX_USER_TAGS / 2 ) {
			$localTagCount = static::MAX_USER_TAGS / 2;
		} else {
			// If there aren't enough global tags, try to render more local tags
			$localTagCount = static::MAX_USER_TAGS - $allGlobalTags;
		}

		return array_merge(
			$this->getGlobalTags( $globalTagCount ),
			$this->getLocalTags( $localTagCount )
		);
	}
}
