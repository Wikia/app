package com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.pageObjects.PageObject.BasePageObject;

/**
 * 
 * @author Karol Kujawiak
 *
 */

public class CreateNewWikiPageObjectStep1 extends BasePageObject{

	@FindBy(name="wiki-name") 
	private WebElement wikiName;
	@FindBy(name="wiki-domain") 
	private WebElement wikiDomain;
	@FindBy(css="span.domain-status-icon img[src*='check.png']")
	private WebElement successIcon;
	@FindBy(className="next") 
	private WebElement submitButton;
	
	
	

	public CreateNewWikiPageObjectStep1(WebDriver driver) {
		super(driver);
		PageFactory.initElements(driver, this);
		// TODO Auto-generated constructor stub
	}
	
	/**
	 * 
	 * @param name
	 * @author Karol Kujawiak
	 */
	public void typeInWikiName(String name)
	{
		wikiName.sendKeys(name);
		PageObjectLogging.log("typeInWikiName ", "Typed wiki name" +name, true, driver);
	}
	
	
	/**
	 * 
	 * @param domain
	 * @author Karol Kujawiak
	 */
	public void typeInWikiDomain(String domain)
	{
		wikiDomain.clear();
		wikiDomain.sendKeys(domain);
		PageObjectLogging.log("typeInWikiDomain ", "Typed wiki domain" +domain, true, driver);
	}
	
	/**
	 * @author Karol Kujawiak
	 */
	public void waitForSuccessIcon()
	{
		waitForElementByElement(successIcon);																				 
		PageObjectLogging.log("waitForSuccessIcon", "Success icon found", true, driver);																							
	}
	
	public CreateNewWikiPageObjectStep1 openCreateNewWikiPage()
	{
		driver.get("http://www.wikia.com/Special:CreateNewWiki?uselang=en");
		return new CreateNewWikiPageObjectStep1(driver);
	}
	
	public void verifyOccupiedWikiAddress(String wikiName)
	{
		wikiName = wikiName.toLowerCase();
		waitForElementByCss("div.wiki-domain-error a[href='http://"+wikiName+".wikia.com']");
		PageObjectLogging.log("verifyOccupiedWikiAddress", "Verified occupied wiki address", true, driver);
	}
	
	public CreateNewWikiPageObjectStep2 submit()
	{
		submitButton.click();
		PageObjectLogging.log("submit", "Submit button clicked", true, driver);
		return new CreateNewWikiPageObjectStep2(driver);
	}
	
	public CreateNewWikiLogInPageObject submitToLogIn()
	{
		submitButton.click();
		PageObjectLogging.log("submit", "Submit button clicked", true, driver);
		return new CreateNewWikiLogInPageObject(driver);
	}


	
	
	
}
