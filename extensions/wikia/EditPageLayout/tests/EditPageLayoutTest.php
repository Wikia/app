<?php

class EditPageLayoutTest extends WikiaBaseTest {

	public function setUp() {
		require_once( dirname(__FILE__) . '/../../CityVisualization/CityVisualization.setup.php' );
		$this->setupFile = dirname(__FILE__) . '/../EditPageLayout_setup.php';
		parent::setUp();
	}

	/**
	 * @param Title $title
	 * @return EditPageLayout
	 */
	private function editPageFactory(Title $title) {
		$article = new Article($title);
		return new EditPageLayout($article);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.01107 ms
	 * @group UsingDB
	 */
	public function testMainPageEdit() {
		// setup edit page object
		$title = Title::newMainPage();
		$editPage = $this->editPageFactory($title);

		// it should extend MW core class
		$this->assertInstanceOf('EditPage', $editPage);

		$this->assertEquals($title->getArticleID(), $editPage->getArticle()->getID());
		$this->assertEquals($title, $editPage->getEditedTitle());

		$formAction = str_replace('action=edit', 'action=submit', $title->getEditURL());
		$this->assertEquals($formAction, $editPage->getFormAction());
	}

	/**
	 * @group UsingDB
	 */
	public function testCustomFormHandler() {
		$title = Title::newFromText('Foo');
		$editPage = $this->editPageFactory($title);

		$customHandler = Title::newFromText('Special:CustomHandler');

		$editPage->setCustomFormHandler($customHandler);
		$this->assertEquals($customHandler, $editPage->getCustomFormHandler());
		$this->assertEquals($customHandler->getLocalURL('action=submit'), $editPage->getFormAction());
		$this->assertEquals($title, $editPage->getEditedTitle());
	}

	/**
	 * @group UsingDB
	 */
	public function testAddingFields() {
		$title = Title::newFromText('Foo');
		$editPage = $this->editPageFactory($title);

		// test custom checkboxes
		$editPage->addCustomCheckbox('foo', 'label', true /* $checked */);
		$editPage->addCustomCheckbox('bar', 'test', false /* $checked */);

		$this->assertEquals(array(
			array(
				'name' => 'foo',
				'label' => 'label',
				'checked' => true,
			),
			array(
				'name' => 'bar',
				'label' => 'test',
				'checked' => false,
			),
		), $editPage->getCustomCheckboxes());

		// test hidden fields
		$editPage->addHiddenField(array(
			'type' => 'checkbox',
			'name' => 'foo',
			'value' => true,
			'label' => 'label',
		));
		$editPage->addHiddenField(array(
			'type' => 'text',
			'name' => 'bar',
			'value' => 'summary',
			'required' => false,
		));
		$editPage->addHiddenField(array(
			'type' => 'textarea',
			'name' => 'field123',
			'value' => 'qwerty',
			'required' => true,
		));
		$editPage->addHiddenField(array(
			'type' => 'hidden',
			'name' => 'test',
			'value' => 'hidden value',
		));

		$this->assertEquals(
			'<fieldset id="EditPageHiddenFields">'.
				'<label>label<input type="checkbox" name="foo" value="1" data-required="" checked="checked" /></label>'.
				'<input type="text" name="bar" value="summary" data-required="" />'.
				'<textarea name="field123" data-required="1">qwerty</textarea>'.
				'<input type="hidden" name="test" value="hidden value" data-required="" />'.
			'</fieldset>',
			$editPage->renderHiddenFields());

		// summary box
		$this->assertStringStartsWith('<input type="text" id="wpSummary" name="wpSummary" placeholder=', $editPage->renderSummaryBox());
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07107 ms
	 * @group UsingDB
	 */
	public function testPreloadText() {
		$title = Title::newFromText('NewArticle');
		$editPage = $this->editPageFactory($title);
		// This test has a dependency on the global title
		// TODO: fixme with $this->mockProxy
		global $wgTitle;
		$tempTitle = $wgTitle;
		$wgTitle = $title;
		// TODO mock something in this test because it's running hooks

		$preload = 'Preload - testing, testing...';
		$editPage->setPreloadedText($preload);
		$editPage->showEditForm();

		// With RTE enabled by default now, this is wrapped in a <p> tag
		$this->assertContains($preload, $editPage->textbox1);
		$wgTitle = $tempTitle;
	}

	/**
	 * @group UsingDB
	 */
	public function testEditNotices() {
		$title = Title::newFromText('NewArticle');
		$editPage = $this->editPageFactory($title);

		$testNotice1Body = '<div>1st notice</div>';
		$testNotice1Key = 'TESTKEY1';
		$testNotice2Body = '<div>2nd notice</div>';
		$testNotice2Key = 'TESTKEY2';

		$editPage->addEditNotice($testNotice1Body, $testNotice1Key);
		$editPage->addEditNotice($testNotice2Body, $testNotice2Key);

		$this->assertEquals(array(
			md5($testNotice1Key) => '1st notice',
			md5($testNotice2Key) => '2nd notice'
		), $editPage->getNotices());
		$this->assertEquals($testNotice1Body.$testNotice2Body, $editPage->getNoticesHtml());
	}
}
