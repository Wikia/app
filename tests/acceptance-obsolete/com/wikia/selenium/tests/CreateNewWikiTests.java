package com.wikia.tests;

import java.awt.AWTException;
import java.io.File;
import java.net.MalformedURLException;
import java.net.URL;

import java.util.ArrayList;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.ie.InternetExplorerDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.firefox.FirefoxDriver;

import org.testng.annotations.*;
import org.openqa.selenium.remote.DesiredCapabilities;
import org.openqa.selenium.remote.RemoteWebDriver;
import org.openqa.selenium.support.ui.Select;
import org.openqa.selenium.support.ui.WebDriverWait;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.By;
import static org.testng.AssertJUnit.fail;
import static org.testng.AssertJUnit.assertEquals;

public class CreateNewWikiTests extends WebDriverTest{
	// STATUS: READY
	// Related URL: https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_CNW
	
	// Additional info: 
	//info1: Lets say you've created a new wiki in non english language, e.g. Italian language named 'yourwikiname'. If you want to delete the wiki, you must delete 'it.yourwikiname' , NOT 'yourwikiname'.
	
 	private WebDriver driver;
	private WebDriverWait wait;
	private String STAFFlogin = "";
	private String STAFFpassword = "";
	
	@BeforeClass
		public void setUp() {
// 	 driver = new FirefoxDriver();
		
		File file = new File("D:/NeptuN/programy/programowanie/Selenium-Webdriver/IEDriverServer/IEDriverServer_x64_2.25.0/IEDriverServer.exe");
		System.setProperty("webdriver.ie.driver", file.getAbsolutePath());
		driver = new InternetExplorerDriver();

		// below code is to set up chrome driver in order to run by stand-alone
		// server. Also stand alone server must be launched with special command
	
		//START
//		 DesiredCapabilities capability = DesiredCapabilities.chrome();
//		
//		 try {
//	driver = new RemoteWebDriver(new URL("http://localhost:4444/wd/hub"),
//		 capability);
//	
//		 } catch (MalformedURLException e) {
//		 		 e.printStackTrace();
//		 }
		//END
		
		// below code is to set up chrome driver in order to run it outside of
		// stand-alone server
		
		//START
//		 System.setProperty("webdriver.chrome.driver",
//		 "D:/NeptuN/Selenium Webdriver/Selenium2.25/chromedriver_win_20.0.1133.0/chromedriver.exe");
//		 driver = new ChromeDriver();
		//END
		
		wait = new WebDriverWait(driver, 30);
		// 30 sec is needed especially after theme selection
		
	}

//	@AfterClass(alwaysRun = true)
	public void tearDown() throws Exception {
		driver.close();
		driver.quit();
	}

//	@Test	
	// Test Case 3_1_01 Crate new wiki Have an account? page: Dispaly
	public void TEST_CASE_3_1_01() throws Exception {
		// Author: Michal Nowierski
		String wikiname = "autoqatest"+getDateString();
		System.out.println("Create New Wiki Test Case 3.1.01");
		
		// Step 1 Navigate to www.wikia.com/Wikia
		NavigateToWikia(driver);
		
		//Make sure user is logged out.
		 MakeSureUserLoggedOut(driver);
		
		// Step 2 Left click "Start a wiki"
		LeftClickStartAwiki();

		// Step 3 Verify the Special:CreateNewWiki site is opened
		VerifyTheSpecialCreateNewWiki();
		VerifyRediectionToSpecialPage("CreateNewWiki", driver);

		// Step 4 Populate the "Name your wiki" field with a valid wiki name
		PopulateNameYourWikiField(wikiname);
	
		// Step 5 Verify the "Give your wiki an address" appears with a green tick and that field is auto populated
		VerifyTheGiveYourWikiAnAddress();
	 
		// Step 6 Left click next button
		LeftClickNextButton1();

		// Step 7 Verify user is redirected to the Have an Account? page
		VerifyTheHaveAnAccount();
		
		// Step 8 Verify Username field is Blank.
		System.out.println("Verify Username field is Blank");
		wait.until(ExpectedConditions.presenceOfElementLocated(By
				.cssSelector("div.UserLoginModal input[name='username']")));
		WebElement Username_field = driver.findElement(By
				.cssSelector("div.UserLoginModal input[name='username']"));
		if (!Username_field.getText().equalsIgnoreCase("")) {
			fail("TEST CASE step 8: Username field is not Blank");
		}
		
		// Step 9 Verify Password field is Blank.
		System.out.println("Verify Password field is Blank");
		WebElement Password_field = driver.findElement(By
				.cssSelector("div.UserLoginModal input[name='password']"));
		if (!Password_field.getText().equalsIgnoreCase("")) {
			fail("TEST CASE step 9: Password field is not Blank");
		}
		
		// Step 10 - striked through - Verify Username field is highlighted.
//		System.out.println("Verify Username field is highlighted. - striked through");
		
		// Step 11 Select Username field
		System.out.println("Select Username field");
		
		// Step 12 Select Press tab button and verify focus is on the Password field
		System.out.println("Press tab button and verify focus is on the Password field");
		Username_field.sendKeys(Keys.TAB);
		WebElement currently_focused = driver.switchTo().activeElement();
		assertEquals(
				"TEST CASE step 12: after clicking TAB 'Password' field not focused",
				"password", currently_focused.getAttribute("name"));
		// assertEquals("message shown if assert fails, expected object, actual
		// object)

		// Step 13 Press tab button and verify focus is on the Forgot your Password link.
		System.out.println("Press tab button and verify focus is on the Forgot your Password link.");
		currently_focused.sendKeys(Keys.TAB);
		currently_focused = driver.switchTo().activeElement();
		assertEquals(
				"TEST CASE step 13: after clicking TAB 'Forgot your password?' field not focused",
				"forgot-password", currently_focused.getAttribute("class"));

		// Step 14 Press tab button and verify focus is on the Log in button
		System.out.println("Press tab button and verify focus is on the Log in button");
		currently_focused.sendKeys(Keys.TAB);
		currently_focused = driver.switchTo().activeElement();
		assertEquals(
				"TEST CASE step 14: after clicking TAB 'Log in' field not focused",
				"Log in", currently_focused.getAttribute("value"));

		// Step 15 Press tab button and verify focus is on the FaceBook connect button.
		System.out.println("Press tab button and verify focus is on the FaceBook connect button.");
		currently_focused.sendKeys(Keys.TAB);
		currently_focused = driver.switchTo().activeElement();
		// WebElement facebook_button = currently_focused; 

		assertEquals(
				"TEST CASE step 15: after clicking TAB 'facebook' field not focused",
				"facebook", currently_focused.getAttribute("data-id"));

		// Step 16 Press tab button and verify focus is on the Sign up button TODO: return step 16 before introducing this TEST
	//TODO: RETURN THE STEP WHEN https://wikia.fogbugz.com/default.asp?36200 is resolved and closed
		// System.out.println("Press tab button and verify focus is on the Sign up button");
		// currently_focused.sendKeys(Keys.TAB);
		// currently_focused = driver.switchTo().activeElement();
		// assertEquals("TEST CASE step 16: after clicking TAB 'Sign up' field not focused",
		// "password", currently_focused.getAttribute("name"));

		// Step 17 Verify 'Log in' button is the same colour as other buttons on the wiki. - colour verification not possible
	// TODO: execute this step (when comparing color comparision will be possible)
	
		// Step 18 Verify a tooltip appears when mouse hovering over the FaceBook connect button
		// Hovering is possible, but didn't find any way to identify appearing tooltip by selector.
	//TODO: execute this step if identifying appearing tooltip will be possible
			
		// Step 19 	Verify tooltip reads: "Click the button to sign in with facebook"
		System.out.println("Verify tooltip reads: 'Click the button to sign in with facebook'");
				wait.until(ExpectedConditions.presenceOfElementLocated(By
				.cssSelector("div.sso-login a[data-tooltip='Click the button to log in with Facebook']")));

		// Step 20 Verify there is a Sign up link in the text '. It only takes a minute to sign up!'
		System.out.println("Verify there is a Sign up link in the text 'It only takes a minute to sign up!'");
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("div.signup-marketing a[href='/Special:UserSignup']")));
	}
	



