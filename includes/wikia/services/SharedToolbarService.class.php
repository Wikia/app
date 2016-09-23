<?php

class SharedToolbarService extends ToolbarService {

	static protected $recursiveBarrier = 0;

	public function __construct() {
		self::$recursiveBarrier++;
		parent::__construct();
		if ( self::$recursiveBarrier <= 1 ) {
			$this->updatePromotions();
		}
		self::$recursiveBarrier--;
	}

	public function getVisibleList() {
		$list = $this->getCurrentList();
		$list[] = $this->buildListItem( 'Action:CustomizeToolbar' );
		return $list;
	}

	public function getCurrentList() {
		$data = $this->loadToolbarList();
		if ( $data == false ) {
			$data = $this->getDefaultList();
			if ( isset( $data['my-tools'] ) ) {
				$data['my-tools']['items'] = array_merge( $this->importMyTools(), $data['my-tools']['items'] );
			}
		}

		$data = $this->stringsToList( $data );

		return $data;
	}

	public function getDefaultList() {
		global $wgUser;

		$data = array(
			$this->buildListItem( 'PageAction:Follow' ),
		);

		if ( !$wgUser->isAnon() ) {
			$data['my-tools'] = $this->buildMenuListItem( 'my-tools', array_merge(
				array(
					$this->buildListItem( 'PageAction:History' ),
					$this->buildListItem( 'PageAction:Whatlinkshere' ),
				),
				$this->stringsToList( $this->getSeenPromotions() )
			) );
		}

		$data = $this->stringsToList( $data );

		return $data;
	}

	public function getPopularList() {
		return $this->stringsToList( array_merge( $this->getPopularOptionNames(), $this->getSeenPromotions() ) );
	}

	public function getAllList() {
		return $this->stringsToList( $this->getAllOptionNames() );
	}


	public function getPromotions() {
		return array(
			'SpecialPage:ThemeDesigner',
			'SpecialPage:LayoutBuilder',
		);
	}

	public function getAllOptionNames() {
		return array(
			'PageAction:Follow',
			'PageAction:History',
			'PageAction:Move',
			'PageAction:Delete',
			'PageAction:Edit',
			'PageAction:Protect',
			'PageAction:Whatlinkshere',
			'SpecialPage:AllPages',
			'SpecialPage:PrefixIndex',
			'SpecialPage:Block',
			'SpecialPage:BlockList',
			'SpecialPage:BrokenRedirects',
			'SpecialPage:Categories',
			'SpecialPage:CategoryTree',
			'SpecialPage:Contact',
			'SpecialPage:Contributions',
			'SpecialPage:DeadendPages',
			'SpecialPage:DeletedContributions',
			'SpecialPage:Disambiguations',
			'SpecialPage:DoubleRedirects',
			'SpecialPage:FileDuplicateSearch',
			'SpecialPage:Editcount',
			'SpecialPage:Export',
			'SpecialPage:LinkSearch',
			'SpecialPage:ListFiles',
			'SpecialPage:FilePath',
			'SpecialPage:Import',
			'SpecialPage:Insights',
			'SpecialPage:Log',
			'SpecialPage:LongPages',
			'SpecialPage:MIMESearch',
			'SpecialPage:MostLinkedCategories',
			'SpecialPage:MostLinkedPages',
			'SpecialPage:MostLinkedFiles',
			'SpecialPage:MostLinkedTemplates',
			'SpecialPage:Mostpopularcategories',
			'SpecialPage:NewPages',
			'SpecialPage:Images',
			'SpecialPage:AncientPages',
			'SpecialPage:LonelyPages',
			'SpecialPage:FewestRevisions',
			'SpecialPage:MostCategories',
			'SpecialPage:MostRevisions',
			'SpecialPage:WithoutInterwiki',
			'SpecialPage:ProtectedPages',
			'SpecialPage:ProtectedTitles',
			'SpecialPage:RecentChanges',
			'SpecialPage:ListRedirects',
			'SpecialPage:RecentChangesLinked',
			'SpecialPage:Undelete',
			'SpecialPage:Search',
			'SpecialPage:ShortPages',
			'SpecialPage:SpecialPages',
			'SpecialPage:AllMessages',
			'SpecialPage:TagsReport',
			'SpecialPage:UncategorizedCategories',
			'SpecialPage:UncategorizedFiles',
			'SpecialPage:UncategorizedPages',
			'SpecialPage:UncategorizedTemplates',
			'SpecialPage:UnusedCategories',
			'SpecialPage:UnusedFiles',
			'SpecialPage:UnusedTemplates',
			'SpecialPage:UnwatchedPages',
			'SpecialPage:MultipleUpload',
			'SpecialPage:Upload',
			'SpecialPage:ListGroupRights',
			'SpecialPage:UserRights',
			'SpecialPage:ListUsers',
			'SpecialPage:Version',
			'SpecialPage:WantedCategories',
			'SpecialPage:WantedFiles',
			'SpecialPage:WantedPages',
			'SpecialPage:WantedTemplates',
			'SpecialPage:Watchlist',
			'SpecialPage:Leaderboard',
			'SpecialPage:CreatePage',
			'SpecialPage:Preferences',
			'SpecialPage:Random',
			'SpecialPage:WikiActivity',
			'SpecialPage:ThemeDesigner',
			'SpecialPage:LayoutBuilder',
			'SpecialPage:MyContributions',
			'SpecialPage:Statistics',
			'SpecialPage:WikiFactory',
			'SpecialPage:WikiFeatures',
			'Action:DevInfo' // a.k.a. PerformanceStats, BugId:5497
		);
	}

	public function getPopularOptionNames() {
		return array(
			'SpecialPage:CreatePage',
			'PageAction:Delete',
			'PageAction:Edit',
			'PageAction:Follow',
			'PageAction:History',
			'SpecialPage:Insights',
			'PageAction:Move',
			'SpecialPage:MyContributions',
			'SpecialPage:Random',
			'SpecialPage:RecentChanges',
			'SpecialPage:Upload',
			'PageAction:Whatlinkshere',
			'SpecialPage:WikiActivity',
		);
	}

	public function getBlacklist() {
		$out = array(
			'PageAction:Share',
			'SpecialPage:WikiaLabs',
		);
		// BugId:5497, blacklist DevInfo if not allowed
		if ( !F::app()->wg->user->isAllowed( 'performancestats' ) ) {
			$out[] = 'Action:DevInfo';
		}
		return $out;
	}

	protected function importMyTools() {
		global $wgUser;

		$list = array();
		$data = $wgUser->getGlobalPreference( 'myTools' );
		if ( is_string( $data ) ) {
			$data = json_decode( $data, true );
			foreach ( $data as $specialPage )
				$list[] = $this->buildListItem( "SpecialPage:{$specialPage}" );
		}

		return $list;
	}

}
