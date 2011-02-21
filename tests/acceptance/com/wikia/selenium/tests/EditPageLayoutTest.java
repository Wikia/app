package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;

public class EditPageLayoutTest extends BaseTest {

	@Test(groups={"oasis", "CI"})
	public void testEditPageLayout() throws Exception {
		// go to random article
		session().open("index.php?title=Special:Random");
		session().waitForPageToLoad(this.getTimeout());

		// click "edit" link
		clickAndWait("//a[@data-id='edit']");

		// get title of edit page
		String title = session().getEval("window.wgPageName");

		assertTrue(session().isElementPresent("//form[@id='editform']"));
		assertTrue(session().isElementPresent("//*[@id='cke_wpTextbox1']"));

		assertTrue(session().isElementPresent("//header[@id='EditPageHeader']//h1[contains(text(), 'Editing')]"));
		//assertTrue(session().isElementPresent("//header[@id='EditPageHeader']//h1[contains(text(), '" + title + "')]"));

		assertTrue(session().isElementPresent("//td[@id='cke_top_wpTextbox1']"));
		assertTrue(session().isElementPresent("//td[@id='cke_rail_wpTextbox1']"));
		assertTrue(session().isElementPresent("//td[@id='cke_contents_wpTextbox1']"));
	}
}
