///  <reference path="../SvgManip.js" />
function ColorWheel(region, title, color1, color2, color3, color4, color5, color6)
{
    this.Region = region;
     this.Title = title;

    this.Color1 = color1;
    this.Color2 = color2;
    this.Color3 = color3;
    this.Color4 = color4;
    this.Color5 = color5;
    this.Color6 = color6;
    //this.Color7 = color7;
    //this.Color8 = color8;
    //this.Color9;
    //this.Color10;
}

ColorWheel.prototype.GetTitle = function ()
{
    try
    {
        var title = MyLangMap.GetText("CW-" + this.Region);
        if (title != "")
            return title;

        return this.Region;
    }

    catch (e)
    {
        LogErrorMessage("ColorWheel.GetTitle", e);
        throw e;
    }
}