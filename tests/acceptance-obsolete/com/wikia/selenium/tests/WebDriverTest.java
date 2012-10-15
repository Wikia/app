package com.wikia.selenium.tests;

import java.net.URL;
import java.util.Arrays;
import java.util.Date;
import java.text.DateFormat;
import java.text.SimpleDateFormat;

import java.io.File;
import java.awt.AWTException;
import java.awt.Robot;

import org.openqa.selenium.*;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.remote.DesiredCapabilities;
import org.openqa.selenium.remote.RemoteWebDriver;
import org.openqa.selenium.support.ui.WebDriverWait;
import org.openqa.selenium.support.ui.ExpectedCondition;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.testng.annotations.Test;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Parameters;
import static org.testng.AssertJUnit.fail;

import org.apache.commons.configuration.Configuration;
import org.apache.commons.configuration.ConfigurationException;
import org.apache.commons.configuration.XMLConfiguration;

public class WebDriverTest {

	protected String seleniumHost;
	protected int    seleniumPort;
	protected String browserName;
	protected String browserVersion;
	protected String browserPlatform;
	protected String webSite;
	protected int timeout;
	protected String noCloseAfterFail;
	protected String seleniumSpeed;
	private XMLConfiguration testConfig;
	
	private static ThreadLocal<RemoteWebDriver> threadLocalWebDriver = new ThreadLocal<RemoteWebDriver>();
	
	public static RemoteWebDriver driver() {
		return threadLocalWebDriver.get();
	}
	
	@BeforeMethod(alwaysRun = true)
	@Parameters( { "seleniumHost", "seleniumPort", "browserName", "browserVersion", "browserPlatform", "webSite", "timeout", "noCloseAfterFail"})
	protected void initDriver(String seleniumHost, int seleniumPort,
			String browserName, String browserVersion, String browserPlatform, String webSite, int timeout, String noCloseAfterFail) throws Exception {
		this.seleniumHost = seleniumHost;
		this.seleniumPort = seleniumPort;
		this.browserName = browserName;
		this.browserVersion = browserVersion;
		this.browserPlatform = browserPlatform;
		this.webSite = webSite;
		this.noCloseAfterFail = noCloseAfterFail;
		this.timeout = timeout;

		DesiredCapabilities capabilities = new DesiredCapabilities();
		capabilities.setBrowserName( this.browserName );
		if ( !this.browserVersion.isEmpty() ) capabilities.setVersion( this.browserVersion) ; 
		capabilities.setPlatform( org.openqa.selenium.Platform.ANY );	// todo
		RemoteWebDriver driver = new RemoteWebDriver( new URL("http://" + seleniumHost + ":" + seleniumPort + "/wd/hub"), capabilities );
		threadLocalWebDriver.set( driver );
		
		
		//driver().get( webSite );
	}
	
	@AfterMethod(alwaysRun = true)
	protected void closeDriver() throws Exception {
		try {
			//driver().close();
		} catch(Exception e) {
			System.out.println("================== Warning, exception while doing driver.close " + e);
		};
		try {
			driver().quit();
		} catch(Exception e) {
			System.out.println("================== Warning, exception while doing driver.quit " + e);
		};
		threadLocalWebDriver.set(null);
	}

	public XMLConfiguration getTestConfig() throws Exception{
		if (null == this.testConfig) {
			File file = new File(System.getenv("TESTSCONFIG"));
			if (null != file) {
				this.testConfig = new XMLConfiguration(file);
			}
		}
		return this.testConfig;
	}
	
	protected void clickAndWait(WebElement e) throws Exception {
		clearDOMReadyFlag();
		e.click();
		waitForPageToLoad();
	}
	
	protected void openAndWait(String url) throws Exception {
		clearDOMReadyFlag();
		driver().get( getFullURL(url));
		waitForPageToLoad();
	}
	
	protected void clearDOMReadyFlag() throws Exception {
		driver().executeScript("if (window && window.wgWikiaDOMReady) delete window.wgWikiaDOMReady;");
	}
	
	protected String getFullURL(String relativeUrl) {
		return webSite + relativeUrl;
	}
	
	protected boolean isElementPresent(By by) throws Exception {
		return ( driver().findElements(by).size() > 0 );
	}
	
