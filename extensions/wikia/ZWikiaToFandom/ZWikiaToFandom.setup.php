<?php
/**
 * ZWikiaToFandom
 *
 * This extension is only for the purpose of getting all text connected to Fandom rebranding in one place - to be able
 * to localize them ably. Also that's why the funny name for the ext.
 * After the rebranding process is done messages should be populated through all the original
 * extensions and ZWikiaToFandom should be removed. If you are reading this doc in 2017 (or later), it means
 * something went wrong.
 *
 */

$dir = dirname(__FILE__) . '/';

// i18n
$wgExtensionMessagesFiles['ZWikiaToFandom'] = $dir . 'ZWikiaToFandom.i18n.php';

