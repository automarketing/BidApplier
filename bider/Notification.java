package freelancer.bider;

import java.awt.Image;
import java.awt.SystemTray;
import java.awt.Toolkit;
import java.awt.TrayIcon;
import java.awt.TrayIcon.MessageType;














public class Notification
{
  static Image image = Toolkit.getDefaultToolkit().getImage("fav.jpg");
  
  static TrayIcon trayIcon = new TrayIcon(image, "Tester2");
  
  public Notification(String title, String message) throws Exception {
    if (SystemTray.isSupported())
    {
      SystemTray tray = SystemTray.getSystemTray();
      trayIcon.setImageAutoSize(true);
      
      tray.add(trayIcon);
      trayIcon.displayMessage(title, message, TrayIcon.MessageType.INFO);
      Thread.sleep(10000L);
      tray.remove(trayIcon);
    }
  }
}
