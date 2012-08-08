package com.wikia.webdriver.TestCases;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.support.PageFactory;
import org.testng.annotations.Test;

import com.wikia.webdriver.DriverProvider.DriverProvider;
import com.wikia.webdriver.Logging.PageObjectLogging;
import com.wikia.webdriver.pageObjects.PageObject.BasePageObject;
import com.wikia.webdriver.pageObjects.PageObject.HomePageObject;
import com.wikia.webdriver.pageObjects.PageObject.SpecialFactoryPageObject;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep1;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep2;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep3;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.NewWikiaHomePage;

public class CreateAWiki{
	
	private String wikiName;
	
	@Test
	public void CreateNewWiki()
	{
		
		PageObjectLogging.startLogging(getClass().getName().toString());
		
		WebDriver driver = DriverProvider.getInstance().getWebDriver();
		
		HomePageObject home = new HomePageObject(driver);
//		PageFactory.initElements(driver, home);
		
		home.logIn();
		CreateNewWikiPageObjectStep1 createNewWikistep1 = home.StartAWikia();
		String timeStamp = createNewWikistep1.getTimeStamp();
		wikiName = "QaTest"+timeStamp;
		
		createNewWikistep1.submit();
		//create new wiki step 1
		createNewWikistep1.waitForElementNotVisibleByCss("span.submit-error.error-msg");
		createNewWikistep1.typeInWikiName(wikiName);
		createNewWikistep1.typeInWikiDomain(wikiName);
		createNewWikistep1.waitForSuccessIcon();
		createNewWikistep1.waitForElementNotVisibleByCss("span.submit-error.error-msg");
		//create new wiki step 2
		CreateNewWikiPageObjectStep2 createNewWikistep2 = createNewWikistep1.submit();
		createNewWikistep2.describeYourTopic("Duis quam ante, fringilla at cursus tristique, laoreet vel elit. Nullam rhoncus, magna ut dictum ultrices, mauris lectus consectetur tellus, sed dignissim elit justo vel ante.");
		createNewWikistep2.selectCategory("Auto");
		//create new wiki step 3
		CreateNewWikiPageObjectStep3 createNewWikiStep3 = createNewWikistep2.submit();
		createNewWikiStep3.selectTheme(3);
		NewWikiaHomePage newWikia = createNewWikiStep3.submit();
		newWikia.waitForCongratulationsLightBox(wikiName);
		driver.close();
	}
	
	@Test
	public void DeleteWiki()
	{
		
		PageObjectLogging.startLogging(getClass().getName().toString());
		
		WebDriver driver = DriverProvider.getInstance().getWebDriver();
		
		HomePageObject home = new HomePageObject(driver);
		
		
		home.logInAsStaff();
		SpecialFactoryPageObject factory = new SpecialFactoryPageObject(driver);
		factory.typeInDomainName(wikiName);
		factory.getConfiguration();
		factory.clickCloseWikiButton();
		factory.deselectCreateDumpCheckBox();
		factory.deselectImageArchiveCheckBox();
		factory.confirmClose();
		factory.confirmClose();
		factory.clickClosedWikiaLink();
		factory.verifyWikiaClosed();
		driver.close();
	}
	
	

}
