<?php
/*
 * 	mvwScriptLoader.php
* Script Loading Library for MediaWiki
*
* @author Michael Dale mdale@wikimedia.org
* @date  feb, 2009
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License along
* with this program; if not, write to the Free Software Foundation, Inc.,
* 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
* http://www.gnu.org/copyleft/gpl.html
*/

/*
 * mvwScriptLoader:
 * 
 * some documentation goes here
 * 
 */



//set the initial javascript classes: (for loading javascript via class name) 
global $wgJSAutoloadClasses;
$wgJSAutoloadClasses = array(

);

//include WebStart.php (this can be simplified once we move mvwScriptLoader to the root dir: 
$root_path = dirname(__FILE__) . '/../../../../';
chdir( $root_path );
require_once('includes/WebStart.php');

wfProfileIn('mvwScriptLoader.php');

if( isset( $_SERVER['SCRIPT_URL'] ) ) {
	$url = $_SERVER['SCRIPT_URL'];
} else {
	$url = $_SERVER['PHP_SELF'];
}

//if( strcmp( "$wgScriptPath/mvwScriptLoader$wgScriptExtension", $url ) ) {
if( strpos($url, "mvwScriptLoader$wgScriptExtension") === false){
	wfHttpError( 403, 'Forbidden',
		'mvwScriptLoader must be accessed through the primary script entry point.' );
	return;
}
//Verify the script loader is on: 
if (!$wgEnableScriptLoader) {
	echo 'ScriptLoader is not enabled for this site. To enable add the following line to your LocalSettings.php';
	echo '<pre><b>$wgEnableScriptLoader=true;</b></pre>';
	die(1);
}
//run the main action: 
$myScriptLoader = new jsScriptLoader();
$myScriptLoader->doScriptLoader();

class jsScriptLoader{
	var $jsFileList = array();
	var $jsout = '';
	var $rKey = ''; // the request key	
	var $error_msg ='';
	var $debug = false;
	
