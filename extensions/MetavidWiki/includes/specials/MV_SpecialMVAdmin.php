<?php

if (!defined('MEDIAWIKI')) die();

global $IP;
include_once($IP . '/includes/SpecialPage.php');

/*
 * MV_SpecialMVAdmin.php Created on Apr 24, 2007
 *
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 * 
 * This special page for MediaWiki provides an administrative interface 
 * that allows to execute certain functions related to the maintenance 
 * of the metavid database. It is restricted to users with siteadmin status.
 *
 * Updated by
 * @author John Ferlito
 * @email johnf@inodes.org
 * @url http://inodes.org
 *
 * Code based on Semantic Media Wiki equivelant
 */


class MVAdmin extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		global $wgMessageCache; ///TODO: should these be messages?
		$wgMessageCache->addMessages(array('mvadmin' => 'Admin functions for MetavidWiki'));
		parent::__construct('MVAdmin', 'delete');
	}

	public function execute($par = null) {
		global $IP, $mvgIP;
		require_once($IP . '/includes/SpecialPage.php' );
		require_once($IP . '/includes/Title.php' );
	
		global $wgOut, $wgRequest;
		global $wgServer; // "http://www.yourserver.org"
							// (should be equal to 'http://'.$_SERVER['SERVER_NAME'])
		global $wgScript;   // "/subdirectory/of/wiki/index.php"
		global $wgUser;

		if ( ! $wgUser->isAllowed('delete') ) {
			$wgOut->permissionRequired('delete');
			return;
		}

		$wgOut->setPageTitle(wfMsg('mvadmin'));

		/**** Execute actions if any ****/
		$action = $wgRequest->getText( 'action' );
		if ( $action=='updatetables' ) {
			$sure = $wgRequest->getText( 'udsure' );
			if ($sure == 'yes') {
				$wgOut->disable(); // raw output
				ob_start();
				print "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"  \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><title>Setting up Storage for Metavid Wiki</title></head><body>";
				header( "Content-type: text/html; charset=UTF-8" );

				global $botUserName, $valid_attributes, $states_ary;
				require_once("$mvgIP/maintenance/metavid2mvWiki.inc.php");
				require_once("$mvgIP/maintenance/maintenance_util.inc.php");
				require_once("$mvgIP/maintenance/metavid_gov_templates.php");
				require_once( "$IP/install-utils.inc" );

				print '<p><b>Creating database tables</b><p><pre>';
				dbsource("extensions/MetavidWiki/maintenance/mv_tables.sql");

				print '</p><p><b>Creating templates</b><pre>';
				upTemplates(false);
				print '</pre></p>';

				print '<p><b>Please check there were no errors</b></p>';
				$returntitle = Title::newFromText('Special:MVAdmin');
				print '<p> Return to <a href="' . htmlspecialchars($returntitle->getFullURL()) . '">Special:MVAdmin</a></p>';
				print '</body></html>';
				ob_flush();
				flush();
				return;
			}
		}
	
		/**** Normal output ****/
		$html = '<p>This special page helps you during installation and upgrade of 
					<a href="http://metavid.ucsc.edu/wiki/index.php/MetaVidWiki">MetaVidWiki</a>. Remember to backup valuable data before 
					executing administrative functions.</p>' . "\n";
		// creating tables and converting contents from older versions
		$html .= '<form name="buildtables" action="" method="POST">' . "\n" .
				'<input type="hidden" name="action" value="updatetables" />' . "\n";
		$html .= '<h2>Preparing database for  MetaVidWiki</h2>' . "\n" .
				'<p>MetaVidWiki requires some minor extensions to the MediaWiki database in 
				order to store the video data. The below function ensures that your database is
				set up properly. The changes made in this step do not affect the rest of the 
				MediaWiki database, and can easily be undone if desired. This setup function
				can be executed multiple times without doing any harm, but it is needed only once on
				installation or upgrade.<p/>' . "\n";
		$html .= '<p>If the operation fails with obscure SQL errors, the database user employed 
				by your wiki (check your LocalSettings.php) probably does not have sufficient 
				permissions. Either grant this user additional persmissions to create and delete 
				tables, or temporarily enter the login of your database root in LocalSettings.php.<p/>' .
				"\n" . '<input type="hidden" name="udsure" value="yes"/>' .
				'<input type="submit" value="Initialise or upgrade tables"/></form>' . "\n";

		$wgOut->addHTML($html);
		return true;
	}

}
SpecialPage :: addPage(new MVAdmin());