//@Test
	// Test Case 3.1.02 Create new wiki: log in field validation (Latin characters)
	// 2.2.1 Username field validation: username is blank
	public void TEST_CASE_3_1_02_221() throws Exception {
		// Author: Michal Nowierski

	String wikiname = "qatest"+getDateString()+"Automation";
	System.out.println("Create New Wiki Test Case 3.1.02 2.2.1");
	String Username = "";
	String Password = "";
				
			// Step 0 - Preconditions
			System.out.println("preconditions assurance");
		
			// Step 1 Navigate to http://www.wikia.com/Wikia
			NavigateToWikia(driver);
	
			//Make sure user is logged out.
			MakeSureUserLoggedOut(driver);
	
			// Step 2 Left click "Start a wiki"
			LeftClickStartAwiki();
	
			// Step 3 Verify the Special:CreateNewWiki site is opened
			VerifyTheSpecialCreateNewWiki();
				VerifyRediectionToSpecialPage("CreateNewWiki", driver);
	
			// Step 4 Populate the "Name your wiki" field with a valid wiki name
			PopulateNameYourWikiField(wikiname);
	
			// Step 5 Left click next button
			LeftClickNextButton1();
	
			// Step 6 Verify user is redirected to the Have an Account? page
			VerifyTheHaveAnAccount();
	
			// Step7  Populate fields as follows 
			// Username field = blank
			// Password field = blank
			PopulateUsernameAndPasswordField("", "");
	
			// Step 8 Left click log in button.
			LeftClickLogInButton();
	
			//Step 9 Verify error message," Oops, please fill in the username field." is displayed below the username field.
			VerifyErrorMessageForLogInDialog("Oops, please fill in the username field.");
	
			//Step 10 Populate fields as follows 
			//Username field = valid Latin Username
			//Password field = correct Latin password
			PopulateUsernameAndPasswordField(Username, Password);
	
			// Step 11 Left click log in button.
			LeftClickLogInButton();
	
			// Step 12 Verify next stage in CNW workflow is opened i.e. What is your wiki about? page
			VerifyTheWhatIsYouWikiAbout();

			// Step 13 Populate Describe your topic field.
			PopulateDescribeYourTopic("content");
	
			// Step 14 Select a category from Choose a category drop down
			SelectAcategoryFromDropdown("Sports");
	
			// Step 15 Left click next button
			LeftClickNextButton2();
	
			// Step 16 Left click any theme and left click next button
			LeftClickAnyThemeAndNext();
	
			// Step 17 Close congratulations dialog
			CloseCongratulationDialog();
	
			// Step 18 Verify new wiki has been created.
			VerifyNewWikiCreated(wikiname);
		
			// Step 19 Verify "Log in" link is not displayed in Global Nav
			VerifyLogInLinkNotDisplayed();
	
			// Step 20 Verify "Sign up" link is not displayed in Global Nav
			VerifySignUpLinkNotDisplayed();
	
			// Step 21 Verify User name is displayed in place of Log in and Sign up links (user is logged into wiki)
			VerifyUserLoggedIn(Username, driver);
	
			// Step 22 Verify user drop down is enabled.
			VerifyUserDropDownEnabled();
		
			// Step 23 Verify user tool bar is displayed at bottom of window.
			VerifyUserToolBarIsDisplayed();
	
			// Step 24 Log out using user drop down log out item.
			LogOutUsingUserDropDown(driver);
	
			// PostConditions - delete Wiki
			deleteWiki(wikiname);
	
}



//		@Test
	// Test Case 3.1.02 Create new wiki: log in field validation (Latin characters)
	// 2.2.2 Username field validation: username does not exist
	public void TEST_CASE_3_1_02_222() throws Exception {
		// Author: Michal Nowierski
		
		String wikiname = "qatest"+getDateString()+"Automation";
		System.out.println("Create New Wiki Test Case 3.1.02 2.2.2");
		String Username = "";
		String Password = "";
		String Latin_Username_does_not_exist = "tester"+getDateString();
					
			// Step 0 - Preconditions
			System.out.println("preconditions assurance");
				
			// Step 0 Navigate to http://www.wikia.com/Wikia
			NavigateToWikia(driver);
		
			//Make sure user is logged out.
			MakeSureUserLoggedOut(driver);

			// Step 1 Left click "Start a wiki"
			LeftClickStartAwiki();
		
			// Step 2 Verify the Special:CreateNewWiki site is opened
			VerifyTheSpecialCreateNewWiki();
			VerifyRediectionToSpecialPage("CreateNewWiki", driver);
		
			// Step 3 Populate the "Name your wiki" field with a valid wiki name
			PopulateNameYourWikiField(wikiname);
		
			// Step 4 Left click next button
			LeftClickNextButton1();
		
			// Step 5 Verify user is redirected to the Have an Account? page
			VerifyTheHaveAnAccount();
		
			// Step 6  Populate fields as follows 
			// Username field = Latin Username does not exist
			// Password field = blank
			PopulateUsernameAndPasswordField(Latin_Username_does_not_exist, "");
		
			// Step 7 Left click log in button.
			LeftClickLogInButton();
		
			// Step 8 Verify error message, "We don't recognize this name. Don't forget usernames are case sensitive." is displayed below the username field.
			VerifyErrorMessageForLogInDialog("We don't recognize this name. Don't forget usernames are case sensitive.");
	
			// Step 9 Verify Username is populated with Latin Username does not exist.
			// The Username from the usernamefiled does not appear anywhere in the DOM - It is impossible to execute this step
		
			//Step 10 Populate fields as follows 
			//Username field = valid Latin Username
			//Password field = correct Latin password
			PopulateUsernameAndPasswordField(Username, Password);
		
			// Step 11 Left click log in button.
			LeftClickLogInButton();
		
			// Step 12 Verify next stage in CNW workflow is opened i.e. What is your wiki about? page
			VerifyTheWhatIsYouWikiAbout();

			// Step 13 Populate Describe your topic field.
			PopulateDescribeYourTopic("content");
		
			// Step 14 Select a category from Choose a category drop down
			SelectAcategoryFromDropdown("Sports");
		
			// Step 15 Left click next button
			LeftClickNextButton2();
		
			// Step 16 Left click any theme and left click next button
			LeftClickAnyThemeAndNext();
		
			// Step 17 Close congratulations dialog
			CloseCongratulationDialog();
		
			// Step 18 Verify new wiki has been created.
			VerifyNewWikiCreated(wikiname);
			
			// Step 19 Verify "Log in" link is not displayed in Global Nav
			VerifyLogInLinkNotDisplayed();
		
			// Step 20 Verify "Sign up" link is not displayed in Global Nav
			VerifySignUpLinkNotDisplayed();
		
			// Step 21 Verify User name is displayed in place of Log in and Sign up links (user is logged into wiki)
			VerifyUserLoggedIn(Username, driver);
		
			// Step 22 Verify user drop down is enabled.
			VerifyUserDropDownEnabled();
			
			// Step 23 Verify user tool bar is displayed at bottom of window.
			VerifyUserToolBarIsDisplayed();
		
			// Step 24 Log out using user drop down log out item.
			LogOutUsingUserDropDown(driver);
		
			// PostConditions - delete Wiki
			deleteWiki(wikiname);
		}

