package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.closeSeleniumSession;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import java.util.ArrayList;
import java.util.Date;
import java.util.Iterator;
import java.util.List;
import java.util.Random;

import org.testng.annotations.BeforeMethod;
import org.testng.annotations.DataProvider;
import org.testng.annotations.Test;

public class CreateNewWikiTest extends BaseTest {
	private static String wikiName;
	private static List<String> testedLanguages = new ArrayList<String>();	
	
	private static String getWikiName() {
		if (null == wikiName) {
			wikiName = "testwiki" + Long.toString(Math.abs(new Random().nextLong()), 36).toLowerCase() + "t";
		}

		return wikiName;
	}

	@BeforeMethod(alwaysRun=true)
	public void enforceMainWebsite() throws Exception {
		if (this.webSite.contains("preview")) {
			enforceWebsite("http://preview.www.wikia.com");
		} else {
			enforceWebsite("http://www.wikia.com");
		}
	}

	public void enforceWebsite(String website) throws Exception {
		closeSeleniumSession();
		startSession(this.seleniumHost, this.seleniumPort, this.browser, website, this.timeout, this.noCloseAfterFail, this.seleniumSpeed);
	}
	
	@DataProvider(name = "wikiLanguages")
	public Iterator<Object[]> wikiLanguages() throws Exception {
		String[] languages = getTestConfig().getStringArray("ci.extension.wikia.AutoCreateWiki.lang");
		List<Object[]> languageList = new ArrayList<Object[]>();
		for (String language : languages) {
			languageList.add(new Object[] { language });
		}
		return languageList.iterator();
	}
	
	@Test(groups={"envProduction"},dataProvider="wikiLanguages")
	public void testCreateWikiComprehensive(String language) throws Exception {
		loginAsStaff();
		
		openAndWait("/wiki/Special:CreateNewWiki?uselang=" + language);
		waitForElement("//input[@name='wiki-name']");
		session().type("//input[@name='wiki-name']", getWikiName());
		session().type("//input[@name='wiki-domain']", getWikiName());
		session().click("//li[@id='NameWiki']/form/nav/input[@class='next']");
		waitForElementVisible("DescWiki");
		session().select("//select[@name='wiki-category']", "value=3");
		session().click("//li[@id='DescWiki']/form/nav/input[@class='next']");
		waitForElementVisible("ThemeWiki", this.getTimeout());
		/* temporarily commenting out because we might add it back in later 
		if (language.equals("en")) {
			session().click("//li[@id='ThemeWiki']/nav/input[@class='next']");
			waitForElementVisible("UpgradeWiki", this.getTimeout());
			clickAndWait("//li[@id='UpgradeWiki']/nav/input[@class='next']");
		} else {*/
		clickAndWait("//li[@id='ThemeWiki']/nav/input[@class='next']");
		waitForElement("WikiWelcome", this.getTimeout());
		waitForElementVisible("WikiWelcome", this.getTimeout());
		
		String url = "http://" + (language.equals("en") ? "" : language + ".") + getWikiName() + ".wikia.com";
		
		assertTrue(session().getLocation().contains(url));
		
		enforceWebsite(url);
		
		editArticle("A new article", "Lorem ipsum dolor sit amet");
		openAndWait("index.php?title=A_new_article");
		assertTrue(session().isTextPresent("Lorem ipsum dolor sit amet"));
		editArticle("A new article", "consectetur adipiscing elit");
		openAndWait("index.php?title=A_new_article");
		assertFalse(session().isTextPresent("Lorem ipsum dolor sit amet"));
		assertTrue(session().isTextPresent("consectetur adipiscing elit"));
		
		testedLanguages.add(language);
	}
	
	@Test(groups={"envProduction"},dependsOnMethods={"testCreateWikiComprehensive"},alwaysRun=true)
	public void testDeleteComprehensive() throws Exception {
		loginAsStaff();
		
		for (String language : testedLanguages) {
			deleteWiki(language);
		}
		
		wikiName = null;
	}

	@Test(groups={"envProduction"},dependsOnMethods={"testDeleteComprehensive"})
	public void testCreateWikiAsLoggedOutUser() throws Exception {
		session().open("/wiki/Special:CreateNewWiki");
		waitForElement("//input[@name='wiki-name']");
		session().type("//input[@name='wiki-name']", getWikiName());
		session().type("//input[@name='wiki-domain']", getWikiName());
		session().click("//li[@id='NameWiki']/form/nav/input[@class='next']");
		if (session().isElementPresent("Auth")) {
			waitForElementVisible("Auth");
			session().click("//p[@class='login-msg']/a");
			waitForElementVisible("AjaxLoginLoginForm");
			session().type("wpName2Ajax", getTestConfig().getString("ci.user.wikiastaff.username"));
			session().type("wpPassword2Ajax", getTestConfig().getString("ci.user.wikiastaff.password"));
			session().click("//li[@id='Auth']/nav/input[@class='login']");
		} else {
			waitForElementVisible("UserAuth");
			session().type("//li[@id='UserAuth']//input[@name='username']", getTestConfig().getString("ci.user.wikiastaff.username"));
			session().type("//li[@id='UserAuth']//input[@name='password']", getTestConfig().getString("ci.user.wikiastaff.password"));
			session().click("//li[@id='UserAuth']//input[@value='Log in']");
		}
		waitForElementVisible("DescWiki");
		session().select("//select[@name='wiki-category']", "value=3");
		session().click("//li[@id='DescWiki']/form/nav/input[@class='next']");
		waitForElementVisible("ThemeWiki", this.getTimeout());
		clickAndWait("//li[@id='ThemeWiki']/nav/input[@class='next']");
		/*
		waitForElementVisible("UpgradeWiki", this.getTimeout());
		clickAndWait("//li[@id='UpgradeWiki']/nav/input[@class='next']");
		*/
		waitForElement("WikiWelcome", this.getTimeout());
		waitForElementVisible("WikiWelcome", this.getTimeout());
	}
	
