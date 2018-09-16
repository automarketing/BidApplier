using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace LeagueAnalysisConsole
{
    internal class NFL : LeagueBase
    {

        public NFL()
        {
            _writerSignals.WriteLine("DATE,DAY,TEAM,DIV,OTEAM,ODIV,SPREAD,OU,ML,PT,PTA,Favorite,Underdog,Home,Away,Winning Record,Losing Record,Spread -3 or More,Spread -5 or More,Spread -7 or More,Spread -8 or More,Spread -10 or More,Spread -12 or More,Spread -15 or More,Spread -20 or More,Spread -3 or Less,Spread -5 or Less,Spread -7 or Less,Spread -8 or Less,Spread -10 or Less,Spread -12 or Less,Spread -15 or Less,Spread -20 or Less,Spread +3 or Less,Spread +5 or Less,Spread +7 or Less,Spread +8 or Less,Spread +10 or Less,Spread +12 or Less,Spread +15 or Less,Spread +20 or Less,Spread +3 or More,Spread +5 or More,Spread +7 or More,Spread +8 or More,Spread +10 or More,Spread +12 or More,Spread +15 or More,Spread +20 or More,OU Total <= 30,OU Total <= 35,OU Total <= 40,OU Total <= 45,OU Total <= 50,OU Total <= 55,OU Total <= 60,OU Total >= 30,OU Total >= 35,OU Total >= 40,OU Total >= 45,OU Total >= 50,OU Total >= 55,OU Total >= 60,MoneyLine -5000 or More,MoneyLine -2000 or More,MoneyLine -1000 or More,MoneyLine -800 or More,MoneyLine -600 or More,MoneyLine -500 or More,MoneyLine -400 or More,MoneyLine -350 or More,MoneyLine -300 or More,MoneyLine -250 or More,MoneyLine -200 or More,MoneyLine -150 or More,MoneyLine -125 or More,MoneyLine -100 or More,MoneyLine +100 or Less,MoneyLine +150 or Less,MoneyLine +200 or Less,MoneyLine +250 or Less,MoneyLine +300 or Less,MoneyLine +350 or Less,MoneyLine +400 or Less,MoneyLine +500 or Less,MoneyLine +600 or Less,MoneyLine +800 or Less,MoneyLine +1000 or Less,MoneyLine -5000 or Less,MoneyLine -2000 or Less,MoneyLine -1000 or Less,MoneyLine -800 or Less,MoneyLine -600 or Less,MoneyLine -500 or Less,MoneyLine -400 or Less,MoneyLine -350 or Less,MoneyLine -300 or Less,MoneyLine -250 or Less,MoneyLine -200 or Less,MoneyLine -150 or Less,MoneyLine -125 or Less,MoneyLine -100 or Less,MoneyLine -100 or More,MoneyLine -150 or More,MoneyLine -200 or More,MoneyLine -250 or More,MoneyLine -300 or More,MoneyLine -350 or More,MoneyLine -400 or More,MoneyLine -500 or More,MoneyLine -600 or More,MoneyLine -800 or More,MoneyLine -1000 or More,Pts Last gm 7 or Less,Pts Last gm 10 or Less,Pts Last gm 13 or Less,Pts Last gm 14 or Less,Pts Last gm 17 or Less,Pts Last gm 21 or Less,Pts Last gm 24 or Less,Pts Last gm 28 or Less,Pts Last gm 31 or Less,Pts Last gm 35 or Less,Pts Last gm 42 or Less,Pts Last gm 49 or Less,Pts Last gm 60 or Less,Pts Last gm 7 or More,Pts Last gm 10 or More,Pts Last gm 13 or More,Pts Last gm 14 or More,Pts Last gm 17 or More,Pts Last gm 21 or More,Pts Last gm 24 or More,Pts Last gm 28 or More,Pts Last gm 31 or More,Pts Last gm 35 or More,Pts Last gm 42 or More,Pts Last gm 49 or More,Pts Last gm 60 or More,Opp Pts Last gm 7 or Less,Opp Pts Last gm 10 or Less,Opp Pts Last gm 13 or Less,Opp Pts Last gm 14 or Less,Opp Pts Last gm 17 or Less,Opp Pts Last gm 21 or Less,Opp Pts Last gm 24 or Less,Opp Pts Last gm 28 or Less,Opp Pts Last gm 31 or Less,Opp Pts Last gm 35 or Less,Opp Pts Last gm 42 or Less,Opp Pts Last gm 49 or Less,Opp Pts Last gm 60 or Less,Opp Pts Last gm 7 or More,Opp Pts Last gm 10 or More,Opp Pts Last gm 13 or More,Opp Pts Last gm 14 or More,Opp Pts Last gm 17 or More,Opp Pts Last gm 21 or More,Opp Pts Last gm 24 or More,Opp Pts Last gm 28 or More,Opp Pts Last gm 31 or More,Opp Pts Last gm 35 or More,Opp Pts Last gm 42 or More,Opp Pts Last gm 49 or More,Opp Pts Last gm 60 or More,Yards Last gm 150 or Less,Yards Last gm 200 or Less,Yards Last gm 250 or Less,Yards Last gm 300 or Less,Yards Last gm 350 or Less,Yards Last gm 400 or Less,Yards Last gm 450 or Less,Yards Last gm 500 or Less,Yards Last gm 150 or More,Yards Last gm 200 or More,Yards Last gm 250 or More,Yards Last gm 300 or More,Yards Last gm 350 or More,Yards Last gm 400 or More,Yards Last gm 450 or More,Yards Last gm 500 or More,Opp Yards Last gm 150 or Less,Opp Yards Last gm 200 or Less,Opp Yards Last gm 250 or Less,Opp Yards Last gm 300 or Less,Opp Yards Last gm 350 or Less,Opp Yards Last gm 400 or Less,Opp Yards Last gm 450 or Less,Opp Yards Last gm 500 or Less,Opp Yards Last gm 150 or More,Opp Yards Last gm 200 or More,Opp Yards Last gm 250 or More,Opp Yards Last gm 300 or More,Opp Yards Last gm 350 or More,Opp Yards Last gm 400 or More,Opp Yards Last gm 450 or More,Opp Yards Last gm 500 or More,Rush Yards Last gm 50 or Less,Rush Yards Last gm 75 or Less,Rush Yards Last gm 100 or Less,Rush Yards Last gm 125 or Less,Rush Yards Last gm 200 or Less,Rush Yards Last gm 250 or Less,Rush Yards Last gm 300 or Less,Rush Yards Last gm 350 or Less,Rush Yards Last gm 50 or More,Rush Yards Last gm 75 or More,Rush Yards Last gm 100 or More,Rush Yards Last gm 125 or More,Rush Yards Last gm 200 or More,Rush Yards Last gm 250 or More,Rush Yards Last gm 300 or More,Rush Yards Last gm 350 or More,Opp Rush Yards Last gm 50 or Less,Opp Rush Yards Last gm 75 or Less,Opp Rush Yards Last gm 100 or Less,Opp Rush Yards Last gm 125 or Less,Opp Rush Yards Last gm 200 or Less,Opp Rush Yards Last gm 250 or Less,Opp Rush Yards Last gm 300 or Less,Opp Rush Yards Last gm 350 or Less,Opp Rush Yards Last gm 50 or More,Opp Rush Yards Last gm 75 or More,Opp Rush Yards Last gm 100 or More,Opp Rush Yards Last gm 125 or More,Opp Rush Yards Last gm 200 or More,Opp Rush Yards Last gm 250 or More,Opp Rush Yards Last gm 300 or More,Opp Rush Yards Last gm 350 or More,Pass Yards Last gm 50 or Less,Pass Yards Last gm 100 or Less,Pass Yards Last gm 125 or Less,Pass Yards Last gm 150 or Less,Pass Yards Last gm 200 or Less,Pass Yards Last gm 250 or Less,Pass Yards Last gm 300 or Less,Pass Yards Last gm 350 or Less,Pass Yards Last gm 400 or Less,Pass Yards Last gm 500 or Less,Pass Yards Last gm 50 or More,Pass Yards Last gm 100 or More,Pass Yards Last gm 125 or More,Pass Yards Last gm 150 or More,Pass Yards Last gm 200 or More,Pass Yards Last gm 250 or More,Pass Yards Last gm 300 or More,Pass Yards Last gm 350 or More,Pass Yards Last gm 400 or More,Pass Yards Last gm 500 or More,Opp Pass Yards Last gm 50 or Less,Opp Pass Yards Last gm 100 or Less,Opp Pass Yards Last gm 125 or Less,Opp Pass Yards Last gm 150 or Less,Opp Pass Yards Last gm 200 or Less,Opp Pass Yards Last gm 250 or Less,Opp Pass Yards Last gm 300 or Less,Opp Pass Yards Last gm 350 or Less,Opp Pass Yards Last gm 400 or Less,Opp Pass Yards Last gm 500 or Less,Opp Pass Yards Last gm 50 or More,Opp Pass Yards Last gm 100 or More,Opp Pass Yards Last gm 125 or More,Opp Pass Yards Last gm 150 or More,Opp Pass Yards Last gm 200 or More,Opp Pass Yards Last gm 250 or More,Opp Pass Yards Last gm 300 or More,Opp Pass Yards Last gm 350 or More,Opp Pass Yards Last gm 400 or More,Opp Pass Yards Last gm 500 or More,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 75% or Less,Winning Perc 80% or Less,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 75% or More,Winning Perc 80% or More,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 75% or Less,Opp Winning Perc 80% or Less,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 75% or More,Opp Winning Perc 80% or More,Points Per Gm 10 or Less,Points Per Gm 13 or Less,Points Per Gm 15 or Less,Points Per Gm 17 or Less,Points Per Gm 20 or Less,Points Per Gm 22 or Less,Points Per Gm 24 or Less,Points Per Gm 28 or Less,Points Per Gm 30 or Less,Points Per Gm 35 or Less,Points Per Gm 10 or More,Points Per Gm 13 or More,Points Per Gm 15 or More,Points Per Gm 17 or More,Points Per Gm 20 or More,Points Per Gm 22 or More,Points Per Gm 24 or More,Points Per Gm 28 or More,Points Per Gm 30 or More,Points Per Gm 35 or More,Opp Points Per Gm 10 or Less,Opp Points Per Gm 13 or Less,Opp Points Per Gm 15 or Less,Opp Points Per Gm 17 or Less,Opp Points Per Gm 20 or Less,Opp Points Per Gm 22 or Less,Opp Points Per Gm 24 or Less,Opp Points Per Gm 28 or Less,Opp Points Per Gm 30 or Less,Opp Points Per Gm 35 or Less,Opp Points Per Gm 10 or More,Opp Points Per Gm 13 or More,Opp Points Per Gm 15 or More,Opp Points Per Gm 17 or More,Opp Points Per Gm 20 or More,Opp Points Per Gm 22 or More,Opp Points Per Gm 24 or More,Opp Points Per Gm 28 or More,Opp Points Per Gm 30 or More,Opp Points Per Gm 35 or More,Yards Per Gm 250 or Less,Yards Per Gm 300 or Less,Yards Per Gm 350 or Less,Yards Per Gm 400 or Less,Yards Per Gm 450 or Less,Yards Per Gm 250 or More,Yards Per Gm 300 or More,Yards Per Gm 350 or More,Yards Per Gm 400 or More,Yards Per Gm 450 or More,Opp Yards Per Gm 250 or Less,Opp Yards Per Gm 300 or Less,Opp Yards Per Gm 350 or Less,Opp Yards Per Gm 400 or Less,Opp Yards Per Gm 450 or Less,Opp Yards Per Gm 250 or More,Opp Yards Per Gm 300 or More,Opp Yards Per Gm 350 or More,Opp Yards Per Gm 400 or More,Opp Yards Per Gm 450 or More,Rush Yards Per Gm 70 or Less,Rush Yards Per Gm 80 or Less,Rush Yards Per Gm 90 or Less,Rush Yards Per Gm 100 or Less,Rush Yards Per Gm 110 or Less,Rush Yards Per Gm 120 or Less,Rush Yards Per Gm 130 or Less,Rush Yards Per Gm 140 or Less,Rush Yards Per Gm 150 or Less,Rush Yards Per Gm 160 or Less,Rush Yards Per Gm 170 or Less,Rush Yards Per Gm 180 or Less,Rush Yards Per Gm 70 or More,Rush Yards Per Gm 80 or More,Rush Yards Per Gm 90 or More,Rush Yards Per Gm 100 or More,Rush Yards Per Gm 110 or More,Rush Yards Per Gm 120 or More,Rush Yards Per Gm 130 or More,Rush Yards Per Gm 140 or More,Rush Yards Per Gm 150 or More,Rush Yards Per Gm 160 or More,Rush Yards Per Gm 170 or More,Rush Yards Per Gm 180 or More,Opp Rush Yards Per Gm 70 or Less,Opp Rush Yards Per Gm 80 or Less,Opp Rush Yards Per Gm 90 or Less,Opp Rush Yards Per Gm 100 or Less,Opp Rush Yards Per Gm 110 or Less,Opp Rush Yards Per Gm 120 or Less,Opp Rush Yards Per Gm 130 or Less,Opp Rush Yards Per Gm 140 or Less,Opp Rush Yards Per Gm 150 or Less,Opp Rush Yards Per Gm 160 or Less,Opp Rush Yards Per Gm 170 or Less,Opp Rush Yards Per Gm 180 or Less,Opp Rush Yards Per Gm 70 or More,Opp Rush Yards Per Gm 80 or More,Opp Rush Yards Per Gm 90 or More,Opp Rush Yards Per Gm 100 or More,Opp Rush Yards Per Gm 110 or More,Opp Rush Yards Per Gm 120 or More,Opp Rush Yards Per Gm 130 or More,Opp Rush Yards Per Gm 140 or More,Opp Rush Yards Per Gm 150 or More,Opp Rush Yards Per Gm 160 or More,Opp Rush Yards Per Gm 170 or More,Opp Rush Yards Per Gm 180 or More,Pass Yards Per Gm 150 or Less,Pass Yards Per Gm 175 or Less,Pass Yards Per Gm 200 or Less,Pass Yards Per Gm 225 or Less,Pass Yards Per Gm 250 or Less,Pass Yards Per Gm 275 or Less,Pass Yards Per Gm 300 or Less,Pass Yards Per Gm 350 or Less,Pass Yards Per Gm 150 or More,Pass Yards Per Gm 175 or More,Pass Yards Per Gm 200 or More,Pass Yards Per Gm 225 or More,Pass Yards Per Gm 250 or More,Pass Yards Per Gm 275 or More,Pass Yards Per Gm 300 or More,Pass Yards Per Gm 350 or More,Opp Pass Yards Per Gm 150 or Less,Opp Pass Yards Per Gm 175 or Less,Opp Pass Yards Per Gm 200 or Less,Opp Pass Yards Per Gm 225 or Less,Opp Pass Yards Per Gm 250 or Less,Opp Pass Yards Per Gm 275 or Less,Opp Pass Yards Per Gm 300 or Less,Opp Pass Yards Per Gm 350 or Less,Opp Pass Yards Per Gm 150 or More,Opp Pass Yards Per Gm 175 or More,Opp Pass Yards Per Gm 200 or More,Opp Pass Yards Per Gm 225 or More,Opp Pass Yards Per Gm 250 or More,Opp Pass Yards Per Gm 275 or More,Opp Pass Yards Per Gm 300 or More,Opp Pass Yards Per Gm 350 or More,Win Streak of 2 or More,Win Streak of 3 or More,Win Streak of 4 or More,Win Streak of 5 or More,Win Streak of 6 or More,Win Streak of 7 or More,Win Streak of 10 or More,Win Streak of 12 or More,Loss Streak of 2 or More,Loss Streak of 3 or More,Loss Streak of 4 or More,Loss Streak of 5 or More,Loss Streak of 6 or More,Loss Streak of 7 or More,Loss Streak of 10 or More,Loss Streak of 12 or More,Home Win Streak of 2 or More,Home Win Streak of 3 or More,Home Win Streak of 4 or More,Home Win Streak of 5 or More,Home Win Streak of 6 or More,Home Win Streak of 7 or More,Home Win Streak of 10 or More,Home Win Streak of 12 or More,Home Loss Streak of 2 or More,Home Loss Streak of 3 or More,Home Loss Streak of 4 or More,Home Loss Streak of 5 or More,Home Loss Streak of 6 or More,Home Loss Streak of 7 or More,Home Loss Streak of 10 or More,Home Loss Streak of 12 or More,Away Win Streak of 2 or More,Away Win Streak of 3 or More,Away Win Streak of 4 or More,Away Win Streak of 5 or More,Away Win Streak of 6 or More,Away Win Streak of 7 or More,Away Win Streak of 10 or More,Away Win Streak of 12 or More,Away Loss Streak of 2 or More,Away Loss Streak of 3 or More,Away Loss Streak of 4 or More,Away Loss Streak of 5 or More,Away Loss Streak of 6 or More,Away Loss Streak of 7 or More,Away Loss Streak of 10 or More,Away Loss Streak of 12 or More,Opp Win Streak of 2 or More,Opp Win Streak of 3 or More,Opp Win Streak of 4 or More,Opp Win Streak of 5 or More,Opp Win Streak of 6 or More,Opp Win Streak of 7 or More,Opp Win Streak of 10 or More,Opp Win Streak of 12 or More,Opp Loss Streak of 2 or More,Opp Loss Streak of 3 or More,Opp Loss Streak of 4 or More,Opp Loss Streak of 5 or More,Opp Loss Streak of 6 or More,Opp Loss Streak of 7 or More,Opp Loss Streak of 10 or More,Opp Loss Streak of 12 or More,Opp Home Win Streak of 2 or More,Opp Home Win Streak of 3 or More,Opp Home Win Streak of 4 or More,Opp Home Win Streak of 5 or More,Opp Home Win Streak of 6 or More,Opp Home Win Streak of 7 or More,Opp Home Win Streak of 10 or More,Opp Home Win Streak of 12 or More,Opp Home Loss Streak of 2 or More,Opp Home Loss Streak of 3 or More,Opp Home Loss Streak of 4 or More,Opp Home Loss Streak of 5 or More,Opp Home Loss Streak of 6 or More,Opp Home Loss Streak of 7 or More,Opp Home Loss Streak of 10 or More,Opp Home Loss Streak of 12 or More,Opp Away Win Streak of 2 or More,Opp Away Win Streak of 3 or More,Opp Away Win Streak of 4 or More,Opp Away Win Streak of 5 or More,Opp Away Win Streak of 6 or More,Opp Away Win Streak of 7 or More,Opp Away Win Streak of 10 or More,Opp Away Win Streak of 12 or More,Opp Away Loss Streak of 2 or More,Opp Away Loss Streak of 3 or More,Opp Away Loss Streak of 4 or More,Opp Away Loss Streak of 5 or More,Opp Away Loss Streak of 6 or More,Opp Away Loss Streak of 7 or More,Opp Away Loss Streak of 10 or More,Opp Away Loss Streak of 12 or More,Games Played 2 or Less,Games Played 4 or Less,Games Played 6 or Less,Games Played 8 or Less,Games Played 10 or Less,Games Played 12 or Less,Games Played 2 or More,Games Played 4 or More,Games Played 6 or More,Games Played 8 or More,Games Played 10 or More,Games Played 12 or More,Wins 2 or Less,Wins 4 or Less,Wins 6 or Less,Wins 8 or Less,Wins 10 or Less,Wins 12 or Less,Wins 2 or More,Wins 4 or More,Wins 6 or More,Wins 8 or More,Wins 10 or More,Wins 12 or More,Opp Wins 2 or Less,Opp Wins 4 or Less,Opp Wins 6 or Less,Opp Wins 8 or Less,Opp Wins 10 or Less,Opp Wins 12 or Less,Opp Wins 2 or More,Opp Wins 4 or More,Opp Wins 6 or More,Opp Wins 8 or More,Opp Wins 10 or More,Opp Wins 12 or More,Thursday,Saturday,Sunday,Monday,Not Sunday,Grass,Turf,Probability of Win 25% or Less,Probability of Win 30% or Less,Probability of Win 35% or Less,Probability of Win 40% or Less,Probability of Win 45% or Less,Probability of Win 50% or Less,Probability of Win 55% or Less,Probability of Win 60% or Less,Probability of Win 65% or Less,Probability of Win 70% or Less,Probability of Win 75% or Less,Probability of Win 80% or Less,Probability of Win 25% or More,Probability of Win 30% or More,Probability of Win 35% or More,Probability of Win 40% or More,Probability of Win 45% or More,Probability of Win 50% or More,Probability of Win 55% or More,Probability of Win 60% or More,Probability of Win 65% or More,Probability of Win 70% or More,Probability of Win 75% or More,Probability of Win 80% or More,Opp Probability of Win 25% or Less,Opp Probability of Win 30% or Less,Opp Probability of Win 35% or Less,Opp Probability of Win 40% or Less,Opp Probability of Win 45% or Less,Opp Probability of Win 50% or Less,Opp Probability of Win 55% or Less,Opp Probability of Win 60% or Less,Opp Probability of Win 65% or Less,Opp Probability of Win 70% or Less,Opp Probability of Win 75% or Less,Opp Probability of Win 80% or Less,Opp Probability of Win 25% or More,Opp Probability of Win 30% or More,Opp Probability of Win 35% or More,Opp Probability of Win 40% or More,Opp Probability of Win 45% or More,Opp Probability of Win 50% or More,Opp Probability of Win 55% or More,Opp Probability of Win 60% or More,Opp Probability of Win 65% or More,Opp Probability of Win 70% or More,Opp Probability of Win 75% or More,Opp Probability of Win 80% or More");
        }
        private readonly StreamWriter _writer = new StreamWriter("D:\\Leagues\\NFLOutput.csv");
        private readonly StreamWriter _writerSignals = new StreamWriter("D:\\Leagues\\Signals.csv");

        public int Pt;
        public int Pta;
        public int Fd;
        public int Fda;
        public int r;
        public int Ra;
        public int Ry;
        public int Rya;
        public int p;
        public int Pa;
        public int Pc;
        public int Pca;
        public int Py;
        public int Pya;
        public int It;
        public int Ita;
        public int Date;
        public int GmNo;
        public int OgmNo;
        public int Home;
        public int Turf;
        public int Fav;
        public string Team, Div, Oteam, Odiv, Day;
        public double Spread, Ou, Ml;
        public double SpreadResult, OuResult, ml_result;

        public List<int> PT = new List<int>();
        public List<int> PTA = new List<int>();
        public List<int> FD = new List<int>();
        public List<int> FDA = new List<int>();
        public List<int> R = new List<int>();
        public List<int> RA = new List<int>();
        public List<int> RY = new List<int>();
        public List<int> RYA = new List<int>();
        public List<int> P = new List<int>();
        public List<int> PA = new List<int>();
        public List<int> PC = new List<int>();
        public List<int> PCA = new List<int>();
        public List<int> PY = new List<int>();
        public List<int> PYA = new List<int>();
        public List<int> IT = new List<int>();
        public List<int> ITA = new List<int>();
        public List<int> DATE = new List<int>();
        public List<int> GM_NO = new List<int>();
        public List<int> OGM_NO = new List<int>();
        public List<int> HOME = new List<int>();
        public List<int> TURF = new List<int>();
        public List<int> FAV = new List<int>();
        public List<string> TEAM = new List<string>();
        public List<string> DIV = new List<string>();
        public List<string> OTEAM = new List<string>();
        public List<string> ODIV = new List<string>();
        public List<string> DAY = new List<string>();
        public List<double> SPREAD = new List<double>();
        public List<double> OU = new List<double>();
        public List<double> ML = new List<double>();

        #region Features
        //Features


        List<bool> FavFeatures = new List<bool>();
        List<bool> UndFeatures = new List<bool>();
        List<bool> HomeFeatures = new List<bool>();
        List<bool> AwayFeatures = new List<bool>();
        List<bool> WinRecordFeatures = new List<bool>();
        List<bool> LoseRecordFeatures = new List<bool>();
        List<bool> SprdFav3Less = new List<bool>();

        List<bool> SprdFav5Less = new List<bool>();
        List<bool> SprdFav7Less = new List<bool>();
        List<bool> SprdFav8Less = new List<bool>();
        List<bool> SprdFav10Less = new List<bool>();
        List<bool> SprdFav12Less = new List<bool>();
        List<bool> SprdFav15Less = new List<bool>();
        List<bool> SprdFav20Less = new List<bool>();
        List<bool> SprdFav3More = new List<bool>();
        List<bool> SprdFav5More = new List<bool>();
        List<bool> SprdFav7More = new List<bool>();
        List<bool> SprdFav8More = new List<bool>();
        List<bool> SprdFav10More = new List<bool>();
        List<bool> SprdFav12More = new List<bool>();
        List<bool> SprdFav15More = new List<bool>();
        List<bool> SprdFav20More = new List<bool>();

        List<bool> SprdUnd3Less = new List<bool>();
        List<bool> SprdUnd5Less = new List<bool>();
        List<bool> SprdUnd7Less = new List<bool>();
        List<bool> SprdUnd8Less = new List<bool>();
        List<bool> SprdUnd10Less = new List<bool>();
        List<bool> SprdUnd12Less = new List<bool>();
        List<bool> SprdUnd15Less = new List<bool>();
        List<bool> SprdUnd20Less = new List<bool>();
        List<bool> SprdUnd3More = new List<bool>();
        List<bool> SprdUnd5More = new List<bool>();
        List<bool> SprdUnd7More = new List<bool>();
        List<bool> SprdUnd8More = new List<bool>();
        List<bool> SprdUnd10More = new List<bool>();
        List<bool> SprdUnd12More = new List<bool>();
        List<bool> SprdUnd15More = new List<bool>();
        List<bool> SprdUnd20More = new List<bool>();

        List<bool> Over30Less = new List<bool>();
        List<bool> Over35Less = new List<bool>();
        List<bool> Over40Less = new List<bool>();
        List<bool> Over45Less = new List<bool>();
        List<bool> Over50Less = new List<bool>();
        List<bool> Over55Less = new List<bool>();
        List<bool> Over60Less = new List<bool>();
        List<bool> Over30More = new List<bool>();
        List<bool> Over35More = new List<bool>();
        List<bool> Over40More = new List<bool>();
        List<bool> Over45More = new List<bool>();
        List<bool> Over50More = new List<bool>();
        List<bool> Over55More = new List<bool>();
        List<bool> Over60More = new List<bool>();

        List<bool> MLNeg5000Less = new List<bool>();
        List<bool> MLNeg2000Less = new List<bool>();
        List<bool> MLNeg1000Less = new List<bool>();
        List<bool> MLNeg800Less = new List<bool>();
        List<bool> MLNeg600Less = new List<bool>();
        List<bool> MLNeg500Less = new List<bool>();
        List<bool> MLNeg400Less = new List<bool>();
        List<bool> MLNeg350Less = new List<bool>();
        List<bool> MLNeg300Less = new List<bool>();
        List<bool> MLNeg250Less = new List<bool>();
        List<bool> MLNeg200Less = new List<bool>();
        List<bool> MLNeg150Less = new List<bool>();
        List<bool> MLNeg125Less = new List<bool>();
        List<bool> MLNeg100Less = new List<bool>();
        List<bool> MLPos100Less = new List<bool>();
        List<bool> MLPos150Less = new List<bool>();
        List<bool> MLPos200Less = new List<bool>();
        List<bool> MLPos250Less = new List<bool>();
        List<bool> MLPos300Less = new List<bool>();
        List<bool> MLPos350Less = new List<bool>();
        List<bool> MLPos400Less = new List<bool>();
        List<bool> MLPos500Less = new List<bool>();
        List<bool> MLPos600Less = new List<bool>();
        List<bool> MLPos800Less = new List<bool>();
        List<bool> MLPos1000Less = new List<bool>();

        List<bool> MLNeg5000More = new List<bool>();
        List<bool> MLNeg2000More = new List<bool>();
        List<bool> MLNeg1000More = new List<bool>();
        List<bool> MLNeg800More = new List<bool>();
        List<bool> MLNeg600More = new List<bool>();
        List<bool> MLNeg500More = new List<bool>();
        List<bool> MLNeg400More = new List<bool>();
        List<bool> MLNeg350More = new List<bool>();
        List<bool> MLNeg300More = new List<bool>();
        List<bool> MLNeg250More = new List<bool>();
        List<bool> MLNeg200More = new List<bool>();
        List<bool> MLNeg150More = new List<bool>();
        List<bool> MLNeg125More = new List<bool>();
        List<bool> MLNeg100More = new List<bool>();
        List<bool> MLPos100More = new List<bool>();
        List<bool> MLPos150More = new List<bool>();
        List<bool> MLPos200More = new List<bool>();
        List<bool> MLPos250More = new List<bool>();
        List<bool> MLPos300More = new List<bool>();
        List<bool> MLPos350More = new List<bool>();
        List<bool> MLPos400More = new List<bool>();
        List<bool> MLPos500More = new List<bool>();
        List<bool> MLPos600More = new List<bool>();
        List<bool> MLPos800More = new List<bool>();
        List<bool> MLPos1000More = new List<bool>();

        List<bool> PtsLG7Less = new List<bool>();
        List<bool> PtsLG10Less = new List<bool>();
        List<bool> PtsLG13Less = new List<bool>();
        List<bool> PtsLG14Less = new List<bool>();
        List<bool> PtsLG17Less = new List<bool>();
        List<bool> PtsLG21Less = new List<bool>();
        List<bool> PtsLG24Less = new List<bool>();
        List<bool> PtsLG28Less = new List<bool>();
        List<bool> PtsLG31Less = new List<bool>();
        List<bool> PtsLG35Less = new List<bool>();
        List<bool> PtsLG42Less = new List<bool>();
        List<bool> PtsLG49Less = new List<bool>();
        List<bool> PtsLG60Less = new List<bool>();
        List<bool> PtsLG7More = new List<bool>();
        List<bool> PtsLG10More = new List<bool>();
        List<bool> PtsLG13More = new List<bool>();
        List<bool> PtsLG14More = new List<bool>();
        List<bool> PtsLG17More = new List<bool>();
        List<bool> PtsLG21More = new List<bool>();
        List<bool> PtsLG24More = new List<bool>();
        List<bool> PtsLG28More = new List<bool>();
        List<bool> PtsLG31More = new List<bool>();
        List<bool> PtsLG35More = new List<bool>();
        List<bool> PtsLG42More = new List<bool>();
        List<bool> PtsLG49More = new List<bool>();
        List<bool> PtsLG60More = new List<bool>();

        List<bool> oPtsLG7Less = new List<bool>();
        List<bool> oPtsLG10Less = new List<bool>();
        List<bool> oPtsLG13Less = new List<bool>();
        List<bool> oPtsLG14Less = new List<bool>();
        List<bool> oPtsLG17Less = new List<bool>();
        List<bool> oPtsLG21Less = new List<bool>();
        List<bool> oPtsLG24Less = new List<bool>();
        List<bool> oPtsLG28Less = new List<bool>();
        List<bool> oPtsLG31Less = new List<bool>();
        List<bool> oPtsLG35Less = new List<bool>();
        List<bool> oPtsLG42Less = new List<bool>();
        List<bool> oPtsLG49Less = new List<bool>();
        List<bool> oPtsLG60Less = new List<bool>();
        List<bool> oPtsLG7More = new List<bool>();
        List<bool> oPtsLG10More = new List<bool>();
        List<bool> oPtsLG13More = new List<bool>();
        List<bool> oPtsLG14More = new List<bool>();
        List<bool> oPtsLG17More = new List<bool>();
        List<bool> oPtsLG21More = new List<bool>();
        List<bool> oPtsLG24More = new List<bool>();
        List<bool> oPtsLG28More = new List<bool>();
        List<bool> oPtsLG31More = new List<bool>();
        List<bool> oPtsLG35More = new List<bool>();
        List<bool> oPtsLG42More = new List<bool>();
        List<bool> oPtsLG49More = new List<bool>();
        List<bool> oPtsLG60More = new List<bool>();

        List<bool> YDS150Less = new List<bool>();
        List<bool> YDS200Less = new List<bool>();
        List<bool> YDS250Less = new List<bool>();
        List<bool> YDS300Less = new List<bool>();
        List<bool> YDS350Less = new List<bool>();
        List<bool> YDS400Less = new List<bool>();
        List<bool> YDS450Less = new List<bool>();
        List<bool> YDS500Less = new List<bool>();
        List<bool> YDS150More = new List<bool>();
        List<bool> YDS200More = new List<bool>();
        List<bool> YDS250More = new List<bool>();
        List<bool> YDS300More = new List<bool>();
        List<bool> YDS350More = new List<bool>();
        List<bool> YDS400More = new List<bool>();
        List<bool> YDS450More = new List<bool>();
        List<bool> YDS500More = new List<bool>();

        List<bool> oYDS150Less = new List<bool>();
        List<bool> oYDS200Less = new List<bool>();
        List<bool> oYDS250Less = new List<bool>();
        List<bool> oYDS300Less = new List<bool>();
        List<bool> oYDS350Less = new List<bool>();
        List<bool> oYDS400Less = new List<bool>();
        List<bool> oYDS450Less = new List<bool>();
        List<bool> oYDS500Less = new List<bool>();
        List<bool> oYDS150More = new List<bool>();
        List<bool> oYDS200More = new List<bool>();
        List<bool> oYDS250More = new List<bool>();
        List<bool> oYDS300More = new List<bool>();
        List<bool> oYDS350More = new List<bool>();
        List<bool> oYDS400More = new List<bool>();
        List<bool> oYDS450More = new List<bool>();
        List<bool> oYDS500More = new List<bool>();

        List<bool> RYLG50Less = new List<bool>();
        List<bool> RYLG75Less = new List<bool>();
        List<bool> RYLG100Less = new List<bool>();
        List<bool> RYLG125Less = new List<bool>();
        List<bool> RYLG150Less = new List<bool>();
        List<bool> RYLG200Less = new List<bool>();
        List<bool> RYLG250Less = new List<bool>();
        List<bool> RYLG300Less = new List<bool>();
        List<bool> RYLG350Less = new List<bool>();
        List<bool> RYLG50More = new List<bool>();
        List<bool> RYLG75More = new List<bool>();
        List<bool> RYLG100More = new List<bool>();
        List<bool> RYLG125More = new List<bool>();
        List<bool> RYLG150More = new List<bool>();
        List<bool> RYLG200More = new List<bool>();
        List<bool> RYLG250More = new List<bool>();
        List<bool> RYLG300More = new List<bool>();
        List<bool> RYLG350More = new List<bool>();

        List<bool> oRYLG50Less = new List<bool>();
        List<bool> oRYLG75Less = new List<bool>();
        List<bool> oRYLG100Less = new List<bool>();
        List<bool> oRYLG125Less = new List<bool>();
        List<bool> oRYLG150Less = new List<bool>();
        List<bool> oRYLG200Less = new List<bool>();
        List<bool> oRYLG250Less = new List<bool>();
        List<bool> oRYLG300Less = new List<bool>();
        List<bool> oRYLG350Less = new List<bool>();
        List<bool> oRYLG50More = new List<bool>();
        List<bool> oRYLG75More = new List<bool>();
        List<bool> oRYLG100More = new List<bool>();
        List<bool> oRYLG125More = new List<bool>();
        List<bool> oRYLG150More = new List<bool>();
        List<bool> oRYLG200More = new List<bool>();
        List<bool> oRYLG250More = new List<bool>();
        List<bool> oRYLG300More = new List<bool>();
        List<bool> oRYLG350More = new List<bool>();

        List<bool> PYLG50Less = new List<bool>();
        List<bool> PYLG100Less = new List<bool>();
        List<bool> PYLG125Less = new List<bool>();
        List<bool> PYLG150Less = new List<bool>();
        List<bool> PYLG200Less = new List<bool>();
        List<bool> PYLG250Less = new List<bool>();
        List<bool> PYLG300Less = new List<bool>();
        List<bool> PYLG350Less = new List<bool>();
        List<bool> PYLG400Less = new List<bool>();
        List<bool> PYLG500Less = new List<bool>();
        List<bool> PYLG50More = new List<bool>();
        List<bool> PYLG100More = new List<bool>();
        List<bool> PYLG125More = new List<bool>();
        List<bool> PYLG150More = new List<bool>();
        List<bool> PYLG200More = new List<bool>();
        List<bool> PYLG250More = new List<bool>();
        List<bool> PYLG300More = new List<bool>();
        List<bool> PYLG350More = new List<bool>();
        List<bool> PYLG400More = new List<bool>();
        List<bool> PYLG500More = new List<bool>();

        List<bool> oPYLG50Less = new List<bool>();
        List<bool> oPYLG100Less = new List<bool>();
        List<bool> oPYLG125Less = new List<bool>();
        List<bool> oPYLG150Less = new List<bool>();
        List<bool> oPYLG200Less = new List<bool>();
        List<bool> oPYLG250Less = new List<bool>();
        List<bool> oPYLG300Less = new List<bool>();
        List<bool> oPYLG350Less = new List<bool>();
        List<bool> oPYLG400Less = new List<bool>();
        List<bool> oPYLG500Less = new List<bool>();
        List<bool> oPYLG50More = new List<bool>();
        List<bool> oPYLG100More = new List<bool>();
        List<bool> oPYLG125More = new List<bool>();
        List<bool> oPYLG150More = new List<bool>();
        List<bool> oPYLG200More = new List<bool>();
        List<bool> oPYLG250More = new List<bool>();
        List<bool> oPYLG300More = new List<bool>();
        List<bool> oPYLG350More = new List<bool>();
        List<bool> oPYLG400More = new List<bool>();
        List<bool> oPYLG500More = new List<bool>();

        List<bool> winP25Less = new List<bool>();
        List<bool> winP33Less = new List<bool>();
        List<bool> winP40Less = new List<bool>();
        List<bool> winP45Less = new List<bool>();
        List<bool> winP50Less = new List<bool>();
        List<bool> winP55Less = new List<bool>();
        List<bool> winP60Less = new List<bool>();
        List<bool> winP65Less = new List<bool>();
        List<bool> winP75Less = new List<bool>();
        List<bool> winP80Less = new List<bool>();
        List<bool> winP25More = new List<bool>();
        List<bool> winP33More = new List<bool>();
        List<bool> winP40More = new List<bool>();
        List<bool> winP45More = new List<bool>();
        List<bool> winP50More = new List<bool>();
        List<bool> winP55More = new List<bool>();
        List<bool> winP60More = new List<bool>();
        List<bool> winP65More = new List<bool>();
        List<bool> winP75More = new List<bool>();
        List<bool> winP80More = new List<bool>();

        List<bool> owinP25Less = new List<bool>();
        List<bool> owinP33Less = new List<bool>();
        List<bool> owinP40Less = new List<bool>();
        List<bool> owinP45Less = new List<bool>();
        List<bool> owinP50Less = new List<bool>();
        List<bool> owinP55Less = new List<bool>();
        List<bool> owinP60Less = new List<bool>();
        List<bool> owinP65Less = new List<bool>();
        List<bool> owinP75Less = new List<bool>();
        List<bool> owinP80Less = new List<bool>();
        List<bool> owinP25More = new List<bool>();
        List<bool> owinP33More = new List<bool>();
        List<bool> owinP40More = new List<bool>();
        List<bool> owinP45More = new List<bool>();
        List<bool> owinP50More = new List<bool>();
        List<bool> owinP55More = new List<bool>();
        List<bool> owinP60More = new List<bool>();
        List<bool> owinP65More = new List<bool>();
        List<bool> owinP75More = new List<bool>();
        List<bool> owinP80More = new List<bool>();

        List<bool> PPG10Less = new List<bool>();
        List<bool> PPG13Less = new List<bool>();
        List<bool> PPG15Less = new List<bool>();
        List<bool> PPG17Less = new List<bool>();
        List<bool> PPG20Less = new List<bool>();
        List<bool> PPG22Less = new List<bool>();
        List<bool> PPG24Less = new List<bool>();
        List<bool> PPG28Less = new List<bool>();
        List<bool> PPG30Less = new List<bool>();
        List<bool> PPG35Less = new List<bool>();
        List<bool> PPG10More = new List<bool>();
        List<bool> PPG13More = new List<bool>();
        List<bool> PPG15More = new List<bool>();
        List<bool> PPG17More = new List<bool>();
        List<bool> PPG20More = new List<bool>();
        List<bool> PPG22More = new List<bool>();
        List<bool> PPG24More = new List<bool>();
        List<bool> PPG28More = new List<bool>();
        List<bool> PPG30More = new List<bool>();
        List<bool> PPG35More = new List<bool>();

        List<bool> oPPG10Less = new List<bool>();
        List<bool> oPPG13Less = new List<bool>();
        List<bool> oPPG15Less = new List<bool>();
        List<bool> oPPG17Less = new List<bool>();
        List<bool> oPPG20Less = new List<bool>();
        List<bool> oPPG22Less = new List<bool>();
        List<bool> oPPG24Less = new List<bool>();
        List<bool> oPPG28Less = new List<bool>();
        List<bool> oPPG30Less = new List<bool>();
        List<bool> oPPG35Less = new List<bool>();
        List<bool> oPPG10More = new List<bool>();
        List<bool> oPPG13More = new List<bool>();
        List<bool> oPPG15More = new List<bool>();
        List<bool> oPPG17More = new List<bool>();
        List<bool> oPPG20More = new List<bool>();
        List<bool> oPPG22More = new List<bool>();
        List<bool> oPPG24More = new List<bool>();
        List<bool> oPPG28More = new List<bool>();
        List<bool> oPPG30More = new List<bool>();
        List<bool> oPPG35More = new List<bool>();

        List<bool> YDSPG250Less = new List<bool>();
        List<bool> YDSPG300Less = new List<bool>();
        List<bool> YDSPG350Less = new List<bool>();
        List<bool> YDSPG400Less = new List<bool>();
        List<bool> YDSPG450Less = new List<bool>();
        List<bool> YDSPG250More = new List<bool>();
        List<bool> YDSPG300More = new List<bool>();
        List<bool> YDSPG350More = new List<bool>();
        List<bool> YDSPG400More = new List<bool>();
        List<bool> YDSPG450More = new List<bool>();

        List<bool> oYDSPG250Less = new List<bool>();
        List<bool> oYDSPG300Less = new List<bool>();
        List<bool> oYDSPG350Less = new List<bool>();
        List<bool> oYDSPG400Less = new List<bool>();
        List<bool> oYDSPG450Less = new List<bool>();
        List<bool> oYDSPG250More = new List<bool>();
        List<bool> oYDSPG300More = new List<bool>();
        List<bool> oYDSPG350More = new List<bool>();
        List<bool> oYDSPG400More = new List<bool>();
        List<bool> oYDSPG450More = new List<bool>();

        List<bool> RYPG70Less = new List<bool>();
        List<bool> RYPG80Less = new List<bool>();
        List<bool> RYPG90Less = new List<bool>();
        List<bool> RYPG100Less = new List<bool>();
        List<bool> RYPG110Less = new List<bool>();
        List<bool> RYPG120Less = new List<bool>();
        List<bool> RYPG130Less = new List<bool>();
        List<bool> RYPG140Less = new List<bool>();
        List<bool> RYPG150Less = new List<bool>();
        List<bool> RYPG160Less = new List<bool>();
        List<bool> RYPG170Less = new List<bool>();
        List<bool> RYPG180Less = new List<bool>();
        List<bool> RYPG70More = new List<bool>();
        List<bool> RYPG80More = new List<bool>();
        List<bool> RYPG90More = new List<bool>();
        List<bool> RYPG100More = new List<bool>();
        List<bool> RYPG110More = new List<bool>();
        List<bool> RYPG120More = new List<bool>();
        List<bool> RYPG130More = new List<bool>();
        List<bool> RYPG140More = new List<bool>();
        List<bool> RYPG150More = new List<bool>();
        List<bool> RYPG160More = new List<bool>();
        List<bool> RYPG170More = new List<bool>();
        List<bool> RYPG180More = new List<bool>();

        List<bool> oRYPG70Less = new List<bool>();
        List<bool> oRYPG80Less = new List<bool>();
        List<bool> oRYPG90Less = new List<bool>();
        List<bool> oRYPG100Less = new List<bool>();
        List<bool> oRYPG110Less = new List<bool>();
        List<bool> oRYPG120Less = new List<bool>();
        List<bool> oRYPG130Less = new List<bool>();
        List<bool> oRYPG140Less = new List<bool>();
        List<bool> oRYPG150Less = new List<bool>();
        List<bool> oRYPG160Less = new List<bool>();
        List<bool> oRYPG170Less = new List<bool>();
        List<bool> oRYPG180Less = new List<bool>();
        List<bool> oRYPG70More = new List<bool>();
        List<bool> oRYPG80More = new List<bool>();
        List<bool> oRYPG90More = new List<bool>();
        List<bool> oRYPG100More = new List<bool>();
        List<bool> oRYPG110More = new List<bool>();
        List<bool> oRYPG120More = new List<bool>();
        List<bool> oRYPG130More = new List<bool>();
        List<bool> oRYPG140More = new List<bool>();
        List<bool> oRYPG150More = new List<bool>();
        List<bool> oRYPG160More = new List<bool>();
        List<bool> oRYPG170More = new List<bool>();
        List<bool> oRYPG180More = new List<bool>();

        List<bool> PYPG150Less = new List<bool>();
        List<bool> PYPG175Less = new List<bool>();
        List<bool> PYPG200Less = new List<bool>();
        List<bool> PYPG225Less = new List<bool>();
        List<bool> PYPG250Less = new List<bool>();
        List<bool> PYPG275Less = new List<bool>();
        List<bool> PYPG300Less = new List<bool>();
        List<bool> PYPG350Less = new List<bool>();
        List<bool> PYPG150More = new List<bool>();
        List<bool> PYPG175More = new List<bool>();
        List<bool> PYPG200More = new List<bool>();
        List<bool> PYPG225More = new List<bool>();
        List<bool> PYPG250More = new List<bool>();
        List<bool> PYPG275More = new List<bool>();
        List<bool> PYPG300More = new List<bool>();
        List<bool> PYPG350More = new List<bool>();

        List<bool> oPYPG150Less = new List<bool>();
        List<bool> oPYPG175Less = new List<bool>();
        List<bool> oPYPG200Less = new List<bool>();
        List<bool> oPYPG225Less = new List<bool>();
        List<bool> oPYPG250Less = new List<bool>();
        List<bool> oPYPG275Less = new List<bool>();
        List<bool> oPYPG300Less = new List<bool>();
        List<bool> oPYPG350Less = new List<bool>();
        List<bool> oPYPG150More = new List<bool>();
        List<bool> oPYPG175More = new List<bool>();
        List<bool> oPYPG200More = new List<bool>();
        List<bool> oPYPG225More = new List<bool>();
        List<bool> oPYPG250More = new List<bool>();
        List<bool> oPYPG275More = new List<bool>();
        List<bool> oPYPG300More = new List<bool>();
        List<bool> oPYPG350More = new List<bool>();


        List<bool> WStrk2 = new List<bool>();
        List<bool> WStrk3 = new List<bool>();
        List<bool> WStrk4 = new List<bool>();
        List<bool> WStrk5 = new List<bool>();
        List<bool> WStrk6 = new List<bool>();
        List<bool> WStrk7 = new List<bool>();
        List<bool> WStrk10 = new List<bool>();
        List<bool> WStrk12 = new List<bool>();
        List<bool> LStrk2 = new List<bool>();
        List<bool> LStrk3 = new List<bool>();
        List<bool> LStrk4 = new List<bool>();
        List<bool> LStrk5 = new List<bool>();
        List<bool> LStrk6 = new List<bool>();
        List<bool> LStrk7 = new List<bool>();
        List<bool> LStrk10 = new List<bool>();
        List<bool> LStrk12 = new List<bool>();
        List<bool> homeWStrk2 = new List<bool>();
        List<bool> homeWStrk3 = new List<bool>();
        List<bool> homeWStrk4 = new List<bool>();
        List<bool> homeWStrk5 = new List<bool>();
        List<bool> homeWStrk6 = new List<bool>();
        List<bool> homeWStrk7 = new List<bool>();
        List<bool> homeWStrk10 = new List<bool>();
        List<bool> homeWStrk12 = new List<bool>();
        List<bool> homeLStrk2 = new List<bool>();
        List<bool> homeLStrk3 = new List<bool>();
        List<bool> homeLStrk4 = new List<bool>();
        List<bool> homeLStrk5 = new List<bool>();
        List<bool> homeLStrk6 = new List<bool>();
        List<bool> homeLStrk7 = new List<bool>();
        List<bool> homeLStrk10 = new List<bool>();
        List<bool> homeLStrk12 = new List<bool>();
        List<bool> awayWStrk2 = new List<bool>();
        List<bool> awayWStrk3 = new List<bool>();
        List<bool> awayWStrk4 = new List<bool>();
        List<bool> awayWStrk5 = new List<bool>();
        List<bool> awayWStrk6 = new List<bool>();
        List<bool> awayWStrk7 = new List<bool>();
        List<bool> awayWStrk10 = new List<bool>();
        List<bool> awayWStrk12 = new List<bool>();
        List<bool> awayLStrk2 = new List<bool>();
        List<bool> awayLStrk3 = new List<bool>();
        List<bool> awayLStrk4 = new List<bool>();
        List<bool> awayLStrk5 = new List<bool>();
        List<bool> awayLStrk6 = new List<bool>();
        List<bool> awayLStrk7 = new List<bool>();
        List<bool> awayLStrk10 = new List<bool>();
        List<bool> awayLStrk12 = new List<bool>();
        List<bool> oWStrk2 = new List<bool>();
        List<bool> oWStrk3 = new List<bool>();
        List<bool> oWStrk4 = new List<bool>();
        List<bool> oWStrk5 = new List<bool>();
        List<bool> oWStrk6 = new List<bool>();
        List<bool> oWStrk7 = new List<bool>();
        List<bool> oWStrk10 = new List<bool>();
        List<bool> oWStrk12 = new List<bool>();
        List<bool> oLStrk2 = new List<bool>();
        List<bool> oLStrk3 = new List<bool>();
        List<bool> oLStrk4 = new List<bool>();
        List<bool> oLStrk5 = new List<bool>();
        List<bool> oLStrk6 = new List<bool>();
        List<bool> oLStrk7 = new List<bool>();
        List<bool> oLStrk10 = new List<bool>();
        List<bool> oLStrk12 = new List<bool>();
        List<bool> ohomeWStrk2 = new List<bool>();
        List<bool> ohomeWStrk3 = new List<bool>();
        List<bool> ohomeWStrk4 = new List<bool>();
        List<bool> ohomeWStrk5 = new List<bool>();
        List<bool> ohomeWStrk6 = new List<bool>();
        List<bool> ohomeWStrk7 = new List<bool>();
        List<bool> ohomeWStrk10 = new List<bool>();
        List<bool> ohomeWStrk12 = new List<bool>();
        List<bool> ohomeLStrk2 = new List<bool>();
        List<bool> ohomeLStrk3 = new List<bool>();
        List<bool> ohomeLStrk4 = new List<bool>();
        List<bool> ohomeLStrk5 = new List<bool>();
        List<bool> ohomeLStrk6 = new List<bool>();
        List<bool> ohomeLStrk7 = new List<bool>();
        List<bool> ohomeLStrk10 = new List<bool>();
        List<bool> ohomeLStrk12 = new List<bool>();
        List<bool> oawayWStrk2 = new List<bool>();
        List<bool> oawayWStrk3 = new List<bool>();
        List<bool> oawayWStrk4 = new List<bool>();
        List<bool> oawayWStrk5 = new List<bool>();
        List<bool> oawayWStrk6 = new List<bool>();
        List<bool> oawayWStrk7 = new List<bool>();
        List<bool> oawayWStrk10 = new List<bool>();
        List<bool> oawayWStrk12 = new List<bool>();
        List<bool> oawayLStrk2 = new List<bool>();
        List<bool> oawayLStrk3 = new List<bool>();
        List<bool> oawayLStrk4 = new List<bool>();
        List<bool> oawayLStrk5 = new List<bool>();
        List<bool> oawayLStrk6 = new List<bool>();
        List<bool> oawayLStrk7 = new List<bool>();
        List<bool> oawayLStrk10 = new List<bool>();
        List<bool> oawayLStrk12 = new List<bool>();


        List<bool> Gms2Less = new List<bool>();
        List<bool> Gms4Less = new List<bool>();
        List<bool> Gms6Less = new List<bool>();
        List<bool> Gms8Less = new List<bool>();
        List<bool> Gms10Less = new List<bool>();
        List<bool> Gms12Less = new List<bool>();
        List<bool> Gms2More = new List<bool>();
        List<bool> Gms4More = new List<bool>();
        List<bool> Gms6More = new List<bool>();
        List<bool> Gms8More = new List<bool>();
        List<bool> Gms10More = new List<bool>();
        List<bool> Gms12More = new List<bool>();


        List<bool> Wins2Less = new List<bool>();
        List<bool> Wins4Less = new List<bool>();
        List<bool> Wins6Less = new List<bool>();
        List<bool> Wins8Less = new List<bool>();
        List<bool> Wins10Less = new List<bool>();
        List<bool> Wins12Less = new List<bool>();
        List<bool> Wins2More = new List<bool>();
        List<bool> Wins4More = new List<bool>();
        List<bool> Wins6More = new List<bool>();
        List<bool> Wins8More = new List<bool>();
        List<bool> Wins10More = new List<bool>();
        List<bool> Wins12More = new List<bool>();

        List<bool> oWins2Less = new List<bool>();
        List<bool> oWins4Less = new List<bool>();
        List<bool> oWins6Less = new List<bool>();
        List<bool> oWins8Less = new List<bool>();
        List<bool> oWins10Less = new List<bool>();
        List<bool> oWins12Less = new List<bool>();
        List<bool> oWins2More = new List<bool>();
        List<bool> oWins4More = new List<bool>();
        List<bool> oWins6More = new List<bool>();
        List<bool> oWins8More = new List<bool>();
        List<bool> oWins10More = new List<bool>();
        List<bool> oWins12More = new List<bool>();

        List<bool> Thu = new List<bool>();
        List<bool> Sat = new List<bool>();
        List<bool> Sun = new List<bool>();
        List<bool> Mon = new List<bool>();
        List<bool> NotSun = new List<bool>();

        List<bool> Grass = new List<bool>();
        List<bool> TurfFeature = new List<bool>();


        List<bool> Prob25Less = new List<bool>();
        List<bool> Prob30Less = new List<bool>();
        List<bool> Prob35Less = new List<bool>();
        List<bool> Prob40Less = new List<bool>();
        List<bool> Prob45Less = new List<bool>();
        List<bool> Prob50Less = new List<bool>();
        List<bool> Prob55Less = new List<bool>();
        List<bool> Prob60Less = new List<bool>();
        List<bool> Prob65Less = new List<bool>();
        List<bool> Prob70Less = new List<bool>();
        List<bool> Prob75Less = new List<bool>();
        List<bool> Prob80Less = new List<bool>();
        List<bool> Prob25More = new List<bool>();
        List<bool> Prob30More = new List<bool>();
        List<bool> Prob35More = new List<bool>();
        List<bool> Prob40More = new List<bool>();
        List<bool> Prob45More = new List<bool>();
        List<bool> Prob50More = new List<bool>();
        List<bool> Prob55More = new List<bool>();
        List<bool> Prob60More = new List<bool>();
        List<bool> Prob65More = new List<bool>();
        List<bool> Prob70More = new List<bool>();
        List<bool> Prob75More = new List<bool>();
        List<bool> Prob80More = new List<bool>();

        List<bool> oProb25Less = new List<bool>();
        List<bool> oProb30Less = new List<bool>();
        List<bool> oProb35Less = new List<bool>();
        List<bool> oProb40Less = new List<bool>();
        List<bool> oProb45Less = new List<bool>();
        List<bool> oProb50Less = new List<bool>();
        List<bool> oProb55Less = new List<bool>();
        List<bool> oProb60Less = new List<bool>();
        List<bool> oProb65Less = new List<bool>();
        List<bool> oProb70Less = new List<bool>();
        List<bool> oProb75Less = new List<bool>();
        List<bool> oProb80Less = new List<bool>();
        List<bool> oProb25More = new List<bool>();
        List<bool> oProb30More = new List<bool>();
        List<bool> oProb35More = new List<bool>();
        List<bool> oProb40More = new List<bool>();
        List<bool> oProb45More = new List<bool>();
        List<bool> oProb50More = new List<bool>();
        List<bool> oProb55More = new List<bool>();
        List<bool> oProb60More = new List<bool>();
        List<bool> oProb65More = new List<bool>();
        List<bool> oProb70More = new List<bool>();
        List<bool> oProb75More = new List<bool>();
        List<bool> oProb80More = new List<bool>();


        //
        #endregion

        public override void Update()
        {

            SpreadResult = (Pt - Pta) + Spread > 0 ? 100 : -100;
            OuResult = (Pt + Pta) > Ou ? 100 : -100;

            if (Pt - Pta > 0)
            {
                ml_result = Ml > 0 ? Ml : 100;
            }
            else
            {
                ml_result = Ml > 0 ? -100 : Ml;
            }


// Calculate cumulators for Season Stats
            int wins = 0, gms = 0, owins = 0, ogms = 0;
            int index = 0, oindex = 0;

            int wstrk = 0, lstrk = 0, hwstrk = 0, hlstrk = 0, awstrk = 0, alstrk = 0;
            int owstrk = 0, olstrk = 0, ohwstrk = 0, ohlstrk = 0, oawstrk = 0, oalstrk = 0;

            double ppg = 0, rypg = 0, pypg = 0, itpg = 0, itfpg = 0;
            double oppg = 0, orypg = 0, opypg = 0, oitpg = 0, oitfpg = 0;

            double winp = 0, owinp = 0;

            for (var i = 0; i < OTEAM.Count; i++)
            {
                if (TEAM[i] == Team)
                {
                    index = i;
                    gms++;
                    ppg += PT[i];
                    rypg += RY[i];
                    pypg += PY[i];
                    itpg += IT[i];
                    itfpg += ITA[i];
                    if (GM_NO[i] == 1)
                    {
                        gms = 1;
                        wins = 0;
                        wstrk = lstrk = hwstrk = hlstrk = awstrk = alstrk = 0;
                        ppg = rypg = pypg = itpg = itfpg = 0;
//reset stuff here
                    }
                    // sum stuff here		
                    if (PT[i] > PTA[i])
                    {
                        wins++;
                        wstrk++;
                        lstrk = 0;
                        if (HOME[i] == 1)
                        {
                            hwstrk++;
                            hlstrk = 0;
                        }
                        if (HOME[i] == 0)
                        {
                            awstrk++;
                            alstrk = 0;
                        }
                    }
                    if (PT[i] < PTA[i])
                    {
                        lstrk++;
                        wstrk = 0;
                        if (HOME[i] == 1)
                        {
                            hwstrk = 0;
                            hlstrk++;
                        }
                        if (HOME[i] == 0)
                        {
                            awstrk = 0;
                            alstrk++;
                        }
                    }
                }
                if (Oteam == TEAM[i] && OgmNo != GM_NO[i])
                {
                    oindex = i;
                    ogms++;
                    oppg += PT[i];
                    orypg += RY[i];
                    opypg += PY[i];
                    oitpg += IT[i];
                    oitfpg += ITA[i];
                    // if opon game == game then dont count it
                    if (OGM_NO[i] == 1)
                    {
                        ogms = 1;
                        owins = 0;
                        oppg = orypg = opypg = oitpg = oitfpg = 0;
                        owstrk = olstrk = ohwstrk = ohlstrk = oawstrk = oalstrk = 0;
                    }
                    if (PT[i] > PTA[i])
                    {
                        owins++;
                        owstrk++;
                        olstrk = 0;
                        if (HOME[i] == 1)
                        {
                            ohwstrk++;
                            ohlstrk = 0;
                        }
                        if (HOME[i] == 0)
                        {
                            oawstrk++;
                            oalstrk = 0;
                        }
                    }
                    if (PT[i] < PTA[i])
                    {
                        olstrk = 0;
                        owstrk = 0;
                        if (HOME[i] == 1)
                        {
                            ohwstrk = 0;
                            ohlstrk++;
                        }
                        if (HOME[i] == 0)
                        {
                            oawstrk = 0;
                            oalstrk++;
                        }
                    }
                }
            }

            if (gms > 0)
            {
                winp = (double) (wins)/(GmNo);
                ppg /= (double) (gms);
                rypg /= (double) (gms);
                pypg /= (double) (gms);
                itpg /= (double) (gms);
                itfpg /= (double) (gms);
            }
            if (ogms > 0)
            {
                owinp = (double) (owins)/(OgmNo);
                oppg /= (double) (ogms);
                orypg /= (double) (ogms);
                opypg /= (double) (ogms);
                oitpg /= (double) (ogms);
                oitfpg /= (double) (ogms);
            }


            _writer.WriteLine(
                string.Join(",", new string[]
                {
                    Date.ToString(), Day, GmNo.ToString(), Team, Div,
                    Oteam, Odiv, OgmNo.ToString(), Home.ToString(),
                    Turf.ToString(), Fav.ToString(), Spread.ToString(), Ou.ToString(), Ml.ToString(), Pt.ToString(),
                    Pta.ToString(), Fd.ToString(), Fda.ToString(), r.ToString(), Ra.ToString(), Ry.ToString(),
                    Rya.ToString(),
                    p.ToString(), Pa.ToString(), Pc.ToString(), Pca.ToString(), Py.ToString(), Pya.ToString(),
                    It.ToString(), Ita.ToString(),
                    winp.ToString(), owinp.ToString(),
                    ppg.ToString(), rypg.ToString(), pypg.ToString(), itpg.ToString(), itfpg.ToString(),
                    oppg.ToString(), orypg.ToString(), opypg.ToString(), oitpg.ToString(), oitfpg.ToString(),
                    index > 0 ? PT[index].ToString() : "0",
                    index > 0 ? RY[index].ToString() : "0",
                    index > 0 ? PY[index].ToString() : 0.ToString(),
                    oindex > 0 ? PT[oindex].ToString() : 0.ToString(),
                    oindex > 0 ? RY[index].ToString() : 0.ToString(),
                    oindex > 0 ? PY[oindex].ToString() : 0.ToString(),
                    wstrk.ToString(), lstrk.ToString(),
                    hwstrk.ToString(), hlstrk.ToString(),
                    awstrk.ToString(), alstrk.ToString(),
                    owstrk.ToString(), olstrk.ToString(),
                    ohwstrk.ToString(), ohlstrk.ToString(),
                    oawstrk.ToString(), oalstrk.ToString()
                }));
//

            double prob = Ml < 0 ? (Ml/(-100 + Ml)*100) : (100/(100 + Ml))*100;
            FavFeatures.Add(Fav == 1);
            UndFeatures.Add(Fav == 0);
            HomeFeatures.Add(Home == 1);
            AwayFeatures.Add(Home == 0);
            WinRecordFeatures.Add(winp > .5);
            LoseRecordFeatures.Add(winp <= .5);
            SprdFav3Less.Add(Spread <= -3);
            SprdFav5Less.Add(Spread <= -5);
            SprdFav7Less.Add(Spread <= -7);
            SprdFav8Less.Add(Spread <= -8);
            SprdFav10Less.Add(Spread <= -10);
            SprdFav12Less.Add(Spread <= -12);
            SprdFav15Less.Add(Spread <= -15);
            SprdFav20Less.Add(Spread <= -20);
            SprdFav3More.Add(Spread >= -3 && Spread < 0);
            SprdFav5More.Add(Spread >= -5 && Spread < 0);
            SprdFav7More.Add(Spread >= -7 && Spread < 0);
            SprdFav8More.Add(Spread >= -8 && Spread < 0);
            SprdFav10More.Add(Spread >= -10 && Spread < 0);
            SprdFav12More.Add(Spread >= -12 && Spread < 0);
            SprdFav15More.Add(Spread >= -15 && Spread < 0);
            SprdFav20More.Add(Spread >= -20 && Spread < 0);
            SprdUnd3Less.Add(Spread > 0 && Spread < 3);
            SprdUnd5Less.Add(Spread > 0 && Spread < 5);
            SprdUnd7Less.Add(Spread > 0 && Spread < 7);
            SprdUnd8Less.Add(Spread > 0 && Spread < 8);
            SprdUnd10Less.Add(Spread > 0 && Spread < 10);
            SprdUnd12Less.Add(Spread > 0 && Spread < 12);
            SprdUnd15Less.Add(Spread > 0 && Spread < 15);
            SprdUnd20Less.Add(Spread > 0 && Spread < 20);
            SprdUnd3More.Add(Spread >= 3);
            SprdUnd5More.Add(Spread >= 5);
            SprdUnd7More.Add(Spread >= 7);
            SprdUnd8More.Add(Spread >= 8);
            SprdUnd10More.Add(Spread >= 10);
            SprdUnd12More.Add(Spread >= 12);
            SprdUnd15More.Add(Spread >= 15);
            SprdUnd20More.Add(Spread >= 20);
            Over30Less.Add(Ou <= 30);
            Over35Less.Add(Ou <= 35);
            Over40Less.Add(Ou <= 40);
            Over45Less.Add(Ou <= 45);
            Over50Less.Add(Ou <= 50);
            Over55Less.Add(Ou <= 55);
            Over60Less.Add(Ou <= 60);
            Over30More.Add(Ou >= 30);
            Over35More.Add(Ou >= 35);
            Over40More.Add(Ou >= 40);
            Over45More.Add(Ou >= 45);
            Over50More.Add(Ou >= 50);
            Over55More.Add(Ou >= 55);
            Over60More.Add(Ou >= 60);
            MLNeg5000Less.Add(Ml <= -5000);
            MLNeg2000Less.Add(Ml <= -2000);
            MLNeg1000Less.Add(Ml <= -1000);
            MLNeg800Less.Add(Ml <= -800);
            MLNeg600Less.Add(Ml <= -600);
            MLNeg500Less.Add(Ml <= -500);
            MLNeg400Less.Add(Ml <= -400);
            MLNeg350Less.Add(Ml <= -350);
            MLNeg300Less.Add(Ml <= -300);
            MLNeg250Less.Add(Ml <= -250);
            MLNeg200Less.Add(Ml <= -200);
            MLNeg150Less.Add(Ml <= -150);
            MLNeg125Less.Add(Ml <= -125);
            MLNeg100Less.Add(Ml <= -100);
            MLPos100Less.Add(Ml <= 100 && Ml >= 0);
            MLPos150Less.Add(Ml <= 150 && Ml >= 0);
            MLPos200Less.Add(Ml <= 200 && Ml >= 0);
            MLPos250Less.Add(Ml <= 250 && Ml >= 0);
            MLPos300Less.Add(Ml <= 300 && Ml >= 0);
            MLPos350Less.Add(Ml <= 350 && Ml >= 0);
            MLPos400Less.Add(Ml <= 400 && Ml >= 0);
            MLPos500Less.Add(Ml <= 500 && Ml >= 0);
            MLPos600Less.Add(Ml <= 600 && Ml >= 0);
            MLPos800Less.Add(Ml <= 800 && Ml >= 0);
            MLPos1000Less.Add(Ml <= 1000 && Ml >= 0);
            MLNeg5000More.Add(Ml >= -5000 && Ml <= 0);
            MLNeg2000More.Add(Ml >= -2000 && Ml <= 0);
            MLNeg1000More.Add(Ml >= -1000 && Ml <= 0);
            MLNeg800More.Add(Ml >= -800 && Ml <= 0);
            MLNeg600More.Add(Ml >= -600 && Ml <= 0);
            MLNeg500More.Add(Ml >= -500 && Ml <= 0);
            MLNeg400More.Add(Ml >= -400 && Ml <= 0);
            MLNeg350More.Add(Ml >= -350 && Ml <= 0);
            MLNeg300More.Add(Ml >= -300 && Ml <= 0);
            MLNeg250More.Add(Ml >= -250 && Ml <= 0);
            MLNeg200More.Add(Ml >= -200 && Ml <= 0);
            MLNeg150More.Add(Ml >= -150 && Ml <= 0);
            MLNeg125More.Add(Ml >= -125 && Ml <= 0);
            MLNeg100More.Add(Ml >= -100 && Ml <= 0);
            MLPos100More.Add(Ml >= 100);
            MLPos150More.Add(Ml >= 150);
            MLPos200More.Add(Ml >= 200);
            MLPos250More.Add(Ml >= 250);
            MLPos300More.Add(Ml >= 300);
            MLPos350More.Add(Ml >= 350);
            MLPos400More.Add(Ml >= 400);
            MLPos500More.Add(Ml >= 500);
            MLPos600More.Add(Ml >= 600);
            MLPos800More.Add(Ml >= 800);
            MLPos1000More.Add(Ml >= 1000);
            PtsLG7Less.Add(PT.Count == 0 || PT[index] <= 7); //lgpt = PT[index]
            PtsLG10Less.Add(PT.Count == 0 || PT[index] <= 10);
            PtsLG13Less.Add(PT.Count == 0 || PT[index] <= 13);
            PtsLG14Less.Add(PT.Count == 0 || PT[index] <= 14);
            PtsLG17Less.Add(PT.Count == 0 || PT[index] <= 17);
            PtsLG21Less.Add(PT.Count == 0 || PT[index] <= 21);
            PtsLG24Less.Add(PT.Count == 0 || PT[index] <= 24);
            PtsLG28Less.Add(PT.Count == 0 || PT[index] <= 28);
            PtsLG31Less.Add(PT.Count == 0 || PT[index] <= 31);
            PtsLG35Less.Add(PT.Count == 0 || PT[index] <= 35);
            PtsLG42Less.Add(PT.Count == 0 || PT[index] <= 42);
            PtsLG49Less.Add(PT.Count == 0 || PT[index] <= 49);
            PtsLG60Less.Add(PT.Count == 0 || PT[index] <= 60);
            PtsLG7More.Add(PT.Count == 0 || PT[index] >= 7);
            PtsLG10More.Add(PT.Count == 0 || PT[index] >= 10);
            PtsLG13More.Add(PT.Count == 0 || PT[index] >= 13);
            PtsLG14More.Add(PT.Count == 0 || PT[index] >= 14);
            PtsLG17More.Add(PT.Count == 0 || PT[index] >= 17);
            PtsLG21More.Add(PT.Count == 0 || PT[index] >= 21);
            PtsLG24More.Add(PT.Count == 0 || PT[index] >= 24);
            PtsLG28More.Add(PT.Count == 0 || PT[index] >= 28);
            PtsLG31More.Add(PT.Count == 0 || PT[index] >= 31);
            PtsLG35More.Add(PT.Count == 0 || PT[index] >= 35);
            PtsLG42More.Add(PT.Count == 0 || PT[index] >= 42);
            PtsLG49More.Add(PT.Count == 0 || PT[index] >= 49);
            PtsLG60More.Add(PT.Count == 0 || PT[index] >= 60);
            oPtsLG7Less.Add(PT.Count == 0 || PT[oindex] <= 7); //olgpt ==PT[oindex]
            oPtsLG10Less.Add(PT.Count == 0 || PT[oindex] <= 10);
            oPtsLG13Less.Add(PT.Count == 0 || PT[oindex] <= 13);
            oPtsLG14Less.Add(PT.Count == 0 || PT[oindex] <= 14);
            oPtsLG17Less.Add(PT.Count == 0 || PT[oindex] <= 17);
            oPtsLG21Less.Add(PT.Count == 0 || PT[oindex] <= 21);
            oPtsLG24Less.Add(PT.Count == 0 || PT[oindex] <= 24);
            oPtsLG28Less.Add(PT.Count == 0 || PT[oindex] <= 28);
            oPtsLG31Less.Add(PT.Count == 0 || PT[oindex] <= 31);
            oPtsLG35Less.Add(PT.Count == 0 || PT[oindex] <= 35);
            oPtsLG42Less.Add(PT.Count == 0 || PT[oindex] <= 42);
            oPtsLG49Less.Add(PT.Count == 0 || PT[oindex] <= 49);
            oPtsLG60Less.Add(PT.Count == 0 || PT[oindex] <= 60);
            oPtsLG7More.Add(PT.Count == 0 || PT[oindex] >= 7);
            oPtsLG10More.Add(PT.Count == 0 || PT[oindex] >= 10);
            oPtsLG13More.Add(PT.Count == 0 || PT[oindex] >= 13);
            oPtsLG14More.Add(PT.Count == 0 || PT[oindex] >= 14);
            oPtsLG17More.Add(PT.Count == 0 || PT[oindex] >= 17);
            oPtsLG21More.Add(PT.Count == 0 || PT[oindex] >= 21);
            oPtsLG24More.Add(PT.Count == 0 || PT[oindex] >= 24);
            oPtsLG28More.Add(PT.Count == 0 || PT[oindex] >= 28);
            oPtsLG31More.Add(PT.Count == 0 || PT[oindex] >= 31);
            oPtsLG35More.Add(PT.Count == 0 || PT[oindex] >= 35);
            oPtsLG42More.Add(PT.Count == 0 || PT[oindex] >= 42);
            oPtsLG49More.Add(PT.Count == 0 || PT[oindex] >= 49);
            oPtsLG60More.Add(PT.Count == 0 || PT[oindex] >= 60);
            YDS150Less.Add(RY.Count == 0 || RY[index] + PY[index] <= 150); //lgry =RY[index]
            YDS200Less.Add(RY.Count == 0 || RY[index] + PY[index] <= 200); //lgpy =PY[index]
            YDS250Less.Add(RY.Count == 0 || RY[index] + PY[index] <= 250);
            YDS300Less.Add(RY.Count == 0 || RY[index] + PY[index] <= 300);
            YDS350Less.Add(RY.Count == 0 || RY[index] + PY[index] <= 350);
            YDS400Less.Add(RY.Count == 0 || RY[index] + PY[index] <= 400);
            YDS450Less.Add(RY.Count == 0 || RY[index] + PY[index] <= 450);
            YDS500Less.Add(RY.Count == 0 || RY[index] + PY[index] <= 500);
            YDS150More.Add(RY.Count == 0 || RY[index] + PY[index] >= 150);
            YDS200More.Add(RY.Count == 0 || RY[index] + PY[index] >= 200);
            YDS250More.Add(RY.Count == 0 || RY[index] + PY[index] >= 250);
            YDS300More.Add(RY.Count == 0 || RY[index] + PY[index] >= 300);
            YDS350More.Add(RY.Count == 0 || RY[index] + PY[index] >= 350);
            YDS400More.Add(RY.Count == 0 || RY[index] + PY[index] >= 400);
            YDS450More.Add(RY.Count == 0 || RY[index] + PY[index] >= 450);
            YDS500More.Add(RY.Count == 0 || RY[index] + PY[index] >= 500);
            oYDS150Less.Add(RY.Count == 0 || RY[index] + PY[oindex] <= 150); //olgry  = RY.Count == 0 || RY[index]
            oYDS200Less.Add(RY.Count == 0 || RY[index] + PY[oindex] <= 200); //olgpy  = PY[oindex]
            oYDS250Less.Add(RY.Count == 0 || RY[index] + PY[oindex] <= 250);
            oYDS300Less.Add(RY.Count == 0 || RY[index] + PY[oindex] <= 300);
            oYDS350Less.Add(RY.Count == 0 || RY[index] + PY[oindex] <= 350);
            oYDS400Less.Add(RY.Count == 0 || RY[index] + PY[oindex] <= 400);
            oYDS450Less.Add(RY.Count == 0 || RY[index] + PY[oindex] <= 450);
            oYDS500Less.Add(RY.Count == 0 || RY[index] + PY[oindex] <= 500);
            oYDS150More.Add(RY.Count == 0 || RY[index] + PY[oindex] >= 150);
            oYDS200More.Add(RY.Count == 0 || RY[index] + PY[oindex] >= 200);
            oYDS250More.Add(RY.Count == 0 || RY[index] + PY[oindex] >= 250);
            oYDS300More.Add(RY.Count == 0 || RY[index] + PY[oindex] >= 300);
            oYDS350More.Add(RY.Count == 0 || RY[index] + PY[oindex] >= 350);
            oYDS400More.Add(RY.Count == 0 || RY[index] + PY[oindex] >= 400);
            oYDS450More.Add(RY.Count == 0 || RY[index] + PY[oindex] >= 450);
            oYDS500More.Add(RY.Count == 0 || RY[index] + PY[oindex] >= 500);
            RYLG50Less.Add(RY.Count == 0 || RY[index] <= 50);
            RYLG75Less.Add(RY.Count == 0 || RY[index] <= 75);
            RYLG100Less.Add(RY.Count == 0 || RY[index] <= 100);
            RYLG125Less.Add(RY.Count == 0 || RY[index] <= 125);
            RYLG200Less.Add(RY.Count == 0 || RY[index] <= 200);
            RYLG250Less.Add(RY.Count == 0 || RY[index] <= 250);
            RYLG300Less.Add(RY.Count == 0 || RY[index] <= 300);
            RYLG350Less.Add(RY.Count == 0 || RY[index] <= 350);
            RYLG50More.Add(RY.Count == 0 || RY[index] >= 50);
            RYLG75More.Add(RY.Count == 0 || RY[index] >= 75);
            RYLG100More.Add(RY.Count == 0 || RY[index] >= 100);
            RYLG125More.Add(RY.Count == 0 || RY[index] >= 125);
            RYLG200More.Add(RY.Count == 0 || RY[index] >= 200);
            RYLG250More.Add(RY.Count == 0 || RY[index] >= 250);
            RYLG300More.Add(RY.Count == 0 || RY[index] >= 300);
            RYLG350More.Add(RY.Count == 0 || RY[index] >= 350);
            oRYLG50Less.Add(RY.Count == 0 || RY[index] <= 50);
            oRYLG75Less.Add(RY.Count == 0 || RY[index] <= 75);
            oRYLG100Less.Add(RY.Count == 0 || RY[index] <= 100);
            oRYLG125Less.Add(RY.Count == 0 || RY[index] <= 125);
            oRYLG200Less.Add(RY.Count == 0 || RY[index] <= 200);
            oRYLG250Less.Add(RY.Count == 0 || RY[index] <= 250);
            oRYLG300Less.Add(RY.Count == 0 || RY[index] <= 300);
            oRYLG350Less.Add(RY.Count == 0 || RY[index] <= 350);
            oRYLG50More.Add(RY.Count == 0 || RY[index] >= 50);
            oRYLG75More.Add(RY.Count == 0 || RY[index] >= 75);
            oRYLG100More.Add(RY.Count == 0 || RY[index] >= 100);
            oRYLG125More.Add(RY.Count == 0 || RY[index] >= 125);
            oRYLG200More.Add(RY.Count == 0 || RY[index] >= 200);
            oRYLG250More.Add(RY.Count == 0 || RY[index] >= 250);
            oRYLG300More.Add(RY.Count == 0 || RY[index] >= 300);
            oRYLG350More.Add(RY.Count == 0 || RY[index] >= 350);
            PYLG50Less.Add(PY.Count == 0 || PY[index] <= 50);
            PYLG100Less.Add(PY.Count == 0 || PY[index] <= 100);
            PYLG125Less.Add(PY.Count == 0 || PY[index] <= 125);
            PYLG150Less.Add(PY.Count == 0 || PY[index] <= 150);
            PYLG200Less.Add(PY.Count == 0 || PY[index] <= 200);
            PYLG250Less.Add(PY.Count == 0 || PY[index] <= 250);
            PYLG300Less.Add(PY.Count == 0 || PY[index] <= 300);
            PYLG350Less.Add(PY.Count == 0 || PY[index] <= 350);
            PYLG400Less.Add(PY.Count == 0 || PY[index] <= 400);
            PYLG500Less.Add(PY.Count == 0 || PY[index] <= 500);
            PYLG50More.Add(PY.Count == 0 || PY[index] >= 50);
            PYLG100More.Add(PY.Count == 0 || PY[index] >= 100);
            PYLG125More.Add(PY.Count == 0 || PY[index] >= 125);
            PYLG150More.Add(PY.Count == 0 || PY[index] >= 150);
            PYLG200More.Add(PY.Count == 0 || PY[index] >= 200);
            PYLG250More.Add(PY.Count == 0 || PY[index] >= 250);
            PYLG300More.Add(PY.Count == 0 || PY[index] >= 300);
            PYLG350More.Add(PY.Count == 0 || PY[index] >= 350);
            PYLG400More.Add(PY.Count == 0 || PY[index] >= 400);
            PYLG500More.Add(PY.Count == 0 || PY[index] >= 500);
            oPYLG50Less.Add(PY.Count == 0 || PY[oindex] <= 50);
            oPYLG100Less.Add(PY.Count == 0 || PY[oindex] <= 100);
            oPYLG125Less.Add(PY.Count == 0 || PY[oindex] <= 125);
            oPYLG150Less.Add(PY.Count == 0 || PY[oindex] <= 150);
            oPYLG200Less.Add(PY.Count == 0 || PY[oindex] <= 200);
            oPYLG250Less.Add(PY.Count == 0 || PY[oindex] <= 250);
            oPYLG300Less.Add(PY.Count == 0 || PY[oindex] <= 300);
            oPYLG350Less.Add(PY.Count == 0 || PY[oindex] <= 350);
            oPYLG400Less.Add(PY.Count == 0 || PY[oindex] <= 400);
            oPYLG500Less.Add(PY.Count == 0 || PY[oindex] <= 500);
            oPYLG50More.Add(PY.Count == 0 || PY[oindex] >= 50);
            oPYLG100More.Add(PY.Count == 0 || PY[oindex] >= 100);
            oPYLG125More.Add(PY.Count == 0 || PY[oindex] >= 125);
            oPYLG150More.Add(PY.Count == 0 || PY[oindex] >= 150);
            oPYLG200More.Add(PY.Count == 0 || PY[oindex] >= 200);
            oPYLG250More.Add(PY.Count == 0 || PY[oindex] >= 250);
            oPYLG300More.Add(PY.Count == 0 || PY[oindex] >= 300);
            oPYLG350More.Add(PY.Count == 0 || PY[oindex] >= 350);
            oPYLG400More.Add(PY.Count == 0 || PY[oindex] >= 400);
            oPYLG500More.Add(PY.Count == 0 || PY[oindex] >= 500);
            winP25Less.Add(winp <= .25);
            winP33Less.Add(winp <= .33);
            winP40Less.Add(winp <= .40);
            winP45Less.Add(winp <= .45);
            winP50Less.Add(winp <= .50);
            winP55Less.Add(winp <= .55);
            winP60Less.Add(winp <= .60);
            winP65Less.Add(winp <= .65);
            winP75Less.Add(winp <= .75);
            winP80Less.Add(winp <= .80);
            winP25More.Add(winp >= .25);
            winP33More.Add(winp >= .33);
            winP40More.Add(winp >= .40);
            winP45More.Add(winp >= .45);
            winP50More.Add(winp >= .50);
            winP55More.Add(winp >= .55);
            winP60More.Add(winp >= .60);
            winP65More.Add(winp >= .65);
            winP75More.Add(winp >= .75);
            winP80More.Add(winp >= .80);
            owinP25Less.Add(owinp <= .25);
            owinP33Less.Add(owinp <= .33);
            owinP40Less.Add(owinp <= .40);
            owinP45Less.Add(owinp <= .45);
            owinP50Less.Add(owinp <= .50);
            owinP55Less.Add(owinp <= .55);
            owinP60Less.Add(owinp <= .60);
            owinP65Less.Add(owinp <= .65);
            owinP75Less.Add(owinp <= .75);
            owinP80Less.Add(owinp <= .80);
            owinP25More.Add(owinp >= .25);
            owinP33More.Add(owinp >= .33);
            owinP40More.Add(owinp >= .40);
            owinP45More.Add(owinp >= .45);
            owinP50More.Add(owinp >= .50);
            owinP55More.Add(owinp >= .55);
            owinP60More.Add(owinp >= .60);
            owinP65More.Add(owinp >= .65);
            owinP75More.Add(owinp >= .75);
            owinP80More.Add(owinp >= .80);
            PPG10Less.Add(ppg <= 10);
            PPG13Less.Add(ppg <= 13);
            PPG15Less.Add(ppg <= 15);
            PPG17Less.Add(ppg <= 17);
            PPG20Less.Add(ppg <= 20);
            PPG22Less.Add(ppg <= 22);
            PPG24Less.Add(ppg <= 24);
            PPG28Less.Add(ppg <= 28);
            PPG30Less.Add(ppg <= 30);
            PPG35Less.Add(ppg <= 35);
            PPG10More.Add(ppg >= 10);
            PPG13More.Add(ppg >= 13);
            PPG15More.Add(ppg >= 15);
            PPG17More.Add(ppg >= 17);
            PPG20More.Add(ppg >= 20);
            PPG22More.Add(ppg >= 22);
            PPG24More.Add(ppg >= 24);
            PPG28More.Add(ppg >= 28);
            PPG30More.Add(ppg >= 30);
            PPG35More.Add(ppg >= 35);
            oPPG10Less.Add(oppg <= 10);
            oPPG13Less.Add(oppg <= 13);
            oPPG15Less.Add(oppg <= 15);
            oPPG17Less.Add(oppg <= 17);
            oPPG20Less.Add(oppg <= 20);
            oPPG22Less.Add(oppg <= 22);
            oPPG24Less.Add(oppg <= 24);
            oPPG28Less.Add(oppg <= 28);
            oPPG30Less.Add(oppg <= 30);
            oPPG35Less.Add(oppg <= 35);
            oPPG10More.Add(oppg >= 10);
            oPPG13More.Add(oppg >= 13);
            oPPG15More.Add(oppg >= 15);
            oPPG17More.Add(oppg >= 17);
            oPPG20More.Add(oppg >= 20);
            oPPG22More.Add(oppg >= 22);
            oPPG24More.Add(oppg >= 24);
            oPPG28More.Add(oppg >= 28);
            oPPG30More.Add(oppg >= 30);
            oPPG35More.Add(oppg >= 35);
            YDSPG250Less.Add(rypg + pypg <= 250);
            YDSPG300Less.Add(rypg + pypg <= 300);
            YDSPG350Less.Add(rypg + pypg <= 350);
            YDSPG400Less.Add(rypg + pypg <= 400);
            YDSPG450Less.Add(rypg + pypg <= 450);
            YDSPG250More.Add(rypg + pypg >= 250);
            YDSPG300More.Add(rypg + pypg >= 300);
            YDSPG350More.Add(rypg + pypg >= 350);
            YDSPG400More.Add(rypg + pypg >= 400);
            YDSPG450More.Add(rypg + pypg >= 450);
            oYDSPG250Less.Add(orypg + opypg <= 250);
            oYDSPG300Less.Add(orypg + opypg <= 300);
            oYDSPG350Less.Add(orypg + opypg <= 350);
            oYDSPG400Less.Add(orypg + opypg <= 400);
            oYDSPG450Less.Add(orypg + opypg <= 450);
            oYDSPG250More.Add(orypg + opypg >= 250);
            oYDSPG300More.Add(orypg + opypg >= 300);
            oYDSPG350More.Add(orypg + opypg >= 350);
            oYDSPG400More.Add(orypg + opypg >= 400);
            oYDSPG450More.Add(orypg + opypg >= 450);
            RYPG70Less.Add(rypg <= 70);
            RYPG80Less.Add(rypg <= 80);
            RYPG90Less.Add(rypg <= 90);
            RYPG100Less.Add(rypg <= 100);
            RYPG110Less.Add(rypg <= 110);
            RYPG120Less.Add(rypg <= 120);
            RYPG130Less.Add(rypg <= 130);
            RYPG140Less.Add(rypg <= 140);
            RYPG150Less.Add(rypg <= 150);
            RYPG160Less.Add(rypg <= 160);
            RYPG170Less.Add(rypg <= 170);
            RYPG180Less.Add(rypg <= 180);
            RYPG70More.Add(rypg >= 70);
            RYPG80More.Add(rypg >= 80);
            RYPG90More.Add(rypg >= 90);
            RYPG100More.Add(rypg >= 100);
            RYPG110More.Add(rypg >= 110);
            RYPG120More.Add(rypg >= 120);
            RYPG130More.Add(rypg >= 130);
            RYPG140More.Add(rypg >= 140);
            RYPG150More.Add(rypg >= 150);
            RYPG160More.Add(rypg >= 160);
            RYPG170More.Add(rypg >= 170);
            RYPG180More.Add(rypg >= 180);
            oRYPG70Less.Add(orypg <= 70);
            oRYPG80Less.Add(orypg <= 80);
            oRYPG90Less.Add(orypg <= 90);
            oRYPG100Less.Add(orypg <= 100);
            oRYPG110Less.Add(orypg <= 110);
            oRYPG120Less.Add(orypg <= 120);
            oRYPG130Less.Add(orypg <= 130);
            oRYPG140Less.Add(orypg <= 140);
            oRYPG150Less.Add(orypg <= 150);
            oRYPG160Less.Add(orypg <= 160);
            oRYPG170Less.Add(orypg <= 170);
            oRYPG180Less.Add(orypg <= 180);
            oRYPG70More.Add(orypg >= 70);
            oRYPG80More.Add(orypg >= 80);
            oRYPG90More.Add(orypg >= 90);
            oRYPG100More.Add(orypg >= 100);
            oRYPG110More.Add(orypg >= 110);
            oRYPG120More.Add(orypg >= 120);
            oRYPG130More.Add(orypg >= 130);
            oRYPG140More.Add(orypg >= 140);
            oRYPG150More.Add(orypg >= 150);
            oRYPG160More.Add(orypg >= 160);
            oRYPG170More.Add(orypg >= 170);
            oRYPG180More.Add(orypg >= 180);
            PYPG150Less.Add(pypg <= 150);
            PYPG175Less.Add(pypg <= 175);
            PYPG200Less.Add(pypg <= 200);
            PYPG225Less.Add(pypg <= 225);
            PYPG250Less.Add(pypg <= 250);
            PYPG275Less.Add(pypg <= 275);
            PYPG300Less.Add(pypg <= 300);
            PYPG350Less.Add(pypg <= 350);
            PYPG150More.Add(pypg >= 150);
            PYPG175More.Add(pypg >= 175);
            PYPG200More.Add(pypg >= 200);
            PYPG225More.Add(pypg >= 225);
            PYPG250More.Add(pypg >= 250);
            PYPG275More.Add(pypg >= 275);
            PYPG300More.Add(pypg >= 300);
            PYPG350More.Add(pypg >= 350);
            oPYPG150Less.Add(opypg <= 150);
            oPYPG175Less.Add(opypg <= 175);
            oPYPG200Less.Add(opypg <= 200);
            oPYPG225Less.Add(opypg <= 225);
            oPYPG250Less.Add(opypg <= 250);
            oPYPG275Less.Add(opypg <= 275);
            oPYPG300Less.Add(opypg <= 300);
            oPYPG350Less.Add(opypg <= 350);
            oPYPG150More.Add(opypg >= 150);
            oPYPG175More.Add(opypg >= 175);
            oPYPG200More.Add(opypg >= 200);
            oPYPG225More.Add(opypg >= 225);
            oPYPG250More.Add(opypg >= 250);
            oPYPG275More.Add(opypg >= 275);
            oPYPG300More.Add(opypg >= 300);
            oPYPG350More.Add(opypg >= 350);
            WStrk2.Add(wstrk >= 2);
            WStrk3.Add(wstrk >= 3);
            WStrk4.Add(wstrk >= 4);
            WStrk5.Add(wstrk >= 5);
            WStrk6.Add(wstrk >= 6);
            WStrk7.Add(wstrk >= 7);
            WStrk10.Add(wstrk >= 10);
            WStrk12.Add(wstrk >= 12);
            LStrk2.Add(lstrk >= 2);
            LStrk3.Add(lstrk >= 3);
            LStrk4.Add(lstrk >= 4);
            LStrk5.Add(lstrk >= 5);
            LStrk6.Add(lstrk >= 6);
            LStrk7.Add(lstrk >= 7);
            LStrk10.Add(lstrk >= 10);
            LStrk12.Add(lstrk >= 12);
            homeWStrk2.Add(hwstrk >= 2);
            homeWStrk3.Add(hwstrk >= 3);
            homeWStrk4.Add(hwstrk >= 4);
            homeWStrk5.Add(hwstrk >= 5);
            homeWStrk6.Add(hwstrk >= 6);
            homeWStrk7.Add(hwstrk >= 7);
            homeWStrk10.Add(hwstrk >= 10);
            homeWStrk12.Add(hwstrk >= 12);
            homeLStrk2.Add(hlstrk >= 2);
            homeLStrk3.Add(hlstrk >= 3);
            homeLStrk4.Add(hlstrk >= 4);
            homeLStrk5.Add(hlstrk >= 5);
            homeLStrk6.Add(hlstrk >= 6);
            homeLStrk7.Add(hlstrk >= 7);
            homeLStrk10.Add(hlstrk >= 10);
            homeLStrk12.Add(hlstrk >= 12);
            awayWStrk2.Add(awstrk >= 2);
            awayWStrk3.Add(awstrk >= 3);
            awayWStrk4.Add(awstrk >= 4);
            awayWStrk5.Add(awstrk >= 5);
            awayWStrk6.Add(awstrk >= 6);
            awayWStrk7.Add(awstrk >= 7);
            awayWStrk10.Add(awstrk >= 10);
            awayWStrk12.Add(awstrk >= 12);
            awayLStrk2.Add(alstrk >= 2);
            awayLStrk3.Add(alstrk >= 3);
            awayLStrk4.Add(alstrk >= 4);
            awayLStrk5.Add(alstrk >= 5);
            awayLStrk6.Add(alstrk >= 6);
            awayLStrk7.Add(alstrk >= 7);
            awayLStrk10.Add(alstrk >= 10);
            awayLStrk12.Add(alstrk >= 12);
            oWStrk2.Add(owstrk >= 2);
            oWStrk3.Add(owstrk >= 3);
            oWStrk4.Add(owstrk >= 4);
            oWStrk5.Add(owstrk >= 5);
            oWStrk6.Add(owstrk >= 6);
            oWStrk7.Add(owstrk >= 7);
            oWStrk10.Add(owstrk >= 10);
            oWStrk12.Add(owstrk >= 12);
            oLStrk2.Add(olstrk >= 2);
            oLStrk3.Add(olstrk >= 3);
            oLStrk4.Add(olstrk >= 4);
            oLStrk5.Add(olstrk >= 5);
            oLStrk6.Add(olstrk >= 6);
            oLStrk7.Add(olstrk >= 7);
            oLStrk10.Add(olstrk >= 10);
            oLStrk12.Add(olstrk >= 12);
            ohomeWStrk2.Add(ohwstrk >= 2);
            ohomeWStrk3.Add(ohwstrk >= 3);
            ohomeWStrk4.Add(ohwstrk >= 4);
            ohomeWStrk5.Add(ohwstrk >= 5);
            ohomeWStrk6.Add(ohwstrk >= 6);
            ohomeWStrk7.Add(ohwstrk >= 7);
            ohomeWStrk10.Add(ohwstrk >= 10);
            ohomeWStrk12.Add(ohwstrk >= 12);
            ohomeLStrk2.Add(ohlstrk >= 2);
            ohomeLStrk3.Add(ohlstrk >= 3);
            ohomeLStrk4.Add(ohlstrk >= 4);
            ohomeLStrk5.Add(ohlstrk >= 5);
            ohomeLStrk6.Add(ohlstrk >= 6);
            ohomeLStrk7.Add(ohlstrk >= 7);
            ohomeLStrk10.Add(ohlstrk >= 10);
            ohomeLStrk12.Add(ohlstrk >= 12);
            oawayWStrk2.Add(oawstrk >= 2);
            oawayWStrk3.Add(oawstrk >= 3);
            oawayWStrk4.Add(oawstrk >= 4);
            oawayWStrk5.Add(oawstrk >= 5);
            oawayWStrk6.Add(oawstrk >= 6);
            oawayWStrk7.Add(oawstrk >= 7);
            oawayWStrk10.Add(oawstrk >= 10);
            oawayWStrk12.Add(oawstrk >= 12);
            oawayLStrk2.Add(oalstrk >= 2);
            oawayLStrk3.Add(oalstrk >= 3);
            oawayLStrk4.Add(oalstrk >= 4);
            oawayLStrk5.Add(oalstrk >= 5);
            oawayLStrk6.Add(oalstrk >= 6);
            oawayLStrk7.Add(oalstrk >= 7);
            oawayLStrk10.Add(oalstrk >= 10);
            oawayLStrk12.Add(oalstrk >= 12);
            Gms2Less.Add(GmNo <= 2);
            Gms4Less.Add(GmNo <= 4);
            Gms6Less.Add(GmNo <= 6);
            Gms8Less.Add(GmNo <= 8);
            Gms10Less.Add(GmNo <= 10);
            Gms12Less.Add(GmNo <= 12);
            Gms2More.Add(GmNo >= 2);
            Gms4More.Add(GmNo >= 4);
            Gms6More.Add(GmNo >= 6);
            Gms8More.Add(GmNo >= 8);
            Gms10More.Add(GmNo >= 10);
            Gms12More.Add(GmNo >= 12);
            Wins2Less.Add((int) (winp*GmNo) <= 2);
            Wins4Less.Add((int) (winp*GmNo) <= 4);
            Wins6Less.Add((int) (winp*GmNo) <= 6);
            Wins8Less.Add((int) (winp*GmNo) <= 8);
            Wins10Less.Add((int) (winp*GmNo) <= 10);
            Wins12Less.Add((int) (winp*GmNo) <= 12);
            Wins2More.Add((int) (winp*GmNo) >= 2);
            Wins4More.Add((int) (winp*GmNo) >= 4);
            Wins6More.Add((int) (winp*GmNo) >= 6);
            Wins8More.Add((int) (winp*GmNo) >= 8);
            Wins10More.Add((int) (winp*GmNo) >= 10);
            Wins12More.Add((int) (winp*GmNo) >= 12);
            oWins2Less.Add((int) (owinp*OgmNo) <= 2);
            oWins4Less.Add((int) (owinp*OgmNo) <= 4);
            oWins6Less.Add((int) (owinp*OgmNo) <= 6);
            oWins8Less.Add((int) (owinp*OgmNo) <= 8);
            oWins10Less.Add((int) (owinp*OgmNo) <= 10);
            oWins12Less.Add((int) (owinp*OgmNo) <= 12);
            oWins2More.Add((int) (owinp*OgmNo) >= 2);
            oWins4More.Add((int) (owinp*OgmNo) >= 4);
            oWins6More.Add((int) (owinp*OgmNo) >= 6);
            oWins8More.Add((int) (owinp*OgmNo) >= 8);
            oWins10More.Add((int) (owinp*OgmNo) >= 10);
            oWins12More.Add((int) (owinp*OgmNo) >= 12);
            Thu.Add(Day == "Th");
            Sat.Add(Day == "Sat");
            Sun.Add(Day == "Sun");
            Mon.Add(Day == "Mon");
            NotSun.Add(Day != "Sun");
            Grass.Add(Turf == 0);
            TurfFeature.Add(Turf == 1);
            Prob25Less.Add(prob <= 25);
            Prob30Less.Add(prob <= 30);
            Prob35Less.Add(prob <= 35);
            Prob40Less.Add(prob <= 40);
            Prob45Less.Add(prob <= 45);
            Prob50Less.Add(prob <= 50);
            Prob55Less.Add(prob <= 55);
            Prob60Less.Add(prob <= 60);
            Prob65Less.Add(prob <= 65);
            Prob70Less.Add(prob <= 70);
            Prob75Less.Add(prob <= 75);
            Prob80Less.Add(prob <= 80);
            Prob25More.Add(prob >= 25);
            Prob30More.Add(prob >= 30);
            Prob35More.Add(prob >= 35);
            Prob40More.Add(prob >= 40);
            Prob45More.Add(prob >= 45);
            Prob50More.Add(prob >= 50);
            Prob55More.Add(prob >= 55);
            Prob60More.Add(prob >= 60);
            Prob65More.Add(prob >= 65);
            Prob70More.Add(prob >= 70);
            Prob75More.Add(prob >= 75);
            Prob80More.Add(prob >= 80);
            oProb25Less.Add(1 - prob <= 25);
            oProb30Less.Add(1 - prob <= 30);
            oProb35Less.Add(1 - prob <= 35);
            oProb40Less.Add(1 - prob <= 40);
            oProb45Less.Add(1 - prob <= 45);
            oProb50Less.Add(1 - prob <= 50);
            oProb55Less.Add(1 - prob <= 55);
            oProb60Less.Add(1 - prob <= 60);
            oProb65Less.Add(1 - prob <= 65);
            oProb70Less.Add(1 - prob <= 70);
            oProb75Less.Add(1 - prob <= 75);
            oProb80Less.Add(1 - prob <= 80);
            oProb25More.Add(1 - prob >= 25);
            oProb30More.Add(1 - prob >= 30);
            oProb35More.Add(1 - prob >= 35);
            oProb40More.Add(1 - prob >= 40);
            oProb45More.Add(1 - prob >= 45);
            oProb50More.Add(1 - prob >= 50);
            oProb55More.Add(1 - prob >= 55);
            oProb60More.Add(1 - prob >= 60);
            oProb65More.Add(1 - prob >= 65);
            oProb70More.Add(1 - prob >= 70);
            oProb75More.Add(1 - prob >= 75);
            oProb80More.Add(1 - prob >= 80);
            // Push Everything Back
            DATE.Add(Date);
            GM_NO.Add(GmNo);
            OGM_NO.Add(OgmNo);
            TEAM.Add(Team);
            DIV.Add(Div);
            OTEAM.Add(Oteam);
            ODIV.Add(Odiv);
            HOME.Add(Home);
            TURF.Add(Turf);
            FAV.Add(Fav);
            DAY.Add(Day);
            SPREAD.Add(Spread);
            OU.Add(Ou);
            ML.Add(Ml);
            PT.Add(Pt);
            PTA.Add(Pta);
            FD.Add(Fd);
            FDA.Add(Fda);
            R.Add(r);
            RA.Add(Ra);
            RY.Add(Ry);
            RYA.Add(Rya);
            P.Add(p);
            PA.Add(Pa);
            PC.Add(Pc);
            PCA.Add(Pca);
            PY.Add(Py);
            PYA.Add(Pya);
            IT.Add(It);
            ITA.Add(Ita);

            ComposeValues();

        }

        private void ComposeValues()
        {

            StringBuilder sb = new StringBuilder();
            //sb.AppendLine(
            //    "Favorite,Underdog,Home,Away,Winning Record,Losing Record,Spread -3 or More,Spread -5 or More,Spread -7 or More,Spread -8 or More,Spread -10 or More,Spread -12 or More,Spread -15 or More,Spread -20 or More,Spread -3 or Less,Spread -5 or Less,Spread -7 or Less,Spread -8 or Less,Spread -10 or Less,Spread -12 or Less,Spread -15 or Less,Spread -20 or Less,Spread +3 or Less,Spread +5 or Less,Spread +7 or Less,Spread +8 or Less,Spread +10 or Less,Spread +12 or Less,Spread +15 or Less,Spread +20 or Less,Spread +3 or More,Spread +5 or More,Spread +7 or More,Spread +8 or More,Spread +10 or More,Spread +12 or More,Spread +15 or More,Spread +20 or More,OU Total <= 30,OU Total <= 35,OU Total <= 40,OU Total <= 45,OU Total <= 50,OU Total <= 55,OU Total <= 60,OU Total >= 30,OU Total >= 35,OU Total >= 40,OU Total >= 45,OU Total >= 50,OU Total >= 55,OU Total >= 60,MoneyLine -5000 or More,MoneyLine -2000 or More,MoneyLine -1000 or More,MoneyLine -800 or More,MoneyLine -600 or More,MoneyLine -500 or More,MoneyLine -400 or More,MoneyLine -350 or More,MoneyLine -300 or More,MoneyLine -250 or More,MoneyLine -200 or More,MoneyLine -150 or More,MoneyLine -125 or More,MoneyLine -100 or More,MoneyLine +100 or Less,MoneyLine +150 or Less,MoneyLine +200 or Less,MoneyLine +250 or Less,MoneyLine +300 or Less,MoneyLine +350 or Less,MoneyLine +400 or Less,MoneyLine +500 or Less,MoneyLine +600 or Less,MoneyLine +800 or Less,MoneyLine +1000 or Less,MoneyLine -5000 or Less,MoneyLine -2000 or Less,MoneyLine -1000 or Less,MoneyLine -800 or Less,MoneyLine -600 or Less,MoneyLine -500 or Less,MoneyLine -400 or Less,MoneyLine -350 or Less,MoneyLine -300 or Less,MoneyLine -250 or Less,MoneyLine -200 or Less,MoneyLine -150 or Less,MoneyLine -125 or Less,MoneyLine -100 or Less,MoneyLine -100 or More,MoneyLine -150 or More,MoneyLine -200 or More,MoneyLine -250 or More,MoneyLine -300 or More,MoneyLine -350 or More,MoneyLine -400 or More,MoneyLine -500 or More,MoneyLine -600 or More,MoneyLine -800 or More,MoneyLine -1000 or More,Pts Last gm 7 or Less,Pts Last gm 10 or Less,Pts Last gm 13 or Less,Pts Last gm 14 or Less,Pts Last gm 17 or Less,Pts Last gm 21 or Less,Pts Last gm 24 or Less,Pts Last gm 28 or Less,Pts Last gm 31 or Less,Pts Last gm 35 or Less,Pts Last gm 42 or Less,Pts Last gm 49 or Less,Pts Last gm 60 or Less,Pts Last gm 7 or More,Pts Last gm 10 or More,Pts Last gm 13 or More,Pts Last gm 14 or More,Pts Last gm 17 or More,Pts Last gm 21 or More,Pts Last gm 24 or More,Pts Last gm 28 or More,Pts Last gm 31 or More,Pts Last gm 35 or More,Pts Last gm 42 or More,Pts Last gm 49 or More,Pts Last gm 60 or More,Opp Pts Last gm 7 or Less,Opp Pts Last gm 10 or Less,Opp Pts Last gm 13 or Less,Opp Pts Last gm 14 or Less,Opp Pts Last gm 17 or Less,Opp Pts Last gm 21 or Less,Opp Pts Last gm 24 or Less,Opp Pts Last gm 28 or Less,Opp Pts Last gm 31 or Less,Opp Pts Last gm 35 or Less,Opp Pts Last gm 42 or Less,Opp Pts Last gm 49 or Less,Opp Pts Last gm 60 or Less,Opp Pts Last gm 7 or More,Opp Pts Last gm 10 or More,Opp Pts Last gm 13 or More,Opp Pts Last gm 14 or More,Opp Pts Last gm 17 or More,Opp Pts Last gm 21 or More,Opp Pts Last gm 24 or More,Opp Pts Last gm 28 or More,Opp Pts Last gm 31 or More,Opp Pts Last gm 35 or More,Opp Pts Last gm 42 or More,Opp Pts Last gm 49 or More,Opp Pts Last gm 60 or More,Yards Last gm 150 or Less,Yards Last gm 200 or Less,Yards Last gm 250 or Less,Yards Last gm 300 or Less,Yards Last gm 350 or Less,Yards Last gm 400 or Less,Yards Last gm 450 or Less,Yards Last gm 500 or Less,Yards Last gm 150 or More,Yards Last gm 200 or More,Yards Last gm 250 or More,Yards Last gm 300 or More,Yards Last gm 350 or More,Yards Last gm 400 or More,Yards Last gm 450 or More,Yards Last gm 500 or More,Opp Yards Last gm 150 or Less,Opp Yards Last gm 200 or Less,Opp Yards Last gm 250 or Less,Opp Yards Last gm 300 or Less,Opp Yards Last gm 350 or Less,Opp Yards Last gm 400 or Less,Opp Yards Last gm 450 or Less,Opp Yards Last gm 500 or Less,Opp Yards Last gm 150 or More,Opp Yards Last gm 200 or More,Opp Yards Last gm 250 or More,Opp Yards Last gm 300 or More,Opp Yards Last gm 350 or More,Opp Yards Last gm 400 or More,Opp Yards Last gm 450 or More,Opp Yards Last gm 500 or More,Rush Yards Last gm 50 or Less,Rush Yards Last gm 75 or Less,Rush Yards Last gm 100 or Less,Rush Yards Last gm 125 or Less,Rush Yards Last gm 200 or Less,Rush Yards Last gm 250 or Less,Rush Yards Last gm 300 or Less,Rush Yards Last gm 350 or Less,Rush Yards Last gm 50 or More,Rush Yards Last gm 75 or More,Rush Yards Last gm 100 or More,Rush Yards Last gm 125 or More,Rush Yards Last gm 200 or More,Rush Yards Last gm 250 or More,Rush Yards Last gm 300 or More,Rush Yards Last gm 350 or More,Opp Rush Yards Last gm 50 or Less,Opp Rush Yards Last gm 75 or Less,Opp Rush Yards Last gm 100 or Less,Opp Rush Yards Last gm 125 or Less,Opp Rush Yards Last gm 200 or Less,Opp Rush Yards Last gm 250 or Less,Opp Rush Yards Last gm 300 or Less,Opp Rush Yards Last gm 350 or Less,Opp Rush Yards Last gm 50 or More,Opp Rush Yards Last gm 75 or More,Opp Rush Yards Last gm 100 or More,Opp Rush Yards Last gm 125 or More,Opp Rush Yards Last gm 200 or More,Opp Rush Yards Last gm 250 or More,Opp Rush Yards Last gm 300 or More,Opp Rush Yards Last gm 350 or More,Pass Yards Last gm 50 or Less,Pass Yards Last gm 100 or Less,Pass Yards Last gm 125 or Less,Pass Yards Last gm 150 or Less,Pass Yards Last gm 200 or Less,Pass Yards Last gm 250 or Less,Pass Yards Last gm 300 or Less,Pass Yards Last gm 350 or Less,Pass Yards Last gm 400 or Less,Pass Yards Last gm 500 or Less,Pass Yards Last gm 50 or More,Pass Yards Last gm 100 or More,Pass Yards Last gm 125 or More,Pass Yards Last gm 150 or More,Pass Yards Last gm 200 or More,Pass Yards Last gm 250 or More,Pass Yards Last gm 300 or More,Pass Yards Last gm 350 or More,Pass Yards Last gm 400 or More,Pass Yards Last gm 500 or More,Opp Pass Yards Last gm 50 or Less,Opp Pass Yards Last gm 100 or Less,Opp Pass Yards Last gm 125 or Less,Opp Pass Yards Last gm 150 or Less,Opp Pass Yards Last gm 200 or Less,Opp Pass Yards Last gm 250 or Less,Opp Pass Yards Last gm 300 or Less,Opp Pass Yards Last gm 350 or Less,Opp Pass Yards Last gm 400 or Less,Opp Pass Yards Last gm 500 or Less,Opp Pass Yards Last gm 50 or More,Opp Pass Yards Last gm 100 or More,Opp Pass Yards Last gm 125 or More,Opp Pass Yards Last gm 150 or More,Opp Pass Yards Last gm 200 or More,Opp Pass Yards Last gm 250 or More,Opp Pass Yards Last gm 300 or More,Opp Pass Yards Last gm 350 or More,Opp Pass Yards Last gm 400 or More,Opp Pass Yards Last gm 500 or More,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 75% or Less,Winning Perc 80% or Less,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 75% or More,Winning Perc 80% or More,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 75% or Less,Opp Winning Perc 80% or Less,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 75% or More,Opp Winning Perc 80% or More,Points Per Gm 10 or Less,Points Per Gm 13 or Less,Points Per Gm 15 or Less,Points Per Gm 17 or Less,Points Per Gm 20 or Less,Points Per Gm 22 or Less,Points Per Gm 24 or Less,Points Per Gm 28 or Less,Points Per Gm 30 or Less,Points Per Gm 35 or Less,Points Per Gm 10 or More,Points Per Gm 13 or More,Points Per Gm 15 or More,Points Per Gm 17 or More,Points Per Gm 20 or More,Points Per Gm 22 or More,Points Per Gm 24 or More,Points Per Gm 28 or More,Points Per Gm 30 or More,Points Per Gm 35 or More,Opp Points Per Gm 10 or Less,Opp Points Per Gm 13 or Less,Opp Points Per Gm 15 or Less,Opp Points Per Gm 17 or Less,Opp Points Per Gm 20 or Less,Opp Points Per Gm 22 or Less,Opp Points Per Gm 24 or Less,Opp Points Per Gm 28 or Less,Opp Points Per Gm 30 or Less,Opp Points Per Gm 35 or Less,Opp Points Per Gm 10 or More,Opp Points Per Gm 13 or More,Opp Points Per Gm 15 or More,Opp Points Per Gm 17 or More,Opp Points Per Gm 20 or More,Opp Points Per Gm 22 or More,Opp Points Per Gm 24 or More,Opp Points Per Gm 28 or More,Opp Points Per Gm 30 or More,Opp Points Per Gm 35 or More,Yards Per Gm 250 or Less,Yards Per Gm 300 or Less,Yards Per Gm 350 or Less,Yards Per Gm 400 or Less,Yards Per Gm 450 or Less,Yards Per Gm 250 or More,Yards Per Gm 300 or More,Yards Per Gm 350 or More,Yards Per Gm 400 or More,Yards Per Gm 450 or More,Opp Yards Per Gm 250 or Less,Opp Yards Per Gm 300 or Less,Opp Yards Per Gm 350 or Less,Opp Yards Per Gm 400 or Less,Opp Yards Per Gm 450 or Less,Opp Yards Per Gm 250 or More,Opp Yards Per Gm 300 or More,Opp Yards Per Gm 350 or More,Opp Yards Per Gm 400 or More,Opp Yards Per Gm 450 or More,Rush Yards Per Gm 70 or Less,Rush Yards Per Gm 80 or Less,Rush Yards Per Gm 90 or Less,Rush Yards Per Gm 100 or Less,Rush Yards Per Gm 110 or Less,Rush Yards Per Gm 120 or Less,Rush Yards Per Gm 130 or Less,Rush Yards Per Gm 140 or Less,Rush Yards Per Gm 150 or Less,Rush Yards Per Gm 160 or Less,Rush Yards Per Gm 170 or Less,Rush Yards Per Gm 180 or Less,Rush Yards Per Gm 70 or More,Rush Yards Per Gm 80 or More,Rush Yards Per Gm 90 or More,Rush Yards Per Gm 100 or More,Rush Yards Per Gm 110 or More,Rush Yards Per Gm 120 or More,Rush Yards Per Gm 130 or More,Rush Yards Per Gm 140 or More,Rush Yards Per Gm 150 or More,Rush Yards Per Gm 160 or More,Rush Yards Per Gm 170 or More,Rush Yards Per Gm 180 or More,Opp Rush Yards Per Gm 70 or Less,Opp Rush Yards Per Gm 80 or Less,Opp Rush Yards Per Gm 90 or Less,Opp Rush Yards Per Gm 100 or Less,Opp Rush Yards Per Gm 110 or Less,Opp Rush Yards Per Gm 120 or Less,Opp Rush Yards Per Gm 130 or Less,Opp Rush Yards Per Gm 140 or Less,Opp Rush Yards Per Gm 150 or Less,Opp Rush Yards Per Gm 160 or Less,Opp Rush Yards Per Gm 170 or Less,Opp Rush Yards Per Gm 180 or Less,Opp Rush Yards Per Gm 70 or More,Opp Rush Yards Per Gm 80 or More,Opp Rush Yards Per Gm 90 or More,Opp Rush Yards Per Gm 100 or More,Opp Rush Yards Per Gm 110 or More,Opp Rush Yards Per Gm 120 or More,Opp Rush Yards Per Gm 130 or More,Opp Rush Yards Per Gm 140 or More,Opp Rush Yards Per Gm 150 or More,Opp Rush Yards Per Gm 160 or More,Opp Rush Yards Per Gm 170 or More,Opp Rush Yards Per Gm 180 or More,Pass Yards Per Gm 150 or Less,Pass Yards Per Gm 175 or Less,Pass Yards Per Gm 200 or Less,Pass Yards Per Gm 225 or Less,Pass Yards Per Gm 250 or Less,Pass Yards Per Gm 275 or Less,Pass Yards Per Gm 300 or Less,Pass Yards Per Gm 350 or Less,Pass Yards Per Gm 150 or More,Pass Yards Per Gm 175 or More,Pass Yards Per Gm 200 or More,Pass Yards Per Gm 225 or More,Pass Yards Per Gm 250 or More,Pass Yards Per Gm 275 or More,Pass Yards Per Gm 300 or More,Pass Yards Per Gm 350 or More,Opp Pass Yards Per Gm 150 or Less,Opp Pass Yards Per Gm 175 or Less,Opp Pass Yards Per Gm 200 or Less,Opp Pass Yards Per Gm 225 or Less,Opp Pass Yards Per Gm 250 or Less,Opp Pass Yards Per Gm 275 or Less,Opp Pass Yards Per Gm 300 or Less,Opp Pass Yards Per Gm 350 or Less,Opp Pass Yards Per Gm 150 or More,Opp Pass Yards Per Gm 175 or More,Opp Pass Yards Per Gm 200 or More,Opp Pass Yards Per Gm 225 or More,Opp Pass Yards Per Gm 250 or More,Opp Pass Yards Per Gm 275 or More,Opp Pass Yards Per Gm 300 or More,Opp Pass Yards Per Gm 350 or More,Win Streak of 2 or More,Win Streak of 3 or More,Win Streak of 4 or More,Win Streak of 5 or More,Win Streak of 6 or More,Win Streak of 7 or More,Win Streak of 10 or More,Win Streak of 12 or More,Loss Streak of 2 or More,Loss Streak of 3 or More,Loss Streak of 4 or More,Loss Streak of 5 or More,Loss Streak of 6 or More,Loss Streak of 7 or More,Loss Streak of 10 or More,Loss Streak of 12 or More,Home Win Streak of 2 or More,Home Win Streak of 3 or More,Home Win Streak of 4 or More,Home Win Streak of 5 or More,Home Win Streak of 6 or More,Home Win Streak of 7 or More,Home Win Streak of 10 or More,Home Win Streak of 12 or More,Home Loss Streak of 2 or More,Home Loss Streak of 3 or More,Home Loss Streak of 4 or More,Home Loss Streak of 5 or More,Home Loss Streak of 6 or More,Home Loss Streak of 7 or More,Home Loss Streak of 10 or More,Home Loss Streak of 12 or More,Away Win Streak of 2 or More,Away Win Streak of 3 or More,Away Win Streak of 4 or More,Away Win Streak of 5 or More,Away Win Streak of 6 or More,Away Win Streak of 7 or More,Away Win Streak of 10 or More,Away Win Streak of 12 or More,Away Loss Streak of 2 or More,Away Loss Streak of 3 or More,Away Loss Streak of 4 or More,Away Loss Streak of 5 or More,Away Loss Streak of 6 or More,Away Loss Streak of 7 or More,Away Loss Streak of 10 or More,Away Loss Streak of 12 or More,Opp Win Streak of 2 or More,Opp Win Streak of 3 or More,Opp Win Streak of 4 or More,Opp Win Streak of 5 or More,Opp Win Streak of 6 or More,Opp Win Streak of 7 or More,Opp Win Streak of 10 or More,Opp Win Streak of 12 or More,Opp Loss Streak of 2 or More,Opp Loss Streak of 3 or More,Opp Loss Streak of 4 or More,Opp Loss Streak of 5 or More,Opp Loss Streak of 6 or More,Opp Loss Streak of 7 or More,Opp Loss Streak of 10 or More,Opp Loss Streak of 12 or More,Opp Home Win Streak of 2 or More,Opp Home Win Streak of 3 or More,Opp Home Win Streak of 4 or More,Opp Home Win Streak of 5 or More,Opp Home Win Streak of 6 or More,Opp Home Win Streak of 7 or More,Opp Home Win Streak of 10 or More,Opp Home Win Streak of 12 or More,Opp Home Loss Streak of 2 or More,Opp Home Loss Streak of 3 or More,Opp Home Loss Streak of 4 or More,Opp Home Loss Streak of 5 or More,Opp Home Loss Streak of 6 or More,Opp Home Loss Streak of 7 or More,Opp Home Loss Streak of 10 or More,Opp Home Loss Streak of 12 or More,Opp Away Win Streak of 2 or More,Opp Away Win Streak of 3 or More,Opp Away Win Streak of 4 or More,Opp Away Win Streak of 5 or More,Opp Away Win Streak of 6 or More,Opp Away Win Streak of 7 or More,Opp Away Win Streak of 10 or More,Opp Away Win Streak of 12 or More,Opp Away Loss Streak of 2 or More,Opp Away Loss Streak of 3 or More,Opp Away Loss Streak of 4 or More,Opp Away Loss Streak of 5 or More,Opp Away Loss Streak of 6 or More,Opp Away Loss Streak of 7 or More,Opp Away Loss Streak of 10 or More,Opp Away Loss Streak of 12 or More,Games Played 2 or Less,Games Played 4 or Less,Games Played 6 or Less,Games Played 8 or Less,Games Played 10 or Less,Games Played 12 or Less,Games Played 2 or More,Games Played 4 or More,Games Played 6 or More,Games Played 8 or More,Games Played 10 or More,Games Played 12 or More,Wins 2 or Less,Wins 4 or Less,Wins 6 or Less,Wins 8 or Less,Wins 10 or Less,Wins 12 or Less,Wins 2 or More,Wins 4 or More,Wins 6 or More,Wins 8 or More,Wins 10 or More,Wins 12 or More,Opp Wins 2 or Less,Opp Wins 4 or Less,Opp Wins 6 or Less,Opp Wins 8 or Less,Opp Wins 10 or Less,Opp Wins 12 or Less,Opp Wins 2 or More,Opp Wins 4 or More,Opp Wins 6 or More,Opp Wins 8 or More,Opp Wins 10 or More,Opp Wins 12 or More,Thursday,Saturday,Sunday,Monday,Not Sunday,Grass,Turf,Probability of Win 25% or Less,Probability of Win 30% or Less,Probability of Win 35% or Less,Probability of Win 40% or Less,Probability of Win 45% or Less,Probability of Win 50% or Less,Probability of Win 55% or Less,Probability of Win 60% or Less,Probability of Win 65% or Less,Probability of Win 70% or Less,Probability of Win 75% or Less,Probability of Win 80% or Less,Probability of Win 25% or More,Probability of Win 30% or More,Probability of Win 35% or More,Probability of Win 40% or More,Probability of Win 45% or More,Probability of Win 50% or More,Probability of Win 55% or More,Probability of Win 60% or More,Probability of Win 65% or More,Probability of Win 70% or More,Probability of Win 75% or More,Probability of Win 80% or More,Opp Probability of Win 25% or Less,Opp Probability of Win 30% or Less,Opp Probability of Win 35% or Less,Opp Probability of Win 40% or Less,Opp Probability of Win 45% or Less,Opp Probability of Win 50% or Less,Opp Probability of Win 55% or Less,Opp Probability of Win 60% or Less,Opp Probability of Win 65% or Less,Opp Probability of Win 70% or Less,Opp Probability of Win 75% or Less,Opp Probability of Win 80% or Less,Opp Probability of Win 25% or More,Opp Probability of Win 30% or More,Opp Probability of Win 35% or More,Opp Probability of Win 40% or More,Opp Probability of Win 45% or More,Opp Probability of Win 50% or More,Opp Probability of Win 55% or More,Opp Probability of Win 60% or More,Opp Probability of Win 65% or More,Opp Probability of Win 70% or More,Opp Probability of Win 75% or More,Opp Probability of Win 80% or More");

            // header values
            sb.Append(DATE.LastOrDefault()).Append(",");
            sb.Append(TEAM.LastOrDefault().ToString()).Append(",");
            sb.Append(DIV.LastOrDefault().ToString()).Append(",");
            sb.Append(OTEAM.LastOrDefault().ToString()).Append(",");
            sb.Append(ODIV.LastOrDefault().ToString()).Append(",");
            sb.Append(DAY.LastOrDefault().ToString()).Append(",");
            sb.Append(SPREAD.LastOrDefault().ToString()).Append(",");
            sb.Append(OU.LastOrDefault().ToString()).Append(",");
            sb.Append(ML.LastOrDefault().ToString()).Append(",");
            sb.Append(PT.LastOrDefault().ToString()).Append(",");
            sb.Append(PTA.LastOrDefault().ToString()).Append(",");


            // 0 or 1 values
            sb.Append(FavFeatures.LastOrDefault()?1:0).Append(",");
            sb.Append(UndFeatures.LastOrDefault()?1:0).Append(",");
            sb.Append(HomeFeatures.LastOrDefault()?1:0).Append(",");
            sb.Append(AwayFeatures.LastOrDefault()?1:0).Append(",");
            sb.Append(WinRecordFeatures.LastOrDefault()?1:0).Append(",");
            sb.Append(LoseRecordFeatures.LastOrDefault()?1:0).Append(",");

            sb.Append(SprdFav3Less.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdFav5Less.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdFav7Less.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdFav8Less.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdFav10Less.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdFav12Less.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdFav15Less.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdFav20Less.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdFav3More.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdFav5More.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdFav7More.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdFav8More.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdFav10More.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdFav12More.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdFav15More.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdFav20More.LastOrDefault()?1:0).Append(",");

            sb.Append(SprdUnd3Less.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdUnd5Less.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdUnd7Less.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdUnd8Less.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdUnd10Less.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdUnd12Less.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdUnd15Less.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdUnd20Less.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdUnd3More.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdUnd5More.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdUnd7More.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdUnd8More.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdUnd10More.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdUnd12More.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdUnd15More.LastOrDefault()?1:0).Append(",");
            sb.Append(SprdUnd20More.LastOrDefault()?1:0).Append(",");

            sb.Append(Over30Less.LastOrDefault()?1:0).Append(",");
            sb.Append(Over35Less.LastOrDefault()?1:0).Append(",");
            sb.Append(Over40Less.LastOrDefault()?1:0).Append(",");
            sb.Append(Over45Less.LastOrDefault()?1:0).Append(",");
            sb.Append(Over50Less.LastOrDefault()?1:0).Append(",");
            sb.Append(Over55Less.LastOrDefault()?1:0).Append(",");
            sb.Append(Over60Less.LastOrDefault()?1:0).Append(",");
            sb.Append(Over30More.LastOrDefault()?1:0).Append(",");
            sb.Append(Over35More.LastOrDefault()?1:0).Append(",");
            sb.Append(Over40More.LastOrDefault()?1:0).Append(",");
            sb.Append(Over45More.LastOrDefault()?1:0).Append(",");
            sb.Append(Over50More.LastOrDefault()?1:0).Append(",");
            sb.Append(Over55More.LastOrDefault()?1:0).Append(",");
            sb.Append(Over60More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg5000Less.LastOrDefault()?1:0).Append(",");
            sb.Append(MLNeg2000Less.LastOrDefault()?1:0).Append(",");
            sb.Append(MLNeg1000Less.LastOrDefault()?1:0).Append(",");
            sb.Append(MLNeg800Less.LastOrDefault()?1:0).Append(",");
            sb.Append(MLNeg600Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg500Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg400Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg350Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg300Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg250Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg200Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg150Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg125Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg100Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos100Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos150Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos200Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos250Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos300Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos350Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos400Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos500Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos600Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos800Less.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos1000Less.LastOrDefault()?1:0).Append(",");


            sb.Append(MLNeg5000More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg2000More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg1000More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg800More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg600More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg500More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg400More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg350More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg300More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg250More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg200More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg150More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg125More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLNeg100More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos100More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos150More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos200More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos250More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos300More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos350More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos400More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos500More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos600More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos800More.LastOrDefault()?1:0).Append(",");

            sb.Append(MLPos1000More.LastOrDefault()?1:0).Append(",");


            sb.Append(PtsLG7Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG10Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG13Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG14Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG17Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG21Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG24Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG28Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG31Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG35Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG42Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG49Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG60Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG7More.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG10More.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG13More.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG14More.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG17More.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG21More.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG24More.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG28More.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG31More.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG35More.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG42More.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG49More.LastOrDefault()?1:0).Append(",");

            sb.Append(PtsLG60More.LastOrDefault()?1:0).Append(",");


            sb.Append(oPtsLG7Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG10Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG13Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG14Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG17Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG21Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG24Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG28Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG31Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG35Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG42Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG49Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG60Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG7More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG10More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG13More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG14More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG17More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG21More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG24More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG28More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG31More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG35More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG42More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG49More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPtsLG60More.LastOrDefault()?1:0).Append(",");


            sb.Append(YDS150Less.LastOrDefault()?1:0).Append(",");

            sb.Append(YDS200Less.LastOrDefault()?1:0).Append(",");

            sb.Append(YDS250Less.LastOrDefault()?1:0).Append(",");

            sb.Append(YDS300Less.LastOrDefault()?1:0).Append(",");

            sb.Append(YDS350Less.LastOrDefault()?1:0).Append(",");

            sb.Append(YDS400Less.LastOrDefault()?1:0).Append(",");

            sb.Append(YDS450Less.LastOrDefault()?1:0).Append(",");

            sb.Append(YDS500Less.LastOrDefault()?1:0).Append(",");

            sb.Append(YDS150More.LastOrDefault()?1:0).Append(",");

            sb.Append(YDS200More.LastOrDefault()?1:0).Append(",");

            sb.Append(YDS250More.LastOrDefault()?1:0).Append(",");

            sb.Append(YDS300More.LastOrDefault()?1:0).Append(",");

            sb.Append(YDS350More.LastOrDefault()?1:0).Append(",");

            sb.Append(YDS400More.LastOrDefault()?1:0).Append(",");

            sb.Append(YDS450More.LastOrDefault()?1:0).Append(",");

            sb.Append(YDS500More.LastOrDefault()?1:0).Append(",");


            sb.Append(oYDS150Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDS200Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDS250Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDS300Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDS350Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDS400Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDS450Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDS500Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDS150More.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDS200More.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDS250More.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDS300More.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDS350More.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDS400More.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDS450More.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDS500More.LastOrDefault()?1:0).Append(",");


            sb.Append(RYLG50Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYLG75Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYLG100Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYLG125Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYLG200Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYLG250Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYLG300Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYLG350Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYLG50More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYLG75More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYLG100More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYLG125More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYLG200More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYLG250More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYLG300More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYLG350More.LastOrDefault()?1:0).Append(",");


            sb.Append(oRYLG50Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYLG75Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYLG100Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYLG125Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYLG200Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYLG250Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYLG300Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYLG350Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYLG50More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYLG75More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYLG100More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYLG125More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYLG200More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYLG250More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYLG300More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYLG350More.LastOrDefault()?1:0).Append(",");


            sb.Append(PYLG50Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG100Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG125Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG150Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG200Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG250Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG300Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG350Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG400Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG500Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG50More.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG100More.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG125More.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG150More.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG200More.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG250More.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG300More.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG350More.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG400More.LastOrDefault()?1:0).Append(",");

            sb.Append(PYLG500More.LastOrDefault()?1:0).Append(",");


            sb.Append(oPYLG50Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG100Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG125Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG150Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG200Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG250Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG300Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG350Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG400Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG500Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG50More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG100More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG125More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG150More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG200More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG250More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG300More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG350More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG400More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYLG500More.LastOrDefault()?1:0).Append(",");


            sb.Append(winP25Less.LastOrDefault()?1:0).Append(",");

            sb.Append(winP33Less.LastOrDefault()?1:0).Append(",");

            sb.Append(winP40Less.LastOrDefault()?1:0).Append(",");

            sb.Append(winP45Less.LastOrDefault()?1:0).Append(",");

            sb.Append(winP50Less.LastOrDefault()?1:0).Append(",");

            sb.Append(winP55Less.LastOrDefault()?1:0).Append(",");

            sb.Append(winP60Less.LastOrDefault()?1:0).Append(",");

            sb.Append(winP65Less.LastOrDefault()?1:0).Append(",");

            sb.Append(winP75Less.LastOrDefault()?1:0).Append(",");

            sb.Append(winP80Less.LastOrDefault()?1:0).Append(",");

            sb.Append(winP25More.LastOrDefault()?1:0).Append(",");

            sb.Append(winP33More.LastOrDefault()?1:0).Append(",");

            sb.Append(winP40More.LastOrDefault()?1:0).Append(",");

            sb.Append(winP45More.LastOrDefault()?1:0).Append(",");

            sb.Append(winP50More.LastOrDefault()?1:0).Append(",");

            sb.Append(winP55More.LastOrDefault()?1:0).Append(",");

            sb.Append(winP60More.LastOrDefault()?1:0).Append(",");

            sb.Append(winP65More.LastOrDefault()?1:0).Append(",");

            sb.Append(winP75More.LastOrDefault()?1:0).Append(",");

            sb.Append(winP80More.LastOrDefault()?1:0).Append(",");


            sb.Append(owinP25Less.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP33Less.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP40Less.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP45Less.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP50Less.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP55Less.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP60Less.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP65Less.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP75Less.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP80Less.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP25More.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP33More.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP40More.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP45More.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP50More.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP55More.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP60More.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP65More.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP75More.LastOrDefault()?1:0).Append(",");

            sb.Append(owinP80More.LastOrDefault()?1:0).Append(",");


            sb.Append(PPG10Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG13Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG15Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG17Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG20Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG22Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG24Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG28Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG30Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG35Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG10More.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG13More.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG15More.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG17More.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG20More.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG22More.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG24More.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG28More.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG30More.LastOrDefault()?1:0).Append(",");

            sb.Append(PPG35More.LastOrDefault()?1:0).Append(",");


            sb.Append(oPPG10Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG13Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG15Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG17Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG20Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG22Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG24Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG28Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG30Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG35Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG10More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG13More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG15More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG17More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG20More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG22More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG24More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG28More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG30More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPPG35More.LastOrDefault()?1:0).Append(",");


            sb.Append(YDSPG250Less.LastOrDefault()?1:0).Append(",");

            sb.Append(YDSPG300Less.LastOrDefault()?1:0).Append(",");

            sb.Append(YDSPG350Less.LastOrDefault()?1:0).Append(",");

            sb.Append(YDSPG400Less.LastOrDefault()?1:0).Append(",");

            sb.Append(YDSPG450Less.LastOrDefault()?1:0).Append(",");

            sb.Append(YDSPG250More.LastOrDefault()?1:0).Append(",");

            sb.Append(YDSPG300More.LastOrDefault()?1:0).Append(",");

            sb.Append(YDSPG350More.LastOrDefault()?1:0).Append(",");

            sb.Append(YDSPG400More.LastOrDefault()?1:0).Append(",");

            sb.Append(YDSPG450More.LastOrDefault()?1:0).Append(",");


            sb.Append(oYDSPG250Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDSPG300Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDSPG350Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDSPG400Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDSPG450Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDSPG250More.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDSPG300More.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDSPG350More.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDSPG400More.LastOrDefault()?1:0).Append(",");

            sb.Append(oYDSPG450More.LastOrDefault()?1:0).Append(",");


            sb.Append(RYPG70Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG80Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG90Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG100Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG110Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG120Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG130Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG140Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG150Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG160Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG170Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG180Less.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG70More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG80More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG90More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG100More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG110More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG120More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG130More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG140More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG150More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG160More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG170More.LastOrDefault()?1:0).Append(",");

            sb.Append(RYPG180More.LastOrDefault()?1:0).Append(",");


            sb.Append(oRYPG70Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG80Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG90Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG100Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG110Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG120Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG130Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG140Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG150Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG160Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG170Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG180Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG70More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG80More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG90More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG100More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG110More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG120More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG130More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG140More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG150More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG160More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG170More.LastOrDefault()?1:0).Append(",");

            sb.Append(oRYPG180More.LastOrDefault()?1:0).Append(",");


            sb.Append(PYPG150Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYPG175Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYPG200Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYPG225Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYPG250Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYPG275Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYPG300Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYPG350Less.LastOrDefault()?1:0).Append(",");

            sb.Append(PYPG150More.LastOrDefault()?1:0).Append(",");

            sb.Append(PYPG175More.LastOrDefault()?1:0).Append(",");

            sb.Append(PYPG200More.LastOrDefault()?1:0).Append(",");

            sb.Append(PYPG225More.LastOrDefault()?1:0).Append(",");

            sb.Append(PYPG250More.LastOrDefault()?1:0).Append(",");

            sb.Append(PYPG275More.LastOrDefault()?1:0).Append(",");

            sb.Append(PYPG300More.LastOrDefault()?1:0).Append(",");

            sb.Append(PYPG350More.LastOrDefault()?1:0).Append(",");


            sb.Append(oPYPG150Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYPG175Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYPG200Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYPG225Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYPG250Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYPG275Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYPG300Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYPG350Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYPG150More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYPG175More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYPG200More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYPG225More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYPG250More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYPG275More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYPG300More.LastOrDefault()?1:0).Append(",");

            sb.Append(oPYPG350More.LastOrDefault()?1:0).Append(",");

            sb.Append(WStrk2.LastOrDefault()?1:0).Append(",");

            sb.Append(WStrk3.LastOrDefault()?1:0).Append(",");

            sb.Append(WStrk4.LastOrDefault()?1:0).Append(",");

            sb.Append(WStrk5.LastOrDefault()?1:0).Append(",");

            sb.Append(WStrk6.LastOrDefault()?1:0).Append(",");

            sb.Append(WStrk7.LastOrDefault()?1:0).Append(",");

            sb.Append(WStrk10.LastOrDefault()?1:0).Append(",");

            sb.Append(WStrk12.LastOrDefault()?1:0).Append(",");

            sb.Append(LStrk2.LastOrDefault()?1:0).Append(",");

            sb.Append(LStrk3.LastOrDefault()?1:0).Append(",");

            sb.Append(LStrk4.LastOrDefault()?1:0).Append(",");

            sb.Append(LStrk5.LastOrDefault()?1:0).Append(",");

            sb.Append(LStrk6.LastOrDefault()?1:0).Append(",");

            sb.Append(LStrk7.LastOrDefault()?1:0).Append(",");

            sb.Append(LStrk10.LastOrDefault()?1:0).Append(",");

            sb.Append(LStrk12.LastOrDefault()?1:0).Append(",");


            sb.Append(homeWStrk2.LastOrDefault()?1:0).Append(",");

            sb.Append(homeWStrk3.LastOrDefault()?1:0).Append(",");

            sb.Append(homeWStrk4.LastOrDefault()?1:0).Append(",");

            sb.Append(homeWStrk5.LastOrDefault()?1:0).Append(",");

            sb.Append(homeWStrk6.LastOrDefault()?1:0).Append(",");

            sb.Append(homeWStrk7.LastOrDefault()?1:0).Append(",");

            sb.Append(homeWStrk10.LastOrDefault()?1:0).Append(",");

            sb.Append(homeWStrk12.LastOrDefault()?1:0).Append(",");

            sb.Append(homeLStrk2.LastOrDefault()?1:0).Append(",");

            sb.Append(homeLStrk3.LastOrDefault()?1:0).Append(",");

            sb.Append(homeLStrk4.LastOrDefault()?1:0).Append(",");

            sb.Append(homeLStrk5.LastOrDefault()?1:0).Append(",");

            sb.Append(homeLStrk6.LastOrDefault()?1:0).Append(",");

            sb.Append(homeLStrk7.LastOrDefault()?1:0).Append(",");

            sb.Append(homeLStrk10.LastOrDefault()?1:0).Append(",");

            sb.Append(homeLStrk12.LastOrDefault()?1:0).Append(",");


            sb.Append(awayWStrk2.LastOrDefault()?1:0).Append(",");

            sb.Append(awayWStrk3.LastOrDefault()?1:0).Append(",");

            sb.Append(awayWStrk4.LastOrDefault()?1:0).Append(",");

            sb.Append(awayWStrk5.LastOrDefault()?1:0).Append(",");

            sb.Append(awayWStrk6.LastOrDefault()?1:0).Append(",");

            sb.Append(awayWStrk7.LastOrDefault()?1:0).Append(",");

            sb.Append(awayWStrk10.LastOrDefault()?1:0).Append(",");

            sb.Append(awayWStrk12.LastOrDefault()?1:0).Append(",");

            sb.Append(awayLStrk2.LastOrDefault()?1:0).Append(",");

            sb.Append(awayLStrk3.LastOrDefault()?1:0).Append(",");

            sb.Append(awayLStrk4.LastOrDefault()?1:0).Append(",");

            sb.Append(awayLStrk5.LastOrDefault()?1:0).Append(",");

            sb.Append(awayLStrk6.LastOrDefault()?1:0).Append(",");

            sb.Append(awayLStrk7.LastOrDefault()?1:0).Append(",");

            sb.Append(awayLStrk10.LastOrDefault()?1:0).Append(",");

            sb.Append(awayLStrk12.LastOrDefault()?1:0).Append(",");


            sb.Append(oWStrk2.LastOrDefault()?1:0).Append(",");

            sb.Append(oWStrk3.LastOrDefault()?1:0).Append(",");

            sb.Append(oWStrk4.LastOrDefault()?1:0).Append(",");

            sb.Append(oWStrk5.LastOrDefault()?1:0).Append(",");

            sb.Append(oWStrk6.LastOrDefault()?1:0).Append(",");

            sb.Append(oWStrk7.LastOrDefault()?1:0).Append(",");

            sb.Append(oWStrk10.LastOrDefault()?1:0).Append(",");

            sb.Append(oWStrk12.LastOrDefault()?1:0).Append(",");

            sb.Append(oLStrk2.LastOrDefault()?1:0).Append(",");

            sb.Append(oLStrk3.LastOrDefault()?1:0).Append(",");

            sb.Append(oLStrk4.LastOrDefault()?1:0).Append(",");

            sb.Append(oLStrk5.LastOrDefault()?1:0).Append(",");

            sb.Append(oLStrk6.LastOrDefault()?1:0).Append(",");

            sb.Append(oLStrk7.LastOrDefault()?1:0).Append(",");

            sb.Append(oLStrk10.LastOrDefault()?1:0).Append(",");

            sb.Append(oLStrk12.LastOrDefault()?1:0).Append(",");


            sb.Append(ohomeWStrk2.LastOrDefault()?1:0).Append(",");

            sb.Append(ohomeWStrk3.LastOrDefault()?1:0).Append(",");

            sb.Append(ohomeWStrk4.LastOrDefault()?1:0).Append(",");

            sb.Append(ohomeWStrk5.LastOrDefault()?1:0).Append(",");

            sb.Append(ohomeWStrk6.LastOrDefault()?1:0).Append(",");

            sb.Append(ohomeWStrk7.LastOrDefault()?1:0).Append(",");

            sb.Append(ohomeWStrk10.LastOrDefault()?1:0).Append(",");

            sb.Append(ohomeWStrk12.LastOrDefault()?1:0).Append(",");

            sb.Append(ohomeLStrk2.LastOrDefault()?1:0).Append(",");

            sb.Append(ohomeLStrk3.LastOrDefault()?1:0).Append(",");

            sb.Append(ohomeLStrk4.LastOrDefault()?1:0).Append(",");

            sb.Append(ohomeLStrk5.LastOrDefault()?1:0).Append(",");

            sb.Append(ohomeLStrk6.LastOrDefault()?1:0).Append(",");

            sb.Append(ohomeLStrk7.LastOrDefault()?1:0).Append(",");

            sb.Append(ohomeLStrk10.LastOrDefault()?1:0).Append(",");

            sb.Append(ohomeLStrk12.LastOrDefault()?1:0).Append(",");


            sb.Append(oawayWStrk2.LastOrDefault()?1:0).Append(",");

            sb.Append(oawayWStrk3.LastOrDefault()?1:0).Append(",");

            sb.Append(oawayWStrk4.LastOrDefault()?1:0).Append(",");

            sb.Append(oawayWStrk5.LastOrDefault()?1:0).Append(",");

            sb.Append(oawayWStrk6.LastOrDefault()?1:0).Append(",");

            sb.Append(oawayWStrk7.LastOrDefault()?1:0).Append(",");

            sb.Append(oawayWStrk10.LastOrDefault()?1:0).Append(",");

            sb.Append(oawayWStrk12.LastOrDefault()?1:0).Append(",");

            sb.Append(oawayLStrk2.LastOrDefault()?1:0).Append(",");

            sb.Append(oawayLStrk3.LastOrDefault()?1:0).Append(",");

            sb.Append(oawayLStrk4.LastOrDefault()?1:0).Append(",");

            sb.Append(oawayLStrk5.LastOrDefault()?1:0).Append(",");

            sb.Append(oawayLStrk6.LastOrDefault()?1:0).Append(",");

            sb.Append(oawayLStrk7.LastOrDefault()?1:0).Append(",");

            sb.Append(oawayLStrk10.LastOrDefault()?1:0).Append(",");

            sb.Append(oawayLStrk12.LastOrDefault()?1:0).Append(",");


            sb.Append(Gms2Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Gms4Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Gms6Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Gms8Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Gms10Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Gms12Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Gms2More.LastOrDefault()?1:0).Append(",");

            sb.Append(Gms4More.LastOrDefault()?1:0).Append(",");

            sb.Append(Gms6More.LastOrDefault()?1:0).Append(",");

            sb.Append(Gms8More.LastOrDefault()?1:0).Append(",");

            sb.Append(Gms10More.LastOrDefault()?1:0).Append(",");

            sb.Append(Gms12More.LastOrDefault()?1:0).Append(",");


            sb.Append(Wins2Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Wins4Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Wins6Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Wins8Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Wins10Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Wins12Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Wins2More.LastOrDefault()?1:0).Append(",");

            sb.Append(Wins4More.LastOrDefault()?1:0).Append(",");

            sb.Append(Wins6More.LastOrDefault()?1:0).Append(",");

            sb.Append(Wins8More.LastOrDefault()?1:0).Append(",");

            sb.Append(Wins10More.LastOrDefault()?1:0).Append(",");

            sb.Append(Wins12More.LastOrDefault()?1:0).Append(",");


            sb.Append(oWins2Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oWins4Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oWins6Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oWins8Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oWins10Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oWins12Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oWins2More.LastOrDefault()?1:0).Append(",");

            sb.Append(oWins4More.LastOrDefault()?1:0).Append(",");

            sb.Append(oWins6More.LastOrDefault()?1:0).Append(",");

            sb.Append(oWins8More.LastOrDefault()?1:0).Append(",");

            sb.Append(oWins10More.LastOrDefault()?1:0).Append(",");

            sb.Append(oWins12More.LastOrDefault()?1:0).Append(",");


            sb.Append(Thu.LastOrDefault()?1:0).Append(",");

            sb.Append(Sat.LastOrDefault()?1:0).Append(",");

            sb.Append(Sun.LastOrDefault()?1:0).Append(",");

            sb.Append(Mon.LastOrDefault()?1:0).Append(",");

            sb.Append(NotSun.LastOrDefault()?1:0).Append(",");


            sb.Append(Grass.LastOrDefault()?1:0).Append(",");

            sb.Append(TurfFeature.LastOrDefault()?1:0).Append(",");


            sb.Append(Prob25Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob30Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob35Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob40Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob45Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob50Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob55Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob60Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob65Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob70Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob75Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob80Less.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob25More.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob30More.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob35More.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob40More.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob45More.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob50More.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob55More.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob60More.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob65More.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob70More.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob75More.LastOrDefault()?1:0).Append(",");

            sb.Append(Prob80More.LastOrDefault()?1:0).Append(",");


            sb.Append(oProb25Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb30Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb35Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb40Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb45Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb50Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb55Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb60Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb65Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb70Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb75Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb80Less.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb25More.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb30More.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb35More.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb40More.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb45More.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb50More.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb55More.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb60More.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb65More.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb70More.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb75More.LastOrDefault()?1:0).Append(",");

            sb.Append(oProb80More.LastOrDefault()?1:0).Append(",").AppendLine();

            _writerSignals.Write(sb.ToString());   
        }


        public override void LoadData(string fileName)
        {
            var input = new StreamReader(fileName);
            var text = input.ReadLine();
            while (!input.EndOfStream)
            {
                if (text != null)
                {
                    var tokens = text.Split('\t');
                    Date = Convert.ToInt32(tokens[0]);
                    GmNo = Convert.ToInt32(tokens[1]);
                    Team = tokens[2];
                    Div = tokens[3];
                    Day = tokens[4];
                    Oteam = tokens[5];
                    Odiv = tokens[6];
                    OgmNo = Convert.ToInt32(tokens[7]);
                    Home = Convert.ToInt32(tokens[8]);
                    Turf = Convert.ToInt32(tokens[9]);
                    Fav = Convert.ToInt32(tokens[10]);
                    Spread = Convert.ToDouble(tokens[11]);
                    Ou = Convert.ToDouble(tokens[12]);
                    Pt = Convert.ToInt32(tokens[13]);
                    Pta = Convert.ToInt32(tokens[14]);
                    Fd = Convert.ToInt32(tokens[15]);
                    Fda = Convert.ToInt32(tokens[16]);
                    r = Convert.ToInt32(tokens[17]);
                    Ra = Convert.ToInt32(tokens[18]);
                    Ry = Convert.ToInt32(tokens[19]);
                    Rya = Convert.ToInt32(tokens[20]);
                    p = Convert.ToInt32(tokens[21]);
                    Pa = Convert.ToInt32(tokens[22]);
                    Pc = Convert.ToInt32(tokens[23]);
                    Pca = Convert.ToInt32(tokens[24]);
                    Py = Convert.ToInt32(tokens[25]);
                    Pya = Convert.ToInt32(tokens[26]);
                    It = Convert.ToInt32(tokens[27]);
                    Ita = Convert.ToInt32(tokens[28]);
                    Ml = Convert.ToDouble(tokens[29]);
                    text = input.ReadLine();
                    Update();
                } 
            }
        }

    }
}
