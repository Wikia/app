package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertEquals;

import java.util.Date;

import org.testng.annotations.Test;

/**
 * @author Krzysztof Krzyżaniak (eloy)
 *
 * 1. create test article
 * 2. login as different user
 * 3. comment created article
 */
public class BlogArticleTest extends BaseTest {

	String title = new String();

	@Test(groups={"CI", "envProduction"})
	public void testEnsureLoggedInUserCanCreateBlogPosts() throws Exception {
		// random article title
		String date  = (new Date()).toString();
		title = "Test Blog Article no. " + date;

		login();
		session().open("index.php?title=Special:CreateBlogPage");

		session().type( "blogPostTitle", title );

		// create test article
		doEdit( ( "blogtest by bot " + new Date()).toString() );
		session().click("wpPreview");
		session().waitForPageToLoad( this.getTimeout() );
		session().click("wpSave");
		session().waitForPageToLoad( this.getTimeout() );
		
		assertEquals(title, session().getText("//div[@id='WikiaUserPagesHeader']/h1"));

		logout();
	}
	
	@Test(groups={"CI", "envProduction"},dependsOnMethods={"testEnsureLoggedInUserCanCreateBlogPosts"})
	public void testEnsureUserCanPostCommentsOnBlogPosts() throws Exception {
		loginAsRegular();
		session().open( "index.php?title=User_blog:" + getTestConfig().getString("ci.user.wikiabot.username") + "/" + title.replace( " ", "_" ) );
		assertTrue( session().isTextPresent( "blogtest by bot" ) );

		String date  = (new Date()).toString();
		String comment = "comment test by bot " + date;
		
		session().type("article-comm", comment);
		session().click("//input[@id='article-comm-submit']");
		waitForElement("//div[@class='article-comm-text']");
		assertTrue(session().isTextPresent(comment));
		logout();
	}
}
