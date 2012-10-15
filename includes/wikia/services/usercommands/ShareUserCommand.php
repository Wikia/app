<?php

	class ShareUserCommand extends UserCommand {

		protected $defaultRenderType = 'share';

		protected function buildData() {
			global $wgTitle;

			$namespace = $wgTitle->getNamespace();

			// Disable share on talk pages
			if ($wgTitle->isTalkPage() || $namespace == NS_USER_TALK) {
				return;
			}

			$this->available = true;
			$this->enabled = true;

			$this->listItemId = "ca-share_feature";
			$this->imageSprite = 'share';
			$this->linkId = "control_share_feature";
			$this->caption = wfMsg('oasis-share');
		}

		protected function getAbstractCaption() {
			return wfMsg('oasis-share');
		}

		protected function getAbstractDescription() {
			return wfMsg('oasis-share-desc');
		}

	}
