<?php
/*******************************************************************************
 *
 *	Copyright (c) 2010 Frank Dengler, Jonas Bissinger
 *
 *   Semantic Project Management is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   Semantic Project Management is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with Semantic Project Management. If not, see <http://www.gnu.org/licenses/>.
 *******************************************************************************/

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 *
 * @author Frank Dengler, Jonas Bissinger
 *
 * @ingroup SemanticProjectManagement
 *
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

define( 'SPM_VERSION', '1.5' );

$wgExtensionCredits[defined( 'SEMANTIC_EXTENSION_TYPE' ) ? 'semantic' : 'other'][] = array(
	'path' => __FILE__,
	'name' => 'Semantic Project Management',
	'version' => SPM_VERSION,
	'author' => array( 'Frank Dengler, Jonas Bissinger'),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Semantic_Project_Management',
	'descriptionmsg' => 'semanticprojectmanagement-desc'
);

$spmgScriptPath = $wgScriptPath . '/extensions/SemanticProjectManagement';
$spmgIP = $IP . '/extensions/SemanticProjectManagement';

$wgExtensionFunctions[] = 'spmfSetup';

require_once( $spmgIP . '/includes/SPM_ProjectManagementClass.php' );

//set permission to change SPMsetup 
$wgGroupPermissions['sysop']['SPMsetup'] = true;
$wgAvailableRights[] = 'SPMsetup';

//define semanticprojectmanagement special page

$wgAutoloadClasses['SemanticProjectManagement'] = $spmgIP. '/includes/SPM_SpecialPage.php';
$wgExtensionMessagesFiles['SemanticProjectManagement'] = $spmgIP . '/includes/SPM_Messages.php';
$wgExtensionMessagesFiles['SemanticProjectManagementAlias'] = $spmgIP . '/includes/SPM_Alias.php';
$wgSpecialPages['SemanticProjectManagement'] = 'SemanticProjectManagement';

// FIXME: Can be removed when new style magic words are used (introduced in r52503)

$wgHooks['AdminLinks'][] = 'spmfAddToAdminLinks';

$spmgFormats = array( 'ganttchart','wbs');

function spmfSetup() {
	global $spmgFormats, $wgOut;

	foreach ( $spmgFormats as $fn ) {
		spmfInitFormat( $fn );
	}
	
	$formats_list = implode( ', ', $spmgFormats );
}

function spmfInitFormat( $format ) {
	global $smwgResultFormats, $wgAutoloadClasses, $spmgIP;

	$class = '';
	$file = '';
	switch ( $format ) {
		case 'ganttchart':
			$class = 'SPMGanttChart';
			$file = $spmgIP . '/includes/SPM_GanttChart.php';
		break;
		case 'wbs':
			$class = 'SPMWBS';
			$file = $spmgIP . '/includes/SPM_WBS.php';
		break;
	}
	if ( ( $class != '') && ( $file !='') ) {
		$smwgResultFormats[$format] = $class;
		$wgAutoloadClasses[$class] = $file;
	}
}

/**
 * Adds a link to Admin Links page
 */
function spmfAddToAdminLinks( &$admin_links_tree ) {
	$displaying_data_section = $admin_links_tree->getSection( wfMsg( 'smw_adminlinks_displayingdata' ) );
	// escape is SMW hasn't added links
	if ( is_null( $displaying_data_section ) )
		return true;
	$smw_docu_row = $displaying_data_section->getRow( 'smw' );
	$srf_docu_label = wfMsg( 'adminlinks_documentation', wfMsg( 'spm-name' ) );
	$smw_docu_row->addItem( AlItem::newFromExternalLink( "http://www.mediawiki.org/wiki/Extension:Semantic_Project_Management", $spm_docu_label ) );
	return true;
}
