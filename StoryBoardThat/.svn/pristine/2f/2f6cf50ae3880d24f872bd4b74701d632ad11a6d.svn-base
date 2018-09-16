/// <reference path="SvgManip.js" />

/**
 * The pointers class serves as a global reference for various objects.
 * 
 * The aim is to make it easier/faster to find objects than looking them up in the DOM.
 * @returns Nothing
 */
function Pointers()
{
    this.CellContainer;
    this.CoreSvg;
    this.Watermark;
    this.SvgContainer;
    //this.WorkingArea;
    this.Tabs;
    this.BottomControls;
    this.HelpTopicArea;

    this.CoreSVG_SvgTop;
    

    this.Dialog_ChangeLayout;
    //this.Dialog_ChangeLayout2;
    this.Dialog_SpiderCellCount;
    this.Dialog_CycleCellCount;
    this.Dialog_TimelineCellCount;
    this.Dialog_StoryboardType;
    this.Dialog_PurchasePopForMoreLayouts;
    this.Dialog_PurchasePopForMoreLayoutsOnCopy;

    this.Dialog_PurchasePopForMoreStoryboardLayouts;
    

    this.Dialog_PurchaseForUploads;
    this.Dialog_CropImage;
    this.Dialog_PoseImage;
    this.Dialog_SmartScene;
    this.Dialog_UploadImage;
    this.Dialog_Help;
    this.Dialog_Policies;
    this.Dialog_AdvancedButtons;

    this.Controls_UpdateColor;
    this.Controls_TextableControls;
    this.Controls_TextableControls_TextArea;
    this.Controls_TextableControls_ColorSelector;
    this.Controls_TextableControls_FontSelector;
    this.Controls_ShapeControls;
    this.Controls_MultiShapeControls;

    

    this.StagingGround;

    this.ResetAllPointers = function ()
    {
        this.CellContainer = $("#CellDefinition");
        this.CoreSvg = $("#CoreSvg");
        this.SvgContainer = $("#svgContainer");
        //this.WorkingArea = $("#WorkingArea");
        this.BottomControls = $("#bottom-toolbar");
        this.Tabs = $("#WorkingArea div.clipart-library-tabs");
        this.Watermark = $("#watermark");

        this.HelpTopicArea = $("#HelpTopicArea");
        
        this.Dialog_ChangeLayout = $("#ChangeLayoutDialog");
        //this.Dialog_ChangeLayout2 = $("#LayoutSettings_DefaultLayout");
        this.Dialog_SpiderCellCount = $("#ChangeCellCountSpider");
        this.Dialog_CycleCellCount = $("#ChangeCellCountCycle");
        this.Dialog_TimelineCellCount = $("#ChangeCellCountTimeline");

        this.Dialog_StoryboardType = $("#StoryboardTypeDialog");
        this.Dialog_PurchasePopForMoreLayouts = $("#PurchasePopForLayoutOptions");
        this.Dialog_PurchasePopForMoreLayoutsOnCopy = $("#PurchasePopForLayoutOptionsOnCopy");

        this.Dialog_PurchasePopForMoreStoryboardLayouts = $("#PurchasePopForStoryboardLayoutOptions");
        

        this.Dialog_CropImage = $("#CropArea");
        this.Dialog_PoseImage = $("#PoseArea");
        this.Dialog_SmartScene = $("#Smart-Scene-Modal");
        this.Dialog_UploadImage = $("#UploadArea");
        this.Dialog_PurchaseForUploads = $("#PurchaseForUploads");
        this.Dialog_Help = $("#HelpArea");
        //this.Dialog_HelpPrint = $("#HelpPrintArea");
        this.Dialog_CellSize = $("#StoryboardCellSizeDialog");
        this.Dialog_Policies = $("#PoliciesDialog");
        this.Dialog_AdvancedButtons = $("#AdvancedButtonsDialog");

        //this.Dialog_SaveWarning = $("#SaveWarning");
        //this.Dialog_SaveWarning_Message = $("#SaveWarningText");



        this.CoreSVG_SvgTop = $("#SvgTop");

        this.Controls_UpdateColor = $("#ColorUpdaterBox");
        this.Controls_TextableControls = $("#textableControls");
        this.Controls_TextableControls_TextArea = $("#textableText");
        this.Controls_TextableControls_ColorSelector = $("#FontColorSelector");
        this.Controls_TextableControls_FontSelector = $("#FontSelector");
        this.Controls_TextableControls_TextAlignmentSelectors = $("#textableControls .MenuAlignText");

        this.Controls_ShapeControls = $("#controlsBox");
        this.Controls_MultiShapeControls = $("#MultiSelectControlsBox");
        
        this.StagingGround = $("#StagingGround");
    };

    this.GetSvgTop = function ()
    {
        if (this.CoreSVG_SvgTop == null || this.CoreSVG_SvgTop.length==0)
        {
            this.CoreSVG_SvgTop = $("#SvgTop");
            if (this.CoreSVG_SvgTop == null || this.CoreSVG_SvgTop.length == 0)
            {
                var svgGroup = document.createElementNS("http://www.w3.org/2000/svg", "g");
                svgGroup.setAttribute("id", "SvgTop");

                this.CoreSvg.append(svgGroup);

                this.CoreSVG_SvgTop = $("#SvgTop");
            }
        }

        return this.CoreSVG_SvgTop;
    };

    this.ResetAllPointers();
}