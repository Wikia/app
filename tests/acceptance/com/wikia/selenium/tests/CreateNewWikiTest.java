package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.closeSeleniumSession;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

import java.util.Date;
import java.util.Random;

import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;

public class CreateNewWikiTest extends BaseTest {
	public static final String TEST_USER_PREFIX = "WikiaTestAccount";
	public static final String TEST_EMAIL_FORMAT = "WikiaTestAccount%s@wikia-inc.com";
	private static String wikiName;
	
	@BeforeMethod(alwaysRun=true)
	public void enforceMainWebsite() throws Exception {
		enforceWebsite("http://www.wikia.com");
	}
	
	public void enforceWebsite(String website) throws Exception {
		closeSeleniumSession();
		startSession(this.seleniumHost, this.seleniumPort, this.browser, website, this.timeout, this.noCloseAfterFail);
	}
	
	private static String getWikiName() {
		if (null == wikiName) {
			wikiName = "testwiki" + Long.toString(Math.abs(new Random().nextLong()), 36).toLowerCase();
		}

		return wikiName;
	}
	
	@Test(groups="oasis")
	public void testCreateWikiAsLoggedInUser() throws Exception {
		loginAsStaff();
		session().open("/wiki/Special:CreateNewWiki");
		waitForElement("//input[@name='wiki-name']");
		session().type("//input[@name='wiki-name']", getWikiName());
		session().type("//input[@name='wiki-domain']", getWikiName());
		session().click("//li[@id='NameWiki']/form/nav/input[@class='next']");
		waitForElementVisible("DescWiki");
		session().select("//select[@name='wiki-category']", "value=3");
		session().click("//li[@id='DescWiki']/form/nav/input[@class='next']");
		waitForElementVisible("ThemeWiki", 3000);
		session().click("//li[@id='ThemeWiki']/nav/input[@class='next']");
		waitForElementVisible("UpgradeWiki", 3000);
		clickAndWait("//li[@id='UpgradeWiki']/nav/input[@class='next']");
		waitForElementVisible("WikiWelcome", 60000);
	}
	
	@Test(groups="oasis",dependsOnMethods={"testCreateWikiAsLoggedInUser"},alwaysRun=true)
	public void testDeleteCreateWikiAsLoggedInUser() throws Exception {
		loginAsStaff();
		
		deleteWiki("en");
		
		wikiName = null;
	}

	@Test(groups="oasis")
	public void testCreateWikiAsLoggedOutUser() throws Exception {
		session().open("/wiki/Special:CreateNewWiki");
		waitForElement("//input[@name='wiki-name']");
		session().type("//input[@name='wiki-name']", getWikiName());
		session().type("//input[@name='wiki-domain']", getWikiName());
		session().click("//li[@id='NameWiki']/form/nav/input[@class='next']");
		waitForElementVisible("Auth");
		session().click("//p[@class='login-msg']/a");
		waitForElementVisible("AjaxLoginLoginForm");
		session().type("wpName2Ajax", getTestConfig().getString("ci.user.wikiastaff.username"));
		session().type("wpPassword2Ajax", getTestConfig().getString("ci.user.wikiastaff.password"));
		session().click("//li[@id='Auth']/nav/input[@class='login']");
		waitForElementVisible("DescWiki");
		session().select("//select[@name='wiki-category']", "value=3");
		session().click("//li[@id='DescWiki']/form/nav/input[@class='next']");
		waitForElementVisible("ThemeWiki", 3000);
		session().click("//li[@id='ThemeWiki']/nav/input[@class='next']");
		waitForElementVisible("UpgradeWiki", 3000);
		clickAndWait("//li[@id='UpgradeWiki']/nav/input[@class='next']");
		waitForElementVisible("WikiWelcome", 60000);
	}
	
	@Test(groups="oasis",dependsOnMethods={"testCreateWikiAsLoggedOutUser"},alwaysRun=true)
	public void testDeleteCreateWikiAsLoggedOutUser() throws Exception {
		loginAsStaff();
		
		deleteWiki("en");
		
		wikiName = null;
	}
	
	@Test(groups="oasis")
	public void testCreateWikiAsNewUser() throws Exception {
		session().open("/wiki/Special:CreateNewWiki");
		waitForElement("//input[@name='wiki-name']");
		session().type("//input[@name='wiki-name']", getWikiName());
		session().type("//input[@name='wiki-domain']", getWikiName());
		session().click("//li[@id='NameWiki']/form/nav/input[@class='next']");
		waitForElementVisible("Auth");
		
		String time = Long.toString((new Date()).getTime());
		String password = Long.toString(Math.abs(new Random().nextLong()), 36).toLowerCase();
		String captchaWord = getWordFromCaptchaId(session().getValue("wpCaptchaId"));

		session().type("wpName2", TEST_USER_PREFIX + time);
		session().type("wpEmail", String.format(TEST_EMAIL_FORMAT, time));
		session().type("wpPassword2", password);
		session().type("wpRetype", password);
		session().select("wpBirthYear", "1900");
		session().select("wpBirthMonth", "1");
		session().select("wpBirthDay", "1");
		session().type("wpCaptchaWord", captchaWord);
		
		session().click("//li[@id='Auth']/nav/input[@class='signup']");
		
		waitForElementVisible("DescWiki");
		session().select("//select[@name='wiki-category']", "value=3");
		session().click("//li[@id='DescWiki']/form/nav/input[@class='next']");
		waitForElementVisible("ThemeWiki", 3000);
		session().click("//li[@id='ThemeWiki']/nav/input[@class='next']");
		waitForElementVisible("UpgradeWiki", 3000);
		clickAndWait("//li[@id='UpgradeWiki']/nav/input[@class='next']");
		waitForElementVisible("WikiWelcome", 60000);
	}
	
	@Test(groups="oasis",dependsOnMethods={"testCreateWikiAsNewUser"},alwaysRun=true)
	public void testDeleteCreateWikiAsNewUser() throws Exception {
		loginAsStaff();
		
		deleteWiki("en");
		
		wikiName = null;
	}
	
	
	public void deleteWiki(String language) throws Exception {
		session().open("http://community.wikia.com/wiki/Special:WikiFactory");
		session().waitForPageToLoad(this.getTimeout());

		session().type("citydomain", (language.equals("en") ? "" : language + ".") + getWikiName() + ".wikia.com");
		clickAndWait("//form[@id='WikiFactoryDomainSelector']/div/ul/li/button");
		session().waitForPageToLoad(this.getTimeout());
		waitForElementVisible("link=Close", 10000);

		System.out.println(session().isElementPresent("link=Close"));
		
		if (session().isElementPresent("link=Close")) {
			clickAndWait("link=Close");

			session().uncheck("flag_1");
			session().uncheck("flag_2");
			session().check("flag_4");
			session().check("flag_8");
			clickAndWait("close_saveBtn");

			clickAndWait("close_saveBtn");
			assertTrue(session().isTextPresent("was closed"));
		}
	}

}
