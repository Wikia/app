package com.wikia.webdriver.TestCases;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.support.PageFactory;
import org.testng.annotations.Test;

import com.wikia.webdriver.DriverProvider.DriverProvider;

import com.wikia.webdriver.pageObjects.PageObject.HomePageObject;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWikiPageObject;

public class CreateAWiki{
	
	@Test
	public void CreateNewWiki()
	{
		WebDriver driver = DriverProvider.getInstance().getWebDriver();
		
		HomePageObject home = new HomePageObject(driver);
		PageFactory.initElements(driver, home);
		
		CreateNewWikiPageObject createNewWiki = home.StartAWikia();
		PageFactory.initElements(driver, createNewWiki);
		String timeStamp = createNewWiki.getTimeStamp();
		
		createNewWiki.typeInWikiName("qaTest"+timeStamp);
		createNewWiki.typeInWikiDomain("qaTest"+timeStamp);
		createNewWiki.waitForSuccessIcon();
		createNewWiki.submit();
		
		driver.close();
	}

}
