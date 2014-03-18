<?php

namespace Wikia\Sass\Compiler;
use Wikia\Sass\Source\Source;
use Wikia;

/**
 * SassExternalRubyCompiler implements a Sass compiler interface
 * giving you access to use external Ruby compiler.
 *
 * @author Inez Korczyński <korczynski@gmail.com>
 * @author Piotr Bablok <piotr.bablok@gmail.com>
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
class ExternalRubyCompiler extends Compiler {

	protected $tempDir;
	protected $rootDir;
	protected $sassExecutable;
	protected $sassVariables = array();
	protected $outputStyle = 'nested';
	protected $useSourceMaps = false;

	/**
	 * Compile the given SASS source
	 *
	 * @param Source $source Sass source
	 * @throws Wikia\Sass\Exception
	 * @return string CSS stylesheet
	 */
	public function compile( Source $source ) {
		wfProfileIn(__METHOD__);

		$tempDir = $this->tempDir ?: sys_get_temp_dir();
		//replace \ to / is needed because escapeshellcmd() replace \ into spaces (?!!)
		$outputFile = str_replace('\\', '/', tempnam($tempDir, 'Sass'));
		$tempDir = str_replace('\\', '/', $tempDir);

		$sassVariables = urldecode(http_build_query($this->sassVariables, '', ' '));
		$debugMode = $this->useSourceMaps ? '--debug-in' : '';

		$hasLocalFile = $source->hasPermanentFile();
		$localFile = $source->getLocalFile();
		$inputFile = $hasLocalFile ? $localFile : '-s';

		$cmd = "{$this->sassExecutable} {$inputFile} {$outputFile} --scss -t {$this->outputStyle} "
			. "-I {$this->rootDir} {$debugMode} "
			. "--cache-location {$tempDir}/sass2 -r {$this->rootDir}/extensions/wikia/SASS/wikia_sass.rb {$sassVariables}";
		$cmd = escapeshellcmd($cmd) . " 2>&1";

		if ( !$hasLocalFile ) {
			$cmd = escapeshellcmd("cat {$localFile}") . " | " . $cmd;
		}

		$sassOutput = shell_exec($cmd);
		if ($sassOutput != '') {
			Wikia::log('sass-errors-WIKIA', false, "out: " . preg_replace('#\n\s+#', ' ', trim($sassOutput)). " / cmd: $cmd", true /* $always */);
			if ( file_exists( $outputFile ) ) {
				unlink($outputFile);
			}

			throw new \Wikia\Sass\Exception("SASS compilation failed: {$sassOutput}\nFull commandline: $cmd");
		}

		$styles = file_get_contents($outputFile);

		unlink($outputFile);

		wfProfileOut(__METHOD__);

		return $styles;
	}

}