function HorizontalTimelineLayout(enableTitle, enableDescription, scale)
{
    BaseStoryboardLayout.call(this, enableTitle, enableDescription, scale,12);


    this.LayoutType = StoryboardLayoutType.TChart;

    
    this._ChartTitleStrokeWidth = 6;
    this._ChartGridStrokeWidth = 9;
    this._ChartOuterBoxWidth = 3;

    this._ChartLabelHeight = 55;
    
    this._ChartLabelPaddingTop = (this._Padding-(this._CellStroke/2)) + (this._ChartTitleStrokeWidth/2);    
    this._ChartLabelPaddingBottom = (this._Padding - (this._CellStroke / 2)) + (this._ChartTitleStrokeWidth / 2) + (this._ChartGridStrokeWidth / 2);  // 6 stroke thickness on either side vs usual 3 
    
    this.CellPaddingLeft = (this._Padding * 2) + this._ChartGridStrokeWidth;

    this.Row1PaddingTop = this._ChartLabelPaddingTop + this._ChartLabelHeight + this._ChartLabelPaddingBottom + (this._ChartGridStrokeWidth / 2) + 60;
    this.Row1PaddingLeft = this.CellPaddingLeft;

    //when transitioning between cell types we need update scale
    this.CellPaddingLeft *= scale;
    this.Row1PaddingTop *= scale;
    this.Row1PaddingLeft *= scale;

    this._ChartLabelHeight *= scale;
    this._ChartLabelPaddingTop *= scale;
    this._ChartLabelPaddingBottom *= scale;
    this.WatermarkPaddingTop = 50;

};

inheritPrototype(HorizontalTimelineLayout, BaseStoryboardLayout);

HorizontalTimelineLayout.prototype._ExpandCellsLayoutSpecific = function (amount)
{
    this._ChartLabelHeight *= amount;
    this._ChartLabelPaddingTop *= amount;
    this._ChartLabelPaddingBottom *= amount;
};

HorizontalTimelineLayout.prototype.GetStoryboardAreaTitleLayout = function (row, col)
{
    return new TChartTitle("24");
};

HorizontalTimelineLayout.prototype.GetLayoutLines = function (rows, cols)
{
    var g = SvgCreator.CreateSvgGroup("t-chart");

    var x1 = this.Row1PaddingLeft - this._Padding;
    var x2 = this.Row1PaddingLeft + this._GetGap(cols - 1) + this.FullColumnWidth();
    var y1 = this._ChartLabelPaddingTop + this._ChartLabelHeight + this._ChartLabelPaddingBottom +20;
    var y2 = y1;
    var stroke = "stroke:black; stroke-width:" + this._ChartGridStrokeWidth + "px; ";

    g.appendChild(SvgCreator.AddLine(x1, y1, x2, y2, stroke, "t-chart-horizontal"));

    for (var col = 0; col < cols; col++)
    {
        var boxPosition = this.GetCellPartPosition(StoryboardPartTypeEnum.StoryboardCellTitle, 0,col);
        var anchorBox = this.GetAnchorPoints(boxPosition);

        boxPosition.X -= this._Padding;
        boxPosition.Width += 2 * this._Padding;

        boxPosition.Y -= this._Padding;
        boxPosition.Height = this.FullRowHeight() + 2 * this._Padding - this.BetweenRowPadding;

        var rect = SvgCreator.AddRect(boxPosition.X, boxPosition.Y, boxPosition.Width, boxPosition.Height, "black", "none", null, null, "outerbox_" + col);
        rect.setAttributeNS(null, "stroke-width", + this._ChartOuterBoxWidth + "px");
        g.appendChild(rect);

        g.appendChild(SvgCreator.AddLine(anchorBox.MiddleX, 72, anchorBox.MiddleX, 150, "stroke:black; stroke-width:" + this._ChartOuterBoxWidth + "px", "timeline-connector-" +col));

        if (this._TimeJump(col))
        {
            var timeJumpX1 = anchorBox.Left - .25 * this.FullColumnWidth() - 10;
            var timeJumpX2 = anchorBox.Left - .25 * this.FullColumnWidth() + 10;
            var timeJumpY1 = y1 + 15;
            var timeJumpY2 = y1 - 15;

            g.appendChild(SvgCreator.AddLine(timeJumpX1, timeJumpY1, timeJumpX2, timeJumpY2, "stroke:black; stroke-width:" + this._ChartOuterBoxWidth + "px", "time-jump-a" + col));
            g.appendChild(SvgCreator.AddLine(timeJumpX1+10, timeJumpY1, timeJumpX2+10, timeJumpY2, "stroke:black; stroke-width:" + this._ChartOuterBoxWidth + "px", "time-jump-b" + col));
        }

    }
    //    var x1 = (i * this.FullColumnWidth()) + this.Row1PaddingLeft / 2;
    //    var x2 = x1;
    //    var y1 = this._ChartLabelPaddingTop - (this._ChartTitleStrokeWidth / 2);
    //    var y2 = (this.FullRowHeight() * rows) + this._ChartLabelPaddingTop + this._ChartLabelHeight + this._ChartLabelPaddingBottom + this._ChartTitleStrokeWidth - this.BetweenRowPadding;

    //    g.appendChild(SvgCreator.AddLine(x1, y1, x2, y2, stroke, "t-chart-vertical-" + i));
    //}

    return g;

};

