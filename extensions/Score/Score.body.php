<?php
/*
	Score, a MediaWiki extension for rendering musical scores with LilyPond.
	Copyright © 2011 Alexander Klauer

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.

	To contact the author:
	<Graf.Zahl@gmx.net>
	http://en.wikisource.org/wiki/User_talk:GrafZahl
	https://github.com/TheCount/score

 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file cannot be run standalone.\n" );
}

/**
 * Helper class for mixing profiling with code that throws exceptions.
 * It produces matching wfProfileIn/Out calls for scopes.
 * This class would be superfluous if PHP had a try-finally construct.
 */
class ScopedProfiling {
	/**
	 * Profiling ID such as a method name.
	 */
	private $id;

	/**
	 * Creates new scoped profiling.
	 * The new scoped profiling will profile out as soon as its destructor
	 * is called (normally when the variable holding the created object
	 * goes out of scope).
	 *
	 * @param $id string profiling ID, most commonly a method name.
	 */
	public function __construct( $id ) {
		$this->id = $id;
		wfProfileIn( $id );
	}

	/**
	 * Out-profiles on end of scope.
	 */
	public function __destruct() {
		wfProfileOut( $this->id );
	}
}

/**
 * Score exception
 */
class ScoreException extends Exception {
	/**
	 * Constructor.
	 *
	 * @param $message Message to create error message from. Should have one $1 parameter.
	 * @param $code optionally, an error code.
	 * @param $previous Exception that caused this exception.
	 */
	public function __construct( $message, $code = 0, Exception $previous = null ) {
		parent::__construct( $message->inContentLanguage()->parse(), $code, $previous );
	}

	/**
	 * Auto-renders exception as HTML error message in the wiki's content
	 * language.
	 *
	 * @return error message HTML.
	 */
	public function  __toString() {
		return Html::rawElement(
			'span',
			array( 'class' => 'error' ),
			$this->getMessage()
		);
	}
}

/**
 * Score class.
 */
class Score {
	/**
	 * Cache directory name.
	 */
	const LILYPOND_DIR_NAME = 'lilypond';

	/**
	 * Default audio player width.
	 */
	const DEFAULT_PLAYER_WIDTH = 300;

	/**
	 * Supported score languages.
	 */
	private static $supportedLangs = array( 'lilypond', 'ABC' );

	/**
	 * LilyPond version string.
	 * It defaults to null and is set the first time it is required.
	 */
	private static $lilypondVersion = null;

	/**
	 * Throws proper ScoreException in case of failed shell executions.
	 *
	 * @param $message Message to display.
	 * @param $output collected output from wfShellExec().
	 *
	 * @throws ScoreException always.
	 */
	private static function throwCallException( $message, $output ) {
		throw new ScoreException(
			$message->rawParams(
				Html::rawElement( 'pre',
					array(),
					htmlspecialchars( $output )
				)
			)
		);
	}

	/**
	 * Determines the version of LilyPond in use and writes the version
	 * string to self::$lilypondVersion.
	 *
	 * @throws ScoreException if LilyPond could not be executed properly.
	 */
	private static function getLilypondVersion() {
		global $wgScoreLilyPond;

		$prof = new ScopedProfiling( __METHOD__ );

		if ( !is_executable( $wgScoreLilyPond ) ) {
			throw new ScoreException( wfMessage( 'score-notexecutable', $wgScoreLilyPond ) );
		}

		$cmd = wfEscapeShellArg( $wgScoreLilyPond ) . ' --version 2>&1';
		$output = wfShellExec( $cmd, $rc );
		if ( $rc != 0 ) {
			self::throwCallException( wfMessage( 'score-versionerr' ), $output );
		}

		$n = sscanf( $output, 'GNU LilyPond %s', self::$lilypondVersion );
		if ( $n != 1 ) {
			self::$lilypondVersion = null;
			self::throwCallException( wfMessage( 'score-versionerr' ), $output );
		}
	}

