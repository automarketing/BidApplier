var CellPickerHelper = function ()
{
    var CellPickerHelperObject = new Object();
    
    var Props = new Object();
    
    Props.SelectedCell = null;
    Props.ActionType = "";
    Props.UndoCount = 0;
    Props.ActionMethod = null;
    
    Props.CopyActionType = "copy";
    Props.MoveActionType = "move";

    function ToggleMaxSize ()
    {
        //remove top controls
        $("#StoryboardCreatorWrapper").toggle();
        $(".Upgrade-Bar").toggleClass("hide-in-fullscreen");    // we don't want to turn on the ad bars when super tiny
        $("#bottom-toolbar-controls").toggle();
        $("#bottom-toolbar-advice").toggle();
        $("#tab-roller").toggle();

        

        $("#bt-copy-cell-undo").css("display", "none");

        StoryboardContainer.JiggleSvgSize();
        StoryboardContainer.SetCoreSvgDimensions();
    };

    function DrawOverlay ()
    {
        $("#cell-overlay-helper").remove();

        MyPointers.SvgContainer.css("position", "fixed");
        MyPointers.SvgContainer.append("<div id='cell-overlay-helper' class='cell-overlay-parent-div'></div>")

        var cellOverlayDiv = $("#cell-overlay-helper");
        
        var svgContainerHeight = parseFloat(MyPointers.SvgContainer.css("height"));
        var coreSvgHeight = MyPointers.CoreSvg.height() + 16;
        cellOverlayDiv.css("height", Math.max(svgContainerHeight,coreSvgHeight)+ "px");
        

        if ($(window).width() < MyPointers.CoreSvg.width())
        {
            cellOverlayDiv.css("width", MyPointers.CoreSvg.width() + 10 + "px");
        }

        var left = MyPointers.CoreSvg.position().left;
        var top = MyPointers.CoreSvg.position().top;

        var paddingTop = top + parseFloat(MyPointers.CoreSvg.css("margin-top")) + parseFloat(MyPointers.CoreSvg.css("padding-top")) + parseFloat(MyPointers.SvgContainer.scrollTop());
        var paddingLeft =left+ parseFloat(MyPointers.CoreSvg.css("margin-left")) + parseFloat(MyPointers.CoreSvg.css("padding-left")) + parseFloat(MyPointers.SvgContainer.scrollLeft());

        for (var col = 0; col < StoryboardContainer.Cols; col++)
        {
            for (var row = 0; row < StoryboardContainer.Rows; row++)
            {
                AddCellOverlay(cellOverlayDiv, paddingTop, paddingLeft, row, col, StoryboardPartTypeEnum.StoryboardCell);

                if (CellConfiguration.HasTitle)
                    AddCellPartOverlay(cellOverlayDiv, paddingTop, paddingLeft, row, col, StoryboardPartTypeEnum.StoryboardCellTitle);

                if (CellConfiguration.HasDescription)
                    AddCellPartOverlay(cellOverlayDiv, paddingTop, paddingLeft, row, col, StoryboardPartTypeEnum.StoryboardCellDescription);
            }
        }
    }

    function AddCellOverlay (cellOverlayDiv, paddingTop, paddingLeft, row, col, part)
    {
        var cell = $("#" + MyIdGenerator.GenerateCellId(row, col));
        if (cell.length == 0) { return; }

        var id = MyIdGenerator.GenerateCellOverlayId(row, col, part);
        cellOverlayDiv.append("<div id='" + id + "' class='cell-overlay-cell'></div>");

        var strokeWidth = parseFloat(cell.attr("stroke-width")) / 2;
        strokeWidth = isNaN(strokeWidth) ? 0 : strokeWidth;

        var cellOverlay = $("#" + id);

        var cellLeft = paddingLeft + strokeWidth + parseFloat(cell.attr("x"));
        var cellTop = paddingTop + strokeWidth + parseFloat(cell.attr("y"));

        cellOverlay.css("top", cellTop + "px");
        cellOverlay.css("left", cellLeft + "px");
        cellOverlay.css("height", cell.attr("height") + "px");
        cellOverlay.css("width", cell.attr("width") + "px");

        cellOverlay.click(OnCellSelected(row, col));
    }

    function AddCellPartOverlay (cellOverlayDiv,  paddingTop, paddingLeft, row, col, part)
    {
        var partPosition = CellConfiguration.GetCellPartPosition(part, row, col)
        if (partPosition.length == 0) { return; }

        var id = MyIdGenerator.GenerateCellOverlayId(row, col, part);
        cellOverlayDiv.append("<div id='" + id + "' class='cell-overlay-cell'></div>");

        var cellOverlay = $("#" + id);

        var cellLeft =  paddingLeft + partPosition.X;
        var cellTop = paddingTop + partPosition.Y;

        cellOverlay.css("top", cellTop + "px");
        cellOverlay.css("left", cellLeft + "px");
        cellOverlay.css("height", partPosition.Height + "px");
        cellOverlay.css("width", partPosition.Width + "px");

        cellOverlay.click(OnCellSelected(row, col));
    }


    function OnCellSelected (row, col)
    {
        //var props = Props;

        return function ()
        {
            if (Props.SelectedCell == null)
            {
                $("#" + MyIdGenerator.GenerateCellOverlayId(row, col, StoryboardPartTypeEnum.StoryboardCell)).addClass("cell-overlay-cell-selected");
                $("#" + MyIdGenerator.GenerateCellOverlayId(row, col, StoryboardPartTypeEnum.StoryboardCellDescription)).addClass("cell-overlay-cell-selected");
                $("#" + MyIdGenerator.GenerateCellOverlayId(row, col, StoryboardPartTypeEnum.StoryboardCellTitle)).addClass("cell-overlay-cell-selected");

                Props.SelectedCell = new Object({ Row: row, Col: col });
                UpdateHelpMessage(2);

            }
            else
            {
                console.log('here');
                $("#" + MyIdGenerator.GenerateCellOverlayId(Props.SelectedCell.Row, Props.SelectedCell.Col, StoryboardPartTypeEnum.StoryboardCell)).removeClass("cell-overlay-cell-selected");
                $("#" + MyIdGenerator.GenerateCellOverlayId(Props.SelectedCell.Row, Props.SelectedCell.Col, StoryboardPartTypeEnum.StoryboardCellDescription)).removeClass("cell-overlay-cell-selected");
                $("#" + MyIdGenerator.GenerateCellOverlayId(Props.SelectedCell.Row, Props.SelectedCell.Col, StoryboardPartTypeEnum.StoryboardCellTitle)).removeClass("cell-overlay-cell-selected");

                //unselect!
                if (Props.SelectedCell.Row == row && Props.SelectedCell.Col == col)
                    UpdateHelpMessage(1);
                else
                {
                    Props.ActionMethod(Props.SelectedCell.Row, Props.SelectedCell.Col, row, col)
                    UpdateHelpMessage(3);
                    
                }

                Props.SelectedCell = null;
                CellPickerHelper.UpdateIfNeeded();
            }
        };
    }

    function UpdateHelpMessage (step)
    {

        $("#bt-copy-part-1").css("display", "none");
        $("#bt-copy-part-2").css("display", "none");
        $("#bt-copy-part-3").css("display", "none");

        $("#bt-move-part-1").css("display", "none");
        $("#bt-move-part-2").css("display", "none");
        $("#bt-move-part-3").css("display", "none");


        $("#bt-" + Props.ActionType + "-part-" + step).css("display", "");

        if (step == 3)
        {
            $("#bt-copy-cell-undo").css("display", "");
            Props.UndoCount++;
        }

        
    }

    function PrepareCellPickerHelper ()
    {
        Props.UndoCount = 0;
        Props.SelectedCell = null;

        ClearActiveState();

        UpdateHelpMessage(1);

        ToggleMaxSize();

        

        DrawOverlay();
    };

    CellPickerHelperObject.UndoHelper = function ()
    {
        Undo();
        Props.UndoCount--;
        if (Props.UndoCount < 1)
        {
            $("#bt-copy-cell-undo").css("display", "none");
        }
    };

    CellPickerHelperObject.UpdateIfNeeded = function ()
    {
        if (Props.ActionType == "")
            return;
        if ($("#cell-overlay-helper").length == 0)
            return;

        DrawOverlay();

        if (Props.SelectedCell != null)
        {
            $("#" + MyIdGenerator.GenerateCellOverlayId(Props.SelectedCell.Row, Props.SelectedCell.Col, StoryboardPartTypeEnum.StoryboardCell)).addClass("cell-overlay-cell-selected");
            $("#" + MyIdGenerator.GenerateCellOverlayId(Props.SelectedCell.Row, Props.SelectedCell.Col, StoryboardPartTypeEnum.StoryboardCellDescription)).addClass("cell-overlay-cell-selected");
            $("#" + MyIdGenerator.GenerateCellOverlayId(Props.SelectedCell.Row, Props.SelectedCell.Col, StoryboardPartTypeEnum.StoryboardCellTitle)).addClass("cell-overlay-cell-selected");
        }

    };

    CellPickerHelperObject.StartCopyCell = function ()
    {
        Props.ActionType = Props.CopyActionType;
        Props.ActionMethod = CopyHelper.CopyCell;

        PrepareCellPickerHelper();
    };

    CellPickerHelperObject.StartMoveCell = function ()
    {
        Props.ActionType = Props.MoveActionType;
        //Props.ActionMethod = MoveCellHelper.MoveCell;
        Props.ActionMethod = MoveCellHelper.SwapCell;
        PrepareCellPickerHelper();
    };

 

    CellPickerHelperObject.Finish = function ()
    {
        MyPointers.SvgContainer.css("position", "fixed");


        $("#cell-overlay-helper").remove();

        ToggleMaxSize();

    };

    return CellPickerHelperObject;
}();
