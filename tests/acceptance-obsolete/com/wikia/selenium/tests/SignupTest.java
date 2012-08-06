package com.wikia.selenium.tests;

import java.util.Date;
import java.util.Random;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.*;

public class SignupTest extends BaseTest {
	public static final String TEST_USER_PREFIX = "WikiaTestAccount";
	public static final String TEST_EMAIL_FORMAT = "WikiaTestAccount%s@wikia-inc.com";

	private static final String INPUT_USERNAME = "//form[@id='WikiaSignupForm']//input[@name='username']";
	private static final String INPUT_EMAIL = "//form[@id='WikiaSignupForm']//input[@name='email']";
	private static final String INPUT_PASSWORD = "//form[@id='WikiaSignupForm']//input[@name='password']";
	private static final String INPUT_BIRTHYEAR = "//form[@id='WikiaSignupForm']//select[@name='birthyear']";
	private static final String INPUT_BIRTHMONTH = "//form[@id='WikiaSignupForm']//select[@name='birthmonth']";
	private static final String INPUT_BIRTHDAY = "//form[@id='WikiaSignupForm']//select[@name='birthday']";
	private static final String INPUT_CAPTCHAID = "//form[@id='WikiaSignupForm']//input[@id='wpCaptchaId']";
	private static final String INPUT_CAPTCHAWORD = "//form[@id='WikiaSignupForm']//input[@id='wpCaptchaWord']";
	private static final String IMAGE_CAPTCHAWORD = "//form[@id='WikiaSignupForm']//img[contains(@src,'Special:Captcha')]";
	private static final String LINK_TERMS = "//form[@id='WikiaSignupForm']//a[contains(@href, 'Terms_of_use')]";
	private static final String INPUT_SUBMIT = "//form[@id='WikiaSignupForm']//input[@type='submit']";

	@Test(groups={"CI", "legacy"})
	public void testSignupPageElements() throws Exception {
		openAndWait("/wiki/Special:UserSignup");

		// log in link
		assertTrue(session().isElementPresent("//div[@id='WikiaArticle']//div[@class='wiki-info']//a[contains(@href, '/wiki/Special:UserLogin')]"));

		// sign up form
		assertTrue(session().isElementPresent(INPUT_USERNAME));
		assertTrue(session().isElementPresent(INPUT_EMAIL));
		assertTrue(session().isElementPresent(INPUT_PASSWORD));
		assertTrue(session().isElementPresent(INPUT_BIRTHYEAR));
		assertTrue(session().isElementPresent(INPUT_BIRTHMONTH));
		assertTrue(session().isElementPresent(INPUT_BIRTHDAY));
		assertTrue(session().isElementPresent(INPUT_CAPTCHAID));
		assertTrue(session().isElementPresent(INPUT_CAPTCHAWORD));
		assertTrue(session().isElementPresent(IMAGE_CAPTCHAWORD));
		assertTrue(session().isElementPresent(LINK_TERMS));
		assertTrue(session().isElementPresent(INPUT_SUBMIT));
		assertTrue(session().isElementPresent("//div[@id='WikiaArticle']//a[@data-id='facebook']"));
	}