//	@Test
	// Test Case 3.1.02 Create new wiki: log in field validation (Latin characters)
	// 2.2.3 Password field Validation: password is blank
	public void TEST_CASE_3_1_02_223() throws Exception {
		// Author: Michal Nowierski
		
		String wikiname = "qatest"+getDateString()+"Automation";
		System.out.println("Create New Wiki Test Case 3.1.02 2.2.3");
		String Username = "";
		String Password = "";
		
			// Step 0 - Preconditions
			System.out.println("preconditions assurance");
			
			// Step 0 Navigate to http://www.wikia.com/Wikia
			NavigateToWikia(driver);
			
			//Make sure user is logged out.
			MakeSureUserLoggedOut(driver);
			
			// Step 1 Left click "Start a wiki"
			LeftClickStartAwiki();
			
			// Step 2 Verify the Special:CreateNewWiki site is opened
			VerifyTheSpecialCreateNewWiki();
			
			// Step 3 Populate the "Name your wiki" field with a valid wiki name
			PopulateNameYourWikiField(wikiname);
			
			// Step 4 Left click next button
			LeftClickNextButton1();
			
			// Step 5 Verify user is redirected to the Have an Account? page
			VerifyTheHaveAnAccount();
			
			// Step 6  Populate fields as follows 
			// Username field = valid Latin Username
			// Password field = blank
			PopulateUsernameAndPasswordField(Username, "");
			
			// Step 7 Left click log in button.
			LeftClickLogInButton();
			
			// Step 8 Verify error message, "Oops, please fill in the password field."
			VerifyErrorMessageForLogInDialog("Oops, please fill in the password field.");
		
			// Step 9 Verify Username is populated with Latin Username does not exist.
			// The Username from the usernamefiled does not appear anywhere in the DOM - It is impossible to execute this step
			
			//Step 10 Populate fields as follows 
			//Username field = valid Latin Username
			//Password field = correct Latin password
			PopulateUsernameAndPasswordField(Username, Password);
			
			// Step 11 Left click log in button.
			LeftClickLogInButton();
			
			// Step 12 Verify next stage in CNW workflow is opened i.e. What is your wiki about? page
			VerifyTheWhatIsYouWikiAbout();

			// Step 13 Populate Describe your topic field.
			PopulateDescribeYourTopic("content");
			
			// Step 14 Select a category from Choose a category drop down
			SelectAcategoryFromDropdown("Sports");
			
			// Step 15 Left click next button
			LeftClickNextButton2();
			
			// Step 16 Left click any theme and left click next button
			LeftClickAnyThemeAndNext();
			
			// Step 17 Close congratulations dialog
			CloseCongratulationDialog();
			
			// Step 18 Verify new wiki has been created.
			VerifyNewWikiCreated(wikiname);
				
			// Step 19 Verify "Log in" link is not displayed in Global Nav
			VerifyLogInLinkNotDisplayed();
			
			// Step 20 Verify "Sign up" link is not displayed in Global Nav
			VerifySignUpLinkNotDisplayed();
			
			// Step 21 Verify User name is displayed in place of Log in and Sign up links (user is logged into wiki)
			VerifyUserLoggedIn(Username, driver);
			
			// Step 22 Verify user drop down is enabled.
			VerifyUserDropDownEnabled();
				
			// Step 23 Verify user tool bar is displayed at bottom of window.
			VerifyUserToolBarIsDisplayed();
			
			// Step 24 Log out using user drop down log out item.
			LogOutUsingUserDropDown(driver);
			
			// PostConditions - delete Wiki
			deleteWiki(wikiname);
		}
	
	@Test
	// Test Case 3.1.02 Create new wiki: log in field validation (Latin characters)
	// 2.2.4 Password field Validation: password is incorrect
	public void TEST_CASE_3_1_02_224() throws Exception {
		// Author: Michal Nowierski
		
		String wikiname = "qatest"+getDateString()+"Automation";
		System.out.println("Create New Wiki Test Case 3.1.02 2.2.4");
		String Username = "";
		String Password = "";
	
		// Step 0 - Preconditions
		System.out.println("preconditions assurance");
						
			// Step 0 Navigate to http://www.wikia.com/Wikia
			NavigateToWikia(driver);
			
			//Make sure user is logged out.
		 MakeSureUserLoggedOut(driver);
			
			// Step 1 Left click "Start a wiki"
			LeftClickStartAwiki();
			
			// Step 2 Verify the Special:CreateNewWiki site is opened
			VerifyTheSpecialCreateNewWiki();
			
			// Step 3 Populate the "Name your wiki" field with a valid wiki name
			PopulateNameYourWikiField(wikiname);
			
			// Step 4 Left click next button
			LeftClickNextButton1();
			
			// Step 5 Verify user is redirected to the Have an Account? page
			VerifyTheHaveAnAccount();
			
			// Step 6  Populate fields as follows 
			// Username field = valid Latin Username
			// Password field = incorrect password
			PopulateUsernameAndPasswordField(Username, "incorrect_password");
			
			// Step 7 Left click log in button.
			LeftClickLogInButton();
			
			// Step 8 Verify error message, "Oops, wrong password. Make sure caps lock is off and try again."
			VerifyErrorMessageForLogInDialog("Oops, wrong password. Make sure caps lock is off and try again.");
		
			// Step 9 Verify Username is populated with Latin Username does not exist.
			// The Username from the usernamefiled does not appear anywhere in the DOM - It is impossible to execute this step
			
			//Step 10 Populate fields as follows 
			//Username field = valid Latin Username
			//Password field = correct Latin password
			PopulateUsernameAndPasswordField(Username, Password);
			
			// Step 11 Left click log in button.
			LeftClickLogInButton();
			
			// Step 12 Verify next stage in CNW workflow is opened i.e. What is your wiki about? page
			VerifyTheWhatIsYouWikiAbout();

			// Step 13 Populate Describe your topic field.
			PopulateDescribeYourTopic("content");
			
			// Step 14 Select a category from Choose a category drop down
			SelectAcategoryFromDropdown("Sports");
			
			// Step 15 Left click next button
			LeftClickNextButton2();
			
			// Step 16 Left click any theme and left click next button
			LeftClickAnyThemeAndNext();
			
			// Step 17 Close congratulations dialog
			CloseCongratulationDialog();
			
			// Step 18 Verify new wiki has been created.
			VerifyNewWikiCreated(wikiname);
				
			// Step 19 Verify "Log in" link is not displayed in Global Nav
			VerifyLogInLinkNotDisplayed();
			
			// Step 20 Verify "Sign up" link is not displayed in Global Nav
			VerifySignUpLinkNotDisplayed();
			
			// Step 21 Verify User name is displayed in place of Log in and Sign up links (user is logged into wiki)
			VerifyUserLoggedIn(Username, driver);
			
			// Step 22 Verify user drop down is enabled.
			VerifyUserDropDownEnabled();
				
			// Step 23 Verify user tool bar is displayed at bottom of window.
			VerifyUserToolBarIsDisplayed();
			
			// Step 24 Log out using user drop down log out item.
			LogOutUsingUserDropDown(driver);
			
			// PostConditions - delete Wiki
			deleteWiki(wikiname);
	}

//	@Test
	// Test Case 3.1.02 Create new wiki: log in field validation (Latin characters)
	// 2.2.5 Password field Validation: username and password are correct
	public void TEST_CASE_3_1_02_225() throws Exception {
		// Author: Michal Nowierski
		
		String wikiname = "qatest"+getDateString()+"Automation";
		System.out.println("Create New Wiki Test Case 3.1.02 2.2.5");
		String Username = "";
		String Password = "";

			// Step 0 - Preconditions
			System.out.println("preconditions assurance");
						
			// Step 0 Navigate to http://www.wikia.com/Wikia
			NavigateToWikia(driver);
			
			//Make sure user is logged out.
			MakeSureUserLoggedOut(driver);
			
			// Step 1 Left click "Start a wiki"
			LeftClickStartAwiki();
			
			// Step 2 Verify the Special:CreateNewWiki site is opened
			VerifyTheSpecialCreateNewWiki();
			
			// Step 3 Populate the "Name your wiki" field with a valid wiki name
			PopulateNameYourWikiField(wikiname);
			
			// Step 4 Left click next button
			LeftClickNextButton1();
			
			// Step 5 Verify user is redirected to the Have an Account? page
			VerifyTheHaveAnAccount();

			//Step 6 Populate fields as follows 
			//Username field = valid Latin Username
			//Password field = correct Latin password
			PopulateUsernameAndPasswordField(Username, Password);
			
			// Step 7 Left click log in button.
			LeftClickLogInButton();
			
			// Step 8 Verify next stage in CNW workflow is opened i.e. What is your wiki about? page
			VerifyTheWhatIsYouWikiAbout();

			// Step 9 Populate Describe your topic field.
			PopulateDescribeYourTopic("content");
			
			// Step 10 Select a category from Choose a category drop down
			SelectAcategoryFromDropdown("Sports");
			
			// Step 11 Left click next button
			LeftClickNextButton2();
			
			// Step 12 Left click any theme and left click next button
			LeftClickAnyThemeAndNext();
			
			// Step 13 Close congratulations dialog
			CloseCongratulationDialog();
			
			// Step 14 Verify new wiki has been created.
			VerifyNewWikiCreated(wikiname);
				
			// Step 15 Verify "Log in" link is not displayed in Global Nav
			VerifyLogInLinkNotDisplayed();
			
			// Step 16 Verify "Sign up" link is not displayed in Global Nav
			VerifySignUpLinkNotDisplayed();
			
			// Step 17 Verify User name is displayed in place of Log in and Sign up links (user is logged into wiki)
			VerifyUserLoggedIn(Username, driver);
			
			// Step 18 Verify user drop down is enabled.
			VerifyUserDropDownEnabled();
				
			// Step 19 Verify user tool bar is displayed at bottom of window.
			VerifyUserToolBarIsDisplayed();
			
			// Step 20 Log out using user drop down log out item.
			LogOutUsingUserDropDown(driver);
			
			// PostConditions - delete Wiki
			deleteWiki(wikiname);
	}
	
