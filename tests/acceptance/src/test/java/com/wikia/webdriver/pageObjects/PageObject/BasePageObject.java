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
	
	public String wikiFactoryLiveDomain = liveDomain + "wiki/Special:WikiFactory";
	
	protected int timeOut = 30;
	
	private WebDriverWait wait;

	
	public BasePageObject(WebDriver driver)
	{
		this.driver = driver;
		wait = new WebDriverWait(driver, timeOut);
		driver.manage().window().maximize();
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
		pageElem.click();
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
	
	public void waitForElementClickableByClassName(String className)
	{
		wait.until(ExpectedConditions.elementToBeClickable(By.className(className)));
	}
	
	public void waitForElementClickableByCss(String css)
	{
		wait.until(ExpectedConditions.elementToBeClickable(By.cssSelector(css)));
	}
	

	
	
	
	
	public String getTimeStamp()
	{
		Date time = new Date();
		long timeCurrent = time.getTime();
		return String.valueOf(timeCurrent);
		
	}
	
    
} 