	@Test(groups={"envProduction"},dependsOnMethods={"testCreateWikiAsLoggedOutUser"},alwaysRun=true)
	public void testDeleteCreateWikiAsLoggedOutUser() throws Exception {
		loginAsStaff();
		
		deleteWiki("en");
		
		wikiName = null;
	}
	
	/*
	 * not testable - requires user account confirmation (reading mail) in order to complete process
	@Test(groups={"envProduction", "legacy"},dependsOnMethods={"testDeleteCreateWikiAsLoggedOutUser"})
	public void testCreateWikiAsNewUser() throws Exception {
		openAndWait("/wiki/Special:CreateNewWiki");
		waitForElement("//input[@name='wiki-name']");
		session().type("//input[@name='wiki-name']", getWikiName());
		session().type("//input[@name='wiki-domain']", getWikiName());
		session().click("//li[@id='NameWiki']/form/nav/input[@class='next']");
		waitForElementVisible("Auth");
		
		String time = Long.toString((new Date()).getTime());
		String password = Long.toString(Math.abs(new Random().nextLong()), 36).toLowerCase();
		String captchaWord = getWordFromCaptchaId(session().getValue("wpCaptchaId"));

		session().type("wpName2", SignupTest.TEST_USER_PREFIX + time);
		session().type("wpEmail", String.format(SignupTest.TEST_EMAIL_FORMAT, time));
		session().type("wpPassword2", password);
		session().type("wpRetype", password);
		session().select("wpBirthYear", "1900");
		session().select("wpBirthMonth", "1");
		session().select("wpBirthDay", "1");
		session().type("//input[@id='wpCaptchaWord']", captchaWord);
		
		session().click("//li[@id='Auth']/nav/input[@class='signup']");
		
		waitForElementVisible("DescWiki");
		session().select("//select[@name='wiki-category']", "value=3");
		session().click("//li[@id='DescWiki']/form/nav/input[@class='next']");
		waitForElementVisible("ThemeWiki", this.getTimeout());
		clickAndWait("//li[@id='ThemeWiki']/nav/input[@class='next']");
		// waitForElementVisible("UpgradeWiki", this.getTimeout());
		// clickAndWait("//li[@id='UpgradeWiki']/nav/input[@class='next']");
		waitForElement("WikiWelcome", this.getTimeout());
		waitForElementVisible("WikiWelcome", this.getTimeout());
	}
	
	@Test(groups={"envProduction", "legacy"},dependsOnMethods={"testCreateWikiAsNewUser"},alwaysRun=true)
	public void testDeleteCreateWikiAsNewUser() throws Exception {
		loginAsStaff();
		
		deleteWiki("en");
		
		wikiName = null;
	}
	*/
	
	public void deleteWiki(String language) throws Exception {
		closeNotifications();
		openAndWait("http://community.wikia.com/wiki/Special:WikiFactory");

		session().type("citydomain", (language.equals("en") ? "" : language + ".") + getWikiName() + ".wikia.com");
		clickAndWait("//form[@id='WikiFactoryDomainSelector']/div/ul/li/button");
		waitForElementVisible("link=Close", this.getTimeout());
		
		if (session().isElementPresent("link=Close")) {
			clickAndWait("link=Close");

			session().uncheck("flag_1");
			session().uncheck("flag_2");
			session().check("flag_4");
			session().check("flag_8");
			clickAndWait("//input[@name='close_saveBtn']");

			clickAndWait("//input[@name='close_saveBtn']");
			assertTrue(session().isTextPresent("was closed"));
		}
	}
	
	public void closeNotifications() throws Exception {
		String closeButton = "//*[@id='WikiaNotifications']//a[contains(@class, 'close-notification')]";
		if (session().isElementPresent(closeButton)) {
			// click but don't wait for anything
			session().click(closeButton);
		}
	}
	
