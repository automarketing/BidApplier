function SmartSceneItem()
{
    this.Title = "";
    
    this.SmartSceneItemOptions = [];


    //this.ParseMetaData(shapeId, smartSceneItemMetaData, colorableState);
};

SmartSceneItem.prototype.ParseMetaData = function (shapeId, smartSceneItemMetaData, colorableState)
{
    this.Title = GetSafeAttributeNS(smartSceneItemMetaData, SbtDataEnum.Attribute_SmartSceneItemOption_Title);
    var smartSceneItems = $(smartSceneItemMetaData).find(SbtDataEnum.MetaData_SmartSceneItemOption);

    for (var i = 0; i < smartSceneItems.length; i++)
    {
        try
        {
            var smartSceneItemOption = new SmartSceneItemOption(shapeId, colorableState);
            smartSceneItemOption.ParseMetaData(smartSceneItems[i]);

            this.SmartSceneItemOptions.push(smartSceneItemOption);
        }
        catch (e)
        {
            LogErrorMessage("SmartSceneItem._ParseMetaData:  ", e);
        }

    }
};

SmartSceneItem.prototype.GetActiveSceneIndex = function ()
{
    for (var i = 0; i < this.SmartSceneItemOptions.length; i++)
    {
        if (this.SmartSceneItemOptions[i].IsActive)
            return i;
    }
    return 0;
};

SmartSceneItem.prototype.ActivateSceneOption = function (index)
{
    for (var i = 0; i < this.SmartSceneItemOptions.length; i++)
    {
        this.SmartSceneItemOptions[i].IsActive = false;
    }

    this.SmartSceneItemOptions[index].Activate();
};

SmartSceneItem.prototype.CopySmartSceneItem = function (rhs, shapeId, colorableState)
{
    this.Title = rhs.Title;

    for (var i = 0; i < rhs.SmartSceneItemOptions.length; i++)
    {
        var smartSceneItemOption = new SmartSceneItemOption(shapeId, colorableState)
        smartSceneItemOption.CopySmartSceneItemOption(rhs.SmartSceneItemOptions[i]);

        this.SmartSceneItemOptions.push(smartSceneItemOption);

    }
};

SmartSceneItem.prototype.GetTitle = function ()
{
    var langmapTitle = MyLangMap.GetText("ST-" + this.Title);
    if (langmapTitle === "")
        return this.Title;

    return langmapTitle;
};


