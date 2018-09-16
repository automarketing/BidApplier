var MoveCellHelper = function ()
{
    var MoveCellHelperObject = new Object();

    MoveCellHelperObject.MoveCell = function (oldRow, oldCol, newRow, newCol)
    {
        var redoList = [];
        var undoList = [];

        for (var row = 0; row < StoryboardContainer.Rows; row++)
        {
            for (var col = 0; col < StoryboardContainer.Cols; col++)
            {
                var cellNumber = CalculateCellNumber(row, col, oldRow, oldCol, newRow, newCol);

                var cellOldCol = cellNumber % StoryboardContainer.Cols;
                var cellOldRow = Math.floor(cellNumber / StoryboardContainer.Cols);

                undoList.push({ 'oldCol': cellOldCol, 'oldRow': cellOldRow, 'newCol': col, 'newRow': row });
                redoList.push({ 'oldCol': col, 'oldRow': row, 'newCol': cellOldCol, 'newRow': cellOldRow });

            }
        }

        // Register operation in UR stack
        UndoManager.register(undefined, MoveCellHelper.UndoRearrangeCells, [undoList], '', undefined, MoveCellHelper.UndoRearrangeCells, [redoList], '');

        // And apply
        MoveCellHelper.RearrangeCells(redoList);
    };

    MoveCellHelperObject.SwapCell = function (oldRow, oldCol, newRow, newCol)
    {
        var redoList = [];
        var undoList = [];


        undoList.push({ 'oldCol': oldCol, 'oldRow': oldRow, 'newCol': newCol, 'newRow': newRow });
        undoList.push({ 'oldCol': newCol, 'oldRow': newRow, 'newCol': oldCol, 'newRow': oldRow });

        redoList.push({ 'oldCol': newCol, 'oldRow': newRow, 'newCol': oldCol, 'newRow': oldRow });
        redoList.push({ 'oldCol': oldCol, 'oldRow': oldRow, 'newCol': newCol, 'newRow': newRow });
        

        // Register operation in UR stack
        UndoManager.register(undefined, MoveCellHelper.UndoRearrangeCells, [undoList], '', undefined, MoveCellHelper.UndoRearrangeCells, [redoList], '');

        // And apply
        MoveCellHelper.RearrangeCells(redoList);
    };


    MoveCellHelperObject.RearrangeCells = function (reorderList)
    {
        var i = 0;

        StoryboardContainer.Public_ChangeCellOrder(reorderList);


        if (CellConfiguration.HasTitle || CellConfiguration.HasDescription)
        {
            var titleGrid = null;
            var descriptionGrid = null;

            if (CellConfiguration.HasTitle)
                titleGrid = GetTextableGrid(MyIdGenerator.GenerateTitleCellId);

            if (CellConfiguration.HasDescription)
                descriptionGrid = GetTextableGrid(MyIdGenerator.GenerateDescriptionCellId);

            for (i = 0; i < reorderList.length; i++)
            {
                var cellMove = reorderList[i];
                if (cellMove.newCol != cellMove.oldCol || cellMove.newRow != cellMove.oldRow)
                {
                    if (CellConfiguration.HasTitle)
                    {
                        var titleShapeState = MyShapesState.Public_GetShapeStateById(MyIdGenerator.GenerateTitleCellId(cellMove.newRow, cellMove.newCol));
                        MoveUnmovableText(titleShapeState, titleGrid[cellMove.oldCol][cellMove.oldRow]);
                    }

                    if (CellConfiguration.HasDescription)
                    {
                        var descriptionShapeState = MyShapesState.Public_GetShapeStateById(MyIdGenerator.GenerateDescriptionCellId(cellMove.newRow, cellMove.newCol));
                        MoveUnmovableText(descriptionShapeState, descriptionGrid[cellMove.oldCol][cellMove.oldRow]);
                    }
                }
            }
        }
    };

    MoveCellHelperObject.UndoRearrangeCells = function (data)
    {
        try
        {
            MoveCellHelper.RearrangeCells(data);
            UpdateActiveDrawing();
        }
        catch (e)
        {
            LogErrorMessage("SvgManip.UndoRearrangeCells", e);
        }
    };


    //#region "Privates"


    function CalculateCellNumber  (row, col, oldRow, oldCol, newRow, newCol)
    {
        var cellNumber = (row * StoryboardContainer.Cols) + col;

        var toMoveCellNumber = (oldRow * StoryboardContainer.Cols) + oldCol;
        var moveToCellNumber = (newRow * StoryboardContainer.Cols) + newCol;

        if (toMoveCellNumber == cellNumber)
            return moveToCellNumber;

        if (toMoveCellNumber < moveToCellNumber)
        {
            if (cellNumber < toMoveCellNumber)
                return cellNumber;

            if (cellNumber > moveToCellNumber)
                return cellNumber;

            return cellNumber - 1;
        }

        if (cellNumber < moveToCellNumber)
            return cellNumber;

        if (cellNumber > toMoveCellNumber)
            return cellNumber;

        return cellNumber + 1;
    }


    function GetTextableGrid (titleFunction)
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

    function MoveUnmovableText(copyTo, copyFrom)
    {
        if (copyTo == null || copyFrom == null)
            return;

        //copies text and font
        copyTo.TextState.CopyFontStyles(copyFrom.TextStyles);
        copyTo.ColorableState.Public_CopyColorStyles(copyFrom.ColorStyles);
        copyTo.UpdateDrawing();

    };


    //#endregion
    return MoveCellHelperObject;
}();