	@Test(groups={"CI", "legacy"})
	public void testSignupErrorMessages() throws Exception {
		Random random = new Random();
		String sufix = "";
		for (int i = 0; i < 10; i++) {
			sufix += String.valueOf((char) (97 + random.nextInt(25)));
		}

		String validUsername          = TEST_USER_PREFIX + sufix;
		String validEmail             = String.format(TEST_EMAIL_FORMAT, sufix);
		String validPassword          = getTestConfig().getString("ci.user.wikiastaff.password");
		String existingUsername       = getTestConfig().getString("ci.user.wikiastaff.username");
		String phalanxBlockedUsername = PhalanxTest.badWord + sufix;
		String invalidEmail           = "this is not valid email address";
		String tooLongUsername        = "";
		for (int i = 0; i <= 50; i++) { tooLongUsername += String.valueOf((char) (97 + random.nextInt(25))); }

		openAndWait("/wiki/Special:UserSignup");

		// no username
		clickAndWait(INPUT_SUBMIT);
		assertTrue(session().isTextPresent("Oops, please fill in the username field."));

		// no password
		session().type(INPUT_USERNAME, validUsername);
		clickAndWait(INPUT_SUBMIT);
		assertTrue(session().isTextPresent("Oops, please fill in the password field."));
		assertEquals(validUsername, session().getValue(INPUT_USERNAME));

		// no email
		session().type(INPUT_PASSWORD, validPassword);
		clickAndWait(INPUT_SUBMIT);
		assertTrue(session().isTextPresent("Oops, please fill in your email address."));
		assertEquals("", session().getValue(INPUT_PASSWORD));

		// invalid email address
		session().type(INPUT_EMAIL, invalidEmail);
		session().type(INPUT_PASSWORD, validPassword);
		clickAndWait(INPUT_SUBMIT);
		assertTrue(session().isTextPresent("Please enter a valid email address."));
		assertEquals(invalidEmail, session().getValue(INPUT_EMAIL));

		// no birth date
		session().type(INPUT_EMAIL, validEmail);
		session().type(INPUT_PASSWORD, validPassword);
		clickAndWait(INPUT_SUBMIT);
		assertTrue(session().isTextPresent("Oops, please fill out month, day, and year."));

		// invalid birth date
		session().type(INPUT_PASSWORD, validPassword);
		session().select(INPUT_BIRTHYEAR, "index=1");
		session().select(INPUT_BIRTHMONTH, "index=1");
		session().select(INPUT_BIRTHDAY, "index=1");
		clickAndWait(INPUT_SUBMIT);
		assertTrue(session().isTextPresent("Sorry, we're not able to register your account at this time."));
		assertEquals("1", session().getSelectedIndex(INPUT_BIRTHYEAR));
		assertEquals("1", session().getSelectedIndex(INPUT_BIRTHMONTH));
		assertEquals("1", session().getSelectedIndex(INPUT_BIRTHDAY));

		// existing username - must fill in whole form!
		session().type(INPUT_USERNAME, existingUsername);
		session().type(INPUT_PASSWORD, validPassword);
		session().select(INPUT_BIRTHYEAR, "index=20");
		clickAndWait(INPUT_SUBMIT);
		assertTrue(session().isTextPresent("Someone already has this username. Try a different one!"));
		assertEquals(existingUsername, session().getValue(INPUT_USERNAME));

		// phalanx blocks username
		session().type(INPUT_USERNAME, phalanxBlockedUsername);
		session().type(INPUT_PASSWORD, validPassword);
		session().type(INPUT_CAPTCHAWORD, getWordFromCaptchaId(session().getValue("wpCaptchaId")));
		clickAndWait(INPUT_SUBMIT);
		assertTrue(session().isTextPresent("This username is not allowed."));

		// too long username (50 chars)
		session().type(INPUT_USERNAME, tooLongUsername);
		session().type(INPUT_PASSWORD, validPassword);
		session().type(INPUT_CAPTCHAWORD, getWordFromCaptchaId(session().getValue("wpCaptchaId")));
		clickAndWait(INPUT_SUBMIT);
		assertTrue(session().isTextPresent("Oops, your username can't be more than 50 characters."));

		// no captcha
		session().type(INPUT_USERNAME, validUsername);
		session().type(INPUT_PASSWORD, validPassword);
		session().type(INPUT_CAPTCHAWORD, "");
		clickAndWait(INPUT_SUBMIT);
		assertTrue(session().isTextPresent("The word you entered didn't match the word in the box, try again!"));

		// password same as username
		session().type(INPUT_USERNAME, validUsername);
		session().type(INPUT_PASSWORD, validUsername);
		session().type(INPUT_CAPTCHAWORD, getWordFromCaptchaId(session().getValue("wpCaptchaId")));
		clickAndWait(INPUT_SUBMIT);
		assertTrue(session().isTextPresent("Your password must be different from your username."));
		assertEquals("", session().getValue(INPUT_PASSWORD));
	}
	
	@Test(groups={"CI", "legacy"})
	public void testSignup() throws Exception {
		Random random = new Random();
		String sufix = "";
		for (int i = 0; i < 10; i++) {
			sufix += String.valueOf((char) (97 + random.nextInt(25)));
		}

		String validUsername = TEST_USER_PREFIX + sufix;
		String validEmail    = String.format(TEST_EMAIL_FORMAT, sufix);
		String validPassword = getTestConfig().getString("ci.user.wikiastaff.password");
		openAndWait("/wiki/Special:UserSignup");

		session().type(INPUT_USERNAME, validUsername);
		session().type(INPUT_EMAIL, validEmail);
		session().type(INPUT_PASSWORD, validPassword);
		session().select(INPUT_BIRTHYEAR, "index=20");
		session().select(INPUT_BIRTHMONTH, "index=1");
		session().select(INPUT_BIRTHDAY, "index=1");
		session().type(INPUT_CAPTCHAWORD, getWordFromCaptchaId(session().getValue("wpCaptchaId")));
		clickAndWait(INPUT_SUBMIT);

		assertEquals("Almost there", session().getText("//div[@id='WikiaArticle']//h2[@class='heading']"));
		assertEquals("Check your email", session().getText("//div[@id='WikiaArticle']//h3[@class='subheading']"));
		assertTrue(session().isElementPresent("//input[@value='Send me another confirmation email']"));
		assertTrue(session().isElementPresent("//a[@class='change-email-link']"));

		openAndWait("index.php?title=Special:UserLogin");
		waitForElement("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='username']");
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='username']", validUsername);
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='password']", validPassword);
		clickAndWait("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@type='submit']");
		assertFalse(isLoggedIn()); 

		assertTrue(session().getLocation().contains("Special:UserSignup&method=sendConfirmationEmail&username=" + validUsername));
		assertEquals("Almost there", session().getText("//div[@id='WikiaArticle']//h2[@class='heading']"));

		openAndWait("/");

		openAndWait("index.php?title=Special:UserLogin");
		waitForElement("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='username']");
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='username']", validUsername);
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='password']", validPassword);
		clickAndWait("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@type='submit']");
		assertFalse(isLoggedIn()); 

		assertTrue(session().getLocation().contains("Special:UserSignup&method=sendConfirmationEmail&username=" + validUsername));
		assertEquals("Almost there", session().getText("//div[@id='WikiaArticle']//h2[@class='heading']"));
	}
}
