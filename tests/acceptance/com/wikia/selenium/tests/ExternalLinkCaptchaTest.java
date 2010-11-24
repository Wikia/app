package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertNotNull;

public class ExternalLinkCaptchaTest extends BaseTest {

	@Test(groups={"CI"})
	public void testIsCaptchaShowedForNotLoggedInUsers() throws Exception {

		editArticle("ExternalLinkTest", "");
		editArticle("ExternalLinkTest", "[[http://www.wp.pl/ www.wp.pl]]");

		// write word from captcha
		String captchaID = session().getValue("wpCaptchaId");
		String captchaWord = getWordFromCaptchaId(captchaID);
		assertNotNull("No captcha word for " + captchaID, captchaWord);
		session().type("wpCaptchaWord", captchaWord);
		session().click("wpSave");
		session().waitForPageToLoad(TIMEOUT);

		assertTrue(session().isTextPresent("www.wp.pl"));
		assertFalse(session().isTextPresent("Incorrect or missing confirmation code."));
		assertFalse(session().isTextPresent("OR: Element wpCaptchaId not found"));
	}
}
