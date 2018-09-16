using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Fitness.Gui
{
    /**
 *******************************************************************************
 *
 * \brief Configuration object.
 *
 *******************************************************************************
 */

    public class Config
    {
        public int numStrategies;
        
        public int testsPerGeneration;

        public int minNumOfRules;

        public int maxNumOfRules;

        public string start_date , end_date;

        public int fitnessValue;

        public int PT_ON, SL_ON, HH_ON, LL_ON;

        public int max_time, prof_x;

        public int fitness;

        public double pt_mult, sl_mult;

        public BetStyle betstyle;

    }

    public class FitnessConfig
    {

        public const int BINARY = 2;
        public int MAX_TIME_START = 10;
        public int MAX_TIME_END = 20;
        public int PROF_X_START = 10;
        public int PROF_X_END = 30;
        public int FITNESS_START = 10;
        public int FITNESS_END = 40;
        public int PT_MULT_START = 10;
        public int PT_MULT_END = 20;
        public int SL_MULT_START = 10;
        public int SL_MULT_END = 20;


        /**
 *******************************************************************************
 *
 * \brief Function for setting configuration values.
 *
 *        Function for setting random configuration values.
 *
 * \param  c   		[IN] 	Configuration object
 *
 * \return  void
 *
 *******************************************************************************
 */

        public void setConfiguration(Config c)
        {

            //srand(time(NULL));
            Random rnd = new Random();

            /*cout << "Input number of strategies: ";
            cin >> c.numStrategies;

            cout << "Max number of generations: ";
            cin >> c.maxNumGenerations;

            cout << "Tests per generation: ";
            cin >> c.testsPerGeneration;

            cout << "Min number of rules: ";
            cin >> c.minNumOfRules;

            cout << "Max number of rules: ";
            cin >> c.maxNumOfRules;

            cout << "Fitness value: ";
            cin >> c.fitnessValue;
            */
            /*c.numStrategies = 2;
            c.maxNumGenerations = 15;
            c.testsPerGeneration = 8;
            c.minNumOfRules = 10;
            c.maxNumOfRules = 12;
            c.fitnessValue = 9;*/
            c.PT_ON = rnd.Next(BINARY); //rand()%BINARY;
            c.SL_ON = rnd.Next(BINARY);
            c.HH_ON = rnd.Next(BINARY);
            c.LL_ON = rnd.Next(BINARY);
            c.max_time = rnd.Next((MAX_TIME_END - MAX_TIME_START)) + MAX_TIME_START;
                //(rand()%(MAX_TIME_END - MAX_TIME_START)) + MAX_TIME_START;
            c.prof_x = rnd.Next(PROF_X_END - PROF_X_START) + PROF_X_START;
            c.fitness = rnd.Next(FITNESS_END - FITNESS_START) + FITNESS_START;

            c.pt_mult = rnd.Next(PT_MULT_END - PT_MULT_START) + PT_MULT_START + rnd.NextDouble();
            c.sl_mult = rnd.Next(SL_MULT_END - SL_MULT_START) + SL_MULT_START + rnd.NextDouble();
        }


/**
 *******************************************************************************
 *
 * \brief Function for printing configuration values.
 *
 *        Function for printing configuration values to stdout.
 *
 * \param  c   		[IN] 	Configuration object
 *
 * \return  void
 *
 *******************************************************************************
 */

        public void printConfiguration(Config c)
        {
            Console.WriteLine("Number of strategies: " + c.numStrategies); 
            Console.WriteLine("PT_ON: " + c.PT_ON);
            Console.WriteLine("SL_ON: " + c.SL_ON);
            Console.WriteLine("HH_ON: " + c.HH_ON);
            Console.WriteLine("LL_ON: " + c.LL_ON);
            Console.WriteLine("max_time: " + c.max_time);
            Console.WriteLine("prof_x: " + c.prof_x);
            Console.WriteLine("fitness: " + c.fitness);
            Console.WriteLine("pt_mult: " + c.pt_mult);
            Console.WriteLine("sl_mult: " + c.sl_mult);
        }
    }
}
