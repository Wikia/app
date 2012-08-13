package com.wikia.webdriver.TestCases.CreateAWikiTests;

import org.testng.annotations.DataProvider;
import org.testng.annotations.Test;

import com.wikia.webdriver.Templates.TestTemplate;
import com.wikia.webdriver.pageObjects.PageObject.BasePageObject;
import com.wikia.webdriver.pageObjects.PageObject.HomePageObject;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiLogInPageObject;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep1;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep2;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep3;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.NewWikiaHomePage;

public class CreateAWikiTests_logInFieldValidation extends TestTemplate{
	
	private String wikiName;
	
	@DataProvider
	private static final Object[][] getUserName()
	{
		return new Object[][]
				{
					{BasePageObject.userNameWithUnderScore},
					{BasePageObject.userNameWithBackwardSlash},
					{BasePageObject.userNameLong}
				};
	}
			
	@Test(dataProvider="getUserName")
	public void CreateNewWiki_LogInFieldValidation(String userName)
	{
		driver.get("http://community.wikia.com/wiki/Special:UserLogout?returnto=User "+userName);
		HomePageObject home = new HomePageObject(driver);
		home.openHomePage();
		CreateNewWikiPageObjectStep1 createNewWiki1 = home.StartAWikia();
		String timeStamp = createNewWiki1.getTimeStamp();
		wikiName = "QaTest"+timeStamp;
		createNewWiki1.typeInWikiName(wikiName);
		createNewWiki1.waitForSuccessIcon();
		CreateNewWikiLogInPageObject logInPage = createNewWiki1.submitToLogIn();
		logInPage.typeInUserName(userName);
		logInPage.typeInPassword(BasePageObject.password);
		CreateNewWikiPageObjectStep2 createNewWiki2 = logInPage.submitLogin();
		createNewWiki2.describeYourTopic("Duis quam ante, fringilla at cursus tristique, laoreet vel elit. Nullam rhoncus, magna ut dictum ultrices, mauris lectus consectetur tellus, sed dignissim elit justo vel ante.");
		createNewWiki2.selectCategory("Auto");
		CreateNewWikiPageObjectStep3 createNewWiki3 = createNewWiki2.submit();
		createNewWiki3.selectTheme(3);
		NewWikiaHomePage newWikia = createNewWiki3.submit();
		newWikia.VerifyCongratulationsLightBox();
		newWikia.closeCongratulationsLightBox();
		newWikia.vefifyUserLoggedIn(userName);
		newWikia.verifyUserToolBar();
		driver.get("http://community.wikia.com/wiki/Special:UserLogout?returnto=User "+userName);
	}
	
	

}
