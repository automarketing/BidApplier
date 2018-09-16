function Pose_CharacterLibrarySwapOption(svgId, globalImageId, swapOption, position)
{
    //this._ShapeId = svgId;    Uses too much space when export to JSON :(
    this._SwapId;

    this._Title;
    this._Position = position;


    this.Private_ParseSwapOption(svgId, swapOption, globalImageId);
}

Pose_CharacterLibrarySwapOption.prototype.Private_ParseSwapOption = function (svgId, swapOption, globalImageId)
{
    if (swapOption == null)
        return;

    this._Title = GetSafeAttributeNS(swapOption, SbtDataEnum.Attribute_SwapOption_Title);
    this._SwapId = GetSafeAttributeNS(swapOption, SbtDataEnum.Attribute_SwapOption_SwapId);

    var svg = $("#" + svgId).find("#" + this._SwapId).remove();
    if (svg.length == 0)
    {
        //DebugLine("Can't find: " + this._SwapId);
        return;
    }
    svg.attr("display", "inline");

    RecursivelyUpdateChildrenIds(svg, svgId, SbtDataEnum.Id_Storage);

    MyCharacterSwapLibrary.Public_SetSwap(globalImageId, this._Position, this._SwapId, svg);
};

Pose_CharacterLibrarySwapOption.prototype.Public_GetPoseSvg = function (globalImageId)
{
    var html = MyCharacterSwapLibrary.Public_GetSwap(globalImageId, this._Position, this._SwapId);
    if (html == null)
    {
        //DebugLine("Unable to find:" + globalImageId + ":" + this._SwapId);
    }
    return ParseRawSVG(html);
}


Pose_CharacterLibrarySwapOption.prototype.Public_GetInternalId = function ()
{
    return this._SwapId;
};

Pose_CharacterLibrarySwapOption.prototype.Public_Copy = function (rhs)
{
    this._SwapId = rhs._SwapId;
    this._Title = rhs._Title;
    this._Position = rhs._Position;//gets set twice, but better safe than sorry
    //this.Posi
};

Pose_CharacterLibrarySwapOption.prototype.Public_GetTitle = function ()
{
    if (this._Title == null || this._Title == "")
    {
        return MyLangMap.GetText("Cls-" + this._SwapId);
    }

    return this._Title;
};

Pose_CharacterLibrarySwapOption.prototype.IsEqual = function (rhs)
{
    if (rhs == null)
        return false;

    if (this._Position != rhs._Position)
        return false;

    if (this._SwapId != rhs._SwapId)
        return false;


    return true;
}