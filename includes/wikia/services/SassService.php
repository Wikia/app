<?php

class SassService extends Service {

	protected $fileName;
	protected $modificationTime;

	public function __construct( $fileName ) {
		$this->fileName = $fileName;
	}

	protected function findFile( $fileName ) {
		if ( !file_exists( $fileName ) ) {
			$parts = explode('/', $fileName);
			$baseName = array_pop($parts);
			$dir = implode('/',$parts) . '/';
			$alternatives = array(
				$dir . $baseName,
				$dir . $baseName . '.scss',
				$dir . $baseName . '.sass',
				$dir . '_' . $baseName,
				$dir . '_' . $baseName . '.scss',
				$dir . '_' . $baseName . '.sass',
			);

			$fileName = false;
			foreach( $alternatives as $a ) {
				if ( file_exists( $a ) ) {
					$fileName = $a;
					break;
				}
			}
		}

		return $fileName;
	}

	/**
	 * Iterates recursively over all the files included in this SASS file
	 *
	 * Return an associative array containing file names as keys,
	 * and callback results or true (when no callback present) as values.
	 *
	 * @author wladek
	 * @param $callback callable Callback to be called
	 * @return array Result array
	 */
	protected function forEachFile( $callback = null ) {
		global $IP;

		$hasCallback = is_callable($callback);

		$files = array();
		$processed = array();

		$queue = array( $this->fileName );
		while ( !empty( $queue ) ) {
			$file = array_pop($queue);
			$file = $this->findFile($file);
			$file = realpath( $file );

			if ( isset($processed[$file]) ) {
				continue;
			}
			$processed[$file] = true;

			$contents = file_get_contents($file);
			if ($hasCallback) {
				$files[$file] = call_user_func($callback,$file,$contents);
			} else {
				$files[$file] = true;
			}

			$matches = array();
			preg_match_all('/\\@import(\\s)*[\\"\']([^\\"\']*)[\\"\']/', $contents, $matches, PREG_PATTERN_ORDER );
			$matches = $matches[2];
			foreach ($matches as $k => $match) {
				if ( startsWith( $match, '/' ) ) {
					$matches[$k] = $IP . $match;
				} else {
					$matches[$k] = dirname( $file ) . '/' . $match;
				}
			}
			foreach (array_reverse($matches) as $match) {
				array_push($queue,$match);
			}
		};

		return $files;
	}

	protected function filemtime( $file ) {
		return filemtime($file);
	}

	/**
	 * Calculates the last modification time of this SASS taking into account
	 * all files that it depends on.
	 *
	 * @return int Timestamp representing last modification time
	 */
	public function getModificationTime() {
		if ( !empty($this->modificationTime) ) {
			return $this->modificationTime;
		}

		$files = $this->forEachFile(array($this,'filemtime'));
		$maxTime = 0;
		foreach ($files as $fileName => $fileTime) {
			$maxTime = max( $maxTime, $fileTime );
		}

		return $maxTime;
	}

	/**
	 * todo: add caching layer
	 *
	 * @param $parameters
	 * @return string
	 * @throws Exception
	 */
	protected function compileExternal( $parameters ) {
		global $IP, $wgSassExecutable, $wgDevelEnvironment;

		wfProfileIn(__METHOD__);

		$tempDir = sys_get_temp_dir();
		//replace \ to / is needed because escapeshellcmd() replaces \ into spaces (?!!)
		$tempOutFile = str_replace('\\', '/', tempnam($tempDir, 'Sass'));
		$tempDir = str_replace('\\', '/', $tempDir);
		$params = urldecode(http_build_query($parameters, '', ' '));

		$random = '';
		$chars = "0123456789abcdefghijklmnopqrstuvwxyz";
		for ($i=0;$i<16;$i++)
			$random .= $chars[rand(0,strlen($chars)-1)];

		$cmd = "{$wgSassExecutable} {$this->fileName} {$tempOutFile} --cache-location {$tempDir}/sass --style compact -r {$IP}/extensions/wikia/SASS/wikia_sass.rb {$params}";
		$escapedCmd = escapeshellcmd($cmd) . " 2>&1";

		$sassResult = shell_exec($escapedCmd);
		if ($sassResult != '') {
			Wikia::log(__METHOD__, false, "commandline error: " . $sassResult. " -- Full commandline was: $escapedCmd", true /* $always */);
			Wikia::log(__METHOD__, false, "Full commandline was: {$escapedCmd}", true /* $always */);
//			Wikia::log(__METHOD__, false, AssetsManager::getRequestDetails(), true /* $always */);
			if ( file_exists( $tempOutFile ) ) {
				unlink($tempOutFile);
			}

			if ( !empty($wgDevelEnvironment) ) {
				$exceptionMsg = "SassService problem with {$this->fileName}: {$sassResult}";
			}
			else {
				$exceptionMsg = 'SassService problem with {$this->fileName}. Check the PHP error log for more details.';
			}

			throw new Exception($exceptionMsg);
		}

		$result = file_get_contents($tempOutFile);

		unlink($tempOutFile);

		wfProfileOut(__METHOD__);

		return $result;
	}

