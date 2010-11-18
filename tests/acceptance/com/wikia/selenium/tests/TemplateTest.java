package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import com.thoughtworks.selenium.SeleniumException;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertEquals;

import org.testng.annotations.Test;

import java.util.UUID;

public class TemplateTest extends BaseTest {

	@Test(groups="oasis")
	public void testEnsureImportantElementsOfExistentTemplatePageExist() throws Exception {
		login();
		session().open("index.php?title=Template:Infobox");

		// check what page you land on
		assertTrue(session().getLocation().contains("index.php?title=Template:Infobox"));
		assertEquals(session().getText("//header[@id='WikiaPageHeader']/h1"), "Infobox");
		assertEquals(session().getText("//header[@id='WikiaPageHeader']/h2"), "Template page");

		// Edit Button
		assertTrue(session().isElementPresent("//header[@id='WikiaPageHeader']/ul/li/a[@data-id='edit']"));

		// Comments Button
		assertTrue(session().isElementPresent("//header[@id='WikiaPageHeader']/ul/li/a[@data-id='comment']"));

		// History Menu
		assertEquals(session().getText("//header[@id='WikiaPageHeader']/details/ul/li/a[@accesskey='h']"), "View full history");
		
		// non existent elements
		// Wikia Rail
		assertFalse(session().isElementPresent("//div[@id='WikiaRail']"));
	}

	@Test(groups="oasis")
	public void testEnsureImportantElementsOfExistentTemplateTalkPageExist() throws Exception {
		login();
		session().open("index.php?title=Template_talk:Infobox");
		assertTrue(session().getLocation().contains("index.php?title=Template_talk:Infobox"));
		
		// page title's prefix
		assertEquals(session().getText("//header[@id='WikiaPageHeader']/h1/strong"), "Talk:");
		
		// back to template link
		assertEquals(session().getText("//header[@id='WikiaPageHeader']/h2/a"), "Back to template");

		// add topic button
		assertTrue(session().isElementPresent("//header[@id='WikiaPageHeader']/ul/li/a[@data-id='addtopic']"));

		// History Menu
		assertEquals(session().getText("//header[@id='WikiaPageHeader']/details/ul/li/a[@accesskey='h']"), "View full history");
		
		// non existent elements
		// Wikia Rail
		assertFalse(session().isElementPresent("//div[@id='WikiaRail']"));
	}

	@Test(groups="oasis")
	public void testEnsureNonExistantTemplatePageContainsProperElements() throws Exception {

		login();
		String templateName = "NonExistentTemplateName" + UUID.randomUUID().toString().substring(0, 7);
		String url = "index.php?title=Template:" + templateName;
		try {
			session().open(url);
		} catch (SeleniumException se) {
			assertTrue(se.getMessage().contains("Response_Code = 404"));
		}

		// check what page you land on
		assertTrue(session().getLocation().contains("index.php?title=Template:" + templateName));
		assertEquals(session().getText("//header[@id='WikiaPageHeader']/h1"), templateName);
		assertEquals(session().getText("//header[@id='WikiaPageHeader']/h2"), "Template page");

		// check info message
		assertTrue(session().isTextPresent("This page needs content. You can help by adding a sentence or a photo!"));

		// non existent elements
		// Wikia Rail
		assertFalse(session().isElementPresent("//div[@id='WikiaRail']"));
	}
}
