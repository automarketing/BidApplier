
function Pose_TiltOption(tiltOption, poseGroup)
{
    //this._Title;
    this._Region;
    this.Degrees;
    this.Position;

    this.Private_ParseTiltOption(tiltOption, poseGroup);
}

Pose_TiltOption.prototype.Public_Copy = function (rhs)
{
    //this._Title = rhs._Title;
    this.Degrees = rhs.Degrees;
    this._Region = rhs._Region;
    this.Position = rhs.Position;
};


Pose_TiltOption.prototype.Public_GetTitle = function ()
{
    return MyLangMap.GetText("Tilt-" + this._Region + "-" + this.Position + "-" + this.Degrees);
    //if (this._Title == null || this._Title == "")
    //{
    //    this._Title = 
    //}
    //return this._Title
};

Pose_TiltOption.prototype.Public_GetInternalId = function ()
{
    return this.Degrees;
};

Pose_TiltOption.prototype.Private_ParseTiltOption = function (tiltOption, poseGroup)
{
    if (tiltOption == null)
        return;

    // IF YOU NEED THIS - it means you forgot to trim white space from the posable meta data... WTF - abs 7/1/14
    //if (tiltOption.hasAttributes() == false)
    //    return;

    this._Region = poseGroup.Title;

    //this._Title = GetSafeAttributeNS(tiltOption, SbtDataEnum.Attribute_TiltOption_Title);
    this.Degrees = GetSafeAttributeNS(tiltOption, SbtDataEnum.Attribute_TiltOption_Degree);
    this.Position = poseGroup.Position;
};

Pose_TiltOption.prototype.IsEqual = function (rhs)
{
    if (rhs == null)
        return false;

    if (this._Region != rhs._Region)
        return false;

    if (this.Position != rhs.Position)
        return false;

    if (this.Degrees != rhs.Degrees)
        return false;

    return true;
};
