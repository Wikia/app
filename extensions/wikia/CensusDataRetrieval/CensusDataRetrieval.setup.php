<?php

//$wgHooks['EditFormPreloadText'][] = 'CensusDataRetrieval::retrieveFromName';
//static run
$wgHooks['EditPage::showEditForm:initial'][] = 'CensusDataRetrieval::retrieveFromName';
//object run
//$wgHooks[' EditPage::showEditForm:initial'][] = 'CensusDataRetrieval::retrieveFromName';
//$wgHooks['EditPage::importFormData'][] = 'CensusDataRetrieval::retrieveFromName';
//$wgHooks['ParserBeforeInternalParse'][] = 'CensusArticleSave::replaceLinks';
$wgHooks['EditPage::attemptSave'][] = 'CensusArticleSave::replaceLinks';
//$wgHooks['OutputPageParserOutput'][] = 'CensusDataRetrieval::onOutputPageParserOutput';
$wgAutoloadClasses['CensusDataRetrieval'] =  __DIR__ . '/CensusDataRetrieval.class.php' ;
$wgAutoloadClasses['CensusArticleSave'] =  __DIR__ . '/CensusArticleSave.php' ;
$wgAutoloadClasses['CensusEnabledPagesUpdate'] =  __DIR__ . '/CensusEnabledPagesUpdate.php' ;
$wgExtensionMessagesFiles['CensusDataRetrieval'] = __DIR__ . '/CensusDataRetrieval.i18n.php' ;
