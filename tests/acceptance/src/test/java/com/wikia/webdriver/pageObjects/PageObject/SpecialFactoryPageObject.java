package com.wikia.webdriver.pageObjects.PageObject;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.Logging.PageObjectLogging;

public class SpecialFactoryPageObject extends BasePageObject
{
	@FindBy(id="citydomain")
	private WebElement domainField;
	@FindBy(css="form[id='WikiFactoryDomainSelector'] button")
	private WebElement getConfigButton;
	@FindBy(css="ul#wiki-factory-tabs li:nth-child(8)")
	private WebElement closeWikiButton;
	@FindBy(css="form#wk-wf-variables-select ul:nth-child(1) li:nth-child(1) input")
	private WebElement dumpCheckBox;
	@FindBy(css="form#wk-wf-variables-select ul:nth-child(1) li:nth-child(2) input")
	private WebElement imageArchiveCheckBox;
	@FindBy(css="input[name='close_saveBtn']")
	private WebElement confirmCloseButton;
	@FindBy(css="a.free")
	private WebElement closedWikiaLink;
	
	public SpecialFactoryPageObject(WebDriver driver) {
		super(driver);
		driver.get(wikiFactoryLiveDomain);
		PageFactory.initElements(driver, this);
		// TODO Auto-generated constructor stub
	}
	
	
	
	public void typeInDomainName(String name)
	{
		domainField.sendKeys(name);		
		PageObjectLogging.log("typeInDomainName ", "Typed domain name " +name, true, driver);
	}
	
	public void getConfiguration()
	{
		getConfigButton.click();
		PageObjectLogging.log("getConfiguration ", "Get configuration button clicked", true, driver);
	}
	
	public void clickCloseWikiButton()
	{
		closeWikiButton.click();
		PageObjectLogging.log("clickCloseWikiButton ", "Close wiki button clicked", true, driver);
	}
	
	public void deselectCreateDumpCheckBox()
	{
		dumpCheckBox.click();
		PageObjectLogging.log("deselectCreateDumpCheckBox ", "Create dump checkbox deselected", true, driver);
	}
	
	public void deselectImageArchiveCheckBox()
	{
		imageArchiveCheckBox.click();
		PageObjectLogging.log("deselectImageArchiveCheckBox ", "Create image archive checkbox deselected", true, driver);
	}
	
	public void confirmClose()
	{
		confirmCloseButton.click();
		PageObjectLogging.log("confirmClose ", "Close confirmation button clicked", true, driver);
	}
	
	public void clickClosedWikiaLink()
	{
		closedWikiaLink.click();
		PageObjectLogging.log("clickClosedWikiaLink ", "Closed wikia link clicked", true, driver);
	}
	
	public void verifyWikiaClosed()
	{
		waitForElementById("close-title");
		waitForElementById("close-info");
		PageObjectLogging.log("verifyWikiaClosed ", "Closed wikia verified", true, driver);
	}
			
}
