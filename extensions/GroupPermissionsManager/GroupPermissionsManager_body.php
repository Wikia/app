<?php

/**
* Class definition for the special page
*/

class GroupPermissions extends SpecialPage {
	var $target = '';
	var $oldrev = '';
	var $permissionslist = array();
	var $groupslist = array();
	var $otherrights = array();

	/**
	* Constructor
	*/
	function GroupPermissions() {
		SpecialPage::SpecialPage( 'GroupPermissions', 'grouppermissions' );
	}

	/**
	* Main execution function
	* @param $par the target group to act upon
	*/
	function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;
		
		if( !$wgUser->isAllowed( 'grouppermissions' ) ) {
			$wgOut->permissionRequired( 'grouppermissions' );
			return;
		}
		wfLoadExtensionMessages('GroupPermissions');
		$this->setHeaders();
		$wgOut->addWikiText( wfMsg( 'grouppermissions-header' ) );

		//display the search form and define an array of the usergroups and an array of all current permissions
		global $wgGroupPermissions, $wgGPManagerNeverGrant;
		$this->target = $par ? $par : $wgRequest->getText( 'groupsearch', '');
		
		foreach($wgGroupPermissions as $group => $permissions) {
			$this->groupslist[] = $group;
			foreach($permissions as $right => $value) {
				if(!in_array($right, $this->permissionslist)) {
					$this->permissionslist[] = $right;
				}
			}
		}
		//sort the array in alphabetical order for ease of finding things
		sort($this->permissionslist);

		$wgOut->addHtml( $this->makeSearchForm() );
				
