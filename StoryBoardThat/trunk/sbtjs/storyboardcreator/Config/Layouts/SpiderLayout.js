function SpiderLayout(enableTitle, enableDescription, scale)
{
    BaseStoryboardLayout.call(this, enableTitle, enableDescription, scale, 12);

    this.LayoutType = StoryboardLayoutType.Spider;
    this.Layouts = null;

    this._ChartGridStrokeWidth = 6;
    this._ChartLabelHeight = 55;

    this.ContainerBorderPaddingRight = -2 * this._Padding;

    this.CellPaddingLeft = 4 * this._Padding;

    this.Row1PaddingTop = 2 * this._Padding;
    this.Row1PaddingLeft = 2 * this._Padding;

    this.BetweenRowPadding = (this.TitlePaddingTop / scale + this.TitleHeight / scale + this.CellPaddingTop / scale + this.CellHeight / scale + this.DescriptionPaddingTop / scale + this.DescriptionHeight / scale) * .75;


    //Special Scales
    this._ChartLabelHeight *= scale;
    this.ContainerBorderPaddingRight *= scale;

    this.CellPaddingLeft *= scale;
    this.Row1PaddingTop *= scale;
    this.Row1PaddingLeft *= scale;

    this.BetweenRowPadding *= scale;

    this._InitializeCellLayouts();
};

inheritPrototype(SpiderLayout, BaseStoryboardLayout);

SpiderLayout.prototype._ExtraFullColumnWidth = function ()
{
    return (this._Padding * 2);
};

SpiderLayout.prototype._ExtraFullRowHeight = function ()
{
    return (this._Padding * 1);
};

SpiderLayout.prototype._ExpandCellsLayoutSpecific = function (amount)
{
    this._ChartLabelHeight *= amount;
    //this._ChartLabelPaddingTop *= amount;
    //this._ChartLabelPaddingBottom *= amount;
};

SpiderLayout.prototype.GetStoryboardAreaTitleLayout = function (row, col)
{
    return new TChartTitle("24");
};

SpiderLayout.prototype._EnableDescriptionLayoutSpecific = function (enableDescription)
{
    this.BetweenRowPadding = (this.TitlePaddingTop + this.TitleHeight + this.CellPaddingTop + this.CellHeight + this.DescriptionPaddingTop + this.DescriptionHeight) * .75;
};

SpiderLayout.prototype._EnableTitleLayoutSpecific = function (enableTitle)
{
    this.BetweenRowPadding = (this.TitlePaddingTop + this.TitleHeight + this.CellPaddingTop + this.CellHeight + this.DescriptionPaddingTop + this.DescriptionHeight) * .75;
};