	protected boolean isElementPresentByCssSelector(String using) throws Exception {
		return ( driver().findElementsByCssSelector( using ).size() > 0 );
	}
	
	protected void hoverMouseOver(WebElement e) throws Exception {
		Actions builder = new Actions(driver());
		Actions hoverOver = builder.moveToElement( e );
		hoverOver.perform();
	}
	
	protected void hoverMouseOver(By by) throws Exception {
		hoverMouseOver( driver().findElement( by ) );				
	}
	
	protected void hoverMouseOverByCssSelector(String using) throws Exception {
		hoverMouseOver( driver().findElementByCssSelector( using ) );
	}
	
	protected void waitForVisibility(By by) throws Exception {
		WebDriverWait waitForElement = new WebDriverWait(driver(), timeout);
		waitForElement.until( ExpectedConditions.visibilityOfElementLocated( by ) );
	}
	
	protected void waitForVisibilityByCssSelector(String using) throws Exception {
		waitForVisibility( By.cssSelector( using ) );
	}
	
	protected void waitForPresence(By by) throws Exception {
		WebDriverWait waitForElement = new WebDriverWait(driver(), timeout);
		waitForElement.until( ExpectedConditions.presenceOfElementLocated( by ) );
	}
	
	protected void waitForPresenceByCssSelector(String using) throws Exception {
		waitForPresence( By.cssSelector( using ) );
	}
	
	protected void waitForPageToLoad() throws Exception {
		//long startTimestamp = (new Date()).getTime();
		WebDriverWait waitForFooter = new WebDriverWait(driver(), timeout);
		
		//ExpectedConditions.presenceOfElementLocated(By.cssSelector("footer#WikiaFooter"));
		waitForFooter.until(new ExpectedCondition<Boolean>(){
			@Override
			public Boolean apply(WebDriver d) {
				JavascriptExecutor javascriptExecutor = (JavascriptExecutor) d;
				return ( ( ( d.findElements( By.cssSelector( "footer#WikiaFooter" )).size() > 0 ) || ( d.findElements( By.cssSelector( "div#footer" ) ).size() > 0 ) ) && 
						( (Boolean)javascriptExecutor.executeScript( "return typeof window != 'undefined' && typeof window.wgWikiaDOMReady != 'undefined';" ) ) );
			}});
		/*
		while(!Boolean.TRUE.equals(driver().executeScript("typeof window != 'undefined' && typeof window.wgWikiaDOMReady != 'undefined'"))) {
			if ((new Date()).getTime() - startTimestamp > (timeout * 1000)) break;
			Thread.sleep(1000);
		}
		*/
	}
	
