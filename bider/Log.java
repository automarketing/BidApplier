package freelancer.bider;

import java.awt.Color;
import java.awt.Font;
import java.awt.event.ActionEvent;
import java.io.File;
import java.io.PrintStream;
import java.net.InetAddress;
import java.net.UnknownHostException;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.Date;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.GroupLayout;
import javax.swing.GroupLayout.Alignment;
import javax.swing.GroupLayout.ParallelGroup;
import javax.swing.GroupLayout.SequentialGroup;
import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JPasswordField;
import javax.swing.JSeparator;
import javax.swing.JTextField;
import javax.swing.LayoutStyle.ComponentPlacement;
import javax.swing.UIManager;
import javax.swing.UIManager.LookAndFeelInfo;
import javax.swing.UnsupportedLookAndFeelException;

public class Log extends javax.swing.JFrame
{
  public Log() throws InterruptedException
  {
    initComponents();
    setIconImage(java.awt.Toolkit.getDefaultToolkit().getImage(getClass().getResource("fav.jpg")));
    
    String COPYRIGHT = "©";
    copy.setText(COPYRIGHT + " Copyrights Reserved By Aleem (2016)");
    getContentPane().setBackground(Color.decode("#F8F8FF"));
    jPanel1.setBackground(Color.decode("#F8F8FF"));
    Thread.sleep(5000L);
  }
  

  String url1 = "jdbc:mysql://139.162.252.82/zadmin_eapplier";
  
  String username = "admin";
  String password = "elambakaleem123";
  
  private JLabel copy;
  private JTextField eemail;
  private JPasswordField epassword;
  private JButton jButton1;
  private JLabel jLabel1;
  
