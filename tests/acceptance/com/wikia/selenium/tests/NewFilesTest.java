package com.wikia.selenium.tests;

import java.io.File;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Parameters;
import org.testng.annotations.Test;

public class NewFilesTest extends BaseTest {
	private static final String testArticleName = "WikiaNewFilesTest";

	// let's create an article on which view mode tests will be performed
	private void prepareTestArticle() throws Exception {
		editArticle(NewFilesTest.testArticleName, "Wikia automated test for NewFiles\n\n===Gallery===\n\n<gallery>\nWiki.png\n</gallery>\n\n[[Category:Wikia tests]]");
	}

	@Test(groups={"CI"})
	public void imageCaptions() throws Exception {
		loginAsStaff();
		prepareTestArticle();
		
		session().open("wiki/Special:NewFiles");
		waitForElement("//div[@id='gallery-']", TIMEOUT);
		assertTrue(session().isElementPresent("//div[@id='gallery-']/div/div[@class='thumb']"));
		assertTrue(session().isElementPresent("//div[@id='gallery-']/div/div[@class='lightbox-caption']"));
	}

	@Test(groups={"CI"})
	public void imageLightbox() throws Exception {
		loginAsStaff();
		prepareTestArticle();

		session().open("wiki/Special:NewFiles");
		waitForElement("//div[@id='gallery-']", TIMEOUT);
		session().click("//a[@class='image lightbox']");
		assertTrue(session().isElementPresent("//div[@id='lightbox-image']"));
	}
}
