<?php

// Return template type for given template from Template Classification Service
$wgAutoloadClasses[ 'ExternalTemplateTypesProvider' ] = __DIR__ . '/ExternalTemplateTypesProvider.class.php';

$wgAutoloadClasses[ 'RecognizedTemplatesProvider' ] = __DIR__ . '/RecognizedTemplatesProvider.class.php';

// Handles special parsing of templates classified by Template Classification Service
$wgAutoloadClasses[ 'TemplateTypesParser' ] = __DIR__ . '/TemplateTypesParser.class.php';
$wgAutoloadClasses[ 'TemplateArgsHelper' ] = __DIR__ . '/TemplateArgsHelper.class.php';

// Template type handlers
$wgAutoloadClasses[ 'ContextLinkTemplate' ] = __DIR__ . '/handlers/ContextLinkTemplate.class.php';
$wgAutoloadClasses[ 'InfoIconTemplate' ] = __DIR__ . '/handlers/InfoIconTemplate.class.php';
$wgAutoloadClasses[ 'NavboxTemplate' ] = __DIR__ . '/handlers/NavboxTemplate.class.php';
$wgAutoloadClasses[ 'NoticeTemplate' ] = __DIR__ . '/handlers/NoticeTemplate.class.php';
$wgAutoloadClasses[ 'QuoteTemplate' ] = __DIR__ . '/handlers/QuoteTemplate.class.php';
$wgAutoloadClasses[ 'ReferencesTemplate' ] = __DIR__ . '/handlers/ReferencesTemplate.class.php';
$wgAutoloadClasses[ 'ScrollboxTemplate' ] = __DIR__ . '/handlers/ScrollboxTemplate.class.php';
$wgAutoloadClasses[ 'NavigationTemplate' ] = __DIR__ . '/handlers/NavigationTemplate.class.php';
$wgAutoloadClasses[ 'ArticleHTMLCleanup' ] = __DIR__ . '/handlers/ArticleHTMLCleanup.class.php';

// other handlers
$wgAutoloadClasses[ 'DataTables' ] = __DIR__ . '/handlers/DataTables.class.php';

// hooks
$wgHooks[ 'Parser::FetchTemplateAndTitle' ][] = 'TemplateTypesParser::onFetchTemplateAndTitle';
$wgHooks[ 'Parser::FetchTemplateAndTitle' ][] = 'DataTables::markTranscludedTables';
$wgHooks[ 'Parser::getTemplateDom' ][] = 'TemplateTypesParser::onGetTemplateDom';
$wgHooks[ 'Parser::endBraceSubstitution' ][] = 'TemplateTypesParser::onEndBraceSubstitution';
$wgHooks[ 'Parser::endBraceSubstitution' ][] = 'NavigationTemplate::onEndBraceSubstitution';
$wgHooks[ 'ParserAfterTidy' ][] = 'DataTables::markDataTables';
$wgHooks[ 'ParserAfterTidy' ][] = 'TemplateTypesParser::onParserAfterTidy';
$wgHooks[ 'ParserAfterTidy' ][] = 'ArticleHTMLCleanup::doCleanup';
