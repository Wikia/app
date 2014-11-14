<?php

	class CustomizeToolbarUserCommand extends UserCommand {

		protected $overflow = false;
		protected $defaultRenderType = 'customize';

		protected function buildData() {
			global $wgUser;
			$this->available = !$wgUser->isAnon();
			$this->enabled = true;
			$this->imageSprite = 'share';
			$this->caption = wfMessage('user-tools-customize')->text();
			$this->linkClass = 'tools-customize';
		}

		protected function renderIcon() {
			global $wgBlankImgUrl;
			return "<img src=\"$wgBlankImgUrl\" class=\"sprite gear\" height=\"16\" width=\"16\" />";
		}

		protected function getTrackerName() {
			return 'customize';
		}

	}
