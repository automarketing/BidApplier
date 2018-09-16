/// <reference path="../svgManip.js" />

function MultiSelectState()
{
    this.StartX = undefined;
    this.StartY = undefined;

    this.Private_Left = undefined;
    this.Private_Right = undefined;
    this.Private_Top = undefined;
    this.Private_Bottom = undefined;

    this.SelectionAreaPartsEnum =
    {
        SelectionAreaRect:  "selection_area_rect",
    };

    this.Public_StartMultiSelect = function (e)
    {
        this.StartX = PageXtoStoryboardX(e.pageX);
        this.StartY = PageYtoStoryboardY(e.pageY);

        if (this.StartY < 0)
            this.StartY = 0;

        if (this.StartX < 0)
            this.StartX = 0;



        this.Private_Left = 0;
        this.Private_Right = 0;
        this.Private_Top = 0;
        this.Private_Bottom = 0;
    };

    this.Public_CompleteSelection = function ()
    { 
        var x = GetGlobalById(this.SelectionAreaPartsEnum.SelectionAreaRect);
        if( x )
            x.parentNode.removeChild(x);
    


        var allShapeStates = MyShapesState.Public_GetAllMovableShapeStates(true);
        for (var i = 0; i < allShapeStates.length; i++)
        {
            var shapeState = allShapeStates[i];

            // JIRA-WEB-28 - somehow, the method Public_GetAllShapeStates returns some invalid shapes (could not reproduce in dev), causing the following statement to fail. We need more information.
            var areaBox = null;
            try {
                areaBox = shapeState.Public_GetImaginaryOuterBox();
            } catch (e) {
                throw e + " - Object used: " + JSON.stringify(shapeState);
            }

            if (areaBox.Top >= this.Private_Top && areaBox.Bottom <= this.Private_Bottom)
            {
                if (areaBox.Left >= this.Private_Left && areaBox.Right <= this.Private_Right)
                {
                    MyShapesState.Public_SelectShape($("#" + shapeState.Id));
                }
            }
        }

        UpdateActiveDrawing();
    };

    this.Public_DrawSelectionArea = function (e)
    {
        var x = e.pageX - StoryboardContainer.CoreSvgLeft + MyPointers.SvgContainer.scrollLeft();
        var y = e.pageY - StoryboardContainer.CoreSvgTop + MyPointers.SvgContainer.scrollTop();

        this.Private_Left = Math.min(x, this.StartX);
        this.Private_Right = Math.max(x, this.StartX);

        this.Private_Top = Math.min(y, this.StartY);
        this.Private_Bottom = Math.max(y, this.StartY);
 
        var x = GetGlobalById(this.SelectionAreaPartsEnum.SelectionAreaRect);
        if( x )
            x.parentNode.removeChild(x);

        var selectionAreaRectangle = SvgCreator.AddRect(this.Private_Left, this.Private_Top, this.Private_Right - this.Private_Left, this.Private_Bottom - this.Private_Top, SbtConstants.SelectionAreaStrokeColor, SbtConstants.SelectionAreaFillColor, SbtConstants.SelectionAreaStrokeDash, SbtConstants.SelectionAreaOpacity, this.SelectionAreaPartsEnum.SelectionAreaRect);
        MyPointers.CoreSvg.append(selectionAreaRectangle);

    };
 
}