<?php

	class PageActionUserCommand extends UserCommand {

		static protected $pageActionsMap = array(
			'Delete' => array(
				'source' => 'content_actions',
				'action' => 'delete',
				'message' => 'delete',
			),
			'Edit' => array(
				'source' => 'content_actions',
				'action' => 'edit',
				'message' => 'edit',
			),
			'History' => array(
				'source' => 'content_actions',
				'action' => 'history',
				'message' => 'history_short',
			),
			'Move' => array(
				'source' => 'content_actions',
				'action' => 'move',
				'message' => 'move',
			),
			'Whatlinkshere' => array(
				'source' => 'nav_urls',
				'action' => 'whatlinkshere',
				'message' => 'whatlinkshere',
			),
			'Protect' => array(
				'source' => 'content_actions',
				'actions' => array( 'protect', 'unprotect' ),
				'message' => 'protect',
				'abstractCaption' => 'protect',
			),
		);

		public function buildData() {
			if ( !isset(self::$pageActionsMap[$this->name]) ) {
				return;
			}

			self::needSkinData();

			$pageActionInfo = self::$pageActionsMap[$this->name];
			$this->caption = wfMsg( $pageActionInfo['message'] );

			// support two-state page actions like protect/unprotect
			if (!isset($pageActionInfo['action'])) {
				foreach ($pageActionInfo['actions'] as $action) {
					if ( !empty(self::$skinData[$pageActionInfo['source']][$action]) ) {
						$pageActionInfo['action'] = $action;
						break;
					}
				}
				if ( !isset($pageActionInfo['action'])) {
					return;
				}
			}

			if ( empty(self::$skinData[$pageActionInfo['source']][$pageActionInfo['action']]) ) {
				return;
			}

			$action = self::$skinData[$pageActionInfo['source']][$pageActionInfo['action']];
			if ( empty($action['text']) ) {
				$action['text'] = wfMsg( $pageActionInfo['message'] );
			}
			$this->available = true;
			$this->enabled = true;
			$this->caption = $action['text'];
			$this->description = $action['text'];
			$this->href = $action['href'];
		}

		protected function getAbstractCaption() {
			if (isset(self::$pageActionsMap[$this->name]) && isset(self::$pageActionsMap[$this->name]['abstractCaption'])) {
				return wfMsg(self::$pageActionsMap[$this->name]['abstractCaption']);
			}
			return parent::getAbstractCaption();
		}

	}
