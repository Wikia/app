<?php

// Simple Article/Page class with properties used in the DPL
class DPLArticle {
	public $mTitle = ''; 		// title
	public $mNamespace = -1;	// namespace (number)
	public $mID = 0;			// page_id
	public $mSelTitle = '';    // selected title of initial page
	public $mSelNamespace = -1;// selected namespace (number) of initial page
	public $mImageSelTitle = ''; // selected title of image
	public $mLink = ''; 		// html link to page
	public $mExternalLink = '';// external link on the page
	public $mStartChar = ''; 	// page title first char
	public $mParentHLink = ''; // heading (link to the associated page) that page belongs to in the list (default '' means no heading)
	public $mCategoryLinks = array(); // category links in the page
	public $mCategoryTexts = array(); // category names (without link) in the page
	public $mCounter = ''; 	// Number of times this page has been viewed
	public $mSize = ''; 		// Article length in bytes of wiki text
	public $mDate = ''; 		// timestamp depending on the user's request (can be first/last edit, page_touched, ...)
	public $myDate = ''; 		// the same, based on user format definition
	public $mRevision = '';    // the revision number if specified
	public $mUserLink = ''; 	// link to editor (first/last, depending on user's request) 's page or contributions if not registered
	public $mUser = ''; 		// name of editor (first/last, depending on user's request) or contributions if not registered
	public $mComment = ''; 	// revision comment / edit summary
	public $mContribution= ''; // number of bytes changed
	public $mContrib= '';      // short string indicating the size of a contribution
	public $mContributor= '';  // user who made the changes
	
	function __construct($title, $namespace) {
		$this->mTitle     = $title;
		$this->mNamespace = $namespace;
	}
}
