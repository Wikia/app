/*Bugs
 * first bug - can not move items manually to change their positions
 * second bug - top list with blocked data is created
 * third bug - top list is sometimes created without "vote buttons" 
 * fourth bug - can not upload the same file with same name previously deleted
 * fifth bug - can not upload the same file with changed name
 */
package com.wikia.selenium.tests;

import java.util.Date;

import org.testng.annotations.Test;
import org.testng.annotations.BeforeMethod;

import com.thoughtworks.selenium.SeleniumException;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertEquals;


public class Top10Test extends BaseTest {
	public static final String TOP10_ARTICLE_1 = "Top 10 test article 1";
	public static final String TOP10_ARTICLE_2 = "Top 10 test article 2";
	public static final String TOP10_ARTICLE_3 = "Top 10 test article 3";
	public static final String TOP10_ARTICLE_4 = "Top 10 test article 4";
	public static final String TOP10_ARTICLE_5 = "Item with slash /";
	public static final String TOP10_ARTICLE_6 = "Item with slash / 2";
	
	public static final String TOP10_LIST_NAME = "Test top 10 list ";

	private static final String BLOCKED_TITLE = "WikiaTestBadWordDontRemoveMe";
	
	private boolean isDataPrepared = false;
	
	@BeforeMethod(alwaysRun = true)
	public void prepareTestData() throws Exception {
		loginAsRegular();
		
		if (!isDataPrepared) {
			editArticle(TOP10_ARTICLE_1, "Lorem ipsum " + new Date().toString());
			editArticle(TOP10_ARTICLE_2, "Lorem ipsum " + (new Date()).toString());
			editArticle(TOP10_ARTICLE_3, "Lorem ipsum " + (new Date()).toString());
			editArticle(TOP10_ARTICLE_4, "Lorem ipsum " + (new Date()).toString());
			isDataPrepared = true;
		}
	}
	
	@Test(groups={"envProduction", "CI","legacy"})
	public void testCreateEmptyList() throws Exception {
		session().open("wiki/Special:CreateTopList");
		session().waitForPageToLoad(this.getTimeout());
		waitForElement("//input[@value='Create list']");
		session().click("//input[@value='Create list']");
		session().waitForPageToLoad(this.getTimeout());
		
		assertTrue(session().isTextPresent("The supplied text is not valid."));
		assertTrue(session().getLocation().contains("wiki/Special:CreateTopList"));
		
		session().type("list_name", TOP10_LIST_NAME + (new Date()).toString());
		
		session().click("//input[@value='Create list']");
		session().waitForPageToLoad(this.getTimeout());
		assertTrue(session().getLocation().contains("wiki/Top_10_list"));
	}
	
	//Broken
	//Test to verify because of phalanx problems, ask TOR	
	//@Test(groups={"envProduction", "CI"}) 
	public void testCreateListWithInvalidData() throws Exception {
		openAndWait("wiki/Special:CreateTopList");

		waitForElement("list_name");
		session().type("list_name", BLOCKED_TITLE + " " + (new Date()).toString());
		session().click("//input[@value='Create list']");
		session().waitForPageToLoad(this.getTimeout());
		
		assertTrue("The page you wanted to save was blocked by the spam filter", session().getLocation().contains("wiki/Special:CreateTopList"));
		
		//It is possible to add in the related page field BLOCKED_TITLE
		
		session().type("list_name", TOP10_LIST_NAME + (new Date()).toString());
		session().type("related_article_name", BLOCKED_TITLE + " " + (new Date()).toString());
		session().click("//input[@value='Create list']");
		session().waitForPageToLoad(this.getTimeout());
		
		assertTrue("The page you wanted to save was blocked by the spam filter", session().getLocation().contains("wiki/Special:CreateTopList"));

		//It is possible to add in the item fields BLOCKED_TITLE
		
		session().type("related_article_name", "");
		session().type("//form[@id='toplist-editor']//div[@class='ItemName']/input", BLOCKED_TITLE + " " + (new Date()).toString());
		session().click("//input[@value='Create list']");
		session().waitForPageToLoad(this.getTimeout());
		
		assertTrue("The page you wanted to save was blocked by the spam filter", session().getLocation().contains("wiki/Special:CreateTopList"));
	}
	
	
	@Test(groups={"envProduction", "CI", "legacy"})
	public void testCreateDuplicatedTopList() throws Exception {
		session().open("wiki/Special:CreateTopList");
		session().waitForPageToLoad(this.getTimeout());
		
		String name = TOP10_LIST_NAME + (new Date()).toString();
		waitForElement("list_name");
		session().type("list_name", name);
		session().click("//input[@value='Create list']");
		session().waitForPageToLoad(this.getTimeout());
		
		assertTrue(session().getLocation().contains("wiki/Top_10_list:"));

		session().open("wiki/Special:CreateTopList");
		session().waitForPageToLoad(this.getTimeout());
		
		waitForElement("list_name");
		session().type("list_name", name);
		session().click("//input[@value='Create list']");
		session().waitForPageToLoad(this.getTimeout());
		
		assertTrue(session().getLocation().contains("wiki/Special:CreateTopList"));
		assertTrue(session().isTextPresent("This page already exists."));
	}
	
