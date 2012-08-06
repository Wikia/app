package com.wikia.selenium.tests;


import java.util.Date;
import java.util.Random;

import org.apache.commons.lang.ArrayUtils;
import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.*;


public class ProfileMastheadTest extends BaseTest {
	
private static String PROFILE_ARTICLE_ONE   = "Profile Article One";
public static final String TEST_USER_PREFIX = "WikiaTestAccount";
public static final String TEST_EMAIL_FORMAT = "WikiaTestAccount%s@wikia-inc.com";

@Test(groups={"CI"})
public void TestProfilOwnerVisitsHisProfilePage() throws Exception
{
	loginAsRegular();
	waitForElement("//ul[@id='AccountNavigation']/li/a");
	clickAndWait("//ul[@id='AccountNavigation']/li/a");
	assertTrue(session().isElementPresent("//section[@id='UserProfileMasthead']"));
	int aNumber0 = (new Integer(session().getText("//section[@id='UserProfileMasthead']/div[@class='masthead-info']/div/div[@class='tally']/em"))).intValue();
	String content = "Lorem ipsum " + (new Date()).toString();
	editArticle(PROFILE_ARTICLE_ONE, content);
	
	waitForElement("//ul[@id='AccountNavigation']/li/a");
	clickAndWait("//ul[@id='AccountNavigation']/li/a");
	
	int aNumber1 = (new Integer(session().getText("//section[@id='UserProfileMasthead']/div[@class='masthead-info']/div/div[@class='tally']/em"))).intValue();
    assertTrue((aNumber0+1)==aNumber1);
	
	session().mouseOver("//span[@id='userIdentityBoxEdit']/a");
	session().mouseOver("//a[@id='userAvatarEdit']");
	
}
@Test(groups={"CI"})
public void TestAnAonymousUserVisitsStaffProfilePage() throws Exception
{
	
	
	openAndWait("wiki/User:WikiaStaff");
	assertTrue(session().isElementPresent("//section[@id='UserProfileMasthead']/div[@class='masthead-info']/hgroup/span[@class='group']"));
	
	//check if information that user is staff member, or founder appears in bubble next to his username 
    assertTrue(("Staff").equals(session().getText("//section[@id='UserProfileMasthead']/div[@class='masthead-info']/hgroup/span[@class='group']"))||(("Founder").equals(session().getText("//section[@id='UserProfileMasthead']/div[@class='masthead-info']/hgroup/span[@class='group']"))));
	
	
}
@Test(groups={"CI"})
public void TestStaffMemberVisitsUsersProfilePage() throws Exception
{
	loginAsStaff();
	openAndWait("index.php?title=User:WikiaUser");
	session().mouseOver("//span[@id='userIdentityBoxEdit']/a");
	session().mouseOver("//a[@id='userAvatarEdit']");
	session().mouseOver("//section[@id='UserProfileMasthead']/div[@class='masthead-avatar']/span[2]/a");
	clickAndWait("//section[@id='UserProfileMasthead']/div[@class='masthead-avatar']/span[2]/a");
	assertEquals("WikiaUser", session().getValue("//form[@id='wba-search-form']/input[@name='av_user']" ));
	
}
@Test(groups={"CI"})
public void TestProfileOwnerEditsHisInformation() throws Exception
{
	loginAsRegular();
	openAndWait("index.php?title=User:WikiaUser");
    session().click("//span[@id='userIdentityBoxEdit']/a");
    waitForElement("//div[@id='UPPLightbox']");
    assertEquals("Avatar", session().getText("//div[@id='UPPLightbox']/ul[@class='tabs']/li[1]/a" ));
    assertEquals("About Me", session().getText("//div[@id='UPPLightbox']/ul[@class='tabs']/li[2]/a"));
	assertEquals("What's your name?", session().getText("//form[@id='userData']/div[1]/label[1]"));
	assertEquals("Where do you live?", session().getText("//form[@id='userData']/div[1]/label[2]"));
	assertEquals("When is your birthday?", session().getText("//form[@id='userData']/div[1]/label[3]"));
	assertEquals("What's your occupation?", session().getText("//form[@id='userData']/div[1]/label[4]"));
	assertEquals("What gender are you?", session().getText("//form[@id='userData']/div[1]/label[5]"));
	assertEquals("What's your personal website?", session().getText("//form[@id='userData']/div[2]/label[1]"));
	assertEquals("What's your Twitter name?", session().getText("//form[@id='userData']/div[2]/label[2]"));
	assertEquals("Wikis you've contributed to:", session().getText("//form[@id='userData']/div[2]/label[3]"));
	assertTrue(session().isEditable("//form[@id='userData']/div[1]/input[1]"));
	assertTrue(session().isEditable("//form[@id='userData']/div[1]/input[2]"));
	assertTrue(session().isEditable("//form[@id='userData']/div[1]/input[3]"));
	assertTrue(session().isEditable("//form[@id='userData']/div[1]/input[4]"));
	assertTrue(session().isEditable("//form[@id='userData']/div[2]/input[1]"));
	assertTrue(session().isEditable("//form[@id='userData']/div[2]/input[2]"));

	session().select("userBDayMonth", "--");
	assertFalse(session().isElementPresent("//select[@id='userBDayDay']/option[2]"));
	session().select("userBDayMonth", "January");
	assertTrue(session().isElementPresent("//select[@id='userBDayDay']/option[2]"));
}
@Test(groups={"CI"})
public void TestEditingAvatar() throws Exception
{
	loginAsRegular();
	openAndWait("index.php?title=User:WikiaUser");
	session().click("//a[@id='userAvatarEdit']");
	waitForElement("//div[@id='UPPLightbox']/ul[@class='tabs']/li[@class='selected']/a");
	assertTrue(session().isElementPresent("//input[@id='UPPLightboxAvatar']"));
	assertTrue(session().isElementPresent("//p[@id='facebookConnectAvatar']"));
	assertTrue(session().isElementPresent("//ul[@class='sample-avatars']"));
	
	
	loginAsStaff();
	openAndWait("index.php?title=User:WikiaUser");
	session().click("//a[@id='userAvatarEdit']");
	waitForElement("//div[@id='UPPLightbox']/ul[@class='tabs']/li[@class='selected']/a");
	assertTrue(session().isElementPresent("//input[@id='UPPLightboxAvatar']")); 
	assertFalse(session().isElementPresent("//p[@id='facebookConnectAvatar']"));
	assertTrue(session().isElementPresent("//ul[@class='sample-avatars']"));
	
	
}
@Test(groups={"CI"})
public void TestEnsuresThatMastheadIsPresentOnPage() throws Exception
{
	loginAsRegular();
	openAndWait("index.php?title=User:WikiaUser");
	assertTrue(session().isElementPresent("//section[@id='UserProfileMasthead']"));
	clickAndWait("//div[@id='WikiaUserPagesHeader']/div[@class='tabs-container']/ul/li[2]/a");
	assertTrue(session().isElementPresent("//section[@id='UserProfileMasthead']"));
	session().open("index.php?title=Special:CreateBlogPage");
	String content =(new Date()).toString();
	session().type("//section[@id='HiddenFieldsDialog']/section[@class='modalContent']/div/div[@class='fields']/label[2]/input", content);
	session().click("//a[@id='ok']");
	session().type("//textarea[@id='wpTextbox1']", "blog blog blog"); 
	doSave();
	clickAndWait("//header[@id='WikiaPageHeader']/h2/a");
	clickAndWait("//div[@id='WikiaArticle']/section[@class='WikiaBlogListing']/ul/li[1]/h1/a");
	assertFalse(session().isElementPresent("//section[@id='UserProfileMasthead']"));
	clickAndWait("//header[@id='WikiaPageHeader']/h2/a");
	clickAndWait("//div[@id='WikiaUserPagesHeader']/div[@class='tabs-container']/ul/li[3]/a");
	assertTrue(session().isElementPresent("//section[@id='UserProfileMasthead']"));
	clickAndWait("//div[@id='WikiaUserPagesHeader']/div[@class='tabs-container']/ul/li[4]/a");
	assertTrue(session().isElementPresent("//section[@id='UserProfileMasthead']"));
	clickAndWait("//div[@id='WikiaUserPagesHeader']/div[@class='tabs-container']/ul/li[5]/a");
	assertTrue(session().isElementPresent("//section[@id='UserProfileMasthead']"));
	
}
@Test(groups={"CI"})
public void TestNewUserProfilePage() throws Exception
{
	session().click("//ul[@id='AccountNavigation']/li[3]/a");
	waitForElement("//section[@id='AjaxLoginBoxWrapper']");
	String time = Long.toString((new Date()).getTime());
	String password = Long.toString(Math.abs(new Random().nextLong()), 36).toLowerCase();
	String captchaWord = getWordFromCaptchaId(session().getValue("wpCaptchaId"));
	
	String user = TEST_USER_PREFIX + time;

	session().type("wpName2", user);
	session().type("wpEmail", String.format(TEST_EMAIL_FORMAT, time));
	session().type("wpPassword2", password);
	session().type("wpRetype", password);
	session().select("wpBirthYear", "1900");
	session().select("wpBirthMonth", "1");
	session().select("wpBirthDay", "1");
	session().type("wpCaptchaWord", captchaWord);
	session().click("//input[@id='wpCreateaccountXSteer']");
	
	openAndWait("index.php?title=User:" + user);
	assertTrue(session().isElementPresent("//section[@id='UserProfileMasthead']"));
	assertEquals(user, session().getText("//section[@id='UserProfileMasthead']/div[@class='masthead-info']/hgroup/h1"));
	int aNumber = (new Integer(session().getText("//section[@id='UserProfileMasthead']/div[@class='masthead-info']/div/div[@class='tally']/em"))).intValue();
	assertTrue(aNumber==0);
	
	
	openAndWait(randomWiki()+ "/wiki/User:" + user);
	assertTrue(session().isElementPresent("//section[@id='UserProfileMasthead']"));
	assertEquals(user, session().getText("//section[@id='UserProfileMasthead']/div[@class='masthead-info']/hgroup/h1"));
	int aNumber1 = (new Integer(session().getText("//section[@id='UserProfileMasthead']/div[@class='masthead-info']/div/div[@class='tally']/em"))).intValue();
	assertTrue(aNumber1==0);
	
}	
@Test(groups={"CI"})
public void TestGlobalnessNewUserEditsHisProfilePageOnAnotherWiki () throws Exception
{
	session().click("//ul[@id='AccountNavigation']/li[3]/a");
	waitForElement("//section[@id='AjaxLoginBoxWrapper']");
	String time = Long.toString((new Date()).getTime());
	String password = Long.toString(Math.abs(new Random().nextLong()), 36).toLowerCase();
	String captchaWord = getWordFromCaptchaId(session().getValue("wpCaptchaId"));
	
	String user = TEST_USER_PREFIX + time;

	session().type("wpName2", user);
	session().type("wpEmail", String.format(TEST_EMAIL_FORMAT, time));
	session().type("wpPassword2", password);
	session().type("wpRetype", password);
	session().select("wpBirthYear", "1900");
	session().select("wpBirthMonth", "1");
	session().select("wpBirthDay", "1");
	session().type("wpCaptchaWord", captchaWord);
	session().click("//input[@id='wpCreateaccountXSteer']");
	openAndWait("index.php?title=User:" + user);
	
	session().click("//span[@id='userIdentityBoxEdit']/a");
    waitForElement("//div[@id='UPPLightbox']");
    
	
	session().type("name", "name");
	session().type("location", "location");
	session().select("userBDayMonth", "January");
	session().select("userBDayDay", "25");
	session().click("//div[@id='UPPLightbox']/div[@class='modalToolbar']/button[@class='save']");
	
	
	openAndWait(randomWiki()+ "/wiki/User:" + user);
	session().click("//span[@id='userIdentityBoxEdit']/a");
    waitForElement("//div[@id='UPPLightbox']");
	session().type("location", "location02");
	session().click("//div[@id='UPPLightbox']/div[@class='modalToolbar']/button[@class='save']");
	
	int aNumber = (new Integer(session().getText("//section[@id='UserProfileMasthead']/div[@class='masthead-info']/div/div[@class='tally']/em"))).intValue();
	assertTrue(aNumber==0);
	
	assertEquals("I live in location02", session().getText("//section[@id='UserProfileMasthead']/div[@class='masthead-info']/div/ul[@class='details']/li[1]"));
	assertEquals("aka name",session().getText("//section[@id='UserProfileMasthead']/div[@class='masthead-info']/hgroup/h2"));
	assertEquals("I was born on January 25",session().getText("//section[@id='UserProfileMasthead']/div[@class='masthead-info']/div[2]/ul[@class='details']/li[2]"));
	int aNumber01 = (new Integer(session().getText("//section[@id='UserProfileMasthead']/div[@class='masthead-info']/div/div[@class='tally']/em"))).intValue();
	assertTrue(aNumber01==0);
	
}
       //@Test
	public void testFoo() throws Exception {
		System.out.println("start test");
		String randomWiki;
		randomWiki = this.randomWiki();
		System.out.println(randomWiki);
	}


