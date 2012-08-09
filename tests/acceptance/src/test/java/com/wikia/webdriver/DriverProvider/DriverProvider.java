package com.wikia.webdriver.DriverProvider;

import java.util.concurrent.TimeUnit;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.events.EventFiringWebDriver;

import com.wikia.webdriver.Logging.PageObjectLogging;


//import com.wikia.selenium.logging.LoggerDriver;

public class DriverProvider {
	
	private static final DriverProvider instance = new DriverProvider();
	private static WebDriver driver;
	
	public static DriverProvider getInstance()
	{

		PageObjectLogging listener = new PageObjectLogging();
//		File file = new File("c:/IEDriverServer.exe");
//		System.setProperty("webdriver.ie.driver", file.getAbsolutePath());
//		driver = new EventFiringWebDriver(new InternetExplorerDriver()).register(listener);
		driver = new EventFiringWebDriver(new FirefoxDriver()).register(listener);
		driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);
		return instance;
	}
	
	public static WebDriver getWebDriver()
	{
		return driver;
	}
	
	
	public void close()
	{
		driver.close();
	}

}
