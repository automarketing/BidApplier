function TimelineLayout(enableTitle, enableDescription, scale, layoutConfig)
{
    BaseStoryboardLayout.call(this, enableTitle, enableDescription, scale, 12);

    this.LayoutType = StoryboardLayoutType.Timeline;

    this._ChartTitleStrokeWidth = 6;
    this._ChartGridStrokeWidth = 9;
    this._ChartOuterBoxWidth = 3;

    this._ChartLabelHeight = 55;

    this._ChartLabelPaddingTop = (2 * this._Padding - (this._CellStroke / 2)) + (this._ChartTitleStrokeWidth / 2);
    this._ChartLabelPaddingBottom = (2 * this._Padding - (this._CellStroke / 2)) + (this._ChartTitleStrokeWidth / 2) + (this._ChartGridStrokeWidth / 2);  // 6 stroke thickness on either side vs usual 3 

    this.CellPaddingLeft = 0;

    this.Row1PaddingTop = this._ChartLabelPaddingTop + this._ChartLabelPaddingBottom + this._ChartLabelHeight;

    this.Row1PaddingLeft = this._Padding - this._ChartOuterBoxWidth / 2;

    this._LegendPaddingTop = 30;
    this._LegendBoxHeight = 110;
    this.WatermarkPaddingTop = 30 + this._LegendBoxHeight + this._LegendPaddingTop;

    this._TimeLinePaddingMultiple = 16;
    this.BetweenRowPadding = this._Padding;

    //when transitioning between cell types we need update scale

    this.BetweenRowPadding *= scale;

    this.CellPaddingLeft *= scale;
    this.Row1PaddingTop *= scale;
    this.Row1PaddingLeft *= scale;

    this._ChartLabelHeight *= scale;
    this._ChartLabelPaddingTop *= scale;
    this._ChartLabelPaddingBottom *= scale;

    this.TimelineDates = layoutConfig.TimelineDates;

    this._TimeUnit = this._CalculateTimeUnit();

};

inheritPrototype(TimelineLayout, BaseStoryboardLayout);

//#region Sizing

//#region Cell Sizing
TimelineLayout.prototype._EnableTitleLayoutSpecific
{
    this.BetweenRowPadding = this._Padding;
};

TimelineLayout.prototype._EnableDescriptionLayoutSpecific
{
    this.BetweenRowPadding = this._Padding;
};

TimelineLayout.prototype._ExtraFullColumnWidth = function ()
{
    return (this._Padding * 1); // there is already a "natural" padding on left from this.CellPaddingLeft
};

TimelineLayout.prototype._ExtraFullRowHeight = function ()
{
    return (this._Padding * 1);// there is already a "natural" padding on top from this.TitlePaddingTop and this.CellPaddingTop
};

TimelineLayout.prototype._ExpandCellsLayoutSpecific = function (amount)
{
    this._ChartLabelHeight *= amount;
    this._ChartLabelPaddingTop *= amount;
    this._ChartLabelPaddingBottom *= amount;

    //this._Padding *= amount;
};

TimelineLayout.prototype.GetStoryboardAreaTitleLayout = function (row, col)
{
    return new TChartTitle("24");
};

TimelineLayout.prototype._AreaTitlePosition = function (row, col)
{
    if (row != 0 || col != 0)
        return null;

    var titleBoxLayout = this.GetStoryboardAreaTitleLayout(row, col);

    var extraStrokeWidth = titleBoxLayout.StrokeWidth - 3;
    var titleBoxWidth = this.CellWidth * 1.5;



    var x = this.Row1PaddingLeft + this.FullColumnWidth() + this._TimeLinePaddingMultiple * this._Padding - titleBoxWidth / 2;
    var y = this._ChartLabelPaddingTop;

    var boxPosition = new BoxPosition(this._ChartLabelHeight, titleBoxWidth, x, y, row, col, StoryboardPartTypeEnum.StoryboardAreaTitle);

    return boxPosition;

};

