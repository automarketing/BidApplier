namespace Fitness.Gui
{
    partial class MainForm
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.txtStrategy = new System.Windows.Forms.TextBox();
            this.txtPerGeneration = new System.Windows.Forms.TextBox();
            this.txtminrule = new System.Windows.Forms.TextBox();
            this.label1 = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.label3 = new System.Windows.Forms.Label();
            this.label4 = new System.Windows.Forms.Label();
            this.label5 = new System.Windows.Forms.Label();
            this.txtmaxrule = new System.Windows.Forms.TextBox();
            this.button1 = new System.Windows.Forms.Button();
            this.groupBox1 = new System.Windows.Forms.GroupBox();
            this.enddatePicker = new System.Windows.Forms.DateTimePicker();
            this.startdatePicker = new System.Windows.Forms.DateTimePicker();
            this.btn_randomclear = new System.Windows.Forms.Button();
            this.label9 = new System.Windows.Forms.Label();
            this.btn_random1000 = new System.Windows.Forms.Button();
            this.btn_random500 = new System.Windows.Forms.Button();
            this.label6 = new System.Windows.Forms.Label();
            this.cboBetStyle = new System.Windows.Forms.ComboBox();
            this.comboBox1 = new System.Windows.Forms.ComboBox();
            this.label7 = new System.Windows.Forms.Label();
            this.button2 = new System.Windows.Forms.Button();
            this.signalchecklist = new System.Windows.Forms.CheckedListBox();
            this.label8 = new System.Windows.Forms.Label();
            this.groupBox1.SuspendLayout();
            this.SuspendLayout();
            // 
            // txtStrategy
            // 
            this.txtStrategy.Location = new System.Drawing.Point(22, 94);
            this.txtStrategy.Name = "txtStrategy";
            this.txtStrategy.Size = new System.Drawing.Size(125, 20);
            this.txtStrategy.TabIndex = 0;
            // 
            // txtPerGeneration
            // 
            this.txtPerGeneration.Location = new System.Drawing.Point(22, 247);
            this.txtPerGeneration.Name = "txtPerGeneration";
            this.txtPerGeneration.Size = new System.Drawing.Size(125, 20);
            this.txtPerGeneration.TabIndex = 2;
            // 
            // txtminrule
            // 
            this.txtminrule.Location = new System.Drawing.Point(22, 298);
            this.txtminrule.Name = "txtminrule";
            this.txtminrule.Size = new System.Drawing.Size(125, 20);
            this.txtminrule.TabIndex = 3;
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(22, 75);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(107, 13);
            this.label1.TabIndex = 4;
            this.label1.Text = "Number of strategies:";
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(22, 126);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(52, 13);
            this.label2.TabIndex = 5;
            this.label2.Text = "StartDate";
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Location = new System.Drawing.Point(22, 228);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(110, 13);
            this.label3.TabIndex = 6;
            this.label3.Text = "Tests Per Generation:";
            // 
            // label4
            // 
            this.label4.AutoSize = true;
            this.label4.Location = new System.Drawing.Point(22, 279);
            this.label4.Name = "label4";
            this.label4.Size = new System.Drawing.Size(112, 13);
            this.label4.TabIndex = 7;
            this.label4.Text = "Number of Rules(Min):";
            // 
            // label5
            // 
            this.label5.AutoSize = true;
            this.label5.Location = new System.Drawing.Point(22, 330);
            this.label5.Name = "label5";
            this.label5.Size = new System.Drawing.Size(115, 13);
            this.label5.TabIndex = 9;
            this.label5.Text = "Number of Rules(Max):";
            // 
            // txtmaxrule
            // 
            this.txtmaxrule.Location = new System.Drawing.Point(22, 349);
            this.txtmaxrule.Name = "txtmaxrule";
            this.txtmaxrule.Size = new System.Drawing.Size(125, 20);
            this.txtmaxrule.TabIndex = 8;
            // 
            // button1
            // 
            this.button1.Location = new System.Drawing.Point(203, 628);
            this.button1.Name = "button1";
            this.button1.Size = new System.Drawing.Size(135, 31);
            this.button1.TabIndex = 12;
            this.button1.Text = "Simulate";
            this.button1.UseVisualStyleBackColor = true;
            this.button1.Click += new System.EventHandler(this.button1_Click);
            // 
            // groupBox1
            // 
            this.groupBox1.Controls.Add(this.enddatePicker);
            this.groupBox1.Controls.Add(this.startdatePicker);
            this.groupBox1.Controls.Add(this.btn_randomclear);
            this.groupBox1.Controls.Add(this.label9);
            this.groupBox1.Controls.Add(this.label5);
            this.groupBox1.Controls.Add(this.label2);
            this.groupBox1.Controls.Add(this.btn_random1000);
            this.groupBox1.Controls.Add(this.btn_random500);
            this.groupBox1.Controls.Add(this.label3);
            this.groupBox1.Controls.Add(this.label1);
            this.groupBox1.Controls.Add(this.label6);
            this.groupBox1.Controls.Add(this.cboBetStyle);
            this.groupBox1.Controls.Add(this.txtStrategy);
            this.groupBox1.Controls.Add(this.txtmaxrule);
            this.groupBox1.Controls.Add(this.label4);
            this.groupBox1.Controls.Add(this.txtminrule);
            this.groupBox1.Controls.Add(this.txtPerGeneration);
            this.groupBox1.Location = new System.Drawing.Point(24, 94);
            this.groupBox1.Name = "groupBox1";
            this.groupBox1.Size = new System.Drawing.Size(168, 497);
            this.groupBox1.TabIndex = 13;
            this.groupBox1.TabStop = false;
            this.groupBox1.Text = "Input Parameters";
            this.groupBox1.Enter += new System.EventHandler(this.groupBox1_Enter);
            // 
            // enddatePicker
            // 
            this.enddatePicker.Format = System.Windows.Forms.DateTimePickerFormat.Custom;
            this.enddatePicker.Location = new System.Drawing.Point(22, 196);
            this.enddatePicker.Name = "enddatePicker";
            this.enddatePicker.Size = new System.Drawing.Size(126, 20);
            this.enddatePicker.TabIndex = 31;
            // 
            // startdatePicker
            // 
            this.startdatePicker.Format = System.Windows.Forms.DateTimePickerFormat.Custom;
            this.startdatePicker.Location = new System.Drawing.Point(22, 145);
            this.startdatePicker.Name = "startdatePicker";
            this.startdatePicker.Size = new System.Drawing.Size(126, 20);
            this.startdatePicker.TabIndex = 30;
            this.startdatePicker.Value = new System.DateTime(2006, 1, 1, 0, 0, 0, 0);
            // 
            // btn_randomclear
            // 
            this.btn_randomclear.Location = new System.Drawing.Point(22, 456);
            this.btn_randomclear.Name = "btn_randomclear";
            this.btn_randomclear.Size = new System.Drawing.Size(125, 21);
            this.btn_randomclear.TabIndex = 22;
            this.btn_randomclear.Text = "Clear";
            this.btn_randomclear.UseVisualStyleBackColor = true;
            this.btn_randomclear.Click += new System.EventHandler(this.btn_randomclear_Click);
            // 
            // label9
            // 
            this.label9.AutoSize = true;
            this.label9.Location = new System.Drawing.Point(22, 23);
            this.label9.Name = "label9";
            this.label9.Size = new System.Drawing.Size(66, 13);
            this.label9.TabIndex = 29;
            this.label9.Text = "Betting Style";
            // 
            // btn_random1000
            // 
            this.btn_random1000.Location = new System.Drawing.Point(22, 419);
            this.btn_random1000.Name = "btn_random1000";
            this.btn_random1000.Size = new System.Drawing.Size(125, 21);
            this.btn_random1000.TabIndex = 21;
            this.btn_random1000.Text = "Random 1000";
            this.btn_random1000.UseVisualStyleBackColor = true;
            this.btn_random1000.Click += new System.EventHandler(this.btn_random1000_Click);
            // 
            // btn_random500
            // 
            this.btn_random500.Location = new System.Drawing.Point(22, 385);
            this.btn_random500.Name = "btn_random500";
            this.btn_random500.Size = new System.Drawing.Size(125, 21);
            this.btn_random500.TabIndex = 20;
            this.btn_random500.Text = "Random 500";
            this.btn_random500.UseVisualStyleBackColor = true;
            this.btn_random500.Click += new System.EventHandler(this.btn_random500_Click);
            // 
            // label6
            // 
            this.label6.AutoSize = true;
            this.label6.Location = new System.Drawing.Point(22, 177);
            this.label6.Name = "label6";
            this.label6.Size = new System.Drawing.Size(49, 13);
            this.label6.TabIndex = 11;
            this.label6.Text = "EndDate";
            // 
            // cboBetStyle
            // 
            this.cboBetStyle.Font = new System.Drawing.Font("Microsoft Sans Serif", 8F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.cboBetStyle.FormattingEnabled = true;
            this.cboBetStyle.ItemHeight = 13;
            this.cboBetStyle.Items.AddRange(new object[] {
            "spread",
            "over",
            "under",
            "moneyline"});
            this.cboBetStyle.Location = new System.Drawing.Point(22, 42);
            this.cboBetStyle.Name = "cboBetStyle";
            this.cboBetStyle.Size = new System.Drawing.Size(125, 21);
            this.cboBetStyle.TabIndex = 28;
            this.cboBetStyle.Text = "spread";
            // 
            // comboBox1
            // 
            this.comboBox1.Font = new System.Drawing.Font("Microsoft Sans Serif", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.comboBox1.FormattingEnabled = true;
            this.comboBox1.Location = new System.Drawing.Point(24, 44);
            this.comboBox1.Name = "comboBox1";
            this.comboBox1.Size = new System.Drawing.Size(125, 28);
            this.comboBox1.TabIndex = 14;
            // 
            // label7
            // 
            this.label7.AutoSize = true;
            this.label7.Font = new System.Drawing.Font("Microsoft Sans Serif", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label7.Location = new System.Drawing.Point(21, 15);
            this.label7.Name = "label7";
            this.label7.Size = new System.Drawing.Size(126, 20);
            this.label7.TabIndex = 15;
            this.label7.Text = "Choose League:";
            // 
            // button2
            // 
            this.button2.Location = new System.Drawing.Point(40, 632);
            this.button2.Name = "button2";
            this.button2.Size = new System.Drawing.Size(135, 23);
            this.button2.TabIndex = 18;
            this.button2.Text = "Generate File";
            this.button2.UseVisualStyleBackColor = true;
            this.button2.Visible = false;
            this.button2.Click += new System.EventHandler(this.button2_Click);
            // 
            // signalchecklist
            // 
            this.signalchecklist.FormattingEnabled = true;
            this.signalchecklist.Location = new System.Drawing.Point(225, 44);
            this.signalchecklist.Name = "signalchecklist";
            this.signalchecklist.Size = new System.Drawing.Size(314, 544);
            this.signalchecklist.TabIndex = 19;
            // 
            // label8
            // 
            this.label8.AutoSize = true;
            this.label8.Font = new System.Drawing.Font("Microsoft Sans Serif", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label8.Location = new System.Drawing.Point(229, 15);
            this.label8.Name = "label8";
            this.label8.Size = new System.Drawing.Size(61, 20);
            this.label8.TabIndex = 20;
            this.label8.Text = "Signals";
            // 
            // MainForm
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(560, 677);
            this.Controls.Add(this.label8);
            this.Controls.Add(this.signalchecklist);
            this.Controls.Add(this.button2);
            this.Controls.Add(this.label7);
            this.Controls.Add(this.comboBox1);
            this.Controls.Add(this.button1);
            this.Controls.Add(this.groupBox1);
            this.Name = "MainForm";
            this.Text = "Input Parameters";
            this.Load += new System.EventHandler(this.Form1_Load);
            this.groupBox1.ResumeLayout(false);
            this.groupBox1.PerformLayout();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.TextBox txtStrategy;
        private System.Windows.Forms.TextBox txtPerGeneration;
        private System.Windows.Forms.TextBox txtminrule;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.Label label3;
        private System.Windows.Forms.Label label4;
        private System.Windows.Forms.Label label5;
        private System.Windows.Forms.TextBox txtmaxrule;
        private System.Windows.Forms.Button button1;
        private System.Windows.Forms.GroupBox groupBox1;
        private System.Windows.Forms.ComboBox comboBox1;
        private System.Windows.Forms.Label label7;
        private System.Windows.Forms.Button button2;
        private System.Windows.Forms.Label label9;
        private System.Windows.Forms.ComboBox cboBetStyle;
        private System.Windows.Forms.Button btn_randomclear;
        private System.Windows.Forms.Button btn_random1000;
        private System.Windows.Forms.Button btn_random500;
        private System.Windows.Forms.CheckedListBox signalchecklist;
        private System.Windows.Forms.Label label8;
        private System.Windows.Forms.DateTimePicker enddatePicker;
        private System.Windows.Forms.DateTimePicker startdatePicker;
        private System.Windows.Forms.Label label6;
    }
}

