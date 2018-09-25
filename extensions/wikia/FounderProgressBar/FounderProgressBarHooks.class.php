<?php

/**
 * This class is a container for all the hooks we will use to capture actions/events for the Founder Progress Bar
 *
 */

class FounderProgressBarHooks {

	/** @var FounderProgressBarHooks $instance */
	private static $instance;

	/** @var FounderProgressBarModel $model */
	private $model;

	/** @var UpdateFounderProgressTask $task */
	private $task;
	
	/** @var bool $wasCompletionTaskFinished */
	private $wasCompletionTaskFinished;

	public function __construct( FounderProgressBarModel $model ) {
		$this->model = $model;
	}

	/**
	 * @desc Counts actions involve adding or editing articles
	 *
	 * @param WikiPage $article
	 * @return bool
	 */
	public function onArticleSaveComplete(
		WikiPage $article, User $user, $text, $summary, $minoredit, $watchthis, $sectionanchor,
		$flags, $revision, Status $status, $baseRevId
	): bool {

		// Quick exit if we are already done with Founder Progress Bar (memcache key set for 30 days)
		if ( $this->wasCompletionTaskFinished() ) {
			return true;
		}

		$title = $article->getTitle();
		$done = [];

		if ( $flags & EDIT_NEW ) {
			// Tasks related to adding new pages X (do not count auto generated user pages or categories or files or ...)
			if ( $title->getNamespace() == NS_MAIN ) {
				$done[] = FounderTask::TASKS['FT_PAGE_ADD_10'];
				$done[] = FounderTask::TASKS['FT_PAGE_ADD_20'];
				$done[] = FounderTask::TASKS['FT_BONUS_PAGE_ADD_5'];
			}
			// if blogpost
			if ( defined( 'NS_BLOG_ARTICLE' ) && $title->getNamespace() == NS_BLOG_ARTICLE ) {
				$done[] = FounderTask::TASKS['FT_BLOGPOST_ADD'];
			}

			// edit profile page X
			if ( $title->getNamespace() == NS_USER && $title->getText() == $user->getName() ) {
				$done[] = FounderTask::TASKS['FT_PROFILE_EDIT'];
			}
		}

		// Tasks related to updating existing pages
		if ( $flags & EDIT_UPDATE ) {

			// Tasks related to editing any article content X
			$done[] = FounderTask::TASKS['FT_TOTAL_EDIT_75'];
			$done[] = FounderTask::TASKS['FT_TOTAL_EDIT_300'];
			$done[] = FounderTask::TASKS['FT_BONUS_EDIT_50'];

			// if main page
			if ( $title->getArticleId() == Title::newMainPage()->getArticleId() ) {
				$done[] = FounderTask::TASKS['FT_MAINPAGE_EDIT'];

				// Is there a better way to detect if there's a slider on the main page?
				if ( stripos( $text, "slider" ) > 0 ) {
					$done[] = FounderTask::TASKS['FT_MAINPAGE_ADDSLIDER'];
				}
			}

			// Add a page to a category: this var is set by the Parser
			$categoryInserts = Wikia::getVar( 'categoryInserts' );
			if ( !empty( $categoryInserts ) ) {
				$done[] = FounderTask::TASKS['FT_CATEGORY_ADD_3'];
				$done[] = FounderTask::TASKS['FT_CATEGORY_ADD_5'];
			}

			// edit category page X
			if ( $title->getNamespace() == NS_CATEGORY ) {
				$done[] = FounderTask::TASKS['FT_CATEGORY_EDIT'];
			}

			// edit TOP_NAV Wiki-navigation X
			if ( $title->getNamespace() == NS_MEDIAWIKI &&
				 $title->getText() == "Wiki-navigation" ) {
				$done[] = FounderTask::TASKS['FT_TOPNAV_EDIT'];
			}

			// if commcorner X
			if ( $title->getNamespace() == NS_MEDIAWIKI &&
				 $title->getText() == "Community-corner" ) {
				$done[] = FounderTask::TASKS['FT_COMMCORNER_EDIT'];
			}

			// edit profile page X
			if ( $title->getNamespace() == NS_USER && $title->getText() == $user->getName() ) {
				$done[] = FounderTask::TASKS['FT_PROFILE_EDIT'];
			}

			// if page contains gallery tag
			if ( stripos( $text, "<gallery" ) !== false ) {
				$done[] = FounderTask::TASKS['FT_GALLERY_ADD'];
			}
		}

		$this->scheduleTasksUpdate( $done );

		return true;
	}

