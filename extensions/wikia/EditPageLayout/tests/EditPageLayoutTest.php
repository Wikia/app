<?php
require_once dirname(__FILE__) . '/../EditPageLayout_setup.php';
wfLoadAllExtensions();

class EditPageLayoutTest extends PHPUnit_Framework_TestCase {

	private function editPageFactory(Title $title) {
		$article = WF::build('Article', array($title));

		return WF::build('EditPageLayout', array($article));
	}

	public function testMainPageEdit() {
		// setup edit page object
		$title = WF::build('Title', array(), 'newMainPage');
		$editPage = $this->editPageFactory($title);

		// it should extend MW core class
		$this->assertInstanceOf('EditPage', $editPage);

		$this->assertEquals($title->getArticleID(), $editPage->getArticle()->getID());
		$this->assertEquals($title, $editPage->getEditedTitle());

		$formAction = str_replace('action=edit', 'action=submit', $title->getEditURL());
		$this->assertEquals($formAction, $editPage->getFormAction());
	}

	public function testCustomFormHandler() {
		$title = WF::build('Title', array('Foo'), 'newFromText');
		$editPage = $this->editPageFactory($title);

		$customHandler = WF::build('Title', array('Special:CustomHandler'), 'newFromText');

		$editPage->setCustomFormHandler($customHandler);
		$this->assertEquals($customHandler, $editPage->getCustomFormHandler());
		$this->assertEquals($customHandler->getLocalURL('action=submit'), $editPage->getFormAction());
	}
}