package freelancer.bider;

import java.awt.EventQueue;
import java.io.File;
import java.io.PrintStream;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.UIManager;
import javax.swing.UIManager.LookAndFeelInfo;
import javax.swing.UnsupportedLookAndFeelException;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;



public class readxml
{
  public readxml() {}
  
  public String[] readxml()
  {
    String[] user = new String[17];
    try
    {
      File fXmlFile = new File("mydata.xml");
      DocumentBuilderFactory dbFactory = DocumentBuilderFactory.newInstance();
      DocumentBuilder dBuilder = dbFactory.newDocumentBuilder();
      Document doc = dBuilder.parse(fXmlFile);
      

      doc.getDocumentElement().normalize();
      

      NodeList nList = doc.getElementsByTagName("data");
      

      for (int temp = 0; temp < nList.getLength(); temp++)
      {
        Node nNode = nList.item(temp);
        Element eElement = (Element)nNode;
        user[0] = eElement.getElementsByTagName("freelancer-user").item(0).getTextContent();
        user[1] = eElement.getElementsByTagName("freelancer-pass").item(0).getTextContent();
        user[2] = eElement.getElementsByTagName("upwork-user").item(0).getTextContent();
        user[3] = eElement.getElementsByTagName("upwork-pass").item(0).getTextContent();
        user[4] = eElement.getElementsByTagName("guru-user").item(0).getTextContent();
        user[5] = eElement.getElementsByTagName("guru-pass").item(0).getTextContent();
        user[6] = eElement.getElementsByTagName("pph-user").item(0).getTextContent();
        user[7] = eElement.getElementsByTagName("pph-pass").item(0).getTextContent();
        user[8] = eElement.getElementsByTagName("detail-1").item(0).getTextContent();
        user[9] = eElement.getElementsByTagName("detail-2").item(0).getTextContent();
        user[10] = eElement.getElementsByTagName("keys-1").item(0).getTextContent();
        user[11] = eElement.getElementsByTagName("keys-2").item(0).getTextContent();
        user[12] = eElement.getElementsByTagName("read-pages").item(0).getTextContent();
        user[13] = eElement.getElementsByTagName("recheck-loop").item(0).getTextContent();
        user[14] = eElement.getElementsByTagName("search-by").item(0).getTextContent();
        user[15] = eElement.getElementsByTagName("c-url").item(0).getTextContent();
        user[16] = eElement.getElementsByTagName("country-filter").item(0).getTextContent();
      }
      
    }
    catch (Exception e)
    {
      e.printStackTrace();
    }
    return user;
  }
  



  public static void main(String[] args)
  {
    try
    {
      for (UIManager.LookAndFeelInfo info : ) {
        if ("Nimbus".equals(info.getName())) {
          UIManager.setLookAndFeel(info.getClassName());
          break;
        }
      }
    } catch (ClassNotFoundException ex) {
      Logger.getLogger(Log.class.getName()).log(Level.SEVERE, null, ex);
    } catch (InstantiationException ex) {
      Logger.getLogger(Log.class.getName()).log(Level.SEVERE, null, ex);
    } catch (IllegalAccessException ex) {
      Logger.getLogger(Log.class.getName()).log(Level.SEVERE, null, ex);
    } catch (UnsupportedLookAndFeelException ex) {
      Logger.getLogger(Log.class.getName()).log(Level.SEVERE, null, ex);
    }
    


    EventQueue.invokeLater(new Runnable() {
      public void run() {
        String[] ret = new String[17];
        
        readxml user = new readxml();
        ret = user.readxml();
        System.out.println(ret[0]);
        System.out.println(ret[1]);
        System.out.println(ret[2]);
        System.out.println(ret[3]);
        System.out.println(ret[4]);
        System.out.println(ret[5]);
        System.out.println(ret[6]);
        System.out.println(ret[7]);
        System.out.println(ret[8]);
        System.out.println(ret[9]);
        System.out.println(ret[10]);
        System.out.println(ret[11]);
        System.out.println(ret[12]);
        System.out.println(ret[13]);
        System.out.println(ret[14]);
        System.out.println(ret[15]);
        System.out.println(ret[16]);
      }
    });
  }
}