	/**
	 * @desc Counts the following actions
	 *
	 * Adding a photo
	 * @param UploadBase $image
	 * @return bool
	 */
	public function onUploadComplete ( UploadBase $image ): bool {
		// Quick exit if tasks are all completed
		if ( $this->wasCompletionTaskFinished() ) {
			return true;
		}

		// Any image counts for these
		$this->scheduleTasksUpdate( [
			FounderTask::TASKS['FT_PHOTO_ADD_10'],
			FounderTask::TASKS['FT_PHOTO_ADD_20'],
			FounderTask::TASKS['FT_BONUS_PHOTO_ADD_10'],
		] );

		return true;
	}

	/**
	 * @desc Counts the following actions
	 *
	 * uploading a new wordmark
	 *
	 */
	public function onUploadWordmarkComplete( &$image ) {
		// Quick exit if tasks are all completed
		if ( $this->wasCompletionTaskFinished() ) {
			return true;
		}

		$this->scheduleTasksUpdate( [ FounderTask::TASKS['FT_WORDMARK_EDIT'] ] );

		return true;
	}

	public function onAddNewAccount ($user) {

		// Quick exit if tasks are all completed
		if ($this->wasCompletionTaskFinished()) {
			return true;
		}

		$this->scheduleTasksUpdate( [ FounderTask::TASKS['FT_USER_ADD_5'] ] );

		return true;
	}

	// Initialize schema for a new wiki
	public function onWikiCreation( $params ) {

		// Always initialize for new wikis
		if ( isset( $params['city_id'] ) ) {
			self::initRecords( $params['city_id'] );
		}

		return true;
	}

	/**
	 * @desc Sends a request to update add video founder progress bar task
	 *
	 * @return bool true because it's a hook
	 */
	public function onAfterVideoFileUploaderUpload( File $file, FileRepoStatus $result ) {
		// Quick exit if tasks are all completed
		if ( $this->wasCompletionTaskFinished() ) {
			return true;
		}

		if ( $result->ok ) {
			$this->scheduleTasksUpdate( [ FounderTask::TASKS['FT_VIDEO_ADD'] ] );
		}

		return true;
	}

	// Initialize a scratch record for each of the initial available tasks
	public function initRecords( $wiki_id ) {
		global $wgExternalSharedDB, $wgMemc;

		$rows = [];

		foreach ( FounderTask::TASKS as $task_id ) {
			if ( $task_id < FounderProgressBarController::REGULAR_TASK_MAX_ID ) {
				$rows[] = [
					'wiki_id' => $wiki_id,
					'task_id' => $task_id
				];
			}
		}

		try {
			if ( !empty( $rows ) ) {
				// Records go into global wikicities table
				$dbw = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
				$dbw->insert( 'founder_progress_bar_tasks', $rows, __METHOD__ );
				$dbw->commit();
			}
		} catch ( DBError $ex ) {
			// SUS-4322 | DBError exceptions are logged by default
		}

		// also clear out any lingering memcache keys
		$wgMemc->delete(wfMemcKey('FounderLongTaskList'));
		$wgMemc->delete(wfMemcKey('FounderTasksComplete'));

	}

	/**
	 * Schedule an update for Founder Progress Bar.
	 * At most one background job will be scheduled per request to update the tasks at once.
	 *
	 * @param array $done founder tasks to be done in the background
	 */
	private function scheduleTasksUpdate( array $done ) {
		if ( !empty( $done ) ) {
			if ( !$this->task ) {
				$this->task = UpdateFounderProgressTask::newLocalTask();
				$this->task->call( 'doUpdate' );
				$this->task->queue();
			}

			foreach ( $done as $id ) {
				$this->task->pushTask( $id );
			}
		}
	}
	
	private function wasCompletionTaskFinished(): bool {
		if ( $this->wasCompletionTaskFinished === null ) {
			$this->wasCompletionTaskFinished = $this->model->wasCompletionTaskFinished();
		}
		
		return $this->wasCompletionTaskFinished;
	}

	public static function __callStatic( $name, $arguments ) {
		if ( !self::$instance ) {
			self::$instance = new self( new FounderProgressBarModel() );
		}

		return call_user_func_array( [ self::$instance, $name ], $arguments );
	}
}
