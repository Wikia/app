<?php

class CommunityPageSpecialCommunityTodoListModel {
	public function getData() {
		$messageKey = 'community-to-do-list';
		$message = wfMessage( $messageKey );
		$title = Title::newFromText( $messageKey, NS_MEDIAWIKI );
		$data = [
			'haveContent' => false,
			'editUrl' => $title->getFullURL( ['action' => 'edit'] ),
		];

		if ( !$message->isDisabled() ) {
			$data['haveContent'] = true;
			$data['data'] = $message->parse();
		}

		return $data;
	}
}
