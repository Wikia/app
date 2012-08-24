package com.wikia.webdriver.Common.Core;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;

import org.apache.commons.io.FileUtils;
import org.openqa.selenium.OutputType;
import org.openqa.selenium.TakesScreenshot;
import org.openqa.selenium.WebDriver;

public class CommonUtils {
	
	
	
	/**
	 * appends given text to specified file
	 * 
	 * @param filePath
	 * @param textToWrite
	 * @author Karol Kujawiak
	 */
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
				System.out.println("ERROR in saveTextToFile(2 args) in CommonUtils.java \n"+ e.getMessage());
			}
		}
	
	
	/**
	 * captures screenshot with given path, returns output file path
	 * @param outputFilePath
	 * @param driver
	 * @return captured screen path
	 * @author Karol Kujawiak
	 */
	public static String captureScreenshot(String outputFilePath, WebDriver driver) 
	{
		if (Global.LOG_VERBOSE == 2)
		{
			if (!outputFilePath.endsWith(".png"))
			outputFilePath = outputFilePath + ".png";
			File scrFile = ((TakesScreenshot) driver).getScreenshotAs(OutputType.FILE);
			try {
				FileUtils.copyFile(scrFile, new File(outputFilePath));
			} 
			catch (IOException e) 
			{
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			return outputFilePath;
		}
		else
		{			
			return "Switch Global.LOG_VERBOSE to get test screenshots";
		}
	}
	
	
	/**
	 * delete directory by path
	 * @param fileName
	 * @author Karol Kujawiak
	 */
	public static void deleteDirectory(String dirName)
	{
		try {
			FileUtils.deleteDirectory(new File(dirName));
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	/**
	 * creates directory based on given path
	 * @param fileName
	 * @author Karol Kujawiak
	 */
	public static void createDirectory(String fileName)
	{
		new File(fileName).mkdir();
	}
	
	
//	public static void createFile(String filePath, String content)
//	{
//		try {
//			File file = new File(filePath);
//			FileWriter newfile = new FileWriter(file);
//			BufferedWriter out = new BufferedWriter(newfile);
//			out.write(content);
//			out.flush();
//			out.close();
//		} 
//		catch (IOException e) 
//		{
//			System.out.println("ERROR in createFile) in CommonUtils.java \n"+ e.getMessage());
//			// TODO Auto-generated catch block
//			e.printStackTrace();
//		}
//	}

}
