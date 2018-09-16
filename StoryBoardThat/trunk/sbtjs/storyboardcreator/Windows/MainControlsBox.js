﻿/// <reference path="../SvgManip.js" />
/// <reference path="TextControlsBox.js" />

function MainControlsBox()
{
    this.TextControls = new TextControlsBox();
    this.ColorUpdateControls = new ColorUpdaterBox();



    //#region "Privates"


    //#endregion
    this.HideControlsBox = function ()
    {
        this.Private_HideMultiControlsBox();
        this.Private_HideSingleControlsBox();
    };

    this.Private_HideSingleControlsBox = function ()
    {
        

        MyPointers.Controls_ShapeControls.css("display", "none");

        this.TextControls.HideTextControlsBox();
        this.ColorUpdateControls.HideUpdateColors();
    };

    this.Private_HideMultiControlsBox = function ()
    {
        MyPointers.Controls_MultiShapeControls.css("display", "none");
    };

    this.DrawMainControlsBox = function ()//x, y, width, height, widthOffset)
    {
        var selectedCount = MyShapesState.Property_SelectedCount();

        if (selectedCount === 0)
            return;

        if (selectedCount === 1)
        {
            this.Private_HideMultiControlsBox();
            this.Private_DrawSingleShapeControlsBox();
        }
        else
        {
            this.Private_HideSingleControlsBox();
            this.Private_DrawMultipleShapeControlsBox();
        }

    };

    this.Private_DrawMultipleShapeControlsBox = function ()
    {
        var areaBox = this.Private_CalculateMutlipleShapesArea();



        var x = areaBox.X;
        var y = areaBox.Y;
        var width = areaBox.Width;
        var height = areaBox.Height;

        var margin = 45;
        var maxWidth = MyPointers.Tabs.width() - margin;

        x += width + margin;
        var controlsWidth = MyPointers.Controls_MultiShapeControls.width();

        var rightMostControlX = x + controlsWidth;

        var coreSvgClientRect = document.getElementById("CoreSvg").getBoundingClientRect();
        var coreSvgWidth = (coreSvgClientRect.width - 2);


        if (rightMostControlX > (MyPointers.SvgContainer.width() + MyPointers.SvgContainer.scrollLeft())
            || (rightMostControlX > coreSvgWidth && rightMostControlX > MyPointers.SvgContainer.width()))
        {
            x = areaBox.X - margin - controlsWidth;
        }

        if (y < MyPointers.SvgContainer.scrollTop())
        {
            y = MyPointers.SvgContainer.scrollTop() + 10;
        }

        var controlsLeftStart = StoryboardXtoPageX(x);
        var controlsTopStart = StoryboardYtoPageY(y);
        //var controlsLeftStart = x + StoryboardContainer.SvgContainerPositionLeft - MyPointers.SvgContainer.scrollLeft();
        // var controls = $("#controlsBox");
        MyPointers.Controls_MultiShapeControls.css("display", "block");
        MyPointers.Controls_MultiShapeControls.css("left", controlsLeftStart);
        MyPointers.Controls_MultiShapeControls.css("top", controlsTopStart);

        // Last but not least, color filters should be hidden for Safari5 anyways...
        if (MyBrowserProperties.IsSafari5 || MyBrowserProperties.IsOldIE)
        {
            $("#multiSelectControlsBoxTable tr.colorfilterrow").hide();
        } else
        {

            // Otherwise, we're safe: show the color filters
            $("#multiSelectControlsBoxTable tr.colorfilterrow").show();

            var $dropdown = $('#multiSelectControlsBoxTable tr.colorfilterrow td.filter-dropdown-wrapper ul.dropdown-menu');

            // Control state of color filter icon, to indicate current state for the selected item.
            $dropdown.parent().find('button.btn.btn-label').html(MyLangMap.GetText("text-filter-select") + ' <span class="caret"></span>');

            // Add active class to selected item
            $dropdown.find('li').removeClass('active');

        }
    };

    this.Private_DrawSingleShapeControlsBox = function ()
    {
        var areaBox = this.Private_CalculateMutlipleShapesArea();

        

        var x = StoryboardXtoPageX(areaBox.X);
        var y = areaBox.Y; //StoryboardYtoPageY(areaBox.Y);
        var width = areaBox.Width;
        var height = areaBox.Height;

        var margin = 20;


        var shapeState = MyShapesState.Public_GetFirstSelectedShapeState();

        // leave room for rotation bar!
        if (shapeState.Angle % 180 >= 45 && shapeState.Angle % 180 <= 135)
        {
            margin += 25;
        }
        var textable = shapeState.IsTextable();
        var colorable = shapeState.Property_IsColorable();

        var posable = shapeState.Public_IsPosable();
        var smartScene = shapeState.Public_IsSmartScene();

        var controlsWidth = MyPointers.Controls_ShapeControls.width();
        var controlsHeight = MyPointers.Controls_ShapeControls.height();
        var movable = shapeState.Movable;

        if (shapeState.IsLocked == true)
        {
            $("#lockButton").css("display", "none");
            $("#unlockButton").css("display", "");
        }
        else
        {
            $("#lockButton").css("display", "");
            $("#unlockButton").css("display", "none");
            
        }
        if (colorable)
        {
            //y -= 80;
            controlsWidth = Math.max(MyPointers.Controls_UpdateColor.width(), controlsWidth);
            controlsHeight += 10 + MyPointers.Controls_UpdateColor.height()
        }

        if (textable)
        { 
                controlsWidth = Math.max(MyPointers.Controls_TextableControls.width(), controlsWidth, 375);
                controlsHeight += 10 + MyPointers.Controls_TextableControls.height()
           
        }

        x += width + margin;


        var windowLeftX = MyPointers.SvgContainer.scrollLeft();
        var windowRightX = MyPointers.SvgContainer.width() + MyPointers.SvgContainer.scrollLeft();

        // console.log(windowLeftX , windowRightX);

        var coreSvgClientRect = document.getElementById("CoreSvg").getBoundingClientRect();
        var coreSvgWidth = (coreSvgClientRect.width - 2);

        var rightMostControlX = x + controlsWidth + MyPointers.SvgContainer.scrollLeft();

        if (rightMostControlX > windowRightX
            || (rightMostControlX > coreSvgWidth && rightMostControlX > MyPointers.SvgContainer.width()))
        {
            x = StoryboardXtoPageX(areaBox.X) - margin - controlsWidth;
            if (x < windowLeftX)
                x = windowLeftX + 10;
        }

        if (movable == false)
        {
            controlsHeight -= (10 + MyPointers.Controls_ShapeControls.height());
        }
        var windowTop = MyPointers.SvgContainer.scrollTop();
        var windowBottom = MyPointers.SvgContainer.height() + MyPointers.SvgContainer.scrollTop();

        y = y - controlsHeight / 2;

        if (y < windowTop)
        {
            y = windowTop + 10;
        }

        if (y + controlsHeight > windowBottom)
        {
            y = Math.max(windowTop + 10, windowBottom - controlsHeight);
        }
        var controlsLeftStart = x;
        var controlsTopStart = StoryboardYtoPageY(y);

        // we don't show basic controls on title boxes
        // console.log(movable);
        if (movable)
        {
            MyPointers.Controls_ShapeControls.css("display", "block");
            MyPointers.Controls_ShapeControls.css("left", controlsLeftStart);
            MyPointers.Controls_ShapeControls.css("top", controlsTopStart);
        }
        // console.log(MyPointers.Controls_ShapeControls);

        var posableRow = $("#EditPoseRow");
        var editItemOptions = $("#EditItemOptionsRow");

        posableRow.hide();
        editItemOptions.hide();

        if (posable)
        {
            if (shapeState.Public_IsInstaPosable())
            {
                posableRow.show();
            }
            else
            {
                editItemOptions.show();
            }
        }
   
        var editSceneRow = $("#EditSceneRow");
        if (smartScene)
            editSceneRow.show();
        else
            editSceneRow.hide();

        var secondaryControlsTop = controlsTopStart;
        if (movable)
        {
            secondaryControlsTop += 10 + MyPointers.Controls_ShapeControls.height()
        }

        if (colorable)
        {
            this.ColorUpdateControls.Public_PrepColorControls(controlsLeftStart, secondaryControlsTop, shapeState);
        }

        if (textable)
        {
            if (colorable)
            {
                secondaryControlsTop += MyPointers.Controls_UpdateColor.height() + 10;
            }

            this.TextControls.PrepTextControls(MyPointers.Controls_TextableControls, controlsLeftStart, secondaryControlsTop, shapeState);
        }

        // Last but not least, color filters should be hidden for Safari5 anyways...
        if (MyBrowserProperties.IsSafari5 || MyBrowserProperties.IsOldIE)
        {
            $("#controlsBoxTable tr.colorfilterrow").hide();
            $("#single-select-filter-dropdown").hide();
        }


        /*
        if (shapeState.LockState === true) {
            $("#controlsBoxTable td.MenuLockItem").addClass('active');
        } else {
            $("#controlsBoxTable td.MenuLockItem").removeClass('active');
        }
        */
    };

    this.Private_CalculateMutlipleShapesArea = function ()
    {
        var left = undefined;
        var right = undefined;
        var top = undefined;
        var bottom = undefined;


        var selectedShapeStates = MyShapesState.Public_GetAllSelectedShapeStates();

        for (var i = 0; i < selectedShapeStates.length; i++)
        {
            boxArea = selectedShapeStates[i].Public_GetImaginaryOuterBox();
            if (left === undefined)
            {
                left = boxArea.Left;
                right = boxArea.Right;
                top = boxArea.Top;
                bottom = boxArea.Bottom;
            }

            left = Math.min(left, boxArea.Left);
            right = Math.max(right, boxArea.Right);
            top = Math.min(top, boxArea.Top);
            bottom = Math.max(bottom, boxArea.Bottom);

        }

        return { X: left, Y: top, Width: right - left, Height: bottom - top };

    };



}