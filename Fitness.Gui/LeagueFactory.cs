using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace LeagueAnalysisConsole
{
    class LeagueFactory
    {
        public static LeagueBase CreateLeague(LeagueType type)
        {
            switch (type)
            {
                case LeagueType.NBA:
                    return new NBA();
                    break;
                case LeagueType.NFL:
                    return new NFL();
                    break;
                case LeagueType.NCAAF:
                    return new NCAAF();
                    break;
                default:
                    return null;
                    break;
            }
        }
    }
}
