package com.wikia.selenium.tests;

import java.io.ByteArrayInputStream;
import java.util.UUID;
import java.util.Date;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.BeforeMethod;

public class PageLayoutBuilderTest extends BaseTest {
	
	@Test
	public void testPrivileges() throws Exception {
		loginAsStaff();
		session().open("index.php?title=Special:PageLayoutBuilder");
		session().waitForPageToLoad(TIMEOUT);
		assertEquals(session().getText("//div[@id='WikiaPageHeader']/h1"), "Create a new layout");
		logout();
		
		loginAsRegular();
		session().open("index.php?title=Special:PageLayoutBuilder");
		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().isTextPresent("Permission error"));
		logout();
	}

	@Test
	public void testCreateNonExistentLayout() throws Exception {
		loginAsStaff();
		session().click("link=My Tools");
		session().click("link=Layout builder");
		session().waitForPageToLoad(TIMEOUT);
		int layoutsNum = session().getXpathCount("/html/body/section/article/div/table/tbody/tr").intValue();
		clickAndWait("plbNewButton");

		assertTrue(session().isTextPresent("Create a new layout"));
		clickAndWait("wpSave");
		assertTrue(session().isTextPresent("Please correct the following errors"));
		assertTrue(session().isTextPresent("plb-create-empty-title-error"));
		assertTrue(session().isTextPresent("plb-create-empty-body-error"));
		assertTrue(session().isTextPresent("plb-create-empty-desc"));

		String date  = (new Date()).toString();
		String title = "Test layout " + date;
		String description = "Test description " + date;
		session().type("wgTitle", title);
		session().type("wgDesc", description);
		doEdit("Lorem ipsum");
		clickAndWait("wpSave");
		assertTrue(session().isTextPresent(title.replace(" ", "_")));
		assertTrue(session().isTextPresent(description));
		assertEquals(layoutsNum + 1, session().getXpathCount("/html/body/section/article/div/table/tbody/tr"));
	}

	@Test
	public void testCreateExistentLayout() throws Exception {
		loginAsStaff();
		session().click("link=My Tools");
		session().click("link=Layout builder");
		session().waitForPageToLoad(TIMEOUT);
		clickAndWait("plbNewButton");

		String date  = (new Date()).toString();
		String title = "Test layout " + date;
		String description = "Test layout " + date;
		session().type("wgTitle", "Test layout " + date);
		session().type("wgDesc", "Test description " + date);
		doEdit("Lorem ipsum");
		clickAndWait("wpSave");
		int layoutsNum = session().getXpathCount("/html/body/section/article/div/table/tbody/tr").intValue();

		clickAndWait("plbNewButton");

		session().type("wgTitle", "Test layout " + date);
		session().type("wgDesc", "Test description " + date);
		doEdit("Lorem ipsum");
		clickAndWait("wpSave");

		assertTrue(session().isTextPresent("plb-create-already-exists-error"));
		
		session().open("index.php?title=Special:PageLayoutBuilder&action=list");
		session().waitForPageToLoad(TIMEOUT);
		assertEquals(layoutsNum, session().getXpathCount("/html/body/section/article/div/table/tbody/tr").intValue());
	}
}
