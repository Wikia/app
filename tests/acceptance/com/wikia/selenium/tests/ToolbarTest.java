package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertTrue;

import org.testng.annotations.Test;

public class ToolbarTest extends BaseTest {

	public static String randomArticlePath = "index.php?title=Special:Random";
	
	/**
	 * selenium training test
	 */ 
	////@Test
	public void testEditToolbarEntry() throws Exception {
		login();
		openAndWait(randomArticlePath);
		
		logout();
	}
	
	//@Test(groups={"envProduction","verified"})
	public void testEnsuresThatToolbarIsNotPresentForAnonymousUsers() throws Exception {
		//Written by Aga Serowiec 02-Feb-2012
		openAndWait("/");
		assertTrue(session().isElementPresent("WikiaFooter"));
		assertFalse(session().isElementPresent("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]"));
	}

	//@Test(groups={"envProduction","verified"})
	public void testResetsDefaultsInCustomizedToolbar() throws Exception {
		//Written by Aga Serowiec 02-Feb-2012
		openAndWait("/");
		login();
		session().click("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]//a[@data-name='customize']");
		waitForElement("css=section#MyToolsConfigurationWrapper span.reset-defaults");
		session().click("css=section#MyToolsConfigurationWrapper span.reset-defaults a");

		assertFalse(session().isElementPresent("//section[contains(@class, 'modalContent')]//ul[contains(@class, 'options-list ui-sortable')]//li[@data-caption='Edit']"));
		session().click("//section[@id='MyToolsConfigurationWrapper']//div[contains(@class, 'buttons')]/input[@type='submit']");
		logout();
		
		loginAsRegular();
		session().click("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]//a[@data-name='customize']");
		waitForElement("//section[@id='MyToolsConfigurationWrapper']");
		session().click("//section[@id='MyToolsConfigurationWrapper']//a[@href='#']");
		assertFalse(session().isElementPresent("//section[contains(@class, 'modalContent')]//ul[contains(@class, 'options-list ui-sortable')]//li[@data-caption='Edit']"));
		session().click("//section[@id='MyToolsConfigurationWrapper']//div[contains(@class, 'buttons')]/input[@type='submit']");
		logout();
		
	}
	
	
	//@Test(groups={"envProduction","verified"},dependsOnMethods={"testResetsDefaultsInCustomizedToolbar"},alwaysRun=false)
	public void testEnsuresThatSignedInUserCanAddAnItemToCustomizedToolbar() throws Exception {
		//Written by Aga Serowiec 02-Feb-2012
		
		openAndWait("/");	
		login();
		assertTrue(session().isElementPresent("WikiaFooter"));
		
		//"ul.tools a.tools-customize"
		
		assertTrue(session().isElementPresent("footer#WikiaFooter div.toolbar"));
		//assertTrue(session().isElementPresent("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]"));
		
		//footer#WikiaFooter div.toolbar
		session().click("ul.tools link=Customize");
		waitForElement("//section[@id='MyToolsConfigurationWrapper']");
		session().click("//section[@id='MyToolsConfigurationWrapper']//div[contains(@class, 'popular-toggle toggle-1')]");
		waitForElementVisible("//section[@id='MyToolsConfigurationWrapper']//ul[contains(@class, 'popular-list')]");
		session().click("//section[@id='MyToolsConfigurationWrapper']//ul[contains(@class, 'popular-list')]//a[@data-tool-id='PageAction:Edit']");
		waitForElement("//section[@id='MyToolsConfigurationWrapper']//ul[contains(@class, 'options-list ui-sortable')]//li[@data-tool-id='PageAction:Edit']");
		assertTrue(session().isVisible("//section[@id='MyToolsConfigurationWrapper']//ul[contains(@class, 'options-list ui-sortable')]//li[@data-tool-id='PageAction:Edit']"));
		session().click("//section[@id='MyToolsConfigurationWrapper']//div[contains(@class, 'buttons')]/input[@type='submit']");
		waitForElement("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]//a[@data-name='edit']");
		assertTrue(session().isVisible("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]//a[@data-name='edit']"));
		logout();
		
		loginAsRegular();
		assertFalse(session().isElementPresent("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]//a[@data-name='edit']"));
		logout();
		
		login();
		assertTrue(session().isElementPresent("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]//a[@data-name='edit']"));
		logout();
		
		
		openAndWait("/");
		loginAsRegular();
		openAndWait("wiki/Special:Upload");
		session().click("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]//a[@data-name='customize']");
		waitForElement("//section[@id='MyToolsConfigurationWrapper']");
		session().click("//section[@id='MyToolsConfigurationWrapper']//div[contains(@class, 'popular-toggle toggle-1')]");
		waitForElementVisible("//section[@id='MyToolsConfigurationWrapper']//ul[contains(@class, 'popular-list')]");
		session().click("//section[@id='MyToolsConfigurationWrapper']//ul[contains(@class, 'popular-list')]//a[@data-tool-id='PageAction:Edit']");
		waitForElement("//section[@id='MyToolsConfigurationWrapper']//ul[contains(@class, 'options-list ui-sortable')]//li[@data-tool-id='PageAction:Edit']");
		assertTrue(session().isVisible("//section[@id='MyToolsConfigurationWrapper']//ul[contains(@class, 'options-list ui-sortable')]//li[@data-tool-id='PageAction:Edit']"));
		session().click("//section[@id='MyToolsConfigurationWrapper']//div[contains(@class, 'buttons')]/input[@type='submit']");
		waitForElementNotPresent("//section[@id='MyToolsConfigurationWrapper']");
		waitForElement("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]");
		assertFalse(session().isElementPresent("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]//a[@data-name='edit']"));
		
		editArticle("toolbartest", "testujemy toolbar");
		waitForElement("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]");
		assertTrue(session().isVisible("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]//a[@data-name='edit']"));
		logout();
	}
	
//@Test(groups={"envProduction","verified"},dependsOnMethods={"testResetsDefaultsInCustomizedToolbar"},alwaysRun=false)
	@Test(groups={"envProduction","verified"}
	public void testVerifiesThatSignedInUserCanDeleteAnItemInCustomizedToolbar() throws Exception {
		//WIP Written by Patrick Archbold 10-Apr-2012
		
		//openAndWait("/");	
		openAndWait(randomArticlePath);
		login();
		assertTrue(session().isElementPresent("WikiaFooter"));
		
		//"ul.tools a.tools-customize"
		
		assertTrue(session().isElementPresent("footer#WikiaFooter div.toolbar"));
		//assertTrue(session().isElementPresent("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]"));
		
		//footer#WikiaFooter div.toolbar
		session().click("ul.tools link=Customize");
		//waitForElement("//section[@id='MyToolsConfigurationWrapper']");
		assertTrue(session().isElementPresent("section#MyToolsConfigurationWrapper"));
		
		//waitForElement("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]//a[@data-name='edit']");
		//assertTrue(session().isVisible("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]//a[@data-name='edit']"));
		logout();
		
		//loginAsRegular();
		//assertFalse(session().isElementPresent("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]//a[@data-name='edit']"));
		//logout();
		
		//login();
		//assertTrue(session().isElementPresent("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]//a[@data-name='edit']"));
		//logout();
		
		
		
		//editArticle("toolbartest", "testujemy toolbar");
		//waitForElement("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]");
		//assertTrue(session().isVisible("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]//a[@data-name='edit']"));
		//logout();
	}
}