	protected function compileInternal( $parameters ) {
		global $wgAutoloadClasses, $IP;
		$wgAutoloadClasses['SassParser'] = $IP.'/lib/phpsass/SassParser.php';

		// make sure SassParser-related classes are loaded
		require_once $wgAutoloadClasses['SassParser'];

		// process source sass file
		$options = array(
			'style' => SassRenderer::STYLE_COMPACT,
			'syntax' => SassFile::SCSS,
			'filename' => $this->fileName,
			'load_paths' => array(
				$IP
			),
//			'load_path_functions' => array(
//
//			),
			'functions' => array(
				'get_command_line_param' => function( $name, $default ) use ($parameters) {
					return
						(array_key_exists($name,$parameters) && $parameters[$name] !== '')
						? $parameters[$name]
						: $default;
				}
			),
		);
		$context = new SassContext();
		$parser = new SassParser($options);
		$startTime = microtime(true);
		$tree = $parser->parse($this->fileName,true);
		$midTime = microtime(true);
		$contents = $tree->render($context);
		$endTime = microtime(true);
		$contents = sprintf("/* phpsass: parse/render: %.5f / %.5f */\n\n",$midTime-$startTime,$endTime-$midTime)
			. $contents;

		return $contents;
	}

	protected function processImports( $contents ) {
		global $IP;
		wfProfileIn(__METHOD__);

		$matches = array();
		$importRegexOne = "/@import ['\\\"]([^\\n]*\\.css)['\\\"]([^\\n]*)(\\n|$)/is"; // since this stored is in a string, remember to escape quotes, slashes, etc.
		$importRegexTwo = "/@import url[\\( ]['\\\"]?([^\\n]*\\.css)['\\\"]?[ \\)]([^\\n]*)(\\n|$)/is";
		while ((0 < preg_match_all($importRegexOne, $contents, $matches, PREG_SET_ORDER)) || (0 < preg_match_all($importRegexTwo, $contents, $matches, PREG_SET_ORDER))) {
			foreach($matches as $match) {
				$lineMatched = $match[0];
				$fileName = trim($match[1]);
				$fileContents = file_get_contents($IP . $fileName);
				$contents = str_replace($lineMatched, $fileContents, $contents);
			}
		}

		wfProfileOut(__METHOD__);

		return $contents;
	}

	protected function processStylePath( $contents ) {
		global $wgCdnStylePath;
		wfProfileIn(__METHOD__);

		if (strpos($contents, "wgCdnStylePath") !== false) { // faster to skip the regex in most cases
			// Because of fonts in CSS, we have to allow for lines with multiple url()s in them.
			// This will rewrite all but the last URL on the line (the last regex will fix the final URL and remove the special comment).
			$wasChanged = true;

			// TODO: refactor?
			while($wasChanged) {
				$changedCss = preg_replace("/([\(][\"']?)(\/[^\n]*?)([, ]url[^\n]*?)(\s*\/\*\s*[\\\$]?wgCdnStylePath\s*\*\/)/is", '\\1'.$wgCdnStylePath.'\\2\\3\\4', $contents);
				if($changedCss != $contents) {
					$wasChanged = true;
					$contents = $changedCss;
				} else {
					$wasChanged = false;
				}
			}

			$contents = preg_replace("/([\(][\"']?)(\/[^\n]*?)\s*\/\*\s*[\\\$]?wgCdnStylePath\s*\*\//is", '\\1'.$wgCdnStylePath.'\\2', $contents);
		}

		wfProfileOut(__METHOD__);

		return $contents;
	}

	protected function processBase64( $contents ) {
		wfProfileIn(__METHOD__);

		$contents = preg_replace_callback("/([, ]url[^\n]*?)(\s*\/\*\s*base64\s*\*\/)/is",
			array( $this, 'processBase64Callback' ), $contents);

		wfProfileOut(__METHOD__);

		return $contents;
	}

	protected function processBase64Callback($matches) {
		global $IP;
		$fileName = $IP . trim(substr($matches[1], 4, -1), '\'"() ');

		$encoded = $this->encodeFileBase64($fileName);
		if ($encoded !== false) {
			return "url({$encoded});";
		}
		else {
			throw new Exception("/* Base64 encoding failed: {$fileName} not found! */");
		}
	}

	protected function encodeFileBase64( $fileName ) {
		wfProfileIn(__METHOD__);

		if (!file_exists($fileName)) {
			wfProfileOut(__METHOD__);
			return false;
		}

		$ext = end(explode('.', $fileName));

		switch ($ext) {
			case 'gif':
			case 'png':
				$type = $ext;
				break;
			case 'jpg':
				$type = 'jpeg';
				break;
			// not supported image type provided
			default:
				wfProfileOut(__METHOD__);
				return false;
		}

		$content = file_get_contents($fileName);
		$encoded = base64_encode($content);

		wfProfileOut(__METHOD__);
		return "data:image/{$type};base64,{$encoded}";
	}

	/**
	 * Returns the CSS compiled from this SASS source file applying the parameters
	 * passed in argument
	 *
	 * @param $parameters array SASS parameters to be passed to the compiler
	 * @return string Generated CSS
	 */
	public function getContents( $parameters ) {
		$startTime = microtime(true);
		$contents = $this->compileExternal($parameters);
//		$contents = $this->compileInternal($parameters);
		$endTime = microtime(true);
		$contents = $this->processImports($contents);
		// style path processing is done automatically by ResourceLoader
//		$contents = $this->processStylePath($contents);
		$contents = $this->processBase64($contents);

		$contents = sprintf("/* SASS processing time: %.5f */\n\n",$endTime-$startTime)
			. $contents;

		return $contents;
	}

}