HorizontalTimelineLayout.prototype._TimeJump = function (col)
{
    var dates = [new Date("3/22/1765"),
               new Date("3/5/1770"),
               new Date("12/16/1773"),
               new Date("1/1/1774"),
               new Date("9/5/1774"),
               new Date("4/18/1775"),
               new Date("7/4/1776"),
               new Date("9/19/1777"),
               new Date("10/19/1781"),
               new Date("9/3/1783")
    ];

    if (col == 0)
        return 0;

    var oneUnit = dates[5] - dates[4];

    var delta = (dates[col] - dates[col - 1]) / oneUnit;
    if (delta > 5 || delta < 1)
        return true;

    return false;
};

HorizontalTimelineLayout.prototype._GetGap = function (col)
{
    var dates = [new Date("3/22/1765"),
                 new Date("3/5/1770"),
                 new Date("12/16/1773"),
                 new Date("1/1/1774"),
                 new Date("9/5/1774"),
                 new Date("4/18/1775"),
                 new Date("7/4/1776"),
                 new Date("9/19/1777"),
                 new Date("10/19/1781"),
                 new Date("9/3/1783")
    ];

    if (col == 0)
        return 0;

    var oneUnit = dates[5] - dates[4];

    var delta = (dates[col] - dates[col - 1]) / oneUnit;
    if (delta > 5 || delta<1)
        delta = 1.5;

    return delta * this.FullColumnWidth() + this._GetGap(col - 1);
};

HorizontalTimelineLayout.prototype._AreaTitlePosition = function (row, col)
{
    if (row != 0)
        return;

    var titleBoxLayout = this.GetStoryboardAreaTitleLayout(row,col);

    var extraStrokeWidth = titleBoxLayout.StrokeWidth - 3;

    var x = this._GetGap(col) + (this.Row1PaddingLeft) + extraStrokeWidth / 2;
    var y = this._ChartLabelPaddingTop;

    var boxPosition = new BoxPosition(this._ChartLabelHeight, this.CellWidth - extraStrokeWidth, x, y, row, col, StoryboardPartTypeEnum.StoryboardAreaTitle);

    return boxPosition;
};


HorizontalTimelineLayout.prototype._CellPosition = function (row, col)
{
    var x = this._GetGap(col) + (this.Row1PaddingLeft);
    var y = this.Row1PaddingTop + this.BeforeCellHeight() + (row * (this.FullRowHeight()));

    var boxPosition = new BoxPosition(this.CellHeight, this.CellWidth, x, y, row, col, StoryboardPartTypeEnum.StoryboardCell);

    return boxPosition;
};

HorizontalTimelineLayout.prototype._CellTitlePosition = function (row, col)
{
    var x = this._GetGap(col) + (this.Row1PaddingLeft);
    var y = this.Row1PaddingTop + this.TitlePaddingTop + (row * (this.FullRowHeight()));

    var boxPosition = new BoxPosition(this.TitleHeight, this.CellWidth, x, y, row, col, StoryboardPartTypeEnum.StoryboardCellTitle);

    return boxPosition;
};

HorizontalTimelineLayout.prototype._CellDescriptionPosition = function (row, col)
{

    var x = this._GetGap(col) + (this.Row1PaddingLeft);
    var y = this.Row1PaddingTop + this.BeforeDescriptionHeight() + (row * (this.FullRowHeight()));

    var boxPosition = new BoxPosition(this.DescriptionHeight, this.CellWidth, x, y, row, col, StoryboardPartTypeEnum.StoryboardCellDescription);

    return boxPosition;
};

HorizontalTimelineLayout.prototype._GetStoryboardSizePreAttribution = function (rows, cols)
{
    var boxPosition = new BoxPosition();

    boxPosition.X = 0;
    boxPosition.Y = 0;

    boxPosition.Width = this.Row1PaddingLeft + this._GetGap(cols-1) + this.FullColumnWidth();
    boxPosition.Height = this.Row1PaddingTop + this.WatermarkPaddingTop + this.ContainerBorderPaddingBottom + (rows * (this.FullRowHeight())) - this.BetweenRowPadding;

    return boxPosition;
};

HorizontalTimelineLayout.prototype.GetStoryboardContentBounds = function (rows, cols)
{
    var boxPosition = new BoxPosition();

    boxPosition.X = 0;
    boxPosition.Y = 0;

    boxPosition.Height = this.Row1PaddingTop + (rows * (this.FullRowHeight())) - this.BetweenRowPadding;
    boxPosition.Width = this.Row1PaddingLeft + this._GetGap(cols - 1) + this.FullColumnWidth();

    return boxPosition;
};