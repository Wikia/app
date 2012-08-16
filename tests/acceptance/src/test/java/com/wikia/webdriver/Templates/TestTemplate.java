package com.wikia.webdriver.Templates;

import java.io.File;
import java.io.IOException;
import java.lang.reflect.Method;

import org.openqa.selenium.WebDriver;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.AfterSuite;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.BeforeSuite;

import com.wikia.webdriver.Common.CommonUtils;
import com.wikia.webdriver.Common.Global;
import com.wikia.webdriver.DriverProvider.DriverProvider;
import com.wikia.webdriver.Logging.PageObjectLogging;
import com.wikia.webdriver.Properties.Properties;

public class TestTemplate {
	
	public WebDriver driver;
	
	@BeforeSuite
	public void beforeSuite()
	{
		CommonUtils.deleteDirectory("."+File.separator+"logs");
		CommonUtils.createDirectory("."+File.separator+"logs");
		PageObjectLogging.startLoggingSuite();
		
		Properties.setProperties();
		
	}
	
	@AfterSuite
	public void afterSuite()
	{
		PageObjectLogging.stopLoggingSuite();
		if (Global.BROWSER.equals("IE"))
		{
			try {
				Runtime.getRuntime().exec("taskkill /F /IM IEdriverServer.exe");
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
		else if (Global.BROWSER.equals("CHROME"));
		{
			try {
				Runtime.getRuntime().exec("taskkill /F /IM chromedriver.exe");
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
	}
	
	@BeforeMethod
	public void start(Method method)
	{
		PageObjectLogging.startLoggingMethod(getClass().getSimpleName().toString(), method.getName());
			
	}
	
	@AfterMethod
	public void stop()
	{
		PageObjectLogging.stopLoggingMethod();
		driver.quit();
	}
	
	
	public void startBrowser()
	{
		DriverProvider.getInstance();
		driver = DriverProvider.getWebDriver();
	}
	
	public void stopBrowser()
	{
		if (driver != null)
		{
			driver.close();
			driver = null;
		}
	}
	
	
	

}
