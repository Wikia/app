package com.wikia.selenium.tests;

import java.util.Date;
import java.util.Random;
import org.openqa.selenium.*;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.support.ui.WebDriverWait;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.testng.annotations.Test;
import static org.testng.AssertJUnit.*;

public class LogInTest extends WebDriverTest {
	
	@Test(groups={"CI", "verified"})
	public void testLogInUsingGlobalNavDropDown() throws Exception {
		openAndWait("/wiki/Special:Random");
		String title = (String) driver().executeScript("return typeof(window !== 'undefined') ? window.wgTitle : '';");
		
		assertFalse( isElementPresentByCssSelector( "footer#WikiaFooter div.toolbar" ) );
		
		hoverMouseOverByCssSelector( "header#WikiaHeader a.ajaxLogin" );
		waitForVisibilityByCssSelector( "div#UserLoginDropdown.show input[name='username']" );
		
		WebElement usernameField = driver().findElement( By.cssSelector( "div#UserLoginDropdown input[name='username']" ) );
		usernameField.sendKeys( getTestConfig().getString("ci.user.regular.username") );
		WebElement passwordField = driver().findElement( By.cssSelector( "div#UserLoginDropdown input[name='password']" ) );
		passwordField.sendKeys( getTestConfig().getString("ci.user.regular.password") );
		WebElement loginButton = driver().findElement( By.cssSelector( "div#UserLoginDropdown input[type='submit']" ) );
		clickAndWait( loginButton );
		
		assertFalse( isElementPresentByCssSelector( "header#WikiaHeader a.ajaxLogin" ) );
		assertTrue( isElementPresentByCssSelector( "ul#AccountNavigation a[href='/wiki/User:" + getTestConfig().getString("ci.user.regular.username") + "']" ) );
		assertTrue( isElementPresentByCssSelector( "footer#WikiaFooter div.toolbar" ) );
		assertEquals(title, (String) driver().executeScript( "return typeof(window !== 'undefined') ? window.wgTitle : '';" ) );
		
		hoverMouseOverByCssSelector( "ul#AccountNavigation a[href='/wiki/User:" + getTestConfig().getString("ci.user.regular.username") +"']" );
		waitForVisibilityByCssSelector( "ul#AccountNavigation ul.show a[data-id='logout']" );
		WebElement logoutButton = driver().findElement( By.cssSelector( "ul#AccountNavigation a[data-id='logout']" ) );
		// ??? sprawdzic co bedzie szybsze - od dom ready czy ajaxLogin
		//clickAndWait( logoutButton ); // instead of waiting for the DomReady, we just wait for the plain page, should be faster in this case (as we skip ads and JS)
		logoutButton.click();
		waitForPresenceByCssSelector( "header#WikiaHeader a.ajaxLogin" );
		
		assertFalse( isElementPresentByCssSelector( "footer#WikiaFooter div.toolbar" ) );
		assertTrue( isElementPresentByCssSelector( "header#WikiaHeader a.ajaxLogin" ) );
		assertEquals(title, (String) driver().executeScript( "return typeof(window !== 'undefined') ? window.wgTitle : '';" ) );
	}
	/*
	@Test(groups={"CI", "legacy"})
	public void testLogInUsingForcedDialog() throws Exception {
		openAndWait("/wiki/Special:NewFiles");
		
		String title = session().getEval("window.wgTitle");
		
		assertFalse(session().isElementPresent("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]"));
		
		session().click("//a[contains(@class,'upphotoslogin')]");
		waitForElement("//section[@class='modalWrapper']//div[@class='UserLoginModal']");
		
		session().type("//section[@class='modalWrapper']//div[@class='UserLoginModal']//input[@name='username']", getTestConfig().getString("ci.user.regular.username"));
		session().type("//section[@class='modalWrapper']//div[@class='UserLoginModal']//input[@name='password']", getTestConfig().getString("ci.user.regular.password"));
		clickAndWait("//section[@class='modalWrapper']//div[@class='UserLoginModal']//input[@type='submit']");
		
		assertFalse(session().isElementPresent("//header[@id='WikiaHeader']//a[@class='ajaxLogin']"));
		assertTrue(session().isElementPresent("//ul[@id='AccountNavigation']//a[@href='/wiki/User:" + getTestConfig().getString("ci.user.regular.username") + "']"));
		assertTrue(session().isElementPresent("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]"));
		assertEquals(title, session().getEval("window.wgTitle"));
		
		session().mouseOver("//ul[@id='AccountNavigation']//a[@href='/wiki/User:" + getTestConfig().getString("ci.user.regular.username") + "']");
		waitForElementVisible("//ul[@id='AccountNavigation']//ul[contains(@class, 'WikiaMenuElement')]");
		clickAndWait("//ul[@id='AccountNavigation']//a[@data-id='logout']");
		
		assertFalse(session().isElementPresent("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]"));
		assertTrue(session().isElementPresent("//header[@id='WikiaHeader']//a[@class='ajaxLogin']"));
		assertEquals(title, session().getEval("window.wgTitle"));
	}

	@Test(groups={"CI", "legacy"})
	public void testLogInUsingLoginPage() throws Exception {
		openAndWait("/wiki/Special:UserLogin");
		
		String title = session().getEval("window.wgTitle");
		
		assertFalse(session().isElementPresent("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]"));
		
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='username']", getTestConfig().getString("ci.user.regular.username"));
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='password']", getTestConfig().getString("ci.user.regular.password"));
		clickAndWait("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@type='submit']");
		
		assertFalse(session().isElementPresent("//header[@id='WikiaHeader']//a[@class='ajaxLogin']"));
		assertTrue(session().isElementPresent("//ul[@id='AccountNavigation']//a[@href='/wiki/User:" + getTestConfig().getString("ci.user.regular.username") + "']"));
		assertTrue(session().isElementPresent("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]"));
		assertFalse(session().getEval("window.wgTitle").equals(title));
		assertTrue(session().getEval("window.wgIsMainpage ? 'true' : 'false'").equals("true"));

		String afterLoginTitle = session().getEval("window.wgTitle");
		
		session().mouseOver("//ul[@id='AccountNavigation']//a[@href='/wiki/User:" + getTestConfig().getString("ci.user.regular.username") + "']");
		waitForElementVisible("//ul[@id='AccountNavigation']//ul[contains(@class, 'WikiaMenuElement')]");
		clickAndWait("//ul[@id='AccountNavigation']//a[@data-id='logout']");
		
		assertFalse(session().isElementPresent("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]"));
		assertTrue(session().isElementPresent("//header[@id='WikiaHeader']//a[@class='ajaxLogin']"));
		assertEquals(afterLoginTitle, session().getEval("window.wgTitle"));
	}

	@Test(groups={"CI", "legacy"})
	public void testLogInVariousUsers() throws Exception {
		// regular
		openAndWait("/wiki/Special:UserLogin");
		
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='username']", getTestConfig().getString("ci.user.regular.username"));
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='password']", getTestConfig().getString("ci.user.regular.password"));
		clickAndWait("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@type='submit']");
		
		assertTrue(session().isElementPresent("//ul[@id='AccountNavigation']//a[@href='/wiki/User:" + getTestConfig().getString("ci.user.regular.username") + "']"));
		clickAndWait("//ul[@id='AccountNavigation']//a[@data-id='logout']");
		
		// bot
		openAndWait("/wiki/Special:UserLogin");
		
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='username']", getTestConfig().getString("ci.user.wikiabot.username"));
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='password']", getTestConfig().getString("ci.user.wikiabot.password"));
		clickAndWait("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@type='submit']");
		
		assertTrue(session().isElementPresent("//ul[@id='AccountNavigation']//a[@href='/wiki/User:" + getTestConfig().getString("ci.user.wikiabot.username") + "']"));
		clickAndWait("//ul[@id='AccountNavigation']//a[@data-id='logout']");
		
		// staff
		openAndWait("/wiki/Special:UserLogin");
		
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='username']", getTestConfig().getString("ci.user.wikiastaff.username"));
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='password']", getTestConfig().getString("ci.user.wikiastaff.password"));
		clickAndWait("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@type='submit']");
		
		assertTrue(session().isElementPresent("//ul[@id='AccountNavigation']//a[@href='/wiki/User:" + getTestConfig().getString("ci.user.wikiastaff.username") + "']"));
		clickAndWait("//ul[@id='AccountNavigation']//a[@data-id='logout']");
		
		// sysop
		openAndWait("/wiki/Special:UserLogin");
		
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='username']", getTestConfig().getString("ci.user.wikiasysop.username"));
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='password']", getTestConfig().getString("ci.user.wikiasysop.password"));
		clickAndWait("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@type='submit']");
		
		assertTrue(session().isElementPresent("//ul[@id='AccountNavigation']//a[@href='/wiki/User:" + getTestConfig().getString("ci.user.wikiasysop.username") + "']"));
		clickAndWait("//ul[@id='AccountNavigation']//a[@data-id='logout']");
	}

	@Test(groups={"CI", "legacy"})
	public void testForcedLoginDialogErrorMessages() throws Exception {
		openAndWait("/wiki/Special:NewFiles");
		
		String title = session().getEval("window.wgTitle");
		
		assertFalse(session().isElementPresent("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]"));
		
		session().click("//a[contains(@class,'upphotoslogin')]");
		waitForElement("//section[@class='modalWrapper']//div[@class='UserLoginModal']");
		
		// no username
		session().click("//section[@class='modalWrapper']//div[@class='UserLoginModal']//input[@type='submit']");

		waitForTextPresent("Oops, please fill in the username field.");
		assertTrue(session().isVisible("//section[@class='modalWrapper']//div[@class='UserLoginModal']"));

		// non-existent username
		Random random = new Random();
		String username = "";
		for (int i = 0; i < 10; i++) {
			username += String.valueOf((char) (97 + random.nextInt(25)));
		}
		
		session().type("//section[@class='modalWrapper']//div[@class='UserLoginModal']//input[@name='username']", username);
		session().click("//section[@class='modalWrapper']//div[@class='UserLoginModal']//input[@type='submit']");
		waitForTextPresent("Hm, we don't recognize this name. Don't forget usernames are case sensitive.");
		assertTrue(session().isVisible("//section[@class='modalWrapper']//div[@class='UserLoginModal']"));

		// existing username, no password
		session().type("//section[@class='modalWrapper']//div[@class='UserLoginModal']//input[@name='username']", getTestConfig().getString("ci.user.regular.username"));
		session().click("//section[@class='modalWrapper']//div[@class='UserLoginModal']//input[@type='submit']");
		waitForTextPresent("Oops, please fill in the password field.");
		assertTrue(session().isVisible("//section[@class='modalWrapper']//div[@class='UserLoginModal']"));

		// invalid password
		String password = "";
		for (int i = 0; i < 10; i++) {
			password += String.valueOf((char) (97 + random.nextInt(25)));
		}

		session().type("//section[@class='modalWrapper']//div[@class='UserLoginModal']//input[@name='username']", getTestConfig().getString("ci.user.regular.username"));
		session().type("//section[@class='modalWrapper']//div[@class='UserLoginModal']//input[@name='password']", password);
		session().click("//section[@class='modalWrapper']//div[@class='UserLoginModal']//input[@type='submit']");
		waitForTextPresent("Oops, wrong password. Make sure caps lock is off and try again.");
		assertTrue(session().isVisible("//section[@class='modalWrapper']//div[@class='UserLoginModal']"));
	}

	@Test(groups={"CI", "legacy"})
	public void testLoginPageErrorMessages() throws Exception {
		openAndWait("/wiki/Special:UserLogin");
		
		String title = session().getEval("window.wgTitle");
		
		assertFalse(session().isElementPresent("//footer[@id='WikiaFooter']//div[contains(@class, 'toolbar')]"));
		
		// no username
		clickAndWait("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@type='submit']");

		waitForTextPresent("Oops, please fill in the username field.");

		// non-existent username
		Random random = new Random();
		String username = "";
		for (int i = 0; i < 10; i++) {
			username += String.valueOf((char) (97 + random.nextInt(25)));
		}
		
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='username']", username);
		clickAndWait("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@type='submit']");
		waitForTextPresent("Hm, we don't recognize this name. Don't forget usernames are case sensitive.");

		// existing username, no password
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='username']", getTestConfig().getString("ci.user.regular.username"));
		clickAndWait("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@type='submit']");
		waitForTextPresent("Oops, please fill in the password field.");

		// invalid password
		String password = "";
		for (int i = 0; i < 10; i++) {
			password += String.valueOf((char) (97 + random.nextInt(25)));
		}

		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='username']", getTestConfig().getString("ci.user.regular.username"));
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='password']", password);
		clickAndWait("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@type='submit']");
		waitForTextPresent("Oops, wrong password. Make sure caps lock is off and try again.");
	}
	
	@Test(groups={"CI", "legacy"})
	public void testSendingNewPassword() throws Exception {
		openAndWait("/wiki/Special:UserLogin");

		// no username
		clickAndWait("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[contains(@class,'forgot-password')]");
		assertTrue(session().isTextPresent("Oops, please fill in the username field."));
		
		// non-existent username
		Random random = new Random();
		String username = "";
		for (int i = 0; i < 10; i++) {
			username += String.valueOf((char) (97 + random.nextInt(25)));
		}
		
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='username']", username);
		clickAndWait("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[contains(@class,'forgot-password')]");
		assertTrue(session().isTextPresent("Hm, we don't recognize this name. Don't forget usernames are case sensitive."));

		// existing username
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='username']", getTestConfig().getString("ci.user.regular.username"));
		clickAndWait("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[contains(@class,'forgot-password')]");
		assertTrue(session().isTextPresent("We've sent a new password to the email address for WikiaUser."));
		
		// user should be still able to login
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='username']", getTestConfig().getString("ci.user.regular.username"));
		session().type("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@name='password']", getTestConfig().getString("ci.user.regular.password"));
		clickAndWait("//div[@class='WikiaArticle']//div[@class='UserLogin']//input[@type='submit']");
	}
	*/
}
