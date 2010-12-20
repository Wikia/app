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

import org.testng.annotations.Test;
import com.thoughtworks.selenium.SeleniumException;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

/**
 * To enable the extension used by this test, in LocalSettings.php or WikiFactory, set:
 * $wgEnableArticleCommentsExt = true;
 * $wgArticleCommentsMaxPerPage = 5; // the default varies (right now it's 20 in production and 25 on dev boxes).
 */
public class ArticleCommentTest extends BaseTest {

	public static int articleCommentsMaxPerPage = 25; // = $wgArticleCommentsMaxPerPage
	public static String articlePath = "index.php?title=Special:Random";
	public static String blogPostName = "Blog_post_number_2";
	public static String blogPostName_1 = "Blog_post_number_1";
	
	/**
	 * Opens a page. If that page doesn't exist yet, instead of just 404ing, will
	 * create the page with some default text.
	 */
	private void openOrCreatePage(String pageName) throws Exception {
		try{
			session().open(pageName);
			session().waitForPageToLoad(TIMEOUT);
		} catch(SeleniumException e){
			session().open(pageName + "&action=edit");
			session().waitForPageToLoad(TIMEOUT);
			waitForElement("wpTextbox1");
			waitForElement("wpSave");
			doEdit("Test page content");
			session().click("wpSave");
			session().waitForPageToLoad(TIMEOUT);
			session().open(pageName);
			session().waitForPageToLoad(TIMEOUT);
		}
	}

	/**
	 * Opens a page. If that page doesn't exist yet, instead of just 404ing, will
	 * create the page with some default text.
	 */
	private void openOrCreateBlogPage(String username, String blogPostName) throws Exception {
		String pageName = "index.php?title=User_blog:"+username+"/"+blogPostName;
		try{
			session().open(pageName);
		} catch(SeleniumException e){
			// Page might not exist yet.
			loginAsStaff();
			session().open("index.php?title=Special:CreateBlogPage");
			session().waitForPageToLoad(TIMEOUT);
			waitForElement("wpTextbox1");
			waitForElement("wpSave");
			session().type("blogPostTitle", blogPostName);
			doEdit("Test page content");
			session().click("wpSave");
			session().waitForPageToLoad(TIMEOUT);
			session().open(pageName);
		}

		session().waitForPageToLoad(TIMEOUT);
	}

	private void addComment(String commentContent) throws Exception {
		session().type("article-comm", commentContent);
		session().click("article-comm-submit");

		waitForElement("//ul[@id='article-comments-ul']" +
						"/li[1 and contains(@class,'article-comments-li')]" +
						"//div[@class='article-comm-text']" +
						"/p[contains(text(), '" + commentContent + "')]");
	}

	private void addReply(String replyContent) throws Exception {
		if(isOasis()){
			session().click("//ul[@id='article-comments-ul']" +
				"/li[1 and contains(@class,'article-comments-li')]" +
				"//a[contains(@class, 'article-comm-reply')]");
			waitForElement("//ul[@id='article-comments-ul']" +
				"/li[1 and contains(@class,'article-comments-li')]" +
				"//textarea[@name='wpArticleReply']");

			session().type("//ul[@id='article-comments-ul']" +
				"/li[1 and contains(@class,'article-comments-li')]" +
				"//textarea[@name='wpArticleReply']", replyContent);

			session().click("//ul[@id='article-comments-ul']" +
				"/li[1 and contains(@class,'article-comments-li')]" +
				"//input[@name='wpArticleSubmit' and @value='Post comment']");

			waitForElement("//ul[@id='article-comments-ul']" +
				"/ul[@class='sub-comments']/li[1 and contains(@class,'article-comments-li')]" +
				"//div[@class='article-comm-text']" +
				"/p[contains(text(), '" + replyContent + "')]");
		} else {
			session().click("//ul[@id='article-comments-ul']" +
					"/li[@class='article-comments-li article-comments-row-odd " +
					"article-comment-first clearfix']/div/div[@class='comment']" +
					"/div[@class='buttons']/a[@class='article-comm-reply wikia-button secondary']");

			session().type("//ul[@id='article-comments-ul']" +
					"/li[@class='article-comments-li article-comments-row-odd " +
					"article-comment-first clearfix']/div/div[@class='comment']" +
					"/div[@class='clearfix']/div/form/div" +
					"/textarea[@name='wpArticleReply']", replyContent);
	
			session().click("//ul[@id='article-comments-ul']" +
					"/li[@class='article-comments-li article-comments-row-odd " +
					"article-comment-first clearfix']/div/div[@class='comment']" +
					"/div[@class='clearfix']/div/form/div" +
					"/input[@name='wpArticleSubmit' and @value='Post comment']");
		}
	}