TimelineLayout.prototype._GetCellX = function (col)
{
    if (col % 2 == 0)
        return this.Row1PaddingLeft + this._Padding + this._ChartOuterBoxWidth;
    else
        return this.Row1PaddingLeft + this.FullColumnWidth() + (2 * this._TimeLinePaddingMultiple * this._Padding);
};

TimelineLayout.prototype._CellPosition = function (row, col)
{
    var x = this._GetCellX(col);
    var y = this.Row1PaddingTop + this.BeforeCellHeight() + this._GetGap(col, this._TimeUnit);

    var boxPosition = new BoxPosition(this.CellHeight, this.CellWidth, x, y, row, col, StoryboardPartTypeEnum.StoryboardCell);

    return boxPosition;
};

TimelineLayout.prototype._CellTitlePosition = function (row, col)
{
    var x = this._GetCellX(col);
    var y = this.Row1PaddingTop + this.TitlePaddingTop + this._GetGap(col, this._TimeUnit);

    var boxPosition = new BoxPosition(this.TitleHeight, this.CellWidth, x, y, row, col, StoryboardPartTypeEnum.StoryboardCellTitle);

    return boxPosition;
};

TimelineLayout.prototype._CellDescriptionPosition = function (row, col)
{

    var x = this._GetCellX(col);
    var y = this.Row1PaddingTop + this.BeforeDescriptionHeight() + this._GetGap(col, this._TimeUnit);

    var boxPosition = new BoxPosition(this.DescriptionHeight, this.CellWidth, x, y, row, col, StoryboardPartTypeEnum.StoryboardCellDescription);

    return boxPosition;
};

//#endregion

//#region storyboard Sizing

TimelineLayout.prototype._GetStoryboardSizePreAttribution = function (rows, cols)
{
    var boxPosition = this.GetStoryboardContentBounds(rows, cols);

    boxPosition.Height += this.WatermarkPaddingTop;

    return boxPosition;
};

TimelineLayout.prototype.GetStoryboardContentBounds = function (rows, cols)
{
    var boxPosition = new BoxPosition();

    boxPosition.X = 0;
    boxPosition.Y = 0;


    boxPosition.Height = this.Row1PaddingTop + this._GetGap(cols - 1, this._TimeUnit) + this.FullRowHeight();
    boxPosition.Width = 2 * this.FullColumnWidth() + 2 * this.Row1PaddingLeft + (2 * this._Padding * this._TimeLinePaddingMultiple);

    return boxPosition;
};

TimelineLayout.prototype.GetWatermarkTop = function (rows)
{
    var boxPosition = this.GetStoryboardContentBounds(StoryboardContainer.Rows, StoryboardContainer.Cols);

    var y = boxPosition.Height + this.WatermarkPaddingTop;

    return y;
}

//#endregion

//#endregion

//#region Timespan Math

TimelineLayout.prototype._CalculateTimeUnit = function ()
{
    var timeUnit = this.TimelineDates[2] - this.TimelineDates[0];
    var currentGaps = 10;
    for (var i = 2; i < this.TimelineDates.length; i++)
    {
        var tempTimeUnit = this.TimelineDates[i] - this.TimelineDates[i - 2];
        var gaps = 0;
        for (var col = 1; col < this.TimelineDates.length; col++)
        {
            if (this._TimeJump(col, tempTimeUnit))
                gaps++;
        }
        if (gaps == currentGaps)
        {
            // choose whichever one has a shorter length
            if (this._GetGap(this.TimelineDates.length - 1, tempTimeUnit) < this._GetGap(this.TimelineDates.length - 1, timeUnit))
                timeUnit = tempTimeUnit;
        }
        else if (gaps < currentGaps)
        {
            currentGaps = gaps;
            timeUnit = tempTimeUnit;
        }
    }
    if (timeUnit <= 0)
        return 1;
    return timeUnit;
};

TimelineLayout.prototype._TimeJump = function (col, timeUnit)
{
    var maxJump = 3;

    if (col == 0)
        return false;

    var delta = (this.TimelineDates[col] - this.TimelineDates[col - 1]) / timeUnit;
    if (col == 1)
    {
        return (delta > maxJump);
    }

    delta = (this.TimelineDates[col] - this.TimelineDates[col - 2]) / timeUnit;


    if (delta > maxJump || delta < 1)
        return true;

    return false;
};

