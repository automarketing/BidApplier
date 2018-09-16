package freelancer.bider;

import java.io.PrintStream;


















































public class Testdriver
{
  public Testdriver() {}
  
  public static void main(String[] a)
    throws Exception
  {
    String str = "50.00";
    String substr = ".";
    String bud = str.substring(0, str.indexOf(substr));
    String amt = "50";
    int total = Integer.parseInt(bud);
    int budg = Integer.parseInt(amt);
    int perc = budg * total / 100;
    System.out.println("Job Budget:" + total + "User Amount" + amt + "Percent of budget" + perc);
  }
}
