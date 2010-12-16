<?php

// Simple Article/Page class with properties used in the DPL
class DPLArticle {
	var $mTitle = ''; 		// title
	var $mNamespace = -1;	// namespace (number)
	var $mID = 0;			// page_id
	var $mSelTitle = '';    // selected title of initial page
	var $mSelNamespace = -1;// selected namespace (number) of initial page
	var $mImageSelTitle = ''; // selected title of image
	var $mLink = ''; 		// html link to page
	var $mExternalLink = '';// external link on the page
	var $mStartChar = ''; 	// page title first char
	var $mParentHLink = ''; // heading (link to the associated page) that page belongs to in the list (default '' means no heading)
	var $mCategoryLinks = array(); // category links in the page
	var $mCategoryTexts = array(); // category names (without link) in the page
	var $mCounter = ''; 	// Number of times this page has been viewed
	var $mSize = ''; 		// Article length in bytes of wiki text
	var $mDate = ''; 		// timestamp depending on the user's request (can be first/last edit, page_touched, ...)
	var $myDate = ''; 		// the same, based on user format definition
	var $mRevision = '';    // the revision number if specified
	var $mUserLink = ''; 	// link to editor (first/last, depending on user's request) 's page or contributions if not registered
	var $mUser = ''; 		// name of editor (first/last, depending on user's request) or contributions if not registered
	var $mComment = ''; 	// revision comment / edit summary
	var $mContribution = ''; // number of bytes changed
	var $mContrib = '';      // short string indicating the size of a contribution
	var $mContributor = '';  // user who made the changes

	function __construct( $title, $namespace ) {
		$this->mTitle     = $title;
		$this->mNamespace = $namespace;
	}
}
