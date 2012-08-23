package com.wikia.webdriver.pageObjects.PageObject;

import java.util.Date;
import java.util.List;

import org.junit.internal.runners.statements.Fail;
import org.openqa.selenium.By;
import org.openqa.selenium.NoSuchElementException;
import org.openqa.selenium.Point;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.interactions.internal.Coordinates;
import org.openqa.selenium.internal.Locatable;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import com.wikia.webdriver.Common.Core.CommonExpectedConditions;
import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import static org.testng.AssertJUnit.fail;

/**
 * 
 * @author Karol
 *
 */

public class BasePageObject{

	public final WebDriver driver;
	
	public String wikiFactoryLiveDomain = "http://community.wikia.com/wiki/Special:WikiFactory";
		
	protected int timeOut = 30;
	
	public WebDriverWait wait;

	@FindBy(css="a.tools-customize[data-name='customize']")
	WebElement customizeToolbar_CustomizeButton;
	@FindBy(css="div.search-box input.search")
	WebElement customizeToolbar_FindAToolField;
	@FindBy(css="div.MyToolsRenameItem input.input-box")
	WebElement customizeToolbar_RenameItemDialogInput;
	@FindBy(css="div.MyToolsRenameItem input.save-button")
	WebElement customizeToolbar_SaveItemDialogInput;
	@FindBy(css="input.save-button")
	WebElement customizeToolbar_SaveButton;
	@FindBy(css="span.reset-defaults a")
	WebElement customizeToolbar_ResetDefaultsButton;
	
	private By ToolsList = By.cssSelector("ul.tools li");
	
	public BasePageObject(WebDriver driver)
	{
		this.driver = driver;
		wait = new WebDriverWait(driver, timeOut);
		PageFactory.initElements(driver, this);
		driver.manage().window().maximize();
	}
	

	/**
	 * Checks page title
	 *
	 ** @param title Specifies the title that you want to compare with the actual current title
	 */

	public boolean verifyTitle(String title)
	{
		String currentTitle = driver.getTitle();
		if (!currentTitle.equals(title))
		{
			return false;
		}
		return true;
	}
	
	/**
	 * Checks if the current URL contains the given String
	 *
	 *  @author Michal Nowierski
	 ** @param GivenString 
	 */
	public void verifyURLcontains(String GivenString)
	{
		String currentURL = driver.getCurrentUrl();
		if (currentURL.contains(GivenString))
		{
			PageObjectLogging.log("verifyURLcontains", "current url is the same as expected url", true, driver);
		}
		else
		{
			PageObjectLogging.log("verifyURLcontains", "current url isn't the same as expetced url", false, driver);
		}
	}
	
	/**
	 * Checks if the current URL is the given URL
	 *
	 *  @author Michal Nowierski
	 ** @param GivenURL 
	 */
	public boolean verifyURL(String GivenURL)
	{
		String currentURL = driver.getCurrentUrl();
		if (currentURL.equals(GivenURL))
		{
			PageObjectLogging.log("verifyURL", "Given URL matches actual URL", true, driver);
			return true;
		}
		else {
			PageObjectLogging.log("verifyURL", "Given URL: "+GivenURL+", does not match actual URL: "+currentURL, false, driver);
			return false;
		}
		
	}
	
	
	
	
	/**
	 * Clicks on an element
	 */

	public void click(WebElement pageElem)
	{
		CommonFunctions.scrollToElement(pageElem);
		pageElem.click();
	}
	/**
	 * Send keys to WebElement
	 */

	public void sendKeys(WebElement pageElem, String KeysToSend)
	{
		pageElem.sendKeys(KeysToSend);
	}
	
	/**
	 * Clicks on an element using Actions click method
	 * 
	 * @author Michal Nowierski
	 * ** @param pageElem The WebElement to be clicked on 
	 */
	public void clickActions(WebElement pageElem)
	{
		Actions builder = new Actions(driver);
		Actions click = builder.click(pageElem);
		click.perform();
		
	}
	
	/**
	 * Returns List of WebElements by CssSelector
	 * 
	 * @author Michal Nowierski
	 * ** @param Selector  
	 */
	public List<WebElement> getListOfElementsByCss(String Selector) {
	
		return driver.findElements(By.cssSelector(Selector));
	}
	/**
	 * Checks if the element is visible on browser
	 *
	 ** @param by The By class defined for the element
	 */
	public void waitForElementByBy(By by)
	{
		wait.until(ExpectedConditions.visibilityOfElementLocated(by));
	}
	
	/**
	 * Checks if the element is visible on browser
	 *
	 ** @param element The element to be checked
	 */
	public void waitForElementByElement(WebElement element)
	{
		wait.until(ExpectedConditions.visibilityOf(element));
	}
	
