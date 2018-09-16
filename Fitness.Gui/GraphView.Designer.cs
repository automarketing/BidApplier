namespace Fitness.Gui
{
    partial class GraphView
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
            System.Windows.Forms.DataVisualization.Charting.ChartArea chartArea8 = new System.Windows.Forms.DataVisualization.Charting.ChartArea();
            System.Windows.Forms.DataVisualization.Charting.Legend legend8 = new System.Windows.Forms.DataVisualization.Charting.Legend();
            System.Windows.Forms.DataVisualization.Charting.Series series8 = new System.Windows.Forms.DataVisualization.Charting.Series();
            System.Windows.Forms.DataVisualization.Charting.ChartArea chartArea9 = new System.Windows.Forms.DataVisualization.Charting.ChartArea();
            System.Windows.Forms.DataVisualization.Charting.Legend legend9 = new System.Windows.Forms.DataVisualization.Charting.Legend();
            System.Windows.Forms.DataVisualization.Charting.Series series9 = new System.Windows.Forms.DataVisualization.Charting.Series();
            System.Windows.Forms.DataVisualization.Charting.ChartArea chartArea10 = new System.Windows.Forms.DataVisualization.Charting.ChartArea();
            System.Windows.Forms.DataVisualization.Charting.Legend legend10 = new System.Windows.Forms.DataVisualization.Charting.Legend();
            System.Windows.Forms.DataVisualization.Charting.Series series10 = new System.Windows.Forms.DataVisualization.Charting.Series();
            System.Windows.Forms.DataVisualization.Charting.ChartArea chartArea11 = new System.Windows.Forms.DataVisualization.Charting.ChartArea();
            System.Windows.Forms.DataVisualization.Charting.Legend legend11 = new System.Windows.Forms.DataVisualization.Charting.Legend();
            System.Windows.Forms.DataVisualization.Charting.Series series11 = new System.Windows.Forms.DataVisualization.Charting.Series();
            System.Windows.Forms.DataVisualization.Charting.ChartArea chartArea12 = new System.Windows.Forms.DataVisualization.Charting.ChartArea();
            System.Windows.Forms.DataVisualization.Charting.Legend legend12 = new System.Windows.Forms.DataVisualization.Charting.Legend();
            System.Windows.Forms.DataVisualization.Charting.Series series12 = new System.Windows.Forms.DataVisualization.Charting.Series();
            System.Windows.Forms.DataVisualization.Charting.ChartArea chartArea13 = new System.Windows.Forms.DataVisualization.Charting.ChartArea();
            System.Windows.Forms.DataVisualization.Charting.Legend legend13 = new System.Windows.Forms.DataVisualization.Charting.Legend();
            System.Windows.Forms.DataVisualization.Charting.Series series13 = new System.Windows.Forms.DataVisualization.Charting.Series();
            System.Windows.Forms.DataVisualization.Charting.ChartArea chartArea14 = new System.Windows.Forms.DataVisualization.Charting.ChartArea();
            System.Windows.Forms.DataVisualization.Charting.Legend legend14 = new System.Windows.Forms.DataVisualization.Charting.Legend();
            System.Windows.Forms.DataVisualization.Charting.Series series14 = new System.Windows.Forms.DataVisualization.Charting.Series();
            this.ChartPieProfit = new System.Windows.Forms.DataVisualization.Charting.Chart();
            this.dataGridView = new System.Windows.Forms.DataGridView();
            this.SignalNames = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.TotalPL = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.DD = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.Bets = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.Win = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.PF = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.Sharpe = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.ChartPieWinLoss = new System.Windows.Forms.DataVisualization.Charting.Chart();
            this.MonthChart = new System.Windows.Forms.DataVisualization.Charting.Chart();
            this.YearChart = new System.Windows.Forms.DataVisualization.Charting.Chart();
            this.MonteChart = new System.Windows.Forms.DataVisualization.Charting.Chart();
            this.ChartCumulative2 = new System.Windows.Forms.DataVisualization.Charting.Chart();
            this.ChartCumulative1 = new System.Windows.Forms.DataVisualization.Charting.Chart();
            ((System.ComponentModel.ISupportInitialize)(this.ChartPieProfit)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.dataGridView)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.ChartPieWinLoss)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.MonthChart)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.YearChart)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.MonteChart)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.ChartCumulative2)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.ChartCumulative1)).BeginInit();
            this.SuspendLayout();
            // 
            // ChartPieProfit
            // 
            this.ChartPieProfit.BackColor = System.Drawing.Color.Thistle;
            this.ChartPieProfit.BorderSkin.BackSecondaryColor = System.Drawing.Color.White;
            chartArea8.BackColor = System.Drawing.Color.Transparent;
            chartArea8.Name = "ChartArea1";
            this.ChartPieProfit.ChartAreas.Add(chartArea8);
            legend8.BackColor = System.Drawing.Color.Transparent;
            legend8.DockedToChartArea = "ChartArea1";
            legend8.Name = "Legend1";
            this.ChartPieProfit.Legends.Add(legend8);
            this.ChartPieProfit.Location = new System.Drawing.Point(900, 409);
            this.ChartPieProfit.Name = "ChartPieProfit";
            this.ChartPieProfit.Palette = System.Windows.Forms.DataVisualization.Charting.ChartColorPalette.Bright;
            series8.ChartArea = "ChartArea1";
            series8.Legend = "Legend1";
            series8.Name = "Series1";
            this.ChartPieProfit.Series.Add(series8);
            this.ChartPieProfit.Size = new System.Drawing.Size(251, 172);
            this.ChartPieProfit.TabIndex = 35;
            this.ChartPieProfit.Text = "chart2";
            // 
            // dataGridView
            // 
            this.dataGridView.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dataGridView.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.SignalNames,
            this.TotalPL,
            this.DD,
            this.Bets,
            this.Win,
            this.PF,
            this.Sharpe});
            this.dataGridView.Location = new System.Drawing.Point(28, 618);
            this.dataGridView.Name = "dataGridView";
            this.dataGridView.RowHeadersWidth = 40;
            this.dataGridView.Size = new System.Drawing.Size(1123, 178);
            this.dataGridView.TabIndex = 34;
            this.dataGridView.CellContentClick += new System.Windows.Forms.DataGridViewCellEventHandler(this.dataGridView_CellContentClick);
            // 
            // SignalNames
            // 
            this.SignalNames.FillWeight = 280F;
            this.SignalNames.HeaderText = "Signal Names";
            this.SignalNames.Name = "SignalNames";
            this.SignalNames.Width = 280;
            // 
            // TotalPL
            // 
            this.TotalPL.FillWeight = 160F;
            this.TotalPL.HeaderText = "Total P&L";
            this.TotalPL.Name = "TotalPL";
            this.TotalPL.Width = 160;
            // 
            // DD
            // 
            this.DD.FillWeight = 130F;
            this.DD.HeaderText = "DD";
            this.DD.Name = "DD";
            this.DD.Width = 130;
            // 
            // Bets
            // 
            this.Bets.FillWeight = 130F;
            this.Bets.HeaderText = "Bets";
            this.Bets.Name = "Bets";
            this.Bets.Width = 130;
            // 
            // Win
            // 
            this.Win.FillWeight = 130F;
            this.Win.HeaderText = "Win %";
            this.Win.Name = "Win";
            this.Win.Width = 130;
            // 
            // PF
            // 
            this.PF.FillWeight = 120F;
            this.PF.HeaderText = "PF";
            this.PF.Name = "PF";
            this.PF.Width = 120;
            // 
            // Sharpe
            // 
            this.Sharpe.FillWeight = 130F;
            this.Sharpe.HeaderText = "Sharpe";
            this.Sharpe.Name = "Sharpe";
            this.Sharpe.Width = 130;
            // 
            // ChartPieWinLoss
            // 
            this.ChartPieWinLoss.BackColor = System.Drawing.Color.Thistle;
            this.ChartPieWinLoss.BorderSkin.BackSecondaryColor = System.Drawing.Color.White;
            chartArea9.BackColor = System.Drawing.Color.Transparent;
            chartArea9.Name = "ChartArea1";
            this.ChartPieWinLoss.ChartAreas.Add(chartArea9);
            legend9.BackColor = System.Drawing.Color.Transparent;
            legend9.DockedToChartArea = "ChartArea1";
            legend9.Name = "Legend1";
            this.ChartPieWinLoss.Legends.Add(legend9);
            this.ChartPieWinLoss.Location = new System.Drawing.Point(608, 409);
            this.ChartPieWinLoss.Name = "ChartPieWinLoss";
            this.ChartPieWinLoss.Palette = System.Windows.Forms.DataVisualization.Charting.ChartColorPalette.Bright;
            series9.ChartArea = "ChartArea1";
            series9.Legend = "Legend1";
            series9.Name = "Series1";
            this.ChartPieWinLoss.Series.Add(series9);
            this.ChartPieWinLoss.Size = new System.Drawing.Size(251, 172);
            this.ChartPieWinLoss.TabIndex = 33;
            this.ChartPieWinLoss.Text = "chart2";
            // 
            // MonthChart
            // 
            chartArea10.Name = "ChartArea1";
            this.MonthChart.ChartAreas.Add(chartArea10);
            legend10.Enabled = false;
            legend10.Name = "Legend1";
            this.MonthChart.Legends.Add(legend10);
            this.MonthChart.Location = new System.Drawing.Point(28, 409);
            this.MonthChart.Name = "MonthChart";
            this.MonthChart.Palette = System.Windows.Forms.DataVisualization.Charting.ChartColorPalette.Bright;
            series10.ChartArea = "ChartArea1";
            series10.Legend = "Legend1";
            series10.Name = "Series1";
            this.MonthChart.Series.Add(series10);
            this.MonthChart.Size = new System.Drawing.Size(260, 183);
            this.MonthChart.TabIndex = 32;
            this.MonthChart.Text = "chart2";
            // 
            // YearChart
            // 
            chartArea11.BackColor = System.Drawing.Color.Transparent;
            chartArea11.Name = "ChartArea1";
            this.YearChart.ChartAreas.Add(chartArea11);
            legend11.BackColor = System.Drawing.Color.Transparent;
            legend11.Enabled = false;
            legend11.Name = "Legend1";
            this.YearChart.Legends.Add(legend11);
            this.YearChart.Location = new System.Drawing.Point(294, 409);
            this.YearChart.Name = "YearChart";
            this.YearChart.Palette = System.Windows.Forms.DataVisualization.Charting.ChartColorPalette.Bright;
            series11.ChartArea = "ChartArea1";
            series11.Color = System.Drawing.Color.Red;
            series11.LabelBackColor = System.Drawing.Color.White;
            series11.Legend = "Legend1";
            series11.Name = "Series1";
            this.YearChart.Series.Add(series11);
            this.YearChart.Size = new System.Drawing.Size(279, 183);
            this.YearChart.TabIndex = 31;
            this.YearChart.Text = "chart2";
            // 
            // MonteChart
            // 
            chartArea12.Name = "ChartArea1";
            this.MonteChart.ChartAreas.Add(chartArea12);
            legend12.Enabled = false;
            legend12.Name = "Legend1";
            this.MonteChart.Legends.Add(legend12);
            this.MonteChart.Location = new System.Drawing.Point(608, 25);
            this.MonteChart.Name = "MonteChart";
            this.MonteChart.Palette = System.Windows.Forms.DataVisualization.Charting.ChartColorPalette.Bright;
            series12.ChartArea = "ChartArea1";
            series12.Legend = "Legend1";
            series12.Name = "Series1";
            this.MonteChart.Series.Add(series12);
            this.MonteChart.Size = new System.Drawing.Size(543, 370);
            this.MonteChart.TabIndex = 30;
            this.MonteChart.Text = "chart1";
            // 
            // ChartCumulative2
            // 
            this.ChartCumulative2.BackColor = System.Drawing.Color.Lavender;
            chartArea13.BackColor = System.Drawing.Color.Transparent;
            chartArea13.Name = "ChartArea1";
            this.ChartCumulative2.ChartAreas.Add(chartArea13);
            legend13.Enabled = false;
            legend13.Name = "Legend1";
            this.ChartCumulative2.Legends.Add(legend13);
            this.ChartCumulative2.Location = new System.Drawing.Point(28, 267);
            this.ChartCumulative2.Name = "ChartCumulative2";
            series13.ChartArea = "ChartArea1";
            series13.Legend = "Legend1";
            series13.Name = "Series1";
            this.ChartCumulative2.Series.Add(series13);
            this.ChartCumulative2.Size = new System.Drawing.Size(545, 129);
            this.ChartCumulative2.TabIndex = 29;
            this.ChartCumulative2.Text = "chart2";
            // 
            // ChartCumulative1
            // 
            this.ChartCumulative1.BackColor = System.Drawing.Color.Lavender;
            chartArea14.BackColor = System.Drawing.Color.Transparent;
            chartArea14.Name = "ChartArea1";
            this.ChartCumulative1.ChartAreas.Add(chartArea14);
            legend14.Enabled = false;
            legend14.Name = "Legend1";
            this.ChartCumulative1.Legends.Add(legend14);
            this.ChartCumulative1.Location = new System.Drawing.Point(28, 25);
            this.ChartCumulative1.Name = "ChartCumulative1";
            series14.ChartArea = "ChartArea1";
            series14.Legend = "Legend1";
            series14.Name = "Series1";
            this.ChartCumulative1.Series.Add(series14);
            this.ChartCumulative1.Size = new System.Drawing.Size(545, 232);
            this.ChartCumulative1.TabIndex = 28;
            this.ChartCumulative1.Text = "chart1";
            // 
            // GraphView
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(1178, 837);
            this.Controls.Add(this.ChartPieProfit);
            this.Controls.Add(this.dataGridView);
            this.Controls.Add(this.ChartPieWinLoss);
            this.Controls.Add(this.MonthChart);
            this.Controls.Add(this.YearChart);
            this.Controls.Add(this.MonteChart);
            this.Controls.Add(this.ChartCumulative2);
            this.Controls.Add(this.ChartCumulative1);
            this.Name = "GraphView";
            this.Text = "GraphView";
            ((System.ComponentModel.ISupportInitialize)(this.ChartPieProfit)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.dataGridView)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.ChartPieWinLoss)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.MonthChart)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.YearChart)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.MonteChart)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.ChartCumulative2)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.ChartCumulative1)).EndInit();
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.DataVisualization.Charting.Chart ChartPieProfit;
        private System.Windows.Forms.DataGridView dataGridView;
        private System.Windows.Forms.DataGridViewTextBoxColumn SignalNames;
        private System.Windows.Forms.DataGridViewTextBoxColumn TotalPL;
        private System.Windows.Forms.DataGridViewTextBoxColumn DD;
        private System.Windows.Forms.DataGridViewTextBoxColumn Bets;
        private System.Windows.Forms.DataGridViewTextBoxColumn Win;
        private System.Windows.Forms.DataGridViewTextBoxColumn PF;
        private System.Windows.Forms.DataGridViewTextBoxColumn Sharpe;
        private System.Windows.Forms.DataVisualization.Charting.Chart ChartPieWinLoss;
        private System.Windows.Forms.DataVisualization.Charting.Chart MonthChart;
        private System.Windows.Forms.DataVisualization.Charting.Chart YearChart;
        private System.Windows.Forms.DataVisualization.Charting.Chart MonteChart;
        private System.Windows.Forms.DataVisualization.Charting.Chart ChartCumulative2;
        private System.Windows.Forms.DataVisualization.Charting.Chart ChartCumulative1;
    }
}