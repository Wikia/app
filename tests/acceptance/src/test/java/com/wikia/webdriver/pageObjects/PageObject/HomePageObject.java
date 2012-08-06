package com.wikia.webdriver.pageObjects.PageObject;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;

public class HomePageObject extends BasePageObject{

	@FindBy(className="create-wiki") 
	public WebElement startWikiButton;
	
	public HomePageObject(WebDriver driver) 
	{
		super(driver);
		driver.get(liveDomain);
	}
	
	public CreateNewWikiPageObject StartAWikia()
	{
		click(startWikiButton);
		return new CreateNewWikiPageObject(driver);
	}

}
