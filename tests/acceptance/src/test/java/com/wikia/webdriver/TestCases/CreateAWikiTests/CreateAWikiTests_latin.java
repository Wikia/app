package com.wikia.webdriver.TestCases.CreateAWikiTests;

import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Properties.Properties;
import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.PageObjects.PageObject.HomePageObject;
import com.wikia.webdriver.PageObjects.PageObject.SpecialFactoryPageObject;
import com.wikia.webdriver.PageObjects.PageObject.CreateNewWiki.CreateNewWikiLogInPageObject;
import com.wikia.webdriver.PageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep1;
import com.wikia.webdriver.PageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep2;
import com.wikia.webdriver.PageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep3;
import com.wikia.webdriver.PageObjects.PageObject.CreateNewWiki.NewWikiaHomePage;





public class CreateAWikiTests_latin extends TestTemplate
{
	private String wikiName;
	
	
	
	/*
	 * Test Case 3.1.01 Create new wiki Have an account? page: Display
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_CNW#Test_Case_3.1.01_Create_new_wiki_Have_an_account.3F_page:_Display  
	 * */
//	@Test(groups = {"CreateNewWiki_latin_001","CNW"})
	public void CreateNewWiki_latin_001_have_an_account()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		HomePageObject home = new HomePageObject(driver);
		home.openHomePage();
		CreateNewWikiPageObjectStep1 createNewWiki1 = home.startAWiki();
		String timeStamp = createNewWiki1.getTimeStamp();
		wikiName = "QaTest"+timeStamp;
		createNewWiki1.typeInWikiName(wikiName);
		createNewWiki1.waitForSuccessIcon();
		CreateNewWikiLogInPageObject logInPage = createNewWiki1.submitToLogIn();
		logInPage.verifyTabTransition();
		logInPage.verifyFaceBookToolTip();
		logInPage.verifySignUpText();
		CommonFunctions.logOut(Properties.userName, driver);
	}
	
	
	/*
	 * Test Case 3.1.02 Create new wiki: log in field validation (Latin characters)
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_CNW#Test_Case_3.1.02_Create_new_wiki:_log_in_field_validation_.28Latin_characters.29  
	 * Username field validation: username is blank
	 * */
	@Test(groups = {"CreateNewWiki_latin_002","CNW"})
	public void CreateNewWiki_latin_TC002_user_name_is_blank()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		HomePageObject home = new HomePageObject(driver);
		home.openHomePage();
		CreateNewWikiPageObjectStep1 createNewWiki1 = home.startAWiki();
		String timeStamp = createNewWiki1.getTimeStamp();
		wikiName = "QaTest"+timeStamp;
		createNewWiki1.typeInWikiName(wikiName);
		createNewWiki1.waitForSuccessIcon();
		CreateNewWikiLogInPageObject logInPage = createNewWiki1.submitToLogIn();
		logInPage.submitLogin();
		logInPage.verifyEmptyUserNameValidation();
		logInPage.typeInUserName(Properties.userName);		
		logInPage.typeInPassword(Properties.password);
		CreateNewWikiPageObjectStep2 createNewWiki2 = logInPage.submitLogin();
		createNewWiki2.describeYourTopic("Duis quam ante, fringilla at cursus tristique, laoreet vel elit. Nullam rhoncus, magna ut dictum ultrices, mauris lectus consectetur tellus, sed dignissim elit justo vel ante.");
		createNewWiki2.selectCategory("Auto");
		CreateNewWikiPageObjectStep3 createNewWiki3 = createNewWiki2.submit();
		createNewWiki3.selectTheme(3);
		NewWikiaHomePage newWikia = createNewWiki3.submit(wikiName);
		newWikia.VerifyCongratulationsLightBox();
		newWikia.closeCongratulationsLightBox();
		newWikia.verifyUserLoggedIn(Properties.userName);
		CommonFunctions.logOut(Properties.userName, driver);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		SpecialFactoryPageObject factory = new SpecialFactoryPageObject(driver);
		factory.openWikiFactoryPage();
		factory.deleteWiki(wikiName);
		CommonFunctions.logOut(Properties.userNameStaff, driver);
	}
	
	
	/*
	 * Test Case 3.1.02 Create new wiki: log in field validation (Latin characters)
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_CNW#Test_Case_3.1.02_Create_new_wiki:_log_in_field_validation_.28Latin_characters.29
	 * Username field validation: username does not exist  
	 * */
	@Test(groups = {"CreateNewWiki_latin_003","CNW"})
	public void CreateNewWiki_latin_TC003_user_name_does_not_exists()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		HomePageObject home = new HomePageObject(driver);
		home.openHomePage();
		CreateNewWikiPageObjectStep1 createNewWiki1 = home.startAWiki();
		String timeStamp = createNewWiki1.getTimeStamp();
		wikiName = "QaTest"+timeStamp;
		createNewWiki1.typeInWikiName(wikiName);
		createNewWiki1.waitForSuccessIcon();
		CreateNewWikiLogInPageObject logInPage = createNewWiki1.submitToLogIn();
		logInPage.typeInUserName("invalidUserName");
		logInPage.submitLogin();
		logInPage.verifyInvalidUserNameValidation();
		logInPage.typeInUserName(Properties.userName);
		logInPage.typeInPassword(Properties.password);
		CreateNewWikiPageObjectStep2 createNewWiki2 = logInPage.submitLogin();
		createNewWiki2.describeYourTopic("Duis quam ante, fringilla at cursus tristique, laoreet vel elit. Nullam rhoncus, magna ut dictum ultrices, mauris lectus consectetur tellus, sed dignissim elit justo vel ante.");
		createNewWiki2.selectCategory("Auto");
		CreateNewWikiPageObjectStep3 createNewWiki3 = createNewWiki2.submit();
		createNewWiki3.selectTheme(3);
		NewWikiaHomePage newWikia = createNewWiki3.submit(wikiName);
		newWikia.VerifyCongratulationsLightBox();
		newWikia.closeCongratulationsLightBox();
		newWikia.verifyUserLoggedIn(Properties.userName);
		newWikia.verifyUserToolBar();
		CommonFunctions.logOut(Properties.userName, driver);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		SpecialFactoryPageObject factory = new SpecialFactoryPageObject(driver);
		factory.openWikiFactoryPage();
		factory.deleteWiki(wikiName);
		CommonFunctions.logOut(Properties.userNameStaff, driver);
	}
	
	/*
	 * Test Case 3.1.02 Create new wiki: log in field validation (Latin characters)
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_CNW#Test_Case_3.1.02_Create_new_wiki:_log_in_field_validation_.28Latin_characters.29
	 * Password field Validation: password is blank
	 * */
	@Test(groups = {"CreateNewWiki_latin_004","CNW"})
	public void CreateNewWiki_latin_TC004_password_is_blank()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		HomePageObject home = new HomePageObject(driver);
		home.openHomePage();
		CreateNewWikiPageObjectStep1 createNewWiki1 = home.startAWiki();
		String timeStamp = createNewWiki1.getTimeStamp();
		wikiName = "QaTest"+timeStamp;
		createNewWiki1.typeInWikiName(wikiName);
		createNewWiki1.waitForSuccessIcon();
		CreateNewWikiLogInPageObject logInPage = createNewWiki1.submitToLogIn();
		logInPage.typeInUserName(Properties.userName);
		logInPage.submitLogin();
		logInPage.verifyBlankPasswordValidation();
		logInPage.typeInUserName(Properties.userName);
		logInPage.typeInPassword(Properties.password);
		CreateNewWikiPageObjectStep2 createNewWiki2 = logInPage.submitLogin();
		createNewWiki2.describeYourTopic("Duis quam ante, fringilla at cursus tristique, laoreet vel elit. Nullam rhoncus, magna ut dictum ultrices, mauris lectus consectetur tellus, sed dignissim elit justo vel ante.");
		createNewWiki2.selectCategory("Auto");
		CreateNewWikiPageObjectStep3 createNewWiki3 = createNewWiki2.submit();
		createNewWiki3.selectTheme(3);
		NewWikiaHomePage newWikia = createNewWiki3.submit(wikiName);
		newWikia.VerifyCongratulationsLightBox();
		newWikia.closeCongratulationsLightBox();
		newWikia.verifyUserLoggedIn(Properties.userName);
		newWikia.verifyUserToolBar();
		CommonFunctions.logOut(Properties.userName, driver);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		SpecialFactoryPageObject factory = new SpecialFactoryPageObject(driver);
		factory.openWikiFactoryPage();
		factory.deleteWiki(wikiName);
		CommonFunctions.logOut(Properties.userNameStaff, driver);
	}
	
	/*
	 * Test Case 3.1.02 Create new wiki: log in field validation (Latin characters)
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_CNW#Test_Case_3.1.02_Create_new_wiki:_log_in_field_validation_.28Latin_characters.29
	 * Password field Validation: password is incorrect
	 * */
	@Test(groups = {"CreateNewWiki_latin_005","CNW"})
	public void CreateNewWiki_latin_TC005_password_is_incorrect()
	{
		HomePageObject home = new HomePageObject(driver);
		home.openHomePage();
		CreateNewWikiPageObjectStep1 createNewWiki1 = home.startAWiki();
		String timeStamp = createNewWiki1.getTimeStamp();
		wikiName = "QaTest"+timeStamp;
		createNewWiki1.typeInWikiName(wikiName);
		createNewWiki1.waitForSuccessIcon();
		CreateNewWikiLogInPageObject logInPage = createNewWiki1.submitToLogIn();
		logInPage.typeInUserName(Properties.userName);
		logInPage.typeInPassword("Invalid password");
		logInPage.submitLogin();
		logInPage.verifyInvalidPasswordValidation();
		logInPage.typeInUserName(Properties.userName);
		logInPage.typeInPassword(Properties.password);
		CreateNewWikiPageObjectStep2 createNewWiki2 = logInPage.submitLogin();
		createNewWiki2.describeYourTopic("Duis quam ante, fringilla at cursus tristique, laoreet vel elit. Nullam rhoncus, magna ut dictum ultrices, mauris lectus consectetur tellus, sed dignissim elit justo vel ante.");
		createNewWiki2.selectCategory("Auto");
		CreateNewWikiPageObjectStep3 createNewWiki3 = createNewWiki2.submit();
		createNewWiki3.selectTheme(3);
		NewWikiaHomePage newWikia = createNewWiki3.submit(wikiName);
		newWikia.VerifyCongratulationsLightBox();
		newWikia.closeCongratulationsLightBox();
		newWikia.verifyUserLoggedIn(Properties.userName);
		newWikia.verifyUserToolBar();
		CommonFunctions.logOut(Properties.userName, driver);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		SpecialFactoryPageObject factory = new SpecialFactoryPageObject(driver);
		factory.openWikiFactoryPage();
		factory.deleteWiki(wikiName);
		CommonFunctions.logOut(Properties.userNameStaff, driver);
	}
	
	/*
	 * Test Case 3.1.02 Create new wiki: log in field validation (Latin characters)
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_CNW#Test_Case_3.1.02_Create_new_wiki:_log_in_field_validation_.28Latin_characters.29
	 * Password field Validation: username and password are correct
	 * */
	@Test(groups = {"CreateNewWiki_latin_006","CNW"})
	public void CreateNewWiki_latin_TC006_user_name_and_password_are_correct()
	{
		HomePageObject home = new HomePageObject(driver);
		home.openHomePage();
		CreateNewWikiPageObjectStep1 createNewWiki1 = home.startAWiki();
		String timeStamp = createNewWiki1.getTimeStamp();
		wikiName = "QaTest"+timeStamp;
		createNewWiki1.typeInWikiName(wikiName);
		createNewWiki1.waitForSuccessIcon();
		CreateNewWikiLogInPageObject logInPage = createNewWiki1.submitToLogIn();
		logInPage.typeInUserName(Properties.userName);
		logInPage.typeInPassword(Properties.password);
		CreateNewWikiPageObjectStep2 createNewWiki2 = logInPage.submitLogin();
		createNewWiki2.describeYourTopic("Duis quam ante, fringilla at cursus tristique, laoreet vel elit. Nullam rhoncus, magna ut dictum ultrices, mauris lectus consectetur tellus, sed dignissim elit justo vel ante.");
		createNewWiki2.selectCategory("Auto");
		CreateNewWikiPageObjectStep3 createNewWiki3 = createNewWiki2.submit();
		createNewWiki3.selectTheme(3);
		NewWikiaHomePage newWikia = createNewWiki3.submit(wikiName);
		newWikia.VerifyCongratulationsLightBox();
		newWikia.closeCongratulationsLightBox();
		newWikia.verifyUserLoggedIn(Properties.userName);
		newWikia.verifyUserToolBar();
		CommonFunctions.logOut(Properties.userName, driver);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		SpecialFactoryPageObject factory = new SpecialFactoryPageObject(driver);
		factory.openWikiFactoryPage();
		factory.deleteWiki(wikiName);
		CommonFunctions.logOut(Properties.userNameStaff, driver);
	}	
	
	
	
}
