using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Management;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.IO;
using System.Collections;
using System.Security.Cryptography;
 


namespace Fitness.Gui
{
    public partial class LicenseCheck : Form
    {
        public LicenseCheck()
        {
            InitializeComponent();

            ManagementObjectSearcher searcher = new
            ManagementObjectSearcher("SELECT * FROM Win32_DiskDrive");

            string hardstr = "";

            foreach (ManagementObject wmi_HD in searcher.Get())
            {
                hardstr += wmi_HD["Model"].ToString() + wmi_HD["InterfaceType"].ToString();
            }
            txtRequest.Text = GetHashString(hardstr).Substring(0,24);
        }

        private void button2_Click(object sender, EventArgs e)
        {
            System.Windows.Forms.Application.Exit();
        }

        public static byte[] GetHash(string inputString)
        {
            HashAlgorithm algorithm = MD5.Create();  //or use SHA256.Create();
            return algorithm.ComputeHash(Encoding.UTF8.GetBytes(inputString));
        }

        public static string GetHashString(string inputString)
        {
            StringBuilder sb = new StringBuilder();
            foreach (byte b in GetHash(inputString))
                sb.Append(b.ToString("X2"));

            return sb.ToString();
        }

        private string get_encryption(string src)
        {
            src += "ServerHashCode";

            return GetHashString(src);
        }

        private void btnActivate_Click(object sender, EventArgs e)
        { 
            if (get_encryption(txtRequest.Text) == txtActivate.Text)
            {
                this.Hide();
            }
        }
    }
}