	public void HoverOverElement(String cssSelectorHoverOver, WebDriver driver) throws AWTException, InterruptedException {
	// Author: Michal Nowierski 
	// This method is designed to manage ChromeDriver FirefoxDriver and InternetExplorerDriver
		
	if (driver.getClass().getSimpleName().equalsIgnoreCase("FirefoxDriver")) {
		// For FirefoxDriver cursor must be in the browser window boundaries
		Robot robot = new Robot();
	  
		int x = driver.manage().window().getSize().getWidth();
		int y = driver.manage().window().getSize().getHeight(); //send the cursor inside window browser
	   robot.mouseMove(x-1,y-1);
	   
	}
	   if (driver.getClass().getSimpleName().equalsIgnoreCase("ChromeDriver")||driver.getClass().getSimpleName().equalsIgnoreCase("InternetExplorerDriver")||driver.getClass().getSimpleName().equalsIgnoreCase("RemoteWebDriver")) {
	// For ChromeDriver and InternetExplorerDriver cursor must be outside the browser window boundaries
		int x_max = driver.manage().window().getSize().getWidth();
		int y_max = driver.manage().window().getSize().getHeight();
		Robot robot = new Robot();
		
		//send the cursor outside window browser (it will land at the bottom right corner of screen)
		   robot.mouseMove(x_max-10000,y_max+10000);
	}
	   if (driver.getClass().getSimpleName().equalsIgnoreCase("InternetExplorerDriver")) {
		 //For InternetExplorer special script is NEEDED
		      String mouseOverScript = "if(document.createEvent){var evObj = document.createEvent('MouseEvents');evObj.initEvent('mouseover', true, false); arguments[0].dispatchEvent(evObj);} else if(document.createEventObject) { arguments[0].fireEvent('onmouseover');}";
			JavascriptExecutor js = (JavascriptExecutor) driver;
			WebElement someElem = driver.findElement(By.cssSelector(cssSelectorHoverOver)); //replace with your own WebElement call/code here
			js.executeScript(mouseOverScript, someElem);
	   }
	   else if (driver.getClass().getSimpleName().equalsIgnoreCase("FirefoxDriver")||driver.getClass().getSimpleName().equalsIgnoreCase("ChromeDriver")||driver.getClass().getSimpleName().equalsIgnoreCase("RemoteWebDriver")) {
		 //For Firefox, or Chrome (RemoteWebDriver) special script is NOT NEEDED
		   String mouseOverScript = "if(document.createEvent){var evObj = document.createEvent('MouseEvents');evObj.initEvent('mouseover', true, false); arguments[0].dispatchEvent(evObj);} else if(document.createEventObject) { arguments[0].fireEvent('onmouseover');}";
			JavascriptExecutor js = (JavascriptExecutor) driver;
			WebElement someElem = driver.findElement(By.cssSelector(cssSelectorHoverOver)); //replace with your own WebElement call/code here
			js.executeScript(mouseOverScript, someElem);
	   }
	   else {
		 //For any other browser:
		   String mouseOverScript = "if(document.createEvent){var evObj = document.createEvent('MouseEvents');evObj.initEvent('mouseover', true, false); arguments[0].dispatchEvent(evObj);} else if(document.createEventObject) { arguments[0].fireEvent('onmouseover');}";
			JavascriptExecutor js = (JavascriptExecutor) driver;
			WebElement someElem = driver.findElement(By.cssSelector(cssSelectorHoverOver)); //replace with your own WebElement call/code here
			js.executeScript(mouseOverScript, someElem);
	}
	   
// The below code is a js workaround for hovering over elements
// Try to use if the acutal code does not work.
	   
	   //Start
//	   String mouseOverScript = "if(document.createEvent){var evObj = document.createEvent('MouseEvents');evObj.initEvent('mouseover', true, false); arguments[0].dispatchEvent(evObj);} else if(document.createEventObject) { arguments[0].fireEvent('onmouseover');}";
//		JavascriptExecutor js = (JavascriptExecutor) driver;
//		WebElement someElem = driver.findElement(By.cssSelector(cssSelectorHoverOver)); //replace with your own WebElement call/code here
//		js.executeScript(mouseOverScript, someElem);
	   // End
		
// The below code is official WebDriver code for hovering over elements
		// Start
//		WebElement HoverOverElement =driver.findElement(By.cssSelector(cssSelectorHoverOver));
//		Actions builder = new Actions(driver);
//		builder.moveToElement(HoverOverElement).perform();
		// End
   	    	
	      }
		  
public void HoverOverElementAndClick(String cssSelectorHoverOver, String cssSelectorClick, WebDriver driver) throws AWTException, InterruptedException {
	// Author: Michal Nowierski 
	// This method is designed to manage ChromeDriver FirefoxDriver and InternetExplorerDriver
	// This method is needed now because Selenium Webdriver Team has problems with hovering over elements (31 july 2012) - Webdriver Release 2.25
	
	WebDriverWait wait = new WebDriverWait(driver, 30);
	if (driver.getClass().getSimpleName().equalsIgnoreCase("FirefoxDriver")) {
		// For FirefoxDriver cursor must be in the browser window boundaries
		Robot robot = new Robot();
	  
		int x = driver.manage().window().getSize().getWidth();
		int y = driver.manage().window().getSize().getHeight(); //send the cursor inside window browser
	   robot.mouseMove(x-1,y-1);
	   
	}
	   if (driver.getClass().getSimpleName().equalsIgnoreCase("ChromeDriver")||driver.getClass().getSimpleName().equalsIgnoreCase("InternetExplorerDriver")||driver.getClass().getSimpleName().equalsIgnoreCase("RemoteWebDriver")) {
	// For ChromeDriver and InternetExplorerDriver cursor must be outside the browser window boundaries
		int x_max = driver.manage().window().getSize().getWidth();
		int y_max = driver.manage().window().getSize().getHeight();
		Robot robot = new Robot();
		
		//send the cursor outside window browser (it will land at the bottom right corner of screen)
		   robot.mouseMove(x_max-10000,y_max+10000);
	}
	  	   
	   if (driver.getClass().getSimpleName().equalsIgnoreCase("InternetExplorerDriver")) {
		//For InternetExplorer special script is NEEDED
			String mouseOverScript = "if(document.createEvent){var evObj = document.createEvent('MouseEvents');evObj.initEvent('mouseover', true, false); arguments[0].dispatchEvent(evObj);} else if(document.createEventObject) { arguments[0].fireEvent('onmouseover');}";
			JavascriptExecutor js = (JavascriptExecutor) driver;
			WebElement someElem = driver.findElement(By.cssSelector(cssSelectorHoverOver)); //replace with your own WebElement call/code here
			js.executeScript(mouseOverScript, someElem);
			 WebElement ClickOnElement = driver.findElement(By.cssSelector(cssSelectorClick));
			 wait.until(ExpectedConditions.visibilityOf(ClickOnElement));
			 Thread.sleep(500);
			 ClickOnElement.click();
	}
	   else if (driver.getClass().getSimpleName().equalsIgnoreCase("FirefoxDriver")||driver.getClass().getSimpleName().equalsIgnoreCase("ChromeDriver")||driver.getClass().getSimpleName().equalsIgnoreCase("RemoteWebDriver")) {
		 //For Firefox, or Chrome (RemoteWebDriver) special script is  NEEDED
		   String mouseOverScript = "if(document.createEvent){var evObj = document.createEvent('MouseEvents');evObj.initEvent('mouseover', true, false); arguments[0].dispatchEvent(evObj);} else if(document.createEventObject) { arguments[0].fireEvent('onmouseover');}";
			JavascriptExecutor js = (JavascriptExecutor) driver;
			WebElement someElem = driver.findElement(By.cssSelector(cssSelectorHoverOver)); //replace with your own WebElement call/code here
			js.executeScript(mouseOverScript, someElem);
			 WebElement ClickOnElement = driver.findElement(By.cssSelector(cssSelectorClick));
			 wait.until(ExpectedConditions.visibilityOf(ClickOnElement));
			 Thread.sleep(500);
			 ClickOnElement.click();
	}
	   else {
		//For any other browser:
		String mouseOverScript = "if(document.createEvent){var evObj = document.createEvent('MouseEvents');evObj.initEvent('mouseover', true, false); arguments[0].dispatchEvent(evObj);} else if(document.createEventObject) { arguments[0].fireEvent('onmouseover');}";
		JavascriptExecutor js = (JavascriptExecutor) driver;
		WebElement someElem = driver.findElement(By.cssSelector(cssSelectorHoverOver)); //replace with your own WebElement call/code here
		js.executeScript(mouseOverScript, someElem);
		WebElement ClickOnElement = driver.findElement(By.cssSelector(cssSelectorClick));
		wait.until(ExpectedConditions.visibilityOf(ClickOnElement));
		Thread.sleep(500);
		ClickOnElement.click();
		}
	   
	   
//The below code is official WebDriver code for hovering over elements
	   
	 //Start
//		   WebElement HoverOverElement =driver.findElement(By.cssSelector(cssSelectorHoverOver));
//		   WebElement ClickOnElement = driver.findElement(By
//				   .cssSelector(cssSelectorClick));
//		   Actions builder = new Actions(driver);
//		   
//		   builder.moveToElement(HoverOverElement).perform();
//		   		   
//		   wait.until(ExpectedConditions.visibilityOf(ClickOnElement));
//		  
//		   wait.until(ExpectedConditions.elementToBeClickable(By
//				   .cssSelector(cssSelectorClick)));
//		   Thread.sleep(800);
//		   ClickOnElement.click();
	  //End
		  
// Huge discussion about hover over ellements issue: link below
	   //https://code.google.com/p/selenium/issues/detail?can=2&start=0&num=100&q=&colspec=ID%20Stars%20Type%20Status%20Priority%20Milestone%20Owner%20Summary&groupby=&sort=&id=2067
	    
// Post from the discussion which provided the solution used in current code (17 jul 2012 M Nowierski)	 
	   //JAVA VERSION OF COMMENT 60
	   // Jul 11  - comment 64
}


protected void NavigateToWikia(WebDriver driver) {
	// Author: Michal Nowierski 
	// Navigate to www.wikia.com/Wikia
		System.out.println("Navigate to www.wikia.com/Wikia");
		driver.get("http://www.wikia.com/Wikia");
		WebDriverWait wait = new WebDriverWait(driver, 30);
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("header.WikiaHeader nav ul li.WikiaLogo a img")));

		
}

