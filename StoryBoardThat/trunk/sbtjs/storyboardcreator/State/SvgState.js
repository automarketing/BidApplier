﻿//Copyright 2012-2016, Clever Prototypes, LLC
// ALL RIGHTS RESERVED

/// <reference path="sbtLib.js" />
/// <reference path="../svgManip.js" />
function SvgState(id)
{
    this.Id = id;
    this.GlobalImageId;
    this.FlipHorizontal = false;
    this.FlipVertical = false;
    this.X = 0;
    this.Y = 0;
    this.ScaleX = 1;
    this.ScaleY = 1;
    this.Angle = 0;
    this.NaturalOffsetX = 0;
    this.NaturalOffsetY = 0;

    this.CropType = CropTypeEnum.Standard;
    this.UseClipping = false;
    this.ClipX = 10;
    this.ClipY = 10;
    this.ClipWidth = 150;
    this.ClipHeight = 100;
    this.CropPolygonPoint = [{x:0,y:0},{x:150,y:0},{x:150,y:100},{x:0,y:100}];
    this.CropPolygonPointJson = ""; // used for snapshort
    this.CacheAddress=new Array();

    

    this.FilterColorMode = "";
    this.IsLocked = false;

    this.Position = "Front";

    this.Movable = true;
    //this.AllowMainControls = true;

    this.TextState;
    this.ColorableState;
    this.PosableState;
    this.ImageAttribution;
    this.SmartSceneState;

    this.ActivelySelected = false;


    // List properties we'll use to detect a state change warranting a redraw
    // ABS 8/7/16 - we should probably move these to a global variable and save space on the stack/heap
    this._SvgStateProperties = ['Id', 'FlipHorizontal', 'FlipVertical', 'X', 'Y', 'ScaleX', 'ScaleY', 'Angle', 'NaturalOffsetX', 'NaturalOffsetY', 'UseClipping', 'ClipX', 'ClipY', 'ClipWidth', 'ClipHeight', 'FilterColorMode', 'IsLocked', 'ActivelySelected', 'Position','CropPolygonPointJson','CropType'];
    this._TextStateDataProperties = ['Text', 'Font', 'FontSize', 'FontColor', 'TextAlignment', '_QuillDeltas'];

    // Hold a snapshot of the item state during the previous redraw
    this._SnapshotStateData = {};

    this.Private_Init();


}

SvgState.prototype.Public_IsSmartScene = function ()
{
    if (this.SmartSceneState == null)
        return false;

    return this.SmartSceneState.IsSmartScene();
}

SvgState.prototype.Property_ClippedOffsetX = function ()
{
    if (this.UseClipping == false)
    {
        return 0;
    }

    return (this.ClipX * this.ScaleX);
};

SvgState.prototype.Property_ClippedOffsetY = function ()
{
    if (this.UseClipping == false)
    {
        return 0;
    }

    return (this.ClipY * this.ScaleY);

};

SvgState.prototype.Property_VisibleX = function ()
{
    var x = this.X + this.Property_ClippedOffsetX();

    return x;
};

SvgState.prototype.Property_VisibleY = function ()
{
    var y = this.Y + this.Property_ClippedOffsetY();
    return y;
};

SvgState.prototype.IsTextable = function ()
{
    return this.TextState.Textable;
};




SvgState.prototype.Private_Init = function ()
{
    // pDos
    var shape = GetGlobalById(this.Id);
    //var shape = $("#" + this.Id);

    var sbtdata = shape.querySelector("sbtdata");
 
    if( sbtdata != null )
    {
        this.GlobalImageId = sbtdata.getAttribute(SbtDataEnum.AttributeGlobalImageId);
        this.Position = sbtdata.getAttribute(SbtDataEnum.MetaData_Position) || this.Position;
    }
  

    //this.Position = shape.find("sbtdata").attr(SbtDataEnum.MetaData_Position) || this.Position; //http://stackoverflow.com/questions/476436/is-there-a-null-coalescing-operator-in-javascript
    
    this.TextState = new TextState(this.Id);
    this.ColorableState = new ColorableState(this.Id);

    this.PosableState = new PosableState(this.Id, this.GlobalImageId, this.Position);

    this.SmartSceneState = new SmartSceneState(this.Id)
    this.SmartSceneState.ParseMetaData(this.ColorableState);


    this.SpringableState = new SpringableState(this.Id);
    this.SpringableState.ParseMetaData();

    this.ImageAttribution = new ImageAttribution(shape.querySelector("attribution"));

    this.Private_ClearMetaData();

};



SvgState.prototype.ChangeCharacterPosition = function (position)
{
    if (position == this.Position)
        return;

    var positionObject = MyCharacterPosistionLibrary.GetCharacterPosition(this.GlobalImageId, position);

    var oldX = this.X;
    var oldY = this.Y;

    var appendTo = this.Private_GetPointer(SvgPartsEnum.Natural);


 var positionObject = MyCharacterPosistionLibrary.GetCharacterPosition(this.GlobalImageId, position);

    var oldX = this.X;
    var oldY = this.Y;

    var appendTo    = this.Private_GetPointer(SvgPartsEnum.Natural);
    var appendToObj = GetGlobalById( this.Private_GetId(SvgPartsEnum.Natural) );

    while (appendToObj.firstChild) {
        appendToObj.removeChild(appendToObj.firstChild);
    }

    appendToObj.insertAdjacentHTML('afterbegin', positionObject.Svg )

    appendToObj.querySelector("svg").setAttribute("id",this.Id);
 
    StoryboardContainer.UpdateGradientIds(appendTo);
    /////// 
    MyShapeMetaData.LookForMetaData(this.Id);

    this.Position = positionObject.Position;

    this.Private_ResetNaturalOffset();

    this.PosableState = new PosableState(this.Id, this.GlobalImageId, this.Position);
    this.ColorableState.Public_HandlePositionSwap();


    this.Private_ClearMetaData();

    this.X = oldX;
    this.Y = oldY;

    this.UpdateDrawing();
};

//this.Property_IsDeleted=function()
//{
//    if (this.Private_GetElement(SvgPartsEnum.Scale) == null)
//        return true;

//    return false;
//}

//#region Cell Location

//#endregion

SvgState.prototype.Public_RecreateFromOrphan = function ()
{
     
    // JIRA-WEB-6 - Somewhere we should recover the color filter state, as well as text, and colorable data - not of this is done. Per discussion, we recover just enough that the user can then delete the mysteriously corrupted shape)
    try
    {
        var svg = GetGlobalById(this.Id);

        //<g id="sbt_9783" class="activeShape" transform="translate(724.5851593017578, 126.2713623046875)rotate(0, 21.71484375,68.6953125)">
        var transform = svg.getAttribute("transform");
        if (transform != null)
        {
            var indexOfTranslate = (transform == null) ? 0 : transform.indexOf("translate");
            var indexOfRotate = (transform == null) ? 0 : transform.indexOf("rotate");

            var offset = transform.substring(indexOfTranslate + "translate".length, transform.indexOf(")", indexOfTranslate));
            var rotate = transform.substring(indexOfRotate + "rotate".length, transform.indexOf(")", indexOfRotate));

            offset = SplitParenthesis(offset);
            rotate = SplitParenthesis(rotate);

            this.X = Number(offset[0]);
            this.Y = Number(offset[1]);

            this.Angle = Number(rotate[0]);// other 2 values are auto calculated
        }
        else
        {
            this.X = 0;
            this.Y = 0;

            this.Angle = 0;// other 2 values are auto calculated
        }
    }
    catch (e)
    {
        //DebugLine("Recreate From Orphan [Svg]: " + e);
    }

    try
    {
        //<g id="sbt_9783_scale" transform="scale(1, 1)">
        var scaleG = this.Private_GetElement(SvgPartsEnum.Scale);
        var scale = scaleG.getAttribute("transform");
        if (scale != null)
        {
            scale = scale.replace("scale", "");
            scale = SplitParenthesis(scale);


            if (Number(scale[0]) < 0)
                this.FlipHorizontal = true;

            if (Number(scale[1]) < 0)
                this.FlipVertical = true;

            this.ScaleX = Math.abs(Number(scale[0]));
            this.ScaleY = Math.abs(Number(scale[1]));
        }
        else
        {
            this.ScaleX = 1;
            this.ScaleY = 1;
        }
    }
    catch (e)
    {
        // DebugLine("Recreate From Orphan [Scale]: " + e);
    }

    try
    {
        this.NaturalOffsetX = 0;
        this.NaturalOffsetY = 0;

        var naturalOffsetG = this.Private_GetElement(SvgPartsEnum.Natural);

        var translate = naturalOffsetG.getAttribute("transform");

        translate = translate.replace("translate", "");
        translate = SplitParenthesis(translate);

        this.NaturalOffsetX = -1 * Number(translate[0]); // you need to multiply by -1 since you want to do the "inverse" of the offset...
        this.NaturalOffsetY = -1 * Number(translate[1]);

        this.NaturalOffsetX = isNaN(this.NaturalOffsetX) ? 0 : this.NaturalOffsetX;
        this.NaturalOffsetY = isNaN(this.NaturalOffsetY) ? 0 : this.NaturalOffsetY;

    } catch (e)
    {
        //DebugLine("Recreate From Orphan [Translate]: " + e);
    }
};

