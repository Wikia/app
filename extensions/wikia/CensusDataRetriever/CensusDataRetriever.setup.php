<?php
/** CensusDataRetriever Extension setup file
 *
 * @author Kamil Koterba <kamil(at)wikia-inc.com>
 */

	
$app = F::app();
//$app->wf->Debug("EditFormPreloadText kamilk into setup\n");
$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$app->registerClass('CensusDataRetriever', $dir . 'CensusDataRetriever.class.php');

/**
 * hooks
 */
$wgHooks['EditFromPreloadedText'][] = 'CensusDataRetriever::onEditFromPreloadedText';
//$app->registerHook('EditFromPreloadedText', 'CensusDataRetriever', 'onEditFromPreloadedText');
//wfDebug("EditFormPreloadText kamilk hook registered\n");
