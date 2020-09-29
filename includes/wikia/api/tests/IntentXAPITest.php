<?php

class IntentXAPITEST extends WikiaBaseTest {
    private $client;
    private $response;
    private $body;
    private $data;

	/**
	 * Test IntentX API
	 */
    public function setUp() {
        global $wgFandomShopUrl;

        parent::setUp();

        $this->client = new GuzzleHttp\Client( [
            'base_uri' => $wgFandomShopUrl,
            'timeout' => 30.0
        ] );

        $params = [
            'clientId' => 'fandom',
            'relevanceKey' => 'Star Wars'
        ];
        
        $this->response = $this->client->get( '', [
            'query' => GuzzleHttp\Psr7\build_query( $params, PHP_QUERY_RFC1738 ),
        ] );

        $this->body = $this->response->getBody();
        $this->data = json_decode( $this->body );

        require_once __DIR__ . '/../DesignSystemApiController.class.php';
    }

    public function tearDown() {
        $this->client = null;
    }
    
    public function testGet() {
        // check for successful response
        $this->assertEquals(200, $this->response->getStatusCode());

        // check for proper content type
        $contentType = $this->response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json;charset=UTF-8", $contentType);

        // check for valid data
        $this->assertObjectHasAttribute( 'results', $this->data );
    }
}
