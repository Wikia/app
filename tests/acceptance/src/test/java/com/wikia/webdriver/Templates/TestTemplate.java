package com.wikia.webdriver.Templates;

import java.io.File;
import java.lang.reflect.Method;

import org.openqa.selenium.WebDriver;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.AfterSuite;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.BeforeSuite;

import com.wikia.webdriver.Common.CommonUtils;
import com.wikia.webdriver.DriverProvider.DriverProvider;
import com.wikia.webdriver.Logging.PageObjectLogging;

public class TestTemplate {
	
	public WebDriver driver;
	
	@BeforeSuite
	public void beforeSuite()
	{
		CommonUtils.deleteDirectory("."+File.separator+"logs");
		CommonUtils.createDirectory("."+File.separator+"logs");
		PageObjectLogging.startLoggingSuite();
		
	}
	
	@AfterSuite
	public void afterSuite()
	{
		PageObjectLogging.stopLoggingSuite();
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
		
	}
	
	
	public void startBrowser()
	{
		DriverProvider.getInstance();
		driver = DriverProvider.getWebDriver();
	}
	
	public void stopBrowser()
	{
		driver.quit();
	}
	
	
	

}
