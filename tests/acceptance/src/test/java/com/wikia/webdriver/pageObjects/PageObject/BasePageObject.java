package com.wikia.webdriver.pageObjects.PageObject;

import java.io.File;
import java.util.Date;
import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import com.wikia.webdriver.Common.CommonExpectedConditions;
import com.wikia.webdriver.Common.CommonFunctions;
import com.wikia.webdriver.Common.Global;
import com.wikia.webdriver.Common.XMLFunctions;
import com.wikia.webdriver.Logging.PageObjectLogging;



public class BasePageObject{

	public final WebDriver driver;
	
	public String liveDomain = "http://www.wikia.com/";
	
	public String wikiFactoryLiveDomain = "http://community.wikia.com/wiki/Special:WikiFactory";
	

	
	
	public static String userName = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.regular.username");
	public static String password = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.regular.password");
	
	public static String userNameNonLatin = "卡羅爾";
	public static String userNameNonLatinEncoded = "%E5%8D%A1%E7%BE%85%E7%88%BE";
	
	public static String userNameWithUnderScore = "Driver_web";
	public static String userNameWithBackwardSlash = "Driver\\web";
	public static String userNameLong = "Webdriverwikiaselenium";
	
	
													
	public static String passwordNonLatin = "";
	
	public static String email = "webdriverseleniumwikia@gmail.com";
	public static String emailPassword = "";
	//卡羅爾
	
	public static String userNameStaff = System.getenv("STAFF_USER");
	public static String passwordStaff = System.getenv("STAFF_PASS");;
	
	protected int timeOut = 30;
	
	public WebDriverWait wait;

	
	public BasePageObject(WebDriver driver)
	{
		this.driver = driver;
		wait = new WebDriverWait(driver, timeOut);
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
			return true;
		}
		return false;
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
	
	
	public void waitForElementClickableByClassName(String className)
	{
		wait.until(ExpectedConditions.elementToBeClickable(By.className(className)));
	}
	
	public void waitForElementClickableByCss(String css)
	{
		wait.until(ExpectedConditions.elementToBeClickable(By.cssSelector(css)));
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
	
	
	
	public String getTimeStamp()
	{
		Date time = new Date();
		long timeCurrent = time.getTime();
		return String.valueOf(timeCurrent);
		
	}
	
	
	

	
    
} 