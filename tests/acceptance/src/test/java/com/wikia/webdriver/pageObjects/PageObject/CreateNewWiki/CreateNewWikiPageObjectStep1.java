package com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki;

import org.openqa.selenium.support.ui.Select;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;

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
		watForElementByXPath("//span[@class='domain-status-icon status-icon']/img[@src='http://slot2.images.wikia.nocookie.net/__cb57524/common/extensions/wikia/CreateNewWiki/images/check.png']");
																						
		
	}
	
	public CreateNewWikiPageObjectStep2 submit()
	{
		submitButton.click();
		return new CreateNewWikiPageObjectStep2(driver);
	}


	
	
	public void selectTheme()
	{
		
	}
}
