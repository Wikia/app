package com.wikia.webdriver.TestCases.CreateAWikiTests;

import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Properties.Properties;
import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.PageObjects.PageObject.HomePageObject;
import com.wikia.webdriver.PageObjects.PageObject.CreateNewWiki.CreateNewWikiLogInPageObject;
import com.wikia.webdriver.PageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep1;
import com.wikia.webdriver.PageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep2;
import com.wikia.webdriver.PageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep3;
import com.wikia.webdriver.PageObjects.PageObject.CreateNewWiki.NewWikiaHomePage;

public class CreateAWikiTests_misc extends TestTemplate 
{
	private String wikiName;
	/*
	 * Test Case 3.1.09 Create new wiki: log in browser back button
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_CNW#Test_Case_3.1.01_Create_new_wiki_Have_an_account.3F_page:_Display  
	 * */
//	@Test
	public void CreateNewWiki_misc_001_log_in_browser_back_button()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		HomePageObject home = new HomePageObject(driver);
		home.openHomePage();
		CommonFunctions.logIn();
		CreateNewWikiPageObjectStep1 createNewWiki1 = home.startAWiki();
		String timeStamp = createNewWiki1.getTimeStamp();
		wikiName = "QaTest"+timeStamp;
		createNewWiki1.typeInWikiName(wikiName);
		createNewWiki1.waitForSuccessIcon();
		CreateNewWikiPageObjectStep2 createNewWiki2 = createNewWiki1.submit();
		createNewWiki2.describeYourTopic("Duis quam ante, fringilla at cursus tristique, laoreet vel elit. Nullam rhoncus, magna ut dictum ultrices, mauris lectus consectetur tellus, sed dignissim elit justo vel ante.");
		createNewWiki2.selectCategory("Auto");
		CreateNewWikiPageObjectStep3 createNewWiki3 = createNewWiki2.submit();
		createNewWiki3.selectTheme(3);
		NewWikiaHomePage newWikia = createNewWiki3.submit(wikiName);
		newWikia.VerifyCongratulationsLightBox();
		newWikia.closeCongratulationsLightBox();
		newWikia.navigateBack();
		createNewWiki1.verifyOccupiedWikiAddress(wikiName);
		
	}
	
	/*
	 * Test Case 3.1.13 Create new wiki: log in FaceBook button (logged out of FaceBook)
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_CNW#Test_Case_3.1.01_Create_new_wiki_Have_an_account.3F_page:_Display  
	 * */
	@Test
	public void CreateNewWiki_misc_002_log_in_facebook_button_logged_out()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		HomePageObject home = new HomePageObject(driver);
		home.openHomePage();
		CreateNewWikiPageObjectStep1 createNewWiki1 = home.startAWiki();
		String timeStamp = createNewWiki1.getTimeStamp();
		wikiName = "QaTest"+timeStamp;
		createNewWiki1.typeInWikiName(wikiName);
		createNewWiki1.waitForSuccessIcon();
		CreateNewWikiLogInPageObject createNewWikiLoginPage = createNewWiki1.submitToLogIn();
		createNewWikiLoginPage.facebookConnectButtonClick();
		
//		driver.switchTo().window("Log In | Facebook");
		WebElement email = driver.findElement(By.cssSelector("input[id='email']"));
		WebElement pass = driver.findElement(By.cssSelector("input[id='pass']"));
		
		CommonFunctions.logOut(Properties.userName, driver);
		
		
		
		
		
//		createNewWiki2.describeYourTopic("Duis quam ante, fringilla at cursus tristique, laoreet vel elit. Nullam rhoncus, magna ut dictum ultrices, mauris lectus consectetur tellus, sed dignissim elit justo vel ante.");
//		createNewWiki2.selectCategory("Auto");
//		CreateNewWikiPageObjectStep3 createNewWiki3 = createNewWiki2.submit();
//		createNewWiki3.selectTheme(3);
//		NewWikiaHomePage newWikia = createNewWiki3.submit(wikiName);
//		newWikia.VerifyCongratulationsLightBox();
//		newWikia.closeCongratulationsLightBox();
//		newWikia.navigateBack();
//		createNewWiki1.verifyOccupiedWikiAddress(wikiName);
//		stopBrowser();
	}
	
	
	
	
}
