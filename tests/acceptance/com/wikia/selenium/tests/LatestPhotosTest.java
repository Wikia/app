package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertEquals;

import org.testng.annotations.Test;

public class LatestPhotosTest extends BaseTest {
	@Test(groups={"oasis","CI"})
	public void testLatestPhotos() throws Exception {
		loginAsRegular();
		session().open("index.php?title=Special:Random");
		session().waitForPageToLoad(TIMEOUT);

		// Latest Photos Module
		assertTrue(session().isElementPresent("//section[contains(@class,'LatestPhotosModule')]"));
		assertTrue(session().isElementPresent("link=Add a Photo"));

		// Interatction Part
		// add a photo button
		session().click("link=Add a Photo");
		waitForElement("//section[@id='UploadPhotosWrapper']");
		session().click("//section[@id='UploadPhotosWrapper']//button[contains(@class, 'close')]");

		session().open("index.php?title=Special:Random");
		session().waitForPageToLoad(TIMEOUT);

		// browse through gallery
		String firstPhotoSrc = session().getAttribute("//section[contains(@class,'LatestPhotosModule')]//ul[@class='carousel']/li/a/img@src");
		session().click("//div[@id='WikiaRail']/section[contains(@class,'LatestPhotosModule')]/a[@class='next']/img");
		waitForAttributeNotEquals("//section[contains(@class,'LatestPhotosModule')]//ul[@class='carousel']/li/a/img@src", firstPhotoSrc, TIMEOUT);

		//view all photos
		session().click("//section[contains(@class,'LatestPhotosModule')]/a[@class='more']");
		session().waitForPageToLoad(TIMEOUT);
		assertEquals(session().getText("//header[@id='WikiaPageHeader']/h1"), "New photos on this wiki");

		session().open("index.php?title=Special:Random");
	 	session().waitForPageToLoad(TIMEOUT);

		// open a photo in the lightbox
		session().click("//section[contains(@class,'LatestPhotosModule')]//ul[@class='carousel']/li/a");
		waitForElement("//section[@id='lightbox']");
	}
}
