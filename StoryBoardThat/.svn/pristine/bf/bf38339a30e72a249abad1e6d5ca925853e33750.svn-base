var GestureHelper = function ()
{
    var GestureHelperObject = new Object();

    //#region "Emphasis (white text / black background)"
    GestureHelperObject.TitleEmphasis = function ()
    {
        if (CellConfiguration.HasTitle == false)
            return;

        var fontSize = parseInt($("#advanced-title-text-size").val());
        EmphasizeTextArea(MyIdGenerator.GenerateTitleCellId, fontSize);
    };

    GestureHelperObject.DescriptionEmphasis = function ()
    {
        if (CellConfiguration.HasDescription == false)
            return;

        var fontSize = parseInt($("#advanced-description-text-size").val());
        EmphasizeTextArea(MyIdGenerator.GenerateDescriptionCellId, fontSize);
    };

    function EmphasizeTextArea(idFunction, fontSize)
    {
        var undoArray = new Array();
        var redoArray = new Array();

        for (var col = 0; col < StoryboardContainer.Cols; col++)
        {
            for (var row = 0; row < StoryboardContainer.Rows; row++)
            {
                var shapeState = MyShapesState.Public_GetShapeStateById(idFunction(row, col));

                if (shapeState == null)
                    continue;

                undoArray.push(
                    {
                        Id: shapeState.Id,
                        FontColor: shapeState.TextState.FontColor,
                        FontSize: shapeState.TextState.FontSize,
                        BackgroundColor: shapeState.Public_GetColorForRegion("Textables")
                    });

                redoArray.push(
                    {
                        Id: shapeState.Id,
                        FontColor: "#FFFFFF",
                        FontSize: fontSize,
                        BackgroundColor: "#000000"
                    });


                //shapeState.TextState.Font = "'Francois One'";

                shapeState.Public_SetColorForRegion("Textables", "#000000", false, false);

                if (UseQuill)
                {
                    shapeState.TextState.Public_QuillSetFontColor("#FFFFFF");
                    shapeState.TextState.Public_QuillSetFontSize(fontSize);
                }
                else if (UseSummerNote)
                {
                    shapeState.TextState.Public_SummerNote_SetFontSizeAndColor(fontSize, "rgb(255,255,255)");
                }
                else
                {
                    shapeState.TextState.FontColor = "#FFFFFF";
                    shapeState.TextState.FontSize = fontSize;
                }
                shapeState.UpdateDrawing();
            }
        }

        UndoManager.register(undefined, UndoHelper.UndoTitleEmphasis, undoArray, '', undefined, UndoHelper.UndoTitleEmphasis, redoArray, '')

        CloseModal(MyPointers.Dialog_AdvancedButtons);
    };

    //#endregion

    GestureHelperObject.CapitalizeTitles = function ()
    {
        if (CellConfiguration.HasTitle == false)
            return;

        var undoArray = new Array();
        var redoArray = new Array();


        for (var col = 0; col < StoryboardContainer.Cols; col++)
        {
            for (var row = 0; row < StoryboardContainer.Rows; row++)
            {
                var shapeState = MyShapesState.Public_GetShapeStateById(MyIdGenerator.GenerateTitleCellId(row, col));

                if (shapeState == null)
                    continue;

                if (UseQuill || UseSummerNote)
                {
                    // Deep copy http://stackoverflow.com/a/122704/1560273
                    var quillDeltas = SbtLib.DeepCopy(shapeState.TextState.Public_GetQuillDeltas());

                    if (quillDeltas == null)
                        continue;

                    for (var i = 0; i < quillDeltas.length; i++)
                    {
                        if (quillDeltas[i] != null && quillDeltas[i].insert != null)
                            quillDeltas[i].insert = quillDeltas[i].insert.toUpperCase();
                    }
                    undoArray.push({ Id: shapeState.Id, QuillDeltas: shapeState.TextState.Public_GetQuillDeltas() });
                    redoArray.push({ Id: shapeState.Id, QuillDeltas: quillDeltas });

                    shapeState.TextState.Public_SetQuillDeltas(quillDeltas);
                }
               

                else
                {
                    var oldText = shapeState.GetText();
                    var newText = oldText.toUpperCase();
                    shapeState.SetText(newText);
                    //shapeState.TextState.Text = shapeState.TextState.Text.toUpperCase();

                    undoArray.push({ Id: shapeState.Id, Text: oldText });
                    redoArray.push({ Id: shapeState.Id, Text: newText });
                }

                //need to force it for quill... makes me nervous for future bugs / ABS 3-13-17
                shapeState.UpdateDrawing();
            }
        };


        UndoManager.register(undefined, UndoHelper.UndoBulkTextChange, undoArray, '', undefined, UndoHelper.UndoBulkTextChange, redoArray, '')


        CloseModal(MyPointers.Dialog_AdvancedButtons);
    };

    return GestureHelperObject;
}();