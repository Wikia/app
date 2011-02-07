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

import java.util.Date;
import java.text.SimpleDateFormat;
import java.text.DateFormat;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.*;

import org.testng.annotations.Test;

public class ScavengerHuntTest extends BaseTest {
//	@Test(groups={"oasis", "CI"})
	public void testAddGame() throws Exception {
		// prepare some data
		DateFormat df = new SimpleDateFormat("yyyyMMDDHHmm");
		String date = df.format(new Date());
		String gameName = "WikiaScavengerHuntGame " + date;
		String landing = "Main Page";	//this title MUST exist
		String startingClue = "starting clue " + date;
		String pageTitle = "Main Page";	//this title MUST exist
		String hiddenImage = "http://hidden.image." + date;
		String clueImage = "http://clue.image." + date;
		String clue = "clue " + date;
		String entryForm = "entry form " + date;
		String finalQuestion = "final question " + date;
		String goodbyeMsg = "goodbye message " + date;

		// go to the list
		session().open("index.php?title=Special:ScavengerHunt");
		session().waitForPageToLoad(this.getTimeout());

		// click `add` button
		assertTrue(session().isElementPresent("//form[@class='scavenger-form']//input[@class='scavenger-add']"));
		session().click("//form[@class='scavenger-form']//input[@class='scavenger-add']");
		session().waitForPageToLoad(this.getTimeout());

		// fill in the form
		session().type("gameName", gameName);
		session().type("//input[@name='landing']", landing);
		session().type("//textarea[@name='startingClue']", startingClue);
		session().type("//input[@name='pageTitle[]']", pageTitle);
		session().type("//input[@name='hiddenImage[]']", hiddenImage);
		session().type("//input[@name='clueImage[]']", clueImage);
		session().type("//textarea[@name='clue[]']", clue);
		session().type("//textarea[@name='entryForm']", entryForm);
		session().type("//textarea[@name='finalQuestion']", finalQuestion);
		session().type("//textarea[@name='goodbyeMsg']", goodbyeMsg);
		session().click("//form[@class='scavenger-form']//input[@name='save']");
		session().waitForPageToLoad(this.getTimeout());

		//TODO: check on the list if game has been created

		// go to edit form (TODO: click from the list)
		session().open("index.php?title=Special:ScavengerHunt/edit/5");
		session().waitForPageToLoad(this.getTimeout());
		//TODO: FIX: getText is returning nothing
		assertEquals(gameName, session().getText("gameName"));
		assertEquals(landing, session().getText("//input[@name='landing']"));
		//TODO: add other fields
	}
}