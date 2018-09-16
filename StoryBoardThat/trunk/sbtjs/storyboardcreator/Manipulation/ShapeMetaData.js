function ShapeMetaData()
{

    this.LookForMetaData = function (id)
    { 
        var metaData = $("#" + id).find("sbtdata");
        if (metaData.length == 0)
            return;

        try
        {


            var colorables = metaData.find("colorable");
            for (var i = 0; i < colorables.length; i++)
            {
                var region = colorables[i].getAttributeNS("", "region");
                if (region.length === 0)
                    region = colorables[i].getAttributeNS("", "Region");

                var secretColor = colorables[i].getAttributeNS("", "secretcolor");
                if (secretColor.length === 0)
                    secretColor = colorables[i].getAttributeNS("", "SecretColor");

                var replaceColor = colorables[i].getAttributeNS("", "replacecolor");
                if (replaceColor.length === 0)
                    replaceColor = colorables[i].getAttributeNS("", "ReplaceColor");

                this.Private_ExtractColors(id, secretColor, replaceColor, region);
            }
        } catch (e)
        {
            LogErrorMessage("ShapeMetaData.LookForMetaData.Colorables", e);
        }

        var globalImageId = null;
        try
        {

            var svgRoot = $("#" + id).children().first();
            if (svgRoot.prop('tagName') != 'svg')
            {
                svgRoot = metaData.closest("svg");
            }

            globalImageId = metaData.attr(SbtDataEnum.AttributeGlobalImageId);
            var position = metaData.attr(SbtDataEnum.MetaData_Position);

            var posable = metaData.find(SbtDataEnum.MetaData_Posable);
            var poses = posable.find(SbtDataEnum.MetaData_Poses);

            if (globalImageId == null && poses != null && poses.length > 0)
            {
                //DebugLine("Missing Global Image Id");
            }
            for (var i = 0; i < poses.length; i++)
            {
                var poseType = GetSafeAttributeNS(poses[i], SbtDataEnum.Attribute_Pose_Type);
                if (LowerCaseCompare(poseType, SbtDataEnum.PoseType_LibrarySwap))
                {
                    var defaultSwapId = GetSafeAttributeNS(poses[i], SbtDataEnum.Attribute_LibrarySwapPose_DefaultId);
                    var startPointId = GetSafeAttributeNS(poses[i], SbtDataEnum.Attribute_LibrarySwapPose_StartPointId);
                    var appendToId = GetSafeAttributeNS(poses[i], SbtDataEnum.Attribute_LibrarySwapPose_AppendToId);

                    this.Private_GlobalLibrarySwap(svgRoot, defaultSwapId, startPointId, appendToId, globalImageId, position);
                }
            }
        } catch (e)
        {
            try
            {
                LogErrorMessage("ShapeMetaData.LookForMetaData.Posables GUID:  " + globalImageId, e);
            } catch (g)
            {
                LogErrorMessage("ShapeMetaData.LookForMetaData.Posables: ", e);
            }

        }

    };

    this.Private_ExtractColors = function (id, secretColor, replaceColor, region)
    {
        var shape = $("#" + id);
        var filter = "[fill=\"" + secretColor + "\"]";
        var toBeUpdated = shape.find(filter);

        // this is for IE
        if (toBeUpdated.length === 0)
        {
            filter = "[fill=\"" + secretColor.toLowerCase() + "\"]";
            toBeUpdated = shape.find(filter);
        }

        //this is for EDGE in ... JUNE OF 2017!!! fuck Edge is an embarassment - ABS 6/13/17
        if (toBeUpdated.length === 0)
        {
            filter = "[FILL=\"" + secretColor.toLowerCase() + "\"]";
            toBeUpdated = shape.find(filter);
        }

        for (var i = 0; i < toBeUpdated.length; i++)
        {
            var colorId = region + "_" + id + "_" + i;
            toBeUpdated[i].setAttributeNS(null, "fill", replaceColor)
            toBeUpdated[i].setAttributeNS(null, "id", colorId);
        }
    };

    //SUCKS this is 95% the same as PosableState.Private_GlobalLibrarySwap abs 4-18-14
    this.Private_GlobalLibrarySwap = function (svgRoot, librarySwapId, startPointId, appentToId, globalImageId, position)
    {
        var clonePart = MyGlobalSwapLibrary.Public_GetSvgById(librarySwapId, position);
        if (clonePart == null)
        {
            //DebugLine("Bad swap: " + globalImageId + " : " + librarySwapId);
        }
        clonePart = clonePart.clone();

        var appendTo = svgRoot.find("#" + appentToId);

        //var positionPoint = GetGlobalById(libraryPose.Public_StartPointId);

        appendTo.children().remove();

        appendTo.append(clonePart);

        var clonePartId = "gls_" + new Date().getTime();    //This should probably be gsl.. but code works.. ABS 7/1/14
        clonePart.attr("id", clonePartId);

        RecursivelyUpdateChildrenIds(clonePart, SbtDataEnum.GlobalLibraryId, globalImageId);

        var clonePartElement = GetGlobalById(clonePartId);
        var bbox = clonePartElement.getBBox();

        var positionPoints = ExtractPositionPoint(svgRoot.find("#" + startPointId));

        var translateX = positionPoints.X - bbox.x;
        var translateY = positionPoints.Y - bbox.y;

        clonePart.attr("transform", "translate(" + translateX + ", " + translateY + ")");
    };

}