	@Test(groups={"envProduction", "CI","legacy"}) 
	public void testCreateTopListAndFillIt() throws Exception {
		openAndWait("wiki/Special:CreateTopList");
		String name = TOP10_LIST_NAME + (new Date()).toString();
		waitForElement("list_name");
		session().type("list_name", name);
		session().type("//ul[@class='ItemsList ui-sortable']/li[2]/div[2]/input", TOP10_ARTICLE_1);
		session().type("//ul[@class='ItemsList ui-sortable']/li[3]/div[2]/input", TOP10_ARTICLE_2);
		clickAndWait("//input[@value='Create list']");
		
		waitForElement("//button[@class='VoteButton']");
		Number numberOfOptions = session().getXpathCount("//button[@class='VoteButton']");
		assertEquals(2, numberOfOptions.intValue());
	    
	    clickAndWait("//nav[@class='wikia-menu-button']//img[@class='sprite edit-pencil']");
	    session().type("//ul[@class='ItemsList ui-sortable']/li[4]/div[2]/input", TOP10_ARTICLE_3);
	    clickAndWait("//input[@value='Save list']");

		waitForElement("//button[@class='VoteButton']");
	    Number numberOfOptions2 = session().getXpathCount("//button[@class='VoteButton']");
		assertEquals(3, numberOfOptions2.intValue());

		clickAndWait("//nav[@class='wikia-menu-button']//img[@class='sprite edit-pencil']");
	    session().click("//img[@class='sprite new']");

	    openAndWait("wiki/Top_10_List:" + name.replace(" ", "_"));
	    Number numberOfOptions3 = session().getXpathCount("//button[@class='VoteButton']");
	    assertEquals(3, numberOfOptions3.intValue());

	    clickAndWait("//nav[@class='wikia-menu-button']//img[@class='sprite edit-pencil']");
	    session().click("//img[@class='sprite new']");
	    session().type("//ul[@class='ItemsList ui-sortable']/li[5]/div[2]/input", TOP10_ARTICLE_4);
	    clickAndWait("//input[@value='Save list']");

	    Number numberOfOptions4 = session().getXpathCount("//button[@class='VoteButton']");
	    assertEquals(4, numberOfOptions4.intValue());

	    clickAndWait("//nav[@class='wikia-menu-button']//img[@class='sprite edit-pencil']");
	    session().click("//form[@id='toplist-editor']/ul/li[5]/div[3]/a/img");

	    openAndWait("wiki/Top_10_List:" + name.replace(" ", "_"));
	    assertEquals(4, numberOfOptions4.intValue());

	    clickAndWait("//nav[@class='wikia-menu-button']//img[@class='sprite edit-pencil']");
	    session().click("//form[@id='toplist-editor']/ul/li[5]/div[3]/a/img");
	    clickAndWait("//input[@value='Save list']");

	    assertEquals(3, numberOfOptions3.intValue());
	    
	    session().click("//div[@id='toplists-list-body']//ul/li[2]/div[@class='ItemNumber']/button");

	    clickAndWait("//nav[@class='wikia-menu-button']//img[@class='sprite edit-pencil']");
	    session().click("//form[@id='toplist-editor']/ul/li[2]/div[3]/a/img");
	    session().click("//input[@value='Save list']");

	    openAndWait("wiki/Top_10_List:" + name.replace(" ", "_"));
	}
	
	@Test(groups={"envProduction", "CI","legacy"})
	public void testTypeSameArticleInTwoItems() throws Exception {
		session().open("wiki/Special:CreateTopList");
		session().waitForPageToLoad(this.getTimeout());
		
		String name = TOP10_LIST_NAME + (new Date()).toString(); //list name
		waitForElement("list_name");
		session().type("list_name", name);
		
		session().type("//ul[@class='ItemsList ui-sortable']/li[2]/div[2]/input", TOP10_ARTICLE_1);
		session().type("//ul[@class='ItemsList ui-sortable']/li[3]/div[2]/input", TOP10_ARTICLE_1);
		session().click("//input[@value='Create list']");
		session().waitForPageToLoad(this.getTimeout());	
		
		assertTrue(session().getLocation().contains("wiki/Special:CreateTopList"));
		assertTrue(session().isTextPresent("You can't use the same name more than once."));
	}
	
