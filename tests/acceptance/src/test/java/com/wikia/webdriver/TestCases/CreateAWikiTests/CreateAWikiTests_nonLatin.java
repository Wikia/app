package com.wikia.webdriver.TestCases.CreateAWikiTests;

import org.testng.annotations.Test;

import com.wikia.webdriver.Common.CommonFunctions;
import com.wikia.webdriver.Templates.TestTemplate;
import com.wikia.webdriver.pageObjects.PageObject.BasePageObject;
import com.wikia.webdriver.pageObjects.PageObject.HomePageObject;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiLogInPageObject;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep1;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep2;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep3;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.NewWikiaHomePage;





public class CreateAWikiTests_nonLatin extends TestTemplate
{
	private String wikiName;

	
	
	/*
	 * Test Case 3.1.03 Create new wiki: log in field validation (non-Latin characters)
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_CNW#Test_Case_3.1.02_Create_new_wiki:_log_in_field_validation_.28Latin_characters.29
	 * Username field validation: username does not exist  
	 * */
	@Test
	public void CreateNewWiki_nonLatin_TC001_user_name_does_not_exists()
	{
		driver.get("http://community.wikia.com/wiki/Special:UserLogout?returnto=User "+BasePageObject.userNameNonLatinEncoded);
		HomePageObject home = new HomePageObject(driver);
		home.openHomePage();
		CreateNewWikiPageObjectStep1 createNewWiki1 = home.StartAWikia();
		String timeStamp = createNewWiki1.getTimeStamp();
		wikiName = "QaTest"+timeStamp;
		createNewWiki1.typeInWikiName(wikiName);
		createNewWiki1.waitForSuccessIcon();
		CreateNewWikiLogInPageObject logInPage = createNewWiki1.submitToLogIn();
		logInPage.typeInUserName("查爾斯和");
		logInPage.submitLogin();
		logInPage.verifyInvalidUserNameValidation();
		logInPage.typeInUserName(BasePageObject.userNameNonLatin);
		logInPage.typeInPassword(BasePageObject.passwordNonLatin);
		CreateNewWikiPageObjectStep2 createNewWiki2 = logInPage.submitLogin();
		createNewWiki2.describeYourTopic("Duis quam ante, fringilla at cursus tristique, laoreet vel elit. Nullam rhoncus, magna ut dictum ultrices, mauris lectus consectetur tellus, sed dignissim elit justo vel ante.");
		createNewWiki2.selectCategory("Auto");
		CreateNewWikiPageObjectStep3 createNewWiki3 = createNewWiki2.submit();
		createNewWiki3.selectTheme(3);
		NewWikiaHomePage newWikia = createNewWiki3.submit();
		newWikia.VerifyCongratulationsLightBox();
		newWikia.closeCongratulationsLightBox();
		newWikia.vefifyUserLoggedIn(BasePageObject.userNameNonLatinEncoded);
		newWikia.verifyUserToolBar();
		CommonFunctions.logOut(BasePageObject.userNameNonLatin);
		driver.get("http://community.wikia.com/wiki/Special:UserLogout?returnto=User "+BasePageObject.userNameNonLatinEncoded);
	}
	
	/*
	 * Test Case 3.1.02 Create new wiki: log in field validation (Latin characters)
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_CNW#Test_Case_3.1.02_Create_new_wiki:_log_in_field_validation_.28Latin_characters.29
	 * Password field Validation: password is blank
	 * */
	@Test
	public void CreateNewWiki_nonLatin_TC002_password_is_blank()
	{
		driver.get("http://community.wikia.com/wiki/Special:UserLogout?returnto=User "+BasePageObject.userNameNonLatinEncoded);
		HomePageObject home = new HomePageObject(driver);
		home.openHomePage();
		CreateNewWikiPageObjectStep1 createNewWiki1 = home.StartAWikia();
		String timeStamp = createNewWiki1.getTimeStamp();
		wikiName = "QaTest"+timeStamp;
		createNewWiki1.typeInWikiName(wikiName);
		createNewWiki1.waitForSuccessIcon();
		CreateNewWikiLogInPageObject logInPage = createNewWiki1.submitToLogIn();
		logInPage.typeInUserName(BasePageObject.userNameNonLatin);
		logInPage.submitLogin();
		logInPage.verifyBlankPasswordValidation();
		logInPage.typeInUserName(BasePageObject.userNameNonLatin);
		logInPage.typeInPassword(BasePageObject.passwordNonLatin);
		CreateNewWikiPageObjectStep2 createNewWiki2 = logInPage.submitLogin();
		createNewWiki2.describeYourTopic("Duis quam ante, fringilla at cursus tristique, laoreet vel elit. Nullam rhoncus, magna ut dictum ultrices, mauris lectus consectetur tellus, sed dignissim elit justo vel ante.");
		createNewWiki2.selectCategory("Auto");
		CreateNewWikiPageObjectStep3 createNewWiki3 = createNewWiki2.submit();
		createNewWiki3.selectTheme(3);
		NewWikiaHomePage newWikia = createNewWiki3.submit();
		newWikia.VerifyCongratulationsLightBox();
		newWikia.closeCongratulationsLightBox();
		newWikia.vefifyUserLoggedIn(BasePageObject.userNameNonLatinEncoded);
		newWikia.verifyUserToolBar();
		CommonFunctions.logOut(BasePageObject.userNameNonLatinEncoded);
		driver.get("http://community.wikia.com/wiki/Special:UserLogout?returnto=User "+BasePageObject.userNameNonLatinEncoded);
	}
	
