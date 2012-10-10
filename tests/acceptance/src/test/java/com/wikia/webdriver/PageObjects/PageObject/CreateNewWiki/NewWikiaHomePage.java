package com.wikia.webdriver.PageObjects.PageObject.CreateNewWiki;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.PageObjects.PageObject.WikiBasePageObject;


/**
 * 
 * @author Karol
 *
 */
public class NewWikiaHomePage extends WikiBasePageObject{

	@FindBy(css="button[class='close wikia-chiclet-button']")
	WebElement congratulationLightBoxCloseButton;
	
	public NewWikiaHomePage(WebDriver driver, String wikiname) 
	{
		super(driver, wikiname);
		PageFactory.initElements(driver, this);	
	}
	
	public void VerifyCongratulationsLightBox()
	{
		
	}
	
	public void waitForCongratulationsLightBox(String wikiaName)
	{
		waitForElementByCss("section#WikiWelcomeWrapper");
		waitForElementByCss("div#WikiWelcome");
		waitForElementByCss("div.WikiWelcome");		
		PageObjectLogging.log("waitForCongratulationsLightBox ", "Congratulations lightbox verified", true, driver);
	}
	
	public void closeCongratulationsLightBox()
	{
		waitForElementByElement(congratulationLightBoxCloseButton);
		congratulationLightBoxCloseButton.click();
		PageObjectLogging.log("closeCongratulationsLightBox ", "Congratulations lightbox closed", true, driver);
	}
	
	public void verifyUserLoggedIn(String userName)
	{
		waitForElementByCss("header#WikiaHeader a[href*=':"+userName+"']");
		PageObjectLogging.log("vefifyUserLoggedIn ", "Verified that user: "+userName+" is logged in", true);
	}

	
	
	


}
