package com.wikia.webdriver.pageObjects.PageObject;

import org.openqa.selenium.WebDriver;

public class SpecialFactoryPageObject extends BasePageObject
{

	public SpecialFactoryPageObject(WebDriver driver) {
		super(driver);
		driver.get(wikiFactoryLiveDomain);
		// TODO Auto-generated constructor stub
	}

	

}
