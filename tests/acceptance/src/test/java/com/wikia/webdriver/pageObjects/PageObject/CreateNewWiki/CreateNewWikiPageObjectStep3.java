package com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki;

import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.Logging.PageObjectLogging;
import com.wikia.webdriver.pageObjects.PageObject.BasePageObject;

public class CreateNewWikiPageObjectStep3 extends BasePageObject{

	@FindBy(css="li[data-theme]")
	private WebElement themeList;
	@FindBy(css="li[id='ThemeWiki'] input[class='next']") 
	private WebElement submitButton;

	
	public CreateNewWikiPageObjectStep3(WebDriver driver) {
		super(driver);
		PageFactory.initElements(driver, this);
		// TODO Auto-generated constructor stub
	}
	
	
	
	public void selectTheme(int skinNumber)
	{
		waitForElementByCss("li[data-theme]");
		List<WebElement> lista = driver.findElements(By.cssSelector("li[data-theme]"));
		PageObjectLogging.log("selectTheme", "skin number: " + skinNumber + " selected", true, driver);
		Actions builder = new Actions(driver);
		WebElement e = lista.get(skinNumber);
		builder.click(e);
//		builder.moveToElement(logInAjax).build().perform();
//		lista.get(skinNumber).click();
	}
	
	public NewWikiaHomePage submit(String wikiName)
	{
		submitButton.click();
		PageObjectLogging.log("submit", "Submit button clicked", true, driver);
		return new NewWikiaHomePage(driver, wikiName);
	}

}
