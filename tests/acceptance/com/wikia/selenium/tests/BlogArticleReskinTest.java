package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertEquals;

import java.util.Random;

import org.testng.annotations.Test;

/**
 * @author Krzysztof Krzyżaniak (eloy)
 * @author macbre (modified for RTE reskin project)
 *
 * 1. create test article
 * 2. login as different user
 * 3. comment created article
 */
public class BlogArticleReskinTest extends EditPageBaseTest {

	String content;
	String postPage;
	String postTitle;

	@Test(groups={"CI", "legacy", "envProduction", "reskin"})
	public void testEnsureLoggedInUserCanCreateBlogPosts() throws Exception {
		this.postTitle = "BlogPostPrettyLongTestTitle" + Integer.toString(new Random().nextInt(9999));
		this.postPage = "User_blog:" + getTestConfig().getString("ci.user.wikiabot.username") + "/" + this.postTitle;

		this.content = "test blog post --~~~~";

		login();
		openAndWait("index.php?title=Special:CreateBlogPage");

		// test modal with required fields
		waitForElement("//section[@id='HiddenFieldsDialog']//input[@name='wpTitle']");
		assertTrue(session().isVisible("//section[@id='HiddenFieldsDialog']//input[@name='wpTitle']"));

		// click "Ok" without providing any data - modal should not be hidden
		session().click("//section[@id='HiddenFieldsDialog']//*[@id='ok']");
		waitForElementVisible("//section[@id='HiddenFieldsDialog']");

		// provide title
		session().type("wpTitle", this.postTitle + "foo");
		session().click("//section[@id='HiddenFieldsDialog']//*[@id='ok']");
		waitForElementNotPresent("//section[@id='HiddenFieldsDialog']");

		// header should be updated with new title
		waitForElement("//header[@id='EditPageHeader']//h1/a[contains(@title, '" + this.postTitle + "foo')]");

		// edit title
		session().click("//a[@id='EditPageTitle']");
		waitForElementVisible("//section[@id='HiddenFieldsDialog']");
		session().type("wpTitle", this.postTitle);
		session().click("//section[@id='HiddenFieldsDialog']//*[@id='ok']");
		waitForElementNotPresent("//section[@id='HiddenFieldsDialog']");

		// header should be updated with new title
		waitForElement("//header[@id='EditPageHeader']//h1/a[contains(@title, '" + this.postTitle + "')]");

		// edit article content (don't save yet)
		doEdit(this.content);

		// switch back to wysiwyg mode
		this.toggleMode();

		// test preview
		this.checkPreviewModal(postTitle, this.content);

		// save it
		clickAndWait("wpSave");

		// verify saved blog post
		
		assertEquals(this.postTitle, session().getText("//header[@id='WikiaUserPagesHeader']/h1"));
		
		assertTrue(session().isTextPresent("test blog post --"));
	}

	@Test(groups={"CI", "legacy", "envProduction", "reskin"},dependsOnMethods={"testEnsureLoggedInUserCanCreateBlogPosts"})
	public void testEnsureUserCanPostCommentsOnBlogPosts() throws Exception {
		loginAsBot();

		// comment newly created blog post
		openAndWait("index.php?title=" + this.postPage);
		assertTrue(session().isTextPresent("test blog post --"));

		String comment = "comment test";

		session().type("wpArticleComment", comment);
		session().click("//input[@id='article-comm-submit']");
		waitForElement("//div[@class='article-comm-text']");
		assertTrue(session().isTextPresent(comment));
	}

	@Test(groups={"CI", "legacy", "envProduction", "reskin"},dependsOnMethods={"testEnsureUserCanPostCommentsOnBlogPosts"})
	public void testEditExistingBlogPost() throws Exception {
		// login as staff user so we can remove blog post when the test is done
		loginAsStaff();

		// edit existing blog post
		openAndWait("index.php?action=edit&title=" + this.postPage);

		// header should contain blog post title
		assertTrue(session().isElementPresent("//header[@id='EditPageHeader']//h1/a[contains(@title, '" + this.postTitle + "')]"));

		// user should not be able to rename an existing blog post
		assertFalse(session().isVisible("//a[@id='EditPageTitle']"));

		// test diff
		this.checkDiffModal(postTitle, this.content);

		// change the content
		doEdit("blog post updated --~~~~");
		clickAndWait("wpSave");
		waitForTextPresent("blog post updated --");

		// cleanup
		openAndWait("index.php?title=" + this.postPage);
		doDelete("label=regexp:.*Author request", "Cleanup after BlogArticle test");
	}

	@Test(groups={"CI", "legacy", "envProduction", "reskin"})
	public void testEnsureCreateBlogPageIsNotAvailableForAnons() throws Exception {
		openAndWait("index.php?action=edit&useeditor=wysiwyg&title=Special:CreateBlogPage");

		waitForTextPresent("Not logged in");
	}
}