	// tests for article comments

	@Test(groups={"CI"})
	public void testa1CommentSection() throws Exception {
		//System.out.println("Starting testa1CommentSection...");
		session().open(articlePath);
		session().waitForPageToLoad(TIMEOUT);

		assertTrue(session().isElementPresent("WikiaArticleComments"));
	}

	@Test(groups={"CI"})
	public void testb2ShowAllComments() throws Exception {
		//System.out.println("Starting testb2ShowAllComments...");
		session().open(articlePath);
		session().waitForPageToLoad(TIMEOUT);

		// adding (articleCommentsMaxPerPage + 1) comments
		for (int i = 0; i < articleCommentsMaxPerPage + 1; i++)
			addComment("comment " + i + ": " + new Date().toString());

		session().refresh();
		session().waitForPageToLoad(TIMEOUT);
		
		String location = session().getLocation();
		//System.out.println(location);
		session().open(location);
		session().waitForPageToLoad(TIMEOUT);
		
		assertTrue(session().isElementPresent("//div[contains(@class,'article-comments-pagination')]//a"));

		if(isOasis()){
			session().click("link=Show all");
		} else {
			session().click("link=Show all comments");
		}
		session().waitForPageToLoad(TIMEOUT);

		assertFalse(session().isElementPresent("//div[contains(@class,'article-comments-pagination')]//a"));
	}

	@Test(groups={"CI"})
	public void testc3NumberOfComments() throws Exception {
		//System.out.println("Starting testc3NumberOfComments...");
		session().open(articlePath + "&showall=1");

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		Number numberOfComments = session().getXpathCount("//li[contains(@class,'article-comments-li')]");
		//System.out.println("Counted comments: " + numberOfComments);

		String articleCommentHeader = session().getText("//h1[@id='article-comments-counter-header']");
		//System.out.println("Article comment header: " + articleCommentHeader);

		String stringToCompare = numberOfComments + " comments";
		assertTrue(articleCommentHeader.equals(stringToCompare));
	}

