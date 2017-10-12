<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Przemek Piotrowski <ppiotr@wikia.com>
 */

if (!defined('MEDIAWIKI')) { echo "This is MediaWiki extension.\n"; exit(1); }

$wgExtensionCredits['specialpage'][] = array
(
    'name'        => 'WikiFactory Reporter',
    'description' => 'Display info about WikiFactory settings.',
    'author'      => '[http://www.wikia.com/wiki/User:Ppiotr Przemek Piotrowski (Nef)]'
);

$wgExtensionMessagesFiles['WikiFactoryReporter'] = dirname(__FILE__) . '/SpecialWikiFactoryReporter.i18n.php';

extAddSpecialPage(dirname(__FILE__) . '/SpecialWikiFactoryReporter_body.php', 'WikiFactoryReporter', 'WikiFactoryReporter');

