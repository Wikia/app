<?php

abstract class CodeCommentLinker {

	/**
	 * @var Skin
	 */
	protected $skin;

	/**
	 * @var CodeRepository
	 */
	protected $mRepo;

	/**
	 * @param $repo CodeRepository
	 */
	function __construct( $repo ) {
		global $wgUser;
		$this->skin = $wgUser->getSkin();
		$this->mRepo = $repo;
	}

	/**
	 * @param $text string
	 * @return string
	 */
	function link( $text ) {
		# Catch links like http://www.mediawiki.org/wiki/Special:Code/MediaWiki/44245#c829
		# Ended by space or brackets (like those pesky <br /> tags)
		$text = preg_replace_callback( '/(^|[^\w[])(' . wfUrlProtocolsWithoutProtRel() . ')(' . Parser::EXT_LINK_URL_CLASS . '+)/',
			array( $this, 'generalLink' ), $text );
		$text = preg_replace_callback( '/\br(\d+)\b/',
			array( $this, 'messageRevLink' ), $text );
		$text = preg_replace_callback( CodeRevision::BugReference,
			array( $this, 'messageBugLink' ), $text );
		return $text;
	}

	/**
	 * @param $arr array
	 * @return string
	 */
	function generalLink( $arr ) {
		$url = $arr[2] . $arr[3];
		// Re-add the surrounding space/punctuation
		return $arr[1] . $this->makeExternalLink( $url, $url );
	}

	/**
	 * @param $arr array
	 * @return string
	 */
	function messageBugLink( $arr ) {
		$text = $arr[0];
		$bugNo = intval( $arr[1] );
		$url = $this->mRepo->getBugPath( $bugNo );
		if ( $url ) {
			return $this->makeExternalLink( $url, $text );
		} else {
			return $text;
		}
	}

	/**
	 * @param $matches array
	 */
	function messageRevLink( $matches ) {
		$text = $matches[0];
		$rev = intval( $matches[1] );

		$repo = $this->mRepo->getName();
		$title = SpecialPage::getTitleFor( 'Code', "$repo/$rev" );

		return $this->makeInternalLink( $title, $text );
	}

	/**
	 * @param $url string
	 * @param $text string
	 * @return string
	 */
	abstract function makeExternalLink( $url, $text );

	abstract function makeInternalLink( $title, $text );
}

class CodeCommentLinkerHtml extends CodeCommentLinker {

	/**
	 * @param $url string
	 * @param $text string
	 * @return string
	 */
	function makeExternalLink( $url, $text ) {
		return $this->skin->makeExternalLink( $url, $text );
	}

	/**
	 * @param $title Title
	 * @param $text string
	 * @return  string
	 */
	function makeInternalLink( $title, $text ) {
		return $this->skin->link( $title, $text );
	}
}

class CodeCommentLinkerWiki extends CodeCommentLinker {
	/**
	 * @param $url string
	 * @param $text string
	 * @return string
	 */
	function makeExternalLink( $url, $text ) {
		return "[$url $text]";
	}

	/**
	 * @param $title Title
	 * @param $text string
	 * @return string
	 */
	function makeInternalLink( $title, $text ) {
		return "[[" . $title->getPrefixedText() . "|$text]]";
	}
}