protected void scrollToElement(WebDriver driver, WebElement element) {
	// Author: Michal Nowierski 
	// Scroll to an element
	//This mehtod is used mostly because Chrome does not scroll to elements automaticly (18 july 2012)
		int y = element.getLocation().getY();
		((JavascriptExecutor)driver).executeScript("window.scrollBy(0,"+y+");");
	}
public void MakeSureUserLoggedOut(WebDriver driver) throws AWTException, InterruptedException {
	// Author: Michal Nowierski 
	// because on InternetExplorerDriver user is not always logged out by default after new IEdriver instance initiation  
    // Therefore, tis method is to make sure that User is logged out
		try {
			
			LogOutUsingUserDropDown(driver);
		
		} catch (Exception e) {
			
		}

	}
	
public void MakeSureUserLoggedIn(WebDriver driver, String username, String password) throws AWTException, InterruptedException {
	// Author: Michal Nowierski 
    // Make sure that user is logged in. If he is, dont throw exception.
		try {
			
			LogInUsingUserDropDown(driver, username, password);
		
		} catch (Exception e) {
			
		}
	}
	
protected void LogOutUsingUserDropDown(WebDriver driver) throws AWTException, InterruptedException {
	// Author: Michal Nowierski
	//Log out using user drop down log out item.
		WebDriverWait wait = new WebDriverWait(driver, 30);
		System.out.println("Log out using user drop down log out item.");
		HoverOverElementAndClick("ul[id='AccountNavigation'] li a img.chevron",
				"ul[id='AccountNavigation'] li a[data-id='logout']", driver);
		System.out.println("user is logged out");
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
	.cssSelector("ul[id='AccountNavigation'] li a[data-id='login']")));

}
protected void LogInUsingUserDropDown(WebDriver driver, String username, String password) throws AWTException, InterruptedException {
	// Author: Michal Nowierski
	//Log in using user drop down log out item.
		WebDriverWait wait = new WebDriverWait(driver, 30);
		System.out.println("Log in using user drop down log in item.");
		HoverOverElement("ul[id='AccountNavigation'] li a img.chevron", driver);
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("ul[id='AccountNavigation'] li a[data-id='login']")));
		driver.findElement(
				By.cssSelector("ul[id='AccountNavigation'] li div form input[name='username']"))
				.sendKeys(username);
		driver.findElement(
				By.cssSelector("ul[id='AccountNavigation'] li div form input[name='password']"))
				.sendKeys(password);
		wait.until(ExpectedConditions.elementToBeClickable(By
				.cssSelector("ul[id='AccountNavigation'] li div.submits input[value='Log in']")));
		driver.findElement(By.cssSelector("ul[id='AccountNavigation'] li div.submits input[value='Log in']")).click();
	
}
protected void VerifyUserLoggedIn(String username, WebDriver driver) {
	// Author: Michal Nowierski
	// Verify user is logged into wiki
	// Remember ! username must be a string that start with the first letter in Upper case ! otherwise exception will be thrown (wikia automaticly sets the first letter of user to uppercase
		WebDriverWait wait = new WebDriverWait(driver, 30);
		System.out
				.println("Verify User name is displayed in place of Log in and Sign up links (user is logged into wiki)");
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
	.cssSelector("li img[alt='"+username+"']")));
}
protected void VerifyUserLoggedOut(WebDriver driver) {
	// Author: Michal Nowierski
	// Verify that user is logged out
		WebDriverWait wait = new WebDriverWait(driver, 30);
		System.out
				.println("Verify User avatar is not displayed in place of Log in and Sign up links (user is logged into wiki)");
		wait.until(ExpectedConditions.invisibilityOfElementLocated(By
	.cssSelector("ul[id='AccountNavigation'] li img.avatar")));
	
}
protected void LeftClickOnSignUpLink(WebDriver driver) {
	// Author: Michal Nowierski
	// Left click on sign up link
		WebDriverWait wait = new WebDriverWait(driver, 30);
		wait.until(ExpectedConditions.elementToBeClickable(By
				.cssSelector("ul[id='AccountNavigation'] li a.ajaxRegister")));
		driver.findElement(By.cssSelector("ul[id='AccountNavigation'] li a.ajaxRegister")).click();
	
}
protected void VerifyRediectionToSpecialPage(String specialPage, WebDriver driver) {
	// Author: Michal Nowierski
	// Verify that you have been redirected to Special:specialPage - specialPage may be Version, NewFiles, Upload etc.
		WebDriverWait wait = new WebDriverWait(driver, 30);
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("header.WikiaHeader nav ul li.WikiaLogo a img")));
		System.out.println("Verify the Special:" + specialPage
				+ " site is opened");
		if (!driver.getCurrentUrl().contains(specialPage)) {
			fail("TEST CASE step: URL does not contain 'Special:" + specialPage
					+ "' key String");
		}
}
protected void VerifyTheGivenStringURLpresence(final String givenstring, final WebDriver driver) {
	// Author: Michal Nowierski
	// Verify the given String exists in URL of currently opened page
		System.out.println("Verify presence of the " + givenstring
				+ " string  in the current URL");
		WebDriverWait wait = new WebDriverWait(driver, 30);
	// New Expected Condition is created below. It returns true when wanted URL is a current page URL
		ExpectedCondition e = new ExpectedCondition<Boolean>() {
			public Boolean apply(WebDriver d) {
				Boolean contains;
				contains = driver.getCurrentUrl().contains(givenstring);
				return contains;
			}
		};
		wait.until(e);
	    

	
	
}
protected void TypeIntoTheSearchField(String SearchString, WebDriver driver) {
	// Author: Michal Nowierski
	// Type into a search filed the given SearchString
	// This method is global for all WikiaSearch forms on all of the wikis
		System.out.println("Type " + SearchString
				+ " String into the search field ");
		WebDriverWait wait = new WebDriverWait(driver, 30);
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("form.WikiaSearch input[name='search']")));
		WebElement SearchField = driver.findElement(By
				.cssSelector("form.WikiaSearch input[name='search']"));
		SearchField.sendKeys(SearchString);
	}

