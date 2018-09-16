function TChartLayout(enableTitle, enableDescription, scale)
{
    BaseStoryboardLayout.call(this, enableTitle, enableDescription, scale,12);


    this.LayoutType = StoryboardLayoutType.TChart;

    
    this._ChartTitleStrokeWidth = 6;
    this._ChartGridStrokeWidth = 9;

    this._ChartLabelHeight = 55;
    
    this._ChartLabelPaddingTop = (this._Padding-(this._CellStroke/2)) + (this._ChartTitleStrokeWidth/2);    
    this._ChartLabelPaddingBottom = (this._Padding - (this._CellStroke / 2)) + (this._ChartTitleStrokeWidth / 2) + (this._ChartGridStrokeWidth / 2);  // 6 stroke thickness on either side vs usual 3 
    
    this.CellPaddingLeft = (this._Padding * 2) + this._ChartGridStrokeWidth;

    this.Row1PaddingTop = this._ChartLabelPaddingTop + this._ChartLabelHeight + this._ChartLabelPaddingBottom + (this._ChartGridStrokeWidth / 2);
    this.Row1PaddingLeft = this.CellPaddingLeft;

    //when transitioning between cell types we need update scale
    this.CellPaddingLeft *= scale;
    this.Row1PaddingTop *= scale;
    this.Row1PaddingLeft *= scale;

    this._ChartLabelHeight *= scale;
    this._ChartLabelPaddingTop *= scale;
    this._ChartLabelPaddingBottom *= scale;

};

inheritPrototype(TChartLayout, BaseStoryboardLayout);

TChartLayout.prototype._ExpandCellsLayoutSpecific = function (amount)
{
    this._ChartLabelHeight *= amount;
    this._ChartLabelPaddingTop *= amount;
    this._ChartLabelPaddingBottom *= amount;
};

TChartLayout.prototype.GetStoryboardAreaTitleLayout = function (row,col)
{
    return new TChartTitle("24");
};

TChartLayout.prototype.GetLayoutLines = function (rows, cols)
{
    var g = SvgCreator.CreateSvgGroup("t-chart");

    var x1 = this.Row1PaddingLeft;
    var x2 = this.FullColumnWidth() * cols;
    var y1 = this._ChartLabelPaddingTop + this._ChartLabelHeight + this._ChartLabelPaddingBottom;
    var y2 = y1;
    var stroke = "stroke:black; stroke-width:" + this._ChartGridStrokeWidth + "px; ";

    g.appendChild(SvgCreator.AddLine(x1, y1, x2, y2, stroke, "t-chart-horizontal"));

    for (var i = 1; i < cols; i++)
    {
        var x1 = (i * this.FullColumnWidth()) + this.Row1PaddingLeft / 2;
        var x2 = x1;
        var y1 = this._ChartLabelPaddingTop - (this._ChartTitleStrokeWidth / 2);
        var y2 = (this.FullRowHeight() * rows) + this._ChartLabelPaddingTop + this._ChartLabelHeight + this._ChartLabelPaddingBottom + this._ChartTitleStrokeWidth - this.BetweenRowPadding;

        g.appendChild(SvgCreator.AddLine(x1, y1, x2, y2, stroke, "t-chart-vertical-" + i));
    }

    return g;

};

TChartLayout.prototype._AreaTitlePosition = function (row, col)
{
    if (row != 0)
        return;

    var titleBoxLayout = this.GetStoryboardAreaTitleLayout(row,col);

    var extraStrokeWidth = titleBoxLayout.StrokeWidth - 3;

    var x = (col * this.FullColumnWidth()) + (this.Row1PaddingLeft) + extraStrokeWidth / 2;
    var y = this._ChartLabelPaddingTop;

    var boxPosition = new BoxPosition(this._ChartLabelHeight, this.CellWidth - extraStrokeWidth, x, y, row, col, StoryboardPartTypeEnum.StoryboardAreaTitle);

    return boxPosition;
};
