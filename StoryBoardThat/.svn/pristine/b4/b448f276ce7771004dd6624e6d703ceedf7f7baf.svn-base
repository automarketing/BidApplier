///  <reference path="../../SvgManip.js" />
function BasicTextLayoutTitle(defaultText)
{
    this.DefaultText = MyLangMap.GetText("text-click-to-edit-title");
    this.DefaultFontSize = "18";
    this.DefaultFontColor = "#000000";
    this.DefaultFont = MyBrowserProperties.Public_GetDefaultFont();

    this.FillColor = new ColorableBox("rgb(255, 255, 255)", "Textables", "Fill");

    this.Stroke = "black";
    this.StrokeWidth = 3;
    this.RoundedCornerRadius = 2;
    //this.InnerPadding = 3;
    this.TextPadding = 5;
    this.TextAlignment = "middle";
    this.Rotation = 0;

    this.AllowEditting = true;
    this.ForceTextOverride = false;

    this.StoryboardPartType = StoryboardPartTypeEnum.StoryboardCellTitle;

    if (defaultText != null)
    {
        this.DefaultText = defaultText;
    }
}