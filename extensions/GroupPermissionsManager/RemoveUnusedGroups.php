<?php

/**
* class definition for the special page
*/
class RemoveUnusedGroups extends SpecialPage {
	
	/**
	* Constructor function
	* Registers the special page, restricts it to those with the 'userrights' right
	*/
	function __construct() {
		SpecialPage::SpecialPage( 'RemoveUnusedGroups', 'userrights' );
	}
	
	/**
	* Main execution function
	* @param $par unused
	*/
	function execute($par) {
		global $wgUser, $wgRequest, $wgOut, $wgGPManagerRUGconfirm;
		
		if( !$wgUser->isAllowed( 'userrights' ) ) {
			$wgOut->permissionRequired( 'userrights' );
			return;
		}
		
		loadGPMessages();
		$this->setHeaders();
		$wgOut->addWikiText( wfMsg( 'grouppermissions-rug-header' ) );
		if($wgRequest->wasPosted() || !$wgGPManagerRUGconfirm) {
			$success = $this->removeUsers();
			if($success) {
				$wgOut->addWikiText(wfMsg('grouppermissions-rug-success'));
			}
			return;
		}
		$thisTitle = Title::makeTitle( NS_SPECIAL, $this->getName() );
		$form = "<form method=\"post\" action=\"".$thisTitle->getLocalUrl()."\">\n<input type=\"submit\" name=\"wpConfirm\" value=\"".wfMsg('grouppermissions-rug-confirm')."\" />\n</form>";
		$wgOut->addHTML($form);
	}
	
	/**
	* Function to remove users from unused groups
	* @return bool the success of the operation
	* @private
	*/
	private function removeUsers() {
		global $wgDBprefix, $wgOut;
		//just use the master for everything, since we're reading and writing in the same link
		$db = wfGetDB(DB_MASTER);
		$db->begin();
		$query = "SELECT DISTINCT `ug_group` FROM `{$wgDBprefix}user_groups`";
		$res = $db->query($query, 'RemoveUnusedGroups::removeUsers:select');
		if($res === false) {
			return false;
		}
		$nr = $db->numRows($res);
		$i = 0;
		$dbgroups = array();
		while($i < $nr) {
			$row = $db->fetchRow($res);
			$dbgroups[] = $row['ug_group'];
			$i++;
		}
		$db->freeResult($res);
		global $wgGroupPermissions;
		$defgroups = array();
		foreach($wgGroupPermissions as $group => $perms) {
			$defgroups[] = $group;
		}
		//todo: could this in any way be optimized?
		$diff = array_diff($dbgroups, $defgroups);
		foreach($diff as $group) {
			$query = "DELETE FROM `{$wgDBprefix}user_groups` WHERE ug_group='{$group}'";
			$s = $db->query($query, 'RemoveUnusedGroups::removeUsers:delete');
			if(!$s) {
				return false;
			}
		}
		$db->commit();
		return true;
	}
}