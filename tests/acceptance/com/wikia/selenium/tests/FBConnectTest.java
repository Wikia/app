package com.wikia.selenium.tests;

import java.io.File;
import java.util.Random;
import java.util.Date;
import java.util.ArrayList;
import java.text.SimpleDateFormat;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Parameters;
import org.testng.annotations.Test;

public class FBConnectTest extends BaseTest {

	/**
	 * Make sure that the FBConnect button renders everywhere it's supposed to.
	 *
	 * For now this is the main test (other tests would leave data artifacts).
	 */
	@Test(groups={"CI"})
	public void testForButtons() throws Exception {

		// NOTE: SINCE SELENIUM JUST GIVES THE NAME OF THE FAILING TEST, DO
		// THESE SUBTESTS IN PRIVATE METHODS WITH HELPFUL NAMES.

		// Test to make sure the button is rendered in userlinks as logged out user.
		testButtonOnUserLinks();

		// Test to make sure the button is rendered in the AjaxLogin dialog as logged out user.
		testButtonOnLoginDialog();

		// Test to make sure the button is rendered on Speical:Signup
		testButtonOnSpecialSignup();

		// Test button on Special:Connect when accessed directly.
		testButtonOnSpecialConnect();

		// Check to make sure that the button is rendered in the Special:Preferences as a logged-in but not connected user.
		testButtonOnSpecialPreferences();

		// Check to make sure that the button is rendered in the modal dialog during login-and-connect
		testButtonOnLoginAndConnect();
	}

	private void testButtonOnUserLinks() throws Exception {
		//System.out.println("FBConnect: testing for buttons on User Links");
		session().open("index.php?title=Special:Random&useskin=oasis");
		session().waitForPageToLoad(this.getTimeout());
		if(isOasis()){
			assertTrue(session().isElementPresent("//ul[@id='AccountNavigation']/li/span[@id='fbconnect']/a"));
		} else {
			assertTrue(session().isElementPresent("//div[@id='userData']/span[@id='fbconnect']/a"));
		}
	}

	// PRECONDITION: testButtonOnUserLinks() should be called before this so that there is a page loaded.
	private void testButtonOnLoginDialog() throws Exception {
		//System.out.println("FBConnect: testing for buttons on Login Dialog");
		session().click("//a[@class='ajaxLogin']");
		waitForElement("//div[@id='AjaxLoginBox']");

		if(isOasis()){
			assertTrue(session().isElementPresent("//div[@id='AjaxLoginBox']//div[@id='AjaxLoginSlider']//span[@class='fb_button_text']"));
		} else {
			assertTrue(session().isElementPresent("//div[@id='AjaxLoginBox']/div/*/a/span[@class='fb_button_text']"));
		}
	}

	private void testButtonOnSpecialSignup() throws Exception {
		//System.out.println("FBConnect: testing for buttons on Special:Signup");
		session().open("index.php?title=Special:Signup");
		session().waitForPageToLoad(this.getTimeout());

		if(isOasis()){
			assertTrue(session().isElementPresent("//div[@id='AjaxLoginBox']//div[@id='AjaxLoginSlider']//span[@class='fb_button_text']"));
		} else {
			assertTrue(session().isElementPresent("//div[@id='AjaxLoginBox']/div/*/a/span[@class='fb_button_text']"));
		}
	}

	private void testButtonOnSpecialConnect() throws Exception {
		//System.out.println("FBConnect: testing for buttons on Special:Connect");
		session().open("index.php?title=Special:Connect");
		session().waitForPageToLoad(this.getTimeout());
		assertTrue(session().isElementPresent("//a/span[@class='fb_button_text']"));
	}

	private void testButtonOnSpecialPreferences() throws Exception {
		//System.out.println("FBConnect: testing for buttons on Special:Preferences");
		loginAsRegular();
		session().open("index.php?title=Special:Preferences");
		session().waitForPageToLoad(this.getTimeout());
		waitForElement("//li/a[text() = \"Facebook Connect\"]");
		session().click("//li/a[text() = \"Facebook Connect\"]"); // select the correct tab
		assertTrue(session().isElementPresent("//fieldset[@class='prefsection']//a/span[@class='fb_button_text']"));
	}

	private void testButtonOnLoginAndConnect() throws Exception {
		//System.out.println("FBConnect: testing for buttons on LoginAndConnect");
		logout();
		session().open("index.php?title=Special:Random&useskin=oasis");
		session().waitForPageToLoad(this.getTimeout());
		waitForElement("//a[@class='ajaxLogin']");
		session().click("//a[@class='ajaxLogin']");
		waitForElement("//div[@id='AjaxLoginBox']");
		session().click("//a[@class='forward']");
		waitForElement("//input[@id='wpName3Ajax']");
		session().type("//input[@id='wpName3Ajax']", getTestConfig().getString("ci.user.facebook.username"));
		session().type("//input[@id='wpPassword3Ajax']", getTestConfig().getString("ci.user.facebook.password"));
		session().click("//input[@id='wpLoginAndConnectCombo']");
		waitForElement("//div[@id='fbNowConnectBox']");
		assertTrue(session().isElementPresent("//div[@id='fbNowConnectBox']/div/*/a"));
	}
}
