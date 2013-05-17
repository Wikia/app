<?php
/**
 * Cli controller
 *
 * PHP Version 5.3.2
 *
 * Copyright (c) 2007-2010, Mayflower GmbH
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Mayflower GmbH nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  PHP_CodeBrowser
 * @package   PHP_CodeBrowser
 * @author    Elger Thiele <elger.thiele@mayflower.de>
 * @author    Simon Kohlmeyer <simon.kohlmeyer@mayflower.de>
 * @copyright 2007-2010 Mayflower GmbH
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpunit.de/
 * @since     File available since  0.1.0
 */

if (strpos('/usr/share/php', '@php_dir') === false) {
    if (!defined('PHPCB_ROOT_DIR')) {
        define('PHPCB_ROOT_DIR', '/usr/share/php/PHP_CodeBrowser');
    }
    if (!defined('PHPCB_TEMPLATE_DIR')) {
        define('PHPCB_TEMPLATE_DIR', '/usr/share/php/data/PHP_CodeBrowser/templates');
    }
} else {
    if (!defined('PHPCB_ROOT_DIR')) {
        define('PHPCB_ROOT_DIR', dirname(__FILE__) . '/../');
    }
    if (!defined('PHPCB_TEMPLATE_DIR')) {
        define('PHPCB_TEMPLATE_DIR', dirname(__FILE__) . '/../templates');
    }
}

require_once dirname(__FILE__) . '/Util/Autoloader.php';
require_once 'Console/CommandLine.php';
require_once 'File/Iterator/Factory.php';

/**
 * CbCLIController
 *
 * @category  PHP_CodeBrowser
 * @package   PHP_CodeBrowser
 * @author    Elger Thiele <elger.thiele@mayflower.de>
 * @author    Michel Hartmann <michel.hartmann@mayflower.de>
 * @author    Simon Kohlmeyer <simon.kohlmeyer@mayflower.de>
 * @copyright 2007-2010 Mayflower GmbH
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.9.0
 * @link      http://www.phpunit.de/
 * @since     Class available since  0.1.0
 */
class CbCLIController
{
    /**
     * Path to the Cruise Control input xml file
     *
     * @var string
     */
    private $_logDir;

    /**
     * Path to the code browser html output folder
     *
     * @var string
     */
    private $_htmlOutputDir;

    /**
     * Path to the project source code files
     *
     * @var string
     */
    private $_projectSource;

    /**
     * Array of PCREs. Matching files will not appear in the output.
     *
     * @var Array
     */
    private $_excludeExpressions;

    /**
     * Array of glob patterns. Matching files will not appear in the output.
     *
     * @var Array
     */
    private $_excludePatterns;

    /**
     * The error plugin classes
     *
     * @var array
     */
    private $_registeredPlugins;

    /**
     * The IOHelper used for filesystem interaction.
     *
     * @var CbIOHelper
     */
    private $_ioHelper;

    /**
     * The constructor
     *
     * Standard setters are initialized
     *
     * @param string $logPath          The (path-to) xml log files. Can be null.
     * @param Array  $projectSource    The project sources. Can be null.
     * @param string $htmlOutputDir    The html output dir, where new files will
     *                                 be created
     * @param Array  $excludeExpressions
     *                                 A list of PCREs. Files matching will not
     *                                 appear in the output.
     * @param Array  $excludePatterns  A list of glob patterns. Files matching
     *                                 will not appear in the output.
     * @param CbIOHelper $ioHelper     The CbIOHelper object to be used for
     *                                 filesystem interaction.
     */
    public function __construct($logPath,       Array $projectSource,
                                $htmlOutputDir, Array $excludeExpressions,
                                Array $excludePatterns, $ioHelper)
    {
        $this->_logDir             = $logPath;
        $this->_projectSource      = $projectSource;
        $this->_htmlOutputDir      = $htmlOutputDir;
        $this->_excludeExpressions = $excludeExpressions;
        $this->_excludePatterns    = $excludePatterns;
        $this->_ioHelper           = $ioHelper;
    }

