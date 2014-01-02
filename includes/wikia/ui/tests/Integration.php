<?php
/**
 * @group Integration
 *
 * Integration test for Wikia Styleguide.
 *
 * Covers:
 * * Wikia\UI\Factory
 * * Wikia\UI\Component
 *
 */

class Integration extends WikiaBaseTest {

	/**
	 * @var \Wikia\UI\Factory $uiFactory
	 */
	private $uiFactoryMock;
	
	public function testRenderingOneComponent() {
		// only required parameters given
		$this->assertEquals(
			'<input type="submit"  class="button small " name="just-a-button" value="Just a button in form of a link"  />',
			trim(
				\Wikia\UI\Factory::getInstance()->init( 'button' )->render([
					'type' => 'input',
					'vars' => [
						'type' => 'submit',
						'name' => 'just-a-button',
						'classes' => ['small'],
						'value' => 'Just a button in form of a link',
					]
				])
			)
		);
		
		// required parameters and optional given
		$this->assertEquals(
			'<input type="submit" id="uniqueButton" class="button small blue " name="just-a-button" value="Just a button in form of a link" disabled />',
			trim(
				\Wikia\UI\Factory::getInstance()->init( 'button' )->render([
					'type' => 'input',
					'vars' => [
						'type' => 'submit',
						'name' => 'just-a-button',
						'classes' => ['small', 'blue'],
						'value' => 'Just a button in form of a link',
						'id' => ['uniqueButton'],
						'disabled' => 'disabled'
					]
				])
			)
		);

		// required parameters and optional given + data attributes
		$this->assertEquals(
			'<input type="submit" id="uniqueButton" class="button small blue " name="just-a-button" value="Just a button in form of a link" disabled data-id="123"data-name="button"/>',
			trim(
				\Wikia\UI\Factory::getInstance()->init( 'button' )->render([
					'type' => 'input',
					'vars' => [
						'type' => 'submit',
						'name' => 'just-a-button',
						'classes' => ['small', 'blue'],
						'value' => 'Just a button in form of a link',
						'id' => ['uniqueButton'],
						'disabled' => 'disabled',
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
		list($a, $b, $c) = \Wikia\UI\Factory::getInstance()->init( [ 'button', 'button', 'button' ] );
		
		/** @var \Wikia\UI\Component $a */
		$aMarkup = $a->render([
			'type' => 'link',
			'vars' => [
				'href' => 'http://www.wikia.com',
				'classes' => ['small'],
				'value' => 'Just a button in form of a link',
				'title' => 'Link which looks like a button!'
			]
		]);

		/** @var \Wikia\UI\Component $b */
		$bMarkup = $b->render([
			'type' => 'button',
			'vars' => [
				'type' => 'submit',
				'classes' => ['small', 'blue'],
				'value' => 'Just a button in form of a link',
				'id' => [ 'uniqueButton' ],
				'disabled' => 'disabled',
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
				'classes' => ['small', 'blue'],
				'value' => 'Just a button in form of a link',
				'id' => ['uniqueButton'],
				'disabled' => 'disabled',
				'data' => [
					[ 'key' => 'id', 'value' => 123 ],
					[ 'key' => 'name', 'value' => 'button' ]
				],
			]
		]);
		
		$this->assertEquals(
			'<a href="http://www.wikia.com"  class="button small " title="Link which looks like a button!" target="" >Just a button in form of a link</a>',
			trim($aMarkup)
		);

		$this->assertEquals(
			'<button type="submit" id="uniqueButton " class="button small blue " disabled  data-id="123" data-name="button">Just a button in form of a link</button>',
			trim($bMarkup)
		);

		$this->assertEquals(
			'<input type="submit" id="uniqueButton" class="button small blue " name="just-a-button" value="Just a button in form of a link" disabled data-id="123"data-name="button"/>',
			trim($cMarkup)
		);
	}

}
