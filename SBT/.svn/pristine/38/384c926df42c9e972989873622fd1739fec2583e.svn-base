function RotateImageAction()
{
    this.ShapeStateBeingRotated = null;

    this.MouseRotateX = null; 
    this.MouseRotateY = null; 
    this.UndoRotateAngle = null;

    this.ResetRotateImageAction = function (shapeState, e)
    {
        this.ShapeStateBeingRotated = shapeState;

        this.MouseRotateX = PageXtoStoryboardX(e.pageX);
        this.MouseRotateY = PageYtoStoryboardY(e.pageY);
        this.UndoRotateAngle = this.ShapeStateBeingRotated.Angle;
    };

    this.CalculateRotationAngle = function (e)
    {
        var bb = this.ShapeStateBeingRotated.Public_GetVisibleShapeDimensions();
        var width = bb.width; 
        var height = bb.height; 

        var offsetX = PageXtoStoryboardX(e.pageX);
        var offsetY = PageYtoStoryboardY(e.pageY);
        
        var centerX = this.ShapeStateBeingRotated.Property_VisibleX() + (width / 2);
        var centerY = this.ShapeStateBeingRotated.Property_VisibleY() + (height / 2);

        var angle = SbtMath.CalculateAngle(centerX, centerY, offsetX, offsetY, this.MouseRotateX, this.MouseRotateY);

        this.MouseRotateX = offsetX;
        this.MouseRotateY = offsetY;

        return angle;
    };

    this.Public_TotalAngleRotation = function ()
    {
        var delta = this.ShapeStateBeingRotated.Angle - this.UndoRotateAngle;
        delta %=360;

        return delta;
    };
}