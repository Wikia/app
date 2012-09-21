package com.wikia.webdriver.PageObjects.PageObject;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.support.PageFactory;

public class PageObjectTemplate extends BasePageObject{

	public PageObjectTemplate(WebDriver driver) 
	{
		super(driver);
		PageFactory.initElements(driver, this);
	}
	

}
