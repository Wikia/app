package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;

import org.testng.annotations.Test;

public class CreatePageTest extends BaseTest {

	private void openDialogOnRandomPage() throws Exception {
		session().open("index.php?title=Special:Random");
		session().waitForPageToLoad(TIMEOUT);

		if (isOasis()) {
			session().click("//div[@id='WikiaRail']//a[@class='wikia-button createpage']");
		}
		else {
			session().click("//a[@id='dynamic-links-write-article-link']");
		}

		waitForElement("CreatePageDialog", TIMEOUT);
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
		session().waitForPageToLoad(TIMEOUT);

		if (isOasis()) {
			assertTrue(session().isElementPresent("//div[@id='WikiaPageHeader']//h1"));
		}
		else {
			assertTrue(session().isElementPresent("//div[@id='article']//h1"));
		}

		assertTrue(session().isTextPresent(title));
	}

	@Test(groups="CI")
	public void testTitleErrorChecking() throws Exception {
		openDialogOnRandomPage();

		String pageTitle = session().getEval("window.wgTitle");

		// existing title error checking
		session().type("wpCreatePageDialogTitle", pageTitle);
		session().click("wpCreatePageDialogButton");
		waitForElement("createPageErrorMsg", TIMEOUT);
		assertTrue(session().isElementPresent("createPageErrorMsg"));

		// invalid title error checking
		session().type("wpCreatePageDialogTitle", "inval|dt|tle");
		session().click("wpCreatePageDialogButton");
		waitForElement("createPageErrorMsg", TIMEOUT);
		assertTrue(session().isElementPresent("createPageErrorMsg"));

		// empty title error checking
		session().type("wpCreatePageDialogTitle", "");
		session().click("wpCreatePageDialogButton");
		waitForElement("createPageErrorMsg", TIMEOUT);
		assertTrue(session().isElementPresent("createPageErrorMsg"));

		// spam title error checking
		session().type("wpCreatePageDialogTitle", "WikiaTestBadWordDontRemoveMe");
		session().click("wpCreatePageDialogButton");
		waitForElement("createPageErrorMsg", TIMEOUT);
		assertTrue(session().isElementPresent("createPageErrorMsg"));
	}

	@Test(groups="CI")
	public void testCreateStandardLayoutArticle() throws Exception {
		login();
		openDialogOnRandomPage();

		// creating new page with standard layout
		String nonExistentTitle = "N0n 3xist3nt p4ge t1tl3";
		session().type("wpCreatePageDialogTitle", nonExistentTitle);
		session().click("//input[@id='CreatePageDialogFormat']");
		session().click("wpCreatePageDialogButton");

		// checking edit page
		checkEditPage(nonExistentTitle);
	}

	@Test(groups="CI")
	public void testCreateBlankArticle() throws Exception {
		login();
		openDialogOnRandomPage();

		// creating new page with standard layout
		String nonExistentTitle = "N0n 3xist3nt p4ge t1tl3";
		session().type("wpCreatePageDialogTitle", nonExistentTitle);
		session().click("//input[@id='CreatePageDialogBlank']");
		session().click("wpCreatePageDialogButton");

		// checking edit page
		checkEditPage(nonExistentTitle);
	}

	@Test(groups={"CI"})
	public void testRedlinksAndCreateboxSupport() throws Exception {
		login();

		String testTitle = "Test Title 1";
		String content = "[[" + testTitle + "]]\n\n<createbox>\nwidth=24\nbreak=no\nbuttonlabel=Create\n</createbox>\n\n<createbox>\npreload=Template:CreatePageTest/{{PAGENAME}}\nbuttonlabel=Create\n</createbox>";
		editArticle("Project:CreatePageTestArticle", content);
		assertTrue(session().isTextPresent(testTitle));

		// clicking redlink
		session().click("//a[@title='" + testTitle + " (page does not exist)']");
		waitForElement("CreatePageDialog", TIMEOUT);
		assertTrue(session().isElementPresent("CreatePageDialog"));
		assertEquals(testTitle, session().getValue("//input[@id='wpCreatePageDialogTitle']"));

		closeDialog();

		// checking createbox (standard mode)
		testTitle = "Test Title 2";
		session().type("//div[@class='createbox'][1]/form/input[@class='createboxInput']", testTitle);
		session().click("//div[@class='createbox'][1]/form/input[@type='submit']");
		waitForElement("CreatePageDialog", TIMEOUT);
		assertTrue(session().isElementPresent("CreatePageDialog"));
		assertEquals(testTitle, session().getValue("//input[@id='wpCreatePageDialogTitle']"));

		closeDialog();

		// checking createbox (with preload)
		testTitle = "Test Title 3";
		session().type("//div[@class='createbox'][2]/form/input[@class='createboxInput']", testTitle);
		session().click("//div[@class='createbox'][2]/form/input[@type='submit']");
		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().isElementPresent(isOasis() ? "WikiaArticle" : "article"));

		// delete temporary created article
		logout();
		loginAsStaff();
		deleteArticle("Project:CreatePageTestArticle", "label=regexp:^.*Author request", "WikiaBot CreatePage test");
	}

	@Test(groups="CI")
	public void testUserSetting() throws Exception {
		login();
		session().open("index.php?title=Special:Preferences");
		waitForElement("preftoc", TIMEOUT);

		session().click("//li/a[@href='#prefsection-4']");

		if(session().isElementPresent("//div[@class='toggle']/input[@id='createpagedefaultblank' and contains(@checked, 'checked')]") == false) {
			session().click("//div[@class='toggle']/input[@id='createpagedefaultblank']");
			session().click("//td/input[@id='wpSaveprefs']");
			session().waitForPageToLoad(TIMEOUT);
		}
		else {
			System.out.println("createpagedefaultblank is already set");
		}

		openDialogOnRandomPage();

		assertTrue(session().isElementPresent("CreatePageDialog"));
		assertTrue(session().isElementPresent("//li[@id='CreatePageDialogBlankContainer' and contains(@class, 'chooser accent')]"));
	}
}
