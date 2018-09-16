using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using LeagueAnalysisConsole;
using System.Windows.Forms.DataVisualization.Charting;

namespace Fitness.Gui
{
    public partial class GraphView : Form
    {
        public Fitness fitness = new Fitness();

        public GraphView()
        {
            InitializeComponent();
        }

        private void dataGridView_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
            draw_second_gauge(e.RowIndex);
        }

        public void create_table()
        {
            int i;
            for (i = 0; i < fitness.StrategyResultList.Count; i++)
            {
                if (fitness.StrategyResultList[i].combinedColumn == null) continue;
                int n = dataGridView.Rows.Add();
                dataGridView.Rows[n].Cells[0].Value = fitness.StrategyResultList[i].combinedColumn;
                dataGridView.Rows[n].Cells[1].Value = fitness.StrategyResultList[i].sum;
                dataGridView.Rows[n].Cells[2].Value = fitness.StrategyResultList[i].min;
                dataGridView.Rows[n].Cells[3].Value = fitness.StrategyResultList[i].win - fitness.StrategyResultList[i].loss;

                if((fitness.StrategyResultList[i].win - fitness.StrategyResultList[i].loss) != 0)
                    dataGridView.Rows[n].Cells[4].Value = fitness.StrategyResultList[i].win * 100 / (fitness.StrategyResultList[i].win - fitness.StrategyResultList[i].loss );
                dataGridView.Rows[n].Cells[5].Value = fitness.StrategyResultList[i].BestProfit;
                //dataGridView.Rows[n].Cells[5].Value = '';
            }
        }



