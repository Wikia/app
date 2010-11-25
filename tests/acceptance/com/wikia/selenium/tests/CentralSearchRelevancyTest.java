package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

import org.testng.annotations.Test;

public class CentralSearchRelevancyTest extends BaseTest {

	@Test(groups={"central","CI"})
	public void testRelevancy() throws Exception {
		String phrases[];
		String results[];
		phrases = new String[10];
		results = new String[10];
		phrases[0] = "warcraft";
		results[0] = "www.wowwiki.com/wiki/World of Warcraft";
		
		phrases[1] = "spiderman";
		results[1] = "spiderman.wikia.com/wiki/Spider-Man";
		
		phrases[2] = "tennis";
		results[2] = "tennis.wikia.com/wiki/Tennis";
		
		phrases[3] = "naruto";
		results[3] = "naruto.wikia.com/wiki/Naruto Series";
		
		phrases[4] = "desperate housewives";
		results[4] = "desperate.wikia.com/wiki/Desperate Housewives";

		phrases[5] = "cooking";
		results[5] = "cooking.wikia.com/wiki/Cooking Recipes";
		
		phrases[6] = "flashforward";
		results[6] = "flashforward.wikia.com/wiki/Flashforward";
		
		phrases[7] = "twilight";
		results[7] = "twilightsaga.wikia.com/wiki/Twilight";
		
		phrases[8] = "v";
		results[8] = "v.wikia.com/wiki/V";
		
		phrases[9] = "orson welles";
		results[9] = "muppet.wikia.com/wiki/Orson Welles";
		
		for (int i = 0; i < phrases.length; i++) {
			session().open("index.php?title=Special:Search/" + phrases[i]);
			waitForElement("powersearch", TIMEOUT);
			assertTrue(session().isElementPresent("powersearch"));
			assertTrue(session().isElementPresent("//a[@href='http://" + results[i] + "']"));
		}
	}
}