	/**
	 * Creates the specified directory if it does not exist yet.
	 * Otherwise does nothing.
	 *
	 * @param $path string Path to directory to be created.
	 * @param $mode integer Chmod value of the new directory.
	 *
	 * @throws ScoreException if the directory does not exist and could not
	 * 	be created.
	 */
	private static function createDirectory( $path, $mode = null ) {
		if ( !is_dir( $path ) ) {
			$rc = wfMkdirParents( $path, $mode, __METHOD__ );
			if ( !$rc ) {
				throw new ScoreException( wfMessage( 'score-nooutput', $path ) );
			}
		}
	}

	/**
	 * Renders the score code (LilyPond, ABC, etc.) in a <score>…</score> tag.
	 *
	 * @param $code score code.
	 * @param $args array of score tag attributes.
	 * @param $parser Parser of Mediawiki.
	 * @param $frame PPFrame expansion frame, not used by this extension.
	 *
	 * @return Image link HTML, and possibly anchor to MIDI file.
	 */
	public static function render( $code, array $args, Parser $parser, PPFrame $frame ) {
		global $wgTmpDirectory, $wgUploadDirectory, $wgUploadPath;

		$prof = new ScopedProfiling( __METHOD__ );

		try {
			$options = array(); // options to self::generateHTML()

			/* temporary working directory to use */
			$fuzz = md5( mt_rand() );
			$options['factory_directory'] = $wgTmpDirectory . "/MWLP.$fuzz";

			/* Score language selection */
			if ( array_key_exists( 'lang', $args ) ) {
				$options['lang'] = $args['lang'];
			} else {
				$options['lang'] = 'lilypond';
			}
			if ( !in_array( $options['lang'], self::$supportedLangs ) ) {
				throw new ScoreException( wfMessage( 'score-invalidlang', htmlspecialchars( $options['lang'] ) ) );
			}

			/* Override MIDI file? */
			if ( array_key_exists( 'override_midi', $args ) ) {
				$file = wfFindFile( $args['override_midi'] );
				if ( $file === false ) {
					throw new ScoreException( wfMessage( 'score-midioverridenotfound', htmlspecialchars( $args['override_midi'] ) ) );
				}
				$options['override_midi'] = true;
				$options['midi_file'] = $file;
				$options['midi_path'] = $file->getLocalRefPath();
				/* Set OGG stuff in case Vorbis rendering is requested */
				$sha1 = $file->getSha1();
				$oggRel = self::LILYPOND_DIR_NAME . "/{$sha1[0]}/{$sha1[0]}{$sha1[1]}/$sha1.ogg";
				$options['ogg_path'] = "$wgUploadDirectory/$oggRel";
				$options['ogg_url'] = "$wgUploadPath/$oggRel";
			} else {
				$options['override_midi'] = false;
			}
	
			/* image file path and URL prefixes */
			$imageCacheName = wfBaseConvert( sha1( $code ), 16, 36, 31 );
			$imagePrefixEnd = self::LILYPOND_DIR_NAME . '/'
				. "{$imageCacheName[0]}/{$imageCacheName[0]}{$imageCacheName[1]}/$imageCacheName";
			$options['image_path_prefix'] = "$wgUploadDirectory/$imagePrefixEnd";
			$options['image_url_prefix'] = "$wgUploadPath/$imagePrefixEnd";

			/* Midi linking? */
			if ( array_key_exists( 'midi', $args ) ) {
				$options['link_midi'] = $args['midi'];
			} else {
				$options['link_midi'] = false;
			}
			if ( $options['link_midi'] ) {
				if ( $options['override_midi'] ) {
					$options['midi_url'] = $options['midi_file']->getUrl();
				} else {
					$options['midi_url'] = "{$options['image_url_prefix']}.midi";
				}
			}

			/* Override OGG file? */
			if ( array_key_exists( 'override_ogg', $args ) ) {
				$t = Title::newFromText( $args['override_ogg'], NS_FILE );
				if ( is_null( $t ) ) {
					throw new ScoreException( wfMessage( 'score-invalidoggoverride', htmlspecialchars( $args['override_ogg'] ) ) );
				}
				if ( !$t->isKnown() ) {
					throw new ScoreException( wfMessage( 'score-oggoverridenotfound', htmlspecialchars( $args['override_ogg'] ) ) );
				}
				$options['override_ogg'] = true;
				$options['ogg_name'] = $args['override_ogg'];
			} else {
				$options['override_ogg'] = false;
			}

			/* Vorbis rendering? */
			if ( array_key_exists( 'vorbis', $args ) ) {
				$options['generate_vorbis'] = $args['vorbis'];
			} else {
				$options['generate_vorbis'] = false;
			}
			if ( $options['generate_vorbis'] && !( class_exists( 'OggHandler' ) && class_exists( 'OggAudioDisplay' ) ) ) {
				throw new ScoreException( wfMessage( 'score-noogghandler' ) );
			}
			if ( $options['generate_vorbis'] && ( $options['override_ogg'] !== false ) ) {
				throw new ScoreException( wfMessage( 'score-vorbisoverrideogg' ) );
			}
			if ( $options['generate_vorbis'] && !$options['override_midi'] ) {
				$options['ogg_path'] = "{$options['image_path_prefix']}.ogg";
				$options['ogg_url'] = "{$options['image_url_prefix']}.ogg";
			}

			/* Generate MIDI? */
			$options['generate_midi'] = ( $options['override_midi'] === false ) && ( $options['link_midi'] || $options['generate_vorbis'] );
			if ( $options['generate_midi'] && !array_key_exists( 'midi_path', $options ) ) {
				$options['midi_path'] = "{$options['image_path_prefix']}.midi";
			}

			/* Raw rendering? */
			if ( array_key_exists( 'raw', $args ) ) {
				$options['raw'] = $args['raw'];
			} else {
				$options['raw'] = false;
			}

			$html = self::generateHTML( $parser, $code, $options );
		} catch ( ScoreException $e ) {
			$html = "$e";
		}

		return $html;
	}

