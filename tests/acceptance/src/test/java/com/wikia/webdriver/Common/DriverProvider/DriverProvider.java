package com.wikia.webdriver.Common.DriverProvider;

import java.io.File;
import java.util.Arrays;
import java.util.concurrent.TimeUnit;

import org.browsermob.core.har.Har;
import org.browsermob.proxy.ProxyServer;
import org.openqa.selenium.Capabilities;
import org.openqa.selenium.Proxy;
import org.openqa.selenium.TimeoutException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.firefox.FirefoxProfile;
import org.openqa.selenium.htmlunit.HtmlUnitDriver;
import org.openqa.selenium.ie.InternetExplorerDriver;
import org.openqa.selenium.remote.CapabilityType;
import org.openqa.selenium.remote.DesiredCapabilities;
import org.openqa.selenium.support.events.EventFiringWebDriver;

import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;


//import com.wikia.selenium.logging.LoggerDriver;

public class DriverProvider {
	
	private static final DriverProvider instance = new DriverProvider();
	private static WebDriver driver;
	private static ProxyServer server;

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
		else if (Global.BROWSER.equals("FFPROXY"))
		{
			server = new ProxyServer(4569);
			try
			{
				server.start();
				server.setCaptureHeaders(true);
				server.setCaptureContent(true);
				server.newHar("test");
				DesiredCapabilities caps = new DesiredCapabilities();
				Proxy proxy = server.seleniumProxy();
				FirefoxProfile profile = new FirefoxProfile();
				profile.setAcceptUntrustedCertificates(true);
				profile.setAssumeUntrustedCertificateIssuer(true);
				profile.setPreference("network.proxy.http", "localhost");
		        profile.setPreference("network.proxy.http_port", 4569);
		        profile.setPreference("network.proxy.ssl", "localhost");
		        profile.setPreference("network.proxy.ssl_port", 4569);
		        profile.setPreference("network.proxy.type", 1);
		        profile.setPreference("network.proxy.no_proxies_on", "");
		        profile.setProxyPreferences(proxy);
		        caps.setCapability(FirefoxDriver.PROFILE,profile);
		        caps.setCapability(CapabilityType.PROXY, proxy);
		        driver = new EventFiringWebDriver(new FirefoxDriver(caps)).register(listener);
			}
			catch(Exception e)
			{
				e.printStackTrace();
			}
		}
		else if (Global.BROWSER.equals("CHROME"))
		{
			setChromeProperties();
			driver = new EventFiringWebDriver(new ChromeDriver()).register(listener);
		}
		else if (Global.BROWSER.equals("CHROMEMOBILE"))
		{
			setChromeProperties();
			DesiredCapabilities caps = new DesiredCapabilities();
			caps.setCapability("chrome.switches", Arrays.asList("--user-agent="+"Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A543a Safari/419.3"));
			//"--user-agent="+"Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A543a Safari/419.3");
			driver = new EventFiringWebDriver(new ChromeDriver(caps)).register(listener);
		}
		else if (Global.BROWSER.equals("HTMLUNIT"))
		{
			driver = new EventFiringWebDriver(new HtmlUnitDriver()).register(listener);
		}
			
		
		driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);
		try
		{			
			if (!Global.BROWSER.equals("CHROME"))
			{
				driver.manage().timeouts().pageLoadTimeout(60, TimeUnit.SECONDS);
			}
			driver.manage().timeouts().setScriptTimeout(30, TimeUnit.SECONDS);
		}
		catch (TimeoutException e)
		{
			PageObjectLogging.log("Page load timeout", "Page was loading for over 30 seconds", true);
		}
		return instance;
	}
	
	/**
	 * creating webdriver instance based on given browser string
	 * @return
	 * @author Karol Kujawiak
	 */
	public static DriverProvider getInstanceFF()
	{
		
		PageObjectLogging listener = new PageObjectLogging();
		driver = new EventFiringWebDriver(new FirefoxDriver()).register(listener);
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
	
	public static ProxyServer getServer()
	{
		return server;
	}
	/**
	 * @author Karol Kujawiak
	 */
	
	

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
