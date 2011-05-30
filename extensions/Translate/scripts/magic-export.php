<?php

/**
 * Script to export special page aliases and magic words of extensions.
 *
 * @author Robert Leverington <robert@rhl.me.uk>
 *
 * @copyright Copyright © 2010 Robert Leverington
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

require( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/maintenance/Maintenance.php' );

/**
 * Maintenance class for the fast export of special page aliases and magic words.
 */
class MagicExport extends Maintenance {
	protected $type;
	protected $target;

	protected $handles = array();
	protected $messagesOld = array();

	public function __construct() {
		parent::__construct();

		$this->addOption( 'target', 'Target directory for exported files', true, true );
		$this->addOption( 'type', 'magic or special', true, true );
	}

	public function execute() {
		$this->target = $this->getOption( 'target' );
		$this->type = $this->getOption( 'type' );

		switch( $this->type ) {
			case 'special':
			case 'magic':
				break;
			default:
				die( 'Invalid type.' );
		}

		$this->openHandles();
		$this->writeHeaders();
		$this->writeFiles();
		$this->writeFooters();
		$this->closeHandles();
	}

	/**
	 * Itterate through all groups, loading current data from the existing
	 * extension and opening message files for message output.
	 *  - If the group does not define a special page alias file or magic
	 *    words file, or that file does not exist, it is ignored silently.
	 *  - If the file does contain a data array (e.g. $aliases) then the
	 *    program exits.
	 */
	protected function openHandles() {
		$this->output( "Opening file handles and loading current data...\n" );

		$groups = MessageGroups::singleton()->getGroups();
		foreach ( $groups as $group ) {
			if ( !$group instanceof ExtensionMessageGroup ) {
				continue;
			}

			switch ( $this->type ) {
				case 'special':
					$filename = $group->getAliasFile();
					break;
				case 'magic':
					$filename = $group->getMagicFile();
					break;
			}

			if ( $filename === null ) {
				continue;
			}

			global $wgTranslateExtensionDirectory;
			$inFile = "$wgTranslateExtensionDirectory/$filename";
			$dir = dirname( $inFile );
			if ( !file_exists( $inFile ) )  {
				continue;
			}

			include( $inFile );
			switch( $this->type ) {
				case 'special':
					if ( isset( $aliases ) ) {
						$this->messagesOld[$group->getId()] = $aliases;
						unset( $aliases );
					} elseif ( isset( $specialPageAliases ) ) {
						$this->messagesOld[$group->getId()] = $specialPageAliases;
						unset( $specialPageAliases );
					} else {
						die( "File '$inFile' does not contain an aliases array.\n" );
					}
					break;
				case 'magic':
					if ( !isset( $magicWords ) ) {
						die( "File '$inFile' does not contain a magic words array.\n" );
					}
					$this->messagesOld[$group->getId()] = $magicWords;
					unset( $magicWords );
					break;
			}

			$outFile = $this->target . '/' . $filename;
			wfMkdirParents( dirname( $outFile ) );
			$this->handles[$group->getId()] = fopen( $outFile, 'w' );
			fwrite( $this->handles[$group->getId()], $this->readHeader( $inFile ) );

			$this->output( "\t{$group->getId()}\n" );
		}
	}

	protected function readHeader( $file ) {
		$data = file_get_contents( $file );

		// Seek first '*/'.
		$end = strpos( $data, '*/' ) + 2;

		if ( $end === false ) {
			die( "No header found in '$file'.\n" );
		}

		// Grab header.
		return substr( $data, 0, $end );
	}

	/**
	 * Write the opening of the files for each output file handle.
	 */
	protected function writeHeaders() {
		foreach ( $this->handles as $handle ) {
			switch( $this->type ) {
				case 'special':
					fwrite( $handle, <<<PHP


\$specialPageAliases = array();
PHP
					);
					break;
				case 'magic':
					fwrite( $handle, <<<PHP


\$magicWords = array();
PHP
					);
				break;
			}
		}
	}