SvgState.prototype.Public_ChangeShapeLocation = function (oldShapeLocation, newShapeLocation)
{
    if (oldShapeLocation == null || newShapeLocation == null)
        return;

    var deltaX = newShapeLocation.X - oldShapeLocation.X;
    var deltaY = newShapeLocation.Y - oldShapeLocation.Y;

    this.MoveDistance(deltaX, deltaY);
    this.UpdateDrawing();

    //DebugLine("Change Shape Location: " + this.Id + " x:" + deltaX + " y:" + deltaY);
};


//#region Coloring

SvgState.prototype.Property_IsColorable = function ()
{
    if (this.ColorableState == undefined || this.ColorableState == null)
        return false;



    return this.ColorableState.Property_IsColorable();
};

// call this to remove 'hover colors'
SvgState.prototype.Public_ResetColors = function ()
{
    if (this.TextState != null)
        this.TextState.Public_ResetFontColor();

    if (this.Property_IsColorable() == false)
        return;

    this.ColorableState.Public_ResetColors();
};

SvgState.prototype.Public_SetColorForRegion = function (region, color, isPreview, updateControlsMenu, addUndo)
{
    if (this.Property_IsColorable() == false)
        return;


    if (addUndo)
    {
        var currentColor = this.ColorableState.Public_GetColorForRegion(region);

        UndoManager.register(undefined, UndoColorChange, [this.Id, region, currentColor], '', undefined, UndoColorChange, [this.Id, region, color], '')
    }

    this.ColorableState.Public_UpdateColorForRegion(region, color, isPreview);

    if (updateControlsMenu)
    {
        DrawControlsMenu();
    }
};

SvgState.prototype.Public_GetColorRegions = function ()
{
    if (this.Property_IsColorable() == false)
        return null;

    return this.ColorableState.Public_GetRegionList();
};

SvgState.prototype.Public_GetColorWheelForRegion = function (region)
{
    if (this.Property_IsColorable() == false)
        return null;

    return this.ColorableState.Public_GetColorWheelForRegion(region);
};

SvgState.prototype.Public_GetColorForRegion = function (region)
{
    if (this.Property_IsColorable() == false)
        return null;

    return this.ColorableState.Public_GetColorForRegion(region);
};

SvgState.prototype.Public_GetTitleForRegion = function (region)
{
    if (this.Property_IsColorable() == false)
        return null;

    try
    {
        return this.ColorableState.Public_GetTitleForRegion(region);
    } catch (e)
    {

    }
    return "";
};

SvgState.prototype.Private_CopyColorableState = function (colorableState)
{
    this.ColorableState.Public_Copy(colorableState);
};
//#endregion

//#region "Springables"
SvgState.prototype.Private_CopySpringableState = function (springableState)
{
    if (springableState == null)
        return;

    this.SpringableState.CopySpringableState(springableState);
};

SvgState.prototype.IsSpringable = function ()
{
    if (this.SpringableState == null)
        return false;

    return this.SpringableState.IsSpringable;

};

SvgState.prototype._CanResizeVertical = function ()
{
    if (this.IsSpringable() == false)
        return true;

    return this.SpringableState.CanResizeVertical();
};

SvgState.prototype._CanResizeHorizontal = function ()
{
    if (this.IsSpringable() == false)
        return true;

    return this.SpringableState.CanResizeHorizontal();
};
//#endregion

SvgState.prototype.CopyShapeState = function (rhs)
{ 
    this.SetScale(rhs.ScaleX, rhs.ScaleY);
    this.RotateShape(rhs.Angle);
    this.FlipHorizontal = rhs.FlipHorizontal;
    this.FlipVertical = rhs.FlipVertical;

    this.FilterColorMode = rhs.FilterColorMode;
    this.IsLocked = false;
    //try
    //{
    //    this.IsLocked = rhs.IsLocked || false;
    //} catch (e)
    //{

    //}


    this.UseClipping = rhs.UseClipping;
    this.ClipX = rhs.ClipX;
    this.ClipY = rhs.ClipY;
    this.ClipWidth = rhs.ClipWidth;
    this.ClipHeight = rhs.ClipHeight;
    this.CropType = rhs.CropType;
    this.CropPolygonPointJson = JSON.stringify( rhs.CropPolygonPoint );
    this.CropPolygonPoint = JSON.parse( this.CropPolygonPointJson ) ;
    
    
    this.GlobalImageId = rhs.GlobalImageId;
    this.Position = rhs.Position;

    if (this.UseClipping == undefined || this.UseClipping == null)
    {
        this.UseClipping = false;
        this.ClipX = 0;
        this.ClipY = 0;
        this.ClipWidth = 0;
        this.ClipHeight = 0;
    }
    if (rhs.IsTextable())
    {
        this.CopyTextState(rhs.TextState);
    }
    if (rhs.Property_IsColorable())
    {
        this.Private_CopyColorableState(rhs.ColorableState);
    }
    if (rhs.Public_IsPosable())
    {
        this.Private_CopyPosableState(rhs.PosableState);
    }
    if (rhs.Public_IsSmartScene())
    {
        this.Private_CopySmartSceneState(rhs.SmartSceneState);
    }
    if (rhs.IsSpringable())
    {
        this.Private_CopySpringableState(rhs.SpringableState);
    }
};



// Takes a snapshot of the item state
SvgState.prototype.Private_SnapshotState = function ()
{
    var i;
    for (i = 0; i < this._SvgStateProperties.length; i++)
    {
        this._SnapshotStateData[this._SvgStateProperties[i]] = this[this._SvgStateProperties[i]];
    }

    for (i = 0; i < this._TextStateDataProperties.length; i++)
    {
        this._SnapshotStateData[this._TextStateDataProperties[i]] = this.TextState[this._TextStateDataProperties[i]];
    }

    if (this.Public_IsPosable())
    {
        var poseGroups = this.PosableState.Public_PoseGroups();
        for (i = 0; i < poseGroups.length; i++)
        {
            pose = poseGroups[i];
            var id = "posable_" + i;
            this._SnapshotStateData[id] = pose.Public_GetActiveOption()

        }
    }

};

// Test whether the item state has changed since the last call (the last redraw). If so, takes a new snapshot and return 'true' to indicate the redraw operation should proceed. Otherwise, return false, to skip the redraw and save some CPU
SvgState.prototype.Private_HasChangedSinceLastUpdateDrawing = function ()
{
    var i;

    try
    {
        for (i = 0; i < this._SvgStateProperties.length; i++)
        {
            if ((this._SnapshotStateData[this._SvgStateProperties[i]] || EMPTY_STRING) !== (this[this._SvgStateProperties[i]] || EMPTY_STRING))
            {
                
                // if( this._SvgStateProperties[i]=="CropPolygonPointJson" )
                //     DebugLine(this._SvgStateProperties[i] + ":" + this[this._SvgStateProperties[i]])// see what triggered update

                this.Private_SnapshotState(); // Status changed: take a new snapshot for the next check

                return true; // And indicate we need to redraw
            }
        }
    }
    catch (e)
    {
        LogErrorMessage("Private_HasChangedSinceLastUpdateDrawing.a", e);
        return true;

    }

    try
    {
        for (i = 0; i < this._TextStateDataProperties.length; i++)
        {
            if ((this._SnapshotStateData[this._TextStateDataProperties[i]] || EMPTY_STRING) !== (this.TextState[this._TextStateDataProperties[i]] || EMPTY_STRING))
            {
                //DebugLine(_TextStateDataProperties[i] + ":" + this.TextState[_TextStateDataProperties[i]]); // see what triggered update
                this.Private_SnapshotState();   // Status changed: take a new snapshot for the next check

                return true; // And indicate we need to redraw
            }
        }
       
    }
    catch (e)
    {
        LogErrorMessage("Private_HasChangedSinceLastUpdateDrawing.b", e);
        return true;

    }

    try
    {
        if (this.Public_IsPosable())
        {
            var poseGroups = this.PosableState.Public_PoseGroups();
            for (i = 0; i < poseGroups.length; i++)
            {
                pose = poseGroups[i];
                var id = "posable_" + i;
                var activePoseOption = pose.Public_GetActiveOption();
                if (activePoseOption == null)
                {
                    LogErrorMessage("SvgState.Private_HasChangedSinceLastUpdateDrawing ActivePoseOption is null")
                    this.Private_SnapshotState();   // Status changed: take a new snapshot for the next check
                    return true; // And indicate we need to redraw
                }
                if (this._SnapshotStateData[id] == null)
                {
                    LogErrorMessage("SvgState.Private_HasChangedSinceLastUpdateDrawing _SnapshotStateData is null - id " + id);
                    this.Private_SnapshotState();   // Status changed: take a new snapshot for the next check
                    return true; // And indicate we need to redraw
                }

                if (activePoseOption.IsEqual(this._SnapshotStateData[id]) == false)
                {
                    this.Private_SnapshotState();   // Status changed: take a new snapshot for the next check
                    return true; // And indicate we need to redraw
                }
            }
        }
    }
    catch (e)
    {
        LogErrorMessage("Private_HasChangedSinceLastUpdateDrawing.c", e);
        return true;
    }

    // Indicate there is no need to redraw
    return false;
};

