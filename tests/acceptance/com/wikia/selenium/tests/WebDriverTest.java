package com.wikia.selenium.tests;

import java.net.URL;
import java.util.Arrays;
import java.util.Date;

import java.io.File;

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

}
