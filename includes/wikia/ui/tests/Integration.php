<?php
class Integration extends WikiaBaseTest {
	/**
	 * @var String $path
	 */
	private $path;

	/**
	 * @var \Wikia\UI\Factory $uiFactory
	 */
	private $uiFactory;

	protected function setUp() {
		parent::setUp();
		$this->path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '_fixtures/components/';

		$this->uiFactory = \Wikia\UI\Factory::getInstance();
		$this->uiFactory->setComponentsDir( $this->path );
	}
	
	public function testRenderingOneComponent() {
		// only required parameters given
		$this->assertEquals(
			'<input type="submit" class="button " name="just-a-button" value="Just a button in form of a link" />',
			trim(
				$this->uiFactory->init( 'button' )->render([
					'type' => 'input',
					'vars' => [
						'type' => 'submit',
						'name' => 'just-a-button',
						'classes' => ['button'],
						'value' => 'Just a button in form of a link',
					]
				])
			)
		);
		
		// required parameters and optional given
		$this->assertEquals(
			'A button: <a href="http://www.wikia.com" class="button big " target="_blank">Just a button in form of a link</a>',
			trim(
				$this->uiFactory->init( 'button' )->render([
					'type' => 'link',
					'vars' => [
						'href' => 'http://www.wikia.com',
						'classes' => ['button', 'big'],
						'value' => 'Just a button in form of a link',
						'label' => 'A button: ',
						'target' => '_blank',
					]
				])
			)
		);

		// required parameters and optional given + data attributes
		$this->assertEquals(
			'A button: <button type="submit" class="button " data-id="123" data-name="button">Just a button in form of a link</button>',
			trim(
				$this->uiFactory->init( 'button' )->render([
					'type' => 'button',
					'vars' => [
						'type' => 'submit',
						'classes' => ['button'],
						'value' => 'Just a button in form of a link',
						'label' => 'A button: ',
						'data' => [
							[ 'key' => 'id', 'value' => 123 ],
							[ 'key' => 'name', 'value' => 'button' ]
						],
					]
				])
			)
		);
	}

	public function testRenderingMoreThanOneComponent() {
		list($a, $b, $c) = $this->uiFactory->init( [ 'button', 'button', 'button' ] );
		
		/** @var \Wikia\UI\Component $a */
		$aMarkup = $a->render([
			'type' => 'link',
			'vars' => [
				'href' => 'http://www.wikia.com',
				'classes' => ['button'],
				'value' => 'Just a button in form of a link',
			]
		]);

		/** @var \Wikia\UI\Component $b */
		$bMarkup = $b->render([
			'type' => 'button',
			'vars' => [
				'type' => 'submit',
				'classes' => ['button'],
				'value' => 'Just a button in form of a link',
				'label' => 'A button: ',
				'data' => [
					[ 'key' => 'id', 'value' => 123 ],
					[ 'key' => 'name', 'value' => 'button' ]
				],
			]
		]);

		/** @var \Wikia\UI\Component $c */
		$cMarkup = $c->render([
			'type' => 'input',
			'vars' => [
				'type' => 'submit',
				'name' => 'just-a-button',
				'classes' => ['button'],
				'value' => 'Just a button in form of a link',
				'label' => 'An input: ',
			]
		]);
		
		$this->assertEquals(
			'<a href="http://www.wikia.com" class="button " target="">Just a button in form of a link</a>',
			trim($aMarkup)
		);

		$this->assertEquals(
			'A button: <button type="submit" class="button " data-id="123" data-name="button">Just a button in form of a link</button>',
			trim($bMarkup)
		);

		$this->assertEquals(
			'An input: <input type="submit" class="button " name="just-a-button" value="Just a button in form of a link" />',
			trim($cMarkup)
		);
	}
}