SvgState.prototype.Public_ClearDefaults = function ()
{
    if (this.IsTextable && this.TextState.Public_ClearDefaults())
    {
        try
        {
            this.UpdateDrawing();
        }
        catch (e)
        {
            LogErrorMessage("SvgState.Public_ClearDefaults", e);
        }
    }

};

SvgState.prototype.UpdateDrawing = function (forceUpdate)
{
 
    if (forceUpdate == null || forceUpdate == false)
    {
        // If the state hasn;t changed, we need not redraw: exit right away.
        if (!this.Private_HasChangedSinceLastUpdateDrawing())
        {
            return;
        }
    }
    //DebugLine("not changed: " + this.CropType);
    if (this.ActivelySelected == false)
    {
        this.ClearSelectionBox();
    }

    var svg = GetGlobalById(this.Id);
 

    // Set color mode (remove old filter on selection box from early implementation!)
    //if (($(svg).css('filter') || EMPTY_STRING) !== EMPTY_STRING)
    //{
    //    $(svg).css('filter', EMPTY_STRING);
    //}

    // latest version of chrome 2/21/17 is ignoring a change on filter so we have to kick it to refresh it...
    // http://stackoverflow.com/questions/8840580/force-dom-redraw-refresh-on-chrome-mac
    var svg_nat = GetGlobalById(this.Id + SvgPartsEnum.Natural);
    var svg_nat_childsvg = svg_nat.querySelector('svg');

    if( svg_nat_childsvg != null && svg_nat_childsvg.style.filter != this.FilterColorMode )
    {
        svg_nat_childsvg.style.filter = this.FilterColorMode;
        svg_nat_childsvg.style.display = 'none';
        svg_nat_childsvg.style.display = '';
        this.FilterColorMode = svg_nat_childsvg.style.filter;
    }
 
    var naturalOffsetG = this.Private_GetElement(SvgPartsEnum.Natural);
    var scaleG = this.Private_GetElement(SvgPartsEnum.Scale);
 

    var bb = this.Private_GetFullShapeDimensions();
    //if (bb == null && this.Movable == false)
    //{
    //    return;
    //}
    var bb_clip = this.Public_GetVisibleShapeDimensions();
    var scaleX = this.ScaleX;
    var xOffset = 0;
    var yOffset = 0;

    // DebugLine( "bb_clip.width : " + bb_clip.width  );
    // DebugLine( "this.ClipX : " + this.ClipX  );
    // DebugLine( "this.ScaleX : " + this.ScaleX  );

    var pivotRotateX = bb_clip.width / 2 + this.Property_ClippedOffsetX();
    var pivotRotateY = bb_clip.height / 2 + this.Property_ClippedOffsetY();

    
    // DebugLine( "pivotRotateY : " + pivotRotateY  );


    if (this.FlipHorizontal)
    {
        scaleX *= -1;
        pivotRotateX *= -1;
        xOffset += bb.width;
        if (this.UseClipping)
        {
            /*
            |                      |
            |  (r)   [new box] (s) |
            |                      |
            */
            var substractOffset = bb_clip.width + (2 * this.Property_ClippedOffsetX());
            xOffset -= bb.width - substractOffset;
        }
    } 
    //var scaleY = this.ScaleY ? this.ScaleY : this.ScaleX; //WTF getting nulls...  assume proportional...
    var scaleY = this.ScaleY;
    if (this.FlipVertical)
    {
        scaleY *= -1;
        pivotRotateY *= -1;
        yOffset += bb.height;

        if (this.UseClipping)
        {
            var substractOffset = bb_clip.height + (2 * this.Property_ClippedOffsetY());
            yOffset -= bb.height - substractOffset;
        }
    }
 
    var natOffsetX = -1 * this.NaturalOffsetX;
    var natOffsetY = -1 * this.NaturalOffsetY;

    natOffsetX = isNaN(natOffsetX) ? 0 : natOffsetX;    //sometimes it is NAN...
    natOffsetY = isNaN(natOffsetY) ? 0 : natOffsetY;

    if (naturalOffsetG == null)
        LogErrorMessage("SvgState.UpdateDrawing - No NaturalOffsetG " + this.Id);
    else
        naturalOffsetG.setAttribute("transform", "translate(" + natOffsetX + "," + natOffsetY + ")");

    if (scaleG == null)
        LogErrorMessage("SvgState.UpdateDrawing - No scaleG " + this.Id);
    else
        scaleG.setAttribute("transform", "scale(" + scaleX + ", " + scaleY + ")");

    var translation = "translate(" + (this.X + xOffset) + ", " + (this.Y + yOffset) + ")";
    translation += "rotate(" + this.Angle + ", " + pivotRotateX + "," + pivotRotateY + ")";

    if (svg == null)
        LogErrorMessage("SvgState.UpdateDrawing - No svg " + this.Id);
    else
        svg.setAttribute("transform", translation);
 
    this.UpdateCropping();

    if (this.IsTextable())
    {
        this.AddText();
    }

    if (this.ActivelySelected)
    { 
        this.DrawSelectionBox();
    }

    // this is required by safari to realize there is a clip path! probably safe to wrap in safari only block...
    if (MyBrowserProperties.IsSafari5)
    {
        var mainSvg = MyPointers.CoreSvg;
        var svgContainer = MyPointers.SvgContainer;

        mainSvg.detach();
        svgContainer.append(mainSvg);
    }
};

SvgState.prototype.ClearSelectionBox = function ()
{  
 
    var x = GetGlobalById(this.Private_GetId(SvgPartsEnum.SelectionBox) );
    if( x )
        x.parentNode.removeChild(x);
    
    x = GetGlobalById(this.Private_GetId(SvgPartsEnum.RotateCircleGroup) );
    if( x )
        x.parentNode.removeChild(x); 
    
};

SvgState.prototype.SetEdgeHandlers = function (id, mouseDownEvent, mouseLeaveEvent)
{ 
    GetGlobalById(id).addEventListener("mousedown",mouseDownEvent);
    GetGlobalById(id).addEventListener("mouseup",mouseLeaveEvent);
    GetGlobalById(id).addEventListener("mouseleave",mouseLeaveEvent); 
};

SvgState.prototype.Private_GetSelectionBoxArea = function (selectorOffset)
{
    var bb = this.Private_GetFullShapeDimensions();

    var width = bb.width;
    var height = bb.height;

    var clipOffsetX = 0;
    var clipOffsetY = 0;

    if (this.UseClipping)
    {
        width = this.ClipWidth * this.ScaleX;
        height = this.ClipHeight * this.ScaleY;

        clipOffsetX = (this.ClipX * this.ScaleX);
        clipOffsetY = this.ClipY * this.ScaleY;
    }

    if (isNaN(width) || isFinite(width) == false)
    {
        width = 40;
    }
    if (isNaN(height) || isFinite(height) == false)
    {
        height = 10;
    }
    var left = -1 * selectorOffset + clipOffsetX;
    var right = width + selectorOffset + clipOffsetX;

    var top = -1 * selectorOffset + clipOffsetY;
    var bottom = height + selectorOffset + clipOffsetY;


    if (this.FlipHorizontal)
    {
        var flipHorizontalOffset = width + (2 * this.Property_ClippedOffsetX());
        left -= flipHorizontalOffset;
        right -= flipHorizontalOffset;
    }

    if (this.FlipVertical)
    {
        var flipVerticalOffset = height + (2 * this.Property_ClippedOffsetY());
        top -= flipVerticalOffset;
        bottom -= flipVerticalOffset;
    }

    return { Width: width, Height: height, Left: left, Right: right, Bottom: bottom, Top: top };
};

