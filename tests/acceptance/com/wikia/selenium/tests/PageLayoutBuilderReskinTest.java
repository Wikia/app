package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertNotNull;

import java.util.Random;

import org.testng.annotations.Test;

public class PageLayoutBuilderReskinTest extends EditPageBaseTest {

	@Test(groups={"CI", "reskin"})
	public void testPageLayoutBuilderSpecialPageLayout() throws Exception {
		String layoutTitle = "FooBarFooBarLayoutLongTest" + Integer.toString(new Random().nextInt(9999));

		loginAsStaff();
		session().open("index.php?title=Special:LayoutBuilder");
		session().waitForPageToLoad(this.getTimeout());

		waitForElement("HiddenFieldsDialog");

		// test modal with required fields
		assertTrue(session().isVisible("//section[@id='HiddenFieldsDialog']//input[@name='wpTitle']"));

		// click "Ok" without providing any data - modal should not be hidden
		session().click("//section[@id='HiddenFieldsDialog']//*[@id='ok']");
		assertTrue(session().isVisible("//section[@id='HiddenFieldsDialog']"));

		// provide title and description
		session().type("wpTitle", layoutTitle + "foo");
		session().type("wpDescription", "foo bar");

		session().click("//section[@id='HiddenFieldsDialog']//*[@id='ok']");
		assertFalse(session().isElementPresent("//section[@id='HiddenFieldsDialog']"));

		// header should be updated with new title
		assertTrue(session().isElementPresent("//header[@id='EditPageHeader']//h1/a[contains(@title, '" + layoutTitle + "foo')]"));

		// edit title
		session().click("//a[@id='EditPageTitle']");
		assertTrue(session().isVisible("//section[@id='HiddenFieldsDialog']"));
		session().type("wpTitle", layoutTitle);
		session().click("//section[@id='HiddenFieldsDialog']//*[@id='ok']");

		// header should be updated with new title
		assertTrue(session().isElementPresent("//header[@id='EditPageHeader']//h1/a[contains(@title, '" + layoutTitle + "')]"));

		assertTrue(session().isElementPresent("//form[@id='editform']"));
		assertTrue(session().isElementPresent("//*[@id='cke_wpTextbox1']"));

		assertTrue(session().isElementPresent("//span[contains(@class,'wordmark')]"));

		/**
		 * Test new edit page layout
		 */

		// JS code
		assertEquals(session().getEval("window.wgIsEditPage"), "true");
		assertEquals(session().getEval("window.$.msg('editpagelayout-less')"), "less");

		// some elements should not be visible on edit page
		assertFalse(session().isElementPresent("//header[@id='WikiHeader']/nav"));
		assertFalse(session().isElementPresent("//header[@id='WikiHeader']/div[@class='buttons']"));
		assertFalse(session().isElementPresent("//div[@id='WikiaRail']"));
		assertFalse(session().isElementPresent("//footer[@id='WikiaFooter']"));

		// spaces
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']"));
		assertTrue(session().isElementPresent("//div[@id='EditPageEditorWrapper']"));
		assertTrue(session().isElementPresent("//nav[@id='EditPageTabs']"));

		// tabs
		assertTrue(session().isElementPresent("//nav[@id='EditPageTabs']//span[contains(@class, 'cke_button_ModeSource')]"));
		assertTrue(session().isElementPresent("//nav[@id='EditPageTabs']//span[contains(@class, 'cke_button_ModeWysiwyg')]"));

		// help link
		assertTrue(session().isElementPresent("//aside[@id='HelpLink']/a"));

		// toolbars
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']/*[contains(@class, 'cke_toolbar_source')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']/*[contains(@class, 'cke_toolbar_format')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']/*[contains(@class, 'cke_toolbar_format_expanded')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']/*[contains(@class, 'cke_toolbar_expand')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']/*[contains(@class, 'cke_toolbar_widescreen')]"));

		// toolbar buttons
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']/*[contains(@class, 'cke_buttons')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']//*[contains(@class, 'cke_button_bold')]"));

		// right rail modules
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']//div[contains(@class, 'module_page_controls')]"));

		// PLB specific modules
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']//div[contains(@class, 'module_plb_insert')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']//div[contains(@class, 'module_plb_insert')]//span[contains(@class, 'PLBAddElement')]"));

		assertTrue(session().isElementPresent("//div[@id='EditPageRail']//div[contains(@class, 'module_plb_list')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']//div[contains(@class, 'module_plb_list')]//div[@class='plb-widgets-tutorial']"));

		// page controls
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']//div[contains(@class, 'module_page_controls')]//textarea[@id='wpSummary']"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']//div[contains(@class, 'module_page_controls')]//input[@name='wpMinoredit']"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']//div[contains(@class, 'module_page_controls')]//input[@id='wpSave']"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']//div[contains(@class, 'module_page_controls')]//ul//a[@id='wpPreview']"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']//div[contains(@class, 'module_page_controls')]//ul//a[@id='wpDiff']"));

		// PLB specific page controls
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']//div[contains(@class, 'module_page_controls')]//input[@id='wpSaveDraft']"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']//div[contains(@class, 'module_page_controls')]//input[@id='wpPreviewForm']"));

		// edit article content (don't save yet)
		String content = "PLB test --~~~~";
		doEdit(content);

		// switch back to wysiwyg mode
		this.toggleMode();

		// test preview
		this.checkPreviewModal(layoutTitle, content);
	}

	@Test(groups={"CI", "reskin"})
	public void testEnsurePLBIsNotAvailableForAnons() throws Exception {
		session().open("index.php?action=edit&useeditor=wysiwyg&title=Special:LayoutBuilder");
		session().waitForPageToLoad(this.getTimeout());

		assertTrue(session().isTextPresent("Please log in to use the layout builder"));
	}
}