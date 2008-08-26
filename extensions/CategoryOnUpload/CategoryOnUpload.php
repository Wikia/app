<?php

/**
 * CategoryOnUpload Extension
 *
 * Adds a selection box to the upload page for choosing a category.
 *
 * Warning: Should not be enabled on wikis with lots of categories.
 *
 * @ingroup Extensions
 * 
 * @link http://www.mediawiki.org/wiki/Extension:CategoryOnUpload
 *
 * @author MinuteElectron <minuteelectron@googlemail.com>
 * @copyright Copyright © 2008 MinuteElectron.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

// Ensure accessed via a valid entry point.
if( !defined( 'MEDIAWIKI' ) ) die( 'Invalid entry point.' );

// Register extension credits.
$wgExtensionCredits[ 'other' ][] = array(
	'name'          => 'CategoryOnUpload',
	'url'           => 'http://www.mediawiki.org/wiki/Extension:CategoryOnUpload',
	'author'        => 'MinuteElectron',
	'version'       => '1.0',
	'description'   => 'Prompts a user to select a category when uploading a file.',
	'decriptionmsg' => 'categoryonupload-desc'
);

// Register internationalisation file.
$wgExtensionMessagesFiles[ 'CategoryOnUpload' ] = dirname( __FILE__ ) . '/CategoryOnUpload.i18n.php';

// Register required hooks.
$wgHooks[ 'UploadForm:initial'          ][] = 'efCategoryOnUploadForm';
$wgHooks[ 'UploadForm:BeforeProcessing' ][] = 'efCategoryOnUploadProcess';

// Initialize configuration variables.
$wgCategoryOnUploadDefault = null;
$wgCategoryOnUploadAllowNone = true;

/**
 * Adds a category selection box to the end of the default UploadForm table.
 */
function efCategoryOnUploadForm( $uploadFormObj ) {

	/* Get the database prefix, needed for 1.12 to do custom query. When 1.13
	 * is released it can be removed and the category table used instead.
	 */
	global $wgDBprefix;

	/* Load extension messages, currently only used for the label beside the
	 * select box.
	 */
	wfLoadExtensionMessages( 'CategoryOnUpload' );

	/* Begin generation of the form, output the table row, label, open the
	 * select box, and add the default option for not adding a category at all.
	 */
	$cat =
		Xml::openElement( 'tr' ) .
			Xml::openElement( 'td', array( 'align' => 'right' ) ) .
				Xml::label( wfMsg( 'categoryonupload-label' ), 'wpUploadCategory' ) .
			Xml::closeElement( 'td' ) .
			Xml::openElement( 'td' ) .
				Xml::openElement( 'select', array( 'name' => 'wpUploadCategory', 'id' => 'wpUploadCategory' ) );

	/* Get whether or not to allow the "none" option.
	 */
	global $wgCategoryOnUploadAllowNone;

	/* If permitted output the "none" option.
	 */
	if( $wgCategoryOnUploadAllowNone ) {

		$cat .=
					Xml::option( wfMsg( 'categoryonupload-none' ), '#' );

	}

	/* Get a database read object.
	 */
	$dbr = wfGetDB( DB_SLAVE );

	/* Perform a query on the categorylinks table to retreieve a list of all
	 * cateogries, this probably shouldn't be installed on wikis with more than
	 * a few hundred categories as the list would be very long.  If anyone ever
	 * feels the need to put this extension on such a wiki, a dynamic AJAX
	 * interface could be created; but when it was developed only a few needed
	 * to be displayed so this was not an issue.  Fallback to the select box is
	 * essential no matter what improvements are made.
	 * 
	 * It would be nice to use the category table to avoid having to do a
	 * manual query and perhaps improve performance, but it appears to not
	 * descriminate between existing and non-existing categories, this would be
	 * essential; probably needs more looking in to however.  Also it would be
	 * nice not to use it until 1.13 is released so that it works on at least
	 * the latest release.
	 */
	$res = $dbr->query( 'SELECT DISTINCT cl_to FROM ' . $wgDBprefix . 'categorylinks' );

	/* Get deault category, to compare with category option being output, so the
	 * default category can be selected.
	 */
	global $wgCategoryOnUploadDefault;

	/* Generate an option for each of the categories in the wiki and add.  A
	 * title object could be generated for each of the categories so that the
	 * hacky replacement of '_' to ' ' could be removed, but it seams a waste
	 * of resources.  If this becomes an issue simply remove the # comments and
	 * comment out the first line.
	 */
	while( $row = $dbr->fetchObject( $res ) ) {

		$text   = str_replace( '_', ' ', $row->cl_to );
		#$title = Title::newFromText( $row->cl_to, NS_CATEGORY );
		#$text  = $title->getText();

		/* Add option to output, if it is the default then make it selected too.
		 */
		$cat .= Xml::option( $text, $row->cl_to, ( $text == $wgCategoryOnUploadDefault ) );

	}

	/* Close all the open elements, finished generation.
	 */
	$cat .=
				Xml::closeElement( 'select' ) .
			Xml::closeElement( 'td' ) .
		Xml::closeElement( 'tr' );

	/* Add the category selector to the start of the form so that other
	 * extensions can still change stuff and this doesn't override them. But we
	 * can be sure that the table hasn't been closed.
	 */
	$old = $uploadFormObj->uploadFormTextAfterSummary;
	$uploadFormObj->uploadFormTextAfterSummary = $cat . $old;

	/* Return true to ensure processing is continued and an exception is not
	 * generated.
	 */
	return true;

}

/**
 * Append the category statement to the end of the upload summary.
 */
function efCategoryOnUploadProcess( $uploadFormObj ) {

	/* Get the request object.
	 */
	global $wgRequest;

	/* Get the name of the category being added.
	 */
	$cat = $wgRequest->getText( 'wpUploadCategory' );

	/* Append the category statement to the end of the upload summary if the
	 * cateogry is not '#' (indicating no category to be added).
	 */
	if( $cat != '#' ) {
		$uploadFormObj->mComment .= "\n" . '[[Category:' . $wgRequest->getText( 'wpUploadCategory' ) . ']]';
	}

	/* Return true to ensure processing is continued and an exception is not
	 * generated.
	 */
	return true;

}