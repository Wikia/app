<?php

/**
 * Functions for handling Semantic Internal Objects data within the Page Schemas
 * extension.
 * 
 * @author Yaron Koren
 * @file SIO_PageSchemas.php
 * @ingroup SIO
 */

class SIOPageSchemas extends PSExtensionHandler {
	public static function registerClass() {
		global $wgPageSchemasHandlerClasses;
		$wgPageSchemasHandlerClasses[] = 'SIOPageSchemas';
		return true;
	}

	public static function getDisplayColor() {
		return '#FF8';
	}

	public static function getTemplateDisplayString() {
		return wfMsg( 'semanticinternalobjects-internalproperty' );
	}

	/**
	 * Returns the display info for the property (if any is defined)
	 * for a single field in the Page Schemas XML.
	 */
	public static function getTemplateDisplayValues( $templateXML ) {
		foreach ( $templateXML->children() as $tag => $child ) {
			if ( $tag == "semanticinternalobjects_MainProperty" ) {
				$propName = $child->attributes()->name;
				$values = array();
				return array( $propName, $values );
			}
		}
		return null;
	}

	/**
	 * Constructs XML for the SIO property, based on what was submitted
	 * in the 'edit schema' form.
	 */
	public static function createTemplateXMLFromForm() {
		global $wgRequest;

		$xmlPerTemplate = array();
		foreach ( $wgRequest->getValues() as $var => $val ) {
			if ( substr( $var, 0, 18 ) == 'sio_property_name_' ) {
				$templateNum = substr( $var, 18 );
				$xml = '<semanticinternalobjects_MainProperty name="' . $val . '" />';
				$xmlPerTemplate[$templateNum] = $xml;
			}
		}
		return $xmlPerTemplate;
	}

	/**
	 * Returns the HTML necessary for getting information about the
	 * semantic property within the Page Schemas 'editschema' page.
	 */
	public static function getTemplateEditingHTML( $psTemplate) {
		$prop_array = array();
		$hasExistingValues = false;
		if ( !is_null( $psTemplate ) ) {
			$prop_array = $psTemplate->getObject( 'semanticinternalobjects_MainProperty' );
			if ( !is_null( $prop_array ) ) {
				$hasExistingValues = true;
			}
		}
		$text = '<p>' . 'Name of property to connect this template\'s fields to the rest of the page (should only be used if this template can have multiple instances):' . ' ';
		$propName = PageSchemas::getValueFromObject( $prop_array, 'name' );
		$text .= Html::input( 'sio_property_name_num', $propName, array( 'size' => 15 ) ) . "\n";

		return array( $text, $hasExistingValues );
	}

	/**
	 * Returns the property based on the XML passed from the Page Schemas
	 * extension.
	*/
	public static function createPageSchemasObject( $tagName, $xml ) {
		if ( $tagName == "semanticinternalobjects_MainProperty" ) {
			foreach ( $xml->children() as $tag => $child ) {
				if ( $tag == $tagName ) {
					$sio_array = array();
					$propName = $child->attributes()->name;
					$sio_array['name'] = (string)$propName;
					foreach ( $child->children() as $prop => $value ) {
						$sio_array[$prop] = (string)$value;
					}
					return $sio_array;
				}
			}
		}
		return null;
	}

	static function getInternalObjectPropertyName ( $psTemplate ) {
		// TODO - there should be a more direct way to get
		// this data.
		$sioPropertyArray = $psTemplate->getObject( 'semanticinternalobjects_MainProperty' );
		return PageSchemas::getValueFromObject( $sioPropertyArray, 'name' );
	}

	public static function getPagesToGenerate( $pageSchemaObj ) {
		$pagesToGenerate = array();
		$psTemplates = $pageSchemaObj->getTemplates();
		foreach ( $psTemplates as $psTemplate ) {
			$sioPropertyName = self::getInternalObjectPropertyName( $psTemplate );
			if ( is_null( $sioPropertyName ) ) {
				continue;
			}
			$pagesToGenerate[] = Title::makeTitleSafe( SMW_NS_PROPERTY, $sioPropertyName );
		}
		return $pagesToGenerate;
	}

	public static function generatePages( $pageSchemaObj, $selectedPages ) {
		global $smwgContLang, $wgUser;

		$datatypeLabels = $smwgContLang->getDatatypeLabels();
		$pageTypeLabel = $datatypeLabels['_wpg'];

		$jobs = array();
		$jobParams = array();
		$jobParams['user_id'] = $wgUser->getId();

		$psTemplates = $pageSchemaObj->getTemplates();
		foreach ( $psTemplates as $psTemplate ) {
			$sioPropertyName = self::getInternalObjectPropertyName( $psTemplate );
			if ( is_null( $sioPropertyName ) ) {
				continue;
			}
			$propTitle = Title::makeTitleSafe( SMW_NS_PROPERTY, $sioPropertyName );
			if ( !in_array( $propTitle, $selectedPages ) ) {
				continue;
			}
			$jobParams['page_text'] = SMWPageSchemas::createPropertyText( $pageTypeLabel, null );
			$jobs[] = new PSCreatePageJob( $propTitle, $jobParams );
		}
		Job::batchInsert( $jobs );
	}
}
