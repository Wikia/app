package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

import org.testng.annotations.Test;

public class RandomPageTest extends BaseTest {
	@Test(groups={"CI"})
	public void testHitRandom() throws Exception {
		for (int i = 1; i <= 5; i++) {
			session().open("index.php?title=Special:Random");
			assertTrue(session().isTextPresent(isOasis() ? "Wiki Activity" : "Latest activity"));
		}
	}
}