protected void LeftClickOnWikiaSearchButton(WebDriver driver) {
	// Author: Michal Nowierski
	// Left click on search button in order to initiate searching. 
	// This method is global for all WikiaSearch buttons on all of the wikis.
	// The method should be invoked after TypeIntoTheSearchField method
		System.out.println("Left click on the WikiaSearch button");
		WebDriverWait wait = new WebDriverWait(driver, 30);
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("form.WikiaSearch button.wikia-button")));
		WebElement WikiaSearchButton = driver.findElement(By
				.cssSelector("form.WikiaSearch button.wikia-button"));
		wait.until(ExpectedConditions.elementToBeClickable(By
				.cssSelector("form.WikiaSearch button.wikia-button")));

		WikiaSearchButton.click();
	
}
protected void VerifyIfTheGivenSiteHasBeenFound(String URL,
		WebDriver driver) {
	// Author: Michal Nowierski
	// Verify that the given site is one of the results of searching process
	// The method should be invoked after TypeIntoTheSearchField and The method should be invoked after TypeIntoTheSearchField method methods
	// This method is global for all WikiaSearch results on all of the wikis
		WebDriverWait wait = new WebDriverWait(driver, 30);
		System.out.println("Verify if " + URL
				+ " URL is one of found the results");
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("li.result a[href='"+URL+"']")));

	
}
protected void NavigateToWiki(WebDriver driver, String wikiName) {
	// Author: Michal Nowierski
	// navigate to wiki by the wikiname. eg. http://mediawiki119.wikia.com
		System.out.println("Navigate to " + wikiName + " wiki");
		driver.get(wikiName);
		WebDriverWait wait = new WebDriverWait(driver, 30);
		wait.until(ExpectedConditions.visibilityOfElementLocated(By
				.cssSelector("header.WikiaHeader nav ul li.WikiaLogo a img")));
}
	
protected static String getDateString() {
	// Author: Michal Nowierski
	// The method is use to help to differeniate various newly created wikis, pages, captions etc.
		DateFormat dateFormat = new SimpleDateFormat("yyyyMMddHHmmss");
		Date date = new Date();
		return (dateFormat.format(date));
}

}
