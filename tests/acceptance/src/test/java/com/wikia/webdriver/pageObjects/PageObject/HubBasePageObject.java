package com.wikia.webdriver.pageObjects.PageObject;

import java.util.List;

import javax.swing.text.html.CSS;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;


import com.wikia.webdriver.pageObjects.PageObject.Hubs.VideoGamesHub;

public class HubBasePageObject extends BasePageObject{

	@FindBy(css="div.button.scrollleft p") 
	private WebElement RelatedVideosScrollLeft;
	@FindBy(css="div.button.scrollright p") 
	private WebElement RelatedVideosScrollRight;
		
	public HubBasePageObject(WebDriver driver) {
		super(driver);
		PageFactory.initElements(driver, this);
	}

	public void ClickOnNewsTab(int TabNumber) {
		List<WebElement> newstabs = driver.findElements(By.cssSelector("section.wikiahubs-newstabs ul.tabbernav li a"));
		waitForElementClickableByCss("section.wikiahubs-newstabs ul.tabbernav li a");
		click(newstabs.get(TabNumber - 1));

	}
	public void RelatedVideosScrollLeft() {
		click(RelatedVideosScrollLeft);
	}
	
	public void RelatedVideosScrollRight() {
		click(RelatedVideosScrollRight);
	}
	public HomePageObject BackToHomePage() {
		return new HomePageObject(driver);
	}

}