//	@Test
	// Test Case 3.1.03 Create new wiki: log in field validation (Latin characters)
	// 2.3.1 Password field Validation: password is incorrect
	public void TEST_CASE_3_1_03_231() throws Exception {
		// Author: Michal Nowierski
		
		String wikiname = "qatest"+getDateString()+"Automation";
		System.out.println("Create New Wiki Test Case 3.1.03 2.3.1");
		String Username = "¥êœNonLatinQAautomationBot";
		String Password = "";
		String Non_Latin_Username_does_not_exist = "¹êœ"+getDateString();
		// Step 0 - Preconditions
		System.out.println("preconditions assurance");
						
			// Step 0 Navigate to http://www.wikia.com/Wikia
			NavigateToWikia(driver);
			
			//Make sure user is logged out.
			MakeSureUserLoggedOut(driver);
			
			// Step 1 Left click "Start a wiki"
			LeftClickStartAwiki();
			
			// Step 2 Verify the Special:CreateNewWiki site is opened
			VerifyTheSpecialCreateNewWiki();
			
			// Step 3 Populate the "Name your wiki" field with a valid wiki name
			PopulateNameYourWikiField(wikiname);
			
			// Step 4 Left click next button
			LeftClickNextButton1();
			
			// Step 5 Verify user is redirected to the Have an Account? page
			VerifyTheHaveAnAccount();

			//Step 6 Populate fields as follows 
			//Username field = non Latin Username does not exist
			//Password field = blank
			PopulateUsernameAndPasswordField(Non_Latin_Username_does_not_exist, "");
			
			// Step 7 Left click log in button.
			LeftClickLogInButton();
			
			// Step 8 Verify error message, "We don't recognize this name. Don't forget usernames are case sensitive."
			VerifyErrorMessageForLogInDialog("We don't recognize this name. Don't forget usernames are case sensitive.");
		
			// Step 9 Verify Username is populated with Latin Username does not exist.
			// The Username from the usernamefiled does not appear anywhere in the DOM - It is impossible to execute this step
			
			//Step 10 Populate fields as follows 
			//Username field = valid Latin Username
			//Password field = correct Latin password
			PopulateUsernameAndPasswordField(Username, Password);
			
			// Step 11 Left click log in button.
			LeftClickLogInButton();
			
			// Step 12 Verify next stage in CNW workflow is opened i.e. What is your wiki about? page
			VerifyTheWhatIsYouWikiAbout();

			// Step 13 Populate Describe your topic field.
			PopulateDescribeYourTopic("content");
			
			// Step 14 Select a category from Choose a category drop down
			SelectAcategoryFromDropdown("Sports");
			
			// Step 15 Left click next button
			LeftClickNextButton2();
			
			// Step 16 Left click any theme and left click next button
			LeftClickAnyThemeAndNext();
			
			// Step 17 Close congratulations dialog
			CloseCongratulationDialog();
			
			// Step 18 Verify new wiki has been created.
			VerifyNewWikiCreated(wikiname);
				
			// Step 19 Verify "Log in" link is not displayed in Global Nav
			VerifyLogInLinkNotDisplayed();
			
			// Step 20 Verify "Sign up" link is not displayed in Global Nav
			VerifySignUpLinkNotDisplayed();
			
			// Step 21 Verify User name is displayed in place of Log in and Sign up links (user is logged into wiki)
			VerifyUserLoggedIn(Username, driver);
			
			// Step 22 Verify user drop down is enabled.
			VerifyUserDropDownEnabled();
				
			// Step 23 Verify user tool bar is displayed at bottom of window.
			VerifyUserToolBarIsDisplayed();
			
			// Step 24 Log out using user drop down log out item.
			LogOutUsingUserDropDown(driver);
			
			// PostConditions - delete Wiki
			deleteWiki(wikiname);
	}
	
//	@Test
	// Test Case 3.1.03 Create new wiki: log in field validation (Latin characters)
	// 2.3.2 Password field Validation: password is blank
	public void TEST_CASE_3_1_03_232() throws Exception {
		// Author: Michal Nowierski
		
		String wikiname = "qatest"+getDateString()+"Automation";
		System.out.println("Create New Wiki Test Case 3.1.03 2.3.2");
		String Username = "¥êœNonLatinQAautomationBot";
		String Password = "";
		
			// Step 0 - Preconditions
			System.out.println("preconditions assurance");
						
			// Step 0 Navigate to http://www.wikia.com/Wikia
			NavigateToWikia(driver);
			
			//Make sure user is logged out.
			MakeSureUserLoggedOut(driver);
			
			// Step 1 Left click "Start a wiki"
			LeftClickStartAwiki();
			
			// Step 2 Verify the Special:CreateNewWiki site is opened
			VerifyTheSpecialCreateNewWiki();
			
			// Step 3 Populate the "Name your wiki" field with a valid wiki name
			PopulateNameYourWikiField(wikiname);
			
			// Step 4 Left click next button
			LeftClickNextButton1();
			
			// Step 5 Verify user is redirected to the Have an Account? page
			VerifyTheHaveAnAccount();

			//Step 6 Populate fields as follows 
			//Username field = valid Latin Username
			//Password field = blank
			PopulateUsernameAndPasswordField(Username, "");
			
			// Step 7 Left click log in button.
			LeftClickLogInButton();
			
			// Step 8 Verify error message, "Oops, please fill in the password field."
			VerifyErrorMessageForLogInDialog("Oops, please fill in the password field.");
		
			// Step 9 Verify Username is populated with Latin Username does not exist.
			// The Username from the usernamefiled does not appear anywhere in the DOM - It is impossible to execute this step
			
			//Step 10 Populate fields as follows 
			//Username field = valid Latin Username
			//Password field = correct Latin password
			PopulateUsernameAndPasswordField(Username, Password);
			
			// Step 11 Left click log in button.
			LeftClickLogInButton();
			
			// Step 12 Verify next stage in CNW workflow is opened i.e. What is your wiki about? page
			VerifyTheWhatIsYouWikiAbout();

			// Step 13 Populate Describe your topic field.
			PopulateDescribeYourTopic("content");
			
			// Step 14 Select a category from Choose a category drop down
			SelectAcategoryFromDropdown("Sports");
			
			// Step 15 Left click next button
			LeftClickNextButton2();
			
			// Step 16 Left click any theme and left click next button
			LeftClickAnyThemeAndNext();
			
			// Step 17 Close congratulations dialog
			CloseCongratulationDialog();
			
			// Step 18 Verify new wiki has been created.
			VerifyNewWikiCreated(wikiname);
				
			// Step 19 Verify "Log in" link is not displayed in Global Nav
			VerifyLogInLinkNotDisplayed();
			
			// Step 20 Verify "Sign up" link is not displayed in Global Nav
			VerifySignUpLinkNotDisplayed();
			
			// Step 21 Verify User name is displayed in place of Log in and Sign up links (user is logged into wiki)
			VerifyUserLoggedIn(Username, driver);
			
			// Step 22 Verify user drop down is enabled.
			VerifyUserDropDownEnabled();
				
			// Step 23 Verify user tool bar is displayed at bottom of window.
			VerifyUserToolBarIsDisplayed();
			
			// Step 24 Log out using user drop down log out item.
			LogOutUsingUserDropDown(driver);
			
			// PostConditions - delete Wiki
			deleteWiki(wikiname);
	}
	
	
//	@Test
	// Test Case 3.1.03 Create new wiki: log in field validation (Latin characters)
	// 2.3.3 Password field Validation:  password is incorrect
	public void TEST_CASE_3_1_03_233() throws Exception {
		// Author: Michal Nowierski
		
		String wikiname = "qatest"+getDateString()+"Automation";
		System.out.println("Create New Wiki Test Case 3.1.03 2.3.3");
		String Username = "¥êœNonLatinQAautomationBot";
		String Password = "";
		
			// Step 0 - Preconditions
			System.out.println("preconditions assurance");
						
			// Step 0 Navigate to http://www.wikia.com/Wikia
			NavigateToWikia(driver);
			
			//Make sure user is logged out.
			MakeSureUserLoggedOut(driver);
			
			// Step 1 Left click "Start a wiki"
			LeftClickStartAwiki();
			
			// Step 2 Verify the Special:CreateNewWiki site is opened
			VerifyTheSpecialCreateNewWiki();
			
			// Step 3 Populate the "Name your wiki" field with a valid wiki name
			PopulateNameYourWikiField(wikiname);
			
			// Step 4 Left click next button
			LeftClickNextButton1();
			
			// Step 5 Verify user is redirected to the Have an Account? page
			VerifyTheHaveAnAccount();

			//Step 6 Populate fields as follows 
			//Username field = valid Latin Username
			//Password field = blank
			PopulateUsernameAndPasswordField(Username, "incorrect_password");
			
			// Step 7 Left click log in button.
			LeftClickLogInButton();
			
			// Step 8 Verify error message, "Oops, wrong password. Make sure caps lock is off and try again."
			VerifyErrorMessageForLogInDialog("Oops, wrong password. Make sure caps lock is off and try again.");
		
			// Step 9 Verify Username is populated with Latin Username does not exist.
			// The Username from the usernamefiled does not appear anywhere in the DOM - It is impossible to execute this step
			
			//Step 10 Populate fields as follows 
			//Username field = valid Latin Username
			//Password field = correct Latin password
			PopulateUsernameAndPasswordField(Username, Password);
			
			// Step 11 Left click log in button.
			LeftClickLogInButton();
			
			// Step 12 Verify next stage in CNW workflow is opened i.e. What is your wiki about? page
			VerifyTheWhatIsYouWikiAbout();

			// Step 13 Populate Describe your topic field.
			PopulateDescribeYourTopic("content");
			
			// Step 14 Select a category from Choose a category drop down
			SelectAcategoryFromDropdown("Sports");
			
			// Step 15 Left click next button
			LeftClickNextButton2();
			
			// Step 16 Left click any theme and left click next button
			LeftClickAnyThemeAndNext();
			
			// Step 17 Close congratulations dialog
			CloseCongratulationDialog();
			
			// Step 18 Verify new wiki has been created.
			VerifyNewWikiCreated(wikiname);
				
			// Step 19 Verify "Log in" link is not displayed in Global Nav
			VerifyLogInLinkNotDisplayed();
			
			// Step 20 Verify "Sign up" link is not displayed in Global Nav
			VerifySignUpLinkNotDisplayed();
			
			// Step 21 Verify User name is displayed in place of Log in and Sign up links (user is logged into wiki)
			VerifyUserLoggedIn(Username, driver);
			
			// Step 22 Verify user drop down is enabled.
			VerifyUserDropDownEnabled();
				
			// Step 23 Verify user tool bar is displayed at bottom of window.
			VerifyUserToolBarIsDisplayed();
			
			// Step 24 Log out using user drop down log out item.
			LogOutUsingUserDropDown(driver);
			
			// PostConditions - delete Wiki
			deleteWiki(wikiname);
	}
	
