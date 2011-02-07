/**
 * ScavengerHunt
 *
 * A ScavengerHunt extension for MediaWiki
 * Alows to create a scavenger hunt game on a wiki
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2011-01-31
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 */

package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.*;

import org.testng.annotations.Test;

public class ScavengerHuntTest extends BaseTest {
//	@Test(groups={"oasis", "CI"})
	public void testAddGame() throws Exception {
		DateFormat df = new SimpleDateFormat("yyyyMMDDHHmm");
		String date = df.format(new Date());

		session().open("index.php?title=Special:ScavengerHunt");
		session().waitForPageToLoad(this.getTimeout());

		// add button
		assertTrue(session().isElementPresent("//form[@class='scavenger-form']//input[@name='add']"));
		session().click("//form[@class='scavenger-form']//input[@name='add']");
		session().waitForPageToLoad(this.getTimeout());

//		waitForElement("//input[@id='landing']", this.getTimeout());
		session().type("landing", "WikiaScavengerHuntStartingPage");
		session().type("//textarea[@name='startingClue']", "starting clue " + date);
		session().type("//input[@name='pageTitle[]']", "page title " + date);
		session().type("//input[@name='hiddenImage[]']", "http://hidden.image." + date);
		session().type("//input[@name='clueImage[]']", "http://clue.image." + date);
		session().type("//textarea[@name='clue[]']", "clue " + date);
		session().type("//textarea[@name='entryForm']", "entry form " + date);
		session().type("//textarea[@name='finalQuestion']", "final question " + date);
		session().type("//textarea[@name='goodbyeMsg']", "goodbye message " + date);
		session().click("//form[@class='scavenger-form']//input[@name='save']");
		session().waitForPageToLoad(this.getTimeout());

		//check on the list if game has been created
	}
}