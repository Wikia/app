package com.wikia.selenium.tests;

import java.io.File;
import java.util.Random;
import java.util.Date;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Parameters;
import org.testng.annotations.Test;
import org.testng.annotations.BeforeMethod;
import org.testng.SkipException;

public class PhalanxTest extends BaseTest {

	private static final String uploadFileUrl = "http://images.wikia.com/wikiaglobal/images/b/bc/Wiki.png";

	private String testArticleName = "PhalanxTest";

	// word added to article title
	public static final String badWord = "WikiaTestBlockDontRemoveMe";

	// used for content and summary
	private static final String goodWords = "Wikia test text";
	private static final String badWords = "WikiaTestBadWordDontRemoveMe is a dirty word";

	// used in answers related tests
	private static final String goodQuestion = "Is bar a foo";
	private static final String badQuestion = "Is this a fucking question";

	private static final String filteredQuestionPhrase = "Is this a WikiaTestFilteredPhraseDontRemoveMe";

	// MW message with whitelist
	private static final String whitelistMessage = "MediaWiki:Spam-whitelist";
	private static final String whitelistWord = "WikiaTestBlockDontRemoveMeWhitelisted";

	// did cleanup method have been run?
	private static boolean run = false;

	// used by contentBlockTest tests
	private String blockId;
	private String blockFilter;

	/**
	 * Login on selected testing account (with rights to remove articles)
	 */
	protected void login() throws Exception {
		loginAsSysop();
	}

	/**
 	 * Console logging
 	 */
	private void log(String message) {
		//System.out.println(message);
	}

	/**
	 * Check whether current page is view mode of given article
	 */
	private boolean isArticleViewMode(String articleName) throws Exception {
		String content = session().getHtmlSource();
		String patternTitle = "wgTitle=\"" + articleName + "\"";
		String patternAction = "wgAction=\"view\"";

		return (content.indexOf(patternTitle) > -1 && content.indexOf(patternAction) > -1);
	}

	/**
	 * Delete given article
	 */
	private void deleteArticle(String articleName) throws Exception {
		this.log(" Removing an article: '" + articleName + "'");

		session().open("index.php?action=delete&title=" + articleName);
		session().waitForPageToLoad(this.getTimeout());

		// seems that given article does not exist
		if (!session().isElementPresent("wpDeleteReasonList")) {
			return;
		}

		session().select("wpDeleteReasonList", "label=regexp:^.*Author request");
		session().type("wpReason", "Cleanup after Phalanx test");
		session().uncheck("wpWatch");
		session().click("wpConfirmB");
		session().waitForPageToLoad(this.getTimeout());
	}

	/**
	 * Delete given image
	 */
	private void deleteImage(String imageName) throws Exception {
		this.log(" Removing an image: '" + imageName + "'");

		session().open("index.php?title=File:" + imageName);
		session().waitForPageToLoad(this.getTimeout());

		clickAndWait("//a[@data-id='delete']");

		session().type("wpReason", "this was for test");
		session().uncheck("wpWatch");
		clickAndWait("mw-filedelete-submit");

		assertTrue(session().isTextPresent(imageName + "\" has been deleted."));
	}

	/**
	 * Ask question using new answers skin and verify whether it's blocked or not
	 */
	private boolean askQuestion(String question) throws Exception {
		this.log(" Asking a question: '" + question + "'");

		session().open("index.php");
		session().waitForPageToLoad(this.getTimeout());

		// ask question (usage of new answers skin is assumed here)
		session().type("answers_ask_field", question);
		session().click("ask_button");
		session().waitForPageToLoad(this.getTimeout());

		// return true if article creation was successful
		return this.isArticleViewMode(question);
	}

	/**
	 * Ask question using new answers skin and verify whether it's on list of recenlty asked (via HomePageList)
	 */
	private boolean askQuestionAndCheckHPL(String question) throws Exception {
		this.log(" Asking a question: '" + question + "'");

		session().open("index.php");
		session().waitForPageToLoad(this.getTimeout());

		// ask question (usage of new answers skin is assumed here)
		session().type("answers_ask_field", question);
		session().click("ask_button");
		session().waitForPageToLoad(this.getTimeout());

		assertTrue(this.isArticleViewMode(question));

		// check HomePageList
		return this.isQuestionOnListOfRecentlyAsked(question);
	}

	/**
	 * Check whether given question is on list of recent unanswered questions
	 */
	private boolean isQuestionOnListOfRecentlyAsked(String question) throws Exception {
		session().open("index.php?smaxage=1&action=ajax&rs=HomePageListAjax&method=recent_unanswered_questions");
		session().waitForPageToLoad(this.getTimeout());

		String content = session().getHtmlSource();
		String pattern = ">" + question + "?</a></li>";

		return (content.indexOf(pattern) > -1);
	}

