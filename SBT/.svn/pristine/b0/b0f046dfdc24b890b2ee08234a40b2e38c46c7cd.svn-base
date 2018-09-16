var AlignHelper = function ()
{
    var AlignHelperObject = new Object();

    //#region "Align Types"
    AlignHelperObject.AlignLeft = function ()
    {
        var moveAlg = function (left, right, top, bottom, dimensions)
        {
            var move = new Object();
            move.X = left - dimensions.Left;
            move.Y = 0;

            return move;
        }

        AlignWorker(null, moveAlg);
    };

    AlignHelperObject.AlignRight = function ()
    {
        var moveAlg = function (left, right, top, bottom, dimensions)
        {
            var move = new Object();
            move.X = right - dimensions.Right;
            move.Y = 0;

            return move;
        }

        AlignWorker(null, moveAlg);
    }

    AlignHelperObject.AlignCenter = function ()
    {
        var moveAlg = function (left, right, top, bottom, dimensions)
        {
            var center = (left + right) / 2;
            var width = dimensions.Right - dimensions.Left;
            var desiredLeft = center - width / 2;

            var move = new Object();
            move.X = desiredLeft - dimensions.Left;
            move.Y = 0;

            return move;
        }

        AlignWorker(null, moveAlg);
    }

    AlignHelperObject.HorizontalDistribution = function ()
    {
        var moveAlg = function (left, right, top, bottom, dimensions, totalWidth, totalHeight, i, count, rollingRight)
        {
            if (i == 0 || i == count - 1)
                return new Object({ X: 0, Y: 0 });

            var gap = ((right - left)-(totalWidth)) / (count - 1);
            var desiredLeft =  gap + rollingRight;

            var move = new Object();
            move.X = desiredLeft - dimensions.Left;
            move.Y = 0; 

            return move;
        };

      
        //var sortAlg= function (a, b)
        //{
        //    return a.Property_VisibleX() == b.Property_VisibleX() ? 0 : +(a.Property_VisibleX() > b.Property_VisibleX()) || -1;
        //};

        AlignWorker(Sorters.SortShapesByVisibleX, moveAlg);
    }

    AlignHelperObject.AlignTop = function ()
    {
        var moveAlg = function (left, right, top, bottom, dimensions)
        {
            var move = new Object();
            move.X = 0;
            move.Y = top - dimensions.Top;;

            return move;
        }

        AlignWorker(null, moveAlg);
    }

    AlignHelperObject.AlignBottom = function ()
    {
        var moveAlg = function (left, right, top, bottom, dimensions)
        {
            var move = new Object();
            move.X = 0;
            move.Y = bottom - dimensions.Bottom;

            return move;
        }

        AlignWorker(null, moveAlg);
    }

    AlignHelperObject.AlignMiddle = function ()
    {
        var moveAlg = function (left, right, top, bottom, dimensions)
        {
            var center = (top + bottom) / 2;
            var height = dimensions.Bottom - dimensions.Top;
            var desiredTop = center - height / 2;

            var move = new Object();
            move.X = 0;
            move.Y = desiredTop - dimensions.Top;

            return move;
        }

        AlignWorker(null, moveAlg);
    }

    AlignHelperObject.VerticalDistribution = function ()
    {
        var moveAlg = function (left, right, top, bottom, dimensions, totalWidth, totalHeight, i, count, rollingRight, rollingBottom)
        {
            if (i == 0 || i == count - 1)
                return new Object({ X: 0, Y: 0 });

            var gap = ((bottom - top) - (totalHeight)) / (count - 1);
            var desiredTop = gap + rollingBottom;

            var move = new Object();
            move.X = 0;
            move.Y = desiredTop - dimensions.Top;
            
            return move;
        };

        ////http://stackoverflow.com/questions/1129216/sort-array-of-objects-by-string-property-value-in-javascript
        //var sortAlg = function (a, b)
        //{
        //    return a.Property_VisibleY() == b.Property_VisibleY() ? 0 : +(a.Property_VisibleY() > b.Property_VisibleY()) || -1;
        //};

        AlignWorker(Sorters.SortShapesByVisibleY, moveAlg);
    }
    //#endregion


    function AlignWorker(sortAlg, moveAlg)
    {
        try
        {
            
            var selectedShapesStates = MyShapesState.Public_GetAllSelectedMovableShapeStates(true);

            if (selectedShapesStates.length === 0)
                return;

            selectedShapesStates = selectedShapesStates.filter(
                function (shapeState)
                {
                    return shapeState.Movable;
                });

            if (selectedShapesStates.length === 0)
                return;

            var undoArray = new Array();
            var redoArray = new Array();

            if (sortAlg != null)
            {
                selectedShapesStates = selectedShapesStates.sort(sortAlg);
            }

            var shapeDimensions = new Object();
            var left;
            var right;
            var top;
            var bottom;
            var totalWidth = 0;
            var totalHeight = 0;

            for (var i = 0; i < selectedShapesStates.length; i++)
            {
                var shapeState = selectedShapesStates[i];
                shapeDimensions[shapeState.Id] = shapeState.Public_GetImaginaryOuterBox();
                if (i == 0)
                {
                    left = shapeDimensions[shapeState.Id].Left;
                    right = shapeDimensions[shapeState.Id].Right;
                    top = shapeDimensions[shapeState.Id].Top;
                    bottom = shapeDimensions[shapeState.Id].Bottom;
                }

                left = Math.min(left, shapeDimensions[shapeState.Id].Left);
                right = Math.max(right, shapeDimensions[shapeState.Id].Right);
                top = Math.min(top, shapeDimensions[shapeState.Id].Top);
                bottom = Math.max(bottom, shapeDimensions[shapeState.Id].Bottom);

                totalWidth += shapeDimensions[shapeState.Id].Right - shapeDimensions[shapeState.Id].Left;
                totalHeight += shapeDimensions[shapeState.Id].Bottom - shapeDimensions[shapeState.Id].Top;
            }

            left = Math.max(left, 0);
            top = Math.max(top, 0);

            right = Math.min(StoryboardContainer.CoreSvgRight - StoryboardContainer.CoreSvgLeft, right);
            bottom = Math.min(StoryboardContainer.CoreSvgBottom - StoryboardContainer.CoreSvgTop, bottom);

            //rolling right/bottom needed for distribution of items
            var rollingRight = 0;
            var rollingBottom = 0;

            for (var i = 0; i < selectedShapesStates.length; i++)
            {
                var move = moveAlg(left, right, top, bottom, shapeDimensions[selectedShapesStates[i].Id], totalWidth, totalHeight, i, selectedShapesStates.length, rollingRight, rollingBottom);

                rollingRight = shapeDimensions[selectedShapesStates[i].Id].Right + move.X;
                rollingBottom = shapeDimensions[selectedShapesStates[i].Id].Bottom + move.Y;

                undoArray.push({ Id: selectedShapesStates[i].Id, X: move.X * -1, Y: move.Y * -1 });
                redoArray.push({ Id: selectedShapesStates[i].Id, X: move.X, Y: move.Y });

                selectedShapesStates[i].MoveDistance(move.X, move.Y);
            }

            UndoManager.register(undefined, UndoShapeMoveArray, undoArray, '', undefined, UndoShapeMoveArray, redoArray, '');
            UpdateActiveDrawing();
        }
        catch (e)
        {
            LogErrorMessage("SvgManip.AlignLeft", e);
        }
    }

    return AlignHelperObject;
}();