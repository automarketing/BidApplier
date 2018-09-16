var UndoHelper = function ()
{
    var UndoHelperObject = new Object();

    UndoHelperObject.UndoBulkTextChange = function ()
    {
        try
        {
            for (var i = 0; i < arguments.length; i++)
            {
                var id = arguments[i].Id;
                var shapeState = MyShapesState.Public_GetShapeStateById(id);

                if (UseQuill || UseSummerNote)
                {
                    shapeState.TextState.Public_SetQuillDeltas(arguments[i].QuillDeltas);
                }
                else
                {
                    shapeState.SetText(arguments[i].Text);
                }

                //due to quill force update...
                shapeState.UpdateDrawing();
            }


        }
        catch (e)
        {
            LogErrorMessage("UndoHelper.UndoBulkTextChange", e);
        }
    };

    UndoHelperObject.UndoTitleEmphasis = function ()
    {
        try
        {
            for (var i = 0; i < arguments.length; i++)
            {
                var id = arguments[i].Id;
                var shapeState = MyShapesState.Public_GetShapeStateById(id);


                shapeState.Public_SetColorForRegion("Textables", arguments[i].BackgroundColor, false, false);

                if (UseQuill)
                {
                    shapeState.TextState.Public_QuillSetFontColor(arguments[i].FontColor);
                    shapeState.TextState.Public_QuillSetFontSize(arguments[i].FontSize);
                }
                else if (UseSummerNote)
                {
                    shapeState.TextState.Public_SummerNote_SetFontSizeAndColor(arguments[i].FontSize, arguments[i].FontColor);
                }
                else
                {

                    shapeState.TextState.FontColor = arguments[i].FontColor;
                    shapeState.TextState.FontSize = arguments[i].FontSize;
                }
                shapeState.UpdateDrawing();
            }


        }
        catch (e)
        {
            LogErrorMessage("UndoHelper.UndoBulkTextChange", e);
        }
    };

    return UndoHelperObject;
}();