	/**
	 * Generates the HTML code for a score tag.
	 *
	 * @param $parser Parser MediaWiki parser.
	 * @param $code string Score code.
	 * @param $options array of rendering options.
	 * 	The options keys are:
	 * 	* factory_directory: string Path to directory in which files
	 * 		may be generated without stepping on someone else's
	 * 		toes. The directory may not exist yet. Required.
	 * 	* generate_midi: bool Whether to create a MIDI file, either
	 * 		to subsequently generate a vorbis file, or to provide
	 * 		a link to the MIDI file. Required.
	 * 	* generate_vorbis: bool Whether to create an Ogg/Vorbis file in
	 * 		an OggHandler. If set to true, the override_ogg option
	 * 		must be set to false. Required.
	 * 	* image_path_prefix: string Prefix to the local image path.
	 * 		Required.
	 * 	* image_url_prefix: string Prefix to the image URL. Required.
	 * 	* lang: string Score language. Required.
	 * 	* link_midi: bool Whether to link to a MIDI file. Required.
	 * 	* midi_file: MIDI file object.
	 * 	* midi_path: string Local MIDI path. Required if the link_midi,
	 * 		override_midi, or the generate_vorbis option is set to
	 * 		true, ignored otherwise.
	 * 	* midi_url: string MIDI URL. Required if the link_midi option
	 * 		is set to true, ignored otherwise.
	 * 	* ogg_name: string Name of the OGG file. Required if the
	 * 		override_ogg option is set to true, ignored otherwise.
	 * 	* ogg_path: string Local Ogg/Vorbis path. Required if the
	 * 		generate_vorbis option is set to true, ignored
	 * 		otherwise.
	 * 	* ogg_url: string Ogg/Vorbis URL. Required if the
	 * 		generate_vorbis option is set to true, ignored
	 * 		otherwise.
	 * 	* override_midi: bool Whether to use a user-provided MIDI file.
	 * 		Required.
	 * 	* override_ogg: bool Whether to generate a wikilink to a
	 * 		user-provided OGG file. If set to true, the vorbis
	 * 		option must be set to false. Required.
	 * 	* raw: bool Whether to assume raw LilyPond code. Ignored if the
	 * 		language is not lilypond, required otherwise.
	 *
	 * @return string HTML.
	 *
	 * @throws ScoreException if an error occurs.
	 */
	private static function generateHTML( &$parser, $code, $options ) {
		global $wgOut;

		$prof = new ScopedProfiling( __METHOD__ );

		try {
			/* Generate PNG and MIDI files if necessary */
			$imagePath = "{$options['image_path_prefix']}.png";
			$multi1Path = "{$options['image_path_prefix']}-1.png";
			if ( ( !file_exists( $imagePath ) && !file_exists( $multi1Path ) )
					|| ( array_key_exists( 'midi_path', $options ) && !file_exists( $options['midi_path'] ) ) ) {
				self::generatePngAndMidi( $code, $options );
			}

			/* Generate Ogg/Vorbis file if necessary */
			if ( $options['generate_vorbis'] && !file_exists( $options['ogg_path'] ) ) {
				self::generateOgg( $options );
			}

			/* return output link(s) */
			if ( file_exists( $imagePath ) ) {
				$link = Html::rawElement( 'img', array(
					'src' => "{$options['image_url_prefix']}.png",
					'alt' => $code,
				) );
			} elseif ( file_exists( $multi1Path ) ) {
				$multiPathFormat = "{$options['image_path_prefix']}-%d.png";
				$multiUrlFormat = "{$options['image_url_prefix']}-%d.png";
				$link = '';
				for ( $i = 1; file_exists( sprintf( $multiPathFormat, $i ) ); ++$i ) {
					$link .= Html::rawElement( 'img', array(
						'src' => sprintf( $multiUrlFormat, $i ),
						'alt' => wfMessage( 'score-page' )->inContentLanguage()->numParams( $i )->plain()
					) );
				}
			} else {
				/* No images; this may happen in raw mode or when the user omits the score code */
				throw new ScoreException( wfMessage( 'score-noimages' ) );
			}
			if ( $options['link_midi'] ) {
				$link = Html::rawElement( 'a', array( 'href' => $options['midi_url'] ), $link );
			}
			if ( $options['generate_vorbis'] ) {
				try {
					$oh = new OggHandler();
					$oh->setHeaders( $wgOut );
					$oad = new OggAudioDisplay(
						new UnregisteredLocalFile( false, false, $options['ogg_path'] ),
						$options['ogg_url'],
						self::DEFAULT_PLAYER_WIDTH, 0, 0,
						$options['ogg_url'],
						false
					);
					$link .= $oad->toHtml( array( 'alt' => $code ) );
				} catch ( Exception $e ) {
					throw new ScoreException( wfMessage( 'score-novorbislink', htmlspecialchars( $e->getMessage() ) ), 0, $e );
				}
			}
			if ( $options['override_ogg'] !== false ) {
				try {
					$link .= $parser->recursiveTagParse( "[[File:{$options['ogg_name']}]]" );
				} catch ( Exception $e ) {
					throw new ScoreException( wfMessage( 'score-novorbislink', htmlspecialchars( $e->getMessage() ) ), 0, $e );
				}
			}
		} catch ( Exception $e ) {
			self::eraseFactory( $options['factory_directory'] );
			throw $e;
		}

		self::eraseFactory( $options['factory_directory'] );

		return $link;
	}

