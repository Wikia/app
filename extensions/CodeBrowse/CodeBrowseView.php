<?php

class CodeBrowseView {
	static function newFromPath( $path, $request ) {
		if ( ltrim( $path, '/' ) == '' )
			return new CodeBrowseRepoListView( $path, $request );
		else
			return new CodeBrowseItemView( $path, $request );
	}
	
	function __construct( $path, $request ) {
		$this->mPath = $path;
		$this->mAction = $request->getText( 'action', 'view' );
		$this->mRev = $request->getText( 'rev', 'HEAD' );
	}
	
	function getHeader() {
		return '';		
	}
	
	function getContent() {
		return '';
	}
	
	function getFooter() {
		return '';
	}
	
	
}
