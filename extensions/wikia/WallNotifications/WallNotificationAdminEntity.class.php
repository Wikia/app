<?php


class WallNotificationAdminEntity {
	public function __construct( $wikiId, $data ) {
		$this->data = new stdClass;

		$this->data->type = 'ADMIN';

		$this->data->wiki_id = $wikiId;
		$this->data->parent_page_id = $data['parentPageId'];
		$this->data->timestamp = wfTimestampNow();
		$this->data->url = $data['url'];
		$this->data->title = $data['title'];
		$this->data->user_removing_id = $data['userIdRemoving'];
		$this->data->user_wallowner_id = $data['userIdWallOwner'];
		$this->data->message_id = $data['messageId'];
		$this->data->is_reply = $data['isReply'];
		if ( $data['parentId'] == 0 ) {
			$this->data->hide_for_userid = [ $data['userIdRemoving'] => true ];
		} else {
			$this->data->hide_for_userid = [ $data['userIdRemoving'] => true, $data['userIdWallOwner'] => true ];
		}

		$this->data->parent_id = $data['parentId'];
		$this->data->reason = $data['reason'];

	}

	public function getData() {
		return $this->data;
	}
}
