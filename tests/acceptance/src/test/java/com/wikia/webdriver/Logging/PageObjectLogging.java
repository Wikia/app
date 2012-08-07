package com.wikia.webdriver.Logging;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;

import net.sourceforge.htmlunit.corejs.javascript.tools.shell.Global;

import org.apache.commons.io.FileUtils;
import org.openqa.selenium.By;
import org.openqa.selenium.OutputType;
import org.openqa.selenium.TakesScreenshot;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.events.WebDriverEventListener;



public class PageObjectLogging implements WebDriverEventListener{

	private By lastFindBy;
	
	private static String reportPath = "c:/log.html";
	
	public static void startLogging(String className)
	{
			String l1 = "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\"><style>td { border-top: 1px solid grey; } </style></head><body>";
			String l2 = "<h1>Class: <em>"+className+"</em></h1>";
			String l3 = "<table>";
			appendTextToFile("c:/log.html", l1);
			appendTextToFile("c:/log.html", l2);
			appendTextToFile("c:/log.html", l3);
	}
	
	public static void log(String command, String description, boolean success)
	{
		String hexColor = success ? "#CCFFCC" : "#FFCCCC";
		String s = "<tr style=\"background:"+hexColor+";\"><td>"+command+"</td><td>s"+description+"</td><td> <br/> &nbsp;</td></tr>";
		appendTextToFile(reportPath, s);
	}
	

	
	@Override
	public void beforeNavigateTo(String url, WebDriver driver) {
		System.out.println("Before navigate to " + url);
		
	}

	@Override
	public void afterNavigateTo(String url, WebDriver driver) {
		System.out.println("After navigate to " + url);
		String s = "<tr style=\"background:#CCFFCC;\"><td>Navigate to</td><td>"+url+"</td><td> <br/> &nbsp;</td></tr>";
		appendTextToFile(reportPath, s);
		
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
		System.out.println("beforeFindBy");
		
	}

	@Override
	public void afterFindBy(By by, WebElement element, WebDriver driver) {
		lastFindBy = by;
		String s = "<tr style=\"background:#CCFFCC;\"><td>Found element</td><td>"+lastFindBy+"</td><td> <br/> &nbsp;</td></tr>";
		appendTextToFile(reportPath, s);

	}

	@Override
	public void beforeClickOn(WebElement element, WebDriver driver) {
		System.out.println("beforeClick");
		
	}

	@Override
	public void afterClickOn(WebElement element, WebDriver driver) {
		
		String s = "<tr style=\"background:#CCFFCC;\"><td>click</td><td>"+lastFindBy+"</td><td> <br/> &nbsp;</td></tr>";
		appendTextToFile(reportPath, s);

		System.out.println("afterClick");
		
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
		System.out.println(throwable.toString());
		
	}

	public static void appendTextToFile(String filePath, String textToWrite) {
		try {
			boolean append;
			File file = new File(filePath);
			if (!file.exists())
			{
				append = false;
			}
			else
			{
				append = true;
			}
			FileWriter newFile = new FileWriter(filePath, true);
			BufferedWriter out = new BufferedWriter(newFile);
			out.write(textToWrite);
			out.newLine();
			out.flush();
			out.close();
			} catch (Exception e) 
			{
				System.out.println("ERROR in saveTextToFile(2 args) in Utils.java \n"+ e.getMessage());
			}
		}

	public String captureScreenshot(String outputFilePath, WebDriver driver) {
		if (!outputFilePath.endsWith(".png"))
			outputFilePath = outputFilePath + ".png";
		File scrFile = ((TakesScreenshot) driver).getScreenshotAs(OutputType.FILE);
		try {
			FileUtils.copyFile(scrFile, new File(outputFilePath));
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return outputFilePath;
	}
	
}
