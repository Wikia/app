package com.wikia.webdriver.Common.Logging;

import java.awt.Dimension;
import java.awt.Toolkit;
import java.io.File;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.events.WebDriverEventListener;

import com.google.common.base.Throwables;
import com.wikia.webdriver.Common.Core.CommonUtils;
import com.wikia.webdriver.Common.Core.Global;

public class PageObjectLogging implements WebDriverEventListener {

	private By lastFindBy;

	private static long imageCounter;
	private static String reportPath = "." + File.separator + "logs"
			+ File.separator;
	private static String screenDirPath = reportPath + "screenshots"
			+ File.separator;
	private static String screenPath = screenDirPath + "screenshot";
	private static String logFileName = "log.html";
	private static String logPath = reportPath + logFileName;

	public static void startLoggingSuite() {
		CommonUtils.createDirectory(screenDirPath);
		imageCounter = 0;
		//date time
		DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
		Date date = new Date();
		//resolution
		Toolkit toolkit =  Toolkit.getDefaultToolkit ();
		Dimension dim = toolkit.getScreenSize();
		
		String l1 = "<html><style>table {margin:0 auto;}td:first-child {width:200px;}td:nth-child(2) {width:660px;}td:nth-child(3) {width:100px;}tr.success{color:black;background-color:#CCFFCC;}tr.error{color:black;background-color:#FFCCCC;}tr.step{color:white;background:grey}</style><head><meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\"><style>td { border-top: 1px solid grey; } </style></head><body>";
		String l2 = "<p>Date: " + dateFormat.format(date) + " UTC</p>";
		String l3 = "<p>Browser: " + Global.BROWSER + "</p>";
		String l4 = "<p>OS: " + System.getProperty("os.name") + "</p>";
		String l5 = "<p>Screen resolution: " + dim.width + "x"+dim.height+"</p>";
		
		
		CommonUtils.appendTextToFile(logPath, l1);
		CommonUtils.appendTextToFile(logPath, l2);
		CommonUtils.appendTextToFile(logPath, l3);
		CommonUtils.appendTextToFile(logPath, l4);
		CommonUtils.appendTextToFile(logPath, l5);
	}

	public static void stopLoggingSuite() {
		String l1 = "</body></html>";
		CommonUtils.appendTextToFile(logPath, l1);
	}

	public static void startLoggingMethod(String className, String methodName) {
		String l1 = "<h1>Class: <em>" + className + "." + methodName
				+ "</em></h1>";
		String l2 = "<table>";
		String l3 = "<tr class=\"step\"><td>&nbsp</td><td>START LOGGING METHOD</td><td> <br/> &nbsp;</td></tr>";
		CommonUtils.appendTextToFile(logPath, l1);
		CommonUtils.appendTextToFile(logPath, l2);
		CommonUtils.appendTextToFile(logPath, l3);
	}

	public static void stopLoggingMethod() {
		String l1 = "<tr class=\"step\"><td>&nbsp</td><td>STOP LOGGING METHOD</td><td> <br/> &nbsp;</td></tr>";
		String l2 = "</table>";
		CommonUtils.appendTextToFile(logPath, l1);
		CommonUtils.appendTextToFile(logPath, l2);
	}

	public static void log(String command, String description, boolean success,
			WebDriver driver) {
		imageCounter += 1;
		CommonUtils.captureScreenshot(screenPath + imageCounter, driver);
		CommonUtils.appendTextToFile(screenPath + imageCounter + ".html",
				driver.getPageSource());
		String className = success ? "success" : "error";
		String s = "<tr class=\"" + className + "\"><td>" + command
				+ "</td><td>" + description
				+ "</td><td> <br/><a href='screenshots/screenshot"
				+ imageCounter
				+ ".png'>Screenshot</a><br/><a href='screenshots/screenshot"
				+ imageCounter + ".html'>HTML Source</a></td></tr>";
		CommonUtils.appendTextToFile(logPath, s);
		
	}

	public static void log(String command, String description, boolean success) {
		String className = success ? "success" : "error";
		String s = "<tr class=\"" + className + "\"><td>" + command
				+ "</td><td>" + description
				+ "</td><td> <br/> &nbsp;</td></tr>";
		CommonUtils.appendTextToFile(logPath, s);
	
		
	}

