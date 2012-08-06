package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;

public class PageTypesTest extends BaseTest {

	@Test(groups={"CI", "legacy"})
	public void testContentPage() throws Exception {
		openAndWait("index.php?title=Special:Random");

		String title = session().getEval("window.wgTitle");

		// right rail
		assertTrue(session().isElementPresent("WikiaRail"));

		// page title
		assertTrue(session().isElementPresent("//h1[text()='" + title + "']"));

		// comments buttons
		assertTrue(session().isElementPresent("//a[@data-id='comment']"));
		assertTrue(session().isElementPresent("//a[@data-id='comment' and contains(@href, '#WikiaArticleComments')]"));

		// search box
		assertTrue(session().isElementPresent("WikiaSearch"));
	}

	@Test(groups={"CI", "legacy"})
	public void testMediawikiPage() throws Exception {
		loginAsStaff();
		editArticle("MediaWiki:Mainpage", "Mainpage");
		logout();
		openAndWait("index.php?title=MediaWiki:Mainpage");

		// right rail
		assertTrue(session().isElementPresent("WikiaRail"));

		// page title
		assertTrue(session().isElementPresent("//h1[text()='Mainpage']"));

		// page subtitle
		assertTrue(session().isElementPresent("//h2[text()='MediaWiki page']"));

		// comments chicklet
		assertTrue(session().isElementPresent("//a[@data-id='comment']"));
		assertTrue(session().isElementPresent("//a[@data-id='comment' and contains(@href, 'MediaWiki_talk:Mainpage')]"));

		// search box
		assertTrue(session().isElementPresent("WikiaSearch"));
	}

	@Test(groups={"CI", "legacy"})
	public void testCategoryPage() throws Exception {
		loginAsStaff();
		editArticle("Category:Some category", "Wikia PageTypes test");
		openAndWait("index.php?title=Category:Some category");
		addCategory("Lorem ipsum", "Some category");
		logout();
		openAndWait("index.php?title=Category:Some category");

		// right rail
		assertTrue(session().isElementPresent("WikiaRail"));

		// page title
		assertTrue(session().isElementPresent("//h1[text()='Some category']"));

		// page subtitle
		assertTrue(session().isElementPresent("//h2[text()='Category page']"));

		// comments buttons
		assertTrue(session().isElementPresent("//a[@data-id='comment']"));
		assertTrue(session().isElementPresent("//a[@data-id='comment' and contains(@href, 'Category_talk:Some_category')]"));

		// search box
		assertTrue(session().isElementPresent("WikiaSearch"));
		
		// cleanup
		loginAsStaff();
		openAndWait("index.php?title=Category:Some category");
		doDelete("label=regexp:^.*Author request", "Wikia PageTypes test");
	}

	@Test(groups={"CI", "legacy"})
	public void testForumPage() throws Exception {
		String page = "Forum:WikiaTest";

		// create page in forum namespace
		loginAsStaff();
		editArticle(page, "test --~~~~");

		// right rail
		assertTrue(session().isElementPresent("WikiaRail"));

		// page title
		assertTrue(session().isElementPresent("//h1[text()='WikiaTest']"));

		// page subtitle
		assertTrue(session().isElementPresent("//h2[text()='Forum page']"));

		// comments chicklet (old and new version)
		assertFalse(session().isElementPresent("//ul[@class='commentslikes']"));
		assertFalse(session().isElementPresent("//a[@data-id='comment']"));

		// search box
		assertTrue(session().isElementPresent("WikiaSearch"));

		// cleanup
		doDelete("label=regexp:^.*Author request", "Wikia PageTypes test");
	}

