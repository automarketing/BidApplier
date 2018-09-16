package freelancer.bider;

import java.awt.Color;
import java.awt.Font;
import java.awt.Menu;
import java.awt.MenuBar;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.ItemEvent;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.ButtonGroup;
import javax.swing.DefaultComboBoxModel;
import javax.swing.GroupLayout;
import javax.swing.GroupLayout.Alignment;
import javax.swing.GroupLayout.ParallelGroup;
import javax.swing.GroupLayout.SequentialGroup;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JCheckBox;
import javax.swing.JComboBox;
import javax.swing.JLabel;
import javax.swing.JMenuItem;
import javax.swing.JPanel;
import javax.swing.JPasswordField;
import javax.swing.JPopupMenu;
import javax.swing.JScrollPane;
import javax.swing.JSeparator;
import javax.swing.JSpinner;
import javax.swing.JTabbedPane;
import javax.swing.JTextArea;
import javax.swing.JTextField;
import javax.swing.JTextPane;
import javax.swing.LayoutStyle.ComponentPlacement;
import javax.swing.SpinnerNumberModel;
import javax.swing.UIManager.LookAndFeelInfo;
import javax.swing.event.ChangeEvent;

public class Main extends javax.swing.JFrame
{
  public static String eu = null;
  
  JTextField customurl = new JTextField();
  JTextField pr1 = new JTextField();
  JTextField pr2 = new JTextField();
  JTextField pr3 = new JTextField();
  JTextField pr4 = new JTextField();
  JTextField pr5 = new JTextField();
  JTextField pr6 = new JTextField();
  JTextField pr7 = new JTextField();
  private String clink;
  private static JLabel alert;
  private JCheckBox amtfilter;
  private JTextArea app1;
  private JTextArea app2;
  private JComboBox<String> atype;
  private static JSpinner bids;
  private static JComboBox browser;
  private ButtonGroup buttonGroup1; private ButtonGroup buttonGroup2; private ButtonGroup buttonGroup3; public static JCheckBox clip; private JPanel conf1; private JPanel conf2; private JPanel conf3; private JCheckBox email; private JTextField flags; private JTextField framount; private static JTextField fremail; public JLabel frp; private static JPasswordField frpassword;
  public Main(String auth, String euser) { if (auth == "success")
    {
      eu = euser;
      try {
        initComponents();
        setIconImage(java.awt.Toolkit.getDefaultToolkit().getImage(getClass().getResource("fav.jpg")));
        

        getContentPane().setBackground(Color.decode("#EAFAF1"));
        jPanel3.setBackground(Color.decode("#EAFAF1"));
        jPanel54.setBackground(Color.decode("#EAFAF1"));
        jPanel55.setBackground(Color.decode("#EAFAF1"));
        jPanel56.setBackground(Color.decode("#EAFAF1"));
        jPanel57.setBackground(Color.decode("#EAFAF1"));
        jPanel58.setBackground(Color.decode("#EAFAF1"));
        jPanel59.setBackground(Color.decode("#EAFAF1"));
        jPanel60.setBackground(Color.decode("#EAFAF1"));
        jPanel61.setBackground(Color.decode("#EAFAF1"));
        jPanel7.setBackground(Color.decode("#EAFAF1"));
        conf1.setBackground(Color.decode("#EAFAF1"));
        conf2.setBackground(Color.decode("#EAFAF1"));
        conf3.setBackground(Color.decode("#EAFAF1"));
        

        frp.setVisible(false);
        



        String url1 = "jdbc:mysql://139.162.252.82/zadmin_eapplier";
        
        String username = "admin";
        String password = "elambakaleem123";
        java.sql.Statement stmt = null;
        java.sql.Connection conn = java.sql.DriverManager.getConnection(url1, username, password);
        
        String select = "SELECT `message`  FROM `notification`";
        stmt = conn.createStatement(1005, 1008);
        

        java.sql.ResultSet rs = stmt.executeQuery(select);
        List<String> all = new java.util.ArrayList();
        




        while (rs.next())
        {
          all.add(rs.getString("message"));
        }
        
        System.out.println(all);
        msg1.setText((String)all.get(0));
        msg2.setText((String)all.get(2));
        msg3.setText((String)all.get(3));
        msg4.setText((String)all.get(1));
        alert.setText((String)all.get(4));
        
        java.io.File file = new java.io.File("mydata.xml");
        if (file.exists()) {
          String[] ret = new String[17];
          readxml user = new readxml();
          ret = user.readxml();
          fremail.setText(ret[0]);
          frpassword.setText(ret[1]);
          upemail.setText(ret[2]);
          uppassword.setText(ret[3]);
          gemail.setText(ret[4]);
          gpassword.setText(ret[5]);
          pemail.setText(ret[6]);
          ppassword.setText(ret[7]);
          app1.setText(ret[8]);
          app2.setText(ret[9]);
          keys1.setText(ret[10]);
          keys2.setText(ret[11]);
          
          if (!ret[12].isEmpty()) {
            jpages.setValue(Integer.valueOf(2));
          }
          if (!ret[13].isEmpty()) {
            loop.setValue(Integer.valueOf(2));
          }
          if (!ret[14].isEmpty()) {
            searchby.setSelectedItem(ret[14]);
          }
          url.setText(ret[15]);
          flags.setText(ret[16]);
        }
        
      }
      catch (java.sql.SQLException ex)
      {
        Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex); } } }
  
  private JLabel frs;
  private JTextField frtime;
  private JTextField gamount;
  private static JTextField gemail;
  private static JPasswordField gpassword;
  private JLabel gs;
  private JTextField gtime;
  private JLabel jLabel1;
  private JLabel jLabel10;
  private JLabel jLabel11;
  private JLabel jLabel12;
  private JLabel jLabel124;
  private JLabel jLabel125;
  private JLabel jLabel126;
  private JLabel jLabel127; private JLabel jLabel128; private JLabel jLabel129; private JLabel jLabel13; private JLabel jLabel130; private JLabel jLabel131;
  private void initComponents() { menuBar1 = new MenuBar();
    menu1 = new Menu();
    menu2 = new Menu();
    jPopupMenu1 = new JPopupMenu();
    jPopupMenu2 = new JPopupMenu();
    jPopupMenu3 = new JPopupMenu();
    jMenuItem1 = new JMenuItem();
    jMenu3 = new javax.swing.JMenu();
    jPopupMenu4 = new JPopupMenu();
    jPopupMenu5 = new JPopupMenu();
    buttonGroup1 = new ButtonGroup();
    buttonGroup2 = new ButtonGroup();
    buttonGroup3 = new ButtonGroup();
    jTabbedPane4 = new JTabbedPane();
    jPanel54 = new JPanel();
    jPanel55 = new JPanel();
    jLabel124 = new JLabel();
    jSeparator20 = new JSeparator();
    msg1 = new JLabel();
    jLabel125 = new JLabel();
    fremail = new JTextField();
    jLabel126 = new JLabel();
    frpassword = new JPasswordField();
    jLabel8 = new JLabel();
    framount = new JTextField();
    jLabel10 = new JLabel();
    frtime = new JTextField();
    jPanel56 = new JPanel();
    jPanel57 = new JPanel();
    jLabel127 = new JLabel();
    jSeparator21 = new JSeparator();
    msg3 = new JLabel();
    jLabel128 = new JLabel();
    upemail = new JTextField();
    jLabel129 = new JLabel();
    uppassword = new JPasswordField();
    jLabel11 = new JLabel();
    upamount = new JTextField();
    jLabel12 = new JLabel();
    uptime = new JComboBox();
    upamounthr = new JTextField();
    jLabel26 = new JLabel();
    jPanel58 = new JPanel();
    jPanel59 = new JPanel();
    jLabel130 = new JLabel();
    jSeparator22 = new JSeparator();
    msg4 = new JLabel();
    jLabel131 = new JLabel();
    gemail = new JTextField();
    jLabel132 = new JLabel();
    gpassword = new JPasswordField();
    jLabel13 = new JLabel();
    gamount = new JTextField();
    jLabel14 = new JLabel();
    gtime = new JTextField();
    atype = new JComboBox();
    jPanel60 = new JPanel();
    jPanel61 = new JPanel();
    jLabel133 = new JLabel();
    jSeparator23 = new JSeparator();
    msg2 = new JLabel();
    jLabel134 = new JLabel();
    pemail = new JTextField();
    jLabel135 = new JLabel();
    ppassword = new JPasswordField();
    jLabel15 = new JLabel();
    pamount = new JTextField();
    jLabel16 = new JLabel();
    ptime = new JTextField();
    phmt = new JTextField();
    jLabel9 = new JLabel();
    progress = new JPanel();
    frp = new JLabel();
    frs = new JLabel();
    ups = new JLabel();
    ps = new JLabel();
    gs = new JLabel();
    alert = new JLabel();
    jScrollPane1 = new JScrollPane();
    stm = new JTextPane();
    jTabbedPane1 = new JTabbedPane();
    jPanel7 = new JPanel();
    jLabel6 = new JLabel();
    keys2 = new JTextField();
    jLabel7 = new JLabel();
    jScrollPane3 = new JScrollPane();
    app2 = new JTextArea();
    jPanel3 = new JPanel();
    jLabel4 = new JLabel();
    keys1 = new JTextField();
    jLabel5 = new JLabel();
    jScrollPane2 = new JScrollPane();
    app1 = new JTextArea();
    jSeparator2 = new JSeparator();
    stime = new JLabel();
    conf1 = new JPanel();
    jLabel3 = new JLabel();
    jpages = new JSpinner();
    jLabel1 = new JLabel();
    loop = new JSpinner();
    jLabel22 = new JLabel();
    bids = new JSpinner();
    jLabel23 = new JLabel();
    timing = new JSpinner();
    jLabel25 = new JLabel();
    uread = new JSpinner();
    jLabel18 = new JLabel();
    conf2 = new JPanel();
    jLabel17 = new JLabel();
    searchby = new JComboBox();
    jLabel20 = new JLabel();
    method = new JComboBox();
    jLabel2 = new JLabel();
    browser = new JComboBox();
    jLabel24 = new JLabel();
    os = new JComboBox();
    conf3 = new JPanel();
    clip = new JCheckBox();
    amtfilter = new JCheckBox();
    email = new JCheckBox();
    save = new JCheckBox();
    jLabel19 = new JLabel();
    flags = new JTextField();
    jLabel27 = new JLabel();
    url = new JTextField();
    start = new JButton();
    stoptime = new JLabel();
    starttime = new JLabel();
    
    menu1.setLabel("File");
    menuBar1.add(menu1);
    
    menu2.setLabel("Edit");
    menuBar1.add(menu2);
    
    jMenuItem1.setText("jMenuItem1");
    
    jMenu3.setText("jMenu3");
    
    setDefaultCloseOperation(3);
    setTitle("E-Appler (Automation Solution)");
    setMaximumSize(new java.awt.Dimension(1050, 760));
    setPreferredSize(new java.awt.Dimension(1100, 760));
    
    jTabbedPane4.setName("freelancer");
    
    jLabel124.setIcon(new ImageIcon(getClass().getResource("/freelancer/bider/freelancer.gif")));
    
    GroupLayout jPanel55Layout = new GroupLayout(jPanel55);
    jPanel55.setLayout(jPanel55Layout);
    jPanel55Layout.setHorizontalGroup(jPanel55Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel55Layout.createSequentialGroup()
      .addComponent(jSeparator20, -2, 426, -2)
      .addGap(0, 0, 32767))
      .addGroup(jPanel55Layout.createSequentialGroup()
      .addGroup(jPanel55Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(msg1, -1, -1, 32767)
      .addGroup(jPanel55Layout.createSequentialGroup()
      .addComponent(jLabel124, -2, 318, -2)
      .addGap(0, 0, 32767)))
      .addContainerGap()));
    
    jPanel55Layout.setVerticalGroup(jPanel55Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel55Layout.createSequentialGroup()
      .addGap(4, 4, 4)
      .addComponent(jLabel124, -2, 77, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(msg1, -1, 22, 32767)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(jSeparator20, -2, 10, -2)));
    

    jLabel125.setText("Email:");
    
    jLabel126.setText("Password:");
    
    frpassword.addActionListener(new ActionListener() {
      public void actionPerformed(ActionEvent evt) {
        Main.this.frpasswordActionPerformed(evt);
      }
      
    });
    jLabel8.setText("Amount %:");
    
    jLabel10.setText("Duration:");
    
    GroupLayout jPanel54Layout = new GroupLayout(jPanel54);
    jPanel54.setLayout(jPanel54Layout);
    jPanel54Layout.setHorizontalGroup(jPanel54Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel54Layout.createSequentialGroup()
      .addComponent(jPanel55, -2, -1, -2)
      .addGap(0, 0, 32767))
      .addGroup(jPanel54Layout.createSequentialGroup()
      .addContainerGap()
      .addGroup(jPanel54Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(frpassword, -2, 138, -2)
      .addComponent(jLabel125)
      .addComponent(fremail, -2, 138, -2)
      .addComponent(jLabel126))
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED, 154, 32767)
      .addGroup(jPanel54Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(jLabel10)
      .addComponent(frtime, -2, 92, -2)
      .addComponent(jLabel8)
      .addComponent(framount, -2, 92, -2))
      .addGap(34, 34, 34)));
    
    jPanel54Layout.setVerticalGroup(jPanel54Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel54Layout.createSequentialGroup()
      .addComponent(jPanel55, -2, -1, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addGroup(jPanel54Layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
      .addComponent(jLabel125)
      .addComponent(jLabel8))
      .addGap(18, 18, 18)
      .addGroup(jPanel54Layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
      .addComponent(fremail, -2, -1, -2)
      .addComponent(framount, -2, -1, -2))
      .addGap(18, 18, 32767)
      .addGroup(jPanel54Layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
      .addComponent(jLabel10)
      .addComponent(jLabel126))
      .addGap(18, 18, 18)
      .addGroup(jPanel54Layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
      .addComponent(frtime, -2, -1, -2)
      .addComponent(frpassword, -2, -1, -2))
      .addGap(23, 23, 23)));
    

    jTabbedPane4.addTab("Freelancer", jPanel54);
    
    jLabel127.setIcon(new ImageIcon(getClass().getResource("/freelancer/bider/upwork.gif")));
    
    GroupLayout jPanel57Layout = new GroupLayout(jPanel57);
    jPanel57.setLayout(jPanel57Layout);
    jPanel57Layout.setHorizontalGroup(jPanel57Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel57Layout.createSequentialGroup()
      .addComponent(jSeparator21, -2, 426, -2)
      .addGap(0, 0, 32767))
      .addGroup(jPanel57Layout.createSequentialGroup()
      .addGroup(jPanel57Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(msg3, -1, -1, 32767)
      .addGroup(jPanel57Layout.createSequentialGroup()
      .addComponent(jLabel127, -2, 318, -2)
      .addGap(0, 0, 32767)))
      .addContainerGap()));
    
    jPanel57Layout.setVerticalGroup(jPanel57Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel57Layout.createSequentialGroup()
      .addGap(4, 4, 4)
      .addComponent(jLabel127, -2, 77, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(msg3, -1, 22, 32767)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(jSeparator21, -2, 10, -2)));
    

    jLabel128.setText("Email:");
    
    jLabel129.setText("Password:");
    
    uppassword.addActionListener(new ActionListener() {
      public void actionPerformed(ActionEvent evt) {
        Main.this.uppasswordActionPerformed(evt);
      }
      
    });
    jLabel11.setText("Amount (Fixed):");
    
    jLabel12.setText("Duration:");
    
    uptime.setModel(new DefaultComboBoxModel(new String[] { "1-week", "1-month", "1-3 month", "3-6 month", "More than 6-month" }));
    
    jLabel26.setText("Amount (Hourly):");
    
    GroupLayout jPanel56Layout = new GroupLayout(jPanel56);
    jPanel56.setLayout(jPanel56Layout);
    jPanel56Layout.setHorizontalGroup(jPanel56Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel56Layout.createSequentialGroup()
      .addContainerGap()
      .addGroup(jPanel56Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(uppassword, -2, 138, -2)
      .addComponent(jLabel129)
      .addGroup(jPanel56Layout.createSequentialGroup()
      .addGroup(jPanel56Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(upemail, -2, 138, -2)
      .addComponent(jLabel128))
      .addGap(29, 29, 29)
      .addGroup(jPanel56Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(jLabel11)
      .addComponent(upamount, -2, 92, -2))))
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED, -1, 32767)
      .addGroup(jPanel56Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(GroupLayout.Alignment.TRAILING, jPanel56Layout.createSequentialGroup()
      .addGroup(jPanel56Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(jLabel12)
      .addComponent(upamounthr, -2, 92, -2)
      .addComponent(jLabel26))
      .addGap(35, 35, 35))
      .addGroup(GroupLayout.Alignment.TRAILING, jPanel56Layout.createSequentialGroup()
      .addComponent(uptime, -2, -1, -2)
      .addContainerGap())))
      .addGroup(jPanel56Layout.createSequentialGroup()
      .addComponent(jPanel57, -2, -1, -2)
      .addGap(0, 2, 32767)));
    
    jPanel56Layout.setVerticalGroup(jPanel56Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel56Layout.createSequentialGroup()
      .addComponent(jPanel57, -2, -1, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED, 29, 32767)
      .addGroup(jPanel56Layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
      .addComponent(jLabel128)
      .addComponent(jLabel11)
      .addComponent(jLabel26))
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addGroup(jPanel56Layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
      .addComponent(upemail, -2, -1, -2)
      .addComponent(upamount, -2, -1, -2)
      .addComponent(upamounthr, -2, -1, -2))
      .addGroup(jPanel56Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel56Layout.createSequentialGroup()
      .addGap(26, 26, 26)
      .addComponent(jLabel129)
      .addGap(11, 11, 11)
      .addComponent(uppassword, -2, -1, -2))
      .addGroup(jPanel56Layout.createSequentialGroup()
      .addGap(18, 18, 18)
      .addComponent(jLabel12)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(uptime, -2, -1, -2)))
      .addGap(26, 26, 26)));
    

    jTabbedPane4.addTab("Upwork", jPanel56);
    
    jLabel130.setIcon(new ImageIcon(getClass().getResource("/freelancer/bider/imageedit_6_3616317562.png")));
    
    GroupLayout jPanel59Layout = new GroupLayout(jPanel59);
    jPanel59.setLayout(jPanel59Layout);
    jPanel59Layout.setHorizontalGroup(jPanel59Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel59Layout.createSequentialGroup()
      .addComponent(jSeparator22, -2, 426, -2)
      .addGap(0, 0, 32767))
      .addGroup(jPanel59Layout.createSequentialGroup()
      .addGroup(jPanel59Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(msg4, -1, -1, 32767)
      .addGroup(jPanel59Layout.createSequentialGroup()
      .addComponent(jLabel130, -2, 318, -2)
      .addGap(0, 0, 32767)))
      .addContainerGap()));
    
    jPanel59Layout.setVerticalGroup(jPanel59Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel59Layout.createSequentialGroup()
      .addGap(4, 4, 4)
      .addComponent(jLabel130, -2, 77, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(msg4, -1, 22, 32767)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(jSeparator22, -2, 10, -2)));
    

    jLabel131.setText("Email:");
    
    jLabel132.setText("Password:");
    
    gpassword.addActionListener(new ActionListener() {
      public void actionPerformed(ActionEvent evt) {
        Main.this.gpasswordActionPerformed(evt);
      }
      
    });
    jLabel13.setText("Amount %:");
    
    jLabel14.setText("Duration:");
    
    atype.setModel(new DefaultComboBoxModel(new String[] { "Placeholder bid", "Hourly by time tracked", "Fixed Price by milestone", "Recurring payments", " " }));
    
    GroupLayout jPanel58Layout = new GroupLayout(jPanel58);
    jPanel58.setLayout(jPanel58Layout);
    jPanel58Layout.setHorizontalGroup(jPanel58Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel58Layout.createSequentialGroup()
      .addContainerGap()
      .addGroup(jPanel58Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel58Layout.createSequentialGroup()
      .addGroup(jPanel58Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(gpassword, -2, 138, -2)
      .addComponent(jLabel132)
      .addComponent(gemail, -2, 138, -2))
      .addGap(27, 27, 27)
      .addGroup(jPanel58Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel58Layout.createSequentialGroup()
      .addComponent(gamount, -2, 92, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED, -1, 32767)
      .addGroup(jPanel58Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(jLabel14)
      .addComponent(gtime, -2, 92, -2))
      .addGap(37, 37, 37))
      .addGroup(jPanel58Layout.createSequentialGroup()
      .addComponent(atype, -2, 112, -2)
      .addContainerGap(-1, 32767))))
      .addGroup(jPanel58Layout.createSequentialGroup()
      .addComponent(jLabel131)
      .addGap(137, 137, 137)
      .addComponent(jLabel13)
      .addContainerGap(-1, 32767))))
      .addGroup(jPanel58Layout.createSequentialGroup()
      .addComponent(jPanel59, -2, -1, -2)
      .addGap(0, 2, 32767)));
    
    jPanel58Layout.setVerticalGroup(jPanel58Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel58Layout.createSequentialGroup()
      .addComponent(jPanel59, -2, -1, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED, 37, 32767)
      .addGroup(jPanel58Layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
      .addComponent(jLabel131)
      .addComponent(jLabel13)
      .addComponent(jLabel14))
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addGroup(jPanel58Layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
      .addComponent(gemail, -2, -1, -2)
      .addComponent(gamount, -2, -1, -2)
      .addComponent(gtime, -2, -1, -2))
      .addGap(18, 18, 18)
      .addComponent(jLabel132)
      .addGap(11, 11, 11)
      .addGroup(jPanel58Layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
      .addComponent(gpassword, -2, -1, -2)
      .addComponent(atype, -2, -1, -2))
      .addGap(26, 26, 26)));
    

    jTabbedPane4.addTab("Guru", jPanel58);
    
    jLabel133.setIcon(new ImageIcon(getClass().getResource("/freelancer/bider/pphe.gif")));
    
    msg2.setText("aleem");
    
    GroupLayout jPanel61Layout = new GroupLayout(jPanel61);
    jPanel61.setLayout(jPanel61Layout);
    jPanel61Layout.setHorizontalGroup(jPanel61Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel61Layout.createSequentialGroup()
      .addComponent(jSeparator23, -2, 426, -2)
      .addGap(0, 0, 32767))
      .addGroup(jPanel61Layout.createSequentialGroup()
      .addGroup(jPanel61Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(msg2, -1, -1, 32767)
      .addGroup(jPanel61Layout.createSequentialGroup()
      .addComponent(jLabel133, -2, 318, -2)
      .addGap(0, 0, 32767)))
      .addContainerGap()));
    
    jPanel61Layout.setVerticalGroup(jPanel61Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel61Layout.createSequentialGroup()
      .addGap(4, 4, 4)
      .addComponent(jLabel133, -2, 77, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(msg2, -1, 22, 32767)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(jSeparator23, -2, 10, -2)));
    

    jLabel134.setText("Email:");
    
    jLabel135.setText("Password:");
    
    ppassword.addActionListener(new ActionListener() {
      public void actionPerformed(ActionEvent evt) {
        Main.this.ppasswordActionPerformed(evt);
      }
      
    });
    jLabel15.setText("Amount (Fixed):");
    
    jLabel16.setText("Duration:");
    
    GroupLayout jPanel60Layout = new GroupLayout(jPanel60);
    jPanel60.setLayout(jPanel60Layout);
    jPanel60Layout.setHorizontalGroup(jPanel60Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel60Layout.createSequentialGroup()
      .addComponent(jPanel61, -2, -1, -2)
      .addGap(0, 2, 32767))
      .addGroup(jPanel60Layout.createSequentialGroup()
      .addContainerGap()
      .addGroup(jPanel60Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(ppassword, -2, 138, -2)
      .addComponent(jLabel135)
      .addComponent(pemail, -2, 138, -2)
      .addComponent(jLabel134))
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED, -1, 32767)
      .addGroup(jPanel60Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(pamount, -2, 92, -2)
      .addComponent(jLabel16)
      .addComponent(ptime, -2, 92, -2)
      .addComponent(jLabel15)
      .addComponent(phmt, -2, 92, -2))
      .addGap(37, 37, 37)));
    
    jPanel60Layout.setVerticalGroup(jPanel60Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel60Layout.createSequentialGroup()
      .addGroup(jPanel60Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel60Layout.createSequentialGroup()
      .addGroup(jPanel60Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel60Layout.createSequentialGroup()
      .addComponent(jPanel61, -2, -1, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addGroup(jPanel60Layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
      .addComponent(jLabel134)
      .addComponent(jLabel15)))
      .addGroup(jPanel60Layout.createSequentialGroup()
      .addContainerGap()
      .addComponent(pamount, -2, -1, -2)))
      .addGroup(jPanel60Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel60Layout.createSequentialGroup()
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED, 17, 32767)
      .addComponent(pemail, -2, -1, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED))
      .addGroup(jPanel60Layout.createSequentialGroup()
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(phmt, -2, -1, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED, -1, 32767)))
      .addGroup(jPanel60Layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
      .addComponent(jLabel135)
      .addComponent(jLabel16))
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(ptime, -2, -1, -2)
      .addGap(6, 6, 6))
      .addGroup(jPanel60Layout.createSequentialGroup()
      .addGap(0, 0, 32767)
      .addComponent(ppassword, -2, -1, -2)))
      .addGap(57, 57, 57)));
    

    jTabbedPane4.addTab("PeoplePerHour", jPanel60);
    
    jLabel9.setFont(new Font("MV Boli", 3, 36));
    jLabel9.setIcon(new ImageIcon(getClass().getResource("/freelancer/bider/logo.png")));
    
    progress.setLayout(new org.netbeans.lib.awtextra.AbsoluteLayout());
    
    frp.setFont(new Font("Tahoma", 0, 12));
    frp.setHorizontalTextPosition(0);
    
    alert.setFont(new Font("Plantagenet Cherokee", 3, 13));
    alert.setForeground(new Color(0, 102, 102));
    
    stm.setText("This is status reporting area about the services ");
    jScrollPane1.setViewportView(stm);
    
    jLabel6.setText("Keywords: (Must be separted with commas)");
    
    keys2.setToolTipText("Follow format(website,wordpress,articles)");
    keys2.addActionListener(new ActionListener() {
      public void actionPerformed(ActionEvent evt) {
        Main.this.keys2ActionPerformed(evt);
      }
      
    });
    jLabel7.setText("Proposal/Application:");
    
    app2.setColumns(20);
    app2.setRows(5);
    jScrollPane3.setViewportView(app2);
    
    GroupLayout jPanel7Layout = new GroupLayout(jPanel7);
    jPanel7.setLayout(jPanel7Layout);
    jPanel7Layout.setHorizontalGroup(jPanel7Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel7Layout.createSequentialGroup()
      .addContainerGap()
      .addGroup(jPanel7Layout.createParallelGroup(GroupLayout.Alignment.TRAILING, false)
      .addComponent(jScrollPane3, -1, 413, 32767)
      .addComponent(jLabel6, GroupLayout.Alignment.LEADING)
      .addComponent(keys2)
      .addComponent(jLabel7, GroupLayout.Alignment.LEADING))
      .addContainerGap(24, 32767)));
    
    jPanel7Layout.setVerticalGroup(jPanel7Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel7Layout.createSequentialGroup()
      .addContainerGap()
      .addComponent(jLabel6)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(keys2, -2, 28, -2)
      .addGap(18, 18, 18)
      .addComponent(jLabel7)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(jScrollPane3, -2, 169, -2)
      .addContainerGap(33, 32767)));
    

    jTabbedPane1.addTab("Proposal-2", jPanel7);
    
    jLabel4.setText("Keywords: (Must be separted with commas)");
    
    keys1.setToolTipText("Follow format(website,wordpress,articles)");
    
    jLabel5.setText("Proposal/Application:");
    
    app1.setColumns(20);
    app1.setRows(5);
    jScrollPane2.setViewportView(app1);
    
    GroupLayout jPanel3Layout = new GroupLayout(jPanel3);
    jPanel3.setLayout(jPanel3Layout);
    jPanel3Layout.setHorizontalGroup(jPanel3Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel3Layout.createSequentialGroup()
      .addContainerGap()
      .addGroup(jPanel3Layout.createParallelGroup(GroupLayout.Alignment.TRAILING, false)
      .addComponent(jScrollPane2, -1, 413, 32767)
      .addComponent(jLabel4, GroupLayout.Alignment.LEADING)
      .addComponent(keys1)
      .addComponent(jLabel5, GroupLayout.Alignment.LEADING))
      .addContainerGap(24, 32767)));
    
    jPanel3Layout.setVerticalGroup(jPanel3Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(jPanel3Layout.createSequentialGroup()
      .addContainerGap()
      .addComponent(jLabel4)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(keys1, -2, 28, -2)
      .addGap(18, 18, 18)
      .addComponent(jLabel5)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(jScrollPane2, -2, 169, -2)
      .addGap(0, 33, 32767)));
    

    jTabbedPane1.addTab("Proposal-1", jPanel3);
    
    jLabel3.setText("Read Job Pages:");
    
    jpages.setModel(new SpinnerNumberModel(1, 1, 1000, 1));
    jpages.addChangeListener(new javax.swing.event.ChangeListener() {
      public void stateChanged(ChangeEvent evt) {
        Main.this.jpagesStateChanged(evt);
      }
      
    });
    jLabel1.setText("Re-Check for more jobs:");
    
    loop.setModel(new SpinnerNumberModel(1, 1, 1000, 1));
    
    jLabel22.setText("Limit Bids:");
    
    bids.setModel(new SpinnerNumberModel(20, 1, 1000, 1));
    bids.setToolTipText("Support only freelancer");
    
    jLabel23.setText("Loading Time:");
    
    timing.setModel(new SpinnerNumberModel(5, 5, 1000, 1));
    timing.setToolTipText("Support only freelancer");
    
    jLabel25.setText("How many jobs to read (Upwork only)");
    
    uread.setModel(new SpinnerNumberModel(10, 10, 1000, 10));
    uread.setToolTipText("Support only freelancer");
    
    jLabel18.setFont(new Font("Tahoma", 3, 13));
    jLabel18.setText("Configuration:");
    
    GroupLayout conf1Layout = new GroupLayout(conf1);
    conf1.setLayout(conf1Layout);
    conf1Layout.setHorizontalGroup(conf1Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(GroupLayout.Alignment.TRAILING, conf1Layout.createSequentialGroup()
      .addGap(0, 11, 32767)
      .addGroup(conf1Layout.createParallelGroup(GroupLayout.Alignment.TRAILING)
      .addComponent(jLabel18)
      .addComponent(jLabel3))
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(jpages, -2, 57, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(jLabel1)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(loop, -2, 57, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(jLabel22)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(bids, -2, 47, -2)
      .addGap(18, 18, 18)
      .addComponent(jLabel23)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(timing, -2, 47, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(jLabel25)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(uread, -2, 57, -2)
      .addContainerGap()));
    
    conf1Layout.setVerticalGroup(conf1Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(GroupLayout.Alignment.TRAILING, conf1Layout.createSequentialGroup()
      .addContainerGap(-1, 32767)
      .addComponent(jLabel18)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addGroup(conf1Layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
      .addComponent(jLabel3)
      .addComponent(jpages, -2, -1, -2)
      .addComponent(jLabel1)
      .addComponent(loop, -2, -1, -2)
      .addComponent(jLabel22)
      .addComponent(bids, -2, -1, -2)
      .addComponent(jLabel23)
      .addComponent(timing, -2, -1, -2)
      .addComponent(jLabel25)
      .addComponent(uread, -2, -1, -2))
      .addContainerGap()));
    

    uread.getAccessibleContext().setAccessibleDescription("Support only Upwork");
    
    jLabel17.setText("Search Keywords By:");
    
    searchby.setModel(new DefaultComboBoxModel(new String[] { "Job Title", "Skills" }));
    
    jLabel20.setText("Reading Method:");
    
    method.setModel(new DefaultComboBoxModel(new String[] { "Read only keywords matched jobs", "Read all jobs from the listing page" }));
    method.setToolTipText("");
    
    jLabel2.setText("Choose Browser:");
    
    browser.setModel(new DefaultComboBoxModel(new String[] { "Chrome", "Opera", "Firefox", "Background" }));
    
    jLabel24.setText("Operating System:");
    
    os.setModel(new DefaultComboBoxModel(new String[] { "Windows", "Mac" }));
    os.addActionListener(new ActionListener() {
      public void actionPerformed(ActionEvent evt) {
        Main.this.osActionPerformed(evt);
      }
      
    });
    clip.setSelected(true);
    clip.setText("Use Clipboard ");
    
    amtfilter.setText("Set Price Filter");
    amtfilter.setToolTipText("Support only freelancer");
    amtfilter.addActionListener(new ActionListener() {
      public void actionPerformed(ActionEvent evt) {
        Main.this.amtfilterActionPerformed(evt);
      }
      
    });
    email.setText("Send result in email");
    email.setToolTipText("Support only freelancer");
    
    save.setText("Save my data");
    save.addActionListener(new ActionListener() {
      public void actionPerformed(ActionEvent evt) {
        Main.this.saveActionPerformed(evt);
      }
      
    });
    jLabel19.setText("Countries (Except):");
    
    flags.setText("Pakistan,India,etc");
    flags.setToolTipText("Support only freelancer");
    
    jLabel27.setText("Custom URL:");
    
    url.setToolTipText("example: https://www.freelancer.com/jobs/s-php-Wordpress");
    url.addActionListener(new ActionListener() {
      public void actionPerformed(ActionEvent evt) {
        Main.this.urlActionPerformed(evt);
      }
      
    });
    GroupLayout conf3Layout = new GroupLayout(conf3);
    conf3.setLayout(conf3Layout);
    conf3Layout.setHorizontalGroup(conf3Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(conf3Layout.createSequentialGroup()
      .addContainerGap()
      .addComponent(clip)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(amtfilter)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(email)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(save)
      .addGap(24, 24, 24)
      .addComponent(jLabel19)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(flags, -2, 154, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(jLabel27)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(url)
      .addContainerGap()));
    
    conf3Layout.setVerticalGroup(conf3Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(conf3Layout.createSequentialGroup()
      .addGap(25, 25, 25)
      .addGroup(conf3Layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
      .addComponent(clip)
      .addComponent(amtfilter)
      .addComponent(email)
      .addComponent(save)
      .addComponent(jLabel19)
      .addComponent(flags, -2, -1, -2)
      .addComponent(jLabel27)
      .addComponent(url, -2, -1, -2))
      .addContainerGap(-1, 32767)));
    

    GroupLayout conf2Layout = new GroupLayout(conf2);
    conf2.setLayout(conf2Layout);
    conf2Layout.setHorizontalGroup(conf2Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(conf2Layout.createSequentialGroup()
      .addContainerGap()
      .addGroup(conf2Layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(conf3, -1, -1, 32767)
      .addGroup(conf2Layout.createSequentialGroup()
      .addComponent(jLabel17)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(searchby, -2, 92, -2)
      .addGap(18, 18, 18)
      .addComponent(jLabel2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(browser, -2, 105, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(jLabel24)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(os, -2, 105, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(jLabel20)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(method, -2, -1, -2)
      .addGap(0, 40, 32767)))
      .addContainerGap()));
    
    conf2Layout.setVerticalGroup(conf2Layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(GroupLayout.Alignment.TRAILING, conf2Layout.createSequentialGroup()
      .addGap(16, 16, 16)
      .addGroup(conf2Layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
      .addComponent(jLabel17)
      .addComponent(searchby, -2, -1, -2)
      .addComponent(jLabel2)
      .addComponent(browser, -2, -1, -2)
      .addComponent(jLabel24)
      .addComponent(os, -2, -1, -2)
      .addComponent(jLabel20)
      .addComponent(method, -2, -1, -2))
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(conf3, -2, -1, -2)
      .addContainerGap(-1, 32767)));
    

    start.setText("Start Service");
    start.addItemListener(new java.awt.event.ItemListener() {
      public void itemStateChanged(ItemEvent evt) {
        Main.this.startItemStateChanged(evt);
      }
    });
    start.addActionListener(new ActionListener() {
      public void actionPerformed(ActionEvent evt) {
        Main.this.startActionPerformed(evt);
      }
      
    });
    stoptime.setForeground(new Color(255, 51, 51));
    
    starttime.setForeground(new Color(102, 102, 0));
    
    GroupLayout layout = new GroupLayout(getContentPane());
    getContentPane().setLayout(layout);
    layout.setHorizontalGroup(layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(layout.createSequentialGroup()
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(layout.createSequentialGroup()
      .addComponent(jLabel9, -2, 445, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(alert, -2, 411, -2))
      .addGroup(layout.createSequentialGroup()
      .addContainerGap()
      .addComponent(jSeparator2, -2, 903, -2))
      .addGroup(layout.createSequentialGroup()
      .addGap(461, 461, 461)
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.TRAILING)
      .addComponent(ps, -2, 800, -2)
      .addComponent(gs, -2, 800, -2)))
      .addGroup(layout.createSequentialGroup()
      .addGap(1139, 1139, 1139)
      .addComponent(progress, -2, -1, -2))
      .addGroup(GroupLayout.Alignment.TRAILING, layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(stime)
      .addGroup(layout.createSequentialGroup()
      .addGap(316, 316, 316)
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(ups, -2, 800, -2)
      .addComponent(frs, -2, 800, -2)))
      .addGroup(layout.createSequentialGroup()
      .addGap(0, 0, 32767)
      .addComponent(frp))))
      .addContainerGap(-1, 32767))
      .addGroup(layout.createSequentialGroup()
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(layout.createSequentialGroup()
      .addGap(38, 38, 38)
      .addComponent(jTabbedPane4, -2, 433, -2)
      .addGap(46, 46, 46)
      .addComponent(jTabbedPane1, -2, 452, -2))
      .addGroup(layout.createSequentialGroup()
      .addGap(25, 25, 25)
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(conf1, -2, -1, -2)
      .addGroup(layout.createSequentialGroup()
      .addComponent(start, -2, 108, -2)
      .addGap(18, 18, 18)
      .addComponent(jScrollPane1, -2, 321, -2)
      .addGap(42, 42, 42)
      .addComponent(starttime, -2, 200, -2)
      .addGap(18, 18, 18)
      .addComponent(stoptime, -2, 200, -2))
      .addComponent(conf2, -2, -1, -2))))
      .addGap(0, 0, 32767)));
    
    layout.setVerticalGroup(layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(layout.createSequentialGroup()
      .addGap(1, 1, 1)
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addComponent(jLabel9, -2, 75, -2)
      .addGroup(GroupLayout.Alignment.TRAILING, layout.createSequentialGroup()
      .addComponent(alert, -2, 27, -2)
      .addGap(15, 15, 15)))
      .addComponent(jSeparator2, -2, 10, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(layout.createSequentialGroup()
      .addComponent(jTabbedPane4, -2, -1, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addComponent(conf1, -2, -1, -2))
      .addComponent(jTabbedPane1, -2, 327, -2))
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(conf2, -2, -1, -2)
      .addPreferredGap(LayoutStyle.ComponentPlacement.UNRELATED)
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.TRAILING)
      .addComponent(start, -2, 26, -2)
      .addComponent(jScrollPane1, -2, -1, -2)
      .addComponent(stoptime, GroupLayout.Alignment.LEADING, -2, 22, -2))
      .addComponent(starttime, -2, 22, -2))
      .addGap(18, 18, 32767)
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.TRAILING)
      .addGroup(layout.createSequentialGroup()
      .addComponent(frp, -2, 9, -2)
      .addGap(17, 17, 17)
      .addComponent(progress, -2, -1, -2))
      .addGroup(layout.createSequentialGroup()
      .addComponent(frs)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(stime)
      .addGap(3, 3, 3)
      .addComponent(ups)
      .addPreferredGap(LayoutStyle.ComponentPlacement.RELATED)
      .addComponent(gs)))
      .addGap(18, 18, 18)
      .addComponent(ps)));
    

    jTabbedPane4.getAccessibleContext().setAccessibleName("Freelancer");
    
    pack();
    setLocationRelativeTo(null); }
  
  private JLabel jLabel132;
  private JLabel jLabel133;
  private JLabel jLabel134;
  private JLabel jLabel135; private JLabel jLabel14; private JLabel jLabel15; private JLabel jLabel16; private JLabel jLabel17; private JLabel jLabel18;
  private void startActionPerformed(ActionEvent evt) { Object source = evt.getSource();
    if (source == start) {
      java.util.Date date = new java.util.Date();
      final String record = date.toString();
      
      Thread hilo = new Thread(new Runnable()
      {
        public void run()
        {
          starttime.setText("Started: " + record);
          Main.start.setText("Started");
          Main.start.setBackground(Color.green);
          frp.setVisible(true);
          Main.stm.setVisible(true);
          boolean gurus = false;boolean people = false;boolean freelancers = false;boolean odeskk = false;
          Object re = Main.loop.getValue();
          Object pages = Main.jpages.getValue();
          String sb = searchby.getSelectedItem().toString();
          String rev = re.toString();
          String page = pages.toString();
          int pc = Integer.parseInt(page);
          boolean site1 = false;boolean site2 = false;boolean site3 = false;boolean site4 = false;
          int rec = Integer.parseInt(rev);
          boolean cp = Main.clip.isSelected();
          String brw = (String)Main.browser.getSelectedItem();
          String user = Main.fremail.getText();
          String pass = Main.frpassword.getText();
          String keywords1 = keys1.getText().replaceAll(", ", ",").toLowerCase();
          String keywords2 = keys2.getText().replaceAll(", ", ",").toLowerCase();
          String desc1 = app1.getText();
          String desc2 = app2.getText();
          String amt = framount.getText();
          String time = frtime.getText();
          String guser = Main.gemail.getText();
          String gpass = Main.gpassword.getText();
          String uuser = Main.upemail.getText();
          String upass = Main.uppassword.getText();
          String uamt = upamount.getText();
          String uamth = upamounthr.getText();
          String utime = Main.uptime.getSelectedItem().toString();
          String puser = Main.pemail.getText();
          String ppass = Main.ppassword.getText();
          String pamt = phmt.getText();
          String gamt = gamount.getText();
          String flg = flags.getText().replaceAll(", ", ",").toLowerCase();
          String curl = url.getText();
          Object ab = Main.bids.getValue();
          String bds = ab.toString();
          String readjobs = (String)method.getSelectedItem();
          Object lt = Main.timing.getValue();
          Object ujobs = Main.uread.getValue();
          String upj = ujobs.toString();
          Object system = Main.os.getSelectedItem();
          Object milesway = atype.getSelectedItem();
          





          String p1 = null;String p2 = null;String p3 = null;String p4 = null;String p5 = null;String p6 = null;String p7 = null;
          boolean pfilter = false;
          if (amtfilter.isEnabled()) {
            pfilter = true;
            p1 = pr1.getText();
            p2 = pr2.getText();
            p3 = pr3.getText();
            p4 = pr4.getText();
            p5 = pr5.getText();
            p6 = pr6.getText();
            p7 = pr7.getText();
          }
          
          int option = 0;
          



          try
          {
            if ((user.length() > 0) && (pass.length() > 0)) {
              freelancers = true;
              frp.setText("Freelancer Running");
              Freelancer freelancer = new Freelancer();
              String frl = freelancer.freelancer(Main.stm, brw, sb, desc1, desc2, keywords1, keywords2, amt, time, user, pass, rec, pc, cp, flg, amtfilter, p1, p2, p3, p4, p5, p6, p7, bds, readjobs, Main.eu, email, starttime, stoptime, lt, system, curl);
              
              if (frs != null) {
                site1 = true;
                frp.setVisible(false);
              }
            }
            



            if ((guser.length() > 0) && (gpass.length() > 0)) {
              gurus = true;
              frp.setText("Guru Running");
              
              Guru guru = new Guru();
              String gur = guru.guru(Main.stm, brw, sb, desc1, desc2, keywords1, keywords2, gamt, time, guser, gpass, rec, pc, cp, flg, amtfilter, p1, p2, p3, p4, p5, p6, p7, bds, readjobs, Main.eu, email, lt, system, curl, milesway);
              
              if (gur != null) {
                site2 = true;
              }
            }
            



            if ((puser.length() > 0) && (ppass.length() > 0)) {
              people = true;
              frp.setText("PPH Running");
              
              Pph pph = new Pph();
              String ph = pph.pph(Main.stm, desc1, desc2, keywords1, keywords2, pamt, puser, ppass, rec, brw, cp);
              
              if (ph != null) {
                site3 = true;
              }
            }
            


            if ((uuser.length() > 0) && (upass.length() > 0)) {
              odeskk = true;
              frp.setText("Upwork Running");
              
              Odesk odesk = new Odesk();
              String odk = odesk.odesk(Main.stm, brw, sb, desc1, desc2, keywords1, keywords2, uamt, uamth, utime, uuser, upass, rec, pc, cp, flg, amtfilter, p1, p2, p3, p4, p5, p6, p7, bds, readjobs, Main.eu, email, lt, system, upj);
              
              if (odk != null) {
                site4 = true;
              }
            }
            
            if ((freelancers == true) && (!gurus) && (!people) && (!odeskk) && 
              (site1 == true)) {
              Main.start.setText("Completed");
              Main.start.setBackground(Color.red);
            }
            

            if ((freelancers == true) && (gurus == true) && (!people) && (!odeskk) && 
              (site1 == true) && (site2 == true)) {
              Main.start.setText("Completed");
              Main.start.setBackground(Color.red);
            }
            

            if ((freelancers == true) && (gurus == true) && (people == true) && (!odeskk) && 
              (site1 == true) && (site2 == true) && (site3 == true)) {
              Main.start.setText("Completed");
              Main.start.setBackground(Color.red);
            }
            

            if ((freelancers == true) && (gurus == true) && (people == true) && (odeskk == true) && 
              (site1 == true) && (site2 == true) && (site3 == true) && (site4 == true)) {
              Main.start.setText("Completed");
              Main.start.setBackground(Color.red);
            }
            
          }
          catch (java.awt.AWTException ex)
          {
            Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
          } catch (Exception ex) {
            Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
          }
          

          if ((user.isEmpty()) && (pass.isEmpty()) && (guser.isEmpty()) && (gpass.isEmpty()) && 
            (uuser.isEmpty()) && (upass.isEmpty())) {}








        }
        








      });
      hilo.start(); } }
  
  private JLabel jLabel19;
  private JLabel jLabel2;
  
  private void frpasswordActionPerformed(ActionEvent evt) {}
  
  private void startItemStateChanged(ItemEvent evt) {}
  
  private void keys2ActionPerformed(ActionEvent evt) {}
  
  private void uppasswordActionPerformed(ActionEvent evt) {}
  
  private void gpasswordActionPerformed(ActionEvent evt) {}
  
  private void ppasswordActionPerformed(ActionEvent evt) {}
  private JLabel jLabel20;
  private JLabel jLabel22;
  private JLabel jLabel23;
  private JLabel jLabel24;
  private JLabel jLabel25;
  private JLabel jLabel26;
  private JLabel jLabel27;
  private JLabel jLabel3;
  private JLabel jLabel4;
  private JLabel jLabel5;
  private JLabel jLabel6;
  private JLabel jLabel7;
  private JLabel jLabel8;
  private JLabel jLabel9;
  private javax.swing.JMenu jMenu3;
  private JMenuItem jMenuItem1;
  private JPanel jPanel3;
  private JPanel jPanel54;
  private JPanel jPanel55;
  private JPanel jPanel56; private JPanel jPanel57; private JPanel jPanel58; private JPanel jPanel59; private JPanel jPanel60; private JPanel jPanel61;
  private void amtfilterActionPerformed(ActionEvent evt) { Object[] Payments = { "For Max-cost 100 (Applied to all currencies):", pr1, "For Max-cost 250 (Applied to all currencies)", pr2, "For Max-cost 500 (Applied to all currencies)", pr3, "For Max-cost 750 (Applied to all currencies)", pr4, "For Max-cost 1500 (Applied to all currencies)", pr5, "For Max-cost 3000 (Applied to all currencies)", pr6, "For Max-cost 5000 (Applied to all currencies)", pr7 };
    









    javax.swing.JOptionPane.showConfirmDialog(null, Payments, "Set Amount for different job-budget", 2); }
  
  private JPanel jPanel7;
  private JPopupMenu jPopupMenu1;
  private JPopupMenu jPopupMenu2;
  private JPopupMenu jPopupMenu3; private JPopupMenu jPopupMenu4; private JPopupMenu jPopupMenu5; private JScrollPane jScrollPane1; private JScrollPane jScrollPane2; private JScrollPane jScrollPane3;
  private void saveActionPerformed(ActionEvent evt) { System.out.println();
    try {
      boolean gurus = false;boolean people = false;boolean freelancers = false;boolean odeskk = false;
      
      String user = fremail.getText();
      String pass = frpassword.getText();
      String keywords1 = keys1.getText();
      String keywords2 = keys2.getText();
      String desc1 = app1.getText();
      String desc2 = app2.getText();
      String guser = gemail.getText();
      String gpass = gpassword.getText();
      String uuser = upemail.getText();
      String upass = uppassword.getText();
      String puser = pemail.getText();
      String ppass = ppassword.getText();
      String readpages = jpages.getValue().toString();
      String recheck = loop.getValue().toString();
      String sby = searchby.getSelectedItem().toString();
      String curl = url.getText();
      String countries = flags.getText();
      
      new createxml(user, pass, uuser, upass, guser, gpass, puser, ppass, desc1, desc2, keywords1, keywords2, readpages, recheck, sby, curl, countries);
    }
    catch (java.io.IOException ex) {
      Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
    } catch (org.xml.sax.SAXException ex) {
      Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex); } }
  
  private JSeparator jSeparator2;
  private JSeparator jSeparator20;
  private JSeparator jSeparator21;
  private JSeparator jSeparator22; private JSeparator jSeparator23; private JTabbedPane jTabbedPane1; private JTabbedPane jTabbedPane4;
  private void jpagesStateChanged(ChangeEvent evt) { loop.setValue(jpages.getValue()); }
  
  private static JSpinner jpages;
  private JTextField keys1;
  private JTextField keys2;
  private void osActionPerformed(ActionEvent evt) { if (os.getSelectedItem() == "Mac")
      browser.setSelectedItem("Chrome"); }
  
  private static JSpinner loop;
  private Menu menu1;
  private Menu menu2;
  private MenuBar menuBar1;
  private JComboBox method;
  private JLabel msg1;
  private JLabel msg2;
  private JLabel msg3;
  private JLabel msg4;
  private static JComboBox os;
  private JTextField pamount;
  private static JTextField pemail;
  private JTextField phmt;
  private static JPasswordField ppassword;
  private JPanel progress;
  
  private void urlActionPerformed(ActionEvent evt) {}
  public static void main(String[] args) { try { for (UIManager.LookAndFeelInfo info : ) {
        if ("Nimbus".equals(info.getName())) {
          javax.swing.UIManager.setLookAndFeel(info.getClassName());
          break;
        }
      }
    } catch (ClassNotFoundException ex) {
      Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
    } catch (InstantiationException ex) {
      Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
    } catch (IllegalAccessException ex) {
      Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
    } catch (javax.swing.UnsupportedLookAndFeelException ex) {
      Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
    }
    

    java.awt.EventQueue.invokeLater(new Runnable()
    {
      public void run() {}
    });
  }
  
  private JLabel ps;
  private JTextField ptime;
  private JCheckBox save;
  private JComboBox searchby;
  public static JButton start;
  private JLabel starttime;
  public static JLabel stime;
  public static JTextPane stm;
  private JLabel stoptime;
  private static JSpinner timing;
  private JTextField upamount;
  private JTextField upamounthr;
  private static JTextField upemail;
  private static JPasswordField uppassword;
  private JLabel ups;
  private static JComboBox uptime;
  private static JSpinner uread;
  private JTextField url;
}