//	@Test
	// Test Case 3.1.03 Create new wiki: log in field validation (Latin characters)
	// 2.3.4 Password field Validation:  username and password are correct
	public void TEST_CASE_3_1_03_234() throws Exception {
		// Author: Michal Nowierski
		
		String wikiname = "qatest"+getDateString()+"Automation";
		System.out.println("Create New Wiki Test Case 3.1.03 2.3.4");
		String Username = "¥êœNonLatinQAautomationBot";
		String Password = "";
		
			// Step 0 - Preconditions
			System.out.println("preconditions assurance");
						
			// Step 0 Navigate to http://www.wikia.com/Wikia
			NavigateToWikia(driver);
			
			//Make sure user is logged out.
			MakeSureUserLoggedOut(driver);
			
			// Step 1 Left click "Start a wiki"
			LeftClickStartAwiki();
			
			// Step 2 Verify the Special:CreateNewWiki site is opened
			VerifyTheSpecialCreateNewWiki();
			
			// Step 3 Populate the "Name your wiki" field with a valid wiki name
			PopulateNameYourWikiField(wikiname);
			
			// Step 4 Left click next button
			LeftClickNextButton1();
			
			// Step 5 Verify user is redirected to the Have an Account? page
			VerifyTheHaveAnAccount();

			//Step 6 Populate fields as follows 
			//Username field = valid Latin Username
			//Password field = correct Latin password
			PopulateUsernameAndPasswordField(Username, Password);
			
			// Step 7 Left click log in button.
			LeftClickLogInButton();
			
			// Step 8 Verify next stage in CNW workflow is opened i.e. What is your wiki about? page
			VerifyTheWhatIsYouWikiAbout();

			// Step 9 Populate Describe your topic field.
			PopulateDescribeYourTopic("content");
			
			// Step 10 Select a category from Choose a category drop down
			SelectAcategoryFromDropdown("Sports");
			
			// Step 11 Left click next button
			LeftClickNextButton2();
			
			// Step 12 Left click any theme and left click next button
			LeftClickAnyThemeAndNext();
			
			// Step 13 Close congratulations dialog
			CloseCongratulationDialog();
			
			// Step 14 Verify new wiki has been created.
			VerifyNewWikiCreated(wikiname);
			
			// Step 15 Verify user is logged into wiki.
			VerifyUserLoggedIn(Username, driver);
				
			// Step 16 Verify "Log in" link is not displayed in Global Nav
			VerifyLogInLinkNotDisplayed();
			
			// Step 17 Verify "Sign up" link is not displayed in Global Nav
			VerifySignUpLinkNotDisplayed();
			
			// Step 18 Verify User name is displayed in place of Log in and Sign up links (user is logged into wiki)
			VerifyUserLoggedIn(Username, driver);
			
			// Step 19 Verify user drop down is enabled.
			VerifyUserDropDownEnabled();
				
			// Step 20 Verify user tool bar is displayed at bottom of window.
			VerifyUserToolBarIsDisplayed();
			
			// Step 21 Log out using user drop down log out item.
			LogOutUsingUserDropDown(driver);
			
			// PostConditions - delete Wiki
			deleteWiki(wikiname);
	}

//	@Test
	// Test Case 3.1.04 Create new wiki:  log in field validation (Username with underscore)
	public void TEST_CASE_3_1_04() throws Exception {
		// Author: Michal Nowierski
		
		String wikiname = "qatest"+getDateString()+"Automation";
		System.out.println("Create New Wiki Test Case 3.1.04");
		String Username = "Underscore QA automation Bot";
		String Password = "QAcorrectpassword123";
		
			// Step 0 - Preconditions
			System.out.println("preconditions assurance");
						
			// Step 0 Navigate to http://www.wikia.com/Wikia
			NavigateToWikia(driver);
			
			//Make sure user is logged out.
			MakeSureUserLoggedOut(driver);
			
			// Step 1 Left click "Start a wiki"
			LeftClickStartAwiki();
			
			// Step 2 Verify the Special:CreateNewWiki site is opened
			VerifyTheSpecialCreateNewWiki();
			
			// Step 3 Populate the "Name your wiki" field with a valid wiki name
			PopulateNameYourWikiField(wikiname);
			
			// Step 4 Left click next button
			LeftClickNextButton1();
			
			// Step 5 Verify user is redirected to the Have an Account? page
			VerifyTheHaveAnAccount();

			//Step 6 Populate fields as follows 
			//Username field = valid Username containing underscore
			//Password field = correct Latin password
			PopulateUsernameAndPasswordField(Username, Password);
			
			// Step 7 Left click log in button.
			LeftClickLogInButton();
			
			// Step 8 Verify next stage in CNW workflow is opened i.e. What is your wiki about? page
			VerifyTheWhatIsYouWikiAbout();

			// Step 9 Populate Describe your topic field.
			PopulateDescribeYourTopic("content");
			
			// Step 10 Select a category from Choose a category drop down
			SelectAcategoryFromDropdown("Sports");
			
			// Step 11 Left click next button
			LeftClickNextButton2();
			
			// Step 12 Left click any theme and left click next button
			LeftClickAnyThemeAndNext();
			
			// Step 13 Close congratulations dialog
			CloseCongratulationDialog();
			
			// Step 14 Verify new wiki has been created.
			VerifyNewWikiCreated(wikiname);
			
			// Step 15 Verify user is logged into wiki.
			VerifyUserLoggedIn(Username, driver);
				
			// Step 16 Verify "Log in" link is not displayed in Global Nav
			VerifyLogInLinkNotDisplayed();
			
			// Step 17 Verify "Sign up" link is not displayed in Global Nav
			VerifySignUpLinkNotDisplayed();
			
			// Step 18 Verify User name is displayed in place of Log in and Sign up links (user is logged into wiki)
			VerifyUserLoggedIn(Username, driver);
			
			// Step 19 Verify user drop down is enabled.
			VerifyUserDropDownEnabled();
				
			// Step 20 Verify user tool bar is displayed at bottom of window.
			VerifyUserToolBarIsDisplayed();
			
			// Step 21 Log out using user drop down log out item.
			LogOutUsingUserDropDown(driver);
			
			// PostConditions - delete Wiki
			deleteWiki(wikiname);
	}
	
//	@Test
	// Test Case 3.1.05 Create new wiki: log in: field validation (Username with backward slash \)
	public void TEST_CASE_3_1_05() throws Exception {
		// Author: Michal Nowierski
		
		String wikiname = "qatest"+getDateString()+"Automation";
		System.out.println("Create New Wiki Test Case 3.1.05");
		// REMEMBER! in JAVA \\ means \ and \"  means "
		//therefore the below Username means: Backslash\QA\automation\Bot
		String Username = "Backslash\\QA\\automation\\Bot";
		String Password = "QAcorrectpassword123";
		
			// Step 0 - Preconditions
			System.out.println("preconditions assurance");
						
			// Step 0 Navigate to http://www.wikia.com/Wikia
			NavigateToWikia(driver);
			
			//Make sure user is logged out.
			MakeSureUserLoggedOut(driver);
			
			// Step 1 Left click "Start a wiki"
			LeftClickStartAwiki();
			
			// Step 2 Verify the Special:CreateNewWiki site is opened
			VerifyTheSpecialCreateNewWiki();
			
			// Step 3 Populate the "Name your wiki" field with a valid wiki name
			PopulateNameYourWikiField(wikiname);
			
			// Step 4 Left click next button
			LeftClickNextButton1();
			
			// Step 5 Verify user is redirected to the Have an Account? page
			VerifyTheHaveAnAccount();

			//Step 6 Populate fields as follows 
			//Username field = valid Username containing backward slash
			//Password field = correct Latin password
			PopulateUsernameAndPasswordField(Username, Password);
			
			// Step 7 Left click log in button.
			LeftClickLogInButton();
			
			// Step 8 Verify next stage in CNW workflow is opened i.e. What is your wiki about? page
			VerifyTheWhatIsYouWikiAbout();

			// Step 9 Populate Describe your topic field.
			PopulateDescribeYourTopic("content");
			
			// Step 10 Select a category from Choose a category drop down
			SelectAcategoryFromDropdown("Sports");
			
			// Step 11 Left click next button
			LeftClickNextButton2();
			
			// Step 12 Left click any theme and left click next button
			LeftClickAnyThemeAndNext();
			
			// Step 13 Close congratulations dialog
			CloseCongratulationDialog();
			
			// Step 14 Verify new wiki has been created.
			VerifyNewWikiCreated(wikiname);
			
			// Step 15 Verify user is logged into wiki.
		//TODO: unsure why exception is thrown from the below method. It states that element with alt='Username' was not found, but it definitely exists in the page DOM.
			//execute this step when you will have spare time, find out why this does not work, or find a workaround
//			VerifyUserLoggedIn(Username, driver);
				
			// Step 16 Verify "Log in" link is not displayed in Global Nav
			VerifyLogInLinkNotDisplayed();
			
			// Step 17 Verify "Sign up" link is not displayed in Global Nav
			VerifySignUpLinkNotDisplayed();
			
			// Step 18 Verify User name is displayed in place of Log in and Sign up links (user is logged into wiki)
		//TODO: unsure why exception is thrown from the below method. It states that element with alt='Username' was not found, but it definitely exists in the page DOMd.
			//execute this step when you will have spare time, find out why this does not work, or find a workaround
//			VerifyUserLoggedIn(Username, driver);
			
			// Step 19 Verify user drop down is enabled.
			VerifyUserDropDownEnabled();
				
			// Step 20 Verify user tool bar is displayed at bottom of window.
			VerifyUserToolBarIsDisplayed();
			
			// Step 21 Log out using user drop down log out item.
			LogOutUsingUserDropDown(driver);
			
			// PostConditions - delete Wiki
			deleteWiki(wikiname);
	}
	
	// Test Case 3.1.06 Create new wiki: log in field validation (short Username) <- striked from test cases

