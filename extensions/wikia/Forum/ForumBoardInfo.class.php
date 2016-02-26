<?php

class ForumBoardInfo {

	private $id;
	private $name;
	private $url;
	private $description;
	private $postCount;
	private $threadCount;
	/** @var ForumPostInfo $lastPost */
	private $lastPost;

	/**
	 * ForumBoardInfo constructor.
	 * @param array $array ;
	 */
	public function __construct( $array = [ ] ) {
		$this->setLastPost( new ForumPostInfo( $array[ 'lastPost' ] ) );
		unset( $array[ 'lastPost' ] );
		foreach ( $array as $key => $val ) {
			$this->$key = $val;
		}
	}

	public function setPostCount( $postCount ) {
		$this->postCount = $postCount;
	}

	public function setThreadCount( $threadCount ) {
		$this->threadCount = $threadCount;
	}

	public function setLastPost( $lastPost ) {
		$this->lastPost = $lastPost;
	}

	public function setId( $id ) {
		$this->id = $id;
	}

	public function setName( $name ) {
		$this->name = $name;
	}

	public function setUrl( $url ) {
		$this->url = $url;
	}

	public function setDescription( $description ) {
		$this->description = $description;
	}

	public function toArray() {
		$ret = get_object_vars( $this );

		if ( !empty( $this->lastPost ) ) {
			$ret[ 'lastPost' ] = $this->lastPost->toArray();
		}

		return $ret;
	}
}
