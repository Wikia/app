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

$DATA = "$dir/core/common/main";
$OUTPUT = $dir;

if (isset( $options['datadir'] ) ) {
	$DATA = $options['datadir'];
}

if (isset( $options['outputdir'] ) ) {
	$OUTPUT = $options['outputdir'];
}

$langs = Language::getLanguageNames( false );
# hack to get pt-pt too
$langs['pt-pt'] = 'Foo';
ksort($langs);

foreach ( $langs as $code => $name ) {
	unset( $codePartStr );
	$codePartStr = explode( '-', $code );
	$countCode = count( $codePartStr );
	if ( count( $codePartStr ) > 1) {
		unset( $codePart );
		for ($i = 0; $i < count( $codePartStr ); $i++) {
			if ( isset( $codePartStr[$i] ) ) {
				$codePart[$i] = $codePartStr[$i];
			} else {
				$codePart[$i] = '';
			}
		}	
		// ISO 15924 alpha-4 script code
		if (strlen($codePart[1]) == 4 ) {
			$codePart[1] = ucfirst( $codePart[1] );
		}

		// ISO 3166-1 alpha-2 country code
		if (strlen($codePart[1]) == 2 ) {
			$codePart[2] = strtoupper( $codePart[1] );
			$codePart[1] = '';
		}
		if ( isset( $codePart[2] )) {
			if ( strlen( $codePart[2] ) == 2 ) {
				$codePart[2] = strtoupper( $codePart[2] );
			}
		}
		for ( $i = 0; $i < count($codePart); $i++ ) {
			if ( $codePart[$i] === '' )
				unset( $codePart[$i] );
		}
		$codeCLDR = implode( '-', $codePart );
	} else {
		$codeCLDR = $code;
	}

	$codeCLDR = str_replace(
			array( '-' ),
			array( '_' ),
			$codeCLDR
	);

	$input = "$DATA/$codeCLDR.xml";

	if ( file_exists( $input ) ) {
		$en = Language::factory('en');
		$p = new CLDRParser();
		$p->parse( $input, "$OUTPUT/" . LanguageNames::getFileName( getRealCode ( $code ) ) );
		while ($p->getAlias() != false) {
			$codeCLDR = $p->getAlias();
			$input = "$DATA/$codeCLDR.xml";
			echo "Alias $codeCLDR found for $code\n";
			$p->setAlias( false );
			$p->parse( $input, "$OUTPUT/" . LanguageNames::getFileName( getRealCode( $code ) ) );
		}
	} elseif (isset( $options['verbose'] ) ) {
		echo "File $input not found\n";
	}
}


class CLDRParser {
	private $ok = true;
	private $languages = false;
	private $alias = false;
	private $output = "<?php\n\$names = array(\n";
	private $count = 0;

	function s($parser, $name, $attrs) {
		if ( $name === 'LANGUAGES' ) {
			$this->languages = true;
		}
		if ( $name === 'ALIAS') {
			$this->alias = $attrs["SOURCE"];
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
		if ( $name === 'ALIAS' ) {
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

		if ($this->alias === false)
			$this->output .= ");\n";
		if ( $this->count == 1 )
			echo "Wrote $this->count entry to $output\n";
		else
			echo "Wrote $this->count entries to $output\n";

		if (!($fp = fopen($output, "w+"))) {
			die("could not open putput input");
		}

		fwrite($fp, $this->output);
		fclose($fp);

	}

	function getAlias() {
		return $this->alias;
	}
	function setAlias( $code ) {
		$this->alias = $code;
	}
}

// Get the code for the MediaWiki localisation,
// these are same as the fallback.
function getRealCode( $code ) {
	$realCode = $code;
	if ( !strcmp( $code, 'kk' ) )
		$realCode = 'kk-cyrl';
	else if ( !strcmp( $code, 'ku' ) )
		$realCode = 'ku-arab';
	else if ( !strcmp( $code, 'sr' ) )
		$realCode = 'sr-ec';
	else if ( !strcmp( $code, 'tg' ) )
		$realCode = 'tg-cyrl';
	else if ( !strcmp( $code, 'zh' ) )
		$realCode = 'zh-hans';
	else if ( !strcmp( $code, 'pt' ) )
		$realCode = 'pt-br';
	else if ( !strcmp( $code, 'pt-pt' ) )
		$realCode = 'pt';
	return $realCode;
}
