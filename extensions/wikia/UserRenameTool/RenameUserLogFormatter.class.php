<?php
class RenameUserLogFormatter {
	const COMMUNITY_CENTRAL_CITY_ID = 177;

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
			User::getLinkToUserPageOnCommunityWiki( $requestor ),
			User::getLinkToUserPageOnCommunityWiki( $oldUsername, true ),
			User::getLinkToUserPageOnCommunityWiki( $newUsername ),
			$tasks ? implode( ', ', $tasks ) : '-',
			$reason
		)->escaped();
	}

	static public function getLogForWiki($requestor, $oldUsername, $newUsername, $cityId, $reason, $problems = false ) {
		$text = wfMessage(
			$problems ? 'userrenametool-info-wiki-finished-problems' : 'userrenametool-info-wiki-finished',
			User::getLinkToUserPageOnCommunityWiki( $requestor ),
			User::getLinkToUserPageOnCommunityWiki( $oldUsername, true ),
			User::getLinkToUserPageOnCommunityWiki( $newUsername ),
			WikiFactory::getCityLink( $cityId ),
			$reason
		)->escaped();

		return $text;
	}
}
