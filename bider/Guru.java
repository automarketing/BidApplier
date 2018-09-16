package freelancer.bider;

import java.awt.AWTException;
import java.io.PrintStream;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Iterator;
import java.util.List;
import java.util.concurrent.TimeUnit;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.JCheckBox;
import javax.swing.JOptionPane;
import javax.swing.JPasswordField;
import javax.swing.JTextField;
import javax.swing.JTextPane;
import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebDriver.Options;
import org.openqa.selenium.WebDriver.Timeouts;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.opera.OperaDriver;
import org.openqa.selenium.phantomjs.PhantomJSDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;





















public class Guru
{
  public Guru() {}
  
  public static String stripNonDigits(CharSequence input)
  {
    StringBuilder sb = new StringBuilder(input.length());
    for (int i = 0; i < input.length(); i++) {
      char c = input.charAt(i);
      if ((c > '/') && (c < ':')) {
        sb.append(c);
      }
    }
    return sb.toString();
  }
  
  public String guru(JTextPane stm, String brw, String sb, String app1, String app2, String keywords, String keywords1, String amt, String time, String user, String pass, int lv, int pc, boolean cp, String flags, JCheckBox prcs, String p1, String p2, String p3, String p4, String p5, String p6, String p7, String bids, String rj, String euser, JCheckBox email, Object timer, Object os, String curl, Object miles) throws AWTException {
    String redata = null;
    
    String status = "Inititalizing Guru";
    stm.setText(status);
    
    int loop = 0;
    int pagecount = 1;
    pc += 1;
    
    int sucess = 0;int found = 0;int error = 0;
    if (os == "Windows") {
      System.setProperty("webdriver.chrome.driver", "./lib/chromedriver.exe");
      System.setProperty("webdriver.phantomjs.driver", "./lib/phantomjs.exe");
      System.setProperty("webdriver.opera.driver", "./lib/launcher.exe");
    }
    if (os == "Mac") {
      try {
        System.setProperty("webdriver.chrome.driver", "./lib/chromedriver");
      }
      catch (Exception e) {
        System.setProperty("webdriver.chrome.driver", "./lib/chromedriver.dmg");
      }
    }
    WebDriver driver = null;
    JavascriptExecutor jse = (JavascriptExecutor)driver;
    if (brw == "Chrome") {
      ChromeOptions options = new ChromeOptions();
      try {
        options.addArguments(new String[] { "--start-maximized" });
      } catch (Exception localException1) {}
      driver = new ChromeDriver(options);
    }
    else if (brw == "Opera") {
      driver = new OperaDriver();

    }
    else if (brw == "Firefox") {
      driver = new FirefoxDriver();
    }
    else
    {
      driver = new PhantomJSDriver();
    }
    

    driver.get("https://www.guru.com/login.aspx");
    
    String det = null;
    String det1 = app1;
    String det2 = app2;
    WebElement us = driver.findElement(By.name("ctl00$ContentPlaceHolder1$ucLogin$txtUserName$txtUserName_TextBox"));
    us.sendKeys(new CharSequence[] { user });
    WebElement ps = driver.findElement(By.name("ctl00$ContentPlaceHolder1$ucLogin$txtPassword$txtPassword_TextBox"));
    ps.sendKeys(new CharSequence[] { pass });
    driver.findElement(By.name("ctl00$ContentPlaceHolder1$btnLoginAccount$btnLoginAccount_Button")).click();
    status = "Signing";
    JTextField username1 = new JTextField();
    JTextField password = new JPasswordField();
    int option = 0;
    Object[] message = { "Re-type Email/Username:", username1, "Re-type Password:", password };
    


    try
    {
      WebElement err = driver.findElement(By.id("ctl00_ContentPlaceHolder1_valSummary_valSummary_ErrorText"));
      option = JOptionPane.showConfirmDialog(null, message, "Login", 2);
      String repass = password.getText();
      String reuser = username1.getText();
      driver.findElement(By.name("ctl00$ContentPlaceHolder1$ucLogin$txtUserName$txtUserName_TextBox"));
      us.sendKeys(new CharSequence[] { reuser });
      driver.findElement(By.name("ctl00$ContentPlaceHolder1$ucLogin$txtPassword$txtPassword_TextBox"));
      ps.sendKeys(new CharSequence[] { repass });
      driver.findElement(By.name("ctl00$ContentPlaceHolder1$btnLoginAccount$btnLoginAccount_Button")).click();
    }
    catch (Exception localException2) {}
    



    String ques = driver.findElement(By.id("ctl00_ContentPlaceHolder1_ucSqAnswer_lblSq")).getText();
    
    String ans = JOptionPane.showInputDialog(ques);
    driver.findElement(By.name("ctl00$ContentPlaceHolder1$ucSqAnswer$txtAns1$txtAns1_TextBox")).sendKeys(new CharSequence[] { ans });
    driver.findElement(By.name("ctl00$ContentPlaceHolder1$ucSqAnswer$btnSave$btnSave_Button")).click();
    try {
      driver.findElement(By.id("ctl00_ContentPlaceHolder1_aSkip")).click();
    }
    catch (Exception localException3) {}
    driver.manage().timeouts().implicitlyWait(5L, TimeUnit.SECONDS);
    try {
      Thread.sleep(5000L);
    } catch (InterruptedException ex) {
      Logger.getLogger(Freelancer.class.getName()).log(Level.SEVERE, null, ex);
    }
    while (loop < lv) {
      if (curl.isEmpty()) {
        driver.get("http://www.guru.com/d/jobs/pg/" + pagecount + "/");
      } else {
        driver.get(curl + "/" + pagecount + "/");
      }
      


      WebElement table = driver.findElement(By.id("serviceList"));
      status = "Reading Jobs";
      List<WebElement> title = table.findElements(By.cssSelector(".servTitle a"));
      
      List<WebElement> skills = table.findElements(By.cssSelector(".skills"));
      int ts = title.size() - 20;
      int c = 0;
      String str = keywords;
      String str1 = keywords1;
      
      List<String> strlist = new ArrayList();
      List<String> keysall = new ArrayList();
      ArrayList keys = new ArrayList(Arrays.asList(str.split(",")));
      ArrayList keys1 = new ArrayList(Arrays.asList(str1.split(",")));
      String br = System.getProperty("line.separator");
      for (int i = 0; i < ts; i++)
      {
        if (sb.equals("Job Title")) {
          keysall.add(((WebElement)title.get(i)).getText());
        }
        
        if (sb.equals("Skills")) {
          keysall.add(((WebElement)skills.get(i)).getText());
        }
        


        strlist.add(((WebElement)title.get(i)).getAttribute("href"));
        strlist.remove("http://www.guru.com/d/jobs/#");
        
        System.out.print(strlist);
      }
      


      for (Iterator<String> it = strlist.iterator(); it.hasNext();) {
        try {
          int res = 0;
          
          if (!str.isEmpty()) {
            for (Object word : keys) {
              if (((String)keysall.get(c)).toLowerCase().contains((CharSequence)word)) {
                res = 1;
              }
            }
          }
          if (!str1.isEmpty())
          {
            for (Object word1 : keys1) {
              if (((String)keysall.get(c)).toLowerCase().contains((CharSequence)word1)) {
                res = 2;
              }
            }
          }
          


          if (rj == "Read all jobs from the listing page") {
            driver.get((String)strlist.get(c));
          }
          if ((res == 1) || (res == 2)) {
            found += 1;
            
            if (res == 1) det = det1;
            if (res == 2) det = det2;
            if (rj == "Read only keywords matched jobs") {
              driver.get((String)strlist.get(c));
            }
            

            status = "Applying At Guru Job";
            WebElement bid = driver.findElement(By.id("ctl00_guB_btnSubmit"));
            bid.click();
            if (cp == true) {
              if (res == 1)
              {
                Freelancer.setClipboardContents(det1);
              }
              if (res == 2)
              {
                Freelancer.setClipboardContents(det2);
              }
            }
            
            WebElement drop = driver.findElement(By.className("niceInput"));
            drop.click();
            int sel = 0;
            
            switch (miles.toString()) {
            case "Placeholder bid": 
              driver.findElement(By.xpath("//*[contains(text(), 'Placeholder bid')]")).click();
              
              sel = 1;
              
              break;
            case "Hourly by time tracked": 
              driver.findElement(By.xpath("//*[contains(text(), 'Hourly by time tracked')]")).click();
              
              sel = 2;
              

              break;
            case "Fixed Price by milestone": 
              driver.findElement(By.xpath("//*[contains(text(), 'Fixed Price by milestone')]")).click();
              
              sel = 3;
              break;
            case "Recurring payments": 
              driver.findElement(By.xpath("//*[contains(text(), 'Recurring payments')]")).click();
              
              sel = 4;
            }
            
            






            WebElement detail = driver.findElement(By.className("fr-view"));
            
            if (cp == true) {
              detail.sendKeys(new CharSequence[] { Keys.CONTROL + "v" });
              driver.findElement(By.id("manualAcceptRadio")).click();
            }
            








            if (!cp) {
              detail.sendKeys(new CharSequence[] { det });
            }
            

            WebDriverWait wait = new WebDriverWait(driver, 8000L);
            wait.until(ExpectedConditions.elementToBeClickable(By.cssSelector("button.module_btn.primary_btn.large_btn")));
            driver.findElement(By.cssSelector("button.module_btn.primary_btn.large_btn")).click();
            
            Thread.sleep(5000L);
            
            sucess += 1;
          }
          else {
            c++;
          }
        }
        catch (Exception e)
        {
          error += 1;
          
          System.out.println(e);
          c++;
        }
      }
      
      redata = "Guru Result: Founded: " + Integer.toString(found) + " Success:" + Integer.toString(sucess) + " Error:" + Integer.toString(error);
      if (pagecount != pc) {
        pagecount++;
      }
      if (pagecount == pc) {
        pagecount = 1;
      }
      loop++;
    }
    JOptionPane.showMessageDialog(null, redata);
    
    driver.close();
    return redata;
  }
}
