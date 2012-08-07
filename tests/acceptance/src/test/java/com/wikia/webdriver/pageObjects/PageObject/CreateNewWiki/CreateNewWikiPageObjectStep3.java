package com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki;

import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.pageObjects.PageObject.BasePageObject;

public class CreateNewWikiPageObjectStep3 extends BasePageObject{

	@FindBy(css="li[data-theme]")
	private WebElement themeList;
	@FindBy(css="form[name='desc-form'] input[class='next']") 
	private WebElement submitButton;

	
	public CreateNewWikiPageObjectStep3(WebDriver driver) {
		super(driver);
		PageFactory.initElements(driver, this);
		// TODO Auto-generated constructor stub
	}
	
	
	
	public void selectTheme(int skinNumber)
	{
		List<WebElement> lista = driver.findElements(By.cssSelector("li[data-theme]"));
		lista.get(skinNumber).click();
	}
	
	public CreateNewWikiPageObjectStep4 submit()
	{
		submitButton.click();
		return new CreateNewWikiPageObjectStep4(driver);
	}

}