	private String randomWiki() throws Exception {
		String[] wikis = testWikiNames();
		int size = wikis.length;
		Random rand = new Random();
		String randomName;
		String randomUrl;
		
		do {
			int index = rand.nextInt(size - 1);
			randomName = wikis[index];
			randomUrl = wikiUrl(randomName);
			System.out.println("found: " + randomName + " " + randomUrl);
			System.out.println(!this.webSite.contains(randomName));
		} while (this.webSite.contains(randomName));
		
		return randomUrl;
	}
	
	private String wikiUrl(String wikiName) throws Exception {
		if (isPreview()) {
			return "http://preview." + wikiName + ".wikia.com";
		} else if (isProduction()) {
			return "http://" + wikiName + ".wikia.com";
		} else if (isDevBox()) {
			String url = this.webSite;
			
			int length= url.length();
			System.out.println(length + " ===length");
		
			int ind1=url.lastIndexOf("/")+1;
			System.out.println(ind1 + " ===last index of /");
			
			if(ind1==length)
			{
			url=url.substring(0, length-1); 
			}
			
			
			
			url = url.replace(".wikia-dev.com", "");
			url = url.substring(url.lastIndexOf("."));
			return "http://" + wikiName + url + ".wikia-dev.com";
		} else {
			throw new Exception("Unknown test environment type.");
		}
	}
}