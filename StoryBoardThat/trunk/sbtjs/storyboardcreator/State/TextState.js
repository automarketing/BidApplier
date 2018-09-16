﻿/// <reference path="../svgManip.js" />
function TextState(id)
{
    this.Text = "";
    this.DefaultText = "";

    //this.Font = "nobile regular";
    this.Font = MyBrowserProperties.Public_GetDefaultFont();
    this.FontSize = "10";
    this.FontColor = "000000";
    this.TextAlignment = "middle";

    this.Textable = false;
    this.TextOffsetLeft = 0;
    this.TextOffsetRight = 0;
    this.TextOffsetTop = 0;

    this.Private_IdTextableRectangle = "";
    this.Private_ShapeId = id
    this.Private_RevertColor = "";

    this.RemovalId = null;

    this._QuillDeltas = null;



    //I HATE THIS IS JUST HANGING OUT!!!
    this.Private_CheckForMetaData(id);

}

TextState.prototype.Public_ClearDefaults = function ()
{
    if (this.Text != this.DefaultText)
        return false;

    if (UseSummerNote)
    {
        SbtSummerNoteHelper.ResetToDefaults();
        this.Public_SetQuillDeltas(SbtSummerNoteHelper.GetDeltas());

    }
    //if (UseQuill || UseSummerNote)
    //{
    //    this.Public_SetQuillDeltas(null, true);
    //}
    
    this.Text = "";

    return true;

};



TextState.prototype.Public_GetSavedFontColor = function ()
{
    if (this.Private_RevertColor != "")
        return this.Private_RevertColor;

    return this.FontColor;
};

TextState.prototype.Public_ResetFontColor = function ()
{
    if (this.Private_RevertColor != null && this.Private_RevertColor != "")
    {
        this.FontColor = this.Private_RevertColor;
    }
};

TextState.prototype.Public_SetFontColor = function (color, isPreview)
{
    if (this.Private_RevertColor === "")
    {
        this.Private_RevertColor = this.FontColor;
    }

    if (isPreview === false)
    {
        this.Private_RevertColor = color;
    }

    this.FontColor = color;
};

TextState.prototype.Public_GetTextArea = function (bbox, scaleX, scaleY, offsetX, offsetY, isSpringable)//, flipX, flipY)
{
    var dimensions = new Object();

    if (this.Private_IdTextableRectangle != null && this.Private_IdTextableRectangle.length > 0)
    {
        var textableRectangle = $("#" + this.Private_IdTextableRectangle);
        var x = Number(textableRectangle.attr("x"));
        var y = Number(textableRectangle.attr("y"));
        var width = Number(textableRectangle.attr("width"));
        var height = Number(textableRectangle.attr("height"));


        dimensions.Left = (x - offsetX) * scaleX;
        dimensions.Width = width * scaleX;
        dimensions.Top = (y - offsetY) * scaleY;
        dimensions.Height = height * scaleY;

        if (isSpringable)
        {
            //extra complex for ie10/11 :( abs 6/22/16
            var textRect = GetGlobalById(this.Private_IdTextableRectangle);
            var parentId = $(textRect).parent().attr("id")

            var transform = SvgCreator.GetTransform(parentId);

            dimensions.Width *= transform.Scale[0];
//            dimensions.Left *= transform.Scale[0];

            dimensions.Height *= transform.Scale[1];
  //          dimensions.Top *= transform.Scale[1];

        }

        //if (flipX)
        //    dimensions.Left *= -1;

        //if (flipY)
        //    dimensions.Top *= -1;
    }
    else
    {
        var width = bbox.width;
        var height = bbox.height;

        dimensions.Left = width * this.TextOffsetLeft;

        dimensions.Top = (height * this.TextOffsetTop);
        dimensions.Width = (width * this.TextOffsetRight) - dimensions.Left;
        dimensions.Height = Infinity;
    }



    return dimensions;
};

TextState.prototype.Public_GenerateQuillForOneLiner = function (text, fontSize, textAlignment, font, fontColor)
{
    this.Public_SetQuillDeltas(SbtSummerNoteHelper.GenerateQuillForOneLiner(text, fontSize, textAlignment, font, fontColor));
};

