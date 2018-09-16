var SbtSummerNoteHelper = function ()
{
    var SbtSummerNoteHelperObject = new Object();

    var DefaultFont = "";
    var DefaultSize = 10;
    var DefaultDeltas = null;

    var UsePAlign = false;
    var SummerNoteInitialized = false;
    SbtSummerNoteHelperObject.InitSummerNoteIfNeeded = function ()
    {
        if (SummerNoteInitialized === true)
            return false;

        SummerNoteInitialized = true;
        InitSummerNote();



        SbtSummerNoteHelper.ResetToDefaults();

        return true;
    };



    SbtSummerNoteHelperObject.ResetToDefaults = function ()
    {
       // var t0 = performance.now();
        try 
        {
            if (SummerNoteInitialized === false)
            {
                InitSummerNote();
                SummerNoteInitialized = true;
            }
        }
        catch (e)
        {
            LogErrorMessage("SbtSummerNoteHelperObject.ResetToDefaults.a", e);

        }

        try 
        {
            //seeing if this clears up next set of error in summernote!
            ClearSelections();

            DefaultFont = MyBrowserProperties.Public_GetDefaultFont().replaceAll2("_", " "); //.replaceAll2("'", "")
            $(".note-editable.panel-body").css("font-family", DefaultFont);

          
            if ($('.note-current-fontname').text() != DefaultFont.replaceAll2("\'", ""))
                $('#summernote-editor').summernote('fontName', DefaultFont);

          
            var deltas = [];

            var deltaParagraph = new Object();
            deltaParagraph.insert = "\n";
            deltaParagraph.attributes = new Object();
            deltaParagraph.attributes.align = "center";


            var deltaText = new Object();
            deltaText.insert = "&#65279;";//no size blank space - so the entity exists!
            deltaText.attributes = GetDefaultStyleObject();

            deltas.push(deltaParagraph);
            deltas.push(deltaText);


            SbtSummerNoteHelper.UpdateForDeltas(deltas);

            if ($('.note-current-fontname').text() != DefaultFont.replaceAll2("\'", ""))
                $('#summernote-editor').summernote('fontName', DefaultFont);

            //much faster code... but introduce any bugs??
            if ($('.note-current-fontsize').text() != DefaultSize)
                $('#summernote-editor').summernote('fontSize', DefaultSize);
            DefaultDeltas = SbtSummerNoteHelper.GetDeltas();
        }
        catch (e)
        {
            LogErrorMessage("SbtSummerNoteHelperObject.ResetToDefaults.b", e);

        }


       // var t1 = performance.now();
//console.log("\t Reset Defaults.b " + (t1 - t0) + " milliseconds.");


        //change init order to have this not called so often
    };



    SbtSummerNoteHelperObject.JamText = function (key)
    {
        try
        {
            var activeStyle = $('#summernote-editor').summernote('currentStyle');
            var insertSpan = document.createElement("span");
            insertSpan.textContent = key;
            $(insertSpan).css("font-family", activeStyle["font-family"]);
            $(insertSpan).css("font-size", activeStyle["font-size"] + "pt");
            try
            {
                //PURE SHOT IN THE DARK! abs 4/23/17
                $(insertSpan).css("color", $(activeStyle.ancestors[1]).css("color"))
                $(insertSpan).css("text-decoration", $(activeStyle.ancestors[1]).css("text-decoration"))
            } catch (e)
            {
                LogErrorMessage(" SbtSummerNoteHelperObject.JamText - Sneaky styles", e);
            }
            //TODO add rest of properties (subscript/superscript)... it is late and this code is behind schedule, and not sure how popular this feature is - ABS 4/23/17
            $('#summernote-editor').summernote('insertNode', insertSpan)
        } catch (e)
        {
            LogErrorMessage(" SbtSummerNoteHelperObject.JamText", e);

        }
    };

    SbtSummerNoteHelperObject.Deltas_UpdateFontSizeAndColor = function (deltas, size, color)
    {

        if (deltas == null)
            return deltas;

        for (var i = 0; i < deltas.length; i++)
        {
            if (deltas[i]["attributes"] != null)
            {
                deltas[i].attributes.size = size;
                deltas[i].attributes.color = color;
            }
        }

        return deltas;

    };

    SbtSummerNoteHelperObject.GenerateQuillForOneLiner = function (text, fontSize, textAlignment, font, fontColor)
    {
        if (textAlignment == "middle")
            textAlignment = "center";

        var deltas = [];

        var deltaParagraph = new Object();
        deltaParagraph.insert = "\n";
        deltaParagraph.attributes = new Object();
        deltaParagraph.attributes.align = textAlignment;

        var deltaText = new Object();
        deltaText.insert = text;
        deltaText.attributes = GetDefaultStyleObject();
        deltaText.attributes.size = fontSize;
        deltaText.attributes.font = font;
        deltaText.attributes.align = textAlignment;
        deltaText.attributes.color = fontColor;

        deltas.push(deltaParagraph);
        deltas.push(deltaText);

        return deltas;
    };

    SbtSummerNoteHelperObject.GetDefaultFont = function ()
    {
        return MyBrowserProperties.Public_GetDefaultFont().replaceAll2("_", " ");
    };

    SbtSummerNoteHelperObject.HandleWhiteText = function ()
    {
        //return;
        var hasWhite = false;
        var ops = SbtSummerNoteHelper.GetDeltas();
        if (ops === null)
        {
            $(".note-editable").css("background-color", "");
            return;
        }

        for (var i = 0; i < ops.length; i++)
        {
            if (ops[i].attributes != null && ops[i].attributes.color != null)
            {
                var color = ops[i].attributes.color.replaceAll2(" ", "").toLowerCase();
                if (color === "#ffffff" || color.indexOf("rgb(255,255,255)") >= 0)
                    hasWhite = true;
            }
        }

        if (hasWhite)

            $(".note-editable").css("background-color", "#555555");

        else
            $(".note-editable").css("background-color", "");
    };


    SbtSummerNoteHelperObject.Paste = function ()
    {
        // Props.NeedsSanitization = true;
    };

    SbtSummerNoteHelperObject.IsDefault = function ()
    {
        if (DefaultDeltas == null)
            return false;

        var deltas = SbtSummerNoteHelper.GetDeltas();
        return SbtLib.DeepCompareEquality(deltas, DefaultDeltas);
    };

    SbtSummerNoteHelperObject.GetDeltas = function ()
    {

        var rawCode = $('#summernote-editor').summernote('code');


        if (rawCode === "")
            return null;

        rawCode = rawCode.replaceAll2('<div', '<p').replaceAll2('</div', '</p');

        var deltas = SbtSummerNoteHelper.GetSummerNoteDeltas(rawCode);

        if (deltas == null)
        {
            LogErrorMessage("SbtSummerNoteHelper.GetDeltas: Deltas null ");
        }

        return deltas;
    };

    SbtSummerNoteHelperObject.OnChange = function (we, contents, $editable)
    {
        var shapeState = MyShapesState.Public_GetFirstSelectedShapeState();
        if (shapeState == null)
            return;

        var oldQuill = shapeState.TextState.Public_GetQuillDeltas();


        var deltas = SbtSummerNoteHelper.GetDeltas();
        if (deltas == null)
            return;

        if (SbtLib.DeepCompareEquality(deltas, oldQuill))
            return;

        var rawCode = $('#summernote-editor').summernote('code');


        // if we need to sanitize, no need to re-render svg
        if (SanitizeIfNeeded(rawCode, deltas))
            return;



        //        var range = $('#summernote-editor').summernote('saveRange');

        // NO IDEA how this doesn't create a loop... ABS 4/23/17'
        UndoManager.register(undefined, SbtSummerNoteHelper.UndoTextChange, [shapeState.Id, oldQuill], '',
            undefined, SbtSummerNoteHelper.UndoTextChange, [shapeState.Id, deltas], '')


        shapeState.TextState.Public_SetQuillDeltas(deltas);
        shapeState.SetText(SbtSummerNoteHelper.GetText(deltas));

        if (deltas == null)
        {
            LogErrorMessage("SbtSummerNoteHelper.OnChange: Deltas null ");
        }

        UpdateActiveDrawing();
    };

    SbtSummerNoteHelperObject.UndoTextChange = function (id, deltas)
    {
        try
        {
            var shapeState = MyShapesState.Public_GetShapeStateById(id);

            if (shapeState == null)
            {
                LogErrorMessage("SvgManip.UndoTextChangeSummerNote - ShapeState is Null - ID: " + id);
                return;
            }

            shapeState.TextState.Public_SetQuillDeltas(deltas);
            shapeState.SetText(SbtSummerNoteHelper.GetText(deltas));

            SbtSummerNoteHelper.UpdateForDeltas(deltas);
            shapeState.UpdateDrawing();

            if (deltas == null)
            {
                LogErrorMessage("SbtSummerNoteHelper.UndoTextChange: Deltas null ");
            }


        }
        catch (e)
        {
            LogErrorMessage("SvgManip.UndoTextChangeQuill", e);
        }
    }

    SbtSummerNoteHelperObject.GetText = function (deltas)
    {
        var text = ""
        if (deltas == null)
            return text;

        for (var i = 0; i < deltas.length; i++)
        {
            text += deltas[i].insert;
        }
        return text;
    };

    SbtSummerNoteHelperObject.UpdateForHtml = function (html)
    {
        $('#summernote-editor').summernote('code', html);
    }

    SbtSummerNoteHelperObject.UpdateForDeltas = function (deltas)
    {
        if (deltas == null)
        {
            SbtSummerNoteHelper.ResetToDefaults();
        }
        else
            $('#summernote-editor').summernote('code', SummerDeltasToHtml(deltas));

    }

    function SanitizeIfNeeded(rawCode, deltas)
    {
        try
        {
            //return false;

            if (NeedsHtmlSanitization(rawCode) || NeedsWhiteListSanitization(deltas))
            {
                $('#summernote-editor').summernote('code', SummerDeltasToHtml(deltas));
                return true;
            }
        } catch (e)
        {
            LogErrorMessage("SbtSummerNoteHelper.SanitizeIfNeeded", e);

        }
        return false;

    }


    SbtSummerNoteHelperObject.GetSummerNoteDeltas = function (rawCode)
    {
        var summerNoteTextParseArea = $("#summernote-text-parse");
        //$("#delta-output").empty();

        summerNoteTextParseArea.empty();

        summerNoteTextParseArea.append(rawCode);

        var deltas = [];
        DeltasForNode(summerNoteTextParseArea, null, deltas);

        try
        {
            var deltaLength = deltas.length;
            if (deltaLength > 2)
            {
                //this means we have an empty last delta!  this is a side effect of resettodefault... maybe better code could avoid half this code... feels like a CS2 HW assignment with 5x the code to fix the bugs caused by the bug fixes... ABS 4/24/17
                if (deltas[deltaLength - 1].insert[0].charCodeAt() === 65279 && SbtLib.DeepCompareEquality(deltas[deltaLength - 1]["attributes"], deltas[deltaLength - 2]["attributes"]))
                {
                    deltas.pop();
                }
            }
        } catch (e)
        {
            LogErrorMessage("SbtSummerNoteHelperObject.GetSummerNoteDeltas", e);
        }

        summerNoteTextParseArea.empty();

        return deltas;
    }

    //check for unsupported HTML
    function NeedsHtmlSanitization(rawCode)
    {

        var rejectionTags = ['<a', '<script', '<img', '<i>', '<b>', '<ul', '<table', '<p class=', '<span class='];
        for (var i = 0; i < rejectionTags.length; i++)
        {
            if (rawCode.indexOf(rejectionTags[i]) >= 0)
                return true;
        }

        return false;
    }

    //check for non supported fonts/sizes
    function NeedsWhiteListSanitization(deltas)
    {
        if (deltas[0] != null && deltas[0]["attributes"] != null)
        {
            if (deltas[0].attributes.font.toLowerCase().indexOf("open sans") >= 0)
                return false;
        }
        for (var i = 0; i < deltas.length; i++)
        {
            if (CompareFonts(deltas[i].attributes.font, SbtSummerNoteHelper.SanitizeFont(deltas[i].attributes.font)) == false)
                return true;

        }

        return false;
    }

    function DeltasForNode(node, textStyle, deltas)
    {
        node = $(node);

        // create delta
        if (node[0].nodeName === "#text")
        {
            var delta = new Object();
            delta.insert = node.text();
            delta.attributes = textStyle;

            deltas.push(delta);
        }
        else if (node[0].nodeName === "#comment")
        {

        }
        //track style
        else
        {
            var textStyle = GetTextStyles(node, textStyle);
            if (node[0].nodeName.toLowerCase() === "p")
            {
                var delta = new Object();
                delta.insert = "\n";
                delta.attributes = textStyle;

                deltas.push(delta);
            }
        }


        var children = $(node).contents();
        for (var i = 0; i < children.length; i++)
        {
            DeltasForNode(children[i], textStyle, deltas);
        }
    }

    function GetDefaultStyleObject()
    {
        var style = new Object();

        style.font = DefaultFont
        style.size = DefaultSize;
        style.color = "rgb(0,0,0)";

        style.bold = false;
        style.italic = false;
        style.strike = false;
        style.underline = false;

        style.align = "center";
        style.script = "";

        return style;
    }

    SbtSummerNoteHelperObject.UpdateUsePAlign = function (usePAlign)
    {
        UsePAlign = usePAlign;
    }

    function GetTextStyles(node, textStyle)
    {

        var style = GetDefaultStyleObject();
        if (textStyle != null)
        {
            style.script = textStyle.script;
            style.underline = textStyle.underline;
            style.strike = textStyle.strike;
            style.font = textStyle.font;
        }

        try
        {
            if (node.context.nodeName.toLowerCase() === "sub")
                style.script = "sub";

            if (node.context.nodeName.toLowerCase() === "sup")
                style.script = "super";

            var fontSizeMultiple = 1;
            if (style.script != "")
                fontSizeMultiple = 1.333;

            var cssFont = $(node).css("font-family");
            style.font = cssFont || style.font || DefaultFont;//first non null font


            style.font = style.font == null ? DefaultFont : style.font;
            style.font = SbtSummerNoteHelper.SanitizeFont(style.font);
            var cssFontSize = $(node).css("font-size");
            style.size = cssFontSize == null ? style.size : (parseFloat(cssFontSize) * fontSizeMultiple * 72.0 / 96.0).toFixed(0)
            style.size = style.size.replace("pt", "").replace("px", "");



            style.color = $(node).css("color");

            style.underline = style.underline ? true : $(node).css("text-decoration").toLowerCase().indexOf("underline") >= 0;
            style.strike = style.strike ? true : $(node).css("text-decoration").toLowerCase().indexOf("line-through") >= 0;

            style.align = $(node).css("text-align");
            //if (style.align === "start")
            //    style.align = "left";

            if ($(node).attr("align") != null && $(node).attr("align") != "" && $(node).attr("align") != style.align)
            {
                SbtSummerNoteHelper.UpdateUsePAlign(true);
                style.align = $(node).attr("align");
            }


            //if (style.align === "start")
            //    style.align = "left";
            //   style.script = $(node).css("vertical-align") === "baseline" ? "" : $(node).css("vertical-align");

        }
        catch (e)
        {
            LogErrorMessage("SbtSummerNoteHelper.GetTextStyles", e);

        }
        return style;
    }

    function SummerDeltasToHtml(deltas)
    {
        var toHtml = "";
        var openParagraph = false;
        if (deltas == null)
            return "";

        if (deltas[0].insert !== "\n")
        {
            if (UsePAlign)
                toHtml += "<p align=\"center\">";
            else
                toHtml += "<p style=\"text-align:center;\">";
        }

        for (var i = 0; i < deltas.length; i++)
        {
            var delta = deltas[i];
            if (delta.insert === "\n")
            {
                if (openParagraph)
                    toHtml += "</p>";

                var align = "center";
                if (delta["attributes"] != null)
                    align = delta.attributes.align;

                openParagraph = true;
                var pAlign = align === "start" ? "left" : align;

                if (UsePAlign)
                    toHtml += "<p align=\"" + pAlign + "\">";
                else
                    toHtml += "<p style=\"text-align:" + align + ";\">";
                //toHtml += "<p align=\"" + align + "\>";
            }
            else
            {
                var style = "";
                var font = GetAttributeOrDefault(delta.attributes, "font", DefaultFont).replaceAll2("\"", "\'").replaceAll2("_", " ");
                font = SbtSummerNoteHelper.SanitizeFont(font);

                style += "font-family:" + font + ";";

                style += "color:" + GetAttributeOrDefault(delta.attributes, "color", "black") + ";";

                var underline = GetAttributeOrDefault(delta.attributes, "underline", false);
                var strike = GetAttributeOrDefault(delta.attributes, "strike", false);
                var script = GetAttributeOrDefault(delta.attributes, "script", "");
                script = script === "super" ? "sup" : script;

                var fontSize = GetAttributeOrDefault(delta.attributes, "size", DefaultSize);
                //if (script)
                //    fontSize = (fontSize * .666).toFixed(0);

                style += "font-size:" + fontSize + "pt;";

                if (underline)
                    style += "text-decoration:underline;"

                if (strike)
                    style += "text-decoration:line-through;"

                var preTags = "";
                var postTags = "";

                if (script != "")
                {
                    preTags = "<" + script + ">";
                    postTags = "</" + script + ">";
                }
                toHtml += "<span style=\"" + style + "\">" + preTags + delta.insert.replaceAll2("\r", " ").replaceAll2("\n", "") + postTags + "</span>";
            }
        }

        if (openParagraph)
            toHtml += "</p>";


        return toHtml;
    }

    SbtSummerNoteHelperObject.SanitizeFont = function (font)
    {
        try
        {
            var defaultFont = SbtSummerNoteHelper.GetDefaultFont().replaceAll2("\"", "\'").replaceAll2("_", " ");

            if (font == null)
                return defaultFont;

            for (var i = 0; i < SummerNoteSettings.FontNames.length; i++)
            {
                if (CompareFonts(font, SummerNoteSettings.FontNames[i].Family))
                {
                    // console.log("Accepted font: " + font)
                    return SummerNoteSettings.FontNames[i].Family.replaceAll2("\"", "\'").replaceAll2("_", " ");;
                }
            }
        } catch (e)
        {
            LogErrorMessage("SbtSummerNoteHelperObject.SanitizeFont", e);

        }

        // console.log("Rejected font: " + font)
        return defaultFont;
    };

    function CompareFonts(font1, font2)
    {
        font1 = font1.replaceAll2("\"", "")
            .replaceAll2("\'", "")
            .toLowerCase();

        font2 = font2.replaceAll2("\"", "")
            .replaceAll2("\'", "")
            .toLowerCase();

        return (font1 === font2)
    }
    function GetAttributeOrDefault(obj, property, defaultValue)
    {
        if (obj == null || obj[property] == null)
            return defaultValue;

        return obj[property];
    };


    return SbtSummerNoteHelperObject;
}();