	/**
	 * Create an article and verify whether it's blocked or not
	 */
	private boolean createArticle(String articleName, String articleContent) throws Exception {
		return this.createArticle(articleName, articleContent, "");
	}

	/**
	 * Create an article (with summary) and verify whether it's blocked or not
	 */
	private boolean createArticle(String articleName, String articleContent, String articleSummary) throws Exception {
		openAndWait("index.php?title=" + articleName + "&action=edit&useeditor=mediawiki");

		doEdit(articleContent);

		if (articleSummary != "") {
			session().type("//textarea[@id='wpSummary']", articleSummary);
		}

		doSave();

		// check for spam filter message when editing an article
		if (session().isTextPresent("triggered our spam filter") && !this.isArticleViewMode(articleName)) {
			return false;
		}

		return true;
	}

	/**
	 * Move an article and verify whether it's blocked or not
	 */
	private boolean moveArticle(String oldName, String newName) throws Exception {
		// let's create test article
		editArticle(oldName, "Phalanx test article");
		assertTrue(this.isArticleViewMode(oldName));

		// try to move it
		openAndWait("index.php?title=Special:MovePage/" + oldName);

		session().type("wpNewTitle", newName);
		session().type("wpReason", "Phalanx test");

		if (session().isElementPresent("wpLeaveRedirect")) {
			session().uncheck("wpLeaveRedirect");
		}
		session().uncheck("watch");

		clickAndWait("wpMove");

		if (session().isElementPresent("wpConfirm")) {
			if (session().isElementPresent("wpLeaveRedirect")) {
				session().uncheck("wpLeaveRedirect");
			}
			session().uncheck("watch");
			session().check("wpConfirm");
			clickAndWait("wpDeleteAndMove");
		}

		// check whether move was correct
		if (session().isTextPresent("\"" + oldName + "\" has been renamed \"" + newName + "\"")) {
			return true;
		}

		assertTrue(session().isTextPresent("triggered our spam filter"));

		return false;
	}

	/**
	 * Upload a file and verify whether it's blocked or not
	 */
	private boolean uploadFile(String srcName, String destName) throws Exception {
		// keep file extensions consistent (uploaded image can be either PNG or JPG)
		String srcNameExtension = srcName.substring(srcName.length() - 3, srcName.length());
		destName += "." + srcNameExtension;

		openAndWait("index.php?title=Special:Upload");

		session().attachFile("wpUploadFile", srcName);
		session().type("wpDestFile", destName);
		session().type("wpUploadDescription", "Phalanx test");
		session().uncheck("wpWatchthis");
		clickAndWait("//input[@name='wpUpload']");

		if (session().isTextPresent("Upload warning")) {
			clickAndWait("//input[@name='wpUpload']");
		}

		assertFalse(session().isTextPresent("Upload error"));

		// upload warning - duplicate ...
		if (session().isTextPresent("Upload warning")) {
			clickAndWait("//input[@name='wpUploadIgnoreWarning']");
		}

		assertTrue(session().isTextPresent("Image:" + destName) || session().isTextPresent("File:" + destName));

		return true;
	}

	/**
	 * Test answers creation on answers site
	 *
	 * Hook triggered: CreateDefaultQuestionPageFilter
	 * Tests blocks: TitleBlackList, BadWords
	 */
	@Test(groups={"answers", "CI"})
	public void createAnswersQuestionTest() throws Exception {
		login();

		// ask "good" question
		assertTrue(this.askQuestion(this.goodQuestion));

		// ask "bad" question
		assertFalse(this.askQuestion(this.badQuestion));
	}

	/**
	 * Test recent questions filtering
	 *
	 * Hook triggered: FilterWords
	 * Tests blocks: DefaultQuestion::filterWordsTest
	 */
	@Test(groups={"answers", "CI"})
	public void filterRecentQuestionsTest() throws Exception {
		login();

		// ask question which wont be filtered out
		assertTrue(this.askQuestionAndCheckHPL(this.goodQuestion));

		// ask question which will be filtered out
		assertFalse(this.askQuestionAndCheckHPL(this.filteredQuestionPhrase));
	}

	/**
	 * Test article move
	 *
	 * Hook triggered: AbortMove, SpecialMovepageBeforeMove
	 * Tests blocks: SpamRegex, TitleBlackList
	 */
	@Test(groups={"CI", "legacy"})
	public void articleMoveTest() throws Exception {
		testArticleName = "Phalanx test" + (new Date()).toString();
		
		login();

		// try moving an article using "good" title
		assertTrue(this.moveArticle(testArticleName, testArticleName + "New"));

		// try moving an article using "bad" title
		assertFalse(this.moveArticle(testArticleName, testArticleName + this.badWord + "New"));
	}

