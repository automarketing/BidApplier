function WordRun()
{
    this.TextRuns = [];
    this.Width = 0;
    this.Height = 0;

    this.IsSpace = false;
    this.IsLineBreak = false;
    this.Alignment = "left";
}

WordRun.prototype.AddTextRun = function (textRun)
{
    this.TextRuns.push(textRun);

    this.Width += textRun.Width;
    this.Height = Math.max(textRun.Height, this.Height);

};

var WordRunHelper = function ()
{
    var WordRunHelperObject = new Object();

    WordRunHelperObject.GetWordRuns = function (deltas, textBlock)
    {
        var wordRuns = [];
        var activeWord = null;

        for (var i = 0; i < deltas.length; i++)
        {
            var textStyle = GetTextStyle(deltas[i]);
            var text = deltas[i].insert;

            //can delete this line post quill retirement! abs 4/14/17
            if (deltas[i].insert.image !== undefined)
                continue;

            text = text.replaceAll2("\r\n", "\n");
            text = text.replaceAll2("\r", "\n");

            //http://stackoverflow.com/a/25221523/1560273
            var lines = text.split(/(\n)/g);
            for (var l = 0; l < lines.length; l++)
            {
                if (lines[l] === "")
                    continue;

                var words = lines[l].split(/( )/g);
                for (var w = 0; w < words.length; w++)
                {
                    if (words[w] === "")
                        continue;

                    if (words[w] === "\n")
                    {
                        if (activeWord != null)
                            wordRuns.push(activeWord);

                        activeWord = new WordRun();
                        activeWord.IsLineBreak = true;
                        activeWord.Alignment = textStyle.Alignment === "" || textStyle.Alignment === "left" ? activeWord.Alignment : textStyle.Alignment;
                        wordRuns.push(activeWord);

                        activeWord = null;
                    }

                    else if (words[w] === " ")
                    {
                        if (activeWord != null)
                            wordRuns.push(activeWord);

                        activeWord = new WordRun();

                        activeWord.IsSpace = true;

                        var textRun = GetTextRun(textStyle, textBlock, words[w]);
                        textRun.Width = GetSpaceWidth(textStyle, textBlock);
                        activeWord.AddTextRun(textRun);

                        wordRuns.push(activeWord);

                        activeWord = null;
                    }
                    else
                    {
                        if (activeWord === null)
                        {
                            activeWord = new WordRun();
                        }
                        var textRun = GetTextRun(textStyle, textBlock, words[w]);
                        activeWord.AddTextRun(textRun);
                    }

                }
            }
        }
        if (activeWord != null)
            wordRuns.push(activeWord);

        $(textBlock).children().remove();

        return wordRuns;
    };

    function GetSpaceWidth(textStyle, textBlock)
    {
        //calculate size of 'X X' and substract 'XX' - THIS IS NOT THE SAME AS 'X X' - 2* size of x! - ABS 4/19/17
        return GetTextRun(textStyle, textBlock, 'X X').Width - GetTextRun(textStyle, textBlock, 'XX').Width;
    }
    function GetTextRun(textStyle, textBlock, text)
    {
        var textRun = new Object();
        textRun.TextStyle = textStyle;
        textRun.Tspan = CreateTspan(text, textRun.TextStyle);

        textBlock.appendChild(textRun.Tspan);


        //oh shit values just in case!
        textRun.Width = text.length * 12;
        textRun.Height = 12

        try
        {
            // if (textRun.Tspan == null)
            //  {
            //      //console.log("null tspan" + new Date().getTime());
            //  }

            var boundingRectangle = textRun.Tspan.getClientRects()[0];
            if (boundingRectangle == null)
            {
                //console.log("Bounding rect is null" + text);
            }
            else
            {
                textRun.Width = boundingRectangle.width;
                textRun.Height = (boundingRectangle.height);
            }

        } catch (e)
        {
            LogErrorMessage("WordRun.GetTextRun: " + text, e);

        }

        $(textBlock).children().remove();

        return textRun;
    }

    function GetTextStyle(delta)
    {
        var textStyle = new Object();

        textStyle.Font = MyBrowserProperties.Public_GetDefaultFont();
        textStyle.Color = "Black";
        textStyle.Bold = false;
        textStyle.Italic = false;
        textStyle.Strike = false;
        textStyle.UnderLine = false;
        textStyle.FontSize = 10; //$(".ql-size.ql-picker").children().first().attr("data-value");
        textStyle.Alignment = "left";
        textStyle.Shift = "";

        try
        {
            if (delta.attributes == null)
                return textStyle;

            //textStyle.Bold = delta.attributes.bold == null ? false : true;
            //textStyle.Italic = delta.attributes.italic == null ? false : true;
            textStyle.Strike = delta.attributes.strike == null ? false : delta.attributes.strike;
            textStyle.UnderLine = delta.attributes.underline == null ? false : delta.attributes.underline;
            textStyle.Color = delta.attributes.color == null ? "black" : delta.attributes.color;
            textStyle.Alignment = delta.attributes.align;

            textStyle.Font = delta.attributes.font == null ? textStyle.Font : delta.attributes.font;
            textStyle.FontSize = delta.attributes.size == null ? textStyle.FontSize : delta.attributes.size;
            textStyle.Shift = delta.attributes.script == null ? textStyle.Shift : delta.attributes.script

            //delta.attributes.link;  If we ever wanted to suport URLs in storyboard text we could... I don't think we want to Abs 2/17/17
            textStyle.Font = textStyle.Font.replaceAll2("_", " ")
                .replaceAll2("\"", "")
                .replaceAll2("\'", "");


            if (textStyle.Font.indexOf(" ") >= 0)
                textStyle.Font = "\"" + textStyle.Font + "\"";

        } catch (e)
        {
            LogErrorMessage("WordRun.GetTextStyle:", e);
          

        }
        return textStyle;
    };

    function CreateTspan(text, textStyle)
    {
        var style = "";


        style += "font-family:" + textStyle.Font + ";";
        style += "fill: " + textStyle.Color + ";"
        //style += "text-anchor:" + textStyle.Alignment + ";"

        if (textStyle.Bold)
            style += "font-weight:bold;"

        if (textStyle.Italic)
            style += "font-style:italic;"

        if (textStyle.Shift == "sub")
        {
            style += "font-size:" + (textStyle.FontSize * .75) + "pt;";
            style += "baseline-shift: sub; "
        }
        else if (textStyle.Shift == "super")
        {
            style += "font-size:" + (textStyle.FontSize * .75) + "pt;";
            style += "baseline-shift: super; "
        }
        else
        {
            style += "font-size:" + textStyle.FontSize + "pt;";

        }

        if (textStyle.UnderLine)
        {
            if (textStyle.Strike)
                style += "text-decoration: underline, line-through;";
            else
                style += "text-decoration: underline;";
        }
        else if (textStyle.Strike)
            style += "text-decoration: line-through;";


        var shape = document.createElementNS("http://www.w3.org/2000/svg", "tspan");


        shape.setAttributeNS(null, "style", style);
        shape.setAttributeNS(null, "class", "DisableSelection");

        //shape.setAttributeNS("http://www.w3.org/2000/svg", "xml:space", "preserve");
        //$(shape).attr("xml:space", "preserve");
        var data = document.createTextNode(text);
        shape.appendChild(data);

        return shape;
    };

    return WordRunHelperObject;
}();

