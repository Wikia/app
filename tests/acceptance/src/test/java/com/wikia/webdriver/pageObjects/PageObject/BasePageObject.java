package com.wikia.webdriver.pageObjects.PageObject;

import java.util.Date;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;



public class BasePageObject{

	public final WebDriver driver;
	
	public String liveDomain = "http://www.wikia.com/";

	private int timeOut = 30;
	
	public BasePageObject(WebDriver driver)
	{
		this.driver = driver;
	}
	
	/*
	 * Checks page title
	 * @param title 
	 * @return true|false
	 * */
	
	public boolean verifyTitle(String title)
	{
		String currentTitle = driver.getTitle();
		if (!currentTitle.equals(title))
		{
			return false;
		}
		return true;
	}
	
	
	/*
	 * Clicks on an element
	 * */
	public void click(WebElement pageElem)
	{
		Actions action = new Actions(driver);
		action.click(pageElem).perform();
		
	}
	
	public void watForElementByCss(String cssSelector)
	{
		WebDriverWait wait = new WebDriverWait(driver, timeOut);
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.cssSelector(cssSelector)));
	}

	public void watForElementByClassName(String className)
	{
		WebDriverWait wait = new WebDriverWait(driver, timeOut);
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.className(className)));
	}
	
	public void watForElementByClassId(String id)
	{
		WebDriverWait wait = new WebDriverWait(driver, timeOut);
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.id(id)));
	}
	
	public void watForElementByXPath(String xPath)
	{
		WebDriverWait wait = new WebDriverWait(driver, timeOut);
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath(xPath)));
	}
	
	public void waitForElementNotPresentByClass(String className)
	{
		
//		WebDriverWait wait = new WebDriverWait(driver, timeOut);
//		wait.until(ExpectedConditions.stalenessOf(driver.findElement(By.className(className))));
		
		
	}
	
	
	public void waitForElementNotVisibleByCss(String css)
	{
		WebDriverWait wait = new WebDriverWait(driver, timeOut);
		wait.until(ExpectedConditions.invisibilityOfElementLocated(By.cssSelector(css)));

	}
	
	
	public String getTimeStamp()
	{
		Date time = new Date();
		long timeCurrent = time.getTime();
		return String.valueOf(timeCurrent);
		
	}
	
    
} 