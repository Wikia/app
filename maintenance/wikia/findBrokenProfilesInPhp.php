<?php
$optionsWithArgs = array(
	'single',
	'source',
	'blacklist',
);
ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$batch = new PhpFileBatch();
if ( !empty($options['dry-run']) ) {
	$batch->setFlag('dry-run',true);
}

if ( @$options['source'] ) {
	$batch->addFileList($options['source']);
}
if ( @$options['single'] ) {
	$batch->addSingleFile($options['single']);
}
if ( @$options['blacklist'] ) {
	$batch->setBlacklist($options['blacklist']);
}

$mode = PhpFileBatch::MODE_LIST;
if ( @$options['check'] ) {
	$mode = PhpFileBatch::MODE_CHECK;
}

$batch->process($mode);
//$name = "/usr/wikia/source/wiki/extensions/wikia/WikiaMiniUpload/js/WMU.js";

function debug_print( $string ) {
	fprintf(STDERR,$string."\n");
	fflush(STDERR);
}



class PhpFileBatch {

	const MODE_LIST = 1;
	const MODE_CHECK = 2;
//	const MODE_FIX = 3;

	protected $files = array();
	protected $blacklist = array();
	protected $flags = array(
		'dry-run' => true,
	);

	public function setFlag( $name, $value ) {
		$this->flags[$name] = $value;
	}

	public function getFlag( $name ) {
		return @$this->flags[$name];
	}

	protected function getListFromFile( $fileName ) {
		$ret = array();
		$names = @file_get_contents($fileName);
		$names = preg_split("/[\r\n]+/",(string)$names);
		foreach ($names as $name) {
			if ( $name === '' )
				continue;
			$ret[] = $name;
		}
		return $ret;
	}
	public function setBlacklist( $blacklistFile ) {
		$this->blacklist = $this->getListFromFile($blacklistFile);
	}
	public function addSingleFile( $fileName ) {
		$this->files[] = $fileName;
	}

	public function addFileList( $fileName ) {
		$this->files = array_merge( $this->files, $this->getListFromFile($fileName) );
	}

	protected function printMessages( $messages ) {
		foreach ($messages as $message) {
			if ( strtolower($message['type']) == 'error' ) {
				echo sprintf("%s:%d: ERROR %s\n",
					$message['file'],
					$message['line'],
					$message['message']);
			} else {
				echo sprintf("%s:%d: %s %s\n",
					$message['file'],
					$message['line'],
					$message['type'],
					$message['name']);
			}
		}
	}

	protected function isBlacklisted( $file ) {
		foreach ($this->blacklist as $entry) {
			if ( strpos($file,$entry) !== false ) {
				return true;
			}
		}
		return false;
	}

	public function process( $mode = self::MODE_LIST ) {
		if ( empty($mode) ) {
			return;
		}
		foreach ($this->files as $file) {
			if ( $this->isBlacklisted($file) ) {
				continue;
			}
			if ( $mode == self::MODE_LIST ) {
				echo "{$file}\n";
				continue;
			}
			$file = new PhpFile($file);
			$parsed = $file->load();
			if ( !empty($parsed) ) {
				$this->printMessages($parsed);
			}
		}
	}
}


class PhpFile {

	protected $fileName;
	protected $fileContents = false;
	/** @var JSNode */
	protected $fileTree;

	protected $messages = array();
	protected $errors = array();
	protected $fixErrors = array();

	public function __construct( $fileName ) {
		$this->fileName = $fileName;
	}

