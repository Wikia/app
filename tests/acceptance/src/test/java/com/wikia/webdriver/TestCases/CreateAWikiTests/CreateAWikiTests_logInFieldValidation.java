package com.wikia.webdriver.TestCases.CreateAWikiTests;

import org.testng.annotations.DataProvider;
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

public class CreateAWikiTests_logInFieldValidation extends TestTemplate{
	
	/*
	 * Test Case 3.1.04 Create new wiki: log in field validation (Username with underscore)
	 * Test Case 3.1.05 Create new wiki: log in: field validation (Username with backward slash \)
	 * Test Case 3.1.07 Create new wiki: log in field validation (long Username)
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_CNW#Test_Case_3.1.01_Create_new_wiki_Have_an_account.3F_page:_Display  
	 * */
	
	private String wikiName;
	
	@DataProvider
	private static final Object[][] getUserName()
	{
		return new Object[][]
				{
					{Properties.userNameWithUnderScore, Properties.userNameWithUnderScore, Properties.passwordWithUnderScore},
					{Properties.userNameWithBackwardSlash, Properties.userNameWithBackwardSlashEncoded, Properties.passwordWithBackwardSlash},
					{Properties.userNameLong, Properties.userNameLong, Properties.passwordLong}
				};
	}
			
	@Test(dataProvider="getUserName",groups={"CreateNewWiki_LogInFieldValidation","CNW"})
	
	public void CreateNewWiki_LogInFieldValidation(String userName, String userNameEnc, String password)
	{
		CommonFunctions.logOut(userNameEnc, driver);
		HomePageObject home = new HomePageObject(driver);
		home.openHomePage();
		CreateNewWikiPageObjectStep1 createNewWiki1 = home.startAWiki();
		String timeStamp = createNewWiki1.getTimeStamp();
		wikiName = "QaTest"+timeStamp;
		createNewWiki1.typeInWikiName(wikiName);
		createNewWiki1.waitForSuccessIcon();
		CreateNewWikiLogInPageObject logInPage = createNewWiki1.submitToLogIn();
		logInPage.typeInUserName(userName);
		logInPage.typeInPassword(password);
		CreateNewWikiPageObjectStep2 createNewWiki2 = logInPage.submitLogin();
		createNewWiki2.describeYourTopic("Duis quam ante, fringilla at cursus tristique, laoreet vel elit. Nullam rhoncus, magna ut dictum ultrices, mauris lectus consectetur tellus, sed dignissim elit justo vel ante.");
		createNewWiki2.selectCategory("Auto");
		CreateNewWikiPageObjectStep3 createNewWiki3 = createNewWiki2.submit();
		createNewWiki3.selectTheme(3);
		NewWikiaHomePage newWikia = createNewWiki3.submit(wikiName);
		newWikia.VerifyCongratulationsLightBox();
		newWikia.closeCongratulationsLightBox();
		newWikia.verifyUserLoggedIn(userNameEnc);
		newWikia.verifyUserToolBar();
		CommonFunctions.logOut(userNameEnc, driver);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		SpecialFactoryPageObject factory = new SpecialFactoryPageObject(driver);
		factory.openWikiFactoryPage();
		factory.deleteWiki(wikiName);
		CommonFunctions.logOut(Properties.userNameStaff, driver);
	}
}
