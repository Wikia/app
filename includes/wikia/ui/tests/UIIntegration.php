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

	protected function setUp() {
		$this->path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '_fixtures/components/';

		$this->uiFactory = UIFactory::getInstance();
		$this->uiFactory->setComponentsDir( $this->path );
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
