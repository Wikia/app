package com.wikia.webdriver.TestCases;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.support.PageFactory;
import org.testng.annotations.Test;

import com.wikia.webdriver.DriverProvider.DriverProvider;
import com.wikia.webdriver.pageObjects.PageObject.HomePageObject;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.EntertainmentHub;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.LifestyleHub;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.VideoGamesHub;

public class HubsTests {

	@Test
	public void VideoGamesHubTest()
	{
		WebDriver driver = DriverProvider.getInstance().getWebDriver();
		
		HomePageObject home = new HomePageObject(driver);
		PageFactory.initElements(driver, home);
		
		VideoGamesHub VGHub = home.OpenVideoGamesHub();
		PageFactory.initElements(driver, VGHub);
		
		VGHub.ClickOnNewsTab(2);
		VGHub.ClickOnNewsTab(3);
		VGHub.ClickOnNewsTab(1);
		VGHub.RelatedVideosScrollRight();
		VGHub.RelatedVideosScrollLeft();
		
		home = VGHub.BackToHomePage();
		PageFactory.initElements(driver, home);
		
		LifestyleHub LHub = home.OpenLifestyleHub();
		PageFactory.initElements(driver, LHub);
		
		LHub.ClickOnNewsTab(2);
		LHub.ClickOnNewsTab(3);
		LHub.ClickOnNewsTab(1);
		LHub.RelatedVideosScrollRight();
		LHub.RelatedVideosScrollLeft();
		
		home = LHub.BackToHomePage();
		PageFactory.initElements(driver, home);
		
		EntertainmentHub EHub = home.OpenEntertainmentHub();
		PageFactory.initElements(driver, EHub);
		
		EHub.ClickOnNewsTab(2);
		EHub.ClickOnNewsTab(3);
		EHub.ClickOnNewsTab(1);
		EHub.RelatedVideosScrollRight();
		EHub.RelatedVideosScrollLeft();
		driver.close();
	}
}
