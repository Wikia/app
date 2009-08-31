<?php

/*
 * Fake Title class for custom speedups
 *
 */

class Title
{
	var $titleText;
	var $revision;
	var $redirect;
	var $does_exist;
	
	static private $titleCache=array();
	
	function newFromText( $text, $defaultNamespace = NS_MAIN )
	{
		$fname = 'Title::newFromText';

		if( is_object( $text ) ) {
			throw new MWException( 'Title::newFromText given an object' );
		}

		/**
		 * Wiki pages often contain multiple links to the same page.
		 * Title normalization and parsing can become expensive on
		 * pages with many links, so we can save a little time by
		 * caching them.
		 *
		 * In theory these are value objects and won't get changed...
		 */
		if( $defaultNamespace == NS_MAIN && isset( Title::$titleCache[$text] ) ) {
			return Title::$titleCache[$text];
		}

		/**
		 * Our custom handling
		 */
		
		$t =& new Title();
		$t->titleText = $mDbkeyform = str_replace( ' ', '_', $text );

		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array('page'),
			array( 'page_is_redirect', 'page_latest' ),
			array(
				'page_namespace' => $defaultNamespace,
				'page_title' => $mDbkeyform,
			),
			$fname,
			array()
		);
		$s = $dbr->fetchObject( $res );
		if( $s )
		{
			$t->revision = $s->page_latest;
			$t->redirect = ( $s->page_is_redirect == 0 );
			$t->does_exist = true;
		}
		else
		{
			$t->does_exist = false;
		}

		return $t;
	}

	function exists()
	{
		return $this->does_exist;
	}
}

class Article
{
	var $title;
	
	function Article( $title )
	{
		$this->title = $title;
	}
	function isRedirect()
	{
		return $title->redirect;
	}
	function getContent()
	{
		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array('text','revision'),
			array( 'rev_text_id', 'old_id', 'old_text' ),
			array(
				'rev_text_id=old_id',
				'rev_id' => $this->title->revision,
			),
			$fname,
			array()
		);
		$s = $dbr->fetchObject( $res );
		if( $s )
		{
			return $s->old_text;
		}
		else
		{
			return "";
		}
		return "FIXME";
	}
}

class WGOutFake
{
	function addHTML(){}
	function disable(){}
}
class SpecialPage
{
	function SpecialPage($p) {}
	function setHeaders(){}
};

?>