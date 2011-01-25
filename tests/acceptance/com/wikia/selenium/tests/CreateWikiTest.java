package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertEquals;

import java.math.BigInteger;
import java.util.Random;

import org.testng.annotations.Test;

public class CreateWikiTest extends BaseTest {
	private static String wikiName;
	
	private static String getWikiName() {
		if (null == wikiName) {
			wikiName = "testwiki" + Long.toString(Math.abs(new Random().nextLong()), 36).toLowerCase();
		}
		
		return wikiName;
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
				waitForElementVisible("ThemeTab");
				session().click("//input[@value='Save Theme']");
				waitForElementVisible("//section[@id='WikiBuilder']/div/div[@class='step3']");
				session().click("//input[@value='Save Pages']");
				waitForElementVisible("//section[@id='WikiBuilder']/div/div[@class='step4']");
				session().click("//input[@value='Continue to your wiki']");
				
				waitForTextPresent("Welcome to the Wiki", this.getTimeout(), "Wiki has not been created, language: " + languages[i]);
				assertTrue(session().getLocation().contains("http://" + getWikiName() + ".wikia.com/wiki/"));
			} else {
				waitForTextPresent("Your wiki has been created!", this.getTimeout(), "Wiki has not been created, language: " + languages[i]);
				clickAndWait("//div[@class='awc-domain']/a");
		
				assertTrue(session().getLocation().contains("http://" + languages[i] + "." + getWikiName() + ".wikia.com/wiki/"));
				assertTrue(session().getLocation().contains(":WikiActivity"));
			}
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
	public void testCreateWikiAsLoggedOutUser() throws Exception {
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
	
	@Test(groups={"envProduction"},dependsOnMethods={"testCreateWikiAsLoggedOutUser"},alwaysRun=true)
	public void cleanupTestCreateWikiAsLoggedOutUser() throws Exception {
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
