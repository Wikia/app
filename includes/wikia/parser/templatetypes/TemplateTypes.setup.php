<?php

// Return template type for given template from Template Classification Service
$wgAutoloadClasses['ExternalTemplateTypesProvider'] = __DIR__ . '/ExternalTemplateTypesProvider.class.php';
$wgAutoloadClasses['AutomaticTemplateTypes'] = __DIR__ . '/AutomaticTemplateTypes.class.php';

$wgAutoloadClasses['RecognizedTemplatesProvider'] = __DIR__ . '/RecognizedTemplatesProvider.class.php';

// Handles special parsing of templates classified by Template Classification Service
$wgAutoloadClasses['TemplateTypesParser'] = __DIR__ . '/TemplateTypesParser.class.php';

// hooks
$wgHooks['Parser::FetchTemplateAndTitle'][] = 'TemplateTypesParser::onFetchTemplateAndTitle';
$wgHooks['Parser::startBraceSubstitution'][] = 'TemplateTypesParser::onStartBraceSubstitution';
$wgHooks['Parser::endBraceSubstitution'][] = 'TemplateTypesParser::onBraceSubstitution';
