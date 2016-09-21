<?php
/**
 * Special page which lists all of the PHP files included at the time. Should help track down what's being included
 * on a wiki to help debug some strange occurrances and to help minimize unnecessary inclusions.
 *
 * Mainly intended for dev use... not because it's private, just because it's not too useful to anyone else.
 */
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['listincludedfiles'] = $dir . 'Special_ListIncludedFiles.i18n.php';

require_once($IP . '/includes/SpecialPage.php');
$wgSpecialPages['ListIncludedFiles'] = 'ListIncludedFiles';

class ListIncludedFiles extends SpecialPage{

	public function __construct(){
		parent::__construct('ListIncludedFiles');
	}

	function execute(){
		global $wgOut, $wgUser;

		if( !$wgUser->isAllowed( 'listincludedfilesright' ) ) {
			throw new PermissionsError( 'listincludedfilesright' );
		}

		ob_start();

		$includedFiles = get_included_files();
		sort($includedFiles);

		print count($includedFiles)." Included files:<ul>\n";
		foreach($includedFiles as $fileName){
			print "<li>$fileName</li>\n";
		}
		print "</ul>\n";

		$html = ob_get_clean();
		$wgOut->addHTML($html);
	} // end execute()

} // end class ListIncludedFiles
