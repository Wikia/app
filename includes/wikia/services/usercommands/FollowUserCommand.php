<?php

	class FollowUserCommand extends UserCommand {
		
		protected function buildData() {
			$mode = '';
			if(isset(self::$skinData['content_actions']['watch'])) {
				$follow = self::$skinData['content_actions']['watch'];
				$mode = 'watch';
			} else if(isset(self::$skinData['content_actions']['unwatch'])) {
				$follow = self::$skinData['content_actions']['unwatch'];
				$mode = 'unwatch';
			}
			if (!$mode) {
				return;
			}
			
			$this->available = true;
			$this->enabled = true;
			
			$this->href = $follow['href'];
			$this->imageSprite = 'follow';
			$this->accessKey = 'w';
			$this->linkId = "ca-" . $mode;
			$this->caption = $follow['text'];
		}
				
		protected function getAbstractCaption() {
			return wfMsg('oasis-follow');
		}
		
		protected function getAbstractDescription() {
			return wfMsg('oasis-follow-desc');
		}
		
		
	}
	