	/*
	 * Test Case 3.1.02 Create new wiki: log in field validation (Latin characters)
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_CNW#Test_Case_3.1.02_Create_new_wiki:_log_in_field_validation_.28Latin_characters.29
	 * Password field Validation: password is incorrect
	 * */
	@Test
	public void CreateNewWiki_nonLatin_TC003_password_is_incorrect()
	{
		driver.get("http://community.wikia.com/wiki/Special:UserLogout?returnto=User "+BasePageObject.userNameNonLatinEncoded);
		HomePageObject home = new HomePageObject(driver);
		home.openHomePage();
		CreateNewWikiPageObjectStep1 createNewWiki1 = home.StartAWikia();
		String timeStamp = createNewWiki1.getTimeStamp();
		wikiName = "QaTest"+timeStamp;
		createNewWiki1.typeInWikiName(wikiName);
		createNewWiki1.waitForSuccessIcon();
		CreateNewWikiLogInPageObject logInPage = createNewWiki1.submitToLogIn();
		logInPage.typeInUserName(BasePageObject.userNameNonLatin);
		logInPage.typeInPassword("Invalid password");
		logInPage.submitLogin();
		logInPage.verifyInvalidPasswordValidation();
		logInPage.typeInUserName(BasePageObject.userNameNonLatin);
		logInPage.typeInPassword(BasePageObject.passwordNonLatin);
		CreateNewWikiPageObjectStep2 createNewWiki2 = logInPage.submitLogin();
		createNewWiki2.describeYourTopic("Duis quam ante, fringilla at cursus tristique, laoreet vel elit. Nullam rhoncus, magna ut dictum ultrices, mauris lectus consectetur tellus, sed dignissim elit justo vel ante.");
		createNewWiki2.selectCategory("Auto");
		CreateNewWikiPageObjectStep3 createNewWiki3 = createNewWiki2.submit();
		createNewWiki3.selectTheme(3);
		NewWikiaHomePage newWikia = createNewWiki3.submit();
		newWikia.VerifyCongratulationsLightBox();
		newWikia.closeCongratulationsLightBox();
		newWikia.vefifyUserLoggedIn(BasePageObject.userNameNonLatinEncoded);
		newWikia.verifyUserToolBar();
		driver.get("http://community.wikia.com/wiki/Special:UserLogout?returnto=User "+BasePageObject.userNameNonLatinEncoded);
	}
	
	/*
	 * Test Case 3.1.02 Create new wiki: log in field validation (Latin characters)
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_CNW#Test_Case_3.1.02_Create_new_wiki:_log_in_field_validation_.28Latin_characters.29
	 * Password field Validation: username and password are correct
	 * */
	@Test
	public void CreateNewWiki_nonLatin_TC004_user_name_and_password_are_correct()
	{
		driver.get("http://community.wikia.com/wiki/Special:UserLogout?returnto=User "+BasePageObject.userNameNonLatinEncoded);
		HomePageObject home = new HomePageObject(driver);
		home.openHomePage();
		CreateNewWikiPageObjectStep1 createNewWiki1 = home.StartAWikia();
		String timeStamp = createNewWiki1.getTimeStamp();
		wikiName = "QaTest"+timeStamp;
		createNewWiki1.typeInWikiName(wikiName);
		createNewWiki1.waitForSuccessIcon();
		CreateNewWikiLogInPageObject logInPage = createNewWiki1.submitToLogIn();
		logInPage.typeInUserName(BasePageObject.userNameNonLatin);
		logInPage.typeInPassword(BasePageObject.passwordNonLatin);
		CreateNewWikiPageObjectStep2 createNewWiki2 = logInPage.submitLogin();
		createNewWiki2.describeYourTopic("Duis quam ante, fringilla at cursus tristique, laoreet vel elit. Nullam rhoncus, magna ut dictum ultrices, mauris lectus consectetur tellus, sed dignissim elit justo vel ante.");
		createNewWiki2.selectCategory("Auto");
		CreateNewWikiPageObjectStep3 createNewWiki3 = createNewWiki2.submit();
		createNewWiki3.selectTheme(3);
		NewWikiaHomePage newWikia = createNewWiki3.submit();
		newWikia.VerifyCongratulationsLightBox();
		newWikia.closeCongratulationsLightBox();
		newWikia.vefifyUserLoggedIn(BasePageObject.userNameNonLatinEncoded);
		newWikia.verifyUserToolBar();
		driver.get("http://community.wikia.com/wiki/Special:UserLogout?returnto=User "+BasePageObject.userNameNonLatinEncoded);
	}	
	
}