SvgState.prototype.DrawSelectionBox = function ()
{
    if (this.Movable == false)
        return;
    var selectorOffset = 5;
    var boxArea = this.Private_GetSelectionBoxArea(selectorOffset);
    var selectionBoxObj = GetGlobalById(this.Private_GetId(SvgPartsEnum.SelectionBox));
    var selectionBoxWidth = boxArea.Width + (2 * selectorOffset);
    var selectionBoxHeight = boxArea.Height + (2 * selectorOffset);
 
    if (selectionBoxObj == null)
    { 
        var selectionBoxId = this.Private_GetId(SvgPartsEnum.SelectionBox);
        var selectionBoxElement = document.createElementNS("http://www.w3.org/2000/svg", "g");
        selectionBoxElement.setAttributeNS(null, "id", selectionBoxId);
         
        var x = GetGlobalById(this.Id);
        x.insertBefore( selectionBoxElement , x.childNodes[0] );
        selectionBoxElement.appendChild(SvgCreator.AddRect(boxArea.Left, boxArea.Top, selectionBoxWidth, selectionBoxHeight, "#526C85", "#D0E8F4", "4,4", ".25", this.Private_GetId(SvgPartsEnum.SelectionBoxRectangle)));
        selectionBoxObj = GetGlobalById(this.Private_GetId(SvgPartsEnum.SelectionBox));
    }
    else
    {

        SvgCreator.UpdateRectangleDom(GetGlobalById(this.Private_GetId(SvgPartsEnum.SelectionBoxRectangle)), boxArea.Left, boxArea.Top, selectionBoxWidth, selectionBoxHeight);
    }
 

    this.Private_HandleHotSpots(selectionBoxObj, boxArea.Top, boxArea.Right, boxArea.Bottom, boxArea.Left);
};

SvgState.prototype.Private_HandleHotSpots = function (selectionBoxElement, top, right, bottom, left)
{
    if (MyBrowserProperties.IsMobile)
    {
        this.Private_HandleMobileSelectionHotSpots(selectionBoxElement, top, right, bottom, left);
    }
    else
    {
        this.Private_HandlePCSelectionHotSpots(selectionBoxElement, top, right, bottom, left);
    }

};

SvgState.prototype.Private_HandleMobileSelectionHotSpots = function (g, top, right, bottom, left)
{
    var circleSize = 13;
    var rotateX = (left + right) / 2;
    var rotateY = top - 30;

    //http://www.colorcombos.com/color-schemes/408/ColorCombo408.html
    var strokeColor = "#AAA393";
    var fillColor = "#6285C7";

//    var rotateCircleGroup = this.Private_GetPointer(SvgPartsEnum.RotateCircleGroup);
    var rotateCircleGroupObj = GetGlobalById( this.Private_GetId(SvgPartsEnum.RotateCircleGroup) );

    if (rotateCircleGroupObj == null)
    {
        g.appendChild(SvgCreator.AddLine(rotateX, rotateY, rotateX, top - 3, "Stroke-dasharray:4,4; stroke: " + strokeColor, this.Private_GetId(SvgPartsEnum.RotateCircleBar)));

        //touchy needs to work on a group
        var circleG = document.createElementNS("http://www.w3.org/2000/svg", "g");
        circleG.setAttributeNS(null, "id", this.Private_GetId(SvgPartsEnum.RotateCircleGroup));


        g.appendChild(circleG);
        circleG.appendChild(SvgCreator.AddCircle(rotateX, rotateY, circleSize, strokeColor, fillColor, this.Private_GetId(SvgPartsEnum.RotateCircle), "RotateBar"));

        var rotateCircleGroup = GetGlobalById( this.Private_GetId(SvgPartsEnum.RotateCircleGroup) );
        rotateCircleGroup.addEventListener('touchy-rotate', HandleTouchyRotate);
    }
    else
    {
        SvgCreator.UpdateLineDom( GetGlobalById( this.Private_GetId( SvgPartsEnum.RotateCircleBar ) ), rotateX, rotateY, rotateX, top - 3);
        SvgCreator.UpdateCircleDom( GetGlobalById( this.Private_GetId( SvgPartsEnum.RotateCircle) ), rotateX, rotateY);
    }

};


SvgState.prototype.Private_HandlePCSelectionHotSpots = function (g, top, right, bottom, left)
{ 
    var rotateX = (left + right) / 2;
    var rotateY = top - 30;
    var middleX = (left + right) / 2;
    var middleY = (top + bottom) / 2;

    if (GetGlobalById( this.Private_GetId(SvgPartsEnum.Selector_NW)))
    {
        this.Private_UpdatePCSelectionHotSpots(g, top, right, bottom, left, rotateX, rotateY, middleX, middleY)
    }
    else
    {
        this.Private_AddPCSelectionHotSpots(g, top, right, bottom, left, rotateX, rotateY, middleX, middleY)
    }
};

SvgState.prototype.Private_UpdatePCSelectionHotSpots = function (g, top, right, bottom, left, rotateX, rotateY, middleX, middleY)
{
 

    var C = GetGlobalById(this.Private_GetId(SvgPartsEnum.RotateCircleBar));
    if( C ) SvgCreator.UpdateLineDom( C , rotateX, rotateY, rotateX, top - 3);

    C = GetGlobalById(this.Private_GetId(SvgPartsEnum.RotateCircle));
    if( C ) SvgCreator.UpdateCircleDom(C , rotateX, rotateY);

    C = GetGlobalById(this.Private_GetId(SvgPartsEnum.Selector_NW));
    if( C )
    { 
        SvgCreator.UpdateCircleDom(C, left, top);
        C.setAttribute('class' , this.Private_GetResizeArrow(3));
    }

    C=GetGlobalById(this.Private_GetId(SvgPartsEnum.Selector_NE));

    if( C )
    { 
        SvgCreator.UpdateCircleDom( C, right, top); 
        C.setAttribute('class' , this.Private_GetResizeArrow(1));
    }

    C = GetGlobalById(this.Private_GetId(SvgPartsEnum.Selector_SW));
    if( C )
    { 
        SvgCreator.UpdateCircleDom(C , left, bottom);
        C.setAttribute('class' , this.Private_GetResizeArrow(1)); 
    }

    C = GetGlobalById(this.Private_GetId(SvgPartsEnum.Selector_SE));
    if( C )
    {
         SvgCreator.UpdateCircleDom(C , right, bottom);
         C.setAttribute('class' , this.Private_GetResizeArrow(3));
    }

    C = GetGlobalById(this.Private_GetId(SvgPartsEnum.Selector_N));
    if( C )
    { 
        SvgCreator.UpdateCircleDom(C, middleX, top);
        C.setAttribute('class' , this.Private_GetResizeArrow(0));
    }

    C = GetGlobalById(this.Private_GetId(SvgPartsEnum.Selector_S));
    if( C )
    { 
        SvgCreator.UpdateCircleDom(C, middleX, bottom);
        C.setAttribute('class' , this.Private_GetResizeArrow(0));
    }

    C = GetGlobalById(this.Private_GetId(SvgPartsEnum.Selector_W));
    if( C )
    { 
        SvgCreator.UpdateCircleDom(C, left, middleY);
        C.setAttribute('class' , this.Private_GetResizeArrow(2));
    }

    C = GetGlobalById(this.Private_GetId(SvgPartsEnum.Selector_E));
    if( C )
    { 
        SvgCreator.UpdateCircleDom(C, right, middleY);
        C.setAttribute('class' , this.Private_GetResizeArrow(2));
    } 
};

SvgState.prototype.Private_AddPCSelectionHotSpots = function (g, top, right, bottom, left, rotateX, rotateY, middleX, middleY)
{
    var circleSize = CommonStylingEnum.ShapeSelector_HotSpot_Corner_CircleSize;
    var strokeColor = CommonStylingEnum.ShapeSelector_HotSpot_Corner_Stroke;
    var fillColor = CommonStylingEnum.ShapeSelector_HotSpot_Corner_Fill;

    //Rotate Bar        
    g.appendChild(SvgCreator.AddLine(rotateX, rotateY, rotateX, top - 3, "Stroke-dasharray:4,4; stroke: " + strokeColor, this.Private_GetId(SvgPartsEnum.RotateCircleBar)));
    g.appendChild(SvgCreator.AddCircle(rotateX, rotateY, circleSize, strokeColor, fillColor, this.Private_GetId(SvgPartsEnum.RotateCircle), CommonStylingEnum.ShapeSelector_HotSpot_Fill));

    //Corner Selectors
    g.appendChild(SvgCreator.AddCircle(left, top, circleSize, strokeColor, fillColor, this.Private_GetId(SvgPartsEnum.Selector_NW), this.Private_GetResizeArrow(3)));
    g.appendChild(SvgCreator.AddCircle(right, top, circleSize, strokeColor, fillColor, this.Private_GetId(SvgPartsEnum.Selector_NE), this.Private_GetResizeArrow(1)));
    g.appendChild(SvgCreator.AddCircle(left, bottom, circleSize, strokeColor, fillColor, this.Private_GetId(SvgPartsEnum.Selector_SW), this.Private_GetResizeArrow(1)));
    g.appendChild(SvgCreator.AddCircle(right, bottom, circleSize, strokeColor, fillColor, this.Private_GetId(SvgPartsEnum.Selector_SE), this.Private_GetResizeArrow(3)));


    var circleSize = CommonStylingEnum.ShapeSelector_HotSpot_Side_CircleSize;
    var strokeColor = CommonStylingEnum.ShapeSelector_HotSpot_Side_Stroke;
    var fillColor = CommonStylingEnum.ShapeSelector_HotSpot_Side_Fill;

    //Side Selectors
    if (this._CanResizeVertical())
    {
        g.appendChild(SvgCreator.AddCircle(middleX, top, circleSize, strokeColor, fillColor, this.Private_GetId(SvgPartsEnum.Selector_N), this.Private_GetResizeArrow(0)));
        g.appendChild(SvgCreator.AddCircle(middleX, bottom, circleSize, strokeColor, fillColor, this.Private_GetId(SvgPartsEnum.Selector_S), this.Private_GetResizeArrow(0)));
    }

    if (this._CanResizeHorizontal())
    {
        g.appendChild(SvgCreator.AddCircle(left, middleY, circleSize, strokeColor, fillColor, this.Private_GetId(SvgPartsEnum.Selector_W), this.Private_GetResizeArrow(2)));
        g.appendChild(SvgCreator.AddCircle(right, middleY, circleSize, strokeColor, fillColor, this.Private_GetId(SvgPartsEnum.Selector_E), this.Private_GetResizeArrow(2)));
    }

    this.SetEdgeHandlers(this.Private_GetId(SvgPartsEnum.RotateCircle), StartRotate, StopRotate);

    this.SetEdgeHandlers(this.Private_GetId(SvgPartsEnum.Selector_NE), StartResize, StopResize);
    this.SetEdgeHandlers(this.Private_GetId(SvgPartsEnum.Selector_NW), StartResize, StopResize);
    this.SetEdgeHandlers(this.Private_GetId(SvgPartsEnum.Selector_SE), StartResize, StopResize);
    this.SetEdgeHandlers(this.Private_GetId(SvgPartsEnum.Selector_SW), StartResize, StopResize);

    this.SetEdgeHandlers(this.Private_GetId(SvgPartsEnum.Selector_N), StartResize, StopResize);
    this.SetEdgeHandlers(this.Private_GetId(SvgPartsEnum.Selector_E), StartResize, StopResize);
    this.SetEdgeHandlers(this.Private_GetId(SvgPartsEnum.Selector_S), StartResize, StopResize);
    this.SetEdgeHandlers(this.Private_GetId(SvgPartsEnum.Selector_W), StartResize, StopResize);


};

