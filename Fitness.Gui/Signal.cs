using System;
using System.Collections.Concurrent;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Fitness.Gui
{
    internal class Signal
    {
        const string SignalNames =
               "Favorite,Underdog,Home,Away,Winning Record,Losing Record,Spread -3 or More,Spread -5 or More,Spread -7 or More,Spread -8 or More,Spread -10 or More,Spread -12 or More,Spread -15 or More,Spread -20 or More,Spread -3 or Less,Spread -5 or Less,Spread -7 or Less,Spread -8 or Less,Spread -10 or Less,Spread -12 or Less,Spread -15 or Less,Spread -20 or Less,Spread +3 or Less,Spread +5 or Less,Spread +7 or Less,Spread +8 or Less,Spread +10 or Less,Spread +12 or Less,Spread +15 or Less,Spread +20 or Less,Spread +3 or More,Spread +5 or More,Spread +7 or More,Spread +8 or More,Spread +10 or More,Spread +12 or More,Spread +15 or More,Spread +20 or More,OU Total <= 30,OU Total <= 35,OU Total <= 40,OU Total <= 45,OU Total <= 50,OU Total <= 55,OU Total <= 60,OU Total >= 30,OU Total >= 35,OU Total >= 40,OU Total >= 45,OU Total >= 50,OU Total >= 55,OU Total >= 60,MoneyLine -5000 or More,MoneyLine -2000 or More,MoneyLine -1000 or More,MoneyLine -800 or More,MoneyLine -600 or More,MoneyLine -500 or More,MoneyLine -400 or More,MoneyLine -350 or More,MoneyLine -300 or More,MoneyLine -250 or More,MoneyLine -200 or More,MoneyLine -150 or More,MoneyLine -125 or More,MoneyLine -100 or More,MoneyLine +100 or Less,MoneyLine +150 or Less,MoneyLine +200 or Less,MoneyLine +250 or Less,MoneyLine +300 or Less,MoneyLine +350 or Less,MoneyLine +400 or Less,MoneyLine +500 or Less,MoneyLine +600 or Less,MoneyLine +800 or Less,MoneyLine +1000 or Less,MoneyLine -5000 or Less,MoneyLine -2000 or Less,MoneyLine -1000 or Less,MoneyLine -800 or Less,MoneyLine -600 or Less,MoneyLine -500 or Less,MoneyLine -400 or Less,MoneyLine -350 or Less,MoneyLine -300 or Less,MoneyLine -250 or Less,MoneyLine -200 or Less,MoneyLine -150 or Less,MoneyLine -125 or Less,MoneyLine -100 or Less,MoneyLine -100 or More,MoneyLine -150 or More,MoneyLine -200 or More,MoneyLine -250 or More,MoneyLine -300 or More,MoneyLine -350 or More,MoneyLine -400 or More,MoneyLine -500 or More,MoneyLine -600 or More,MoneyLine -800 or More,MoneyLine -1000 or More,Pts Last gm 7 or Less,Pts Last gm 10 or Less,Pts Last gm 13 or Less,Pts Last gm 14 or Less,Pts Last gm 17 or Less,Pts Last gm 21 or Less,Pts Last gm 24 or Less,Pts Last gm 28 or Less,Pts Last gm 31 or Less,Pts Last gm 35 or Less,Pts Last gm 42 or Less,Pts Last gm 49 or Less,Pts Last gm 60 or Less,Pts Last gm 7 or More,Pts Last gm 10 or More,Pts Last gm 13 or More,Pts Last gm 14 or More,Pts Last gm 17 or More,Pts Last gm 21 or More,Pts Last gm 24 or More,Pts Last gm 28 or More,Pts Last gm 31 or More,Pts Last gm 35 or More,Pts Last gm 42 or More,Pts Last gm 49 or More,Pts Last gm 60 or More,Opp Pts Last gm 7 or Less,Opp Pts Last gm 10 or Less,Opp Pts Last gm 13 or Less,Opp Pts Last gm 14 or Less,Opp Pts Last gm 17 or Less,Opp Pts Last gm 21 or Less,Opp Pts Last gm 24 or Less,Opp Pts Last gm 28 or Less,Opp Pts Last gm 31 or Less,Opp Pts Last gm 35 or Less,Opp Pts Last gm 42 or Less,Opp Pts Last gm 49 or Less,Opp Pts Last gm 60 or Less,Opp Pts Last gm 7 or More,Opp Pts Last gm 10 or More,Opp Pts Last gm 13 or More,Opp Pts Last gm 14 or More,Opp Pts Last gm 17 or More,Opp Pts Last gm 21 or More,Opp Pts Last gm 24 or More,Opp Pts Last gm 28 or More,Opp Pts Last gm 31 or More,Opp Pts Last gm 35 or More,Opp Pts Last gm 42 or More,Opp Pts Last gm 49 or More,Opp Pts Last gm 60 or More,Yards Last gm 150 or Less,Yards Last gm 200 or Less,Yards Last gm 250 or Less,Yards Last gm 300 or Less,Yards Last gm 350 or Less,Yards Last gm 400 or Less,Yards Last gm 450 or Less,Yards Last gm 500 or Less,Yards Last gm 150 or More,Yards Last gm 200 or More,Yards Last gm 250 or More,Yards Last gm 300 or More,Yards Last gm 350 or More,Yards Last gm 400 or More,Yards Last gm 450 or More,Yards Last gm 500 or More,Opp Yards Last gm 150 or Less,Opp Yards Last gm 200 or Less,Opp Yards Last gm 250 or Less,Opp Yards Last gm 300 or Less,Opp Yards Last gm 350 or Less,Opp Yards Last gm 400 or Less,Opp Yards Last gm 450 or Less,Opp Yards Last gm 500 or Less,Opp Yards Last gm 150 or More,Opp Yards Last gm 200 or More,Opp Yards Last gm 250 or More,Opp Yards Last gm 300 or More,Opp Yards Last gm 350 or More,Opp Yards Last gm 400 or More,Opp Yards Last gm 450 or More,Opp Yards Last gm 500 or More,Rush Yards Last gm 50 or Less,Rush Yards Last gm 75 or Less,Rush Yards Last gm 100 or Less,Rush Yards Last gm 125 or Less,Rush Yards Last gm 200 or Less,Rush Yards Last gm 250 or Less,Rush Yards Last gm 300 or Less,Rush Yards Last gm 350 or Less,Rush Yards Last gm 50 or More,Rush Yards Last gm 75 or More,Rush Yards Last gm 100 or More,Rush Yards Last gm 125 or More,Rush Yards Last gm 200 or More,Rush Yards Last gm 250 or More,Rush Yards Last gm 300 or More,Rush Yards Last gm 350 or More,Opp Rush Yards Last gm 50 or Less,Opp Rush Yards Last gm 75 or Less,Opp Rush Yards Last gm 100 or Less,Opp Rush Yards Last gm 125 or Less,Opp Rush Yards Last gm 200 or Less,Opp Rush Yards Last gm 250 or Less,Opp Rush Yards Last gm 300 or Less,Opp Rush Yards Last gm 350 or Less,Opp Rush Yards Last gm 50 or More,Opp Rush Yards Last gm 75 or More,Opp Rush Yards Last gm 100 or More,Opp Rush Yards Last gm 125 or More,Opp Rush Yards Last gm 200 or More,Opp Rush Yards Last gm 250 or More,Opp Rush Yards Last gm 300 or More,Opp Rush Yards Last gm 350 or More,Pass Yards Last gm 50 or Less,Pass Yards Last gm 100 or Less,Pass Yards Last gm 125 or Less,Pass Yards Last gm 150 or Less,Pass Yards Last gm 200 or Less,Pass Yards Last gm 250 or Less,Pass Yards Last gm 300 or Less,Pass Yards Last gm 350 or Less,Pass Yards Last gm 400 or Less,Pass Yards Last gm 500 or Less,Pass Yards Last gm 50 or More,Pass Yards Last gm 100 or More,Pass Yards Last gm 125 or More,Pass Yards Last gm 150 or More,Pass Yards Last gm 200 or More,Pass Yards Last gm 250 or More,Pass Yards Last gm 300 or More,Pass Yards Last gm 350 or More,Pass Yards Last gm 400 or More,Pass Yards Last gm 500 or More,Opp Pass Yards Last gm 50 or Less,Opp Pass Yards Last gm 100 or Less,Opp Pass Yards Last gm 125 or Less,Opp Pass Yards Last gm 150 or Less,Opp Pass Yards Last gm 200 or Less,Opp Pass Yards Last gm 250 or Less,Opp Pass Yards Last gm 300 or Less,Opp Pass Yards Last gm 350 or Less,Opp Pass Yards Last gm 400 or Less,Opp Pass Yards Last gm 500 or Less,Opp Pass Yards Last gm 50 or More,Opp Pass Yards Last gm 100 or More,Opp Pass Yards Last gm 125 or More,Opp Pass Yards Last gm 150 or More,Opp Pass Yards Last gm 200 or More,Opp Pass Yards Last gm 250 or More,Opp Pass Yards Last gm 300 or More,Opp Pass Yards Last gm 350 or More,Opp Pass Yards Last gm 400 or More,Opp Pass Yards Last gm 500 or More,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 75% or Less,Winning Perc 80% or Less,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 75% or More,Winning Perc 80% or More,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 75% or Less,Opp Winning Perc 80% or Less,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 75% or More,Opp Winning Perc 80% or More,Points Per Gm 10 or Less,Points Per Gm 13 or Less,Points Per Gm 15 or Less,Points Per Gm 17 or Less,Points Per Gm 20 or Less,Points Per Gm 22 or Less,Points Per Gm 24 or Less,Points Per Gm 28 or Less,Points Per Gm 30 or Less,Points Per Gm 35 or Less,Points Per Gm 10 or More,Points Per Gm 13 or More,Points Per Gm 15 or More,Points Per Gm 17 or More,Points Per Gm 20 or More,Points Per Gm 22 or More,Points Per Gm 24 or More,Points Per Gm 28 or More,Points Per Gm 30 or More,Points Per Gm 35 or More,Opp Points Per Gm 10 or Less,Opp Points Per Gm 13 or Less,Opp Points Per Gm 15 or Less,Opp Points Per Gm 17 or Less,Opp Points Per Gm 20 or Less,Opp Points Per Gm 22 or Less,Opp Points Per Gm 24 or Less,Opp Points Per Gm 28 or Less,Opp Points Per Gm 30 or Less,Opp Points Per Gm 35 or Less,Opp Points Per Gm 10 or More,Opp Points Per Gm 13 or More,Opp Points Per Gm 15 or More,Opp Points Per Gm 17 or More,Opp Points Per Gm 20 or More,Opp Points Per Gm 22 or More,Opp Points Per Gm 24 or More,Opp Points Per Gm 28 or More,Opp Points Per Gm 30 or More,Opp Points Per Gm 35 or More,Yards Per Gm 250 or Less,Yards Per Gm 300 or Less,Yards Per Gm 350 or Less,Yards Per Gm 400 or Less,Yards Per Gm 450 or Less,Yards Per Gm 250 or More,Yards Per Gm 300 or More,Yards Per Gm 350 or More,Yards Per Gm 400 or More,Yards Per Gm 450 or More,Opp Yards Per Gm 250 or Less,Opp Yards Per Gm 300 or Less,Opp Yards Per Gm 350 or Less,Opp Yards Per Gm 400 or Less,Opp Yards Per Gm 450 or Less,Opp Yards Per Gm 250 or More,Opp Yards Per Gm 300 or More,Opp Yards Per Gm 350 or More,Opp Yards Per Gm 400 or More,Opp Yards Per Gm 450 or More,Rush Yards Per Gm 70 or Less,Rush Yards Per Gm 80 or Less,Rush Yards Per Gm 90 or Less,Rush Yards Per Gm 100 or Less,Rush Yards Per Gm 110 or Less,Rush Yards Per Gm 120 or Less,Rush Yards Per Gm 130 or Less,Rush Yards Per Gm 140 or Less,Rush Yards Per Gm 150 or Less,Rush Yards Per Gm 160 or Less,Rush Yards Per Gm 170 or Less,Rush Yards Per Gm 180 or Less,Rush Yards Per Gm 70 or More,Rush Yards Per Gm 80 or More,Rush Yards Per Gm 90 or More,Rush Yards Per Gm 100 or More,Rush Yards Per Gm 110 or More,Rush Yards Per Gm 120 or More,Rush Yards Per Gm 130 or More,Rush Yards Per Gm 140 or More,Rush Yards Per Gm 150 or More,Rush Yards Per Gm 160 or More,Rush Yards Per Gm 170 or More,Rush Yards Per Gm 180 or More,Opp Rush Yards Per Gm 70 or Less,Opp Rush Yards Per Gm 80 or Less,Opp Rush Yards Per Gm 90 or Less,Opp Rush Yards Per Gm 100 or Less,Opp Rush Yards Per Gm 110 or Less,Opp Rush Yards Per Gm 120 or Less,Opp Rush Yards Per Gm 130 or Less,Opp Rush Yards Per Gm 140 or Less,Opp Rush Yards Per Gm 150 or Less,Opp Rush Yards Per Gm 160 or Less,Opp Rush Yards Per Gm 170 or Less,Opp Rush Yards Per Gm 180 or Less,Opp Rush Yards Per Gm 70 or More,Opp Rush Yards Per Gm 80 or More,Opp Rush Yards Per Gm 90 or More,Opp Rush Yards Per Gm 100 or More,Opp Rush Yards Per Gm 110 or More,Opp Rush Yards Per Gm 120 or More,Opp Rush Yards Per Gm 130 or More,Opp Rush Yards Per Gm 140 or More,Opp Rush Yards Per Gm 150 or More,Opp Rush Yards Per Gm 160 or More,Opp Rush Yards Per Gm 170 or More,Opp Rush Yards Per Gm 180 or More,Pass Yards Per Gm 150 or Less,Pass Yards Per Gm 175 or Less,Pass Yards Per Gm 200 or Less,Pass Yards Per Gm 225 or Less,Pass Yards Per Gm 250 or Less,Pass Yards Per Gm 275 or Less,Pass Yards Per Gm 300 or Less,Pass Yards Per Gm 350 or Less,Pass Yards Per Gm 150 or More,Pass Yards Per Gm 175 or More,Pass Yards Per Gm 200 or More,Pass Yards Per Gm 225 or More,Pass Yards Per Gm 250 or More,Pass Yards Per Gm 275 or More,Pass Yards Per Gm 300 or More,Pass Yards Per Gm 350 or More,Opp Pass Yards Per Gm 150 or Less,Opp Pass Yards Per Gm 175 or Less,Opp Pass Yards Per Gm 200 or Less,Opp Pass Yards Per Gm 225 or Less,Opp Pass Yards Per Gm 250 or Less,Opp Pass Yards Per Gm 275 or Less,Opp Pass Yards Per Gm 300 or Less,Opp Pass Yards Per Gm 350 or Less,Opp Pass Yards Per Gm 150 or More,Opp Pass Yards Per Gm 175 or More,Opp Pass Yards Per Gm 200 or More,Opp Pass Yards Per Gm 225 or More,Opp Pass Yards Per Gm 250 or More,Opp Pass Yards Per Gm 275 or More,Opp Pass Yards Per Gm 300 or More,Opp Pass Yards Per Gm 350 or More,Win Streak of 2 or More,Win Streak of 3 or More,Win Streak of 4 or More,Win Streak of 5 or More,Win Streak of 6 or More,Win Streak of 7 or More,Win Streak of 10 or More,Win Streak of 12 or More,Loss Streak of 2 or More,Loss Streak of 3 or More,Loss Streak of 4 or More,Loss Streak of 5 or More,Loss Streak of 6 or More,Loss Streak of 7 or More,Loss Streak of 10 or More,Loss Streak of 12 or More,Home Win Streak of 2 or More,Home Win Streak of 3 or More,Home Win Streak of 4 or More,Home Win Streak of 5 or More,Home Win Streak of 6 or More,Home Win Streak of 7 or More,Home Win Streak of 10 or More,Home Win Streak of 12 or More,Home Loss Streak of 2 or More,Home Loss Streak of 3 or More,Home Loss Streak of 4 or More,Home Loss Streak of 5 or More,Home Loss Streak of 6 or More,Home Loss Streak of 7 or More,Home Loss Streak of 10 or More,Home Loss Streak of 12 or More,Away Win Streak of 2 or More,Away Win Streak of 3 or More,Away Win Streak of 4 or More,Away Win Streak of 5 or More,Away Win Streak of 6 or More,Away Win Streak of 7 or More,Away Win Streak of 10 or More,Away Win Streak of 12 or More,Away Loss Streak of 2 or More,Away Loss Streak of 3 or More,Away Loss Streak of 4 or More,Away Loss Streak of 5 or More,Away Loss Streak of 6 or More,Away Loss Streak of 7 or More,Away Loss Streak of 10 or More,Away Loss Streak of 12 or More,Opp Win Streak of 2 or More,Opp Win Streak of 3 or More,Opp Win Streak of 4 or More,Opp Win Streak of 5 or More,Opp Win Streak of 6 or More,Opp Win Streak of 7 or More,Opp Win Streak of 10 or More,Opp Win Streak of 12 or More,Opp Loss Streak of 2 or More,Opp Loss Streak of 3 or More,Opp Loss Streak of 4 or More,Opp Loss Streak of 5 or More,Opp Loss Streak of 6 or More,Opp Loss Streak of 7 or More,Opp Loss Streak of 10 or More,Opp Loss Streak of 12 or More,Opp Home Win Streak of 2 or More,Opp Home Win Streak of 3 or More,Opp Home Win Streak of 4 or More,Opp Home Win Streak of 5 or More,Opp Home Win Streak of 6 or More,Opp Home Win Streak of 7 or More,Opp Home Win Streak of 10 or More,Opp Home Win Streak of 12 or More,Opp Home Loss Streak of 2 or More,Opp Home Loss Streak of 3 or More,Opp Home Loss Streak of 4 or More,Opp Home Loss Streak of 5 or More,Opp Home Loss Streak of 6 or More,Opp Home Loss Streak of 7 or More,Opp Home Loss Streak of 10 or More,Opp Home Loss Streak of 12 or More,Opp Away Win Streak of 2 or More,Opp Away Win Streak of 3 or More,Opp Away Win Streak of 4 or More,Opp Away Win Streak of 5 or More,Opp Away Win Streak of 6 or More,Opp Away Win Streak of 7 or More,Opp Away Win Streak of 10 or More,Opp Away Win Streak of 12 or More,Opp Away Loss Streak of 2 or More,Opp Away Loss Streak of 3 or More,Opp Away Loss Streak of 4 or More,Opp Away Loss Streak of 5 or More,Opp Away Loss Streak of 6 or More,Opp Away Loss Streak of 7 or More,Opp Away Loss Streak of 10 or More,Opp Away Loss Streak of 12 or More,Games Played 2 or Less,Games Played 4 or Less,Games Played 6 or Less,Games Played 8 or Less,Games Played 10 or Less,Games Played 12 or Less,Games Played 2 or More,Games Played 4 or More,Games Played 6 or More,Games Played 8 or More,Games Played 10 or More,Games Played 12 or More,Wins 2 or Less,Wins 4 or Less,Wins 6 or Less,Wins 8 or Less,Wins 10 or Less,Wins 12 or Less,Wins 2 or More,Wins 4 or More,Wins 6 or More,Wins 8 or More,Wins 10 or More,Wins 12 or More,Opp Wins 2 or Less,Opp Wins 4 or Less,Opp Wins 6 or Less,Opp Wins 8 or Less,Opp Wins 10 or Less,Opp Wins 12 or Less,Opp Wins 2 or More,Opp Wins 4 or More,Opp Wins 6 or More,Opp Wins 8 or More,Opp Wins 10 or More,Opp Wins 12 or More,Thursday,Saturday,Sunday,Monday,Not Sunday,Grass,Turf,Probability of Win 25% or Less,Probability of Win 30% or Less,Probability of Win 35% or Less,Probability of Win 40% or Less,Probability of Win 45% or Less,Probability of Win 50% or Less,Probability of Win 55% or Less,Probability of Win 60% or Less,Probability of Win 65% or Less,Probability of Win 70% or Less,Probability of Win 75% or Less,Probability of Win 80% or Less,Probability of Win 25% or More,Probability of Win 30% or More,Probability of Win 35% or More,Probability of Win 40% or More,Probability of Win 45% or More,Probability of Win 50% or More,Probability of Win 55% or More,Probability of Win 60% or More,Probability of Win 65% or More,Probability of Win 70% or More,Probability of Win 75% or More,Probability of Win 80% or More,Opp Probability of Win 25% or Less,Opp Probability of Win 30% or Less,Opp Probability of Win 35% or Less,Opp Probability of Win 40% or Less,Opp Probability of Win 45% or Less,Opp Probability of Win 50% or Less,Opp Probability of Win 55% or Less,Opp Probability of Win 60% or Less,Opp Probability of Win 65% or Less,Opp Probability of Win 70% or Less,Opp Probability of Win 75% or Less,Opp Probability of Win 80% or Less,Opp Probability of Win 25% or More,Opp Probability of Win 30% or More,Opp Probability of Win 35% or More,Opp Probability of Win 40% or More,Opp Probability of Win 45% or More,Opp Probability of Win 50% or More,Opp Probability of Win 55% or More,Opp Probability of Win 60% or More,Opp Probability of Win 65% or More,Opp Probability of Win 70% or More,Opp Probability of Win 75% or More,Opp Probability of Win 80% or More";


        /**
         *******************************************************************************
         *
         * \brief Function for reading and parsing CSV file.
         *
         *        	Reads data from input CSV file, parses that data
         *			and fills appropriate structures.
         *
         * \param  data   			[OUT] 	Vector of all NFL data
         * \param  fileName   		[IN] 	CSV filename
         *
         * \return  void
         *
         *******************************************************************************
         */

        public void ReadNFL(List<NFL> data, string content)
        {

             
            var nflRow = new NFL();

            var fileLines = content.Split('\n');
            int i = 0;
            foreach (var line in fileLines)
            {

                var tokens = line.Split(',');
                // Spread -> 11. column
                nflRow.spread = Convert.ToDouble(tokens[11]);
                // Over-Under -> 12. column
                nflRow.ou = Convert.ToDouble(tokens[12]);
                // Points -> 13. column
                nflRow.pts = Convert.ToDouble(tokens[13]); //atof(row[13].c_str());
                // Points -> 14. column
                nflRow.ptsa = Convert.ToDouble(tokens[14]);
                // Moneyline -> 29. column
                nflRow.ml = Convert.ToDouble(tokens[29]);
                data.Add(nflRow);

            }

            
            //var retVal =data.Where(item => item == null).Count();
            //Console.WriteLine(retVal);
        }

        /**
         *******************************************************************************
         *
         * \brief Function for reading signals from file.
         *
         *        	Reads signals data from input file. Every row in file
         *			represents one signal.
         *
         * \param  allData   		[OUT] 	Vector of all signals data
         * \param  fileName   		[IN] 	Filename of signal data
         *
         * \return  void
         *
         *******************************************************************************
         */

        public void ReadSignalDataByLine(List<Data> allData, string content)
        {
            const string values =
                "Favorite,Underdog,Home,Away,Winning Record,Losing Record,Spread -3 or More,Spread -5 or More,Spread -7 or More,Spread -8 or More,Spread -10 or More,Spread -12 or More,Spread -15 or More,Spread -20 or More,Spread -3 or Less,Spread -5 or Less,Spread -7 or Less,Spread -8 or Less,Spread -10 or Less,Spread -12 or Less,Spread -15 or Less,Spread -20 or Less,Spread +3 or Less,Spread +5 or Less,Spread +7 or Less,Spread +8 or Less,Spread +10 or Less,Spread +12 or Less,Spread +15 or Less,Spread +20 or Less,Spread +3 or More,Spread +5 or More,Spread +7 or More,Spread +8 or More,Spread +10 or More,Spread +12 or More,Spread +15 or More,Spread +20 or More,OU Total <= 30,OU Total <= 35,OU Total <= 40,OU Total <= 45,OU Total <= 50,OU Total <= 55,OU Total <= 60,OU Total >= 30,OU Total >= 35,OU Total >= 40,OU Total >= 45,OU Total >= 50,OU Total >= 55,OU Total >= 60,MoneyLine -5000 or More,MoneyLine -2000 or More,MoneyLine -1000 or More,MoneyLine -800 or More,MoneyLine -600 or More,MoneyLine -500 or More,MoneyLine -400 or More,MoneyLine -350 or More,MoneyLine -300 or More,MoneyLine -250 or More,MoneyLine -200 or More,MoneyLine -150 or More,MoneyLine -125 or More,MoneyLine -100 or More,MoneyLine +100 or Less,MoneyLine +150 or Less,MoneyLine +200 or Less,MoneyLine +250 or Less,MoneyLine +300 or Less,MoneyLine +350 or Less,MoneyLine +400 or Less,MoneyLine +500 or Less,MoneyLine +600 or Less,MoneyLine +800 or Less,MoneyLine +1000 or Less,MoneyLine -5000 or Less,MoneyLine -2000 or Less,MoneyLine -1000 or Less,MoneyLine -800 or Less,MoneyLine -600 or Less,MoneyLine -500 or Less,MoneyLine -400 or Less,MoneyLine -350 or Less,MoneyLine -300 or Less,MoneyLine -250 or Less,MoneyLine -200 or Less,MoneyLine -150 or Less,MoneyLine -125 or Less,MoneyLine -100 or Less,MoneyLine -100 or More,MoneyLine -150 or More,MoneyLine -200 or More,MoneyLine -250 or More,MoneyLine -300 or More,MoneyLine -350 or More,MoneyLine -400 or More,MoneyLine -500 or More,MoneyLine -600 or More,MoneyLine -800 or More,MoneyLine -1000 or More,Pts Last gm 7 or Less,Pts Last gm 10 or Less,Pts Last gm 13 or Less,Pts Last gm 14 or Less,Pts Last gm 17 or Less,Pts Last gm 21 or Less,Pts Last gm 24 or Less,Pts Last gm 28 or Less,Pts Last gm 31 or Less,Pts Last gm 35 or Less,Pts Last gm 42 or Less,Pts Last gm 49 or Less,Pts Last gm 60 or Less,Pts Last gm 7 or More,Pts Last gm 10 or More,Pts Last gm 13 or More,Pts Last gm 14 or More,Pts Last gm 17 or More,Pts Last gm 21 or More,Pts Last gm 24 or More,Pts Last gm 28 or More,Pts Last gm 31 or More,Pts Last gm 35 or More,Pts Last gm 42 or More,Pts Last gm 49 or More,Pts Last gm 60 or More,Opp Pts Last gm 7 or Less,Opp Pts Last gm 10 or Less,Opp Pts Last gm 13 or Less,Opp Pts Last gm 14 or Less,Opp Pts Last gm 17 or Less,Opp Pts Last gm 21 or Less,Opp Pts Last gm 24 or Less,Opp Pts Last gm 28 or Less,Opp Pts Last gm 31 or Less,Opp Pts Last gm 35 or Less,Opp Pts Last gm 42 or Less,Opp Pts Last gm 49 or Less,Opp Pts Last gm 60 or Less,Opp Pts Last gm 7 or More,Opp Pts Last gm 10 or More,Opp Pts Last gm 13 or More,Opp Pts Last gm 14 or More,Opp Pts Last gm 17 or More,Opp Pts Last gm 21 or More,Opp Pts Last gm 24 or More,Opp Pts Last gm 28 or More,Opp Pts Last gm 31 or More,Opp Pts Last gm 35 or More,Opp Pts Last gm 42 or More,Opp Pts Last gm 49 or More,Opp Pts Last gm 60 or More,Yards Last gm 150 or Less,Yards Last gm 200 or Less,Yards Last gm 250 or Less,Yards Last gm 300 or Less,Yards Last gm 350 or Less,Yards Last gm 400 or Less,Yards Last gm 450 or Less,Yards Last gm 500 or Less,Yards Last gm 150 or More,Yards Last gm 200 or More,Yards Last gm 250 or More,Yards Last gm 300 or More,Yards Last gm 350 or More,Yards Last gm 400 or More,Yards Last gm 450 or More,Yards Last gm 500 or More,Opp Yards Last gm 150 or Less,Opp Yards Last gm 200 or Less,Opp Yards Last gm 250 or Less,Opp Yards Last gm 300 or Less,Opp Yards Last gm 350 or Less,Opp Yards Last gm 400 or Less,Opp Yards Last gm 450 or Less,Opp Yards Last gm 500 or Less,Opp Yards Last gm 150 or More,Opp Yards Last gm 200 or More,Opp Yards Last gm 250 or More,Opp Yards Last gm 300 or More,Opp Yards Last gm 350 or More,Opp Yards Last gm 400 or More,Opp Yards Last gm 450 or More,Opp Yards Last gm 500 or More,Rush Yards Last gm 50 or Less,Rush Yards Last gm 75 or Less,Rush Yards Last gm 100 or Less,Rush Yards Last gm 125 or Less,Rush Yards Last gm 200 or Less,Rush Yards Last gm 250 or Less,Rush Yards Last gm 300 or Less,Rush Yards Last gm 350 or Less,Rush Yards Last gm 50 or More,Rush Yards Last gm 75 or More,Rush Yards Last gm 100 or More,Rush Yards Last gm 125 or More,Rush Yards Last gm 200 or More,Rush Yards Last gm 250 or More,Rush Yards Last gm 300 or More,Rush Yards Last gm 350 or More,Opp Rush Yards Last gm 50 or Less,Opp Rush Yards Last gm 75 or Less,Opp Rush Yards Last gm 100 or Less,Opp Rush Yards Last gm 125 or Less,Opp Rush Yards Last gm 200 or Less,Opp Rush Yards Last gm 250 or Less,Opp Rush Yards Last gm 300 or Less,Opp Rush Yards Last gm 350 or Less,Opp Rush Yards Last gm 50 or More,Opp Rush Yards Last gm 75 or More,Opp Rush Yards Last gm 100 or More,Opp Rush Yards Last gm 125 or More,Opp Rush Yards Last gm 200 or More,Opp Rush Yards Last gm 250 or More,Opp Rush Yards Last gm 300 or More,Opp Rush Yards Last gm 350 or More,Pass Yards Last gm 50 or Less,Pass Yards Last gm 100 or Less,Pass Yards Last gm 125 or Less,Pass Yards Last gm 150 or Less,Pass Yards Last gm 200 or Less,Pass Yards Last gm 250 or Less,Pass Yards Last gm 300 or Less,Pass Yards Last gm 350 or Less,Pass Yards Last gm 400 or Less,Pass Yards Last gm 500 or Less,Pass Yards Last gm 50 or More,Pass Yards Last gm 100 or More,Pass Yards Last gm 125 or More,Pass Yards Last gm 150 or More,Pass Yards Last gm 200 or More,Pass Yards Last gm 250 or More,Pass Yards Last gm 300 or More,Pass Yards Last gm 350 or More,Pass Yards Last gm 400 or More,Pass Yards Last gm 500 or More,Opp Pass Yards Last gm 50 or Less,Opp Pass Yards Last gm 100 or Less,Opp Pass Yards Last gm 125 or Less,Opp Pass Yards Last gm 150 or Less,Opp Pass Yards Last gm 200 or Less,Opp Pass Yards Last gm 250 or Less,Opp Pass Yards Last gm 300 or Less,Opp Pass Yards Last gm 350 or Less,Opp Pass Yards Last gm 400 or Less,Opp Pass Yards Last gm 500 or Less,Opp Pass Yards Last gm 50 or More,Opp Pass Yards Last gm 100 or More,Opp Pass Yards Last gm 125 or More,Opp Pass Yards Last gm 150 or More,Opp Pass Yards Last gm 200 or More,Opp Pass Yards Last gm 250 or More,Opp Pass Yards Last gm 300 or More,Opp Pass Yards Last gm 350 or More,Opp Pass Yards Last gm 400 or More,Opp Pass Yards Last gm 500 or More,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 25% or Less,Winning Perc 75% or Less,Winning Perc 80% or Less,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 25% or More,Winning Perc 75% or More,Winning Perc 80% or More,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 25% or Less,Opp Winning Perc 75% or Less,Opp Winning Perc 80% or Less,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 25% or More,Opp Winning Perc 75% or More,Opp Winning Perc 80% or More,Points Per Gm 10 or Less,Points Per Gm 13 or Less,Points Per Gm 15 or Less,Points Per Gm 17 or Less,Points Per Gm 20 or Less,Points Per Gm 22 or Less,Points Per Gm 24 or Less,Points Per Gm 28 or Less,Points Per Gm 30 or Less,Points Per Gm 35 or Less,Points Per Gm 10 or More,Points Per Gm 13 or More,Points Per Gm 15 or More,Points Per Gm 17 or More,Points Per Gm 20 or More,Points Per Gm 22 or More,Points Per Gm 24 or More,Points Per Gm 28 or More,Points Per Gm 30 or More,Points Per Gm 35 or More,Opp Points Per Gm 10 or Less,Opp Points Per Gm 13 or Less,Opp Points Per Gm 15 or Less,Opp Points Per Gm 17 or Less,Opp Points Per Gm 20 or Less,Opp Points Per Gm 22 or Less,Opp Points Per Gm 24 or Less,Opp Points Per Gm 28 or Less,Opp Points Per Gm 30 or Less,Opp Points Per Gm 35 or Less,Opp Points Per Gm 10 or More,Opp Points Per Gm 13 or More,Opp Points Per Gm 15 or More,Opp Points Per Gm 17 or More,Opp Points Per Gm 20 or More,Opp Points Per Gm 22 or More,Opp Points Per Gm 24 or More,Opp Points Per Gm 28 or More,Opp Points Per Gm 30 or More,Opp Points Per Gm 35 or More,Yards Per Gm 250 or Less,Yards Per Gm 300 or Less,Yards Per Gm 350 or Less,Yards Per Gm 400 or Less,Yards Per Gm 450 or Less,Yards Per Gm 250 or More,Yards Per Gm 300 or More,Yards Per Gm 350 or More,Yards Per Gm 400 or More,Yards Per Gm 450 or More,Opp Yards Per Gm 250 or Less,Opp Yards Per Gm 300 or Less,Opp Yards Per Gm 350 or Less,Opp Yards Per Gm 400 or Less,Opp Yards Per Gm 450 or Less,Opp Yards Per Gm 250 or More,Opp Yards Per Gm 300 or More,Opp Yards Per Gm 350 or More,Opp Yards Per Gm 400 or More,Opp Yards Per Gm 450 or More,Rush Yards Per Gm 70 or Less,Rush Yards Per Gm 80 or Less,Rush Yards Per Gm 90 or Less,Rush Yards Per Gm 100 or Less,Rush Yards Per Gm 110 or Less,Rush Yards Per Gm 120 or Less,Rush Yards Per Gm 130 or Less,Rush Yards Per Gm 140 or Less,Rush Yards Per Gm 150 or Less,Rush Yards Per Gm 160 or Less,Rush Yards Per Gm 170 or Less,Rush Yards Per Gm 180 or Less,Rush Yards Per Gm 70 or More,Rush Yards Per Gm 80 or More,Rush Yards Per Gm 90 or More,Rush Yards Per Gm 100 or More,Rush Yards Per Gm 110 or More,Rush Yards Per Gm 120 or More,Rush Yards Per Gm 130 or More,Rush Yards Per Gm 140 or More,Rush Yards Per Gm 150 or More,Rush Yards Per Gm 160 or More,Rush Yards Per Gm 170 or More,Rush Yards Per Gm 180 or More,Opp Rush Yards Per Gm 70 or Less,Opp Rush Yards Per Gm 80 or Less,Opp Rush Yards Per Gm 90 or Less,Opp Rush Yards Per Gm 100 or Less,Opp Rush Yards Per Gm 110 or Less,Opp Rush Yards Per Gm 120 or Less,Opp Rush Yards Per Gm 130 or Less,Opp Rush Yards Per Gm 140 or Less,Opp Rush Yards Per Gm 150 or Less,Opp Rush Yards Per Gm 160 or Less,Opp Rush Yards Per Gm 170 or Less,Opp Rush Yards Per Gm 180 or Less,Opp Rush Yards Per Gm 70 or More,Opp Rush Yards Per Gm 80 or More,Opp Rush Yards Per Gm 90 or More,Opp Rush Yards Per Gm 100 or More,Opp Rush Yards Per Gm 110 or More,Opp Rush Yards Per Gm 120 or More,Opp Rush Yards Per Gm 130 or More,Opp Rush Yards Per Gm 140 or More,Opp Rush Yards Per Gm 150 or More,Opp Rush Yards Per Gm 160 or More,Opp Rush Yards Per Gm 170 or More,Opp Rush Yards Per Gm 180 or More,Pass Yards Per Gm 150 or Less,Pass Yards Per Gm 175 or Less,Pass Yards Per Gm 200 or Less,Pass Yards Per Gm 225 or Less,Pass Yards Per Gm 250 or Less,Pass Yards Per Gm 275 or Less,Pass Yards Per Gm 300 or Less,Pass Yards Per Gm 350 or Less,Pass Yards Per Gm 150 or More,Pass Yards Per Gm 175 or More,Pass Yards Per Gm 200 or More,Pass Yards Per Gm 225 or More,Pass Yards Per Gm 250 or More,Pass Yards Per Gm 275 or More,Pass Yards Per Gm 300 or More,Pass Yards Per Gm 350 or More,Opp Pass Yards Per Gm 150 or Less,Opp Pass Yards Per Gm 175 or Less,Opp Pass Yards Per Gm 200 or Less,Opp Pass Yards Per Gm 225 or Less,Opp Pass Yards Per Gm 250 or Less,Opp Pass Yards Per Gm 275 or Less,Opp Pass Yards Per Gm 300 or Less,Opp Pass Yards Per Gm 350 or Less,Opp Pass Yards Per Gm 150 or More,Opp Pass Yards Per Gm 175 or More,Opp Pass Yards Per Gm 200 or More,Opp Pass Yards Per Gm 225 or More,Opp Pass Yards Per Gm 250 or More,Opp Pass Yards Per Gm 275 or More,Opp Pass Yards Per Gm 300 or More,Opp Pass Yards Per Gm 350 or More,Win Streak of 2 or More,Win Streak of 3 or More,Win Streak of 4 or More,Win Streak of 5 or More,Win Streak of 6 or More,Win Streak of 7 or More,Win Streak of 10 or More,Win Streak of 12 or More,Loss Streak of 2 or More,Loss Streak of 3 or More,Loss Streak of 4 or More,Loss Streak of 5 or More,Loss Streak of 6 or More,Loss Streak of 7 or More,Loss Streak of 10 or More,Loss Streak of 12 or More,Home Win Streak of 2 or More,Home Win Streak of 3 or More,Home Win Streak of 4 or More,Home Win Streak of 5 or More,Home Win Streak of 6 or More,Home Win Streak of 7 or More,Home Win Streak of 10 or More,Home Win Streak of 12 or More,Home Loss Streak of 2 or More,Home Loss Streak of 3 or More,Home Loss Streak of 4 or More,Home Loss Streak of 5 or More,Home Loss Streak of 6 or More,Home Loss Streak of 7 or More,Home Loss Streak of 10 or More,Home Loss Streak of 12 or More,Away Win Streak of 2 or More,Away Win Streak of 3 or More,Away Win Streak of 4 or More,Away Win Streak of 5 or More,Away Win Streak of 6 or More,Away Win Streak of 7 or More,Away Win Streak of 10 or More,Away Win Streak of 12 or More,Away Loss Streak of 2 or More,Away Loss Streak of 3 or More,Away Loss Streak of 4 or More,Away Loss Streak of 5 or More,Away Loss Streak of 6 or More,Away Loss Streak of 7 or More,Away Loss Streak of 10 or More,Away Loss Streak of 12 or More,Opp Win Streak of 2 or More,Opp Win Streak of 3 or More,Opp Win Streak of 4 or More,Opp Win Streak of 5 or More,Opp Win Streak of 6 or More,Opp Win Streak of 7 or More,Opp Win Streak of 10 or More,Opp Win Streak of 12 or More,Opp Loss Streak of 2 or More,Opp Loss Streak of 3 or More,Opp Loss Streak of 4 or More,Opp Loss Streak of 5 or More,Opp Loss Streak of 6 or More,Opp Loss Streak of 7 or More,Opp Loss Streak of 10 or More,Opp Loss Streak of 12 or More,Opp Home Win Streak of 2 or More,Opp Home Win Streak of 3 or More,Opp Home Win Streak of 4 or More,Opp Home Win Streak of 5 or More,Opp Home Win Streak of 6 or More,Opp Home Win Streak of 7 or More,Opp Home Win Streak of 10 or More,Opp Home Win Streak of 12 or More,Opp Home Loss Streak of 2 or More,Opp Home Loss Streak of 3 or More,Opp Home Loss Streak of 4 or More,Opp Home Loss Streak of 5 or More,Opp Home Loss Streak of 6 or More,Opp Home Loss Streak of 7 or More,Opp Home Loss Streak of 10 or More,Opp Home Loss Streak of 12 or More,Opp Away Win Streak of 2 or More,Opp Away Win Streak of 3 or More,Opp Away Win Streak of 4 or More,Opp Away Win Streak of 5 or More,Opp Away Win Streak of 6 or More,Opp Away Win Streak of 7 or More,Opp Away Win Streak of 10 or More,Opp Away Win Streak of 12 or More,Opp Away Loss Streak of 2 or More,Opp Away Loss Streak of 3 or More,Opp Away Loss Streak of 4 or More,Opp Away Loss Streak of 5 or More,Opp Away Loss Streak of 6 or More,Opp Away Loss Streak of 7 or More,Opp Away Loss Streak of 10 or More,Opp Away Loss Streak of 12 or More,Games Played 2 or Less,Games Played 4 or Less,Games Played 6 or Less,Games Played 8 or Less,Games Played 10 or Less,Games Played 12 or Less,Games Played 2 or More,Games Played 4 or More,Games Played 6 or More,Games Played 8 or More,Games Played 10 or More,Games Played 12 or More,Wins 2 or Less,Wins 4 or Less,Wins 6 or Less,Wins 8 or Less,Wins 10 or Less,Wins 12 or Less,Wins 2 or More,Wins 4 or More,Wins 6 or More,Wins 8 or More,Wins 10 or More,Wins 12 or More,Opp Wins 2 or Less,Opp Wins 4 or Less,Opp Wins 6 or Less,Opp Wins 8 or Less,Opp Wins 10 or Less,Opp Wins 12 or Less,Opp Wins 2 or More,Opp Wins 4 or More,Opp Wins 6 or More,Opp Wins 8 or More,Opp Wins 10 or More,Opp Wins 12 or More,Thursday,Saturday,Sunday,Monday,Not Sunday,Grass,Turf,Probability of Win 25% or Less,Probability of Win 30% or Less,Probability of Win 35% or Less,Probability of Win 40% or Less,Probability of Win 45% or Less,Probability of Win 50% or Less,Probability of Win 55% or Less,Probability of Win 60% or Less,Probability of Win 65% or Less,Probability of Win 70% or Less,Probability of Win 75% or Less,Probability of Win 80% or Less,Probability of Win 25% or More,Probability of Win 30% or More,Probability of Win 35% or More,Probability of Win 40% or More,Probability of Win 45% or More,Probability of Win 50% or More,Probability of Win 55% or More,Probability of Win 60% or More,Probability of Win 65% or More,Probability of Win 70% or More,Probability of Win 75% or More,Probability of Win 80% or More,Opp Probability of Win 25% or Less,Opp Probability of Win 30% or Less,Opp Probability of Win 35% or Less,Opp Probability of Win 40% or Less,Opp Probability of Win 45% or Less,Opp Probability of Win 50% or Less,Opp Probability of Win 55% or Less,Opp Probability of Win 60% or Less,Opp Probability of Win 65% or Less,Opp Probability of Win 70% or Less,Opp Probability of Win 75% or Less,Opp Probability of Win 80% or Less,Opp Probability of Win 25% or More,Opp Probability of Win 30% or More,Opp Probability of Win 35% or More,Opp Probability of Win 40% or More,Opp Probability of Win 45% or More,Opp Probability of Win 50% or More,Opp Probability of Win 55% or More,Opp Probability of Win 60% or More,Opp Probability of Win 65% or More,Opp Probability of Win 70% or More,Opp Probability of Win 75% or More,Opp Probability of Win 80% or More";
            var headers = values.Split(',');
            var fileLines = content.Split('\n');
            int i = 0;
            foreach (var line in fileLines)
            {
                if (line.Contains("Favorite,Underdog"))
                    continue;

                var d = new Data { signal = new List<char>() };

                var tokens = line.Split(',');
                var pos = 0;
                foreach (var token in tokens)
                {
                    switch( pos )
                    {
                        case 0:
                            d.DATE = token;
                            break;
                        case 1:
                            d.DAY = token;
                            break;
                        case 2:
                            d.TEAM = token;
                            break;
                        case 3:
                            d.DIV = token;
                            break;
                        case 4:
                            d.OTEAM = token;
                            break;
                        case 5:
                            d.ODIV = token;
                            break;
                        case 6:
                            d.SPREAD = double.Parse(token);
                            break;
                        case 7:
                            d.OU = double.Parse(token);
                            break;
                        case 8:
                            d.ML = int.Parse(token);
                            break;
                        case 9:
                            d.PT = double.Parse(token);
                            break;
                        case 10:
                            d.PTA = double.Parse(token);
                            break;
                        default:
                            d.signal.AddRange(token);
                            break;
                    }
                    pos++;
                }

                allData.Add(d);
                i++;
            }
        }


/**
 *******************************************************************************
 *
 * \brief Function for reading signals names from file.
 *
 *        	Reads signals names from input file. Every row in file
 *			represents one signal name.
 *
 * \param  allData   		[OUT] 	Vector of all signals data
 * \param  fileName   		[IN] 	Filename of signals names
 *
 * \return  void
 *
 *******************************************************************************
 */
  
         
        public string combineSignals(List<Data> src , List<int> dst, Config cfg)
        {
            int i, j;
            
            string selectedSignalNames = "";
            bool updated = false;

            while (!updated)
            {
                var signalIndex = new List<int>();
                Random rnd = new Random();
                int numRules = (rnd.Next(cfg.maxNumOfRules - cfg.minNumOfRules + 1)) + cfg.minNumOfRules;
                dst.Clear();
                selectedSignalNames = "";

                var headers = SignalNames.Split(',');
                // Random signals
                for (i = 0; i < numRules; i++)
                {
                    int id = rnd.Next(400);
                    signalIndex.Add(id);
                    selectedSignalNames = selectedSignalNames + "," + headers[id];
                }

                updated = false;

                for (j = 0; j < src.Count; j++)
                {
                    int v = 0;
                    for (i = 0; i < numRules; i++)
                    {
                        int index = signalIndex[i];
                        v += src[j].signal[index] == '1' ? 1 : 0;
                    }
                    dst.Add(v == numRules ? 1 : 0);
                    if (v == numRules) updated = true;
                }
            }
            return selectedSignalNames;

        } 


/**
 *******************************************************************************
 *
 * \brief Function for padding signal values.
 *
 *        	Adds random signal values (0 or 1) in order to
 *			signal length be same as number of rows in NFL file
 *
 * \param  allData   		[IN] 	Vector of all signals data
 * \param  data			    [IN] 	NFL data
 *
 * \return  void
 *
 *******************************************************************************
 */

        public void signalPadding(List<Data> allData, List<NFL> data)
        {
            int i, j;
            Random rnd = new Random();
            for (i = 0; i < allData.Count; i++)
            {
                if (data.Count > allData[i].signal.Count)
                {
                    int count = data.Count - allData[i].signal.Count;
                    for (j = 0; j < count; j++)
                    {
                        allData[i].signal.Add((char)rnd.Next(2));
                    }
                }
            }
        }

        /**
         *******************************************************************************
         *
         * \brief Fitness Function.
         *
         *        Sequential fitness function.
         *
         * \param  signals   		[IN] 	Vector of signals data
         * \param  fitnessOptions   [IN] 	Options for fitness function
         * \param  data   			[IN] 	NFL data
         *
         * \return  void
         *
         *******************************************************************************
         */
 



        /**
         *******************************************************************************
         *
         * \brief Fitness Function.
         *
         *        Multithread fitness function.
         *
         * \param  signals   		[IN] 	Vector of signals data
         * \param  fitnessOptions   [IN] 	Options for fitness function
         * \param  data   			[IN] 	NFL data
         * \param  ret   			[OUT] 	Return value from fitness function
         *
         * \return  void
         *
         *******************************************************************************
         */
 


/**
 *******************************************************************************
 *
 * \brief Function for reading signal from file.
 *
 *        Reads signal data from input file.
 *
 * \param  signalData   	[OUT] 	Vector of signal data
 * \param  fileName   		[IN] 	Filename of signal data
 *
 * \return  void
 *
 *******************************************************************************
 */

        public void readSignalData(List<char> signalData, string fileName)
        {
            var file = new StreamReader(fileName);

            //if (file.is_open())
            {
                while (!file.EndOfStream)
                {
                    var signal =(char)file.Read();
                    //TODO: chek for the ascii code of space
                    if (signal != ' ')
                    {
                        signalData.Add(signal);
                    }
                }
                file.Close();
            }
            //else
            {
                Console.WriteLine("Error opening file!");
            }
        }
    }
}
