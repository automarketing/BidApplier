///  <reference path="../../SvgManip.js" />


function GlobalLibrarySwappablePose(svgId, pose)
{
    this._LibrarySwapOptions = new Object();
    this._ShapeId = svgId;
    
    this._SelectedLibraryOption;

    this.PoseType = SbtDataEnum.PoseType_LibrarySwap;
    this.Title;

    this._StartPointId;
    this._AppendToId;

    // #region "Privates
   

    this.Private_ParseLibrarySwapOptions(pose);
}

GlobalLibrarySwappablePose.prototype.Private_ParseLibrarySwapOptions = function (pose)
{
    if (pose == null)
        return;

    this.Title = GetSafeAttributeNS(pose, SbtDataEnum.Attribute_LibrarySwapOption_Title);
    var defaultId = GetSafeAttributeNS(pose, SbtDataEnum.Attribute_LibrarySwapPose_DefaultId);

    this._StartPointId = GetSafeAttributeNS(pose, SbtDataEnum.Attribute_LibrarySwapPose_StartPointId);
    this._AppendToId = GetSafeAttributeNS(pose, SbtDataEnum.Attribute_LibrarySwapPose_AppendToId);

    FindAndUpdateId(this._ShapeId, this._StartPointId, this.Public_GetStartPointToId());
    FindAndUpdateId(this._ShapeId, this._AppendToId, this.Public_GetAppendToId());

    for (var i = 0; i < pose.childElementCount; i++)
    {
        var poseOption = new Pose_GlobalLibrarySwapOption(GetIESafeChild(pose, i));
        this._LibrarySwapOptions[poseOption.LibrarySwapId] = poseOption;
    }

    this.Public_SetActiveOption(this.Public_GetLibrarySwapOptionById(defaultId));
    if (this.Public_GetActiveOption() == null)
    {
        //DebugLine("Unable to Find: " + defaultId)
    }
};

GlobalLibrarySwappablePose.prototype.Private_GetLocalId = function (idPart)
{
    return this._ShapeId + SbtDataEnum.Id_GlobalLibrary_Middle + idPart;
};

GlobalLibrarySwappablePose.prototype.Private_GetCopyId = function (rhs, idPart)
{
    return rhs._ShapeId + SbtDataEnum.Id_GlobalLibrary_Middle + idPart;;
};

//#region "Publics

GlobalLibrarySwappablePose.prototype.Public_GetAppendToId = function ()
{
    return this.Private_GetLocalId(this._AppendToId);
};

GlobalLibrarySwappablePose.prototype.Public_GetStartPointToId = function ()
{
    return this.Private_GetLocalId(this._StartPointId);
};

GlobalLibrarySwappablePose.prototype.Public_GetLibrarySwapOptions = function ()
{
    return this._LibrarySwapOptions;
};

GlobalLibrarySwappablePose.prototype.Public_GetLibrarySwapOptionById = function (librarySwapOptionId)
{
    return this._LibrarySwapOptions[librarySwapOptionId];
};


GlobalLibrarySwappablePose.prototype.Public_SetActiveOption = function (libraryOption)
{
    this._SelectedLibraryOption = libraryOption;
};

GlobalLibrarySwappablePose.prototype.Public_GetActiveOption = function ()
{
    return this._SelectedLibraryOption;
};

//#endregion

GlobalLibrarySwappablePose.prototype.Public_Copy = function (rhs)
{
    this.Title = rhs.Title;

    this._StartPointId = rhs._StartPointId;
    this._AppendToId = rhs._AppendToId;

    //can't use helper methods for RHS due to load from JSON
    FindAndUpdateId(this._ShapeId, this.Private_GetCopyId(rhs, rhs._AppendToId), this.Public_GetAppendToId());
    FindAndUpdateId(this._ShapeId, this.Private_GetCopyId(rhs, rhs._StartPointId), this.Public_GetStartPointToId());

    this._SelectedLibraryOption = new Pose_GlobalLibrarySwapOption(null);
    this._SelectedLibraryOption.Public_Copy(rhs._SelectedLibraryOption);

    for (var key in rhs._LibrarySwapOptions)
    {
        if (rhs._LibrarySwapOptions.hasOwnProperty(key))
        {
            var swapOption = new Pose_GlobalLibrarySwapOption(null);
            swapOption.Public_Copy(rhs._LibrarySwapOptions[key]);

            this._LibrarySwapOptions[key] = swapOption;
        }
    }
};