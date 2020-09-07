<?php


class PostBuilder {
	private $position;
	private $author;
	private $creationDate;
	private $isEditable;
	private $isThreadEditable;

	public function position( int $position ): self {
		$this->position = $position;
		return $this;
	}

	public function author( int $author ): self {
		$this->author = $author;
		return $this;
	}

	public function creationDate( $creationDate ): self {
		$this->creationDate = $creationDate;
		return $this;
	}

	public function isEditable( bool $isEditable ): self {
		$this->isEditable = $isEditable;
		return $this;
	}

	public function isThreadEditable( bool $isThreadEditable ): self {
		$this->isThreadEditable = $isThreadEditable;
		return $this;
	}

	public function build(): Post {
		return new Post(
			$this->position,
			$this->author,
			$this->creationDate,
			$this->isEditable,
			$this->isThreadEditable
		);
	}
}
