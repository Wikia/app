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

	@BeforeMethod(alwaysRun = true)
	public void setUp() throws Exception
	{
		loginAsStaff();
		session().open("index.php?title=Special:PageLayoutBuilder&action=list");
		session().waitForPageToLoad(TIMEOUT);
		while (!session().isTextPresent("Layouts(0)")) {
			clickAndWait("//table[@id='plbLayoutList']/tbody/tr[1]/td[1]/p[2]/a[contains(@class, 'delete')]");
			assertTrue(session().getConfirmation().matches("^Are you sure you want to delete this layout[\\s\\S]$"));
			session().waitForPageToLoad(TIMEOUT);
		}
		logout();
	}
	
	@Test(groups={"extensionPLB"})
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

	@Test(groups={"extensionPLB"})
	public void testCreateNonExistentLayoutFromScratch() throws Exception {
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
		assertFalse(session().isTextPresent(title.replace(" ", "_")));
		assertTrue(session().isTextPresent(title));
		assertTrue(session().isTextPresent(description));
		assertEquals(layoutsNum + 1, session().getXpathCount("/html/body/section/article/div/table/tbody/tr"));
	}

	@Test(groups={"extensionPLB"})
	public void testCreateExistentLayoutFromScratch() throws Exception {
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

	@Test(groups={"extensionPLB"})
	public void testCreateLayoutWithCategories() throws Exception {
		loginAsStaff();
		session().open("index.php?title=Special:PageLayoutBuilder");
		session().waitForPageToLoad(TIMEOUT);

		String date  = (new Date()).toString();
		String title = "Test layout " + date;
		String description = "Test layout " + date;
		
		// fill in form
		session().type("wgTitle", "Test layout " + date);
		session().type("wgDesc", "Test description " + date);
		doEdit("Lorem ipsum");
		
		// add categories
		session().click("csAddCategoryButton");
		session().focus("css=#csCategoryInput");
		session().type("css=#csCategoryInput", "Test category A");
		session().keyPress("css=#csCategoryInput", "13");
		waitForElement("//div[@id='csItemsContainer']/a[1]/img[2]");
		session().type("css=#csCategoryInput", "Test category B");
		session().keyPress("css=#csCategoryInput", "13");
		waitForElement("//div[@id='csItemsContainer']/a[2]/img[2]");
		
		// verify categories
		assertEquals("Test category A", session().getText("link=Test category A"));
		assertEquals("Test category B", session().getText("link=Test category B"));
		
		// preview and verify categories
		clickAndWait("wpPreviewform");
		assertEquals("Test category A", session().getText("link=Test category A"));
		assertEquals("Test category B", session().getText("link=Test category B"));
		
		// save
		clickAndWait("wpSave");
		int layoutsNum = session().getXpathCount("//table[@id='plbLayoutList']/tbody/tr").intValue();
		
		// edit
		clickAndWait("//table[@id='plbLayoutList']/tbody/tr[" + layoutsNum + "]/td[1]/p[2]/a[contains(@class, 'edit')]");
		
		// verify categories
		assertEquals("Test category A", session().getText("link=Test category A"));
		assertEquals("Test category B", session().getText("link=Test category B"));
		
		// remove category
		session().click("//div[@id='csItemsContainer']/a[2]/img[2]");
		assertFalse(session().isElementPresent("link=Test category B"));
		
		// preview
		clickAndWait("wpPreviewform");
		assertFalse(session().isElementPresent("link=Test category B"));
		
		// save
		clickAndWait("wpSave");
		
		// edit
		clickAndWait("//table[@id='plbLayoutList']/tbody/tr[" + layoutsNum + "]/td[1]/p[2]/a[contains(@class, 'edit')]");
		assertFalse(session().isElementPresent("link=Test category B"));
		
		// open category page
		session().open("index.php?title=Category:Test_category_A");
		session().waitForPageToLoad(TIMEOUT);
		assertFalse(session().isTextPresent("Test layout"));
	}

	@Test(groups={"extensionPLB"})
	public void testPreviewFormAndArticle() throws Exception {
		loginAsStaff();
		session().open("index.php?title=Special:PageLayoutBuilder");
		session().waitForPageToLoad(TIMEOUT);

		String date  = (new Date()).toString();
		String title = "Test layout " + date;
		String description = "Test layout " + date;
		session().type("wgTitle", "Test layout " + date);
		session().type("wgDesc", "Test description " + date);
		
		doEdit("Lorem ipsum<plb_input id=\"1\" caption=\"A caption\" instructions=\"\" required=\"0\" />");
		clickAndWait("wpPreviewform");
		
		assertTrue(session().isElementPresent("//input[@name='plb_1']"));
		assertEquals("", session().getValue("plb_1"));
		assertFalse(session().getText("//div[@class='plb-preview-div']").contains("Lorem ipsum"));
		
		clickAndWait("wpPreviewarticle");
		assertFalse(session().isElementPresent("//input[@name='plb_1']"));
		assertTrue(session().getText("//div[@class='plb-preview-div']").contains("Lorem ipsum"));
	}
	
	@Test(groups={"extensionPLB"})
	public void testSourceModeSwitching() throws Exception {
		String allInputTypesContent =
			"Lorem ipsum <plb_input id=\"1\" caption=\"inline text input\" instructions=\"\" required=\"0\" />\n" +
			"<plb_mlinput id=\"2\" caption=\"paragraph text input\" instructions=\"\" required=\"0\" />" + 
			"<plb_image id=\"3\" caption=\"image input\" instructions=\"\" required=\"0\" align=\"left\" size=\"150\" type=\"frameless\" />" +
			"<plb_sinput id=\"4\" caption=\"select box input\" instructions=\"\" required=\"0\" options=\"item one|item two\" />";

		loginAsStaff();
		session().open("index.php?title=Special:PageLayoutBuilder");
		session().waitForPageToLoad(TIMEOUT);

		switchEditorMode("source");
		session().type("//td[@id='cke_contents_wpTextbox1']/textarea", allInputTypesContent);
		switchEditorMode("wysiwyg");
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-manager']/ul/li");
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-manager']/ul/li/ul/li[@class='plb-add-menu-item-plb_input']");
		waitForElementVisible("caption");
		session().type("caption", "New text input");
		session().click("//input[@value='Save']");
		switchEditorMode("source");
		assertEquals(
			allInputTypesContent + "\n\n<plb_input id=\"5\" caption=\"New text input\" instructions=\"\" required=\"0\" />",
			session().getValue("//td[@id='cke_contents_wpTextbox1']/textarea")
		);
	}
	
	@Test(groups={"extensionPLB"})
	public void testEditingInlineInputElements() throws Exception {
		loginAsStaff();
		session().open("index.php?title=Special:PageLayoutBuilder");
		session().waitForPageToLoad(TIMEOUT);
		
		waitForElement("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-manager']/ul/li");
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-manager']/ul/li");
		
		// add input, save empty form and filled in
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-manager']/ul/li/ul/li[@class='plb-add-menu-item-plb_input']");
		waitForElementVisible("caption");
		session().click("//input[@value='Save']");
		waitForElement("//div[@class='plb-pe-validation-status']");
		session().type("caption", "Text input caption");
		session().type("instructions", "Text input instructions");
		session().click("//input[@value='Save']");
		
		// RTE content
		assertEquals("1", session().getText("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-widgets']/span[@class='plb-widgets-summary']/span[@class='plb-widgets-count']"));
		assertTrue(session().isElementPresent("//body[@id='bodyContent']"));
		assertTrue(session().isElementPresent("//span[contains(@class, 'plb-rte-widget-plb_input')]"));
		assertEquals("Text input caption", session().getText("//span[contains(@class, 'plb-rte-widget-plb_input')]/span[@class='plb-rte-widget-caption']"));
		
		// edit
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-widgets']/ul[@class='plb-widget-list']/li[contains(@class, 'plb-widget-list-entry-plb_input')]/span[@class='buttons']/button[contains(@class, 'edit')]");
		waitForElementVisible("caption");
		assertEquals("Text input caption", session().getValue("caption"));
		assertEquals("Text input instructions", session().getValue("instructions"));
		assertFalse(session().isChecked("required"));
		session().type("caption", "New text input caption");
		session().type("instructions", "New text input instructions");
		session().click("required");
		session().click("//input[@value='Cancel']");
		
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-widgets']/ul[@class='plb-widget-list']/li[contains(@class, 'plb-widget-list-entry-plb_input')]/span[@class='buttons']/button[contains(@class, 'edit')]");
		waitForElementVisible("caption");
		assertEquals("Text input caption", session().getValue("caption"));
		assertEquals("Text input instructions", session().getValue("instructions"));
		assertFalse(session().isChecked("required"));
		session().type("caption", "New text input caption");
		session().type("instructions", "New text input instructions");
		session().click("required");
		session().click("//input[@value='Save']");
		
		assertEquals("New text input caption", session().getText("//span[contains(@class, 'plb-rte-widget-plb_input')]/span[@class='plb-rte-widget-caption']"));
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-widgets']/ul[@class='plb-widget-list']/li[contains(@class, 'plb-widget-list-entry-plb_input')]/span[@class='buttons']/button[contains(@class, 'edit')]");
		waitForElementVisible("caption");
		assertEquals("New text input caption", session().getValue("caption"));
		assertEquals("New text input instructions", session().getValue("instructions"));
		assertTrue(session().isChecked("required"));
		session().click("//input[@value='Save']");
	}
	
	@Test(groups={"extensionPLB"})
	public void testEditingParagraphElements() throws Exception {
		loginAsStaff();
		session().open("index.php?title=Special:PageLayoutBuilder");
		session().waitForPageToLoad(TIMEOUT);
		
		waitForElement("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-manager']/ul/li");
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-manager']/ul/li");
		
		// add
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-manager']/ul/li/ul/li[@class='plb-add-menu-item-plb_mlinput']");
		waitForElementVisible("caption");
		session().click("//input[@value='Save']");
		waitForElement("//div[@class='plb-pe-validation-status']");
		session().type("caption", "Paragraph caption");
		session().type("instructions", "Paragraph instructions");
		session().click("//input[@value='Save']");
		
		// RTE content
		assertEquals("1", session().getText("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-widgets']/span[@class='plb-widgets-summary']/span[@class='plb-widgets-count']"));
		assertTrue(session().isElementPresent("//span[contains(@class, 'plb-rte-widget-plb_mlinput')]"));
		assertEquals("Paragraph caption", session().getText("//span[contains(@class, 'plb-rte-widget-plb_mlinput')]/span[@class='plb-rte-widget-caption']"));
		
		// edit
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-widgets']/ul[@class='plb-widget-list']/li[contains(@class, 'plb-widget-list-entry-plb_mlinput')]/span[@class='buttons']/button[contains(@class, 'edit')]");
		waitForElementVisible("caption");
		System.out.println(session().getValue("caption"));
		System.out.println(session().getValue("instructions"));
		assertEquals("Paragraph caption", session().getValue("caption"));
		assertEquals("Paragraph instructions", session().getValue("instructions"));
		assertFalse(session().isChecked("required"));
		session().type("caption", "New paragraph caption");
		session().type("instructions", "New paragraph instructions");
		session().click("required");
		session().click("//input[@value='Cancel']");
		
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-widgets']/ul[@class='plb-widget-list']/li[contains(@class, 'plb-widget-list-entry-plb_mlinput')]/span[@class='buttons']/button[contains(@class, 'edit')]");
		waitForElementVisible("caption");
		assertEquals("Paragraph caption", session().getValue("caption"));
		assertEquals("Paragraph instructions", session().getValue("instructions"));
		assertFalse(session().isChecked("required"));
		session().type("caption", "New paragraph caption");
		session().type("instructions", "New paragraph instructions");
		session().click("required");
		session().click("//input[@value='Save']");
		
		assertEquals("New paragraph caption", session().getText("//span[contains(@class, 'plb-rte-widget-plb_mlinput')]/span[@class='plb-rte-widget-caption']"));
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-widgets']/ul[@class='plb-widget-list']/li[contains(@class, 'plb-widget-list-entry-plb_mlinput')]/span[@class='buttons']/button[contains(@class, 'edit')]");
		waitForElementVisible("caption");
		assertEquals("New paragraph caption", session().getValue("caption"));
		assertEquals("New paragraph instructions", session().getValue("instructions"));
		assertTrue(session().isChecked("required"));
		session().click("//input[@value='Save']");
	}
	
	@Test(groups={"extensionPLB"})
	public void testEditingImageElements() throws Exception {
		loginAsStaff();
		session().open("index.php?title=Special:PageLayoutBuilder");
		session().waitForPageToLoad(TIMEOUT);
		
		waitForElement("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-manager']/ul/li");
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-manager']/ul/li");
		
		// add
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-manager']/ul/li/ul/li[@class='plb-add-menu-item-plb_image']");
		waitForElementVisible("caption");
		session().click("//input[@value='Save']");
		waitForElement("//div[@class='plb-pe-validation-status']");
		session().type("caption", "Image caption");
		session().type("instructions", "Image instructions");
		session().select("align", "label=Right");
		session().type("size", "250");
		session().click("x-type");
		session().click("//input[@value='Save']");
		
		// RTE content
		assertEquals("1", session().getText("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-widgets']/span[@class='plb-widgets-summary']/span[@class='plb-widgets-count']"));
		assertTrue(session().isElementPresent("//body[@id='bodyContent']"));
		assertTrue(session().isElementPresent("//span[contains(@class, 'plb-rte-widget-plb_image')]"));
		assertEquals("Image caption", session().getText("//span[contains(@class, 'plb-rte-widget-plb_image')]/span[@class='plb-rte-widget-caption']"));
		assertTrue(session().isElementPresent("//span[contains(@class, 'plb-rte-widget-plb_image')]/img"));
		
		// edit
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-widgets']/ul[@class='plb-widget-list']/li[contains(@class, 'plb-widget-list-entry-plb_image')]/span[@class='buttons']/button[contains(@class, 'edit')]");
		waitForElementVisible("caption");
		assertEquals("Image caption", session().getValue("caption"));
		assertEquals("Image instructions", session().getValue("instructions"));
		assertEquals("right", session().getValue("align"));
		assertEquals("250", session().getValue("size"));
		assertTrue(session().isChecked("x-type"));
		assertFalse(session().isChecked("required"));
		session().type("caption", "New image caption");
		session().type("instructions", "New image instructions");
		session().select("align", "label=Center");
		session().type("size", "350");
		session().click("x-type");
		session().click("required");
		session().click("//input[@value='Cancel']");
		
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-widgets']/ul[@class='plb-widget-list']/li[contains(@class, 'plb-widget-list-entry-plb_image')]/span[@class='buttons']/button[contains(@class, 'edit')]");
		waitForElementVisible("caption");
		assertEquals("Image caption", session().getValue("caption"));
		assertEquals("Image instructions", session().getValue("instructions"));
		assertEquals("right", session().getValue("align"));
		assertEquals("250", session().getValue("size"));
		assertTrue(session().isChecked("x-type"));
		assertFalse(session().isChecked("required"));
		session().type("caption", "New image caption");
		session().type("instructions", "New image instructions");
		session().select("align", "label=Center");
		session().type("size", "350");
		session().click("x-type");
		session().click("required");
		session().click("//input[@value='Save']");
		
		assertEquals("New image caption", session().getText("//span[contains(@class, 'plb-rte-widget-plb_image')]/span[@class='plb-rte-widget-caption']"));
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-widgets']/ul[@class='plb-widget-list']/li[contains(@class, 'plb-widget-list-entry-plb_image')]/span[@class='buttons']/button[contains(@class, 'edit')]");
		waitForElementVisible("caption");
		assertEquals("New image caption", session().getValue("caption"));
		assertEquals("New image instructions", session().getValue("instructions"));
		assertEquals("center", session().getValue("align"));
		assertEquals("350", session().getValue("size"));
		assertFalse(session().isChecked("x-type"));
		assertTrue(session().isChecked("required"));
		session().click("//input[@value='Save']");
	}
	
	@Test(groups={"extensionPLB"})
	public void testEditingComboBoxElements() throws Exception {
		loginAsStaff();
		session().open("index.php?title=Special:PageLayoutBuilder");
		session().waitForPageToLoad(TIMEOUT);
		
		waitForElement("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-manager']/ul/li");
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-manager']/ul/li");
		
		// add
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-manager']/ul/li/ul/li[@class='plb-add-menu-item-plb_sinput']");
		waitForElementVisible("caption");
		session().click("//input[@value='Save']");
		waitForElement("//div[@class='plb-pe-validation-status']");
		session().type("x-options", "choice one\nchoice two\nchoice three");
		session().click("//input[@value='Save']");
		waitForElement("//div[@class='plb-pe-validation-status']");
		session().type("caption", "Combo box caption");
		session().type("instructions", "Combo box instruction");
		session().type("x-options", "choice one\nchoice two\nchoice three");
		session().click("//input[@value='Save']");
		
		// RTE content
		assertEquals("1", session().getText("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-widgets']/span[@class='plb-widgets-summary']/span[@class='plb-widgets-count']"));
		assertTrue(session().isElementPresent("//body[@id='bodyContent']"));
		assertTrue(session().isElementPresent("//span[contains(@class, 'plb-rte-widget-plb_sinput')]"));
		assertEquals("Combo box caption", session().getText("//span[contains(@class, 'plb-rte-widget-plb_sinput')]/span[@class='plb-rte-widget-caption']"));
		
		// edit
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-widgets']/ul[@class='plb-widget-list']/li[contains(@class, 'plb-widget-list-entry-plb_sinput')]/span[@class='buttons']/button[contains(@class, 'edit')]");
		waitForElementVisible("caption");
		assertEquals("Combo box caption", session().getValue("caption"));
		assertEquals("Combo box instruction", session().getValue("instructions"));
		assertEquals("choice one\nchoice two\nchoice three", session().getValue("x-options"));
		assertFalse(session().isChecked("required"));
		session().type("caption", "New combo box caption");
		session().type("instructions", "New combo box instructions");
		session().type("x-options", "choice one\nchoice two\nchoice three\nchoice four");
		session().click("required");
		session().click("//input[@value='Cancel']");
		
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-widgets']/ul[@class='plb-widget-list']/li[contains(@class, 'plb-widget-list-entry-plb_sinput')]/span[@class='buttons']/button[contains(@class, 'edit')]");
		waitForElementVisible("caption");
		assertEquals("Combo box caption", session().getValue("caption"));
		assertEquals("Combo box instruction", session().getValue("instructions"));
		assertEquals("choice one\nchoice two\nchoice three", session().getValue("x-options"));
		assertFalse(session().isChecked("required"));
		session().type("caption", "New combo box caption");
		session().type("instructions", "New combo box instructions");
		session().type("x-options", "choice one\nchoice two\nchoice three\nchoice four");
		session().click("required");
		session().click("//input[@value='Save']");
		
		System.out.println("edit");
		assertEquals("New combo box caption", session().getText("//span[contains(@class, 'plb-rte-widget-plb_sinput')]/span[@class='plb-rte-widget-caption']"));
		session().click("//td[@id='cke_contents_wpTextbox1_sidebar']/div[@class='plb-widgets']/ul[@class='plb-widget-list']/li[contains(@class, 'plb-widget-list-entry-plb_sinput')]/span[@class='buttons']/button[contains(@class, 'edit')]");
		waitForElementVisible("caption");
		assertEquals("New combo box caption", session().getValue("caption"));
		assertEquals("New combo box instructions", session().getValue("instructions"));
		assertEquals("choice one\nchoice two\nchoice three\nchoice four", session().getValue("x-options"));
		assertTrue(session().isChecked("required"));
		session().click("//input[@value='Save']");
	}
	
	public void createLayoutFromArticle() throws Exception {
	}
	
	public void testRemovingHintFromInputOnLayoutPreviewAndArticleCreatePages() throws Exception {
	}
	
	public void testCreateArticleUsingLayout() throws Exception {
	}
	
	public void testEditingLayoutElementsWhenAnArticleExists() throws Exception {
	}
	
	public void testDeletingLayout() throws Exception {
	}
	
	public void testDeletingLayoutWhenArticleExists() throws Exception {
	}
	
	public void testEditingLayoutWhenLayoutHasBeenDeleted() throws Exception {
	}
	
	public void testRevertingLayoutRevision() throws Exception {
	}
	
	public void testSavingLayoutAsDraft() throws Exception {
	}
	
	public void testPublishingLayout() throws Exception {
	}
	
	public void testSwitchingEditorModeAndAddingInputsDoesNotDuplicateInput() throws Exception {
	}
	
	public void testPipeCharacterAsPartOfChoiceItemDoesNotBreakItIntoTwoChoices() throws Exception {
	}
	
	public void testJavaScriptEnteredIntoAnyInputDoesNotEvaluateOnAnyPage() throws Exception {
	}
	
	public void testHandlingWikiMarkup() throws Exception {
	}
	
	private void switchEditorMode(String mode) throws Exception {
		if (isFCK() && !session().getEval("window.RTE.instance.mode").equals(mode)) {
			session().runScript("window.RTE.instance.switchMode('" + mode + "')");
			session().waitForCondition("window.RTE.instance.mode == '" + mode + "'", "7500");
		}
	}
}
