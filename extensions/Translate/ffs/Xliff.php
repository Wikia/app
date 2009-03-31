<?php
/**
 * Basic support for XLIFF (XML Localization Interchange File Format).
 * http://docs.oasis-open.org/xliff/xliff-core/xliff-core.html
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

/**
 * This writer creates standard compliant XLIFF documents. Currently it only
 * writes little more than what is mandatory.
 */
class XliffFormatWriter extends SimpleFormatWriter {
	// Re-implemented
	protected function exportLanguage( $target, MessageCollection $collection ) {
		$code = $collection->code;
		$w = new XMLWriter();
		$w->openMemory();

		$w->setIndent( true );
		$this->header( $w, $target, $code );
		$this->messages( $w, $target, $collection );
		$this->footer( $w, $target, $code );
	}

	/**
	 * Writes very minimalistic header that validates XLIFF schema.
	 */
	protected function header( XMLWriter $w, $handle, $code ) {
		$header = '';
		$w->startDocument( '1.0', 'UTF-8' );

		// http://docs.oasis-open.org/xliff/v1.2/os/xliff-core.html#Specs_XMLDecl
		$w->startElement ( 'xliff' ); // level 0
		$w->writeAttribute( 'version', '1.2' );
		$w->writeAttribute( 'xmlns', 'urn:oasis:names:tc:xliff:document:1.2' );
		$w->writeAttribute( 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance' );
		$w->writeAttribute( 'xsi:schemaLocation', 'urn:oasis:names:tc:xliff:document:1.2 xliff-core-1.2.xsd' );

		// http://docs.oasis-open.org/xliff/v1.2/os/xliff-core.html#file
		$w->startElement( 'file' ); // level 1
		$w->writeAttribute( 'source-language', 'en' );
		$w->writeAttribute( 'target-language', $code );
		// TODO: use better type depending on the group
		$w->writeAttribute( 'datatype', 'x-wiki' );
		// doesn't make any sense
		$w->writeAttribute( 'original', $this->group->getId() );
		
		fwrite( $handle, $w->outputMemory( true ) );
	}

	/**
	 * Exports the messages to XLIFF trans-units.
	 * TODO: Add more information like provided in the web interface.
	 */
	protected function messages( XMLWriter $w, $handle, MessageCollection $collection ) {
		$w->startElement( 'body' );

		foreach ( $collection->keys() as $key ) {
			$w->startElement( 'trans-unit' );
			$w->writeAttribute( 'id', $key );
			$w->writeElement( 'source', $collection[$key]->definition );
			$translation = $collection[$key]->translation;
			if ( $translation !== null ) {
				$w->writeElement( 'target',  $translation );
			}
			$w->endElement();
			fwrite( $handle, $w->outputMemory( true ) );
		}
		$w->endElement(); // </body>
	}

	/**
	 * Ends the XLIFF document
	 */
	protected function footer( XMLWriter $w, $handle, $code ) {
		$w->endElement(); // </file>
		$w->endElement(); // </xliff>
		fwrite( $handle, $w->outputMemory( true ) );
	}
}