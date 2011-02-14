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
	@Test(groups={"oasis", "CI"})
	public void testGame() throws Exception {
		//prepare some data
		DateFormat df = new SimpleDateFormat("yyyyMMDDHHmm");
		String date = df.format(new Date());
		//general
		String generalGameName = "WikiaScavengerHuntGame " + date;
		String generalLanding = "Main Page";	//this title MUST exist
		String generalButton = "Start a game!";
		String imageTop = "150";
		String imageLeft = "-150";
		//starting
		String startingClueTitle = "Starting title " + date;
		String startingClueText = "Starting clue text " + date;
		String startingClueImage = "http://images2.wikia.nocookie.net/__cb20101125134213/lukasztest/pl/images/8/84/Test_picture_1.png";
		String startingButtonText = "Starting clue button " + date;
		String startingButtonTarget = "http://wikia.com/?target=starting&date=" + date;
		//article
		String articleTitle = "Main Page";	//this title MUST exist
		String articleHiddenImage = "http://images2.wikia.nocookie.net/__cb20101125134214/lukasztest/pl/images/f/f6/Test_picture_2.png";
		String articleClueTitle = "Article clue title " + date;
		String articleClueText = "Article clue text " + date;
		String articleClueImage = "http://images4.wikia.nocookie.net/__cb20101125134214/lukasztest/pl/images/d/da/Test_picture_3.png";
		String articleButtonText = "Article clue button " + date;
		String articleButtonTarget = "http://wikia.com/?target=article&date=" + date;
		//entry form
		String entryModalTitle = "Entry title " + date;
		String entryModalText = "Entry modal text " + date;
		String entryModalImage = "http://images1.wikia.nocookie.net/__cb20101125134214/lukasztest/pl/images/8/8c/Test_picture_4.png";
		String entryQuestion = "Entry question " + date;
		//goodbye
		String goodbyeModalTitle = "Goodbye title " + date;
		String goodbyeModalText = "Goodbye text " + date;
		String goodbyeModalImage = "http://images1.wikia.nocookie.net/__cb20101125134214/lukasztest/pl/images/8/88/Test_picture_5.png";

		//go to the list
		session().open("index.php?title=Special:ScavengerHunt");
		session().waitForPageToLoad(this.getTimeout());

		//click `add` button
		assertTrue(session().isElementPresent("//header[@id='WikiaPageHeader']//a[contains(@class, 'scavengerhunt-add-button')]"));
		session().click("//header[@id='WikiaPageHeader']//a[contains(@class, 'scavengerhunt-add-button')]");
		session().waitForPageToLoad(this.getTimeout());

		//fill in the form
		//general
		session().type("gameName", generalGameName);
		session().type("//input[@name='landingTitle']", generalLanding);
		session().type("//input[@name='landingButtonText']", generalButton);
		//starting
		session().type("//input[@name='startingClueTitle']", startingClueTitle);
		session().type("//textarea[@name='startingClueText']", startingClueText);
		session().type("//input[@name='startingClueImage']", startingClueImage);
		session().type("//input[@name='startingClueImageTopOffset']", imageTop);
		session().type("//input[@name='startingClueImageLeftOffset']", imageLeft);
		session().type("//input[@name='startingClueButtonText']", startingButtonText);
		session().type("//input[@name='startingClueButtonTarget']", startingButtonTarget);
		//article #1
		session().type("//input[@name='articleTitle[]']", articleTitle);
		session().type("//input[@name='articleHiddenImage[]']", articleHiddenImage);
		session().type("//input[@name='articleClueTitle[]']", articleClueTitle);
		session().type("//textarea[@name='articleClueText[]']", articleClueText);
		session().type("//input[@name='articleClueImage[]']", articleClueImage);
		session().type("//input[@name='articleClueImageTopOffset[]']", imageTop);
		session().type("//input[@name='articleClueImageLeftOffset[]']", imageLeft);
		session().type("//input[@name='articleClueButtonText[]']", articleButtonText);
		session().type("//input[@name='articleClueButtonTarget[]']", articleButtonTarget);
		//TODO: add article #2 (invoke onblur() on articleTitle)
		//entry
		session().type("//input[@name='entryFormTitle']", entryModalTitle);
		session().type("//textarea[@name='entryFormText']", entryModalText);
		session().type("//input[@name='entryFormImage']", entryModalImage);
		session().type("//input[@name='entryFormImageTopOffset']", imageTop);
		session().type("//input[@name='entryFormImageLeftOffset']", imageLeft);
		session().type("//textarea[@name='entryFormQuestion']", entryQuestion);
		//goodbye
		session().type("//input[@name='goodbyeTitle']", goodbyeModalTitle);
		session().type("//textarea[@name='goodbyeText']", goodbyeModalText);
		session().type("//input[@name='goodbyeImage']", goodbyeModalImage);
		session().type("//input[@name='goodbyeImageTopOffset']", imageTop);
		session().type("//input[@name='goodbyeImageLeftOffset']", imageLeft);
		//finish
		session().click("//form[@class='scavenger-form']//input[@name='save']");
		session().waitForPageToLoad(this.getTimeout());

		//check confirmation (Oasis only)
		assertTrue(session().isElementPresent("//section[@id='WikiaPage']/div[@class='WikiaConfirmation']"));
		//check if new game is on the list
		assertTrue(session().isElementPresent("//div[@id='WikiaArticle']/table/tbody/tr/td[contains(text(), '" + generalGameName + "')]"));
		//click edit
		session().click("//div[@id='WikiaArticle']/table/tbody/tr[td[contains(text(), '" + generalGameName + "')]]/td[3]/a");
		//enable the game
		session().click("//form[@class='scavenger-form']//input[@name='enable']");
		session().waitForPageToLoad(this.getTimeout());

		//go to article with game data
		session().open("index.php?title=" + generalLanding);
		session().waitForPageToLoad(this.getTimeout());
		//check presence of start button
		assertTrue(session().isElementPresent("//div[@id='WikiaArticle']/input[@value='" + generalButton + "']"));
		//click it
		session().click("//div[@id='WikiaArticle']/input[@value='" + generalButton + "']");
		//wait for modal and check presence of the button
		assertTrue(waitForModal("//div[@class='scavenger-clue-button']/a[@href='" + startingButtonTarget + "']"));
	}

	private boolean waitForModal(String xpath) throws Exception {
		for (int second = 0;; second++) {
			if (second >= 60) return false;
			try {
				if (session().isElementPresent(xpath)) return true;
			}
			catch (Exception e) {}
			Thread.sleep(500);
		}
	}
}