///  <reference path="../../SvgManip.js" />

function TiltablePose(svgId, pose, position)
{
    this._TiltOptions = new Array();
    this._ShapeId = svgId;
    this.Position = position;
    this.PoseType = SbtDataEnum.PoseType_Tilt;

    this._TiltableId;
    this._Tiltable2Id;
    this._PivotId;
    this._ClearId;

    this.Title;

    this.Private_SelectedTiltOption;

    this.Private_ParseTiltOptions(pose);
}

TiltablePose.prototype.Private_ParseTiltOptions = function (pose)
{
    if (pose == null)
        return;

    this.Title = GetSafeAttributeNS(pose, SbtDataEnum.Attribute_TiltPose_Title);
    var defaultTilt = GetSafeAttributeNS(pose, SbtDataEnum.Attribute_TiltPose_DefaultTilt);

    this._ClearId = GetSafeAttributeNS(pose, SbtDataEnum.Attribute_TiltPose_ClearId);
    this._PivotId = GetSafeAttributeNS(pose, SbtDataEnum.Attribute_TiltPose_PivotId);
    this._TiltableId = GetSafeAttributeNS(pose, SbtDataEnum.Attribute_TiltPose_TiltableId);
    this._Tiltable2Id = GetSafeAttributeNS(pose, SbtDataEnum.Attribute_TiltPose_Tiltable2Id);

    // FindAndUpdateId(this._ShapeId, this._ClearId, this.Public_GetClearId());    // this will break face expressions...
    FindAndUpdateId(this._ShapeId, this._PivotId, this.Public_GetPivotId());
    FindAndUpdateId(this._ShapeId, this._TiltableId, this.Public_GetTiltableId());
    FindAndUpdateId(this._ShapeId, this._Tiltable2Id, this.Public_GetTiltable2Id());

    for (var i = 0; i < pose.childElementCount; i++)
    {
        //this._TiltOptions[i] = new Pose_TiltOption(pose.childNodes[i], this); //tiltablePoseOption;
        this._TiltOptions[i] = new Pose_TiltOption(GetIESafeChild(pose, i), this); //tiltablePoseOption;
    }

    this.Private_SelectedTiltOption = this.Public_GetTiltOptionByDegrees(defaultTilt);
};

TiltablePose.prototype.Public_GetTiltOptionByDegrees = function (degrees)
{
    for (var i = 0; i < this._TiltOptions.length; i++)
    {
        if (this._TiltOptions[i].Degrees == degrees)
            return this._TiltOptions[i];
    }
    return null;
};

TiltablePose.prototype.Private_GetLocalId = function (idPart)
{
    return this._ShapeId + "_TILT_" + idPart;
};

TiltablePose.prototype.Private_GetCopyId = function (rhs, idPart)
{
    return rhs._ShapeId + "_TILT_" + idPart;
};


TiltablePose.prototype.Public_GetTiltableId = function ()
{
    return this.Private_GetLocalId(this._TiltableId);
};

TiltablePose.prototype.Public_GetTiltable2Id = function ()
{
    if (this._Tiltable2Id == null || this._Tiltable2Id == "")
        return null;


    return this.Private_GetLocalId(this._Tiltable2Id);
};

TiltablePose.prototype.Public_GetPivotId = function ()
{
    return this.Private_GetLocalId(this._PivotId);
};

TiltablePose.prototype.Public_GetClearId = function ()
{
    return this._ClearId; // this will break face expressions...

};

TiltablePose.prototype.Public_GetTiltOptions = function ()
{
    return this._TiltOptions;
};


TiltablePose.prototype.Public_Copy = function (rhs)
{
    this.Title = rhs.Title;
    this.Public_DefaultTilt = rhs.Public_DefaultTilt;

    this._TiltableId = rhs._TiltableId;
    this._Tiltable2Id = rhs._Tiltable2Id;

    this._PivotId = rhs._PivotId;
    this._ClearId = rhs._ClearId;
    this.Position = rhs.Position;

    // can't use helper functions, since the methods don't exist on loads...
    FindAndUpdateId(this._ShapeId, this.Private_GetCopyId(rhs, rhs._PivotId), this.Public_GetPivotId());
    FindAndUpdateId(this._ShapeId, this.Private_GetCopyId(rhs, rhs._TiltableId), this.Public_GetTiltableId());
    FindAndUpdateId(this._ShapeId, this.Private_GetCopyId(rhs, rhs._Tiltable2Id), this.Public_GetTiltable2Id());


    this.Private_SelectedTiltOption = new Pose_TiltOption(null);

    if (rhs.Private_SelectedTiltOption == null)
        rhs.Private_SelectedTiltOption = new Pose_TiltOption(null);

    rhs.Private_SelectedTiltOption.Position = rhs.Private_SelectedTiltOption.Position || rhs.Position; // UGH ugly, due to OLD posables not recording position... abs 7/9/14
    this.Private_SelectedTiltOption.Public_Copy(rhs.Private_SelectedTiltOption);

    for (var i = 0; i < rhs._TiltOptions.length; i++)
    {
        var tiltOption = new Pose_TiltOption(null, null);
        rhs._TiltOptions[i].Position = rhs._TiltOptions[i].Position || rhs.Position; // UGH ugly, due to OLD posables not recording position... abs 7/9/14
        tiltOption.Public_Copy(rhs._TiltOptions[i]);

        this._TiltOptions[i] = tiltOption;
    }
};

TiltablePose.prototype.Public_GetActiveOption = function ()
{
    return this.Private_SelectedTiltOption;
};

TiltablePose.prototype.Public_SetActiveOption = function (tiltOption)
{
    this.Private_SelectedTiltOption = tiltOption;
};