/// <reference path="../svgManip.js" />

function CellSorter()
{
    this.Public_ShowCellSorterDialog = function ()
    {
        ClearActiveState();

        MyPointers.Dialog_ReorderCells_Grid.children().remove()

        MyPointers.Dialog_ReorderCells_Grid.css("width", (StoryboardContainer.Cols * 54) + "px");
        MyPointers.Dialog_ReorderCells_GridWrapper.css("width", ((StoryboardContainer.Cols * 54) + 6) + "px").css("height", ((StoryboardContainer.Rows * 54) + 6) + "px");

        var totalCells = StoryboardContainer.Cols * StoryboardContainer.Rows;
        for (var i = 0; i < totalCells; i++)
        {
            MyPointers.Dialog_ReorderCells_Grid.append("<li class=\"ui-state-default\" id=\"reorder_cell_" + (i + 1) + "\">" + (i + 1) + "</li>");
        }

        MyPointers.Dialog_ReorderCells.modal();
    };

    this.Public_RearrangeCells = function ()
    {
        var i = 0;
        //var grid = this.Private_BucketShapes();
        var redoList = [], undoList = [];

        // Assemble list of moves
        for (var row = 0; row < StoryboardContainer.Rows; row++)
        {
            for (var col = 0; col < StoryboardContainer.Cols; col++)
            {
                var cell = MyPointers.Dialog_ReorderCells_Grid.children()[i];
                var cellId = cell.getAttribute("id");
                cellId = cellId.replace("reorder_cell_", "");
                cellId -= 1; //cell id's are there "Friendly number 1,2,3 not 0,1,2
                var cellOldCol = cellId % StoryboardContainer.Cols;
                var cellOldRow = Math.floor(cellId / StoryboardContainer.Cols);

                // Track undo and redo information ('redo' is what we'll want to execute now, and then again if the operation should be undone)
                redoList.push({ 'oldCol': cellOldCol, 'oldRow': cellOldRow, 'newCol': col, 'newRow': row });
                undoList.push({ 'oldCol': col, 'oldRow': row, 'newCol': cellOldCol, 'newRow': cellOldRow });

                i++;
            }
        }

        // Register operation in UR stack
        UndoManager.register(undefined, UndoRearrangeCells, [undoList], '', undefined, UndoRearrangeCells, [redoList], '');

        // And apply
        this.Public_ApplyRearrangeCells(redoList);

        // Hide the dialog
        MyPointers.Dialog_ReorderCells.modal('hide');
    };

    /**
     * Applies a cell shift for a given array of moves (undo or redo array of all cell moves)
     */
    this.Public_ApplyRearrangeCells = function (reorderList)
    {
        var i = 0;

        StoryboardContainer.Public_ChangeCellOrder(reorderList);


        if (CellConfiguration.HasTitle || CellConfiguration.HasDescription)
        {
            var titleGrid = null;
            var descriptionGrid = null;

            if (CellConfiguration.HasTitle)
                titleGrid = this.Private_GetTextableGrid(MyIdGenerator.GenerateTitleCellId);

            if (CellConfiguration.HasDescription)
                descriptionGrid = this.Private_GetTextableGrid(MyIdGenerator.GenerateDescriptionCellId);

            for (i = 0; i < reorderList.length; i++)
            {
                var cellMove = reorderList[i];
                if (cellMove.newCol != cellMove.oldCol || cellMove.newRow != cellMove.oldRow)
                {
                    if (CellConfiguration.HasTitle)
                    {
                        var titleShapeState = MyShapesState.Public_GetShapeStateById(MyIdGenerator.GenerateTitleCellId(cellMove.newRow, cellMove.newCol));
                        this.Private_MoveUnmovableText(titleShapeState, titleGrid[cellMove.oldCol][cellMove.oldRow]);
                    }

                    if (CellConfiguration.HasDescription)
                    {
                        var descriptionShapeState = MyShapesState.Public_GetShapeStateById(MyIdGenerator.GenerateDescriptionCellId(cellMove.newRow, cellMove.newCol));
                        this.Private_MoveUnmovableText(descriptionShapeState, descriptionGrid[cellMove.oldCol][cellMove.oldRow]);
                    }
                }
            }
        }
    };

    this.Private_MoveUnmovableText = function (copyTo, copyFrom)
    {
        if (copyTo == null || copyFrom == null)
            return;

        copyTo.TextState.CopyFontStyles(copyFrom.TextStyles);
        copyTo.ColorableState.Public_CopyColorStyles(copyFrom.ColorStyles);
        copyTo.UpdateDrawing();

    };

    this.Public_CancelRearrangeCells = function ()
    {
        MyPointers.Dialog_ReorderCells.modal('hide');
    };

    this.Private_GetTextableGrid = function (titleFunction)
    {
        var grid = new Array();
        try
        {
            for (var col = 0; col < StoryboardContainer.Cols; col++)
            {
                grid[col] = new Array();
                for (var row = 0; row < StoryboardContainer.Rows; row++)
                {
                    var id = titleFunction(row, col);
                    var styles = new Object();
                    styles.TextStyles = MyShapesState.Public_GetShapeStateById(id).TextState.Public_GetFontStyles();
                    styles.ColorStyles = MyShapesState.Public_GetShapeStateById(id).ColorableState.Public_GetColorStyles();
                    grid[col][row] = styles;
                }
            }
        }
        catch (e)
        {
            //DebugLine("Private_GetTextableGrid" + e);
        }
        return grid;
    };


}