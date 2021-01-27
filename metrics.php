<?php

/**
 * This is an HTTP end-point that exposes metrics for Prometheus
 *
 * @see SUS-5855
 */

// Prometheus does not set a "Host" header,
// tell WikiFactoryLoader class which wiki to use when serving this request
$_ENV['SERVER_ID'] = 2393201;

require __DIR__ . '/includes/WebStart.php'; // we want to load config to have $wgRedisHost

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;

$adapter = new Prometheus\Storage\Redis( [ 'host' => $wgRedisHost ] );

$registry = new CollectorRegistry($adapter);
$renderer = new RenderTextFormat();

header( 'Content-Type: ' . RenderTextFormat::MIME_TYPE );
header( 'Cache-Control: s-maxage=0, must-revalidate, max-age=0' );

echo $renderer->render( $registry->getMetricFamilySamples() );
