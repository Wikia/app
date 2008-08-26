<?php

/**
* class definition for SortPermissions
*/

class SortPermissions extends SpecialPage {
	var $oldrev = '';
	
	/**
	* Constructor function
	* Registers the special page, restricts it to those with the 'grouppermissions' right
	*/
	function SortPermissions() {
		SpecialPage::SpecialPage( 'SortPermissions', 'grouppermissions' );
	}
	
	/**
	* Main execution function
	* @param $par unused
	*/
	function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser, $wgScriptPath;
		
		if( !$wgUser->isAllowed( 'grouppermissions' ) ) {
			$wgOut->permissionRequired( 'grouppermissions' );
			return;
		}
		$wgOut->addHTML('<noscript><strong>' . wfMsg('grouppermissions-needjs') . '</strong></noscript>');
		wfLoadExtensionMessages('GroupPermissions');
		$this->setHeaders();
		$wgOut->addWikiText( wfMsg( 'grouppermissions-sp-header' ) );
		//if we posted, try to write the file
		if($wgRequest->wasPosted()) {
			$success = $this->writeFile();
			if($success) {
				$wgOut->addWikiText(wfMsg('grouppermissions-sp-success'));
				global $wgGroupPermissions, $wgGPManagerSortTypes, $wgGPManagerSort;
				require(dirname(__FILE__).'/config/SortPermissions.php');
			}
		}
		$this->makeForm();
		$dir = dirname(__FILE__);
		$pos = strpos($dir, $wgScriptPath);
		$inc = substr($dir, $pos);
		addScriptFile("$inc/scripts/permsort.js");
	}
	
	/**
	* Make the form
	*/
	function makeForm() {
		global $wgOut, $wgGPManagerSortTypes, $wgGroupPermissions, $wgGPManagerSort;
		$a = '["' . implode('", "', $wgGPManagerSortTypes) . '"]';
		if($a === '[""]') {
			$a = '[]';
		}
		$nt = count($wgGPManagerSortTypes);
		$script = "<script type=\"text/javascript\">\n  var numtypes = $nt;\n  var types = [];\n";
		$c = 0;
		foreach($wgGPManagerSortTypes as $type) {
			$script .= "  types[$c] = '$type';\n";
			$c++;
		}
		$script .= "  var remove = '".wfMsg('grouppermissions-sp-remove')."'\n</script>";
		$wgOut->addHTML($script);
		$thisTitle = Title::makeTitle( NS_SPECIAL, $this->getName() );
		$mainform = "\n<fieldset>\n<legend>" . wfMsg('grouppermissions-sp-sort') . "</legend>\n";
		$mainform .= "<form method=\"post\" action=\"".$thisTitle->getLocalUrl()."\">\n";
		$mainform .= "<table id=\"sorttable\">";
		foreach($wgGroupPermissions as $permissions) {
			foreach($permissions as $permission => $value) {
				$this->permlist[] = $permission;
			}
		}
		//also grab permissions only defined in $wgGPManagerSort
		foreach($wgGPManagerSort as $key => $values) {
			foreach($values as $right) {
				$this->permlist[] = $right;
			}
		}
		$this->permlist = array_unique($this->permlist);
		sort($this->permlist);
		foreach($this->permlist as $permission) {
			$mainform .= $this->makeRadios($permission, $wgGPManagerSortTypes );
		}
		$mainform .= "\n</table>\n<input type=\"submit\" name=\"wpSave\" value=\"".wfMsg('grouppermissions-sp-save')."\" />";
		$st = implode('|', $wgGPManagerSortTypes);
		$mainform .= "\n<input type=\"hidden\" id=\"sorttypes\" name=\"sorttypes\" value=\"$st\" />\n</form>\n</fieldset>";
		$wgOut->addHTML($mainform);
		$form = "\n<fieldset>\n<legend>".wfMsg('grouppermissions-sp-addtype')."</legend>\n";
		$form .= "<form method=\"post\" action=\"\">\n<input type=\"text\" name=\"wpNewType\" id=\"wpNewType\" /> ";
		$form .= "<input type=\"button\" onclick=\"javascript:addColumn();\" value=\"".wfMsg('grouppermissions-sp-addtype')."\"/>\n</form>\n</fieldset>";
		$form .= "\n<fieldset>\n<legend>".wfMsg('grouppermissions-sp-addperm')."</legend>\n";
		$form .= "<form method=\"post\" action=\"\">\n<input type=\"text\" name=\"wpNewPerm\" id=\"wpNewPerm\" /> ";
		$form .= "<input type=\"button\" onclick=\"javascript:addRow();\" value=\"".wfMsg('grouppermissions-sp-addperm')."\"/>\n</form>\n</fieldset>";
		$form .= "\n<fieldset>\n<legend>".wfMsg('grouppermissions-sp-deltype')."</legend>\n";
		$form .= "<form method=\"post\" action=\"\">\n<input type=\"text\" name=\"wpDelType\" id=\"wpDelType\" /> ";
		$form .= "<input type=\"button\" onclick=\"javascript:delType();\" value=\"".wfMsg('grouppermissions-sp-deltype')."\"/>\n</form>\n</fieldset>";
		$wgOut->addHTML($form);
		return true;
	}
	
	/**
	* Make radio buttons for the form
	* @param $perm the permission to make a row for
	* @param $types array of sort types
	* @return $ret the HTML of the table row
	*/
	function makeRadios($perm, $types) {
		global $wgGPManagerSort;
		$ret = "\n<tr id=\"right-$perm\"><td>$perm (<a href=\"javascript:removePerm('$perm');\">".wfMsg('grouppermissions-sp-remove')."</a>)</td>";
		foreach($types as $type) {
			if(array_key_exists($type, $wgGPManagerSort) && in_array($perm, $wgGPManagerSort[$type])) {
				$ret .= "\n<td><input type=\"radio\" name=\"right-$perm\" id=\"$perm-$type\" class=\"type-$type\" value=\"$type\" checked=\"checked\" />";
			} else {
				$ret .= "\n<td><input type=\"radio\" name=\"right-$perm\" id=\"$perm-$type\" class=\"type-$type\" value=\"$type\" />";
			}
			$ret .= "<label for=\"$perm-$type\">$type</label></td>";
		}
		$ret .= "\n</tr>";
		return $ret;
	}
	
	/**
	* Write the php file
	* @return bool the success of the file write
	* @private
	*/
	private function writeFile() {
	//can we write the file?
		if(!is_writable( dirname(__FILE__) . "/config" )) {
			echo( "<h2>Cannot write config file, aborting</h2>
			
			<p>In order to use this extension, you need to make the /config subdirectory of this extension
			writable by the webserver.</p>
			
			<p>Make the necessary changes, then refresh this page to try again</p>" );
			die( 1 );
		}
		$this->oldrev = gmdate('dmYHis');
		if(file_exists(dirname(__FILE__) . '/config/SortPermissions.php')) {
			$r = rename(dirname(__FILE__) . '/config/SortPermissions.php', dirname(__FILE__) . '/config/SortPermissions.' . $this->oldrev . '.php');
			if(!$r) {
				global $wgOut;
				$wgOut->addWikiText(wfMsg('grouppermissions-nooldrev'));
			}
		}
		global $wgGroupPermissions;
		$permissionslist = array();
		foreach($wgGroupPermissions as $group => $permissions) {
			foreach($permissions as $right => $value) {
				if(!in_array($right, $permissionslist)) {
					$permissionslist[] = $right;
				}
			}
		}
		//sort the array in alphabetical order for ease of finding things
		sort($permissionslist);
		$sortpermissions = '<?php
##### This file was automatically generated by Special:SortPermissions. When changing
##### permission sorting, please do so HERE instead of LocalSettings.php or anywhere		
##### else. If you sort permissions elsewhere, sorting them here may not produce the
##### desired results.';
		global $wgRequest;
		//define the sort types
		$sts = explode('|', $wgRequest->getVal('sorttypes'));
		$st = " '" . implode("', '", $sts) . "' ";
		if($st === " '' ") {
			$st = '';
		}
		$sortpermissions .= "\n\$wgGPManagerSortTypes = array($st);";
		//do the sorting by iterating through $_POST
		$sortpermissions .= "\n\$wgGPManagerSort = array();";
		$sort = array();
		$stc = array();
		foreach($_POST as $key => $value) {
			if(strpos($key, 'right-') === 0) {
				$rt = explode('-', $key, 2);
				$sort[$value][] = $rt[1];
				$stc[] = $value;
				$sort[$value] = array_unique($sort[$value]);
			}
		}
		//check to make sure that we have every type explicitly defined
		$stc = array_unique($stc);
		foreach(array_diff($sts, $stc) as $value) {
			$sort[$value] = array();
		}
		//now implode it and put it in the file
		foreach($sort as $key => $rights) {
			$st = " '" . implode("', '", $rights) . "' ";
			if($st === " '' ") {
				$st = '';
			}
			foreach($rights as $right) {
				if(!in_array($right, $permissionslist)) {
					//define a new permission since we added it via the javascript
					$sortpermissions .= "\n\$wgGroupPermissions['*']['$right'] = false;";
				}
			}
			$sortpermissions .= "\n\$wgGPManagerSort['$key'] = array($st);";
		}
		$sortpermissions = str_replace( "\r\n", "\n", $sortpermissions );
		chdir( dirname(__FILE__) . "/config" );
		$f = fopen( "SortPermissions.php", 'wt' );
		if(fwrite( $f, $sortpermissions ) ) {
			fclose( $f );
			print "\n";
			return true;
		} else {
			fclose( $f );
			echo("<p class='error'>An error occured while writing the config/SortPermissions.php file. Check user rights and disk space then try again.</p>");
			return false;
		}
	}
}