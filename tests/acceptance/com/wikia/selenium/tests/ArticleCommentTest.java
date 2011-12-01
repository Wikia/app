/**
 * ArticleComment_v2 test
 *
 * @author Adrian Jaroszewicz
 * @date 2010-08-10
 * @copyright Copyright (C) 2010 Adrian Jaroszewicz, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

package com.wikia.selenium.tests;

import java.util.Date;
import java.util.Random;
import java.text.SimpleDateFormat;
import java.text.DateFormat;

import org.testng.annotations.Test;
import com.thoughtworks.selenium.SeleniumException;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertEquals;

/**
 * To enable the extension used by this test, in LocalSettings.php or WikiFactory, set:
 * $wgEnableArticleCommentsExt = true;
 * $wgArticleCommentsMaxPerPage = 5; // the default varies (right now it's 20 in production and 25 on dev boxes).
 */
public class ArticleCommentTest extends BaseTest {

	public static int articleCommentsMaxPerPage = 25; // = $wgArticleCommentsMaxPerPage
	public static String articlePath = "index.php?title=Special:Random";
	public static String blogPostName = "Change_me_in_constructor";
	public static String blogPostName_1 = "Blog_post_number_1";
	public String location = "";
	public String commentContent = "";
	
	public ArticleCommentTest() {
		// choose a blog post name based on the timestamp
		DateFormat df = new SimpleDateFormat("yyyyMMDDHHmm");
		this.blogPostName = "Blog_post_" + df.format(new Date());
	}

	/**
	 * Opens a page. If that page doesn't exist yet, instead of just 404ing, will
	 * create the page with some default text.
	 */
	private void openOrCreatePage(String pageName) throws Exception {
		boolean exists = false;
		try{
			openAndWait(pageName);
			if (!session().isTextPresent("This page needs content")) {
				exists = true;
			}
		} catch(SeleniumException e){
		}
		
		if (!exists) {
			openAndWait(pageName + "&action=edit");
			waitForElement("wpTextbox1");
			waitForElement("wpSave");
			doEdit("Test page content");
			clickAndWait("wpSave");
			openAndWait(pageName);
		}
	}

	/**
	 * Opens a page. If that page doesn't exist yet, instead of just 404ing, will
	 * create the page with some default text.
	 */
	private void openOrCreateBlogPage(String username, String blogPostName) throws Exception {
		String pageName = "index.php?title=User_blog:"+username+"/"+blogPostName;
		boolean exists = true;
		try{
			openAndWait(pageName);
			if (session().isTextPresent("There is currently no text in this page") || session().isTextPresent("This page needs content")) {
				exists = false;
			}
		} catch(SeleniumException e) {
			exists = false;
		}

		// Page might not exist yet.
		if (!exists) {
			loginAsStaff();
			openAndWait("index.php?title=Special:CreateBlogPage");
			waitForElement("wpTextbox1");
			waitForElement("wpSave");
			waitForElement("wpTitle");
			session().type("wpTitle", blogPostName);
			session().click("//section[@id='HiddenFieldsDialog']//*[@id='ok']");
			waitForElementNotPresent("//section[@id='HiddenFieldsDialog']");
			doEdit("Test page content");
			clickAndWait("wpSave");
			openAndWait(pageName);
		}
	}

	private void addComment(String commentContent) throws Exception {
		session().type("article-comm", commentContent);
		session().click("article-comm-submit");

		waitForElement("//ul[@id='article-comments-ul']" +
						"/li[1 and contains(@class,'SpeechBubble')]" +
						"//div[@class='article-comm-text']" +
						"/p[contains(text(), '" + commentContent + "')]");
	}

	private void addReply(String replyContent) throws Exception {
		session().click("//ul[@id='article-comments-ul']" +
			"/li[1 and contains(@class,'SpeechBubble')]" +
			"//a[contains(@class, 'article-comm-reply')]");
		waitForElement("//ul[@id='article-comments-ul']" +
			"/li[1 and contains(@class,'SpeechBubble')]" +
			"//textarea[@name='wpArticleReply']");

		session().type("//ul[@id='article-comments-ul']" +
			"/li[1 and contains(@class,'SpeechBubble')]" +
			"//textarea[@name='wpArticleReply']", replyContent);

		session().click("//ul[@id='article-comments-ul']" +
			"/li[1 and contains(@class,'SpeechBubble')]" +
			"//input[@name='wpArticleSubmit' and @value='Post comment']");

		waitForElement("//ul[@id='article-comments-ul']" +
			"/ul[@class='sub-comments']/li[1 and contains(@class,'SpeechBubble')]" +
			"//div[@class='article-comm-text']" +
			"/p[contains(text(), '" + replyContent + "')]");
	}

