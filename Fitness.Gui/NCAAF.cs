using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace LeagueAnalysisConsole
{
    internal class NCAAF : LeagueBase
    {
        private readonly StreamWriter _writer = new StreamWriter("E:\\Leagues\\NCAAFOutput.csv");

        private int pt;
        private int pta;
        private int fd;
        private int fda;
        private int r;
        private int ra;
        private int ry;
        private int rya;
        private int p;
        private int pa;
        private int pc;
        private int pca;
        private int py;
        private int pya;
        private int it;
        private int ita;
        private int date;
        private int gm_no;
        private int ogm_no;
        private int home;
        private int turf;
        private int fav;
        private string team;
        private string div;
        private string oteam;
        private string odiv;
        private string day;
        private double spread;
        private double ou;
        private double spread_result, ou_result;

        private readonly List<int> PT = new List<int>();
        private readonly List<int> PTA = new List<int>();
        private readonly List<int> FD = new List<int>();
        private readonly List<int> FDA = new List<int>();
        private readonly List<int> R = new List<int>();
        private readonly List<int> RA = new List<int>();
        private readonly List<int> RY = new List<int>();
        private readonly List<int> RYA = new List<int>();
        private readonly List<int> P = new List<int>();
        private readonly List<int> PA = new List<int>();
        private readonly List<int> PC = new List<int>();
        private readonly List<int> PCA = new List<int>();
        private readonly List<int> PY = new List<int>();
        private readonly List<int> PYA = new List<int>();
        private readonly List<int> IT = new List<int>();
        private readonly List<int> ITA = new List<int>();
        private readonly List<int> DATE = new List<int>();
        private readonly List<int> GM_NO = new List<int>();
        private readonly List<int> OGM_NO = new List<int>();
        private readonly List<int> HOME = new List<int>();
        private readonly List<int> TURF = new List<int>();
        private List<int> FAV = new List<int>();
        private readonly List<string> TEAM = new List<string>();
        private readonly List<string> DIV = new List<string>();
        private readonly List<string> OTEAM = new List<string>();
        private readonly List<string> ODIV = new List<string>();
        private List<string> DAY = new List<string>();
        private readonly List<double> SPREAD = new List<double>();
        private List<double> OU = new List<double>();

        public NCAAF()
        {

        }

        public override void Update()
        {

            spread_result = (pt - pta) + spread > 0 ? 100 : -100;
            ou_result = (pt + pta) > ou ? 100 : -100;

            // Calculate cumulators for Season Stats
            int wins = 0, gms = 0, owins = 0, ogms = 0;
            int index = 0, oindex = 0;

            int wstrk = 0, lstrk = 0, hwstrk = 0, hlstrk = 0, awstrk = 0, alstrk = 0;
            int owstrk = 0, olstrk = 0, ohwstrk = 0, ohlstrk = 0, oawstrk = 0, oalstrk = 0;

            double ppg = 0, rypg = 0, pypg = 0, itpg = 0, itfpg = 0;
            double oppg = 0, orypg = 0, opypg = 0, oitpg = 0, oitfpg = 0;

            double winp = 0, owinp = 0;

            for (int i = 0; i < OTEAM.Count; i++)
            {
                if (TEAM[i] == team)
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
                if (oteam == TEAM[i] && ogm_no != GM_NO[i])
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
                winp = (double) (wins)/(gm_no);
                ppg /= (double) (gms);
                rypg /= (double) (gms);
                pypg /= (double) (gms);
                itpg /= (double) (gms);
                itfpg /= (double) (gms);
            }
            if (ogms > 0)
            {
                owinp = (double) (owins)/(ogm_no);
                oppg /= (double) (ogms);
                orypg /= (double) (ogms);
                opypg /= (double) (ogms);
                oitpg /= (double) (ogms);
                oitfpg /= (double) (ogms);
            }

            _writer.WriteLine(string.Join(",", date, day, gm_no, team, div,
                oteam, odiv, ogm_no, home,
                turf, fav, spread, ou, pt, pta, fd, fda, r, ra, ry, rya,
                p, pa, pc, pca, py, pya, it, ita,
                winp, owinp,
                ppg, rypg, pypg, itpg, itfpg,
                oppg, orypg, opypg, oitpg, oitfpg,
                index > 0 ? PT[index] : 0,
                index > 0 ? RY[index] : 0,
                index > 0 ? PY[index] : 0,
                oindex > 0 ? PT[oindex] : 0,
                oindex > 0 ? RY[oindex] : 0,
                oindex > 0 ? PY[oindex] : 0,
                wstrk, lstrk,
                hwstrk, hlstrk,
                awstrk, alstrk,
                owstrk, olstrk,
                ohwstrk, ohlstrk,
                oawstrk, oalstrk
                ));


            // Push Everything Back
            DATE.Add(date);
            GM_NO.Add(gm_no);
            OGM_NO.Add(ogm_no);
            TEAM.Add(team);
            DIV.Add(div);
            OTEAM.Add(oteam);
            ODIV.Add(odiv);
            HOME.Add(home);
            TURF.Add(turf);
            FAV.Add(fav);
            DAY.Add(day);
            SPREAD.Add(spread);
            OU.Add(ou);
            PT.Add(pt);
            PTA.Add(pta);
            FD.Add(fd);
            FDA.Add(fda);
            R.Add(r);
            RA.Add(ra);
            RY.Add(ry);
            RYA.Add(rya);
            P.Add(p);
            PA.Add(pa);
            PC.Add(pc);
            PCA.Add(pca);
            PY.Add(py);
            PYA.Add(pya);
            IT.Add(it);
            ITA.Add(ita);

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
                    date = Convert.ToInt32(tokens[0]);
                    gm_no = Convert.ToInt32(tokens[1]);
                    team = tokens[2];
                    div = tokens[3];
                    day = tokens[4];
                    oteam = tokens[5];
                    odiv = tokens[6];
                    ogm_no = Convert.ToInt32(tokens[7]);
                    home = Convert.ToInt32(tokens[8]);
                    turf = Convert.ToInt32(tokens[9]);
                    fav = Convert.ToInt32(tokens[10]);
                    spread = Convert.ToDouble(tokens[11]);
                    ou = Convert.ToDouble(tokens[12]);
                    pt = Convert.ToInt32(tokens[13]);
                    pta = Convert.ToInt32(tokens[14]);
                    fd = Convert.ToInt32(tokens[15]);
                    fda = Convert.ToInt32(tokens[16]);
                    r = Convert.ToInt32(tokens[17]);
                    ra = Convert.ToInt32(tokens[18]);
                    ry = Convert.ToInt32(tokens[19]);
                    rya = Convert.ToInt32(tokens[20]);
                    p = Convert.ToInt32(tokens[21]);
                    pa = Convert.ToInt32(tokens[22]);
                    pc = Convert.ToInt32(tokens[23]);
                    pca = Convert.ToInt32(tokens[24]);
                    py = Convert.ToInt32(tokens[25]);
                    pya = Convert.ToInt32(tokens[26]);
                    it = Convert.ToInt32(tokens[27]);
                    ita = Convert.ToInt32(tokens[28]);

                    text = input.ReadLine();
                    Update();
                }

            }


        }
    }
}


