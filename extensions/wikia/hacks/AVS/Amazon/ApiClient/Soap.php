<?php
class Amazon_ApiClient_Soap extends Amazon_AApiClient
{
    const WSDL_URL = 'http://ecs.amazonaws.com/AWSECommerceService/2009-11-01/AWSECommerceService.wsdl';

    private $_soapClient;

    public function __construct(array $options = array())
    {
        parent::__construct($options);
    }

    private function _getSoapClient()
    {
            global $wgHTTPProxy;

            list($proxyHost, $proxyPort) = explode(':', $wgHTTPProxy);
            $this->_soapClient = new SoapClient(self::WSDL_URL, array(
                'exceptions' => 1,
                'classmap' => array(
                    'Item'            => 'Amazon_Item',
                    'CustomerReview'  => 'Amazon_CustomerReview',
                    'EditorialReview' => 'Amazon_EditorialReview',
                    'Image'           => 'Amazon_Image',
                    'ListmaniaList'   => 'Amazon_ListmaniaList'
                ),
                'proxy_host' => $proxyHost,
                'proxy_port' => $proxyPort
            ));

        return $this->_soapClient;
    }

    private function _call($procedure, $request)
    {
        $client    = $this->_getSoapClient();
        $timestamp = gmdate("Y-m-d\TH:i:s\Z");
        $signature = base64_encode(hash_hmac("sha256", $procedure . $timestamp, $this->_apiSecretKey, true));
        $request['AssociateTag'] = $this->_associateTag;
        $params    = array(
                         'AWSAccessKeyId' => $this->_apiKey,
                         'AssociateTag'   => $this->_associateTag,
                         'Signature'      => $signature,
                         'Timestamp'      => $timestamp,
                         'Request'        => $request
        );

        $header_arr = array();
        $header_arr[] = new SoapHeader('http://security.amazonaws.com/doc/2007-01-01/', 'AWSAccessKeyId', $this->_apiKey);
        $header_arr[] = new SoapHeader('http://security.amazonaws.com/doc/2007-01-01/', 'AssociateTag', $this->_associateTag);
        $header_arr[] = new SoapHeader('http://security.amazonaws.com/doc/2007-01-01/', 'Timestamp', $timestamp);
        $header_arr[] = new SoapHeader('http://security.amazonaws.com/doc/2007-01-01/', 'Signature', $signature );
        $client->__setSoapHeaders($header_arr);

        return $client->__soapCall($procedure, array($params));
    }

    public function itemSearch(array $options)
    {
        if (!isset($options['ResponseGroup'])) {
            $options['ResponseGroup'] = 'Large';
        }

        return $this->_call('ItemSearch', $options);
    }

    public function itemLookup($itemId, array $options = array())
    {
        if (!isset($options['ResponseGroup'])) {
            $options['ResponseGroup'] = 'Large';
        }

        $options['ItemId'] = $itemId;

        return $this->_call('ItemLookup', $options);
    }
}