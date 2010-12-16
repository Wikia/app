<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

/**#@+
 * Creates a queue-based system for managing deletion.
 * @addtogroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:DeletionQueue Documentation
 *
 *
 * @author Andrew Garrett <andrew@epstone.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'DeleteQueue',
	'version'        => '0.1.1',
	'author'         => 'Andrew Garrett',
	'description'    => 'Creates a queue-based system for managing deletion.',
	'descriptionmsg' => 'deletequeue-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:DeleteQueue',
);

$dir = dirname( __FILE__ ) . '/';

$wgExtensionMessagesFiles['DeleteQueue'] = $dir . 'DeleteQueue.i18n.php';
$wgExtensionAliasesFiles['DeleteQueue'] = $dir . 'DeleteQueue.alias.php';

$wgHooks['SkinTemplateTabs'][] = 'DeleteQueueHooks::onSkinTemplateTabs';
$wgHooks['UnknownAction'][] = 'DeleteQueueHooks::onUnknownAction';
$wgHooks['ArticleViewHeader'][] = 'DeleteQueueHooks::onArticleViewHeader';

$wgAutoloadClasses['SpecialDeleteQueue'] = $dir . 'SpecialDeleteQueue.php';
$wgAutoloadClasses['DeleteQueueHooks'] = $dir . 'DeleteQueue.hooks.php';
$wgAutoloadClasses['DeleteQueueInterface'] = $dir . 'DeleteQueueInterface.php';
$wgAutoloadClasses['DeleteQueueItem'] = $dir . "DeleteQueueItem.php";

// Views
$wgAutoloadClasses['DeleteQueueView'] = "$dir/Views/DeleteQueueView.php";
$wgAutoloadClasses['DeleteQueueViewList'] = "$dir/Views/DeleteQueueViewList.php";
$wgAutoloadClasses['DeleteQueueViewNominate'] = "$dir/Views/DeleteQueueViewNominate.php";
$wgAutoloadClasses['DeleteQueueViewVote'] = "$dir/Views/DeleteQueueViewVote.php";
$wgAutoloadClasses['DeleteQueueViewCase'] = "$dir/Views/DeleteQueueViewCase.php";
$wgAutoloadClasses['DeleteQueueViewReview'] = "$dir/Views/DeleteQueueViewReview.php";

$wgAvailableRights[] = 'speedy-nominate';
$wgAvailableRights[] = 'speedy-review';
$wgAvailableRights[] = 'prod-nominate';
$wgAvailableRights[] = 'prod-review';
$wgAvailableRights[] = 'deletediscuss-review';
$wgAvailableRights[] = 'deletequeue-vote';
$wgAvailableRights[] = 'deletediscuss-nominate';

$wgGroupPermissions['sysop']['speedy-review'] = true;
$wgGroupPermissions['sysop']['deletediscuss-review'] = true;
$wgGroupPermissions['sysop']['prod-review'] = true;

$wgGroupPermissions['autoconfirmed']['deletequeue-vote'] = true;
$wgGroupPermissions['autoconfirmed']['speedy-nominate'] = true;
$wgGroupPermissions['autoconfirmed']['prod-nominate'] = true;
$wgGroupPermissions['autoconfirmed']['deletediscuss-nominate'] = true;

$wgLogActions['delete/nominate'] = 'deletequeue-log-nominate';
$wgLogActions['delete/dequeue'] = 'deletequeue-log-dequeue';
$wgLogActions['delete/requeue'] = 'deletequeue-log-requeue';

$wgDeleteQueueExpiry = array( 'prod' => 5 * 86400, 'deletediscuss' => 7 * 86400 );

$wgSpecialPages['DeleteQueue'] = 'SpecialDeleteQueue';

define( 'NS_DELETION', 140 );
$wgExtraNamespaces[NS_DELETION] = 'Deletion';

$wgDeleteQueueStyleVersion = 1;
