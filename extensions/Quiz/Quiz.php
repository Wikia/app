<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of Quiz.
 * Copyright © 2007 Louis-Rémi BABE. All rights reserved.
 *
 * Quiz is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Quiz is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Quiz; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * Quiz is a quiz tool for MediaWiki.
 *
 * To activate this extension :
 * * Create a new directory named Quiz into the "extensions" directory of MediaWiki.
 * * Place this file and the files Quiz.i18n.php and quiz.js there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once 'extensions/Quiz/Quiz.php';
 *
 * @file
 * @ingroup Extensions
 * @version 1.0.2
 * @author Louis-Rémi Babe <lrbabe@gmail.com>
 * @link http://www.mediawiki.org/wiki/Extension:Quiz Documentation
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is not a valid entry point to MediaWiki.' );
}

/**
 * Extension credits that will show up on Special:Version
 */
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'Quiz',
	'version'        => '1.0.2',
	'author'         => 'Louis-Rémi Babe',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Quiz',
	'descriptionmsg' => 'quiz_desc'
);

/**
 * Add this extension to MediaWiki's extensions list.
 */
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['Quiz'] = $dir . 'Quiz.class.php';
$wgAutoloadClasses['Question'] = $dir . 'Quiz.class.php';
$wgExtensionMessagesFiles['QuizExtension'] = $dir . 'Quiz.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'wfQuizExtension';
$wgHooks['ParserClearState'][] = 'Quiz::resetQuizID';

/**
 * Register the extension with the WikiText parser.
 * The tag used is <quiz>
 *
 * @param $parser Object: the wikitext parser
 * @return Boolean: true to continue hook processing
 */
function wfQuizExtension( &$parser ) {
	$parser->setHook( 'quiz', 'renderQuiz' );
	return true;
}

/**
 * Call the quiz parser on an input text.
 *
 * @param $input String: text between <quiz> and </quiz> tags, in quiz syntax.
 * @param $argv Array: an array containing any arguments passed to the extension
 * @param $parser Object: the wikitext parser.
 *
 * @return An HTML quiz.
 */
function renderQuiz( $input, $argv, $parser ) {
	$parser->disableCache();
	$quiz = new Quiz( $argv, $parser );
	return $quiz->parseQuiz( $input );
}