	/**
	 * Generates score PNG file(s) and possibly a MIDI file.
	 *
	 * @param $code string Score code.
	 * @param $options array Rendering options. They are the same as for
	 * 	Score::generateHTML(). The MIDI file specified by the midi_path
	 * 	option is generated if and only	if the generate_midi option
	 * 	evaluates to true.
	 *
	 * @throws ScoreException on error.
	 */
	private static function generatePngAndMidi( $code, $options ) {
		global $wgScoreLilyPond, $wgScoreTrim;

		$prof = new ScopedProfiling( __METHOD__ );

		/* Various filenames */
		$image = "{$options['image_path_prefix']}.png";
		$multiFormat = "{$options['image_path_prefix']}-%d.png";

		/* delete old files if necessary */
		if ( $options['generate_midi'] ) {
			self::cleanupFile( $options['midi_path'] );
		}
		self::cleanupFile( $image );
		for ( $i = 1; file_exists( $f = sprintf( $multiFormat, $i ) ); ++$i ) {
			self::cleanupFile( $f );
		}

		/* Create the working environment */
		$factoryDirectory = $options['factory_directory'];
		self::createDirectory( $factoryDirectory, 0700 );
		$factoryLy = "$factoryDirectory/file.ly";
		$factoryMidi = "$factoryDirectory/file.midi";
		$factoryImage = "$factoryDirectory/file.png";
		$factoryImageTrimmed = "$factoryDirectory/file-trimmed.png";
		$factoryMultiFormat = "$factoryDirectory/file-%d.png";
		$factoryMultiTrimmedFormat = "$factoryDirectory/file-%d-trimmed.png";

		/* Generate LilyPond input file */
		if ( $options['lang'] == 'lilypond' ) {
			if ( $options['raw'] ) {
				$lilypondCode = $code;
			} else {
				$lilypondCode = self::embedLilypondCode( $code, $options );
			}
			$rc = file_put_contents( $factoryLy, $lilypondCode );
			if ( $rc === false ) {
				throw new ScoreException( wfMessage( 'score-noinput', $factoryLy ) );
			}
		} else {
			$options['lilypond_path'] = $factoryLy;
			self::generateLilypond( $code, $options );
		}

		/* generate lilypond output files in working environment */
		$oldcwd = getcwd();
		if ( $oldcwd === false ) {
			throw new ScoreException( wfMessage( 'score-getcwderr' ) );
		}
		$rc = chdir( $factoryDirectory );
		if ( !$rc ) {
			throw new ScoreException( wfMessage( 'score-chdirerr', $factoryDirectory ) );
		}
		if ( !is_executable( $wgScoreLilyPond ) ) {
			throw new ScoreException( wfMessage( 'score-notexecutable', $wgScoreLilyPond ) );
		}
		$cmd = wfEscapeShellArg( $wgScoreLilyPond )
			. ' -dsafe='
			. wfEscapeShellArg( '#t' )
			. ' -dbackend=eps --png --header=texidoc '
			. wfEscapeShellArg( $factoryLy )
			. ' 2>&1';
		$output = wfShellExec( $cmd, $rc2 );
		$rc = chdir( $oldcwd );
		if ( !$rc ) {
			throw new ScoreException( wfMessage( 'score-chdirerr', $oldcwd ) );
		}
		if ( $rc2 != 0 ) {
			self::throwCallException( wfMessage( 'score-compilererr' ), $output );
		}
		if ( $options['generate_midi'] && !file_exists( $factoryMidi ) ) {
			throw new ScoreException( wfMessage( 'score-nomidi' ) );
		}

		/* trim output images if wanted */
		if ( $wgScoreTrim ) {
			if ( file_exists( $factoryImage ) ) {
				self::trimImage( $factoryImage, $factoryImageTrimmed );
			}
			for ( $i = 1; file_exists( $f = sprintf( $factoryMultiFormat, $i ) ); ++$i ) {
				self::trimImage( $f, sprintf( $factoryMultiTrimmedFormat, $i ) );
			}
		} else {
			$factoryImageTrimmed = $factoryImage;
			$factoryMultiTrimmedFormat = $factoryMultiFormat;
		}

		/* move files to proper places */
		$rc = true;
		if ( $options['generate_midi'] ) {
			self::renameFile( $factoryMidi, $options['midi_path'] );
		}
		if ( file_exists( $factoryImageTrimmed ) ) {
			self::renameFile( $factoryImageTrimmed, $image );
		}
		for ( $i = 1; file_exists( $f = sprintf( $factoryMultiTrimmedFormat, $i ) ); ++$i ) {
			self::renameFile( $f, sprintf( $multiFormat, $i ) );
		}
	}