    /**
     * Setter/adder method for the used plugin classes.
     * For each plugin to use, add it to this array
     *
     * @param mixed $classNames Definition of plugin classes
     *
     * @return void
     */
    public function addErrorPlugins($classNames)
    {
        foreach ((array) $classNames as $className) {
            $this->_registeredPlugins[] = $className;
        }
    }

    /**
     * Main execute function for PHP_CodeBrowser.
     *
     * Following steps are resolved:
     * 1. Clean-up output directory
     * 2. Merge xml log files
     * 3. Generate cbXML file via errorlist from plugins
     * 4. Save the cbErrorList as XML file
     * 5. Generate HTML output from cbXML
     * 6. Copy ressources (css, js, images) from template directory to output
     *
     * @return void
     */
    public function run()
    {
        // clear and create output directory
        if (is_dir($this->_htmlOutputDir)) {
            $this->_ioHelper->deleteDirectory($this->_htmlOutputDir);
        } else if (is_file($this->_htmlOutputDir)) {
            $this->_ioHelper->deleteFile($this->_htmlOutputDir);
        }
        $this->_ioHelper->createDirectory($this->_htmlOutputDir);

        // init needed classes
        $cbViewReview  = new CbViewReview(
            PHPCB_TEMPLATE_DIR,
            $this->_htmlOutputDir,
            $this->_ioHelper
        );

        $sourceHandler = new CbSourceHandler();

        if (isset($this->_logDir)) {
            $cbIssueXml    = new CbIssueXml();

            // merge xml files
            $cbIssueXml->addDirectory($this->_logDir);

            // conversion of XML file cc to cb format
            foreach ($this->_registeredPlugins as $className) {
                $sourceHandler->addPlugin(new $className($cbIssueXml));
            }
        }

        if (isset($this->_projectSource)) {
            foreach ($this->_projectSource as $source) {
                if (is_dir($source)) {
                    $sourceHandler->addSourceFiles(
                        File_Iterator_Factory::getFileIterator(
                            $source, array('php','js','css', 'html')
                        )
                    );
                } else {
                    $sourceHandler->addSourceFile($source);
                }
            }
        }

        array_walk(
            $this->_excludeExpressions,
            array($sourceHandler, 'excludeMatchingPCRE')
        );
        array_walk(
            $this->_excludePatterns,
            array($sourceHandler, 'excludeMatchingPattern')
        );

        $files = $sourceHandler->getFiles();

        if (!$files) {
            $cbViewReview->copyNoErrorsIndex();
        } else {
            // Get the path prefix all files have in common
            $commonPathPrefix = $sourceHandler->getCommonPathPrefix();

            foreach ($files as $file) {
                $cbViewReview->generate(
                    $file->getIssues(),
                    $file->name(),
                    $commonPathPrefix
                );
            }

            // Copy needed ressources (eg js libraries) to output directory
            $cbViewReview->copyRessourceFolders();
            $cbViewReview->generateIndex($files);
        }
    }

    /**
     * Main method called by script
     *
     * @return void
     */
    public static function main()
    {
        // register autoloader
        spl_autoload_register(array(new CbAutoloader(), 'autoload'));

        $parser = self::createCommandLineParser();

        try {
            $opts = $parser->parse()->options;
        } catch (Exception $e) {
            $parser->displayError($e->getMessage());
        }

        $errors = self::errorsForOpts($opts);
        if ($errors) {
            foreach ($errors as $e) {
                error_log("[Error] $e\n");
            }
            exit(1);
        }

        // init new CLIController
        $controller = new CbCLIController(
            $opts['log'],
            isset($opts['source']) ? $opts['source'] : array(),
            $opts['output'],
            isset($opts['excludePCRE']) ? $opts['excludePCRE'] : array(),
            isset($opts['excludePattern']) ? $opts['excludePattern'] : array(),
            new CbIOHelper()
        );

        $controller->addErrorPlugins(
            array(
                'CbErrorCheckstyle',
                'CbErrorPMD',
                'CbErrorCPD',
                'CbErrorPadawan',
                'CbErrorCoverage',
                'CbErrorCRAP'
            )
        );

        try {
            $controller->run();
        } catch (Exception $e) {
            error_log(
<<<HERE
[Error] {$e->getMessage()}

{$e->getTraceAsString()}
HERE
            );
        }
    }

