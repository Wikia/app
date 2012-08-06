package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.*;

import org.testng.annotations.Test;

public class MyToolsTest extends BaseTest {
	@Test(groups={"CI", "legacy"})
	public void testMyTools() throws Exception {
		session().open("index.php");
		session().waitForPageToLoad(this.getTimeout());

		assertFalse(session().isElementPresent("//li[contains(@class, 'mytools')]"));

		loginAsRegular();

		assertTrue(session().isElementPresent("//li[contains(@class, 'mytools')]"));
	}
}
