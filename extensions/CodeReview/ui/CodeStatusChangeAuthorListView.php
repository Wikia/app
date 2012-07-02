<?php

class CodeStatusChangeAuthorListView extends CodeStatusChangeListView {

	function __construct( $repo, $author ) {
		parent::__construct( $repo );

		$this->mAuthor = $author;
	}
}
