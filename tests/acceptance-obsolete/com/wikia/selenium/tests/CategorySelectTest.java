package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import java.awt.event.KeyEvent;

import org.testng.annotations.Test;
import java.util.Date;

public class CategorySelectTest extends BaseTest {

	@Test(groups={"CI", "legacy"})
	public void testAddCategory() throws Exception {
		loginAsStaff();
		String title = "WikiaAutomatedTest" + ((new Date()).toString());
		editArticle(title, "Wikia automated test for CategorySelect\n[[Category:Wikia tests]]");

		// Add new category on view page
		waitForElement("link=Add category");
		session().click("link=Add category");
		waitForElement("csCategoryInput");

		session().type("csCategoryInput", "other category");
		session().getEval("var e = window.jQuery.Event('keypress'); e.keyCode = 13; window.$('#csCategoryInput').trigger(e)");
		// proper but not working in chrome way of doing the above
		//session().focus("csCategoryInput");
		//session().keyPress("csCategoryInput", Integer.toString(KeyEvent.VK_ENTER));
		session().keyPressNative(Integer.toString(KeyEvent.VK_ENTER));
		waitForElement("//div[@id='csItemsContainer']/a[1]/img");
		session().click("//div[@id='csItemsContainer']/a[1]/img");
		waitForElement("csInfoboxCategory");

		session().type("csInfoboxCategory", "Other Category");
		session().type("csInfoboxSortKey", "Other Category sortkey");
		session().click("//a[@id='sortDialogSave']");
		session().click("csSave");
		// Check present of category added via AJAX
		waitForElement("link=Other Category");

		clickAndWait(isOasis() ? "//a[@data-id='edit']" : "ca-edit");
		waitForElement("wpTextbox1");
		waitForElementNotVisible("//div[@class='editpage-loading-indicator']");
		waitForElement("//a[contains(@class, 'cke_button_ModeSource')]");
		session().click("//a[contains(@class, 'cke_button_ModeSource')]");
		waitForElement("//textarea[@id='csWikitext']");
		if (!session().isVisible("//textarea[@id='csWikitext']")) {
			session().click("//div[contains(@class, 'module_categories')]/h3");
			waitForElementVisible("//textarea[@id='csWikitext']");
		}

		session().type("csWikitext", "[[Category:Other Category|Other Category sortkey]]\n[[Category:Wikia tests]]");
		session().click("//a[contains(@class, 'cke_button_ModeWysiwyg')]");
		waitForElementNotVisible("csWikitext");
		waitForElement("csItemsContainerDiv");
		waitForElementVisible("csItemsContainerDiv");

		assertEquals("Other Category", session().getText("//div[@id='csItemsContainerDiv']//li[1]/span"));
		assertEquals("Wikia tests", session().getText("//div[@id='csItemsContainerDiv']//li[2]/span"));
		session().click("//div[@id='csItemsContainerDiv']//li[2]/img[contains(@class, 'delete')]");

		doEdit("Wikia automated test for CategorySelect\n[[Category:Other category]] added via textbox");
		clickAndWait("wpSave");
		waitForElement("link=Other Category");
		assertEquals("Other Category", session().getText("link=Other Category"));

		// TODO: Test to make sure that deleting one tag by clicking an X deletes exactly that one tag (and not more, if there are more). See rt#45033
		doDelete("label=regexp:.*Author request", "Clean up after test");
	}
}
