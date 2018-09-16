using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace LeagueAnalysisConsole
{
    public class NBA : LeagueBase
    {
        readonly StreamWriter _writer = new StreamWriter("E:\\Leagues\\NBAOutput.csv");

        private int _regSeason;
        private int _home;
        private string _season;
        private string _gameType;

        private readonly string _venue;
        private string _team;
        private string _opponent;
        private double _ml;
        private double _ou;
        private double _spread;
        private int _date;
        private int _min;
        private int _fg;
        private int _fga;
        private int _p3;
        private int _pa3;
        private int _ft;
        private int _fta;
        private int _ofr;
        private int _dr;
        private int _totr;
        private int _a;
        private int _pf;
        private int _st;
        private int _to;
        private int _bl;
        private int _pts;
        private int _pts2;

        private int _margOfVict;
        private int _rebDiff;
        private int _q1;
        private int _q2;
        private int _q3;
        private int _q4;
        private int _ot1;
        private int _ot2;
        private int _ot3;
        private int _ot4;
        private int _final;
        private int _index;
        private int _oppIndex;
        
        private double _spreadResult; // betting outcomes
        private double _mlResult; // betting outcomes
        private double _ouResult; // betting outcomes

        private readonly List<string> Season = new List<string>();
        private readonly List<string> Team = new List<string>();
        private readonly List<string> Opponents = new List<string>();
        private readonly List<int> Reg_season = new List<int>();
        private readonly List<int> Home = new List<int>();
        private readonly List<int> Date = new List<int>();
        private readonly List<int> MIN = new List<int>();

        private readonly List<int> FG = new List<int>();
        private readonly List<int> FGA = new List<int>();
        private readonly List<int> P3 = new List<int>();
        private readonly List<int> PA3 = new List<int>();
        private readonly List<int> FT = new List<int>();
        private readonly List<int> FTA = new List<int>();
        private readonly List<int> OFR = new List<int>();
        private readonly List<int> DR = new List<int>();
        private readonly List<int> TOTR = new List<int>();
        private readonly List<int> A = new List<int>();
        private readonly List<int> PF = new List<int>();

        private readonly List<int> ST = new List<int>();
        private readonly List<int> TO = new List<int>();
        private readonly List<int> BL = new List<int>();
        private readonly List<int> PTS = new List<int>();
        private readonly List<int> MARG_OF_VICT = new List<int>();
        private readonly List<int> REB_DIFF = new List<int>();

        private readonly List<int> Q1 = new List<int>();
        private readonly List<int> Q2 = new List<int>();
        private readonly List<int> Q3 = new List<int>();
        private readonly List<int> Q4 = new List<int>();

        private readonly List<int> OT1 = new List<int>();
        private readonly List<int> OT2 = new List<int>();
        private readonly List<int> OT3 = new List<int>();
        private readonly List<int> OT4 = new List<int>();
        private readonly List<int> FINAL = new List<int>();

        private readonly List<double> ML = new List<double>();
        private readonly List<double> OU = new List<double>();

        private readonly List<double> Spread = new List<double>();


        public NBA()
        {

        }

        public override void Update()
        {
            // Calculate Results for P&L Calculations
            _spreadResult = _margOfVict + _spread > 0 ? 100 : -100;
            _ouResult = _pts + (_pts - _margOfVict) > _ou ? 100 : -100;

            if (_margOfVict > 0)
            {
                _mlResult = _ml > 0 ? _ml : 100;
            }
            else
            {
                _mlResult = _ml > 0 ? -100 : _ml;
            }


            // Get Last Game Stats and Win %
            int wins = 0, oppWins = 0, gms = 0, oppGms = 0;
            int winstrk = 0, lossstrk = 0, hwinstrk = 0, hlossstrk = 0;
            int owinstrk = 0, olossstrk = 0, ohwinstrk = 0, ohlossstrk = 0;
            int oawinstrk=0, oalossstrk=0, awinstrk = 0, alossstrk = 0;
            double winPerc = 0.0, oppWinp = 0.0;

            int fld = 0, fldA = 0, thr = 0, thrA = 0, fre = 0, freA = 0;
            int ofld = 0, ofldA = 0, othr = 0, othrA = 0, ofre = 0, ofreA = 0;

            double ppg = 0, apg = 0, spg = 0, rpg = 0, orbpg = 0, drpg = 0, topg = 0, blpg = 0;
            double oppg = 0, oapg = 0, ospg = 0, orpg = 0, oorbpg = 0, odrpg = 0, otopg = 0, oblpg = 0;

            for (int i = 0; i < Opponents.Count; i++)
            {
                if (Team[i] == _team)
                {
                    _index = i;
                    if (_season == Season[i])
                    {
                        gms++;
                        ppg += PTS[i];
                        apg += A[i];
                        spg += ST[i];
                        rpg += TOTR[i];
                        orbpg += OFR[i];
                        drpg += DR[i];
                        topg += TO[i];
                        blpg += BL[i];
                        fld += FG[i];
                        fldA += FGA[i];
                        thr += P3[i];
                        thrA += PA3[i];
                        fre += FT[i];
                        freA += FTA[i];
                        if (MARG_OF_VICT[i] <= 0)
                        {
                            winstrk = 0;
                            lossstrk++;
                            if (Home[i] == 1)
                            {
                                hlossstrk++;
                                hwinstrk = 0;
                            }
                            if (Home[i] == 0)
                            {
                                alossstrk++;
                                awinstrk = 0;
                            }
                        }
                        if (MARG_OF_VICT[i] > 0)
                        {
                            wins++;
                            winstrk++;
                            lossstrk = 0;
                            if (Home[i] == 1)
                            {
                                hwinstrk++;
                                hlossstrk = 0;
                            }
                            if (Home[i] == 0)
                            {
                                awinstrk++;
                                alossstrk = 0;
                            }
                        }
                    }
                }
                if (Team[i] != _opponent) continue;
                _oppIndex = i;
                if (_season != Season[i]) continue;
                oppGms++;
                oppg += PTS[i];
                oapg += A[i];
                ospg += ST[i];
                orpg += TOTR[i];
                oorbpg += OFR[i];
                odrpg += DR[i];
                otopg += TO[i];
                oblpg += BL[i];
                ofld += FG[i];
                ofldA += FGA[i];
                othr += P3[i];
                othrA += PA3[i];
                ofre += FT[i];
                ofreA += FTA[i];
                if (MARG_OF_VICT[i] <= 0)
                {
                    owinstrk = 0;
                    olossstrk++;
                    if (Home[i] == 1)
                    {
                        // should all this be reversed?
                        ohwinstrk = 0;
                        ohlossstrk++;
                    }
                    if (Home[i] == 0)
                    {
                        oawinstrk = 0;
                        oalossstrk++;
                    }
                }
                if (MARG_OF_VICT[i] >= 0)
                {
                    oppWins++;
                    owinstrk++;
                    olossstrk = 0;
                    if (Home[i] == 1)
                    {
                        ohwinstrk++;
                        ohlossstrk = 0;
                    }
                    if (Home[i] == 0)
                    {
                        oawinstrk++;
                        oalossstrk = 0;
                    }
                }
            }




            if (gms > 0)
            {
                winPerc = (double) (wins)/(gms);
                ppg /= (double) (gms);
                apg /= (double) (gms);
                spg /= (double) (gms);
                blpg /= (double) (gms);
                topg /= (double) (gms);
                rpg /= (double) (gms);
                orbpg /= (double) (gms);
                drpg /= (double) (gms);
            }
            if (oppGms > 0)
            {
                oppWinp = (double) (oppWins)/(oppGms);
                oppg /= (double) (oppGms);
                oapg /= (double) (oppGms);
                ospg /= (double) (oppGms);
                oblpg /= (double) (oppGms);
                otopg /= (double) (oppGms);
                orpg /= (double) (oppGms);
                oorbpg /= (double) (oppGms);
                odrpg /= (double) (oppGms);
            }

            // ------------------------------------------------
            //  field goal, three point, free throw perc
            //

            double fgp = (double) (fld)/fldA;
            fgp = fgp != fgp ? 0.0 : fgp;

            double thrp = (double) (thr)/thrA;
            thrp = thrp != thrp ? 0.0 : thrp;

            double fret = (double) (fre)/freA;
            fret = fret != fret ? 0.0 : fret;

            double ofgp = (double) (ofld)/ofldA;
            ofgp = ofgp != ofgp ? 0.0 : fret;

            double othrp = (double) (othr)/othrA;
            othrp = othrp != othrp ? 0.0 : othrp;

            double ofret = (double) (ofre)/ofreA;
            ofret = ofret != ofret ? 0.0 : ofret;




            if (_index > 0)
            {
                    _writer.WriteLine(string.Join(",",_season,
                    _regSeason,
                    _date,
                    _team,
                    _opponent,
                    _venue,
                    _q1, _q2, _q3, _q4, _ot1, _ot2, _ot3, _ot4, _final,
                    _min,
                    _fg, _fga,
                    _p3, _pa3,
                    _ft, _fta,
                    _ofr, _dr, _totr,
                    _a, _pf, _st, _to, _bl, _pts,
                    _margOfVict,
                    _rebDiff,
                    _ml, _ou, _spread,
                    MARG_OF_VICT[_index] > 0 ? 1 : 0,
                    MARG_OF_VICT[_index] + Spread[_index] > 0 ? 1 : 0,
                    MARG_OF_VICT[_index],
                    (double) (FG[_index])/(double) (FGA[_index]),
                    PTS[_index],
                    MARG_OF_VICT[_oppIndex] > 0 ? 1 : 0,
                    MARG_OF_VICT[_oppIndex] + Spread[_oppIndex] > 0 ? 1 : 0,
                    MARG_OF_VICT[_oppIndex],
                    (double) (FG[_oppIndex])/(double) (FGA[_oppIndex]),
                    PTS[_oppIndex],
                    winstrk, lossstrk, hwinstrk, hlossstrk, awinstrk, alossstrk,
                    owinstrk, olossstrk, ohwinstrk, ohlossstrk, oawinstrk,
                    oalossstrk,
                    _mlResult, _ouResult, _spreadResult,
                    winPerc, oppWinp,
                    fgp, thrp, fret, ofgp, othrp, ofret,
                    ppg, apg, rpg, orbpg, drpg, blpg, spg, topg,
                    oppg, oapg, orpg, oorbpg, odrpg, oblpg, ospg, otopg
                    ));

            }
            // Store This Game
            Team.Add(_team);
            Opponents.Add(_opponent);
            Season.Add(_season);
            Reg_season.Add(_regSeason);
            Home.Add(_home); 
            Date.Add(_date);
            MIN.Add(_min);
            FG.Add(_fg);
            FGA.Add(_fga);
            P3.Add(_p3);
            PA3.Add(_pa3);
            FT.Add(_ft);
            FTA.Add(_fta);
            OFR.Add(_ofr);
            DR.Add(_dr);
            TOTR.Add(_totr);
            A.Add(_a);
            PF.Add(_pf);
            ST.Add(_st);
            TO.Add(_to);
            BL.Add(_bl);
            PTS.Add(_pts);
            MARG_OF_VICT.Add(_margOfVict);
            REB_DIFF.Add(_rebDiff);
            Q1.Add(_q1);
            Q2.Add(_q2);
            Q3.Add(_q3);
            Q4.Add(_q4);
            OT1.Add(_ot1);
            OT2.Add(_ot2);
            OT3.Add(_ot3);
            OT4.Add(_ot4);
            FINAL.Add(_final);
            ML.Add(_ml);
            OU.Add(_ou);
            Spread.Add(_spread);
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

                    _season = tokens[0];
                    _regSeason = Convert.ToInt32(tokens[1]);
                    _date = Convert.ToInt32(tokens[2]);
                    _team = tokens[3];
                    _opponent = tokens[4];
                    _home = Convert.ToInt32(tokens[5]);
                    _q1 = Convert.ToInt32(tokens[6]);
                    _q2 = Convert.ToInt32(tokens[7]);
                    _q3 = Convert.ToInt32(tokens[8]);
                    _q4 = Convert.ToInt32(tokens[9]);
                    _ot1 = Convert.ToInt32(tokens[10]);
                    _ot2 = Convert.ToInt32(tokens[11]);
                    _ot3 = Convert.ToInt32(tokens[12]);
                    _ot4 = Convert.ToInt32(tokens[13]);
                    _final = Convert.ToInt32(tokens[14]);
                    _min = Convert.ToInt32((int)Convert.ToDouble(tokens[15]));
                    _fg = Convert.ToInt32(tokens[16]);
                    _fga = Convert.ToInt32(tokens[17]);
                    _p3 = Convert.ToInt32(tokens[18]);
                    _pa3 = Convert.ToInt32(tokens[19]);
                    _ft = Convert.ToInt32(tokens[20]);
                    _fta = Convert.ToInt32(tokens[21]);
                    _ofr = Convert.ToInt32(tokens[22]);
                    _dr = Convert.ToInt32(tokens[23]);
                    _totr = Convert.ToInt32(tokens[24]);
                    _a = Convert.ToInt32(tokens[25]);
                    _pf = Convert.ToInt32(tokens[26]);
                    _st = Convert.ToInt32(tokens[27]);
                    _to = Convert.ToInt32(tokens[28]);
                    _bl = Convert.ToInt32(tokens[29]);
                    _pts = Convert.ToInt32(tokens[30]);
                    _margOfVict = Convert.ToInt32(tokens[31]);
                    _rebDiff = Convert.ToInt32(tokens[32]);
                    _ml = Convert.ToDouble(tokens[33]);
                    _ou = Convert.ToDouble(tokens[34]);
                    _spread = Convert.ToDouble(tokens[35]);
                    text = input.ReadLine();
                    Update();
                }
            }
        }


    }
}

