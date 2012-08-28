<?php

/**
 * Setup for WikiaBar - Meebo replacement
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */


// hooks
$wgHooks['MessageCacheReplace'][] = 'WikiaBarModel::onMessageCacheReplace';
