<?php
/**
 * The purpose of this extension is to provide NameSpace-based features to uploaded files in the local file repositories (FileRepo)

 * The optimal solution would be a clean extension that is easily maintainable as the trunk of MW moves foward.
 *
 * @author Jack D. Pond <jack.pond@psitex.com>
 * @addtogroup Extensions
 * @copyright  2009 Jack D. pond
 * @url http://www.mediawiki.org/wiki/Manual:Extension:NSFileRepo
 * @licence GNU General Public Licence 2.0 or later
 *
 * Version 1.3 - Allows namespace protected files to be whitelisted
 *
 * Version 1.2 - Fixes reupload error and adds lockdown security to archives, deleted, thumbs
 *
 * This extension extends and is dependent on extension Lockdown - see http://www.mediawiki.org/wiki/Extension:Lockdown
 * It must be included(required) after Lockdown!  Also, $wgHashedUploadDirectory must be true and cannot be changed once repository has files in it
 */

if (!defined('MEDIAWIKI')) die('Not an entry point.');
if (!function_exists('lockdownUserCan')) die('You MUST load Extension Lockdown before NSFileRepo (http://www.mediawiki.org/wiki/Extension:Lockdown).');

$wgImgAuthPublicTest = false;		// Must be set to false if you want to use more restrictive than general ['*']['read']
$wgIllegalFileChars = isset($wgIllegalFileChars) ? $wgIllegalFileChars : "";  // For MW Versions <1.16
$wgIllegalFileChars = str_replace(":","",$wgIllegalFileChars);			      // Remove the default illegal char ':' - need it to determine NS

# Internationalisation file
$wgExtensionMessagesFiles['NSFileRepo'] =  dirname(__FILE__) .'/NSFileRepo.i18n.php';
$wgExtensionMessagesFiles['img_auth'] =  dirname(__FILE__) .'/img_auth.i18n.php';


$wgExtensionFunctions[] = 'NSFileRepoSetup';
$wgExtensionCredits['media'][] = array(
	'path' => __FILE__,
	'name' => 'NSFileRepo',
	'author' => 'Jack D. Pond',
	'version' => '1.3',
	'url' => 'http://www.mediawiki.org/wiki/Extension:NSFileRepo',
	'description' => 'Provide namespace-based access restriction features to uploaded files/images',
	'descriptionmsg' => 'nsfilerepo-desc'
);


/**
 * Set up hooks for NSFileRepo
 */

$wgHooks['UploadForm:BeforeProcessing'][] =  'NSFileRepoNSCheck';
/**
Note, this must be AFTER lockdown has been included - thus assuming that the user has access to files in general + files at this particular namespace.
*/
$wgHooks['userCan'][] = 'NSFileRepolockdownUserCan';
$wgHooks['ImgAuthBeforeStream'][] = 'NSFileRepoImgAuthCheck';


class NSLocalRepo extends LocalRepo {
	var $fileFactory = array( 'NSLocalFile', 'newFromTitle' );
	var $oldFileFactory = array( 'NSOldLocalFile', 'newFromTitle' );
	var $fileFromRowFactory = array( 'NSLocalFile', 'newFromRow' );
	var $oldFileFromRowFactory = array( 'NSOldLocalFile', 'newFromRow' );

