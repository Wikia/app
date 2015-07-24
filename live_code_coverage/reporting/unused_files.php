<?php
/****
 * Suggested usage: $ php unused_files.php > /tmp/unused_files.txt
 *
 * Outputs a list of files that appear somewhere in the app/ path, but which did not appear in the
 * collected code coverage data.
 *
 * This code assumes that it's running from inside app/live_code_coverage/reporting.
 *
 */

require __DIR__ . '/../config.php';
require __DIR__ . '/../predis-1.0.1/autoload.php';
Predis\Autoloader::register();
use Predis\Collection\Iterator;

global $config;

$redis = new Predis\Client($config);

// Deserialize the combined coverage data out of Redis
function getCoverageData($redis)
{
    $all_keys = array();
    $coverage_data = array();

    fwrite(STDERR, "Gathering coverage data...\n");
    $pattern = "*";
    $i = 0;
    foreach (new Iterator\Keyspace($redis, $pattern) as $key) {
        array_push($all_keys, $key);
        $parts = explode(":", $key);

        $file = $parts[0];
        $line = $parts[1];

        if (!array_key_exists($file, $coverage_data)) {
            $coverage_data[$file] = array();
        }

        $coverage_data[$file][$line] = -1;  // So that we'll know if there was just a Redis lookup error for a line
        if ($i % 100 === 0) {
            fwrite(STDERR, "\r\033[K");
            fwrite(STDERR, count($all_keys));
        }
        $i++;
    }

    return $coverage_data;
}

$coverage_data = getCoverageData($redis);

function getFileList()
{
    fwrite(STDERR, "\n\nGathering file list...\n");

    $Directory = new RecursiveDirectoryIterator('../../');
    $Iterator = new RecursiveIteratorIterator($Directory);
    $Regex = new RegexIterator($Iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);
    $file_list = array();
    foreach ($Regex as $file) {
        array_push($file_list, realpath($file[0]));
    }
    return $file_list;
}
$file_list = getFileList();

fwrite(STDERR, "\n\nFinding unused files...\n");
fwrite(STDERR, count($file_list) . " files found\n");
fwrite(STDERR, count(array_keys($coverage_data)) . " files with coverage\n");

$unused_files = array_diff($file_list, array_keys($coverage_data));

fwrite(STDERR, count($unused_files) . " unused files \n");
foreach( $unused_files as $file ) {
    print "$file\n";
}

fwrite(STDERR, "\ndone\n");