SpiderLayout.prototype.GetLayoutLines = function (rows, cols)
{
    var g = SvgCreator.CreateSvgGroup("t-chart");

    var vector;

    var stroke = "stroke:black; stroke-width:" + this._ChartGridStrokeWidth + "px; ";

    var titleZone = this.GetAnchorPoints(this._AreaTitlePosition(0, 0));



    for (var i = 0; i < cols; i++)
    {
        var anchorBox = this.GetAnchorPoints(this._CellAnchorPoint(i));
        var rect = SvgCreator.AddRect(anchorBox.X, anchorBox.Y, anchorBox.Width, anchorBox.Height, "black", "none", null, null, "outerbox_" + i);
        rect.setAttributeNS(null, "stroke-width", this._ChartGridStrokeWidth + "px");
        g.appendChild(rect);

        vector = null;
        switch (anchorBox.CellTitle)
        {
            case "6A":
            case "8A":
            case "10A":
                {
                    vector = new Vector(anchorBox.MiddleX, titleZone.Top, anchorBox.MiddleX, anchorBox.Bottom);//Attach Bottom Center
                    break;
                }
            case "6D":
            case "8E":
            case "10F":
                {
                    vector = new Vector(anchorBox.MiddleX, titleZone.Bottom, anchorBox.MiddleX, anchorBox.Top);//Attach Top Center
                    break;
                }

            case "6B":
            case "8B":
            case "10B":
                {
                    vector = new Vector(titleZone.NearRight, titleZone.Top, anchorBox.Left, anchorBox.NearBottom);//Attach Bottom Left
                    break;
                }
            case "6C":
            case "8D":
            case "10E":
                {
                    vector = new Vector(titleZone.NearRight, titleZone.Bottom, anchorBox.Left, anchorBox.NearTop);//Attach Bottom Left
                    break;
                }
            case "6F":
            case "8H":
            case "10J":
                {
                    vector = new Vector(titleZone.NearLeft, titleZone.Top, anchorBox.Right, anchorBox.NearBottom);//Attach Top Right
                    break;
                }
            case "6E":
            case "8F":
            case "10G":
                {
                    vector = new Vector(titleZone.NearLeft, titleZone.Bottom, anchorBox.Right, anchorBox.NearTop);//Attach Bottom Right
                    break;
                }
            case "8C":
                {
                    vector = new Vector(titleZone.Right, titleZone.MiddleY, anchorBox.Left, titleZone.MiddleY);
                    break;
                }
            case "8G":
                {
                    vector = new Vector(titleZone.Left, titleZone.MiddleY, anchorBox.Right, titleZone.MiddleY);
                    break;
                }
            case "10C":
                {
                    vector = new Vector(titleZone.Right, titleZone.MiddleY - this._Padding / 2, anchorBox.Left, anchorBox.NearBottom);
                    break;
                }
            case "10D":
                {
                    vector = new Vector(titleZone.Right, titleZone.MiddleY + this._Padding / 2, anchorBox.Left, anchorBox.NearTop);
                    break;
                }
            case "10I":
                {
                    vector = new Vector(titleZone.Left, titleZone.MiddleY - this._Padding / 2, anchorBox.Right, anchorBox.NearBottom);
                    break;
                }
            case "10H":
                {
                    vector = new Vector(titleZone.Left, titleZone.MiddleY + this._Padding / 2, anchorBox.Right, anchorBox.NearTop);
                    break;
                }



        }

        if (vector)
            g.appendChild(SvgCreator.AddLine(vector.X1, vector.Y1, vector.X2, vector.Y2, stroke, "t-chart-vertical-" + i));
    }


    return g;

};

SpiderLayout.prototype._AreaTitlePosition = function (row, col)
{
    // only return on the first time
    if (row != 0 || col != 0)
        return;

    var titleBoxLayout = this.GetStoryboardAreaTitleLayout();

    var extraStrokeWidth = titleBoxLayout.StrokeWidth - 3;


    var virtualCols = this._VirtualCols(StoryboardContainer.Cols);
    var colOffset = (virtualCols - 1) / 2;

    var x = this.FullColumnWidth() * colOffset + this.Row1PaddingLeft + this._Padding;
    var y = this.Row1PaddingTop + this.FullRowHeight() - this.BetweenRowPadding + (this.BetweenRowPadding - this._ChartLabelHeight) / 2;

    var boxPosition = new BoxPosition(this._ChartLabelHeight, this.CellWidth - extraStrokeWidth, x, y, 0, 0, StoryboardPartTypeEnum.StoryboardAreaTitle);

    return boxPosition;
};



SpiderLayout.prototype._CellPosition = function (row, col)
{
    var cellAnchorPoint = this._CellAnchorPoint(col);
    var x = cellAnchorPoint.X + this._Padding;; //this._ChartGridStrokeWidth - this._CellStroke) * 2;
    var y = cellAnchorPoint.Y + this.BeforeCellHeight();

    var boxPosition = new BoxPosition(this.CellHeight, this.CellWidth, x, y, row, col, StoryboardPartTypeEnum.StoryboardCell);

    return boxPosition;
};

