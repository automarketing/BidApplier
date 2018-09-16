var WordRunRenderHelper = function ()
{
    var WordRunRenderHelperObject = new Object();

    //WordRunRenderHelperObject.PreRenderText = function ()
    //{
    //    var textableRectangle = $("#inner-rectangle-horizontal");

    //    var textAreaDimensions = GetTextArea(textableRectangle);
    //    RenderText(textAreaDimensions, $("#text-goes-here"));
    //};
    WordRunRenderHelperObject.OneLineOffset = 1.075; //pure dicking around to find this number - ABS 3/14/17

    WordRunRenderHelperObject.RenderText = function (deltas, textAreaDimensions, textGoesHere, flipHorizontal, flipVertical, angleDegrees)
    {
        if (deltas == null || deltas.length==0)
            return;

        //POP excess endlines!
        while (deltas.length > 2 && deltas[deltas.length - 1].insert == "\n")
            deltas.pop();

        //var textableRectangle = $("#inner-rectangle-horizontal");

        //var textAreaDimensions = GetTextArea(textableRectangle);

        var currentLine = "";
        var lineIndex = 0;
        var characterHeight = 0;
        var reverseAngleDegrees = -1 * angleDegrees; // This will reverse the roatation for the text only so we can get an accurate length measurement



        textGoesHere.children().remove();

        var startX = textAreaDimensions.Left;
        var startY = textAreaDimensions.Top;
        var maxX = textAreaDimensions.Width + startX;
        var totalTextboxHeight = textAreaDimensions.Height;

        var textBlock = CreateTextBlock(startX, maxX, startY, "", null, 0, false, reverseAngleDegrees);

        textGoesHere.append(textBlock);

        var wordRuns = WordRunHelper.GetWordRuns(deltas, textBlock);

        if (wordRuns == null || wordRuns.length == 0)
        {
            try
            {
                LogErrorMessage("RenderText.Wordruns are null...", { message: "Deltas: " + JSON.stringify(deltas), stack: "" });
            } catch (e)
            {
                LogErrorMessage("RenderText.Wordruns are null.On logging errors", e)

            }
            
        }

        var currentX = startX;
        var currentY = startY;
        var lineNumber = 1;

        var lineHeight = 1.1;

        textGoesHere.children().remove();

        var textBlocks = [];

        textBlock = CreateTextBlock(startX, maxX, startY, "", wordRuns, 0, flipHorizontal, reverseAngleDegrees);
        textGoesHere.append(textBlock);
        for (var i = 0; i < wordRuns.length; i++)
        {
            var wordRun = wordRuns[i];
            var textRuns = wordRun.TextRuns;
            if (wordRun == null)
            {
                try
                {
                    LogErrorMessage("Word run is null...", { message: "Deltas: " + JSON.stringify(deltas) + " word runs: " + JSON.stringify(wordRuns), stack:""});
                } catch (e)
                {
                    LogErrorMessage("Word run is null... Error on debug info", e)
                }
                
                continue;
            }
            if (wordRun.IsLineBreak)
            {
                
                lineNumber++;
                if (textBlock.clientHeight == 0)
                    currentY += 10;
                else
                    currentY += textBlock.clientHeight * lineHeight;
                currentX = startX;

                if (UseSummerNote && i==0)
                {
                    //do NOTHING!
                }
                else
                {
                    textBlocks.push(textBlock);
                    textBlock = CreateTextBlock(startX, maxX, currentY, "", wordRuns, i, flipHorizontal, reverseAngleDegrees);
                    textGoesHere.append(textBlock);
                }
                
                continue;
            }

            if (currentX != startX && currentX + wordRun.Width > maxX)
            {
                lineNumber++;
                currentY += textBlock.clientHeight * lineHeight;
                currentX = startX;

                textBlocks.push(textBlock);
                textBlock = CreateTextBlock(startX, maxX, currentY, "", wordRuns, i, flipHorizontal, reverseAngleDegrees);
                textGoesHere.append(textBlock);
            }

            if (wordRun.IsSpace && currentX == startX)
                continue;


            for (var j = 0; j < wordRun.TextRuns.length; j++)
            {
                var textRun = textRuns[j];

                textBlock.appendChild(textRun.Tspan);

                currentX += textRun.Width;
            }
        }
        textBlocks.push(textBlock);

        // 1) Calulatate total height of text
        // 2) Calculate new "top" to center stext
        // 3) move text boxes accordingly

     
        var totalTextHeight = 0;
        var lastLineHeight = 10;
        var totalLines = 0;

        var lineHeightMultiplier = .8; // in old code, we used fontsize /.75, this gives us a TINY bit more hieght

        for (var i = 0; i < textBlocks.length; i++)
        {
            //don't include trailing linebreaks in height'
            if (i === textBlocks.length - 1 && textBlocks[i].innerHTML === "")
                continue;

            if (textBlocks[i].innerHTML != "")
            {
                totalTextHeight += (textBlocks[i].getBoundingClientRect().height * lineHeightMultiplier);
                lastLineHeight = (textBlocks[i].getBoundingClientRect().height * lineHeightMultiplier);
                totalLines++;
            }
            else
            {
                totalTextHeight += lastLineHeight;
            }
        }

        

        var startTextBlocksY = startY;
        if (flipVertical)
        {
            startTextBlocksY = -1 * (textAreaDimensions.Top + (textAreaDimensions.Height*lineHeightMultiplier));
        }

        if (totalTextHeight < totalTextboxHeight)
        {
            startTextBlocksY += (totalTextboxHeight - totalTextHeight) / 2;
        }
        else if (totalLines === 1 && totalTextHeight * .7 < totalTextboxHeight)
        {
            totalTextHeight *= WordRunRenderHelper.OneLineOffset;  //use .9 since we are then going to divide by 2... so somehow that works to get there...
            startTextBlocksY += (totalTextboxHeight - totalTextHeight) / 2;
        }
        else
        {
            var textHeight = (textBlocks[0].getBoundingClientRect().height *lineHeightMultiplier);
            startTextBlocksY -= textHeight * .25;
        }


        lastLineHeight = 10;

        for (var i = 0; i < textBlocks.length; i++)
        {
            var textHeight = (textBlocks[i].getBoundingClientRect().height * lineHeightMultiplier);
            if (textHeight === 0)
                textHeight = lastLineHeight;
            else
                lastLineHeight = textHeight;

            startTextBlocksY += textHeight * .8;
            textBlocks[i].removeAttributeNS(null, "transform"); // Clear the "reverse rotation" transform on the text so that it properly aligns in the textbox
            textBlocks[i].setAttributeNS(null, "y", startTextBlocksY);
            startTextBlocksY += textHeight * .1;
        }


    };



    function GetTextArea(textableRectangle)
    {
        var dimensions = new Object();

        var x = Number(textableRectangle.attr("x"));
        var y = Number(textableRectangle.attr("y"));
        var width = Number(textableRectangle.attr("width"));
        var height = Number(textableRectangle.attr("height"));

        dimensions.Left = x;
        dimensions.Width = width;
        dimensions.Top = y
        dimensions.Height = height;

        return dimensions;
    }

    function CreateTextBlock(startX, maxX, y, id, wordRuns, currentIndex, flipHorizontal, rotateDegrees)
    {
        rotateDegrees = rotateDegrees || 0;
        var x = startX;
        var alignment = "";
        var textAlignStyle = "";

        if (UseSummerNote)
        {
            //quill stored line breaks at end, now we store them at start!
            if (wordRuns != null && wordRuns.length>0)
            {
                //check back first
                for (var i = currentIndex; i >=0; i--)
                {
                    if (wordRuns[i] == null)
                    {
                        try
                        {
                            LogErrorMessage("CreateTextBlock.Word run is null...", { message: "word runs: " + JSON.stringify(wordRuns), stack: "" });
                        } catch (e)
                        {
                            LogErrorMessage("CreateTextBlock.Word run is null... Error on debug info", e)
                        }
                        continue;
                    }
                    if (wordRuns[i].IsLineBreak)
                    {
                        alignment = wordRuns[i].Alignment;
                        break;
                    }
                }
                if (alignment === "")
                {
                    for (var i = currentIndex ; i < wordRuns.length; i++)
                    {
                        if (wordRuns[i] == null)
                        {
                            try
                            {
                                LogErrorMessage("CreateTextBlock.2.Word run is null...", { message: "word runs: " + JSON.stringify(wordRuns), stack: "" });
                            } catch (e)
                            {
                                LogErrorMessage("CreateTextBlock.2.Word run is null... Error on debug info", e)
                            }
                            continue;
                        }
                        if (wordRuns[i].IsLineBreak)
                        {
                            alignment = wordRuns[i].Alignment;
                            break;
                        }
                    }
                }
            }
        }

        if (UseQuill)
        {
            if (wordRuns != null)
            {
                for (var i = currentIndex + 1; i < wordRuns.length; i++)
                {
                    if (wordRuns[i].IsLineBreak)
                    {
                        alignment = wordRuns[i].Alignment;
                        break;
                    }
                }
            }
        }
        alignment = alignment === "" ? "center" : alignment;
        if (flipHorizontal)
        {
            if (alignment == "right")
            {
                x =-1* startX;
                textAlignStyle = "text-anchor: end;";
            }
            else if (alignment == "center")
            {
                x = -1* (startX + maxX) / 2;
                textAlignStyle = "text-anchor: middle;";
            }
            else
            {
                textAlignStyle = "text-anchor: start;";
                
                x = -1 * maxX;
            }
        }
        else
        {
            if (alignment == "right")
            {
                x = maxX;
                textAlignStyle = "text-anchor: end;";
            }
            else if (alignment == "center")
            {
                x = (startX + maxX) / 2;
                textAlignStyle = "text-anchor: middle;";
            }
            else
            {
                textAlignStyle = "text-anchor: start;";
                //   textAlignStyle = "text-anchor: start";
            }
        }
        



        var shape = document.createElementNS("http://www.w3.org/2000/svg", "text");
        shape.setAttributeNS(null, "x", x);
        shape.setAttributeNS(null, "y", y);
        
        shape.setAttributeNS(null, "style", textAlignStyle);
        shape.setAttributeNS(null, "transform", "rotate(" + rotateDegrees + ")");

        if (id != null && id != "")
            shape.setAttributeNS(null, "id", id);

        //shape.setAttribute("xml:space", "preserve");
        //shape.setAttributeNS("http://www.w3.org/2000/svg", "xml:space", "preserve");


        return shape;

    }


    return WordRunRenderHelperObject;

}();