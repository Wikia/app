package com.wikia.webdriver.PageObjects.PageObject.CreateNewWiki;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.Select;

import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.PageObjects.PageObject.BasePageObject;

/**
 * 
 * @author Karol
 *
 */

public class CreateNewWikiPageObjectStep2 extends BasePageObject{
	
	@FindBy(css="textarea#Description")
	private WebElement descriptionField;
	@FindBy(css="select[name='wiki-category']")
	private WebElement wikiCategory;
	@FindBy(css="form[name='desc-form'] input[class='next']") 
	private WebElement submitButton;

	public CreateNewWikiPageObjectStep2(WebDriver driver) {
		super(driver);
		PageFactory.initElements(driver, this);
		// TODO Auto-generated constructor stub
	}
	
	public void describeYourTopic(String description)
	{
		waitForElementByElement(descriptionField);
		descriptionField.sendKeys(description);
		PageObjectLogging.log("describeYourTopic", "describe your topic populated with: "+description, true, driver);
	}
	
	public void selectCategory(String category)
	{
		waitForElementByElement(wikiCategory);
		Select dropList = new Select(wikiCategory);
		dropList.selectByVisibleText(category);
		PageObjectLogging.log("selectCategory", "selected "+category+" category", true, driver);
	}
	
	public CreateNewWikiPageObjectStep3 submit()
	{
		waitForElementByElement(submitButton);
		submitButton.click();
		PageObjectLogging.log("submit", "Submit button clicked", true, driver);
		return new CreateNewWikiPageObjectStep3(driver);
	}

}
