<?php
/**
 * Hooks for EditSectionClearerLink extension
 *
 * @file
 * @ingroup Extensions
 */

class EditSectionClearerLinkHooks {

	/* Static Functions */

	/**
	 * interceptLink hook
	 */
	public static function reviseLink($this, $nt, $section, $tooltip, &$result)  {
		$linkName = "editSection-$section"; // the span around the link
		$anchorName = "editSectionAnchor-$section"; // the actual link anchor, generated in Linker::makeHeadline
		$chromeName = "editSectionChrome-$section"; // the chrome that surrounds the anchor	

		$result = preg_replace('/(\D+)( title=)(\D+)/', '${1} class=\'editSectionLinkInactive\' id=\'' . $anchorName . '\' onmouseover="editSectionHighlightOn(' . $section . ')" onmouseout="editSectionHighlightOff(' . $section . ')" title=$3', $result);
		$result = preg_replace('/<\/span>/', '<span class="editSectionChromeInactive" id=\'' . $chromeName . '\'>&#8690;</span></span>', $result);

		// while resourceloader loads this extension's css pretty late, it's still
		// overriden by skins/common/shared.css.  to get around that, insert an explicit style here.
		// i'd welcome a better way to do this.
		$result = preg_replace('/(<span class=\"editsection)/', '${1} editSectionInactive" style="float:none" id="' . $linkName, $result);

		return true;
	}

	/**
	 * interceptSection hook
	 */
	public static function reviseSection($this, $section, &$result, $editable)  {
		// skip section 0, since it has no edit link.
		if( $section === 0 ) {
			return true;
		}
		
		// swap the section edit links to the other side.  for some reason
		// Linker::makeHeadline places them on the left and then they're moved
		// to the right with a css hack.  That's teh lame, but I get the
		// feeling that changing it might make some folks unhappy.  For example,
		// anyone else who's written a nasty kludge like this
		$result = preg_replace( '/(<mw\:editsection.*<\/mw:editsection>)\s*(<span class="mw-headline".*<\/span>)/', '$2 $1', $result );

		// A DIV can span sections in wikimarkup, which will break this code.  Such
		// section-spanning DIVs are rare.  If one appears, leave it alone.
		//
		// count opening DIVs.
		preg_match_all( '/(<\s*div[\s>])/i', $result, $matches );
		$openingDivs = count( $matches[0] );

		// count closing DIVs.
		preg_match_all( '/(<\s*\/div[\s>])/i', $result, $matches );
		$closingDivs = count( $matches[0] );

		if ( $openingDivs !== $closingDivs ) {
			return true;
		}
				
		// wrap everything in a div.
		if ( $editable ) {
			$result = '<div class="editableSection" id="articleSection-' . $section . '"' .
				' onmouseover="editSectionActivateLink(\'' . $section . '\')" onmouseout="editSectionInactivateLink(\'' . $section . '\')">' . 
				$result . 
				'</div>';
		} else {
			$result = "<div class='nonEditableSection' id='articleSection-" . $section . "'>" . $result . '</div>';
		}
		
		return true;
	}

	/**
	 * Load resources with ResourceLoader (in this case, CSS and js)
	 */
	public static function addPageResources( &$outputPage, $parserOutput ) {
		$outputPage->addModules( 'ext.editSectionClearerLink' );
		return true;
	}
	
}
