package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;

public class PageTypesTest extends BaseTest {

	@Test(groups={"oasis", "CI"})
	public void testContentPage() throws Exception {
		session().open("index.php?title=Special:Random");
		session().waitForPageToLoad(this.getTimeout());

		String title = session().getEval("window.wgTitle");

		// right rail
		assertTrue(session().isElementPresent("WikiaRail"));

		// page title
		assertTrue(session().isElementPresent("//h1[text()='" + title + "']"));

		// comments / likes buttons
		assertTrue(session().isElementPresent("//ul[@class='commentslikes']"));
		
		assertTrue(session().isElementPresent("//*[contains(@class,'fb_edge_widget_with_comment') and contains(@class, 'fb_iframe_widget')]"));
		assertTrue(session().isElementPresent("//ul[@class='commentslikes']//a[contains(@href, '#WikiaArticleComments')]"));

		// search box
		assertTrue(session().isElementPresent("WikiaSearch"));

		// history dropdown
		assertTrue(session().isElementPresent("//details//ul[@class='history']"));
	}

	@Test(groups={"oasis", "CI"})
	public void testMediawikiPage() throws Exception {
		loginAsStaff();
		editArticle("MediaWiki:Mainpage", "Mainpage");
		logout();
		session().open("index.php?title=MediaWiki:Mainpage");
		session().waitForPageToLoad(this.getTimeout());

		// no right rail
		assertFalse(session().isElementPresent("WikiaRail"));

		// page title
		assertTrue(session().isElementPresent("//h1[text()='Mainpage']"));

		// page subtitle
		assertTrue(session().isElementPresent("//h2[text()='MediaWiki page']"));

		// comments chicklet
		assertTrue(session().isElementPresent("//ul[@class='commentslikes']"));
		assertTrue(session().isElementPresent("//ul[@class='commentslikes']//a[contains(@href, 'MediaWiki_talk:Mainpage')]"));

		// search box
		assertTrue(session().isElementPresent("WikiaSearch"));
	}

	@Test(groups={"oasis", "CI"})
	public void testCategoryPage() throws Exception {
		loginAsStaff();
		editArticle("Category:Some category", "Wikia PageTypes test");
		session().open("index.php?title=Category:Some category");
		addCategory("Lorem ipsum", "Some content", "Some category");
		logout();
		session().open("index.php?title=Category:Some category");
		session().waitForPageToLoad(this.getTimeout());

		// right rail
		assertTrue(session().isElementPresent("WikiaRail"));

		// page title
		assertTrue(session().isElementPresent("//h1[text()='Some category']"));

		// page subtitle
		assertTrue(session().isElementPresent("//h2[text()='Category page']"));

		// comments / likes buttons
		assertTrue(session().isElementPresent("//ul[@class='commentslikes']"));
		assertTrue(session().isElementPresent("//*[contains(@class,'fb_edge_widget_with_comment') and contains(@class, 'fb_iframe_widget')]//iframe"));
		assertTrue(session().isElementPresent("//ul[@class='commentslikes']//a[contains(@href, 'Category_talk:Some_category')]"));

		// search box
		assertTrue(session().isElementPresent("WikiaSearch"));
		
		// cleanup
		loginAsStaff();
		session().open("index.php?title=Category:Some category");
		doDelete("label=regexp:^.*Author request", "Wikia PageTypes test");
	}

	@Test(groups={"oasis", "CI"})
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

		// comments chicklet
		assertFalse(session().isElementPresent("//ul[@class='commentslikes']"));

		// search box
		assertTrue(session().isElementPresent("WikiaSearch"));

		// history dropdown
		assertTrue(session().isElementPresent("//details//ul[@class='history']"));

