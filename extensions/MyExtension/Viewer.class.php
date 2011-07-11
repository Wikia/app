<?php

class Viewer{
	private $id = null;
	
	public $name = null;
	public $views = null;
	
	public function __construct($id){
		$this->id = $id;
	}
	
	private function getDBData($mode = DB_SLAVE, $database = null){
		global $wgExternalSharedDB;

		
		if (is_null($database)) $database = $wgExternalSharedDB;

		return wfGetDB($mode, array(), $database);
	}
	
	public function GetID(){
		return $this->id;
		
	}
	
	public function SetViews($views){
		$this->views = $views;
	}
	
	public function SetName($name){
		$this->name = $name;
	}
	
	public function FindName(){
	
		$user = $this->getDBData()->selectRow(array('`user`'), array('user_name'), array('user_id' => $this->GetID())
		);
		if ( false !== $user) { 
			$this->SetName($user->user_name);
		}
		else {
			$this->SetName('Unknown');
		}
	}
	
	//---------------------do komentarzy dla u¿ytkowników-------------------------
	
	public function getCache(){
		global $wgMemc;
		//$wgMemc->delete( wfSharedMemcKey( __CLASS__, $this->GetID(), 'comments'));
		return $wgMemc;
	}
	
	public function getMemcKey(){
		return wfSharedMemcKey(__CLASS__, $this->GetID(), 'comments');
	}
	
	public function getCommentsFromDB($WikiID){
		global $wgExternalDatawareDB;
		
		$result = $this->getDBData(DB_SLAVE, $wgExternalDatawareDB)->select(
		array( 'top_ten_viewer_comments'),
		array('comment'), 
		array('user_id' => $this->GetID(), 'wiki_id' => $WikiID)
		);
		
		$comments = array();
		
		while ( $comment = $result->fetchObject() ) {
			$comments[] = $comment->comment;
		}
	}
	
	public function getComments($WikiID){ //pobiera wszystkie komentarze z bazy a nie tylko poj usera ?
		$comments = $this->getCache()->get($this->getMemcKey());
		//print_R($comments);
		//exit;
		if ( is_null($comments)){
			$comments = $this->getCommentsFromDB($WikiID);
			$this->getCache()->set( $this->getMemcKey(), $comments);
		}
		
		return empty($comments) ? array():$comments;
	}
	
	public function addComment($comment,$WikiID){
		global $wgExternalDatawareDB;
		$cache = $this->getCache();
		$memKey = $this->getMemcKey();
		$memValue = $this->getComments($WikiID);
		
		$this->getDBData(DB_MASTER, $wgExternalDatawareDB)->insert('top_ten_viewer_comments', array(
			'user_id' => $this->GetID(),
			'wiki_id' => $WikiID,
			'comment' => $comment)
		);
		print_r($this->GetID());
		
		if (empty($memValue)) {
			$memValue = array($comment);
		}
		else {
			$memValue[] = $comment;
		}
		
		$cache->set($memKey, $memValue);
	}
}
