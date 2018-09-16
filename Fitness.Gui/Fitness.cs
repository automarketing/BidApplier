using System;
using System.Collections.Generic;
using System.Configuration;
using System.IO;
using System.Linq;
using System.Runtime.InteropServices.WindowsRuntime;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using Fitness.Gui.Properties;

using System.Collections;
using System.Collections.Specialized;

namespace Fitness.Gui
{
    public class Bet
    {
        public double result;
        public int numberOfBets;

    }

    internal class CSV
    {

        public List<string> m_data;

        public void readNextRow(string fileName)
        {

        }
    }


    public class Data // one signal row
    {
        public List<char> signal;

        // header values
        public string DATE;
        public string DAY;
        public string TEAM;
        public string DIV;
        public string OTEAM;
        public string ODIV;
        public double SPREAD;
        public double OU;
        public int ML;
        public double PT;
        public double PTA;


        //combind signal
        public char combined_signal;
    }

    public class FitnessOptions
    {
        public char kelly_on;
        public char kelly_half;
        public int account_size;
        public BetStyle bet_style;

    };

    internal class Result
    {
        public double finalResult;
        public List<string> signalsNames = new List<string>();

    };



    public enum BetStyle
    {
        spread = 0,
        over = 1,
        under=2,
        moneyline = 3
    };

    public class NFL
    {
        public int index;

        public double spread;
        public double ou;
        public double pts;
        public double ptsa;
        public double ml;


    };

    //internal class CombinedSignal
    //{
    //    public List<string> signalsNames;
    //    public List<char> signal;

    //};

    internal class ColumnData
    {
        public List<char> Data;
        public string Name;
    };

    public class ResultData
    {
        public int value;
        public int count;
    };

    public class StrategyResult
    {
        public List<int> combinedData = new List<int>();
        public string combinedColumn = "";
        public int combinedNullCount = 0;
        public SortedDictionary<string, ResultData> dateToAccumulate = new SortedDictionary<string, ResultData>();
        public SortedDictionary<string, ResultData> yearToAccumulate = new SortedDictionary<string, ResultData>();
        public SortedDictionary<string, ResultData> monthToAccumulate = new SortedDictionary<string, ResultData>();
        public List<SortedDictionary<string, ResultData>> MonteData = new List<SortedDictionary<string, ResultData>>();

        public int sum = 0;
        public int win = 0;
        public int loss = 0;
        public double BestProfit = 0;
        public int min = 0;
        public int total_win, total_loss;
    }


