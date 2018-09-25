<?php

class FounderTask {

	const TASKS = [
		'FT_PAGE_ADD_10' => 10,
		'FT_THEMEDESIGNER_VISIT' => 20,
		'FT_MAINPAGE_EDIT' => 30,
		'FT_PHOTO_ADD_10' => 40,
		'FT_CATEGORY_ADD_3' => 50,
		'FT_COMMCENTRAL_VISIT' => 60,
		'FT_WIKIACTIVITY_VISIT' => 70,
		'FT_PROFILE_EDIT' => 80,
		'FT_PHOTO_ADD_20' => 90,
		'FT_TOTAL_EDIT_75' => 100,
		'FT_PAGE_ADD_20' => 110,
		'FT_CATEGORY_EDIT' => 120,
		'FT_WIKIALABS_VISIT' => 130,
		'FT_CATEGORY_ADD_5' => 150,
		'FT_GALLERY_ADD' => 170,
		'FT_TOPNAV_EDIT' => 180,
		'FT_MAINPAGE_ADDSLIDER' => 190,
		'FT_COMMCORNER_EDIT' => 200,
		'FT_VIDEO_ADD' => 210,
		'FT_USER_ADD_5' => 220,
		'FT_RECENTCHANGES_VISIT' => 230,
		'FT_WORDMARK_EDIT' => 240,
		'FT_MOSTVISITED_VISIT' => 250,
		'FT_BLOGPOST_ADD' => 270,
		'FT_FB_LIKES_3' => 280,
		'FT_UNCATEGORIZED_VISIT' => 290,
		'FT_TOTAL_EDIT_300' => 300,

		// Bonus tasks start at ID 500 just to keep them separate if we add more "base" tasks
		'FT_BONUS_PHOTO_ADD_10' => 510,
		'FT_BONUS_PAGE_ADD_5' => 520,
		'FT_BONUS_EDIT_50' => 540,

		// special internal flag for "all tasks complete"
		'FT_COMPLETION' => 1000,
	];

	const BONUS = [
		self::TASKS['FT_BONUS_PHOTO_ADD_10'],
		self::TASKS['FT_BONUS_PAGE_ADD_5'],
		self::TASKS['FT_BONUS_EDIT_50'],
	];

	// This list says how many times an item needs to be counted to be finished
	const COUNTERS = [
		self::TASKS['FT_PAGE_ADD_10'] => 10,
		self::TASKS['FT_THEMEDESIGNER_VISIT'] => 1,
		self::TASKS['FT_MAINPAGE_EDIT'] => 1,
		self::TASKS['FT_PHOTO_ADD_10'] => 10,
		self::TASKS['FT_CATEGORY_ADD_3'] => 3,
		self::TASKS['FT_COMMCENTRAL_VISIT'] => 1,
		self::TASKS['FT_WIKIACTIVITY_VISIT'] => 1,
		self::TASKS['FT_PROFILE_EDIT'] => 1,
		self::TASKS['FT_PHOTO_ADD_20'] => 20,
		self::TASKS['FT_TOTAL_EDIT_75'] => 75,
		self::TASKS['FT_PAGE_ADD_20'] => 20,
		self::TASKS['FT_CATEGORY_EDIT'] => 1,
		self::TASKS['FT_WIKIALABS_VISIT'] => 1,
		self::TASKS['FT_CATEGORY_ADD_5'] => 5,
		self::TASKS['FT_GALLERY_ADD'] => 1,
		self::TASKS['FT_TOPNAV_EDIT'] => 1,
		self::TASKS['FT_MAINPAGE_ADDSLIDER'] => 1,
		self::TASKS['FT_COMMCORNER_EDIT'] => 1,
		self::TASKS['FT_VIDEO_ADD'] => 1,
		self::TASKS['FT_USER_ADD_5'] => 5,
		self::TASKS['FT_RECENTCHANGES_VISIT'] => 1,
		self::TASKS['FT_WORDMARK_EDIT'] => 1,
		self::TASKS['FT_MOSTVISITED_VISIT'] => 1,
		self::TASKS['FT_BLOGPOST_ADD'] => 1,
		self::TASKS['FT_FB_LIKES_3'] => 3,
		self::TASKS['FT_UNCATEGORIZED_VISIT'] => 1,
		self::TASKS['FT_TOTAL_EDIT_300'] => 300,
		self::TASKS['FT_BONUS_PHOTO_ADD_10'] => 10,
		self::TASKS['FT_BONUS_PAGE_ADD_5'] => 5,
		self::TASKS['FT_BONUS_EDIT_50'] => 50,
		self::TASKS['FT_COMPLETION'] => 1,
	];

	/** @var int $taskId */
	private $taskId;

	/** @var bool $bonus */
	private $bonus;
	
	/** @var int $completed */
	private $completed;

	/** @var bool $skipped */
	private $skipped;
	
	/** @var int $count */
	private $count;
	
	public static function newEmpty( int $taskId ): FounderTask {
		$task = new self();

		$task->taskId = $taskId;
		$task->bonus = in_array( $taskId, self::BONUS );
		$task->completed = 0;
		$task->skipped = false;
		$task->count = 1;
		
		return $task;
	}
	
	public static function newFromRow( $row ): FounderTask {
		$task = new self();
		
		$task->taskId = $row->task_id;
		$task->bonus = in_array( $row->task_id, self::BONUS );
		$task->completed = $row->task_completed;
		$task->skipped = (bool) $row->task_skipped;
		$task->count = $row->task_count;
		
		return $task;
	}

	/**
	 * @return int
	 */
	public function getTaskId(): int {
		return $this->taskId;
	}

	/**
	 * @return bool
	 */
	public function isBonus(): bool {
		return $this->bonus;
	}

	/**
	 * @return int
	 */
	public function getCompleted(): int {
		return $this->completed;
	}

	/**
	 * @return bool
	 */
	public function wasSkipped(): bool {
		return $this->skipped;
	}

	/**
	 * @return int
	 */
	public function getCount(): int {
		return $this->count;
	}
	
	public function increment(): FounderTask {
		$this->count++;
		
		if ( $this->count >= self::COUNTERS[$this->taskId] ) {
			$this->count = 0;
			$this->completed = $this->bonus ? $this->completed + 1 : 1;
		}

		return $this;
	}

	public function setSkipped( bool $skipped ) {
		$this->skipped = $skipped;
	}
	
	public function toDatabaseArray(): array {
		global $wgCityId;

		return [
			'wiki_id' => $wgCityId,
			'task_id' => $this->taskId,
			'task_count' => $this->count,
			'task_skipped' => $this->skipped,
			'task_completed' => $this->completed
		];
	}
}
