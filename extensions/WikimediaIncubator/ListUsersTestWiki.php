<?php

/**
 * Ability to filter list of users based on their test wiki preference
 */
class ListUsersTestWiki {
	/**
	 * If the &testwiki= parameter matches the project site (Incubator), return that
	 * @return Array or null
	 */
	static function getProjectInput() {
		global $wmincProjectSite, $wgRequest;
		$input = strtolower( $wgRequest->getVal( 'testwiki' ) );
		if( $input == strtolower( $wmincProjectSite['name'] ) || $input == strtolower( $wmincProjectSite['short'] ) ) {
			return $wmincProjectSite;
		}
		return null;
	}

	/**
	 * Input form
	 */
	static function onSpecialListusersHeaderForm( $pager, &$out ) {
		$testwiki = IncubatorTest::getUrlParam();
		$project = self::getProjectInput();
		$input = $project ? $project['name'] : ( $testwiki ? $testwiki['prefix'] : null );
		$out .= Xml::label( wfMsg( 'wminc-testwiki' ), 'testwiki' ) . ' ' .
			Xml::input( 'testwiki', 20, $input, array( 'id' => 'testwiki' ) ) . '<br />';
		return true;
	}

	/**
	 * Show a message that you are viewing a list of users of a certain test wiki
	 * @param $pager
	 * @param $out
	 * @return bool
	 */
	static function onSpecialListusersHeader( $pager, &$out ) {
		$project = self::getProjectInput();
		if( $project ) {
			$out .= wfMsgWikiHtml( 'wminc-listusers-testwiki', '"' . $project['name'] . '"' );
		} else {
			$testwiki = IncubatorTest::getUrlParam();
			if ( $testwiki ) {
				$link = Linker::linkKnown( Title::newFromText( $testwiki['prefix'] ) );
				$out .= wfMsgWikiHtml( 'wminc-listusers-testwiki', $link );
			}
		}
		return true;
	}

	/**
	 * Query
	 */
	static function onSpecialListusersQueryInfo( $pager, &$query ) {
		$testwiki = IncubatorTest::getUrlParam();
		$project = self::getProjectInput();
		if( !$project && !$testwiki ) {
			return true; # no input or invalid input
		}
		global $wmincPref;
		$query['tables']['p1'] = 'user_properties';
		$query['join_conds']['p1'] = array( 'JOIN', array( 'user_id=p1.up_user',
			'p1.up_property' => "$wmincPref-project",
			'p1.up_value' => $project ? $project['short'] : $testwiki['project']
		) );
		if( $project ) {
			return true; # project site doesn't need language code = returning
		}
		$query['tables']['p2'] = 'user_properties';
		$query['join_conds']['p2'] = array( 'JOIN', array( 'user_id=p2.up_user',
			'p2.up_property' => "$wmincPref-code",
			'p2.up_value' => $testwiki['lang']
		) );
		return true;
	}
}
