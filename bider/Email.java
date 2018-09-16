package freelancer.bider;

import java.io.PrintStream;
import java.io.UnsupportedEncodingException;
import java.util.Properties;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.mail.Authenticator;
import javax.mail.Message;
import javax.mail.Message.RecipientType;
import javax.mail.MessagingException;
import javax.mail.PasswordAuthentication;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;








public class Email
{
  public Email(String to, String subject, String report)
  {
    Properties props = new Properties();
    props.put("mail.smtp.host", "server5.websitehostserver.net");
    props.put("mail.smtp.socketFactory.port", "465");
    props.put("mail.smtp.socketFactory.class", "javax.net.ssl.SSLSocketFactory");
    
    props.put("mail.smtp.auth", "true");
    props.put("mail.smtp.port", "465");
    
    Session session = Session.getDefaultInstance(props, new Authenticator()
    {
      protected PasswordAuthentication getPasswordAuthentication() {
        return new PasswordAuthentication("support@eapplier.com", "elambak@differently7");
      }
    });
    
    try
    {
      Message message = new MimeMessage(session);
      message.setFrom(new InternetAddress("support@eapplier.com", "E-Applier"));
      message.setRecipients(Message.RecipientType.TO, 
        InternetAddress.parse(to));
      message.setSubject(subject);
      message.setText(report);
      
      Transport.send(message);
      
      System.out.println("Done");
    }
    catch (MessagingException e) {
      throw new RuntimeException(e);
    } catch (UnsupportedEncodingException ex) {
      Logger.getLogger(Email.class.getName()).log(Level.SEVERE, null, ex);
    }
  }
}
