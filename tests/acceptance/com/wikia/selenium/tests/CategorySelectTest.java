package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;

import org.testng.annotations.Test;
import java.util.Random;

public class CategorySelectTest extends BaseTest {

	@Test(groups={"CI"})
	public void testAddCategory() throws Exception {
		loginAsStaff();
		Random randomGenerator = new Random();
		int randomInt = randomGenerator.nextInt(666);
		// System.out.println("Starting test...");
		editArticle("WikiaAutomatedTest" + randomInt,
				"Wikia automated test for CategorySelect\n[[Category:Wikia tests]]");

		// Add new category on view page
		// System.out.println("Clicking on add-category...");
		waitForElement("link=Add category");
		session().click("link=Add category");
		waitForElement("//*[@id=\"csCategoryInput\"]");

		// System.out.println("Typing a category in...");
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

		// System.out.println("Switching to wikitext version...");
		session().click(isOasis() ? "//a[@data-id='edit']" : "ca-edit");
		session().waitForPageToLoad(TIMEOUT);
		session().click("csSwitchView");
		waitForElementVisible("csWikitext");

		// System.out.println("Typing in wikitext version...");
		session()
				.type("csWikitext",
						"[[Category:Other Category|Other Category sortkey]]\n[[Category:Wikia tests]]");
		// System.out.println("Clicking to switch view...");
		session().click("csSwitchView");
		// System.out.println("Checking to make sure the text field is gone...");
		waitForElementNotVisible("csWikitext", 15);

		// System.out.println("Making sure categorizations are present...");
		// System.out.println("Making sure the gui-view categorization held...");
		assertEquals("Other Category", session().getText("//div[@id='csItemsContainer']/a[1]"));
		// System.out.println("Making sure categorization from wiki-text view is present...");
		assertEquals("Wikia tests", session().getText("//div[@id='csItemsContainer']/a[2]"));
		session().click("//div[@id='csItemsContainer']/a[2]/img/");

		// System.out.println("Testing that users can still add categories right in the wikitext of the article...");
		doEdit("Wikia automated test for CategorySelect\n[[Category:Other category]] added via textbox");
		session().click("wpPreview");
		session().waitForPageToLoad(TIMEOUT);
		session().click("//div[@id='csItemsContainer']/a[1]/img/");
		session().click("wpSave");
		session().waitForPageToLoad(TIMEOUT);
		assertEquals("Other Category", session().getText("link=Other Category"));

		// TODO: Test to make sure that deleting one tag by clicking an X deletes exactly that one tag (and not more, if there are more). See rt#45033

		doDelete("label=Author request", "Clean up after test");
	}
}
