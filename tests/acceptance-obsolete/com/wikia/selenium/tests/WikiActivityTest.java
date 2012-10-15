//@author Sean Colombo - based on MyHomeTest by Macbre
package com.wikia.selenium.tests;

import java.util.Date;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.*;

public class WikiActivityTest extends BaseTest {
	private static String WIKIACTIVITY_ARTICLE_ONE   = "Wiki Activity Article One";
	private static String WIKIACTIVITY_ARTICLE_TWO   = "Wiki Activity Article Two";
	private static String WIKIACTIVITY_ARTICLE_THREE = "Wiki Activity Article Three";
	private static String WIKIACTIVITY_ARTICLE_FOUR  = "Wiki Activity Article Four";
	private static String WIKIACTIVITY_ARTICLE_FIVE  = "Wiki Activity Article Five";
	private static String WIKIACTIVITY_ARTICLE_SIX   = "Wiki Activity Article Six";

	@Test(groups={"CI", "legacy"})
	public void testEnsuresThatWikiActivityButtonLeadsToProperSpecialPage() throws Exception {
		login();

		// check presence of link to WikiActivity
		assertTrue(session().isElementPresent("//a[@data-id='wikiactivity']"));

		// and click it
		clickAndWait("//a[@data-id='wikiactivity']");

		// check what page you land on
		assertTrue(session().getLocation().contains("/wiki/Special:WikiActivity"));
	}

	@Test(groups={"CI", "legacy"})
	public void testEnsuresThatActivityFeedModuleIsPresentOnAnArticlePage() throws Exception {
		openAndWait("index.php?title=Special:Random");

		// check that there are items in the Recent Wiki Activity module.
		waitForElement("//section[contains(@class,'WikiaActivityModule')]/ul/li");

		// check presence of link to ActivityFeed for anons
		assertTrue(session().isElementPresent("//section[contains(@class,'WikiaActivityModule')]/a[@class='more']"));
		
		String content = "Lorem ipsum " + (new Date()).toString();
		
		editArticle(WIKIACTIVITY_ARTICLE_ONE, content);
		editArticle(WIKIACTIVITY_ARTICLE_TWO, content);
		editArticle(WIKIACTIVITY_ARTICLE_THREE, content);
		editArticle(WIKIACTIVITY_ARTICLE_FOUR, content);

		session().open("index.php?title=Special:Random");
		session().waitForPageToLoad(this.getTimeout());
		waitForElement("//section[contains(@class,'WikiaActivityModule')]");
		waitForTextPresent(WIKIACTIVITY_ARTICLE_FOUR);
		
		assertEquals(WIKIACTIVITY_ARTICLE_FOUR, session().getText("//section[contains(@class,'WikiaActivityModule')]//li[1]//a"));
		assertEquals(WIKIACTIVITY_ARTICLE_THREE, session().getText("//section[contains(@class,'WikiaActivityModule')]//li[2]//a"));
		assertEquals(WIKIACTIVITY_ARTICLE_TWO, session().getText("//section[contains(@class,'WikiaActivityModule')]//li[3]//a"));
		assertEquals(WIKIACTIVITY_ARTICLE_ONE, session().getText("//section[contains(@class,'WikiaActivityModule')]//li[4]//a"));
		
		editArticle(WIKIACTIVITY_ARTICLE_FIVE, content);

		session().open("index.php?title=Special:Random");
		session().waitForPageToLoad(this.getTimeout());
		waitForElement("//section[contains(@class,'WikiaActivityModule')]");
		waitForTextPresent(WIKIACTIVITY_ARTICLE_FIVE);
		
		assertEquals(WIKIACTIVITY_ARTICLE_FIVE, session().getText("//section[contains(@class,'WikiaActivityModule')]//li[1]//a"));
		assertEquals(WIKIACTIVITY_ARTICLE_FOUR, session().getText("//section[contains(@class,'WikiaActivityModule')]//li[2]//a"));
		assertEquals(WIKIACTIVITY_ARTICLE_THREE, session().getText("//section[contains(@class,'WikiaActivityModule')]//li[3]//a"));
		assertEquals(WIKIACTIVITY_ARTICLE_TWO, session().getText("//section[contains(@class,'WikiaActivityModule')]//li[4]//a"));
		assertFalse(session().isElementPresent("//section[contains(@class,'WikiaActivityModule')]//li[5]"));
	}

