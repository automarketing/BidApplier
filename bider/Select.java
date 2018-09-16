package freelancer.bider;

import java.awt.event.ActionEvent;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.GroupLayout;
import javax.swing.GroupLayout.Alignment;
import javax.swing.GroupLayout.SequentialGroup;
import javax.swing.JButton;
import javax.swing.UIManager.LookAndFeelInfo;
import javax.swing.UnsupportedLookAndFeelException;

public class Select extends javax.swing.JFrame
{
  private JButton jButton1;
  
  public Select(String auth)
  {
    if (auth == "success")
    {
      initComponents();
    }
  }
  







  private void initComponents()
  {
    jButton1 = new JButton();
    
    setDefaultCloseOperation(3);
    
    jButton1.setText("Version 1");
    jButton1.addActionListener(new java.awt.event.ActionListener() {
      public void actionPerformed(ActionEvent evt) {
        Select.this.jButton1ActionPerformed(evt);
      }
      
    });
    GroupLayout layout = new GroupLayout(getContentPane());
    getContentPane().setLayout(layout);
    layout.setHorizontalGroup(layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(layout.createSequentialGroup()
      .addGap(136, 136, 136)
      .addComponent(jButton1)
      .addContainerGap(187, 32767)));
    
    layout.setVerticalGroup(layout
      .createParallelGroup(GroupLayout.Alignment.LEADING)
      .addGroup(GroupLayout.Alignment.TRAILING, layout.createSequentialGroup()
      .addContainerGap(159, 32767)
      .addComponent(jButton1)
      .addGap(118, 118, 118)));
    

    pack();
  }
  




  private void jButton1ActionPerformed(ActionEvent evt) {}
  




  public static void main(String[] args)
  {
    try
    {
      for (UIManager.LookAndFeelInfo info : ) {
        if ("Nimbus".equals(info.getName())) {
          javax.swing.UIManager.setLookAndFeel(info.getClassName());
          break;
        }
      }
    } catch (ClassNotFoundException ex) {
      Logger.getLogger(Select.class.getName()).log(Level.SEVERE, null, ex);
    } catch (InstantiationException ex) {
      Logger.getLogger(Select.class.getName()).log(Level.SEVERE, null, ex);
    } catch (IllegalAccessException ex) {
      Logger.getLogger(Select.class.getName()).log(Level.SEVERE, null, ex);
    } catch (UnsupportedLookAndFeelException ex) {
      Logger.getLogger(Select.class.getName()).log(Level.SEVERE, null, ex);
    }
    


    java.awt.EventQueue.invokeLater(new Runnable() {
      public void run() {
        new Select("").setVisible(true);
      }
    });
  }
}
