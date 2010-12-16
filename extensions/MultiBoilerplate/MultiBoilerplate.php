<?php

/**
 * Allows a boilerplate to be selected from a drop down box located above the
 * edit form when editing non-exstant pages or, optionally (based upon
 * configuration variable $wgMultiBoilerplateOverwrite), load the template
 * over the current contents. 
 * 
 *
 * @addtogroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:MultiBoilerplate
 *
 * @author Robert Leverington <robert@rhl.me.uk>
 * @copyright Copyright © 2007 - 2009 Robert Leverington.
 * @copyright Copyright © 2009 Al Maghi.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

// If this is run directly from the web die as this is not a valid entry point.
if( !defined( 'MEDIAWIKI' ) ) die( 'Invalid entry point.' );

// Extension credits.
$wgExtensionCredits[ 'other' ][] = array(
	'path'           => __FILE__,
	'name'           => 'MultiBoilerplate',
	'description'    => 'Allows a boilerplate to be selected from a drop down box located above the edit form when editing pages.',
	'descriptionmsg' => 'multiboilerplate-desc',
	'author'         => array( 'Robert Leverington', 'Al Maghi' ),
	'url'            => 'http://www.mediawiki.org/wiki/Extension:MultiBoilerplate',
	'version'        => '1.8.0',
);

// Hook into EditPage::showEditForm:initial to modify the edit page header.
$wgHooks[ 'EditPage::showEditForm:initial' ][] = 'efMultiBoilerplate';

// Set extension messages file.
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles[ 'MultiBoilerplate' ] = $dir . 'MultiBoilerplate.i18n.php';
$wgExtensionMessagesFiles[ 'MultiBoilerplate' ] = $dir . 'MultiBoilerplate.i18n.php';
$wgAutoloadClasses['SpecialBoilerplates'] = $dir . 'SpecialBoilerplates_body.php';
$wgSpecialPages['Boilerplates'] = 'SpecialBoilerplates';
$wgSpecialPageGroups['Boilerplates'] = 'wiki'; //section of [[Special:SpecialPages]]

// Default configuration variables.
/* Array of boilerplate names to boilerplate pages to load, for example:
 * e.g. $wgMultiBoilerplateOptions[ 'My Boilerplate' ] = 'Template:My Boilerplate';
 * If set to false then the MediaWiki:multiboilerplate message is used to configure
 * boilerplates in the format of:
 * "* Boilerplate Name|Template:Boilerplate Template"
 */
$wgMultiBoilerplateOptions = array(); 
/* Whether or not to show the form when editing pre-existing pages. */
$wgMultiBoilerplateOverwrite = false;
/* Whether or not to display a special page listing boilerplates.
 * If set to true then the special page exists. */
$wgMultiBoilerplateDiplaySpecialPage = false;
 
$wgHooks['SpecialPage_initList'][]='efBoilerplateDisplaySpecialPage'; 
function efBoilerplateDisplaySpecialPage( &$aSpecialPages ) {
	global $wgMultiBoilerplateDiplaySpecialPage;
	if ( !$wgMultiBoilerplateDiplaySpecialPage ) {
		unset( $aSpecialPages['Boilerplates'] );
	}
	return true;
}


/**
 * Generate the form to be displayed at the top of the edit page and insert it.
 * @param $form EditPage object.
 * @return true
 */
function efMultiBoilerplate( $form ) {

	// Get various variables needed for this extension.
	global $wgMultiBoilerplateOptions, $wgMultiBoilerplateOverwrite, $wgTitle, $wgRequest;

	// Load messages into the message cache.
	wfLoadExtensionMessages( 'MultiBoilerplate' );

	// If $wgMultiBoilerplateOverwrite is true then detect whether
	// the current page exists or not and if it does return true
	// to end execution of this function.
	if( !$wgMultiBoilerplateOverwrite && $wgTitle->exists( $wgTitle->getArticleID() ) ) return true;

	// Generate the options list used inside the boilerplate selection box.
	// If $wgMultiBoilerplateOptions is an array then use that, else fall back
	// to the MediaWiki:Multiboilerplate message.
	if( is_array( $wgMultiBoilerplateOptions ) ) {
		$options = '';
		foreach( $wgMultiBoilerplateOptions as $name => $template ) {
			$selected = false;
			if( $wgRequest->getVal( 'boilerplate' ) == $template ) $selected = true;
			$options .= Xml::option( $name, $template, $selected );
		}
	} else {
		$things = wfMsgForContent( 'multiboilerplate' );
		$options = '';
		$things = explode( "\n", str_replace( "\r", "\n", str_replace( "\r\n", "\n", $things ) ) ); // Ensure line-endings are \n
		foreach( $things as $row ) {
			if ( substr( ltrim( $row ), 0, 1)==="*" ) {
				$row = ltrim( $row, '* ' ); // Remove the asterix (and a space if found) from the start of the line.
				$row = explode( '|', $row );
				if( !isset( $row[ 1 ] ) ) return true; // Invalid syntax, abort.
				$selected = false;
				if( $wgRequest->getVal( 'boilerplate' ) == $row[ 1 ] ) $selected = true;
				$options .= Xml::option( $row[ 0 ], $row[ 1 ], $selected );
			}
		}
	}

	// No options found in either configuration file, abort.
	if( $options == '' ) return true;

	// Append the selection form to the top of the edit page.
	$form->editFormPageTop .=
		Xml::openElement( 'form', array( 'id' => 'multiboilerplateform', 'name' => 'multiboilerplateform', 'method' => 'get', 'action' => $wgTitle->getEditURL() ) ) .
			Xml::openElement( 'fieldset' ) .
				Xml::element( 'legend', null, wfMsg( 'multiboilerplate-legend' ) ) .
				Xml::openElement( 'label' ) .
					wfMsg( 'multiboilerplate-label' ) .
					Xml::openElement( 'select', array( 'name' => 'boilerplate' ) ) .
						$options .
					Xml::closeElement( 'select' ) .
				Xml::closeElement( 'label' ) .
				' ' .
				Xml::hidden( 'action', 'edit' ) .
				Xml::hidden( 'title', $wgRequest->getText( 'title' ) ) .
				Xml::submitButton( wfMsg( 'multiboilerplate-submit' ) ) .
			Xml::closeElement( 'fieldset' ) .
		Xml::closeElement( 'form' );

	// If the Load button has been pushed replace the article text with the boilerplate.
	if( $wgRequest->getText( 'boilerplate', false ) ) {
		$plate = new Article( Title::newFromURL( $wgRequest->getVal( 'boilerplate' ) ) );
		$content = $plate->fetchContent();
		/* Strip out noinclude tags and contained data, and strip includeonly
		 * tags (but retain contained data). If a function exists in the
		 * parser exists to do this it would be nice to replace this with it (I
		 * found one with a name as if it would do this, but it didn't seam to
		 * work).
		 */
		$content = preg_replace( '#<noinclude>(.*?)</noinclude>#', '', $content );
		$content = preg_replace( '#<includeonly>(.*?)</includeonly>#', '$1', $content );
		// TODO: Handle <onlyinclude> tags.
		$form->textbox1 = $content;
	}

	// Return true so things don't break.
	return true;

}
