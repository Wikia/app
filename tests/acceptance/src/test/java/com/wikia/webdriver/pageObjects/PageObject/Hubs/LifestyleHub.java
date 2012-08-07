package com.wikia.webdriver.pageObjects.PageObject.Hubs;

import java.util.List;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.pageObjects.PageObject.HubBasePageObject;

public class LifestyleHub extends HubBasePageObject {


	
	
	public LifestyleHub(WebDriver driver) {
		super(driver);
		PageFactory.initElements(driver, this);
	}


	

}
