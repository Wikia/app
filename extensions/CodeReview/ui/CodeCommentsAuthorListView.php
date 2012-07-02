<?php
 
class CodeCommentsAuthorListView extends CodeCommentsListView {
	function __construct( $repo, $author ) {
		parent::__construct( $repo );
		$this->mAuthor = $author;
	}
}
