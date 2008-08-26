<?php
/**
 * Extract language names from cldr xml.
 * @author Niklas Laxström
 */

/**
 * Assuming default location $IP/extensions/cldr
 */
$IP = "../..";
require_once( "$IP/maintenance/commandLine.inc" );

$dir = dirname(__FILE__);
require_once( "$dir/LanguageNames.php" );

$DATA = "$dir/core/main";
$OUTPUT = $dir;

if (isset( $options['datadir'] ) ) {
	$DATA = $options['datadir'];
}

if (isset( $options['outputdir'] ) ) {
	$OUTPUT = $options['outputdir'];
}

$langs = Language::getLanguageNames( false );

foreach ( $langs as $code => $name ) {
	$codeCLDR = str_replace(
		array( '-', 'hans', 'hant', 'arab', 'latn'),
		array( '_', 'Hans', 'Hant', 'Arab', 'Latn' ),
		$code
	);

	$input = "$DATA/$codeCLDR.xml";

	if (file_exists( $input )) {
		$en = Language::factory('en');
		$p = new CLDRParser();
		$p->parse( $input, "$OUTPUT/" . LanguageNames::getFileName( $code ) );
	} else {
		echo "File $input not found\n";
	}
}


class CLDRParser {
	private $ok = true;
	private $languages = false;
	private $output = "<?php\n\$names = array(\n";
	private $count = 0;

	function s($parser, $name, $attrs) {
		if ( $name === 'LANGUAGES' ) {
			$this->languages = true;
		}

		$this->ok = false;
		if ( $this->languages && $name === 'LANGUAGE' ) {
			if (!isset($attrs["ALT"]) && !isset($attrs["DRAFT"])) {
				$this->ok = true;
				$type = str_replace( '_', '-', strtolower($attrs['TYPE']));
				$this->output .= "'$type' => '";
			}
		}
	}

	function e($parser, $name) {
		if ( $name === 'LANGUAGES' ) {
			$this->languages = false;
			$this->ok = false;
			return;
		}
		if (!$this->ok) return;
		$this->output .= "',\n";
	}

	function c($parser, $data) {
		if (!$this->ok) return;
		if (trim($data) === '') return;
		$this->output .= preg_replace( "/(?<!\\\\)'/", "\'", trim($data));
		$this->count++;
	}

	function parse($input, $output) {

		$xml_parser = xml_parser_create();
		xml_set_element_handler($xml_parser, array($this,'s'), array($this,'e'));
		xml_set_character_data_handler($xml_parser, array($this,'c'));
		if (!($fp = fopen($input, "r"))) {
				die("could not open XML input");
		}

		while ($data = fread($fp, filesize($input))) {
				if (!xml_parse($xml_parser, $data, feof($fp))) {
						die(sprintf("XML error: %s at line %d",
												xml_error_string(xml_get_error_code($xml_parser)),
												xml_get_current_line_number($xml_parser)));
				}
		}
		xml_parser_free($xml_parser);

		fclose($fp);

		if ( !$this->count ) { return; }

		$this->output .= ");\n";
		echo "Wrote $this->count entries to $output\n";

		if (!($fp = fopen($output, "w+"))) {
			die("could not open putput input");
		}

		fwrite($fp, $this->output);
		fclose($fp);

	}

}
?>