	/**
	 * Itterate through available languages, loading and parsing the data
	 * message from the MediaWiki namespace and writing the data to its output
	 * file handle.
	 */
	protected function writeFiles() {
		$langs = self::parseLanguageCodes( '*' );
		unset( $langs[array_search( 'en', $langs )] );
		$langs = array_merge( array( 'en' ), $langs );
		foreach ( $langs as $l ) {
			// Load message page.
			switch ( $this->type ) {
				case 'special':
					$title = Title::makeTitleSafe( NS_MEDIAWIKI, 'Sp-translate-data-SpecialPageAliases/' . $l );
					break;
				case 'magic':
					$title = Title::makeTitleSafe( NS_MEDIAWIKI, 'Sp-translate-data-MagicWords/' . $l );
					break;
				default:
					exit( 1 );
			}

			// Parse message page.
			if ( !$title || !$title->exists() ) {
				$this->output( "Skiping $l...\n" );

				$messagesNew = array();
			} else {
				$this->output( "Processing $l...\n" );

				$article = new Article( $title );
				$data = $article->getContent();

				// Parse message file.
				$segments = explode( "\n", $data );
				array_shift( $segments );
				array_shift( $segments );
				unset( $segments[count( $segments ) -1] );
				unset( $segments[count( $segments ) -1] );
				$messagesNew = array();
				foreach ( $segments as $segment ) {
					$parts = explode( ' = ', $segment );
					$key = array_shift( $parts );
					$translations = explode( ', ', implode( $parts ) );
					$messagesNew[$key] = $translations;
				}
			}

			// Write data to handles.
			$namesEn = LanguageNames::getNames( 'en' );
				$namesNative = Language::getLanguageNames();
			foreach ( $this->handles as $group => $handle ) {
				// Find messages to write to this handle.
				$messagesOut = array();
				foreach ( $this->messagesOld[$group]['en'] as $key => $message ) {
					if ( array_key_exists( $key, $messagesNew ) ) {
						$messagesOut[$key] = $messagesNew[$key];
					} elseif ( isset( $this->messagesOld[$group][$l][$key] ) ) {
						$messagesOut[$key] = $this->messagesOld[$group][$l][$key];
					}
				}

				// If there are messages to write, write them.
				if ( count( $messagesOut ) > 0 ) {
					switch( $this->type ) {
						case 'special':
							$out = "\n\n/** {$namesEn[$l]} ({$namesNative[$l]}) */\n\$specialPageAliases['{$l}'] = array(\n";
							break;
						case 'magic':
							$out = "\n\n/** {$namesEn[$l]} ({$namesNative[$l]}) */\n\$magicWords['{$l}'] = array(\n";
							break;
					}
					foreach ( $messagesOut as $key => $translations ) {
						foreach ( $translations as $id => $translation ) {
							$translations[$id] = addslashes( $translation );
							if ( $this->type === 'magic' && $translation == '0' ) {
									unset( $translations[$id] );
							}
						}
						$translations = implode( "', '", $translations );
						switch( $this->type ) {
							case 'special':
								$out .= "\t'$key' => array( '$translations' ),\n";
								break;
							case 'magic':
								if ( $this->messagesOld[$group]['en'][$key][0] === 0 ) {
									$out .= "\t'$key' => array( 0, '$translations' ),\n";
								} else {
									$out .= "\t'$key' => array( '$translations' ),\n";
								}
								break;
						}
					}
					$out .= ");";
					fwrite( $handle, $out );
				}
			}
		}
	}

	/**
	 * For special page aliases we set $aliases as a reference to
	 * the more modern $specialPageAliases for backwards compatibility.
	 */
	protected function writeFooters() {
		$this->output( "Writing file footers...\n" );
		if ( $this->type === 'special' ) {
			foreach ( $this->handles as $handle ) {
				fwrite( $handle, <<<PHP


/**
 * For backwards compatibility with MediaWiki 1.15 and earlier.
 */
\$aliases =& \$specialPageAliases;
PHP
				);
			}
		}
	}

	/**
	 * Close all output file handles.
	 */
	protected function closeHandles() {
		$this->output( "Closing file handles...\n" );
		foreach ( $this->handles as $handle ) {
			fclose( $handle );
		}
	}

	/**
	 * Copied from cli.inc.
	 */
	private static function parseLanguageCodes( /* string */ $codes ) {
		$langs = array_map( 'trim', explode( ',', $codes ) );
		if ( $langs[0] === '*' ) {
			$languages = Language::getLanguageNames();
			ksort( $languages );
			$langs = array_keys( $languages );
		}
		return $langs;
	}

}

$maintClass = "MagicExport";
require_once( DO_MAINTENANCE );