TimelineLayout.prototype._GetGap = function (col, timeUnit)
{
    
    if (col == 0)
        return 0;

    var delta = (this.TimelineDates[col] - this.TimelineDates[col - 1]) / timeUnit;
    if (this._TimeJump(col, timeUnit))
        delta = 1.5;


    return delta * this.FullRowHeight() + this._GetGap(col - 1, timeUnit);

};

//#endregion

//#region grid lines / legend

TimelineLayout.prototype.GetLayoutLines = function (rows, cols)
{
    var dateFontStyleLeftColumn = "font-size:16pt;font-family:'Francois One';fill:#000000; text-anchor:end;";
    var dateFontStyleRightColumn = "font-size:16pt;font-family:'Francois One';fill:#000000; text-anchor:start;";

    var g = SvgCreator.CreateSvgGroup("timeline-grids");

    var timelineCenterX = this.Row1PaddingLeft + this.FullColumnWidth() + this._TimeLinePaddingMultiple * this._Padding;
    var y1 = this.Row1PaddingTop + 2.5;   //2.5 is to cover pixel stroke width!
    var y2 = this._GetGap(cols - 1, this._TimeUnit) + this.FullRowHeight() + y1 - this.BetweenRowPadding - 3.5;
    var stroke = "stroke:black; stroke-width:" + this._ChartGridStrokeWidth + "px; ";

    g.appendChild(SvgCreator.AddLine(timelineCenterX, y1, timelineCenterX, y2, stroke, "timeline-big-line"));
    g.appendChild(SvgCreator.AddLine(timelineCenterX - 2 * this._Padding, y1, timelineCenterX + 2 * this._Padding, y1, stroke, "timeline-big-line-top-cap"));
    g.appendChild(SvgCreator.AddLine(timelineCenterX - 2 * this._Padding, y2, timelineCenterX + 2 * this._Padding, y2, stroke, "timeline-big-line-bottom-cap"));

    for (var col = 0; col < cols; col++)
    {
        var boxPosition = this.GetCellPartPosition(StoryboardPartTypeEnum.StoryboardCellTitle, 0, col);
        if (this.HasTitle == false)
            boxPosition = this.GetCellPartPosition(StoryboardPartTypeEnum.StoryboardCell, 0, col);

        boxPosition.X -= this._Padding;
        boxPosition.Width += 2 * this._Padding;

        boxPosition.Y -= this._Padding;
        boxPosition.Height = this.FullRowHeight() - this.BetweenRowPadding;

        var anchorBox = this.GetAnchorPoints(boxPosition);

        var rect = SvgCreator.AddRect(boxPosition.X, boxPosition.Y, boxPosition.Width, boxPosition.Height, "black", "none", null, null, "outerbox_" + col);
        rect.setAttributeNS(null, "stroke-width", +this._ChartOuterBoxWidth + "px");
        g.appendChild(rect);

        if (col % 2 == 0)
        {
            var lineEdge = anchorBox.Right + ((this._TimeLinePaddingMultiple - 1) * this._Padding)

            g.appendChild(SvgCreator.AddLine(anchorBox.Right, anchorBox.MiddleY, lineEdge, anchorBox.MiddleY, "stroke:black; stroke-width:" + this._ChartOuterBoxWidth + "px", "timeline-connector-" + col));
            g.appendChild(SvgCreator.AddText(lineEdge - this._Padding, anchorBox.MiddleY - 5, this._FormatDate(this.TimelineDates[col]), dateFontStyleLeftColumn, "date-text-" + col));
            g.appendChild(SvgCreator.AddText(lineEdge - this._Padding, anchorBox.MiddleY + 22, this._FormatTime(this.TimelineDates[col]), dateFontStyleLeftColumn, "date-text-" + col));
        }
        else
        {
            var lineEdge = anchorBox.Left - ((this._TimeLinePaddingMultiple - 1) * this._Padding)

            g.appendChild(SvgCreator.AddLine(anchorBox.Left, anchorBox.MiddleY, lineEdge, anchorBox.MiddleY, "stroke:black; stroke-width:" + this._ChartOuterBoxWidth + "px", "timeline-connector-" + col));

            g.appendChild(SvgCreator.AddText(lineEdge + this._Padding, anchorBox.MiddleY - 5, this._FormatDate(this.TimelineDates[col]), dateFontStyleRightColumn, "date-text-" + col));
            g.appendChild(SvgCreator.AddText(lineEdge + this._Padding, anchorBox.MiddleY + 22, this._FormatTime(this.TimelineDates[col]), dateFontStyleRightColumn, "date-text-" + col));
        }

        if (this._TimeJump(col, this._TimeUnit))
        {
            var timeJumpX1 = timelineCenterX - 15;
            var timeJumpX2 = timelineCenterX + 15;
            var timeJumpY1 = anchorBox.Top - .25 * this.FullRowHeight() + 15;
            var timeJumpY2 = anchorBox.Top - .25 * this.FullRowHeight() - 15;

            g.appendChild(SvgCreator.AddLine(timeJumpX1, timeJumpY1, timeJumpX2, timeJumpY2, "stroke:black; stroke-width:" + this._ChartOuterBoxWidth + "px", "time-jump-a" + col));
            g.appendChild(SvgCreator.AddLine(timeJumpX1, timeJumpY1 + 10, timeJumpX2, timeJumpY2 + 10, "stroke:black; stroke-width:" + this._ChartOuterBoxWidth + "px", "time-jump-b" + col));
        }
    }

    g.appendChild(this._DrawLegend());


    return g;
};

