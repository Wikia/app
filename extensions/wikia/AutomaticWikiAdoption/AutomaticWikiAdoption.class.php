<?php
/**
 * AutomaticWikiAdoption
 *
 * An AutomaticWikiAdoption extension for MediaWiki
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-10-05
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/AutomaticWikiAdoption/AutomaticWikiAdoption_setup.php");
 */

class AutomaticWikiAdoption {
	/**
	 * hook handler
	 * bla bla
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	static function smth() {
	}

	//Background task (cron) to collect daily data about wikis and admins
	//Module for sending e-mail to old admin
	//Module for displaying notification
	//Special page for adoption process
	//Module for checking current user whether to show or not msg about adoption
	//Module to alter user rights
	//Log in local Special:Log
	//Log in global (community.wikia) Special:Log (check possibility)
}