	/**
	 * Embeds simple LilyPond code in a score block.
	 *
	 * @param $lilypondCode string Simple LilyPond code.
	 * @param $options array Rendering options. The are the same as for
	 * 	Score::generateHTML(). A MIDI block is embedded if and only if
	 * 	the generate_midi option evaluates to true.
	 *
	 * @return string Raw lilypond code.
	 *
	 * @throws ScoreException if determining the LilyPond version fails.
	 */
	private static function embedLilypondCode( $lilypondCode, $options ) {
		/* Get LilyPond version if we don't know it yet */
		if ( self::$lilypondVersion === null ) {
			self::getLilypondVersion();
		}

		/* Raw code. Note: the "strange" ##f, ##t, etc., are actually part of the lilypond code!
		 * The raw code is based on the raw code from the original LilyPond extension */
		$raw = "\\header {\n"
			. "\ttagline = ##f\n"
			. "}\n"
			. "\\paper {\n"
			. "\traggedright = ##t\n"
			. "\traggedbottom = ##t\n"
			. "\tindent = 0\mm\n"
			. "}\n"
			. '\version "' . self::$lilypondVersion . "\"\n"
			. "\\score {\n"
			. $lilypondCode
			. "\t\\layout { }\n"
			. ( $options['generate_midi'] ? "\t\\midi { }\n" : '' )
			. "}\n";
		return $raw;
	}

