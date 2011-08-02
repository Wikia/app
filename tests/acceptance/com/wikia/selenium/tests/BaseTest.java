package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.closeSeleniumSession;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.startSeleniumSession;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertEquals;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStream;
import java.math.BigInteger;
import java.net.URL;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.Date;

import org.testng.annotations.AfterMethod;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Parameters;

import com.thoughtworks.selenium.SeleniumException;

import org.apache.commons.configuration.Configuration;
import org.apache.commons.configuration.ConfigurationException;
import org.apache.commons.configuration.XMLConfiguration;

/**
 * Base class for all tests in Selenium Grid Java examples.
 */
public class BaseTest {
	// can not be PNG and must be larger than 2kB
	protected static final String DEFAULT_UPLOAD_IMAGE_URL = "http://www.google.com/logos/chopin10-hp.gif";
	protected String seleniumHost;
	protected int    seleniumPort;
	protected String browser;
	protected String webSite;
	protected String timeout;
	protected String noCloseAfterFail;
	private XMLConfiguration testConfig;

	public XMLConfiguration getTestConfig() throws Exception{
		if (null == this.testConfig) {
			File file = new File(System.getenv("TESTSCONFIG"));
			if (null != file) {
				this.testConfig = new XMLConfiguration(file);
			}
		}
		return this.testConfig;
	}

	@BeforeMethod(alwaysRun = true)
	@Parameters( { "seleniumHost", "seleniumPort", "browser", "webSite", "timeout", "noCloseAfterFail" })
	protected void startSession(String seleniumHost, int seleniumPort,
			String browser, String webSite, String timeout, String noCloseAfterFail) throws Exception {
		this.seleniumHost = seleniumHost;
		this.seleniumPort = seleniumPort;
		this.browser = browser;
		this.webSite = webSite;
		this.noCloseAfterFail = noCloseAfterFail;
		this.setTimeout(timeout);
		startSeleniumSession(seleniumHost, seleniumPort, browser, webSite);
		session().setTimeout(timeout);
		session().setSpeed("1000");

	}

	@AfterMethod(alwaysRun = true)
	protected void closeSession() throws Exception {
		if (isLoggedIn()) {
			logout();
		}
		
		if (noCloseAfterFail == null || noCloseAfterFail.equals("0")) {
			closeSeleniumSession();
		}
	}

	protected boolean isOasis() throws Exception {
		return session().getEval("window.skin").equals("oasis");
	}

	protected void setTimeout(String timeout) {
		this.timeout = timeout;
	}

	protected String getTimeout() {
		return this.timeout;
	}
	
	protected boolean isLoggedIn() throws Exception {
		return session().isElementPresent("link=Log out");
	}

	protected void login(String username, String password) throws Exception {
		session().open("index.php?title=Special:Signup");
		session().type("wpName2Ajax", username);
		session().type("wpPassword2Ajax", password);
		session().click("wpLoginattempt");
		session().waitForPageToLoad(this.getTimeout());
		if(isOasis()) {
			waitForElement("//ul[@id='AccountNavigation']/li/a[contains(@href, '" + username + "')]");
		} else {
			waitForElement("//*[@id=\"pt-userpage\"]/a[text() = \"" + username + "\"]");
		}

	}

	protected void login() throws Exception {
		loginAsBot();
	}

	protected void loginAsBot() throws Exception {
		login(getTestConfig().getString("ci.user.wikiabot.username"), getTestConfig().getString("ci.user.wikiabot.password"));
	}

	protected void loginAsStaff() throws Exception {
		login(getTestConfig().getString("ci.user.wikiastaff.username"), getTestConfig().getString("ci.user.wikiastaff.password"));
	}

	protected void loginAsSysop() throws Exception {
		login(getTestConfig().getString("ci.user.wikiasysop.username"), getTestConfig().getString("ci.user.wikiasysop.password"));
	}

	protected void loginAsRegular() throws Exception {
		login(getTestConfig().getString("ci.user.regular.username"), getTestConfig().getString("ci.user.regular.password"));
	}

	protected void logout() throws Exception {
		session().open("index.php?useskin=oasis");
		session().waitForPageToLoad(this.getTimeout());
		session().click("link=Log out");
		session().waitForPageToLoad(this.getTimeout());
		assertTrue(session().isTextPresent("You have been logged out."));
		assertTrue(session().isElementPresent("//a[@class='ajaxLogin']"));
	}

