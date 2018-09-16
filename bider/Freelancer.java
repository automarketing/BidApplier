package freelancer.bider;

import java.awt.AWTException;
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
import javax.swing.JLabel;
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
import org.openqa.selenium.support.ui.WebDriverWait;






















public class Freelancer
{
  public Freelancer() {}
  
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
  
  public String freelancer(JTextPane stm, String brw, String sb, String app1, String app2, String keywords, String keywords1, String amt, String time, String user, String pass, int lv, int pc, boolean cp, String flags, JCheckBox prcs, String p1, String p2, String p3, String p4, String p5, String p6, String p7, String bids, String rj, String euser, JCheckBox email, JLabel starttime, JLabel stoptime, Object timer, Object os, String curl) throws AWTException, Exception {
    String redata = null;
    Date date = new Date();
    
    String record = date.toString();
    
    String status = "Inititalizing Freelancer";
    Notification notice = new Notification("E-Applier Status", "Launching & Initializing browser");
    
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
    


    String det = null;
    String det1 = app1;
    String det2 = app2;
    
    driver.get("https://www.freelancer.com/?utm_expid=294858-385.QJo86J5YTZaTUq0S8t83Gg.0&utm_referrer=https%3A%2F%2Fwww.freelancer.com%2F#");
    
    JavascriptExecutor js = (JavascriptExecutor)driver;
    


    JTextField username1 = new JTextField();
    JTextField password = new JPasswordField();
    int option = 0;
    
    Object[] message = { "Re-type Email/Username:", username1, "Re-type Password:", password };
    



    driver.findElement(By.xpath("//a[@class='LandingHeader-link']")).click();
    WebElement us = driver.findElement(By.name("username"));
    us.sendKeys(new CharSequence[] { user });
    WebElement ps = driver.findElement(By.name("passwd"));
    ps.sendKeys(new CharSequence[] { pass });
    driver.findElement(By.id("login-bt")).click();
    stm.setText("Logging");
    try {
      String log = driver.findElement(By.id("login-error")).getText();
      if (log.contains("Oops! The login details you entered were incorrect.")) {
        JOptionPane.showConfirmDialog(null, message, "Login", 2);
        System.out.println("Login Failed");
        if (option == 0) {
          String usr = username1.getText();
          String psr = password.getText();
          us.clear();
          us.sendKeys(new CharSequence[] { usr });
          ps.clear();
          ps.sendKeys(new CharSequence[] { psr });
          driver.findElement(By.id("login-bt")).click();
        }
      }
    }
    catch (Exception localException2) {}
    

    String lt = timer.toString();
    Long timeset = new Long(lt);
    System.out.print(timeset);
    
    driver.manage().timeouts().implicitlyWait(timeset.longValue(), TimeUnit.SECONDS);
    try {
      Thread.sleep(5000L);
    } catch (InterruptedException ex) {
      Logger.getLogger(Freelancer.class.getName()).log(Level.SEVERE, null, ex);
    }
    int bds = Integer.parseInt(bids);
    

    while (loop < lv) {
      if (curl.isEmpty()) {
        driver.get("https://www.freelancer.com/jobs/" + pagecount + "/");
      } else {
        driver.get(curl + "/" + pagecount + "/");
      }
      

      WebElement table = driver.findElement(By.id("project_table"));
      status = status + System.lineSeparator() + "Reading Jobs";
      stm.setText(status);
      Notification notice1 = new Notification("E-Applier", "Application will take some time at this page to collect your jobs, don't close or interupt.");
      



      List<WebElement> title = table.findElements(By.xpath("//h2[@class='ProjectTable-title']//a"));
      List<WebElement> skills = table.findElements(By.className("ProjectTable-skills"));
      









      int c = 0;
      String str = keywords;
      String str1 = keywords1;
      
      List<String> strlist = new ArrayList();
      List<String> all = new ArrayList();
      List<String> cclose = new ArrayList();
      

      ArrayList keys = new ArrayList(Arrays.asList(str.split(",")));
      ArrayList keys1 = new ArrayList(Arrays.asList(str1.split(",")));
      ArrayList filterflag = new ArrayList(Arrays.asList(flags.split(",")));
      
      ArrayList keysall = new ArrayList();
      keysall.addAll(keys);
      keysall.addAll(keys1);
      
      for (int i = 0; i < title.size(); i++) {
        if (sb.equals("Job Title")) {
          all.add(((WebElement)title.get(i)).getText());
        }
        

        if (!sb.equals("Job Title"))
        {
          all.add(((WebElement)skills.get(i)).getText());
        }
        

        System.out.println(keysall);
        
        strlist.add(((WebElement)title.get(i)).getAttribute("href"));
      }
      








      System.out.print(strlist);
      
      for (Iterator<String> it = strlist.iterator(); it.hasNext();)
      {

        try
        {
          int res = 0;
          
          if (!str.isEmpty()) {
            for (Object word : keys) {
              if (((String)all.get(c)).toLowerCase().contains((CharSequence)word)) {
                res = 1;
              }
            }
          }
          if (!str1.isEmpty())
          {
            for (Object word1 : keys1) {
              if (((String)all.get(c)).toLowerCase().contains((CharSequence)word1)) {
                res = 2;
              }
            }
          }
          String string = (String)it.next();
          
          if (rj == "Read all jobs from the listing page") {
            driver.get((String)strlist.get(c));
          }
          
          if ((res == 1) || (res == 2))
          {
            if (res == 1) { det = det1;
            }
            if (res == 2) det = det2;
            if (rj == "Read only keywords matched jobs") {
              driver.get((String)strlist.get(c));
            }
            try {
              WebElement chatbox = driver.findElement(By.className("contacts-header"));
              chatbox.click();
            }
            catch (Exception localException3) {}
            int cc;
            try {
              List<WebElement> messages = driver.findElements(By.className("chat_close"));
              int clp = messages.size();
              
              for (cc = 0; cc <= clp; cc++) {
                ((WebElement)messages.get(cc)).click();
              }
              System.out.println("Chat messages found" + clp);

            }
            catch (Exception e)
            {
              System.out.println("Noooo Chat messages found");
            }
            
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
            
            boolean cf = true;
            if (!flags.isEmpty()) {
              WebElement country = driver.findElement(By.cssSelector(".user-flag img"));
              for (Object resc : filterflag) {
                if (country.getAttribute("alt").toLowerCase().contains((CharSequence)resc)) {
                  cf = false;
                  System.out.println("country restricted");
                }
              }
              

              System.out.println("/n countrryyyyyyyyy" + country.getAttribute("alt"));
            }
            if (cf == true)
            {
              System.out.println("Country allowed");
              try {
                WebElement applied = driver.findElement(By.className("alert-success"));
                if (applied.getText().contains("Great! Your bid has been placed successfully! Good job!")) {
                  System.out.println("Already Applied");
                  found = found;
                }
              }
              catch (Exception e) {
                System.out.println("Not Applied");
                
                found += 1;
              }
              
              status = status + System.lineSeparator() + "Applying At Freelancer";
              stm.setText(status);
              
              WebElement bid = driver.findElement(By.linkText("Bid on This Project"));
              bid.click();
              boolean hourly = false;
              String fincost = null;
              

              WebElement budget = driver.findElement(By.className("project-budget"));
              String bud = budget.getText();
              int pos = bud.indexOf("-") + 3;
              String amts = bud.substring(pos);
              amts = stripNonDigits(amts);
              int total = Integer.parseInt(amts);
              int budg = Integer.parseInt(amt);
              int amount = budg * total / 100;
              if (bud.contains("hr")) {
                hourly = true;
              }
              if (!hourly)
              {
                fincost = Integer.toString(amount);
                



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
                  fincost = Integer.toString(amount);
                }
                

                WebDriverWait wdw = new WebDriverWait(driver, 10L);
                

                if (!amt.isEmpty()) {
                  WebElement cost = driver.findElement(By.name("sum"));
                  cost.clear();
                  cost.sendKeys(new CharSequence[] { fincost });
                }
                if (!time.isEmpty()) {
                  WebElement duration = driver.findElement(By.name("period"));
                  duration.clear();
                  duration.sendKeys(new CharSequence[] { time });
                }
              }
              try {
                int ph = driver.findElements(By.id("place-bid")).size();
                ((WebElement)driver.findElements(By.id("place-bid")).get(ph - 1)).click();
              } catch (Exception e) {
                WebDriverWait wdw = new WebDriverWait(driver, timeset.longValue());
                driver.findElement(By.id("place-bid")).click();
              }
              
              try
              {
                WebElement cancel = driver.findElement(By.linkText("No, thanks!"));
                cancel.click();
              } catch (Exception e) {
                WebDriverWait wdw = new WebDriverWait(driver, timeset.longValue());
                WebElement cancel = driver.findElement(By.linkText("No, thanks!"));
                cancel.click();
              }
              



              if (cp == true) {
                try
                {
                  driver.findElement(By.name("descr")).sendKeys(new CharSequence[] { Keys.CONTROL + "v" });
                  
                  driver.findElement(By.id("place-bid-step2")).click();
                  stm.setText("Application Successfully Placed");
                  
                  sucess += 1;
                  
                  WebElement cancel2 = driver.findElement(By.linkText("No, thanks!"));
                  cancel2.click();
                } catch (Exception e) {
                  WebDriverWait wdw = new WebDriverWait(driver, timeset.longValue());
                  System.out.println("Waiting");
                  

                  driver.findElement(By.id("place-bid-step2")).click();
                  stm.setText("Application Successfully Placed");
                  
                  sucess += 1;
                  
                  WebElement cancel2 = driver.findElement(By.linkText("No, thanks!"));
                  cancel2.click();
                }
              }
              
              if (!cp) {
                driver.findElement(By.name("descr")).sendKeys(new CharSequence[] { det });
                driver.findElement(By.id("place-bid-step2")).click();
                stm.setText("Application Successfully Placed");
                sucess += 1;
                WebElement cancel2 = driver.findElement(By.linkText("No, thanks!"));
                cancel2.click();
              }
            }
            
            if (!cf) {
              c++;
            }
            

          }
          else
          {

            c++;
          }
          

        }
        catch (Exception e)
        {
          error += 1;
          System.out.println(e);
          c++;
        }
        


        redata = "Freelancer Result: Founded: " + Integer.toString(found) + " Success:" + Integer.toString(sucess);
        

        stm.setText(redata);
        if (bds == sucess) {
          it.remove();
          redata = "Freelancer Result: Founded: " + Integer.toString(found) + " Success:" + Integer.toString(sucess);
          stm.setText(redata);
          new Email(euser, "E-Applier Result Report " + date.toString(), "Progress/Result Report:" + redata);
          
          JOptionPane.showMessageDialog(null, redata);
          
          driver.close();
          stoptime.setText("Stoped: " + record);
          
          return redata;
        }
      }
      


      if (pagecount != pc) {
        pagecount++;
      }
      if (pagecount == pc) {
        pagecount = 1;
      }
      loop++;
    }
    
    if (email.isSelected()) {
      new Email(euser, "E-Applier Result Report " + date.toString(), "Progress/Result Report:" + redata);
    }
    JOptionPane.showMessageDialog(null, redata);
    stoptime.setText("Stoped: " + record);
    
    driver.close();
    return redata;
  }
  
  public static void setClipboardContents(String text)
  {
    StringSelection stringSelection = new StringSelection(text);
    Clipboard clipboard = Toolkit.getDefaultToolkit().getSystemClipboard();
    clipboard.setContents(stringSelection, null);
  }
  

  public static void auth() {}
  
  String freelancer(String brw, String sb, String desc, String keywords, String amt, String time, String user, String pass, int rec, int pc, boolean cp, JTextPane stm)
  {
    throw new UnsupportedOperationException("Not supported yet.");
  }
}
