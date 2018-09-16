package freelancer.bider;

import java.io.PrintStream;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.UIManager;
import javax.swing.UIManager.LookAndFeelInfo;
import javax.swing.UnsupportedLookAndFeelException;













public class Elance
{
  public Elance() {}
  
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
      Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
    } catch (InstantiationException ex) {
      Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
    } catch (IllegalAccessException ex) {
      Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
    } catch (UnsupportedLookAndFeelException ex) {
      Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
    }
    


    String a = "Elambak.com (Valley of Solution):\t\t\n\n \n\nWho We Are:\nWe're web developers and management team to facilitate you after working on many projects we are now focusing only to develop website of various kinds of different countries we have a team of developers who've different skills and experiences we only would like to know what you want and all your requirements we also a working plan and environment. ";
    




    a = a.replaceAll("(?m)(^ *| +(?= |$))", "").replaceAll("(?m)^$([\r\n]+?)(^$[\r\n]+?^)+", "$1");
    System.out.println(a);
  }
}