	// tests for article comments

	@Test(groups={"CI", "verified"})
	public void testa1CommentSection() throws Exception {
		openAndWait(articlePath);

		assertTrue(session().isElementPresent("WikiaArticleComments"));
	}

	// BugId: 16719
	@Test(groups={"CI", "broken"})
	public void testb2ShowAllComments() throws Exception {
		openAndWait(articlePath);

		// adding (articleCommentsMaxPerPage + 1) comments
		for (int i = 0; i < articleCommentsMaxPerPage + 1; i++)
			addComment("comment " + i + ": " + new Date().toString());

		session().refresh();
		session().waitForPageToLoad(this.getTimeout());
		
		String location = session().getLocation();
		openAndWait(location);
		
		assertTrue(session().isElementPresent("//div[contains(@class,'article-comments-pagination')]//a"));

		clickAndWait("link=Show all");

		assertEquals(26, session().getXpathCount("//ul[@id='article-comments-ul']/li[1 and contains(@class,'SpeechBubble')]"));
		assertFalse(session().isElementPresent("//div[contains(@class,'article-comments-pagination')]//a"));
	}

	@Test(groups={"CI", "verified"})
	public void testc3NumberOfComments() throws Exception {
		openAndWait(articlePath + "&showall=1");

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		Number numberOfComments = session().getXpathCount("//ul[@id='article-comments-ul']/li[1 and contains(@class,'SpeechBubble')]");

		String articleCommentHeader = session().getText("//h1[@id='article-comments-counter-header']");

		String stringToCompare = numberOfComments + " comments";
		assertEquals(articleCommentHeader, stringToCompare);
	}

