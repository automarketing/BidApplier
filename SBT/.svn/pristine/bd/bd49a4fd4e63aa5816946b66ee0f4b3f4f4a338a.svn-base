function Pose_GlobalLibrarySwapOption(librarySwapOption)
{
    //this._ShapeId = svgId;
    this.LibrarySwapId;

    this._Title;

    this.Private_ParseSwapOption(librarySwapOption);
}

Pose_GlobalLibrarySwapOption.prototype.Private_ParseSwapOption = function (librarySwapOption)
{
    if (librarySwapOption === null)
        return;

    this._Title = GetSafeAttributeNS(librarySwapOption, SbtDataEnum.Attribute_LibrarySwapOption_Title);
    this.LibrarySwapId = GetSafeAttributeNS(librarySwapOption, SbtDataEnum.Attribute_LibrarySwapOption_SwapId);
};

Pose_GlobalLibrarySwapOption.prototype.Public_Copy = function (rhs)
{
    this.LibrarySwapId = rhs.LibrarySwapId;
    this._Title = rhs._Title;
};

Pose_GlobalLibrarySwapOption.prototype.Public_GetTitle = function ()
{
    if (this._Title === null || this._Title === "")
    {
        var id = this.LibrarySwapId;
        id = id.replace("Basic-", "")
               .replace("Female2-", "")
               .replace("Female-", "")
               .replace("Male-", "")
               .replace("Asian-", "")
               .replace("Indian-", "")
               .replace("Kid-", "");

        return MyLangMap.GetText("Gls-" + id);
    }
    return this._Title
};

Pose_GlobalLibrarySwapOption.prototype.Public_GetInternalId = function ()
{
    return this.LibrarySwapId;
};

Pose_GlobalLibrarySwapOption.prototype.IsEqual = function (rhs)
{
    if (rhs === null)
        return false;

    if (this.LibrarySwapId !== rhs.LibrarySwapId)
        return false;


    return true;
}
