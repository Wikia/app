<?php

class Post {

	private $position;
	private $author;
	private $creationDate;
	private $isEditable;
	private $isThreadEditable;

	public function __construct( int $position, int $author, $creationDate, bool $isEditable, bool $isThreadEditable ) {
		$this->position = $position;
		$this->author = $author;
		$this->creationDate = $creationDate;
		$this->isEditable = $isEditable;
		$this->isThreadEditable = $isThreadEditable;
	}

	public function isFirstPost() : bool {
		return $this->position == 1;
	}

	public function isAuthor( User $user ) : bool {
		return $this->author == $user->getId();
	}

	public function isEditable() : bool {
		return $this->isEditable;
	}

	public function isThreadEditable() : bool {
		return $this->isThreadEditable;
	}

	/**
	 * Editable period means a 1 day after creation.
	 */
	public function isDuringEditablePeriod() {
		$now = new DateTime();
		$deadline = ( new DateTime( "@$this->creationDate" ) )->add( new DateInterval( 'P1D' ) );
		return $now < $deadline;
	}
}
