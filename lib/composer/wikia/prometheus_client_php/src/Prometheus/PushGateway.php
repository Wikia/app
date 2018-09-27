<?php


namespace Prometheus;


use GuzzleHttp\Client;

class PushGateway
{
    private $address;
    private $connect_timeout;
    private $timeout;

    /**
     * PushGateway constructor.
     * @param $address string host:port of the push gateway
     * @param $connect_timeout int HTTP connection timeout
     * @param $timeout int HTTP request timeout
     */
    public function __construct(string $address, int $connect_timeout = 10, int $timeout = 20)
    {
        $this->address = $address;
        $this->connect_timeout = $connect_timeout;
        $this->timeout = $timeout;
    }

    /**
     * Pushes all metrics in a Collector, replacing all those with the same job.
     * Uses HTTP PUT.
     * @param CollectorRegistry $collectorRegistry
     * @param $job
     * @param $groupingKey
     */
    public function push(CollectorRegistry $collectorRegistry, $job, $groupingKey = null)
    {
        $this->doRequest($collectorRegistry, $job, $groupingKey, 'put');
    }

    /**
     * Pushes all metrics in a Collector, replacing only previously pushed metrics of the same name and job.
     * Uses HTTP POST.
     * @param CollectorRegistry $collectorRegistry
     * @param $job
     * @param $groupingKey
     */
    public function pushAdd(CollectorRegistry $collectorRegistry, $job, $groupingKey = null)
    {
        $this->doRequest($collectorRegistry, $job, $groupingKey, 'post');
    }

    /**
     * Deletes metrics from the Pushgateway.
     * Uses HTTP POST.
     * @param $job
     * @param $groupingKey
     */
    public function delete($job, $groupingKey = null)
    {
        $this->doRequest(null, $job, $groupingKey, 'delete');
    }

    /**
     * @param CollectorRegistry $collectorRegistry
     * @param $job
     * @param $groupingKey
     * @param $method
     */
    private function doRequest(CollectorRegistry $collectorRegistry, $job, $groupingKey, $method)
    {
        $url = "http://" . $this->address . "/metrics/job/" . $job;
        if (!empty($groupingKey)) {
            foreach ($groupingKey as $label => $value) {
                $url .= "/" . $label . "/" . $value;
            }
        }
        $client = new Client();
        $requestOptions = array(
            'headers' => array(
                'Content-Type' => RenderTextFormat::MIME_TYPE
            ),
            'connect_timeout' => $this->connect_timeout,
            'timeout' => $this->timeout,
        );
        if ($method != 'delete') {
            $renderer = new RenderTextFormat();
            $requestOptions['body'] = $renderer->render($collectorRegistry->getMetricFamilySamples());
        }
        $response = $client->request($method, $url, $requestOptions);
        $statusCode = $response->getStatusCode();
        if ($statusCode != 202) {
            $msg = "Unexpected status code " . $statusCode . " received from pushgateway " . $this->address . ": " . $response->getBody();
            throw new \RuntimeException($msg);
        }
    }

}