	protected void waitForAttributeNotEquals(String elementId, String value, int timeOut) throws Exception {
		long startTimestamp = (new Date()).getTime();
		while (true) {
			long curTimestamp = (new Date()).getTime();
			if (curTimestamp-startTimestamp > timeOut) {
				assertFalse(session().getAttribute(elementId).equals(value));
				break;
			}

			try{
				if(!session().getAttribute(elementId).equals(value)) {
					break;
				}
			} catch( SeleniumException e ) {}
			Thread.sleep(1000);
		}
	}
	protected void waitForAttributeNotEquals(String elementId, String value, String timeOut) throws Exception {
		waitForAttributeNotEquals(elementId, value, Integer.parseInt(this.getTimeout()));
	}

	protected void waitForTextPresent(String text, int timeOut)
			throws Exception {
		waitForTextPresent(text, timeOut, null);
	}

	protected void waitForTextPresent(String text, int timeOut, String message)
			throws Exception {
		long startTimestamp = (new Date()).getTime();
		while (true) {
			long curTimestamp = (new Date()).getTime();
			if (curTimestamp-startTimestamp > timeOut) {
				if (message == null) {
					assertTrue(session().isTextPresent(text));
				} else {
					assertTrue(message, session().isTextPresent(text));
				}
				break;
			}

			try{
				if(session().isTextPresent(text)) {
					break;
				}
			} catch( SeleniumException e ) {}
			Thread.sleep(1000);
		}
	}

	protected void waitForTextPresent(String text, String timeOut, String message)
			throws Exception {
		waitForTextPresent(text, Integer.parseInt(timeOut), message);
	}

	protected void waitForTextPresent(String text, String timeOut)
			throws Exception {
		waitForTextPresent(text, Integer.parseInt(timeOut));
	}

	protected void waitForTextPresent(String text) throws Exception {
		waitForTextPresent(text, this.getTimeout());
	}

	protected void waitForElementNotPresent(String elementId, int timeOut)
			throws Exception {
		long startTimestamp = (new Date()).getTime();
		while (true) {
			long curTimestamp = (new Date()).getTime();
			if (curTimestamp-startTimestamp > timeOut) {
				assertFalse(session().isElementPresent(elementId));
				break;
			}

			try{
				if(!session().isElementPresent(elementId)) {
					break;
				}
			} catch( SeleniumException e ) {}
			Thread.sleep(1000);
		}
	}

	protected void waitForElementNotPresent(String elementId, String timeOut)
			throws Exception {
		waitForElementNotPresent(elementId, Integer.parseInt(timeOut));
	}

	protected void waitForElementNotPresent(String elementId) throws Exception {
		waitForElementNotPresent(elementId, this.getTimeout());
	}

	protected void waitForElement(String elementId, int timeOut)
			throws Exception {
		long startTimestamp = (new Date()).getTime();
		while (true) {
			long curTimestamp = (new Date()).getTime();
			if (curTimestamp-startTimestamp > timeOut) {
				assertTrue(session().isElementPresent(elementId));
				break;
			}

			try{
				if(session().isElementPresent(elementId)) {
					break;
				}
			} catch( SeleniumException e ) {}
			Thread.sleep(1000);
		}
	}

	protected void waitForElement(String elementId, String timeOut)
			throws Exception {
		waitForElement(elementId, Integer.parseInt(timeOut));
	}

	protected void waitForElement(String elementId) throws Exception {
		waitForElement(elementId, this.getTimeout());
	}

	protected void waitForElementVisible(String elementId, int timeOut)
			throws Exception {
		long startTimestamp = (new Date()).getTime();
		while (true) {
			long curTimestamp = (new Date()).getTime();
			if (curTimestamp-startTimestamp > timeOut) {
				assertTrue(session().isVisible(elementId));
				break;
			}
			if (session().isVisible(elementId)) {
				break;
			}
			Thread.sleep(1000);
		}
	}

	protected void waitForElementVisible(String elementId, String timeOut)
			throws Exception {
		waitForElementVisible(elementId, Integer.parseInt(timeOut));
	}

	protected void waitForElementVisible(String elementId) throws Exception {
		waitForElementVisible(elementId, this.getTimeout());
	}

	protected void waitForElementNotVisible(String elementId, int timeOut)
			throws Exception {
		long startTimestamp = (new Date()).getTime();
		while (true) {
			long curTimestamp = (new Date()).getTime();
			if (curTimestamp-startTimestamp > timeOut) {
				assertFalse(session().isVisible(elementId));
				break;
			}
			if (!session().isVisible(elementId)) {
				break;
			}
			Thread.sleep(1000);
		}
	}

