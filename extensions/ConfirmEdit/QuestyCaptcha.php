<?php
/**
 * A question-based captcha plugin.
 *
 * Copyright (C) 2009 Benjamin Lees <emufarmers@gmail.com>
 * http://www.mediawiki.org/
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

require_once dirname( __FILE__ ) . '/ConfirmEdit.php';
$wgCaptchaClass = 'QuestyCaptcha';

global $wgCaptchaQuestions;
$wgCaptchaQuestions = array();

// Add your questions in LocalSettings.php using this format
// $wgCaptchaQuestions[] = array( 'question' => "A question?", 'answer' => "An answer!" );
// $wgCaptchaQuestions[] = array( 'question' => 'How much wood would a woodchuck chuck if a woodchuck could chuck wood?', 'answer' => 'as much wood as...' );
// $wgCaptchaQuestions[] = array( 'question' => "What is this wiki's name?", 'answer' => "$wgSitename" );
// You can also provide several acceptable answers to a given question (the answers shall be in lowercase):
// $wgCaptchaQuestions[] = array( 'question' => "2 + 2 ?", 'answer' => array( '4', 'four' ) );

$wgExtensionMessagesFiles['QuestyCaptcha'] = dirname( __FILE__ ) . '/QuestyCaptcha.i18n.php';
$wgAutoloadClasses['QuestyCaptcha'] = dirname( __FILE__ ) . '/QuestyCaptcha.class.php';
