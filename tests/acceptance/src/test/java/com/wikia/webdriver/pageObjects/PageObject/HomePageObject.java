package com.wikia.webdriver.pageObjects.PageObject;

import org.junit.internal.runners.statements.Fail;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep1;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.EntertainmentHubPageObject;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.LifestyleHubPageObject;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.VideoGamesHubPageObject;
import static org.testng.AssertJUnit.fail;

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
		driver.getCurrentUrl();
	}
	
	public CreateNewWikiPageObjectStep1 StartAWikia()
	{
		startWikiButton.click();
		verifyURL("http://www.wikia.com/Special:CreateNewWiki?uselang=en");
		return new CreateNewWikiPageObjectStep1(driver);
	}
	
	public HubBasePageObject OpenHub(String Hub){
		if (Hub.equals("VideoGamesHub")) {
			OpenVideoGamesHub.click();
			return new VideoGamesHubPageObject(driver);
		}
		if (Hub.equals("EntertainmentHub")) {
			OpenEntertainmentHub.click();
			return new EntertainmentHubPageObject(driver);	
		}
		if (Hub.equals("LifestyleHub")) {
			OpenLifestyleHub.click();
			return new LifestyleHubPageObject(driver);	
		}
		else {
			fail("Incorrect parameter. Hub name: '"+Hub+"' is wrong and won't open any hub");
			return null;
		}
	}


}
