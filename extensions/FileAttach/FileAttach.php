<?php
/**
 * FileAttach extension - Allows files to be uploaded to the current article
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Milan Holzapfel
 * @licence GNU General Public Licence 2.0 or later
 *
 */
if ( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' );
define( 'FILEATTCH_VERSION', '1.0.2, 2010-04-24' );

$wgAttachmentHeading = 'Attachments';

$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['FileAttach'] = "$dir/FileAttach.i18n.php";
$wgExtensionCredits['other'][] = array(
	'path'        => __FILE__,
	'name'        => 'FileAttach',
	'author'      => '[http://www.mediawiki.org/wiki/User:Milan Milan Holzapfel]',
	'descriptionmsg' => 'fileattach-desc',
	'url'         => 'https://www.mediawiki.org/wiki/Extension:FileAttach',
	'version'     => FILEATTCH_VERSION
);

class FileAttach {

	private static $uploadForm = false;
	public static $attachto = false;
	public static $wgOut = false;

	/**
	 * Modify the upload form and attachment heading
	 */
	public static function onBeforePageDisplay( $out, $skin ) {
		global $wgParser, $wgAttachmentHeading;

		# Bail if page inappropriate for attachments
		if( !is_object( $wgParser ) || !is_object( $wgParser->mOutput )|| !isset( $wgParser->mOutput->mSections ) ) return true;

		# If the last section in the article is level 2 and "Attachments" then convert to file icons
		$sections = $wgParser->mOutput->mSections;
		if( is_array( $sections ) && count( $sections ) > 0 ) {
			$last = $sections[count( $sections ) - 1];
			if( $last['level'] == 2 && $last['anchor'] == $wgAttachmentHeading ) {
				preg_match( "|.+<h2>.+?$wgAttachmentHeading.+?</h2>\s*<ul>(.+?)</ul>|s", $out->mBodytext, $files );
				preg_match_all( "|<li>\s*<a.+?>(.+?)</a>\s*</li>|", $files[1], $files );
				$html = "\n\n<!-- files attachments rendered by Extension:FileAttach -->\n<div class=\"file-attachments\" style=\"width:85%\">\n";
				foreach( $files[1] as $file ) {
					$title = Title::newFromText( $file, NS_FILE );
					$name = $title->getText();
					$alt = "title=\"$name\"";
					if( strlen( $name ) > 15 ) $name = preg_replace( "|^(............).+(\.\w+$)|", "$1...$2", $name );
					$icon = self::getIcon( $file );
					$url = wfFindFile( $title )->getURL();
					$img = "<a $alt href=\"$url\"><img style=\"padding-bottom:30px\" src=\"$icon\" width=\"80px\" height=\"80px\" /></a>";
					$text = "<a $alt href=\"$url\" style=\"color:black;font-size:10px;position:relative;left:-67px;top:30px;\">$name</a>";
					$html .= "\t<span class=\"file-attachment\">$img$text</span>\n";
				}
				$html .= "</div>\n";
				$out->mBodytext = preg_replace(
					"|^(.+)<h2>.+?$wgAttachmentHeading.+?</h2>\s*<ul>(.+?)</ul>|s",
					"$1<h2>" . wfMsg( 'fileattach-attachments' ) . "</h2>$html",
					$out->mBodytext
				);
			}
		}

		# Modify the upload form
		if( self::$uploadForm ) {
			global $wgRequest;
			$attachto = $wgRequest->getText( 'attachto' );
			if( $attachto ) {
				$out->mPagetitle = wfMsg( 'fileattach-uploadheading', $attachto );
				$escVal = htmlspecialchars( $attachto );
				$out->mBodytext = str_replace( "</form>", "<input type=\"hidden\" name=\"attachto\" value=\"$escVal\" /></form>", $out->mBodytext );
			}
		}

		return true;
	}

	/**
	 * Note if this is the upload form or warning form so that we can modify it before page display
	 */
	public static function onUploadFormInitial( $form ) {
		self::$uploadForm = true;
		return true;
	}

	/**
	 * Check if the upload should attach to an article
	 */
	public static function onUploadFormBeforeProcessing( $form ) {
		global $wgRequest, $wgHooks;
		if( $attachto = $wgRequest->getText( 'attachto', '' ) ) {
			self::$uploadForm = true;
			$title = Title::newFromText( $attachto );
			self::$attachto = new Article( $title, 0 );
			$wgHooks['SpecialUploadComplete'][] = 'FileAttach::onSpecialUploadComplete';
		}
		return true;
	}

	/**
	 * Change the redirection after upload to the page the file attached to,
	 * and attach the file to the article
	 */
	public static function onSpecialUploadComplete( $upload ) {
		global $wgOut, $wgRequest, $wgAttachmentHeading;
		self::$wgOut = $wgOut;
		$wgOut = new FileAttachDummyOutput;
		$filename = $wgRequest->getText( 'wpDestFile' );
		$text = preg_replace( "|(\s+==\s*$wgAttachmentHeading\s*==)\s+|s", "$1\n*[[:File:$filename]]\n", self::$attachto->getContent(), 1, $count );
		if( $count == 0 ) $text .= "\n\n== $wgAttachmentHeading ==\n*[[:File:$filename]]\n";
		self::$attachto->doEdit( $text, wfMsg( 'fileattach-editcomment', $filename ), EDIT_UPDATE );
		return true;
	}

	/**
	 * Return an icon path from passed filename
	 */
	private static function getIcon( $filename ) {
		global $wgStylePath, $wgStyleDirectory;
		$ext = strtolower( preg_match( "|\.(\w+)$|", $filename, $ext ) ? "-$ext[1]" : "" );
		$path = "common/images/icons/fileicon";
		$icon = file_exists( "$wgStyleDirectory/$path$ext.png" ) ? "$wgStylePath/$path$ext.png" : "$wgStylePath/$path.png";
		return $icon;
	}

	public static function onSkinTemplateTabs( $skin, &$actions ) {
		$attachto = $skin->getTitle()->getPrefixedText();
		$url = SpecialPage::getTitleFor( 'Upload' )->getLocalURL( array( 'attachto' => $attachto ) );
		$actions['attach'] = array( 'text' => wfMsg( 'fileattach-attachfile' ), 'class' => false, 'href' => $url );
		return true;
	}

	public static function onSkinTemplateNavigation( $skin, &$actions ) {
		$attachto = $skin->getTitle()->getPrefixedText();
		$url = SpecialPage::getTitleFor( 'Upload' )->getLocalURL( array( 'attachto' => $attachto ) );
		$actions['views']['attach'] = array( 'text' => wfMsg( 'fileattach-attachfile' ), 'class' => false, 'href' => $url );
		return true;
	}

}

/**
 * Dummy class to hack upload form to redirect back to the page the file is attached to
 * - the redirect property of $wgOut is protected so a hack is required
 * - I did this by temporarily replacing the $wgOut object with an instance of a dummy class
 * - this instance puts the original instance back and changes the redirect
 * - the upload hook and redirect are on line 434,435 of SpecialUpload.php
 */
class FileAttachDummyOutput {
	function redirect( $url ) {
		global $wgOut;
		$wgOut = FileAttach::$wgOut;
		$wgOut->redirect( FileAttach::$attachto->getTitle()->getFullURL() );
	}
}

$wgHooks['BeforePageDisplay'][] = 'FileAttach::onBeforePageDisplay';
$wgHooks['UploadForm:initial'][] = 'FileAttach::onUploadFormInitial';
$wgHooks['UploadForm:BeforeProcessing'][] = 'FileAttach::onUploadFormBeforeProcessing';
$wgHooks['SkinTemplateTabs'][] = 'FileAttach::onSkinTemplateTabs';
$wgHooks['SkinTemplateNavigation'][] = 'FileAttach::onSkinTemplateNavigation';
