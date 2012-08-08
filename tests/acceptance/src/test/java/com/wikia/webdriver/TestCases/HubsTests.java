package com.wikia.webdriver.TestCases;

import org.testng.annotations.Test;

import com.wikia.webdriver.Templates.TestTemplate;
import com.wikia.webdriver.pageObjects.PageObject.HomePageObject;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.EntertainmentHubPageObject;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.LifestyleHubPageObject;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.VideoGamesHubPageObject;

public class HubsTests extends TestTemplate{

	@Test
	public void VideoGamesHubTest()
	{
		
		HomePageObject home = new HomePageObject(driver);
		home.openHomePage();
		
		VideoGamesHubPageObject VGHub = home.OpenVideoGamesHub();
		VGHub.verifyURL("http://www.wikia.com/Video_Games");
		
		VGHub.verifyWikiaMosaicSliderHasImages();
		VGHub.ClickOnNewsTab(2);
		VGHub.ClickOnNewsTab(3);
		VGHub.ClickOnNewsTab(1);
		VGHub.RelatedVideosScrollRight();
		VGHub.RelatedVideosScrollLeft();
				
		home = VGHub.BackToHomePage();
		
		
		LifestyleHubPageObject LHub = home.OpenLifestyleHub();
		LHub.verifyURL("http://www.wikia.com/Lifestyle");
		
		LHub.verifyWikiaMosaicSliderHasImages();
		LHub.ClickOnNewsTab(2);
		LHub.ClickOnNewsTab(3);
		LHub.ClickOnNewsTab(1);
		LHub.RelatedVideosScrollRight();
		LHub.RelatedVideosScrollLeft();
		
		
		home = LHub.BackToHomePage();
		
		EntertainmentHubPageObject EHub = home.OpenEntertainmentHub();
		EHub.verifyURL("http://www.wikia.com/Entertainment");
		
		EHub.verifyWikiaMosaicSliderHasImages();
		EHub.ClickOnNewsTab(2);
		EHub.ClickOnNewsTab(3);
		EHub.ClickOnNewsTab(1);
		EHub.RelatedVideosScrollRight();
		EHub.RelatedVideosScrollLeft();
		
	}
}
