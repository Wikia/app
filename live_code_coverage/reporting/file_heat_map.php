<?php
global $argv;

/****
 * Suggested usage: $ php file_heat_map.php > /tmp/file_heat_map.html
 *
 * Outputs an HTML document with a heatmap for files which appear in code coverage data.
 * This is determined by summing the number of lines run for each file.
 *
 * This code assumes that it's running from inside app/live_code_coverage/reporting
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

        $coverage_data[$file][$line] = $redis->get($key);
    }

    return $coverage_data;
}

$coverage_data = getCoverageData($redis);

fwrite(STDERR, "\n\nGenerating file heatmap...\n");

$totals = array();
$max_runs = 1;  // 1, to prevent div-by-zeros
foreach ($coverage_data as $file => $lines) {
    $totals[$file]["line_count"] = [
        "aggregate_runs" => 0,
        "lines_run" => 0
    ];

    foreach ($lines as $line => $aggregate_runs) {
        $totals[$file]["aggregate_runs"] += $aggregate_runs;
        $totals[$file]["lines_run"]++;
    }

    if ($totals[$file]["aggregate_runs"] > $max_runs) {
        $max_runs = $totals[$file]["aggregate_runs"];
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
$header = "<thead><tr>";
$header .= "<th class='line'>Lines Run<br/>(at least once)</th>";
$header .= "<th class='line'>Aggregate Lines Run</th>";
$header .= "<th class='line'>Run Ratio</th>";
$header .= "<th class='line_count'>File Name</th>";
$header .= "</tr></thead>";
$body .= $header;

foreach ($totals as $file => $run_data) {
    $aggregate_runs = $run_data["aggregate_runs"];
    $lines_run = $run_data["lines_run"];
    $run_ratio = round( $aggregate_runs / $lines_run, 1);

    $color_ratio = $aggregate_runs / $max_runs;    // For the coloration heatmap

    $style = "background-color: rgba(166, 255, 0, $color_ratio);";
    $converted_filename = str_replace("/", "_", $file);
    $tr = "<tr class='line' style='$style'>";
    $tr .= "<td class='line_count'>$lines_run</td>";
    $tr .= "<td class='line_count'>$aggregate_runs</td>";
    $tr .= "<td class='line_count'>$run_ratio</td>";
    $tr .= "<td class='line_text'><a href='./line_heat_maps/$converted_filename.html' target='_blank'>$file</a></td>";
    $tr .= "</tr>";
    $body .= $tr;
}

$body .= "</table>";

// Output the final doc
print "<html><head><style>$css</style><script>$sorttable_lib</script></head><body>$body</body></html>";

fwrite(STDERR, "\ndone\n");
