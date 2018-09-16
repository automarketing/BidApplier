function BaseStoryboardLayout(enableTitle, enableDescription, scale, padding)
{
    //#region "Properties"
    this.LayoutType = "";

    this._Padding = padding;
    this._CellStroke = 3;
    

    this.ContainerBorderPaddingRight = 0;
    this.ContainerBorderPaddingBottom = this._Padding;

    this.WatermarkPaddingTop = 25;

    this.Row1PaddingTop = 0;
    this.Row1PaddingLeft = this._Padding;

    this.CellPaddingLeft = this._Padding;
    this.CellPaddingTop = this._Padding;

    this.CellHeight = 336;
    this.CellWidth = 372;

    this.TitlePaddingTop = 0;
    this.TitleHeight = 0;

    this.DescriptionHeight = 0;
    this.DescriptionPaddingTop = 0;

    this.BetweenRowPadding = 0;

    this.TitleLayout = new BasicTextLayoutTitle();
    this.DescriptionLayout = new BasicTextLayoutDescription();

    //Cell Style
    this.Stroke = "black";
    this.StrokeWidth = "3";
    
    //this.StrokeWidth = "2";

    this.Fill = "white";
    this.Rx = "2";
    this.Ry = "2";
    this.StrokeDashArray = "";
    this.Opacity = "1";


    this.BackGroundOffsetX = .5;
    this.BackGroundOffsetY = .5;



    this.DefaultDropWidth = 180;
    this.DefaultDropHeight = 180;

    this.HasTitle = false;
    this.HasDescription = false;

    this.UnscaledCellWidth = 372;

    //#endregion



    //#region "Constructor"
    this.EnableDescription(enableDescription);
    this.EnableTitle(enableTitle);
    this.ExpandCells(scale);
    //#endregion 
};

//#region "Storyboard Cell Size"
BaseStoryboardLayout.prototype.GetScale = function ()
{
    return this.CellWidth / 372;
};

BaseStoryboardLayout.prototype._ExtraFullColumnWidth = function ()
{
    return 0;
};

BaseStoryboardLayout.prototype._ExtraFullRowHeight = function ()
{
    return 0;
};

BaseStoryboardLayout.prototype.FullColumnWidth = function ()
{
    var fullColWidth = this.CellPaddingLeft;
    fullColWidth += this.CellWidth;

    fullColWidth += this._ExtraFullColumnWidth();

    return fullColWidth;
};

BaseStoryboardLayout.prototype.FullRowHeight = function ()
{
    var fullRowHeight = this.TitlePaddingTop;
    fullRowHeight += this.TitleHeight;

    fullRowHeight += this.CellPaddingTop;
    fullRowHeight += this.CellHeight;

    fullRowHeight += this.DescriptionPaddingTop;
    fullRowHeight += this.DescriptionHeight;
    fullRowHeight += this.BetweenRowPadding;

    fullRowHeight += this._ExtraFullRowHeight();

    return fullRowHeight;
};

BaseStoryboardLayout.prototype.BeforeCellHeight = function ()
{
    var beforeCell = this.TitlePaddingTop;
    beforeCell += this.TitleHeight;

    beforeCell += this.CellPaddingTop;

    return beforeCell;
};

BaseStoryboardLayout.prototype.BeforeDescriptionHeight = function ()
{
    var beforeDescriptionHeight = this.TitlePaddingTop;
    beforeDescriptionHeight += this.TitleHeight;

    beforeDescriptionHeight += this.CellPaddingTop;
    beforeDescriptionHeight += this.CellHeight;

    beforeDescriptionHeight += this.DescriptionPaddingTop;

    return beforeDescriptionHeight;
};

BaseStoryboardLayout.prototype._ExpandCellsLayoutSpecific = function (amount)
{

};

BaseStoryboardLayout.prototype.ExpandCells = function (amount)
{
    if (amount == null || isNaN(amount))
        return;

    this.CellWidth *= amount;
    this.CellHeight *= amount;

    this.DefaultDropWidth *= amount;
    this.DefaultDropHeight *= amount;

    this.CellPaddingTop *= amount;
    this.CellPaddingLeft *= amount;

    this.Row1PaddingTop *= amount;
    this.Row1PaddingLeft *= amount;

    this.ContainerBorderPaddingRight *= amount;

    this.TitlePaddingTop *= amount;
    this.TitleHeight *= amount;

    this.DescriptionHeight *= amount;
    this.DescriptionPaddingTop *= amount;

    this.BetweenRowPadding *= amount;

    this._ExpandCellsLayoutSpecific(amount);
};

