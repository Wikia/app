<?php


class WallNotificationOwnerEntity {
	public function __construct($wikiId, $userIdRemoving, $userIdWallOwner, $title, $url, $messageId, $parentId, $isReply, $reason) {
		$app = F::App();
		
		$this->data = new stdClass;
		
		$this->data->type = 'OWNER';
		
		$this->data->wiki_id = $wikiId;
		
		$this->data->timestamp = wfTimestampNow();
		$this->data->url = $url;
		$this->data->title = $title;
		$this->data->user_removing_id = $userIdRemoving;
		$this->data->user_wallowner_id = $userIdWallOwner;
		$this->data->message_id = $messageId;
		$this->data->is_reply = $isReply;
		$this->data->hide_for_userid = array( $userIdRemoving, $userIdWallOwner );
		$this->data->parent_id = $parentId;
		$this->data->reason = $reason;
		
	}
}