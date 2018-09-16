/// <reference path="../SvgManip.js" />

function LoadHelpTopic(url)
{
    
    MyPointers.HelpTopicArea.load(url);
    trackVirtualPageView(url);
}