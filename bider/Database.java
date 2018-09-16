package freelancer.bider;

import java.awt.EventQueue;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.UIManager;
import javax.swing.UIManager.LookAndFeelInfo;
import javax.swing.UnsupportedLookAndFeelException;




public class Database
{
  public Database()
  {
    String url = "jdbc:mysql://localhost:3306/flyer";
    String username = "root";
    String password = "aleem321";
    try { Connection connection = DriverManager.getConnection(url, username, password);Throwable localThrowable3 = null;
      try
      {
        Statement localStatement = connection.createStatement();
      }
      catch (Throwable localThrowable5)
      {
        localThrowable3 = localThrowable5;throw localThrowable5;
      }
      finally
      {
        if (connection != null) if (localThrowable3 != null) try { connection.close(); } catch (Throwable localThrowable2) { localThrowable3.addSuppressed(localThrowable2); } else connection.close();
      } } catch (SQLException ex) { Logger.getLogger(Log.class.getName()).log(Level.SEVERE, null, ex);
    }
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
        new Database();
      }
    });
  }
}
