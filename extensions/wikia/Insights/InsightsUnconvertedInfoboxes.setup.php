<?php

/**
 * Insights - Unconverted Infoboxes
 *
 * CAUTION
 * BELOW CLASSES HAVE DEPENDENCIES ON CLASSES FROM Insights.setup.php - remember to load them as well
 *
 * This is subset config for Unconverted Infoboxes Insight subpage
 *
 * @author Łukasz Konieczny
 * @author Adam Karminski
 * @author Kamil Koterba
 */

$dir = __DIR__ . '/';


/**
 * Custom QueryPage sub-classes
 */
$wgAutoloadClasses['UnconvertedInfoboxesPage'] = $dir . 'specials/UnconvertedInfoboxesPage.class.php';

/**
 * Special pages
 */
$wgSpecialPages['Nonportableinfoboxes'] = 'UnconvertedInfoboxesPage';
$wgSpecialPageGroups['Nonportableinfoboxes'] = 'wikia';

/**
 * Models
 */
$wgAutoloadClasses['InsightsUnconvertedInfoboxesModel'] = $dir . 'models/InsightsUnconvertedInfoboxesModel.php';
