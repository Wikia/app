package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertEquals;

import org.testng.annotations.Test;

public class EditPageLayoutTest extends BaseTest {

	@Test(groups={"CI", "reskin"})
	public void testEditPageLayout() throws Exception {
		// go to random article
		session().open("index.php?title=Special:Random");
		session().waitForPageToLoad(this.getTimeout());

		// click "edit" link
		clickAndWait("//a[@data-id='edit']");

		// get title of edit page
		String title = session().getEval("window.wgPageName");

		assertEquals("true", session().getEval("window.wgIsEditPage"));

		assertTrue(session().isElementPresent("//form[@id='editform']"));
		assertTrue(session().isElementPresent("//*[@id='cke_wpTextbox1']"));

		assertTrue(session().isElementPresent("//span[contains(@class,'wordmark')]"));
		assertTrue(session().isElementPresent("//header[@id='EditPageHeader']//h2[contains(text(), 'Editing')]"));
		//assertTrue(session().isElementPresent("//header[@id='EditPageHeader']//h1[contains(text(), '" + title + "')]"));

		// spaces
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']"));
		assertTrue(session().isElementPresent("//div[@id='EditPageEditorWrapper']"));
		assertTrue(session().isElementPresent("//nav[@id='EditPageTabs']"));

		// toolbars
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']/*[contains(@class, 'cke_toolbar_source')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']/*[contains(@class, 'cke_toolbar_format')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']/*[contains(@class, 'cke_toolbar_format_expanded')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']/*[contains(@class, 'cke_toolbar_expand')]"));

		// buttons
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']/*[contains(@class, 'cke_buttons')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']//span[contains(@class, 'cke_button_bold')]"));

		// right rail modules
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']//div[contains(@class, 'module_page_controls')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']//div[contains(@class, 'module_insert')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']//div[contains(@class, 'module_categories')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']//div[contains(@class, 'module_templates')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']//div[contains(@class, 'module_license')]"));

		// page controls
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']/div[contains(@class, 'module_page_controls')]//textarea[@id='wpSummary']"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']/div[contains(@class, 'module_page_controls')]//input[@id='wpSave']"));
	}
}
