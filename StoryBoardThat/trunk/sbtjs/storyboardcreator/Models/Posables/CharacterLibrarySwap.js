///  <reference path="../../SvgManip.js" />


function CharacterLibrarySwappablePose(svgId, globalImageId, pose, position)
{
    this._SwapOptions = new Object();

    this._ShapeId = svgId;
    this.GlobalImageId = globalImageId;

    this._SelectedSwapOption;

    this.PoseType = SbtDataEnum.PoseType_Swap;
    this.Title;

    this._AppendToId;
    this.Position = position;

    //#region "Privates

    this.Private_ParseSwapOptions(pose);
}

CharacterLibrarySwappablePose.prototype.Private_ParseSwapOptions = function (pose)
{
    if (pose == null)
        return;

    this.Title = GetSafeAttributeNS(pose, SbtDataEnum.Attribute_SwapPose_Title);
    var defaultId = GetSafeAttributeNS(pose, SbtDataEnum.Attribute_SwapPose_DefaultId);

    this._AppendToId = GetSafeAttributeNS(pose, SbtDataEnum.Attribute_SwapPose_AppendToId);

    FindAndUpdateId(this._ShapeId, this._AppendToId, this.Public_GetAppendToId());

    for (var i = 0; i < pose.childElementCount; i++)
    {
        var poseOption = new Pose_CharacterLibrarySwapOption(this._ShapeId, this.GlobalImageId, GetIESafeChild(pose, i), this.Position); //tiltablePoseOption;
        this._SwapOptions[poseOption.Public_GetInternalId()] = poseOption;
    }

    this.Public_SetActiveOption(this.Public_GetSwapOptionById(defaultId));
    if (this.Public_GetActiveOption() == null)
    {
        //DebugLine("Unable to Find: " + this.GlobalImageId + " : " + defaultId)
    }
};

CharacterLibrarySwappablePose.prototype.Private_GetLocalId = function (idPart)
{
    return this._ShapeId + SbtDataEnum.Id_Swap_Middle + idPart;
};

CharacterLibrarySwappablePose.prototype.Private_GetCopyId = function (rhs, idPart)
{
    return rhs._ShapeId + SbtDataEnum.Id_Swap_Middle + idPart;
};

//#region "Publics
CharacterLibrarySwappablePose.prototype.Public_GetAppendToId = function ()
{
    return this.Private_GetLocalId(this._AppendToId);
};

CharacterLibrarySwappablePose.prototype.Public_GetSwapOptions = function ()
{
    return this._SwapOptions;
};

CharacterLibrarySwappablePose.prototype.Public_GetSwapOptionById = function (swapOptionId)
{
    return this._SwapOptions[swapOptionId];
};

CharacterLibrarySwappablePose.prototype.Public_SetActiveOption = function (swapOption)
{
    this._SelectedSwapOption = swapOption;
};

CharacterLibrarySwappablePose.prototype.Public_GetActiveOption = function ()
{
    return this._SelectedSwapOption;
};

//#endregion

CharacterLibrarySwappablePose.prototype.Public_Copy = function (rhs)
{
    this.Title = rhs.Title;
    this._AppendToId = rhs._AppendToId;
    this.GlobalImageId = rhs.GlobalImageId;
    this.Position = rhs.Position;

    FindAndUpdateId(this._ShapeId, this.Private_GetCopyId(rhs, rhs._AppendToId), this.Public_GetAppendToId());

    this._SelectedSwapOption = new Pose_CharacterLibrarySwapOption(this._ShapeId, this.GlobalImageId, null, this.Position);

    if (rhs._SelectedSwapOption != null)
    {
        rhs._SelectedSwapOption._Position = rhs._SelectedSwapOption._Position || this.Position;// YUCK! nastiness of pre-multi-position code abs 7/9/14
        this._SelectedSwapOption.Public_Copy(rhs._SelectedSwapOption);
    }
    else
    {
        this._SelectedSwapOption._Position = this.Position;
        this._SelectedSwapOption._SwapId = "";
        this._SelectedSwapOption._Title = "";

        rhs._SelectedSwapOption = new Object();
        rhs._SelectedSwapOption._Position = this.Position;
    }
    for (var key in rhs._SwapOptions)
    {
        if (rhs._SwapOptions.hasOwnProperty(key))
        {
            try
            {
                var swapOption = new Pose_CharacterLibrarySwapOption(this._ShapeId, this.GlobalImageId, null, this.Position);

                rhs._SwapOptions[key]._Position = rhs._SelectedSwapOption._Position || this.Position;// YUCK! nastiness of pre-multi-position code abs 7/9/14
                swapOption.Public_Copy(rhs._SwapOptions[key]);

                this._SwapOptions[key] = swapOption;
            }

            catch (e)
            {
                LogErrorMessage("CharacterLibrarySwap.Public_Copy", e);
            }
        }
    }
};