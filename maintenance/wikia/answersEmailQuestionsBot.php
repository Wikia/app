<?php
/**
 * Answers QuestionEmail execute script
 * 
 * @addto maintenance
 * @author David Pean <david.pean@wikia-inc.com>
 * 
 */
ini_set( "include_path", dirname(__FILE__)."/.." );
require_once('commandLine.inc');

$bDebugMode = (isset($options['d']) || isset($options['debug'])) ? true : false;
$aUserNames = (isset($options['users'])) ? explode(',', $options['users']) : array();
$bDbExistsCheck = (isset($options['checkdb']) ? true : false);
$bClearMode = (isset($options['clear']) ? true : false);
$sDebugMailTo = (isset($options['mailto']) ? $options['mailto'] : '');
$sQuestionType = (isset($options['questiontype']) ? $options['questiontype'] : '');

if(class_exists('QuestionEmailBot')) {
	$oEmailBot = new QuestionEmailBot($bDebugMode, $aUserNames);
	//$oWatchlistBot->setDbExistsCheck($bDbExistsCheck);
	$oEmailBot->setDebugMailTo($sDebugMailTo);
	if( $sQuestionType )$oEmailBot->setQuestionType($sQuestionType);
	$oEmailBot->run();	
}
else {
	print "QuestionEmail extension is not installed.\n";
	exit(1);
}
