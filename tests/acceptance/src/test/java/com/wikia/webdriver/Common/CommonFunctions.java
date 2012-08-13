package com.wikia.webdriver.Common;

import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;
import org.testng.Assert;

import com.wikia.webdriver.DriverProvider.DriverProvider;
import com.wikia.webdriver.Logging.PageObjectLogging;
import com.wikia.webdriver.pageObjects.PageObject.BasePageObject;

public class CommonFunctions 
{
	static By logInAjax = By.className("ajaxLogin");
	static By userNameField = By.xpath("//div[@class='input-group required   ']/input[@name='username']");
	static By passwordField = By.xpath("//div[@class='input-group required   ']/input[@name='password']");
	static By submitButton = By.cssSelector("input[type='submit']");
			
	private static WebDriver driver = DriverProvider.getWebDriver();
	private static WebDriverWait wait = new WebDriverWait(driver, 30);
	
	public static void logIn(String userName, String password)
	{
		WebElement logInAjaxElem = driver.findElement(logInAjax);
		logInAjaxElem.click();
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("input[name='username']")));
		WebElement userNameFieldElem = driver.findElement(userNameField);
		userNameFieldElem.sendKeys(userName);
		WebElement passwordFieldElem = driver.findElement(passwordField);
		passwordFieldElem.sendKeys(password);
		WebElement submitButtonElem = driver.findElement(submitButton);
		submitButtonElem.click();
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("a[href*='/wiki/User:"+userName+"']")));		
	}
	
	public static void logOut(String userName)
	{
		driver.get("http://community.wikia.com/wiki/Special:UserLogout?returnto=User "+userName);	
	}
	

	
	
	
	public static void logIn()
	{
		WebElement logInAjaxElem = driver.findElement(logInAjax);
		logInAjaxElem.click();
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("input[name='username']")));
		WebElement userNameFieldElem = driver.findElement(userNameField);
		userNameFieldElem.sendKeys(BasePageObject.userName);
		WebElement passwordFieldElem = driver.findElement(passwordField);
		passwordFieldElem.sendKeys(BasePageObject.password);
		WebElement submitButtonElem = driver.findElement(submitButton);
		submitButtonElem.click();
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("a[href*='/wiki/User:"+BasePageObject.userName+"']")));
		PageObjectLogging.log("logIn ", "Normal user logged in", true, driver);
	}
	
	public static void logInAsStaff()
	{
		WebElement logInAjaxElem = driver.findElement(logInAjax);
		logInAjaxElem.click();
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("input[name='username']")));
		WebElement userNameFieldElem = driver.findElement(userNameField);
		userNameFieldElem.sendKeys(BasePageObject.userNameStaff);
		WebElement passwordFieldElem = driver.findElement(passwordField);
		passwordFieldElem.sendKeys(BasePageObject.passwordStaff);
		WebElement submitButtonElem = driver.findElement(submitButton);
		submitButtonElem.click();
//		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("a[href='/wiki/User:"+BasePageObject.userNameStaff+"']")));
		PageObjectLogging.log("logInAsStaff ", "Staff user logged in", true, driver);
	}
	
	public static void assertString(String pattern, String current)
	{
//		if (pattern.equals(current))
//		{
//			PageObjectLogging.log("assertString", "pattern string: "+pattern+" <br/>current string: "+current+"<br/>are the same", true, driver);
//		}
//		else
//		{
//			PageObjectLogging.log("assertString", "pattern string: "+pattern+" <br/>current string: "+current+"<br/>are different", false, driver);
//		}
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
	
	public static String currentlyFocusedGetAttributeValue(String attributeName)
	{
		String currentlyFocusedName = getCurrentlyFocused().getAttribute(attributeName);
		return currentlyFocusedName;
	}
	
	public static String getAttributeValue(WebElement element, String attributeName)
	{
		return element.getAttribute(attributeName);
	}
	
	
	public static WebElement getCurrentlyFocused()
	{
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
	
	public static void scrollToElement(WebElement element) {
		int y = element.getLocation().getY();
			((JavascriptExecutor)driver).executeScript("window.scrollBy(0,"+y+");");
		}

}
