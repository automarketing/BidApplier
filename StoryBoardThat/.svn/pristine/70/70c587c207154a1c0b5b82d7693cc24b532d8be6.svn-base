var MarkerFilter = function ()
{
    var MarkerFilterObject = new Object();

    function getcolorValues(color)
    {
        if (color === '')
            return;
        if (color.toLowerCase() === 'transparent')
            return [0, 0, 0, 0];
        if (color[0] === '#')
        {
            if (color.length < 7)
            {
                // convert #RGB and #RGBA to #RRGGBB and #RRGGBBAA
                color = '#' + color[1] + color[1] + color[2] + color[2] + color[3] + color[3] + (color.length > 4 ? color[4] + color[4] : '');
            }
            return [parseInt(color.substr(1, 2), 16),
            parseInt(color.substr(3, 2), 16),
            parseInt(color.substr(5, 2), 16),
            color.length > 7 ? parseInt(color.substr(7, 2), 16) / 255 : 1];
        }
        if (color.indexOf('rgb') === -1)
        {
            // convert named colors
            var temp_elem = document.body.appendChild(document.createElement('fictum')); // intentionally use unknown tag to lower chances of css rule override with !important
            var flag = 'rgb(1, 2, 3)'; // this flag tested on chrome 59, ff 53, ie9, ie10, ie11, edge 14
            temp_elem.style.color = flag;
            if (temp_elem.style.color !== flag)
                return; // color set failed - some monstrous css rule is probably taking over the color of our object
            temp_elem.style.color = color;
            if (temp_elem.style.color === flag || temp_elem.style.color === '')
                return; // color parse failed
            color = getComputedStyle(temp_elem).color;
            document.body.removeChild(temp_elem);
        }
        if (color.indexOf('rgb') === 0)
        {
            if (color.indexOf('rgba') === -1)
                color += ',1'; // convert 'rgb(R,G,B)' to 'rgb(R,G,B)A' which looks awful but will pass the regxep below
            return color.match(/[\.\d]+/g).map(function (a)
            {
                return +a
            });
        }
    };

    var xConv = 0.2126;
    var yConv = 0.7152;
    var zConv = 0.0722;

    function colorValues(color)
    {
        var x = getcolorValues(color);

        if (x != undefined)
            return Math.round((x[0] * xConv + x[1] * yConv + x[2] * zConv));
        //return (x[0]+ x[1] + x[2] ) / 3;


        else return 0;
    };

    function ToMarkerFilter(shapeState, thickness, removeNoFill)
    {
        var svgId = shapeState.Id;
        var max_col = colorValues('#000000');
        var min_col = colorValues('#ffffff');

        try 
        {
            var colorRegions = shapeState.Public_GetColorRegions();
            for (var i = 0; i < colorRegions.length; i++)
            {
                var newColor = colorValues(shapeState.Public_GetColorForRegion(colorRegions[i]));
                newColor = Math.round(Math.sqrt(newColor / 255.0) * 255.0);
                newColor = "rgb(" + newColor + ", " + newColor + ", " + newColor + ")";

                shapeState.Public_SetColorForRegion(colorRegions[i], newColor, false, false);

            }
        }
        catch (e)
        {
            LogErrorMessage("ToMarkerFilter", e);

        }



        var rrType = ['path', 'polygon', 'rect', 'ellipse'];

        for (var j = 0; j < rrType.length; j++)
        {
            var items = $("#" + svgId)[0].getElementsByTagName(rrType[j]);
            //  console.log(iterms.length);
            for (var i = 0; i < items.length; i++)
            {
                //iterms[i].style("stroke-width", 6);
                //console.log( iterms[i] );
                items[i].setAttributeNS(null, 'stroke-width', thickness);
                // 'rb' 
                items[i].setAttributeNS(null, 'stroke', 'rgb(12,12,12)');

                if (items[i].getAttributeNS(null, 'fill') == null)
                    continue;

                if (removeNoFill)
                {
                    if (items[i].getAttributeNS(null, 'opacity') != null)
                    {
                        items[i].setAttributeNS(null, 'fill', "none");
                        items[i].setAttributeNS(null, 'stroke-width', 0);
                        continue;
                    }
                    if (items[i].getAttributeNS(null, 'fill') == 'none')
                    {
                        items[i].setAttributeNS(null, 'stroke-width', 0);
                        continue;
                    }
                }

                var v = colorValues(items[i].getAttributeNS(null, 'fill'));

                y = Math.round(Math.sqrt(v / 255.0) * 255.0);
                //console.log(y);
                items[i].setAttributeNS(null, 'fill', 'rgb(' + y + ',' + y + ',' + y + ')');

                //console.log( iterms[i].getAttributeNS( null, 'fill' ) );
            }
        }
    };

    MarkerFilterObject.TestMarker = function ()
    {
        var thickness = 3.5// $("#marker-thickness").val();
        var ignoreNoFill = true; //$("#remove-no-fill").prop('checked');

        var selectedShapes = MyShapesState.Public_GetAllSelectedShapeStates();
        for (var i = 0; i < selectedShapes.length; i++)
        {
            var shapeState = selectedShapes[i];

            //var svgId = shapeState.Id;
            //shapeState.ColorableState = null;

            ToMarkerFilter(shapeState, thickness, ignoreNoFill);
        }
    };
        
    return MarkerFilterObject;
}();