SpiderLayout.prototype._CellTitlePosition = function (row, col)
{
    var cellAnchorPoint = this._CellAnchorPoint(col);
    var x = cellAnchorPoint.X + this._Padding; //this._ChartGridStrokeWidth - this._CellStroke) * 2;
    var y = cellAnchorPoint.Y + this.TitlePaddingTop;

    var boxPosition = new BoxPosition(this.TitleHeight, this.CellWidth, x, y, row, col, StoryboardPartTypeEnum.StoryboardCellTitle);

    return boxPosition;
};

SpiderLayout.prototype._CellDescriptionPosition = function (row, col)
{
    var cellAnchorPoint = this._CellAnchorPoint(col);
    var x = cellAnchorPoint.X + this._Padding;; //this._ChartGridStrokeWidth - this._CellStroke) * 2;
    var y = cellAnchorPoint.Y + this.BeforeDescriptionHeight();

    var boxPosition = new BoxPosition(this.DescriptionHeight, this.CellWidth, x, y, row, col, StoryboardPartTypeEnum.StoryboardCellDescription);

    return boxPosition;
};

SpiderLayout.prototype._InitializeCellLayouts = function ()
{
    this.Layouts = new Object();

    this.Layouts["6A"] = new SpiderCellLocation("6A", 1, 0, 0);
    this.Layouts["6B"] = new SpiderCellLocation("6B", 2, 0, .25);
    this.Layouts["6C"] = new SpiderCellLocation("6C", 2, 1, -.25);
    this.Layouts["6D"] = new SpiderCellLocation("6D", 1, 1, 0);
    this.Layouts["6E"] = new SpiderCellLocation("6E", 0, 1, -.25);
    this.Layouts["6F"] = new SpiderCellLocation("6F", 0, 0, .25);

    this.Layouts["8A"] = new SpiderCellLocation("8A", 2, 0, 0);
    this.Layouts["8B"] = new SpiderCellLocation("8B", 3, 0, .25);
    this.Layouts["8C"] = new SpiderCellLocation("8C", 4, 0, .85);
    this.Layouts["8D"] = new SpiderCellLocation("8D", 3, 1, -.25);
    this.Layouts["8E"] = new SpiderCellLocation("8E", 2, 1, 0);
    this.Layouts["8F"] = new SpiderCellLocation("8F", 1, 1, -.25);
    this.Layouts["8G"] = new SpiderCellLocation("8G", 0, 0, .85);
    this.Layouts["8H"] = new SpiderCellLocation("8H", 1, 0, .25);

    this.Layouts["10A"] = new SpiderCellLocation("10A", 2, 0, 0);
    this.Layouts["10B"] = new SpiderCellLocation("10B", 3, 0, .15);
    this.Layouts["10C"] = new SpiderCellLocation("10C", 4, 0, .30);
    this.Layouts["10D"] = new SpiderCellLocation("10D", 4, 1, -.30);
    this.Layouts["10E"] = new SpiderCellLocation("10E", 3, 1, -.15);
    this.Layouts["10F"] = new SpiderCellLocation("10F", 2, 1, 0);
    this.Layouts["10G"] = new SpiderCellLocation("10G", 1, 1, -.15);
    this.Layouts["10H"] = new SpiderCellLocation("10H", 0, 1, -.30);
    this.Layouts["10I"] = new SpiderCellLocation("10I", 0, 0, .30);
    this.Layouts["10J"] = new SpiderCellLocation("10J", 1, 0, .15);

    
    this.Layouts[3] = ["6A", "6B", "6F"];
    this.Layouts[4] = ["6F", "6B", "6C", "6E" ];
    this.Layouts[5] = ["6A", "6B", "6C", "6E", "6F"];
    this.Layouts[6] = ["6A", "6B", "6C", "6D", "6E", "6F"];
    this.Layouts[7] = ["8A", "8B", "8C", "8D", "8F", "8G", "8H"];
    this.Layouts[8] = ["8A", "8B", "8C", "8D", "8E", "8F", "8G", "8H"];
    this.Layouts[9] = ["10A", "10B", "10C", "10D", "10E", "10G", "10H", "10I", "10J"];
    this.Layouts[10] = ["10A", "10B", "10C", "10D", "10E", "10F", "10G", "10H", "10I", "10J"];


    //// proxy data for changing to a frayer model
    this.Layouts[1] = ["6A", "6B", "6F"];
    this.Layouts[2] = ["6A", "6B", "6F"];
};

