<?php
class UIIntegration extends PHPUnit_Framework_TestCase {
	/**
	 * @var String $path
	 */
	private $path;

	/**
	 * @var UIFactory $uiFactory
	 */
	private $uiFactory;

	/**
	 * @var String $serializedComponentsList
	 */
	private $serializedComponentsList;

	protected function setUp() {
		$this->serializedComponentsList = 'a:1:{i:0;a:5:{s:4:"name";s:7:"Buttons";s:11:"description";s:784:"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam in felis dui. Mauris feugiat tortor consectetur vulputate pretium. Vestibulum posuere ut ipsum in elementum. Pellentesque ipsum elit, pulvinar quis venenatis ut, tristique at erat. Mauris molestie erat nunc, elementum aliquet neque euismod in. Pellentesque porta malesuada justo, a commodo dolor mollis eu. Etiam imperdiet vestibulum dolor, sit amet porta ante euismod et. Morbi eget faucibus dolor. Nullam eu diam nec augue ultricies laoreet. Sed nisi tellus, ultrices eu consectetur vitae, accumsan eget lorem. Proin et dapibus justo. Aliquam sit amet sem nec enim bibendum commodo. Praesent interdum libero sem, ac ornare purus facilisis non. Mauris id hendrerit elit. Quisque quis magna tincidunt erat ornare euismod.";s:12:"templateVars";a:3:{s:4:"link";a:2:{s:8:"required";a:3:{i:0;s:4:"href";i:1;s:7:"classes";i:2;s:5:"value";}s:8:"optional";a:2:{i:0;s:5:"label";i:1;s:6:"target";}}s:5:"input";a:2:{s:8:"required";a:3:{i:0;s:4:"name";i:1;s:7:"classes";i:2;s:5:"value";}s:8:"optional";a:1:{i:0;s:5:"label";}}s:6:"button";a:2:{s:8:"required";a:3:{i:0;s:4:"type";i:1;s:7:"classes";i:2;s:5:"value";}s:8:"optional";a:1:{i:0;s:5:"label";}}}s:12:"dependencies";a:2:{s:2:"js";a:0:{}s:3:"css";a:0:{}}s:2:"id";s:7:"buttons";}}';
		$this->path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '_fixtures/components/';
		
		$this->uiFactory = UIFactory::getInstance();
		$this->uiFactory->setComponentsDir( $this->path );
	}
	
	public function testGettingAllComponentsList() {
		$this->assertEquals( 
			unserialize( $this->serializedComponentsList ), 
			$this->uiFactory->getAllComponents() 
		);
	}
	
	public function testRenderingOneComponent() {
		// only required parameters given
		$this->assertEquals(
			'<a href="http://www.wikia.com" class="button" target="">Just a button in form of a link</a>',
			$this->uiFactory->init( 'button' )->render([
				'type' => 'link',
				'params' => [
					'href' => 'http://www.wikia.com',
					'classes' => ['button'],
					'value' => 'Just a button in form of a link',
				]
			])
		);

		// required parameters and optional given
		$this->assertEquals(
			'A button: <a href="http://www.wikia.com" class="button" target="_blank">Just a button in form of a link</a>',
			$this->uiFactory->init( 'button' )->render([
				'type' => 'link',
				'params' => [
					'href' => 'http://www.wikia.com',
					'classes' => ['button'],
					'value' => 'Just a button in form of a link',
					'label' => 'A button: ',
					'target' => '_blank',
				]
			])
		);

		// required parameters and optional given + data attributes
		$this->assertEquals(
			'A button: <a href="http://www.wikia.com" class="button" target="_blank" data-id="123" data-name="button">Just a button in form of a link</a>',
			$this->uiFactory->init( 'button' )->render([
				'type' => 'link',
				'params' => [
					'href' => 'http://www.wikia.com',
					'classes' => ['button'],
					'value' => 'Just a button in form of a link',
					'label' => 'A button: ',
					'target' => '_blank',
					'data' => [
						[ 'key' => 'id', 'value' => 123 ],
						[ 'key' => 'name', 'value' => 'button' ]
					],
				]
			])
		);
	}

	public function testRenderingMoreThanOneComponent() {
		list($a, $b) = $this->uiFactory->init( [ 'button', 'button' ] );
		
		$aMarkup = $a->render([
			'type' => 'link',
			'params' => [
				'href' => 'http://www.wikia.com',
				'classes' => ['button'],
				'value' => 'Just a button in form of a link',
			]
		]);
		
		$bMarkup = $b->render([
			'type' => 'link',
			'params' => [
				'href' => 'http://www.wikia.com',
				'classes' => ['button'],
				'value' => 'Just a button in form of a link',
				'label' => 'A button: ',
				'target' => '_blank',
				'data' => [
					[ 'key' => 'id', 'value' => 123 ],
					[ 'key' => 'name', 'value' => 'button' ]
				],
			]
		]);
		
		$this->assertEquals(
			'<a href="http://www.wikia.com" class="button" target="">Just a button in form of a link</a>',
			$aMarkup
		);

		$this->assertEquals(
			'A button: <a href="http://www.wikia.com" class="button" target="_blank" data-id="123" data-name="button">Just a button in form of a link</a>',
			$bMarkup
		);
	}
}
