package com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.pageObjects.PageObject.BasePageObject;

public class NewWikiaHomePage extends BasePageObject{

	public NewWikiaHomePage(WebDriver driver) 
	{
		super(driver);
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
	}
	
	


}