	@Test(groups={"CI", "legacy"}, dependsOnMethods={"articleMoveTest"}, alwaysRun=true)
	public void articleMoveCleanupTest() throws Exception {
		loginAsStaff();

		this.deleteArticle(this.testArticleName + "New");
	}

	/**
	 * Test article edit (scan title)
	 *
	 * Hook triggered: EditFilter
	 * Tests blocks: TitleBlackList
	 */
	@Test(groups={"CI", "legacy"})
	public void createArticleTitleTest() throws Exception {
		testArticleName = "Phalanx test" + (new Date()).toString();

		login();

		// try creating an article with "good" title
		assertTrue(this.createArticle(this.testArticleName, this.goodWords));

		// try creating an article with "bad" title
		assertFalse(this.createArticle(this.testArticleName + this.badWord, this.goodWords));
	}
	
	@Test(groups={"CI", "legacy"}, dependsOnMethods={"createArticleTitleTest"}, alwaysRun=true)
	public void createArticleTitleTestCleanup() throws Exception {
		loginAsStaff();

		this.deleteArticle(this.testArticleName);
	}

	/**
	 * Test article edit (scan content)
	 *
	 * Hook triggered: EditFilter
	 * Tests blocks: SpamRegex
	 */
	@Test(groups={"CI", "legacy"})
	public void editArticleContentTest() throws Exception {
		testArticleName = "Phalanx test" + (new Date()).toString();
		
		login();

		// try creating an article with "good" content
		assertTrue(this.createArticle(this.testArticleName, this.goodWords));

		// try creating an article with "bad" content
		assertFalse(this.createArticle(this.testArticleName, this.badWords));

		// perform edit with blocked word in the URL
		assertFalse(this.createArticle(this.testArticleName, "http://www." + this.badWord + ".net"));
	}

	@Test(groups={"CI", "legacy"}, dependsOnMethods={"editArticleContentTest"}, alwaysRun=true)
	public void editArticleContentTestCleanup() throws Exception {
		loginAsStaff();

		this.deleteArticle(this.testArticleName);
	}

	/**
	 * Test article edit (scan summary)
	 *
	 * Hook triggered: EditFilter
	 * Tests blocks: SpamRegex
	 */
	@Test(groups={"CI", "legacy"})
	public void editArticleSummaryTest() throws Exception {
		testArticleName = "Phalanx test" + (new Date()).toString();
		
		login();

		// try creating an article with "good" summary
		assertTrue(this.createArticle(this.testArticleName, this.goodWords, this.goodWords));

		// try creating an article with "bad" summary
		assertFalse(this.createArticle(this.testArticleName, this.goodWords, this.badWords));
	}
	
	@Test(groups={"CI", "legacy"}, dependsOnMethods={"editArticleSummaryTest"}, alwaysRun=true)
	public void editArticleSummaryTestCleanup() throws Exception {
		loginAsStaff();

		this.deleteArticle(this.testArticleName);
	}

	/**
	 * Test file upload (using Special:Upload)
	 *
	 * Hook triggered: UploadForm:BeforeProcessing
	 * Tests blocks: TitleBlackList
	 */
	@Test(groups={"CI","fileUpload","broken"})
	public void fileUploadTest() throws Exception {
		testArticleName = "Phalanx test" + (new Date()).toString();
		
		login();

		// try uploading a file with "good" destination name
		assertTrue(this.uploadFile(uploadFileUrl, this.testArticleName + "Image"));

		// try uploading a file with "bad" destination name - this one should NOT be blocked
		assertTrue(this.uploadFile(uploadFileUrl, this.testArticleName + this.badWord + "Image"));
	}

	@Test(groups={"CI","fileUpload","broken"}, dependsOnMethods={"fileUploadTest"}, alwaysRun=true)
	public void fileUploadTestCleanup() throws Exception {
		loginAsStaff();

		this.deleteImage(this.testArticleName + "Image");
	}

	/**
	 * Test user block (on edit page)
	 *
	 * Hook triggered: GetBlockedStatus
	 * Tests blocks: RegexBlock
	 *
	 * BugId: 18710
	 */
	@Test(groups={"CI", "broken"})
	public void userBlockOnEditPageTest() throws Exception {
		login("TestUserFuck", "fuck");

		openAndWait("index.php?title=User:TestUserFuck&action=edit");

		// user should not be able to save the page
		assertFalse(session().isElementPresent("wpSave"));

		// block info should be shown
		assertTrue(session().isElementPresent("//div[@class='permissions-errors']"));
	}

