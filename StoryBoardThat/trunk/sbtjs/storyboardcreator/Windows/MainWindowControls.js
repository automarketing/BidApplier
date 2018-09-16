var MainWindowControls = function ()
{

    function BottomControls_ClickHandlers()
    {
        try
        {
            $('#help-btn').click(ShowHelpDialog);
            //$('#help-print-btn').click(ShowHelpPrintDialog);
            $('#undo-btn').click(Undo);
            $('#redo-btn').click(Redo);
            
            
            $('#addcell-btn').click(ChangeLayoutDialog);
            

            

            $('#movecell-btn').click(CellPickerHelper.StartMoveCell);
            $('#copycell-btn').click(CellPickerHelper.StartCopyCell);
            $('#bt-copy-cell-done').click(CellPickerHelper.Finish);
            $("#bt-copy-cell-undo").click(CellPickerHelper.UndoHelper);

            //$('#change-layout-btn').click(ChangeLayoutDialog2);
            $('#change-storyboard-type-btn').click(ChangeStoryboardTypeDialog);

            $('#save-btn').click(function () { SaveHelper.SaveStoryboard(false, true, false); });
            $('#save-as-btn').click(function () { SaveHelper.SaveStoryboard(false, true, false); });

            $('#saveonly-btn').click(function () { SaveHelper.SaveStoryboard(true, true, true); });
            $('#savequit-btn').click(function () { SaveHelper.SaveStoryboard(false, true, true); });

            $("#save-choices-btn").click(function () { $("#SaveChoicesDialog").modal(); });

            //Advanced buttons
            $('#even-more-btn').click(ShowAdvancedButtons);
            $('#cell-size-btn').click(ShowChangeCellSize);
            $('#gridlines-btn').click(ToggleGridLines);
            $('#title-caps-btn').click(GestureHelper.CapitalizeTitles);
            $('#title-emphasis-btn').click(GestureHelper.TitleEmphasis);
            $('#description-emphasis-btn').click(GestureHelper.DescriptionEmphasis);
            $('#clear-btn').click(DeleteAll);

        }
        catch (e)
        {
            LogErrorMessage("MainWindowControls.BottomControls_ClickHandlers", e);
        }
    };

    function BottomControls_Setup()
    {
        try
        {
            // JIRA-WEB-33 - Make sure both Undo and Redo are disabled by default at the very beginning: there is obviously nothing to undo/redo then!
            $('#undo-btn').prop('disabled', true);
            $('#redo-btn').prop('disabled', true);

            //if ($("#IsEdit").val().toLowerCase() == "true")
            //{
            //    $("#saveAndContinueWrapper").show();
            //    $("#saveOnlyWrapper").hide();
            //} else
            //{
            //    $("#saveAndContinueWrapper").hide();
            //    $("#saveOnlyWrapper").show();
            //}

            // this is used for mini storyboard creator from edmodo
            if (ExtraSetup.EnableSaveButton == false)
            {
                // disable, and hide (not that someone couldn't hack this with Firebug, but...)
                $('#save-btn, #saveonly-btn, #savequit-btn').prop('disabled', true);
                $("#saveAndContinueWrapper").hide();
                $("#saveOnlyWrapper").hide();
            }
        }
        catch (e)
        {
            LogErrorMessage("MainWindowControls.BottomControls_ClickHandlers", e);
        }

    };


    var MainWindowsControlObject = new Object();

    MainWindowsControlObject.Init = function ()
    {
        BottomControls_ClickHandlers();
        BottomControls_Setup();

    };

    return MainWindowsControlObject;

}();