package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.closeSeleniumSession;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertTrue;

import java.util.ArrayList;
import java.util.Date;
import java.util.Iterator;
import java.util.List;
import java.util.Random;

import org.testng.annotations.BeforeMethod;
import org.testng.annotations.DataProvider;
import org.testng.annotations.Test;

public class CreateWikiTest extends BaseTest {
	public static final String TEST_USER_PREFIX = "WikiaTestAccount";
	public static final String TEST_EMAIL_FORMAT = "WikiaTestAccount%s@wikia-inc.com";
	private static String wikiName;
	private static List<String> languagesTested = new ArrayList<String>();

	@BeforeMethod(alwaysRun=true)
	public void enforceMainWebsite() throws Exception {
		enforceWebsite("http://www.wikia.com");
	}
	
	public void enforceWebsite(String website) throws Exception {
		closeSeleniumSession();
		startSession(this.seleniumHost, this.seleniumPort, this.browser, website, this.timeout, this.noCloseAfterFail, this.seleniumSpeed);
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
	
	@DataProvider(name = "wikiLanguages")
	public Iterator<Object[]> wikiLanguages() throws Exception {
		String[] languages = getTestConfig().getStringArray("ci.extension.wikia.AutoCreateWiki.lang");
		ArrayList al = new ArrayList();
		for (String language : languages) {
			if(!language.equals("en")) {
				al.add(new Object[] { language });
			}
		}
		return al.iterator();
	}

	@Test(groups={"deprecated"},dataProvider="wikiLanguages")
	public void testCreateWikiAsLoggedInUser(String language) throws Exception {
		loginAsStaff();

		session().open("/wiki/Special:CreateWiki?uselang=de");
		session().waitForPageToLoad(this.getTimeout());

		session().type("wiki-name", getWikiName());
		session().type("wiki-domain", getWikiName());
		session().select("wiki-category", "label=regexp:^.*Andere");
		session().select("wiki-language", "label=regexp:^" + language + ":.*$");
		clickAndWait("wiki-submit");
		
		waitForTextPresent("Dein Wiki wurde erstellt!", this.getTimeout(), "Wiki has not been created, language: " + language);
		clickAndWait("//div[@class='awc-domain']/a");

		assertTrue(session().getLocation().contains("http://" + language + "." + getWikiName() + ".wikia.com/"));
		assertTrue(session().getLocation().contains(":WikiActivity"));
			
		enforceWebsite("http://" + language + "." + getWikiName() + ".wikia.com/");
			
		editArticle("A new article", "Lorem ipsum dolor sit amet");
		session().open("index.php?title=A_new_article");
		session().waitForPageToLoad(this.getTimeout());
		assertTrue(session().isTextPresent("Lorem ipsum dolor sit amet"));
		editArticle("A new article", "consectetur adipiscing elit");
		session().open("index.php?title=A_new_article");
		session().waitForPageToLoad(this.getTimeout());
		assertFalse(session().isTextPresent("Lorem ipsum dolor sit amet"));
		assertTrue(session().isTextPresent("consectetur adipiscing elit"));
		
		languagesTested.add(language);
	}

	@Test(groups={"deprecated"},dependsOnMethods={"testCreateWikiAsLoggedInUser"},alwaysRun=true)
	public void cleanupTestCreateWikiAsLoggedInUser() throws Exception {
		loginAsStaff();

		for (String language : languagesTested) {
			deleteWiki(language);
		}

		wikiName = null;
	}

	@Test(groups={"deprecated"})
	public void testCreateWikiAsLoggedOutUserLoginWhileCreating() throws Exception {
		session().open("/wiki/Special:CreateWiki?uselang=de");
		session().waitForPageToLoad(this.getTimeout());

		session().type("wiki-name", getWikiName());
		session().type("wiki-domain", getWikiName());
		session().select("wiki-category", "label=regexp:^.*Andere");
		session().select("wiki-language", "label=regexp:^.*Polski");

		session().click("AWClogin");
		waitForElement("AjaxLoginBox");
		session().type("wpName2Ajax", getTestConfig().getString("ci.user.wikiastaff.username"));
		session().type("wpPassword2Ajax", getTestConfig().getString("ci.user.wikiastaff.password"));
		clickAndWait("wpLoginattempt");
		
		waitForTextPresent("Dein Wiki wurde erstellt!");

		clickAndWait("//div[@class='awc-domain']/a");

		assertEquals("http://pl." + getWikiName() + ".wikia.com/wiki/Specjalna:WikiActivity", session().getLocation());
	}

	@Test(groups={"deprecated"},dependsOnMethods={"testCreateWikiAsLoggedOutUserLoginWhileCreating"},alwaysRun=true)
	public void cleanupTestCreateWikiAsLoggedOutUserLoginWhileCreating() throws Exception {
		loginAsStaff();
		deleteWiki("pl");

		wikiName = null;
	}

	@Test(groups={"deprecated"},dependsOnMethods={"cleanupTestCreateWikiAsLoggedOutUserLoginWhileCreating"})
	public void testCreateWikiAsLoggedOutUserRegisterWhileCreating() throws Exception {
		session().open("/wiki/Special:CreateWiki?uselang=de");
		session().waitForPageToLoad(this.getTimeout());

		session().type("wiki-name", getWikiName());
		session().type("wiki-domain", getWikiName());
		session().select("wiki-category", "label=regexp:^.*Andere");
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
		waitForTextPresent("Dein Wiki wurde erstellt!");

		clickAndWait("//div[@class='awc-domain']/a");

		assertEquals("http://pl." + getWikiName() + ".wikia.com/wiki/Specjalna:WikiActivity", session().getLocation());
	}

	@Test(groups={"deprecated"},dependsOnMethods={"testCreateWikiAsLoggedOutUserRegisterWhileCreating"},alwaysRun=true)
	public void cleanupTestCreateWikiAsLoggedOutUserRegisterWhileCreating() throws Exception {
		loginAsStaff();
		deleteWiki("pl");

		wikiName = null;
	}

	public void deleteWiki(String language) throws Exception {
		session().open("http://community.wikia.com/wiki/Special:WikiFactory");
		session().waitForPageToLoad(this.getTimeout());

		session().type("citydomain", (language.equals("en") ? "" : language + ".") + getWikiName() + ".wikia.com");
		clickAndWait("//form[@id='WikiFactoryDomainSelector']/div/ul/li/button");
		session().waitForPageToLoad(this.getTimeout());
		waitForElementVisible("link=Close", this.getTimeout());
		
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
