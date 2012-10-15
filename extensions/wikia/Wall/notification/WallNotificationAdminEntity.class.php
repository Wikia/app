<?php


class WallNotificationAdminEntity {
	public function __construct($wikiId, $userIdRemoving, $userIdWallOwner, $title, $url, $messageId, $parentId, $isReply, $reason) {
		$app = F::App();
		
		$this->data = null;
		
		$this->data->type = 'ADMIN';
		
		$this->data->wiki_id = $wikiId;
		
		$this->data->timestamp = $app->wf->TimestampNow();
		$this->data->url = $url;
		$this->data->title = $title;
		$this->data->user_removing_id = $userIdRemoving;
		$this->data->user_wallowner_id = $userIdWallOwner;
		$this->data->message_id = $messageId;
		$this->data->is_reply = $isReply;
		if( $parentId == 0 ) {
			$this->data->hide_for_userid = array( $userIdRemoving => true );
		} else {
			$this->data->hide_for_userid = array( $userIdRemoving => true, $userIdWallOwner => true );
		}
		
		$this->data->parent_id = $parentId;
		$this->data->reason = $reason;
		
	}
}