	function doScriptLoader(){
		global 	$wgJSAutoloadClasses, $wgEnableScriptLoaderJsFile, $wgRequest, $IP, 
				$wgEnableScriptMinify, $wgUseFileCache;			
				
		//process the request
		$this->procRequestVars();			
				
		$wgUseFileCache=false;
		//if cache is on and file is present grab it from there:			
		if( $wgUseFileCache && !$this->debug ) {
			//setup file cache obj: 
			$this->sFileCache = new simpleFileCache( $this->rKey );
			if( $this->sFileCache->isFileCached() ){
				$this->outputjsHeaders();
				$this->sFileCache->loadFromFileCache();
			}
		}		
		//build the output: 
		
		//swap in the appropriate language per js_file		
		foreach($this->jsFileList as $file_name){
			if( trim( $file_name ) != '')
				$this->jsout .= $this->doProccessJsFile( $file_name );
		}
		
		//check if we should minify : 
		if( $wgEnableScriptMinify && !$this->debug){			
			//do the minification and output
			require_once ( dirname(__FILE__) . '/jsmin.php');	
			$this->jsout = JSMin::minify( $this->jsout);
		}		
		//save to the file cache: 
		if( $wgUseFileCache && !$this->debug) {
			$this->sFileCache->saveToFileCache($this->jsout);			
		}
													
		$this->outputjsHeaders();
		if( $this->error_msg != '')
			echo 'alert(\'' . str_replace("\n", '\'+"\n"+'."\n'", $this->error_msg ). '\');';
			
		echo trim($this->jsout);
				
	}
	function outputJsHeaders(){	
		global $wgJsMimeType;
		//output js mime type: 
		header( 'Content-type: '.$wgJsMimeType);
		header("Pragma: public");
		//cache forever: 
		//(the point is we never have to re validate since we should always change the request url based on the svn version)
		$one_year = 60*60*24*365;
		header("Expires: " . gmdate( "D, d M Y H:i:s", time() + $one_year  ) . " GM");  	
			
	}
	/*
	 * updates the proc Request  
	 */
	function procRequestVars(){
		global $wgRequest, $wgContLanguageCode, $wgEnableScriptMinify, $wgJSAutoloadClasses;

		//set debug flag:
		if($wgRequest->getVal('debug') || $wgEnableScriptDebug==true)
			$this->debug = true;
		
		//check for the requested classes 
		if( $wgRequest->getVal('class') ){
			$reqClassList = explode(',', $wgRequest->getVal('class'));			
				//clean the class list and populate jsFileList 	
			foreach($reqClassList as $reqClass){
				if(trim($reqClass)!=''){	
					$reqClass = ereg_replace("[^A-Za-z0-9_\-\.]", "", $reqClass );
					if( isset( $wgJSAutoloadClasses[$reqClass] ) ){
						$this->jsFileList[ $reqClass ] = $wgJSAutoloadClasses[ $reqClass ];
						$this->rKey.=$reqClass;					
					}else{				
						$this->error_msg.= 'Requested class: '.$reqClass.' not found'."\n";
					}
				}
			}
		}	
		//check for requested files if enabled: 
		if( $wgEnableScriptLoaderJsFile ){
			if( $wgRequest->getVal('files')){
				$reqFileList = explode(',', $wgRequest->getVal('files'));
				//clean the file list and populate jsFileList
				foreach($reqFileList as $reqFile){						
					//no jumping dirs: 
					$reqFile = str_replace('../','',$reqFile);
					//only allow alphanumeric underscores periods and ending with .js
					$reqFile = ereg_replace("[^A-Za-z0-9_\-\/\.]", "", $reqFile );				
					if( substr($reqFile, -3)=='.js'){
						if( is_file( $IP . $reqFile) && !in_array($reqFile, $jsFileList ) ){
		 					$this->jsFileList[] = $IP . $reqFile;
		 					$this->rKey.=$reqFile;
		 				}else{
		 					$this->error_msg.= 'Requested File: '.$reqFile.' not found'."\n";
		 				}						
					}				 				
				}
			}
		}
		//check for a unique request id (should be tied to the svn version for "fresh" copies of things
		if( $wgRequest->getVal('urid') ) {
			$this->urid = $wgRequest->getVal('urid');
		}else{			
			//just give it the current version number:
			global $IP; 
			$this->urid =  SpecialVersion::getSvnRevision( $IP );
		}		
		//add the language code to the rKey:
		$this->rKey .= '_' . $wgContLanguageCode;
		
		//add the unique rid to the rKey
		$this->rKey .= $this->urid;
		
		//add a min flag: 
		if($wgEnableScriptMinify){
			$this->rKey.='_min';
		}
	}
	function doProccessJsFile( $file_name ){
		$str = file_get_contents($file_name);
		$this->cur_file = $file_name;
		//strip out js_log debug lines not much luck with this regExp yet:
		//if( !$this->debug )
		//	 $str = preg_replace('/\n\s*js_log\s*\([^\)]([^;]|\n])*;/', "\n", $str);		
		//die('<pre>'.$str);
		
		// do language swap	
		$str = preg_replace_callback('/loadGM\s*\(\s*{(.*)}\s*\)\s*/siU',	//@@todo fix: will break down if someone does }) in their msg text 
										array($this, 'languageMsgReplace'),
										$str);																			
	
		return $str;					
	}
	function languageMsgReplace($jvar){
		if(!isset($jvar[1]))
			return ;	
					
		$jmsg = json_decode( '{' . $jvar[1] . '}', true );		
		//do the language lookup:
		if($jmsg){
			foreach($jmsg as $msgKey => $default_en_value){
				$jmsg[$msgKey] = wfMsgNoTrans( $msgKey );
			}
			//return the updated loadGM json with fixed new lines: 		
			return 'loadGM( ' . json_encode( $jmsg ) . ')';	
		}else{
			$this->error_msg.= "Could not parse JSON language msg in File:\n" .
								$this->cur_file ."\n";
		}
		//could not parse json (throw error?)
		return $jvar[0];
	}
}
//a simple version of HTMLFileCache (@@todo abstract shared pieces) 
class simpleFileCache{
	var $mFileCache;
	public function __construct( &$rKey ) {
		$this->rKey = $rKey;
		$this->fileCacheName(); // init name
	}
	public function fileCacheName() {
		if( !$this->mFileCache ) {
			global $wgFileCacheDirectory, $wgRequest;
					
			$hash = md5( $this->rKey );
			# Avoid extension confusion
			$key = str_replace( '.', '%2E', urlencode( $this->rKey ) );
	
			$hash1 = substr( $hash, 0, 1 );
			$hash2 = substr( $hash, 0, 2 );		
			$this->mFileCache = "{$wgFileCacheDirectory}/{$subdir}{$hash1}/{$hash2}/{$this->rKey}.js";

			if( $this->useGzip() )
				$this->mFileCache .= '.gz';

			wfDebug( " fileCacheName() - {$this->mFileCache}\n" );
		}
		return $this->mFileCache;
	}	
	public function isFileCached() {	
		return file_exists( $this->fileCacheName() );
	}	
	public function loadFromFileCache(){
		global $wgJsMimeType;				
		if( $wgUseGzip ) {
			if( wfClientAcceptsGzip() ) {
				header( 'Content-Encoding: gzip' );
				readfile( $filename );
			} else {
				/* Send uncompressed */
				readgzfile( $filename );
				return;
			}
		}
	}
	public function saveToFileCache( $text ) {
		global $wgUseFileCache;
		if( !$wgUseFileCache ) {
			return $text; // return to output
		}		
		if( strcmp($text,'') == 0 ) return '';

		wfDebug(" simpleSaveToFileCache()\n", false);

		$this->checkCacheDirs();

		$f = fopen( $this->fileCacheName(), 'w' );
		if($f) {
			$now = wfTimestampNow();
			$text = '//cached at: ' . $now . " :: " . $this->rKey . " \n" . $text ;
			if( $this->useGzip() ) {			
				$text = gzencode( $text);
			} 
			fwrite( $f, $text );
			fclose( $f );
		}
		return $text;
	}
	protected function checkCacheDirs() {
		$filename = $this->fileCacheName();
		$mydir2 = substr($filename,0,strrpos($filename,'/')); # subdirectory level 2
		$mydir1 = substr($mydir2,0,strrpos($mydir2,'/')); # subdirectory level 1

		wfMkdirParents( $mydir1 );
		wfMkdirParents( $mydir2 );
	}
}
?>