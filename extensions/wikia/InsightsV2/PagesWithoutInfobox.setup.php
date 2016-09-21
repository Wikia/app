<?php

/**
 * Insights - Pages without an infobox
 *
 * CAUTION
 * BELOW CLASSES HAVE DEPENDENCIES ON CLASSES FROM Insights.setup.php - remember to load them as well
 *
 * This is subset config for Pages without an Infobox Insights subpage
 * @author Adam Karminski
 */

$dir = __DIR__ . '/';


/**
 * Custom QueryPage sub-classes
 */
$wgAutoloadClasses['PagesWithoutInfobox'] = $dir . 'specials/PagesWithoutInfobox.class.php';

/**
 * Special pages
 */
$wgSpecialPages['PagesWithoutInfobox'] = 'PagesWithoutInfobox';
$wgSpecialPageGroups['PagesWithoutInfobox'] = 'wikia';

/**
 * Models
 */
$wgAutoloadClasses['InsightsPagesWithoutInfoboxModel'] = $dir . 'models/InsightsPagesWithoutInfoboxModel.php';