SvgState.prototype.Private_GetResizeArrow = function (spot)
{
    var angle = this.Angle + 360; // just making sure not negative!
    angle = angle % 180;

    if (angle >= 30 && angle < 75)
        spot += 1;

    if (angle >= 75 && angle < 120)
        spot += 2;

    if (angle >= 120 && angle < 165)
        spot += 3;

    spot %= 4;

    switch (spot)
    {
        case 0:
            return CommonStylingEnum.ShapeSelector_ResizeHotSpot_V_Css;
        case 1:
            return CommonStylingEnum.ShapeSelector_ResizeHotSpot_NE_Css;
        case 2:
            return CommonStylingEnum.ShapeSelector_ResizeHotSpot_H_Css;
        case 3:
            return CommonStylingEnum.ShapeSelector_ResizeHotSpot_NW_Css;
    }
};

SvgState.prototype.CreateTextBlock = function (x, y, id, text, style)
{
    var shape = document.createElementNS("http://www.w3.org/2000/svg", "text");
    shape.setAttributeNS(null, "x", x);
    shape.setAttributeNS(null, "y", y);
    shape.setAttributeNS(null, "id", id);
    shape.setAttributeNS(null, "style", style);
    shape.setAttributeNS(null, "class", "DisableSelection");

    var data = document.createTextNode(text);
    shape.appendChild(data);

    return shape;
};
SvgState.prototype.AddText_Quill = function ()
{
    if (this.TextState.RemovalId !== null)
    {
        var id = "#" + this.Id + " #" + this.TextState.RemovalId;
        $(id).remove();
        this.RemovalId = null;
    }

    var textId = this.Id + "_text";
    $("#" + textId).remove();

    var bbox = this.Private_GetFullShapeDimensions();

    var textAreaDimensions = this.TextState.Public_GetTextArea(bbox, this.ScaleX, this.ScaleY, this.NaturalOffsetX, this.NaturalOffsetY, this.IsSpringable());//, this.FlipHorizontal, this.FlipVertical);

    var svg = document.createElementNS("http://www.w3.org/2000/svg", "g");
    svg.setAttributeNS(null, "id", textId);
    svg = $("#" + this.Id).append(svg);
    svg = $("#" + this.Id).children().last();

    WordRunRenderHelper.RenderText(this.TextState.Public_GetQuillDeltas(), textAreaDimensions, svg, this.FlipHorizontal, this.FlipVertical, this.Angle);
}

SvgState.prototype.AddText = function ()
{
    if (UseQuill || UseSummerNote)
    {
        
        this.AddText_Quill();
        return;
    }
    if (this.TextState.RemovalId !== null)
    {
        var id = "#" + this.Id + " #" + this.TextState.RemovalId;
        $(id).remove();
        this.RemovalId = null;
    }

    var textId = this.Id + "_text";
    $("#" + textId).remove();

    var text = this.TextState.Text;

    // Different platforms save CRLF differently (sometimes only \r, sometimes only \n, or on Windows, always \r\n): reformalize everything to \n
    text = text.replaceAll("\r\n", "\n");
    text = text.replaceAll("\r", "\n");

    // And keep \n as a special word we'll use to force-split our lines
    text = text.replaceAll("\n", " \n ");

    // Don't care about tabs
    text = text.replaceAll("\t", " ");
    var words = text.trim().split(" ");
    var lines = new Array();

    var bbox = this.Private_GetFullShapeDimensions();

    var textAreaDimensions = this.TextState.Public_GetTextArea(bbox, this.ScaleX, this.ScaleY, this.NaturalOffsetX, this.NaturalOffsetY, this.IsSpringable());//, this.FlipHorizontal, this.FlipVertical);

    var textAlignment = (this.TextState.TextAlignment || "middle");
    //var xMiddle = textAreaDimensions.Left + (textAreaDimensions.Width / 2);
    var xOffset = 0;
    switch (textAlignment)
    {
        case "start":
            xOffset = textAreaDimensions.Left;
            break;
        case "middle":
            xOffset = textAreaDimensions.Left + (textAreaDimensions.Width / 2);
            break;
        case "end":
            xOffset = textAreaDimensions.Left + textAreaDimensions.Width;
            break;
    }

    var currentLine = "";
    var lineIndex = 0;
    var characterHeight = 0;

    var textColor = this.TextState.FontColor;
    if (textColor.indexOf("#") < 0)
        textColor = "#" + textColor;

    var style = "font-size:" + this.TextState.FontSize + "pt;font-family:" + this.TextState.Font + ";fill:" + textColor + "; text-anchor:" + textAlignment + ";";
    //font-weight:normal; font-style:normal; text-decoration:none; word-spacing:normal; letter-spacing: normal";
    var svg = document.createElementNS("http://www.w3.org/2000/svg", "g");
    svg.setAttributeNS(null, "id", textId);
    svg = $("#" + this.Id).append(svg);
    svg = $("#" + this.Id).children().last();

    characterHeight = this.TextState.FontSize / .75;
    //characterHeight += (this.TextState < 12) ? 3 : 3.75
    for (var i = 0; i < words.length; i++)
    {
        // If we run into a line termination, do so and move to the next line
        if (words[i] === "\n")
        {
            lines[lineIndex] = currentLine;
            currentLine = "";
            lineIndex++;
        } else
        {
            // Otherwise, run word-by-word processing to build the line until we run out of space
            var temp = currentLine + words[i];
            var tempTextId = this.Id + "_temp_text";
            var textBlock = this.CreateTextBlock(textAreaDimensions.Left, textAreaDimensions.Top, tempTextId, temp, style);

            svg.append(textBlock);
            var tempWidth = textBlock.getBBox().width;

            if (tempWidth > textAreaDimensions.Width)
            {
                lines[lineIndex] = currentLine;
                currentLine = words[i] + " ";
                lineIndex++;
            }
            else
            {
                currentLine += words[i] + " ";
            }

            $("#" + tempTextId).remove();
        }
    }
    lines[lineIndex] = currentLine;

    if (lines[0] == "")
        lines.shift();

    var centerVerticalText = 0;

    if (this.FlipHorizontal)
    {
        switch (textAlignment)
        {
            case "start":
                xOffset = -1 * (textAreaDimensions.Left + textAreaDimensions.Width);
                break;
            case "middle":
                xOffset = -1 * (textAreaDimensions.Left + (textAreaDimensions.Width / 2));
                break;
            case "end":
                xOffset = -1 * textAreaDimensions.Left;
                break;
        }
    }
    //            xOffset = -1 * (textAreaDimensions.Left + textAreaDimensions.Width);
    //            xMiddle *= -1;

    if (this.FlipVertical)
    {
        textAreaDimensions.Top = -1 * (textAreaDimensions.Top + textAreaDimensions.Height);
        //    characterHeight *= -1;
    }

    if (isFinite(textAreaDimensions.Height))
    {

        var heightNeeded = lines.length * characterHeight;
        if (heightNeeded < textAreaDimensions.Height)
        {
            centerVerticalText = (textAreaDimensions.Height - heightNeeded) / 2;
            //centerVerticalText -= 3.5;    // take out the top "padding space"
        }

        centerVerticalText -= (characterHeight * .25);

    }

    //if (this.FlipVertical)
    //{
    //    textAreaDimensions.Top *= -1;
    //    characterHeight *= -1;
    //}

    for (i = 0; i < lines.length; i++)
    {
        var yOffset = textAreaDimensions.Top + ((i + 1) * characterHeight) + centerVerticalText;
        var tsId = "ts_" + AddSvg.CurrentShapeIndex++;

        //if (this.FlipVertical)
        //    yOffset *= -1;

        //var textBlock = this.CreateTextBlock(xMiddle, yOffset, tsId, lines[i], style);
        var textBlock = this.CreateTextBlock(xOffset, yOffset, tsId, lines[i], style);


        svg.append(textBlock);
    }
};

