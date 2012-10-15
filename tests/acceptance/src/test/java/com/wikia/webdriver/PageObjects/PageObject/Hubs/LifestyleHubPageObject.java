package com.wikia.webdriver.PageObjects.PageObject.Hubs;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.PageObjects.PageObject.HubBasePageObject;

public class LifestyleHubPageObject extends HubBasePageObject {


	
	
	public LifestyleHubPageObject(WebDriver driver) {
		super(driver);
		PageFactory.initElements(driver, this);
	}


	

}
