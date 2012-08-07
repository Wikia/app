package com.wikia.webdriver.TestCases;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.support.PageFactory;
import org.testng.annotations.Test;

import com.wikia.webdriver.DriverProvider.DriverProvider;
import com.wikia.webdriver.Logging.PageObjectLogging;
import com.wikia.webdriver.pageObjects.PageObject.HomePageObject;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep1;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep2;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep3;

public class CreateAWiki{
	
	@Test
	public void CreateNewWiki()
	{
		
		PageObjectLogging.startLogging(getClass().getName().toString());
		
		WebDriver driver = DriverProvider.getInstance().getWebDriver();
		
		HomePageObject home = new HomePageObject(driver);
		PageFactory.initElements(driver, home);
		
		home.logIn("KarolK1", "123");
		CreateNewWikiPageObjectStep1 createNewWikistep1 = home.StartAWikia();
		PageFactory.initElements(driver, createNewWikistep1);
		String timeStamp = createNewWikistep1.getTimeStamp();
		
		createNewWikistep1.submit();
		//create new wiki step 1
		createNewWikistep1.waitForElementNotVisibleByCss("span.submit-error.error-msg");
		createNewWikistep1.typeInWikiName("qaTest"+timeStamp);
		createNewWikistep1.typeInWikiDomain("qaTest"+timeStamp);
		createNewWikistep1.waitForSuccessIcon();
		createNewWikistep1.waitForElementNotVisibleByCss("span.submit-error.error-msg");
		//create new wiki step 2
		CreateNewWikiPageObjectStep2 createNewWikistep2 = createNewWikistep1.submit();
		PageFactory.initElements(driver, createNewWikistep2);
		createNewWikistep2.describeYourTopic("Duis quam ante, fringilla at cursus tristique, laoreet vel elit. Nullam rhoncus, magna ut dictum ultrices, mauris lectus consectetur tellus, sed dignissim elit justo vel ante.");
		createNewWikistep2.selectCategory("Auto");
		CreateNewWikiPageObjectStep3 createNewWikiStep3 = createNewWikistep2.submit();
		
		
		driver.close();
	}

}
