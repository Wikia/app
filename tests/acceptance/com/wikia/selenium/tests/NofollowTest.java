/**
 * Nofollow test
 *
 * @author Maciej Błaszkowski (Marooned) <Marooned at wikia-inc.com>
 * @date 2009-09-04
 * @copyright Copyright (C) 2009 Maciej Błaszkowski (Marooned), Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

package com.wikia.selenium.tests;

import java.util.Date;
import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;

public class NofollowTest extends BaseTest {
	@Test(groups={"CI"})
	public void testNofollow() throws Exception {
		login();
		String content = (new Date()).toString();
		editArticle("WikiaAutomatedTest", "*Tested: " + content + " by [[wikia:user:" + getTestConfig().getString("ci.user.wikiabot.username") + "|" + getTestConfig().getString("ci.user.wikiabot.username") + "]]\n[[Category:Wikia tests]]");
		session().open("index.php?title=WikiaAutomatedTest");
		session().waitForPageToLoad(TIMEOUT);
		//testing t:r9070
		assertEquals(session().getAttribute("//div[@id=\"mw-normal-catlinks\"]/a[1]@rel"), "nofollow");
	}
}
