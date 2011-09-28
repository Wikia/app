<?php
/**
 * Author:: Gilles Devaux (<gilles.devaux@gmail.com>)
 * Copyright:: Copyright (c) 2011 Formspring.me
 * License:: Apache License, Version 2.0
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

class Indextank_Api
{
    /*
     * Basic client for an account.
     * It needs an API url to be constructed.
     * It has methods to manage and access the indexes of the
     * account. The objects returned by these methods implement
     * the IndexClient class.
     */

    private $api_url = NULL;
    private $http_options = NULL;

    function __construct($api_url, $http_options = array())
    {
        $this->api_url = rtrim($api_url, "/");
        $this->http_options = $http_options;
    }

    public function get_index($index_name)
    {
        return new Indextank_Index($this, $index_name);
    }

    public function list_indexes()
    {
        return json_decode($this->api_call('GET', $this->indexes_url())->response);
    }

    public function create_index($index_name, $options = array())
    {
        $index = $this->get_index($index_name);
        $index->create_index($options);
        return $index;
    }

    public function set_http_options($http_options)
    {
        $this->http_options = $http_options;
    }

    public function indexes_url()
    {
        return $this->api_url . '/v1/indexes';
    }

    public function index_url($index_name)
    {
        return $this->indexes_url() . "/" . urlencode($index_name);
    }

    /**
     * Make a call to the api
     * @throws Indextank_Exception_HttpException
     * @param string $method HTTP method
     * @param string $url URL to call
     * @param array $params query parameters or body
     * @param array $http_options curlopt options
     * @return Indextank_Response
     */
    public function api_call($method, $url, $params = array(), $http_options = array())
    {
        if ($method == "GET" || $method == "DELETE") {
            $args = http_build_query($params);

            // remove the php special encoding of parameters
            // see http://www.php.net/manual/en/function.http-build-query.php#78603
            $args = preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '=', $args);

            $url .= '?' . $args;
            $args = '';
        } else {
            $args = json_encode($params);
        }

        $session = curl_init($url);
        curl_setopt($session, CURLOPT_CUSTOMREQUEST, $method); // Tell curl to use HTTP method of choice
        curl_setopt($session, CURLOPT_POSTFIELDS, $args); // Tell curl that this is the body of the POST
        curl_setopt($session, CURLOPT_HEADER, false); // Tell curl not to return headers
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // Tell curl to return the response
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Expect:')); //Fixes the HTTP/1.1 417 Expectation Failed

        foreach ($this->http_options as $curlopt => $value) {
            curl_setopt($session, $curlopt, $value);
        }

        foreach ($http_options as $curlopt => $value) {
            curl_setopt($session, $curlopt, $value);
        }

        $response = curl_exec($session);
        $http_code = curl_getinfo($session, CURLINFO_HTTP_CODE);
        curl_close($session);

        if (floor($http_code / 100) == 2) {
            return new Indextank_Response($http_code, $response);
        }
        throw new Indextank_Exception_HttpException($response, $http_code);
    }

}