	@Test(groups={"CI", "legacy"})
	public void testEditingArticleByUser() throws Exception{
		
		session().open("index.php?title=Special:Random");
		String content = "Lorem ipsum " + (new Date()).toString();
		editArticle(WIKIACTIVITY_ARTICLE_ONE, content);
		session().open("index.php?title=Special:Random");
		assertTrue(session().isElementPresent("//a[@data-id='wikiactivity']"));
		session().click("//a[@data-id='wikiactivity']");
		waitForElement("//ul[@id='myhome-activityfeed']");
		assertTrue(session().getLocation().contains("/wiki/Special:WikiActivity"));
		assertEquals(WIKIACTIVITY_ARTICLE_ONE, session().getText("//ul[@id='myhome-activityfeed']/li[1]//a"));
	}
	
	@Test(groups={"CI", "legacy"})
	public void testEditingArticleByAnonymousUserAndLoggedUser() throws Exception{
		
		session().open("index.php?title=Special:Random");
		String content = "Lorem ipsum " + (new Date()).toString();
		editArticle(WIKIACTIVITY_ARTICLE_ONE, content);
	
		content = "dolor " + (new Date()).toString();
		loginAsRegular();
		editArticle(WIKIACTIVITY_ARTICLE_ONE, content);
		
		session().open("index.php?title=Special:Random");
		assertTrue(session().isElementPresent("//a[@data-id='wikiactivity']"));
		session().click("//a[@data-id='wikiactivity']");
		waitForElement("//ul[@id='myhome-activityfeed']");
		assertTrue(session().getLocation().contains("/wiki/Special:WikiActivity"));

		assertEquals(WIKIACTIVITY_ARTICLE_ONE, session().getText("//ul[@id='myhome-activityfeed']/li[1]//a"));
		assertEquals(WIKIACTIVITY_ARTICLE_ONE, session().getText("//ul[@id='myhome-activityfeed']/li[2]//a"));
	}
	
	@Test(groups={"CI", "legacy"})
	public void testFollowingPagesFiltres() throws Exception{
			
		openAndWait("index.php?title=Special:Random");
		String content = "Lorem ipsum " + (new Date()).toString();
		loginAsRegular();
		session().click("link=My preferences");
		waitForElement("//ul[@id='preftoc']");
		session().click("//ul[@id='preftoc']/li[2]/a");
		
		if(!session().isChecked("//input[@id='mw-input-watchdefault']"))
			{
				session().check("//input[@id='mw-input-watchdefault']");
			}
		clickAndWait("//input[@id='prefcontrol']");
		
		editArticle(WIKIACTIVITY_ARTICLE_SIX, content);
		
		openAndWait("index.php?title=Special:Random");
		clickAndWait("//a[@data-id='wikiactivity']");
		waitForElement("//ul[@id='myhome-activityfeed']");
		assertTrue(session().getLocation().contains("/wiki/Special:WikiActivity"));
		clickAndWait("//header[@id='WikiaPageHeader']/h2/nav//li[@class='watchlist']/a");
		waitForElement("//input[@id='wikiactivity-default-view-switch']");
		assertEquals(WIKIACTIVITY_ARTICLE_SIX, session().getText("//ul[@id='myhome-activityfeed']/li[1]//a"));

		session().click("link=My preferences");
		waitForElement("//ul[@id='preftoc']");
		session().click("//ul[@id='preftoc']/li[6]/a");
		if(session().isChecked("//input[@id='mw-input-watchdefault']"))
			{
				session().uncheck("//input[@id='mw-input-watchdefault']");
			}
		clickAndWait("//input[@id='prefcontrol']");
		openAndWait("/wiki/" + WIKIACTIVITY_ARTICLE_FOUR);
		waitForElement("//div[@class='toolbar']");
		if (session().isElementPresent("//a[@id='ca-unwatch' and contains(@href, 'unwatch')]")) {
			session().click("//a[@id='ca-unwatch' and contains(@href, 'unwatch')]");
		}
		content = "dolor " + (new Date()).toString();
		editArticle(WIKIACTIVITY_ARTICLE_FOUR, content);
		clickAndWait("//a[@data-id='wikiactivity']");
		waitForElement("//ul[@id='myhome-activityfeed']");
		assertTrue(session().getLocation().contains("/wiki/Special:WikiActivity"));
		clickAndWait("//header[@id='WikiaPageHeader']/h2/nav//li[@class='watchlist']/a");
		waitForElement("//input[@id='wikiactivity-default-view-switch']");
		assertFalse(session().getText("//ul[@id='myhome-activityfeed']/li[1]//a").equals(WIKIACTIVITY_ARTICLE_FOUR));
	}
}
