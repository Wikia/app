package com.wikia.webdriver.Logging;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;

import org.apache.commons.io.FileUtils;
import org.openqa.selenium.By;
import org.openqa.selenium.OutputType;
import org.openqa.selenium.TakesScreenshot;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.events.WebDriverEventListener;

import com.google.common.base.Throwables;
import com.wikia.webdriver.Common.CommonUtils;
import com.wikia.webdriver.DriverProvider.DriverProvider;



public class PageObjectLogging implements WebDriverEventListener{

	private By lastFindBy;
	
	private static long imageCounter;
	private static String reportPath = "."+File.separator+"logs"+File.separator;
	private static String screenPath = reportPath + "screenshots"+File.separator+"screenshot";
	private static String logFileName = "log.html";
	private static String logPath = reportPath + logFileName;
	
	
	
	
	
	public static void startLoggingSuite()
	{
			imageCounter = 0; 
			String l1 = "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\"><style>td { border-top: 1px solid grey; } </style></head><body>";
			CommonUtils.appendTextToFile(logPath, l1);
			
	}
	
	public static void stopLoggingSuite()
	{
			imageCounter = 0; 
			String l1 = "</body></html>";
			CommonUtils.appendTextToFile(logPath, l1);
			
	}
	
	public static void startLoggingMethod(String className, String methodName)
	{
			imageCounter = 0; 
			String l1 = "<h1>Class: <em>"+className+"."+methodName+"</em></h1>";
			String l2 = "<table>";
			CommonUtils.appendTextToFile(logPath, l1);
			CommonUtils.appendTextToFile(logPath, l2);
	}
	
	
	public static void stopLoggingMethod()
	{ 
			
			String l1 = "</table>";
			CommonUtils.appendTextToFile(logPath, l1);
	}
	
	public static void log(String command, String description, boolean success, WebDriver driver)
	{
		
		CommonUtils.captureScreenshot(screenPath+imageCounter, driver);
		String hexColor = success ? "#CCFFCC" : "#FFCCCC";
		String s = "<tr style=\"background:"+hexColor+";\"><td>"+command+"</td><td>"+description+"</td><td> <br/><a href='screenshots/screenshot"+imageCounter+".png'>Screenshot</a></td></tr>";
		CommonUtils.appendTextToFile(logPath, s);
		imageCounter +=1;
	}
	
	public static void log(String command, String description, boolean success)
	{
		String hexColor = success ? "#CCFFCC" : "#FFCCCC";
		String s = "<tr style=\"background:"+hexColor+";\"><td>"+command+"</td><td>"+description+"</td><td> <br/><a href='screenshots/screenshot"+imageCounter+".png'>Screenshot</a></td></tr>";
		CommonUtils.appendTextToFile(logPath, s);
	}
	

	
	@Override
	public void beforeNavigateTo(String url, WebDriver driver) {
//		System.out.println("Before navigate to " + url);
		
	}

	@Override
	public void afterNavigateTo(String url, WebDriver driver) {
//		System.out.println("After navigate to " + url);
		String s = "<tr style=\"background:#CCFFCC;\"><td>Navigate to</td><td>"+url+"</td><td> <br/> &nbsp;</td></tr>";
		CommonUtils.appendTextToFile(logPath, s);
		
	}

	@Override
	public void beforeNavigateBack(WebDriver driver) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void afterNavigateBack(WebDriver driver) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void beforeNavigateForward(WebDriver driver) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void afterNavigateForward(WebDriver driver) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void beforeFindBy(By by, WebElement element, WebDriver driver) {
//		System.out.println("beforeFindBy");
		
	}

	@Override
	public void afterFindBy(By by, WebElement element, WebDriver driver) {
		lastFindBy = by;
//		String s = "<tr style=\"background:#CCFFCC;\"><td>Found element</td><td>"+lastFindBy+"</td><td> <br/> &nbsp;</td></tr>";
//		appendTextToFile(reportPath, s);

	}

	@Override
	public void beforeClickOn(WebElement element, WebDriver driver) {
//		System.out.println("beforeClick");
		
	}

	@Override
	public void afterClickOn(WebElement element, WebDriver driver) {
		
		String s = "<tr style=\"background:#CCFFCC;\"><td>click</td><td>"+lastFindBy+"</td><td> <br/><a href='screenshots/screenshot"+imageCounter+".png'>Screenshot</a></td></tr>";
		CommonUtils.appendTextToFile(logPath, s);

//		System.out.println("afterClick");
		
	}

	@Override
	public void beforeChangeValueOf(WebElement element, WebDriver driver) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void afterChangeValueOf(WebElement element, WebDriver driver) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void beforeScript(String script, WebDriver driver) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void afterScript(String script, WebDriver driver) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onException(Throwable throwable, WebDriver driver) 
	{
		CommonUtils.captureScreenshot(screenPath+imageCounter, driver);
		String stackTrace = Throwables.getStackTraceAsString(throwable);
		String s1 = "<tr style=\"background:#FFCCCC;\"><td>error</td><td>"+stackTrace+"</td><td> <br/><a href='screenshots/screenshot"+imageCounter+".png'>Screenshot</a></td></tr>";
				
		CommonUtils.appendTextToFile(logPath, s1);
		imageCounter +=1;
				
//		System.out.println(throwable.toString());
	}




	
}
