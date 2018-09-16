function StoryboardGridLayout(enableTitle, enableDescription,scale)
{
    BaseStoryboardLayout.call(this, enableTitle, enableDescription, scale,12);

    this.LayoutType = StoryboardLayoutType.StoryboardGrid;
};

inheritPrototype(StoryboardGridLayout, BaseStoryboardLayout);