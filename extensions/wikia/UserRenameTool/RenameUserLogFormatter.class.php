<?php
class RenameUserLogFormatter {
	const COMMUNITY_CENTRAL_CITY_ID = 177;

	// 13 usages
	static public function getCommunityUser( $name, $noRedirect = false ) {
		if ( is_int( $name ) ) {
			$name = User::whoIs( $name );
		}

		$title = GlobalTitle::newFromText( $name, NS_USER, self::COMMUNITY_CENTRAL_CITY_ID );

		return Xml::element(
			'a',
			array( 'href' => $title->getFullURL( $noRedirect ? 'redirect=no' : '') ),
			$name,
			false
		);
	}

	// 3 usages
	static protected function getCommunityTask( $taskId ) {
		$title = GlobalTitle::newFromText( 'Tasks/log', NS_SPECIAL, self::COMMUNITY_CENTRAL_CITY_ID );

		return Xml::element(
			'a',
			['href' => $title->getFullURL( ['id' => $taskId] )],
			"#{$taskId}",
			false
		);
	}

	// 2 usages
	static public function getCityLink( $cityId ) {
		global $wgCityId, $wgSitename;

		$domains = WikiFactory::getDomains( $cityId );

		if ( $wgCityId == $cityId ) {
			// Hack based on the fact we should only ask for current wiki's sitename
			$text = $wgSitename;
		} else {
			// The fallback to return anything
			$text = "[" . WikiFactory::IDtoDB( $cityId ) . ":{$cityId}]";
		}

		if ( !empty( $domains ) ) {
			$text = Xml::tags( 'a', array( "href" => "http://" . $domains[0] ), $text );
		}

		return $text;
	}

	static public function getLog( $message, $requestor, $oldUsername, $newUsername, $reason, $tasks = [] ) {
		foreach ( $tasks as $key => $value ) {
			$tasks[$key] = self::getCommunityTask( $value );
		}

		return wfMessage(
			$message,
			self::getCommunityUser( $requestor ),
			self::getCommunityUser( $oldUsername, true ),
			self::getCommunityUser( $newUsername ),
			$tasks ? implode( ', ', $tasks ) : '-',
			$reason
		)->escaped();
	}

	// 3 usages
	static public function wiki( $requestor, $oldUsername, $newUsername, $cityId, $reason, $problems = false ) {
		$text = wfMessage(
			$problems ? 'userrenametool-info-wiki-finished-problems' : 'userrenametool-info-wiki-finished',
			self::getCommunityUser( $requestor ),
			self::getCommunityUser( $oldUsername, true ),
			self::getCommunityUser( $newUsername ),
			self::getCityLink( $cityId ),
			$reason
		)->escaped();

		return $text;
	}
}