	/**
	 * Generates an Ogg/Vorbis file from a MIDI file using timidity.
	 *
	 * @param $options array Rendering options. They are the same as for
	 * 	Score::generateHTML(), except that the midi_path option must
	 * 	be present.
	 *
	 * @throws ScoreException if an error occurs.
	 */
	private static function generateOgg( $options ) {
		global $wgScoreTimidity;

		$prof = new ScopedProfiling(  __METHOD__ );

		/* Working environment */
		self::createDirectory( $options['factory_directory'], 0700 );
		$factoryOgg = "{$options['factory_directory']}/file.ogg";

		/* Delete old file if necessary */
		self::cleanupFile( $options['ogg_path'] );

		/* Run timidity */
		if ( !is_executable( $wgScoreTimidity ) ) {
			throw new ScoreException( wfMessage( 'score-timiditynotexecutable', $wgScoreTimidity ) );
		}
		$cmd = wfEscapeShellArg( $wgScoreTimidity )
			. ' -Ov' // Vorbis output
			. ' --output-file=' . wfEscapeShellArg( $factoryOgg )
			. ' ' . wfEscapeShellArg( $options['midi_path'] )
			. ' 2>&1';
		$output = wfShellExec( $cmd, $rc );
		if ( ( $rc != 0 ) || !file_exists( $factoryOgg ) ) {
			self::throwCallException( wfMessage( 'score-oggconversionerr' ), $output );
		}

		/* Move resultant file to proper place */
		self::renameFile( $factoryOgg, $options['ogg_path'] );
	}

	/**
	 * Generates LilyPond code.
	 *
	 * @param $code string Score code.
	 * @param $options array Rendering options. They are the same as for
	 * 	Score::generateHTML(), with the following addition:
	 * 	* lilypond_path: path to the LilyPond file that is to be
	 * 		generated.
	 *
	 * @throws ScoreException if an error occurs.
	 */
	private static function generateLilypond( $code, $options ) {
		$prof = new ScopedProfiling( __METHOD__ );

		/* Delete old file if necessary */
		self::cleanupFile( $options['lilypond_path'] );

		/* Generate LilyPond code by score language */
		switch ( $options['lang'] ) {
		case 'ABC':
			self::generateLilypondFromAbc( $code, $options );
			break;
		case 'lilypond':
			throw new MWException( 'lang="lilypond" in ' . __METHOD__ . ". This should not happen.\n" );
		default:
			throw new MWException( 'Unknown score language in ' . __METHOD__ . ". This should not happen.\n" );
		}

	}

