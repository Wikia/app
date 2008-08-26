<?php
/**
 * @package MediaWiki
 * @subpackage Top
 *
 * @author Inez Korczynski <inez@wikia.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	exit( 1 );
}

$wgAutoloadClasses['Top'] = dirname(__FILE__) . '/Top_body.php';
$wgSpecialPages['Top'] = 'Top';

?>
