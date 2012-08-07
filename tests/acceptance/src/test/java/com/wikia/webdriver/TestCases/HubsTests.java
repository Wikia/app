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
		
		
		VideoGamesHub VGHub = home.OpenVideoGamesHub();
		
		
		VGHub.ClickOnNewsTab(2);
		VGHub.ClickOnNewsTab(3);
		VGHub.ClickOnNewsTab(1);
		VGHub.RelatedVideosScrollRight();
		VGHub.RelatedVideosScrollLeft();
		VGHub.verifyTitle("http://www.wikia.com/Video_Games");
		
		home = VGHub.BackToHomePage();
		
		
		LifestyleHub LHub = home.OpenLifestyleHub();
		
		
		LHub.ClickOnNewsTab(2);
		LHub.ClickOnNewsTab(3);
		LHub.ClickOnNewsTab(1);
		LHub.RelatedVideosScrollRight();
		LHub.RelatedVideosScrollLeft();
		LHub.verifyTitle("http://www.wikia.com/Lifestyle");
		
		home = LHub.BackToHomePage();
		
		
		EntertainmentHub EHub = home.OpenEntertainmentHub();
		
		
		EHub.ClickOnNewsTab(2);
		EHub.ClickOnNewsTab(3);
		EHub.ClickOnNewsTab(1);
		EHub.RelatedVideosScrollRight();
		EHub.RelatedVideosScrollLeft();
		EHub.verifyTitle("http://www.wikia.com/Entertainment");
		driver.close();
	}
}