	@Test(groups={"envProduction", "CI", "legacy"})
	public void testRenameTopList() throws Exception {
		session().open("wiki/Special:CreateTopList");
		session().waitForPageToLoad(this.getTimeout());
		
		String name = TOP10_LIST_NAME + (new Date()).toString();
		waitForElement("list_name");
		session().type("list_name", name);
		session().click("//input[@value='Create list']");
		session().waitForPageToLoad(this.getTimeout());	
		session().click("//header[@id='WikiaPageHeader']/nav[@class='wikia-menu-button']/span[@class='drop']");
		session().click("//header[@id='WikiaPageHeader']/nav[@class='wikia-menu-button']//a[@data-id='move']");
		session().waitForPageToLoad(this.getTimeout());	
		String name2 = TOP10_LIST_NAME + (new Date()).toString(); 
		session().type("//table[@id='mw-movepage-table']//input[@id='wpNewTitle']", name2);
		session().click("//table[@id='mw-movepage-table']//input[@type='submit']");
	}
	
	@Test(groups={"envProduction", "CI","legacy"})
	public void testVoteAsAnonymous() throws Exception {
		session().open("wiki/Special:CreateTopList");
		session().waitForPageToLoad(this.getTimeout());
		
		String name = TOP10_LIST_NAME + (new Date()).toString();
		waitForElement("list_name");
		session().type("list_name", name);
		session().type("//ul[@class='ItemsList ui-sortable']/li[2]/div[2]/input", TOP10_ARTICLE_1);
		session().type("//ul[@class='ItemsList ui-sortable']/li[3]/div[2]/input", TOP10_ARTICLE_2);
		session().click("//input[@value='Create list']");
		session().waitForPageToLoad(this.getTimeout());	
		
		logout();
		
	    session().open("wiki/Top_10_List:" + name.replace(" ", "_"));
	    session().waitForPageToLoad(this.getTimeout());
	    
	    session().click("//div[@id='toplists-list-body']/ul/li[2]/div[@class='ItemNumber']/button[@class='VoteButton']");
	}
	
	@Test(groups={"envProduction", "CI","legacy"})
	public void testAddItemAsLoggedIn() throws Exception {
		session().open("wiki/Special:CreateTopList");
		session().waitForPageToLoad(this.getTimeout());	
		
		String name = TOP10_LIST_NAME + (new Date()).toString();
		waitForElement("list_name");
		session().type("list_name", name);
		session().type("//ul[@class='ItemsList ui-sortable']/li[2]/div[2]/input", TOP10_ARTICLE_1);
		session().type("//ul[@class='ItemsList ui-sortable']/li[3]/div[2]/input", TOP10_ARTICLE_2);
		session().click("//input[@value='Create list']");
		session().waitForPageToLoad(this.getTimeout());	
		
		session().type("//form[@class='NewItemForm']//input[@id='toplist-new-item-name']", TOP10_ARTICLE_3);
		session().click("//form[@class='NewItemForm']//button[@class='AddButton']");
		waitForElement("//div[@id='toplists-list-body']/ul/li[3]/div[@class='ItemNumber']");
		
		//AddEmptyItem
		session().click("//form[@class='NewItemForm']//button[@class='AddButton']");
		waitForTextPresent("Whoops! You didn't type anything.");
	}
	
	@Test(groups={"envProduction", "CI","legacy"})
	public void testAddItemAsAnonymous() throws Exception {
		session().open("wiki/Special:CreateTopList");
		session().waitForPageToLoad(this.getTimeout());	
		
		String name = TOP10_LIST_NAME + (new Date()).toString(); //list name
		waitForElement("list_name");
		session().type("list_name", name);
		session().type("//ul[@class='ItemsList ui-sortable']/li[2]/div[2]/input", TOP10_ARTICLE_1);
		session().type("//ul[@class='ItemsList ui-sortable']/li[3]/div[2]/input", TOP10_ARTICLE_2);
		session().click("//input[@value='Create list']");
		session().waitForPageToLoad(this.getTimeout());	
		
		logout();
		
	    session().open("wiki/Top_10_List:" + name.replace(" ", "_"));
	    session().waitForPageToLoad(this.getTimeout());
	    
	    session().type("//form[@class='NewItemForm']//input[@id='toplist-new-item-name']", TOP10_ARTICLE_3);
	    
	    session().click("//form[@class='NewItemForm']//button[@class='AddButton']");
	    assertTrue(session().isTextPresent("Anonymous users are not allowed to add items to lists."));
	}