	/**
	 * Test whitelist
	 *
	 * Tests blocks from ContentBlock group (maintain the execution order of tests below)
	 */
	@Test(groups={"CI", "legacy"})
	public void beforeWhitelistTest() throws Exception {
		testArticleName = "Phalanx test" + (new Date()).toString();
		
		loginAsStaff();

		// edit whitelist - allow "fuck" word
		String whitelist = " #<!-- Phalanx whitelist text --> <pre>\n" +
			this.whitelistWord +
			"\n #</pre> <!-- Phalanx whitelist text -->" + (new Date()).toString();

		editArticle(this.whitelistMessage, whitelist);
	}

	@Test(groups={"CI", "legacy"}, dependsOnMethods={"beforeWhitelistTest"})
	public void whitelistTest() throws Exception {
		login();

		// perform edits with whitelisted domain in URL
		assertTrue(this.createArticle(this.testArticleName, "http://www." + this.whitelistWord + ".net"));
		assertFalse(this.createArticle(this.testArticleName, "https://www.foo.net/" + this.whitelistWord + ".html"));
		assertFalse(this.createArticle(this.testArticleName, this.goodWords + " " + this.whitelistWord));
	}

	@Test(groups={"CI", "legacy"}, dependsOnMethods={"whitelistTest"}, alwaysRun=true)
	public void afterWhitelistTest() throws Exception {
		loginAsStaff();

		// revert last change to whitelist message
		undoLastEdit(this.whitelistMessage, "Cleanup after Phalanx test");
		this.deleteArticle(this.testArticleName);
	}

	/**
	 * Test adding, applying and removing content block via Special:Phalanx
	 */
	@Test(groups={"CI", "legacy"})
	public void contentBlockTest() throws Exception {
		loginAsStaff();

		try {
			openAndWait("index.php?title=Special:Phalanx");
		} catch(Exception e) {
			this.log("Special:Phalanx not enabled on this wiki - skipping this test");
			throw new SkipException("Skip");
		};

		assertTrue(session().isElementPresent("wpPhalanxFilter"));

		// let's create block which will be applied to article content
		Random randomGenerator = new Random();
		this.blockFilter = "<big>Test / \\ Block" + Integer.toString(randomGenerator.nextInt(666)) + "</big>";
		String blockReason = "Phalanx test block";

		// fill-in the form
		session().type("wpPhalanxFilter", this.blockFilter);
		session().check("wpPhalanxTypeContent");
		session().type("wpPhalanxReason", blockReason);
		session().click("wpPhalanxSubmit");
		Thread.sleep(2000);

		// refresh the page
		openAndWait("index.php?title=Special:Phalanx");

		// get ID of added block
		this.blockId = session().getAttribute("//li[contains(@id, 'phalanx-block-')]/b[text() = '" + this.blockFilter + "']/..@id");
		this.blockId = this.blockId.substring(14, this.blockId.length());

		// check whether new block is on the list
		assertTrue(session().isTextPresent(this.blockFilter));
	}

	@Test(groups={"CI", "legacy"}, dependsOnMethods={"contentBlockTest"})
	public void contentBlockApplyTest() throws Exception {
		testArticleName = "Phalanx test" + (new Date()).toString();
		
		login();

		assertFalse(this.createArticle(this.testArticleName, this.goodWords + " " + this.blockFilter));
	}

	@Test(groups={"CI", "legacy"}, dependsOnMethods={"contentBlockApplyTest"})
	public void contentBlockStatsTest() throws Exception {
		// test stats page
		loginAsStaff();

		openAndWait("index.php?title=Special:PhalanxStats/" + this.blockId);

		assertTrue(session().isElementPresent("phalanx-block-" + this.blockId + "-stats"));

		// remove the block (assume it's the first one on the list)
		openAndWait("index.php?title=Special:Phalanx");

		clickAndWait("//li[@id='phalanx-block-" + this.blockId + "']/a[@class='unblock']");

		// refresh the page
		openAndWait("index.php?title=Special:Phalanx");

		// check whether block is not on the list
		assertFalse(session().isTextPresent(this.blockFilter));
	}

	@Test(groups={"CI", "legacy"}, dependsOnMethods={"contentBlockStatsTest"})
	public void contentBlockAfterRemovalTest() throws Exception {
		login();

		assertTrue(this.createArticle(this.testArticleName, this.goodWords + " " + this.blockFilter));
	}
}