//#endregion

BaseStoryboardLayout.prototype.Activate = function () {

}

BaseStoryboardLayout.prototype.Deactivate = function () {

}

BaseStoryboardLayout.prototype._EnableTitleLayoutSpecific = function (enableTitle)
{
};

BaseStoryboardLayout.prototype.EnableTitle = function (enableTitle)
{
    if (enableTitle == null || enableTitle == this.HasTitle)
        return;

    if (enableTitle)
    {
        var scaleAmount = this.GetScale();

        this.TitlePaddingTop = scaleAmount * this._Padding;
        this.TitleHeight = scaleAmount * 50;
        this.BetweenRowPadding = 25;
    }
    else
    {
        this.TitlePaddingTop = 0;
        this.TitleHeight = 0;

        if (this.HasDescription == false)
            this.BetweenRowPadding = 0;
    }

    this.HasTitle = enableTitle;

    this._EnableTitleLayoutSpecific(enableTitle);
};

BaseStoryboardLayout.prototype._EnableDescriptionLayoutSpecific = function (enableDescription)
{
};

BaseStoryboardLayout.prototype.EnableDescription = function (enableDescription)
{

    if (enableDescription == null || enableDescription == this.HasDescription)
        return;

    if (enableDescription)
    {
        var scaleAmount = this.GetScale();

        this.DescriptionPaddingTop = scaleAmount * this._Padding;
        this.DescriptionHeight = scaleAmount * 90;

        this.BetweenRowPadding = 25;
    }
    else
    {
        this.DescriptionPaddingTop = 0;
        this.DescriptionHeight = 0;

        if (this.HasTitle == false)
            this.BetweenRowPadding = 0;
    }

    this.HasDescription = enableDescription;

    this._EnableDescriptionLayoutSpecific(enableDescription);
};

BaseStoryboardLayout.prototype.GetScale = function ()
{
    return this.CellWidth / this.UnscaledCellWidth;
};

//BaseStoryboardLayout.prototype.GetStoryboardAreaTitlesCount = function (rows, cols)
//{
//    return 0;
//};

BaseStoryboardLayout.prototype.GetStoryboardAreaTitleLayout = function (index)
{
    return null;
};

BaseStoryboardLayout.prototype.GetCellTitleOverrideText = function (row, col)
{
    return this.TitleLayout.DefaultText;
};

BaseStoryboardLayout.prototype.GetLayoutLines = function (rows, cols)
{
    return null;
};

//#region "Positioning"
BaseStoryboardLayout.prototype.GetCellPartPosition = function (partType, row, col)
{
    switch (partType)
    {
        case StoryboardPartTypeEnum.StoryboardCell:
            return this._CellPosition(row, col);

        case StoryboardPartTypeEnum.StoryboardCellTitle:
            return this._CellTitlePosition(row, col);

        case StoryboardPartTypeEnum.StoryboardCellDescription:
            return this._CellDescriptionPosition(row, col);

        case StoryboardPartTypeEnum.StoryboardAreaTitle:
            return this._AreaTitlePosition(row, col);

        case StoryboardPartTypeEnum.StoryboardAttributionArea:
            return this._AttributionAreaPosition(row, col);
    }
};

BaseStoryboardLayout.prototype._CellPosition = function (row, col)
{
    var x = this.Row1PaddingLeft + (col * (this.CellPaddingLeft + this.CellWidth));
    var y = this.Row1PaddingTop + this.BeforeCellHeight() + (row * (this.FullRowHeight()));

    var boxPosition = new BoxPosition(this.CellHeight, this.CellWidth, x, y, row, col, StoryboardPartTypeEnum.StoryboardCell);

    return boxPosition;
};

BaseStoryboardLayout.prototype._CellTitlePosition = function (row, col)
{
    var x = this.Row1PaddingLeft + (col * (this.CellPaddingLeft + this.CellWidth));
    var y = this.Row1PaddingTop + this.TitlePaddingTop + (row * (this.FullRowHeight()));

    var boxPosition = new BoxPosition(this.TitleHeight, this.CellWidth, x, y, row, col, StoryboardPartTypeEnum.StoryboardCellTitle);

    return boxPosition;
};

