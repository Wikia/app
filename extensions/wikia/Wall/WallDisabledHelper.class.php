<?php

class WallDisabledHooksHelper {
	const wallEnableVarName = 'wgEnableWallExt';
	const wallCopyFollowFlag = 'wgWallCopyFollowsHasBeenFiredBefore';
	
	/** @brief Allows to edit or not archived talk pages and its subpages
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 * 
	 * @return boolean true -- because it's a hook
	 */
	public function onAfterEditPermissionErrors($permErrors, $title, $removeArray) {
		$app = F::App();

		if( empty($app->wg->EnableWallExt) && 
			($title->getNamespace() == NS_USER_WALL 
			|| $title->getNamespace() == NS_USER_WALL_MESSAGE
			|| $title->getNamespace() == NS_USER_WALL_MESSAGE_GREETING
		)) {
			$permErrors[] = array(
				0 => 'protectedpagetext',
				1 => 'archived'
			);
		}
		
		return true;
	}
	
	/**
	 * @brief Hook fired after change in WikiFactory
	 * 
	 * @desc If wall is turned on add a task which will copy follows
	 * 
	 * @param string $wikiName
	 * @param integer $wikiId
	 * @param boolean $value
	 * 
	 * @return boolean true
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onWikiFactoryChanged($varName, $wikiId, $value) {
		$value = (bool) $value;
		
		if( $varName === self::wallEnableVarName && $value === true ) {
			$hasTheTaskBeenFiredBefore = WikiFactory::getVarValueByName(self::wallCopyFollowFlag, $wikiId);
			
			if( empty($hasTheTaskBeenFiredBefore) ) {
				$task = new WallCopyFollowsTask();
				$task->createTask(array('wiki_id' => $wikiId), TASK_QUEUED);
				$task->addLog("WallCopyFollows task created with ID ".$task->getID());
				$result = @WikiFactory::setVarByName(self::wallCopyFollowFlag, $wikiId, true);
				
				if( !$result ) {
					$task->addLog('WallCopyFollows task created ('.$task->getID().') but WikiFactory variable ('.self::wallCopyFollowFlag.') wasn\'t found in DB');
				}
			} else {
				//the copy follows task has been fired before
				//we want to copy follows only when wall was 
				//enabled by the first time
			}
		}
		
		return true;
	}
	
	public function onWatchArticle(&$user, &$article) {
		$app = F::app();
		$title = $article->getTitle();
		
		if( $title->getNamespace() == NS_USER_TALK && strpos($title->getText(), '/') === false ) {
			$this->processActionOnWatchlist($user, $title->getText(), 'add');
		}
		
		return true;
	}
	
	public function onUnwatchArticle(&$user, &$article) {
		$app = F::app();
		$title = $article->getTitle();
		
		if( $title->getNamespace() == NS_USER_TALK && strpos($title->getText(), '/') === false ) {
			$this->processActionOnWatchlist($user, $title->getText(), 'remove');
		}
		
		return true;
	}
	
	private function processActionOnWatchlist($user, $followedUserName, $action) {
		$followedUser = User::newFromName($followedUserName);
		
		if( $followedUser instanceof User ) {
			$watchTitles = array(
				Title::newFromText($followedUser->getTitleKey(), NS_USER_WALL),
				Title::newFromText($followedUser->getTitleKey(), NS_USER_WALL_MESSAGE),
			);
			
			foreach($watchTitles as $watchTitle) {
				if( $watchTitle instanceof Title ) {
					$wl = new WatchedItem;
					$wl->mTitle = $watchTitle;
					$wl->id = $user->getId();
					$wl->ns = $watchTitle->getNamespace();
					$wl->ti = $watchTitle->getDBkey();
					
					if( $action === 'add' ) {
						$wl->addWatch();
					} elseif( $action === 'remove' ) {
						$wl->removeWatch();
					}
				} else {
				//just-in-case -- it shouldn't happen but if it does we want to know about it
					Wikia::log( __METHOD__, false, 'WALL_HOOK_ERROR: No title instance while syncing follows. User name: '.$followedUserName);
				}
			}
		} else {
		//just-in-case -- it shouldn't happen but if it does we want to know about it
			Wikia::log( __METHOD__, false, 'WALL_HOOK_ERROR: No user instance while syncing follows. User name: '.$followedUserName);
		}
	}
	
}
