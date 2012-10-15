<?php
$optionsWithArgs = array(
	'single',
	'source',
	'blacklist',
);
ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$batch = new JavascriptFileBatch();
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

$mode = JavascriptFileBatch::MODE_LIST;
if ( @$options['check'] ) {
	$mode = JavascriptFileBatch::MODE_CHECK;
} else if ( @$options['fix'] ) {
	$mode = JavascriptFileBatch::MODE_FIX;
}

$batch->process($mode);
//$name = "/usr/wikia/source/wiki/extensions/wikia/WikiaMiniUpload/js/WMU.js";

function debug_print( $string ) {
	fprintf(STDERR,$string."\n");
	fflush(STDERR);
}



class JavascriptFileBatch {

	const MODE_LIST = 1;
	const MODE_CHECK = 2;
	const MODE_FIX = 3;

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
			if ( $message['type'] == 'error' ) {
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
			$js = new JavascriptFile($file);
			$parsed = $js->load();
			if ( !empty($parsed) ) {
				if ( $mode == self::MODE_FIX ) {
					if ( $js->attemptFix() ) {
						// fix applied without errors
					} else {
						$this->printMessages($js->getFixErrors());
					}
				} else {
					$this->printMessages($parsed);
				}
			}
		}
	}
}


class JavascriptFile {

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
		$contents = file_get_contents($this->fileName);
		if ( !$contents ) {
			$this->errors[] = array(
				'file' => $this->fileName,
				'line' => 0,
				'type' => 'ERROR',
				'message' => 'Could not read file contents or file is empty'
			);
		}
		$this->fileContents = $contents;

		$parser = new JSParser();
		try {
			$tree = $parser->parse( $contents, $this->fileName, 1 );
			$this->fileTree = $tree;
			$this->descend($tree);
		} catch (Exception $e) {
			// We'll save this to cache to avoid having to validate broken JS over and over...
			$err = $e->getMessage();
			$this->errors[] = array(
				'file' => $this->fileName,
				'line' => 0,
				'type' => 'ERROR',
				'message' => 'Parse failed: '.$err
			);
			return false;
		}

