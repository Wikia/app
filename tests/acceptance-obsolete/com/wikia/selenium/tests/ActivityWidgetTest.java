//@author Marooned
package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

public class ActivityWidgetTest extends BaseTest {

	@Test(groups={"CI", "legacy"})
	public void testEnsureDeprecatedNavigationMenuItemsRedirectToWikiaActivity() throws Exception {
		session().open("index.php?title=Special:ActivityFeed");
		assertTrue(session().getLocation().contains("wiki/Special:WikiActivity"));
		
		openAndWait("index.php?title=Special:MyHome");
		assertTrue(session().getLocation().contains("wiki/Special:WikiActivity"));

		login();

		openAndWait("index.php?title=Special:ActivityFeed");
		assertTrue(session().getLocation().contains("wiki/Special:WikiActivity"));
		
		openAndWait("index.php?title=Special:MyHome");
		assertTrue(session().getLocation().contains("wiki/Special:WikiActivity"));
	}
}
