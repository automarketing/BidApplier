﻿var SaveDataHelper = function ()
{
    var SaveDataHelperObject = new Object();

    SaveDataHelperObject.NewStoryboard = 1;
    SaveDataHelperObject.EditStoryboard = 2;
    SaveDataHelperObject.AutoSave = 3;

    SaveDataHelperObject.GetSaveData = function (saveType)
    {
        var storyboardSaveData = new Object();

        storyboardSaveData.MagicToken = MyUserPermissions.MagicToken;
        storyboardSaveData.RequestStart = (new Date()).toUTCString();
        storyboardSaveData.SaveTry = 1;

        
        storyboardSaveData.Svg = GetRawSvg(saveType);
        storyboardSaveData.SvgLength = storyboardSaveData.Svg.length;

        storyboardSaveData.ShapeStates = MyShapesState.Public_ShapeStateToJson();
        storyboardSaveData.ShapeStatesLength = storyboardSaveData.ShapeStates.length;

        storyboardSaveData.CharacterSwapLibrary = MyCharacterSwapLibrary.Public_GetJSON(MyShapesState);
        storyboardSaveData.CharacterSwapLibraryLength = storyboardSaveData.CharacterSwapLibrary.length;

        storyboardSaveData.LayoutConfig = JSON.stringify(CellConfiguration.GetLayoutConfig());
        storyboardSaveData.LayoutConfigLength = storyboardSaveData.LayoutConfig.length;

        storyboardSaveData.UseCompression = 0;

        storyboardSaveData.SaveDuration = +new Date();

        if (saveType == SaveDataHelper.NewStoryboard)
        {
            storyboardSaveData.Title = $("#StoryboardTitle").val();
            storyboardSaveData.Description = $("#StoryboardDescription").val();
            storyboardSaveData.PortalFolderId = $("#portal_folder_id").val();
        }
        else if (saveType == SaveDataHelper.EditStoryboard || saveType == SaveDataHelper.AutoSave)
        {
            storyboardSaveData.UrlTitle = $("#UrlTitle").val();
            storyboardSaveData.UserName = $("#EditUserName").val();
        }

        //if (saveType == SaveDataHelper.AutoSave)
        //{
            storyboardSaveData.UsePmc = 1;
            storyboardSaveData.Svg = pmc(prePmc(storyboardSaveData.Svg));
            storyboardSaveData.SvgLength = storyboardSaveData.Svg.length;

            storyboardSaveData.ShapeStates = pmc(prePmc(storyboardSaveData.ShapeStates));
            storyboardSaveData.ShapeStatesLength = storyboardSaveData.ShapeStates.length;

            storyboardSaveData.CharacterSwapLibrary = pmc(storyboardSaveData.CharacterSwapLibrary);
            storyboardSaveData.CharacterSwapLibraryLength = storyboardSaveData.CharacterSwapLibrary.length;
        //}
        return storyboardSaveData;
    };

    function GetRawSvg(saveType)
    {
        try
        {
            if (saveType == SaveDataHelper.AutoSave)
            {
                var svgCopy = $("#CoreSvg").clone();

                svgCopy.attr("style", "");
                svgCopy.find("[id$=selection_box]").remove()
                svgCopy.find("[id=SvgTop]").children().remove();

                return (new XMLSerializer()).serializeToString(svgCopy.get()[0]);
            }

            var svgById = GetGlobalById("CoreSvg");

            var style = svgById.getAttribute("style");
            svgById.setAttribute("style", "");
            var svg_xml = (new XMLSerializer()).serializeToString(svgById);
            svgById.setAttribute("style", style);

            return svg_xml;
        }
        catch (e)
        {
            LogErrorMessage("SaveDataHelper.GetRawSvg", e);
        }
    };

    function EscapeText(text)
    {

    }



    return SaveDataHelperObject;
}();