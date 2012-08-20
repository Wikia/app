package com.wikia.webdriver.TestCases;

import org.testng.annotations.DataProvider;
import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.pageObjects.PageObject.HomePageObject;
import com.wikia.webdriver.pageObjects.PageObject.HubBasePageObject;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.EntertainmentHubPageObject;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.LifestyleHubPageObject;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.VideoGamesHubPageObject;

public class HubsTests extends TestTemplate{

	
	

	private static final VideoGamesHubPageObject VGHub = null;
	private static final LifestyleHubPageObject LHub = null;
	private static final EntertainmentHubPageObject EHub = null;
	private static HomePageObject home  = null;

	@DataProvider
	private static final Object[][] provideHub(){
		return new Object[][] {
				{VGHub, "VideoGamesHub", "http://www.wikia.com/Video_Games"},
				{EHub, "EntertainmentHub", "http://www.wikia.com/Entertainment"},
				{LHub, "LifestyleHub", "http://www.wikia.com/Lifestyle"}
		};
	}
	
	@Test(dataProvider = "provideHub")
	public void VideoGamesHubTest(HubBasePageObject Hub, String HubName, String HubURL)
	{
		startBrowser();
				
		home = new HomePageObject(driver);
		home.openHomePage();
						
		Hub = home.OpenHub(HubName);
		Hub.verifyURL(HubURL);
		
		Hub.verifyWikiaMosaicSliderHasImages();
		Hub.ClickOnNewsTab(2);
		Hub.ClickOnNewsTab(3);
		Hub.ClickOnNewsTab(1);
		Hub.RelatedVideosScrollRight();
		Hub.RelatedVideosScrollLeft();
				

		home = Hub.BackToHomePage();
		
		stopBrowser();
		
	}
}