		// cleanup
		doDelete("label=regexp:^.*Author request", "Wikia PageTypes test");
	}

	@Test(groups={"oasis", "CI"})
	public void testBlogPostPage() throws Exception {
		String page = "User_blog:WikiaStaff/Test_Blog_Post";

		// create blog post
		loginAsStaff();
		editArticle(page, "blog post --~~~~");

		// right rail
		assertTrue(session().isElementPresent("WikiaRail"));

		// page title
		assertTrue(session().isElementPresent("//h1[text()='Test Blog Post']"));

		// comments / likes buttons
		assertTrue(session().isElementPresent("//ul[@class='commentslikes']"));
		assertTrue(session().isElementPresent("//*[contains(@class,'fb_edge_widget_with_comment') and contains(@class, 'fb_iframe_widget')]//iframe"));
		assertTrue(session().isElementPresent("//ul[@class='commentslikes']//a[contains(@href, '#WikiaArticleComments')]"));

		// search box
		assertTrue(session().isElementPresent("WikiaSearch"));

		// author avatar and name
		assertTrue(session().isElementPresent("//details//img[@class='avatar']"));
		assertTrue(session().isElementPresent("//details//span[@class='post-author']//a[contains(@href,'User:" + getTestConfig().getString("ci.user.wikiastaff.username") + "')]"));

		// no history dropdown
		assertFalse(session().isElementPresent("//details//ul[@class='history']"));
	}

	@Test(groups={"oasis", "CI"})
	public void testBlogPostsListingPage() throws Exception {
		session().open("index.php?title=Blog:Recent_posts");
		session().waitForPageToLoad(this.getTimeout());

		// right rail
		assertTrue(session().isElementPresent("WikiaRail"));

		// "Popular Blog Posts" right rail module
		assertTrue(session().isElementPresent("//section[contains(@class, 'WikiaBlogListingBox')]"));

		// page title
		assertTrue(session().isElementPresent("//h1[text()='Blog posts']"));

		// search box
		assertTrue(session().isElementPresent("WikiaSearch"));

		// "create blog post" button
		assertTrue(session().isElementPresent("//div[@id='WikiaUserPagesHeader']/a[contains(@href,'Special:CreateBlogPage')]"));
	}

	@Test(groups={"oasis", "CI"})
	public void testUserPage() throws Exception {
		// user subpage (catch HTTP 404)
		try {
			session().open("index.php?title=User:" + getTestConfig().getString("ci.user.regular.username") + "/Subpage");
			session().waitForPageToLoad(this.getTimeout());
		} catch(Exception e) {
			loginAsRegular();
			editArticle("User:" + getTestConfig().getString("ci.user.regular.username") + "/Subpage", "Lorem ipsum");
			logout();
		};

		// page title
		assertTrue(session().isElementPresent("//h1[text()='" + getTestConfig().getString("ci.user.regular.username") + "/Subpage']"));

		// avatar
		assertTrue(session().isElementPresent("//div[@id='" + getTestConfig().getString("ci.user.regular.username") + "PagesHeader']//img[@alt='" + getTestConfig().getString("ci.user.regular.username") + "']"));

		// profile tab should be selected
		assertTrue(session().isElementPresent("//ul[@class='tabs']/li[@class='selected']/a[contains(@title,'User:" + getTestConfig().getString("ci.user.regular.username") + "')]"));

		// anon page (catch HTTP 404)
		try {
			session().open("index.php?title=User:1.2.3.4");
		} catch(Exception e) {};

		session().waitForPageToLoad(this.getTimeout());

		// page title
		assertTrue(session().isElementPresent("//h1[contains(text(), 'A Wikia contributor')]"));
		assertTrue(session().isElementPresent("//h1//small[text()= '1.2.3.4']"));

		// avatar
		assertTrue(session().isElementPresent("//div[@id='WikiaUserPagesHeader']//img[@alt='1.2.3.4']"));
		assertTrue(session().isElementPresent("//div[@id='WikiaUserPagesHeader']//img[contains(@src,'100px-')]"));

		// contributions tab
		assertTrue(session().isElementPresent("//div[@id='WikiaUserPagesHeader']//ul[@class='tabs']//a[contains(@href, 'Special:Contributions/1.2.3.4')]"));
	}

	private void addCategory(String articleName, String content, String categoryName) throws Exception {
		session().open("index.php?title=" + articleName + "&action=edit&useeditor=source");
		session().waitForPageToLoad(this.getTimeout());
		
		doEdit(content);
	
		if (!session().isTextPresent(categoryName)) {
			waitForElement("link=Add category");
			session().click("link=Add category");
			waitForElement("//*[@id=\"csCategoryInput\"]");

			session().type("csCategoryInput", categoryName);
			session().keyPress("csCategoryInput", "\\13");
			session().click("//div[@id='csItemsContainer']/a[1]/img");
			waitForElement("csInfoboxCategory");
		}

		doSave();
	}
}
