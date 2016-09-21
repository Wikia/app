<?php
/**
 * Insights - Flags
 *
 * CAUTION
 * BELOW CLASSES HAVE DEPENDENCIES ON CLASSES FROM Insights.setup.php - remember to load them as well
 *
 * This is subset config for Flags Insight subpage that shows pages marked with flags.
 * Uses Flags API to retrieve FlaggedPages.
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @author Łukasz Konieczny
 * @author Mariusz Czeszejko-Sochacki
 */

/**
 * Models
 */
$wgAutoloadClasses['InsightsFlagsModel'] = __DIR__ . '/models/InsightsFlagsModel.php';