		//test if we have a valid target to act upon
		if( $this->target != '') {
			//ok, we do. Now, what action was just being performed?
			if( $wgRequest->getCheck( 'dosearch' ) || !$wgRequest->wasPosted() ) {
				addScriptFile('prefs.js');
				//it was a search, check the group
				if(in_array($this->target, $this->groupslist)) {
					global $wgImplicitGroups;
					//group exists, so we can change it, can't delete it if it's an implicit group
					if(in_array($this->target, $wgImplicitGroups)){
						//cannot delete group, show just show the change form
						$wgOut->addHtml( $this->makeChangeForm() );
					} else {
						//can delete group, so show that form as well
						$wgOut->addHtml( $this->makeDeleteForm() );
						$wgOut->addHtml( $this->makeChangeForm() );
					}
				} else {
					//group doesn't exist, let's make it and assign some rights
					$wgOut->addHtml( $this->makeAddForm() );
				}
			} elseif( $wgRequest->wasPosted() && $wgRequest->getVal('doadd') == '1' ) {
				//we just added a new group!
				$success = $this->writeFile('add');
				if($success) {
					$this->addLogItem( 'add', trim( $wgRequest->getText( 'addcomment' ) ) );
					$wgOut->addWikiText( wfMsg( 'grouppermissions-addsuccess', $this->target ) );
					$this->listsmade = false;
					require(dirname(__FILE__).'/config/GroupPermissions.php');
				}
			} elseif( $wgRequest->wasPosted() && $wgRequest->getVal('dodelete') == '1' ) {
				//we just deleted a user group. don't remove users from the group just in case we want to make it again
				$success = $this->writeFile('delete');
				if($success) {
					$this->addLogItem( 'delete', trim( $wgRequest->getText( 'deletecomment' ) ) );
					$wgOut->addWikiText( wfMsg( 'grouppermissions-deletesuccess', $this->target ) );
					$this->listsmade = false;
					require(dirname(__FILE__).'/config/GroupPermissions.php');
				}
			} elseif( $wgRequest->wasPosted() && $wgRequest->getVal('dochange') == '1' ) {
				//we modified the permissions of an existing group
				$success = $this->writeFile('change');
				if($success) {
					$this->addLogItem( 'change', trim( $wgRequest->getText( 'comment' ) ) );
					$wgOut->addWikiText( wfMsg( 'grouppermissions-changesuccess', $this->target ) );
					$this->listsmade = false;
					require(dirname(__FILE__).'/config/GroupPermissions.php');
				}
			}
		}
	}

	/**
	* Produce a form to search for a group
	* @return $form the HTML of the form
	*/
	function makeSearchForm() {
		$thisTitle = Title::makeTitle( NS_SPECIAL, $this->getName() );
		$form = "<fieldset>\n<legend>".wfMsgHtml('grouppermissions-searchlabel')."</legend>\n";
		$form .= "<form method=\"post\" action=\"".$thisTitle->getLocalUrl()."\">\n";
		$form .= "<label for=\"groupsearch\">".wfMsg('grouppermissions-search')."</label> ";
		$form .= "<input type=\"text\" name=\"groupsearch\" id=\"groupsearch\" value=\"".$this->target."\" /> ";
		$form .= "<input type=\"submit\" name=\"dosearch\" value=\"".wfMsg('grouppermissions-dosearch')."\" />";
		$form .= "<input type=\"hidden\" name=\"issearch\" value=\"1\" />\n</form>\n</fieldset>\n";
		return $form;
	}

	/**
	* Produce a form for changing group permissions
	* @return $form the HTML of the form
	*/
	function makeChangeForm() {
		//Returns the checkbox toggles for the given group.
		$thisTitle = Title::makeTitle( NS_SPECIAL, $this->getName() );
		$form = "<br /><div>\n";
		$form .= "<form method=\"post\" action=\"".$thisTitle->getLocalUrl()."\" id=\"preferences\">\n";
		//get the rows of checkboxes, specify that we should get values for them as well
		$this->createCheckboxes( $form, true );
		$form .= "<div id=\"prefsubmit\">\n";
		$form .= "<label for=\"comment\">".wfMsg('grouppermissions-comment')."</label> ";
		$form .= "<input type=\"text\" name=\"comment\" id=\"comment\" size=\"45\" />\n";
		$form .= "<input type=\"submit\" name=\"change\" value=\"".wfMsg('grouppermissions-change')."\" />\n";
		$form .= "<input type=\"hidden\" name=\"dochange\" value=\"1\" />";
		$form .= "<input type=\"hidden\" name=\"groupsearch\" value=\"".$this->target."\" />\n";
		$form .= "</div></form>\n</div>\n";
		return $form;
	}
	
	/**
	* Produce a form to delete a group
	* @return $form the HTML of the form
	*/
	function makeDeleteForm() {
		//sanity check, make sure that we aren't showing this for the automatic groups
		global $wgImplicitGroups;
		if(in_array($this->target, $wgImplicitGroups)) {
			return '';
		}
		$thisTitle = Title::makeTitle( NS_SPECIAL, $this->getName() );
		$form = "<fieldset>\n<legend>".wfMsgHtml('grouppermissions-deletelabel')."</legend>\n";
		$form .= "<form method=\"post\" action=\"".$thisTitle->getLocalUrl()."\">\n";
		$form .= "<label for=\"deletecomment\">".wfMsg('grouppermissions-comment')."</label> ";
		$form .= "<input type=\"text\" name=\"deletecomment\" id=\"deletecomment\" /> ";
		$form .= "<input type=\"submit\" name=\"delete\" value=\"".wfMsg('grouppermissions-delete')."\" />\n";
		$form .= "<input type=\"hidden\" name=\"dodelete\" value=\"1\" />";
		$form .= "<input type=\"hidden\" name=\"groupsearch\" value=\"".$this->target."\" />\n";
		$form .= "</form>\n</fieldset>\n";
		return $form;
	}
	
	/**
	* Produce a form to add a group
	* @return $form the HTML of the form
	*/
	function makeAddForm() {
		//make a new group and return all toggles
		$thisTitle = Title::makeTitle( NS_SPECIAL, $this->getName() );
		$form = "<br /><div>\n";
		$form .= "<form method=\"post\" action=\"".$thisTitle->getLocalUrl()."\" id=\"preferences\">\n";
		//get the rows of checkboxes, specify that we should not get values for them 
		$this->createCheckboxes( $form, false );
		$form .= "<div id=\"prefsubmit\">\n";
		$form .= "<label for=\"addcomment\">".wfMsg('grouppermissions-comment')."</label> ";
		$form .= "<input type=\"text\" name=\"addcomment\" id=\"addcomment\" size=\"45\" />\n";
		$form .= "<input type=\"submit\" name=\"add\" value=\"".wfMsg('grouppermissions-add')."\" />\n";
		$form .= "<input type=\"hidden\" name=\"doadd\" value=\"1\" />";
		$form .= "<input type=\"hidden\" name=\"groupsearch\" value=\"".$this->target."\" />\n";
		$form .= "</div></form>\n</div>\n";
		return $form;
	}

	/**
	* Add logging entries for the specified action
	* @param $type 'add', 'change', or 'delete',
	* @param $comment the log comment
	* @return bool $s the success of the operation
	*/
	function addLogItem( $type, $comment = '' ) {
		$target = $this->target;
		$page = User::getGroupPage($target);
		if(!$page instanceOf Title) {
			$page = Title::makeTitle(0, $target);
		}
		$log = new LogPage('gpmanager');
		$s = $log->addEntry($type, $page, $comment, array($target));
		return $s;
	}

	/**
	* Make the sorted tables of radio buttons and permissions
	* @param $form the form that it is adding the radio buttons to.
	* @param $getcurrentvalues is used for determining if it should set the radio buttons at the current permissions
	* @return bool the success of the operation
	*/
	function createCheckboxes( &$form, $getcurrentvalues ) {
		global $wgGroupPermissions, $wgGPManagerSortTypes, $wgGPManagerSort, $wgGPManagerNeverGrant;
		if($getcurrentvalues) {
			//let's extract the appropriate array of values from GroupPermissions once so we don't have to put it in the foreach
			foreach($wgGroupPermissions as $group => $permissions) {
				if($group == $this->target) {
					$evGroupPermissions = $permissions;
					break;
				}
			}
		}
		$sort = array();
		foreach($wgGPManagerSortTypes as $type) {
			$sort[$type] = array();
		}
		
		foreach($this->permissionslist as $right) {
			$s = false;
			foreach($wgGPManagerSortTypes as $type) {
				if(in_array($right, $wgGPManagerSort[$type])) {
					$s = true;
					$sort[$type][$right] = false;
					$st = $type;
				}
			}
			if(!$s) {
				$sort['misc'][$right] = false;
				$st = 'misc';
			}
			if($getcurrentvalues) {
				//let's change all the falses to something else if need be
				foreach($evGroupPermissions as $permission => $value) {
					$bool = in_array($right, array_keys($evGroupPermissions));
					if($right == $permission) {
						if($value)
							$sort[$st][$right] = true;
						break;
					}
				}
			}
		}
		foreach($sort as $type => $list) {
			$form .= '<fieldset><legend>'.wfMsgHtml("grouppermissions-sort-$type").'</legend>';
			$form .= "\n<h2>".wfMsgHtml("grouppermissions-sort-$type")."</h2>\n<table>";
			foreach($list as $right => $value) {
				$form .= "\n<tr><td>$right</td><td>";
				if($value) {
					$form .= $this->makeRadio($right, 'true', true) . $this->makeRadio($right, 'false') . $this->makeRadio($right, 'never');
				} else {
					$form .= $this->makeRadio($right, 'true');
					if(array_key_exists($this->target, $wgGPManagerNeverGrant)) {
						if(!in_array($right, $wgGPManagerNeverGrant[$this->target])) {
							$form .= $this->makeRadio($right, 'false', true) . $this->makeRadio($right, 'never');
						} else {
							$form .= $this->makeRadio($right, 'false') . $this->makeRadio($right, 'never', true);
						}
					} else {
						$form .= $this->makeRadio($right, 'false', true) . $this->makeRadio($right, 'never');
					}
				}
				$form .= "</td></tr>\n";
			}
			$form .= "</table></fieldset>\n";
		}
		return true;
	}
	
	/**
	* Write the php file
	* @param $type add, delete, or change - the type of the post
	* @return bool success of the write
	* @private
	*/
	private function writeFile( $type ) {
		//can we write the file?
		if(!is_writable( dirname(__FILE__) . "/config" )) {
			echo( "<h2>Cannot write config file, aborting</h2>
			
			<p>In order to use this extension, you need to make the /config subdirectory of this extension
			writable by the webserver.</p>
			
			<p>Make the necessary changes, then refresh this page to try again</p>" );
			die( 1 );
		}
		$this->oldrev = gmdate('dmYHis');
		if(file_exists(dirname(__FILE__) . '/config/GroupPermissions.php')) {
			$r = rename(dirname(__FILE__) . '/config/GroupPermissions.php', dirname(__FILE__) . '/config/GroupPermissions.' . $this->oldrev . '.php');
			if(!$r) {
				global $wgOut;
				$wgOut->addWikiText(wfMsg('grouppermissions-nooldrev'));
			}
		}
		$grouppermissions = '<?php
##### This file was automatically generated by Special:GroupPermissions. When changing group
##### permissions, please do so HERE instead of LocalSettings.php or anywhere else. If you
##### set permissions elsewhere, changing them here may not produce the desired results.
$wgGroupPermissions = array();
$wgGPManagerNeverGrant = array();';
		global $wgGroupPermissions, $wgRequest, $wgGPManagerNeverGrant;
		//run through the current permissions first and change those if need be, only define true to keep down the filesize
		foreach($wgGroupPermissions as $group => $permissions) {
			if( $group == $this->target && $type == 'change' ) {
				foreach($_POST as $key => $value) {
					if(strpos($key, 'right-') === 0 && $value == 'true') {
						$r = explode('-', $key, 2);
						$right = $r[1];
						$grouppermissions .= "\n\$wgGroupPermissions['$group']['$right'] = true;";
					}
				}
			} elseif( $group != $this->target ) {
				foreach($permissions as $right => $value) {
					if( $value == 'true') {
						//group doesn't match target group and the current value is true
						$grouppermissions .= "\n\$wgGroupPermissions['$group']['$right'] = true;";
					}
				}
			}
		}
		
		if($type == 'add') {
			//add the new group and its permissions
			foreach($_POST as $key => $value) {
					if(strpos($key, 'right-') === 0 && $value == 'true') {
						$r = explode('-', $key, 2);
						$right = $r[1];
						$grouppermissions .= "\n\$wgGroupPermissions['".$this->target."']['$right'] = true;";
					}
				}
		}
		
		//let's iterate through the never grants now
		if($wgGPManagerNeverGrant === array()) {
			foreach($wgGroupPermissions as $group => $permissions) {
				if($type != 'delete' || $group != $this->target) {
					$wgGPManagerNeverGrant[$group] = array();
				}
			}
		}
		if($type == 'add') {
			$wgGPManagerNeverGrant[$this->target] = array();
		}
		foreach($wgGPManagerNeverGrant as $group => $rights) {
			if($group != $this->target) {
				//we didn't change this one, so keep it as-is, defining it as false in wgGroupPermissions so it appears as a group
				foreach($rights as $right) {
					if($right == '') {
						continue;
					}
					$grouppermissions .= "\n\$wgGroupPermissions['$group']['$right'] = false;";
				}
				$str = "array('" . implode("', '", $rights) . "')";
				if($str == 'array(\'\')') {
					$str = 'array()';
				}
				$grouppermissions .= "\n\$wgGPManagerNeverGrant['$group'] = $str;";
			} elseif($type != 'delete') {
				//we changed this group, so make appropriate changes. First, cut out all the ones that were changed to something other than never
				foreach($rights as $permission) {
					if($wgRequest->getVal('right-'.$permission) != 'never') {
						$l = array_search($permission, $rights);
						array_splice($rights, $l, 1);
					}
				}
				//then, add in new ones
				foreach($_POST as $key => $value) {
					if(strpos($key, 'right-') === 0 && $value == 'never') {
						$r = explode('-', $key, 2);
						$right = $r[1];
						$rights[] = $right;
					}
				}
				//delete duplicate keys
				$rights = array_unique($rights);
				//now put it in the file, defining it in wgGroupPermissions as false so it registers the group
				foreach($rights as $right) {
					if($right == '') {
						continue;
					}
					$grouppermissions .= "\n\$wgGroupPermissions['$group']['$right'] = false;";
				}
				$str = "array('" . implode("', '", $rights) . "')";
				if($str == 'array(\'\')') {
					$str = 'array()';
				}
				$grouppermissions .= "\n\$wgGPManagerNeverGrant['$group'] = $str;";
			}
		}
		
		$grouppermissions = str_replace( "\r\n", "\n", $grouppermissions );
		chdir( dirname(__FILE__) . "/config" );
		$f = fopen( "GroupPermissions.php", 'wt' );
		if(fwrite( $f, $grouppermissions ) ) {
			fclose( $f );
			print "\n";
			return true;
		} else {
			fclose( $f );
			echo("<p class='error'>An error occured while writing the config/GroupPermissions.php file. Check user rights and disk space then try again.</p>");
			return false;
		}
	}
	
	/**
	* Make a radio button with label
	* @param $right the permission to make the radio for
	* @param $value can be 'true', 'false' or 'never'
	* @param $checked whether to check this radio by default
	* @return $input the HTML of the input and label tags
	*/
	function makeRadio( $right = '', $value = '', $checked = false ) {
		if($checked) {
			$input = "<input type=\"radio\" name=\"right-{$right}\" id=\"{$right}-{$value}\" class=\"{$value}\" value=\"{$value}\" checked=\"checked\" />";
		} else {
			$input ="<input type=\"radio\" name=\"right-{$right}\" id=\"{$right}-{$value}\" class=\"{$value}\" value=\"{$value}\" />";
		}
		$input .= " <label for=\"{$right}-{$value}\">".wfMsgHtml("grouppermissions-$value")."</label> ";
		return $input;
	}
}