package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;

public class DialogBoxesTest extends BaseTest {

	private void randomPage() throws Exception {
		session().open("index.php?title=Special:Random");
		session().waitForPageToLoad(TIMEOUT);
	}

	private void waitForDialogBox() throws Exception {
		waitForElement("//section[@class='modalWrapper']");
	}

	private void closeDialogBox() throws Exception {
		session().click("//section[@class='modalWrapper']//button[contains(@class, 'close')]");
		assertFalse(session().isElementPresent("//section[@class='modalWrapper']"));
	}

	@Test(groups={"oasis", "CI"})
	public void testShareFeatureDialog() throws Exception {
		randomPage();

		// click "Share" link
		session().click("//footer[@id='WikiaFooter']//a[@id='control_share_feature']");
		waitForDialogBox();

		// check dialog content
		assertTrue(session().isElementPresent("shareFeatureInside"));
		closeDialogBox();
	}

	@Test(groups={"oasis", "CI"})
	public void testCreatePageDialog() throws Exception {
		randomPage();

		// click "Create a page" button in PagesOnWiki module
		session().click("//section[contains(@class, 'WikiaPagesOnWikiModule')]//a[contains(@class, 'createpage')]");
		waitForDialogBox();

		// check dialog content
		assertTrue(session().isElementPresent("CreatePageDialog"));
		closeDialogBox();
	}
}
