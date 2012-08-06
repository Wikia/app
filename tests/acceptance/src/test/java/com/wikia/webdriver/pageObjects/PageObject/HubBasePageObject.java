package com.wikia.webdriver.pageObjects.PageObject;

import java.util.List;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;

import com.wikia.webdriver.pageObjects.PageObject.Hubs.VideoGamesHub;

public class HubBasePageObject extends BasePageObject{
	
	@FindBy(css="section.wikiahubs-newstabs ul.tabbernav li a") 
	public List<WebElement> newstabs;
		
	public HubBasePageObject(WebDriver driver) {
		super(driver);
		// TODO Auto-generated constructor stub
	}

	public void ClickOnNewsTab(int TabNumber) {

		click(newstabs.get(TabNumber + 1));

	}

	

}