	public function getMessages() {
		return $this->errors;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function getFixErrors() {
		return $this->fixErrors;
	}

	public function close() {
		$this->fileContents = false;
		$this->fileTree = null;
		$this->messages = array();
		$this->errors = array();
		$this->fixErrors = array();
	}

	function load() {
		$this->messages = array();
		$this->errors = array();
		$contents = false;
		if ( file_exists( $this->fileName ) ) {
			$contents = file_get_contents($this->fileName);
		}
		if ( $contents === false ) {
			$this->errors[] = array(
				'file' => $this->fileName,
				'line' => 0,
				'type' => 'ERROR',
				'message' => 'Could not read file contents or file is empty'
			);
		}
		$this->fileContents = $contents;

		$this->parse($this->fileContents);

		return array_merge( $this->messages, $this->errors );
	}

	protected function annotate( &$tokens ) {
		$bracketsMap = array(
			')' => '(',
			'}' => '{',
		);
		$stack = array();
		foreach ($tokens as $k => $token) {
			$type = $token[0];
			if ( $type == T_CURLY_OPEN ) $type = '{';
			if ( $type == T_DOLLAR_OPEN_CURLY_BRACES ) $type = '{';
			$starts = false;
			$ends = false;
			if ( in_array( $type, array( '(', '{' ) ) ) {
				$starts = $type;
			} elseif ( in_array( $type, array( ')', '}' ) ) ) {
				$ends = $bracketsMap[$type];
			}
			if ( $starts ) {
				array_push($stack,array($starts,$k));
			} elseif ( $ends ) {
				$ref = array_pop($stack);
				if ( empty($ref) ) {
					$this->errors[] = array(
						'file' => $this->fileName,
						'line' => $token[2],
						'type' => 'ERROR',
						'message' => 'Could not find opening bracket'
					);
					return false;
				} elseif ( $ref[0] !== $ends ) {
					$this->errors[] = array(
						'file' => $this->fileName,
						'line' => $token[2],
						'type' => 'ERROR',
						'message' => 'Could not match brackets'
					);
					return false;
				}
				$tokens[$ref[1]]['end'] = $k;
			}
		}
		return true;
	}

	protected function parse( $code ) {
		if ( !preg_match("/profile(in|out)/i",$code) ) {
			return;
		}
		$tokens = token_get_all($code);
		$line = 1;
		foreach ($tokens as $k => $token) {
			if ( !is_array($token) ) {
				$token = $tokens[$k] = array(
					$token, $token, $line
				);
			}
			$token[3] = $tokens[$k][3] = is_int($token[0]) ? token_name($token[0]) : $token[0];
			$line = $token[2];
//			var_dump($token);
		}
//		var_dump($tokens);

		if ( !$this->annotate($tokens) ) {
			return;
		}

		$this->tokens = $tokens;

		$this->intoBlock( array(), 0, count($tokens) );
	}

	protected $functionsStack = array();
	protected $blocks = array();

	protected function findFirst( $type, $pos, $max ) {
		while ( $pos < $max && $this->tokens[$pos][0] !== $type ) {
			$pos++;
		}
		return $pos;
	}

	protected function findFirstNot( $type, $pos, $max ) {
		while ( $pos < $max && $this->tokens[$pos][0] === $type ) {
			$pos++;
		}
		return $pos;
	}

	protected function getStringRange( $start, $end ) {
		$s = '';
		for ($i=$start;$i<$end;$i++) {
			$s .= $this->tokens[$i][1];
		}
		return $s;
	}

	protected function intoBlock( $state, $start, $end ) {
		if ( empty( $state ) ) {
			$state = array(
				'function' => '[main]',
				'depth' => 0,
				'profiles' => array(),
			);
		}
		$matches = array();

		$state['depth']++;
		$pos = $start;
		$lastLine = $this->tokens[$pos][2];
		while ( $pos < $end && ($token = $this->tokens[$pos]) ) {
			if ( $token[0] === T_FUNCTION ) {
				$j = $this->findFirst('(',$pos,$end);
				$k = $this->findFirst(T_STRING,$pos,$end);
				$name = '[unknown]';
				if ( $k < $end && $k < $j ) {
					$name = $this->tokens[$k][1];
				}
				$i = $this->findFirst('{',$pos,$end);
				$j = $this->findFirst(';',$pos,$end);
				if ( $j < $i && $j < $end ) { // likely an abstract function with no body
					$pos = $j;
				} elseif ( $i < $end && array_key_exists('end',$this->tokens[$i] ) ) {
					$j = $this->tokens[$i]['end'] + 1;
//					var_dump($i,$j);
					$inState = array(
						'function' => $name . '()',
						'depth' => 0,
						'profiles' => array(),
					);
					if ( !in_array( strtolower($name), array( 'profileIn', 'profileOut', 'wfProfileIn', 'wfProfileOut' ) ) ) {
						$this->intoBlock($inState,$i,$j);
					}
					if ( !empty($this->errors) ) {
//						return;
					}
					$pos = $j;
				} else {
//					var_dump(array_slice($this->tokens,$pos,20));
//					var_dump($start,$end,$pos,$i);
					$this->errors[] = array(
						'file' => $this->fileName,
						'line' => $token[2],
						'type' => 'ERROR',
						'message' => 'Could not find opening bracket in function',
					);
					return;
				}
			} elseif ( in_array( $token[0], array( T_IF, T_ELSE, T_ELSEIF, T_SWITCH, T_CATCH ) ) ) {
				$i = $pos;
				if ( !in_array( $token[0], array( T_ELSE, T_CATCH ) ) ) {
					$i = $this->findFirst('(',$pos,$end);
					if ( $i >= $end ) {
						$this->errors[] = array(
							'file' => $this->fileName,
							'line' => $token[2],
							'type' => 'ERROR',
							'message' => 'Could not find opening bracket after IF statement',
						);
						return;
					}
					$i = $this->tokens[$i]['end'] + 1;
				}
				$j = $this->findFirst(';',$pos,$end);
				$k = $this->findFirst('{',$pos,$end);
				$l = $this->findFirst(':',$pos,$end);
				if ( $j < $end && $j < $k && $j < $l ) { // single-line
					$this->intoBlock($state,$i+1,$j);
					$pos = $j;
				} elseif ( $k < $end && $k < $l ) { // block
					$eToken = $this->tokens[$k]['end'];
					$this->intoBlock($state,$k,$eToken);
					if ( !empty($this->errors) ) {
//						return;
					}
					$pos = $eToken;
				} else {
					$this->errors[] = array(
						'file' => $this->fileName,
						'line' => $token[2],
						'type' => 'ERROR',
						'message' => 'Unsupported construct detected IF (condition):',
					);
					return;
				}
			} elseif ( $token[0] == T_RETURN ) {
				if ( count( $state['profiles'] ) > 0) {
					$this->messages[] = array(
						'file' => $this->fileName,
						'line' => $token[2],
						'type' => 'return',
						'name' => $state['function'],
					);
				}
				$pos++;
//				return;
			} elseif ( $token[0] == T_STRING && preg_match("/(wf)?profile(in|out)/i",$token[1],$matches) ) {
//				var_dump($pos,$token,$matches);
				if ( strtolower($matches[2]) == 'in' ) {
					$i = $this->findFirst('(',$pos,$end);
					if ( $i < $end ) {
						$j = $this->tokens[$i]['end'];
						$profile = $this->getStringRange($i,$j);
						$profile = preg_replace("/\s+/",'',$profile);
						$state['profiles'][] = $profile;
						$pos = $j;
					} else {
						$this->errors[] = array(
							'file' => $this->fileName,
							'line' => $token[2],
							'type' => 'ERROR',
							'message' => 'Could not find opening bracket in call to profileIn',
						);
						return;
					}
				} else { // out
					$i = $this->findFirst('(',$pos,$end);
					if ( $i < $end ) {
						$j = $this->tokens[$i]['end'];
						$profile = $this->getStringRange($i,$j);
						$profile = preg_replace("/\s+/",'',$profile);
						if ( count( $state['profiles'] ) == 0 ) {
							$this->errors[] = array(
								'file' => $this->fileName,
								'line' => $token[2],
								'type' => 'ERROR',
								'message' => 'Found a call to profileOut when no profiles are in the stack',
							);
							return;
						} else {
							$openProfile = array_pop($state['profiles']);
							if ( $profile !== $openProfile ) {
								array_push($state['profiles'],$openProfile);
								$this->messages[] = array(
									'file' => $this->fileName,
									'line' => $token[2],
									'type' => 'mismatch',
									'name' => $state['function'],
								);
							} else {
								// everything is in order... nothing to do
							}
						}
						$pos = $j;
					} else {
						$this->errors[] = array(
							'file' => $this->fileName,
							'line' => $token[2],
							'type' => 'ERROR',
							'message' => 'Could not find opening bracket in call to profileIn',
						);
						return;
					}
				}
			} else {
				$pos++;
			}
			$lastLine = $this->tokens[$pos<$end?$pos:$pos-1][2];
		}
		$state['depth']--;

		if ( $state['depth'] == 0 && $pos >= $end ) {
			if ( count( $state['profiles'] ) > 0 ) {
				$this->messages[] = array(
					'file' => $this->fileName,
					'line' => $lastLine,
					'type' => 'return',
					'name' => $state['function'],
				);
			}
		}
	}

	protected function intoFunction( $name, $start, $end ) {
		if ( empty( $state ) ) {
			$state = array(
				'function' => $name,
				'depth' => 0,
				'profiles' => array(),
			);
		}
	}

}

