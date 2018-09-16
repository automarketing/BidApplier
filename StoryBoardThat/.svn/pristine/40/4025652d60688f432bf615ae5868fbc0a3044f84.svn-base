var SbtQuillHelper = function ()
{
    var SbtQuillHelperObject = new Object();

    SbtQuillHelperObject.ResetToDefaults = function ()
    {
        var defaultFont = MyBrowserProperties.Public_GetDefaultFont().replaceAll2("'", "").replaceAll2(" ", "_");

        //center first
        //quill.format('align', 'center');
        quill.formatLine(0, 2, 'align', 'center');   // center aligns the first line
        //quill.format('align', 'center');

        //then other chagnes - order MATTERS - ABS 3/10/17
        quill.format('font', defaultFont);

        //just in case Handle White Text not also called
        $(".ql-editor").css("background-color", "");
    };

    SbtQuillHelperObject.JamText = function (text)
    {
        var selection = quill.getSelection();
        var index = selection == null ? quill.getLength() - 1 : selection.index

        quill.insertText(index, text);
        quill.setSelection(index + text.length);
    };

    SbtQuillHelperObject.HandleWhiteText = function ()
    {
        //return;
        var hasWhite = false;
        var ops = quill.getContents().ops;
        for (var i = 0; i < ops.length; i++)
        {
            if (ops[i].attributes != null && ops[i].attributes.color != null)
            {
                if (ops[i].attributes.color === "#ffffff")
                    hasWhite = true;
            }
        }

        if (hasWhite)
        
            $(".ql-editor").css("background-color", "#555555");
        
        else
            $(".ql-editor").css("background-color", "");
    };

    return SbtQuillHelperObject;

}();