var CopyHelper = function ()
{
    var CopyHelperObject = new Object();


    CopyHelperObject.CopyShape = function (e)
    {
        if (MyShapesState.Property_SelectedCount == 0)
        {
            return;
        }

        var selectedShapeStates = MyShapesState.Public_GetAllSelectedMovableShapeStates(false);
        ClearActiveState(); // don't call this before you call getselected!

        CopyShapeHelper(selectedShapeStates, 30, 30, true,false);
    };

    CopyHelperObject.CopyCell = function (sourceRow, sourceCol, destinationRow, destinationCol)
    {
        $("#CopyReplaceConfirm").show();
        $("#CopyReplaceConfirm").modal();
        $("#CopyReplaceConfirm_ReplaceBtn").click(function(e){
            CopyHelperObject.CopyCellAction(sourceRow, sourceCol, destinationRow, destinationCol , true);
            $("#CopyReplaceConfirm").hide();
        });
        $("#CopyReplaceConfirm_CopyBtn").click(function(e){
            CopyHelperObject.CopyCellAction(sourceRow, sourceCol, destinationRow, destinationCol , false)
            $("#CopyReplaceConfirm").hide();
        });
    };

    CopyHelperObject.CopyCellAction = function (sourceRow, sourceCol, destinationRow, destinationCol , isDelete)
    {

        var sourceCell = $("#" + MyIdGenerator.GenerateCellId(sourceRow, sourceCol));
        var destinationCell = $("#" + MyIdGenerator.GenerateCellId(destinationRow, destinationCol));

        var deltaX = parseFloat(destinationCell.attr("x")) - parseFloat(sourceCell.attr("x"));
        var deltaY = parseFloat(destinationCell.attr("y")) - parseFloat(sourceCell.attr("y"));


        var shapeStatesAndParts = StoryboardContainer.GetShapeStatesForCell(sourceRow, sourceCol);
        

        if( isDelete )
        {
            var DestState       = StoryboardContainer.GetShapeStatesForCell(destinationRow, destinationCol);
            var DestShapeStates = DestState[StoryboardPartTypeEnum.StoryboardCell];
            for (var i = 0; i < DestShapeStates.length; i++)
            {
                MyShapesState.Public_SelectShape($("#" + DestShapeStates[i].Id));
            }
            DeleteShape();
        }


        var toCopyShapes = new Array();
        toCopyShapes = shapeStatesAndParts[StoryboardPartTypeEnum.StoryboardCell].concat(shapeStatesAndParts[StoryboardPartTypeEnum.StoryboardCellTitle], shapeStatesAndParts[StoryboardPartTypeEnum.StoryboardCellDescription]);

        var cell_title_id           = null; 
        var cell_title_txt          = null;
        var cell_title_color        = null; 
        var cell_description_id     = null; 
        var cell_description_txt    = null;
        var cell_description_color  = null; 

        if (CellConfiguration.HasTitle || CellConfiguration.HasDescription)
        {
            if (CellConfiguration.HasTitle)
            {
                cell_title_id       = MyIdGenerator.GenerateTitleCellId(destinationRow, destinationCol);
                var copyTo          = MyShapesState.Public_GetShapeStateById(cell_title_id);
                cell_title_txt      = copyTo.TextState.Public_GetFontStyles();
                cell_title_color    = copyTo.ColorableState.Public_GetColorStyles();
                var copyFrom = MyShapesState.Public_GetShapeStateById(MyIdGenerator.GenerateTitleCellId(sourceRow, sourceCol));
                CopyUnmovableText(copyTo, copyFrom);
            }

            if (CellConfiguration.HasDescription)
            {
                cell_description_id     = MyIdGenerator.GenerateDescriptionCellId(destinationRow, destinationCol);
                var copyTo              = MyShapesState.Public_GetShapeStateById(cell_description_id);
                cell_description_txt    = copyTo.TextState.Public_GetFontStyles();
                cell_description_color  = copyTo.ColorableState.Public_GetColorStyles();
                var copyFrom = MyShapesState.Public_GetShapeStateById(MyIdGenerator.GenerateDescriptionCellId(sourceRow, sourceCol));
                CopyUnmovableText(copyTo, copyFrom);
            }
        }

        var cell_text = null;
        if(cell_title_id || cell_description_id) 
            cell_text = 
            { 
                cell_title_id           : cell_title_id , 
                cell_title_txt          : cell_title_txt , 
                cell_title_color        : cell_title_color , 
                cell_description_id     : cell_description_id , 
                cell_description_txt    : cell_description_txt,
                cell_description_color  : cell_description_color 
            };

        CopyShapeHelper(toCopyShapes, deltaX, deltaY, false,true , cell_text );

        ClearActiveState();
    }

    function CopyShapeHelper(selectedShapeStates, xOffset, yOffset, useSafetyMargins, copyLockState, cell_text )
    {
        try
        {
            var newShapes = new Array();


            selectedShapeStates.sort(Sorters.SortShapeStatesByIndex);

            for (var i = 0; i < selectedShapeStates.length; i++)
            {
                var active = selectedShapeStates[i];
                var id = active.Id + "_natural";
                var shape = $("#" + id).clone();

                StoryboardContainer.UpdateGradientIds(shape);

                var x = active.X + xOffset;  // this is correct because hte copy will have the same screwy offsets, possible some issues, but i think ok abs 8/13/13
                var y = active.Y + yOffset;

                if (useSafetyMargins)
                {
                    if (x + 50 > $("#CoreSvg").width())
                    {
                        x = active.X - xOffset;
                    }
                    if (y + 50 > $("#CoreSvg").height())
                    {
                        y = active.Y - yOffset;
                    }
                }

                var newShape = AddSvg.AddSvgToStoryboard(shape, x, y, false);
                newShapes.push(newShape);

                var newShapeState = MyShapesState.Public_GetShapeStateByShape(newShape);

                newShapeState.CopyShapeState(active);
                newShapeState.MoveTo(x, y);

                if (copyLockState)
                {
                    newShapeState.IsLocked = active.IsLocked;
                }
            }

            var undoArray = new Array();
            var redoArray = new Array();
            for (var j = 0; j < newShapes.length; j++)
            {
                var newShape = newShapes[j];
                var id = newShape.attr("id");

                undoArray.push({ Id: id });
                redoArray.push({ Id: id, Detached: newShape, NextShapeId: newShape.next().attr("id"), ShapeState: MyShapesState.Public_GetShapeStateById(id) });

                MyShapesState.Public_SelectShape(newShape);
            }

            if( cell_text )
                undoArray.push({ Id: null , content : cell_text });

            console.log(undoArray);

            MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Selected);
            // UndoManager.register(undefined, UndoShapeAdd, [{ Id: newShapeId }], undefined, '', UndoDeleteShape, [{ Detached: jq, NextShapeId: "SvgTop", Id: newShapeId, ShapeState: MyShapesState.Public_GetShapeStateById(newShapeId) }]);
            UndoManager.register(undefined, UndoShapeAdd, undoArray, undefined, '', UndoDeleteShape, redoArray, '');

            UpdateActiveDrawing();
        }
        catch (e)
        {
            LogErrorMessage("SvgManip.CopyShapeHelper", e);
        }
    }

    function CopyUnmovableText(copyTo, copyFrom)
    {
        if (copyTo == null || copyFrom == null)
            return;

        // if there is already non default text, don't copy it!
        if (copyTo.TextState.Text != "" && copyTo.TextState.Text != copyTo.TextState.DefaultText)
            return;

        // if there is no text, or just default text, don't copy it
        if (copyFrom.TextState.Text == "" || copyFrom.TextState.Text == copyFrom.TextState.DefaultText)
            return;

        //copies text and font
        copyTo.TextState.CopyFontStyles(copyFrom.TextState.Public_GetFontStyles());
        copyTo.ColorableState.Public_CopyColorStyles(copyFrom.ColorableState.Public_GetColorStyles());
        copyTo.UpdateDrawing();

    };

    return CopyHelperObject;
}();
