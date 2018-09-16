function ParallelLabelMatrixLayout(enableTitle, enableDescription, scale)
{
    MatrixLayout.call(this, enableTitle, enableDescription, scale, 12);

    var titleBoxLayout = this.GetStoryboardAreaTitleLayout();


    // Create "Col1Paddings" that move the ChartLabelHeight from the row1padding Y calculation to the X to account for the bottom-center reference point
    this.Col1PaddingTop = this.Row1PaddingTop - this._ChartLabelHeight + (this._Padding * 1.5); // 1 for the header, 0.5 for our cell
    this.Col1PaddingLeft = this._ChartLabelPaddingTop - (titleBoxLayout.StrokeWidth - 3);//(this._Padding - (this._CellStroke / 2)) +  (this._Padding + this._ChartTitleStrokeWidth);
    this.Row1PaddingLeft = this.Row1PaddingTop + this._Padding; // Both axis title row/col are small - this controls the grid as well

    // Since our base variables are already scaled, we do not need to do any further scaling here... but if we did, this is where we'd do it.

    this.LayoutType = StoryboardLayoutType.ParallelLabelMatrix;
};

inheritPrototype(ParallelLabelMatrixLayout, MatrixLayout);

ParallelLabelMatrixLayout.prototype._IsRowTitleCell = function (row, col) {
    return (col === -1 && row === -1) || (row > 0 && col === 0);
}

ParallelLabelMatrixLayout.prototype.GetStoryboardAreaTitleLayout = function (row, col) {
    var title = MatrixLayout.prototype.GetStoryboardAreaTitleLayout.call(this, row, col);

    // If we are the leftmost column, go sideways
    // NOTE: For all rows not 0, column number starts at 0; otherwise column starts at -1.
    if (this._IsRowTitleCell(row, col)) {
        title.Rotation = 270;
    }

    return title;

};

ParallelLabelMatrixLayout.prototype._AreaTitlePosition = function (row, col) {
    var boxPosition = MatrixLayout.prototype._AreaTitlePosition.call(this, row, col);

    if (this._IsRowTitleCell(row, col)) {
        var realCol = (col == -1) ? 0 : col;
        var realRow = (row == -1) ? 0 : row;

        var titleBoxLayout = this.GetStoryboardAreaTitleLayout();
        var extraStrokeWidth = titleBoxLayout.StrokeWidth - 3;

        var cellHeightPlusPadding = this.CellPaddingTop + this.CellHeight + this.BetweenRowPadding;
        // Because the SVG reference point is top left and our rotational reference point is center, we need to move the svg if its width changes to ensure the rotational reference point does not move.
        var cellSetRowHeightDelta = this.TitleHeight + ((this.TitleHeight > 0) ? this.CellPaddingTop : 0) + this.DescriptionPaddingTop + this.DescriptionHeight;
        var fullishRowHeight = this.CellHeight + cellSetRowHeightDelta;

        boxPosition.Width = fullishRowHeight - titleBoxLayout.StrokeWidth;
        boxPosition.X = this.Col1PaddingLeft - (cellHeightPlusPadding / 2) + this._ChartLabelHeight - (cellSetRowHeightDelta/2);
        boxPosition.Y = this.Col1PaddingTop + ((realRow) * this.FullRowHeight()) + (this.FullRowHeight() / 2);
        
    }
    return boxPosition;
};

ParallelLabelMatrixLayout.prototype._ExpandCellsLayoutSpecific = function (amount) {
    MatrixLayout.prototype._ExpandCellsLayoutSpecific.call(this, amount);

    this.Col1PaddingLeft *= amount;
    this.Col1PaddingTop *= amount;
}