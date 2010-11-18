/**
 * SharedHelp images test
 *
 * This test check whether images in the shared help section correctly link
 * to their image pages at help.wikia.com
 *
 * @author Lucas Garczewski <tor@wikia-inc.com>
 * @date 2009-11-09
 * @copyright Copyright (C) 2009 Lucas 'TOR' Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import com.thoughtworks.selenium.SeleniumException;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;

public class SharedHelpImagesTest extends BaseTest {

	@Test(groups={"oasis", "CI"})
	public void testSharedHelpImages() throws Exception {

		try {
			// this page can return 404 if there's no local content
			session().open("index.php?title=Help:YouTube_extension");
		} catch(SeleniumException se) {
			assertTrue(se.getMessage().contains("Response_Code = 404"));
		};

		session().waitForPageToLoad(TIMEOUT);

		// basic check to see if shared help is displayed
		assertTrue( session().isElementPresent("//div[@class='sharedHelp']") );

		// does the shared help article have any images at all?
		assertTrue( session().isElementPresent("//div[@class='sharedHelp']//a[@class=\"image\"]") );

		// TODO: maybe do a regex check here instead of a hardcoded string
		assertEquals( session().getAttribute( "//div[@class='sharedHelp']//a[@class=\"image\"]@href" ), "http://help.wikia.com/wiki/File:Youtube1.png" );
	}
}
