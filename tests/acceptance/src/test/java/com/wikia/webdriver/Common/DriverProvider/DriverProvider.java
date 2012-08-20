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
import com.wikia.webdriver.Properties.Properties;


//import com.wikia.selenium.logging.LoggerDriver;

public class DriverProvider {
	
	private static final DriverProvider instance = new DriverProvider();
	private static WebDriver driver;
	

	/**
	 * creating webdriver instance based on given browser string
	 * @return
	 * @author Karol Kujawiak
	 */
	public static DriverProvider getInstance()
	{
		
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
	
	/**
	 * 
	 * @return
	 * @author Karol Kujawiak
	 */
	public static WebDriver getWebDriver()
	{
		return driver;
	}
	
	/**
	 * @author Karol Kujawiak
	 */
	public void close()
	{
		driver.close();
	}
	

	/**
	 * @author Karol Kujawiak
	 */
	private static void setIEProperties()
	{
		String sysArch = System.getProperty("os.arch");
		if (sysArch.equals("x86"))
		{
			File file = new File("."+File.separator+
					"src"+File.separator+
					"test"+File.separator+
					"resources"+File.separator+
					"IEDriver"+File.separator+
					"IEDriverServer_x86.exe");	
			System.setProperty("webdriver.ie.driver", file.getAbsolutePath());

		}
		else
		{
			File file = new File("."+File.separator+
					"src"+File.separator+
					"test"+File.separator+
					"resources"+File.separator+
					"IEDriver"+File.separator+
					"IEDriverServer_x64.exe");	
			System.setProperty("webdriver.ie.driver", file.getAbsolutePath());
		}
		
	}
	
	/**
	 * @author Karol Kujawiak
	 */
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