	/**
	 * Runs abc2ly, creating the LilyPond input file.
	 *
	 * @param $code string ABC code.
	 * @param $options array Rendering options. They are the same as for
	 * 	Score::generateLilypond().
	 *
	 * @throws ScoreException if the conversion fails.
	 */
	private static function generateLilypondFromAbc( $code, $options ) {
		global $wgScoreAbc2Ly;

		$prof = new ScopedProfiling( __METHOD__ );

		/* File names */
		$factoryDirectory = $options['factory_directory'];
		$factoryAbc = "$factoryDirectory/file.abc";
		$factoryLy = "$factoryDirectory/file.ly";

		/* Create ABC input file */
		$rc = file_put_contents( $factoryAbc, $code );
		if ( $rc === false ) {
			throw new ScoreException( wfMessage( 'score-noabcinput', $factoryAbc ) );
		}

		/* Convert to LilyPond file */
		if ( !is_executable( $wgScoreAbc2Ly ) ) {
			throw new ScoreException( wfMessage( 'score-abc2lynotexecutable', $wgScoreAbc2Ly ) );
		}

		$cmd = wfEscapeShellArg( $wgScoreAbc2Ly )
			. ' -s'
			. ' --output=' . wfEscapeShellArg( $factoryLy )
			. ' ' . wfEscapeShellArg( $factoryAbc )
			. ' 2>&1';
		$output = wfShellExec( $cmd, $rc );
		if ( ( $rc != 0 ) || !file_exists( $factoryLy ) ) {
			self::throwCallException( wfMessage( 'score-abcconversionerr' ), $output );
		}

		/* The output file has a tagline which should be removed in a wiki context */
		$lyData = file_get_contents( $factoryLy );
		if ( $lyData === false ) {
			throw new ScoreException( wfMessage( 'score-readerr', $factoryLy ) );
		}
		$lyData = preg_replace( '/^(\s*tagline\s*=).*/m', '$1 ##f', $lyData );
		if ( $lyData === null ) {
			throw new ScoreException( wfMessage( 'score-pregreplaceerr' ) );
		}
		$rc = file_put_contents( $factoryLy, $lyData );
		if ( $rc === false ) {
			throw new ScoreException( wfMessage( 'score-noinput', $factoryLy ) );
		}

		/* Move resultant file to proper place */
		self::renameFile( $factoryLy, $options['lilypond_path'] );
	}

	/**
	 * Trims an image with ImageMagick.
	 *
	 * @param $source string path to the source image.
	 * @param $dest string path to the target (trimmed) image.
	 *
	 * @throws ScoreException on error.
	 */
	private static function trimImage( $source, $dest ) {
		global $wgImageMagickConvertCommand;

		$prof = new ScopedProfiling( __METHOD__ );

		$cmd = wfEscapeShellArg( $wgImageMagickConvertCommand )
			. ' -trim '
			. wfEscapeShellArg( $source ) . ' '
			. wfEscapeShellArg( $dest )
			. ' 2>&1';
		$output = wfShellExec( $cmd, $rc );
		if ( $rc != 0 ) {
			self::throwCallException( wfMessage( 'score-trimerr' ), $output );
		}
	}

	/**
	 * Deletes a directory with no subdirectories with all files in it.
	 *
	 * @param $dir string path to the directory that is to be deleted.
	 *
	 * @return true on success, false on error
	 */
	private static function eraseFactory( $dir ) {
		if( file_exists( $dir ) ) {
			array_map( 'unlink', glob( "$dir/*", GLOB_NOSORT ) );
			$rc = rmdir( $dir );
			if ( !$rc ) {
				self::debug( "Unable to remove directory $dir\n." );
			}
			return $rc;

		} else {
			/* Nothing to do */
			return true;
		}
	}

	/**
	 * Renames a file, making sure that the target directory exists.
	 * Do not use with uncanonicalised paths.
	 *
	 * @param $oldname string Old file name.
	 * @param $newname string New file name.
	 *
	 * @throws ScoreException if an error occurs.
	 */
	private static function renameFile( $oldname, $newname ) {
		self::createDirectory( dirname( $newname ) );
		$rc = rename( $oldname, $newname );
		if ( !$rc ) {
			throw new ScoreException( wfMessage( 'score-renameerr' ) );
		}
	}

	/**
	 * Deletes a file if it exists.
	 *
	 * @param $path string path to the file to be deleted.
	 *
	 * @throws ScoreException if the file specified by $path exists but
	 * 	could not be deleted.
	 */
	private static function cleanupFile( $path ) {
		if ( file_exists( $path ) ) {
			$rc = unlink( $path );
			if ( !$rc ) {
				throw new ScoreException( wfMessage( 'score-cleanerr' ) );
			}
		}
	}

	/**
	 * Writes the specified message to the Score debug log.
	 *
	 * @param $msg string message to log.
	 */
	private static function debug( $msg ) {
		wfDebugLog( 'Score', $msg );
	}

}
