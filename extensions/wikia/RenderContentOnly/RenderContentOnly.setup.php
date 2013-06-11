<?php

/**
 * renderContentOnly
 * extension enabling action=rendercontentonly of rendering of article
 * content only inside of skin
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

$wgHooks['UnknownAction'][] = 'RenderContentOnlyHelper::onUnknownAction';