TimelineLayout.prototype._DrawLegend = function ()
{
    var g = SvgCreator.CreateSvgGroup("timeline-legend");
    //return g;

    var storyboardSize = this.GetStoryboardContentBounds(StoryboardContainer.Rows, StoryboardContainer.Cols);
    var stroke = "stroke:black; stroke-width:1px; ";
    var fontStroke = "font-size:10pt;font-family:'roboto';fill:#000000; text-anchor:middle;";


    var boxTopY = storyboardSize.Y + storyboardSize.Height + this._LegendPaddingTop;
    var boxLeftX = this.Row1PaddingLeft;
    var boxWidth = this.FullRowHeight() + 2 * this._Padding;

    var legendY = boxTopY + 1.5 * this._Padding + 25;
    var legendLeftX = boxLeftX + this._Padding;
    var legendRightX = this.FullRowHeight() + legendLeftX;


    var rect = SvgCreator.AddRect(boxLeftX, boxTopY, boxWidth, this._LegendBoxHeight, "black", "white", null, null, "legend-box");
    rect.setAttributeNS(null, "stroke-width", "2px");

    g.appendChild(rect);
    g.appendChild(SvgCreator.AddText((boxLeftX + boxWidth) / 2, boxTopY + 20, MyLangMap.GetText("text-timeline-legend-Legend"), fontStroke.replace("10pt", "14pt"), "legend-text-legend"));

    g.appendChild(SvgCreator.AddLine(legendLeftX, legendY, legendRightX, legendY, stroke, "timeline-legend-width"));
    g.appendChild(SvgCreator.AddLine(legendLeftX, legendY - this._Padding / 2, legendLeftX, legendY + this._Padding / 2, stroke, "timeline-legend-left"));
    g.appendChild(SvgCreator.AddLine(legendRightX, legendY - this._Padding / 2, legendRightX, legendY + this._Padding / 2, stroke, "timeline-legend-right"));

    var breakY = legendY + 50;
    var slashUnit = 6;

    g.appendChild(SvgCreator.AddLine(legendLeftX, breakY + slashUnit, legendLeftX + slashUnit, breakY - slashUnit, stroke, "timeline-legend-slash1"));
    g.appendChild(SvgCreator.AddLine(legendLeftX + slashUnit, breakY + slashUnit, legendLeftX + 2 * slashUnit, breakY - slashUnit, stroke, "timeline-legend-slash2"));
    g.appendChild(SvgCreator.AddLine(legendLeftX, breakY, legendLeftX + 2 * slashUnit, breakY, stroke, "timeline-legend-slash3"));

    g.appendChild(SvgCreator.AddText(legendLeftX + 3 * slashUnit, breakY + slashUnit, MyLangMap.GetText("text-timeline-legend-Time-Break"), fontStroke.replace("middle", "start"), "legend-text"));


    var secondTicks = 1000;
    var minuteTicks = 60 * secondTicks;
    var hourTicks = 60 * minuteTicks;
    var dayTicks = 24 * hourTicks;
    var yearTicks = 365.25 * dayTicks;

    var timeSpan = this._TimeUnit;
    var legendText = "";

    var years = Math.floor(timeSpan / yearTicks);
    timeSpan -= years * yearTicks;

    var days = Math.floor(timeSpan / dayTicks);;
    timeSpan -= days * dayTicks;

    var hours = Math.floor(timeSpan / hourTicks);;
    timeSpan -= hours * hourTicks;

    var minutes = Math.floor(timeSpan / minuteTicks);;
    timeSpan -= minutes * minuteTicks;

    var seconds = Math.floor(timeSpan / secondTicks);;
    timeSpan -= seconds * secondTicks;

    if (years > 0)
    {
        legendText = MyLangMap.GetText("text-timeline-legend-years-and-days").replace("{years}", years).replace("{days}", days);
    }
    else if (days > 0)
    {
        legendText = MyLangMap.GetText("text-timeline-legend-days-and-hours").replace("{hours}", hours).replace("{days}", days);
    }
    else
    {
        legendText = MyLangMap.GetText("text-timeline-legend-hours-minutes").replace("{hours}", hours).replace("{minutes}", minutes);
    }

    g.appendChild(SvgCreator.AddText((legendLeftX + legendRightX) / 2, legendY + 20, legendText, fontStroke + " font-style:italic", "legend-text"));
    return g;
};

