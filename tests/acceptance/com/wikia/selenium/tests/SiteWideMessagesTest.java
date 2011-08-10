package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import com.thoughtworks.selenium.SeleniumException;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;
import java.util.Random;

public class SiteWideMessagesTest extends BaseTest {
	private Random generator = new Random();
	private static String uniqMessage;

	private String uniqId(String msg) throws Exception {
		return msg + ' ' + Integer.toString(generator.nextInt(65536));
	}

	@Test(groups={"CI", "verified"})
	public void testSendMessageToOneUser() throws Exception {
		uniqMessage = uniqId("Selenium test message");
		
		loginAsStaff();
		openAndWait("index.php/Special:SiteWideMessages");
		
		// Set mode "to selected user" and other properties
		session().click("mSendModeUsersU");
		session().type("mUserName", getTestConfig().getString("ci.user.regular.username"));
		session().select("mExpireTime", "label=1 hour");
		session().type("mContent", uniqMessage);
		
		// Check preview
		clickAndWait("fPreview");
		assertTrue(uniqMessage.equals(session().getText("//div[@id='WikiTextPreview']/p")));
		
		// Send the message
		clickAndWait("fSend");
		
		assertTrue(session().isTextPresent("The message has been sent."));
	}
	
	@Test(groups={"CI", "verified"},dependsOnMethods={"testSendMessageToOneUser"})
	public void testReceiveMessageSentToOneUser() throws Exception {
		loginAsRegular();
		
		try {
			openAndWait("index.php/User_talk:" + getTestConfig().getString("ci.user.regular.username") + "?redirect=no");
		} catch (SeleniumException se) {
			// 404
		}
		session().waitForPageToLoad(this.getTimeout());

		assertTrue(session().isElementPresent("//div[contains(@id,'msg_')]/p[contains(text(),'" + uniqMessage + "')]"));
		try {
			session().click("//div[contains(@id,'msg_')]/a");
		} catch (SeleniumException se) {
			// 404
		}
		waitForElementNotPresent("//div[contains(@id,'msg_')]/p[contains(text(),'" + uniqMessage + "')]");
	}
}

