package com.wikia.selenium.tests;

import java.util.Date;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

public class SignupTest extends BaseTest {

	@Test(groups={"CI"})
	public void testLogin() throws Exception {
		session().open("index.php?title=Special:Signup&type=login");
		session().type("wpName2Ajax", getTestConfig().getString("ci.user.wikiabot.username"));
		session().type("wpPassword2Ajax", getTestConfig().getString("ci.user.wikiabot.password"));
		session().click("wpLoginattempt");
		session().waitForPageToLoad(TIMEOUT);

		if(isOasis()) {
			waitForElement("//ul[@id='AccountNavigation']/li/a[contains(., '" + getTestConfig().getString("ci.user.wikiabot.username") + "')]");
		} else {
			waitForElement("//span[@id=\"header_username\"]/a[text() = \"" + getTestConfig().getString("ci.user.wikiabot.username") + "\"]");
		}
	}

	@Test(groups={"CI"})
	public void testReLogin() throws Exception {
		login();
		logout();
		loginAsStaff();
		logout();
		loginAsSysop();
		logout();
	}

	@Test(groups={"CI"})
	public void testMailNewPassword() throws Exception {
		session().open("index.php?title=Special:Signup&type=login");
		session().type("wpName2Ajax", getTestConfig().getString("ci.user.wikiabot.username"));
		session().click("wpMailmypassword");
		waitForElementVisible("wpError");
		assertTrue(session().isTextPresent("A new password has been sent")
				|| session().isTextPresent("A password reminder has already been sent"));
	}

	@Test(groups={"CI"})
	public void testSignupWrongPassword() throws Exception {
		session().open("index.php?title=Special:Signup&type=signup");
		session().waitForPageToLoad(TIMEOUT);

		String username = getTestConfig().getString("ci.user.wikiabot.username") + Long.toString((new Date()).getTime());
		String captchaWord = getWordFromCaptchaId(session().getValue("wpCaptchaId"));

		session().type("wpName2", username);
		session().type("wpPassword2", getTestConfig().getString("ci.user.wikiabot.username") + "12345");
		session().type("wpRetype", getTestConfig().getString("ci.user.wikiabot.username") + "1234");
		session().select("wpBirthYear", "label=1984");
		session().select("wpBirthMonth", "label=1");
		session().select("wpBirthDay", "label=1");
		session().type("wpCaptchaWord", captchaWord);
		session().uncheck("wpMarketingOptIn");
		if(session().isElementPresent("//input[@id='wpCreateaccountX']")){
			session().click("//input[@id='wpCreateaccountX']"); // old method in trunk (can be removed after fbconnect is merged to trunk)
		} else {
			session().click("//input[@id='wpCreateaccountXSteer']"); // method for after fbconnect changes
		}

		// First id is for pre-fbconnect code (trunk at the time of this writing), second id is for fbconnect changes
		waitForElementVisible("//div[@id=\"userloginInnerErrorBox\" or @id=\"userloginErrorBox\"]");
		assertTrue(session().isTextPresent("Your password entries do not match."));
	}
}
