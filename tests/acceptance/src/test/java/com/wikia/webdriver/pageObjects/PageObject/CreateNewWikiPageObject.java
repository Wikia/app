package com.wikia.webdriver.pageObjects.PageObject;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;

public class CreateNewWikiPageObject extends BasePageObject{

	@FindBy(name="wiki-name") 
	public WebElement wikiName;
	@FindBy(name="wiki-domain") 
	public WebElement wikiDomain;
	@FindBy(className="next") 
	public WebElement submitButton;
	
	
	
	
	public CreateNewWikiPageObject(WebDriver driver) {
		super(driver);
		// TODO Auto-generated constructor stub
	}
	
	public void typeInWikiName(String name)
	{
		wikiName.sendKeys(name);
		
	}
	
	public void typeInWikiDomain(String domain)
	{
		wikiDomain.clear();
		wikiDomain.sendKeys(domain);
		
	}
	
	public void waitForSuccessIcon()
	{
		watForElementByXPath("//span[@class='domain-status-icon status-icon']/img[@src]");
	}
	
	public void submit()
	{
		submitButton.click();
	}

}
