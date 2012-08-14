package com.wikia.webdriver.DriverProvider;

import java.io.File;
import java.util.concurrent.TimeUnit;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.ie.InternetExplorerDriver;
import org.openqa.selenium.support.events.EventFiringWebDriver;

import com.wikia.webdriver.Common.Global;
import com.wikia.webdriver.Logging.PageObjectLogging;


//import com.wikia.selenium.logging.LoggerDriver;

public class DriverProvider {
	
	private static final DriverProvider instance = new DriverProvider();
	private static WebDriver driver;
	
	public static DriverProvider getInstance()
	{
		setProperties();
		PageObjectLogging listener = new PageObjectLogging();
		if (Global.BROWSER.equals("IE"))
		{
			setIEProperties();
			driver = new EventFiringWebDriver(new InternetExplorerDriver()).register(listener);
		}
		else if (Global.BROWSER.equals("FF"))
		{
			
			driver = new EventFiringWebDriver(new FirefoxDriver()).register(listener);
		}
		else if (Global.BROWSER.equals("CHROME"))
		{
			setChromeProperties();
			driver = new EventFiringWebDriver(new ChromeDriver()).register(listener);
		}
			
		
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
	
	private static void setProperties()
	{
		Global.RUN_BY_MAVEN = "true".equals(System.getProperty("run_mvn"));
		if (Global.RUN_BY_MAVEN)
		{	
			getPropertiesFromPom();
		}
		else
		{
			setPropertiesManually();
		}
		
	}
	
	private static void getPropertiesFromPom()
	{
		Global.BROWSER = System.getProperty("browser");
		Global.CONFIG_FILE = new File(System.getProperty("config"));
	}
	
	private static void setPropertiesManually()
	{
		Global.BROWSER = "FF";
		Global.CONFIG_FILE = new File("c:"+File.separator+"config.xml"+File.separator+"config.xml");
	}

	private static void setIEProperties()
	{
		File file = new File("."+File.separator+
				"src"+File.separator+
				"test"+File.separator+
				"resources"+File.separator+
				"IEDriver"+File.separator+
				"IEDriverServer.exe");
			System.setProperty("webdriver.ie.driver", file.getAbsolutePath());
	}
	
	private static void setChromeProperties()
	{
		File file = new File("."+File.separator+
				"src"+File.separator+
				"test"+File.separator+
				"resources"+File.separator+
				"ChromeDriver"+File.separator+
				"chromedriver.exe");
			System.setProperty("webdriver.chrome.driver", file.getAbsolutePath());
	}
	
}