	static function getHashPathForLevel( $name, $levels ) {
		global $wgContLang;
		$bits=explode(':',$name);
		$filename = $bits[count($bits)-1];
		$path = parent::getHashPathForLevel( $filename, $levels );
		return ((count($bits) > 1) ? $wgContLang->getNsIndex($bits[0]).'/'.$path : $path);
	}
	/**
	 * Get a relative path including trailing slash, e.g. f/fa/
	 * If the repo is not hashed, returns an empty string
	 * This is needed because self:: will call parent if not included - exact same as in FSRepo
	 */
	function getHashPath( $name ) {
		return self::getHashPathForLevel( $name, $this->hashLevels );
	}
	/**
	 * Pick a random name in the temp zone and store a file to it.
	 * @param string $originalName The base name of the file as specified
	 *     by the user. The file extension will be maintained.
	 * @param string $srcPath The current location of the file.
	 * @return FileRepoStatus object with the URL in the value.
	 */
	function storeTemp( $originalName, $srcPath ) {
		$date = gmdate( "YmdHis" );
		$hashPath = $this->getHashPath( $originalName );
		$bits=explode(':',$originalName);
		$filename = $bits[count($bits)-1];
		$dstRel = "$hashPath$date!$filename";
		$dstUrlRel = $hashPath . $date . '!' . rawurlencode( $filename );
		$result = $this->store( $srcPath, 'temp', $dstRel );
		$result->value = $this->getVirtualUrl( 'temp' ) . '/' . $dstUrlRel;
		return $result;
	}
}

class NSLocalFile extends LocalFile
{
	/**
	 * Get the path of the file relative to the public zone root
	 */
	function getRel() {
		$bits=explode(':',$this->getName());
		$filename = $bits[count($bits)-1];
		return $this->getHashPath() . $filename;
	}

	/**
	 * Get urlencoded relative path of the file
	 */
	function getUrlRel() {
		$bits=explode(':',$this->getName());
		$filename = $bits[count($bits)-1];
		return $this->getHashPath() . rawurlencode( $filename );
	}
	/**
	 * This function overrides the LocalFile because the archive name should not contain the namespace in the
	 * filename.  Otherwise the function would have worked.  This only affects reuploads
	 *
	 * Move or copy a file to its public location. If a file exists at the
	 * destination, move it to an archive. Returns the archive name on success
	 * or an empty string if it was a new file, and a wikitext-formatted
	 * WikiError object on failure.
	 *
	 * The archive name should be passed through to recordUpload for database
	 * registration.
	 *
	 * @param string $sourcePath Local filesystem path to the source image
	 * @param integer $flags A bitwise combination of:
	 *     File::DELETE_SOURCE    Delete the source file, i.e. move
	 *         rather than copy
	 * @return FileRepoStatus object. On success, the value member contains the
	 *     archive name, or an empty string if it was a new file.
	 */
	function publish( $srcPath, $flags = 0 ) {
		$this->lock();
		$dstRel = $this->getRel();
/* This is the part that changed from LocalFile */
		$bits=explode(':',$this->getName());
		$archiveName = gmdate( 'YmdHis' ) . '!'.$bits[count($bits)-1];
/* End of changes */
		$archiveRel = 'archive/' . $this->getHashPath() . $archiveName;
		$flags = $flags & File::DELETE_SOURCE ? LocalRepo::DELETE_SOURCE : 0;
		$status = $this->repo->publish( $srcPath, $dstRel, $archiveRel, $flags );
		if ( $status->value == 'new' ) {
			$status->value = '';
		} else {
			$status->value = $archiveName;
		}
		$this->unlock();
		return $status;
	}



	/** Instantiating this class using "self"
	 * If you're reading this, you're problably wondering why on earth are the following static functions, which are copied
	 * verbatim from the original extended class "LocalFIle" included here?
	 * The answer is that "self", will instantiate the class the code is physically in, not the class extended from it.
	 * Without the inclusion of these methods in "NSLocalFile, "self" would instantiate a "LocalFile" class, not the
	 * "NSLocalFile" class we want it to.  Since there are only two methods within the "LocalFile" class that use "self",
	 * I just copied that code into the new "NSLocalFile" extended class, and the copied code will instantiate the "NSLocalFIle"
	 * class instead of the "LocalFile" class (at least in PHP 5.2.4)
	 */

	/**
	 * Create a NSLocalFile from a title
	 * Do not call this except from inside a repo class.
	 *
	 * Note: $unused param is only here to avoid an E_STRICT
	 */
	static function newFromTitle( $title, $repo, $unused = null ) {
		return new self( $title, $repo );
	}
	/**
	 * Create a NSLocalFile from a title
	 * Do not call this except from inside a repo class.
	 */

