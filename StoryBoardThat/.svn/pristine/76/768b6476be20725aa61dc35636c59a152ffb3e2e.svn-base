function MatrixLayout(enableTitle, enableDescription, scale)
{
    BaseStoryboardLayout.call(this, enableTitle, enableDescription, scale, 12);

    this.LayoutType = StoryboardLayoutType.Matrix;

    this._ChartTitleStrokeWidth = 6;
    this._ChartGridStrokeWidth = 9;

    this._ChartLabelHeight = 55; // FIXME: Dynamic on font size from GetStoryboardAreaTitleLayout?

    this._ChartLabelPaddingTop = (this._Padding - (this._CellStroke / 2)) + (this._ChartTitleStrokeWidth / 2) + (this._Padding + this._ChartTitleStrokeWidth);
    this._ChartLabelPaddingBottom = (this._Padding - (this._CellStroke / 2)) + (this._ChartTitleStrokeWidth / 2) + (this._ChartGridStrokeWidth / 2);  // 6 stroke thickness on either side vs usual 3 

    this._ChartLabelPaddingLeft = this._ChartLabelPaddingTop;
    this._ChartLabelPaddingRight = this._ChartLabelPaddingBottom;

    this.CellPaddingLeft = (this._Padding * 2) + this._ChartGridStrokeWidth;
    this.BetweenRowPadding = (this._Padding * 2) + (this._ChartGridStrokeWidth / 2);
    //this.CellPaddingTop = (this._Padding * 2) + this._ChartGridStrokeWidth;

    this.Row1PaddingTop = this._ChartLabelPaddingTop + this._ChartLabelHeight + this._ChartLabelPaddingBottom + (this._ChartGridStrokeWidth / 2);
    this.Row1PaddingLeft = this._ChartLabelPaddingLeft + (this.CellWidth/scale) + this._ChartLabelPaddingRight + (this._ChartGridStrokeWidth / 2) + (this._Padding / 2);

    this.WatermarkPaddingTop = 50;

    //when transitioning between cell types we need update scale
    this.BetweenRowPadding *= scale;
    this.CellPaddingLeft *= scale;
    this.Row1PaddingTop *= scale;
    this.Row1PaddingLeft *= scale;

    this._ChartLabelHeight *= scale;
    this._ChartLabelPaddingTop *= scale;
    this._ChartLabelPaddingBottom *= scale;
    this._ChartLabelPaddingLeft *= scale;
    this._ChartLabelPaddingRight *= scale;
    this.WatermarkPaddingTop *= scale;
};

inheritPrototype(MatrixLayout, BaseStoryboardLayout);

MatrixLayout.prototype._ExpandCellsLayoutSpecific = function (amount)
{
    this._ChartLabelHeight *= amount;
    this._ChartLabelPaddingTop *= amount;
    this._ChartLabelPaddingBottom *= amount;

    this._ChartLabelPaddingLeft *= amount;
    this._ChartLabelPaddingRight *= amount;

    this.WatermarkPaddingTop *= amount;
};

//MatrixLayout.prototype.GetStoryboardAreaTitlesCount = function (rows, cols)
//{
//    return cols + rows;
//};

MatrixLayout.prototype.GetStoryboardAreaTitleLayout = function (row,col)
{
    return new TChartTitle("24");
};

MatrixLayout.prototype._EnableDescriptionLayoutSpecific = function (enableDescription)
{
    this.BetweenRowPadding = (this._Padding * 2) + (this._ChartGridStrokeWidth / 2);
};

MatrixLayout.prototype._EnableTitleLayoutSpecific = function (enableTitle)
{
    this.BetweenRowPadding = (this._Padding * 2) + (this._ChartGridStrokeWidth / 2);
};

MatrixLayout.prototype.ChartLabelWidth = function () {

}

MatrixLayout.prototype.GetLayoutLines = function (rows, cols)
{
    var g = SvgCreator.CreateSvgGroup("t-chart");

    var x1, x2, y1, y2;

    var stroke = "stroke:black; stroke-width:" + this._ChartGridStrokeWidth + "px; ";

    var columnStartY = this._Padding;// - this._ChartTitleStrokeWidth;// / 2;// - (this._ChartTitleStrokeWidth / 2);
    var columnEndY = (this.FullRowHeight() * rows) + this.Row1PaddingTop - this._Padding + this._ChartGridStrokeWidth;

    var initialX = this._Padding + this._ChartGridStrokeWidth / 2;
    g.appendChild(SvgCreator.AddLine(initialX, columnStartY, initialX, columnEndY, stroke, "t-chart-vertical-0"));

    for (var i = 0; i <= cols; i++)
    {
        x1 = (i * this.FullColumnWidth()) + this.Row1PaddingLeft - (this.CellPaddingLeft / 2);
        x2 = x1;

        g.appendChild(SvgCreator.AddLine(x1, columnStartY, x2, columnEndY, stroke, "t-chart-vertical-" + i));
    }

    var rowStartX = this._Padding;
    var rowEndX = this.FullColumnWidth() * cols + this.Row1PaddingLeft - this._Padding;

    var initialY = this._Padding + this._ChartGridStrokeWidth / 2;
    g.appendChild(SvgCreator.AddLine(rowStartX, initialY, rowEndX, initialY, stroke, "t-chart-vertical-0"));
    for (var j = 0; j <= rows; j++)
    {
        y1 = this.Row1PaddingTop + (j * this.FullRowHeight()) - (this._Padding / 2);
        y2 = y1;

        g.appendChild(SvgCreator.AddLine(rowStartX, y1, rowEndX, y2, stroke, "t-chart-vertical-" + i + j));
    }
    return g;

};

MatrixLayout.prototype._AreaTitlePosition = function (row, col)
{
    var specialRowZero = false;
    if (row == -1 && col == -1)
    {
        row = 0;
        col = 0;
        specialRowZero = true;
    }
    if (row != 0 && col != 0 )
        return null;


    var extraStrokeWidth = this.GetStoryboardAreaTitleLayout().StrokeWidth - 3;
    
    if (specialRowZero)
    {
        x = this._ChartLabelPaddingLeft;
        y = this.Row1PaddingTop +  this._Padding;
    }

    else if (row==0)
    {
        x = (col * this.FullColumnWidth()) + (this.Row1PaddingLeft) + extraStrokeWidth / 2;
        y = this._ChartLabelPaddingTop;
    }
    else
    {
        x = this._ChartLabelPaddingLeft;
        y = this.Row1PaddingTop + ((row) * this.FullRowHeight()) + this._Padding; 
    }
    var boxPosition = new BoxPosition(this._ChartLabelHeight, this.CellWidth - extraStrokeWidth, x, y, row, col, StoryboardPartTypeEnum.StoryboardAreaTitle);

    return boxPosition;
};
