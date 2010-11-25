//@author Marooned
package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

public class ActivityWidgetTest extends BaseTest {

	@Test(groups={"CI"})
	public void testEnsureDeprecatedNavigationMenuItemsRedirectToWikiaActivity() throws Exception {
		session().open("index.php?title=Special:ActivityFeed");
		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().getLocation().contains("wiki/Special:WikiActivity"));
		
		session().open("index.php?title=Special:MyHome");
		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().getLocation().contains("wiki/Special:WikiActivity"));

		login();

		session().open("index.php?title=Special:ActivityFeed");
		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().getLocation().contains("wiki/Special:WikiActivity"));
		
		session().open("index.php?title=Special:MyHome");
		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().getLocation().contains("wiki/Special:WikiActivity"));
	}
}