SpiderLayout.prototype.GetCellLayouts = function () {
    return Layouts;
}

SpiderLayout.prototype._CellAnchorPoint = function (col)
{
    var cellTitle = this.Layouts[StoryboardContainer.Cols][col]

    var spiderCellLocation = this.Layouts[cellTitle];

    var rowHeight = this.FullRowHeight() - this.BetweenRowPadding;
    var colWidth = this._Padding * 2 + this.CellWidth;

    var x = this.Row1PaddingLeft + (spiderCellLocation.FakeCol * this.FullColumnWidth());
    var y = this.Row1PaddingTop + (spiderCellLocation.FakeRow * this.FullRowHeight()) + (rowHeight * spiderCellLocation.RowOffset);

    var boxPosition = new BoxPosition(rowHeight, colWidth, x, y, 0, col, StoryboardPartTypeEnum.StoryboardCellOuterBox);
    boxPosition.CellTitle = cellTitle;

    return boxPosition;
};


SpiderLayout.prototype._VirtualCols = function (cols)
{
    layoutType = parseInt(this.Layouts[cols][0]);
    if (layoutType == 6)
        return 3;

    if (layoutType == 8)
        return 5;

    if (layoutType == 10)
        return 5;

    return 3;
};

SpiderLayout.prototype._VirtualRows = function (cols)
{
    if (cols == 3)
        return 1;

    return 2;
};

SpiderLayout.prototype._GetStoryboardSizePreAttribution = function (rows, cols)
{
    var boxPosition = new BoxPosition();

    rows = this._VirtualRows(cols);
    cols = this._VirtualCols(cols);

    boxPosition.X = 0;
    boxPosition.Y = 0;

    boxPosition.Width = this.Row1PaddingLeft + this.ContainerBorderPaddingRight + (cols * (this.FullColumnWidth()));
    boxPosition.Height = this.Row1PaddingTop + this.WatermarkPaddingTop + this.ContainerBorderPaddingBottom + (rows * (this.FullRowHeight())) - this.BetweenRowPadding;
    if (rows == 1)
    {
        boxPosition.Height += .6 * this.BetweenRowPadding;
    }

    return boxPosition;
};

SpiderLayout.prototype.GetStoryboardContentBounds = function (rows, cols)
{
    rows = this._VirtualRows(cols);
    cols = this._VirtualCols(cols);

    var boxPosition = new BoxPosition();

    boxPosition.X = 0;
    boxPosition.Y = 0;

    boxPosition.Width = this.Row1PaddingLeft + (cols * (this.FullColumnWidth()));
    boxPosition.Height = this.Row1PaddingTop + (rows * this.FullRowHeight()) - this.BetweenRowPadding;
    if (rows == 1)
    {
        boxPosition.Height += .6 * this.BetweenRowPadding;
    }



    return boxPosition;
};

SpiderLayout.prototype.GetWatermarkTop = function (rows)
{
    if (StoryboardContainer.Cols == 3)
    {
        var boxPosition = this.GetStoryboardContentBounds(1, 3);
        return boxPosition.Height + this.WatermarkPaddingTop;
    }

    return this.Row1PaddingTop + this.WatermarkPaddingTop + (2 * this.FullRowHeight()) - this.BetweenRowPadding;


}