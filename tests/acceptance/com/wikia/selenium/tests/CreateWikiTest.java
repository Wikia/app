package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.closeSeleniumSession;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertEquals;

import org.testng.annotations.BeforeMethod;

import java.math.BigInteger;
import java.util.Random;
import java.util.Date;

import org.testng.annotations.Test;

public class CreateWikiTest extends BaseTest {
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

	private void waitForStep(Integer stepNum) throws Exception {
			waitForElementVisible("//div[@class='dialog']/div[@class='step" + Integer.toString(stepNum) + "' or @id='WikiBuilderError']");

			// skip first step, if API request failed (BugID 1702)
			if (session().isElementPresent("//*[@id='WikiBuilderError']")) {
				session().click("//div[@class='step" + Integer.toString(stepNum - 1)  + "']//input[contains(@class, 'skip')]");
			}
	}

	@Test(groups={"envProduction"})
	public void testCreateWikiAsLoggedInUser() throws Exception {
		loginAsStaff();
		session().open("");
		session().waitForPageToLoad(this.getTimeout());

		String[] languages = getTestConfig().getStringArray("ci.extension.wikia.AutoCreateWiki.lang");

		for (int i = languages.length - 1; i >= 0; i--) {
			clickAndWait("link=Start a wiki");

			session().type("wiki-name", getWikiName());
			session().type("wiki-domain", getWikiName());
			session().select("wiki-category", "label=regexp:^.*Other");
			session().select("wiki-language", "label=regexp:^" + languages[i] + ":.*$");
			clickAndWait("wiki-submit");

			if (languages[i].equals("en")) {
				waitForTextPresent("Write a brief intro for your home page.", this.getTimeout(), "Wiki has not been created, language: " + languages[i]);
				session().click("//input[@value='Save Intro']");
				waitForStep(2);

				session().click("//input[@value='Save Theme']");
				waitForStep(3);

				session().click("//input[@value='Save Pages']");
				waitForStep(4);

				session().click("//input[@value='Continue to your wiki']");

				waitForTextPresent("Welcome to the Wiki", this.getTimeout(), "Wiki has not been created, language: " + languages[i]);
				assertTrue(session().getLocation().contains("http://" + getWikiName() + ".wikia.com/wiki/"));
				
				enforceWebsite("http://" + getWikiName() + ".wikia.com/");
			} else {
				waitForTextPresent("Your wiki has been created!", this.getTimeout(), "Wiki has not been created, language: " + languages[i]);
				clickAndWait("//div[@class='awc-domain']/a");

				assertTrue(session().getLocation().contains("http://" + languages[i] + "." + getWikiName() + ".wikia.com/"));
				assertTrue(session().getLocation().contains(":WikiActivity"));
				
				enforceWebsite("http://" + languages[i] + "." + getWikiName() + ".wikia.com/wiki/");
			}
			
			editArticle("A new article", "Lorem ipsum dolor sit amet");
			session().open("index.php?title=A_new_article");
			assertTrue(session().isTextPresent("Lorem ipsum dolor sit amet"));
			editArticle("A new article", "consectetur adipiscing elit");
			session().open("index.php?title=A_new_article");
			assertFalse(session().isTextPresent("Lorem ipsum dolor sit amet"));
			assertTrue(session().isTextPresent("consectetur adipiscing elit"));
		}
	}

	@Test(groups={"envProduction"},dependsOnMethods={"testCreateWikiAsLoggedInUser"},alwaysRun=true)
	public void cleanupTestCreateWikiAsLoggedInUser() throws Exception {
		loginAsStaff();

		String[] languages = getTestConfig().getStringArray("ci.extension.wikia.AutoCreateWiki.lang");

		for (int i = languages.length - 1; i >= 0; i--) {
			deleteWiki(languages[i]);
		}

		wikiName = null;
	}

