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
		$article = F::build('Article', array($title));
		return F::build('EditPageLayout', array($article));
	}

	public function testMainPageEdit() {
		// setup edit page object
		$title = F::build('Title', array(), 'newMainPage');
		$editPage = $this->editPageFactory($title);

		// it should extend MW core class
		$this->assertInstanceOf('EditPage', $editPage);

		$this->assertEquals($title->getArticleID(), $editPage->getArticle()->getID());
		$this->assertEquals($title, $editPage->getEditedTitle());

		$formAction = str_replace('action=edit', 'action=submit', $title->getEditURL());
		$this->assertEquals($formAction, $editPage->getFormAction());
	}

	public function testCustomFormHandler() {
		$title = F::build('Title', array('Foo'), 'newFromText');
		$editPage = $this->editPageFactory($title);

		$customHandler = F::build('Title', array('Special:CustomHandler'), 'newFromText');

		$editPage->setCustomFormHandler($customHandler);
		$this->assertEquals($customHandler, $editPage->getCustomFormHandler());
		$this->assertEquals($customHandler->getLocalURL('action=submit'), $editPage->getFormAction());
		$this->assertEquals($title, $editPage->getEditedTitle());
	}

	public function testAddingFields() {
		$title = F::build('Title', array('Foo'), 'newFromText');
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
		$this->assertStringStartsWith('<textarea id="wpSummary" name="wpSummary" placeholder=', $editPage->renderSummaryBox());
	}

	public function testPreloadText() {
		$title = F::build('Title', array('NewArticle'), 'newFromText');
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

	public function testEditNotices() {
		$title = F::build('Title', array('NewArticle'), 'newFromText');
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
