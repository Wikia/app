package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import java.util.Random;

import org.testng.annotations.Test;

public class CreatePageReskinTest extends EditPageBaseTest {

	private void openDialogOnRandomPage() throws Exception {
		session().open("index.php?title=Special:Random");
		session().waitForPageToLoad(this.getTimeout());

		if (isOasis()) {
			session().click("//div[@id='WikiaRail']//a[@class='wikia-button createpage']");
		}
		else {
			session().click("//a[@id='dynamic-links-write-article-link']");
		}

		waitForElement("CreatePageDialog", this.getTimeout());
		assertTrue(session().isElementPresent("CreatePageDialog"));
	}

	private void closeDialog() throws Exception {
		if (isOasis()) {
			session().click("//section[@id='CreatePageDialog']//button");
		}
		else {
			session().click("//div[@id='CreatePageDialog']//img[@class='sprite close']");
		}
	}

	private void checkEditPage(String title) throws Exception {
		session().waitForPageToLoad(this.getTimeout());

		if (isOasis()) {
			assertTrue(session().isElementPresent("//header[@id='EditPageHeader']/h1"));
		}
		else {
			assertTrue(session().isElementPresent("//div[@id='article']//h1"));
		}

		assertTrue(session().isTextPresent(title));
	}

	@Test(groups={"CI", "reskin"})
	public void testTitleErrorChecking() throws Exception {
		openDialogOnRandomPage();

		String pageTitle = session().getEval("window.wgTitle");

		// existing title error checking
		session().type("wpCreatePageDialogTitle", pageTitle);
		session().click("//*[@id='CreatePageDialogButton']/a");
		waitForElement("createPageErrorMsg", this.getTimeout());
		assertTrue(session().isElementPresent("createPageErrorMsg"));

		// invalid title error checking
		session().type("wpCreatePageDialogTitle", "inval|dt|tle");
		session().click("CreatePageDialogButton");
		waitForElement("createPageErrorMsg", this.getTimeout());
		assertTrue(session().isElementPresent("createPageErrorMsg"));

		// empty title error checking
		session().type("wpCreatePageDialogTitle", "");
		session().click("CreatePageDialogButton");
		waitForElement("createPageErrorMsg", this.getTimeout());
		assertTrue(session().isElementPresent("createPageErrorMsg"));

		// spam title error checking
		session().type("wpCreatePageDialogTitle", "WikiaTestBadWordDontRemoveMe");
		session().click("CreatePageDialogButton");
		waitForElement("createPageErrorMsg", this.getTimeout());
		assertTrue(session().isElementPresent("createPageErrorMsg"));
	}

	@Test(groups={"CI", "reskin"})
	public void testCreateStandardLayoutArticle() throws Exception {
		login();
		openDialogOnRandomPage();

		// creating new page with standard layout
		String nonExistentTitle = "N0n 3xist3nt p4ge t1tl3";
		session().type("wpCreatePageDialogTitle", nonExistentTitle);
		session().click("//input[@id='CreatePageDialogFormat']");
		session().click("//*[@id='CreatePageDialogButton']/a");

		// checking edit page
		checkEditPage(nonExistentTitle);
	}

	@Test(groups={"CI", "reskin"})
	public void testCreateBlankArticle() throws Exception {
		login();
		openDialogOnRandomPage();

		// creating new page with standard layout
		String nonExistentTitle = "N0n 3xist3nt p4ge t1tl3";
		session().type("wpCreatePageDialogTitle", nonExistentTitle);
		session().click("//input[@id='CreatePageDialogBlank']");
		session().click("//*[@id='CreatePageDialogButton']/a");

		// checking edit page
		checkEditPage(nonExistentTitle);
	}

	@Test(groups={"CI", "reskin"})
	public void testRedlinksAndCreateboxSupport() throws Exception {
		loginAsStaff();

		String testTitle = "Test Title 1";
		String content = "[[" + testTitle + "]] --~~~~\n\n<createbox>\nwidth=24\nbreak=no\nbuttonlabel=Create\n</createbox>\n\n<createbox>\npreload=Template:CreatePageTest/{{PAGENAME}}\nbuttonlabel=Create\n</createbox>";
		editArticle("Project:CreatePageTestArticle", content);
		assertTrue(session().isTextPresent(testTitle));

		// clicking redlink
		session().click("//a[@title='" + testTitle + " (page does not exist)']");
		waitForElement("CreatePageDialog", this.getTimeout());
		assertTrue(session().isElementPresent("CreatePageDialog"));
		assertEquals(testTitle, session().getValue("//input[@id='wpCreatePageDialogTitle']"));

		closeDialog();

		// checking createbox (standard mode)
		testTitle = "Test Title 2";
		session().type("//div[@class='createbox'][1]/form/input[@class='createboxInput']", testTitle);
		session().click("//div[@class='createbox'][1]/form/input[@type='submit']");
		waitForElement("CreatePageDialog", this.getTimeout());
		assertTrue(session().isElementPresent("CreatePageDialog"));
		assertEquals(testTitle, session().getValue("//input[@id='wpCreatePageDialogTitle']"));

		closeDialog();

		// checking createbox (with preload)
		testTitle = "Test Title 3";
		session().type("//div[@class='createbox'][2]/form/input[@class='createboxInput']", testTitle);
		session().click("//div[@class='createbox'][2]/form/input[@type='submit']");
		checkEditPage(testTitle);

		// delete temporary created article
		deleteArticle("Project:CreatePageTestArticle", "label=regexp:^.*Author request", "WikiaBot CreatePage test");
	}

