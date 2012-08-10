package com.wikia.webdriver.pageObjects.PageObject;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep1;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.EntertainmentHubPageObject;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.LifestyleHubPageObject;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.VideoGamesHubPageObject;

public class HomePageObject extends BasePageObject{

	@FindBy(className="create-wiki") 
	private WebElement startWikiButton;
	@FindBy(css="section.grid-2.videogames a img") 
	private WebElement OpenVideoGamesHub;
	@FindBy(css="section.grid-2.entertainment a img") 
	private WebElement OpenEntertainmentHub;
	@FindBy(css="section.grid-2.lifestyle a img") 
	private WebElement OpenLifestyleHub;

	
	public HomePageObject(WebDriver driver) 
	{
		super(driver);
		PageFactory.initElements(driver, this);
	}
	
	public void openHomePage()
	{
		driver.get(liveDomain);
	}
	
	public CreateNewWikiPageObjectStep1 StartAWikia()
	{
		click(startWikiButton);
		verifyURL("http://www.wikia.com/Special:CreateNewWiki?uselang=en");
		return new CreateNewWikiPageObjectStep1(driver);
	}
	
	public VideoGamesHubPageObject OpenVideoGamesHub() {
		
		click(OpenVideoGamesHub);
		return new VideoGamesHubPageObject(driver);		
	}
	public EntertainmentHubPageObject OpenEntertainmentHub() {
		
		click(OpenEntertainmentHub);
		return new EntertainmentHubPageObject(driver);		
	}
	public LifestyleHubPageObject OpenLifestyleHub() {
		
		click(OpenLifestyleHub);
		return new LifestyleHubPageObject(driver);		
	}

}
