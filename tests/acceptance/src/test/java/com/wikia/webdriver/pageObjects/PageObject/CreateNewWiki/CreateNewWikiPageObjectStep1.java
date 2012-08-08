package com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.Logging.PageObjectLogging;
import com.wikia.webdriver.pageObjects.PageObject.BasePageObject;

public class CreateNewWikiPageObjectStep1 extends BasePageObject{

	@FindBy(name="wiki-name") 
	private WebElement wikiName;
	@FindBy(name="wiki-domain") 
	private WebElement wikiDomain;
	@FindBy(className="next") 
	private WebElement submitButton;
	
	
	
	
	public CreateNewWikiPageObjectStep1(WebDriver driver) {
		super(driver);
		PageFactory.initElements(driver, this);
		// TODO Auto-generated constructor stub
	}
	
	public void typeInWikiName(String name)
	{
		wikiName.sendKeys(name);
		PageObjectLogging.log("typeInWikiName ", "Typed wiki name" +name, true);
	}
	
	public void typeInWikiDomain(String domain)
	{
		wikiDomain.clear();
		wikiDomain.sendKeys(domain);
		PageObjectLogging.log("typeInWikiDomain ", "Typed wiki domain" +domain, true);
	}
	
	public void waitForSuccessIcon()
	{

		waitForElementByXPath("//span[@class='domain-status-icon status-icon']/img[@src='http://slot2.images.wikia.nocookie.net/__cb57524/common/extensions/wikia/CreateNewWiki/images/check.png']");
		PageObjectLogging.log("waitForSuccessIcon", "Success icon found", true);																							
	}
	
	public CreateNewWikiPageObjectStep2 submit()
	{
		submitButton.click();
		PageObjectLogging.log("submit", "Submit button clicked", true);		
		return new CreateNewWikiPageObjectStep2(driver);
	}


	
	
	
}
