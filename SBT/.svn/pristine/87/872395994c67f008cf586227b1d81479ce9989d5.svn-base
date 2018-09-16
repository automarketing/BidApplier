function MoveShapeAction()
{
    this.UndoMoveX = null;
    this.UndoMoveY = null;

    this.MouseMoveOffsetX=0;
    this.MouseMoveOffsetY=0;

    this.Public_ClearAction = function ()
    {
        this.UndoMoveX = null;
        this.UndoMoveY = null;
        this.MouseMoveOffsetX = 0;
        this.MouseMoveOffsetY = 0;

    };

    this.Public_UpdateMouseMoveOffsets = function (x, y)
    {
        this.MouseMoveOffsetX = x;
        this.MouseMoveOffsetY = y;
    };

    this.Public_UpdateUndos = function (x, y)
    {
        this.UndoMoveX = x;
        this.UndoMoveY = y;
    };
}
