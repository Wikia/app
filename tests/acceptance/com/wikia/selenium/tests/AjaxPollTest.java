package com.wikia.selenium.tests;

import java.io.ByteArrayInputStream;
import java.util.UUID;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;

public class AjaxPollTest extends BaseTest {

	@Test(groups={"oasis"})
	public void testAjaxPoll() throws Exception {
		String uniqId = "Wikia test poll #" + UUID.randomUUID();
		String pollContent = "\n" + uniqId + "\nAnswer 1\nAnswer 2\nAnswer n\n";
		// the line below must match code from AjaxPoll extension
		String pollId = (md5(new ByteArrayInputStream(pollContent.getBytes())))
				.toUpperCase();
		pollContent = "<poll>" + pollContent + "</poll>";

		login();
		editArticle("WikiaAutomatedTest", pollContent);

		String radioToClick = "//input[@id='wpPollRadio" + pollId
								+ "' and @name='wpPollRadio" + pollId
								+ "' and @value='3']"; 
		session().click( radioToClick );
		session().click("axPollSubmit" + pollId);
		waitForElementNotVisible("pollSubmittingInfo" + pollId);
		session().open("index.php?title=WikiaAutomatedTest&action=purge");
		session().waitForPageToLoad(TIMEOUT);
		assertEquals("1", session().getText("wpPollVote" + pollId + "-3"));
		assertEquals("1", session().getText("wpPollTotal" + pollId));

		// clean up
		doDeleteIfAllowed("label=Author request", "Clean up after test");
	}
}
