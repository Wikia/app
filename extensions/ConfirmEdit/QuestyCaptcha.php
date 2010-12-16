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
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @addtogroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

global $wgCaptchaQuestions;
$wgCaptchaQuestions = array();
// $wgCaptchaQuestions[] = array( 'question' => "A question?", 'answer' => "An answer!" );
// $wgCaptchaQuestions[] = array( 'question' => 'How much wood would a woodchuck chuck if a woodchuck could chuck wood?', 'answer' => 'as much wood as...' );
// $wgCaptchaQuestions[] = array( 'question' => "What is this wiki's name?", 'answer' => "$wgSitename" );
// add your questions in LocalSettings.php using this format

$wgExtensionMessagesFiles['QuestyCaptcha'] = dirname( __FILE__ ) . '/QuestyCaptcha.i18n.php';
$wgAutoloadClasses['QuestyCaptcha'] = dirname( __FILE__ ) . '/QuestyCaptcha.class.php';
