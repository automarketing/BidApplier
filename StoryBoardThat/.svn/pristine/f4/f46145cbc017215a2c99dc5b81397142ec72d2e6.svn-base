function SmartSceneItemOption(shapeId, colorableState)
{
    this.Title = "";
    //this.Name = "";

    this._TurnOn = [];
    this._TurnOff = [];
    this._ColorableState = colorableState;
    this._ColorRegions = [];

    this.IsActive = false;
    this._ShapeId = shapeId;
  
};

SmartSceneItemOption.prototype.ParseMetaData = function (smartSceneItemOption)
{
    this.Title = GetSafeAttributeNS(smartSceneItemOption, SbtDataEnum.Attribute_SmartSceneItemOption_Title);
    //this.Name = GetSafeAttributeNS(smartSceneItemOption, SbtDataEnum.Attribute_SmartSceneItemOption_Name);

    var turnOn = GetSafeAttributeNS(smartSceneItemOption, SbtDataEnum.Attribute_SmartSceneItemOption_TurnOn);
    var turnOff = GetSafeAttributeNS(smartSceneItemOption, SbtDataEnum.Attribute_SmartSceneItemOption_TurnOff);
    
    var isDefault = GetSafeAttributeNS(smartSceneItemOption, SbtDataEnum.Attribute_SmartSceneItemOption_Default);
    if (isDefault != null && isDefault.toLowerCase()=="true")
        this.IsActive = true;

    this._TurnOn = this._ParseAndUpdateIds(this._ShapeId, this._ShapeId + "-", turnOn);
    this._TurnOff = this._ParseAndUpdateIds(this._ShapeId, this._ShapeId + "-", turnOff);

    var colorRegionsMetaData = $(smartSceneItemOption).find(SbtDataEnum.MetaData_SmartSceneItemOptionColor);
    for(var i=0; i<colorRegionsMetaData.length; i++)
    {
        var region = GetSafeAttributeNS(colorRegionsMetaData[i], SbtDataEnum.Attribute_SmartSceneItemOptionColor_Region);
        var replaceColor = GetSafeAttributeNS(colorRegionsMetaData[i], SbtDataEnum.Attribute_SmartSceneItemOptionColor_ReplaceColor);

        var colorRegion = { Region: region, ReplaceColor: replaceColor };
        this._ColorRegions.push(colorRegion);
    }
};

SmartSceneItemOption.prototype.Activate = function ()
{
    this._UpdateDisplayForIds(this._TurnOn, "inline");
    this._UpdateDisplayForIds(this._TurnOff, "none");
    this.IsActive = true;

    if (this._ColorableState!=null && this._ColorRegions.length>0)
    {
        for (var i = 0; i < this._ColorRegions.length; i++)
        {

            this._ColorableState.Public_UpdateColorForRegion(this._ColorRegions[i].Region, this._ColorRegions[i].ReplaceColor, false);
        }
    }

};

SmartSceneItemOption.prototype._UpdateDisplayForIds = function (idList, displayVal)
{
    for (var i = 0; i < idList.length; i++)
    {
        $("#" + idList[i]).attr("display", displayVal);
    }
};

SmartSceneItemOption.prototype._ParseAndUpdateIds = function (containerId, preFix, idList)
{
    var splitIds = idList.split(",");
    var newIds = [];
    for (var i = 0; i < splitIds.length; i++)
    {
        var trimmedId = splitIds[i].trim();
        var newId = preFix + trimmedId;

        FindAndUpdateId(containerId, trimmedId, newId);
        newIds.push(newId);
    }

    return newIds;
};

SmartSceneItemOption.prototype.CopySmartSceneItemOption = function (rhs)
{
    this.Title = rhs.Title;
    this.IsActive = rhs.IsActive;

    //update all the ids of items that can be shape swaped!
    for(var i=0; i<rhs._TurnOn.length;i++)
    {
        var oldId = rhs._TurnOn[i];
        var newId = oldId.replace(rhs._ShapeId, this._ShapeId);

        FindAndUpdateId(this._ShapeId, oldId, newId);

        this._TurnOn.push(newId);
    }

    for (var i = 0; i < rhs._TurnOff.length; i++)
    {
        var oldId = rhs._TurnOff[i];
        var newId = oldId.replace(rhs._ShapeId, this._ShapeId);

        FindAndUpdateId(this._ShapeId, oldId, newId);

        this._TurnOff.push(newId);

        //this._TurnOff.push(rhs._TurnOff[i].replace(rhs._ShapeId, this._ShapeId));
    }

    for (var i = 0; i < rhs._ColorRegions.length; i++)
    {
        var colorRegion = { Region: rhs._ColorRegions[i].Region, ReplaceColor: rhs._ColorRegions[i].ReplaceColor };
        this._ColorRegions.push(colorRegion);
    }

    //this.Name = rhs.Name;
};

SmartSceneItemOption.prototype.GetTitle = function ()
{
    var langmapTitle = MyLangMap.GetText("ST-" + this.Title);
    if (langmapTitle == "")
        return this.Title;

    return langmapTitle;
};
