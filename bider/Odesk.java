package freelancer.bider;

import java.awt.AWTException;
import java.awt.Robot;
import java.awt.Toolkit;
import java.awt.datatransfer.Clipboard;
import java.awt.datatransfer.StringSelection;
import java.io.PrintStream;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Date;
import java.util.Iterator;
import java.util.List;
import java.util.concurrent.TimeUnit;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.JCheckBox;
import javax.swing.JOptionPane;
import javax.swing.JTextField;
import javax.swing.JTextPane;
import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.Keys;
import org.openqa.selenium.NoSuchElementException;
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









public class Odesk
{
  private Object capt;
  
  public Odesk() {}
  
  public String odesk(JTextPane stm, String brw, String sb, String app1, String app2, String keywords, String keywords1, String amt, String amth, String time, String user, String pass, int lv, int pc, boolean cp, String flags, JCheckBox prcs, String p1, String p2, String p3, String p4, String p5, String p6, String p7, String bids, String rj, String euser, JCheckBox email, Object timer, Object os, String uj)
    throws AWTException, Exception
  {
    String redata = null;
    
    String status = "Inititalizing Upwork";
    stm.setText(status);
    
    int loop = 0;
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
    

    driver.get("https://www.upwork.com/Login");
    
    String det = null;
    String det1 = app1;
    String det2 = app2;
    int option = 0;
    JTextField security = new JTextField();
    try {
      driver.findElement(By.name("login[username]")).sendKeys(new CharSequence[] { user });
      driver.findElement(By.name("login[password]")).sendKeys(new CharSequence[] { pass });
      driver.findElement(By.tagName("button")).click();
    } catch (Exception localException2) {}
    try {
      WebElement captcha = driver.findElement(By.id("login_captcha"));
      



      JOptionPane.showConfirmDialog(null, security, "Enter Captcha", 2);
      System.out.println("Login Failed");
      if (option == 0) {
        String usr = security.getText();
        captcha.sendKeys(new CharSequence[] { usr });
      }
      driver.findElement(By.tagName("button")).click();
    }
    catch (Exception localException3) {}
    

    status = "Signing At Upwork";
    
    stm.setText(status);
    Notification notice = new Notification("E-Applier Status", "Launching & Initializing browser");
    

    int bds = Integer.parseInt(bids);
    

    while (loop < lv) {
      System.out.println("Loop value" + loop);
      driver.get("https://www.upwork.com/ab/find-work/");
      WebElement table = driver.findElement(By.id("feed-jobs"));
      status = "Reading Jobs";
      ArrayList<Integer> click = new ArrayList();
      int resjobs = Integer.parseInt(uj);
      resjobs /= 10;
      String lt = timer.toString();
      Long timeset = new Long(lt);
      for (int rc = 1; rc <= resjobs; rc++) {
        System.out.println("Jobs input" + resjobs);
        click.add(Integer.valueOf(rc));
      }
      int wt = resjobs / 2;
      WebDriverWait wait = new WebDriverWait(driver, wt);
      stm.setText(status);
      Notification notice1 = new Notification("E-Applier", "Application will take some time at this page to collect your jobs, don't close or interupt.");
      
      int load = 0;
      for (Object mr : click) {
        try {
          driver.findElement(By.id("load-more-button")).click();
          System.out.print("CLicked");
          load += 1;
        }
        catch (Exception localException4) {}
      }
      System.out.println("load size" + load + "clickSize" + click.size());
      
      if (load == click.size())
      {
        wait.until(ExpectedConditions.visibilityOfElementLocated(By.className("job-title-link")));
        
        Object title = table.findElements(By.className("job-title-link"));
        
        wait.until(ExpectedConditions.visibilityOfElementLocated(By.className("job-title-link")));
        
        driver.manage().timeouts().implicitlyWait(timeset.longValue(), TimeUnit.SECONDS);
        try {
          Thread.sleep(5000L);
        } catch (InterruptedException ex) {
          Logger.getLogger(Freelancer.class.getName()).log(Level.SEVERE, null, ex);
        }
        int c = 0;
        String str = keywords;
        String str1 = keywords1;
        
        List<String> strlist = new ArrayList();
        List<String> all = new ArrayList();
        int count = 0;
        ArrayList keys = new ArrayList(Arrays.asList(str.split(",")));
        ArrayList keys1 = new ArrayList(Arrays.asList(str1.split(",")));
        
        System.out.println("Title Size" + ((List)title).size());
        
        for (int i = 0; i <= ((List)title).size(); i++) {
          try {
            ((WebElement)driver.findElements(By.className("eo-truncate-toggle-text")).get(i)).click();
          } catch (Exception localException5) {}
          count++;
        }
        
        System.out.println("COunt" + count + "Size" + ((List)title).size());
        if (count == ((List)title).size() + 1) {
          List<WebElement> skills = table.findElements(By.className("js-skills"));
          System.out.println(skills.size());
          if (sb.equals("Job Title"))
          {
            for (int i = 0; i < ((List)title).size(); i++) {
              all.add(((WebElement)((List)title).get(i)).getText());
              strlist.add(((WebElement)((List)title).get(i)).getAttribute("href"));
            }
          }
          if (!sb.equals("Job Title"))
          {
            for (int i = 0; i <= skills.size(); i++) {
              try {
                all.add(((WebElement)skills.get(i)).getText());
                strlist.add(((WebElement)((List)title).get(i)).getAttribute("href"));
                
                System.out.println(((WebElement)skills.get(i)).getText() + System.lineSeparator());
                System.out.println(((WebElement)((List)title).get(i)).getAttribute("href") + System.lineSeparator());
              } catch (Exception ef) {
                System.out.print("skills not define or found");
              }
            }
          }
        }
        


        for (Iterator<String> it = strlist.iterator(); it.hasNext();) {
          if (it.hasNext())
          {
            try
            {

              int res = 0;
              
              if (!str.isEmpty()) {
                for (Object word : keys) {
                  if (((String)all.get(c)).toLowerCase().contains((CharSequence)word)) {
                    System.out.println("res found1" + ((String)all.get(c)).toLowerCase());
                    res = 1;
                  }
                }
              }
              
              if (!str1.isEmpty())
              {
                for (Object word1 : keys1) {
                  if (((String)all.get(c)).toLowerCase().contains((CharSequence)word1)) {
                    System.out.println("res found2" + ((String)all.get(c)).toLowerCase());
                    
                    res = 2;
                  }
                }
              }
              


              if (rj == "Read all jobs from the listing page") {
                driver.get((String)strlist.get(c));
              }
              
              if ((res == 1) || (res == 2)) {
                found += 1;
                System.out.println("JObs" + (String)strlist.get(c));
                
                if (rj == "Read only keywords matched jobs")
                {
                  driver.get((String)strlist.get(c));
                }
                

                boolean al = false;
                status = "Applying At Upwork";
                stm.setText(status);
                
                WebElement bid = driver.findElement(By.className("btn-primary"));
                bid.click();
                
                boolean hourly = false;
                if (cp == true) {
                  if (res == 1)
                  {
                    setClipboardContents(det1);
                  }
                  if (res == 2)
                  {
                    setClipboardContents(det2);
                  }
                }
                try
                {
                  WebElement jt = driver.findElement(By.xpath("//*[contains(text(), 'Hourly')]"));
                  hourly = true;
                }
                catch (NoSuchElementException localNoSuchElementException) {}
                System.out.println("Hourlyyy:" + hourly);
                if (hourly == true)
                {


                  WebElement cost = driver.findElement(By.id("chargedAmount"));
                  String bud = cost.getAttribute("value");
                  System.out.println("Job Budget:" + bud);
                  if (!amth.isEmpty())
                  {
                    cost.clear();
                    cost.sendKeys(new CharSequence[] { amth });
                    
                    System.out.println("placed hourly Budget" + amth);
                  }
                }
                if (!hourly)
                {


                  WebElement cost = driver.findElement(By.id("chargedAmount"));
                  String strb = cost.getAttribute("value");
                  


                  double d = Double.parseDouble(strb);
                  int total = (int)d;
                  int budg = Integer.parseInt(amt);
                  int perc = budg * total / 100;
                  
                  System.out.println("Job Budget:" + total + "User Amount" + amt + "Percent of budget" + perc);
                  if (!amt.isEmpty()) {
                    String fincost = Integer.toString(perc);
                    if ((total == 100) && (!p1.isEmpty())) {
                      fincost = p1;
                    }
                    else if ((total == 250) && (!p2.isEmpty())) {
                      fincost = p2;
                    }
                    else if ((total == 500) && (!p3.isEmpty())) {
                      fincost = p3;
                    }
                    else if ((total == 750) && (!p4.isEmpty())) {
                      fincost = p4;
                    } else if ((total == 1500) && (!p5.isEmpty())) {
                      fincost = p5;
                    }
                    else if ((total == 3000) && (!p6.isEmpty())) {
                      fincost = p6;
                    } else if ((total == 5000) && (!p7.isEmpty())) {
                      fincost = p7;
                    }
                    else
                    {
                      fincost = Integer.toString(perc);
                    }
                    cost.clear();
                    cost.sendKeys(new CharSequence[] { fincost });
                    
                    System.out.println("placed Budget" + amt);
                  }
                  

                  WebElement drop = driver.findElement(By.xpath("//*[contains(text(), 'Please Select ..')]"));
                  drop.click();
                  
                  int sel = 0;
                  
                  switch (time) {
                  case "1-week": 
                    driver.findElement(By.xpath("//*[contains(text(), 'Less than 1 week')]")).click();
                    
                    sel = 1;
                    
                    break;
                  case "1-month": 
                    driver.findElement(By.xpath("//*[contains(text(), 'Less than 1 month')]")).click();
                    
                    sel = 2;
                    

                    break;
                  case "1-3 month": 
                    driver.findElement(By.xpath("//*[contains(text(), '1 to 3 months')]")).click();
                    
                    sel = 3;
                    break;
                  case "3-6 month": 
                    driver.findElement(By.xpath("//*[contains(text(), '3 to 6 months')]")).click();
                    
                    sel = 4;
                    break;
                  case "More than 6-month": 
                    driver.findElement(By.xpath("//*[contains(text(), 'More than 6 months')]")).click();
                    
                    sel = 5;
                  }
                  
                  



                  WebElement ul = driver.findElement(By.className("dropdown-menu"));
                  
                  Object li = ul.findElements(By.tagName("li"));
                  Robot localRobot = new Robot();
                }
                

                if (cp == true)
                {
                  WebElement desc = driver.findElement(By.name("coverLetter"));
                  desc.sendKeys(new CharSequence[] { Keys.CONTROL + "v" });
                }
                
                if (!cp) {
                  WebElement desc = driver.findElement(By.name("coverLetter"));
                  desc.sendKeys(new CharSequence[] { det });
                }
                
                WebElement fs = driver.findElement(By.xpath("//*[contains(text(), 'Submit A Proposal')]"));
                WebElement fsp = driver.findElement(By.className("btn-primary"));
                fsp.click();
                try
                {
                  fsp.click();
                }
                catch (Exception e) {
                  Thread.sleep(1000L);fs.click();
                }
                
                if (!hourly) {
                  try {
                    driver.findElement(By.className("checkbox-replacement-helper")).click();
                    driver.findElement(By.xpath("//*[contains(text(), 'Continue to submit')]")).click();
                  }
                  catch (Exception e) {
                    Thread.sleep(1000L);
                    driver.findElement(By.className("checkbox-replacement-helper")).click();
                    driver.findElement(By.xpath("//*[contains(text(), 'Continue to submit')]")).click();
                  }
                }
                
                sucess += 1;
                c++;
              }
            }
            catch (Exception e)
            {
              System.out.println(e);
              c++;
            }
          }
          
          redata = "Upwork Result: Founded: " + Integer.toString(found) + " Success:" + Integer.toString(sucess);
          stm.setText(redata);
          if (bds == sucess) {
            it.remove();
            redata = "Freelancer Result: Founded: " + Integer.toString(found) + " Success:" + Integer.toString(sucess);
            stm.setText(redata);
            Date date = new Date();
            new Email(euser, "E-Applier Result Report " + date.toString(), "Progress/Result Report:" + redata);
            
            JOptionPane.showMessageDialog(null, redata);
            
            driver.close();
            
            return redata;
          }
        }
        
        loop++;
      }
    }
    if (email.isSelected()) {
      Date date = new Date();
      new Email(euser, "E-Applier Result Report " + date.toString(), "Progress/Result Report:" + redata);
    }
    JOptionPane.showMessageDialog(null, redata);
    driver.close();
    return redata;
  }
  
  public static void setClipboardContents(String text) { StringSelection stringSelection = new StringSelection(text);
    Clipboard clipboard = Toolkit.getDefaultToolkit().getSystemClipboard();
    clipboard.setContents(stringSelection, null);
  }
}
