function MovieLayout(enableTitle, enableDescription,scale)
{
    BaseStoryboardLayout.call(this, enableTitle, enableDescription, scale,12);

    this.LayoutType = StoryboardLayoutType.Movie;

    this.CellWidth = this.CellHeight * (16 / 9);
    this.UnscaledCellWidth = 597.333;

    //#endregion



    //#region "Constructor"
    //#endregion 
};

inheritPrototype(MovieLayout, BaseStoryboardLayout);

MovieLayout.prototype.GetScale = function ()
{
    return this.CellHeight / 336;
};