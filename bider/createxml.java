package freelancer.bider;

import java.io.File;
import java.io.IOException;
import java.io.PrintStream;
import javax.swing.JOptionPane;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerException;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;
import org.w3c.dom.Attr;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.xml.sax.SAXException;









public class createxml
{
  public createxml(String fruser, String frpass, String uuser, String upass, String guser, String gpass, String puser, String ppass, String det1, String det2, String keys1, String keys2, String rp, String rc, String searchby, String url, String cfilter)
    throws IOException, SAXException
  {
    try
    {
      DocumentBuilderFactory docFactory = DocumentBuilderFactory.newInstance();
      DocumentBuilder docBuilder = docFactory.newDocumentBuilder();
      File file = new File("mydata.xml");
      if (file.exists()) {
        String filepath = "mydata.xml";
        Document doc = docBuilder.parse(filepath);
        

        Node user = doc.getFirstChild();
        






        Node data = doc.getElementsByTagName("data").item(0);
        



        NodeList list = data.getChildNodes();
        
        for (int i = 0; i < list.getLength(); i++)
        {
          Node node = list.item(i);
          


          if ("freelancer-user".equals(node.getNodeName()))
            node.setTextContent(fruser);
          if ("freelancer-pass".equals(node.getNodeName()))
            node.setTextContent(frpass);
          if ("upwork-user".equals(node.getNodeName()))
            node.setTextContent(uuser);
          if ("upwork-pass".equals(node.getNodeName()))
            node.setTextContent(upass);
          if ("guru-user".equals(node.getNodeName()))
            node.setTextContent(guser);
          if ("guru-pass".equals(node.getNodeName()))
            node.setTextContent(gpass);
          if ("pph-user".equals(node.getNodeName()))
            node.setTextContent(puser);
          if ("pph-pass".equals(node.getNodeName())) {
            node.setTextContent(ppass);
          }
          if ("detail-1".equals(node.getNodeName()))
            node.setTextContent(det1);
          if ("detail-2".equals(node.getNodeName()))
            node.setTextContent(det2);
          if ("keys-1".equals(node.getNodeName()))
            node.setTextContent(keys1);
          if ("keys-2".equals(node.getNodeName())) {
            node.setTextContent(keys2);
          }
          if ("read-pages".equals(node.getNodeName()))
            node.setTextContent(rp);
          if ("recheck-loop".equals(node.getNodeName()))
            node.setTextContent(rc);
          if ("search-by".equals(node.getNodeName()))
            node.setTextContent(searchby);
          if ("c-url".equals(node.getNodeName()))
            node.setTextContent(url);
          if ("country-filter".equals(node.getNodeName())) {
            node.setTextContent(cfilter);
          }
        }
        







        TransformerFactory transformerFactory = TransformerFactory.newInstance();
        Transformer transformer = transformerFactory.newTransformer();
        DOMSource source = new DOMSource(doc);
        StreamResult result = new StreamResult(new File(filepath));
        transformer.transform(source, result);
        
        System.out.println("Updated");
        JOptionPane.showMessageDialog(null, "Your data is updated");



      }
      else
      {


        Document doc = docBuilder.newDocument();
        Element rootElement = doc.createElement("user");
        doc.appendChild(rootElement);
        

        Element data = doc.createElement("data");
        rootElement.appendChild(data);
        

        Attr attr = doc.createAttribute("id");
        attr.setValue("1");
        data.setAttributeNode(attr);
        




        Element fe = doc.createElement("freelancer-user");
        fe.appendChild(doc.createTextNode(fruser));
        data.appendChild(fe);
        

        Element fp = doc.createElement("freelancer-pass");
        fp.appendChild(doc.createTextNode(frpass));
        data.appendChild(fp);
        

        Element ue = doc.createElement("upwork-user");
        ue.appendChild(doc.createTextNode(uuser));
        data.appendChild(ue);
        

        Element up = doc.createElement("upwork-pass");
        up.appendChild(doc.createTextNode(upass));
        data.appendChild(up);
        
        Element ge = doc.createElement("guru-user");
        ge.appendChild(doc.createTextNode(guser));
        data.appendChild(ge);
        

        Element gp = doc.createElement("guru-pass");
        gp.appendChild(doc.createTextNode(gpass));
        data.appendChild(gp);
        
        Element pe = doc.createElement("pph-user");
        pe.appendChild(doc.createTextNode(puser));
        data.appendChild(pe);
        

        Element pp = doc.createElement("pph-pass");
        pp.appendChild(doc.createTextNode(ppass));
        data.appendChild(pp);
        
        Element d1 = doc.createElement("detail-1");
        d1.appendChild(doc.createTextNode(det1));
        data.appendChild(d1);
        
        Element d2 = doc.createElement("detail-2");
        d2.appendChild(doc.createTextNode(det2));
        data.appendChild(d2);
        
        Element k1 = doc.createElement("keys-1");
        k1.appendChild(doc.createTextNode(keys1));
        data.appendChild(k1);
        
        Element k2 = doc.createElement("keys-2");
        k2.appendChild(doc.createTextNode(keys2));
        data.appendChild(k2);
        
        Element rps = doc.createElement("read-pages");
        rps.appendChild(doc.createTextNode(rp));
        data.appendChild(rps);
        
        Element rcs = doc.createElement("recheck-loop");
        rcs.appendChild(doc.createTextNode(rc));
        data.appendChild(rcs);
        
        Element sby = doc.createElement("search-by");
        sby.appendChild(doc.createTextNode(searchby));
        data.appendChild(sby);
        
        Element curl = doc.createElement("c-url");
        curl.appendChild(doc.createTextNode(url));
        data.appendChild(curl);
        
        Element countries = doc.createElement("country-filter");
        countries.appendChild(doc.createTextNode(cfilter));
        data.appendChild(countries);
        

        TransformerFactory transformerFactory = TransformerFactory.newInstance();
        Transformer transformer = transformerFactory.newTransformer();
        DOMSource source = new DOMSource(doc);
        StreamResult result = new StreamResult(new File("mydata.xml"));
        



        transformer.transform(source, result);
        
        System.out.println("File saved!");
        JOptionPane.showMessageDialog(null, "Your data is saved");
      }
    }
    catch (ParserConfigurationException pce) {
      pce.printStackTrace();
    } catch (TransformerException tfe) {
      tfe.printStackTrace();
    }
  }
}
