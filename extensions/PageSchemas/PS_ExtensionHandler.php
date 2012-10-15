<?php
/**
 * PSExtensionHandler - meant to be subclassed by the Page Schemas handler
 * class for each extension.
 *
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

class PSExtensionHandler {

	/**
	 * Creates an object to hold form-wide information, based on an XML
	 * object from the Page Schemas extension.
	 */
	public static function createPageSchemasObject( $tagName, $xml ) {
		return array();
	}

	/**
	 * Creates Page Schemas XML for form-wide information.
	 */
	public static function createSchemaXMLFromForm() {
		return null;
	}

	/**
	 * Creates Page Schemas XML for form information on templates.
	 */
	public static function createTemplateXMLFromForm() {
		return null;
	}

	/**
	 * Creates Page Schemas XML for form fields.
	 */
	public static function createFieldXMLFromForm() {
		return null;
	}

	public static function getDisplayColor() {
		return 'white';
	}

	public static function getSchemaDisplayString() {
		return null;
	}

	public static function getSchemaEditingHTML( $pageSchema ) {
		return null;
	}

	public static function getTemplateDisplayString() {
		return null;
	}

	public static function getTemplateEditingHTML( $psTemplate ) {
		return null;
	}

	public static function getFieldDisplayString() {
		return null;
	}

	/**
	 * Returns the HTML for inputs to define a single form field,
	 * within the Page Schemas 'edit schema' page.
	 */
	public static function getFieldEditingHTML( $psField ) {
		return null;
	}

	public static function getFieldInfo( $psTemplate ) {
		return null;
	}

	/**
	 * Return the list of pages that Semantic Forms could generate from
	 * the current Page Schemas schema.
	 */
	public static function getPagesToGenerate( $psSchemaObj ) {
		return array();
	}

	/**
	 * Generate pages (form and templates) specified in the list.
	 */
	public static function generatePages( $psSchemaObj, $selectedPages ) {
	}

	public static function getSchemaDisplayValues( $schemaXML ) {
		return null;
	}

	/**
	 * Displays form details for one template in the Page Schemas XML.
	 */
	public static function getTemplateDisplayValues( $templateXML ) {
		return null;
	}

	/**
	 * Displays data on a single form input in the Page Schemas XML.
	 */
	public static function getFieldDisplayValues( $fieldXML ) {
		return null;
	}
}
