package com.wikia.webdriver.PageObjects.PageObject;

import org.openqa.selenium.By;
import org.openqa.selenium.TimeoutException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.PageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep1;
import com.wikia.webdriver.PageObjects.PageObject.Hubs.EntertainmentHubPageObject;
import com.wikia.webdriver.PageObjects.PageObject.Hubs.LifestyleHubPageObject;
import com.wikia.webdriver.PageObjects.PageObject.Hubs.VideoGamesHubPageObject;

public class HomePageObject extends BasePageObject{

	@FindBy(css="header.wikiahomepage-header a.button") 
	private WebElement startWikiButton;
	@FindBy(css="section.grid-2.videogames a img") 
	private WebElement OpenVideoGamesHub;
	@FindBy(css="section.grid-2.entertainment a img") 
	private WebElement OpenEntertainmentHub;
	@FindBy(css="section.grid-2.lifestyle a img") 
	private WebElement OpenLifestyleHub;
	@FindBy(css="a.ajaxLogin")
	private WebElement LoginOverlay;
	@FindBy(css="div#UserLoginDropdown input[name='username']")
	private WebElement UserNameField;
	@FindBy(css="div#UserLoginDropdown a.forgot-password")
	private WebElement ForgotYourPassword;
	@FindBy(css=".wikia-mosaic-slider-panorama")
	private WebElement hubsHeroCarousel;
	
	public HomePageObject(WebDriver driver) 
	{
		super(driver);
		PageFactory.initElements(driver, this);
	}
	
	public void openHomePage()
	{
		try{
			driver.get(Global.LIVE_DOMAIN);			
		}
		catch (TimeoutException e)
		{
			PageObjectLogging.log("openHomePage", "timeouted when opening homepage", true);
		}
		try{
			driver.getCurrentUrl();			
		}
		catch (TimeoutException e)
		{
			PageObjectLogging.log("openHomePage", "timeouted when opening homepage", true);
		}
	}
	
	public void triggerLoginOverlay()
	{
		clickAndWait(LoginOverlay);
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("input[name='username']")));
	}
	
	public void typeInUserName(String userName)
	{	
		waitForElementByElement(UserNameField);
		UserNameField.sendKeys(userName);
	}
	
	public void forgotYourPasswordClick()
	{
		waitForElementByElement(ForgotYourPassword);
		clickAndWait(ForgotYourPassword);
		waitForElementByCss("div#UserLoginDropdown div.error-msg");
	}
	
	public CreateNewWikiPageObjectStep1 startAWiki()
	{
		clickAndWait(startWikiButton);
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("form[name='label-wiki-form']")));
		if (Global.LIVE_DOMAIN.contains("preview"))
		{
			String currentUrl = driver.getCurrentUrl();
			String desiredUrl = currentUrl.replace("www.wikia.com", "preview.www.wikia.com");
			driver.get(desiredUrl);
		}
		verifyURL(Global.LIVE_DOMAIN+"Special:CreateNewWiki?uselang=en");
		return new CreateNewWikiPageObjectStep1(driver);
	}
	
	public HubBasePageObject OpenHub(String Hub){
		PageObjectLogging.log("OpenHub", "Opening "+Hub, true, driver);
		if (Hub.equals("VideoGamesHub")) {
			clickAndWait(OpenVideoGamesHub);
			waitForElementByElement(hubsHeroCarousel);
			if (Global.LIVE_DOMAIN.contains("preview"))
			{
				String currentUrl = driver.getCurrentUrl();
				String temp = currentUrl.replace("http://www.wikia.com", "http://preview.www.wikia.com");
				driver.get(temp);
				waitForElementByElement(hubsHeroCarousel);
			}
			return new VideoGamesHubPageObject(driver);
		}
		if (Hub.equals("EntertainmentHub")) {
			clickAndWait(OpenEntertainmentHub);
			waitForElementByElement(hubsHeroCarousel);
			if (Global.LIVE_DOMAIN.contains("preview"))
			{
				String currentUrl = driver.getCurrentUrl();
				String temp = currentUrl.replace("http://www.wikia.com", "http://preview.www.wikia.com");
				driver.get(temp);
				waitForElementByElement(hubsHeroCarousel);
			}
			return new EntertainmentHubPageObject(driver);	
		}
		if (Hub.equals("LifestyleHub")) {
			clickAndWait(OpenLifestyleHub);
			waitForElementByElement(hubsHeroCarousel);
			if (Global.LIVE_DOMAIN.contains("preview"))
			{
				String currentUrl = driver.getCurrentUrl();
				String temp = currentUrl.replace("http://www.wikia.com", "http://preview.www.wikia.com");
				driver.get(temp);
				waitForElementByElement(hubsHeroCarousel);
			}
			return new LifestyleHubPageObject(driver);	
		}
		else {
			PageObjectLogging.log("OpenHub", "Incorrect parameter. Hub name: '"+Hub+"' is wrong and won't open any hub", false, driver);
			return null;
		}
	}


}
