<?php
use PHPUnit\Framework\TestCase;

class TaxonomyCategoryListingApiTest extends TestCase {

	private $api;
	private $listing;

	public function setUp() {
		parent::setUp();
		$this->listing = $this->getMockBuilder('TaxonomyCategoryListing')
			->setMethods(['getCategoryListing'])
			->getMock();
		$this->api = new TaxonomyCategoryListingApiController($this->listing);
	}

	public function testResponse() {
		$this->listing->expects($this->any())
			->method('getCategoryListing')
			->will($this->returnValue([
				'Characters' => 50,
				'Episodes' => 22,
			]));
		$request = $this->getMockBuilder('WikiaRequest')
			->setMethods(['getInt'])
			->disableOriginalConstructor()
			->getMock();
		$request->expects($this->any())
			->method('getInt')
			->withAnyParameters()
			->will($this->returnValue(0));

		$response = $this->getMockBuilder('WikiaResponse')
			->setMethods(['setFormat', 'setValues'])
			->disableOriginalConstructor()
			->getMock();
		$response->expects($this->any())
			->method('setFormat')
			->with(WikiaResponse::FORMAT_JSON);
		$response->expects($this->once())
			->method('setValues')
			->with([
				'Characters' => 50,
				'Episodes' => 22,
			]);

		$this->api->setRequest($request);
		$this->api->setResponse($response);
		$this->api->listCategories();
	}
}
