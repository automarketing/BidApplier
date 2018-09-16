using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace LeagueAnalysisConsole
{
    public class LeagueBase
    {
        public virtual void Update()
        {
            Console.WriteLine("base");
        }
        public virtual void LoadData(string fileName)
        {
            Console.WriteLine("base");
        }
    }
}
