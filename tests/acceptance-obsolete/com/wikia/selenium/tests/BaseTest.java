package com.wikia.selenium.tests;

import com.thoughtworks.selenium.DefaultSelenium;
import com.thoughtworks.selenium.Selenium;

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
import java.util.ArrayList;
import java.util.Date;
import java.util.Iterator;
import java.util.List;

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
	protected String seleniumSpeed;
	private XMLConfiguration testConfig;
	

	/**
	 * Thread local Selenium driver instance so that we can run in multi-threaded mode.
	 */
	private static ThreadLocal<Selenium> threadLocalSelenium = new ThreadLocal<Selenium>();

	public static void startSeleniumSession(String seleniumHost, int seleniumPort, String browser, String webSite) {
		threadLocalSelenium.set(new DefaultSelenium(seleniumHost, seleniumPort, browser, webSite));
		if (browser.toLowerCase().contains("chrome")) {
			// Google Chrome has to be run with this switch otherwise cross-domain tests
			// and file upload tests don't work
			session().start("commandLineFlags=--disable-web-security");
		} else {
			session().start();
		}
	}

	public static void closeSeleniumSession() throws Exception {
		if (null != session()) {
			session().stop();
			resetSession();
		}
	}

	public static Selenium session() {
		return threadLocalSelenium.get();
	}


	public static void resetSession() {
		threadLocalSelenium.set(null);
	}
	
	
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
	@Parameters( { "seleniumHost", "seleniumPort", "browser", "webSite", "timeout", "noCloseAfterFail", "seleniumSpeed" })
	protected void startSession(String seleniumHost, int seleniumPort,
			String browser, String webSite, String timeout, String noCloseAfterFail, String seleniumSpeed) throws Exception {
		this.seleniumHost = seleniumHost;
		this.seleniumPort = seleniumPort;
		this.browser = browser;
		this.webSite = webSite;
		this.noCloseAfterFail = noCloseAfterFail;
		this.seleniumSpeed = seleniumSpeed;
		this.setTimeout(timeout);
		startSeleniumSession(seleniumHost, seleniumPort, browser, webSite);
		session().setTimeout(timeout);
		session().setSpeed(this.seleniumSpeed);
		session().open("/");
	}

	@AfterMethod(alwaysRun = true)
	protected void closeSession() throws Exception {
		/*
		if (isLoggedIn()) {
			logout();
		}
		*/
		
		if (noCloseAfterFail == null || noCloseAfterFail.equals("0")) {
			closeSeleniumSession();
		}
	}

	protected boolean isOasis() throws Exception {
		session().waitForCondition("typeof window != 'undefined' && typeof window.skin != 'undefined'", this.getTimeout());
		return session().getEval("window.skin").equals("oasis");
	}

	protected void setTimeout(String timeout) {
		this.timeout = timeout;
	}

	protected String getTimeout() {
		return this.timeout;
	}
	
	protected boolean isLoggedIn() throws Exception {
		return session().getEval("typeof window != 'undefined' && typeof window.wgUserName != 'undefined' && window.wgUserName !== null").equals("true");
	}

	protected void login(String username, String password) throws Exception {
		// check if we're already logged in
		String curUser = session().getEval("window.wgUserName");
		if (username.equals(curUser)) {
			return;
		}
		
		// unlogin, if we want to login 
		if ( username != null && !username.isEmpty() ) {
			this.logout();
		}
			
		openAndWait("/index.php?title=Special:UserLogin");
		
		// if new login page does not exist, try with old one
		if (session().isElementPresent("//div[@class='WikiaArticle']//div[@class='UserLogin']")) {			
			session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='username']", username);
			session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='password']", password);
			clickAndWait("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@type='submit']");
			if(isOasis()) {
				waitForElement("//ul[@id='AccountNavigation']/li/a[contains(@href, '" + username + "')]");
			} else {
				waitForElement("//*[@id=\"pt-userpage\"]/a[text() = \"" + username + "\"]");
			}

		} else {
			openAndWait("/index.php?title=Special:Signup"); 
			waitForElement("wpName2Ajax"); 
			session().type("wpName2Ajax", username); 
			session().type("wpPassword2Ajax", password); 
			clickAndWait("wpLoginattempt");
		}
		assertTrue(isLoggedIn()); 
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
		openAndWait("index.php?useskin=oasis");

		if (isLoggedIn()) {
			// new logout method doesn't always work - sometimes we have to click logout twice
			for(int i = 0 ; i < 3 ; i++) {
				/*
				 * mech - I simply cannot get it working without this sleep :( When selenium tries to logout too fast after
				 * the page is realoded, the logout action on the server does not work and we're still logged
				 */
				Thread.sleep(3000);
				
				//openAndWait(href);
				clickAndWait("link=Log out");
				if (session().isTextPresent("You have been logged out.")) {
					break;
				}
			}
			assertFalse(isLoggedIn());
		}
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

	protected void waitForPageToLoad() throws Exception {
		session().waitForPageToLoad(this.getTimeout());
		long startTimestamp = (new Date()).getTime();
		int timeOut = Integer.parseInt(this.getTimeout());
		while (true) {
			long curTimestamp = (new Date()).getTime();
			if (curTimestamp-startTimestamp > timeOut) {
				assertTrue(session().isElementPresent("//footer[@id='WikiaFooter']") || session().isElementPresent("//div[@id='footer']"));
				break;
			}

			try{
				if(session().isElementPresent("//footer[@id='WikiaFooter']") || session().isElementPresent("//div[@id='footer']")) {
					break;
				}
			} catch( SeleniumException e ) {}
			Thread.sleep(1000);
		}
		// we experienced several problem with this condition, which kind of stops us from working on selenium tests
		// a page is apparently loaded, but wgWikiaDOMReady is not set
		// so here we finish when wgWikiaDOMReady, but after the timeout we continue the test as nothing happened
		while((new Date()).getTime() - startTimestamp <= timeOut) {
			if ("true".equals(session().getEval("typeof window != 'undefined' && typeof window.wgWikiaDOMReady != 'undefined'"))) {
				break;
			}
		}
	}
	
	protected void clickAndWait(String location) throws Exception {
		String curSpeed = session().getSpeed();
		session().setSpeed("50");
		session().getEval("delete window.wgWikiaDOMReady");
		session().click(location);
		waitForPageToLoad();
		session().setSpeed(curSpeed);
	}
	
	protected void openAndWait(String url) throws Exception {
		String curSpeed = session().getSpeed();
		session().setSpeed("50");
		session().getEval("delete window.wgWikiaDOMReady");
		session().open(url);
		waitForPageToLoad();
		session().setSpeed(curSpeed);
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
			output = String.format("%0" + (md5sum.length << 1) + "x", bigInt);
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
	 * Check if The Editor Reskin is enabled on the current edit page
	 */
	protected boolean isReskinEnabled() throws Exception {
		return !session().getEval("typeof window.wgEditedTitle").equals("undefined");
	}

	/**
	 * Change the current mode of Visual Editor.
	 * 
	 * "mode" can be either "wysiwyg" or "source"
	 */
	protected void switchWysiwygMode(String mode) throws Exception {
		session().waitForCondition("(window.RTE && window.RTE.getInstance()).mode", this.getTimeout());
		if (!session().getEval("window.RTE && (window.RTE.instance || window.RTE.getInstance()).mode").equals(mode)) {
			session().runScript("(window.RTE.instance || window.RTE.getInstance()).switchMode('" + mode + "')");
			session().waitForCondition("(window.RTE.instance || window.RTE.getInstance()).mode == '" + mode + "'", this.getTimeout());
		}
	}

	/**
	 * Edit an article using given wikitext
	 * 
	 * Please note that an edit will happen using MW editor to speed things up
	 */
	protected void editArticle(String articleName, String content) throws Exception {
		openAndWait("index.php?title=" + articleName + "&action=edit&useeditor=mediawiki");
		waitForElement("wpTextbox1");
		doEdit(content);
		doSave();
	}

	/**
	 * Save content of the edit page. This method should only be called when the browser is on the edit page.
	 */
	protected void doEdit(String wikitext) throws Exception {
		if (isWysiwygEditor()) {
			// Visual Editor - switch to source mode (if needed)
			// wait for RTE to be fully loaded
			session().waitForCondition("window.CKEDITOR && window.CKEDITOR.status == 'basic_ready'", this.getTimeout());
			this.switchWysiwygMode("source");
			session().runScript("(window.RTE.instance || window.RTE.getInstance()).setData(\"" + wikitext.replace("\n", "\\n").replace("\"", "\\\"") + "\");");
		} else {
			// regular editor
			session().type("wpTextbox1", wikitext);
		}
	}

	protected void doSave() throws Exception {
		clickAndWait("wpSave");
	}

	protected void deleteArticle(String articleName, String reasonGroup, String reason) throws Exception {
		openAndWait("index.php?title=" + articleName);
		doDelete(reasonGroup, reason);
	}

	protected void doDelete(String reasonGroup, String reason) throws Exception {
		if (isOasis()) {
			clickAndWait("//a[@data-id='delete']");
		} else {
			clickAndWait("ca-delete");
		}
		waitForElement("//select[@id='wpDeleteReasonList']");
		session().select("//select[@id='wpDeleteReasonList']", reasonGroup);
		session().type("wpReason", reason);
		session().uncheck("wpWatch");
		clickAndWait("wpConfirmB");
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
			clickAndWait(xpath);
			session().select("wpDeleteReasonList", "label=regexp:.*"+reasonGroup);
			session().type("wpReason", reason);
			session().uncheck("wpWatch");
			if (session().isElementPresent("wpConfirmB")) {
				clickAndWait("wpConfirmB");
			} else {
				clickAndWait("mw-filedelete-submit");
			}
		}
	}

	protected void undeleteArticle(String articleName, String reason) throws Exception {
		openAndWait("index.php?title=Special:Undelete/" + articleName);

		waitForElement("wpComment");
		session().type("wpComment", reason);

		clickAndWait("mw-undelete-submit");
	}

	protected void moveArticle(String oldName, String newName, String reason) throws Exception {
		openAndWait("index.php?title=Special:MovePage/" + oldName);

		waitForElement("wpNewTitle");
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
		openAndWait("index.php?action=history&title=" + articleName);
		try {
			//go to undo page
			String href = session().getAttribute("//ul[@id='pagehistory']/li[1]/span[@class='mw-history-undo']/a@href");
			openAndWait(href);
		}
		catch (SeleniumException e) {
			//no 'undo' link - check if there is only one revision.. if so, then 'undo' means 'delete'
			if (Integer.parseInt(session().getEval("window.document.getElementById('pagehistory').getElementsByTagName('li').length;")) == 1) {
				//can't use deleteArticle() - it's working only for regular skins (with navbar)
				openAndWait("index.php?action=delete&title=" + articleName);
				session().select("wpDeleteReasonList", "label=regexp:.*Author request");
				session().type("wpReason", "Wikia automated test");
				session().uncheck("wpWatch");
				clickAndWait("wpConfirmB");
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
		openAndWait("index.php?title=Special:Upload");
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
	
	protected boolean isPreview() {
		return this.webSite.contains("preview.");
	}
	
	protected boolean isDevBox() {
		return this.webSite.contains("wikia-dev.com");
	}
	
	protected boolean isProduction() {
		return this.webSite.contains("wikia.com") && !isPreview();
	}
	
	public String[] testWikiNames() throws Exception {
		return getTestConfig().getStringArray("ci.wiki.name");
	}
}