	protected void waitForElementNotVisible(String elementId, String timeOut)
			throws Exception {
		waitForElementNotVisible(elementId, Integer.parseInt(timeOut));
	}

	protected void waitForElementNotVisible(String elementId) throws Exception {
		waitForElementNotVisible(elementId, this.getTimeout());
	}

	protected void clickAndWait(String location) {
		session().click(location);
		session().waitForPageToLoad(this.getTimeout());
	}

	protected String md5(InputStream is) throws NoSuchAlgorithmException,
			IOException {
		String output;
		MessageDigest digest = MessageDigest.getInstance("MD5");
		byte[] buffer = new byte[8192];
		int read = 0;
		try {
			while ((read = is.read(buffer)) > 0) {
				digest.update(buffer, 0, read);
			}
			byte[] md5sum = digest.digest();
			BigInteger bigInt = new BigInteger(1, md5sum);
			output = bigInt.toString(16);
		} finally {
			is.close();
		}
		return output;
	}

	protected String getWordFromCaptchaId(String captchaId)
			throws NoSuchAlgorithmException, IOException {
		if (webSite.endsWith("/")) {
			webSite = webSite.substring(0, webSite.length() - 1);
		}
		URL url = new URL(webSite
				+ "/index.php?title=Special:Captcha/image&wpCaptchaId="
				+ captchaId);
		String md5 = md5(url.openStream());
		if (md5 == null) {
			assertTrue(session().isTextPresent("Requested bogus captcha image"));
		}

		File file = new File(System.getenv("TESTSCONFIG"));
		BufferedReader in = new BufferedReader(new FileReader(file.getParentFile() + "/fixtures/captcha.txt"));
		String strLine;
		while ((strLine = in.readLine()) != null) {
			String[] field = strLine.split(" ");
			if (field[1].equals(md5)) {
				in.close();
				return field[0];
			}
		}
		in.close();
		return null;
	}

	/**
	 * Check if the given edit page uses Visual Editor (in either visual or source mode!)
	 */
	protected boolean isWysiwygEditor() throws Exception {
		return session().getEval("typeof window.CKEDITOR").equals("object");
	}

	/**
	 * Change the current mode of Visual Editor.
	 * 
	 * "mode" can be either "wysiwyg" or "source"
	 */
	protected void switchWysiwygMode(String mode) throws Exception {
		if (!session().getEval("window.RTE && window.RTE.instance.mode").equals(mode)) {
			session().runScript("window.RTE.instance.switchMode('" + mode + "')");
			session().waitForCondition("window.RTE.instance.mode == '" + mode + "'", this.getTimeout());
		}
	}

	/**
	 * Edit an article using given wikitext
	 * 
	 * Please note that an edit will happen using MW editor to speed things up
	 */
	protected void editArticle(String articleName, String content) throws Exception {
		session().open("index.php?title=" + articleName + "&action=edit&useeditor=mediawiki");
		session().waitForPageToLoad(this.getTimeout());
		waitForElement("wpTextbox1");
		doEdit(content);
		doSave();
	}

	/**
	 * Save content of the edit page. This method should only be called when the browser is on the edit page.
	 */
	protected void doEdit(String content) throws Exception {
		if (isWysiwygEditor()) {
			// Visual Editor - switch to source mode (if needed)
			this.switchWysiwygMode('source');
			session().type("//td[@id='cke_contents_wpTextbox1']/textarea", content);
		} else {
			// regular editor
			session().type("wpTextbox1", content);
		}
	}

	protected void doSave() throws Exception {
		session().click("wpSave");
		session().waitForPageToLoad(this.getTimeout());
	}

	protected void deleteArticle(String articleName, String reasonGroup,
			String reason) throws Exception {
		session().open("index.php?title=" + articleName);
		session().waitForPageToLoad(this.getTimeout());
		doDelete(reasonGroup, reason);
	}

	protected void doDelete(String reasonGroup, String reason) throws Exception {
		if (isOasis()) {
			session().click("//a[@data-id='delete']");
		} else {
			session().click("ca-delete");
		}
		session().waitForPageToLoad(this.getTimeout());
		session().select("wpDeleteReasonList", reasonGroup);
		session().type("wpReason", reason);
		session().uncheck("wpWatch");
		session().click("wpConfirmB");
		session().waitForPageToLoad(this.getTimeout());
	}

