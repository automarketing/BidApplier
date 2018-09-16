/// <reference path="../SvgManip.js" />

function ColorUpdaterBox()
{
    this.Private_ActiveShapeId = "";

    this.Private_ColorTable = $("#ColorUpdaterBoxTable");
    // this.Private_ColorPicker = null;
    this.Public_PrepColorControls = function (left, top, activeShape)
    {

        var addColors = false;

        if (activeShape.Id != this.Private_ActiveShapeId)
            addColors = true;

        if (MyPointers.Controls_UpdateColor.css("display") === "none")
            addColors = true;

        if (addColors)
        {
            this.Private_AddColors(activeShape);
        }
        else
        {
            this.Private_UpdateColors(activeShape);
        }
        this.Private_ActiveShapeId = activeShape.Id;

        this.Private_MakeVisible(left, top);

    };

    this.HideUpdateColors = function ()
    {
        var visibility = MyPointers.Controls_UpdateColor.css("display");
        if (visibility != "none")
        {
            MyPointers.Controls_UpdateColor.css("display", "none");
            $(".sp-container").remove();
        }
    };

    this.Private_MakeVisible = function (left, top)
    {
        MyPointers.Controls_UpdateColor.css("left", left);
        MyPointers.Controls_UpdateColor.css("top", top);

        MyPointers.Controls_UpdateColor.css("display", "block");
    };

    this.Private_UpdateColors = function (activeShape)
    {
        var regionList = activeShape.Public_GetColorRegions();

        for (var i = 0; i < regionList.length; i++)
        {
            var activeColor = activeShape.Public_GetColorForRegion(regionList[i]);
            //var title = activeShape.Public_GetTitleForRegion(regionList[i]);
            var region = regionList[i];

            if (region == "")
                continue;

            try
            {


                var myColorPicker = $("#ColorSelector_" + region + "_color_picker");

                if (myColorPicker.spectrum('container').attr("class").indexOf("hidden") > 0)  // if it is hidden, it is not actively a popup
                {
                    myColorPicker.spectrum("set", activeColor);
                }

                for (var j = 1; j < 7; j++)
                {
                    var id = this.Private_GenerateColorCellId(region, j);
                    var colorCell = $("#" + id);
                    colorCell.html("");

                    if (activeColor === colorCell.css("background-color"))
                    {
                        colorCell.html(this.Private_GenerateColoredX(activeColor));
                    }
                }
            } catch (e)
            {
                //DebugLine("ColorUpdaterBox.Private_UpdateColors" + e);
            }
        }
    };

    this.Private_AddColors = function (activeShape)
    {
        // JIRA-WEB-28 - SvgManip.DrawControlsMenu fails to create spectrum object. Could be a device issue (known that spectrum had some issues on iPad in the past, for instance), or something wrong on our side. Added debug info.
        var regionList, i;
        try
        {

            this.Private_ColorTable.children().remove();
            $(".sp-container").remove();

            regionList = activeShape.Public_GetColorRegions();
            for (i = 0; i < regionList.length; i++)
            {
                if (regionList[i] == "")
                    continue;


                var colorWheel = activeShape.Public_GetColorWheelForRegion(regionList[i]);



                var activeColor = activeShape.Public_GetColorForRegion(regionList[i]);

                if (colorWheel == null || colorWheel == undefined)
                {
                    var e = new Object();
                    e.message = "No palette: " + regionList[i];
                    e.stack = "";
                    LogErrorMessage("Private_AddColors: No Color", e);
                    continue;
                }

                var title = activeShape.Public_GetTitleForRegion(regionList[i]);
                if (title == null || title == "" || title == undefined)
                {
                    title = colorWheel.GetTitle();
                }

                var newRow = "";
                if (i > 0)
                {
                    newRow = "<tr>";
                    newRow += "<td colspan=\"7\" class=\"BufferRow\"></tr>";
                    newRow += "</tr>";
                }

                newRow += "<tr>";
                newRow += "<td  class=\"ColorPickerTitleCell\">" + title + "</td>";
                newRow += "<td>";
                newRow += "<table class=\"color-selection-block\">";
                newRow += "<tr>";
                newRow += this.Private_GenerateColorCell(regionList[i], 1, colorWheel.Color1, activeColor);
                newRow += this.Private_GenerateColorCell(regionList[i], 2, colorWheel.Color2, activeColor);
                newRow += this.Private_GenerateColorCell(regionList[i], 3, colorWheel.Color3, activeColor);
                //newRow += "<tr>";
                //newRow += "</tr>";
                newRow += this.Private_GenerateColorCell(regionList[i], 4, colorWheel.Color4, activeColor);
                newRow += this.Private_GenerateColorCell(regionList[i], 5, colorWheel.Color5, activeColor);
                newRow += this.Private_GenerateColorCell(regionList[i], 6, colorWheel.Color6, activeColor);
                
                newRow += "</tr>";
                newRow += "</table>"
                newRow += "</td>";


                newRow += this.Private_GenerateColorPickerCell(regionList[i], activeColor);



                newRow += "</tr>";

                //newRow += "<tr>";
                //newRow += "<td rowspan=\"2\" class=\"ColorPickerTitleCell\">" + title + ":</td>";
                //newRow += this.Private_GenerateColorCell(regionList[i], 1, colorWheel.Color1, activeColor);
                //newRow += this.Private_GenerateColorCell(regionList[i], 2, colorWheel.Color2, activeColor);
                //newRow += this.Private_GenerateColorCell(regionList[i], 3, colorWheel.Color3, activeColor);

                //newRow += this.Private_GenerateColorPickerCell(regionList[i], activeColor);
                //newRow += "</tr>";

                //newRow += "<tr>";
                //newRow += this.Private_GenerateColorCell(regionList[i], 4, colorWheel.Color4, activeColor);
                //newRow += this.Private_GenerateColorCell(regionList[i], 5, colorWheel.Color5, activeColor);
                //newRow += this.Private_GenerateColorCell(regionList[i], 6, colorWheel.Color6, activeColor);

                //newRow += "</tr>";

                this.Private_ColorTable.append(newRow);

                var myColorPicker = $("#ColorSelector_" + regionList[i] + "_color_picker");
                myColorPicker.spectrum(
                    {
                        color: activeColor,
                        showInput: true,
                        showAlpha: false,
                        showPalette: true,
                        localStorageKey: "StoryboardThat",
                        clickoutFiresChange: true,
                        showInitial: true,
                        change: UpdateColorRegionFromColorPicker,
                        move: UpdateColorRegionFromColorPickerPreview,
                        hide: UpdateColorRegionFromColorPickerHide
                    });
            }


            $("[id^=ColorSelector_div]").click(UpdateColorRegion);
        } catch (e)
        {
            throw e + " - Debug: " + i + ", " + regionList.join(",");
        }
    };
    this.Private_GenerateColorPickerCell = function (region, color)
    {
        //color = "rgb(0, 0, 255)";
        var id = "ColorSelector_" + region + "_color_picker";
        return "<td  class=\"ColorPickerInput\"><input id=\"" + id + "\" type=\"text\" /></td>"
    };

    this.Private_GenerateColorCell = function (region, cellNumber, color, activeColor)
    {
        var id = this.Private_GenerateColorCellId(region, cellNumber);

        var cell = "<td>";
        cell += "<div id=\"" + id + "\" class=\"ColorPickerCell\" style=\" background-color: " + color + "; \">";
        if (activeColor === color)
        {
            cell += this.Private_GenerateColoredX(activeColor);

        }
        cell += "</div></td>";

        return cell;
    };

    this.Private_GenerateColorCellId = function (region, cellNumber)
    {
        return "ColorSelector_div_" + region + "_cell_" + cellNumber;
    };

    this.Private_GenerateColoredX = function (activeColor)
    {
        try
        {
            if (activeColor === null)
                return "";

            var luma = activeColor.luma();
            var contrastColor = (luma >= 165) ? '000' : 'fff';

            return "<span class=\"selected-color-x\" style=\"color:#" + contrastColor + "\">X</span>";
        }
        catch (err)
        {
            return "";
        }
    };
}