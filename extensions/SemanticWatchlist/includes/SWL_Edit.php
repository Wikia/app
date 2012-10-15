<?php

/**
 * 
 * 
 * @since 0.1
 * 
 * @file SWL_Edit.php
 * @ingroup SemanticWatchlist
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SWLEdit {
	
	/**
	 * The ID of the page the edit was made to.
	 * 
	 * @var integer
	 */
	protected $pageId;
	
	/**
	 * The name of the user that made the edit.
	 * 
	 * @var string
	 */
	protected $userName;
	
	/**
	 * The user that made the changes.
	 * 
	 * @var User or false
	 */
	protected $user = false;
	
	/**
	 * The time on which the edit was made.
	 * 
	 * @var integer
	 */
	protected $time;
	
	/**
	 * DB ID of the edit (swl_edits.edit_id).
	 * 
	 * @var integer
	 */
	protected $id;
	
	/**
	 * Creates and returns a new instance of SWLEdit by getting it's info from the database.
	 * 
	 * @since 0.1 
	 * 
	 * @param integer $id
	 * 
	 * @return SWLEdit
	 */
	public static function newFromId( $id ) {
		$dbr = wfGetDB( DB_SLAVE );
		
		return self::newFromDBResult( $dbr->select(
			'swl_edits',
			array(
				'edit_id',
				'edit_user_name',
				'edit_page_id',
				'edit_time'
			),
			array( 'edit_id' => $id )
		) );
	}
	
	/**
	 * Creates and returns a new instance of SWLEdit from a database result.
	 * 
	 * @since 0.1 
	 * 
	 * @param ResultWrapper $edit
	 * 
	 * @return SWLEdit
	 */
	public static function newFromDBResult( $edit ) {
		return new self(
			$edit->edit_page_id,
			$edit->edit_user_name,
			$edit->edit_time,
			$edit->edit_id
		);
	}
	
	/**
	 * Constructor.
	 * 
	 * @since 0.1
	 */
	public function __construct( $pageId, $userName, $time, $id = null ) {
		$this->pageId = $pageId;
		$this->userName = $userName;
		$this->time = $time;
		$this->id = $id;
	}
	
	/**
	 * Writes the edit to the database, either updating it
	 * when it already exists, or inserting it when it doesn't.
	 * 
	 * @since 0.1
	 * 
	 * @return boolean Success indicator
	 */
	public function writeToDB() {
		if ( is_null( $this->id ) ) {
			return $this->insertIntoDB();
		}
		else {
			return  $this->updateInDB();
		}
	}
	
	/**
	 * Updates the group in the database.
	 * 
	 * @since 0.1
	 * 
	 * @return boolean Success indicator
	 */
	protected function updateInDB() {
		$dbr = wfGetDB( DB_MASTER );
		
		return  $dbr->update(
			'swl_edits',
			array(
				'edit_user_name' => $this->userName,
				'edit_page_id' => $this->pageId,
				'edit_time' => $this->time
			),
			array( 'edit_id' => $this->id )
		);
	}
	
	/**
	 * Inserts the group into the database.
	 * 
	 * @since 0.1
	 * 
	 * @return boolean Success indicator
	 */
	protected function insertIntoDB() {
		wfRunHooks( 'SWLBeforeEditInsert', array( &$this ) );
		
		$dbr = wfGetDB( DB_MASTER );
		
		$result = $dbr->insert(
			'swl_edits',
			array(
				'edit_user_name' => $this->userName,
				'edit_page_id' => $this->pageId,
				'edit_time' => $this->time
			)
		);
		
		$this->id = $dbr->insertId();
		
		wfRunHooks( 'SWLAfterEditInsert', array( &$this ) );
		
		return $result;
	}
	
	/**
	 * Returns the edit database id (swl_edits.edit_id).
	 * 
	 * @since 0.1
	 * 
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Returns the ID of the page the edit was made to.
	 * 
	 * @since 0.1
	 * 
	 * @return integer
	 */
	public function getPageId() {
		return $this->pageId;
	}
	
	/**
	 * Gets the title of the page these changes belong to.
	 * 
	 * @since 0.1
	 * 
	 * @return Title
	 */
	public function getTitle() {
		return Title::newFromID( $this->pageId );
	}
	
	/**
	 * Gets the name of the user that made the changes.
	 * 
	 * @since 0.1
	 * 
	 * @return string
	 */
	public function getUserName() {
		return $this->userName;
	}
	
	/**
	 * Gets the user that made the changes.
	 * 
	 * @since 0.1
	 * 
	 * @return User
	 */
	public function getUser() {
		if ( $this->user === false ) {
			$this->user = User::newFromName( $this->userName, false );
		}
		
		return $this->user;
	}
	
	/**
	 * Gets the time on which the changes where made.
	 * 
	 * @since 0.1
	 * 
	 * @return integer
	 */
	public function getTime() {
		return $this->time;
	}
	
}