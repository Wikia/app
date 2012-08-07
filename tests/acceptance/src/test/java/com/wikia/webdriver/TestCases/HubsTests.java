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
		VGHub.verifyURL("http://www.wikia.com/Video_Games");
		
		VGHub.verifyWikiaMosaicSliderHasImages();
		VGHub.ClickOnNewsTab(2);
		VGHub.ClickOnNewsTab(3);
		VGHub.ClickOnNewsTab(1);
		VGHub.RelatedVideosScrollRight();
		VGHub.RelatedVideosScrollLeft();
				
		home = VGHub.BackToHomePage();
		
		
		LifestyleHub LHub = home.OpenLifestyleHub();
		LHub.verifyURL("http://www.wikia.com/Lifestyle");
		
		LHub.verifyWikiaMosaicSliderHasImages();
		LHub.ClickOnNewsTab(2);
		LHub.ClickOnNewsTab(3);
		LHub.ClickOnNewsTab(1);
		LHub.RelatedVideosScrollRight();
		LHub.RelatedVideosScrollLeft();
		
		
		home = LHub.BackToHomePage();
		
		EntertainmentHub EHub = home.OpenEntertainmentHub();
		EHub.verifyURL("http://www.wikia.com/Entertainment");
		
		EHub.verifyWikiaMosaicSliderHasImages();
		EHub.ClickOnNewsTab(2);
		EHub.ClickOnNewsTab(3);
		EHub.ClickOnNewsTab(1);
		EHub.RelatedVideosScrollRight();
		EHub.RelatedVideosScrollLeft();
		driver.close();
	}
}
