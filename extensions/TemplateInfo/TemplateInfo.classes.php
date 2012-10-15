<?php
/**
 * Classes for TemplateInfo extension
 *
 * @file
 * @ingroup Extensions
 */

class TemplateInfo {

	/* Functions */

	public static function validateXML( $xml, &$error_msg ) {
		$xmlDTD =<<<END
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE template [
<!ELEMENT template (description?,params?,data*)>
<!ELEMENT templateinfo (param|group)*>
<!ELEMENT param (label?,description?,options?,type?,data*)>
<!ATTLIST param id ID #REQUIRED>
<!ELEMENT group (label?,description?,param*,data*)>
<!ELEMENT label (#PCDATA|msg)*>
<!ELEMENT description (#PCDATA|msg)*>
<!ELEMENT options (option*)>
<!ELEMENT option (#PCDATA|msg)*>
<!ELEMENT type (field*)>
<!ATTLIST type name CDATA #REQUIRED>
<!ELEMENT field EMPTY>
<!ATTLIST field name CDATA #REQUIRED>
<!ATTLIST field value CDATA #REQUIRED>
<!ELEMENT msg (#PCDATA)>
<!ATTLIST msg lang CDATA #REQUIRED>
<!ELEMENT data (field*)>
<!ATTLIST data app CDATA #REQUIRED>
]>

END;
		// we are using the SimpleXML library to do the XML validation
		// for now - this may change later
		// hide parsing warnings
		libxml_use_internal_errors(true);
		$xml_success = simplexml_load_string($xmlDTD . $xml);
		$errors = libxml_get_errors();
		$error_msg = $errors[0]->message;
		return $xml_success;
	}

	static function tableRowHTML($css_class, $data_type, $value = null) {
		$data_type = htmlspecialchars($data_type);
		if (is_null($value)) {
			$content = $data_type;
		} else {
			$content = "$data_type: " . HTML::element('span', array('class' => 'rowValue'), $value);
		}
		$cell = HTML::rawElement('td', array('colspan' => 2, 'class' => $css_class), $content);
		$text = HTML::rawElement('tr', null, $cell);
		$text .= "\n";
		return $text;
	}

	static function tableMessageRowHTML($css_class, $name, $value) {
		$cell1 = HTML::element('td', array('class' => $css_class), $name);
		$cell2 = HTML::element('td', array('class' => 'msg'), $value);
		$text = HTML::rawElement('tr', null, $cell1 . "\n" . $cell2);
		$text .= "\n";
		return $text;
	}

	static function parseTemplateInfo($template_info_xml) {
		$text = "<p>Template description:</p>\n";
		$text .= "<table class=\"templateInfo\">\n";
		foreach ($template_info_xml->children() as $tag => $child) {
			if ($tag == 'group') {
				$text .= self::parseParamGroup($child);
			} elseif ($tag == 'param') {
				$text .= self::parseParam($child);
			}
		}
		$text .= "</table>\n";
		return $text;
	}

	static function parseParamGroup($param_group_xml) {
		$id = $param_group_xml->attributes()->id;
		$text = self::tableRowHTML('paramGroup', 'Group', $id);
		foreach ($param_group_xml->children() as $child) {
			$text .= self::parseParam($child);
		}
		return $text;
	}

	static function parseParam($param_xml) {
		$id = $param_xml->attributes()->id;
		$text = self::tableRowHTML('param', 'Parameter', $id);
		foreach ($param_xml->children() as $tag_name => $child) {
			if ($tag_name == 'label') {
				$text .= self::parseParamLabel($child);
			} elseif ($tag_name == 'description') {
				$text .= self::parseParamDescription($child);
			} elseif ($tag_name == 'options') {
				$text .= self::parseParamOptions($child);
			} elseif ($tag_name == 'data') {
				$text .= self::parseParamData($child);
			} elseif ($tag_name == 'type') {
				$text .= self::parseParamType($child);
			}
		}
		return $text;
	}

	static function parseParamLabel($param_label_xml) {
		if (count($param_label_xml->children()) == 0) {
			$text = self::tableRowHTML('paramAttr', 'Label', $param_label_xml);
		} else {
			$text = self::tableRowHTML('paramAttr', 'Label');
			foreach ($param_label_xml->children() as $child) {
				$text .= self::parseMsg($child);
			}
		}
		return $text;
	}

	static function parseParamDescription($param_desc_xml) {
		if (count($param_desc_xml->children()) == 0) {
			$text = self::tableRowHTML('paramAttr', 'Description', $param_desc_xml);
		} else {
			$text = self::tableRowHTML('paramAttr', 'Description');
			foreach ($param_desc_xml->children() as $child) {
				$text .= self::parseMsg($child);
			}
		}
		return $text;
	}

	static function parseParamType($param_type_xml) {
		$name = $param_type_xml->attributes()->name;
		$text = self::tableRowHTML('paramAttr', 'Type', $name);
		return $text;
	}

	static function parseParamOptions($param_options_xml) {
		$text = self::tableRowHTML('paramOptions', 'Options');
		foreach ($param_options_xml->children() as $child) {
			$text .= self::parseParamOption($child);
		}
		return $text;
	}

	static function parseParamOption($param_option_xml) {
		$name = $param_option_xml->attributes()->name;
		$text = self::tableRowHTML('paramOption', 'Option', $name);
		if (count($param_option_xml->children()) == 0) {
			$text .= self::tableRowHTML('paramOptionMsg', $param_option_xml);
		} else {
			foreach ($param_option_xml->children() as $child) {
				$text .= self::parseOptionMsg($child);
			}
		}
		return $text;
	}

	static function parseMsg($msg_xml) {
		$language = $msg_xml->attributes()->language;
		$text = self::tableMessageRowHTML('paramAttrMsg', $language, $msg_xml);
		return $text;
	}

	static function parseOptionMsg($msg_xml) {
		$language = $msg_xml->attributes()->language;
		$text = self::tableMessageRowHTML('paramOptionMsg', $language, $msg_xml);
		return $text;
	}

	static function parseParamData($param_data_xml) {
		$app = $param_data_xml->attributes()->app;
		$text = self::tableRowHTML('paramData', 'Data for app', $app);
		foreach ($param_data_xml->children() as $child) {
			$text .= self::parseField($child);
		}
		return $text;
	}

	static function parseField($field_xml) {
		$name = $field_xml->attributes()->name;
		$text = self::tableMessageRowHTML('paramDataField', $name, $field_xml);
		return $text;
	}

}
