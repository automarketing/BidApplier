function SmartSceneDialog(activeShape)
{
    this._ActiveShape = activeShape;

    this._PreviewSceneWidth = 600;
    this._PreviewSceneHeight = 400;

    this._PrepareDialog();

    this.CancelButtonPressed = false;

    
    this.UndoInfo_Colors;
    this.UndoInfo_SelectedSceneOptions;
    //a.ColorableState.Public_CopyColorStyles(colors)
};


SmartSceneDialog.prototype._PrepareDialog = function ()
{
    this._PrepareDialog_PrepareUndo();
    this._PrepareDialog_SceneOptions();
    this._PrepareDialog_FigureOutSize();

    this.CancelButtonPressed = false;

    $("#Smart-Scene-Preview").children().remove();

    MyPointers.Dialog_SmartScene.one('shown.bs.modal', this._PrepareDialog_PostModalShown_Closure(this));
    MyPointers.Dialog_SmartScene.modal();

};

SmartSceneDialog.prototype._PrepareDialog_PostModalShown_Closure = function (smartSceneDialog)
{
    return function (e)
    {
        smartSceneDialog._RedrawActiveScene();
    };
};

SmartSceneDialog.prototype._RedrawActiveScene = function ()
{
    SvgCloner.CloneSvg("Smart-Scene-Preview", this._ActiveShape.Id, "smart-scene-preview-area", this._PreviewSceneWidth, this._PreviewSceneHeight);
};

SmartSceneDialog.prototype._PrepareDialog_PrepareUndo = function ()
{
    this.UndoInfo_SelectedSceneOptions = this._ActiveShape.SmartSceneState.GetSelectedSceneOptions();

    this.UndoInfo_Colors = null;
    if (this._ActiveShape.Property_IsColorable())
        this.UndoInfo_Colors = this._ActiveShape.ColorableState.Public_GetColorStyles();
};

SmartSceneDialog.prototype._PrepareDialog_SceneOptions = function ()
{
    var optionsArea = $("#smart-scene-options");
    optionsArea.empty();

    var smartSceneItems = this._ActiveShape.SmartSceneState.SmartSceneItems;
    for (var i = 0; i < smartSceneItems.length; i++)
    {
        var smartSceneItem = smartSceneItems[i];
        optionsArea.append("<h2>" + smartSceneItem.GetTitle() + "</h2>")

        optionsArea.append("<div class=\"btn-group\" data-toggle=\"buttons\">")
        var optionsAreaDiv = optionsArea.children().last();

        for (var j = 0; j < smartSceneItem.SmartSceneItemOptions.length; j++)
        {
            var smartSceneItemOption = smartSceneItem.SmartSceneItemOptions[j];
            var id = "sco-" + i + "-" + j;

            var checked = smartSceneItemOption.IsActive ? "checked" : "";
            var isActive = smartSceneItemOption.IsActive ? "active" : "";

            optionsAreaDiv.append("<label class=\"btn btn-default smart-scene-button " + isActive + "\">");
            optionsAreaDiv.children().last().append("<input id=\"" + id + "\" type=\"radio\" autocomplete=\"off\" " + checked + " >" + smartSceneItemOption.GetTitle());

            var onClick = this._CreateOptionClosure(this,smartSceneItem, j);
            $("#" + id).change(onClick);
        }
    }
};

SmartSceneDialog.prototype._PrepareDialog_FigureOutSize = function ()
{
    var fullsize = $(window).width() > 1000;
    if (fullsize)
    {
        $("#SmartSceneDialogSize").css("width", "900px");
        this._PreviewSceneHeight = 400;
        this._PreviewSceneWidth = 600;
    }
    else
    {
        $("#SmartSceneDialogSize").css("width", "600px");
        this._PreviewSceneHeight = 400;
        this._PreviewSceneWidth = 300;
    }
};

//http://stackoverflow.com/questions/750486/javascript-closure-inside-loops-simple-practical-example
SmartSceneDialog.prototype._CreateOptionClosure = function (smartSceneDialog, smartSceneItem, index)
{
    return function (e)
    {
        //annoying check since using a radio vs a button..
        if ($(e.currentTarget).is(':checked'))
        {
            smartSceneItem.ActivateSceneOption(index);
            smartSceneDialog._RedrawActiveScene();            
        }
    }
};