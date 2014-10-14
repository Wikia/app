<?php

/**
 * @author William Lee <wlee at wikia-inc.com>
 * @date 2012-04-26
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * @var WikiaApp
 */
$app = F::app();
$dir = dirname( __FILE__ );
$wgAutoloadClasses[ 'JWPlayer'] = 		$dir . '/JWPlayer.class.php' ;

/**
 * messages
 */
$wgExtensionMessagesFiles['JWPlayer'] = "$dir/JWPlayer.i18n.php";