BaseStoryboardLayout.prototype._CellDescriptionPosition = function (row, col)
{

    var x = this.Row1PaddingLeft + (col * (this.CellPaddingLeft + this.CellWidth));
    var y = this.Row1PaddingTop + this.BeforeDescriptionHeight() + (row * (this.FullRowHeight()));

    var boxPosition = new BoxPosition(this.DescriptionHeight, this.CellWidth, x, y, row, col, StoryboardPartTypeEnum.StoryboardCellDescription);

    return boxPosition;
};

BaseStoryboardLayout.prototype._AttributionAreaPosition = function (row, col)
{
    var storyboardSize = this._GetStoryboardSizePreAttribution(row, col);

    var boxPosition = new BoxPosition(20, storyboardSize.Width - (2 * this._Padding), this._Padding, storyboardSize.Height + this._Padding, row, col, StoryboardPartTypeEnum.StoryboardAttributionArea);

    return boxPosition;
};

BaseStoryboardLayout.prototype._AreaTitlePosition = function (row, col)
{
    return null;
};


BaseStoryboardLayout.prototype.GetAnchorPoints = function (boxPosition)
{
    boxPosition.Top = boxPosition.Y;
    boxPosition.NearTop = boxPosition.Y + 2 * this._Padding;
    boxPosition.MiddleY = boxPosition.Y + boxPosition.Height / 2;
    boxPosition.NearBottom = boxPosition.Y + boxPosition.Height - (2 * this._Padding);
    boxPosition.Bottom = boxPosition.Y + boxPosition.Height;

    boxPosition.Left = boxPosition.X;
    boxPosition.NearLeft = boxPosition.X + 2 * this._Padding;
    boxPosition.MiddleX = boxPosition.X + boxPosition.Width / 2;
    boxPosition.NearRight = boxPosition.X + boxPosition.Width - (2 * this._Padding);
    boxPosition.Right = boxPosition.X + boxPosition.Width;

    boxPosition.Center = new Point(boxPosition.MiddleX, boxPosition.MiddleY);

    return boxPosition;

};


//#endregion

//#region "Storyboard Size"

//how tiny the cell area can be - example small input screens, you shoudl still get a minimum of one row
BaseStoryboardLayout.prototype.GetMinimumStoryboardHeight = function ()
{
    var height = this.Row1PaddingTop + this.FullRowHeight() + this.ContainerBorderPaddingBottom + this.WatermarkPaddingTop + 20; //yes misc 20...:(
    return height;
};

BaseStoryboardLayout.prototype._GetStoryboardSizePreAttribution = function (rows, cols)
{
    var boxPosition = new BoxPosition();

    boxPosition.X = 0;
    boxPosition.Y = 0;

    boxPosition.Width = this.Row1PaddingLeft + this.ContainerBorderPaddingRight + (cols * (this.FullColumnWidth()));
    boxPosition.Height = this.Row1PaddingTop + this.WatermarkPaddingTop + this.ContainerBorderPaddingBottom + (rows * (this.FullRowHeight())) - this.BetweenRowPadding;

    return boxPosition;
};

BaseStoryboardLayout.prototype.GetStoryboardSize = function (rows, cols)
{
    var boxPosition = this._GetStoryboardSizePreAttribution(rows, cols);

    var attributionArea = GetGlobalById("ImageAttributionGroup");
    if (attributionArea != null)
    {
        try
        {
            var bbox = attributionArea.getBBox();
            if (bbox.height > 0)
                boxPosition.Height += 2 * this._Padding + bbox.height;
        }
        catch (e)
        {
            LogErrorMessage("BaseStoryboardLayout.GetStoryboardSize", e);
        }
    }

    return boxPosition;
};

//dont include watermark area
BaseStoryboardLayout.prototype.GetStoryboardContentBounds = function (rows, cols)
{
    var boxPosition = new BoxPosition();

    boxPosition.X = 0;
    boxPosition.Y = 0;

    boxPosition.Height = this.Row1PaddingTop + (rows * (this.FullRowHeight())) - this.BetweenRowPadding;
    boxPosition.Width = this.Row1PaddingLeft + (cols * (this.FullColumnWidth()));

    return boxPosition;
};

BaseStoryboardLayout.prototype.GetWatermarkTop = function (rows)
{
    var y = this.Row1PaddingTop + this.WatermarkPaddingTop + (rows * this.FullRowHeight()) - this.BetweenRowPadding;
    return y;
}

//#endregion

BaseStoryboardLayout.prototype.GetLayoutConfig = function ()
{
    return null;
};