//	@Test
	// Test Case 3.1.07 Create new wiki: log in field validation (long Username)
	public void TEST_CASE_3_1_07() throws Exception {
		// Author: Michal Nowierski
		
		String wikiname = "qatest"+getDateString()+"Automation";
		System.out.println("Create New Wiki Test Case 3.1.07");
		// REMEMBER! in JAVA \\ actualy means \. Same as \" actualy means "
		String Username = "1QAautomationBotAutomationAutomationAutomation";
		String Password = "";
		
			// Step 0 - Preconditions
			System.out.println("preconditions assurance");
						
			// Step 0 Navigate to http://www.wikia.com/Wikia
			NavigateToWikia(driver);
			
			//Make sure user is logged out.
			MakeSureUserLoggedOut(driver);
			
			// Step 1 Left click "Start a wiki"
			LeftClickStartAwiki();
			
			// Step 2 Verify the Special:CreateNewWiki site is opened
			VerifyTheSpecialCreateNewWiki();
			
			// Step 3 Populate the "Name your wiki" field with a valid wiki name
			PopulateNameYourWikiField(wikiname);
			
			// Step 4 Left click next button
			LeftClickNextButton1();
			
			// Step 5 Verify user is redirected to the Have an Account? page
			VerifyTheHaveAnAccount();

			//Step 6 Populate fields as follows 
			//Username field = long valid username
			//Password field = correct Latin password
			PopulateUsernameAndPasswordField(Username, Password);
			
			// Step 7 Left click log in button.
			LeftClickLogInButton();
			
			// Step 8 Verify next stage in CNW workflow is opened i.e. What is your wiki about? page
			VerifyTheWhatIsYouWikiAbout();

			// Step 9 Populate Describe your topic field.
			PopulateDescribeYourTopic("content");
			
			// Step 10 Select a category from Choose a category drop down
			SelectAcategoryFromDropdown("Sports");
			
			// Step 11 Left click next button
			LeftClickNextButton2();
			
			// Step 12 Left click any theme and left click next button
			LeftClickAnyThemeAndNext();
			
			// Step 13 Close congratulations dialog
			CloseCongratulationDialog();
			
			// Step 14 Verify new wiki has been created.
			VerifyNewWikiCreated(wikiname);
			
			// Step 15 Verify user is logged into wiki.
			VerifyUserLoggedIn(Username, driver);
				
			// Step 16 Verify "Log in" link is not displayed in Global Nav
			VerifyLogInLinkNotDisplayed();
			
			// Step 17 Verify "Sign up" link is not displayed in Global Nav
			VerifySignUpLinkNotDisplayed();
			
			// Step 18 Verify User name is displayed in place of Log in and Sign up links (user is logged into wiki)
			VerifyUserLoggedIn(Username, driver);
			
			// Step 19 Verify user drop down is enabled.
			VerifyUserDropDownEnabled();
				
			// Step 20 Verify user tool bar is displayed at bottom of window.
			VerifyUserToolBarIsDisplayed();
			
			// Step 21 Log out using user drop down log out item.
			LogOutUsingUserDropDown(driver);
			
			// PostConditions - delete Wiki
			deleteWiki(wikiname);
	}

	// Test Case 3.1.08 Create new wiki: log in field validation (Username with only numbers) <- striked from test cases


// CNW Tests METHODS
protected void VerifyUserDropDownEnabled() throws AWTException, InterruptedException {
	// Author: Michal Nowierski
	//Verify user drop down is enabled.
	//TODO: this propably does not really check what is hould check
		System.out.println("Verify user drop down is enabled.");
		HoverOverElement("ul[id='AccountNavigation'] li a img.chevron", driver);
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("ul.WikiaMenuElement ")));
	
}
protected void VerifyUserToolBarIsDisplayed() {
	// Author: Michal Nowierski
	// Verify user tool bar is displayed at bottom of window.
		System.out
				.println("Verify user tool bar is displayed at bottom of window.");
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("div.toolbar")));
}
protected void VerifySignUpLinkNotDisplayed() {
	// Author: Michal Nowierski
	// Verify "Sign up" link is not displayed in Global Nav
		System.out
				.println("Verify 'Sign up' link is not displayed in Global Nav");
		wait.until(ExpectedConditions.invisibilityOfElementLocated(By
				.cssSelector("ul.AccountNavigation li a.ajaxRegister")));
}
protected void VerifyLogInLinkNotDisplayed() {
	// Author: Michal Nowierski
	//Verify "Log in" link is not displayed in Global Nav
	System.out.println("Verify 'Log in' link is not displayed in Global Nav");
	wait.until(ExpectedConditions.invisibilityOfElementLocated(By
			.cssSelector("ul.AccountNavigation li a.ajaxLogin")));
}

protected void VerifyNewWikiCreated(String wikiname) {
	// Author: Michal Nowierski
	//Verify new wiki has been created - URL contains wikiname
	//URL contains the new wikiname, but all letters are in lowercase then
		wikiname = wikiname.toLowerCase();
		System.out
				.println("Verify new wiki has been created - URL contains wikiname "
						+ wikiname);
		if (!driver.getCurrentUrl().contains(wikiname)) {
			fail("URL does not contain " + wikiname + " key String");
		}

}
protected void CloseCongratulationDialog() {
	// Author: Michal Nowierski
	// Close congratulations dialog
		System.out.println("Close congratulations dialog");
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("section[id='WikiWelcomeWrapper'] button img")));
		WebElement CloseButton = driver.findElement(By
				.cssSelector("section[id='WikiWelcomeWrapper'] button img"));
		CloseButton.click();
		wait.until(ExpectedConditions.invisibilityOfElementLocated(By
				.cssSelector("section[id='WikiWelcomeWrapper'] button img")));
		
}
protected void LeftClickAnyThemeAndNext() throws InterruptedException {
	// Author: Michal Nowierski
	// Left click any theme and left click next button
	System.out.println("Left click any theme");
	wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("li[id='ThemeWiki'] h2")));
		WebElement ChooseAtheme = driver.findElement(By
				.cssSelector("li[id='ThemeWiki'] h2"));
		assertEquals("Left click any theme and left click next button - FAILED", "Choose a theme", ChooseAtheme.getText());
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("li[data-theme='babygirl'] img")));
		WebElement Theme = driver.findElement(By
				.cssSelector("li[data-theme='babygirl'] img"));
		wait.until(ExpectedConditions.elementToBeClickable(By
				.cssSelector("li[data-theme='babygirl'] img")));
			Theme.click();
		wait.until(ExpectedConditions.presenceOfElementLocated(By
				.cssSelector("li.selected[data-theme='babygirl']")));
		System.out.println("left click next button");
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("li[id='ThemeWiki'] input[value='Next']")));
		WebElement next_Button = driver.findElement(By
				.cssSelector("li[id='ThemeWiki'] input[value='Next']"));
		wait.until(ExpectedConditions.elementToBeClickable(By
				.cssSelector("li[id='ThemeWiki'] input[value='Next']")));
		next_Button.click();
		//TODO IE9 failure here 20 july 2012
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
			.cssSelector("section[id='WikiWelcomeWrapper']")));

}

protected void SelectAcategoryFromDropdown(String category) {
	// Author: Michal Nowierski
	// Select a category from Choose a category drop down
		System.out
				.println("Select a category from Choose a category drop down");
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("select[name='wiki-category']")));

		Select select = new Select(driver.findElement(By
				.cssSelector("select[name='wiki-category']")));

		select.selectByVisibleText(category);
		// below code will make sure that proper category is selected
		String category_name = select.getAllSelectedOptions().get(0).getText();
		while (!category_name.equalsIgnoreCase(category)) {
			select.selectByVisibleText(category);
			category_name = select.getAllSelectedOptions().get(0).getText();
				
	}
	
}
protected void PopulateDescribeYourTopic(String content) {
	// Author: Michal Nowierski
	//Populate Describe your topic field.
		System.out.println("Populate Describe your topic field.");
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("form[name='desc-form'] textarea[id='Description']")));
		WebElement Textarea = driver
				.findElement(By
						.cssSelector("form[name='desc-form'] textarea[id='Description']"));
		Textarea.sendKeys(content);
}

