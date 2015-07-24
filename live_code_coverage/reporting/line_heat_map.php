<?php
global $argv;

/****
 * Suggested usage: $ php line_heat_map.php /absolute/path/to/file/to/get/heatmap/for.php > /tmp/line_heat_map.html
 *
 * Outputs an HTML document for a given file with a heatmap of lines run.
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

$evaluated_file = $argv[1];

if (!file_exists($evaluated_file)) {
    fwrite(STDERR, "FATAL - Unable to find file: $evaluated_file\n");
    exit;
}

// Deserialize the combined coverage data out of Redis
function getCoverageData($redis, $evaluated_file)
{
    $all_keys = array();
    $coverage_data = array();

    // TODO: This could probably be sped up by using this:
    // TODO: http://stackoverflow.com/questions/28545549/how-to-use-scan-with-the-match-option-in-predis

    fwrite(STDERR, "Gathering coverage data...\n");

    $pattern = "$evaluated_file:*";
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

    fwrite(STDERR, "\n\nGathering line run counts...\n");
    $total_lines = count($all_keys);
    $i = 0;
    foreach ($all_keys as $key) {
        if ($i % 100 === 0) {
            fwrite(STDERR, "\r\033[K");
            fwrite(STDERR, "$i / $total_lines");
        }
        $i++;

        $parts = explode(":", $key);

        $file = $parts[0];
        $line = $parts[1];

        if ($file !== $evaluated_file) {
            continue;
        }

        $coverage_data[$file][$line] = $redis->get($key);
    }

    return $coverage_data;
}

$coverage_data = getCoverageData($redis, $evaluated_file);

fwrite(STDERR, "\n\nGenerating heatmap...\n");

// Determine what constitutes "high", "medium", "low" for usage.
$max_runs = 1;  // 1, to prevent div-by-zeros
foreach ($coverage_data[$evaluated_file] as $run_count) {
    if ($run_count > $max_runs) {
        $max_runs = $run_count;
    }
}

// Construct the HTML
$css = "
    td {
        padding: 0.25em;
    }

    .line_number {
        width: 4em;
    }

    .line_count {
        width: 10em;
    }

    table.sortable thead {
        background-color:#eee;
        color:#666666;
        font-weight: bold;
        cursor: default;
    }
";

$sorttable_lib = file_get_contents("sorttable.js");

$body = "<table class='sortable'>";
$header = "<thead><tr><th class='line'>Line #</th><th class='line_count'>Run Count</th><th class='line_name'>File Name</th></tr></thead>";
$body .= $header;

$i = 1;
$base_file = file($evaluated_file);
foreach ($base_file as $line) {
    $count = 0;
    if (array_key_exists($i, $coverage_data[$evaluated_file])) {
        $count = $coverage_data[$evaluated_file][$i];
    }

    $ratio = $count / $max_runs;    // For the coloration heatmap

    $style = "background-color: rgba(255, 166, 0, $ratio);";
    $tr = "<tr class='line' style='$style'><td class='line_number'>$i</td><td class='line_count'>$count</td><td class='line_text'><pre>";
    $tr .= htmlentities($line, ENT_QUOTES);
    $tr .= "</pre></td></tr>";
    $body .= $tr;

    $i++;
}

$body .= "</table>";

// Output the final doc
print "<html><head><style>$css</style><script>$sorttable_lib</script></head><body>$body</body></html>";

fwrite(STDERR, "\ndone\n");
