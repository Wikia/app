package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

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

	@Test(groups={"CI"})
	public void testEnsureLoggedInUserCanCreateBlogPosts() throws Exception {
		login();
		session().open("index.php?title=Special:CreateBlogPage");

		// random article title
		String date  = (new Date()).toString();
		title = "Test Blog Article no. " + date;

		session().type( "blogPostTitle", title );

		// create test article
		doEdit( ( "blogtest by bot " + new Date()).toString() );
		session().click("wpPreview");
		session().waitForPageToLoad( TIMEOUT );
		session().click("wpSave");
		session().waitForPageToLoad( TIMEOUT );
		logout();

		// login as different user and type comment
		// NOTE: These are now powered by article comments extension.
		// TODO: FIXME: Possibly remove this part of
		// the test if it is redundant with what is in ArticleCommentTest. 
		loginAsRegular();
		session().open( "index.php?title=User_blog:" + getTestConfig().getString("ci.user.wikiabot.username") + "/" + title.replace( " ", "_" ) );
		assertTrue( session().isTextPresent( "blogtest by bot" ) );

		session().type("article-comm", "comment test by bot");
		session().click("//input[@id='article-comm-submit']");
		waitForElement("//div[@class='article-comm-text']");
		logout();
	}
}