	@Test(groups={"envProduction"},dependsOnMethods={"cleanupTestCreateWikiAsLoggedInUser"})
	public void testCreateWikiAsLoggedOutUserLoginWhileCreating() throws Exception {
		session().open("");
		session().waitForPageToLoad(this.getTimeout());
		clickAndWait("link=Start a wiki");

		session().type("wiki-name", getWikiName());
		session().type("wiki-domain", getWikiName());
		session().select("wiki-category", "label=regexp:^.*Other");
		session().select("wiki-language", "label=regexp:^.*Polski");

		session().click("AWClogin");
		waitForElement("AjaxLoginBox");
		session().type("wpName2Ajax", getTestConfig().getString("ci.user.wikiastaff.username"));
		session().type("wpPassword2Ajax", getTestConfig().getString("ci.user.wikiastaff.password"));
		session().click("wpLoginattempt");
		session().waitForPageToLoad(this.getTimeout());

		assertEquals(session().getValue("wiki-name"), getWikiName());
		assertEquals(session().getValue("wiki-domain"), getWikiName());

		clickAndWait("wiki-submit");
		waitForTextPresent("Your wiki has been created!");

		clickAndWait("//div[@class='awc-domain']/a");

		assertEquals("http://pl." + getWikiName() + ".wikia.com/wiki/Specjalna:WikiActivity", session().getLocation());
	}

	@Test(groups={"envProduction"},dependsOnMethods={"testCreateWikiAsLoggedOutUserLoginWhileCreating"},alwaysRun=true)
	public void cleanupTestCreateWikiAsLoggedOutUserLoginWhileCreating() throws Exception {
		loginAsStaff();
		deleteWiki("pl");

		wikiName = null;
	}

	@Test(groups={"envProduction"},dependsOnMethods={"cleanupTestCreateWikiAsLoggedOutUserLoginWhileCreating"})
	public void testCreateWikiAsLoggedOutUserRegisterWhileCreating() throws Exception {
		session().open("");
		session().waitForPageToLoad(this.getTimeout());
		clickAndWait("link=Start a wiki");

		session().type("wiki-name", getWikiName());
		session().type("wiki-domain", getWikiName());
		session().select("wiki-category", "label=regexp:^.*Other");
		session().select("wiki-language", "label=regexp:^.*Polski");

		String time = Long.toString((new Date()).getTime());
		String password = Long.toString(Math.abs(new Random().nextLong()), 36).toLowerCase();
		String captchaWord = getWordFromCaptchaId(session().getValue("wpCaptchaId"));

		session().type("wiki-username", TEST_USER_PREFIX + time);
		session().type("wiki-email", String.format(TEST_EMAIL_FORMAT, time));
		session().type("wiki-password", password);
		session().type("wiki-retype-password", password);
		session().select("wiki-user-year", "1900");
		session().select("wiki-user-month", "1");
		session().select("wiki-user-day", "1");
		session().type("wpCaptchaWord", captchaWord);

		clickAndWait("wiki-submit");
		waitForTextPresent("Your wiki has been created!");

		clickAndWait("//div[@class='awc-domain']/a");

		assertEquals("http://pl." + getWikiName() + ".wikia.com/wiki/Specjalna:WikiActivity", session().getLocation());
	}

	@Test(groups={"envProduction"},dependsOnMethods={"testCreateWikiAsLoggedOutUserRegisterWhileCreating"},alwaysRun=true)
	public void cleanupTestCreateWikiAsLoggedOutUserRegisterWhileCreating() throws Exception {
		loginAsStaff();
		deleteWiki("pl");

		wikiName = null;
	}

	public void deleteWiki(String language) throws Exception {
		session().open("http://community.wikia.com/wiki/Special:WikiFactory");
		session().waitForPageToLoad(this.getTimeout());

		session().type("citydomain", language + "." + getWikiName() + ".wikia.com");
		clickAndWait("//form[@id='WikiFactoryDomainSelector']//button");

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
