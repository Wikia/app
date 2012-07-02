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

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * An abstract view which holds parser state and can expand the given text according to ppframe
 * Base class of every another view
 */
class qp_AbstractView {

	# "linked" controller
	var $ctrl;
	# an instance of parser from parser tag hook
	var $parser;
	# an instance of PPFrame (parser context)
	var $ppframe;
	var $linker;

	# the following showresults types are currently available:
	# 0 - none; 1 - percents; 2 - bars
	# may contain extra options (color, width) for selected display type
	var $showResults = Array( 'type' => 0 ); // hide showResults by default

	/**
	 * @param  $parser   instance of parser for current tag hook
	 * @param  $ppframe  instance of ppframe for current tag hook
	 */
	function __construct( Parser $parser, PPFrame $frame ) {
		$this->parser = $parser;
		$this->ppframe = $frame;
		$this->linker = new Linker();
	}

	function isCompatibleController( $ctrl ) {
		return is_object( $ctrl );
	}

	/**
	 * Links an instance of controller to the current view
	 * @param  $ctrl  an instance of controller
	 */
	function setController( $ctrl ) {
		if ( !$this->isCompatibleController( $ctrl ) ) {
			throw new MWException( 'Bug: controller is incompatible to current view in ' . __METHOD__ );
		}
		if ( isset( $this->ctrl ) ) {
			throw new MWException( 'Bug: controller cannot be linked to the view more than once in ' . __METHOD__ );
		}
		$this->ctrl = $ctrl;
	}

	function link(
			$target,
			$text = null,
			array $customAttribs = array(),
			array $query = array(),
			array $options = array() ) {
		return $this->linker->link( $target, $text, $customAttribs, $query, $options );
	}

	function rtp( $text ) {
		return $this->parser->recursiveTagParse( $text, $this->ppframe );
	}

} /* end of qp_AbstractView class */