  private void initComponents()
  {
    jPanel1 = new JPanel();
    eemail = new JTextField();
    jButton1 = new JButton();
    jLabel1 = new JLabel();
    jLabel2 = new JLabel();
    epassword = new JPasswordField();
    logerror = new JLabel();
    jSeparator1 = new JSeparator();
    jLabel4 = new JLabel();
    loge = new JLabel();
    copy = new JLabel();
    
    setDefaultCloseOperation(3);
    setTitle("Login");
    setBackground(new Color(255, 255, 204));
    
    jPanel1.setBorder(javax.swing.BorderFactory.createTitledBorder(null, "Login", 0, 0, new Font("Andalus", 0, 18)));
    
    jButton1.setText("Login");
    jButton1.addActionListener(new java.awt.event.ActionListener() {
      public void actionPerformed(ActionEvent evt) {
        Log.this.jButton1ActionPerformed(evt);
      }
      
    });
    jLabel1.setText("Email:");
    
    jLabel2.setText("Password:");
    
    GroupLayout jPanel1Layout = new GroupLayout(jPanel1);
    jPanel1.setLayout(jPanel1Layout);
    jPanel1Layout.setHorizontalGroup(jPanel1Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel1Layout.createSequentialGroup()
      .addContainerGap()
      .addGroup(jPanel1Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel1Layout.createSequentialGroup()
      .addGroup(jPanel1Layout.createParallelGroup(GroupLayout.Alignment.LEADING, false)
      .addComponent(jLabel1)
      .addComponent(eemail)
      .addComponent(jLabel2)
      .addComponent(epassword, -1, 118, 32767))
      .addContainerGap(188, 32767))
      .addGroup(jPanel1Layout.createSequentialGroup()
      .addComponent(jButton1)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(logerror, -1, -1, 32767)))));
    
    jPanel1Layout.setVerticalGroup(jPanel1Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel1Layout.createSequentialGroup()
      .addContainerGap()
      .addComponent(jLabel1)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(eemail, -2, -1, -2)
      .addGap(18, 18, 18)
      .addComponent(jLabel2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(epassword, -2, -1, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED, 29, 32767)
      .addGroup(jPanel1Layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
      .addComponent(jButton1)
      .addComponent(logerror))));
    

    jLabel4.setIcon(new javax.swing.ImageIcon(getClass().getResource("/freelancer/bider/elogo.png")));
    
    loge.setFont(new Font("Tahoma", 1, 14));
    loge.setForeground(Color.red);
    
    copy.setFont(new Font("Times New Roman", 0, 8));
    copy.setForeground(new Color(51, 51, 51));
    
    GroupLayout layout = new GroupLayout(getContentPane());
    getContentPane().setLayout(layout);
    layout.setHorizontalGroup(layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(layout.createSequentialGroup()
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(layout.createSequentialGroup()
      .addGap(10, 10, 10)
      .addComponent(jLabel4, -2, 421, -2))
      .addComponent(jSeparator1, -2, 441, -2)
      .addGroup(layout.createSequentialGroup()
      .addGap(37, 37, 37)
      .addComponent(copy, -2, 374, -2))
      .addGroup(layout.createSequentialGroup()
      .addGap(56, 56, 56)
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.TRAILING)
      .addComponent(loge, -2, 299, -2)
      .addComponent(jPanel1, -2, -1, -2))))
      .addContainerGap(27, 32767)));
    
    layout.setVerticalGroup(layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(layout.createSequentialGroup()
      .addGap(23, 23, 23)
      .addComponent(jLabel4)
      .addGap(18, 18, 18)
      .addComponent(jSeparator1, -2, 10, -2)
      .addGap(2, 2, 2)
      .addComponent(jPanel1, -2, -1, -2)
      .addGap(18, 18, 18)
      .addComponent(loge, -2, 14, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(copy, -2, 14, -2)
      .addContainerGap(-1, 32767)));
    

    pack();
    setLocationRelativeTo(null);
  }
  
  private void jButton1ActionPerformed(ActionEvent evt)
  {
    Thread hilo = new Thread(new Runnable()
    {
      public void run()
      {
        String email = eemail.getText();
        String epass = epassword.getText();
        String login = null;
        jButton1.setBackground(Color.green);
        jButton1.setText("Logging");
        

        try
        {
          InetAddress ipi = null;
          try {
            ipi = InetAddress.getLocalHost();
          } catch (UnknownHostException ex) {
            Logger.getLogger(Log.class.getName()).log(Level.SEVERE, null, ex);
          }
          String ip = ipi.toString();
          String substr = "/";
          String[] parts = ip.split(substr);
          String fip = parts[1];
          
          Statement stmt = null;
          Connection conn = java.sql.DriverManager.getConnection(url1, username, password);
          String select = "SELECT *  FROM `users` WHERE `Email`='" + email + "'AND `Password`='" + epass + "'";
          stmt = conn.createStatement(1005, 1008);
          

          ResultSet rs = stmt.executeQuery(select);
          boolean count = rs.next();
          int ab = rs.getInt("Allow Bids");
          int ub = rs.getInt("Used Bids");
          Date date = new Date();
          int upd = rs.getInt("Update");
          String stmsg = rs.getString("Message");
          System.out.println(ab + "fdjkfds" + ub);
          String sql = "INSERT INTO visitings VALUES (NULL, '" + email + "', '" + fip + "', '" + date.toString() + "')";
          if (count == true) {
            if (ab == ub) {
              loge.setText("Your application limit has been completed");

            }
            else
            {
              stmt.executeUpdate(sql);
              

              jButton1.setText("Succeed");
              Notification notice = new Notification("E-Applier Login", "Login successfully, redirecting to user-panel");
              login = "success";
              System.out.println("Success");
              
              new Main(login, email).setVisible(count);
              endScreen();
              if (upd == 1) {
                javax.swing.JDialog.setDefaultLookAndFeelDecorated(true);
                int response = JOptionPane.showConfirmDialog(null, "Updates available, Would you like to update now?", "Confirm", 0, 3);
                
                if (response == 0) {
                  System.out.print("update this yes");
                  File file = new File("Update.jar");
                  String path = file.getAbsolutePath();
                  new Main(login, email).disable();
                  Runtime.getRuntime().exec("java -jar Update.jar");
                  

                  System.exit(1);
                }
              }
              else
              {
                JOptionPane.showMessageDialog(null, stmsg);

              }
              

            }
            
          }
          

        }
        catch (SQLException ex)
        {

          login = "fail";
          System.out.println("Wrong detail");
          loge.setText("Email or Password is incorrect");
          jButton1.setBackground(Color.LIGHT_GRAY);
          jButton1.setText("Login again");
        }
        catch (Exception ex) {
          Logger.getLogger(Log.class.getName()).log(Level.SEVERE, null, ex);
        }
        
      }
      

    });
    hilo.start();
  }
  
  public void endScreen() {
    hide();
    dispose();
  }
  
  private JLabel jLabel2;
  private JLabel jLabel4;
  private JPanel jPanel1;
  private JSeparator jSeparator1;
  private JLabel loge;
  private JLabel logerror;
  public static void main(String[] args)
  {
    try {
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
    


    java.awt.EventQueue.invokeLater(new Runnable()
    {
      public void run() {
        try {
          new Log().setVisible(true);
        } catch (InterruptedException ex) {
          Logger.getLogger(Log.class.getName()).log(Level.SEVERE, null, ex);
        }
      }
    });
  }
}
