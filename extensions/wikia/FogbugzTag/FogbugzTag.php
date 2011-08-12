<?php
if (!defined('MEDIAWIKI'))
{
	exit(1);
}
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'FogbugzTagSupport',
	'author' => 'Pepe',
	'url' => 'www.jakasstrona.pl',
	'description' => "Domyslne info",
	'descriptionmsg' => 'myextension-desc',
	'version' => '0.1.0',
);

$dir = dirname(__FILE__) . '/';

//$wgAutoloadClasses['SpecialMyExtension'] = $dir . 'SpecialMyExtension.php'; // no special page, no need for that

//$wgAutoloadClasses['EmoticonsParser'] = $dir . 'EmoticonsParser.class.php';

$wgAutoloadClasses['FogbugzTag'] = $dir . 'FogbugzTag.class.php';
$wgAutoloadClasses['FogbugzContainer'] = $dir . 'FogbugzContainer.class.php';
//set hooks for emotikons parser:
//$wgHooks['ParserFirstCallInit'][] = 'EmoticonsParser::onEmoticonsParserInit';
//$wgHooks['RTEUseDefaultPlaceholder'][] = 'EmoticonsParser::onRTEUseDefPlaceholder';

$wgHooks['ParserFirstCallInit'][] = 'FogbugzTag::onFogbugzTagInit';

//$wgHooks['RTEUseDefaultPlaceholder'][] = 'FogbugzParser::onRTEUseDefPlacehldr';
//$wgHooks['ParserBeforeInternalParse'][] = 'EmoticonsParser::renderTag';


//$wgExtensionMessagesFiles['FogbugzTagSupport'] = $dir . 'FogbugzTagSupport.i18n.php';
//$wgSpecialPages['FogbugzTagSupport'] = 'SpecialMyExtension';



$wgAjaxExportList[] = 'FogbugzTag::getFogbugzServiceResponse';


