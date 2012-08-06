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

	String title = null;
	
	private String getTitle() {
		if (null == this.title) {
			String date  = (new Date()).toString();
			this.title = "Test Blog Article no. " + date + " test";
		}
		
		return this.title;
	}

	@Test(groups={"CI", "legacy", "deprecated"})
	public void testEnsureLoggedInUserCanCreateBlogPosts() throws Exception {
		login();
		openAndWait("index.php?title=Special:CreateBlogPage");

		session().type( "blogPostTitle", this.getTitle() );

		// create test article
		doEdit( ( "blogtest by bot " + new Date()).toString() );
		clickAndWait("wpPreview");
		clickAndWait("wpSave");
		
		assertEquals(this.getTitle(), session().getText("//div[@id='WikiaUserPagesHeader']/h1"));

		logout();
	}
	
	@Test(groups={"CI", "legacy", "deprecated"},dependsOnMethods={"testEnsureLoggedInUserCanCreateBlogPosts"})
	public void testEnsureUserCanPostCommentsOnBlogPosts() throws Exception {
		loginAsRegular();
		openAndWait( "index.php?title=User_blog:" + getTestConfig().getString("ci.user.wikiabot.username") + "/" + this.getTitle().replace( " ", "_" ) );
		assertTrue( session().isTextPresent( "blogtest by bot" ) );

		String date  = (new Date()).toString();
		String comment = "comment test by bot " + date + " test";
		
		session().type("article-comm", comment);
		session().click("//input[@id='article-comm-submit']");
		waitForElement("//div[@class='article-comm-text']");
		assertTrue(session().isTextPresent(comment));
		logout();
	}
}
