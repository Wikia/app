<?php
class RenameUserLogFormatter {
	const COMMUNITY_CENTRAL_CITY_ID = 177;

	// 7 usages
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

	static public function getLog( $message, $requestor, $oldUsername, $newUsername, $reason, $tasks = [] ) {
		foreach ( $tasks as $key => $value ) {
			$title = GlobalTitle::newFromText( 'Tasks/log', NS_SPECIAL, self::COMMUNITY_CENTRAL_CITY_ID );

			$tasks[$key] = Xml::element(
				'a',
				['href' => $title->getFullURL( ['id' => $value] )],
				"#{$value}",
				false
			);
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
			WikiFactory::getCityLink( $cityId ),
			$reason
		)->escaped();

		return $text;
	}
}