TimelineLayout.prototype._FormatTime = function (dateTime)
{
    var hours = dateTime.getHours();
    var minutes = dateTime.getMinutes();
    var seconds = dateTime.getSeconds();
    var formattedHour = hours <= 12 ? hours : hours % 12;

    if (hours == 0 && minutes == 0 && seconds == 0)
        return "";

    var formattedText = "";
    formattedText += formattedHour + ":";

    if (minutes < 10)
        formattedText += "0";

    formattedText += minutes;

    if (seconds > 0)
    {
        formattedText += ":";
        if (seconds < 10)
            formattedText += "0";
        formattedText += seconds;
    }

    if (hours >= 12)
        formattedText += " " + MyLangMap.GetText("text-timeline-legend-PM");
    else
        formattedText += " " + MyLangMap.GetText("text-timeline-legend-AM")

    return formattedText;
}

TimelineLayout.prototype._FormatDate = function (dateTime)
{
    //if (dateTime.getFullYear() > 0)
    //    return dateTime.toDateString()

    var years = Math.abs(dateTime.getFullYear());

    var suffix = " ";
    if (dateTime.getFullYear() < 0)
        suffix = " " + MyLangMap.GetText("text-timeline-legend-BCE")

    if (dateTime.getFullYear() < -1000 && (dateTime.getMonth() == 0 && dateTime.getDate() == 1))
    {
        return years.toLocaleString() + " " + MyLangMap.GetText("text-timeline-legend-BCE")
    }

    if ($("#timeline-use-day").is(':checked'))
        return dateTime.toDateString() + suffix;

    if ($("#timeline-use-month").is(':checked'))
    {
        try
        {
            var tempDate = new Date(dateTime.getTime());
            tempDate.setDate(2); // with day light savings some times reverts a month...  specifically april
            return tempDate.toLocaleDateString(window.navigator.language, { month: "long" }) + " " + years + suffix;
            
        }
        catch(ex)
        {

        }
    }
        
    if (suffix == " ")
        suffix = " " + MyLangMap.GetText("text-timeline-legend-CE")

    return years + suffix;
}

//#endregion

BaseStoryboardLayout.prototype.GetLayoutConfig = function ()
{
    var layoutConfig = new Object();
    layoutConfig.TimelineDates = this.TimelineDates;

    return layoutConfig;
};