	@Override
	public void beforeNavigateTo(String url, WebDriver driver) {
		// System.out.println("Before navigate to " + url);

	}

	@Override
	public void afterNavigateTo(String url, WebDriver driver) {
		// System.out.println("After navigate to " + url);
		String s = "<tr class=\"success\"><td>Navigate to</td><td>" + url
				+ "</td><td> <br/> &nbsp;</td></tr>";
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
		// System.out.println("beforeFindBy");

	}

	@Override
	public void afterFindBy(By by, WebElement element, WebDriver driver) {
		lastFindBy = by;
		// String s =
		// "<tr style=\"background:#CCFFCC;\"><td>Found element</td><td>"+lastFindBy+"</td><td> <br/> &nbsp;</td></tr>";
		// appendTextToFile(reportPath, s);

	}

	@Override
	public void beforeClickOn(WebElement element, WebDriver driver) {
		// System.out.println("beforeClick");

	}

	@Override
	public void afterClickOn(WebElement element, WebDriver driver) {

		String s = "<tr class=\"success\"><td>click</td><td>" + lastFindBy
				+ "</td><td> <br/> &nbsp;</td></tr>";
		CommonUtils.appendTextToFile(logPath, s);

		// System.out.println("afterClick");

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
	public void onException(Throwable throwable, WebDriver driver) {

		//sometimes there is no ability to capture from browser, if it's not responding
		try {
			CommonUtils.captureScreenshot(screenPath + imageCounter, driver);
			CommonUtils.appendTextToFile(screenPath + imageCounter + ".html",
					driver.getPageSource());
		} catch (Exception e) {
			log("onException",
					"driver has no ability to catch screenshot or html source - driver may died",
					false);
		}
		
		//getting stacktrace of exception
		String stackTrace = Throwables.getStackTraceAsString(throwable); 
		Throwable cause = Throwables.getRootCause(throwable);
		//creating array with stacktrace
		StackTraceElement[] stacktraceElements = cause.getStackTrace();
		try {
			//looking for stacktrace element with method name findInvisibleElement when exception message is "Unable to find element"
			for (int i = 0; i < stacktraceElements.length; i++) {
				if (stacktraceElements[i].getMethodName().contains(
						"findInvisibleElement")
						&& throwable.getMessage().contains(
								"Unable to find element")) {
					//if below conditions were met:
					//exception comes from findInvisibleElement method and
					//exception message contains text "Unable to find element"
					//exception "elementIsInvisible" is thrown to be caught at the bottom
					
					throw new Exception("elementIsInvisible");
				}
				if (throwable.getMessage().contains("Timed out waiting for page load"))
				{
					throw new Exception("pageLoadTimeOut");
				}
			}
			String s1 = "<tr class=\"error\"><td>error</td><td>"
					+ stackTrace
					+ "</td><td> <br/><a href='screenshots/screenshot"
					+ imageCounter
					+ ".png'>Screenshot</a><br/><a href='screenshots/screenshot"
					+ imageCounter + ".html'>HTML Source</a></td></tr>";
			CommonUtils.appendTextToFile(logPath, s1);
			imageCounter += 1;
		} 
		catch (Exception e) {
			if (e.getMessage().equals("elementIsInvisible")) {
				String s1 = "<tr class=\"success\"><td>findInvisibleElement</td><td>element is not visible which is expected</td><td> <br/><a href='screenshots/screenshot"
						+ imageCounter
						+ ".png'>Screenshot</a><br/><a href='screenshots/screenshot"
						+ imageCounter + ".html'>HTML Source</a></td></tr>";
				CommonUtils.appendTextToFile(logPath, s1);
				imageCounter += 1;
			}
			if(e.getMessage().equals("pageLoadTimeOut"))
			{
				String s1 = "<tr class=\"success\"><td>pageLoadTimeOut</td><td>page loads for more than 30 seconds</td><td> <br/><a href='screenshots/screenshot"
						+ imageCounter
						+ ".png'>Screenshot</a><br/><a href='screenshots/screenshot"
						+ imageCounter + ".html'>HTML Source</a></td></tr>";
				CommonUtils.appendTextToFile(logPath, s1);
				imageCounter += 1;
			}
		}
	}

}
