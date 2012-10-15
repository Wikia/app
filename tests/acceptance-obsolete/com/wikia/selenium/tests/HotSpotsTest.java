package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

import org.testng.annotations.Test;

public class HotSpotsTest extends BaseTest {

	@Test(groups={"CI"})
	public void testHotSpots() throws Exception {
		loginAsRegular();
		session().open("/wiki/Special:WikiActivity");
		session().waitForPageToLoad(this.getTimeout());
		
		// Hot Spots Module elements
		assertTrue(session().isElementPresent("//section[contains(@class,'HotSpotsModule')]"));
		assertTrue(session().isElementPresent("//section[contains(@class,'HotSpotsModule')]/ul/li[1]"));
		assertTrue(session().isElementPresent("//section[contains(@class,'HotSpotsModule')]/ul/li[1]/span/a[@class='title']"));		
	}
}