		return array_merge( $this->messages, $this->errors );
	}

	protected function doesVarDefaultToWindow( $node ) {
		$orNode = @$node->initializer;
		if ( !($orNode instanceof JSNode)
			|| $orNode->type != '||'
		) {
//		debug_print("is_var_or_window: failed 1");
			return false;
		}
		$dotNode = @$orNode->treeNodes[0];
		if ( !($dotNode instanceof JSNode)
			|| $dotNode->type != '.'
			|| $dotNode->value != $node->name
		) {
//		debug_print("is_var_or_window: failed 2");
			return false;
		}
		$windowNode = @$dotNode->treeNodes[0];
		if ( !$windowNode instanceof JSNode
			|| $windowNode->type != 3
			|| $windowNode->value != 'window'
		) {
//		debug_print("is_var_or_window: failed 3");
			return false;
		}
		return true;
	}

	protected function descend( JSNode $node ) {
		switch ($node->type) {
			case 'function':
				if ($node->name) {
					$this->messages[] = array(
						'file' => $this->fileName,
						'line' => $node->lineno,
						'type' => 'function',
						'name' => $node->name,
						'node' => $node,
					);
				}
				return;
			case 'var':
				foreach ($node->treeNodes as $parentIndex => $subnode) {
					if ( !$this->doesVarDefaultToWindow($subnode) ) {
						$this->messages[] = array(
							'file' => $this->fileName,
							'line' => $subnode->lineno,
							'type' => 'var',
							'name' => $subnode->name,
							'node' => $subnode,
							'parent' => $node,
							'parentIndex' => $parentIndex,
						);
					}
				}
		}
		$keys = array(
			'treeNodes',
			'body',
			'thenPart',
			'elsePart',
			'cases',
			'statements',
			'setup',
			'condition',
			'update',
			'varDecl',
			'iterator',
			'tryBlock',
			'catchClauses',
			'varName',
			'guard',
			'block',
			'value',
			'object',
			'initializer',
			'expression',
			'statement',
		);
		foreach ($keys as $key) {
			$nodes = $node->$key;
			if ($nodes instanceof JSNode) {
				$this->descend($nodes);
			} elseif ( is_array($nodes) ) {
				foreach ($nodes as $subnode) {
					$this->descend($subnode);
				}
			}
		}
	}

	public function getFixedCode() {
		$this->load();
		if ( !empty($this->errors) ) {
			$this->fixErrors = $this->errors;
			return false;
		}

		$this->fixErrors = array();
		if ( empty($this->fileContents) || empty($this->fileTree) ) {
			$this->fixErrors[] = array(
				'file' => $this->fileName,
				'line' => 0,
				'type' => 'error',
				'message' => 'Empty file contents or code tree',
			);
			return false;
		}

		$globals = array();
		foreach ($this->messages as $entry) {
			if ( empty($entry['line']) || empty($entry['type']) || empty($entry['name']) ) {
				$this->fixErrors[] = array(
					'file' => $this->fileName,
					'line' => intval($entry['line']),
					'type' => 'error',
					'message' => 'Entry malformed',
				);
			} else {
				switch ( $entry['type'] ) {
					case 'var':
						$globals[$entry['name']] = 'undefined';
						break;
					case 'function':
						$globals[$entry['name']] = $entry['name'];
						break;
					default:
						$this->fixErrors[] = array(
							'file' => $this->fileName,
							'line' => intval($entry['line']),
							'type' => 'error',
							'message' => 'Unrecognized entry type: '+$entry['type'],
						);
				}
			}
		}
		if ( !empty( $this->fixErrors ) ) {
			return false;
		}

		// do var refactor
		$code = $this->fileContents;
		foreach (array_reverse($this->messages) as $entry) {
			$line = $entry['line'];
			$type = $entry['type'];
			$name = $entry['name'];
			$node = $entry['node'];
			switch ($type) {
				case 'var':
					$varNode = $entry['parent'];
					$varIndex = $entry['parentIndex'];
					$start = $node->start;
					$end = $node->end;

					$code = substr($code,0,$start)."window.".substr($code,$start);

					if ( !$node->initializer ) {
						$removeStart = $node->start;
						$removeEnd = strpos($code,';',$removeStart); // var names cannot have semicolon
						if ( $varIndex == 0 ) {
							$removeStart = $varNode->start;
						}
//						var_dump($node->start,"r",$removeStart,$removeEnd);
						if ( $removeEnd !== false ) {
							$code = substr($code,0,$removeStart).substr($code,$removeEnd);
						}
					} else {
						if ( $varIndex == 0 ) {
							// remove "var "
							$code = substr($code,0,$varNode->start).substr($code,$varNode->start+4/* "var "*/);
						} else {
							// replace the previous comma with semicolon
							$pos = strrpos(substr($code,0,$start),',');
//							var_dump($node->name,$start,$pos);
							if ( $pos !== false ) {
								$code = substr($code,0,$pos).';'.substr($code,$pos+1);
							}
						}
					}

					break;
			}
		}


		// build wrapper beginning
		$preCode = array();
		$preCode[] = '(function(window){';
		foreach ($globals as $k => $v) {
			$preCode[] = "window.$k = $v;";
		}
		$preCode = implode("\n",$preCode);

		// build wrapper end
		$postCode = array();
		$postCode[] = '})(this);';
		$postCode = implode("\n",$postCode);

		// inject
		$code = "{$preCode}\n{$code}\n{$postCode}";

		// test new code if it compiles
		$tmpName = tempnam('/tmp','jsfix');
		file_put_contents($tmpName,$code);
		$newJs = new JavascriptFile($tmpName);
		$newJsStatus = $newJs->load();
		$newJs->close();
		unlink($tmpName);
		if ( !empty( $newJsStatus ) ) {
			$firstItem = $newJsStatus[0];
			if ( $firstItem['type'] === 'error' ) {
				$this->fixErrors[] = array(
					'file' => $this->fileName,
					'line' => intval($entry['line']),
					'type' => 'error',
					'message' => 'Automatic fix failed: '+$firstItem['message'],
				);
			} else {
				$this->fixErrors[] = array(
					'file' => $this->fileName,
					'line' => intval($entry['line']),
					'type' => 'error',
					'message' => 'Automatic fix failed: '+$firstItem['type']+' '+$firstItem['name'],
				);
			}
			return false;
		}

		return $code;
	}

	public function attemptFix() {
		$code = $this->getFixedCode();
		if ( $code === false ) {
			return false;
		}

		file_put_contents($this->fileName.'.fixed',$code);
		return true;
	}

}