        private void draw_second_gauge(int id)
        {
            if (id < 0 || id >= fitness.StrategyResultList.Count)
                return;

            ChartPieProfit.Series.Remove(ChartPieProfit.Series[0]);

            Series s = ChartPieProfit.Series.Add("Profit / Best Profit");
            s.ChartType = SeriesChartType.Doughnut;
            List<double> p = new List<double>();
            p.Add(fitness.StrategyResultList[id].BestProfit);
            p.Add(-(double)fitness.StrategyResultList[id].win / (double)fitness.StrategyResultList[id].loss);
            List<string> title = new List<string>();
            title.Add("Best");
            title.Add("selected");

            ChartPieWinLoss.PaletteCustomColors = new Color[] { Color.Green, Color.Red };
            s.Points.DataBindXY(title, p);
            s.Points[1].Color = Color.Red;





            // Draw accumulation graph 
            ChartCumulative1.Series.Clear();
            ChartCumulative1.Titles.Clear();
            ChartCumulative1.Titles.Add("Accumulate with Dates");
            Series series = ChartCumulative1.Series.Add("Bet ");
            series.ChartType = SeriesChartType.Spline;
            series.BorderWidth = 3;

            int i = 0;
            int curval = 0;

            foreach (KeyValuePair<string, ResultData> entry in fitness.StrategyResultList[id].dateToAccumulate)
            {
                curval += entry.Value.value;
                series.Points.AddXY(entry.Key, curval);
            }

            /// Accumulate
            /// 
            //int mxYear = 0;
            //foreach (KeyValuePair<string, ResultData> entry in fitness.yearToAccumulate)
            //    if (mxYear < entry.Value.value) mxYear = entry.Value.value;

            ChartCumulative2.Series.Clear();
            ChartCumulative2.Titles.Clear();
            ChartCumulative2.Titles.Add("Accumulate with date 2");

            Series series2 = ChartCumulative2.Series.Add("Bet");
            series2.ChartType = SeriesChartType.Spline;
            series2.BorderWidth = 3;

            int maxval = 0;
            curval = 0;
            foreach (KeyValuePair<string, ResultData> entry in fitness.StrategyResultList[id].dateToAccumulate)
            {
                curval += entry.Value.value;
                maxval = curval > maxval ? curval : maxval;
                series2.Points.AddXY(entry.Key, curval - maxval);
            }
            // Year bar
            YearChart.Series.Clear();
            YearChart.Titles.Clear();
            YearChart.Titles.Add("Accumulate with Years");
            Series series3 = YearChart.Series.Add(" Bet 1");
            series3.ChartType = SeriesChartType.Column;

            Series series4 = YearChart.Series.Add(" Bet 2");
            series4.ChartType = SeriesChartType.Column;
            series4.Color = Color.Red;

            foreach (KeyValuePair<string, ResultData> entry in fitness.StrategyResultList[id].yearToAccumulate)
            {
                if (entry.Value.value > 0)
                    series3.Points.AddXY(entry.Key, entry.Value.value);
                else series4.Points.AddXY(entry.Key, entry.Value.value);
            }

            // Month bar
            MonthChart.Series.Clear();
            MonthChart.Titles.Clear();
            MonthChart.Titles.Add("Accumulate with Months");
            Series series5 = MonthChart.Series.Add(" Bet 7");
            series5.ChartType = SeriesChartType.Column;

            Series series6 = MonthChart.Series.Add(" Bet 8");
            series6.ChartType = SeriesChartType.Column;
            series6.Color = Color.Red;

            foreach (KeyValuePair<string, ResultData> entry in fitness.StrategyResultList[id].monthToAccumulate)
            {
                if (entry.Value.value > 0)
                    series5.Points.AddXY(entry.Key, entry.Value.value);
                else series6.Points.AddXY(entry.Key, entry.Value.value);
            }

            // Monte Data
            MonteChart.Series.Clear();
            MonteChart.Titles.Clear();
            MonteChart.Titles.Add("All Graph");

            for (i = 0; i < fitness.StrategyResultList[id].MonteData.Count; i++)
            {
                Series nPolt = MonteChart.Series.Add("");
                nPolt.ChartType = SeriesChartType.Spline;
                curval = 0;
                foreach (KeyValuePair<string, ResultData> entry in fitness.StrategyResultList[id].MonteData[i])
                {
                    curval += entry.Value.value;
                    nPolt.Points.AddXY(entry.Key, curval);
                }
            }

            //Series nPoltMain = MonteChart.Series.Add("");
            //nPoltMain.BorderWidth = 3;
            //nPoltMain.Color = Color.Blue;
            //nPoltMain.ChartType = SeriesChartType.Spline;

            //foreach (KeyValuePair<string, ResultData> entry in fitness.dateToAccumulate)
            //{
            //    curval += entry.Value.value;
            //    nPoltMain.Points.AddXY(entry.Key, curval);
            //}
            // Chart Win and Loss
            ChartPieWinLoss.Series.Clear();
            ChartPieWinLoss.Titles.Clear();
            ChartPieWinLoss.Titles.Add("Win and Loss");
            s = ChartPieWinLoss.Series.Add("win and loss");
            s.ChartType = SeriesChartType.Doughnut;
            p = new List<double>();
            p.Add((double)fitness.StrategyResultList[id].total_win);
            p.Add((double)fitness.StrategyResultList[id].total_loss);

            title = new List<string>();
            title.Clear();
            title.Add("Win");
            title.Add("Loss");

            ChartPieWinLoss.PaletteCustomColors = new Color[] { Color.Green, Color.Red };
            s.Points.DataBindXY(title, p);
            s.Points[1].Color = Color.Red;

            // profit





            //dataGridView.Rows[n].Cells[0].Value = "Signal Names";
            //dataGridView.Rows[n].Cells[1].Value = "Total P&L";
            //dataGridView.Rows[n].Cells[2].Value = "DD";
            //dataGridView.Rows[n].Cells[3].Value = "Bets";
            //dataGridView.Rows[n].Cells[4].Value = "Win %";
            //dataGridView.Rows[n].Cells[5].Value = "PF";
            //dataGridView.Rows[n].Cells[6].Value = "Sharpe";

        }
    }
}
