/// <reference path="../svgManip.js" />
function ColorableState(id)
{
    //#region Private Properties
    this.Private_Colorable = false;
    this.Private_ShapeId = id;


    this.Regions = new Object();
    this.Titles = new Object();

    //#endregion




    this.Private_ParseMetaData();
}

//#region Public Properties
ColorableState.prototype.Property_IsColorable = function ()
{
    return this.Private_Colorable;
};


//#endregion

//#region Public Methods
ColorableState.prototype.Public_GetColorWheelForRegion = function (region)
{
    region = MyColorWheels.SanitizeColor(region);

    return MyColorWheels[region];
};

ColorableState.prototype.Public_GetColorForRegion = function (region)
{
    return this.Regions[region];
}

ColorableState.prototype.Public_GetRegionList = function ()
{
    var regions = new Array();

    $.each(this.Regions, function (key, value)
    {
        regions.push(key);
    });

    return regions;
};

ColorableState.prototype.Public_GetTitleForRegion = function (region)
{
    try
    {
        if (this.Titles == undefined || this.Titles == null)
            return "";

        var title = this.Titles[region];
        if (title == null || title == undefined)
            return "";

        var langmapTitle = MyLangMap.GetText("ST-" + title);
        if (langmapTitle != "")
            return langmapTitle;

        return title;

    } catch (e)
    {
        return "";
    }
    return "";
};

ColorableState.prototype.Public_ResetColors = function ()
{
    var regions = this.Public_GetRegionList();
    for (var i = 0; i < regions.length; i++)
    {
        this.Public_UpdateColorForRegion(regions[i], this.Public_GetColorForRegion(regions[i]));
    }
};

ColorableState.prototype.Public_UpdateColorForRegion = function (region, newColor, isPreview)
{
    this.Private_UpdateColorForRegion(region, newColor, isPreview);
};

ColorableState.prototype.Public_GetColorStyles = function ()
{
    var regions = new Object();

    if (this.Regions == null || this.Regions.length == 0)
        return null;

    $.each(this.Regions, function (key, value)
    {
        regions[key] = value;
    });

    var colorStyles = new Object();
    colorStyles.Regions = regions;

    return colorStyles;

};
//THIS ASSUMES you are copying from an identical object... otherwise this will blow up abs 1/12/15
ColorableState.prototype.Public_CopyColorStyles = function (rhs)
{
    this.Regions = rhs.Regions;
    this.Public_ResetColors()
};

ColorableState.prototype.Public_Copy = function (rhs)
{
    if (rhs == undefined || rhs == null)
    {
        this.Private_Colorable = false;
        return;
    }
    this.Private_Colorable = rhs.Private_Colorable;
    //this.Private_ShapeId = rhs.Private_ShapeId; 90% sure this would be a bad idea..


    var regions = new Object();

    // weird scoping issues when you use this, can't use class variables...
    $.each(rhs.Regions, function (key, value)
    {
        regions[key] = value;
    });
    this.Regions = regions;

    try
    {


        var titles = new Object();
        if (rhs.Titles != null && rhs.Titles != undefined)
        {
            $.each(rhs.Titles, function (key, value)
            {
                titles[key] = value;
            });
        }
        this.Titles = titles;
    } catch (e)
    {

    }

    var regionList = this.Public_GetRegionList();
    for (var i = 0; i < regionList.length; i++)
    {
        this.Private_UpdateRegionIds(regionList[i]);
    }

    this.Public_ResetColors()

};
//#endregion

//#region Private Helpers
ColorableState.prototype.Private_HasColor = function (region)
{
    if (this.Regions == undefined || this.Regions == null)
        return false;

    if (this.Regions[region] == undefined || this.Regions[region] == null)
        return false;

    return true;
};

ColorableState.prototype.Public_HandlePositionSwap = function ()
{
    this.Private_ParseMetaData();
    this.Public_ResetColors();
};


ColorableState.prototype.Private_ParseMetaData = function ()
{
    var metaData = $("#" + this.Private_ShapeId).find("sbtdata");
    if (metaData.length == 0)
        return;

    var colorables = metaData.find("colorable");
    for (var i = 0; i < colorables.length; i++)
    {
        this.Private_Colorable = true;

        var region = GetSafeAttributeNS(colorables[i], "Region");
        var replaceColor = GetSafeAttributeNS(colorables[i], "ReplaceColor");
        var title = GetSafeAttributeNS(colorables[i], "SpecialTitle");

        // if you are doing a swap you don't want to re-change colors
        if (this.Private_HasColor(region) == false)
        {
            this.Private_UpdateRegionColor(region, replaceColor);
        }
        this.Private_UpdateRegionTitle(region, title);

        this.Private_UpdateRegionIds(region);
    }
};

ColorableState.prototype.Private_GetBaseRegionId = function (region)
{
    return region + "_" + this.Private_ShapeId + "_";
};

ColorableState.prototype.Private_UpdateRegionIds = function (region)
{
    var filter = "[id^=\"" + region + "_\"]";
    var toBeUpdated = $("#" + this.Private_ShapeId).find(filter);
    for (var i = 0; i < toBeUpdated.length; i++)
    {
        var id = this.Private_GetBaseRegionId(region) + i;
        toBeUpdated[i].setAttributeNS(null, "id", id);
    }
};

ColorableState.prototype.Private_UpdateColorForRegion = function (region, newColor, isPreview)
{
    try
    {
        var filter = "[id^=" + this.Private_GetBaseRegionId(region) + "]";

        var toBeUpdated = $(filter);

        for (var i = 0; i < toBeUpdated.length; i++)
        {
            toBeUpdated[i].setAttributeNS(null, "fill", newColor)
        }

        if (isPreview === false)
        {
            this.Private_UpdateRegionColor(region, newColor);
        }
    } 
    catch (e)
    {
        LogErrorMessage("ColorableState.Private_UpdateColorForRegion", e);
    }
   
};

ColorableState.prototype.Private_UpdateRegionColor = function (region, newColor)
{
    this.Regions[region] = newColor;

};

ColorableState.prototype.Private_UpdateRegionTitle = function (region, title)
{

    this.Titles[region] = title;
};

//#endregion