	//Test Case 001
	//log in as QATestsStaff(default language=english),change language to deutsch,verify after CNW flow that wiki domain is de.
	@Test(groups={"envProduction"})
	public void createWikiDefaultLanguageForLoggedInUsersIsUserPreferencesLanguage() throws Exception {
		loginAsStaff();
		
		openAndWait("http://de.fallout.wikia.com/");
		clickAndWait("//header/nav//li[2]/a[@class='wikia-button']");
		
		assertTrue(session().getLocation().contains("/Special:CreateNewWiki?uselang=en"));
		session().type("//input[@name='wiki-name']", getWikiName());
		session().type("//input[@name='wiki-domain']", getWikiName());
		//waitForElementVisible("//span[contains(@class,'domain-status-icon')]/img[contains(@src,'check.png')]");
		session().click("//div[@class='language-default']/a[@id='ChangeLang']");
		session().select("//select[@name='wiki-language']", "value=de");
		assertTrue(session().isTextPresent("de."));
		session().click("//ol[@class='steps']//nav[@class='next-controls']/input[@class='next']");
		
		waitForElementVisible("DescWiki");
		session().select("//select[@name='wiki-category']", "value=3");
		session().click("//li[@id='DescWiki']/form/nav/input[@class='next']");
		waitForElementVisible("ThemeWiki", this.getTimeout());
		clickAndWait("//li[@id='ThemeWiki']/nav/input[@class='next']");
		
		waitForElement("WikiWelcome", this.getTimeout());
		waitForElementVisible("WikiWelcome", this.getTimeout());

		assertTrue(session().getLocation().contains("de."));
		
		deleteWiki("de");
		
		wikiName = null;
	}
		
	//Test Case 002
	//logged out in german wiki,domain appears in german,log in as QATestsStaff during CNW flow,verify domain is de.
	@Test(groups={"envProduction"}) 
	//fixed by Rodrigo Molinero 12-Mar-12
		public void createWikiDefaultLanguageForAnonymousIsWikiLanguage() throws Exception {
		openAndWait("http://de.fallout.wikia.com/wiki/Fallout_Wiki");
		clickAndWait("//header/nav//li[2]/a[@class='wikia-button']");
		
		assertTrue(session().isTextPresent("de."));
		session().type("//form[@name='label-wiki-form']/input[@type='text']", getWikiName());
		session().type("//input[@name='wiki-domain']", getWikiName());
		//waitForElementVisible("//form[@name='label-wiki-form]//span[@class='domain-status-icon status-icon']/img[@src='/extensions/wikia/CreateNewWiki/images/check.png'");
		session().click("//ol[@class='steps']//nav[@class='next-controls']/input[@class='next']");
		
		assertTrue(session().isTextPresent("account?"));
		session().type("//div[@class='UserLoginModal']//input[@type='text']", getTestConfig().getString("ci.user.wikiastaff.username"));
		session().type("//div[@class='UserLoginModal']//input[@type='password']", getTestConfig().getString("ci.user.wikiastaff.password"));
		session().click("//div[@class='UserLoginModal']//input[@value='Anmelden']");
		
		session().select("//select[@name='wiki-category']", "value=3");
		session().click("//li[@id='DescWiki']/form/nav/input[@class='next']");
		waitForElementVisible("ThemeWiki", this.getTimeout());
		clickAndWait("//li[@id='ThemeWiki']/nav/input[@class='next']");
		
		waitForElement("WikiWelcome", this.getTimeout());
		waitForElementVisible("WikiWelcome", this.getTimeout());
		assertTrue(session().getLocation().contains("de."));
		
		deleteWiki("de");
		
		wikiName = null;
	}
		
	//Test Case 003
	//logged out in german wiki,change language to english in CNW flow,log in as QATestsStaff,verify domain is english
	@Test(groups={"envProduction"})
	//fixed by Rodrigo Molinero 12-Mar-12
	public void createWikiDefaultLanguageForAnonymousIsWikiAndItCanBeChanged() throws Exception {
		openAndWait("http://de.fallout.wikia.com/wiki/Fallout_Wiki");
		clickAndWait("//header/nav//li[2]/a[@class='wikia-button']");
		
		assertTrue(session().isTextPresent("de."));
		session().type("//form[@name='label-wiki-form']/input[@type='text']", getWikiName());
		session().type("//input[@name='wiki-domain']", getWikiName());
		session().click("//ol[@class='steps']//div[@class='language-default']/a[@id='ChangeLang']");
		session().select("//select[@name='wiki-language']", "value=en");
		session().click("//ol[@class='steps']//nav[@class='next-controls']/input[@class='next']");
		
		assertTrue(session().isTextPresent("account?"));
		session().type("//div[@class='UserLoginModal']//input[@type='text']", getTestConfig().getString("ci.user.wikiastaff.username"));
		session().type("//div[@class='UserLoginModal']//input[@type='password']", getTestConfig().getString("ci.user.wikiastaff.password"));
		session().click("//div[@class='UserLoginModal']//input[@value='Anmelden']");
		
		waitForElementVisible("DescWiki");
		session().select("//select[@name='wiki-category']", "value=3");
		session().click("//li[@id='DescWiki']/form/nav/input[@class='next']");
		waitForElementVisible("ThemeWiki", this.getTimeout());
		clickAndWait("//li[@id='ThemeWiki']/nav/input[@class='next']");
		
		waitForElement("WikiWelcome", this.getTimeout());
		waitForElementVisible("WikiWelcome", this.getTimeout());
		assertFalse(session().getLocation().contains("de."));
		
		deleteWiki("en");
		
		wikiName = null;
	}

}
