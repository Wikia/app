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
		session().waitForPageToLoad(TIMEOUT);
		clickAndWait("link=Start a wiki");
		
		session().type("wiki-name", getWikiName());
		session().type("wiki-domain", getWikiName());
		session().select("wiki-category", "label=regexp:^.*Other");
		session().select("wiki-language", "label=regexp:^.*Polski");
		clickAndWait("wiki-submit");
		
		waitForTextPresent("Your wiki has been created!");
		
		clickAndWait("//div[@class='awc-domain']/a");
		
		assertEquals("http://pl." + getWikiName() + ".wikia.com/wiki/Specjalna:WikiActivity", session().getLocation());
	}
	
	@Test(groups={"envProduction"},dependsOnMethods={"testCreateWikiAsLoggedInUser"})
	public void cleanupTestCreateWikiAsLoggedInUser() throws Exception {
		deleteWiki();
	}

	@Test(groups={"envProduction"},dependsOnMethods={"cleanupTestCreateWikiAsLoggedInUser"})
	public void testCreateWikiAsLoggedOutUser() throws Exception {
		session().open("");
		session().waitForPageToLoad(TIMEOUT);
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
		session().waitForPageToLoad(TIMEOUT);

		assertEquals(session().getValue("wiki-name"), getWikiName());
		assertEquals(session().getValue("wiki-domain"), getWikiName());
		
		clickAndWait("wiki-submit");
		waitForTextPresent("Your wiki has been created!");
		
		clickAndWait("//div[@class='awc-domain']/a");
		
		assertEquals("http://pl." + getWikiName() + ".wikia.com/wiki/Specjalna:WikiActivity", session().getLocation());
	}
	
	@Test(groups={"envProduction"},dependsOnMethods={"testCreateWikiAsLoggedOutUser"})
	public void cleanupTestCreateWikiAsLoggedOutUser() throws Exception {
		deleteWiki();
	}
	
	public void deleteWiki() throws Exception {
		loginAsStaff();
		session().open("http://community.wikia.com/wiki/Special:WikiFactory");
		session().waitForPageToLoad(TIMEOUT);
		
		session().type("citydomain", "pl." + getWikiName() + ".wikia.com");
		clickAndWait("//form[@id='WikiFactoryDomainSelector']//button");
		
		clickAndWait("link=Close");
		
		session().check("flag_1");
		session().check("flag_2");
		session().check("flag_4");
		session().check("flag_8");
		clickAndWait("close_saveBtn");
		
		clickAndWait("close_saveBtn");
		assertTrue(session().isTextPresent("was closed"));
		
		wikiName = null;
	}
}