	//Check code and verify,wait for Nandy to see why you have to be staff to delete top10 list
	//@Test(groups={"envProduction", "CI"})
	public void testDeleteTopList() throws Exception {
		session().open("wiki/Special:CreateTopList");
		
		String name = TOP10_LIST_NAME + (new Date()).toString();
		waitForElement("list_name");
		session().type("list_name", name);
		session().click("//input[@value='Create list']");
		session().waitForPageToLoad(this.getTimeout());	
		
		logout();
		
		loginAsStaff();
		
	    session().open("wiki/Top_10_List:" + name.replace(" ", "_"));
	    session().waitForPageToLoad(this.getTimeout());
	    session().click("//nav[@class='wikia-menu-button']//a[@data-id='delete']");
	    session().waitForPageToLoad(this.getTimeout());	
	    session().click("//input[@value='Delete page']");
	    session().waitForPageToLoad(this.getTimeout());	
	    
	    assertTrue(session().isTextPresent("has been deleted."));
	    
	    try {
	    	openAndWait("wiki/Top_10_List:" + name.replace(" ", "_"));
	    	assertTrue("Could open deleted page", false);
	    } catch (SeleniumException se) {
			assertTrue(se.getMessage().contains("Response_Code = 404"));
	    }
	}
	
	// BugId: 16720
	//@Test(groups={"envProduction", "CI"}) 
	public void testAddPhotoAndClear() throws Exception {
		String name = TOP10_LIST_NAME + (new Date()).toString();

		openAndWait("wiki/Special:CreateTopList");
		
		waitForElement("list_name");
		session().type("list_name", name);
		session().click("//img[@class='sprite photo']");
		waitForElementVisible("image-browser-dialogWrapper", this.getTimeout());
		session().attachFile("//input[@type='file']",DEFAULT_UPLOAD_IMAGE_URL);
		waitForElementNotVisible("image-browser-dialogWrapper", this.getTimeout());
		
		// @todo check if just uploaded image is visible

		session().click("//img[@class='sprite photo']");
		waitForElementVisible("image-browser-dialogWrapper", this.getTimeout());
		// @todo check if just uploaded image is visible in the dialog
		session().click("//div[@id='image-browser-dialog']//div[@class='NoPicture']"); 
		waitForElementNotVisible("image-browser-dialogWrapper", this.getTimeout());
		
		// @todo check if just uploaded image is not visible, the list does not have an image

		session().click("//input[@value='Create list']");
		session().waitForPageToLoad(this.getTimeout());	
		
		// @todo check that just created top list does not have an image
	}
	
	
	@Test(groups={"envProduction", "CI","legacy"})
	public void testSlashAtItemName() throws Exception {
		String name = TOP10_LIST_NAME + (new Date()).toString();;
		String name2 = TOP10_ARTICLE_1 + (new Date()).toString();;
		String special = TOP10_ARTICLE_5 + (new Date()).toString();
		String special2 = TOP10_ARTICLE_6 + (new Date()).toString();
		
		openAndWait("wiki/Special:CreateTopList");
		waitForElement("list_name");
		session().type("list_name", name);		
		session().type("//form[@id='toplist-editor']/ul[contains(@class, 'ItemsList')]/li[2]//input", special);
		session().type("//form[@id='toplist-editor']/ul[contains(@class, 'ItemsList')]/li[3]//input", special2);
		clickAndWait("//input[@value='Create list']");
		
		assertTrue(session().getLocation().contains("wiki/Top_10_list"));		
		assertTrue(session().isTextPresent(name));
				
		clickAndWait("//nav[@class='wikia-menu-button']//a[@data-id='move']");
		
		assertTrue(session().getLocation().contains("wiki/Special:MovePage"));
		assertTrue(session().isTextPresent(name));
		name2 = session().getValue("//form[@id='movepage']//td[@class='mw-input']/input") + " renamed";
		session().type("//form[@id='movepage']//td[@class='mw-input']/input", name2);		
		clickAndWait("//table[@id='mw-movepage-table']//td[@class='mw-submit']/input");
		
		assertTrue(session().getLocation().contains("wiki/Top_10_list"));
		
		assertTrue(session().isTextPresent(name2));		
		assertTrue(session().isTextPresent("/"));
		assertTrue(session().isTextPresent("/ 2"));
		
		clickAndWait("//nav[@class='wikia-menu-button']/a[@data-id='edit']");
		
		assertTrue(session().getLocation().contains("wiki/Special:EditTopList"));
		
		
		session().click("//form[@id='toplist-editor']//li[2]/div[3]/a[@title='Remove item']");
		assertFalse(session().isTextPresent("/ 2"));
		clickAndWait("//form[@id='toplist-editor']//div[@class='FormButtons']/input");
		
		assertTrue(session().getLocation().contains("wiki/Top_10_list"));
		assertFalse(session().isTextPresent("#2"));		
	
		logout();
		
		loginAsStaff();		
		
		openAndWait("wiki/" + name2.replace(" ", "_"));
		
		clickAndWait("//nav[@class='wikia-menu-button']//a[@data-id='delete']");
		
		
		clickAndWait("//form[@id='deleteconfirm']//td[@class='mw-submit']/input");
		assertTrue(session().isTextPresent("has been deleted"));
	}
	
}