    public class Fitness
    {
        public const string SignalNames =
               "Favorite,Underdog,Home,Away,Winning Record,Losing Record,Spread -3 or More,Spread -5 or More,Spread -7 or More,Spread -8 or More,Spread -10 or More,Spread -12 or More,Spread -15 or More,Spread -20 or More,Spread -3 or Less,Spread -5 or Less,Spread -7 or Less,Spread -8 or Less,Spread -10 or Less,Spread -12 or Less,Spread -15 or Less,Spread -20 or Less,Spread +3 or Less,Spread +5 or Less,Spread +7 or Less,Spread +8 or Less,Spread +10 or Less,Spread +12 or Less,Spread +15 or Less,Spread +20 or Less,Spread +3 or More,Spread +5 or More,Spread +7 or More,Spread +8 or More,Spread +10 or More,Spread +12 or More,Spread +15 or More,Spread +20 or More,OU Total <= 30,OU Total <= 35,OU Total <= 40,OU Total <= 45,OU Total <= 50,OU Total <= 55,OU Total <= 60,OU Total >= 30,OU Total >= 35,OU Total >= 40,OU Total >= 45,OU Total >= 50,OU Total >= 55,OU Total >= 60,MoneyLine -5000 or More,MoneyLine -2000 or More,MoneyLine -1000 or More,MoneyLine -800 or More,MoneyLine -600 or More,MoneyLine -500 or More,MoneyLine -400 or More,MoneyLine -350 or More,MoneyLine -300 or More,MoneyLine -250 or More,MoneyLine -200 or More,MoneyLine -150 or More,MoneyLine -125 or More,MoneyLine -100 or More,MoneyLine +100 or Less,MoneyLine +150 or Less,MoneyLine +200 or Less,MoneyLine +250 or Less,MoneyLine +300 or Less,MoneyLine +350 or Less,MoneyLine +400 or Less,MoneyLine +500 or Less,MoneyLine +600 or Less,MoneyLine +800 or Less,MoneyLine +1000 or Less,MoneyLine -5000 or Less,MoneyLine -2000 or Less,MoneyLine -1000 or Less,MoneyLine -800 or Less,MoneyLine -600 or Less,MoneyLine -500 or Less,MoneyLine -400 or Less,MoneyLine -350 or Less,MoneyLine -300 or Less,MoneyLine -250 or Less,MoneyLine -200 or Less,MoneyLine -150 or Less,MoneyLine -125 or Less,MoneyLine -100 or Less,MoneyLine -100 or More,MoneyLine -150 or More,MoneyLine -200 or More,MoneyLine -250 or More,MoneyLine -300 or More,MoneyLine -350 or More,MoneyLine -400 or More,MoneyLine -500 or More,MoneyLine -600 or More,MoneyLine -800 or More,MoneyLine -1000 or More,Pts Last gm 7 or Less,Pts Last gm 10 or Less,Pts Last gm 13 or Less,Pts Last gm 14 or Less,Pts Last gm 17 or Less,Pts Last gm 21 or Less,Pts Last gm 24 or Less,Pts Last gm 28 or Less,Pts Last gm 31 or Less,Pts Last gm 35 or Less,Pts Last gm 42 or Less,Pts Last gm 49 or Less,Pts Last gm 60 or Less,Pts Last gm 7 or More,Pts Last gm 10 or More,Pts Last gm 13 or More,Pts Last gm 14 or More,Pts Last gm 17 or More,Pts Last gm 21 or More,Pts Last gm 24 or More,Pts Last gm 28 or More,Pts Last gm 31 or More,Pts Last gm 35 or More,Pts Last gm 42 or More,Pts Last gm 49 or More,Pts Last gm 60 or More,Opp Pts Last gm 7 or Less,Opp Pts Last gm 10 or Less,Opp Pts Last gm 13 or Less,Opp Pts Last gm 14 or Less,Opp Pts Last gm 17 or Less,Opp Pts Last gm 21 or Less,Opp Pts Last gm 24 or Less,Opp Pts Last gm 28 or Less,Opp Pts Last gm 31 or Less,Opp Pts Last gm 35 or Less,Opp Pts Last gm 42 or Less,Opp Pts Last gm 49 or Less,Opp Pts Last gm 60 or Less,Opp Pts Last gm 7 or More,Opp Pts Last gm 10 or More,Opp Pts Last gm 13 or More,Opp Pts Last gm 14 or More,Opp Pts Last gm 17 or More,Opp Pts Last gm 21 or More,Opp Pts Last gm 24 or More,Opp Pts Last gm 28 or More,Opp Pts Last gm 31 or More,Opp Pts Last gm 35 or More,Opp Pts Last gm 42 or More,Opp Pts Last gm 49 or More,Opp Pts Last gm 60 or More,Yards Last gm 150 or Less,Yards Last gm 200 or Less,Yards Last gm 250 or Less,Yards Last gm 300 or Less,Yards Last gm 350 or Less,Yards Last gm 400 or Less,Yards Last gm 450 or Less,Yards Last gm 500 or Less,Yards Last gm 150 or More,Yards Last gm 200 or More,Yards Last gm 250 or More,Yards Last gm 300 or More,Yards Last gm 350 or More,Yards Last gm 400 or More,Yards Last gm 450 or More,Yards Last gm 500 or More,Opp Yards Last gm 150 or Less,Opp Yards Last gm 200 or Less,Opp Yards Last gm 250 or Less,Opp Yards Last gm 300 or Less,Opp Yards Last gm 350 or Less,Opp Yards Last gm 400 or Less,Opp Yards Last gm 450 or Less,Opp Yards Last gm 500 or Less,Opp Yards Last gm 150 or More,Opp Yards Last gm 200 or More,Opp Yards Last gm 250 or More,Opp Yards Last gm 300 or More,Opp Yards Last gm 350 or More,Opp Yards Last gm 400 or More,Opp Yards Last gm 450 or More,Opp Yards Last gm 500 or More,Rush Yards Last gm 50 or Less,Rush Yards Last gm 75 or Less,Rush Yards Last gm 100 or Less,Rush Yards Last gm 125 or Less,Rush Yards Last gm 200 or Less,Rush Yards Last gm 250 or Less,Rush Yards Last gm 300 or Less,Rush Yards Last gm 350 or Less,Rush Yards Last gm 50 or More,Rush Yards Last gm 75 or More,Rush Yards Last gm 100 or More,Rush Yards Last gm 125 or More,Rush Yards Last gm 200 or More,Rush Yards Last gm 250 or More,Rush Yards Last gm 300 or More,Rush Yards Last gm 350 or More,Opp Rush Yards Last gm 50 or Less,Opp Rush Yards Last gm 75 or Less,Opp Rush Yards Last gm 100 or Less,Opp Rush Yards Last gm 125 or Less,Opp Rush Yards Last gm 200 or Less,Opp Rush Yards Last gm 250 or Less,Opp Rush Yards Last gm 300 or Less,Opp Rush Yards Last gm 350 or Less,Opp Rush Yards Last gm 50 or More,Opp Rush Yards Last gm 75 or More,Opp Rush Yards Last gm 100 or More,Opp Rush Yards Last gm 125 or More,Opp Rush Yards Last gm 200 or More,Opp Rush Yards Last gm 250 or More,Opp Rush Yards Last gm 300 or More,Opp Rush Yards Last gm 350 or More,Pass Yards Last gm 50 or Less,Pass Yards Last gm 100 or Less,Pass Yards Last gm 125 or Less,Pass Yards Last gm 150 or Less,Pass Yards Last gm 200 or Less,Pass Yards Last gm 250 or Less,Pass Yards Last gm 300 or Less,Pass Yards Last gm 350 or Less,Pass Yards Last gm 400 or Less,Pass Yards Last gm 500 or Less,Pass Yards Last gm 50 or More,Pass Yards Last gm 100 or More,Pass Yards Last gm 125 or More,Pass Yards Last gm 150 or More,Pass Yards Last gm 200 or More,Pass Yards Last gm 250 or More,Pass Yards Last gm 300 or More,Pass Yards Last gm 350 or More,Pass Yards Last gm 400 or More,Pass Yards Last gm 500 or More,Opp Pass Yards Last gm 50 or Less,Opp Pass Yards Last gm 100 or Less,Opp Pass Yards Last gm 125 or Less,Opp Pass Yards Last gm 150 or Less,Opp Pass Yards Last gm 200 or Less,Opp Pass Yards Last gm 250 or Less,Opp Pass Yards Last gm 300 or Less,Opp Pass Yards Last gm 350 or Less,Opp Pass Yards Last gm 400 or Less,Opp Pass Yards Last gm 500 or Less,Opp Pass Yards Last gm 50 or More,Opp Pass Yards Last gm 100 or More,Opp Pass Yards Last gm 125 or More,Opp Pass Yards Last gm 150 or More,Opp Pass Yards Last gm 200 or More,Opp Pass Yards Last gm 250 or More,Opp Pass Yards Last gm 300 or More,Opp Pass Yards Last gm 350 or More,Opp Pass Yards Last gm 400 or More,Opp Pass Yards Last gm 500 or More,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 75% or Less,Winning Perc 80% or Less,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 75% or More,Winning Perc 80% or More,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 75% or Less,Opp Winning Perc 80% or Less,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 75% or More,Opp Winning Perc 80% or More,Points Per Gm 10 or Less,Points Per Gm 13 or Less,Points Per Gm 15 or Less,Points Per Gm 17 or Less,Points Per Gm 20 or Less,Points Per Gm 22 or Less,Points Per Gm 24 or Less,Points Per Gm 28 or Less,Points Per Gm 30 or Less,Points Per Gm 35 or Less,Points Per Gm 10 or More,Points Per Gm 13 or More,Points Per Gm 15 or More,Points Per Gm 17 or More,Points Per Gm 20 or More,Points Per Gm 22 or More,Points Per Gm 24 or More,Points Per Gm 28 or More,Points Per Gm 30 or More,Points Per Gm 35 or More,Opp Points Per Gm 10 or Less,Opp Points Per Gm 13 or Less,Opp Points Per Gm 15 or Less,Opp Points Per Gm 17 or Less,Opp Points Per Gm 20 or Less,Opp Points Per Gm 22 or Less,Opp Points Per Gm 24 or Less,Opp Points Per Gm 28 or Less,Opp Points Per Gm 30 or Less,Opp Points Per Gm 35 or Less,Opp Points Per Gm 10 or More,Opp Points Per Gm 13 or More,Opp Points Per Gm 15 or More,Opp Points Per Gm 17 or More,Opp Points Per Gm 20 or More,Opp Points Per Gm 22 or More,Opp Points Per Gm 24 or More,Opp Points Per Gm 28 or More,Opp Points Per Gm 30 or More,Opp Points Per Gm 35 or More,Yards Per Gm 250 or Less,Yards Per Gm 300 or Less,Yards Per Gm 350 or Less,Yards Per Gm 400 or Less,Yards Per Gm 450 or Less,Yards Per Gm 250 or More,Yards Per Gm 300 or More,Yards Per Gm 350 or More,Yards Per Gm 400 or More,Yards Per Gm 450 or More,Opp Yards Per Gm 250 or Less,Opp Yards Per Gm 300 or Less,Opp Yards Per Gm 350 or Less,Opp Yards Per Gm 400 or Less,Opp Yards Per Gm 450 or Less,Opp Yards Per Gm 250 or More,Opp Yards Per Gm 300 or More,Opp Yards Per Gm 350 or More,Opp Yards Per Gm 400 or More,Opp Yards Per Gm 450 or More,Rush Yards Per Gm 70 or Less,Rush Yards Per Gm 80 or Less,Rush Yards Per Gm 90 or Less,Rush Yards Per Gm 100 or Less,Rush Yards Per Gm 110 or Less,Rush Yards Per Gm 120 or Less,Rush Yards Per Gm 130 or Less,Rush Yards Per Gm 140 or Less,Rush Yards Per Gm 150 or Less,Rush Yards Per Gm 160 or Less,Rush Yards Per Gm 170 or Less,Rush Yards Per Gm 180 or Less,Rush Yards Per Gm 70 or More,Rush Yards Per Gm 80 or More,Rush Yards Per Gm 90 or More,Rush Yards Per Gm 100 or More,Rush Yards Per Gm 110 or More,Rush Yards Per Gm 120 or More,Rush Yards Per Gm 130 or More,Rush Yards Per Gm 140 or More,Rush Yards Per Gm 150 or More,Rush Yards Per Gm 160 or More,Rush Yards Per Gm 170 or More,Rush Yards Per Gm 180 or More,Opp Rush Yards Per Gm 70 or Less,Opp Rush Yards Per Gm 80 or Less,Opp Rush Yards Per Gm 90 or Less,Opp Rush Yards Per Gm 100 or Less,Opp Rush Yards Per Gm 110 or Less,Opp Rush Yards Per Gm 120 or Less,Opp Rush Yards Per Gm 130 or Less,Opp Rush Yards Per Gm 140 or Less,Opp Rush Yards Per Gm 150 or Less,Opp Rush Yards Per Gm 160 or Less,Opp Rush Yards Per Gm 170 or Less,Opp Rush Yards Per Gm 180 or Less,Opp Rush Yards Per Gm 70 or More,Opp Rush Yards Per Gm 80 or More,Opp Rush Yards Per Gm 90 or More,Opp Rush Yards Per Gm 100 or More,Opp Rush Yards Per Gm 110 or More,Opp Rush Yards Per Gm 120 or More,Opp Rush Yards Per Gm 130 or More,Opp Rush Yards Per Gm 140 or More,Opp Rush Yards Per Gm 150 or More,Opp Rush Yards Per Gm 160 or More,Opp Rush Yards Per Gm 170 or More,Opp Rush Yards Per Gm 180 or More,Pass Yards Per Gm 150 or Less,Pass Yards Per Gm 175 or Less,Pass Yards Per Gm 200 or Less,Pass Yards Per Gm 225 or Less,Pass Yards Per Gm 250 or Less,Pass Yards Per Gm 275 or Less,Pass Yards Per Gm 300 or Less,Pass Yards Per Gm 350 or Less,Pass Yards Per Gm 150 or More,Pass Yards Per Gm 175 or More,Pass Yards Per Gm 200 or More,Pass Yards Per Gm 225 or More,Pass Yards Per Gm 250 or More,Pass Yards Per Gm 275 or More,Pass Yards Per Gm 300 or More,Pass Yards Per Gm 350 or More,Opp Pass Yards Per Gm 150 or Less,Opp Pass Yards Per Gm 175 or Less,Opp Pass Yards Per Gm 200 or Less,Opp Pass Yards Per Gm 225 or Less,Opp Pass Yards Per Gm 250 or Less,Opp Pass Yards Per Gm 275 or Less,Opp Pass Yards Per Gm 300 or Less,Opp Pass Yards Per Gm 350 or Less,Opp Pass Yards Per Gm 150 or More,Opp Pass Yards Per Gm 175 or More,Opp Pass Yards Per Gm 200 or More,Opp Pass Yards Per Gm 225 or More,Opp Pass Yards Per Gm 250 or More,Opp Pass Yards Per Gm 275 or More,Opp Pass Yards Per Gm 300 or More,Opp Pass Yards Per Gm 350 or More,Win Streak of 2 or More,Win Streak of 3 or More,Win Streak of 4 or More,Win Streak of 5 or More,Win Streak of 6 or More,Win Streak of 7 or More,Win Streak of 10 or More,Win Streak of 12 or More,Loss Streak of 2 or More,Loss Streak of 3 or More,Loss Streak of 4 or More,Loss Streak of 5 or More,Loss Streak of 6 or More,Loss Streak of 7 or More,Loss Streak of 10 or More,Loss Streak of 12 or More,Home Win Streak of 2 or More,Home Win Streak of 3 or More,Home Win Streak of 4 or More,Home Win Streak of 5 or More,Home Win Streak of 6 or More,Home Win Streak of 7 or More,Home Win Streak of 10 or More,Home Win Streak of 12 or More,Home Loss Streak of 2 or More,Home Loss Streak of 3 or More,Home Loss Streak of 4 or More,Home Loss Streak of 5 or More,Home Loss Streak of 6 or More,Home Loss Streak of 7 or More,Home Loss Streak of 10 or More,Home Loss Streak of 12 or More,Away Win Streak of 2 or More,Away Win Streak of 3 or More,Away Win Streak of 4 or More,Away Win Streak of 5 or More,Away Win Streak of 6 or More,Away Win Streak of 7 or More,Away Win Streak of 10 or More,Away Win Streak of 12 or More,Away Loss Streak of 2 or More,Away Loss Streak of 3 or More,Away Loss Streak of 4 or More,Away Loss Streak of 5 or More,Away Loss Streak of 6 or More,Away Loss Streak of 7 or More,Away Loss Streak of 10 or More,Away Loss Streak of 12 or More,Opp Win Streak of 2 or More,Opp Win Streak of 3 or More,Opp Win Streak of 4 or More,Opp Win Streak of 5 or More,Opp Win Streak of 6 or More,Opp Win Streak of 7 or More,Opp Win Streak of 10 or More,Opp Win Streak of 12 or More,Opp Loss Streak of 2 or More,Opp Loss Streak of 3 or More,Opp Loss Streak of 4 or More,Opp Loss Streak of 5 or More,Opp Loss Streak of 6 or More,Opp Loss Streak of 7 or More,Opp Loss Streak of 10 or More,Opp Loss Streak of 12 or More,Opp Home Win Streak of 2 or More,Opp Home Win Streak of 3 or More,Opp Home Win Streak of 4 or More,Opp Home Win Streak of 5 or More,Opp Home Win Streak of 6 or More,Opp Home Win Streak of 7 or More,Opp Home Win Streak of 10 or More,Opp Home Win Streak of 12 or More,Opp Home Loss Streak of 2 or More,Opp Home Loss Streak of 3 or More,Opp Home Loss Streak of 4 or More,Opp Home Loss Streak of 5 or More,Opp Home Loss Streak of 6 or More,Opp Home Loss Streak of 7 or More,Opp Home Loss Streak of 10 or More,Opp Home Loss Streak of 12 or More,Opp Away Win Streak of 2 or More,Opp Away Win Streak of 3 or More,Opp Away Win Streak of 4 or More,Opp Away Win Streak of 5 or More,Opp Away Win Streak of 6 or More,Opp Away Win Streak of 7 or More,Opp Away Win Streak of 10 or More,Opp Away Win Streak of 12 or More,Opp Away Loss Streak of 2 or More,Opp Away Loss Streak of 3 or More,Opp Away Loss Streak of 4 or More,Opp Away Loss Streak of 5 or More,Opp Away Loss Streak of 6 or More,Opp Away Loss Streak of 7 or More,Opp Away Loss Streak of 10 or More,Opp Away Loss Streak of 12 or More,Games Played 2 or Less,Games Played 4 or Less,Games Played 6 or Less,Games Played 8 or Less,Games Played 10 or Less,Games Played 12 or Less,Games Played 2 or More,Games Played 4 or More,Games Played 6 or More,Games Played 8 or More,Games Played 10 or More,Games Played 12 or More,Wins 2 or Less,Wins 4 or Less,Wins 6 or Less,Wins 8 or Less,Wins 10 or Less,Wins 12 or Less,Wins 2 or More,Wins 4 or More,Wins 6 or More,Wins 8 or More,Wins 10 or More,Wins 12 or More,Opp Wins 2 or Less,Opp Wins 4 or Less,Opp Wins 6 or Less,Opp Wins 8 or Less,Opp Wins 10 or Less,Opp Wins 12 or Less,Opp Wins 2 or More,Opp Wins 4 or More,Opp Wins 6 or More,Opp Wins 8 or More,Opp Wins 10 or More,Opp Wins 12 or More,Thursday,Saturday,Sunday,Monday,Not Sunday,Grass,Turf,Probability of Win 25% or Less,Probability of Win 30% or Less,Probability of Win 35% or Less,Probability of Win 40% or Less,Probability of Win 45% or Less,Probability of Win 50% or Less,Probability of Win 55% or Less,Probability of Win 60% or Less,Probability of Win 65% or Less,Probability of Win 70% or Less,Probability of Win 75% or Less,Probability of Win 80% or Less,Probability of Win 25% or More,Probability of Win 30% or More,Probability of Win 35% or More,Probability of Win 40% or More,Probability of Win 45% or More,Probability of Win 50% or More,Probability of Win 55% or More,Probability of Win 60% or More,Probability of Win 65% or More,Probability of Win 70% or More,Probability of Win 75% or More,Probability of Win 80% or More,Opp Probability of Win 25% or Less,Opp Probability of Win 30% or Less,Opp Probability of Win 35% or Less,Opp Probability of Win 40% or Less,Opp Probability of Win 45% or Less,Opp Probability of Win 50% or Less,Opp Probability of Win 55% or Less,Opp Probability of Win 60% or Less,Opp Probability of Win 65% or Less,Opp Probability of Win 70% or Less,Opp Probability of Win 75% or Less,Opp Probability of Win 80% or Less,Opp Probability of Win 25% or More,Opp Probability of Win 30% or More,Opp Probability of Win 35% or More,Opp Probability of Win 40% or More,Opp Probability of Win 45% or More,Opp Probability of Win 50% or More,Opp Probability of Win 55% or More,Opp Probability of Win 60% or More,Opp Probability of Win 65% or More,Opp Probability of Win 70% or More,Opp Probability of Win 75% or More,Opp Probability of Win 80% or More";