	@Test(groups={"CI", "reskin"})
	public void testUserSetting() throws Exception {
		login();
		session().open("index.php?title=Special:Preferences");
		waitForElement("preftoc", this.getTimeout());

		session().click("//li/a[@href='#prefsection-4']");

		if(session().isElementPresent("//input[@id='mw-input-createpagedefaultblank' and contains(@checked, 'checked')]") == false) {
			session().click("//input[@id='mw-input-createpagedefaultblank']");
			session().click("//input[@id='prefcontrol']");
			session().waitForPageToLoad(this.getTimeout());
		}
		else {
			//System.out.println("createpagedefaultblank is already set");
		}

		openDialogOnRandomPage();

		assertTrue(session().isElementPresent("CreatePageDialog"));
		assertTrue(session().isElementPresent("//li[@id='CreatePageDialogBlankContainer' and contains(@class, 'chooser accent')]"));
	}

	@Test(groups={"CI", "reskin"})
	public void testSpecialCreatePage() throws Exception {
		String pageTitle = "CreatePageTest" + Integer.toString(new Random().nextInt(9999));
		String content = "CreatePage test --~~~~";
		loginAsStaff();

		// create an article
		editArticle(pageTitle, "test --~~~~");

		// now try to create new page using title of the existing one
		session().open("index.php?title=Special:CreatePage");
		session().waitForPageToLoad(this.getTimeout());

		// test modal with required fields
		assertTrue(session().isVisible("//section[@id='HiddenFieldsDialog']//input[@name='wpTitle']"));

		// click "Ok" without providing any data - modal should not be hidden
		session().click("//section[@id='HiddenFieldsDialog']//*[@id='ok']");
		assertTrue(session().isVisible("//section[@id='HiddenFieldsDialog']"));

		// provide title
		session().type("wpTitle", pageTitle + "foo");
		session().click("//section[@id='HiddenFieldsDialog']//*[@id='ok']");
		assertFalse(session().isElementPresent("//section[@id='HiddenFieldsDialog']"));

		// header should be updated with new title
		assertTrue(session().isElementPresent("//header[@id='EditPageHeader']//h1/a[contains(text(), '" + pageTitle + "foo')]"));

		// edit title
		session().click("//a[@id='EditPageTitle']");
		assertTrue(session().isVisible("//section[@id='HiddenFieldsDialog']"));
		session().type("wpTitle", pageTitle);
		session().click("//section[@id='HiddenFieldsDialog']//*[@id='ok']");

		// header should be updated with new title
		assertTrue(session().isElementPresent("//header[@id='EditPageHeader']//h1/a[contains(text(), '" + pageTitle + "')]"));

		// provide content
		doEdit(content);

		// test preview and diff (with the existing page)
		this.checkPreviewModal(pageTitle, content);
		this.checkDiffModal(pageTitle, "test --~~~~");

		// save it
		doEdit(content);
		clickAndWait("wpSave");

		// notice bar (page already exists)
		assertTrue(session().isElementPresent("//section[@id='EditPage']//div[@class='editpage-notices']/ul/li"));
		assertTrue(session().isTextPresent("A page with that name already exists"));

		// change the title and save it
		session().click("//a[@id='EditPageTitle']");
		assertTrue(session().isVisible("//section[@id='HiddenFieldsDialog']"));
		session().type("wpTitle", pageTitle + "Foo");
		session().click("//section[@id='HiddenFieldsDialog']//*[@id='ok']");

		// save it
		clickAndWait("wpSave");

		// verify an edit
		assertTrue(session().getEval("window.wgTitle").equals(pageTitle + "Foo"));
		assertTrue(session().isTextPresent("CreatePage test --"));
	}

	@Test(groups={"CI", "reskin"})
	public void testSpecialCreatePageAnonWithCaptcha() throws Exception {
		String pageTitle = "CreatePageTest" + Integer.toString(new Random().nextInt(9999));

		// now try to create new page using title of the existing one
		session().open("index.php?title=Special:CreatePage");
		session().waitForPageToLoad(this.getTimeout());

		// provide a title
		session().type("wpTitle", pageTitle);
		session().click("//section[@id='HiddenFieldsDialog']//*[@id='ok']");

		checkCaptcha();
	}
}