SvgState.prototype.SetNaturalOffset = function (x, y)
{
    this.NaturalOffsetX = x;
    this.NaturalOffsetY = y;
};

//This is to differentiate preview colors vs saved colors
SvgState.prototype.GetSavedFontColor = function ()
{
    if (this.TextState == null)
        return null;

    return this.TextState.Public_GetSavedFontColor();
}

SvgState.prototype.GetFontColor = function ()
{
    return this.TextState.FontColor;
};

SvgState.prototype.SetFontColor = function (color, isPreview)
{
    this.TextState.Public_SetFontColor(color, isPreview);
};

SvgState.prototype.ResetFontColor = function ()
{
    try
    {
        this.TextState.Public_ResetFontColor();

        MyPointers.Controls_TextableControls_ColorSelector.spectrum("set", this.TextState.FontColor);   //this should probably not be in here... but needed to make code work
    }
    catch (e)
    {
        DebugLine("Reset Font Color: " + e);
    }
};

SvgState.prototype.GetFontSize = function ()
{
    return this.TextState.FontSize;
};

SvgState.prototype.SetFontSize = function (size)
{
    this.TextState.FontSize = size;
};

SvgState.prototype.SetFontFace = function (face)
{
    this.TextState.Font = face;
};

SvgState.prototype.GetFontFace = function ()
{
    return this.TextState.Font;
};

SvgState.prototype.GetText = function ()
{
    return this.TextState.Text;
};

SvgState.prototype.SetText = function (text)
{
    this.TextState.Text = text;
};

SvgState.prototype.GetTextAlignment = function ()
{
    return this.TextState.TextAlignment;
};

SvgState.prototype.SetTextAlignment = function (textalign)
{
    this.TextState.TextAlignment = textalign;
};

SvgState.prototype.FlipShapeHorizontal = function ()
{
    this.FlipHorizontal = !this.FlipHorizontal;
};

SvgState.prototype.FlipShapeVertical = function ()
{
    this.FlipVertical = !this.FlipVertical;
};

SvgState.prototype.MoveTo = function (x, y)
{
    this.X = x;
    this.Y = y;
};

SvgState.prototype.MoveDistance = function (x, y)
{
    this.X += x;
    this.Y += y;
};

SvgState.prototype.RotateShape = function (angle)
{
    this.Angle += angle;
    this.Angle %= 360;
};

SvgState.prototype.SetScale = function (scaleX, scaleY)
{
    this.ScaleX = scaleX;
    this.ScaleY = scaleY;
};

SvgState.prototype.ChangeScale = function (amount)
{
    this.ScaleX *= amount;
    this.ScaleY *= amount;
};

SvgState.prototype.ChangeScaleXY = function (scaleX, scaleY)
{
    this.ScaleX *= scaleX;
    this.ScaleY *= scaleY;
};

SvgState.prototype.Resize = function (scaleX, scaleY)
{
    this.ScaleX += scaleX;
    this.ScaleY += scaleY;
};

SvgState.prototype.GetBBox = function (replaceSelectionBox)
{

    this.ClearSelectionBox();
    var bb = GetGlobalById(this.Id).getBBox();

    if (this.ActivelySelected && replaceSelectionBox)
    {
        this.DrawSelectionBox();
    }


    return bb;
};

SvgState.prototype.SetLockState = function (state)
{
    this.IsLocked = state;
};

SvgState.prototype.SetActive = function (active)
{
    this.ActivelySelected = active;

    // JIRA-WEB-28 - Feels like this method fails because it tries to get an object that doesn't exist... Since we actually have the Shape object here, I'd assume $("#" + this.Id) can be found and that the item that cannot be found is: $("#" + this.Id + "_scale")
    if (active)
    {
        try
        {
            $("#" + this.Id).off('touchy-pinch').on('touchy-pinch', HandleTouchyPinch);
            $("#" + this.Id + "_scale").off('touchy-drag').on('touchy-drag', HandleTouchyDrag);
        } catch (e1)
        {
            throw e1 + " Debug: true, " + $("#" + this.Id).length + ", " + $("#" + this.Id + "_scale").length;
        }
    }
    else
    {
        try
        {
            this.Public_ResetColors();
            $("#" + this.Id).off('touchy-pinch');
            //$("#" + this.Id).unbind('touchy-rotate');
            $("#" + this.Id + "_scale").off('touchy-drag');
        } catch (e2)
        {
            throw e2 + " Debug: true, " + $("#" + this.Id).length + ", " + $("#" + this.Id + "_scale").length;
        }
    }

};

SvgState.prototype.CopyTextState = function (textState)
{
    this.TextState.Copy(textState);
};

SvgState.prototype.PopulateFromJson = function (data)
{
    //DebugLine("called here? PopluateFromJson");

    this.ActivelySelected = data.ActivelySelected;
    this.Angle = data.Angle ? data.Angle : 0;
    this.FlipHorizontal = data.FlipHorizontal;
    this.FlipVertical = data.FlipVertical;

    this.FilterColorMode = data.FilterColorMode;
    this.IsLocked = false
    try
    {
        this.IsLocked = data.IsLocked || false;
    } catch (e)
    {

    }


    this.NaturalOffsetX = data.NaturalOffsetX;
    this.NaturalOffsetY = data.NaturalOffsetY;
    this.ScaleX = data.ScaleX ? data.ScaleX : 1;
    this.ScaleY = data.ScaleY ? data.ScaleY : this.ScaleX;

    this.X = data.X ? data.X : 10;
    this.Y = data.Y ? data.Y : 10;

    this.UseClipping = data.UseClipping;
    this.ClipX = data.ClipX;
    this.ClipY = data.ClipY;
    this.ClipWidth = data.ClipWidth;
    this.ClipHeight = data.ClipHeight;

    this.GlobalImageId = data.GlobalImageId;

    this.Position = data.Position || this.Position;

    this.Movable = (data.Movable == null ? true : data.Movable);

    if (this.UseClipping == undefined || this.UseClipping == null)
    {
        this.UseClipping = false;
        this.ClipX = 0;
        this.ClipY = 0;
        this.ClipWidth = 0;
        this.ClipHeight = 0;
    }
    this.CopyTextState(data.TextState);

    this.Private_CopyColorableState(data.ColorableState);
    this.Private_CopyPosableState(data.PosableState);
    this.Private_CopySmartSceneState(data.SmartSceneState);
    this.Private_CopySpringableState(data.SpringableState);

    this.ImageAttribution = data.ImageAttribution;
};

/*Privates*/
//#region Private Helpers

//#region Pointers
SvgState.prototype.Private_GetPointer = function (svgPartEnum)
{
    // pDos , address cache

    return $("#" + this.Private_GetId(svgPartEnum));
};

SvgState.prototype.Private_GetElement = function (svgPartEnum)
{
    return GetGlobalById(this.Private_GetId(svgPartEnum));
};

SvgState.prototype.Private_GetId = function (svgPartEnum)
{
    return this.Id + svgPartEnum;
};

//#endregion

//#region Dimensions
SvgState.prototype.Private_GetFullShapeDimensions = function ()
{

    var scaleElement = this.Private_GetElement(SvgPartsEnum.Scale);
    var scaleBb;

    try
    {
        if (scaleElement == null)
        {
            LogErrorMessage("Scale element is null " + this.Private_GetId(SvgPartsEnum.Scale));
            return null;
        }
        scaleBb = scaleElement.getBBox();
    }
    catch (e)
    {
        try
        {
            LogErrorMessage("SVG CORRUPTED! Unable to get BBOX for " + this.Private_GetId(SvgPartsEnum.Scale), e);
            scaleBb = scaleElement.getBoundingClientRect();
        } catch (e2)
        {
            LogErrorMessage("SVG Really CORRUPTED! Unable to get BBOX for " + this.Private_GetId(SvgPartsEnum.Scale), e);
            var dimensions = new Object();
            dimensions.width = 5;;
            dimensions.height = 5;;
            return dimensions;
        }

    }

    var dimensions = new Object();
    dimensions.width = scaleBb.width * this.ScaleX;
    dimensions.height = scaleBb.height * this.ScaleY;

    if (dimensions.width < 5)
        dimensions.width = 5;

    if (dimensions.height < 5)
        dimensions.height = 5;

    return dimensions;
};

