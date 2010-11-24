package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertTrue;

public class CaptchaTest extends BaseTest {

	@Test(groups={"CI"})
	public void testIsCaptchaShows() throws Exception {
		session().open("index.php?title=Special:Signup");
		assertFalse(session().isTextPresent("out of captcha images; this shouldn't happen"));
		assertTrue(session().isElementPresent("//img[@alt='captcha']"));
	}
}
