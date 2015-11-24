<?php

// Return template type for given template from Template Classification Service
$wgAutoloadClasses['ExternalTemplateTypesProvider'] = __DIR__ . '/ExternalTemplateTypesProvider.class.php';
$wgAutoloadClasses['AutomaticTemplateTypes'] = __DIR__ . '/AutomaticTemplateTypes.class.php';

$wgAutoloadClasses['RecognizedTemplatesProvider'] = __DIR__ . '/RecognizedTemplatesProvider.class.php';

// Handles special parsing of templates classified by Template Classification Service
$wgAutoloadClasses['TemplateTypesParser'] = __DIR__ . '/TemplateTypesParser.class.php';
$wgAutoloadClasses['TemplateArgsHelper'] = __DIR__ . '/TemplateArgsHelper.class.php';

// Handlers load
$wgAutoloadClasses['QuoteTemplate'] = __DIR__ . '/handlers/QuoteTemplate.class.php';

// hooks
$wgHooks['Parser::FetchTemplateAndTitle'][] = 'TemplateTypesParser::onFetchTemplateAndTitle';
$wgHooks['Parser::getTemplateDom'][] = 'TemplateTypesParser::onGetTemplateDom';