// takes 
SvgState.prototype.Public_GetVisibleShapeDimensions = function ()
{
    if (this.UseClipping)
    {
        var dimensions = new Object();
        dimensions.height = this.ClipHeight * this.ScaleY;
        dimensions.width = this.ClipWidth * this.ScaleX;

        if (dimensions.width < 5)
            dimensions.width = 5;

        if (dimensions.height < 5)
            dimensions.height = 5;

        return dimensions;
    }

    return this.Private_GetFullShapeDimensions();
};
 
SvgState.prototype.ConvertCoordinateToBase =function ( P , cen )
{ 
    if( this.FlipHorizontal )
        P.x += cen.x * 2 ; // boxarea.width
    // go center of circle 
    P = { x: P.x - cen.x , y: P.y - cen.y }; 
    // rotate alpha
    P = {  x:  P.x * Math.cos( this.Angle * Math.PI / 180.0 ) - P.y * Math.sin( this.Angle * Math.PI / 180.0 ), // rotate original
            y:  P.x * Math.sin( this.Angle * Math.PI / 180.0 ) + P.y * Math.cos( this.Angle * Math.PI / 180.0 ) }; 
    // go origin
    P = { x: P.x + cen.x , y: P.y + cen.y }; 
    // scale back
    P = { x: P.x + this.X , y: P.y + this.Y };

    
    
    
    return P;
};

SvgState.prototype.Public_GetImaginaryOuterPoints =function ()
{ 
    var boxArea = this.Private_GetSelectionBoxArea(0);
 

    var cen = { x : boxArea.Width / 2   , y : boxArea.Height / 2 };
    var flipPush = 0; 

    var corners = [ { x : boxArea.Left  , y : boxArea.Top} ,    // NW
                    { x : boxArea.Right  , y : boxArea.Top} ,    // NE
                    { x : boxArea.Left  , y : boxArea.Bottom} , // SW
                    { x : boxArea.Right , y : boxArea.Bottom}]; // SE
    
    var resPoints = new Array();

    for( i = 0 ; i < corners.length; i++  )
        resPoints[i] = this.ConvertCoordinateToBase( corners[i] , cen );

    // 8 points in stage
    return resPoints;
}


SvgState.prototype.Public_GetImaginaryOuterBox = function ()
{
    var outerPoints = this.Public_GetImaginaryOuterPoints();
 
    var i ;
    var sTop  = outerPoints[0].y , sBottom = outerPoints[0].y;
    var sLeft = outerPoints[0].x , sRight  = outerPoints[0].x;

    for( i = 1 ; i < outerPoints.length; i++  )
    {
        sTop    = Math.min( sTop     , outerPoints[i].y );
        sBottom = Math.max( sBottom  , outerPoints[i].y );
        sLeft   = Math.min( sLeft    , outerPoints[i].x );
        sRight  = Math.max( sRight   , outerPoints[i].x );
    }
    var res = { Top: sTop, Bottom: sBottom, Left: sLeft, Right: sRight };
    return res;
};


//#endregion

//#endregion

SvgState.prototype.UpdateCropping = function ()
{
   // var cropGroup = this.Private_GetPointer(SvgPartsEnum.CropGroup);
    
    
    if (this.UseClipping)
    {
        
        this.Private_AddClipArea(); 

        switch( this.CropType )
        {
            case CropTypeEnum.Standard:
                {
                    var clipRect = GetGlobalById(this.Private_GetId(SvgPartsEnum.ClipRect));

                    clipRect.setAttributeNS(null, "x", this.ClipX);
                    clipRect.setAttributeNS(null, "y", this.ClipY);
                    clipRect.setAttributeNS(null, "width", this.ClipWidth);
                    clipRect.setAttributeNS(null, "height", this.ClipHeight);           
                }
                break;
            case CropTypeEnum.Advanced:
               { 
                    var clipPolygon = GetGlobalById(this.Private_GetId(SvgPartsEnum.ClipPolygon));
                    var i;
                    var pStr = '';
                    

                    for( i = 0 ; i < this.CropPolygonPoint.length; i++ )   
                        pStr = pStr + ' ' + this.CropPolygonPoint[i].x + "," + this.CropPolygonPoint[i].y; 
 
                    clipPolygon.setAttributeNS( null, "points", pStr );
                }
                break;
            case CropTypeEnum.Circle:
                {
                    var clipEllipse = GetGlobalById(this.Private_GetId(SvgPartsEnum.ClipEllipse));
                     
                    clipEllipse.setAttributeNS( null, "cx", this.ClipX + this.ClipWidth / 2 );
                    clipEllipse.setAttributeNS( null, "cy", this.ClipY + this.ClipHeight / 2 );
                    clipEllipse.setAttributeNS( null, "rx", this.ClipWidth / 2 );
                    clipEllipse.setAttributeNS( null, "ry", this.ClipHeight / 2 );
                }
                break;
        }
 
        var x = GetGlobalById(this.Private_GetId(SvgPartsEnum.Defs) );
        var xx = null;
 
        if( x )
        {
            xx = x.cloneNode(true);
            x.parentNode.removeChild(x); 
        }
        
        var y = GetGlobalById(this.Private_GetId(SvgPartsEnum.Scale) );
        if( y && xx )
            y.insertBefore( xx , y.childNodes[0] );
 
        var cropGroupObj = GetGlobalById(this.Private_GetId(SvgPartsEnum.CropGroup));
        if( cropGroupObj )
        {
            cropGroupObj.removeAttribute("clip-path");
            cropGroupObj.setAttribute("clip-path", "url(#" + this.Private_GetId(SvgPartsEnum.ClipPath) + ")");
        }
        //end reset
    }
    else
    {
        var cropGroupObj = GetGlobalById(this.Private_GetId(SvgPartsEnum.CropGroup));
        if( cropGroupObj )
            cropGroupObj.removeAttribute("clip-path");
        
    }

};


SvgState.prototype.Private_AddClipArea = function ()
{
    var scaleObj = GetGlobalById( this.Private_GetId(SvgPartsEnum.Scale) );
    var defsObj  = GetGlobalById( this.Private_GetId(SvgPartsEnum.Defs) );

    if ( defsObj == null )
    {
        //  defs = SvgCreator.CreateDefs(this.Private_GetId(SvgPartsEnum.Defs));
        defsObj = SvgCreator.CreateSvgGroup(this.Private_GetId(SvgPartsEnum.Defs));
        scaleObj.appendChild( defsObj ); 
    }

    var cropGroupObj = GetGlobalById( this.Private_GetId(SvgPartsEnum.CropGroup) );
    if ( cropGroupObj == null )
    {
        cropGroupObj = SvgCreator.CreateSvgGroup(this.Private_GetId(SvgPartsEnum.CropGroup));
        var natural = GetGlobalById( this.Private_GetId(SvgPartsEnum.Natural) );
        scaleObj.appendChild( cropGroupObj );
        cropGroupObj = GetGlobalById( this.Private_GetId(SvgPartsEnum.CropGroup) );
        cropGroupObj.appendChild(natural);
    }

    var clipPathObj = GetGlobalById( this.Private_GetId(SvgPartsEnum.ClipPath) ); // Oh my GOd , this is pointer 
    if (clipPathObj == null)
    {
        clipPathObj = SvgCreator.CreateClipPath(this.Private_GetId(SvgPartsEnum.ClipPath));
        defsObj.appendChild(clipPathObj);
        clipPathObj = GetGlobalById( this.Private_GetId(SvgPartsEnum.ClipPath) ); 
    }

    switch( this.CropType )
    {
        case CropTypeEnum.Standard:
            {
                // remove other part clip box
                var clipPolygon = GetGlobalById( this.Private_GetId(SvgPartsEnum.ClipPolygon) );
                if( clipPolygon ) clipPathObj.removeChild( clipPolygon );
                var clipEllipse = GetGlobalById( this.Private_GetId(SvgPartsEnum.ClipEllipse) );
                if( clipEllipse ) clipPathObj.removeChild( clipEllipse );
                

                var clipRectObj = GetGlobalById( this.Private_GetId( SvgPartsEnum.ClipRect ) );
                if( clipRectObj == null )
                { 
                    clipRectObj = SvgCreator.AddRect(this.ClipX, this.ClipY, this.ClipWidth, this.ClipHeight, "black", "black", "solid", ".5", this.Private_GetId(SvgPartsEnum.ClipRect));
                    clipPathObj.appendChild(clipRectObj);
                }
                
            }
            break;
        case CropTypeEnum.Advanced:
            { 
                var clipRect = GetGlobalById( this.Private_GetId(SvgPartsEnum.ClipRect) );
                if( clipRect ) clipPathObj.removeChild( clipRect );                    
                var clipEllipse = GetGlobalById( this.Private_GetId(SvgPartsEnum.ClipEllipse) );
                if( clipEllipse ) clipPathObj.removeChild( clipEllipse );
                var clipPolygon = GetGlobalById( this.Private_GetId( SvgPartsEnum.ClipPolygon ) );

                if ( clipPolygon == null ) 
                {
                    clipPolygon = SvgCreator.AddPolygon(this.CropPolygonPoint , "black", "black", "solid", 1 , ".5" , this.Private_GetId(SvgPartsEnum.ClipPolygon));
                    clipPathObj.appendChild(clipPolygon);
                }
            }
            break;

        case CropTypeEnum.Circle:
            {
                var clipRect = GetGlobalById( this.Private_GetId(SvgPartsEnum.ClipRect) );
                if( clipRect ) clipPathObj.removeChild( clipRect );                    
                var clipPolygon = GetGlobalById( this.Private_GetId(SvgPartsEnum.ClipPolygon) );
                if( clipPolygon ) clipPathObj.removeChild( clipPolygon );

                var clipEllipse = GetGlobalById( this.Private_GetId( SvgPartsEnum.ClipEllipse ) );
                if (  clipEllipse == null ) 
                {
                    clipEllipse = SvgCreator.AddEllipse( this.ClipX + this.ClipWidth / 2 ,this.ClipY + this.ClipHeight / 2 ,
                        this.ClipWidth / 2  ,this.ClipHeight / 2 ,"black", "red", "4,4", ".25", this.Private_GetId(SvgPartsEnum.ClipEllipse));
                    clipPathObj.appendChild(clipEllipse);
                }
            }
            break;

    }
  
};