	public void waitForElementByCss(String cssSelector)
	{
		
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.cssSelector(cssSelector)));
	}
	
	public void waitForElementByClassName(String className)
	{
		
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.className(className)));
	}
	
	public void waitForElementByClass(String id)
	{
		
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.id(id)));
	}
	
	public void waitForElementByXPath(String xPath)
	{
		
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath(xPath)));
	}
	
	
	
	public void waitForElementNotVisibleByCss(String css)
	{

		wait.until(ExpectedConditions.invisibilityOfElementLocated(By.cssSelector(css)));
	}
	
	public void waitForElementNotVisibleByBy(By by)
	{
		wait.until(ExpectedConditions.invisibilityOfElementLocated(by));
	}
	
	public void waitForElementClickableByClassName(String className)
	{
		wait.until(ExpectedConditions.elementToBeClickable(By.className(className)));
	}
	
	public void waitForElementClickableByCss(String css)
	{
		wait.until(ExpectedConditions.elementToBeClickable(By.cssSelector(css)));
	}
	
	public void waitForElementClickableByBy(By by)
	{
		wait.until(ExpectedConditions.elementToBeClickable(by));
	}
	
	public void waitForElementClickableByElement(WebElement element)
	{
		wait.until(CommonExpectedConditions.elementToBeClickable(element));
	}
	
	public void waitForElementById(String id)
	{
		
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.id(id)));
	}
	public void waitForValueToBePresentInElementsAttributeByCss(String selector, String attribute,
			String value) {
		wait.until(CommonExpectedConditions.valueToBePresentInElementsAttribute(By.cssSelector(selector), attribute, value));
		
	}

	public void waitForStringInURL(String givenString) {
		wait.until(CommonExpectedConditions.givenStringtoBePresentInURL(givenString));
		
	}
	
	/**
	 * Navigates back to the previous page
	 * 
	 * @author Michal Nowierski
	 */
	public void navigateBack() {
		driver.navigate().back();
	}
	
	public void verifyUserToolBar()
	{
		waitForElementByCss("div.toolbar ul.tools li.overflow");
		waitForElementByCss("div.toolbar ul.tools li.mytools");
		waitForElementByCss("div.toolbar ul.tools li a.tools-customize");
	}
	
	/**
	 * Clicks on "Customize" button. User must be logged in.
	 * 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_ClickCustomize() {
		PageObjectLogging.log("customizeToolbar_ClickCustomize", "Clicks on 'Customize' button.", true, driver);
		waitForElementByElement(customizeToolbar_CustomizeButton);
		waitForElementClickableByElement(customizeToolbar_CustomizeButton);
		customizeToolbar_CustomizeButton.click();
		
	}
	
	/**
	 * Clicks on "ResetDefaults" button.
	 * 	 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_ClickOnResetDefaults() {
		PageObjectLogging.log("customizeToolbar_ClickOnResetDefaults", "Click on 'ResetDefaults' button.", true, driver);
		waitForElementByElement(customizeToolbar_ResetDefaultsButton);
		waitForElementClickableByElement(customizeToolbar_ResetDefaultsButton);
		customizeToolbar_ResetDefaultsButton.click();
		
	}
	
	/**
	 * Types GivenString to Find A Tool field
	 * 
	 * @param GivenString String to be typed into search field 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_TypeIntoFindATool(String GivenString) {
		PageObjectLogging.log("customizeToolbar_TypeIntoFindATool", "Type "+GivenString+" into Find A Tool field", true, driver);
		waitForElementByElement(customizeToolbar_FindAToolField);
		waitForElementClickableByElement(customizeToolbar_FindAToolField);
		customizeToolbar_FindAToolField.clear();
		customizeToolbar_FindAToolField.sendKeys(GivenString);
		
	}
	
	/**
	 * Types GivenString to Find A Tool field
	 * 
	 * @param GivenString new name for the Tool
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_TypeIntoRenameItemDialog(String GivenString) {
		PageObjectLogging.log("customizeToolbar_TypeIntoRenameItemDialog", "Type "+GivenString+" into Find A Tool field", true, driver);
		waitForElementByElement(customizeToolbar_RenameItemDialogInput);
		waitForElementClickableByElement(customizeToolbar_RenameItemDialogInput);
		customizeToolbar_RenameItemDialogInput.clear();
		customizeToolbar_RenameItemDialogInput.sendKeys(GivenString);
	}
	
	/**
	 * Clicks on "save" button on Rename Item dialog.
	 * 	 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_saveInRenameItemDialog() {
		PageObjectLogging.log("customizeToolbar_saveInRenameItemDialog", "Click on 'save' button on Rename Item dialog.", true, driver);
		waitForElementByElement(customizeToolbar_SaveItemDialogInput);
		waitForElementClickableByElement(customizeToolbar_SaveItemDialogInput);
		customizeToolbar_SaveItemDialogInput.click();
		
	}
	
	/**
	 * Click on a Tool after searching for it
	 * 
	 * @param Tool toolname appearing on the list of found tools
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_ClickOnFoundTool(String Tool) {
		PageObjectLogging.log("customizeToolbar_ClickOnFoundTool", "Click on "+Tool, true, driver);
		waitForElementByCss("div.autocomplete div[title='"+Tool+"']");
		waitForElementClickableByCss("div.autocomplete div[title='"+Tool+"']");
		driver.findElement(By.cssSelector("div.autocomplete div[title='"+Tool+"']")).click();
		
	}
	
	/**
	 * Click on a toolbar tool.
	 * 
	 * @param data-name data-name of the toolbar tool. <br> You should check the data-name of the tool you want to click.
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_ClickOnTool(String Tool_dataname) {
		PageObjectLogging.log("customizeToolbar_ClickOnFoundTool", "Click on "+Tool_dataname, true, driver);
		waitForElementByCss("li.overflow a[data-name='"+Tool_dataname+"']");
		waitForElementClickableByCss("li.overflow a[data-name='"+Tool_dataname+"']");
		driver.findElement(By.cssSelector("li.overflow a[data-name='"+Tool_dataname+"']")).click();
		
	}
	/**
	 * Look up if Tool appears on Toolbar List
	 * 
	 * @param Tool {Follow, Edit, History, (...)} 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_VerifyToolOnToolbarList(String Tool) {
		PageObjectLogging.log("customizeToolbar_VerifyToolOnToolbarList", "Check if "+Tool+" appears", true, driver);
		waitForElementByCss("ul.options-list li[data-caption='"+Tool+"']");
	
	}
	
	/**
	 * Look up if Tool does not appear on Toolbar List
	 * 
	 * @param Tool {Follow, Edit, History, (...)} 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_VerifyToolNotOnToolbarList(String Tool) {
		PageObjectLogging.log("customizeToolbar_VerifyToolNotOnToolbarList", "Check if "+Tool+" does not appear on Toolbar list", true, driver);
		waitForElementByCss("ul.options-list li");
		waitForElementNotVisibleByCss("ul.options-list li[data-caption='"+Tool+"']");
	}
	
	/**
	 * Remove a wanted Tool by its data-caption
	 * 
	 * @param Tool ID of tool to be removed. {Follow, Edit, History, (...)} 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_ClickOnToolRemoveButton(String Tool) {
		PageObjectLogging.log("customizeToolbar_ClickOnToolRemoveButton", "Remove Tool with id "+Tool+" from Toolbar List", true, driver);
		By By1 = By.cssSelector("ul.options-list li[data-caption='"+Tool+"']");
		By By2 = By.cssSelector("ul.options-list li[data-caption='"+Tool+"'] img.trash");
		Point Elem1_location = driver.findElement(By1).getLocation();
		moveCursorToElem1UntilElem2IsVisible(Elem1_location, By2);
		waitForElementByBy(By2);
		waitForElementClickableByBy(By2);
		driver.findElement(By2).click();
	}
	
	/**
	 * Rename the wanted Tool
	 * 
	 * @param ToolID ID of tool to be removed. {PageAction:Follow, PageAction:Edit, PageAction:History, (...)} 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_ClickOnToolRenameButton(String ToolID) {
		PageObjectLogging.log("customizeToolbar_ClickOnToolRenameButton", "Rename the wanted "+ToolID+" Tool", true, driver);
		By By1 = By.cssSelector("ul.options-list li[data-caption='"+ToolID+"']");
		By By2 = By.cssSelector("ul.options-list li[data-caption='"+ToolID+"'] img.edit-pencil");
		Point Elem1_location = driver.findElement(By1).getLocation();
		moveCursorToElem1UntilElem2IsVisible(Elem1_location, By2);
		waitForElementByBy(By2);
		waitForElementClickableByBy(By2);
		driver.findElement(By2).click();
	}

	/**
	 * Click on save button on customize toolbar
	 * 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_ClickOnSaveButton() {
		PageObjectLogging.log("customizeToolbar_ClickOnSaveButton", "Click on save button on customize toolbar.", true, driver);
		waitForElementByElement(customizeToolbar_SaveButton);
		waitForElementClickableByElement(customizeToolbar_SaveButton);
		customizeToolbar_SaveButton.click();
		
	}
	
	/**
	 * <p> Verify that wanted Tool appears in Toolbar. <br> 
	 * The method finds all of Tools appearing in Toolbar (by their name), and checks if there is at least one name which fits the given param (ToolName)
	 * 
	 * @param ToolName Tool to be verified (name that should appear on toolbar)
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_VerifyToolOnToolbar(String ToolName) {
		PageObjectLogging.log("customizeToolbar_VerifyToolOnToolbar",
				"Verify that "+ToolName+" appears in Toolbar.", true, driver);
		List<WebElement> List = driver.findElements(ToolsList);
		int amountOfToolsOtherThanTheWantedTool = 0;
		for (int i = 0; i < List.size(); i++) {
			if (!List.get(i).getText().equals(ToolName)) {
				++amountOfToolsOtherThanTheWantedTool;
			}
		}
		if (amountOfToolsOtherThanTheWantedTool==List.size()) {
			PageObjectLogging.log("customizeToolbar_VerifyToolOnToolbar",
					ToolName+" does not appear on toolbar. All of tools are other than the wanted one.", false, driver);
				fail();
		}
	}
	
	/**
	 * <p> Verify that wanted Tool does not appear in Toolbar. <br> 
	 * The method finds all of Tools appearing in Toolbar (by their name), and checks if there is no tool that fits the given param (ToolName)
	 * 
	 * @param ToolName Tool to be verified (name that should not appear on toolbar)
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_VerifyToolNotOnToolbar(String ToolName){
		PageObjectLogging.log("customizeToolbar_VerifyToolNotOnToolbar",
				"Verify that "+ToolName+" tool does not appear in Toolbar.", true, driver);
		waitForElementByBy(ToolsList);
		List<WebElement> List = driver.findElements(ToolsList);
		int amountOfToolsOtherThanTheWantedTool = 0;
		for (int i = 0; i < List.size(); i++) {
			if (!List.get(i).getText().equals(ToolName)) {
				++amountOfToolsOtherThanTheWantedTool;
			}
		}
		if (amountOfToolsOtherThanTheWantedTool<List.size()) {
			PageObjectLogging.log("customizeToolbar_VerifyToolNotOnToolbar",
					ToolName+" Tool appears on toolbar (Not all of tools are other than the wanted one).", false, driver);
				fail();
		}
	}
	
	public String getTimeStamp()
	{
		Date time = new Date();
		long timeCurrent = time.getTime();
		return String.valueOf(timeCurrent);
		
	}
	
	/**
	 * Method moves cursor down from location of Element1 until that action makes the wanted Element2 visible <br> 
	 * When the cursor reaches bottom of window, it moves to right and starts going down again
	 * 
	 * @param location1 Element1Location to start moving cursor from
	 * @param By2 Element2 to be visible at some point after moving the cursor
	 * @author Michal Nowierski
	 */
	public void moveCursorToElem1UntilElem2IsVisible(Point location1, By By2) {
			
		PageObjectLogging.log("moveCursorToEleme1UntilElem2IsVisible",
				"move cursor down from Element1 until that action makes the wanted Element2 visible", true, driver);
		location1 = location1.moveBy(15, 0);
		CommonFunctions.MoveCursorTo(location1.getX(), location1.getY());
		ChangeLocationUntilElemVisible(location1, location1, By2);		
		
	}
	
	/**
	 * The method is engine for moving the cursor <br>
	 * The method is recursive <br> 
	 * The method is used by moveCursorToEleme1UntilElem2IsVisible 
	 *  
	 * @param location Location of element to start moving cursor from
	 * @param OriginalLocation The same location, but this parameter won't be changed inside the method
	 * @param By Element to be visible at some point after moving the cursor
	 * 
	 * @author Michal Nowierski
	 */
	private boolean ChangeLocationUntilElemVisible(Point location, Point OriginalLocation, By by) {
	try {
			if (driver.findElement(by).isDisplayed()) {
				return true;
			}
			else {
				location = location.moveBy(0, 5);
				CommonFunctions.MoveCursorTo(location.getX(), location.getY());
				int WindowHeight = driver.manage().window().getSize().height;
				int WindowWidth = driver.manage().window().getSize().width;
				if (location.getX() > WindowWidth) {
					return false;
				}
				if (location.getY() > WindowHeight) {
					location = OriginalLocation.moveBy(10, 0);
					ChangeLocationUntilElemVisible(location, location, by);				
				}
				return ChangeLocationUntilElemVisible(location, OriginalLocation, by);
				
			}

		} 
		catch (NoSuchElementException e) {
			location = location.moveBy(0, 5);
			CommonFunctions.MoveCursorTo(location.getX(), location.getY());
			int WindowHeight = driver.manage().window().getSize().height;
			int WindowWidth = driver.manage().window().getSize().width;
			if (location.getX() > WindowWidth) {
				return false;
			}
			if (location.getY() > WindowHeight) {
				location = OriginalLocation.moveBy(10, 0);
				ChangeLocationUntilElemVisible(location, location, by);	
			}
			return ChangeLocationUntilElemVisible(location, OriginalLocation, by);
		}
	}
	
	
	

	
    
} 