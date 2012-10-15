<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of QPoll.
 * Uses parts of code from Quiz extension (c) 2007 Louis-Rémi BABE. All rights reserved.
 *
 * QPoll is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * QPoll is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with QPoll; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * QPoll is a poll tool for MediaWiki.
 *
 * To activate this extension :
 * * Create a new directory named QPoll into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/QPoll/qp_user.php";
 *
 * @version 0.8.0a
 * @link http://www.mediawiki.org/wiki/Extension:QPoll
 * @author QuestPC <questpc@rambler.ru>
 */

/**
 * A special page with handy built-in Linker
 */
class qp_SpecialPage extends SpecialPage {

	static $linker = null;

	public function __construct( $name = '', $restriction = '', $listed = true, $function = false, $file = 'default', $includable = false ) {
		if ( self::$linker == null ) {
			self::$linker = new Linker();
		}
		if ( qp_Setup::$propAttrs === null ) {
			qp_Setup::$propAttrs = new qp_PropAttrs();
		}

		parent::__construct( $name, $restriction, $listed, $function, $file, $includable );
	}

	function qpLink(
			$target,
			$text = null,
			array $customAttribs = array(),
			array $query = array(),
			array $options = array() ) {
		return self::$linker->link( $target, $text, $customAttribs, $query, $options );
	}

	/**
	 * Displays current poll actions links.
	 */
	function showPollActionsList( $pid, $poll_id, Title $poll_title ) {
		global $wgContLang;
		return wfMsg(
			'qp_results_line_qpl',
			# pagename
			qp_Setup::specialchars( $wgContLang->convert( $poll_title->getPrefixedText() ) ),
			# polltitle
			qp_Setup::specialchars( $poll_id ),
			# goto link
			$this->qpLink( $poll_title, wfMsg( 'qp_source_link' ) ),
			# voices link
			$this->qpLink( $this->getTitle(), wfMsg( 'qp_stats_link' ), array(), array( "id" => intval( $pid ), "action" => "stats" ) ),
			# users link
			$this->qpLink( $this->getTitle(), wfMsg( 'qp_users_link' ), array(), array( "id" => intval( $pid ), "action" => "pulist" ) ),
			# not participated link
			$this->qpLink( $this->getTitle(), wfMsg( 'qp_not_participated_link' ), array(), array( "id" => intval( $pid ), "action" => "npulist" ) )
		);
	}

} /* end of qp_SpecialPage class */

/**
 * We do not extend QueryPage anymore because it is purposely made incompatible in 1.18+
 * thus, it is much safer to implement a larger subset of pager itself
 */
abstract class qp_QueryPage extends qp_SpecialPage {
	var $listoutput = false;

	public function __construct() {
		parent::__construct( $this->queryPageName() );
	}

	function doQuery( $offset, $limit, $shownavigation = true ) {
		global $wgOut, $wgContLang;

		$res = $this->getIntervalResults( $offset, $limit );
		$num = count( $res );

		if ( $shownavigation ) {
			$wgOut->addHTML( $this->getPageHeader() );

			// if list is empty, display a warning
			if ( $num == 0 ) {
				$wgOut->addHTML( '<p>' . wfMsgHTML( 'specialpage-empty' ) . '</p>' );
				return;
			}

			$top = wfShowingResults( $offset, $num );
			$wgOut->addHTML( "<p>{$top}\n" );

			// often disable 'next' link when we reach the end
			$atend = $num < $limit;

			$sl = wfViewPrevNext( $offset, $limit ,
				$wgContLang->specialPage( $this->queryPageName() ),
				wfArrayToCGI( $this->linkParameters() ), $atend );
			$wgOut->addHTML( "<br />{$sl}</p>\n" );
		}
		if ( $num > 0 ) {
			$s = array();
			if ( ! $this->listoutput )
				$s[] = $this->openList( $offset );

			foreach ( $res as $r ) {
				$format = $this->formatResult( $r );
				if ( $format ) {
					$s[] = $this->listoutput ? $format : "<li>{$format}</li>\n";
				}
			}

			if ( ! $this->listoutput )
				$s[] = $this->closeList();
			$str = $this->listoutput ? $wgContLang->listToText( $s ) : implode( '', $s );
			$wgOut->addHTML( $str );
		}
		if ( $shownavigation ) {
			$wgOut->addHTML( "<p>{$sl}</p>\n" );
		}
		return $num;
	}

	/**
	 * A mutator for $this->listoutput;
	 *
	 * @param $bool Boolean
	 */
	function setListoutput( $bool ) {
		$this->listoutput = $bool;
	}

	function openList( $offset ) {
		return "\n<ol start='" . ( $offset + 1 ) . "' class='special'>\n";
	}

	function closeList() {
		return "</ol>\n";
	}

	/**
	 * If using extra form wheely-dealies, return a set of parameters here
	 * as an associative array. They will be encoded and added to the paging
	 * links (prev/next/lengths).
	 *
	 * @return Array
	 */
	function linkParameters() {
		return array();
	}

	function queryPageName() {
		return "PollResults";
	}

	function isExpensive() {
		return false; // disables caching
	}

	function isSyndicated() {
		return false;
	}

} /* end of qp_QueryPage class */