	@Test(groups={"CI", "verified"})
	public void testd4AddComment() throws Exception {
		openAndWait(articlePath);

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);
	}

	@Test(groups={"CI", "verified"})
	public void testf6EditButtonPresence() throws Exception {
		loginAsRegular();

		openAndWait(articlePath + "&showall=1");

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		Number numberOfComments = session().getXpathCount("//li[contains(@class,'article-comments-li')]");

		for (int i = 1; i < numberOfComments.intValue() + 1; i++) {
			String commentId = session().getAttribute("//ul[@id='article-comments-ul']" +
					"/li[" + i + "]@id");
			// user can edit only his/her own comments
			if (session().isElementPresent("//li[@id='" + commentId + "']//a[contains(text(), '" +
				getTestConfig().getString("ci.user.regular.username") + "')]")) {
				assertFalse(session().isVisible("//li[@id='" + commentId + "']//span[@class='tools']"));
				assertTrue(session().isElementPresent("//li[@id='" + commentId + "']//span[@class='tools']" +
						"/span[@class='edit-link']/a[@class='article-comm-edit']"));
			}
			else {
				assertFalse(session().isElementPresent("//li[@id='" + commentId + "']//a[@class='article-comm-edit']"));
			}
		}
	}

	@Test(groups={"CI", "verified"})
	public void testg7EditArticleComment() throws Exception {
		loginAsRegular();

		openAndWait(articlePath);

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		assertTrue(session().isElementPresent("//ul[@id='article-comments-ul']/li[1]" +
				"//a[@class='article-comm-edit']"));
		
		session().click("//ul[@id='article-comments-ul']/li[1]" +
				"//a[@class='article-comm-edit']");

		waitForElement("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']");

		session().type("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']", "edit(" + commentContent + ")");

		session().click("//ul[@id='article-comments-ul']/li[1]//input[@name='wpArticleSubmit']");

		waitForElement("//ul[@id='article-comments-ul']" +
						"/li[1 and contains(@class,'SpeechBubble')]" +
						"//div[@class='article-comm-text']" +
						"/p[contains(text(), 'edit(" + commentContent + ")')]");
	}

	@Test(groups={"CI", "verified"})
	public void testh8StaffEditArticleCommentPart1() throws Exception {
		loginAsRegular();

		openAndWait(articlePath);
		
		this.location = session().getLocation();

		this.commentContent = "test comment: " + new Date().toString();
		addComment(this.commentContent);

		assertTrue(session().isElementPresent("//ul[@id='article-comments-ul']/li[1]" +
				"//a[@class='article-comm-edit']"));

		session().click("//ul[@id='article-comments-ul']/li[1]" +
				"//a[@class='article-comm-edit']");

		waitForElement("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']");

		session().type("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']", "edit(" + this.commentContent + ")");

		session().click("//ul[@id='article-comments-ul']/li[1]//input[@name='wpArticleSubmit']");

		waitForElement("//ul[@id='article-comments-ul']" +
						"/li[1 and contains(@class,'SpeechBubble')]" +
						"//div[@class='article-comm-text']" +
						"/p[contains(text(), 'edit(" + this.commentContent + ")')]");
	}
	
	@Test(groups={"CI", "verified"},dependsOnMethods={"testh8StaffEditArticleCommentPart1"})
	public void testh8StaffEditArticleCommentPart2() throws Exception {
		loginAsStaff();
		openAndWait(this.location);

		session().click("//ul[@id='article-comments-ul']/li[1]" +
				"//a[@class='article-comm-edit']");

		waitForElement("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']");

		session().type("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']", "edit(" + this.commentContent + ")");

		session().click("//ul[@id='article-comments-ul']/li[1]//input[@name='wpArticleSubmit']");

		waitForElement("//ul[@id='article-comments-ul']" +
						"/li[1 and contains(@class,'SpeechBubble')]" +
						"//div[@class='article-comm-text']" +
						"/p[contains(text(), 'edit(" + this.commentContent + ")')]");
	}

	@Test(groups={"CI","verified"})
	public void testi9HistoryButton() throws Exception {
		loginAsRegular();
		
		String pageToUse = "index.php?title=Test_3";
		openOrCreatePage(pageToUse);

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		session().click("//ul[@id='article-comments-ul']/li[1]" +
				"//a[@class='article-comm-edit']");

		waitForElement("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']");

		session().type("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']", "edit(" + commentContent + ")");

		session().click("//ul[@id='article-comments-ul']/li[1]//input[@name='wpArticleSubmit']");

		waitForElement("//ul[@id='article-comments-ul']" +
						"/li[1 and contains(@class,'SpeechBubble')]" +
						"//div[@class='article-comm-text']" +
						"/p[contains(text(), 'edit(" + commentContent + ")')]");

		assertTrue(session().isElementPresent("//ul[@id='article-comments-ul']/li[1]//a[@class='article-comm-history']"));

		logout();

		openAndWait(pageToUse);

		assertTrue(session().isElementPresent("//ul[@id='article-comments-ul']/li[1]//a[@class='article-comm-history']"));
	}

	@Test(groups={"CI", "verified"})
	public void testj10ReplyTwice() throws Exception {
		loginAsRegular();

		openAndWait(articlePath);
		
		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		addReply("reply 1");
		addReply("reply 2");
	}

	@Test(groups={"CI", "verified"})
	public void testk11DeleteComment() throws Exception {
		loginAsStaff();

		openAndWait(articlePath);
		waitForElement("article-comm");

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		clickAndWait("//ul[@id='article-comments-ul']" +
				"/li[1 and contains(@class, 'SpeechBubble')]" +
				"//a[@class='article-comm-delete']");

		clickAndWait("wpConfirmB");

		// check if the comment was deleted
		assertFalse(session().isElementPresent("//ul[@id='article-comments-ul']" +
				"/li[contains(@class,'article')]" +
				"//p[contains(text(), '" + commentContent + "')]"));
	}

	@Test(groups={"CI", "verified"})
	public void testl12DeleteCascadeComment() throws Exception {
		loginAsStaff();

		openAndWait(articlePath);
		waitForElement("article-comm");

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);
		addReply("reply 1(" + commentContent + ")");
		addReply("reply 2(" + commentContent + ")");

		clickAndWait("//ul[@id='article-comments-ul']" +
				"/li[1 and contains(@class,'SpeechBubble')]" +
				"//a[@class='article-comm-delete']");

		clickAndWait("wpConfirmB");

		// check if the comment and replies were deleted
		assertTrue(!session().isElementPresent("//ul[@id='article-comments-ul']" +
				"//p[contains(text(), '" + commentContent + "')]"));
		assertTrue(!session().isElementPresent("//ul[@id='article-comments-ul']" +
				"//p[contains(text(), 'reply 1(" + commentContent + "')]"));
		assertTrue(!session().isElementPresent("//ul[@id='article-comments-ul']" +
				"//p[contains(text(), 'reply 2(" + commentContent + "')]"));
	}

	// tests for blog pages comments
	@Test(groups={"CI", "verified"})
	public void testn14CommentSection() throws Exception {
		loginAsStaff();
		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);

		assertTrue(session().isElementPresent("WikiaArticleComments"));

	}

	@Test(groups={"CI", "broken"})
	public void testo15ShowAllComments() throws Exception {
		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);
		waitForElement("article-comm");
		
		Number numberOfComments = session().getXpathCount("//li[contains(@class,'SpeechBubble')]");
		
		if (numberOfComments.intValue() <= articleCommentsMaxPerPage) {
			for (int i = 0; i < articleCommentsMaxPerPage + 1; i++) {
				addComment("comment " + i + ": " + new Date().toString());
			}
		}

		session().refresh();
		session().waitForPageToLoad(this.getTimeout());

		assertTrue(session().isElementPresent("//div[contains(@class, 'article-comments-pagination')]//a"));

		clickAndWait("link=Show all");
		assertFalse(session().isElementPresent("//div[contains(@class, 'article-comments-pagination')]//a"));
	}

	@Test(groups={"CI", "verified"})
	public void testp16NumberOfComments() throws Exception {
		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);

		openAndWait("/wiki/User_blog:" + getTestConfig().getString("ci.user.wikiastaff.username") + "/" + blogPostName + "?showall=1");

		Number numberOfComments = session().getXpathCount("//ul[@id='article-comments-ul']//li[contains(@class, 'SpeechBubble')]");

		if (numberOfComments.intValue() == 0) {
			String commentContent = "test comment: " + new Date().toString();
			addComment(commentContent);
			numberOfComments = session().getXpathCount("//ul[@id='article-comments-ul']//li[contains(@class, 'SpeechBubble')]");
		}

		String articleCommentHeader = session().getText("//h1[@id='article-comments-counter-header']");

		String stringToCompare = numberOfComments + " comments";
		assertEquals(articleCommentHeader, stringToCompare);
	}
		
	@Test(groups={"CI", "verified"})
	public void testq17AddComment() throws Exception {
		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);
		waitForElement("article-comm");

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		assertTrue(session().isElementPresent("//ul[@id='article-comments-ul']" +
			"/li[contains(@class, 'SpeechBubble')]//p[contains(text(), '" + commentContent + "')]"));
	}

	@Test(groups={"CI", "verified"})
	public void pre19EditButtonPresence() throws Exception {
		loginAsStaff();
		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName_1);
		logout();
	}

	@Test(groups={"CI", "verified"}, dependsOnMethods={"pre19EditButtonPresence"})
	public void tests19EditButtonPresence() throws Exception {
		// Re-open in showall mode.
		loginAsRegular();
		openAndWait("/wiki/User_blog:WikiaStaff/Blog_post_number_1?showall=1");

		Number numberOfComments = session().getXpathCount("//ul[@id='article-comments-ul']//li[contains(@class, 'SpeechBubble')]");

		if (numberOfComments.intValue() == 0) {
			String commentContent = "test comment: " + new Date().toString();
			addComment(commentContent);
		}

		numberOfComments = session().getXpathCount("//ul[@id='article-comments-ul']//li[contains(@class, 'SpeechBubble')]");

		for (int i = 1; i < numberOfComments.intValue() + 1; i++) {
			String commentId = session().getAttribute("//ul[@id='article-comments-ul']" +
					"/li[" + i + "]@id");

			// user can edit only his/her own comments
			if (session().isElementPresent("//li[@id='" + commentId + "']//a[contains(text(), '" +
				getTestConfig().getString("ci.user.regular.username") + "')]")) {
				assertFalse(session().isVisible("//li[@id='" + commentId + "']//span[@class='tools']"));

				assertTrue(session().isElementPresent("//li[@id='" + commentId + "']//span[@class='tools']" +
						"/span[@class='edit-link']/a[@class='article-comm-edit']"));
			}

			else {
				assertFalse(session().isElementPresent("//li[@id='" + commentId + "']//a[@class='article-comm-edit']"));
			}
		}
	}

	@Test(groups={"CI", "verified"})
	public void testt20EditBlogComment() throws Exception {
		loginAsRegular();

		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		String id = session().getAttribute("//ul[@id='article-comments-ul']/li[1]@id");
		session().click("//li[@id='" + id + "']" + "//a[@class='article-comm-edit']");

		waitForElement("//li[@id='" + id + "']" + "//textarea[@name='wpArticleComment']");

		session().type("//li[@id='" + id + "']" + "//textarea[@name='wpArticleComment']", "edit(" + commentContent + ")");

		session().click("//li[@id='" + id + "']" + "//input[@name='wpArticleSubmit']");

		waitForElement("//li[@id='" + id + "']" +
						"//div[@class='article-comm-text']" +
						"/p[contains(text(), 'edit(" + commentContent + ")')]");
	}

	@Test(groups={"CI", "verified"},dependsOnMethods={"testt20EditBlogComment"})
	public void testu21StaffEditBlogComment() throws Exception {
		loginAsStaff();

		openAndWait("/wiki/User_blog:" + getTestConfig().getString("ci.user.wikiastaff.username") + "/" + blogPostName + "?showall=1");

		String id = session().getAttribute("//ul[@id='article-comments-ul']/li[1]@id");
		String commentContent = "test comment: " + new Date().toString();

		session().click("//li[@id='" + id + "']" + "//a[@class='article-comm-edit']");

		waitForElement("//li[@id='" + id + "']" + "//textarea[@name='wpArticleComment']");

		session().type("//li[@id='" + id + "']" + "//textarea[@name='wpArticleComment']", "staff edit(" + commentContent + ")");

		session().click("//li[@id='" + id + "']" + "//input[@name='wpArticleSubmit']");

		waitForElement("//li[@id='" + id + "']" +
			"//div[@class='article-comm-text']" +
			"/p[contains(text(), 'staff edit(" + commentContent + ")')]");
	}

	@Test(groups={"CI", "verified"})
	public void testv22HistoryButton() throws Exception {
		loginAsRegular();

		// Ensure it exists
		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);

		// Revisit it
		openAndWait("/wiki/User_blog:" + getTestConfig().getString("ci.user.wikiastaff.username") + "/" + blogPostName);

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		session().click("//ul[@id='article-comments-ul']/li[1]//span[@class='edit-link']/a");

		session().type("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']", "edit(" + commentContent + ")");
		
		session().click("//ul[@id='article-comments-ul']/li[1]//input[@name='wpArticleSubmit' and @value='Post comment']");
		
		waitForElement("//ul[@id='article-comments-ul']/li[1]//a[@class='article-comm-history']");

		logout();

		openAndWait("/wiki/User_blog:" + getTestConfig().getString("ci.user.wikiastaff.username") + "/" + blogPostName);

		assertTrue(session().isElementPresent("//ul[@id='article-comments-ul']/li[1]//a[@class='article-comm-history']"));
	}

	@Test(groups={"CI", "verified"})
	public void testw23ReplyTwice() throws Exception {
		loginAsRegular();

		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);
		waitForElement("article-comm");

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		addReply("reply 1");
		addReply("reply 2");
	}

	@Test(groups={"CI", "verified"})
	public void testx24DeleteComment() throws Exception {
		loginAsStaff();

		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);
		waitForElement("article-comm");

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		clickAndWait("//ul[@id='article-comments-ul']" +
			"/li[1 and contains(@class, 'SpeechBubble')]" +
			"//a[@class='article-comm-delete']");

		clickAndWait("wpConfirmB");

		openAndWait("/wiki/User_blog:" + getTestConfig().getString("ci.user.wikiastaff.username") + "/" + blogPostName);

		assertFalse(session().isElementPresent("//ul[@id='article-comments-ul']//p[contains(text(), '" + commentContent + "')]"));
	}

	@Test(groups={"CI", "verified"})
	public void testy25DeleteCascadeComment() throws Exception {
		loginAsStaff();

		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);
		addReply("reply 1(" + commentContent + ")");
		addReply("reply 2(" + commentContent + ")");

		clickAndWait("//ul[@id='article-comments-ul']" +
				"/li[1 and contains(@class, 'SpeechBubble')]" +
				"//a[@class='article-comm-delete']");

		clickAndWait("wpConfirmB");

		openAndWait("/wiki/User_blog:" + getTestConfig().getString("ci.user.wikiastaff.username") + "/" + blogPostName);

		// check if the comment and replies were deleted
		assertFalse(session().isTextPresent(commentContent));
		assertFalse(session().isTextPresent("reply 1(" + commentContent + ")"));
		assertFalse(session().isTextPresent("reply 2(" + commentContent + ")"));
	}
}
