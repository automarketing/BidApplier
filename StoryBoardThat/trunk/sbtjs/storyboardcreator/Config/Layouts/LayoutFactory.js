function LayoutFactory()
{
    this.GetLayout = function (layout, enableTitle, enableDescription, scale, layoutConfig)
    {
        if (layout == StoryboardLayoutType.StoryboardGrid)
            return new StoryboardGridLayout(enableTitle, enableDescription, scale, layoutConfig);

        if (layout == StoryboardLayoutType.TChart)
            return new TChartLayout(enableTitle, enableDescription, scale, layoutConfig);

        if (layout == StoryboardLayoutType.Frayer)
            return new FrayerLayout(enableTitle, enableDescription, scale, layoutConfig);

        if (layout == StoryboardLayoutType.Matrix)
            return new MatrixLayout(enableTitle, enableDescription, scale, layoutConfig);

        if (layout == StoryboardLayoutType.Spider)
            return new SpiderLayout(enableTitle, enableDescription, scale, layoutConfig);

        if (layout == StoryboardLayoutType.Timeline)
            return new TimelineLayout(enableTitle, enableDescription, scale, layoutConfig);

        if (layout == StoryboardLayoutType.Movie)
            return new MovieLayout(enableTitle, enableDescription, scale, layoutConfig);

        if (layout == StoryboardLayoutType.ParallelLabelMatrix)
            return new ParallelLabelMatrixLayout(enableTitle, enableDescription, scale, layoutConfig);

        if (layout == StoryboardLayoutType.Cycle)
            return new CycleLayout(enableTitle, enableDescription, scale, layoutConfig);
    };
}