	/**
	 * Deletes the current page if the user is allowed to do so.  If not allowed,
	 * does not throw an error and just continues on quietly.  This is for use when
	 * it would be nice to delete an article, but it isn't necessary.
	 */
	protected void doDeleteIfAllowed(String reasonGroup, String reason) throws Exception {
		String xpath;
		if (isOasis()) {
			xpath = "//a[@data-id='delete']";
		} else {
			xpath = "ca-delete";
		}
		if(session().isElementPresent(xpath)){
			session().click(xpath);
			session().waitForPageToLoad(this.getTimeout());
			session().select("wpDeleteReasonList", "label=regexp:.*"+reasonGroup);
			session().type("wpReason", reason);
			session().uncheck("wpWatch");
			if (session().isElementPresent("wpConfirmB")) {
				session().click("wpConfirmB");
			} else {
				session().click("mw-filedelete-submit");
			}
			session().waitForPageToLoad(this.getTimeout());
		}
	}

	protected void undeleteArticle(String articleName, String reason) throws Exception {
		session().open("index.php?title=Special:Undelete/" + articleName);
		session().waitForPageToLoad(this.getTimeout());

		session().type("wpComment", reason);

		clickAndWait("mw-undelete-submit");
	}

	protected void moveArticle(String oldName, String newName, String reason) throws Exception {
		session().open("index.php?title=Special:MovePage/" + oldName);
		session().waitForPageToLoad(this.getTimeout());

		session().type("wpNewTitle", newName);
		session().type("wpReason", reason);

		session().uncheck("wpLeaveRedirect");
		session().uncheck("watch");

		clickAndWait("wpMove");

		if (session().isElementPresent("wpConfirm")) {
			session().uncheck("wpLeaveRedirect");
			session().uncheck("watch");
			session().check("wpConfirm");
			clickAndWait("wpDeleteAndMove");
		}
	}

	//set summary as '' to use default MW message
	protected void undoLastEdit(String articleName, String summary) throws Exception {
		//go to history page
		session().open("index.php?action=history&title=" + articleName);
		session().waitForPageToLoad(this.getTimeout());
		try {
			//go to undo page
			String href = session().getAttribute("//ul[@id='pagehistory']/li[1]/span[@class='mw-history-undo']/a@href");
			session().open(href);
		}
		catch (SeleniumException e) {
			//no 'undo' link - check if there is only one revision.. if so, then 'undo' means 'delete'
			if (Integer.parseInt(session().getEval("window.document.getElementById('pagehistory').getElementsByTagName('li').length;")) == 1) {
				//can't use deleteArticle() - it's working only for regular skins (with navbar)
				session().open("index.php?action=delete&title=" + articleName);
				session().waitForPageToLoad(this.getTimeout());
				session().select("wpDeleteReasonList", "label=regexp:.*Author request");
				session().type("wpReason", "Wikia automated test");
				session().uncheck("wpWatch");
				session().click("wpConfirmB");
				session().waitForPageToLoad(this.getTimeout());
			}
			return;
		}
		//fill summary if provided
		if (summary != "") {
			session().type("wpSummary", summary);
		}
		//click save
		doSave();
	}

	protected void uploadImage() throws Exception {
		uploadImage(DEFAULT_UPLOAD_IMAGE_URL);
	}

	protected void uploadImage(String imageUrl) throws Exception {
		// keep file extensions consistent (uploaded image can be either PNG or JPG)
		// String fileNameExtenstion = imageUrl.substring(imageUrl.length() - 3, imageUrl.length());
		String destinationFilename = imageUrl.substring(imageUrl.lastIndexOf("/") + 1);
		destinationFilename = destinationFilename.substring(0,1).toUpperCase() + destinationFilename.substring(1);

		uploadImage(imageUrl, destinationFilename);
	}

	protected void uploadImage(String imageUrl, String destinationFilename) throws Exception {
		session().open("index.php?title=Special:Upload");
		session().waitForPageToLoad(this.getTimeout());
		session().attachFile("wpUploadFile", imageUrl);
		session().type("wpDestFile", destinationFilename);
		session().type("wpUploadDescription", "WikiaBot automated test.");
		session().uncheck("wpWatchthis");
		clickAndWait("wpUpload");

		assertFalse(session().isTextPresent("Upload error"));

		// upload warning - duplicate ...
		if (session().isTextPresent("Upload warning")) {
			session().type("wpUploadDescription", "WikiaBot automated test.");
			clickAndWait("wpUploadIgnoreWarning");
		}
		assertTrue(session().isTextPresent("Image:" + destinationFilename)
			|| session().isTextPresent("File:" + destinationFilename));
	}
}
