/// <reference path="SvgManip.js" />

function SbtMathLibrary()
{

    this.DegreesFromRadians =function(radians)
    {
        return radians * (180 / Math.PI);
    };

    this.ProjectAtoB = function(a , b)
    {
        var bsquare = b.x * b.x + b.y * b.y ;
        var alpha = ( a.x * b.x + a.y * b.y ) / bsquare;
        return { x: alpha * b.x , y : alpha * b.y };
    };

    this.ProjectAtoBScale = function(a , b)
    {
        var bsquare = b.x * b.x + b.y * b.y ;
        var alpha = ( a.x * b.x + a.y * b.y ) / bsquare;
        return alpha;
    };

    this.CosAngleBetweenVector = function( v1 , v2 )
    {
        var v1norm = Math.sqrt( v1.x * v1.x + v1.y * v1.y );
        var v2norm = Math.sqrt( v2.x * v2.x + v2.y * v2.y );
        return ( v1.x * v2.x + v1.y * v2.y ) / ( v1.norm * v2.norm )
    };

    this.CalculateAngle = function (centerX, centerY, newX, newY, oldX, oldY)
    {
        var angle = 2;

        var lengthLastPoint = centerX - oldX;
        var heightLastPoint = centerY - oldY;
        var hypotonuseLastPoint = Math.sqrt((lengthLastPoint * lengthLastPoint) + (heightLastPoint * heightLastPoint));
        var radiansLastPoint = Math.asin(heightLastPoint / hypotonuseLastPoint);
        var angleLastPoint = this.DegreesFromRadians(radiansLastPoint);

        var lengthNewPoint = centerX - newX;
        var heightNewPoint = centerY - newY;
        var hypotonuseNewPoint = Math.sqrt((lengthNewPoint * lengthNewPoint) + (heightNewPoint * heightNewPoint));
        var radiansNewPoint = Math.asin(heightNewPoint / hypotonuseNewPoint);
        var angleNewPoint = this.DegreesFromRadians(radiansNewPoint);
        //LogDebug(angleNewPoint + " - cx:" + centerX + " cy: " + centerY + " nx:" + newX + " ny: " + newY);

        angle = angleLastPoint - angleNewPoint;

        if (newX < centerX)
        {
            angle = angle * -1;
        }

        return angle;
    };

    //Todo - move LOTS of code to use this... have re-written so many time... abs 6/27/14
    this.ScaleAndCenter=function(elementId, maxWidth, maxHeight, xPadding, yPadding)
    {
        var bb = GetGlobalById(elementId).getBBox();
        var xScale = (maxWidth - xPadding) / bb.width;
        var yScale = (maxHeight - yPadding) / bb.height;
        var scale = Math.min(xScale, yScale);

        var centerX = (maxWidth - ((bb.width) * scale)) / 2;
        centerX -= (bb.x * scale);      //does the "natural offset"

        var centerY = (maxHeight - ((bb.height) * scale)) / 2;
        centerY -= (bb.y * scale);

        var retVal = new Object();
        retVal.CenterX = centerX;
        retVal.CenterY = centerY;
        retVal.Scale = scale;

        return retVal;
    }
}