package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.closeSeleniumSession;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.startSeleniumSession;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertTrue;

import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStream;
import java.math.BigInteger;
import java.net.URL;
import java.net.MalformedURLException;
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

import java.util.Map;

/**
 * Base class for all tests in Selenium Grid Java examples.
 */
public class BaseTest {

	public static final String TIMEOUT = "60000";
	private String webSite;
	private XMLConfiguration testConfig;
	
	public XMLConfiguration getTestConfig(){
		if (null == this.testConfig) {
			String testsdir = System.getenv("TESTSDIR");
			if (null == testsdir) {
				testsdir = System.getenv("PWD") + "/source/tests";
			}
			if (null != testsdir) {
				try {
					this.testConfig = new XMLConfiguration();
					this.testConfig.setBasePath(testsdir);
					this.testConfig.setFileName("config.xml");
					this.testConfig.load();
				} catch (ConfigurationException ce) {
				}
			}
		}
		return this.testConfig;
	}

	@BeforeMethod(alwaysRun = true)
	@Parameters( { "seleniumHost", "seleniumPort", "browser", "webSite", "timeout" })
	protected void startSession(String seleniumHost, int seleniumPort,
			String browser, String webSite, String timeout) throws Exception {
		this.webSite = webSite;
		startSeleniumSession(seleniumHost, seleniumPort, browser, webSite);
		session().setTimeout(timeout);
		session().setSpeed("1000");

	}

	@AfterMethod(alwaysRun = true)
	protected void closeSession() throws Exception {
		closeSeleniumSession();
	}

	protected boolean isOasis() throws Exception {
		return session().getEval("window.skin").equals("oasis");
	}

	protected void login(String username, String password) throws Exception {
		session().open("index.php?title=Special:Signup");
		session().type("wpName2Ajax", username);
		session().type("wpPassword2Ajax", password);
		session().click("wpLoginattempt");
		waitForElement("//body");
		if(isOasis()) {
			waitForElement("//ul[@id='AccountNavigation']/li/a[contains(@href, '" + username + "')]");
		} else {
			waitForElement("//*[@id=\"header_username\"]/a[text() = \"" + username + "\"]");
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
		login(getTestConfig().getString("ci.user.regular.username"), getTestConfig().getString("ci.user.wikiabot.regular"));
	}

	protected void logout() throws Exception {
		session().open("index.php?useskin=monaco");
		session().click("link=Log out");
		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().isElementPresent("//a[@id='login']"));
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
		waitForElement(elementId, TIMEOUT);
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
		waitForElementVisible(elementId, TIMEOUT);
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
		waitForElementNotVisible(elementId, TIMEOUT);
	}

	protected void clickAndWait(String location) {
		session().click(location);
		session().waitForPageToLoad(TIMEOUT);
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
		URL url = new URL(webSite
				+ "index.php?title=Special:Captcha/image&wpCaptchaId="
				+ captchaId);
		String md5 = md5(url.openStream());
		if (md5 == null) {
			assertTrue(session().isTextPresent("Requested bogus captcha image"));
		}

		BufferedReader in = new BufferedReader(new FileReader("captcha.txt"));
		String strLine;
		while ((strLine = in.readLine()) != null) {
			String[] field = strLine.split("\t");
			if (field[1].equals(md5)) {
				in.close();
				return field[0];
			}
		}
		in.close();
		return null;
	}

	protected boolean isFCK() throws Exception {
		return session().getEval("typeof window.RTEInstanceId").equals("string");
	}

	protected void editArticle(String articleName, String content)
			throws Exception {
		session().open("index.php?title=" + articleName + "&action=edit&useeditor=source");
		session().waitForPageToLoad(TIMEOUT);
		doEdit(content);
		doSave();
	}

	protected void doEdit(String content) throws Exception {
		if (isFCK()) {
			// RTE editor
			// switch to source mode (if needed)
			if (session().getEval("window.RTE.instance.mode").equals("wysiwyg")) {
				session().runScript("window.RTE.instance.switchMode('source')");
				session().waitForCondition("window.RTE.instance.mode == 'source'", "7500");
			}
			session().type("//td[@id='cke_contents_wpTextbox1']/textarea", content);
		} else {
			// regular editor
			session().type("wpTextbox1", content);
		}
	}

	protected void doSave() throws Exception {
		session().click("wpSave");
		session().waitForPageToLoad(TIMEOUT);
	}

	protected void deleteArticle(String articleName, String reasonGroup,
			String reason) throws Exception {
		session().open("index.php?title=" + articleName);
		session().waitForPageToLoad(TIMEOUT);
		doDelete(reasonGroup, reason);
	}

	protected void doDelete(String reasonGroup, String reason) throws Exception {
		if (isOasis()) {
			session().click("//a[@data-id='delete']");
		}
		else {
			session().click("ca-delete");
		}
		session().waitForPageToLoad(TIMEOUT);
		session().select("wpDeleteReasonList", reasonGroup);
		session().type("wpReason", reason);
		session().uncheck("wpWatch");
		session().click("wpConfirmB");
		session().waitForPageToLoad(TIMEOUT);
	}

	protected void undeleteArticle(String articleName, String reason) throws Exception {
		session().open("index.php?title=Special:Undelete/" + articleName);
		session().waitForPageToLoad(TIMEOUT);

		session().type("wpComment", reason);

		clickAndWait("mw-undelete-submit");
	}

	protected void moveArticle(String oldName, String newName, String reason) throws Exception {
		session().open("index.php?title=Special:MovePage/" + oldName);
		session().waitForPageToLoad(TIMEOUT);

		session().type("wpNewTitle", newName);
		session().type("wpReason", reason);

		session().uncheck("wpLeaveRedirect");
		session().uncheck("watch");

		clickAndWait("wpMove");
	}

	//set summary as '' to use default MW message
	protected void undoLastEdit(String articleName, String summary) throws Exception {
		//go to history page
		session().open("index.php?action=history&title=" + articleName);
		session().waitForPageToLoad(TIMEOUT);
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
				session().waitForPageToLoad(TIMEOUT);
				session().select("wpDeleteReasonList", "label=Author request");
				session().type("wpReason", "Wikia automated test");
				session().uncheck("wpWatch");
				session().click("wpConfirmB");
				session().waitForPageToLoad(TIMEOUT);
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
}