        private readonly FitnessConfig _fitnessConfig = new FitnessConfig();



        public List<StrategyResult> StrategyResultList = new List<StrategyResult>();

        public bool Initialize(Config cfg, string signalData , string leagueOutput)
        {
            var allData = new List<Data>();
            string retVal = string.Empty;
            var fitnessOptions = new FitnessOptions();
            var allResults = new List<Result>();
            var dataNFL = new List<NFL>();


            _fitnessConfig.setConfiguration(cfg);

            fitnessOptions.kelly_on = (char)1;
            fitnessOptions.kelly_half = (char)0;
            fitnessOptions.account_size = 10;
            fitnessOptions.bet_style = cfg.betstyle;

            var signal = new Signal();
            
            signal.ReadSignalDataByLine(allData, signalData);

            //signal.ReadNFL(dataNFL, leagueOutput);

            StrategyResultList.Clear();

            Random rnd = new Random();



            for (var T = 0; T < cfg.numStrategies; T++)
            //Parallel.For(0, cfg.numStrategies, T =>
            {

                StrategyResult R = new StrategyResult();
                R.BestProfit = 0;
                R.min = 99999999;

                R.combinedColumn = signal.combineSignals(allData, R.combinedData, cfg);

                SortedDictionary<string, ResultData> basePlotData = new SortedDictionary<string, ResultData>();
                

                int u;
                for (u = 0; u < allData.Count; u++)
                {
                    if (!(String.Compare(cfg.start_date , allData[u].DATE ) <= 0 &&  String.Compare( allData[u].DATE , cfg.end_date ) <= 0  ) )
                        continue;

                    //int finalResult = signal.fitness(combinedSignal.signal, fitnessOptions, dataNFL);
                    if (R.combinedData[u] == 0)
                    {
                        R.combinedNullCount++;
                        continue;
                    }

                    int finalResult = 0;

                    if (fitnessOptions.bet_style == BetStyle.spread)
                    {
                        if (allData[u].PT + allData[u].SPREAD > allData[u].PTA)
                        {
                            finalResult += 100;
                        }
                        else { finalResult -= 100; }
                    }

                    if (fitnessOptions.bet_style == BetStyle.over) // and user selected over
                    {
                        if (allData[u].PT + allData[u].PTA > allData[u].OU)
                        {
                            finalResult += 100;
                        }
                        else { finalResult -= 100; }
                    }
                    if (fitnessOptions.bet_style == BetStyle.under) // and user selected over
                    {
                        if (allData[u].PT + allData[u].PTA < allData[u].OU)
                        {
                            finalResult += 100;
                        }
                        else { finalResult -= 100; }
                    }
                    if (fitnessOptions.bet_style == BetStyle.moneyline)
                    {
                        if (allData[u].PT > allData[u].PTA)
                        {
                            finalResult += allData[u].ML > 0 ? allData[u].ML : 100;
                        }
                        else { finalResult -= allData[u].ML > 0 ? 100 : allData[u].ML * -1; }
                    }
               


                    if (finalResult > 0)
                    {
                        R.total_win += finalResult;
                        R.win += finalResult;
                    }
                    else
                    {
                        R.total_loss += finalResult;
                        R.loss += finalResult;
                    }
                    R.sum += finalResult;

                    //int finalResult = rnd.Next(300) - 149;

                    // if (allData[u].combined_signal > 0 && finalResult >= cfg.fitnessValue)
                            

                    if (R.dateToAccumulate.ContainsKey(allData[u].DATE))
                    {
                        R.dateToAccumulate[allData[u].DATE].value += finalResult;
                        R.dateToAccumulate[allData[u].DATE].count++;
                    }
                    else
                    {
                        R.dateToAccumulate[allData[u].DATE] = new ResultData
                        {
                            value = finalResult,
                            count = 1
                        };
                    }

                    var Y = allData[u].DATE.Substring(0, 4);
                    if (R.yearToAccumulate.ContainsKey(Y))
                    {
                        R.yearToAccumulate[Y].value += finalResult;
                        R.yearToAccumulate[Y].count++;
                    }
                    else
                    {
                        R.yearToAccumulate[Y] = new ResultData
                        {
                            value = finalResult,
                            count = 1
                        };
                    }

                    var M = allData[u].DATE.Substring(0, 6);
                    if (R.monthToAccumulate.ContainsKey(M))
                    {
                        R.monthToAccumulate[M].value += finalResult;
                        R.monthToAccumulate[M].count++;
                    }
                    else
                    {
                        R.monthToAccumulate[M] = new ResultData
                        {
                            value = finalResult,
                            count = 1
                        };
                    }

                    if (basePlotData.ContainsKey(allData[u].DATE))
                    {
                        R.sum += finalResult;
                        if (finalResult > 0)
                        {
                            R.total_win += finalResult;
                            R.win += finalResult;
                        }
                        else
                        {
                            R.total_loss += finalResult;
                            R.loss += finalResult;
                        }

                        basePlotData[allData[u].DATE].value += finalResult;
                        basePlotData[allData[u].DATE].count++;
                    }
                    else
                    {
                        basePlotData[allData[u].DATE] = new ResultData
                        {
                            value = finalResult,
                            count = 1
                        };
                    }
                }

         
                int j;
                for (j = 0; j < cfg.testsPerGeneration; j++)
                {
                    SortedDictionary<string, ResultData> onePlotData =new SortedDictionary<string, ResultData>();;

                    int s;
                    foreach (KeyValuePair<string, ResultData> entry in basePlotData)
                        onePlotData.Add(entry.Key, entry.Value);

                    for ( s = 0; s < onePlotData.Count; s++)
                    {
                        int xx = rnd.Next(onePlotData.Count);
                        int yy = rnd.Next(onePlotData.Count);
                        KeyValuePair<string, ResultData> tp1 = onePlotData.ElementAt(xx);
                        KeyValuePair<string, ResultData> tp2 = onePlotData.ElementAt(yy);
                        int V1 = tp1.Value.value;
                        int V2 = tp2.Value.value;
                        string Key1 = tp1.Key;
                        string Key2 = tp2.Key;
                        onePlotData[Key1] = new ResultData() { count = 1 , value = V2 };
                        onePlotData[Key2] = new ResultData() { count = 1 , value = V1 };
                    }
                    R.MonteData.Add(onePlotData);
            // rearrange onePlotData
                } 

                foreach (KeyValuePair<string, ResultData> entry in R.dateToAccumulate)
                {
                    if (entry.Value.value < R.min) R.min = entry.Value.value;
                }


                if (R.loss != 0 && (-(double)R.win) / (double)R.loss > R.BestProfit)
                    R.BestProfit = -(double)R.win / R.loss;
                   
                StrategyResultList.Add(R);
            //});
            }

            return true;
        }

        //public string PrintResults(List<Result> allResults)
        //{
        //    int i, j;

        //    StringBuilder sb = new StringBuilder();

        //    for (i = 0; i < allResults.Count; i++)
        //    {
        //        for (j = 0; j < allResults[i].signalsNames.Count; j++)
        //        {
        //            sb.AppendLine(allResults[i].signalsNames[j]);
        //        }
        //        sb.AppendLine("Final Result: " + allResults[i].finalResult);
        //    }
        //    return sb.ToString();
        //}

    }

}
