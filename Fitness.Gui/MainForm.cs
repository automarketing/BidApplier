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
    public partial class MainForm : Form
    {
        public const string SignalNames =
               "Favorite,Underdog,Home,Away,Winning Record,Losing Record,Spread -3 or More,Spread -5 or More,Spread -7 or More,Spread -8 or More,Spread -10 or More,Spread -12 or More,Spread -15 or More,Spread -20 or More,Spread -3 or Less,Spread -5 or Less,Spread -7 or Less,Spread -8 or Less,Spread -10 or Less,Spread -12 or Less,Spread -15 or Less,Spread -20 or Less,Spread +3 or Less,Spread +5 or Less,Spread +7 or Less,Spread +8 or Less,Spread +10 or Less,Spread +12 or Less,Spread +15 or Less,Spread +20 or Less,Spread +3 or More,Spread +5 or More,Spread +7 or More,Spread +8 or More,Spread +10 or More,Spread +12 or More,Spread +15 or More,Spread +20 or More,OU Total <= 30,OU Total <= 35,OU Total <= 40,OU Total <= 45,OU Total <= 50,OU Total <= 55,OU Total <= 60,OU Total >= 30,OU Total >= 35,OU Total >= 40,OU Total >= 45,OU Total >= 50,OU Total >= 55,OU Total >= 60,MoneyLine -5000 or More,MoneyLine -2000 or More,MoneyLine -1000 or More,MoneyLine -800 or More,MoneyLine -600 or More,MoneyLine -500 or More,MoneyLine -400 or More,MoneyLine -350 or More,MoneyLine -300 or More,MoneyLine -250 or More,MoneyLine -200 or More,MoneyLine -150 or More,MoneyLine -125 or More,MoneyLine -100 or More,MoneyLine +100 or Less,MoneyLine +150 or Less,MoneyLine +200 or Less,MoneyLine +250 or Less,MoneyLine +300 or Less,MoneyLine +350 or Less,MoneyLine +400 or Less,MoneyLine +500 or Less,MoneyLine +600 or Less,MoneyLine +800 or Less,MoneyLine +1000 or Less,MoneyLine -5000 or Less,MoneyLine -2000 or Less,MoneyLine -1000 or Less,MoneyLine -800 or Less,MoneyLine -600 or Less,MoneyLine -500 or Less,MoneyLine -400 or Less,MoneyLine -350 or Less,MoneyLine -300 or Less,MoneyLine -250 or Less,MoneyLine -200 or Less,MoneyLine -150 or Less,MoneyLine -125 or Less,MoneyLine -100 or Less,MoneyLine -100 or More,MoneyLine -150 or More,MoneyLine -200 or More,MoneyLine -250 or More,MoneyLine -300 or More,MoneyLine -350 or More,MoneyLine -400 or More,MoneyLine -500 or More,MoneyLine -600 or More,MoneyLine -800 or More,MoneyLine -1000 or More,Pts Last gm 7 or Less,Pts Last gm 10 or Less,Pts Last gm 13 or Less,Pts Last gm 14 or Less,Pts Last gm 17 or Less,Pts Last gm 21 or Less,Pts Last gm 24 or Less,Pts Last gm 28 or Less,Pts Last gm 31 or Less,Pts Last gm 35 or Less,Pts Last gm 42 or Less,Pts Last gm 49 or Less,Pts Last gm 60 or Less,Pts Last gm 7 or More,Pts Last gm 10 or More,Pts Last gm 13 or More,Pts Last gm 14 or More,Pts Last gm 17 or More,Pts Last gm 21 or More,Pts Last gm 24 or More,Pts Last gm 28 or More,Pts Last gm 31 or More,Pts Last gm 35 or More,Pts Last gm 42 or More,Pts Last gm 49 or More,Pts Last gm 60 or More,Opp Pts Last gm 7 or Less,Opp Pts Last gm 10 or Less,Opp Pts Last gm 13 or Less,Opp Pts Last gm 14 or Less,Opp Pts Last gm 17 or Less,Opp Pts Last gm 21 or Less,Opp Pts Last gm 24 or Less,Opp Pts Last gm 28 or Less,Opp Pts Last gm 31 or Less,Opp Pts Last gm 35 or Less,Opp Pts Last gm 42 or Less,Opp Pts Last gm 49 or Less,Opp Pts Last gm 60 or Less,Opp Pts Last gm 7 or More,Opp Pts Last gm 10 or More,Opp Pts Last gm 13 or More,Opp Pts Last gm 14 or More,Opp Pts Last gm 17 or More,Opp Pts Last gm 21 or More,Opp Pts Last gm 24 or More,Opp Pts Last gm 28 or More,Opp Pts Last gm 31 or More,Opp Pts Last gm 35 or More,Opp Pts Last gm 42 or More,Opp Pts Last gm 49 or More,Opp Pts Last gm 60 or More,Yards Last gm 150 or Less,Yards Last gm 200 or Less,Yards Last gm 250 or Less,Yards Last gm 300 or Less,Yards Last gm 350 or Less,Yards Last gm 400 or Less,Yards Last gm 450 or Less,Yards Last gm 500 or Less,Yards Last gm 150 or More,Yards Last gm 200 or More,Yards Last gm 250 or More,Yards Last gm 300 or More,Yards Last gm 350 or More,Yards Last gm 400 or More,Yards Last gm 450 or More,Yards Last gm 500 or More,Opp Yards Last gm 150 or Less,Opp Yards Last gm 200 or Less,Opp Yards Last gm 250 or Less,Opp Yards Last gm 300 or Less,Opp Yards Last gm 350 or Less,Opp Yards Last gm 400 or Less,Opp Yards Last gm 450 or Less,Opp Yards Last gm 500 or Less,Opp Yards Last gm 150 or More,Opp Yards Last gm 200 or More,Opp Yards Last gm 250 or More,Opp Yards Last gm 300 or More,Opp Yards Last gm 350 or More,Opp Yards Last gm 400 or More,Opp Yards Last gm 450 or More,Opp Yards Last gm 500 or More,Rush Yards Last gm 50 or Less,Rush Yards Last gm 75 or Less,Rush Yards Last gm 100 or Less,Rush Yards Last gm 125 or Less,Rush Yards Last gm 200 or Less,Rush Yards Last gm 250 or Less,Rush Yards Last gm 300 or Less,Rush Yards Last gm 350 or Less,Rush Yards Last gm 50 or More,Rush Yards Last gm 75 or More,Rush Yards Last gm 100 or More,Rush Yards Last gm 125 or More,Rush Yards Last gm 200 or More,Rush Yards Last gm 250 or More,Rush Yards Last gm 300 or More,Rush Yards Last gm 350 or More,Opp Rush Yards Last gm 50 or Less,Opp Rush Yards Last gm 75 or Less,Opp Rush Yards Last gm 100 or Less,Opp Rush Yards Last gm 125 or Less,Opp Rush Yards Last gm 200 or Less,Opp Rush Yards Last gm 250 or Less,Opp Rush Yards Last gm 300 or Less,Opp Rush Yards Last gm 350 or Less,Opp Rush Yards Last gm 50 or More,Opp Rush Yards Last gm 75 or More,Opp Rush Yards Last gm 100 or More,Opp Rush Yards Last gm 125 or More,Opp Rush Yards Last gm 200 or More,Opp Rush Yards Last gm 250 or More,Opp Rush Yards Last gm 300 or More,Opp Rush Yards Last gm 350 or More,Pass Yards Last gm 50 or Less,Pass Yards Last gm 100 or Less,Pass Yards Last gm 125 or Less,Pass Yards Last gm 150 or Less,Pass Yards Last gm 200 or Less,Pass Yards Last gm 250 or Less,Pass Yards Last gm 300 or Less,Pass Yards Last gm 350 or Less,Pass Yards Last gm 400 or Less,Pass Yards Last gm 500 or Less,Pass Yards Last gm 50 or More,Pass Yards Last gm 100 or More,Pass Yards Last gm 125 or More,Pass Yards Last gm 150 or More,Pass Yards Last gm 200 or More,Pass Yards Last gm 250 or More,Pass Yards Last gm 300 or More,Pass Yards Last gm 350 or More,Pass Yards Last gm 400 or More,Pass Yards Last gm 500 or More,Opp Pass Yards Last gm 50 or Less,Opp Pass Yards Last gm 100 or Less,Opp Pass Yards Last gm 125 or Less,Opp Pass Yards Last gm 150 or Less,Opp Pass Yards Last gm 200 or Less,Opp Pass Yards Last gm 250 or Less,Opp Pass Yards Last gm 300 or Less,Opp Pass Yards Last gm 350 or Less,Opp Pass Yards Last gm 400 or Less,Opp Pass Yards Last gm 500 or Less,Opp Pass Yards Last gm 50 or More,Opp Pass Yards Last gm 100 or More,Opp Pass Yards Last gm 125 or More,Opp Pass Yards Last gm 150 or More,Opp Pass Yards Last gm 200 or More,Opp Pass Yards Last gm 250 or More,Opp Pass Yards Last gm 300 or More,Opp Pass Yards Last gm 350 or More,Opp Pass Yards Last gm 400 or More,Opp Pass Yards Last gm 500 or More,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 75% or Less,Winning Perc 80% or Less,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 75% or More,Winning Perc 80% or More,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 75% or Less,Opp Winning Perc 80% or Less,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 75% or More,Opp Winning Perc 80% or More,Points Per Gm 10 or Less,Points Per Gm 13 or Less,Points Per Gm 15 or Less,Points Per Gm 17 or Less,Points Per Gm 20 or Less,Points Per Gm 22 or Less,Points Per Gm 24 or Less,Points Per Gm 28 or Less,Points Per Gm 30 or Less,Points Per Gm 35 or Less,Points Per Gm 10 or More,Points Per Gm 13 or More,Points Per Gm 15 or More,Points Per Gm 17 or More,Points Per Gm 20 or More,Points Per Gm 22 or More,Points Per Gm 24 or More,Points Per Gm 28 or More,Points Per Gm 30 or More,Points Per Gm 35 or More,Opp Points Per Gm 10 or Less,Opp Points Per Gm 13 or Less,Opp Points Per Gm 15 or Less,Opp Points Per Gm 17 or Less,Opp Points Per Gm 20 or Less,Opp Points Per Gm 22 or Less,Opp Points Per Gm 24 or Less,Opp Points Per Gm 28 or Less,Opp Points Per Gm 30 or Less,Opp Points Per Gm 35 or Less,Opp Points Per Gm 10 or More,Opp Points Per Gm 13 or More,Opp Points Per Gm 15 or More,Opp Points Per Gm 17 or More,Opp Points Per Gm 20 or More,Opp Points Per Gm 22 or More,Opp Points Per Gm 24 or More,Opp Points Per Gm 28 or More,Opp Points Per Gm 30 or More,Opp Points Per Gm 35 or More,Yards Per Gm 250 or Less,Yards Per Gm 300 or Less,Yards Per Gm 350 or Less,Yards Per Gm 400 or Less,Yards Per Gm 450 or Less,Yards Per Gm 250 or More,Yards Per Gm 300 or More,Yards Per Gm 350 or More,Yards Per Gm 400 or More,Yards Per Gm 450 or More,Opp Yards Per Gm 250 or Less,Opp Yards Per Gm 300 or Less,Opp Yards Per Gm 350 or Less,Opp Yards Per Gm 400 or Less,Opp Yards Per Gm 450 or Less,Opp Yards Per Gm 250 or More,Opp Yards Per Gm 300 or More,Opp Yards Per Gm 350 or More,Opp Yards Per Gm 400 or More,Opp Yards Per Gm 450 or More,Rush Yards Per Gm 70 or Less,Rush Yards Per Gm 80 or Less,Rush Yards Per Gm 90 or Less,Rush Yards Per Gm 100 or Less,Rush Yards Per Gm 110 or Less,Rush Yards Per Gm 120 or Less,Rush Yards Per Gm 130 or Less,Rush Yards Per Gm 140 or Less,Rush Yards Per Gm 150 or Less,Rush Yards Per Gm 160 or Less,Rush Yards Per Gm 170 or Less,Rush Yards Per Gm 180 or Less,Rush Yards Per Gm 70 or More,Rush Yards Per Gm 80 or More,Rush Yards Per Gm 90 or More,Rush Yards Per Gm 100 or More,Rush Yards Per Gm 110 or More,Rush Yards Per Gm 120 or More,Rush Yards Per Gm 130 or More,Rush Yards Per Gm 140 or More,Rush Yards Per Gm 150 or More,Rush Yards Per Gm 160 or More,Rush Yards Per Gm 170 or More,Rush Yards Per Gm 180 or More,Opp Rush Yards Per Gm 70 or Less,Opp Rush Yards Per Gm 80 or Less,Opp Rush Yards Per Gm 90 or Less,Opp Rush Yards Per Gm 100 or Less,Opp Rush Yards Per Gm 110 or Less,Opp Rush Yards Per Gm 120 or Less,Opp Rush Yards Per Gm 130 or Less,Opp Rush Yards Per Gm 140 or Less,Opp Rush Yards Per Gm 150 or Less,Opp Rush Yards Per Gm 160 or Less,Opp Rush Yards Per Gm 170 or Less,Opp Rush Yards Per Gm 180 or Less,Opp Rush Yards Per Gm 70 or More,Opp Rush Yards Per Gm 80 or More,Opp Rush Yards Per Gm 90 or More,Opp Rush Yards Per Gm 100 or More,Opp Rush Yards Per Gm 110 or More,Opp Rush Yards Per Gm 120 or More,Opp Rush Yards Per Gm 130 or More,Opp Rush Yards Per Gm 140 or More,Opp Rush Yards Per Gm 150 or More,Opp Rush Yards Per Gm 160 or More,Opp Rush Yards Per Gm 170 or More,Opp Rush Yards Per Gm 180 or More,Pass Yards Per Gm 150 or Less,Pass Yards Per Gm 175 or Less,Pass Yards Per Gm 200 or Less,Pass Yards Per Gm 225 or Less,Pass Yards Per Gm 250 or Less,Pass Yards Per Gm 275 or Less,Pass Yards Per Gm 300 or Less,Pass Yards Per Gm 350 or Less,Pass Yards Per Gm 150 or More,Pass Yards Per Gm 175 or More,Pass Yards Per Gm 200 or More,Pass Yards Per Gm 225 or More,Pass Yards Per Gm 250 or More,Pass Yards Per Gm 275 or More,Pass Yards Per Gm 300 or More,Pass Yards Per Gm 350 or More,Opp Pass Yards Per Gm 150 or Less,Opp Pass Yards Per Gm 175 or Less,Opp Pass Yards Per Gm 200 or Less,Opp Pass Yards Per Gm 225 or Less,Opp Pass Yards Per Gm 250 or Less,Opp Pass Yards Per Gm 275 or Less,Opp Pass Yards Per Gm 300 or Less,Opp Pass Yards Per Gm 350 or Less,Opp Pass Yards Per Gm 150 or More,Opp Pass Yards Per Gm 175 or More,Opp Pass Yards Per Gm 200 or More,Opp Pass Yards Per Gm 225 or More,Opp Pass Yards Per Gm 250 or More,Opp Pass Yards Per Gm 275 or More,Opp Pass Yards Per Gm 300 or More,Opp Pass Yards Per Gm 350 or More,Win Streak of 2 or More,Win Streak of 3 or More,Win Streak of 4 or More,Win Streak of 5 or More,Win Streak of 6 or More,Win Streak of 7 or More,Win Streak of 10 or More,Win Streak of 12 or More,Loss Streak of 2 or More,Loss Streak of 3 or More,Loss Streak of 4 or More,Loss Streak of 5 or More,Loss Streak of 6 or More,Loss Streak of 7 or More,Loss Streak of 10 or More,Loss Streak of 12 or More,Home Win Streak of 2 or More,Home Win Streak of 3 or More,Home Win Streak of 4 or More,Home Win Streak of 5 or More,Home Win Streak of 6 or More,Home Win Streak of 7 or More,Home Win Streak of 10 or More,Home Win Streak of 12 or More,Home Loss Streak of 2 or More,Home Loss Streak of 3 or More,Home Loss Streak of 4 or More,Home Loss Streak of 5 or More,Home Loss Streak of 6 or More,Home Loss Streak of 7 or More,Home Loss Streak of 10 or More,Home Loss Streak of 12 or More,Away Win Streak of 2 or More,Away Win Streak of 3 or More,Away Win Streak of 4 or More,Away Win Streak of 5 or More,Away Win Streak of 6 or More,Away Win Streak of 7 or More,Away Win Streak of 10 or More,Away Win Streak of 12 or More,Away Loss Streak of 2 or More,Away Loss Streak of 3 or More,Away Loss Streak of 4 or More,Away Loss Streak of 5 or More,Away Loss Streak of 6 or More,Away Loss Streak of 7 or More,Away Loss Streak of 10 or More,Away Loss Streak of 12 or More,Opp Win Streak of 2 or More,Opp Win Streak of 3 or More,Opp Win Streak of 4 or More,Opp Win Streak of 5 or More,Opp Win Streak of 6 or More,Opp Win Streak of 7 or More,Opp Win Streak of 10 or More,Opp Win Streak of 12 or More,Opp Loss Streak of 2 or More,Opp Loss Streak of 3 or More,Opp Loss Streak of 4 or More,Opp Loss Streak of 5 or More,Opp Loss Streak of 6 or More,Opp Loss Streak of 7 or More,Opp Loss Streak of 10 or More,Opp Loss Streak of 12 or More,Opp Home Win Streak of 2 or More,Opp Home Win Streak of 3 or More,Opp Home Win Streak of 4 or More,Opp Home Win Streak of 5 or More,Opp Home Win Streak of 6 or More,Opp Home Win Streak of 7 or More,Opp Home Win Streak of 10 or More,Opp Home Win Streak of 12 or More,Opp Home Loss Streak of 2 or More,Opp Home Loss Streak of 3 or More,Opp Home Loss Streak of 4 or More,Opp Home Loss Streak of 5 or More,Opp Home Loss Streak of 6 or More,Opp Home Loss Streak of 7 or More,Opp Home Loss Streak of 10 or More,Opp Home Loss Streak of 12 or More,Opp Away Win Streak of 2 or More,Opp Away Win Streak of 3 or More,Opp Away Win Streak of 4 or More,Opp Away Win Streak of 5 or More,Opp Away Win Streak of 6 or More,Opp Away Win Streak of 7 or More,Opp Away Win Streak of 10 or More,Opp Away Win Streak of 12 or More,Opp Away Loss Streak of 2 or More,Opp Away Loss Streak of 3 or More,Opp Away Loss Streak of 4 or More,Opp Away Loss Streak of 5 or More,Opp Away Loss Streak of 6 or More,Opp Away Loss Streak of 7 or More,Opp Away Loss Streak of 10 or More,Opp Away Loss Streak of 12 or More,Games Played 2 or Less,Games Played 4 or Less,Games Played 6 or Less,Games Played 8 or Less,Games Played 10 or Less,Games Played 12 or Less,Games Played 2 or More,Games Played 4 or More,Games Played 6 or More,Games Played 8 or More,Games Played 10 or More,Games Played 12 or More,Wins 2 or Less,Wins 4 or Less,Wins 6 or Less,Wins 8 or Less,Wins 10 or Less,Wins 12 or Less,Wins 2 or More,Wins 4 or More,Wins 6 or More,Wins 8 or More,Wins 10 or More,Wins 12 or More,Opp Wins 2 or Less,Opp Wins 4 or Less,Opp Wins 6 or Less,Opp Wins 8 or Less,Opp Wins 10 or Less,Opp Wins 12 or Less,Opp Wins 2 or More,Opp Wins 4 or More,Opp Wins 6 or More,Opp Wins 8 or More,Opp Wins 10 or More,Opp Wins 12 or More,Thursday,Saturday,Sunday,Monday,Not Sunday,Grass,Turf,Probability of Win 25% or Less,Probability of Win 30% or Less,Probability of Win 35% or Less,Probability of Win 40% or Less,Probability of Win 45% or Less,Probability of Win 50% or Less,Probability of Win 55% or Less,Probability of Win 60% or Less,Probability of Win 65% or Less,Probability of Win 70% or Less,Probability of Win 75% or Less,Probability of Win 80% or Less,Probability of Win 25% or More,Probability of Win 30% or More,Probability of Win 35% or More,Probability of Win 40% or More,Probability of Win 45% or More,Probability of Win 50% or More,Probability of Win 55% or More,Probability of Win 60% or More,Probability of Win 65% or More,Probability of Win 70% or More,Probability of Win 75% or More,Probability of Win 80% or More,Opp Probability of Win 25% or Less,Opp Probability of Win 30% or Less,Opp Probability of Win 35% or Less,Opp Probability of Win 40% or Less,Opp Probability of Win 45% or Less,Opp Probability of Win 50% or Less,Opp Probability of Win 55% or Less,Opp Probability of Win 60% or Less,Opp Probability of Win 65% or Less,Opp Probability of Win 70% or Less,Opp Probability of Win 75% or Less,Opp Probability of Win 80% or Less,Opp Probability of Win 25% or More,Opp Probability of Win 30% or More,Opp Probability of Win 35% or More,Opp Probability of Win 40% or More,Opp Probability of Win 45% or More,Opp Probability of Win 50% or More,Opp Probability of Win 55% or More,Opp Probability of Win 60% or More,Opp Probability of Win 65% or More,Opp Probability of Win 70% or More,Opp Probability of Win 75% or More,Opp Probability of Win 80% or More";
        int SignalColCount = 0;
        LicenseCheck checkform = new LicenseCheck();
        GraphView graphview = new GraphView();

        public MainForm()
        {
            InitializeComponent();
            //this.Hide();
            //if (checkform.ShowDialog(this) == DialogResult.OK)
            //{
            //    this.Show();
            //}
            //else
            //{
            //    Application.Exit();
            //}



            var tokens = SignalNames.Split(',');
            SignalColCount = tokens.Length;
            var pos = 0;
            foreach (var token in tokens)
            {
                signalchecklist.Items.Add(token);
            }
                


        }

        private void button1_Click(object sender, EventArgs e)
        {
            var cfg = new Config();
            cfg.numStrategies = Convert.ToInt32(txtStrategy.Text); //2;
            cfg.testsPerGeneration = Convert.ToInt32(txtPerGeneration.Text);//8;
            cfg.minNumOfRules = Convert.ToInt32(txtminrule.Text);//10;
            cfg.maxNumOfRules = Convert.ToInt32(txtmaxrule.Text);//12;
            cfg.betstyle = (BetStyle)cboBetStyle.SelectedIndex;
            cfg.start_date = startdatePicker.Value.Date.ToString("yyyy-MM-dd");
            cfg.end_date   = enddatePicker.Value.Date.ToString("yyyy-MM-dd");



            String leagueOutputFile = Properties.Resources.NFLOutput;
            String signalDataFile = Properties.Resources.Signals;

            graphview.fitness.Initialize(cfg, signalDataFile, leagueOutputFile);

            graphview.create_table();
            graphview.ShowDialog();
        }

        private void Form1_Load(object sender, EventArgs e)
        {
            txtStrategy.Text = "5"; 
            txtPerGeneration.Text="23";
            txtminrule.Text="3";
            txtmaxrule.Text="3"; 
            comboBox1.Items.Add("NFL");
            comboBox1.Items.Add("NBA");
            comboBox1.Items.Add("NCAAF");
            comboBox1.SelectedIndex = 0;
        }

        private void button2_Click(object sender, EventArgs e)
        {
            var l = new LeagueAnalysisConsole.NFL();
            string fileName = "D:\\Leagues\\NFLData.txt";
            l.LoadData(fileName);

        }

        private void groupBox1_Enter(object sender, EventArgs e)
        {

        }

        private void BtnChatDraw_Click(object sender, EventArgs e)
        {
            //ChartCumulative1.Series.Clear();

            //// Data arrays
            //string[] seriesArray = { "Cat", "Dog", "Bird", "Monkey" };
            //int[] pointsArray = { 2, 1, 7, 5 };


            //// Set title
            //ChartCumulative1.Titles.Add("Animals");

            //// Add series.
            //for (int i = 0; i < seriesArray.Length; i++)
            //{
            //    Series series = ChartCumulative1.Series.Add(seriesArray[i]);
            //    series.Points.Add(pointsArray[i]);
            //}

            

        }

        private void clear_all_check_state()
        {
            for (int x = 0; x < signalchecklist.Items.Count; x++)
            {
                signalchecklist.SetItemChecked(x, false);
            }
        }
        private void select_n_check( int n )
        {
            clear_all_check_state();
            List<int> p = new List<int>();
            int i;
            for (i = 0; i < SignalColCount; i++)
                p.Add(i < n ? 1 : 0);
            Random rnd = new Random();
            for (i = 0; i < SignalColCount; i++)
            {
                int a = rnd.Next(SignalColCount);
                int b = rnd.Next(SignalColCount);
                int sw = p[a];
                p[a] = p[b];
                p[b] = sw;
            }
            for (i = 0; i < SignalColCount; i++)
                if (p[i] == 1)
                    signalchecklist.SetItemChecked(i, true);
        }

        private void btn_random500_Click(object sender, EventArgs e)
        {
            select_n_check(500);
        }

        private void btn_randomclear_Click(object sender, EventArgs e)
        {

            clear_all_check_state();
        }

        private void btn_random1000_Click(object sender, EventArgs e)
        {
            select_n_check(1000);
        }
    }
}
