package com.wikia.webdriver.pageObjects.PageObject;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;

import com.wikia.webdriver.pageObjects.PageObject.Hubs.VideoGamesHub;

public class HomePageObject extends BasePageObject{

	@FindBy(className="create-wiki") 
	public WebElement startWikiButton;
	@FindBy(css="section.grid-2.videogames a img") 
	public WebElement OpenVideoGamesHub;
	
	
	public HomePageObject(WebDriver driver) 
	{
		super(driver);
		driver.get(liveDomain);
	}
	
	public CreateNewWikiPageObject StartAWikia()
	{
		click(startWikiButton);
		return new CreateNewWikiPageObject(driver);
	}
	
	public VideoGamesHub OpenVideoGamesHub() {
	
		
		return new VideoGamesHub(driver);		
	}

}