	@Test(groups={"CI", "legacy"})
	public void testBlogPostPage() throws Exception {
		String page = "User_blog:" + getTestConfig().getString("ci.user.wikiastaff.username") + "/Test_Blog_Post";

		// create blog post
		loginAsStaff();
		editArticle(page, "blog post --~~~~");

		// right rail
		assertTrue(session().isElementPresent("WikiaRail"));

		// page title
		assertTrue(session().isElementPresent("//h1[text()='Test Blog Post']"));

		// comments buttons
		assertTrue(session().isElementPresent("//a[@data-id='comment']"));
		assertTrue(session().isElementPresent("//a[@data-id='comment' and contains(@href, '#WikiaArticleComments')]"));

		// search box
		assertTrue(session().isElementPresent("WikiaSearch"));

		// author avatar and name
		assertTrue(session().isElementPresent("//div[@class='author-details']//img[@class='avatar']"));
		assertTrue(session().isElementPresent("//div[@class='author-details']//span[@class='post-author']//a[contains(@href,'User:" + getTestConfig().getString("ci.user.wikiastaff.username") + "')]"));
	}

	@Test(groups={"CI", "legacy"})
	public void testBlogPostsListingPage() throws Exception {
		openAndWait("index.php?title=Blog:Recent_posts");

		// right rail
		assertTrue(session().isElementPresent("WikiaRail"));

		// "Popular Blog Posts" right rail module
		assertTrue(session().isElementPresent("//section[contains(@class, 'WikiaBlogListingBox')]"));

		// page title
		assertTrue(session().isElementPresent("//h1[text()='Recent posts']"));
		assertTrue(session().isElementPresent("//h2[text()='Blog posts']"));

		// search box
		assertTrue(session().isElementPresent("WikiaSearch"));

		// "create blog post" button
		assertTrue(session().isElementPresent("//div[@id='WikiaUserPagesHeader']/a[contains(@href,'Special:CreateBlogPage')]"));
	}

	@Test(groups={"CI", "legacy"})
	public void testUserPage() throws Exception {
		loginAsRegular();
		editArticle("User:" + getTestConfig().getString("ci.user.regular.username") + "/Subpage", "Lorem ipsum");
		logout();
		openAndWait("index.php?title=User:" + getTestConfig().getString("ci.user.regular.username") + "/Subpage");

		// page title
		assertTrue(session().isElementPresent("//h1[text()='" + getTestConfig().getString("ci.user.regular.username") + "/Subpage']"));

		// avatar
		// BugId: 18708
		//assertTrue(session().isElementPresent("//div[@id='" + getTestConfig().getString("ci.user.regular.username") + "PagesHeader']//img[@alt='" + getTestConfig().getString("ci.user.regular.username") + "']"));

		// profile tab should be selected
		// BugId: 18708
		//assertTrue(session().isElementPresent("//ul[@class='tabs']/li[@class='selected']/a[contains(@title,'User:" + getTestConfig().getString("ci.user.regular.username") + "')]"));

		// anon page (catch HTTP 404)
		openAndWait("index.php?title=User:1.2.3.4");

		// page title
		assertTrue(session().isElementPresent("//h1[contains(text(), 'A Wikia Contributor')]"));
		assertTrue(session().isElementPresent("//h2[contains(text(), '1.2.3.4')]"));

		// avatar
		// BugId: 18708
		//assertTrue(session().isElementPresent("//div[@id='WikiaUserPagesHeader']//img[@alt='1.2.3.4']"));
		//assertTrue(session().isElementPresent("//div[@id='WikiaUserPagesHeader']//img[contains(@src,'100px-')]"));

		// contributions tab
		// BugId: 18708
		//assertTrue(session().isElementPresent("//div[@id='WikiaUserPagesHeader']//ul[@class='tabs']//a[contains(@href, 'Special:Contributions/1.2.3.4')]"));
	}

	private void addCategory(String articleName, String categoryName) throws Exception {
		if (!session().isTextPresent(categoryName)) {
			waitForElement("link=Add category");
			session().click("link=Add category");
			waitForElement("csCategoryInput");
			session().type("csCategoryInput", categoryName);
			session().getEval("var e = window.jQuery.Event('keypress'); e.keyCode = 13; window.$('#csCategoryInput').trigger(e)");
			waitForElement("//div[@id='csItemsContainer']/a[1]/img");
		}
	}
}