// we may need this code later, not used now - 4/29/13
SvgState.prototype.GiveSvgId = function ()
{
    var svgImage = this.Private_GetPointer(SvgPartsEnum.SvgImage);

    if (svgImage === null || svgImage.length == 0)
    {
        natural.children().first().attr("id", this.Private_GetId(SvgPartsEnum.SvgImage));
    }

};

SvgState.prototype.Private_ClearMetaData = function ()
{
    var md = $("#" + this.Id).find("sbtdata");
    if (md.length == 0)
        return;
    md.remove();
};



SvgState.prototype.Private_ResetNaturalOffset = function ()
{
    var naturalOffsetG = this.Private_GetElement(SvgPartsEnum.Natural);
    var bbox = naturalOffsetG.getBBox();

    var deltaX = this.NaturalOffsetX - bbox.x;
    var deltaY = this.NaturalOffsetY - bbox.y;

    this.NaturalOffsetX = bbox.x;
    this.NaturalOffsetY = bbox.y;

    if (this.FlipHorizontal)
        deltaX *= -1;

    this.X -= (deltaX * this.ScaleX);
    this.Y -= (deltaY * this.ScaleY);

};

SvgState.prototype.Private_CopySmartSceneState = function (smartSceneState)
{
    //this.PosableState.Position = this.Position;
    if (smartSceneState == null)
        return;

    this.SmartSceneState.CopySmartSceneState(smartSceneState, this.ColorableState);

};

SvgState.prototype.Private_CopyPosableState = function (posableState)
{
    //this.PosableState.Position = this.Position;
    if (posableState == null)
        return;

    posableState.Position = posableState.Position || this.Position;
    this.PosableState.Public_Copy(posableState);

};

SvgState.prototype.Public_IsPosable = function ()
{
    if (this.PosableState == null)
        return false;

    return this.PosableState.Public_IsPosable();
};

SvgState.prototype.Public_IsInstaPosable = function ()
{
    if (this.Public_IsPosable == false)
        return false;

    var poseGroups = this.PosableState.Public_PoseGroups();
    if (poseGroups == null || poseGroups.length < 3)
        return false;

    return true;
};



SvgState.prototype.Public_GetPoseGroups = function ()
{
    if (this.Public_IsPosable() == false)
        return null;

    return this.PosableState.Public_PoseGroups();
};

SvgState.prototype.Public_GetPreviousPoseList = function ()
{
    if (this.Public_IsPosable() == false)
        return null;

    return this.PosableState.Public_GetPreviousPoseList();
};


SvgState.prototype.Public_GetPoseGroupList = function ()
{
    var poseGroupList = new Array();

    var poseGroups = this.Public_GetPoseGroups();

    for (var i = 0; i < poseGroups.length; i++)
    {
        var poseGroup = poseGroups[i];
        poseGroupList.push({ PoseType: poseGroup.PoseType, PoseId: poseGroup.Public_GetActiveOption().Public_GetInternalId() });
    }

    return poseGroupList;
};

SvgState.prototype.Public_UpdatePoseOption = function (pose, poseOption)
{
    if (this.Public_IsPosable() == false)
        return;

    this.PosableState.Public_UpdatePoseOption(pose, poseOption);
    //this.PosableState.Public_CharacterLibrarySwap(swapPose, poseOption);

    this.Private_ResetNaturalOffset();
    this.Public_ResetColors();
    //  this.DrawSelectionBox();
    this.UpdateDrawing();
};

SvgState.prototype.Public_GetPose = function (instaPose)
{
    if (this.Public_IsPosable() == false)
        return null;

    return this.PosableState.Public_GetPose(instaPose);
};

SvgState.prototype.Public_GetSafePoseArray = function (poseList)
{
    if (poseList == null || this.Public_IsPosable() == false)
        return null;

    return this.PosableState.Public_GetSafePoseArray(poseList);
};

SvgState.prototype.Public_SetPreviousPoseList = function (previousPoseList)
{
    if (this.Public_IsPosable() == false)
        return;

    this.PosableState.Public_SetPreviousPoseList(previousPoseList);
};

SvgState.prototype.Public_BulkUpdatePoseGroups = function (poseArray)
{
    if (poseArray == null)
        return;

    for (var i = 0; i < poseArray.length; i++)
    {
        var poseGroup = poseArray[i].PoseGroup;
        var poseOption = poseArray[i].PoseOption;

        this.Public_UpdatePoseOption(poseGroup, poseOption);
    }

    this.UpdateDrawing();
};

SvgState.prototype.Public_HandleCellExpansion = function (scaleAmount, oldShapeLocation, newShapeLocation)
{
    if (this.Movable == false)
        return;

    var scaleX = scaleAmount;
    var scaleY = scaleAmount;

    if (oldShapeLocation != null && newShapeLocation != null)
    {
        var scaleLeftX = newShapeLocation.X / oldShapeLocation.X;
        var scaleTopY = newShapeLocation.Y / oldShapeLocation.Y;

        var scaleRightX = (newShapeLocation.X + newShapeLocation.Width) / (oldShapeLocation.X + oldShapeLocation.Width);
        var scaleBottomY = (newShapeLocation.Y + newShapeLocation.Height) / (oldShapeLocation.Y + oldShapeLocation.Height);

        var scaleMidX = (scaleLeftX + scaleRightX) / 2;
        var scaleMidY = (scaleTopY + scaleBottomY) / 2;



        //TODO : this may be a better algorythm
        //var xPercent = (this.X - oldShapeLocation.X) / oldShapeLocation.Width;
        //scaleX = ((1 - xPercent) * scaleLeftX) + (xPercent * scaleRightX);
        //scaleX = ((1 - xPercent) * scaleRightX) + (xPercent * scaleLeftX);

        if (this.X < oldShapeLocation.X + oldShapeLocation.Width * .25)
            scaleX = scaleLeftX;

        else if (this.X > oldShapeLocation.X + oldShapeLocation.Width * .25 && this.X < oldShapeLocation.X + oldShapeLocation.Width * .75)
            scaleX = scaleMidX;

        else if (this.X > oldShapeLocation.X + oldShapeLocation.Width * .75)
            scaleX = scaleRightX;


        if (this.Y < oldShapeLocation.Y + oldShapeLocation.Height * .25)
            scaleY = scaleTopY;

        else if (this.Y > oldShapeLocation.Y + oldShapeLocation.Height * .25 && this.Y < oldShapeLocation.Y + oldShapeLocation.Height * .75)
            scaleY = scaleMidY;

        else if (this.Y > oldShapeLocation.Y + oldShapeLocation.Height * .75)
            scaleY = scaleBottomY;
    }

    // DebugLine("HCE: scaleXs: " + scaleAmount + ", " + scaleLeftX + ", " + scaleRightX + ", " + scaleMidX + "   ScaleYs: " + scaleAmount + ", " + scaleTopY + ", " + scaleBottomY + ", " + scaleMidY);
    //DebugLine("Handle Cell Expansion: " + this.Id + "amount: " + scaleAmount + "vs calc %:" + (newShapeLocation.X/oldShapeLocation.X) + " " + this.X + "," + this.Y + " vs: " + (this.X - (this.X * scaleAmount)) + "," + (this.Y -(this.Y * scaleAmount)) + "  vs: " + deltaX + " " + deltaY);

    this.X *= scaleX;
    this.Y *= scaleY;

    this.ScaleX *= scaleAmount;
    this.ScaleY *= scaleAmount;


    this.UpdateDrawing();
};
