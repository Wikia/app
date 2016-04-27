<?php

/**
 * Parser hook-based extension to show Crunchyroll feed gallery and player.
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Jakub Kurce <jakub@wikia.com> for Wikia, Inc.
 * @copyright (C) 2006-2011, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301
 * USA
 */

if (!defined('MEDIAWIKI'))
{
	echo "This is MediaWiki extension.\n";
	exit(1);
}

$wgExtensionCredits['parserhook'][] = array
(
	'name'           => 'Crunchyroll',
	'version'        => '1.10',
	'author'         => 'Jakub Kurcek',
	'url'            => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Crunchyroll',
	'descriptionmsg' => 'crunchyroll-desc',
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['Crunchyroll']	    	= $dir . 'Crunchyroll.body.php';
$wgAutoloadClasses['CrunchyrollRSS']		= $dir . 'CrunchyrollRSS.class.php';
$wgAutoloadClasses['CrunchyrollVideo']		= $dir . 'CrunchyrollVideo.class.php';
$wgAutoloadClasses['CrunchyrollHelpers']	= $dir . 'CrunchyrollHelpers.class.php';
$wgAutoloadClasses['CrunchyrollAjax']		= $dir . 'CrunchyrollAjax.class.php';
$wgExtensionMessagesFiles['Crunchyroll']	= $dir . 'i18n/Crunchyroll.i18n.php';

$wgSpecialPages['Crunchyroll']			= 'Crunchyroll';
$wgSpecialPageGroups['Crunchyroll']		= 'wikia';

$wgHooks['ParserFirstCallInit'][] = 'CrunchyrollHelpers::crunchyrollSetup';

// Ajax dispatcher
$wgAjaxExportList[] = 'CrunchyrollAjax';

function CrunchyrollAjax() {
	global $wgRequest;
	wfProfileIn(__METHOD__);
	$method = $wgRequest->getVal('method', false);
	if ( method_exists('CrunchyrollAjax', $method) ) {
		$data = CrunchyrollAjax::$method();
		if (is_array($data)) {
			// send array as JSON
			$json = json_encode($data);
			$response = new AjaxResponse($json);
			$response->setContentType('application/json; charset=utf-8');
		}
		else {
			// send text as text/html
			$response = new AjaxResponse($data);
			$response->setContentType('text/html; charset=utf-8');
		}
	}
	wfProfileOut(__METHOD__);
	return $response;
}

\Wikia\Logger\WikiaLogger::instance()->warning( 'Crunchyroll extension in use' );
