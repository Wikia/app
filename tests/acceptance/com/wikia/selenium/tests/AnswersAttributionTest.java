package com.wikia.selenium.tests;

import java.util.regex.*;
import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertEquals;

public class AnswersAttributionTest extends BaseTest {
	
	@Test(groups={"answers", "CI"})
	public void testUserEditPoints() throws Exception {
		for (int i = 1; i <= 10; i++) {
			session().open("index.php?title=Special:Randomincategory/Answered_questions");
			waitForElement("contributors", TIMEOUT);
			assertTrue(session().isElementPresent("contributors"));
			if(session().isElementPresent("//a[@class='userPageLink']")) {
				// non-anon contributors were found, proceed..
				break;
			}
			else if(i == 10) {
				System.out.println("Unable to find random answer with real contributors");
				return;
			}
		}
		
		assertTrue(session().isElementPresent("//a[@class='userPageLink']"));
		
		String userPage = session().getAttribute("//div[@class='userInfo']/a[@class='userPageLink'][1]@href");
		String userEditPoints = session().getText("//div[@class='userInfo']/div[@class='userEditPoints']/span[@class='userPoints'][1]");
		System.out.println("User page: " + userPage + ", edit points to look for: " + userEditPoints);
		
		// check user page
		session().open(userPage);
		waitForElement("profile-title", TIMEOUT);
		assertTrue(session().isElementPresent("profile-title"));
		assertTrue(session().isElementPresent("//span[@class='profile-title-points']"));
		
		String userPageEditPointString = session().getText("//span[@class='profile-title-points']");
		System.out.println("User page edit points string: " + userPageEditPointString);
		
		Pattern pattern = Pattern.compile(userEditPoints);
		Matcher matcher = pattern.matcher(userPageEditPointString);
		
		assertTrue(matcher.find());
		
		// check first recently edited page by this user
		if(session().isElementPresent("//div[@id='user-page-right']/div[3]/a")) {
			String recentlyEditedPage = session().getAttribute("//div[@id='user-page-right']/div[3]/a@href");
			System.out.println("Checking random page edited by user: " + recentlyEditedPage);
			
			session().open(recentlyEditedPage);
			session().waitForPageToLoad(TIMEOUT);
			//waitForElement("contributors", TIMEOUT);
			if(session().isElementPresent("contributors")) {
				// question is answered
				assertTrue(session().isElementPresent("//a[@href='" + userPage + "']/../div[@class='userEditPoints']/span[@class='userPoints']"));
				String editedPageUserEditPoints = session().getText("//a[@href='" + userPage + "']/../div[@class='userEditPoints']/span[@class='userPoints']");
				System.out.println("User edit points at " + recentlyEditedPage + ": " + editedPageUserEditPoints);
				
				assertEquals(userEditPoints, editedPageUserEditPoints);
			}
		}
	}
}
