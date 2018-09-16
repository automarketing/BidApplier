function SmartSceneState(id)
{
    this._ShapeId = id;

    this.SmartSceneItems = [];

    // this._ParseMetaData(colorableState);
};

SmartSceneState.prototype.ParseMetaData = function (colorableState)
{
    try
    {
        var metaData = $("#" + this._ShapeId).find("sbtdata");
        if (metaData == null || metaData.length == 0)
            return;

        var smartSceneData = metaData.find(SbtDataEnum.MetaData_SmartScene);

        var smartSceneItems = smartSceneData.find(SbtDataEnum.MetaData_SmartSceneItem);

        for (var i = 0; i < smartSceneItems.length; i++)
        {
            var smartSceneItem = new SmartSceneItem();
            smartSceneItem.ParseMetaData(this._ShapeId, smartSceneItems[i], colorableState)

            this.SmartSceneItems.push(smartSceneItem);
        }
    }
    catch (e)
    {
        LogErrorMessage("SmartSceneState._ParseMetaData:  ", e);
        throw e;
    }
};

SmartSceneState.prototype.IsSmartScene = function ()
{
    return this.SmartSceneItems.length > 0;
};

// this feels like a very sloppy way to do this - abs 2/6/16
SmartSceneState.prototype.GetSelectedSceneOptions = function ()
{
    var selectedItems = [];
    for (var i = 0; i < this.SmartSceneItems.length; i++)
    {
        selectedItems.push(this.SmartSceneItems[i].GetActiveSceneIndex());
    }
    return selectedItems;
};

SmartSceneState.prototype.SetSelectedSceneOptions = function (selectedItems)
{
    //this is bad
    if (selectedItems.length != this.SmartSceneItems.length)
        return;

    for (var i = 0; i < this.SmartSceneItems.length; i++)
    {
        this.SmartSceneItems[i].ActivateSceneOption(selectedItems[i]);
    }

};

SmartSceneState.prototype.CopySmartSceneState = function (rhs, colorableState)
{
    if (rhs == undefined || rhs == null)
    {
        return;
    }

    for (var i = 0; i < rhs.SmartSceneItems.length; i++)
    {
        var smartSceneItem = new SmartSceneItem()
        smartSceneItem.CopySmartSceneItem(rhs.SmartSceneItems[i], this._ShapeId, colorableState);


        this.SmartSceneItems.push(smartSceneItem);
    }
};