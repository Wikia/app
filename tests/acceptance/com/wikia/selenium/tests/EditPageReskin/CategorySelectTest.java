package com.wikia.selenium.tests.EditPageReskin;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertEquals;

import org.testng.annotations.Test;
import java.util.Random;

public class CategorySelectTest extends BaseTest {

	@Test(groups={"CI"})
	public void testAddCategory() throws Exception {
		loginAsStaff();

		Random randomGenerator = new Random();
		int randomInt = randomGenerator.nextInt(666);

		editArticle("WikiaAutomatedTest" + randomInt, "Wikia automated test for CategorySelect\n[[Category:Wikia tests]]");

		// Add new category on view page
		waitForElement("link=Add category");
		session().click("link=Add category");
		waitForElement("//*[@id=\"csCategoryInput\"]");

		// add categories
		session().type("csCategoryInput", "other category");
		session().keyPress("csCategoryInput", "\\13");
		session().click("//div[@id='csItemsContainer']/a[1]/img");
		waitForElement("csInfoboxCategory");

		// System.out.println("Typing in the sorting dialog...");
		session().type("csInfoboxCategory", "Other Category");
		session().type("csInfoboxSortKey", "Other Category sortkey");
		// System.out.println("Saving...");
		session().click("//a[@id='sortDialogSave']");
		session().click("csSave");
		// Check present of category added via AJAX
		waitForElement("link=Other Category");

		// go to edit page
		session().click("//a[@data-id='edit']");
		session().waitForPageToLoad(this.getTimeout());

		// "Categories" right rail module
		assertTrue(session().isElementPresent("//div[contains(@class,'module_categories')]"));
		assertTrue(session().isElementPresent("//input[@id='csCategoryInput']"));

		assertTrue(session().isElementPresent("//div[contains(@class,'module_categories')]//li[@class='CSitem']/span[text()='Wikia tests']"));
		assertTrue(session().isElementPresent("//div[contains(@class,'module_categories')]//li[@class='CSitem']/span[text()='Other Category']"));

		// add category in edit mode
		String categoryName = "TestCategory" + randomGenerator.nextInt(999);

		/**
		var ev = new jQuery.Event("keypress");
		ev.keyCode = 13;

		$('#csCategoryInput').val('category name').trigger(ev);
		**/

		session().runScript("window.ev = new window.jQuery.Event('keypress');" +
			"window.ev.keyCode = 13;" +
			"window.jQuery('#csCategoryInput').val('" + categoryName + "').trigger(window.ev);");

		assertTrue(session().isElementPresent("//div[contains(@class,'module_categories')]//li[@class='CSitem']/span[text()='" + categoryName + "']"));

		// save the page
		session().click("wpSave");
		session().waitForPageToLoad(this.getTimeout());
		assertEquals("Other Category", session().getText("link=Other Category"));

		// check for added category
		assertTrue(session().isElementPresent("//nav[@id='WikiaArticleCategories']//a[text()='" + categoryName + "']"));

		// TODO: Test to make sure that deleting one tag by clicking an X deletes exactly that one tag (and not more, if there are more). See rt#45033
		doDelete("label=regexp:.*Author request", "Clean up after test");
	}
}
