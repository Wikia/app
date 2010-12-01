package com.wikia.selenium.tests;

import java.io.File;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Parameters;
import org.testng.annotations.Test;

public class RelatedVideoTest extends BaseTest {

	@Test(groups={"CI"})
	public void testFooterSpotlight() throws Exception {
		
		// open any page
		session().open("/wiki/Special:RandomPage");
		session().waitForPageToLoad(TIMEOUT);
		
		// wait for scripts to load
		waitForElement("//div[contains(@class,'WikiaRelatedVideoSpotlightModule')]//div[@class='fmts-img_wrapper']", TIMEOUT);
		
		// click on element
		session().click("//div[contains(@class,'WikiaRelatedVideoSpotlightModule')]//div[@class='fmts-img_wrapper']//a[@class='fmts-btn_click']");
		session().waitForPageToLoad(TIMEOUT);
		
		// is page loaded properly
		waitForElement("//*[@id='FiveminPlayer']", TIMEOUT);
	}
	
	@Test(groups={"CI"})
	public void testRailModule() throws Exception {
		
		// open any page
		session().open("/wiki/Special:RandomPage");
		session().waitForPageToLoad(TIMEOUT);
		
		// wait for scripts to load
		waitForElement("//section[contains(@class,'WikiaRelatedVideoModule')]//div[@class='fmts-img_wrapper']", TIMEOUT);
		
		// click on element
		session().click("//section[contains(@class,'WikiaRelatedVideoModule')]//div[@class='fmts-img_wrapper']//a[@class='fmts-btn_click']");
		session().waitForPageToLoad(TIMEOUT);
		
		// is page loaded properly
		waitForElement("//*[@id='FiveminPlayer']", TIMEOUT);
	}
}