	static function newFromRow( $row, $repo ) {
		$title = Title::makeTitle( NS_FILE, $row->img_name );
		$file = new self( $title, $repo );
		$file->loadFromRow( $row );
		return $file;
	}
}
class NSOldLocalFile extends OldLocalFile
{
	function getRel( $name, $levels) {
		return(NSLocalFile::getRel( $name, $levels ));
	}
	function getUrlRel( $name, $levels ) {
		return(NSLocalFile::getUrlRel( $name, $levels ));
	}
	function publish( $srcPath, $flags = 0 ) {
		return NSLocalFile::publish( $srcPath, $flags );
	}

	/** See comment about Instantiating this class using "self", above */

	static function newFromTitle( $title, $repo, $time = null ) {
		# The null default value is only here to avoid an E_STRICT
		if( $time === null )
			throw new MWException( __METHOD__.' got null for $time parameter' );
		return new self( $title, $repo, $time, null );
	}

	static function newFromArchiveName( $title, $repo, $archiveName ) {
		return new self( $title, $repo, null, $archiveName );
	}

	static function newFromRow( $row, $repo ) {
		$title = Title::makeTitle( NS_FILE, $row->oi_name );
		$file = new self( $title, $repo, null, $row->oi_archive_name );
		$file->loadFromRow( $row, 'oi_' );
		return $file;
	}
}


/**
 * Initial setup, add .i18n. messages from $IP/extensions/DiscussionThreading/DiscussionThreading.i18n.php
*/
function NSFileRepoSetup() {
	global $wgLocalFileRepo,$wgVersion;
	$xversion = explode(".",$wgVersion);
	if ($xversion[0] <= "1" && $xversion[1] < "16") wfLoadExtensionMessages( 'img_auth' );  // loads img_auth messages for versions <1.16
	wfLoadExtensionMessages( 'NSFileRepo' );
	$wgLocalFileRepo['class'] = "NSLocalRepo";
	RepoGroup::destroySingleton();
}
/*
 * Check for Namespace in Title Line
*/
function NSFileRepoNSCheck($UploadForm) {
	$title = Title::newFromText($UploadForm->mDesiredDestName);
	if ($title->mNamespace < 100) {
		$UploadForm->mDesiredDestName = preg_replace ( "/:/", '-', $UploadForm->mDesiredDestName);
	} else {
		$bits=explode(':',$UploadForm->mDesiredDestName);
		$ns = array_shift($bits);
		$UploadForm->mDesiredDestName = $ns.":".implode("-",$bits);
	}
	return (true);
}


// If Extension:Lockdown has been activated (recommend), check individual namespace protection

function NSFileRepolockdownUserCan($title, $user, $action, &$result) {
	global $wgWhitelistRead;
	if (in_array($title->getPrefixedText(), $wgWhitelistRead)) return true;
	if (function_exists('lockdownUserCan')){
		if($title->getNamespace() == NS_FILE) {
			$ntitle = Title::newFromText($title->mDbkeyform);
			return ($ntitle->mNamespace < 100) ? true : lockdownUserCan($ntitle, $user, $action, $result);
		}
	}
	return true;
}

function NSFileRepoImgAuthCheck($title, $path, $name, $result) {
	global $wgContLang;

# See if stored in a NS path

	$subdirs = explode('/',$path);
	$x = (strlen($subdirs[1]) <> 3 && ($subdirs[1] == "archive" || $subdirs[1] == "deleted" || $subdirs[1] == "thumb")) ? 2 : 1;
	if (strlen($subdirs[$x]) == 3 && is_numeric($subdirs[$x]) && $subdirs[$x] >= 100)  {
		$title = Title::makeTitleSafe( NS_FILE, $wgContLang->getNsText($subdirs[$x]).":".$name );
		if( !$title instanceof Title ) {
			$result = array('img-auth-accessdenied','img-auth-badtitle',$name);
			return false;
		}
	}
	return true;
}