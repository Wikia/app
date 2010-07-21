<?PHP
/**
* AWC`s Mediawiki Forum Extension
* 
* License: <br />
* Another Web Compnay (AWC) 
* 
* All of Another Web Company's (AWC) MediaWiki Extensions are licensed under<br />
* Creative Commons Attribution-Share Alike 3.0 United States License<br />
* http://creativecommons.org/licenses/by-sa/3.0/us/
* 
* All of AWC's MediaWiki extension's can be freely-distribute, 
*  no profit of any kind is allowed to be made off of or because of the extension itself, this includes Donations.
* 
* All of AWC's MediaWiki extension's can be edited or modified and freely-distribute <br />
*  but these changes must be made public and viewable noting the changes are not original AWC code. <br />
*  A link to http://anotherwebcom.com must be visable in the source code 
*  along with being visable in render code for the public to see.
* 
* You are not allowed to remove the Another Web Company's (AWC) logo, link or name from any source code or rendered code.<br /> 
* You are not allowed to create your own code which will remove or hide Another Web Company's (AWC) logo, link or name.
* 
* This License can and will be change with-out notice. 
* 
* All of Another Web Company's (AWC) software/code/programs are distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
* 
* 4/2008 Another Web Compnay (AWC)<br />
* The above text must stay intact and not edited in any way.
* 
* @filepath /extensions/awc/forums/install_update.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/


class awcforum_cls_dBase{

	private $sqlType;
	
	function awcforum_cls_dBase(){
    	self::sqlCheck();
	}
	 
	 
	 function sqlCheck(){
	 global $wgDBtype;
	 	$this->sqlType = $wgDBtype;
	 }
	 
	 
	 public function testCreate(){
	 global $wgDBprefix;
	 
	 	 	switch( $this->sqlType ) {
				
				case 'sqlite':
					$sql = "CREATE TABLE IF NOT EXISTS {$wgDBprefix}awc_f_test (`test` varchar(255) default NULL);";
				break;
				
				case 'postgres':
					$sql = 'CREATE OR REPLACE FUNCTION awc_f_test()
RETURNS void
LANGUAGE plpgsql AS
$mw$
BEGIN
IF NOT exists(select relname FROM pg_class WHERE relname = \'awc_f_test\') THEN
CREATE TABLE awc_f_test (
  test varchar(255) default NULL);
END IF;
END;
$mw$;
select awc_f_test();
drop function awc_f_test();';
				break;
				
				case 'mysql':
					$sql = "CREATE TABLE IF NOT EXISTS {$wgDBprefix}awc_f_test (`test` varchar(255) default NULL);";
				break;
				
				
				
	 		}
	 		
	 		
	 	$dbr = wfGetDB( DB_SLAVE );
        $dbr->ignoreErrors(true);
        
        if($dbr->query($sql)){
        	
        	#$cols['test'] = array('table' => $wgDBprefix."awc_f_test", 'sql' => "ALTER TABLE ".$wgDBprefix."awc_f_test2 ADD (t int(11) NULL)");
			#$this->colAlt($cols);
        	$dbr->query("DROP TABLE IF EXISTS {$wgDBprefix}awc_f_test;");
        	return;
        	
        } else {
        	die( '<b>' . $this->sqlType . '</b> user needs to have CREATE and ALTER privileges<br /><i>Temporarily</i> change<br />> LocalSettings.php<br />> $wgDBuser<br />> $wgDBpassword');
        }
        
	 
	 }
	 
	 function limit($limit){
	 	
	 	$tmp = $limit;
	 	$tmp = str_replace('LIMIT ', '', $tmp);
	 	$spl = explode(',', $tmp);
	 	
	 	switch( $this->sqlType ) {
				
				case 'sqlite':
					$limit = 'LIMIT ' . $spl[1] . ' OFFSET '. $spl[0];
				break;
				
				case 'postgres':
					$limit = 'LIMIT ' . $spl[1] . ' OFFSET '. $spl[0];
				break;
				
				case 'mysql':
				break;
				
	 		}
	 		
	 		return $limit;
	 		
	 }
	 
	 
	 
	 function sourceFile($sqlPath, $sqlFile){
	 global $wgOut;
	 	
	 		switch( $this->sqlType ) {
				
				case 'sqlite':
					$sqlFile= $sqlPath . $sqlFile . '.sqlite';
				break;
				
				case 'postgres':
					$sqlFile= $sqlPath . $sqlFile . '.postgre';
				break;
				
				case 'mysql':
					$sqlFile= $sqlPath . $sqlFile . '.mysql';
				break;
				
	 		}
	 		
	 		$dbw =& wfGetDB( DB_MASTER );
	 		
	 		$dbw->sourceFile($sqlFile);
	 		
	        $lines = file($sqlFile);
	        foreach ($lines as $line_num => $line) {
	           $wgOut->addHTML(htmlspecialchars($line) . "<br />\n");
	        }
	        
	        unset($dbw, $lines, $sqlFile);
	        
	       
	 }
	 
	 function clearTable($tbl){
	 
	 	$str = null;
	 	 	
	 		switch( $this->sqlType ) {
					
				case 'sqlite':
					$str = 'DELETE FROM ' . $tbl . '; VACUUM';
				break;
				
				
				case 'postgres':
					# truncate sources cascade
					$str = 'TRUNCATE TABLE ' . $tbl;
				break;
				
				case 'mysql':
					$str = 'TRUNCATE TABLE ' . $tbl;
				break;				
				
	 		}
	 		
	 		return $str;
	 
	 }
	 
	 public function colCheck($tbl, $colCheck){
	 	
	 	$cols = self::showCol($tbl);
	 	#awc_pdie($cols);
	 	foreach($cols as $col){
           if($col == $colCheck) return true;    
	 	}
	 	
	 	return false;
	 
	 }
	 
	 function showCol($tbl){
	 #select sql from sqlite_master
	 	
	 	$out=array();
	 	
	 	 	switch( $this->sqlType ) {
					
				case 'sqlite':
					$sql = 'select sql from sqlite_master where type = \'table\' and tbl_name = \'' . $tbl . '\'';
					break;
				
				case 'postgres':
					$sql = 'SELECT column_name FROM information_schema.columns WHERE table_name =\'' .  $tbl . '\'';
				break;
				
				case 'mysql':
					$sql = 'SHOW COLUMNS FROM ' . $tbl;
				break;
				
	 		}
	 		
	 		$dbr = wfGetDB( DB_SLAVE );
	 		$res = $dbr->query($sql);
	 		
	 	 	switch( $this->sqlType ) {
					
					case 'sqlite':
						while ($r = $dbr->fetchObject( $res )) {
							$out = self::sqliteColReg($r->sql, $tbl);
						}
						break;
						
					case 'postgres':
						while ($r = $dbr->fetchObject( $res )) {
							#$out = self::sqliteColReg($r->sql, $tbl);
							$out[] = $r->column_name; 
						}
						break;
					
					case 'mysql':
	 	 				while ($r = $dbr->fetchObject( $res )) {
							$out[] = $r->Field;
						}
					break;
				
	 	   }
	 	   $dbr->freeResult( $res );
	 	   
	 	   #awc_pdie($out);
	 	   return $out;
	 	   
	 }
	 
	 
	 
	 private function sqliteColReg($str, $tbl){
	 	
	 	$out = array();
	 	
	 	$str = str_replace("CREATE TABLE $tbl (", '', $str);
	 
    	#preg_match($pattern, $str, $matches);
      	#$spl = $matches[1];
    
	 	$spl = explode(',', $str);
	 	
	 	foreach($spl as $line){
	 		$spl2 = explode(' ', $line);
	 		$out[] = $spl2[1];
	 	}
	 	
	 	return $out;
	 }
	 
	 
	 public function colAlt($col_info){
	 global $wgOut;
	 
	 	$dbw = wfGetDB( DB_MASTER );
	 	
	 	foreach($col_info as $col => $sql){
	 		
	 		
	 		
	 		if(!self::colCheck($sql['table'], $col)){
	 			
	 			 switch( $this->sqlType ) {
					
					case 'sqlite':
						self::sqliteColAlt($dbw, $sql['sql']);
					break;
					
					case 'postgres':
						self::postgreColAlt($dbw, $sql['sql']);
					break;
					
					case 'mysql':
						$dbw->ignoreErrors(true);
						$res = $dbw->query($sql['sql']);
					break;
					
		 		}
	 		
	 		}
	 		
	 		$wgOut->addHTML("<b>-</b> <i>".$sql['sql'] ."</i> <br />");
	 	
	 	}
	 
	 
	 }
	 
	 private function sqliteColAlt($dbw, $sql){
	 	
	 	$sql = preg_replace("/int\((.*)\)/", 'int', $sql);
	 	$sql = preg_replace("/smallint\((.*)\)/", 'smallint', $sql);
	 	$sql = preg_replace("/tinyint\((.*)\)/", 'tinyint', $sql);
	 	$sql = preg_replace("/bigint\((.*)\)/", 'bigint', $sql);
	 	$sql = preg_replace("/enum\((.*)\)/", 'varchar(255)', $sql);
	 	
	 	$sql = str_replace("ADD (", 'ADD ', $sql);
	 	
	 	if(substr($sql, -1) == ')'){
	 		$sql = substr($sql, 0, (strlen($sql)-1));
	 	}
	 	
	 	$sql = str_replace('auto_increment', 'PRIMARY KEY AUTO_INCREMENT', $sql);
	 	$sql = str_replace('character set latin1 collate latin1_bin', '', $sql);
	 	
	 	$dbw->ignoreErrors(true);
	 	$res = $dbw->query($sql);
	 }
	 
	 
	 private function postgreColAlt($dbw, $sql){
	 	
	 	$sql = preg_replace("/int\((.*)\)/", 'INTEGER', $sql);
	 	$sql = preg_replace("/TINYINT\((.*)\)/", 'SMALLINT', $sql);
	 	$sql = preg_replace("/MEDIUMINT\((.*)\)/", 'BIGINT', $sql);
	 	#$sql = preg_replace("/TINYINT\((.*)\)/", 'SMALLINT', $sql);
	 	
	 	$sql = str_replace('ZEROFILL', '', $sql);
	 	$sql = str_replace('DOUBLE', 'DOUBLE PRECISION', $sql);
	 	$sql = str_replace('DATETIME', 'TIMESTAMP', $sql);
	 	
	 	$sql = str_replace('TINYTEXT', 'TEXT', $sql);
	 	$sql = str_replace('LONGTEXT', 'TEXT', $sql);
	 	$sql = str_replace('MEDIUMTEXT', 'TEXT', $sql);
	 	$sql = str_replace('BLOB', 'BYTEA', $sql);
	 	
	 	$sql = str_replace('int NOT NULL auto_increment', 'SERIAL', $sql);
	 	
	 	
	 	#$sql = str_replace("ADD (", 'ADD ', $sql);
	 	
	 	if(substr($sql, -1) == ')'){
	 		$sql = substr($sql, 0, (strlen($sql)-1));
	 	}
	 	$sql = str_replace(' (', ' ', $sql);
	 	
	 	#$sql = str_replace('auto_increment', 'PRIMARY KEY AUTO_INCREMENT', $sql);
	 	#$sql = str_replace('character set latin1 collate latin1_bin', '', $sql);
	 #	die($sql);
	 	#$dbw->ignoreErrors(true);
	 	
	 	$space_split = explode(' ', $sql);
	 	
	 	#awc_pdie($space_split);
	 	
	 	if(strtoupper($space_split[3]) == 'ADD'){
	 		
	 		if(self::colCheck($space_split[2], $space_split[4])){
	 			$res = $dbw->query($sql);
	 		}
	 		
	 	}
	 	
	 	
	 	
	 }
	 
	 
	 
	 public function changeColumnName($tbl, $oldName, $newName, $type, $extra = ''){
	 global $wgOut;
	 
	 	 $dbw = wfGetDB( DB_MASTER );
	 	 $tbl = $dbw->tableName($tbl);
	 	 
	 		switch( $this->sqlType ) {
					
					case 'sqlite':
						return;
					break;
					
					case 'postgres':
						$sql = "ALTER TABLE $tbl RENAME COLUMN $oldName TO $newName";
					break;
					
					case 'mysql':
						$sql = "ALTER TABLE $tbl CHANGE $oldName $newName $type $extra";
					break;
					
		 		}
	 	 
		
		$wgOut->addHTML("- <i>$sql</i><br />"); 
		#die($sql);
		if(self::colCheck($tbl, $newName) == true){
	 		return;
	 	}
	 	
	 	$dbw->ignoreErrors(true);
	 	$dbw->query($sql);
	 	$dbw->ignoreErrors(false);
	 
	 }

}