protected void VerifyTheWhatIsYouWikiAbout() {
	// Author: Michal Nowierski
	// Verify next stage in CNW workflow is opened i.e. What is your wiki about? page
		System.out
				.println("Verify next stage in CNW workflow is opened i.e. What is your wiki about? page");
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("li[id='DescWiki'] h2")));
		WebElement WhatIsYourWikiAbout = driver.findElement(By
				.cssSelector("li[id='DescWiki'] h2"));
		assertEquals("Verify next stage in CNW workflow is opened - FAILED", "What's your wiki about?", WhatIsYourWikiAbout.getText());
	 
}

protected void VerifyErrorMessageForLogInDialog(String ExpectedErrorMessage) {
	// Author: Michal Nowierski
	//Verify error message,' Oops, please fill in the username field.' is displayed below the username field.
	
	System.out.println("Verify error message,'"+ExpectedErrorMessage+"' is displayed below the username field.");
	//below try catch block is here in case logInButton was not clicked on. selenium 2.24 - it happend once on IE9
	try {
		
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("div.error-msg")));
	} catch (Exception e) {
		WebElement LogInButton = driver.findElement(By
				.cssSelector("div.UserLoginModal div.submits input[value='Log in']"));
		// ChromeDriver does not auto scroll to elements therefore this is needed (18 july 2012)
		scrollToElement(driver, LogInButton);
		wait.until(ExpectedConditions.elementToBeClickable(By.
				cssSelector("div.UserLoginModal div.submits input[value='Log in']")));
		LogInButton.click();
	}
// below code failed test 224 on IE9 (19 jul 2012 Selenium 2.24 )
	wait.until(ExpectedConditions.visibilityOfElementLocated(By
			.cssSelector("div.error-msg")));

	WebElement ErrorMessage = driver.findElement(By
			.cssSelector("div.error-msg"));
	assertEquals(
			"Verify error message is displayed below the username field - FAILED",
			ExpectedErrorMessage, ErrorMessage.getText());
		
	}

	

