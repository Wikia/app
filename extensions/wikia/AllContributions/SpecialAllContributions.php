<?php
    if( !defined('MEDIAWIKI'))
	die();
	
    require_once( "$IP/extensions/LookupContribs/SpecialLookupContribs.php" );
    
    $wgExtensionCredits['specialpage'][] = array(
	'name' => 'All Contributions',
	'author' => 'Gerard Adamczewski',
	'description' => 'Displays user\'s contributions accross all wikia'
    );
    
    //$wgSpecialPages['AllContribs'] = array( 'SpecialPage', 'AllContribs', 'allcontribs' );
    $wgAvailableRights[] = 'allcontribs';
    $wgGroupPermissions['user']['allcontribs'] = true;
    
    $wgExtensionFunctions[] = 'wfAllContribsSetup';
    
    function wfAllContribsSetup() {
	global $wgMessageCache;
	SpecialPage::addPage( new SpecialPage('Allcontribs', 'allcontribs', true, 'wfSpecialAllContribs', false ) );
	$wgMessageCache->addMessage('allcontribs', 'All Contributions');
    }
    
    
    function wfSpecialAllContribs() {
	global $wgOut, $wgUser;
	$wgOut->setPageTitle('All Contributions');
	$list = new LookupContribsList( 'links', 'normal', true );
	$list->showList( '', $wgUser->getName() );
    }
?>