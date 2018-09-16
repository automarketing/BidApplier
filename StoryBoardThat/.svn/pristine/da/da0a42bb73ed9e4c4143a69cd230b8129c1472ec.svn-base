// Singleton to manage adding raw SVG to tabs or the storyboard

var SvgCloner = function ()
{
    var SvgClonerObject = new Object();

    // destinationAreaId = PoseAreaSvg
    // sourceId = activeShape.Id
    // newItemId = this.Private_PoseId
    // width = this.Private_PoseWidth
    // height = this.Private_PoseHeight

    SvgClonerObject.CloneSvg = function (destinationAreaId, sourceId, newItemId, width, height)
    {
        var destinationAreaSvg = $("#" + destinationAreaId);

        var clone = $("#" + sourceId).clone();

        StoryboardContainer.UpdateGradientIds(clone);

        clone.attr("id", newItemId);

        var childrenIds = new Array();
        RecursivelyFindChildrenIds(clone, childrenIds);
        for (var i = 0; i < childrenIds.length; i++)
        {
            var oldId = childrenIds[i];
            var newId = oldId.replaceAll(sourceId, newItemId);

            FindAndUpdateId(newItemId, oldId, newId)
        }

        clone.attr("id", newItemId);
        clone.attr("class", "");

        // Remove selection box and clip-path defs if present
        clone.find("[id$='selection_box'], [id$='_defs']").remove();

        // If there is a crop-group, reset it
        clone.find("[id$='cropGroup']").removeAttr("clip-path").attr("id", newItemId + "_cropGroup");

        var scale = clone.find("[id$='_scale']").attr("id", newItemId + "_scale");
        clone.find("[id$='_natural']").attr("id", newItemId + "_natural");

        scale.attr("transform", "scale(1,1)");

        destinationAreaSvg.children().remove();

        destinationAreaSvg.attr("width", width);
        destinationAreaSvg.attr("height", height);

        destinationAreaSvg.append(clone);
        var bb = GetGlobalById(newItemId).getBBox();
        var xScale = (width - 5) / bb.width;
        var yScale = (height - 5) / bb.height;

        var minScale = Math.min(xScale, yScale);
        //this.CropViewScale = 1;
        scale.attr("transform", "scale(" + minScale + ")");

        var centerX = (width - ((bb.width) * minScale)) / 2;
        centerX -= (bb.x * minScale);      //does the "natural offset"

        var centerY = (height - ((bb.height) * minScale)) / 2;
        centerY -= (bb.y * minScale);

        // NO FUCKING clue why this needs to happen here... but the bounding box of the svg is getting moved...  i feel like this happened elsewhere and we solved it...  is it due to bootstrap modal windows? //abs 1/13/14
        clone.attr("transform", "translate(" + centerX + ", " + centerY + ")");
    };

    return SvgClonerObject;
}();