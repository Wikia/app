package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.*;

import org.testng.annotations.Test;

public class MyToolsTest extends BaseTest {
	@Test(groups={"oasis", "CI"})
	public void testMyTools() throws Exception {
		session().open("index.php");
		session().waitForPageToLoad(TIMEOUT);

		assertFalse(session().isElementPresent("//li[@class='mytools']"));

		loginAsRegular();

		assertTrue(session().isElementPresent("//li[@class='mytools']"));
	}
}
