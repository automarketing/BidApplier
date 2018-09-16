package freelancer.bider;

import java.awt.AWTException;
import java.awt.Toolkit;
import java.awt.datatransfer.Clipboard;
import java.awt.datatransfer.StringSelection;
import java.io.PrintStream;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Iterator;
import java.util.List;
import java.util.concurrent.TimeUnit;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.JOptionPane;
import javax.swing.JTextPane;
import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebDriver.Options;
import org.openqa.selenium.WebDriver.Timeouts;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.opera.OperaDriver;
import org.openqa.selenium.phantomjs.PhantomJSDriver;





















public class Pph
{
  public Pph() {}
  
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
  
  public String pph(JTextPane stm, String app, String app2, String keywords, String keywords2, String amt, String user, String pass, int lv, String brw, boolean cp) throws AWTException { String redata = null;
    String status = "Inititalizing PeoplePerHour";
    stm.setText(status);
    
    int loop = 0;
    int sucess = 0;int found = 0;int error = 0;
    
    System.setProperty("webdriver.chrome.driver", "./lib/chromedriver.exe");
    System.setProperty("webdriver.phantomjs.driver", "./lib/phantomjs.exe");
    
    WebDriver driver = null;
    if (brw == "Live Browser") {
      driver = new ChromeDriver();
    }
    if (brw == "Opera") {
      driver = new OperaDriver();
    }
    
    if (brw == "Background")
    {

      driver = new PhantomJSDriver();
    }
    

    driver.get("https://www.peopleperhour.com/site/login?next=http%3A%2F%2Fwww.peopleperhour.com%2Ffreelance-jobs");
    
    String detail = app;
    String detail2 = app2;
    
    driver.findElement(By.id("LoginForm_email")).sendKeys(new CharSequence[] { user });
    driver.findElement(By.id("LoginForm_password")).sendKeys(new CharSequence[] { pass });
    driver.findElement(By.name("yt0")).click();
    status = "Signing at PeoplePerHour";
    stm.setText(status);
    
    driver.manage().timeouts().implicitlyWait(5L, TimeUnit.SECONDS);
    try {
      Thread.sleep(5000L);
    } catch (InterruptedException ex) {
      Logger.getLogger(Freelancer.class.getName()).log(Level.SEVERE, null, ex);
    }
    while (loop < lv)
    {
      WebElement table = driver.findElement(By.id("job-listing-listview"));
      status = "Reading Jobs at PeoplePerHour";
      stm.setText(status);
      
      List<WebElement> title = table.findElements(By.className("job"));
      
      int c = 0;
      String str = keywords;
      String str2 = keywords2;
      
      List<String> strlist = new ArrayList();
      List<String> all = new ArrayList();
      ArrayList keys = new ArrayList(Arrays.asList(str.split(",")));
      ArrayList keys2 = new ArrayList(Arrays.asList(str2.split(",")));
      ArrayList keysall = new ArrayList();
      keysall.addAll(keys);
      keysall.addAll(keys2);
      Object word; for (int i = 0; i < title.size(); i++) {
        all.add(((WebElement)title.get(i)).getText());
        
        for (Iterator localIterator = keysall.iterator(); localIterator.hasNext();) { word = localIterator.next();
          if (((String)all.get(i)).toLowerCase().contains((CharSequence)word)) {
            strlist.add(((WebElement)title.get(i)).getAttribute("href"));
          }
        }
        

        System.out.print(all);
      }
      

      for (Iterator<String> it = strlist.iterator(); it.hasNext();)
      {
        try
        {
          int res = 0;
          

          for (Object word : keys) {
            if (((String)all.get(c)).toLowerCase().contains((CharSequence)word)) {
              res = 1;
            }
          }
          
          for (Object word2 : keys2) {
            if (((String)all.get(c)).toLowerCase().contains((CharSequence)word2)) {
              res = 2;
            }
          }
          
          String string = (String)it.next();
          
          driver.get((String)strlist.get(c));
          
          if (res == 2) detail = detail2;
          if ((res == 1) || (res == 2)) {
            found += 1;
            status = "Applying At PeoplePerHour";
            stm.setText(status);
            
            WebElement bid = driver.findElement(By.name("yt4"));
            bid.click();
            boolean hourly = false;
            

            WebElement budget = driver.findElement(By.className("budget"));
            String bud = budget.getText();
            if ((bud.contains("Per Hour")) || (bud.contains("PER HOUR"))) {
              hourly = true;
            }
            if (cp == true) {
              setClipboardContents(app);
              
              WebElement det = driver.findElement(By.tagName("textarea"));
              det.sendKeys(new CharSequence[] { Keys.CONTROL + "v" });
              WebElement miles = driver.findElement(By.className("description"));
              miles.sendKeys(new CharSequence[] { "Default Milestone" });
              WebElement cost = driver.findElement(By.className("total"));
              WebElement dep = driver.findElement(By.className("deposit"));
              cost.sendKeys(new CharSequence[] { amt });
              String gb = cost.getText();
              dep.sendKeys(new CharSequence[] { amt });
              
              WebElement sub = driver.findElement(By.xpath("//button[contains(text(),'Send')]"));
              System.out.println(sub.getText());
              sub.click();
              sucess += 1;
            }
            if (!cp)
            {
              WebElement det = driver.findElement(By.tagName("textarea"));
              det.sendKeys(new CharSequence[] { app });
              WebElement miles = driver.findElement(By.className("description"));
              miles.sendKeys(new CharSequence[] { "Default Milestone" });
              WebElement cost = driver.findElement(By.className("total"));
              WebElement dep = driver.findElement(By.className("deposit"));
              cost.sendKeys(new CharSequence[] { amt });
              String gb = cost.getText();
              dep.sendKeys(new CharSequence[] { amt });
              
              WebElement sub = driver.findElement(By.xpath("//button[contains(text(),'Send')]"));
              System.out.println(sub.getText());
              sub.click();
              sucess += 1;
            }
            
            c++;

          }
          else
          {
            System.out.println("Keyword not found!");
            
            c++;
          }
          

        }
        catch (Exception e)
        {
          error += 1;
          System.out.println(e);
          c++;
        }
        

        redata = "PPH Result: Founded: " + Integer.toString(found) + " Success:" + Integer.toString(sucess);
        stm.setText(redata);
      }
      
      loop++;
    }
    JOptionPane.showMessageDialog(null, redata);
    
    driver.close();
    return redata;
  }
  
  public static void setClipboardContents(String text)
  {
    StringSelection stringSelection = new StringSelection(text);
    Clipboard clipboard = Toolkit.getDefaultToolkit().getSystemClipboard();
    clipboard.setContents(stringSelection, null);
  }
}