    /**
     * Checks the given options array for errors.
     *
     * @param Array Options as returned by Console_CommandLine->parse()
     *
     * @return Array of String Errormessages.
     */
    private static function errorsForOpts($opts)
    {
        $errors = array();

        if (!isset($opts['log'])) {
            if (!isset($opts['source'])) {
                $errors[] = 'Missing log or source argument.';
            }
        } else if (!file_exists($opts['log'])) {
            $errors[] = 'Log directory does not exist.';
        } else if (!is_dir($opts['log'])) {
            $errors[] = 'Log argument must be a directory, a file was given.';
        }

        if (!isset($opts['output'])) {
            $errors[] = 'Missing output argument.';
        } else if (file_exists($opts['output']) && !is_dir($opts['output'])) {
            $errors[] = 'Ouput argument must be a directory, a file was given.';
        }

        if (isset($opts['source'])) {
            foreach ($opts['source'] as $s) {
                if (!file_exists($s)) {
                    $errors[] = "Source '$s' does not exist";
                }
            }
        }

        return $errors;
    }

    /**
     * Creates a Console_CommandLine object to parse options.
     *
     * @return Console_CommandLine
     */
    private static function createCommandLineParser()
    {
        $parser = new Console_CommandLine(
            array(
                'description' => 'A Code browser for PHP files with syntax '
                                    . 'highlighting and colored error-sections '
                                    . 'found by quality assurance tools like '
                                    . 'PHPUnit or PHP_CodeSniffer.',
                'version'     => (strpos('0.9.0', '@') === false)
                                    ? '0.9.0'
                                    : 'from Git'
            )
        );

        $parser->addOption(
            'log',
            array(
                'description' => 'The path to the xml log files, e.g. generated'
                                    . ' from PHPUnit. Either this or --source '
                                    . 'must be given',
                'short_name'  => '-l',
                'long_name'   => '--log'
            )
        );

        $parser->addOption(
            'output',
            array(
                'description' => 'Path to the output folder where generated '
                                    . 'files should be stored.',
                'short_name'  => '-o',
                'long_name'   => '--output'
            )
        );

        $parser->addOption(
            'source',
            array(
                'description' => 'Path to the project source code. Can either '
                                    . 'be a directory or a single file. Parse '
                                    . 'complete source directory if set, else '
                                    . 'only files found in logs. Either this or'
                                    . ' --log must be given. Can be given '
                                    . 'multiple times',
                'short_name'  => '-s',
                'long_name'   => '--source',
                'action'      => 'StoreArray'
            )
        );

        $parser->addOption(
            'excludePattern',
            array(
                'description' => 'Excludes all files matching the given glob '
                                    . 'pattern. This is done after pulling the '
                                    . 'files in the source dir in if one is '
                                    . 'given. Can be given multiple times. Note'
                                    . ' that the match is run against '
                                    . 'absolute filenames.',
                'short_name'  => '-e',
                'long_name'   => '--exclude',
                'action'      => 'StoreArray'
            )
        );

        $parser->addOption(
            'excludePCRE',
            array(
                'description' => 'Works like -e but takes PCRE instead of '
                                    . 'glob patterns.',
                'short_name'  => '-E',
                'long_name'   => '--excludePCRE',
                'action'      => 'StoreArray'
            )
        );

        return $parser;
    }
}