	@Test(groups={"CI"})
	public void testd4AddComment() throws Exception {
		//System.out.println("Starting testd4AddComment...");
		session().open(articlePath);
		session().waitForPageToLoad(TIMEOUT);

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);
	}

	@Test(groups={"CI"})
	public void testf6EditButtonPresence() throws Exception {
		//System.out.println("Starting testf6EditButtonPresence...");
		loginAsRegular();

		session().open(articlePath + "&showall=1");
		session().waitForPageToLoad(TIMEOUT);

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		Number numberOfComments = session().getXpathCount("//li[contains(@class,'article-comments-li')]");
		//System.out.println("Counted comments: " + numberOfComments);

		for (int i = 1; i < numberOfComments.intValue() + 1; i++) {
			String commentId = session().getAttribute("//ul[@id='article-comments-ul']" +
					"/li[" + i + "]@id");
			// user can edit only his/her own comments
			if (session().isElementPresent("//li[@id='" + commentId + "']//a[contains(text(), '" +
				getTestConfig().getString("ci.user.regular.username") + "')]")) {
				assertFalse(session().isVisible("//li[@id='" + commentId + "']//span[@class='tools']"));
				assertTrue(session().isElementPresent("//li[@id='" + commentId + "']//span[@class='tools']" +
						"/span[@class='edit-link']/a[@class='article-comm-edit']"));
				//System.out.println(commentId + ": edit button present");
			}
			else {
				assertFalse(session().isElementPresent("//li[@id='" + commentId + "']//a[@class='article-comm-edit']"));
			}
		}
	}

	@Test(groups={"CI"})
	public void testg7EditionOfComment() throws Exception {
		//System.out.println("Starting testg7EditionOfComment...");
		loginAsRegular();

		session().open(articlePath);
		session().waitForPageToLoad(TIMEOUT);

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		assertTrue(session().isVisible("//ul[@id='article-comments-ul']/li[1]" +
				"//a[@class='article-comm-edit']"));
		
		session().click("//ul[@id='article-comments-ul']/li[1]" +
				"//a[@class='article-comm-edit']");

		waitForElement("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']");

		session().type("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']", "edition(" + commentContent + ")");

		session().click("//ul[@id='article-comments-ul']/li[1]//input[@name='wpArticleSubmit']");

		waitForElement("//ul[@id='article-comments-ul']" +
						"/li[1 and contains(@class,'article-comments-li')]" +
						"//div[@class='article-comm-text']" +
						"/p[contains(text(), 'edition(" + commentContent + ")')]");
	}

	@Test(groups={"CI"})
	public void testh8StaffEditionOfComment() throws Exception {
		loginAsRegular();

		session().open(articlePath);
		session().waitForPageToLoad(TIMEOUT);
		
		String location = session().getLocation();

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		session().click("//ul[@id='article-comments-ul']/li[1]" +
				"//a[@class='article-comm-edit']");

		waitForElement("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']");

		session().type("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']", "edition(" + commentContent + ")");

		session().click("//ul[@id='article-comments-ul']/li[1]//input[@name='wpArticleSubmit']");

		waitForElement("//ul[@id='article-comments-ul']" +
						"/li[1 and contains(@class,'article-comments-li')]" +
						"/p[contains(text(), 'edition(" + commentContent + ")')]");

		logout();
		loginAsStaff();
		session().open(location);
		session().waitForPageToLoad(TIMEOUT);

		session().click("//ul[@id='article-comments-ul']/li[1]" +
				"//a[@class='article-comm-edit']");

		waitForElement("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']");

		session().type("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']", "edition(" + commentContent + ")");

		session().click("//ul[@id='article-comments-ul']/li[1]//input[@name='wpArticleSubmit']");

		waitForElement("//ul[@id='article-comments-ul']" +
						"/li[1 and contains(@class,'article-comments-li')]" +
						"//div[@class='article-comm-text']" +
						"/p[contains(text(), 'edition(" + commentContent + ")')]");
	}

	@Test(groups={"CI"})
	public void testi9HistoryButton() throws Exception {
		//System.out.println("Starting testi9HistoryButton...");
		loginAsRegular();
		
		String pageToUse = "index.php?title=Test_3";
		openOrCreatePage(pageToUse);

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		session().click("//ul[@id='article-comments-ul']/li[1]" +
				"//a[@class='article-comm-edit']");

		waitForElement("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']");

		session().type("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']", "edition(" + commentContent + ")");

		session().click("//ul[@id='article-comments-ul']/li[1]//input[@name='wpArticleSubmit']");

		waitForElement("//ul[@id='article-comments-ul']" +
						"/li[1 and contains(@class,'article-comments-li')]" +
						"/p[contains(text(), 'edition(" + commentContent + ")')]");

		assertTrue(session().isElementPresent("//ul[@id='article-comments-ul']/li[1]//a[@class='article-comm-history']"));

		logout();

		session().open(pageToUse);
		session().waitForPageToLoad(TIMEOUT);


		assertTrue(session().isElementPresent("//ul[@id='article-comments-ul']/li[1]//a[@class='article-comm-history']"));
	}

	@Test(groups={"CI"})
	public void testj10ReplyTwice() throws Exception {
		//System.out.println("Starting testj10ReplyTwice...");
		loginAsRegular();

		session().open(articlePath);
		session().waitForPageToLoad(TIMEOUT);
		
		//System.out.println(session().getLocation());

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		addReply("reply 1");
		addReply("reply 2");
	}

	@Test(groups={"CI"})
	public void testk11DeleteComment() throws Exception {
		//System.out.println("Starting testk11DeleteComment...");
		loginAsStaff();

		session().open(articlePath);
		session().waitForPageToLoad(TIMEOUT);
		waitForElement("article-comm");

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		session().click("//ul[@id='article-comments-ul']" +
				"/li[1 and contains(@class, 'article-comments-li')]" +
				"//a[@class='article-comm-delete']");
		session().waitForPageToLoad(TIMEOUT);

		session().click("wpConfirmB");
		session().waitForPageToLoad(TIMEOUT);

		// check if the comment was deleted
		assertFalse(session().isElementPresent("//ul[@id='article-comments-ul']" +
				"/li[contains(@class,'article')]" +
				"//p[contains(text(), '" + commentContent + "')]"));
	}

	@Test(groups={"CI"})
	public void testl12DeleteCascadeComment() throws Exception {
		//System.out.println("Starting testl12DeleteCascadeComment...");
		loginAsStaff();

		session().open(articlePath);
		session().waitForPageToLoad(TIMEOUT);
		waitForElement("article-comm");

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);
		addReply("reply 1(" + commentContent + ")");
		addReply("reply 2(" + commentContent + ")");

		session().click("//ul[@id='article-comments-ul']" +
				"/li[1 and contains(@class,'article-comments-li')]" +
				"//a[@class='article-comm-delete']");
		session().waitForPageToLoad(TIMEOUT);

		session().click("wpConfirmB");
		session().waitForPageToLoad(TIMEOUT);

		// check if the comment and replies were deleted
		assertTrue(!session().isElementPresent("//ul[@id='article-comments-ul']" +
				"//p[contains(text(), '" + commentContent + "')]"));
		assertTrue(!session().isElementPresent("//ul[@id='article-comments-ul']" +
				"//p[contains(text(), 'reply 1(" + commentContent + "')]"));
		assertTrue(!session().isElementPresent("//ul[@id='article-comments-ul']" +
				"//p[contains(text(), 'reply 2(" + commentContent + "')]"));
	}

	// tests for blog pages comments

	@Test(groups={"CI"})
	public void testn14CommentSection() throws Exception {
		//System.out.println("Starting testn14CommentSection...");
		
		loginAsStaff();
		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);

		assertTrue(session().isElementPresent("WikiaArticleComments"));
	}

	@Test(groups={"CI"})
	public void testo15ShowAllComments() throws Exception {
		//System.out.println("Starting testo15ShowAllComments...");
		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);
		waitForElement("article-comm");
		
		Number numberOfComments = session().getXpathCount("//li[contains(@class,'article-comments-li')]");
		
		if (numberOfComments.intValue() <= articleCommentsMaxPerPage) {
			for (int i = 0; i < articleCommentsMaxPerPage + 1; i++) {
				addComment("comment " + i + ": " + new Date().toString());
			}
		}

		session().refresh();
		session().waitForPageToLoad(TIMEOUT);

		assertTrue(session().isElementPresent("//div[contains(@class, 'article-comments-pagination')]//a"));

		if(isOasis()){
			session().click("link=Show all");
		} else {
			session().click("link=Show all comments");
		}
		session().waitForPageToLoad(TIMEOUT);

		assertFalse(session().isElementPresent("//div[contains(@class, 'article-comments-pagination')]//a"));
	}

	@Test(groups={"CI"})
	public void testp16NumberOfComments() throws Exception {
		//System.out.println("Starting testp16NumberOfComments...");
		
		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);

		session().open("/wiki/User_blog:" + getTestConfig().getString("ci.user.wikiastaff.username") + "/" + blogPostName + "?showall=1");

		Number numberOfComments;
		if(isOasis()){
			numberOfComments = session().getXpathCount("//ul[@id='article-comments-ul']//li[contains(@class, 'article-comments-li')]");
		} else {
			numberOfComments = session().getXpathCount("//div[@class='article-comments']");
		}
		//System.out.println("Counted comments: " + numberOfComments);

		if (numberOfComments.intValue() == 0) {
			String commentContent = "test comment: " + new Date().toString();
			addComment(commentContent);
		}

		String articleCommentHeader;
		if(isOasis()){
			articleCommentHeader = session().getText("//h1[@id='article-comments-counter-header']");
		} else {
			articleCommentHeader = session().getText("//div[@id='article-comments-wrapper']/h2/span");
		}
		//System.out.println("Article comment header: " + articleCommentHeader);

		String stringToCompare;
		if(isOasis()){
			stringToCompare = numberOfComments + " comments";
		} else {
			stringToCompare = "Comments (" + numberOfComments + ")";
		}
		assertTrue(articleCommentHeader.equals(stringToCompare));
	}

	@Test(groups={"CI"})
	public void testq17AddComment() throws Exception {
		//System.out.println("Starting testq17AddComment...");
		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);
		waitForElement("article-comm");

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		if(isOasis()){
			assertTrue(session().isElementPresent("//ul[@id='article-comments-ul']" +
				"/li[contains(@class, 'article-comments-li')]//p[contains(text(), '" + commentContent + "')]"));
		} else {
			assertTrue(session().isElementPresent("//ul[@id='article-comments-ul']" +
					"/li[@class='article-comments-li article-comments-row-odd " +
					"article-comment-first clearfix']/div[@class='article-comments']" +
					"/div[@class='comment']/div/p[contains(text(), '" + commentContent + "')]"));
		}
	}

	@Test
	public void pre19EditButtonPresence() throws Exception {
		loginAsStaff();
		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName_1);
		logout();
	}

	@Test(groups={"CI"}, dependsOnMethods={"pre19EditButtonPresence"})
	public void tests19EditButtonPresence() throws Exception {
		//System.out.println("Starting tests19EditButtonPresence...");

		// Re-open in showall mode.
		loginAsRegular();
		session().open("/wiki/User_blog:WikiaStaff/Blog_post_number_1?showall=1");
		session().waitForPageToLoad(TIMEOUT);

		Number numberOfComments = session().getXpathCount("//ul[@id='article-comments-ul']//li[contains(@class, 'article-comments-li')]");

		if (numberOfComments.intValue() == 0) {
			String commentContent = "test comment: " + new Date().toString();
			addComment(commentContent);
		}

		numberOfComments = session().getXpathCount("//ul[@id='article-comments-ul']//li[contains(@class, 'article-comments-li')]");
		//System.out.println("Counted comments: " + numberOfComments);

		for (int i = 1; i < numberOfComments.intValue() + 1; i++) {
			String commentId = session().getAttribute("//ul[@id='article-comments-ul']" +
					"/li[" + i + "]@id");

			// user can edit only his/her own comments
			if (session().isElementPresent("//li[@id='" + commentId + "']//a[contains(text(), '" +
				getTestConfig().getString("ci.user.regular.username") + "')]")) {
				assertFalse(session().isVisible("//li[@id='" + commentId + "']//span[@class='tools']"));

				assertTrue(session().isElementPresent("//li[@id='" + commentId + "']//span[@class='tools']" +
						"/span[@class='edit-link']/a[@class='article-comm-edit']"));
				//System.out.println(commentId + ": edit button present");
			}

			else {
				assertFalse(session().isElementPresent("//li[@id='" + commentId + "']//a[@class='article-comm-edit']"));
			}
		}
	}

	@Test(groups={"CI"})
	public void testt20EditionOfComment() throws Exception {
		//System.out.println("Starting testt20EditionOfComment...");
		loginAsRegular();

		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		String id = session().getAttribute("//ul[@id='article-comments-ul']/li[1]@id");
		session().click("//li[@id='" + id + "']" + "//a[@class='article-comm-edit']");

		waitForElement("//li[@id='" + id + "']" + "//textarea[@name='wpArticleComment']");

		session().type("//li[@id='" + id + "']" + "//textarea[@name='wpArticleComment']", "edition(" + commentContent + ")");

		session().click("//li[@id='" + id + "']" + "//input[@name='wpArticleSubmit']");

		waitForElement("//li[@id='" + id + "']" +
						"//div[@class='article-comm-text']" +
						"/p[contains(text(), 'edition(" + commentContent + ")')]");
	}

	@Test(groups={"CI"},dependsOnMethods={"testt20EditionOfComment"})
	public void testu21StaffEditionOfComment() throws Exception {
		//System.out.println("Starting testu21StaffEditionOfComment...");
		loginAsStaff();

		session().open("/wiki/User_blog:" + getTestConfig().getString("ci.user.wikiastaff.username") + "/" + blogPostName + "?showall=1");
		session().waitForPageToLoad(TIMEOUT);

		String id = session().getAttribute("//ul[@id='article-comments-ul']/li[1]@id");
		String commentContent = "test comment: " + new Date().toString();

		session().click("//li[@id='" + id + "']" + "//a[@class='article-comm-edit']");

		waitForElement("//li[@id='" + id + "']" + "//textarea[@name='wpArticleComment']");

		session().type("//li[@id='" + id + "']" + "//textarea[@name='wpArticleComment']", "staff edition(" + commentContent + ")");

		session().click("//li[@id='" + id + "']" + "//input[@name='wpArticleSubmit']");

		waitForElement("//li[@id='" + id + "']" +
			"//div[@class='article-comm-text']" +
			"/p[contains(text(), 'staff edition(" + commentContent + ")')]");
	}

	@Test(groups={"CI"})
	public void testv22HistoryButton() throws Exception {
		//System.out.println("Starting testv22HistoryButton...");

		loginAsRegular();

		// Ensure it exists
		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);

		// Revisit it
		session().open("/wiki/User_blog:" + getTestConfig().getString("ci.user.wikiastaff.username") + "/" + blogPostName);
		session().waitForPageToLoad(TIMEOUT);

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		session().click("//ul[@id='article-comments-ul']/li[1]//span[@class='edit-link']/a");

		session().type("//ul[@id='article-comments-ul']/li[1]//textarea[@name='wpArticleComment']", "edition(" + commentContent + ")");
		
		session().click("//ul[@id='article-comments-ul']/li[1]//input[@name='wpArticleSubmit' and @value='Post comment']");
		
		waitForElement("//ul[@id='article-comments-ul']/li[1]//a[@class='article-comm-history']");

		logout();

		session().open("/wiki/User_blog:" + getTestConfig().getString("ci.user.wikiastaff.username") + "/" + blogPostName);
		session().waitForPageToLoad(TIMEOUT);

		assertTrue(session().isElementPresent("//ul[@id='article-comments-ul']/li[1]//a[@class='article-comm-history']"));
	}

	@Test(groups={"CI"})
	public void testw23ReplyTwice() throws Exception {
		//System.out.println("Starting testw23ReplyTwice...");
		
		loginAsRegular();

		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);
		session().waitForPageToLoad(TIMEOUT);

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		addReply("reply 1");
		addReply("reply 2");
	}

	@Test(groups={"CI"})
	public void testx24DeleteComment() throws Exception {
		//System.out.println("Starting testx24DeleteComment...");
		loginAsStaff();

		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);
		waitForElement("article-comm");

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);

		if(isOasis()){
			session().click("//ul[@id='article-comments-ul']" +
				"/li[1 and contains(@class, 'article-comments-li')]" +
				"//a[@class='article-comm-delete']");
		} else {
			session().click("//ul[@id='article-comments-ul']" +
					"/li[@class='article-comments-li article-comments-row-odd " +
					"article-comment-first clearfix']/div/div[@class='comment']" +
					"/div[@class='buttons']/span/a[@class='article-comm-delete']");
		}
		session().waitForPageToLoad(TIMEOUT);

		session().click("wpConfirmB");
		session().waitForPageToLoad(TIMEOUT);

		session().open("/wiki/User_blog:" + getTestConfig().getString("ci.user.wikiastaff.username") + "/" + blogPostName);
		session().waitForPageToLoad(TIMEOUT);

		if(isOasis()){
			// opposite of normal... make sure it ISN'T there.
			assertFalse(session().isElementPresent("//ul[@id='article-comments-ul']//p[contains(text(), '" + commentContent + "')]"));
		} else {
			// opposite of normal... make sure it ISN'T there.
			assertTrue(!session().isElementPresent("//ul[@id='article-comments-ul']" +
					"/li[@class='article-comments-li article-comments-row-odd " +
					"article-comment-first clearfix']/div[@class='article-comments']" +
					"/div[@class='comment']/div" +
					"/p[contains(text(), '" + commentContent + "')]"));
		}
	}

	@Test(groups={"CI"})
	public void testy25DeleteCascadeComment() throws Exception {
		//System.out.println("Starting testy25DeleteCascadeComment...");
		loginAsStaff();

		openOrCreateBlogPage(getTestConfig().getString("ci.user.wikiastaff.username"), blogPostName);

		String commentContent = "test comment: " + new Date().toString();
		addComment(commentContent);
		addReply("reply 1(" + commentContent + ")");
		addReply("reply 2(" + commentContent + ")");

		session().click("//ul[@id='article-comments-ul']" +
				"/li[1 and contains(@class, 'article-comments-li')]" +
				"//a[@class='article-comm-delete']");
		session().waitForPageToLoad(TIMEOUT);

		session().click("wpConfirmB");
		session().waitForPageToLoad(TIMEOUT);

		session().open("/wiki/User_blog:" + getTestConfig().getString("ci.user.wikiastaff.username") + "/" + blogPostName);
		session().waitForPageToLoad(TIMEOUT);

		// check if the comment and replies were deleted
		assertFalse(session().isTextPresent(commentContent));
		assertFalse(session().isTextPresent("reply 1(" + commentContent + ")"));
		assertFalse(session().isTextPresent("reply 2(" + commentContent + ")"));
	}
}
