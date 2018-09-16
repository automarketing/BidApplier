function SpringableState(id)
{
    this._ShapeId = id;

    this.IsSpringable = false;

    this.Anchors = new Object();
    //this.Anchors.Left = [];
    this.Anchors.Right = [];
    //this.Anchors.Top  = [];
    this.Anchors.Bottom = [];

    this.Springs = new Object();
    this.Springs.Horizontal = [];
    this.Springs.Vertical = [];
    
    //this.SpringX = 0;
    //this.SpringY = 0;
}

SpringableState.prototype.ParseMetaData = function ()
{
    var metaData = $("#" + this._ShapeId).find("sbtdata");
    
    if (metaData.length == 0)
        return;

    var anchorSets = metaData.find(SbtDataEnum.MetaData_Springable_Anchorset);
    var springSets = metaData.find(SbtDataEnum.MetaData_Springable_SpringSet);

    if (anchorSets.length == 0 || springSets.length==0)
        return;

    this._ParseMetaData_ExtractItems(anchorSets, this.Anchors, SbtDataEnum.MetaData_Springable_Attribute_Side);
    this._ParseMetaData_ExtractItems(springSets, this.Springs, SbtDataEnum.MetaData_Springable_Attribute_Direction);

    this.IsSpringable = true;
};

SpringableState.prototype._ParseMetaData_ExtractItems = function (nodes, idHolders, holderTitle)
{
    for (var i = 0; i < nodes.length; i++)
    {
        var title = GetSafeAttributeNS(nodes[i], holderTitle);
        var groups = GetSafeAttributeNS(nodes[i], SbtDataEnum.MetaData_Springable_Attribute_Groups);

        if (title == null || groups == null || groups=="")
            continue;

        title = title.toLowerCase().CapitalizeFirstLetter();
        idHolders[title] = StoryboardCreatorLibrary.ParseAndUpdateIds(this._ShapeId, this._ShapeId + "-spring-", groups);
    }
}

SpringableState.prototype.CopySpringableState = function (rhs, springableState)
{
    if (rhs == undefined || rhs == null)
    {
        return;
    }

    this.IsSpringable = rhs.IsSpringable;

    //this._UpdateIdsInArray(this.Anchors.Left, rhs.Anchors.Left, rhs._ShapeId);
    this._UpdateIdsInArray(this.Anchors.Right, rhs.Anchors.Right, rhs._ShapeId);
    //this._UpdateIdsInArray(this.Anchors.Top, rhs.Anchors.Top, rhs._ShapeId);
    this._UpdateIdsInArray(this.Anchors.Bottom, rhs.Anchors.Bottom, rhs._ShapeId);

    this._UpdateIdsInArray(this.Springs.Horizontal, rhs.Springs.Horizontal, rhs._ShapeId);
    this._UpdateIdsInArray(this.Springs.Vertical, rhs.Springs.Vertical, rhs._ShapeId);
   
};

SpringableState.prototype._UpdateIdsInArray = function (arrayToUpdate, arrayToCopy, oldShapeId)
{
    for (var i = 0; i < arrayToCopy.length; i++)
    {
        var oldId = arrayToCopy[i];
        var newId = oldId.replace(oldShapeId, this._ShapeId);

        FindAndUpdateId(this._ShapeId, oldId, newId);
        arrayToUpdate.push(newId);
    }
};

//this is for undo!
SpringableState.prototype.GetSpringStateTransforms = function ()
{
    var transformIds = [];
    //transformStates.concat(shapeState.SpringableState.Anchors.Left);
    //transformStates.concat(shapeState.SpringableState.Anchors.Top);
    transformIds = transformIds.concat(this.Anchors.Right);
    transformIds = transformIds.concat(this.Anchors.Bottom);
    
    transformIds = transformIds.concat(this.Springs.Horizontal);
    transformIds = transformIds.concat(this.Springs.Vertical);

    //var undoObject = new Object();
    var transforms =  [];
    
    //note there are dupes in this list... i'm just not good enough to know how to easily dedupe or care...
    for (var i=0; i<transformIds.length; i++)
    {
        var trans = new Object();
        trans.Id = transformIds[i];
        trans.Transform = SvgCreator.GetTransform(trans.Id);

        transforms.push(trans);
    }

    return transforms;
};

SpringableState.prototype.CanResizeVertical = function ()
{
    if (this.IsSpringable == false)
        return false;

    return this.Springs.Vertical.length > 0;
}

SpringableState.prototype.CanResizeHorizontal = function ()
{
    if (this.IsSpringable == false)
        return false;

    return this.Springs.Horizontal.length > 0;
}