protected void LeftClickLogInButton() {
	// Author: Michal Nowierski
	//	Left click log in button.
	System.out.println("Left click log in button.");
	wait.until(ExpectedConditions.visibilityOfElementLocated(By
			.cssSelector("div.UserLoginModal div.submits input[value='Log in']")));

	WebElement LogInButton = driver.findElement(By
			.cssSelector("div.UserLoginModal div.submits input[value='Log in']"));
	// ChromeDriver does not auto scroll to elements therefore this is needed (18 july 2012)
	scrollToElement(driver, LogInButton);
	wait.until(ExpectedConditions.elementToBeClickable(By.
			cssSelector("div.UserLoginModal div.submits input[value='Log in']")));
	
	LogInButton.click();

}
protected void PopulateUsernameAndPasswordField(String username, String password) {
	// Author: Michal Nowierski
	//Populate fields as follows
	System.out.println("Populate fields as follows");
	wait.until(ExpectedConditions.presenceOfElementLocated(By
			.cssSelector("div.UserLoginModal input[name='username']")));
	WebElement Username_field = driver.findElement(By
			.cssSelector("div.UserLoginModal input[name='username']"));
	System.out.println("Verify Password field is Blank");
	WebElement Password_field = driver.findElement(By
			.cssSelector("div.UserLoginModal input[name='password']"));
    //Make Sure Username and password field are blank
	Username_field.clear();
    Password_field.clear();
    //Send given username and password
    Username_field.sendKeys(username);
    Password_field.sendKeys(password);
	
}
	protected void VerifyTheHaveAnAccount() {
		// Author: Michal Nowierski
		//Verify user is redirected to the Have an Account? page
		System.out.println("Verify user is redirected to the Have an Account? page");
		//test 222 IE9 failure at below line. 19 july 2012 16:00 Selenium 2.24
		// propably due to faulty working IE9 'click' method. 
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("h2.headline")));
		WebElement Have_an_Account = driver.findElement(By
				.cssSelector("h2.headline"));
		String text = Have_an_Account.getText();
		assertEquals("TEST CASE step 7: Anon user have not been redirected to \"Have an account?\" site or the headline \"Have an account?\" has different text from what it should have", "Have an account?", text);
	
	}
	protected void LeftClickNextButton1() throws InterruptedException {
		// Author: Michal Nowierski
		// Left click next button
		System.out.println("Left click next button");
		WebElement error = driver.findElement(By
				.cssSelector("span.submit-error.error-msg"));
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.className("next-controls")));
		WebElement next_Button = driver.findElement(By
				.className("next-controls"));
		wait.until(ExpectedConditions.elementToBeClickable(By
				.className("next-controls")));

		next_Button.click();
		

		error = driver.findElement(By
				.cssSelector("span.submit-error.error-msg"));
		while (error
				.getText()
				.equalsIgnoreCase(
						"Oops! You need to fill in both of the boxes above to keep going.")) {
			wait.until(ExpectedConditions.invisibilityOfElementLocated(By
					.cssSelector("span.submit-error.error-msg")));
			wait.until(ExpectedConditions.elementToBeClickable(By
					.className("next-controls")));
			// The below sleep is necessary because otherwise IE webdriver may
			// not get out of the 'while' loop
			Thread.sleep(300);
			next_Button.click();
			// the Try catch block below is needed - in some cases click method doesn't work on the first click. It's here to make sure we click next
			try {
				wait.until(ExpectedConditions.invisibilityOfElementLocated(By
						.cssSelector("div.language-default")));
			} catch (Exception e) {
				
				next_Button.click();
			}
			
		}
		try {
			wait.until(ExpectedConditions.invisibilityOfElementLocated(By
					.cssSelector("div.language-default")));
		} catch (Exception e) {
			
			next_Button.click();
		}
	

	}
	protected void LeftClickNextButton2() {
		// Author: Michal Nowierski
		//Left click next button		
		System.out.println("Left click next button");
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("form[name='desc-form'] input[value='Next']")));
		WebElement next_Button = driver.findElement(By
				.cssSelector("form[name='desc-form'] input[value='Next']"));
		scrollToElement(driver, next_Button);
		// the above mehtod is needed for Chrome (17 july 2012 Selenium Webdriver 2.24 version)
		wait.until(ExpectedConditions.elementToBeClickable(By
				.cssSelector("form[name='desc-form'] input[value='Next']")));
		next_Button.click();
		

		
	}
	protected void VerifyTheGiveYourWikiAnAddress() {
		// Author: Michal Nowierski
		// Verify the "Give your wiki an address" appears with a green tick and that field is auto populated
		System.out.println("Verify the 'Give your wiki an address' appears with a green tick and that field is auto populated");
		wait.until(ExpectedConditions.presenceOfElementLocated(By
				.cssSelector("span.domain-status-icon.status-icon img")));
		//IE9 failure at below line: Error determining if element is displayed 19 july 2012
		//Related issue: https://groups.google.com/forum/#!msg/webdriver/YlmQlaVAP-E/eEgyOM4MqPgJ
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("span.domain-status-icon.status-icon img")));
		
		
	}
	protected void PopulateNameYourWikiField(String wikiname) {
		// Author: Michal Nowierski
		// Populate the "Name your wiki" field with a valid wiki name
		WebElement wiki_name = driver.findElement(By.name("wiki-name"));
		System.out.println("Populate the 'Name your wiki' field with a valid wiki name");
		wiki_name.sendKeys(wikiname);
		
	}
	protected void LeftClickStartAwiki() {
		// Author: Michal Nowierski
		// Left click "Start a wiki"
		//IE9 failure at the line below test 20 july. 
		WebElement start_a_wiki_button = driver
		.findElement(By
				.cssSelector("header.wikiahomepage-header a[href='http://www.wikia.com/Special:CreateWiki']"));
		System.out.println("Left click \"Start a wiki\"");
		start_a_wiki_button.click();
		
		wait.until(ExpectedConditions.presenceOfElementLocated(By
				.name("label-wiki-form")));
	}
	protected void VerifyTheSpecialCreateNewWiki() {
		// Author: Michal Nowierski
		// Verify the Special:CreateNewWiki site is opened
		System.out.println("Verify the Special:CreateNewWiki site is opened");
		if (!driver.getCurrentUrl().contains("Special:CreateNewWiki")) {
			fail("TEST CASE step 3: URL does not contain 'Special:CreateNewWiki' key String");
		}

		WebElement name_your_wiki = driver.findElement(By
				.name("label-wiki-form"));
		wait.until(ExpectedConditions.visibilityOf(name_your_wiki));
		
	}
	
	// DELETION METHODS

	protected void deleteWiki(String wikiname) {
		// Author: Michal Nowierski
		System.out.println("Deleting wiki "+wikiname);
		navigateToWikiFactory();
		DeleteParticularWiki(wikiname);

	}
	protected void deleteListOfWikis(ArrayList<String> WikisToBeDeleted) {
		// Author: Michal Nowierski
		// Delete whole list of wikis
		
		if (WikisToBeDeleted.isEmpty()) {
			fail("No Wikis in the list");
		}
		navigateToWikiFactory();
		DeleteParticularWiki(WikisToBeDeleted.get(0));
		if (WikisToBeDeleted.isEmpty()) {
			System.out.println("You should not use DeleteListOfWikis Mehtod to delete only 1 wiki. DeleteWiki Mehtod is designed for that");
			this.driver.close();
			this.driver.quit();
		}
		else {
			for (int i = 1; i < WikisToBeDeleted.size(); i++) {
				ContinueDeletinWikis(WikisToBeDeleted.get(i));
			}

			
		}
	}

	private void ContinueDeletinWikis(String wikiname) {
		// Author: Michal Nowierski
		// continue deleting after one deletion - in order to not have to log in again etc
		this.wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("div.WikiaArticle input[name='wiki-return']")));
		WebElement BackToWikiFactory = this.driver.findElement(By
				.cssSelector("div.WikiaArticle input[name='wiki-return']"));
		this.wait.until(ExpectedConditions.elementToBeClickable(By
				.cssSelector("div.WikiaArticle input[name='wiki-return']")));
		BackToWikiFactory.click();
		this.wait
		.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("form[id='WikiFactoryDomainSelector'] input[name='wpCityDomain']")));
		DeleteParticularWiki(wikiname);
	}


	private void navigateToWikiFactory() {
		// Author: Michal Nowierski

		this.driver.get("http://community.wikia.com/wiki/Special:UserLogin");
		this.wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("div.UserLogin input[name='username']")));
		WebElement login_field = this.driver.findElement(By
				.cssSelector("div.UserLogin input[name='username']"));
		login_field.sendKeys(this.STAFFlogin);
		WebElement password_field = this.driver.findElement(By
				.cssSelector("div.UserLogin input[name='password']"));
		password_field.sendKeys(this.STAFFpassword);
		WebElement log_in_button = this.driver.findElement(By
				.cssSelector("div.UserLogin input[value='Log in']"));
		this.wait.until(ExpectedConditions.elementToBeClickable(By
				.cssSelector("div.UserLogin input[value='Log in']")));
		log_in_button.click();
		this.wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("div.wordmark img[class='sprite logo4']")));

		// if there is an error message on the page, the below while will hande it
		while (!this.driver.findElements(
				By.cssSelector("div.UserLogin div.error-msg")).isEmpty()) {
			log_in_button = this.driver.findElement(By
					.cssSelector("div.UserLogin input[value='Log in']"));
			this.wait.until(ExpectedConditions.elementToBeClickable(By
					.cssSelector("div.UserLogin input[value='Log in']")));
			log_in_button.click();
			this.wait.until(ExpectedConditions.visibilityOfElementLocated(By
					.cssSelector("div.wordmark img[class='sprite logo4']")));

		}
		
		this.wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("img[alt='"+STAFFlogin+"']")));

		this.driver.get("http://community.wikia.com/wiki/Special:WikiFactory");
		this.wait
				.until(ExpectedConditions.visibilityOfElementLocated(By
						.cssSelector("form[id='WikiFactoryDomainSelector'] input[name='wpCityDomain']")));
	}

	private void DeleteParticularWiki(String wikiname) {
		// Author: Michal Nowierski
		// Delete only one wiki
		
		if (!wikiname.toLowerCase().contains("qatest")) {
			fail("CNWwikiDeletor deletes only wikis witch keystring 'qatest'");
		}
		
		WebElement wiki_name_field = this.driver
				.findElement(By
						.cssSelector("form[id='WikiFactoryDomainSelector'] input[name='wpCityDomain']"));
		wiki_name_field.sendKeys(wikiname);

		WebElement get_configuration_button = this.driver.findElement(By
				.cssSelector("form[id='WikiFactoryDomainSelector'] button"));
		this.wait.until(ExpectedConditions.elementToBeClickable(By
				.cssSelector("form[id='WikiFactoryDomainSelector'] button")));
		get_configuration_button.click();
		this.wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("div.wordmark img[class='sprite logo4']")));

		// existance of below element means that status of the wiki is 'enabled'
		// (green) not 'disabled' (red). If Exception is thrown here it might
		// also mean that the wiki does not exist
		//TODO: Jesli chce sie usuwac kilka wiki na raz, to lepiej te ify  zrobic tak zeby program szedl na koniec, ale zeby driver sie nie wywalal, bo wtedy jak bedzie sie kasowac wikis hurtowo to sie jedna wywali i cale kasowanie sie wywali
		try {
			//This block is added due to a failure that occured during one of test - somehow, there was presence of below element, although it wasn't there when i checked it after the failure. So lets wait some seconds and make sure before official validation (the next "if" block)
			wait.until(ExpectedConditions.invisibilityOfElementLocated(By
					.cssSelector("form[id='WikiFactoryDomainSelector']")));
		} catch (Exception e) {
			
		}
		// do some validation.
		if (!this.driver.findElements(
				By.cssSelector("form[id='WikiFactoryDomainSelector']")).isEmpty()) {
			fail("wiki: "+wikiname+"  does not exist");

		}
		if (!this.driver.findElements(
				By.cssSelector("div[id='wk-wf-info'] table.WikiaTable td[data-status='0']")).isEmpty()) {
			fail("wiki: "+wikiname+" is allready closed (disables status of the wiki)");

		}
		this.wait
				.until(ExpectedConditions.visibilityOfElementLocated(By
						.cssSelector("div[id='wk-wf-info'] table.WikiaTable td[data-status='1']")));
		WebElement Close_tab = this.driver
				.findElement(By
						.cssSelector("ul.tabs[id='wiki-factory-tabs'] a[href$='close']")); 
		//$= css selector (used in the line above) means that an atribute gref ands wit the 'close' word 																				// 
																						
		this.wait.until(ExpectedConditions.elementToBeClickable(By
				.cssSelector("ul[id='wiki-factory-tabs'] a[href$='close']")));
		Close_tab.click();
		this.wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("div.wordmark img[class='sprite logo4']")));
		this.wait
				.until(ExpectedConditions.visibilityOfElementLocated(By
						.cssSelector("form[id='wk-wf-variables-select'] input[id='flag_1']")));
		WebElement Create_a_database_dump = this.driver
				.findElement(By
						.cssSelector("form[id='wk-wf-variables-select'] input[id='flag_1']"));

		this.wait
				.until(ExpectedConditions.elementToBeClickable(By
						.cssSelector("form[id='wk-wf-variables-select'] input[id='flag_1']")));
		// uncheck Create_a_database_dump
		scrollToElement(this.driver, Create_a_database_dump);
		Create_a_database_dump.click();

		this.wait
				.until(ExpectedConditions.elementToBeClickable(By
						.cssSelector("form[id='wk-wf-variables-select'] input[id='flag_2']")));
		// uncheck Create_an_image_archive
		WebElement Create_an_image_archive = this.driver
				.findElement(By
						.cssSelector("form[id='wk-wf-variables-select'] input[id='flag_2']"));
		scrollToElement(this.driver, Create_an_image_archive);
		Create_an_image_archive.click();

		this.wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("div.wordmark img[class='sprite logo4']")));

		this.wait
				.until(ExpectedConditions.elementToBeClickable(By
						.cssSelector("div[id='wiki-factory-close'] input[value='Confirm close']")));

		// click on confirm close
		WebElement confirm_close = this.driver
				.findElement(By
						.cssSelector("div[id='wiki-factory-close'] input[value='Confirm close']"));
		 scrollToElement(this.driver, confirm_close); 
		// to
		confirm_close.click();
			
		//invisibility of the below element will meant that confirm_close click was succesful
		wait.until(ExpectedConditions.invisibilityOfElementLocated(By
				.cssSelector("div[id='wiki-factory-panel'] ul[id=¹wiki-factory-tabs¹]")));

		this.wait
				.until(ExpectedConditions.visibilityOfElementLocated(By
						.cssSelector("div[id='WikiaArticle'] input[value='Confirm close']")));

		this.wait
				.until(ExpectedConditions.elementToBeClickable(By
						.cssSelector("div[id='WikiaArticle'] input[value='Confirm close']")));
		// click on confirm close
		confirm_close = this.driver
				.findElement(By
						.cssSelector("div[id='WikiaArticle'] input[value='Confirm close']"));
		scrollToElement(this.driver, confirm_close);//Chrome nie przewija do elementow podczas wykonywania metody click
		confirm_close.click();
		//invisibility of the below element will meant that confirm_close click was succesful
		wait.until(ExpectedConditions.invisibilityOfElementLocated(By
				.cssSelector("table.WikiaTable")));
		
		System.out.println("Deleting wiki "+wikiname+" has been succesful");

	}
}
