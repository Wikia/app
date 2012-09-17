package com.wikia.webdriver.Common.Core;

import java.awt.AWTException;
import java.awt.GraphicsEnvironment;
import java.awt.MouseInfo;
import java.awt.Rectangle;
import java.awt.Robot;
import java.awt.event.InputEvent;

import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.Point;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;
import org.testng.Assert;

import com.wikia.webdriver.Common.DriverProvider.DriverProvider;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.Common.Properties.Properties;

public class CommonFunctions 
{
	static By logInAjax = By.className("ajaxLogin");
	static By userNameField = By.xpath("//div[@class='input-group required   ']/input[@name='username']");
	static By passwordField = By.xpath("//div[@class='input-group required   ']/input[@name='password']");
	static By remeberMeCheckBox = By.cssSelector("input[type=checkbox]");
	static By submitButton = By.cssSelector("input[type='submit']");
	
	private static WebDriver driver;
	private static WebDriverWait wait;
	
//	public CommonFunctions() 
//	{
//		driver   = DriverProvider.getWebDriver();
//		wait = new WebDriverWait(driver, 30);
//	}		
	
	
	/**
	 * log in by overlay available from main menu
	 * @param userName
	 * @param password
	 * @author: Karol Kujawiak
	 */
	
	public static void logIn(String userName, String password)
	{
		driver   = DriverProvider.getWebDriver();
		wait = new WebDriverWait(driver, 30);
		WebElement logInAjaxElem = driver.findElement(logInAjax);
		logInAjaxElem.click();
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("input[name='username']")));
		WebElement userNameFieldElem = driver.findElement(userNameField);
		userNameFieldElem.sendKeys(userName);
		try {
			Thread.sleep(500);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		WebElement passwordFieldElem = driver.findElement(passwordField);
		passwordFieldElem.sendKeys(password);
		WebElement submitButtonElem = driver.findElement(submitButton);
		submitButtonElem.click();
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("a[href*='/User:"+userName+"']")));		
	}
	
	/**
	 * log in by overlay available from main menu
	 * @param userName
	 * @param password
	 * @author: Karol Kujawiak
	 */
	
	public static void logInDriver(String userName, String password, WebDriver driver)
	{
		wait = new WebDriverWait(driver, 30);
		WebElement logInAjaxElem = driver.findElement(logInAjax);
		logInAjaxElem.click();
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("input[name='username']")));
		WebElement userNameFieldElem = driver.findElement(userNameField);
		userNameFieldElem.sendKeys(userName);
		try {
			Thread.sleep(500);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		WebElement passwordFieldElem = driver.findElement(passwordField);
		passwordFieldElem.sendKeys(password);
		WebElement submitButtonElem = driver.findElement(submitButton);
		submitButtonElem.click();
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("a[href*='/User:"+userName+"']")));		
	}
	
	/**
	 * log in by overlay available from main menu
	 * @param userName
	 * @param password
	 * @author: Karol Kujawiak
	 */
	
	public static void logIn(String userName, String password, WebDriver driver)
	{
		wait = new WebDriverWait(driver, 30);
		WebElement logInAjaxElem = driver.findElement(logInAjax);
		logInAjaxElem.click();
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("input[name='username']")));
		WebElement userNameFieldElem = driver.findElement(userNameField);
		userNameFieldElem.sendKeys(userName);
		try {
			Thread.sleep(500);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		WebElement passwordFieldElem = driver.findElement(passwordField);
		passwordFieldElem.sendKeys(password);
		WebElement submitButtonElem = driver.findElement(submitButton);
		submitButtonElem.click();
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("a[href*='/User:"+userName+"']")));		
	}
	
	/**
	 * 
	 * @param userName
	 * @author: Karol Kujawiak
	 */
	public static void logOut(String userName, WebDriver driver)
	{
		wait = new WebDriverWait(driver, 30);
		driver.get(Global.LIVE_DOMAIN+"wiki/Special:UserLogout?returnto=User "+userName);
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.cssSelector("$('a[data-id='login']')")));
	}
	

	
	
	/**
	 * log in by overlay available from main menu, using generic credentials
	 * @author: Karol Kujawiak
	 */
	public static void logIn()
	{
		driver   = DriverProvider.getWebDriver();
		wait = new WebDriverWait(driver, 30);
		WebElement logInAjaxElem = driver.findElement(logInAjax);
		logInAjaxElem.click();
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("input[name='username']")));
		WebElement userNameFieldElem = driver.findElement(userNameField);
		userNameFieldElem.sendKeys(Properties.userName);
		WebElement passwordFieldElem = driver.findElement(passwordField);
		passwordFieldElem.sendKeys(Properties.password);
		WebElement submitButtonElem = driver.findElement(submitButton);
		submitButtonElem.click();
		wait.until(ExpectedConditions.invisibilityOfElementLocated(By.cssSelector("header#WikiaHeader a.ajaxLogin")));
		wait.until(ExpectedConditions.invisibilityOfElementLocated(By.cssSelector("header#WikiaHeader a.ajaxRegister")));
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("a[href*='/User:"+Properties.userName+"']")));
		PageObjectLogging.log("logIn ", "Normal user logged in", true, driver);
	}
	
	
	/**
	 * log in by overlay available from main menu, using generic credentials with stay logged in check-box checked
	 * @author: Karol Kujawiak
	 */
	public static void logInRememberMe()
	{
		driver   = DriverProvider.getWebDriver();
		wait = new WebDriverWait(driver, 30);
		WebElement logInAjaxElem = driver.findElement(logInAjax);
		logInAjaxElem.click();
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("input[name='username']")));
		WebElement userNameFieldElem = driver.findElement(userNameField);
		userNameFieldElem.sendKeys(Properties.userName);
		WebElement passwordFieldElem = driver.findElement(passwordField);
		passwordFieldElem.sendKeys(Properties.password);
		WebElement rememberMeCheckBox = driver.findElement(remeberMeCheckBox);
		rememberMeCheckBox.click();
		WebElement submitButtonElem = driver.findElement(submitButton);
		submitButtonElem.click();
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("a[href*='/User:"+Properties.userName+"']")));
		PageObjectLogging.log("logIn ", "Normal user logged in", true, driver);
	}
	
	/**
	 * Obsolete below method - should be fixed
	 * */
	
	public static void logInAsStaff()
	{
		driver   = DriverProvider.getWebDriver();
		wait = new WebDriverWait(driver, 30);
		WebElement logInAjaxElem = driver.findElement(logInAjax);
		logInAjaxElem.click();
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("input[name='username']")));
		WebElement userNameFieldElem = driver.findElement(userNameField);
		userNameFieldElem.sendKeys(Properties.userNameStaff);
		WebElement passwordFieldElem = driver.findElement(passwordField);
		passwordFieldElem.sendKeys(Properties.passwordStaff);
		WebElement submitButtonElem = driver.findElement(submitButton);
		submitButtonElem.click();
		wait.until(ExpectedConditions.invisibilityOfElementLocated(By.cssSelector("header#WikiaHeader a.ajaxLogin")));
		wait.until(ExpectedConditions.invisibilityOfElementLocated(By.cssSelector("header#WikiaHeader a.ajaxRegister")));
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("a[href*='/User:"+Properties.userNameStaff+"']")));
		PageObjectLogging.log("logInAsStaff ", "Staff user logged in", true, driver);
	}
	
	
	/**
	 * verifies whether pattern and current string are the same and log to log file
	 * @param pattern
	 * @param current
	 * @author: Karol Kujawiak
	 */
	public static void assertString(String pattern, String current)
	{
		
		try
		{
			Assert.assertEquals(pattern, current);
			PageObjectLogging.log("assertString", "pattern string: "+pattern+" <br/>current string: "+current+"<br/>are the same", true);
		}
		catch(AssertionError e)
		{
			PageObjectLogging.log("assertString", "pattern string: "+pattern+" <br/>current string: "+current+"<br/>are different", false);
		}
	}
	
	/**
	 * Verify actual number is the same as expected number
	 * @param aNumber
	 * @param secondNumber
	 * @author: Piotr Gabryjeluk
	 */
	public static void assertNumber(Number expected, Number actual, String message)
	{
		try
		{
			Assert.assertEquals(expected, actual);
			PageObjectLogging.log("assertNumber", message + ", expected: " + expected + ", got: " + actual, true);
		}
		catch(AssertionError e)
		{
			PageObjectLogging.log("assertNumber", message + ", expected: " + expected + ", got: " + actual, false);
		}
	}

	/**
	 * 
	 * @param attributeName
	 * @return
	 * @author: Karol Kujawiak
	 */
	public static String currentlyFocusedGetAttributeValue(String attributeName)
	{
		
		String currentlyFocusedName = getCurrentlyFocused().getAttribute(attributeName);
		return currentlyFocusedName;
	}
	
	/**
	 * 
	 * @param element
	 * @param attributeName
	 * @return
	 * @author: Karol Kujawiak
	 */
	public static String getAttributeValue(WebElement element, String attributeName)
	{
		driver   = DriverProvider.getWebDriver();
		wait = new WebDriverWait(driver, 30);
		return element.getAttribute(attributeName);
	}
	
	
	
	/**
	 * 
	 * @return 
	 * author: Karol Kujawiak
	 */
	public static WebElement getCurrentlyFocused()
	{
		driver   = DriverProvider.getWebDriver();
		wait = new WebDriverWait(driver, 30);
		return driver.switchTo().activeElement();
	}
	/**
	 * Scroll to the given element
	 * <p> This mehtod is used mostly because Chrome does not scroll to elements automaticly (18 july 2012)
	 * <p> This method uses JavascriptExecutor
	 * 
	 * @author Michal Nowierski
	 * @param element Webelement to be scrolled to
	*/
	public static void scrollToElement(WebElement element) 
	{
		driver   = DriverProvider.getWebDriver();
		wait = new WebDriverWait(driver, 30);
		int y = element.getLocation().getY();
			//firstly make sure that window scroll is set at the top of browser (if not method will scroll up)
			((JavascriptExecutor)driver).executeScript("window.scrollBy(0,-3000);");
			((JavascriptExecutor)driver).executeScript("window.scrollBy(0,"+y+");");
		}
	/**
	 * Move cursor to the given X and Y coordinates
	 * 
	 * @author Michal Nowierski
	 * @param x 
	 * @param y 
	*/
	public static void MoveCursorTo(int x, int y)
	{
		Robot robot = null;
		try {
			Thread.sleep(1000);
			robot = new Robot();
		} catch (AWTException e) {
			e.printStackTrace();
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	   robot.mouseMove(x,y);
	}
	
	/**
	 * Move cursor to Element existing in default DOM, by its Location
	 * 
	 * @author Michal Nowierski
	 * @param elem1_location Location of WebElement (getLocation method)
	 */
	public static void MoveCursorToElement(Point elem1_location) {
//		Toolkit toolkit =  Toolkit.getDefaultToolkit ();
//		Dimension dim = toolkit.getScreenSize();
//		double ScreenHeight = dim.getHeight();
	
//		int FireFoxStatusBarHeight = 20;
		driver   = DriverProvider.getWebDriver();
		int pixDiff = 0;
		if (Global.BROWSER.equals("FF")) {		
			pixDiff = 6;
		}
		int elem_Y = elem1_location.getY();
		int elem_X = elem1_location.getX();
		
		
		Rectangle maxBounds = GraphicsEnvironment.getLocalGraphicsEnvironment().getMaximumWindowBounds();
		int ScreenHeightWithoutTaskBarHeight = maxBounds.height;
		JavascriptExecutor js = (JavascriptExecutor) driver;
		Object visibleDomHeightJS = js.executeScript("return $(window).height()");
		int VisibleDomHeight = Integer.parseInt(visibleDomHeightJS.toString());
		
		Object invisibleUpperDomHeightJS = js.executeScript("return document.documentElement.scrollTop");
		int invisibleUpperDomHeight = Integer.parseInt(invisibleUpperDomHeightJS.toString());
		MoveCursorTo(elem_X+10, elem_Y+ScreenHeightWithoutTaskBarHeight-VisibleDomHeight-pixDiff+1-invisibleUpperDomHeight);
	}
	
	
	public static void MoveCursorToElement(Point elem1_location, WebDriver driver) {
//		Toolkit toolkit =  Toolkit.getDefaultToolkit ();
//		Dimension dim = toolkit.getScreenSize();
//		double ScreenHeight = dim.getHeight();
	
//		int FireFoxStatusBarHeight = 20;
		
		int pixDiff = 0;
		if (Global.BROWSER.equals("FF")) {		
			pixDiff = 6;
		}
		int elem_Y = elem1_location.getY();
		int elem_X = elem1_location.getX();
		
		
		Rectangle maxBounds = GraphicsEnvironment.getLocalGraphicsEnvironment().getMaximumWindowBounds();
		int ScreenHeightWithoutTaskBarHeight = maxBounds.height;
		JavascriptExecutor js = (JavascriptExecutor) driver;
		Object visibleDomHeightJS = js.executeScript("return window.innerHeight");
		int VisibleDomHeight = Integer.parseInt(visibleDomHeightJS.toString());	
		Object invisibileUpperDomHeightJS = js.executeScript("return window.pageYOffset");
		int invisibileUpperDomHeight = Integer.parseInt(invisibileUpperDomHeightJS.toString());
		
		MoveCursorTo(elem_X+10, elem_Y+ScreenHeightWithoutTaskBarHeight-VisibleDomHeight-invisibileUpperDomHeight-pixDiff+1);
	}
	
	/**
	 * Move cursor to Element existing in an IFrame DOM, by its By locator, and the Iframe Webelement
	 * 
	 * @author Michal Nowierski
	 * @param IframeElemBy By selector of element to be hovered over
	 * @param IFrame IFrame where the element exists
	 */
	public static void MoveCursorToIFrameElement(By IframeElemBy, WebElement IFrame){
		driver   = DriverProvider.getWebDriver();
		Point IFrameLocation = IFrame.getLocation();
		driver.switchTo().frame(IFrame);
		wait.until(ExpectedConditions.visibilityOfElementLocated(IframeElemBy));
		Point IFrameElemLocation = driver.findElement(IframeElemBy).getLocation();
		IFrameElemLocation = IFrameElemLocation.moveBy(IFrameLocation.getX(), IFrameLocation.getY());
		driver.switchTo().defaultContent();
		MoveCursorToElement(IFrameElemLocation);
	}
	
	public static void ClickElement() 
	{
		Robot robot = null;
		try {
			Thread.sleep(300);
			robot = new Robot();
		} catch (AWTException e) {
			e.printStackTrace();
		} catch (InterruptedException e) {
			e.printStackTrace();
		}
	   robot.mousePress(InputEvent.BUTTON1_MASK);
	   robot.mouseRelease(InputEvent.BUTTON1_MASK);
	}

	/**
	 * Move cursor to from current position by given x and y
	 * 
	 * @author Michal Nowierski
	 * @param x horrizontal move
	 * @param y	vertical move
	 */
	public static void DragFromCurrentCursorPositionAndDrop(int x, int y) {
		Robot robot = null;
		try {
			robot = new Robot();
		} catch (AWTException e) {
			e.printStackTrace();
		}
		java.awt.Point CurrentCursorPosition = MouseInfo.getPointerInfo().getLocation();
		int currentX = (int) CurrentCursorPosition.getX();
		int currentY = (int) CurrentCursorPosition.getY();
		robot.mousePress(InputEvent.BUTTON1_MASK);
		robot.mouseMove(currentX+x, currentY+y);
		robot.mouseRelease(InputEvent.BUTTON1_MASK);
	}
	
	
	public static void removeChatModeratorRights(String userName, WebDriver driver)
	{
		driver.get(Global.DOMAIN + "wiki/Special:UserRights?user="+userName);
		PageObjectLogging.log("enterUserRightsPage", "user rights page opened", true);
		WebElement chatModeratorChkbox = driver.findElement((By.cssSelector("input#wpGroup-chatmoderator")));
		WebElement submitButton = driver.findElement((By.cssSelector("input[title='[alt-shift-s]']")));
		chatModeratorChkbox.click();
		submitButton.click();
	}
	
	
	

}
