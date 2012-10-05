package com.wikia.webdriver.PageObjects.PageObject;

import static org.testng.AssertJUnit.fail;

import java.util.Date;
import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.NoSuchElementException;
import org.openqa.selenium.Point;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import com.google.common.base.Throwables;
import com.wikia.webdriver.Common.Core.CommonExpectedConditions;
import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;

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

	@FindBy(css="div[class='wikia-bar'] a.tools-customize[data-name='customize']")
	WebElement customizeToolbar_CustomizeButton;
	@FindBy(css="div.msg")
	WebElement customizeToolbar_PageWatchlistStatusMessage;
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
	@FindBy(css="li.mytools.menu")
	WebElement customizeToolbar_MyToolsMenuButton;
	@FindBy(css="ul[id='my-tools-menu']")
	WebElement customizeToolbar_MyToolsMenu;
	
	@FindBy(css="form.WikiaSearch")
	WebElement wikiaSearch_searchForm;
	@FindBy(css="section.modalContent div.UserLoginModal form")
	WebElement modalLoginForm;
	
	private By customizeToolbar_ToolsList = By.cssSelector("ul.tools li");
	private By customizeToolbar_MyToolsList = By.cssSelector("ul[id='my-tools-menu'] a");
	
	
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
	
	public String getCurrentUrl()
	{
		System.out.println(driver.getCurrentUrl());
		return driver.getCurrentUrl();
	}
	
	
	
	/**
	 * Clicks on an element
	 */

	public void click(WebElement pageElem)
	{
		try
		{
			CommonFunctions.scrollToElement(pageElem);
			pageElem.click();
		}
		catch(Exception e)
		{
			
			PageObjectLogging.log("click", Throwables.getStackTraceAsString(e), false);
		}
	}
	/**
	 * Send keys to WebElement
	 */

	public void sendKeys(WebElement pageElem, String KeysToSend)
	{
		try
		{
			pageElem.sendKeys(KeysToSend);			
		}
		catch(Exception e)
		{
			PageObjectLogging.log("sendKeys", e.toString(), false);			
		}
	}
	
	/**
	 * Clicks on an element using Actions click method
	 * 
	 * @author Michal Nowierski
	 * ** @param pageElem The WebElement to be clicked on 
	 */
	public void clickActions(WebElement pageElem)
	{
		try
		{
			Actions builder = new Actions(driver);
			Actions click = builder.click(pageElem);
			click.perform();				
		}
		catch(Exception e)
		{
			PageObjectLogging.log("clickActions", e.toString(), false);			
		}
	}
	
	public void mouseOverInArticleIframe(String cssSelecotr)
	{
		executeScript("$($($('iframe[title*=\"Rich\"]')[0].contentDocument.body).find('"+cssSelecotr+"')).mouseenter()");
		try {
			Thread.sleep(500);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}

	public void mouseReleaseInArticleIframe(String cssSelecotr)
	{
		executeScript("$($($('iframe[title*=\"Rich\"]')[0].contentDocument.body).find('"+cssSelecotr+"')).mouseleave()");
		try {
			Thread.sleep(500);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	public void mouseOver(String cssSelecotr)
	{
		executeScript("$('"+cssSelecotr+"').mouseenter()");
		try {
			Thread.sleep(500);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	public void mouseRelease(String cssSelecotr)
	{
		executeScript("$('"+cssSelecotr+"').mouseleave()");
		try {
			Thread.sleep(500);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	
	public void jQueryClick(String cssSelector)
	{
		executeScript("$('"+cssSelector+"').click()");
	}
	
	public void jQueryFocus(String cssSelector)
	{
		executeScript("$('"+cssSelector+"').focus()");
	}
	
//	public void clickRobot(WebElement pageElem)
//	{
////		try
////		{
//			Point p = pageElem.getLocation();
////			PageObjectLogging.log(p.toString(),p.toString(),p.toString());
//			CommonFunctions.MoveCursorToElement(p);
//			CommonFunctions.ClickElement();
////		}
////		catch(Exception e)
////		{
////			PageObjectLogging.log("clickRobot", e.toString(), false);			
////		}
//	}
	
	
	public void executeScript(String script)
	{
		JavascriptExecutor js = (JavascriptExecutor) driver;
		js.executeScript(script);
		try {
			Thread.sleep(1000);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	protected void executeScript(String script, WebDriver driver)
	{
		JavascriptExecutor js = (JavascriptExecutor) driver;
		js.executeScript(script);
		try {
			Thread.sleep(1000);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	/**
	 * Returns List of WebElements by CssSelector
	 * 
	 * @author Michal Nowierski
	 * ** @param Selector  
	 */
	public List<WebElement> getListOfElementsByCss(String Selector) 
	{
		try
		{
			return driver.findElements(By.cssSelector(Selector));						
		}
		catch(Exception e)
		{
			PageObjectLogging.log("getListOfElementsByCss", e.toString(), false);
			return null;
		}
	}
	/**
	 * Checks if the element is visible on browser
	 *
	 ** @param by The By class defined for the element
	 */
	public void waitForElementByBy(By by)
	{
		try
		{
			wait.until(ExpectedConditions.visibilityOfElementLocated(by));						
		}
		catch(Exception e)
		{
			PageObjectLogging.log("clickActions", e.toString(), false);			
		}
	}
	
	/**
	 * Checks if the element is visible on browser
	 *
	 ** @param element The element to be checked
	 */
	public boolean waitForElementByElement(WebElement element)
	{
		try
		{
			wait.until(ExpectedConditions.visibilityOf(element));	
			return true;
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForElementByElement", e.toString(), false);			
			return false;
		}
	}

	/**
	 * Checks if the element is present in DOM
	 *
	 * @param element The element to be checked
	 */
	public void waitForElementPresenceByBy(By locator)
	{
		try
		{			
			wait.until(ExpectedConditions.presenceOfElementLocated(locator));
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForElementPresenceByBy", e.toString(), false);			
		}
	}
	
	public boolean waitForElementByCss(String cssSelector)
	{
		try
		{						
			wait.until(ExpectedConditions.visibilityOfElementLocated(By.cssSelector(cssSelector)));
			return true;
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForElementByCss", e.toString(), false);
			return false;
		}
		
	}
	
	public void waitForElementByClassName(String className)
	{
		try
		{								
			wait.until(ExpectedConditions.visibilityOfElementLocated(By.className(className)));
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForElementByClassName", e.toString(), false);			
		}
	}
	
	public void waitForElementByClass(String id)
	{
		try
		{								
			wait.until(ExpectedConditions.visibilityOfElementLocated(By.id(id)));
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForElementByClass", e.toString(), false);			
		}
	}
	
	public void waitForElementByXPath(String xPath)
	{
		try
		{
			wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath(xPath)));								
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForElementByXpath", e.toString(), false);			
		}
	}
	
	public void waitForElementNotVisibleByCss(String css)
	{
		try
		{
			wait.until(ExpectedConditions.invisibilityOfElementLocated(By.cssSelector(css)));								
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForElementNotVisibleByCss", e.toString(), false);			
		}
	}
	
	public void waitForElementNotVisibleByBy(By by)
	{
		try
		{
			wait.until(CommonExpectedConditions.invisibilityOfElementLocated(by));								
		}
		catch(NoSuchElementException e)
		{
			PageObjectLogging.log("waitForElementNotVisibleByBy", "Element " + by.getClass() + " is not visible which is expected", true);
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForElementNotVisibleByBy", e.toString(), false);			
		}
	}
	
	public void waitForElementClickableByClassName(String className)
	{
		try
		{
			wait.until(ExpectedConditions.elementToBeClickable(By.className(className)));								
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForElementClickableByClassName", e.toString(), false);			
		}
	}
	
	public void waitForElementClickableByCss(String css)
	{
		try
		{
			wait.until(ExpectedConditions.elementToBeClickable(By.cssSelector(css)));								
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForElementClickAbleByCss", e.toString(), false);			
		}
	}
	
	public void waitForElementClickableByBy(By by)
	{
		try
		{
			wait.until(ExpectedConditions.elementToBeClickable(by));								
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForElementClickableByBy", e.toString(), false);			
		}
	}
	
	public void waitForElementClickableByElement(WebElement element)
	{
		try
		{
			wait.until(CommonExpectedConditions.elementToBeClickable(element));								
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForElementClickableByElement", e.toString(), false);			
		}
	}
	public void waitForElementNotClickableByElement(WebElement element)
	{
		try
		{
			wait.until(CommonExpectedConditions.elementNotToBeClickable(element));								
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForElementNotClickableByElement", e.toString(), false);			
		}
	}
	
	public void waitForElementById(String id)
	{
		try
		{
			wait.until(ExpectedConditions.visibilityOfElementLocated(By.id(id)));								
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForElementById", e.toString(), false);			
		}
	}

	
	
	public void waitForValueToBePresentInElementsAttributeByCss(String selector, String attribute, String value)
	{
		try
		{
			wait.until(CommonExpectedConditions.valueToBePresentInElementsAttribute(By.cssSelector(selector), attribute, value));								
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForValueToBePresentInElementsAttributeByCss", e.toString(), false);			
		}
	}

	public void waitForValueToNotBePresentInElementsAttributeByCss(String selector, String attribute, String value)
	{
		try
		{
			wait.until(CommonExpectedConditions.valueToNotBePresentInElementsAttribute(By.cssSelector(selector), attribute, value));								
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForValueToNotBePresentInElementsAttributeByCss", e.toString(), false);			
		}
	}
	
	public void waitForTextToBePresentInElementByElement(WebElement element, String text)
	{
		try
		{
			wait.until(CommonExpectedConditions.textToBePresentInElement(element, text));								
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForTextToBePresentInElementByElement", e.toString(), false);
		}
		
	}

	public void waitForClassRemovedFromElement(WebElement element, String className)
	{
		try
		{
			wait.until(CommonExpectedConditions.classRemovedFromElement(element, className));								
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForClassRemovedFromElement", e.toString(), false);			
		}
	}

	public void waitForStringInURL(String givenString)
	{
		try
		{								
			wait.until(CommonExpectedConditions.givenStringtoBePresentInURL(givenString));
		}
		catch(Exception e)
		{
			PageObjectLogging.log("waitForStringInURL", e.toString(), false);			
		}
	}
	
	/**
	 * Navigates back to the previous page
	 * 
	 * @author Michal Nowierski
	 */
	public void navigateBack()
	{
		try
		{								
			driver.navigate().back();
		}
		catch(Exception e)
		{
			PageObjectLogging.log("navigateBack", e.toString(), false);			
		}
	}
	
	/**
	 * Verifies that user toolbar buttons are visible
	 */
	public void verifyUserToolBar()
	{
		waitForElementByCss("div.toolbar ul.tools li.overflow");
		waitForElementByCss("div.toolbar ul.tools li.mytools");
		waitForElementByCss("div.toolbar ul.tools li a.tools-customize");
		PageObjectLogging.log("verifyUserToolBar", "user toolbar verified", true, driver);
	}
	
	/**
	 * Clicks on "Customize" button. User must be logged in.
	 * 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_ClickCustomize() {
		waitForElementByElement(customizeToolbar_CustomizeButton);
		waitForElementClickableByElement(customizeToolbar_CustomizeButton);
		click(customizeToolbar_CustomizeButton);
		PageObjectLogging.log("customizeToolbar_ClickCustomize", "Clicks on 'Customize' button.", true, driver);
		
	}
	
	/**
	 * Clicks on "ResetDefaults" button.
	 * 	 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_ClickOnResetDefaults() {
		waitForElementByElement(customizeToolbar_ResetDefaultsButton);
		waitForElementClickableByElement(customizeToolbar_ResetDefaultsButton);
		customizeToolbar_ResetDefaultsButton.click();
		PageObjectLogging.log("customizeToolbar_ClickOnResetDefaults", "Click on 'ResetDefaults' button.", true, driver);
		
	}
	
	/**
	 * Types GivenString to Find A Tool field
	 * 
	 * @param GivenString String to be typed into search field 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_TypeIntoFindATool(String GivenString) {
		waitForElementByElement(customizeToolbar_FindAToolField);
		waitForElementClickableByElement(customizeToolbar_FindAToolField);
		customizeToolbar_FindAToolField.clear();
		customizeToolbar_FindAToolField.sendKeys(GivenString);
		PageObjectLogging.log("customizeToolbar_TypeIntoFindATool", "Type "+GivenString+" into Find A Tool field", true, driver);
		
	}
	
	/**
	 * Types GivenString to Find A Tool field
	 * 
	 * @param GivenString new name for the Tool
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_TypeIntoRenameItemDialog(String GivenString) {
		waitForElementByElement(customizeToolbar_RenameItemDialogInput);
		waitForElementClickableByElement(customizeToolbar_RenameItemDialogInput);
		customizeToolbar_RenameItemDialogInput.clear();
		customizeToolbar_RenameItemDialogInput.sendKeys(GivenString);
		PageObjectLogging.log("customizeToolbar_TypeIntoRenameItemDialog", "Type "+GivenString+" into rename item input", true, driver);
	}
	
	/**
	 * Clicks on "save" button on Rename Item dialog.
	 * 	 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_saveInRenameItemDialog() {
		waitForElementByElement(customizeToolbar_SaveItemDialogInput);
		waitForElementClickableByElement(customizeToolbar_SaveItemDialogInput);
		customizeToolbar_SaveItemDialogInput.click();
		PageObjectLogging.log("customizeToolbar_saveInRenameItemDialog", "Click on 'save' button on Rename Item dialog.", true, driver);
		
	}
	
	/**
	 * Click on a Tool after searching for it
	 * 
	 * @param Tool toolname appearing on the list of found tools
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_ClickOnFoundTool(String Tool) {
		waitForElementByCss("div.autocomplete div[title='"+Tool+"']");
		waitForElementClickableByCss("div.autocomplete div[title='"+Tool+"']");
		driver.findElement(By.cssSelector("div.autocomplete div[title='"+Tool+"']")).click();
		PageObjectLogging.log("customizeToolbar_ClickOnFoundTool", "Click on "+Tool, true, driver);
		
	}
	
	/**
	 * Click on a toolbar tool.
	 * 
	 * @param data-name data-name of the toolbar tool. <br> You should check the data-name of the tool you want to click.
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_ClickOnTool(String Tool_dataname) {
		waitForElementByCss("li.overflow a[data-name='"+Tool_dataname+"']");
		WebElement element = driver.findElement(By.cssSelector("li.overflow a[data-name='"+Tool_dataname+"']"));
		if (Global.BROWSER.equals("IE")) {
			// clicking on parent element of the above 'a' element, because IE couldn't click on the above 'a' element
			// Unfortunately Firefox can't click on this parent element, so the code must be browser-dependent
			WebElement parent = element.findElement(By.xpath(".."));
			waitForElementClickableByElement(parent);
			parent.click();
		}
		else {
			waitForElementClickableByElement(element);
			click(element);
		}
		PageObjectLogging.log("customizeToolbar_ClickOnFoundTool", "Click on "+Tool_dataname, true, driver);
	}
	
	/**
	 * Click on a toolbar tool.
	 * 
	 * @param data-name data-name of the toolbar tool. <br> You should check the data-name of the tool you want to click.
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_VerifyPageWatchlistStatusMessage() {
		waitForElementByElement(customizeToolbar_PageWatchlistStatusMessage);
		PageObjectLogging.log("customizeToolbar_VerifyPageWatchlistStatusMessage", "Verify that the page watchlist status message appeared ", true, driver);
		
	}
	
	/**
	 * Verify that page is followed
	 * The method should be used only after clicking on "follow" button. Before that, "follow" button does not have 'title' attribute which is necessary in the method
	 * 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_VerifyPageFollowed() {
		waitForElementByCss("a[data-name='follow']");
		waitForValueToBePresentInElementsAttributeByCss("a[data-name='follow']", "title", "Unfollow");
		PageObjectLogging.log("customizeToolbar_VerifyPageFollowed", "Verify that page is followed", true, driver);
	
	}
	
	/**
	 * Verify that page is unfollowed
	 * The method should be used only after clicking on "Unfollow" button. Before that, "follow" button does not have 'title' attribute which is necessary in the method
	 * 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_VerifyPageUnfollowed() {
		waitForElementByElement(customizeToolbar_PageWatchlistStatusMessage);
		waitForValueToBePresentInElementsAttributeByCss("a[data-name='follow']", "title", "Follow");
		PageObjectLogging.log("customizeToolbar_VerifyPageUnfollowed", "Verify that page is unfollowed", true, driver);
		
	}
	
	/**
	 * Look up if Tool appears on Toolbar List
	 * 
	 * @param Tool {Follow, Edit, History, (...)} 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_VerifyToolOnToolbarList(String Tool) {
		waitForElementByCss("ul.options-list li[data-caption='"+Tool+"']");
		PageObjectLogging.log("customizeToolbar_VerifyToolOnToolbarList", "Check if "+Tool+" appears on list", true, driver);
	
	}
	
	/**
	 * Look up if Tool does not appear on Toolbar List
	 * 
	 * @param Tool {Follow, Edit, History, (...)} 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_VerifyToolNotOnToolbarList(String Tool) {
		waitForElementByCss("ul.options-list li");
		waitForElementNotVisibleByCss("ul.options-list li[data-caption='"+Tool+"']");
		PageObjectLogging.log("customizeToolbar_VerifyToolNotOnToolbarList", "Check if "+Tool+" does not appear on Toolbar list", true, driver);
	}
	
	/**
	 * Remove a wanted Tool by its data-caption
	 * 
	 * @param Tool ID of tool to be removed. {Follow, Edit, History, (...)} 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_ClickOnToolRemoveButton(String Tool) {
		By By1 = By.cssSelector("ul.options-list li[data-caption='"+Tool+"']");
//		By By2 = By.cssSelector("ul.options-list li[data-caption='"+Tool+"'] img.trash");
//		Point Elem1_location = driver.findElement(By1).getLocation();
//		CommonFunctions.MoveCursorToElement(Elem1_location);
//		waitForElementByBy(By2);
//		waitForElementClickableByBy(By2);
//		driver.findElement(By2).click();
		jQueryClick("ul.options-list li[data-caption=\""+Tool+"\"] img.trash");
		PageObjectLogging.log("customizeToolbar_ClickOnToolRemoveButton", "Remove Tool with id "+Tool+" from Toolbar List", true, driver);
	}
	
	/**
	 * Rename the wanted Tool
	 * 
	 * @param ToolID ID of tool to be removed. {PageAction:Follow, PageAction:Edit, PageAction:History, (...)} 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_ClickOnToolRenameButton(String ToolID) {
		By By1 = By.cssSelector("ul.options-list li[data-caption='"+ToolID+"']");
		waitForElementByBy(By1);
		jQueryClick("ul.options-list li[data-caption=\""+ToolID+"\"] img.edit-pencil");
		PageObjectLogging.log("customizeToolbar_ClickOnToolRenameButton", "Rename the "+ToolID+" Tool", true, driver);
	}
	
	/**
	 * Drag the wanted Tool
	 * 
	 * @param ToolID ID of tool to be dragged. {PageAction:Follow, PageAction:Edit, PageAction:History, (...)}
	 * @param DragDirection The direction of dragging. e.g -1 is 'drop the tool one item below'
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_DragElemAndDrop(String ToolID, int DragDirection) {
		By By1 = By.cssSelector("ul.options-list li[data-caption='"+ToolID+"']");
		By By2 = By.cssSelector("ul.options-list li[data-caption='"+ToolID+"'] img.drag");
		Point Elem1_location = driver.findElement(By1).getLocation();
		CommonFunctions.MoveCursorToElement(Elem1_location);
		waitForElementByBy(By2);
		waitForElementClickableByBy(By2);
		Point Elem2_location = driver.findElement(By2).getLocation();
		CommonFunctions.MoveCursorToElement(Elem2_location);
		if (Global.BROWSER.equals("FF")) {
			// Firefox is unable to drag and drop customize toolbar elements using actions class. Able to do it with robot class
			CommonFunctions.DragFromCurrentCursorPositionAndDrop(0, 25*DragDirection+8);
		}
		else {		
			// Chrome is unable to drag and drop customize toolbar elements using robot class. Able to do it with actions class
			WebElement draggable = driver.findElement(By2); 
			new Actions(driver).dragAndDropBy(draggable, 0, 25*DragDirection+8).perform();  
			
		}
		PageObjectLogging.log("customizeToolbar_DragElemAndDrop", "Drag element "+ToolID+", by "+DragDirection, true, driver);
	}
	
	/**
	 * Check the order of two first tools on My tools list
	 * 
	 * @param tool1 The first tool to appear on My Tools list. {History, What links here, (...)} 
	 * @param tool2 The second tool to appear on My Tools list. {History, What links here, (...)} 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_VerifyMyToolsOrder(String tool1, String tool2) {
		CommonFunctions.MoveCursorTo(0, 100);		
		CommonFunctions.MoveCursorTo(0, 0);		
		waitForElementByElement(customizeToolbar_MyToolsMenuButton);
		Point location = customizeToolbar_MyToolsMenuButton.getLocation();
		try {Thread.sleep(1000);} catch (InterruptedException e) {}
		CommonFunctions.MoveCursorToElement(location);
		waitForElementByElement(customizeToolbar_MyToolsMenu);
		List<WebElement> MyToolsList = driver.findElements(customizeToolbar_MyToolsList);
		String ActualTool1=MyToolsList.get(0).getText();
		String ActualTool2=MyToolsList.get(1).getText();
		if (!tool1.equals(ActualTool1)) {
			PageObjectLogging.log("customizeToolbar_VerifyMyToolsOrder", ActualTool1+" where "+tool1+" should be. Drag & drop action (from previous step) must hadn't been succesful", false, driver);
		}
		if (!tool2.equals(ActualTool2)) {
			PageObjectLogging.log("customizeToolbar_VerifyMyToolsOrder", ActualTool2+" where "+tool2+" should be. Drag & drop action (from previous step) must hadn't been succesful", false, driver);
		}
		PageObjectLogging.log("customizeToolbar_VerifyMyToolsOrder", "Verify that My Tools list has"+tool2+" appearing after "+tool1, true, driver);
	}

	/**
	 * Click on save button on customize toolbar
	 * 
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_ClickOnSaveButton() {
		waitForElementByElement(customizeToolbar_SaveButton);
		waitForElementClickableByElement(customizeToolbar_SaveButton);
		customizeToolbar_SaveButton.click();
		PageObjectLogging.log("customizeToolbar_ClickOnSaveButton", "Click on 'save' button.", true, driver);
		
	}
	
//	/**
//	 * <p> Verify that wanted Tool appears in Toolbar. <br> 
//	 * The method finds all of Tools appearing in Toolbar (by their name), and checks if there is at least one name which fits the given param (ToolName)
//	 * 
//	 * @param ToolName Tool to be verified (name that should appear on toolbar)
//	 * @author Michal Nowierski
//	 */
//	public void customizeToolbar_VerifyToolOnToolbar(String ToolName) {
//		try {Thread.sleep(500);} catch (InterruptedException e) {e.printStackTrace();}
//		waitForElementByBy(customizeToolbar_ToolsList);
//		List<WebElement> List = driver.findElements(customizeToolbar_ToolsList);
//		int amountOfToolsOtherThanTheWantedTool = 0;
//		for (int i = 0; i < List.size(); i++) {
//			if (!driver.findElements(customizeToolbar_ToolsList).get(i).getText().equals(ToolName)) {
//				++amountOfToolsOtherThanTheWantedTool;
//			}
//		}
//		if (amountOfToolsOtherThanTheWantedTool==List.size()) {
//			PageObjectLogging.log("customizeToolbar_VerifyToolOnToolbar",
//					ToolName+" does not appear on toolbar. All of tools are other than the wanted one.", false, driver);
//				fail();
//		}
//		PageObjectLogging.log("customizeToolbar_VerifyToolOnToolbar",
//				"Verify that "+ToolName+" appears in Toolbar.", true, driver);
//	}
	
	public void customizeToolbar_VerifyToolOnToolbar(String ToolName)
	{
		waitForElementByXPath("//ul[@class='tools']//a[contains(text(), '"+ToolName+"')]");
		PageObjectLogging.log("customizeToolbar_VerifyToolOnToolbar","Verify that "+ToolName+" appears in Toolbar.", true, driver);
	}
	
	/**
	 * <p> Verify that wanted Tool appears in Toolbar. <br> 
	 * The method finds all of Tools appearing in Toolbar (by their name), and checks if there is at least one name which fits the given param (ToolName)
	 * 
	 * @param ToolName Tool to be verified (name that should appear on toolbar)
	 * @author Michal Nowierski
	 */
	public void customizeToolbar_UnfollowIfPageIsFollowed() {
		List<WebElement> List = driver.findElements(customizeToolbar_ToolsList);
		for (int i = 0; i < List.size(); i++) {
			if (List.get(i).getText().equals("Following")) {
				customizeToolbar_ClickOnTool("follow");
				customizeToolbar_VerifyPageWatchlistStatusMessage();
				wait.until(ExpectedConditions.textToBePresentInElement(customizeToolbar_ToolsList, "Follow"));
			
			}
		}
		PageObjectLogging.log("customizeToolbar_UnfollowIfPageIsFollowed",
				"If the page is Followed, unfollow it (preconditions assurance)", true, driver);

	}
	
	
	/**
	 * <p> Verify that wanted Tool does not appear in Toolbar. <br> 
	 * The method finds all of Tools appearing in Toolbar (by their name), and checks if there is no tool that fits the given param (ToolName)
	 * 
	 * @param ToolName Tool to be verified (name that should not appear on toolbar)
	 * @author Michal Nowierski
	 */
//	public void customizeToolbar_VerifyToolNotOnToolbar(String ToolName){
//		try {Thread.sleep(500);} catch (InterruptedException e) {e.printStackTrace();}
//		waitForElementByBy(customizeToolbar_ToolsList);
//		List<WebElement> List = driver.findElements(customizeToolbar_ToolsList);
//		int amountOfToolsOtherThanTheWantedTool = 0;
//		for (int i = 0; i < List.size(); i++) {
//			if (!List.get(i).getText().equals(ToolName)) {
//				++amountOfToolsOtherThanTheWantedTool;
//			}
//		}
//		if (amountOfToolsOtherThanTheWantedTool<List.size()) {
//			PageObjectLogging.log("customizeToolbar_VerifyToolNotOnToolbar",
//					ToolName+" Tool appears on toolbar (Not all of tools are other than the wanted one).", false, driver);
//				fail();
//		}
//		PageObjectLogging.log("customizeToolbar_VerifyToolNotOnToolbar",
//				"Verify that "+ToolName+" tool does not appear in Toolbar.", true, driver);
//		
//	}
	
	public void customizeToolbar_VerifyToolNotOnToolbar(String ToolName)
	{
		By tool = By.xpath("//ul[@class='tools']//a[contains(text(), '"+ToolName+"')]");
		waitForElementNotVisibleByBy(tool);
		PageObjectLogging.log("customizeToolbar_VerifyToolNotOnToolbar","Verify that "+ToolName+" tool does not appear in Toolbar.", true, driver);
	}
	
	/**
	 * verify that wikia search field is displayed
	 * 
	 * @author Michal Nowierski
	 */	
	public void verifyWikiaSearchFieldIsDisplayed() {
		waitForElementByElement(wikiaSearch_searchForm);
		PageObjectLogging.log("verifyWikiaSearchFieldIsDisplayed", "verify that wikia search field is displayed", true, driver);
	}
	
	public String getTimeStamp()
	{
		Date time = new Date();
		long timeCurrent = time.getTime();
		return String.valueOf(timeCurrent);
	} 
	
	public void verifyModalLogin()
	{
		waitForElementByElement(modalLoginForm);
		PageObjectLogging.log("verifyModalLogin", "verify modal login form is displayed", true, driver);
	}
} 