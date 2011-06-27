<?php
require_once dirname(__FILE__) . '/../EditPageLayout_setup.php';
wfLoadAllExtensions();

class EditPageLayoutTest extends PHPUnit_Framework_TestCase {

	public function testMainPageEdit() {
		$title = WF::build('Title', array(), 'newMainPage');
		$article = WF::build('Article', array($title));

		// setup edit page object
		$editPage = WF::build('EditPageLayout', array($article));

		// it should extend MW core class
		$this->assertInstanceOf('EditPage', $editPage);

		$this->assertEquals($article, $editPage->getArticle());
		$this->assertEquals($title, $editPage->getEditedTitle());

		$formAction = str_replace('=edit', '=submit', $title->getEditURL());
		$this->assertEquals($formAction, $editPage->getFormAction());
	}
}