TextState.prototype.Public_ConvertToQuill = function ()
{
    //"", right, center
    var alignment = "";
    if (this.TextAlignment == "middle")
        alignment = "center";
    else if (this.TextAlignment == "end")
        alignment = "right";

    var color = this.FontColor === "" ? "black" : this.FontColor;

    if (UseSummerNote)
    {
        try
        {

            //var t0 = performance.now();

       
        alignment = alignment == "" ? "left" : alignment;
        SbtSummerNoteHelper.ResetToDefaults();
        
        var pTag = "<p style=\"text-align:" + alignment + "; color:" + color + ";font-family: " + this.Font.replaceAll2("\"", "\'") + "; font-size:" + this.FontSize + "pt;\">";


        var toParseText = this.Text
            .replaceAll2("\n\n\n", "\n\n")
            .replaceAll2("\n", "</p>" + pTag);

        toParseText = pTag + toParseText + "</p>";

      

        SbtSummerNoteHelper.UpdateForHtml(toParseText);

     
        this.Public_SetQuillDeltas(SbtSummerNoteHelper.GetDeltas());

        if (this.Public_GetQuillDeltas() == null)
        {
            try
            {
                LogErrorMessage("Post Conversion - Quill is NULL - " + this.Text);
            } catch (e2)
            {
                LogErrorMessage("Post Conversion - Quill is NULL - ERROR",e2);
            }
            
        }
        SbtSummerNoteHelper.ResetToDefaults();
        } catch (e)
        {
            try
            {
                LogErrorMessage("Public_ConvertToQuill Text " + this.Text, e)
            } catch (e2)
            {
                LogErrorMessage("Public_ConvertToQuill Error Fallback", e2)
            }
            

        }

       // t1 = performance.now();
       // console.log("\t Part 2 " + (t1 - t0) + " milliseconds.");
    }
    //else if (UseQuill)
    //{
    //    quill.setContents(null);
        

    //    quill.insertText(0, this.Text,
    //        {
    //            color: color,
    //            size: this.FontSize,
    //            font: this.Font.replaceAll2(" ", "_").replaceAll2("'", "").replaceAll2("\"", "")
    //        }

    //    );

    //    if (alignment != "")
    //    {
    //        //http://quilljs.com/docs/api/#formatline
    //        quill.formatLine(1, 2, 'align', alignment);   //  aligns the first line
    //    }

    //    this.Public_SetQuillDeltas(quill.getContents().ops);

    //    //clean out quill post conversion!
    //    quill.setContents(null);
    //}
};


TextState.prototype.Public_SetQuillDeltas = function (quillDeltas, supressWarning)
{

    this._QuillDeltas = SbtLib.DeepCopy(quillDeltas);
    try
    {
        if(supressWarning==null || supressWarning==false)
        if (this._QuillDeltas == null)
        {

            if (quillDeltas == null)
            {
                LogErrorMessage("_Quill deltas is null, and quilldeltas was null")
            }
            else
                
                    LogErrorMessage("_Quill deltas is null, and quilldeltas was NOT null", { message: "quillDeltas: " + JSON.stringify(quillDeltas), stack: "" });

        }
    } catch (e)
    {
        LogErrorMessage("Public_SetQuillDeltas - errors", e)

    }
    
}

TextState.prototype.Public_GetQuillDeltas = function ()
{
    return this._QuillDeltas;
}

TextState.prototype.Public_SummerNote_SetFontSizeAndColor = function (size, color)
{
    var deltas = SbtSummerNoteHelper.Deltas_UpdateFontSizeAndColor(this.Public_GetQuillDeltas(), size, color);
    this.Public_SetQuillDeltas(deltas);

    if (deltas == null)
    {
        LogErrorMessage("SbtSummerNoteHelper.OnChange: Deltas null ");
    }
}


TextState.prototype.Public_QuillSetFontColor = function (color)
{
    quill.setContents ( this.Public_GetQuillDeltas());
    quill.formatText(0, 1000, 'color', color)

    this.Public_SetQuillDeltas(quill.getContents().ops);

 
}

TextState.prototype.Public_QuillSetFontSize = function (size)
{
    quill.setContents (this.Public_GetQuillDeltas());
    quill.formatText(0, 1000, 'size', size.toString());

    //not always needed, but helps with making sure you are editing the right version of the data
    this.Public_SetQuillDeltas(quill.getContents().ops);
}

TextState.prototype.Public_GetFontStyles = function ()
{
    var styles = new Object();

    styles.Text = this.Text;
    styles.DefaultText = this.DefaultText;

    styles.Font = this.Font;
    styles.FontSize = this.FontSize;
    styles.FontColor = this.FontColor;
    styles.TextAlignment = this.TextAlignment;

    styles.Textable = this.Textable;
    styles._QuillDeltas = SbtLib.DeepCopy(this._QuillDeltas);

    return styles;
};

