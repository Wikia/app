<?PHP

$wgExtensionFunctions[] = "wfExtensionAWCMultiFileUploader";

$wgAvailableRights[] = 'MultiFileUploader';
$wgGroupPermissions[ 'user' ][ 'MultiFileUploader' ] = true;

function wfExtensionAWCMultiFileUploader() {
    global $wgMessageCache;
    $wgMessageCache->addMessages(array('awcmultifileuploader' => 'Multi-File Uploader')); //will expand
    SpecialPage::addPage( new SpecialPage( 'AWCMultiFileUploader', 'MultiFileUploader', true ) );
}

$wgExtensionCredits['other'][] = array(
        'name' => 'AWC`s Muli-file Uploader',
        'version' => '1.0',
        'author' => 'Another Web Company',
        'url' => 'http://wiki.anotherwebcom.com/Multi-File_Upload_%28MediaWiki%29',
        'description' => 'Upload more then one file at a time.'
);	

?>
