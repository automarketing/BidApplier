function FrayerLayout(enableTitle, enableDescription, scale)
{
    BaseStoryboardLayout.call(this, enableTitle, enableDescription, scale,15);

    this.LayoutType = StoryboardLayoutType.Frayer;

    this._ChartLabelHeight = 55;
    
    this._ChartLabelPaddingTop = 2 * this._Padding;
    this._ChartLabelPaddingBottom = 2 * this._Padding;

    
    this.BetweenRowPadding = this._ChartLabelPaddingTop + this._ChartLabelHeight + this._ChartLabelPaddingBottom - (this.CellPaddingTop/scale);


    this._ChartLabelHeight *= scale
    this._ChartLabelPaddingTop *= scale;
    this._ChartLabelPaddingBottom *= scale;
    this.BetweenRowPadding *= scale;
};

inheritPrototype(FrayerLayout, BaseStoryboardLayout);

FrayerLayout.prototype._ExpandCellsLayoutSpecific = function (amount)
{
    this._ChartLabelHeight *= amount;
    this._ChartLabelPaddingTop *= amount;
    this._ChartLabelPaddingBottom *= amount;
};

FrayerLayout.prototype._EnableDescriptionLayoutSpecific = function (enableDescription)
{
    this.BetweenRowPadding = this._ChartLabelPaddingTop + this._ChartLabelHeight + this._ChartLabelPaddingBottom - this.CellPaddingTop;
};

FrayerLayout.prototype._EnableTitleLayoutSpecific = function (enableTitle)
{
    this.BetweenRowPadding = this._ChartLabelPaddingTop + this._ChartLabelHeight + this._ChartLabelPaddingBottom - this.CellPaddingTop;
};

//FrayerLayout.prototype.GetStoryboardAreaTitlesCount = function (rows, cols)
//{
//    return 1;
//};

FrayerLayout.prototype.GetStoryboardAreaTitleLayout = function (row,col)
{
    return new TChartTitle("24");
};

FrayerLayout.prototype.GetCellTitleOverrideText = function (row, col)
{
    var frayerText = "Definitions";

    if (row == 0 && col == 1)
        frayerText = "Characteristics";
    else if (row == 1 && col == 0)
        frayerText = "Examples";
    else if (row == 1 && col == 1)
        frayerText = "Non-Examples";

    return frayerText;
};


FrayerLayout.prototype._AreaTitlePosition = function (row,col)
{
    // only return on the first time
    if (row != 0 || col != 0)
        return;

    var titleBoxLayout = this.GetStoryboardAreaTitleLayout(row,col);

    var extraStrokeWidth = titleBoxLayout.StrokeWidth - 3;

    var x = this.FullColumnWidth() / 2 + this.CellPaddingLeft;
    var y = this.FullRowHeight() + this._ChartLabelPaddingTop - this.BetweenRowPadding;

    var boxPosition = new BoxPosition(this._ChartLabelHeight, this.CellWidth - extraStrokeWidth, x, y, 0, 0, StoryboardPartTypeEnum.StoryboardAreaTitle);

    return boxPosition;
};