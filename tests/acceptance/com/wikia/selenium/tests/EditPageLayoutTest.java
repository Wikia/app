package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertEquals;

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

		assertEquals(session().getEval("window.wgIsEditPage"), "true");

		assertTrue(session().isElementPresent("//form[@id='editform']"));
		assertTrue(session().isElementPresent("//*[@id='cke_wpTextbox1']"));

		assertTrue(session().isElementPresent("//span[contains(@class,'wordmark')]"));
		assertTrue(session().isElementPresent("//header[@id='EditPageHeader']//h1[contains(text(), 'Editing')]"));
		//assertTrue(session().isElementPresent("//header[@id='EditPageHeader']//h1[contains(text(), '" + title + "')]"));

		assertTrue(session().isElementPresent("//td[@id='cke_toolbar_wpTextbox1']"));
		assertTrue(session().isElementPresent("//td[@id='cke_rail_wpTextbox1']"));
		assertTrue(session().isElementPresent("//td[@id='cke_space_wpTextbox1']"));
		assertTrue(session().isElementPresent("//td[@id='cke_contents_wpTextbox1']"));

		// toolbars
		assertTrue(session().isElementPresent("//td[@id='cke_toolbar_wpTextbox1']/div[contains(@class, 'cke_toolbar_format')]"));
		assertTrue(session().isElementPresent("//td[@id='cke_toolbar_wpTextbox1']/div[contains(@class, 'cke_toolbar_templates')]"));
		assertTrue(session().isElementPresent("//td[@id='cke_toolbar_wpTextbox1']/div[contains(@class, 'cke_toolbar_insert')]"));

		assertTrue(session().isElementPresent("//td[@id='cke_toolbar_wpTextbox1']/div[contains(@class, 'cke_buttons')]"));
		assertTrue(session().isElementPresent("//td[@id='cke_toolbar_wpTextbox1']//span[contains(@class, 'cke_button_bold')]"));
		assertTrue(session().isElementPresent("//td[@id='cke_toolbar_wpTextbox1']/div[contains(@class, 'cke_toolbar_insert')]/span[contains(@class,'cke_button_big')]"));

		// right rail modules
		assertTrue(session().isElementPresent("//td[@id='cke_rail_wpTextbox1']/div[contains(@class, 'cke_module_page_controls')]"));
		assertTrue(session().isElementPresent("//td[@id='cke_rail_wpTextbox1']/div[contains(@class, 'cke_module_rail_insert')]"));
		assertTrue(session().isElementPresent("//td[@id='cke_rail_wpTextbox1']/div[contains(@class, 'cke_module_rail_templates')]"));
		assertTrue(session().isElementPresent("//td[@id='cke_rail_wpTextbox1']/div[contains(@class, 'cke_module_license')]"));

		assertTrue(session().isElementPresent("//td[@id='cke_rail_wpTextbox1']/div[contains(@class, 'cke_module_page_controls')]//textarea[@id='wpSummary']"));
		assertTrue(session().isElementPresent("//td[@id='cke_rail_wpTextbox1']/div[contains(@class, 'cke_module_page_controls')]//input[@id='wpSave']"));
	}
}