//copies text and font
TextState.prototype.CopyFontStyles = function (textState)
{

    this.Text = textState.Text;
    this.DefaultText = textState.DefaultText;

    this.Font = this.UpdateOldFont(textState.Font);
    this.FontSize = textState.FontSize;
    this.FontColor = textState.FontColor;
    this.TextAlignment = textState.TextAlignment;
    this.Textable = textState.Textable;

    //if something is already corrupt, this won't help, but partial check.  Soome data from 5/13/17 to 5/15/17 may be corrupted...  as well as any copy of a textable?'
    if (this.Text != null && this.Text != "")
        this.Textable = true;
    

   
    if (UseQuill || UseSummerNote)
    {
        this._QuillDeltas = textState._QuillDeltas;
     

        if (this._QuillDeltas == null && textState.Textable==true)
        {
            this.Public_ConvertToQuill();
        }

    }

     
};

TextState.prototype.Copy = function (textState)
{
    this.CopyFontStyles(textState);

    this.Textable = textState.Textable;
    this.TextOffsetLeft = textState.TextOffsetLeft;
    this.TextOffsetRight = textState.TextOffsetRight;
    this.TextOffsetTop = textState.TextOffsetTop;



    if (textState.Private_IdTextableRectangle != null && textState.Private_IdTextableRectangle.length > 0)
    {
        this.Private_IdTextableRectangle = this.Private_ShapeId + "_TextBoxArea";
        var shape = $("#" + this.Private_ShapeId);
        var textRectangle = shape.find("[id=" + textState.Private_IdTextableRectangle + "]");
        textRectangle.attr("id", this.Private_IdTextableRectangle);
    }
    this.RemovalId = textState.RemovalId;

};

TextState.prototype.UpdateOldFont = function (font)
{
    try
    {
        var fontLowerCase = font.toLowerCase();

        if (fontLowerCase.indexOf("arial") >= 0)
            return "Roboto";

        if (fontLowerCase.indexOf("calibri") >= 0)
            return "Roboto";

        if (fontLowerCase.indexOf("courier") >= 0)
            return "Roboto";

        if (fontLowerCase.indexOf("junction") >= 0)
            return "'Montserrat Alternates'";

        if (fontLowerCase.indexOf("gothic") >= 0)
            return "'Francois One'";

        if (fontLowerCase.indexOf("linden") >= 0)
            return "'times new roman'";

        if (fontLowerCase.indexOf("nobile") >= 0)
            return "'Montserrat Alternates'";

        if (fontLowerCase.indexOf("goudy") >= 0)
            return "Coustard";

        if (fontLowerCase.indexOf("aleo") >= 0)
            return "Coustard";

        if (fontLowerCase.indexOf("questrial") >= 0)
            return "'Montserrat Alternates'";

        if (fontLowerCase.indexOf("green fuz") >= 0)
            return "Creepster";

        if (fontLowerCase.indexOf("times new roman") >= 0)
            return "Lora";

        if (fontLowerCase.indexOf("david") >= 0)
            return "'Varela Round'";

    } catch (e)
    {
        LogErrorMessage("TextState.UpdateFont", e);
    }

    return font;
};

TextState.prototype.Private_CheckForMetaData = function (id)
{
    var md = $("#" + id).find("sbtdata");
    if (md.length == 0)
        return;

    var textOffsetData = md.find("textoffset");
    if (textOffsetData.length > 0)
    {
        this.Private_HandleOldTextables(textOffsetData);
    }

    var textable = md.find("textable");
    if (textable.length > 0)
    {
        this.Private_HandleTextable(textable);
    }

    this.Private_CheckForRemovals(md);

    //md.remove();
};

TextState.prototype.Private_HandleTextable = function (textOffsetData)
{
    this.Textable = true;
    this.Private_IdTextableRectangle = textOffsetData.attr("textarea");

    var shape = $("#" + this.Private_ShapeId);
    var textRectangle = shape.find("[id=" + this.Private_IdTextableRectangle + "]");
    if (textRectangle != null)
    {
        this.Private_IdTextableRectangle = this.Private_ShapeId + "_TextBoxArea";
        textRectangle.attr("id", this.Private_IdTextableRectangle);
    }
};

TextState.prototype.Private_HandleOldTextables = function (textOffsetData)
{
    this.Textable = true;
    this.TextOffsetLeft = textOffsetData.find("left").first().text();
    this.TextOffsetRight = textOffsetData.find("right").first().text();
    this.TextOffsetTop = textOffsetData.find("top").first().text();
};

TextState.prototype.Private_CheckForRemovals = function (md)
{
    var removal = md.find("removetext");
    if (removal.length == 0)
        return;

    this.RemovalId = removal.first().text();    //why does firefox require thsi???!!?

};