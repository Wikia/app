<?php

// Return template type for given template from Template Classification Service
$wgAutoloadClasses['ExternalTemplateTypesProvider'] = $dir . 'ExternalTemplateTypesProvider.class.php';

// Handles special parsing of templates classified by Template Classification Service
$wgAutoloadClasses['TemplateTypesParser'] = $dir . 'TemplateTypesParser.class.php';

// hooks
$wgHooks['Parser::FetchTemplateAndTitle'][] = 'TemplateTypesParser::onFetchTemplateAndTitle';