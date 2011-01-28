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
				'message' => 'history',
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
		);
		
		public function buildData() {
			global $wgUser, $wgTitle;
			
			if ( !isset(self::$pageActionsMap[$this->name]) ) {
				return;
			}
			
			self::needSkinData();
			
			$pageActionInfo = self::$pageActionsMap[$this->name];
			$this->caption = wfMsg( $pageActionInfo['message'] );
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
				
	}
	