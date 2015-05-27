<?php


class WallNotificationOwnerEntity {
	public function __construct( $wikiId, $data ) {
		$this->data = new stdClass;

		$this->data->type = 'OWNER';

		$this->data->wiki_id = $wikiId;

		$this->data->timestamp = wfTimestampNow();
		$this->data->url = $data['url'];
		$this->data->title = $data['title'];
		$this->data->user_removing_id = $data['userIdRemoving'];
		$this->data->user_wallowner_id = $data['userIdWallOwner'];
		$this->data->message_id = $data['messageId'];
		$this->data->is_reply = $data['isReply'];
		$this->data->hide_for_userid = [ $data['userIdRemoving'], $data['userIdWallOwner'] ];
		$this->data->parent_id = $data['parentId'];
		$this->data->reason = $data['reason'];

	}
}
