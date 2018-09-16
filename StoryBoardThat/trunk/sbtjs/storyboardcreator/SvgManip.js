﻿//Copyright 2012-2015, Clever Prototypes, LLC

/// <reference path="/Scripts/storyboard-creator/spectrum.js" />


/// <reference path="Pointers.js" />
/// <reference path="./sbtLib.js" />
/// <reference path="SvgCreatorLibrary.js" />
/// <reference path="StoryboardContainerLibrary.js" />
/// <reference path="SbtMathLibrary.js" />
/// <reference path="LangMap.js" />

/// <reference path="Cache/Posables/CharacterSwapLibrary.js" />
/// <reference path="Cache/Posables/GlobalSwapLibrary.js" />
/// <reference path="Cache/Posables/CharacterPosistionLibrary.js" />

/// <reference path="State/SvgState.js" />
/// <reference path="State/TextState.js" />
/// <reference path="State/ColorableState.js" />
/// <reference path="State/ShapesState.js" />

/// <reference path="State/PosableState.js" />

/// <reference path="Models/ColorWheel.js" />
/// <reference path="Models/ColorWheels.js" />
/// <reference path="Models/SbtColors.js" />
/// <reference path="Models/StoryboardSaveData.js" />
/// <reference path="Models/BoxPosition.js" />
/// <reference path="Models/Posables/CharacterLibrarySwap.js" />
/// <reference path="Models/Posables/GlobalLibrarySwap.js" />
/// <reference path="Models/Posables/TiltPose.js" />

/// <reference path="enum/ResizeEnum.js" />
/// <reference path="enum/ShapeActionEnum.js" />
/// <reference path="enum/CellConfigurationEnum.js" />
/// <reference path="enum/SvgPartsEnum.js" />
/// <reference path="enum/SbtConstants.js" />
/// <reference path="enum/PinchResizeEnum.js" />
/// <reference path="enum/CommonStylingEnum.js" />
/// <reference path="enum/InstaPoseEnum.js" />
/// <reference path="enum/CropTypeEnum.js" />

/// <reference path="Manipulation/CroppedImageState.js" />
/// <reference path="Manipulation/ResizeImageAction.js" />
/// <reference path="Manipulation/RotateImageAction.js" />
/// <reference path="Manipulation/MultiSelectState.js" />  
/// <reference path="Manipulation/MoveShapeAction.js" />
/// <reference path="Manipulation/ShapeMetaData.js" />


/// <reference path="Windows/ColorUpdaterBox.js" />
/// <reference path="Windows/MainControlsBox.js" />
/// <reference path="Windows/TextControlsBox.js" />
/// <reference path="Windows/Help.js" />
/// <reference path="Windows/CellSorter.js" />
/// <reference path="Windows/PosableControlsBox.js" />

/// <reference path="Config/UserPermissions.js" />
/// <reference path="Config/BrowserProperties.js" />
/// <reference path="Config/Layouts/StoryboardGridLayout.js" />

/// <reference path="Util/MathUtilsLibrary.js" />

//#region Properties

var DrawMenuMask = false;

$(document).ready(function ()
{

    
    /// START LEGACY CODE
    try
    {
        initProperties();
    }
    catch (e)
    {
    }

    if (MyBrowserProperties == null || MyBrowserProperties.SupportsSvg() == false)
    {
        window.location.href = "/storyboardcreator/upgradebrowser";
        return;
    }


    $.blockUI();


    PopulateEvents();

    /// END LEGACY CODE

    // This should be the only call in doc.ready!
    //App_ModuleRef.load();

    ClipartTab_ModuleRef.load();

    $(".subcategory-ul").tabdrop({ text: MyLangMap.GetText("Text-More") });

    SvgSearch.Load();

    // JIRA WEB-60 WARNING: We have a seriously flawed circular reference: board initialization code depends on the tabs being populated, which in turn depend on key objects being created in the odl code!
    // For the time being, we call this a second time after our tabs have been created, which resolves the issue of items not being dropped with the right offset and becoming unmanagable (duh!)
    StoryboardContainer.Initialize();

    // And validate the UI layout (in case the page is already scrolled down, which can happen during some reloads)
    ValidateUILayout();

    /**
     * Hookup for window scroll method, allowing us to detach the clipart library into a floating bar (only on desktops)
     */
    //$(window).scroll($.throttle(250, App_ModuleRef.validateUILayout));

    // Hack to make sure the UI block is removed (from old code now no longer completing)
    setTimeout(function ()
    {
        if (svgContainerPath == null || svgContainerPath == "")
            $.unblockUI();

        TabRoller.RefreshRollers_PostResize();

    }, 1000);

    if (UseQuill)
    {
        InitQuill();
        try
        {
            if (quill == null)
            {
                LogErrorMessage("document.Ready. Init Quill -  quill is null");
            }
        } catch (e)
        {
        
            LogErrorMessage(".Ready.Init Quill, quill is null with error", e);
        }
    }
    //if (UseSummerNote)
    //{
    //    setTimeout(function ()
    //    {
    //        InitSummerNote();
    //        try
    //        {
    //            if ($('#summernote-editor') == null)
    //            {
    //                LogErrorMessage("document.Ready. Init InitSummerNote -  SummerNote is null");
    //            }
    //        } catch (e)
    //        {

    //            LogErrorMessage(".Ready.Init summernote, summernote is null with error", e);
    //        }

    //    }, 10);

       
    //}

    Date.prototype.toJSON = (function () { return this.getTime(); });	//firefox returns non standard dateformat - all browsers respect "Ticks"
});


var MouseDown = false;



var SearchResultsDiv = "";

var NewShapeIsBackdrop = false;

var warnOnExit = false;
var saveAndContinue = false;
var UndoManager;

var LogUndo = false;


var skipNextDrag = false;

var MyPointers
    , MyBrowserProperties
    , SvgCreator
    , StoryboardContainer
    , SbtMath
    , MainControls
    , MyMultiSelectState
    , MyShapeMetaData
    , MyColors
    , MyColorWheels
    , MyShapesState
    , MyTitlesState
    , MyMoveShapeAction
    , MyCroppedImage
    , MyPosableControlsBox
    , MySmartSceneDialog
    , MyResizeActions
    , MyRotateAction
    , MySvgForCategories
    , MyGlobalSwapLibrary
    , MyCharacterSwapLibrary
    , MyUserPermissions
    , MyCharacterPosistionLibrary
    , CellConfiguration
    , MyIdGenerator
    , MyLayoutFactory
    , MathUtils
   ;

function initProperties()
{
    SpecialSignOut = null; // don't allow special signouts on this page!

    if (typeof IsUserLoggedOn === 'undefined')
    {
        var IsUserLoggedOn = false;
    }

    MyIdGenerator = new IdGenerator();
    MyBrowserProperties = new BrowserProperties();

    CellConfiguration = new StoryboardGridLayout();
    // JIRA-WEB-32 - DOM access should only be made in document.ready...
    MyPointers = new Pointers();
    MyUserPermissions = new UserPermissions(InitialUserPermissions, IsUserLoggedOn);

    SvgCreator = new SvgCreatorLibrary();
    StoryboardContainer = new StoryboardContainerLibrary();
    SbtMath = new SbtMathLibrary();
    MainControls = new MainControlsBox();
    MyMultiSelectState = new MultiSelectState();
    MyShapeMetaData = new ShapeMetaData();
    MyColors = new SbtColors();
    MyColorWheels = new ColorWheels();
    MyShapesState = new ShapesState();
    MyTitlesState = new ShapesState();
    MyMoveShapeAction = new MoveShapeAction();

    MyResizeActions = new ResizeImageAction();
    MyRotateAction = new RotateImageAction();

    //load async!
    window.setTimeout(function ()
    {
        MyGlobalSwapLibrary = new GlobalSwapLibrary();
    }, 1);
    

    // for new save code - BPC RIP OUT IF NEEDED
    if (UseAdvancedLoad)
        MyCharacterSwapLibrary = new CharacterSwapLibrary(null);
    else
        MyCharacterSwapLibrary = new CharacterSwapLibrary(CharacterSwapLibraryJson);
    //MyLangMap = new LangMap();

    MySvgForCategories = new Object();
    MyCharacterPosistionLibrary = new CharacterPosistionLibrary();
    MyLayoutFactory = new LayoutFactory();
    //MyCellConfiguration = new CellConfiguration();
    MathUtils = new MathUtilsLibrary();
    MainWindowControls.Init();

};
//#endregion

"use strict";

function ValidateUILayout()
{
    if (!MyBrowserProperties.IsMobile)
    {
        if (!$('body').hasClass('compact-nav'))
        {
            $('body').addClass('compact-nav');
            StoryboardContainer.Initialize();
        }
    }
    else
    {
        if (!$('body').hasClass('mobile-nav'))
        {
            $('body').addClass('mobile-nav');
            StoryboardContainer.Initialize();
        }
    }
}

function PopulateEvents()
{

    //MyBrowserProperties.UpdateShapesPerPanel();
    MyBrowserProperties.DetermineBrowserInfo();

    $(window).resize(HandleWindowResize);
    //$("#storyboard-container-outer-div").resize(HandleWindowResize2);  // this will now fire 2x... set for iPad
    // $("#WorkingArea").resize(HandleWindowResize2);  // this will now fire 2x... set for iPad

    window.onbeforeunload = closeEditorWarning


    // for new save code - BPC RIP OUT IF NEEDED
    if (UseAdvancedLoad)
        GetAndPopulateShateState();
    else
        PopulateShapeStateFromLoad();

    ConfigureDialogs();

    UndoManager = new UndoManager();

    // JIRA-WEB-33 - Add callback to manager so we can manage the button state (and specifically disable the buttons when the operation isn't available)
    UndoManager.setCallback(function ()
    {
        if (UndoManager.hasUndo())
        {
            $('#undo-btn').prop('disabled', false);
        } else
        {
            $('#undo-btn').prop('disabled', true);
        }
        if (UndoManager.hasRedo())
        {
            $('#redo-btn').prop('disabled', false);
        } else
        {
            $('#redo-btn').prop('disabled', true);
        }
    });

    SetEventHandlersOnCoreSvg();
    SetEventHandlersOnSvgContainer();
    SetEventHandlersOnSvgControlBox();

    $(document).keydown(HandleKeyDown);

    AddSlider();
    //ConfigureBottomControls();

    StoryboardContainer.Initialize();

    //LogStartup();

    if (MyBrowserProperties.IsMobile)
    {
        $.touchyOptions.useDelegation = true;
    }



    MyPointers.Dialog_PoseImage.on('hidden.bs.modal', HandlePoseDialogClose);
    MyPointers.Dialog_SmartScene.on('hidden.bs.modal', HandleSmartSceneDialogClose);

    ResetSaveWarning();

    if (StoryboardSetup.EnableAutoSave)
    {
        setInterval(SaveHelper.AutoSave, 10 * 60 * 1000);
    }
}

/**
   * Adds handlers to prevent text selection outside of inputs and textareas. Some of this is needed specifically for IE (first handler),
   * but also for all other browsers (second handler) to prevent a full page selection on Ctrl+A (Cmd+A on Mac).
   */
function PreventSelection()
{
    // Uses selectstart handler on IE/Opera to prevent selection on everything but inputs and textareas on old versions of IE that do not
    // understand the CSS3 unselectable support. If the event isn't supported by the browser, this will simply be ignored.
    $("body").on("selectstart", function (e)
    {
        if (!$(e.target).is('input, textarea'))
        {
            return false;
        }
    });
}

function ConfigureDialogs()
{
    try
    {
        PopulateUploadDialog();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.ConfigureDialogs", e);
    }

}

function SetEventHandlersOnCoreSvg()
{
    try
    {
        MyPointers.CoreSvg.mousedown(HandleCoreSvgClick);
        MyPointers.CoreSvg.mousemove($.throttle(50, SvgMouseMove));

        MyPointers.CoreSvg.mouseup(HandleMouseExit);
        MyPointers.CoreSvg.mouseleave(HandleMouseLeaveSvg);

        MyPointers.SvgContainer.mousedown(HandleSvgContainerClick);
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SetEventHandlersOnCoreSvg", e);
    }

}

function SetEventHandlersOnSvgContainer()
{
    try
    { 
        //MyPointers.SvgContainer.droppable({ drop: HandleDrop });
        MyPointers.CoreSvg[0].addEventListener("dragover", function(event) {
            event.preventDefault();
        });

        MyPointers.CoreSvg[0].addEventListener("drop", function(event) {
            HandleDrop(event);
        });
 

        MyPointers.SvgContainer.mouseup(HandleMouseExit);
        MyPointers.SvgContainer.mouseleave(HandleMouseLeaveDiv);
        MyPointers.SvgContainer.scroll($.throttle(50, OnScrollSvgContainer));

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SetEventHandlersOnSvgContainer", e);
    }

}
 

function ObjectDrop(ev)
{
    try
    {
        ev.preventDefault();
       
        // console.log( drag_canvas_id);
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.dragEndEvent", e);
    }
}


function HandleDrop(e)
{
    try
    {  
        e.preventDefault();
        var drag_canvas_id  = e.dataTransfer.getData("text");
         
        if (typeof SVGBUF[ drag_canvas_id ] === 'undefined')
            return;
 
        ClearActiveState();
        warnOnExit = true;

        //bad things happen if this is set wrong :(
        StoryboardContainer.SetCoreSvgDimensions();
        
        var coreSvgClientRect = GetGlobalById("CoreSvg").getBoundingClientRect();
        var svgWidth = (coreSvgClientRect.width - 2);
        var svgHeight = (coreSvgClientRect.height - 2);



        var x = PageXtoStoryboardX(e.pageX);
        var y = PageYtoStoryboardY(e.pageY);

        //DebugLine("x:" + x + "    Y:" + y + "      width:" + svgWidth + "   height:" + svgHeight);

        if ((x < 0 || x > svgWidth) && (y < 0 || y > svgHeight))
            return;

        x = Math.min(Math.max(x, 0), svgWidth - 25);
        y = Math.min(Math.max(y, 0), svgHeight - 50);


        var newNode = SVGBUF[ drag_canvas_id ].xml.clone();
        StoryboardContainer.UpdateGradientIds(newNode);
        
     
        NewShapeIsBackdrop = SVGBUF[ drag_canvas_id ].isSceneItem;
         
        AddSvg.AddSvgToStoryboard(newNode, x, y, true);
        
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.HandleDrop", e);
    }
}



function ConfigureTouchEvents()
{
    //  $('#CoreSvg').bind('touchy-pinch', HandleSvgPinch);
}

/**
 * Formatting method: transforms the selection or current line into a bullet list item
 * It text is selected, the selection is validated and, if needed, expanded to encompass the entire line, then the markdown formatting is added.  The transformed text is then selected.
 * If multiple lines are selected, each is transformed into a bullet list item.  The selection is expanded to contain all transformed text
 * If no text is selected, the entire line is transformed with markdown to become a bullet list item, and the focus point is moved in the transformed text so as to be placed on the same character as before the transformation.
 * @param $_textareaNode
 *  The textarea control where the text is being analyzed and modified.
 */
function formatListText($_textareaNode)
{
    var isSpace = /\s/;
    var isCRLF = /[\r\n]/;
    var s = $_textareaNode.getSelection();
    var t = $_textareaNode.val();
    var i, stop = false, nst;
    if (s.length === 0)
    {
        for (i = s.start - 2; i < s.start; i++)
        {
            if (t.substr(i, 3) === '\n' + BULLET_STRING + '\n')
            {
                $_textareaNode.setSelection(i, i + 3).replaceSelectedText('').focus();
                stop = true;
            }
        }
        if (!stop)
        {
            var i = s.start - 1, ws = s.start - 1, we = s.start;
            while (i >= 0)
            {
                if (isCRLF.test(t[i]))
                {
                    ws = i + 1;
                    break;
                }
                i = i - 1;
            }
            if (i === -1)
            {
                ws = 0;
            }
            i = s.start;
            while (i <= t.length)
            {
                if (isCRLF.test(t[i]))
                {
                    we = i;
                    break;
                }
                i = i + 1;
            }
            if (i === t.length + 1)
            {
                we = t.length;
            }
            $_textareaNode.setSelection(ws, we);
            var ns = $_textareaNode.getSelection();
            if (ns.text.startsWith(BULLET_STRING))
            {
                $_textareaNode.replaceSelectedText(ns.text.substr(1, ns.text.length - 1)).setSelection(s.start - 1).focus();
            } else
            {
                $_textareaNode.surroundSelectedText(BULLET_STRING, EMPTY_STRING).setSelection(s.start + 1).focus();
            }
        }
    } else
    {
        var i = s.start - 1, ws = s.start - 1, we = s.end;
        while (i >= 0)
        {
            if (isCRLF.test(t[i]))
            {
                ws = i + 1;
                break;
            }
            i = i - 1;
        }
        if (i === -1)
        {
            ws = 0;
        }
        i = s.end;
        while (i <= t.length)
        {
            if (isCRLF.test(t[i]))
            {
                we = i;
                break;
            }
            i = i + 1;
        }
        if (i === t.length + 1)
        {
            we = t.length;
        }
        $_textareaNode.setSelection(ws, we);
        var ns = $_textareaNode.getSelection();
        if (ns.text.startsWith(BULLET_STRING))
        {
            nst = '\n' + ns.text.replace(new RegExp('\n' + BULLET_STRING, 'g'), '\n');
            nst = nst.substr(2, nst.length - 1);
            $_textareaNode.replaceSelectedText(nst).setSelection(ns.start, ns.start + nst.length).focus();
        } else
        {
            nst = ns.text.replace(/\r\n/g, '\n').replace(/\n/g, '\n' + BULLET_STRING);
            $_textareaNode.replaceSelectedText(BULLET_STRING + nst + '').setSelection(ns.start, ns.start + nst.length + 1).focus();
        }
    }
};

function SetEventHandlersOnSvgControlBox()
{
    try
    {
        //textable controls

        MyPointers.Controls_TextableControls_TextArea.keyup(SetTextableText);
        MyPointers.Controls_TextableControls_TextArea.bind('cut paste', function ()
        {
            setTimeout(function ()
            {
                SetTextableText();
            }, 100);
        });

        try
        {
            textableTextArea = GetGlobalById('textableText');
            textableTextArea.oninput = SetTextableText; //not sure why I need to do this, but this is what is needed to pick up spell check


        } catch (e)
        {

        }




        $("#sizeSelector").change(UpdateFontSize);

        MyPointers.Controls_TextableControls_TextAlignmentSelectors.click(function (e)
        {

            e.stopPropagation();

            // Figure out which button was clicked in the menubar
            var val = "middle";
            if (this.className.split(" ").indexOf("start") > -1)
            {
                val = "start";
            }
            else
            {
                if (this.className.split(" ").indexOf("middle") > -1)
                {
                    val = "middle";
                }
                else
                {
                    if (this.className.split(" ").indexOf("end") > -1)
                    {
                        val = "end";
                    } // else { shouldn't happen: no other choice available }
                }
            }

            // And update the text alignment
            UpdateTextAlignment(val);
        });

        $('#textableControlsTable td.MenuAddList').click(function (e)
        {
            formatListText($('#textableText'));
            SetTextableText();
        });

        InitializeFontSelector();

        // SVG single selected Controls
        $("#flipVerticalButton").click(FlipVertical);
        $("#flipHorizontalButton").click(FlipHorizontal);
        $("#flipHorizontalButton2").click(FlipHorizontal);
        $("#rotateLeftButton").click(RotateLeft);
        $("#rotateRightButton").click(RotateRight);
        $("#bringForwardButton").click(BringShapeForward);
        $("#bringForwardButton2").click(BringShapeForward);
        $("#bringToFrontButton").click(BringShapeToFront);
        $("#sendBackwardsButton").click(SendShapeBackwards);
        $("#sendBackwardsButton2").click(SendShapeBackwards);
        $("#sendToBackButton").click(SendShapeToBack);

        $("#lockButton").click(LockSelected);
        $("#unlockButton").click(UnlockSelected);

        $("#copyShapeButton").click(CopyHelper.CopyShape);
        $("#copyShapeButton2").click(CopyHelper.CopyShape);

        $("#stretchToFillButton").click(StretchToFill);
        $("#stretchToFillProportionalButton").click(StretchToFill_Proportional);

        $("#cropShapeButton").click({CropType: CropTypeEnum.Standard},CropShape);
        $("#cropAdvancedShapeButton").click({CropType: CropTypeEnum.Advanced},CropShape);
        $("#cropCircleButton").click({CropType: CropTypeEnum.Circle},CropShape);

        $("#CropInnerMenuStandard").click({CropType: CropTypeEnum.Standard},CropShapeChange);
        $("#CropInnerMenuAdvanced").click({CropType: CropTypeEnum.Advanced},CropShapeChange);
        $("#CropInnerMenuCircle").click({CropType: CropTypeEnum.Circle},CropShapeChange);

        $("#cropShapeButton2").click({CropType: CropTypeEnum.Standard},CropShape);

        $("#deleteShapeButton").click(DeleteShape);
        $("#deleteShapeButton2").click(DeleteShape);

        $("#poseShapeButton, #poseShapeButton2").click(PoseShape);
        $("#editItemOptionsButton").click(SmartImageOptions);
        $("#editSceneButton").click(SmartSceneShape);
        


        $("#poseSpeaking").click(InstaPoseClosure(InstaPoseEnum.Speaking));
        $("#poseSad").click(InstaPoseClosure(InstaPoseEnum.Sad));
        $("#poseAngry").click(InstaPoseClosure(InstaPoseEnum.Angry));
        $("#poseWalking").click(InstaPoseClosure(InstaPoseEnum.Walking));
        $("#poseSitting").click(InstaPoseClosure(InstaPoseEnum.Sit));
        

        // Multiselect Controls
        $("#multiFlipVerticalButton").click(FlipVertical);
        $("#multiFlipHorizontalButton").click(FlipHorizontal);
        $("#multiRotateLeftButton").click(RotateLeft);
        $("#multiRotateRightButton").click(RotateRight);
        $("#multiCopyShapeButton").click(CopyHelper.CopyShape);
        $("#multiDeleteShapeButton").click(DeleteShape);

        $("#multi-select-align-left").click(AlignHelper.AlignLeft);
        $("#multi-select-align-right").click(AlignHelper.AlignRight);
        $("#multi-select-align-center").click(AlignHelper.AlignCenter);
        $("#multi-select-align-horizontal-dist").click(AlignHelper.HorizontalDistribution);

        $("#multi-select-align-top").click(AlignHelper.AlignTop);
        $("#multi-select-align-middle").click(AlignHelper.AlignMiddle);
        $("#multi-select-align-bottom").click(AlignHelper.AlignBottom);
        $("#multi-select-align-vertical-dist").click(AlignHelper.VerticalDistribution);

        /*
          Filter control, for both single- and multi-select popups
        */
        $('#multiSelectControlsBoxTable .colorfilterrow td.MenuFilter img, #controlsBoxTable .colorfilterrow td.MenuFilter img').click(function (e)
        {
            FilterColorMode((this.className === 'color') ? EMPTY_STRING : 'url(#' + this.className + ')');
        });

        AddSpanishKeyboard();
        $("#showSpanishKeyboard").click(function () { $("#spanish-keypad").toggle() });

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SetEventHandlersOnSvgControlBox", e);
    }
}



//function LogStartup()
//{
//    try
//    {
//        var isEditValForGoogle = 'New Storyboard';
//        if ($("#IsEdit").val().toLowerCase() == "true")
//        {
//            isEditValForGoogle = 'Edit Storyboard'
//        }

//        trackEventWithGA('Storyboard Creator', 'Start Editor', isEditValForGoogle, 0);
//    }
//    catch (e)
//    {
//        LogErrorMessage("SvgManip.LogStartup", e);
//    }
//}

//#endregion

//#region Upload
function ShowUploadDialog()
{
    try
    {
        ClearActiveState();
        CheckForUploadAccessPreRefresh(true);
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.ShowUploadDialog", e);
    }
}

function PopulateUploadDialog()
{
    try
    {
        var uploadButtonText = MyLangMap.GetText("button-upload-multiple-files");
        if (MyBrowserProperties.IsSafari5)
        {
            uploadButtonText = MyLangMap.GetText("button-upload-single-file");
            var safariWarning = $("#SafariUploadWarning");
            safariWarning.show();
        }
        $('#fine-uploader').fineUploader(
            {
                //template: 'qq-template',
                request:
                {
                    //endpoint: '/imageupload/imageuploadhelper?magicToken=' + MyUserPermissions.MagicToken,
                    endpoint: CreatorUrls.GeoServer + '/imageupload/imageuploadhelper',
                    customHeaders: { Accept: 'application/json' },
                },
                cors: {
                    //all requests are expected to be cross-domain requests
                    expected: true,
                },
                validation:
                {
                    allowedExtensions: ['jpeg', 'jpg', 'gif', 'png', 'bmp', "wmf", "svg"],
                    sizeLimit: 1024 * 1024 * 3
                },
                text: { uploadButton: uploadButtonText },

            })
            .on('complete', function (event, id, fileName, responseJSON)
            {
                if (responseJSON.success == true)
                {
                    UglyUploadCallback(responseJSON.svg);
                }
                else
                {
                    alert(responseJSON.errorMessage);
                }
            });
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.PopulateUploadDialog", e);
    }
}


function CheckForUploadAccessPreRefresh(promptForLogon)
{
    try
    {
        if (MyUserPermissions.EnableUploads)
        {
            MyPointers.Dialog_UploadImage.modal();
            return;
        }

        MyUserPermissions.Public_RefreshPermissions(false, function () { CheckForUploadAccessPostRefresh(promptForLogon); });

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.CheckForUploadAccessPreRefresh", e);
    }
}

function CheckForUploadAccessPostRefresh(promptForLogon)
{
    try
    {
        if (MyUserPermissions.EnableUploads)
        {
            MyPointers.Dialog_UploadImage.modal();
            return;
        }

        if (MyUserPermissions.IsLoggedOn == false)
        {
            if (promptForLogon)
            {
                HandleLoginCloseFunction = function () { CheckForUploadAccessPreRefresh(false); };
                showLogonDialog();
                return;
            }
        }

        MyPointers.Dialog_PurchaseForUploads.modal();

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.CheckForUploadAccessPostRefresh", e);
    }
}

//#endregion




//#region Load Saved Storyboardrec

//var ShapeLoadData = new Object();
function GetAndPopulateShateState()
{
    if (ExtraSetup.LoadFrom == null)
        return;

    var postData = {
        userName: ExtraSetup.LoadFrom.UserName,
        url_title: ExtraSetup.LoadFrom.UrlTitle,
        revision: ExtraSetup.LoadFrom.Revision
    };
    //$.post("/api_storyboardcreator/getstoryboardmetadata", postData, GetAndPopulateShateState_Success, GetAndPopulateShateState_Failure);

    $.ajax({
        type: 'POST',
        timeout: 10 * 1000,
        url: '/api_storyboardcreator/getstoryboardmetadata',
        data: postData,

        success: GetAndPopulateShateState_Success,
        error: GetAndPopulateShateState_Failure,
        cache: false
    });


    //contentType: "application/json",
    //    dataType: 'json',
}

function GetAndPopulateShateState_Failure(data)
{
    var tryNumber = GetQSParameterByName("try") || 1;
    if (tryNumber < 5)
    {
        try
        {
            LogErrorMessage("GetAndPopulateShateState_Failure - Try + " + tryNumber + " ExtraSetup : " + ExtraSetup.LoadFrom.UserName + " " + ExtraSetup.LoadFrom.UrlTitle);
        } catch (e)
        {
            LogErrorMessage("GetAndPopulateShateState_Failure - debug message! ");
        }


        tryNumber = Number(tryNumber) + 1;
        // swal({ title: "", text: "going to reload", type: "error", confirmButtonText: MyLangMap.GetText("warning-ok-button") });

        var url = window.location.origin + window.location.pathname + "?try=" + tryNumber;

        window.location = url;
        return;
    }
    alert(data);
}



function GetAndPopulateShateState_Success(data)
{
    try
    {

        if (data.Success == false)
        {
            HandleLoadFailure(false);
            swal({ title: "", text: data.ErrorMessage, type: "error", confirmButtonText: MyLangMap.GetText("warning-ok-button") });

            return;
        }
        ExtraSetup.ShapeStateJson = data.ShapeStateJson;
        ExtraSetup.LayoutConfig = JSON.parse(data.LayoutConfig);
        if (data.CharacterSwapLibrary == null || data.CharacterSwapLibrary == "")
            ExtraSetup.CharacterSwapLibrary = null;
        else
        ExtraSetup.CharacterSwapLibrary = JSON.parse(data.CharacterSwapLibrary);
        ExtraSetup.SvgPath = data.SvgPath;


        MyShapesState.Public_LoadShapeStatesFromJson(shapeStateJson);
        MyCharacterSwapLibrary = new CharacterSwapLibrary(ExtraSetup.CharacterSwapLibrary);

        $.ajax({
            type: 'GET',
            timeout: 120 * 1000,
            url: CreatorUrls.LoadSaved + "?sanitizeSvg=true&url=" + svgContainerPath,

            contentType: "application/json",
            dataType: 'json',
            success: LoadCoreSvg,
            error: LoadCoreSvgFail,
            cache: false
        });
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.GetAndPopulateShateState_Success", e);
    }

}

function PopulateShapeStateFromLoad()
{
    try
    {
        if (svgContainerPath == null || svgContainerPath == "")
            return;

        if (shapeStateJson.length == 0 || shapeStateJson == null)
        {
            LogErrorMessage("SvgManip.PopulateShapeStateFromLoad: Completely empty shapeState");
        }
        else
        {
            MyShapesState.Public_LoadShapeStatesFromJson(shapeStateJson);
        }
        //return;

        $.ajax({
            type: 'GET',
            timeout: 120 * 1000,
            url: CreatorUrls.LoadSaved + "?sanitizeSvg=true&url=" + svgContainerPath,
            contentType: "application/json",
            dataType: 'json',
            success: LoadCoreSvg,
            error: LoadCoreSvgFail,
            cache: false
        });
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.PopulateShapeStateFromLoad", e);
    }
}


function HandleLoadFailure(showError)
{
    try
    {
        // this is why we spam so many erors to JS log
        MyShapesState.Private_ClearUnusedShapes();


        // even though we say don't hit save... if they do save make it a new storyboard...
        $('#save-choices-btn').click(function () { SaveHelper.SaveStoryboard(false, true, false); });
        $("#UrlTitle").val("");
        $("#EditUserName").val("");
        if (StoryboardSetup != null)
            StoryboardSetup.EnableAutoSave = false;

    } catch (e)
    {

    }


    $.unblockUI();
    if (showError)
    {
        swal({ title: "", text: MyLangMap.GetTextLineBreaks("warning-load-failed"), type: "error", confirmButtonText: MyLangMap.GetText("warning-ok-button") });
    }
    return;
}

function LoadCoreSvgFail(data)
{
    //http://stackoverflow.com/questions/6186770/ajax-request-return-200-ok-but-error-event-is-fired-instead-of-success
    if ((data.status == 200 || data.status == "200") && data.responseText != "")
    {
        //$.unblockUI();
        return;
    }


    HandleLoadFailure(true);

};

function LoadCoreSvg(data)
{
    try
    {
        if (data.svg.length == 0)
        {
            // this is why we spam so many erors to JS log
            MyShapesState.Private_ClearUnusedShapes();

            $.unblockUI();

            var tryNumber = GetQSParameterByName("try") || 1;
            if (tryNumber < 5)
            {
                LogErrorMessage("Failed to Load Svg - Try + " + tryNumber + " Path : " + svgContainerPath);

                tryNumber = Number(tryNumber) + 1;
                // swal({ title: "", text: "going to reload", type: "error", confirmButtonText: MyLangMap.GetText("warning-ok-button") });

                var url = window.location.origin + window.location.pathname + "?try=" + tryNumber;

                window.location = url;
                return;
            }
            HandleLoadFailure(true);



            return;
        }

        MyPointers.CoreSvg.remove();
        MyPointers.SvgContainer.append(InjectSvgFilters(data.svg));

        MyPointers.ResetAllPointers();
        SetEventHandlersOnCoreSvg();

        var hasTitle = $("#c_title_R0C0").length > 0;
        var hasDescription = $("#c_descr_R0C0").length > 0;

        var layoutType = StoryboardContainer.GetLayoutType();
        if (layoutType == StoryboardLayoutType.Frayer)
            $('#addcell-btn').prop("disabled", true);

        if (layoutType == StoryboardLayoutType.Movie)
        {
            SwapSceneCategory(true);
        }
        if (layoutType == StoryboardLayoutType.Timeline)
        {
            $('#addcell-btn').html("<i class=\"icon isbt-addcell\"></i> " + MyLangMap.GetText("button-timeline-dates"));

            var layoutConfig = new Object();
            layoutConfig.TimelineDates = []

            // we lost the dates... :(
            if (ExtraSetup.LayoutConfig == null || ExtraSetup.LayoutConfig.TimelineDates == null)
            {
                StoryboardContainer.CalculateRowsAndCols();
                for (var i = 0; i < StoryboardContainer.Cols; i++)
                {
                    layoutConfig.TimelineDates.push(new Date(2000, i, 1));
                }
                LogErrorMessage("Timeline lost dates");
                swal({ title: "", text: MyLangMap.GetTextLineBreaks("warning-timeline-lost-dates"), type: "error", confirmButtonText: MyLangMap.GetText("warning-ok-button") });
            }
            else
            {
                for (var i = 0; i < ExtraSetup.LayoutConfig.TimelineDates.length; i++)
                {
                    layoutConfig.TimelineDates.push(new Date(ExtraSetup.LayoutConfig.TimelineDates[i]));
                }
            }
            ExtraSetup.LayoutConfig = layoutConfig;
            TimelineDateManager.PreparePopup(layoutConfig.TimelineDates);
        }

        CellConfiguration = MyLayoutFactory.GetLayout(layoutType, hasTitle, hasDescription, 1, ExtraSetup.LayoutConfig);

        //yuck layout code is a bit all over!
   
        var maxId = AddSvg.CurrentShapeIndex;
        var toBeDeleted = []
        var shapeStates = MyShapesState.Public_GetAllShapeStates();
        for (var i = 0; i < shapeStates.length; i++)
        {
           
            var shapeState = shapeStates[i];

            try
            {
                var id = shapeState.Id;
                if (id.indexOf("sbt_") >= 0)
                {
                    var offsetNumber = id.replace("sbt_", "");
                    maxId = Math.max(maxId, offsetNumber);
                }
                var item = $("#" + id);

                if (item.length == 0)
                {
                    toBeDeleted.push(id);
                    continue;
                }
                item.off("mousedown").on("mousedown", ShapeSelected);
                item.off("mouseup").on("mouseup", HandleMouseExit);

                var shapeState = new SvgState(id);
                shapeState.PopulateFromJson(MyShapesState.Public_GetShapeStateById(id));

                shapeState.UpdateDrawing(true); //force the drawing to redo itself, CRITICAL for text to re-align
                MyShapesState.Public_SetShapeState(id, shapeState);
            } catch (e)
            {
                LogErrorMessage("SvgManip.LoadCoreSvg", e);
            }
        }

        for (i = 0; i < toBeDeleted.length; i++)
        {
            MyShapesState.Public_RemoveShapeStateById(toBeDeleted[i]);
        }


        StoryboardContainer.CleanupAndVerifyLoadedSvg();

        var firstCell = $("#cell_R0C0");
        if (firstCell != null && firstCell.length > 0)
        {
            var cellWidth = firstCell.attr("width");
            expandBy = cellWidth / CellConfiguration.CellWidth

            //CellConfiguration.CurrentCellExpansion = expandBy;
            CellConfiguration.ExpandCells(expandBy);

            StoryboardContainer.CalculateRowsAndCols();

            StoryboardContainer.ExpandCells(expandBy);      //YUCK same method name as call on CellConfiguration abs 1/28/15

            $("#cell-size-slider").slider('setValue', expandBy);
            $("#cell-size-slider").data("previousValue", expandBy);
        }

       FindOrphans();
        AddSvg.CurrentShapeIndex = maxId + 1;


        StoryboardContainer.UpdateBackgroundColors();
        StoryboardContainer.UpdateImageAttributions();
        StoryboardContainer.JiggleSvgSize();

        // $.unblockUI();

        CheckForLayoutAccessOnStoryboardCopy(StoryboardContainer.Rows, StoryboardContainer.Cols, true);

        //update watermark
        MyPointers.Watermark.text(WatermarkCopy);
        MyPointers.Watermark.css("font-family", "roboto");

        setTimeout(UpdateTextSpace, 500);

        //when using revions sometimes there are selected items...
        setTimeout(ClearActiveState, 500);

        if (UseSummerNote)
        {
            //post load should be good enough to get this ready...
            SbtSummerNoteHelper.InitSummerNoteIfNeeded();
        }
        $.unblockUI();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.LoadCoreSvg", e);
        $.unblockUI();
    }
   
}

/**
 * Provides a regexp-based 'indexOf' function
 */
//WTF this isn't working on some browers (ie 11)... just making it non prototype code'
//String.prototype.regexIndexOf = function (regex, startpos)
//{
//    var indexOf = this.substring(startpos || 0).search(regex);
//    return (indexOf >= 0) ? (indexOf + (startpos || 0)) : indexOf;
//}

function RegexIndexOf(content, regex, startpos)
{
    var indexOf = content.substring(startpos || 0).search(regex);
    return (indexOf >= 0) ? (indexOf + (startpos || 0)) : indexOf;
}


function InjectSvgFilters(data)
{
    // Find start of svg node (passing XML declaration)
    var start = data.indexOf("<svg") + 1;

    // Find end of SVG tag
    var injectionPoint = data.indexOf(">", start) + 1;

    // Do we have a 'defs' section
    //var injectionPointHasDefs = data.regexIndexOf(/>([\s])*<defs/, start) + 1;
    var injectionPointHasDefs = RegexIndexOf(data, />([\s])*<defs/, start) + 1;
    var endDefs = -1;

    // If there's already a defs section AND it is right after the first SVG tag (not anywhere in the document!!!), strip it out and use ours.
    if (injectionPointHasDefs === injectionPoint)
    {
        //endDefs = data.regexIndexOf(/<\/defs>([\s])*<g\s/, injectionPointHasDefs) + 7;
        endDefs = RegexIndexOf(data, /<\/defs>([\s])*<g\s/, injectionPointHasDefs) + 7;
        return [data.slice(0, injectionPoint), SVGFilterDeclaration, data.slice(endDefs)].join('')
    }
    // Otherwise, no filter definition exist: inject ours
    return [data.slice(0, injectionPoint), SVGFilterDeclaration, data.slice(injectionPoint)].join('')
};


function UpdateTextSpace()
{
    var shapeStates = MyShapesState.Public_GetAllShapeStates();
    for (var i = 0; i < shapeStates.length; i++)
    {
        shapeStates[i].UpdateDrawing(true);
    }
}

//#endregion

//#region Page Management 

function OnScrollSvgContainer()
{
    try
    {
        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.OnScrollSvgContainer", e);
    }
}


function HandleWindowResize(e)
{
    try
    {

        //MyBrowserProperties.UpdateShapesPerPanel();
        TabRoller.RefreshRollers_PostResize();
        StoryboardContainer.JiggleSvgSize();
        StoryboardContainer.SetCoreSvgDimensions();

        CellPickerHelper.UpdateIfNeeded();

        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.HandleWindowResize", e);
    }
}

function closeEditorWarning(e)
{
    try
    {
        if (warnOnExit == true)
            return 'Did you mean to leave? If you do you will lose your storyboard!  You might want to hit save.';
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.closeEditorWarning", e);
    }
}

//#endregion

//#region Event Delegators 

function HandleKeyDown(e)
{
    try
    {
        if (e.ctrlKey || e.metaKey)
        {
            //DebugLine(e);
            switch (e.keyCode)
            {
                case 90:
                    {
                        if( e.metaKey && e.shiftKey )  Redo();
                        else Undo();
                        e.stopPropagation();
                        e.preventDefault();
                        return;
                    }
                case 89:
                    {
                        Redo();
                        e.stopPropagation();
                        e.preventDefault();
                        return;
                    }
                case 75:  //ctrl-k -- https://css-tricks.com/snippets/javascript/javascript-keycodes/
                    {
                        SaveStoryboard(false, true);
                        e.stopPropagation();
                        e.preventDefault();
                        return;
                    }
            }

            // I don't think this works... - ABS 3/9/17'
            // Prevent Ctrl+A/Cmd+A that would bypass the unselectable CSS/IE-hacked support and still select the entire page! (Seb?)
            if (!$(e.target).is('input, textarea'))
            {
                if (e.which === 65)
                {
                    return false;
                }
            }
        }
        //if (e.metaKey && e.shiftKey && e.keyCode==90) //fucking macs
        //{
        //    Redo();
        //    e.stopPropagation();
        //    e.preventDefault();
        //    return;
        //}

        if (MyShapesState.Property_SelectedCount() == 0)
            return;

        //if we are editing, we don't want to do these other things
        if ($("#textableText").is(":focus") || $(e.target).is('.ql-editor') ||$(e.target).is('.note-editable'))
        {
            return;
        }



        if (UnmovableShapeSelected())
            return;

        var dirty = false;

        switch (e.keyCode) //http://www.cambiaresearch.com/articles/15/javascript-char-codes-key-codes
        {
            case 46:
                {

                    DeleteShape();
                    return;
                }
            case 37: //left arrow
                {
                    if (e.shiftKey)
                    {
                        QuickRotate(-10);
                    }
                    else
                    {
                        QuickShapeMove(-5, 0);
                    }

                    dirty = true;
                    break;
                }
            case 38: //up arrow
                {
                    if (e.shiftKey)
                    {
                        QuickShapeScale(1.1);
                    }
                    else
                    {
                        QuickShapeMove(0, -5);
                    }


                    dirty = true;
                    break;
                }
            case 39: //right arrow
                {
                    if (e.shiftKey)
                    {
                        QuickRotate(10);
                    }
                    else
                    {
                        QuickShapeMove(5, 0);
                    }



                    dirty = true;
                    break;
                }
            case 40: //down arrow
                {
                    if (e.shiftKey)
                    {
                        QuickShapeScale(.9);
                    }
                    else
                    {
                        QuickShapeMove(0, 5);
                    }


                    dirty = true;
                    break;
                }
        }
        if (dirty)
        {
            UpdateActiveDrawing();
            e.stopPropagation();
            e.preventDefault();
        }
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.HandleKeyDown", e);
    }

}

function HandleCoreSvgClick(e)
{
    try
    {
        ClearActiveState();

        MyMultiSelectState.Public_StartMultiSelect(e);
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.MultiSelecting);
        e.stopPropagation();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.HandleCoreSvgClick", e);
    }
}

function HandleSvgContainerClick(e)
{

    try
    {
        ClearActiveState();

        MyMultiSelectState.Public_StartMultiSelect(e);
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.MultiSelecting);

        e.stopPropagation();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.HandleSvgContainerClick", e);
    }

}

function HandleMouseLeaveSvg()
{
    //HandleMouseExit();
}

function HandleMouseLeaveDiv()
{
    HandleMouseExit();

}

function HandleMouseLeave(e)
{
}

function HandleMouseExit()
{
    try
    {
        var currentShapeAction = MyShapesState.Property_GetCurrentShapeAction();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.HandleMouseExit.a", e);
    }
    if (currentShapeAction == ShapeActionEnum.MultiSelecting)
    {
        MyMultiSelectState.Public_CompleteSelection(); // JIRA-WEB-28 - this is where the error is triggerred
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Selected);
    }
    try
    {


        var shapeState = MyShapesState.Public_GetFirstSelectedShapeState();

        if (shapeState == null)
            LogUndo = false;
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.HandleMouseExit.b", e);
    }
    try
    {
        if (LogUndo)
        {
            LogUndo = false;

            if (currentShapeAction == ShapeActionEnum.Rotating)
            {
                HandleMouseStopRotating();
            }

            if (currentShapeAction == ShapeActionEnum.Move && MyMoveShapeAction.UndoMoveX != null && MyMoveShapeAction.UndoMoveY != null)
            {
                HandleShapeStopMove();
            }

            if (currentShapeAction == ShapeActionEnum.Resize && MyResizeActions != null)
            {
                HandleShapeStopResizing();
            }
        }

        MouseDown = false;
        ClearShapeEvents();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.HandleMouseExit.c", e);
    }
}

function StartDrag(e, f)
{
    try
    {
        ClearActiveState();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.StartDrag", e);
    }
}

function SvgMouseMove(e)
{
    try
    {
        var takingAction = false;

        var x = e.pageX;
        var y = e.pageY;

        var currentShapeAction = MyShapesState.Property_GetCurrentShapeAction();

        if (StoryboardContainer.CoreSvgLeft < 0)
        {
            //bad things happen if this is set wrong :(
            StoryboardContainer.SetCoreSvgDimensions();
        }



        if (MyShapesState.Property_SelectedCount() == 0)
        {
            if (currentShapeAction == ShapeActionEnum.MultiSelecting)
            {
                MyMultiSelectState.Public_DrawSelectionArea(e);
            }
            return;
        }

        if (x < StoryboardContainer.CoreSvgLeft || x > StoryboardContainer.CoreSvgRight || y < StoryboardContainer.CoreSvgTop || y > StoryboardContainer.CoreSvgBottom)
        {
            HandleMouseExit();
            return;
        }

        if (currentShapeAction == ShapeActionEnum.Nothing)
        {
            return;
        }
        //e.which is which mouse key is pressed - 1 is left
        else if (currentShapeAction == ShapeActionEnum.Selected || currentShapeAction == ShapeActionEnum.SelectedControlsHidden)
        {
            if (MouseDown)
            {
                MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Move);
                HandleShapeMove(e);
                takingAction = true;
            }
        }
        else if (currentShapeAction == ShapeActionEnum.Move)
        {
            HandleShapeMove(e);
            takingAction = true;
        }

        else if (currentShapeAction == ShapeActionEnum.Resize)
        {
            ResizeShape(e);
            takingAction = true;
        }
        else if (currentShapeAction == ShapeActionEnum.Rotating)
        {
            RotateShape(e);
            takingAction = true;
        }

        if (takingAction)
        {
            e.stopPropagation();
            HideControlsMenu();
            return;
        }
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SvgMouseMove", e);
    }

}

function ShapeSelected(e)
{
    try

    {    
        if (CheckForActiveDialogs())
            return;

        e.stopPropagation();

        var selectedShape = $(this);

        var multiSelect = false;

        if (e.ctrlKey || e.shiftKey)
            multiSelect = true;

        if (MyShapesState.Public_ShapeSelected(selectedShape))
        {
            if (MyShapesState.Property_SelectedCount() > 1)
                multiSelect = true;
        }

        if (multiSelect)
        {
            MultipleShapeSelected(e, selectedShape);
        }
        else
        {
            SingleShapeSelected(selectedShape)
        }

        MouseDown = true;
        MyMoveShapeAction.Public_UpdateMouseMoveOffsets(e.pageX, e.pageY);
        DrawControlsMenu();
        UpdateActiveDrawing();
        
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.ShapeSelected", e);
    }
}

function MultipleShapeSelected(e, selectedShape)
{
    try
    {

        var containsShape = MyShapesState.Public_ShapeSelected(selectedShape);
        var controlOrShiftClick = false;

        if (e.ctrlKey || e.shiftKey)
        {
            controlOrShiftClick = true;
        }

        if (containsShape === true && controlOrShiftClick === false)
        {
            MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.SelectedControlsHidden);
            HideControlsMenu();
            return; // this means we have already selected some content and someone wants to move them...  alternative we should hide/show controls here...
        }

        if (containsShape)
        {
            MyShapesState.Public_UnselectShape(selectedShape);
            var shapeState = MyShapesState.Public_GetShapeStateByShape(selectedShape);
            shapeState.UpdateDrawing();
        }
        else
        {
            MyShapesState.Public_SelectShape(selectedShape);
            var shapeState = MyShapesState.Public_GetShapeStateByShape(selectedShape);
        }

        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Selected);
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.MultipleShapeSelected", e);
    }
}

function SingleShapeSelected(selectedShape)
{
    try
    {
        var action = ShapeActionEnum.Selected;
        var currentShapeAction = MyShapesState.Property_GetCurrentShapeAction();


        var hideControlsMenu = false;
        var removeOldShapes = true;
        var debugInitialSelectedCount = MyShapesState.Property_SelectedCount();

        if (MyShapesState.Property_SelectedCount() > 0)
        {
            var activeShape = MyShapesState.Public_GetFirstSelectedShape();

            if (activeShape.attr("id") == selectedShape.attr("id"))
            {
                removeOldShapes == false;
                if (currentShapeAction != ShapeActionEnum.SelectedControlsHidden)
                {
                    action = ShapeActionEnum.SelectedControlsHidden;
                    hideControlsMenu = true;
                    removeOldShapes = false;
                }
            }
        }

        if (hideControlsMenu)
            HideControlsMenu();

        if (removeOldShapes)
            ClearActiveState();

        MyShapesState.Public_UpdateSingleShapeAndAction(selectedShape, action);
        MyShapesState.Public_GetFirstSelectedShapeState().SetActive(true);

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SingleShapeSelected", e);

        try
        {
            var message = "SvgManip.SingleShapeSelected: ";
            if (selectedShape == null || selectedShape.length == 0)
                message += "selected shape is null"
            else
                message += "selected shape id: " + selectedShape.attr("id")

            LogErrorMessage(message);
        } catch (e) { }
        try
        {
            LogErrorMessage("SvgManip.SingleShapeSelected: count of selected shapes: " + MyShapesState.Property_SelectedCount());
            LogErrorMessage("SvgManip.SingleShapeSelected: initial count of selected shapes: " + debugInitialSelectedCount);

        } catch (e)
        {

        }
    }
}
//#endregion

//#region Active Shape Management

function ClearShapeEvents()
{
    try
    {
        if (MyShapesState.Property_GetCurrentShapeAction() != ShapeActionEnum.SelectedControlsHidden)
        {
            MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Selected);
        }

        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.ClearShapeEvents", e);
    }
}

function ClearActiveState()
{
    try
    {
        //  var selectedShapes = MyShapesState.Public_GetAllSelectedShapeStates();

        //if (selectedShapes.length > 0)
        //{
        //    for (var i = 0; i < selectedShapes.length; i++)
        //    {
        //        selectedShapes[i].SetActive(false);
        //        selectedShapes[i].UpdateDrawing();
        //    }
        //}

        $("[id$=selection_box]").remove();

        MyMoveShapeAction.Public_ClearAction();

        MyShapesState.Public_ClearAllSelectedShapes();
        //MySelectedState.Property_SetCurrentShapeAction(ShapeActionEnum.Nothing); // done by ClearAll -abs 8/7/13

        HideControlsMenu();
    }
    catch (e)
    {
        //DebugLine("Failed to clear active state: " + e);
        LogErrorMessage("SvgManip.ClearActiveState", e);
    }
}

function UpdateActiveDrawing()
{
    try
    {
        var selectedShapes = MyShapesState.Public_GetAllSelectedShapeStates();

        if (selectedShapes.length == 0)
            return;

        for (var i = 0; i < selectedShapes.length; i++)
        {
            // JIRA-WEB-28 - not sure why 'undefined' wasn't like, but in any case, this is how things should be tested. 
           // Attempts to address errors around SvgManip.UpdateActiveDrawing: 'undefined' is not a function
            if ((selectedShapes[i] != null) && (typeof (selectedShapes[i]) != 'undefined'))
            {
                selectedShapes[i].UpdateDrawing();
            }
        }  
        DrawControlsMenu();

        
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UpdateActiveDrawing", e);
    }
}

//#endregion

//#region Create Multi Select Area
function HandleMultiSelectDrag(e)
{
}
//#endregion

//#region Dialog Management

function HideControlsMenu()
{
    try
    {
        MainControls.HideControlsBox();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.HideControlsMenu", e);
    }
}

function ShowHelpDialog()
{
    try
    {
        ClearActiveState();

        MyPointers.Dialog_Help.modal();
        if ($("#append-help-here").children().length == 0)
        {
            $("#append-help-here").load('/modal_help/storyboardcreatormodal');
        }

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.ShowHelpDialog", e);
    }
}




//function ShowHelpPrintDialog()
//{
//    try
//    {
//        ClearActiveState();
//        MyPointers.Dialog_HelpPrint.modal();
//    }
//    catch (e)
//    {
//        LogErrorMessage("SvgManip.ShowHelpPrintDialog", e);
//    }
//}




function ChangeStoryboardTypeDialog()
{
    try
    {
        ClearActiveState();

        MyPointers.Dialog_StoryboardType.modal();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.ChangeStoryboardTypeDialog", e);
    }
}

function CloseBasicDialog(dialogId)
{
    try
    {
        $("#" + dialogId).modal('hide');
    } catch (e)
    {
        LogErrorMessage("SvgManip.CloseBasicDialog", e);
    }
}
function CloseChangeStoryboardTypeDialog()
{
    try
    {
        MyPointers.Dialog_StoryboardType.modal('hide');
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.CloseChangeStoryboardTypeDialog", e);
    }

}

//function ChangeLayoutDialog2()
//{
//    try
//    {
//        ClearActiveState();

//        MyPointers.Dialog_ChangeLayout2.modal();
//    }
//    catch (e)
//    {
//        LogErrorMessage("SvgManip.ChangeLayoutDialog2", e);
//    }
//}

//function CloseLayoutDialog2()
//{
//    try
//    {
//        MyPointers.Dialog_ChangeLayout2.modal('hide');
//    }
//    catch (e)
//    {
//        LogErrorMessage("SvgManip.CloseLayoutDialog2", e);
//    }
//}

function ChangeLayoutDialog()
{
    try
    {
        ClearActiveState();

        if (StoryboardContainer.GetLayoutType() == StoryboardLayoutType.Spider) {
            MyPointers.Dialog_SpiderCellCount.modal();
        }
        else if (StoryboardContainer.GetLayoutType() == StoryboardLayoutType.Cycle) {
            MyPointers.Dialog_CycleCellCount.modal();
        }
        else if (StoryboardContainer.GetLayoutType() == StoryboardLayoutType.Timeline)
        {
            TimelineDateManager.PreparePopup(CellConfiguration.TimelineDates);
            MyPointers.Dialog_TimelineCellCount.modal();
        }
        else
        {
            PrepareChangeLayoutDialog();
            MyPointers.Dialog_ChangeLayout.modal();
        }
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.ChangeLayoutDialog", e);
    }
}


 
function DrawControlsMenu()
{  
    try
    {
        var currentShapeAction = MyShapesState.Property_GetCurrentShapeAction();

        if (currentShapeAction == ShapeActionEnum.Move
            || currentShapeAction == ShapeActionEnum.Resize
            || currentShapeAction == ShapeActionEnum.Rotating
            || currentShapeAction == ShapeActionEnum.SelectedControlsHidden)
        {
            return;
        }


        var shapeState = MyShapesState.Public_GetFirstSelectedShapeState();
        if (shapeState == null)
            return;

        // var t2 = performance.now();
        //  console.log(  t2 - t1 , 'Property_GetCurrentShapeAction') ;

        if( DrawMenuMask && GetGlobalById('controlsBox').style.display != 'none' )
        {  
            return;
        }
        else if( !DrawMenuMask )
        {
            DrawMenuMask = true;
            setTimeout(function(){ DrawMenuMask = false; }, 500);
        }
        MainControls.DrawMainControlsBox();
  //      var t3 = performance.now();
        // console.log( t3 -t2  , 'DrawMainControlsBox' ) ;


    }
    catch (e)
    {
        LogErrorMessage("SvgManip.DrawControlsMenu", e);
        ClearActiveState();
    }
}

function CheckForActiveDialogs()
{
    try
    {
        var isOpen = "isOpen";

        if (MyPointers.Dialog_ChangeLayout.hasClass('in'))
            return true;

        if (MyPointers.Dialog_CropImage.hasClass('in'))
            return true;

        if (MyPointers.Dialog_PoseImage.hasClass('in'))
            return true;

        if (MyPointers.Dialog_Help.hasClass('in'))
            return true;

        if (MyPointers.Dialog_PurchasePopForMoreLayouts.hasClass('in'))
            return true;

        if (MyPointers.Dialog_PurchasePopForMoreLayoutsOnCopy.hasClass('in'))
            return true;

        if (MyPointers.Dialog_PurchasePopForMoreStoryboardLayouts.hasClass('in'))
            return true;

        if (MyPointers.Dialog_PurchaseForUploads.hasClass('in'))
            return true;


        if (MyPointers.Dialog_UploadImage.hasClass('in'))
            return true;

        if (MyPointers.Dialog_CellSize.hasClass('in'))
            return true;

        if (MyPointers.Dialog_SpiderCellCount.hasClass('in'))
            return true;

        if (MyPointers.Dialog_CycleCellCount.hasClass('in'))
            return true;

        if (MyPointers.Dialog_TimelineCellCount.hasClass('in'))
            return true;

        if (MyPointers.Dialog_Policies.hasClass('in'))
            return true;

        if (MyPointers.Dialog_AdvancedButtons.hasClass('in'))
            return true;

        return false;
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.CheckForActiveDialogs", e);
    }

}
//#endregion



//#region Adding shapes

// Below methods very similiar to StoryboardContainerLibrary.GetCalculatedOffsetX/Y - Abs 2/13/15
function PageXtoStoryboardX(x)
{
    return x - StoryboardContainer.CoreSvgLeft + MyPointers.SvgContainer.scrollLeft();
}

function StoryboardXtoPageX(x)
{
    return x - MyPointers.SvgContainer.scrollLeft() + StoryboardContainer.CoreSvgLeft;
}

function PageYtoStoryboardY(y)
{
    return y - StoryboardContainer.CoreSvgTop + MyPointers.SvgContainer.scrollTop();
}

function StoryboardYtoPageY(y)
{
    return y - MyPointers.SvgContainer.scrollTop() + StoryboardContainer.CoreSvgTop;
}



function StretchToFill()
{
    StretchHelper(StoryboardContainer.DetermineBackDropCords, true);
}

function StretchToFill_Proportional()
{
    StretchHelper(StoryboardContainer.DetermineBackDropCords_Proportional, false);

}

function StretchHelper(stretchDimensionFunction, sendToBack)
{
    try
    {
        // Grab shape state
        var shapeState = MyShapesState.Public_GetFirstSelectedShapeState();

        // Grab actual shape
        var activeShape = MyShapesState.Public_GetFirstSelectedShape();
        var shapeId = activeShape.attr("id");

        // Get previous shape
        var prevShape = activeShape.prev();
        var prevShapeId = prevShape.attr("id");

        // Get current shape position info
        var positionBefore = { 'X': shapeState.X, 'Y': shapeState.Y, 'ScaleX': shapeState.ScaleX, 'ScaleY': shapeState.ScaleY };

        var newBackShapeId = prevShapeId;

        if (sendToBack)
        {
            // Send shape to back
            activeShape.detach();

            $("#CellDefinition").after(activeShape);
            newBackShapeId = "CellDefinition";
        }

        var areaBox = shapeState.Public_GetImaginaryOuterBox();

        var centeredX = (areaBox.Left + areaBox.Right) / 2;
        var centeredY = (areaBox.Top + areaBox.Bottom) / 2;
        // Stretch to fill cell
        var moveAndScale = stretchDimensionFunction(shapeState, centeredX, centeredY);
        if (moveAndScale == null)
            return;

        // set scale first, since it affects the crop offset (this is SHITTY code)
        shapeState.SetScale(moveAndScale.ScaleX, moveAndScale.ScaleY);
        shapeState.MoveTo(moveAndScale.MoveToX - shapeState.Property_ClippedOffsetX(), moveAndScale.MoveToY - shapeState.Property_ClippedOffsetY());

        // Get shape position info, after operation
        var positionAfter = { 'X': shapeState.X, 'Y': shapeState.Y, 'ScaleX': shapeState.ScaleX, 'ScaleY': shapeState.ScaleY };

        // Register in UR stack
        UndoManager.register(undefined, UndoStretchToFill, [shapeId, prevShapeId, positionBefore], '', undefined, UndoStretchToFill, [shapeId, newBackShapeId, positionAfter], '');

        // Update drawing
        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.StretchToFill", e);
    }
}


function UndoStretchToFill(shapeId, prevShapeId, position)
{
    try
    {
        // Move z_index back to normal
        var shapeToMove = $("#" + shapeId).detach();
        $("#" + prevShapeId).after(shapeToMove);

        // Move position & scale back to normal
        var shapeState = MyShapesState.Public_GetShapeStateById(shapeId);
        shapeState.SetScale(position.ScaleX, position.ScaleY);
        shapeState.MoveTo(position.X, position.Y);

        // Make sure shape is selected
        MyShapesState.Public_SelectShape(shapeToMove);

        // Update drawing
        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoStretchToFill", e);
    }
}



// This function is used when adding a Scene backdrop: don't make it undo-able!
function StretchToFillShape(shapeState, x, y)
{
    try
    {
        var moveAndScale = StoryboardContainer.DetermineBackDropCords(shapeState, x, y);
        if (moveAndScale == null)
        {
            return;
        }

        // set scale first, since it affects the crop offset (this is SHITTY code)
        shapeState.SetScale(moveAndScale.ScaleX, moveAndScale.ScaleY);
        shapeState.MoveTo(moveAndScale.MoveToX - shapeState.Property_ClippedOffsetX(), moveAndScale.MoveToY - shapeState.Property_ClippedOffsetY());

        SendShapeToBack();

        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.StretchToFillShape", e);
    }
}

function SetInitialShapeCords(item, bb, x, y, scale, shapeState)
{
    try
    {
        var width = bb.width;
        var height = bb.height;
 

        if (!NewShapeIsBackdrop)
        { // Ah, the humanity... All those offset calculations are a bit wacky...
            x -= (width * scale / 2);
            y -= (height * scale / 2);
        }

        shapeState.MoveTo(x, y);
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SetInitialShapeCords", e);
    }
}

function SetInitialShapeIds(item, id)
{
    try
    {
        item.children().first().children().first().children().first().attr("id", id + SvgPartsEnum.SvgImage);
        item.children().first().children().first().attr("id", id + "_natural");
        item.children().first().attr("id", id + "_scale");
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SetInitialShapeIds", e);
    }
}

function SetInitalShapeScale(item, shapeState, bb)
{
    try
    {
        var maxWidth = CellConfiguration.DefaultDropWidth;
        var maxHeight = CellConfiguration.DefaultDropHeight;

        var width = bb.width;
        var height = bb.height;
        var minX = (maxWidth) / width;
        var minY = (maxHeight) / height;

        var scale = Math.min(minX, minY);
        scale = Math.min(scale, 1); 

        shapeState.SetScale(scale, scale);
        return scale;
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SetInitalShapeScale", e);
    }
}

function SetInitialShapeOffset(item, shapeState)
{
    try
    {
        var id = item.attr("id");

        var bb = GetGlobalById(id).getBBox(); 

        var naturalXOffset = bb.x;
        var naturalYOffset = bb.y;
 

        shapeState.SetNaturalOffset(naturalXOffset, naturalYOffset);
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SetInitialShapeOffset", e);
    }
}

//#endregion


//#region Svg Manipulation Actions

//#region Mouse Based Rotation
function StartRotate(e)
{
    try
    {
        var circleId = e.currentTarget.id;
        var shapeId = $("#" + circleId).parent().parent().attr("id");
        var beingRotatedShapeState = MyShapesState.Public_GetShapeStateById(shapeId);
        MyRotateAction.ResetRotateImageAction(beingRotatedShapeState, e);

        LogUndo = true;
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Rotating);
    }
    catch (e)
    {
        //DebugLine(e);
        LogErrorMessage("SvgManip.StartRotate", e);
    }

    e.stopPropagation();

}

function RotateShape(e)
{
    try
    {
        var rotationAngle = MyRotateAction.CalculateRotationAngle(e);

        var selectedShapeStates = MyShapesState.Public_GetAllSelectedShapeStates();
        for (var i = 0; i < selectedShapeStates.length; i++)
        {
            selectedShapeStates[i].RotateShape(rotationAngle);
        }
        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.RotateShape", e);
    }

}

function HandleMouseStopRotating()
{
    try
    {
        var delta = MyRotateAction.Public_TotalAngleRotation();
        var selectedShapesStates = MyShapesState.Public_GetAllSelectedShapeStates();

        var undoArray = new Array();
        var redoArray = new Array();

        for (var i = 0; i < selectedShapesStates.length; i++)
        {
            var shapeState = selectedShapesStates[i];

            undoArray.push({ Id: shapeState.Id, Angle: delta * -1 });
            redoArray.push({ Id: shapeState.Id, Angle: delta });
        }

        UndoManager.register(undefined, UndoShapeRotate, undoArray, '', undefined, UndoShapeRotate, redoArray, '')

        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.HandleMouseStopRotating", e);
    }
}


function StopRotate(e)
{

}
//#endregion

//#region Mouse Based Resize

function StartResize(e)
{
    try
    {
        LogUndo = true;
        var id = this.id.toLowerCase();
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Resize);

        var activeShape = $("#" + id).parent().parent();
        var activeShapeState = MyShapesState.Public_GetShapeStateByShape(activeShape);

        MyResizeActions.Public_StartResize(activeShapeState, id);

        e.stopPropagation();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.StartResize", e);
    }
}

function ResizeShape(e)
{
    try
    {
        MyResizeActions.Public_ResizeShapes(e);
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.ResizeShape", e);
    }
}

function HandleShapeStopResizing()
{
    try
    {
        MyResizeActions.Public_StopResizing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.HandleShapeStopResizing", e);
    }
}

function StopResize()
{
}

//#endregion

function UnmovableShapeSelected()
{
    var selectedShapes = MyShapesState.Public_GetAllSelectedShapeStates();
    if (selectedShapes.length == 1)
    {
        if (selectedShapes[0].Movable == false)
            return true;
    }
    return false;
}

//#region Mouse Based Shape Move

function HandleShapeMove(e)
{
    try
    {
        var selectedShapes = MyShapesState.Public_GetAllSelectedMovableShapeStates(true);
        if (UnmovableShapeSelected())
            return;


        if (MyMoveShapeAction.UndoMoveX == null)
        {
            LogUndo = true;
            MyMoveShapeAction.Public_UpdateUndos(MyMoveShapeAction.MouseMoveOffsetX, MyMoveShapeAction.MouseMoveOffsetY);
        }
        var offsetX = e.pageX - MyMoveShapeAction.MouseMoveOffsetX;
        var offsetY = e.pageY - MyMoveShapeAction.MouseMoveOffsetY;

        MyMoveShapeAction.Public_UpdateMouseMoveOffsets(e.pageX, e.pageY);

        for (var i = 0; i < selectedShapes.length; i++)
        {
            selectedShapes[i].MoveDistance(offsetX, offsetY);
        }
        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.HandleShapeMove", e);

    }
}

function HandleShapeStopMove()
{
    try
    {
        var deltaX = MyMoveShapeAction.MouseMoveOffsetX - MyMoveShapeAction.UndoMoveX;
        var deltaY = MyMoveShapeAction.MouseMoveOffsetY - MyMoveShapeAction.UndoMoveY;

        MyMoveShapeAction.Public_UpdateUndos(null, null);

        if (deltaX != 0 || deltaY != 0)
        {
            var selectedShapes = MyShapesState.Public_GetAllSelectedMovableShapeStates(true);
            var undoArray = new Array();
            var redoArray = new Array();

            for (var i = 0; i < selectedShapes.length; i++)
            {
                undoArray.push({ Id: selectedShapes[i].Id, X: (deltaX * -1), Y: (deltaY * -1) });
                redoArray.push({ Id: selectedShapes[i].Id, X: deltaX, Y: deltaY });
            }

            UndoManager.register(undefined, UndoShapeMoveArray, undoArray, '', undefined, UndoShapeMoveArray, redoArray, '');
        }
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.HandleShapeStopMove", e);
    }
}

//#endregion

//#region Resize Cells

function ShowChangeCellSize()
{
    try
    {
        CloseModal(MyPointers.Dialog_AdvancedButtons);

        MyPointers.Dialog_CellSize.modal()

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.ShowChangeCellSize", e);
    }
}



function ExpandCells(scaleAmount, sliderValue, redraw)
{
    ClearActiveState();

    //DebugLine(scaleAmount + ", " + sliderValue);
    $("#cell-size-slider").data("previousValue", sliderValue);
    var newVal = $('#cell-size-slider').slider('setValue', sliderValue);

    var cellScaleAmount = (scaleAmount * CellConfiguration.CellWidth) / CellConfiguration.UnscaledCellWidth;//372;

    var newCellConfiguration = MyLayoutFactory.GetLayout(StoryboardContainer.GetLayoutType(), CellConfiguration.HasTitle, CellConfiguration.HasDescription, cellScaleAmount, CellConfiguration.GetLayoutConfig());

    StoryboardContainer.ChangeCellConfiguration_ScaleShapes(CellConfiguration, newCellConfiguration, scaleAmount);

    CellConfiguration.ExpandCells(scaleAmount);
    StoryboardContainer.ExpandCells(scaleAmount, redraw);
    StoryboardContainer.UpdateImageAttributions();

    if (HasGridLines())
    {
        AddGridLines();
    }
}


function AddSlider()
{
    //https://github.com/seiyria/bootstrap-slider
    $("#cell-size-slider").data("previousValue", 1);
    $('#cell-size-slider').slider({
        value: 1,
        formater: function (value)
        {
            return parseInt(value * 100) + "%";
        }

    });
    $('#cell-size-slider').on('slide', HandleCellSizeSlide);
    $('#cell-size-slider').on('slideStop', HandleCellSizeSlide);
 

}

function HandleCellSizeSlide(oldval1 , newval2)
{
    //var newVal = $('#cell-size-slider').slider('getValue');

    //DebugLine('chnage value',oldval1, newval2);
    var newVal = $('#cell-size-slider').slider('getValue');
    var oldVal = $(this).data("previousValue");

    var expansionAmount = newVal / oldVal;
    var undoAmount = oldVal / newVal;

    if (undoAmount == 1)
        return;

    ExpandCells(expansionAmount, newVal);


    UndoManager.register(undefined, ExpandCells, [undoAmount, oldVal], undefined, '', ExpandCells, [expansionAmount, newVal]);

}
//#endregion




//#region "Posables"
function SmartImageOptions(e)
{
    try
    {
        var active = MyShapesState.Public_GetFirstSelectedShapeState();
        HideControlsMenu();

        MyPosableControlsBox = new PosableControlsBox(active, PosableTypeEnum.SmartItem);
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SmartImageOptions", e);
    }
}

function PoseShape(e)
{
    try
    {
        var active = MyShapesState.Public_GetFirstSelectedShapeState();
        HideControlsMenu();

        MyPosableControlsBox = new PosableControlsBox(active, PosableTypeEnum.Character);
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.PoseShape", e);
    }
}
function InstaPoseClosure(instaPose)
{
    return function ()
    {
        var activeShape = MyShapesState.Public_GetFirstSelectedShapeState();

        var position = activeShape.Position;
        var redoActivePoseList = activeShape.Public_GetPoseGroupList();
        var redoPreviousPoseList = activeShape.Public_GetPreviousPoseList();


        var poseList = activeShape.Public_GetPose(instaPose);
        var poseArray = activeShape.Public_GetSafePoseArray(poseList);

        activeShape.Public_BulkUpdatePoseGroups(poseArray);
        activeShape.Public_SetPreviousPoseList(poseList);


        UndoManager.register(undefined, UndoPose, [activeShape.Id, redoActivePoseList, redoPreviousPoseList, position], '',
            undefined, UndoPose, [activeShape.Id, activeShape.Public_GetPoseGroupList(), activeShape.Public_GetPreviousPoseList(), position], '');
    }
}


function HandlePoseDialogClose(e)
{
    var activeShape = MyShapesState.Public_GetFirstSelectedShapeState();

    var undoInfo = MyPosableControlsBox.Public_UndoInfo;


    var redoPosition = activeShape.Position;
    var redoActivePoseList = activeShape.Public_GetPoseGroupList();
    var redoPreviousPoseList = activeShape.Public_GetPreviousPoseList();


    var shapeId = activeShape.Id;

    if (MyPosableControlsBox.Public_IsCancel == false)
    {
        UndoManager.register(undefined, UndoPose, [shapeId, undoInfo.UndoActivePoseList, undoInfo.UndoPreviousPoseList, undoInfo.UndoPosition], '',
            undefined, UndoPose, [shapeId, redoActivePoseList, redoPreviousPoseList, redoPosition], '');
    }
    else
    {
        UndoPose(shapeId, undoInfo.UndoActivePoseList, undoInfo.UndoPreviousPoseList, undoInfo.UndoPosition);
    }


}

function CancelPose(e)
{
    MyPosableControlsBox.Public_IsCancel = true;

    MyPointers.Dialog_PoseImage.modal('hide')
}

function UndoPose(id, activePoseList, previousPoseList, position)
{
    try
    {
        var shape = MyShapesState.Public_GetShapeStateById(id);

        shape.ChangeCharacterPosition(position)

        shape.Public_SetPreviousPoseList(previousPoseList); // is this correct or is it activePoseList????

        shape.Public_BulkUpdatePoseGroups(shape.Public_GetSafePoseArray(previousPoseList));
        shape.Public_BulkUpdatePoseGroups(shape.Public_GetSafePoseArray(activePoseList));

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoTextAlignment", e);
    }
}
//#endregion

//#region "Smart Scene"
function SmartSceneShape(e)
{
    try
    {
        var active = MyShapesState.Public_GetFirstSelectedShapeState();
        HideControlsMenu();

        MySmartSceneDialog = new SmartSceneDialog(active);
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SmartSceneShape", e);
    }
}


function HandleSmartSceneDialogClose(e)
{
    //in case the selected color changed!
    DrawControlsMenu();

    var activeShape = MyShapesState.Public_GetFirstSelectedShapeState();

    var selectedScenes = activeShape.SmartSceneState.GetSelectedSceneOptions();

    var selectedColors = null;
    if (activeShape.Property_IsColorable())
        selectedColors = activeShape.ColorableState.Public_GetColorStyles();

    var shapeId = activeShape.Id;

    if (MySmartSceneDialog.CancelButtonPressed == false)
    {
        UndoManager.register(undefined, UndoSmartScene, [shapeId, MySmartSceneDialog.UndoInfo_Colors, MySmartSceneDialog.UndoInfo_SelectedSceneOptions], '',
            undefined, UndoSmartScene, [shapeId, selectedColors, selectedScenes], '');
    }
    else
    {
        UndoSmartScene(shapeId, MySmartSceneDialog.UndoInfo_Colors, MySmartSceneDialog.UndoInfo_SelectedSceneOptions);
    }
}

function CancelSmartScene(e)
{
    MySmartSceneDialog.CancelButtonPressed = true;

    MyPointers.Dialog_SmartScene.modal('hide')
}

function UndoSmartScene(id, colors, sceneOptions)
{
    try
    {
        var shape = MyShapesState.Public_GetShapeStateById(id);

        if (colors != null)
            shape.ColorableState.Public_CopyColorStyles(colors)

        shape.SmartSceneState.SetSelectedSceneOptions(sceneOptions);

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoSmartScene", e);
    }
}
//#endregion

function ChangeCropBoxTitle(CropType)
{
    switch(CropType)
    {
        case CropTypeEnum.Standard:
            $('#CropBoxTitle').html("Standard Crop"); 
            break;

        case CropTypeEnum.Advanced:
            $('#CropBoxTitle').html("Advanced Crop");
            break;
        case CropTypeEnum.Circle:
            $('#CropBoxTitle').html("Circular Crop");
            break;
    }
}

function CropShapeChange(e)
{
    var active = MyShapesState.Public_GetFirstSelectedShapeState();
    ChangeCropBoxTitle(e.data.CropType);
    CropHelper.ChangeCropMode( active , e.data.CropType );
}

function CropShape(e)
{
    try
    {
        var active = MyShapesState.Public_GetFirstSelectedShapeState();

        HideControlsMenu();

        if (MyBrowserProperties.IsMobile)
        {
            $.touchyOptions.useDelegation = false;
        }
        ChangeCropBoxTitle(active.CropType);
        CropHelper.ShowCropDialog(active , active.CropType );
        //MyCroppedImage = new CroppedImageState(active);
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.CropShape", e);
    }
}

function RemoveCrop()
{
    try
    {
        if (MyBrowserProperties.IsMobile)
        {
            $.touchyOptions.useDelegation = true;
        }
        MyCroppedImage.RemoveCrop();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.RemoveCrop", e);
    }
}

function CancelCrop()
{
    try
    {
        if (MyBrowserProperties.IsMobile)
        {
            $.touchyOptions.useDelegation = true;
        }
        MyCroppedImage.CancelCrop();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.CancelCrop", e);
    }
}

function HandleCropSelection()
{
    try
    {
        if (MyBrowserProperties.IsMobile)
        {
            $.touchyOptions.useDelegation = true;
        }
        MyCroppedImage.UpdateCrop();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.HandleCropSelection", e);
    }
}

//#endregion 

//#region Layering

function BringShapeForward()
{
    try
    {
        var activeShape = MyShapesState.Public_GetFirstSelectedShape();

        var nextShape = activeShape.next()
        var nextShapeId = nextShape.attr("id");
        var shapeId = activeShape.attr("id");

        if (nextShapeId == "SvgTop")
            return;

        activeShape.detach();
        nextShape.after(activeShape);

        UndoManager.register(undefined, UndoShapeIndexBefore, [shapeId, nextShapeId], '', undefined, UndoShapeIndexAfter, [shapeId, nextShapeId], '');

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.BringShapeForward", e);
    }
}

function BringShapeToFront()
{
    try
    {
        var activeShape = MyShapesState.Public_GetFirstSelectedShape();

        var nextShape = activeShape.next()
        var nextShapeId = nextShape.attr("id");
        var shapeId = activeShape.attr("id");

        activeShape.detach();
        MyPointers.GetSvgTop().before(activeShape);

        UndoManager.register(undefined, UndoShapeIndexBefore, [shapeId, nextShapeId], '', undefined, UndoShapeIndexBefore, [shapeId, "SvgTop"], '');

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.BringShapeToFront", e);
    }
}

function SendShapeBackwards()
{
    try
    {
        var activeShape = MyShapesState.Public_GetFirstSelectedShape();

        var prevShape = activeShape.prev();
        var prevShapeId = prevShape.attr("id");
        var shapeId = activeShape.attr("id");

        if (prevShape.attr("id") == "CellDefinition")
            return;

        activeShape.detach();
        prevShape.before(activeShape);

        UndoManager.register(undefined, UndoShapeIndexAfter, [shapeId, prevShapeId], '', undefined, UndoShapeIndexBefore, [shapeId, prevShapeId], '');

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SendShapeBackwards", e);
    }
}

function SendShapeToBack()
{
    try
    {
        var activeShape = MyShapesState.Public_GetFirstSelectedShape();

        var prevShape = activeShape.prev();
        var prevShapeId = prevShape.attr("id");
        var shapeId = activeShape.attr("id");

        activeShape.detach();
        $("#CellDefinition").after(activeShape);

        UndoManager.register(undefined, UndoShapeIndexAfter, [shapeId, prevShapeId], '', undefined, UndoShapeIndexAfter, [shapeId, "CellDefinition"], '');

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SendShapeToBack", e);
    }

}

//#endregion

//#region Copy


//#endregion


//#region Delete




function DeleteShape()
{
    try
    {
        if (MyShapesState.Property_SelectedCount == 0)
        {
            return;
        }
        var selectedShapeStates = MyShapesState.Public_GetAllSelectedMovableShapeStates(false);
        var undoArray = new Array();
        var redoArray = new Array();


        for (var i = 0; i < selectedShapeStates.length; i++)
        {
            var activeShapeState = selectedShapeStates[i];
            var id = activeShapeState.Id;
            var activeShape = $("#" + id);

            var nextShape = activeShape.next()
            var nextShapeId = nextShape.attr("id");

            undoArray.push({ Detached: activeShape, NextShapeId: nextShapeId, Id: id, ShapeState: MyShapesState.Public_GetShapeStateById(id) });
            redoArray.push({ Id: id });

            MyShapesState.Public_RemoveShapeStateById(id);
            var detached = $("#" + id).detach();
        }


        UndoManager.register(undefined, UndoDeleteShape, undoArray, '', undefined, UndoShapeAdd, redoArray, '')

        MyShapesState.Public_ClearAllSelectedShapes();
        HideControlsMenu();

        // could be smarter, but this won't be called that often
        StoryboardContainer.UpdateImageAttributions();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.DeleteShape", e);
    }
}

function DeleteAll(e)
{
    try
    {
        if (confirm(MyLangMap.GetText("warning-clear-all")) == false)
        {
            return;
        }
        var shapeStates = MyShapesState.Public_GetAllShapeStates();
        for (shapeId in MyShapesState.Private_ShapeStates)
        {
            var shapeState = MyShapesState.Public_GetShapeStateById(shapeId);
            if (shapeState == null)
                continue;

            $("#" + shapeState.Id).remove();
            MyShapesState.Public_RemoveShapeStateById(shapeId);

        }

        MyShapesState.Public_ResetShapeStates();
        MyShapesState.Public_ClearAllSelectedShapes();
        StoryboardContainer.Public_ResetLayout();

        UndoManager.clear();
        ClearActiveState();

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.DeleteAll", e);
    }
}

//#endregion

//#region Rotate

function RotateLeft()
{
    try
    {
        QuickRotate(-90);
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.RotateLeft", e);
    }
}

function RotateRight()
{
    try
    {
        QuickRotate(90);
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.RotateRight", e);
    }
}

function QuickRotate(angle)
{
    try
    {
        var undoArray = new Array();
        var redoArray = new Array();
        var selectedShapesStates = MyShapesState.Public_GetAllSelectedMovableShapeStates(true);

        if (selectedShapesStates.length === 0)
            return;

        for (var i = 0; i < selectedShapesStates.length; i++)
        {
            //if (selectedShapesStates[i].Movable == false)
            //    continue;

            var shapeState = selectedShapesStates[i];
            shapeState.RotateShape(angle);

            undoArray.push({ Id: shapeState.Id, Angle: angle * -1 });
            redoArray.push({ Id: shapeState.Id, Angle: angle });
        }

        UndoManager.register(undefined, UndoShapeRotate, undoArray, '', undefined, UndoShapeRotate, redoArray, '')

        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.QuickRotate", e);
    }
}

//#endregion

//#region "Align"



//#endregion"
//#region Flip

function FlipVertical()
{
    try
    {
        var undoArray = new Array();
        var selectedShapesStates = MyShapesState.Public_GetAllSelectedMovableShapeStates(true);

        if (selectedShapesStates.length === 0)
            return;

        for (var i = 0; i < selectedShapesStates.length; i++)
        {
            //if (selectedShapesStates[i].Movable == false)
            //    continue;

            var shapeState = selectedShapesStates[i];
            shapeState.FlipShapeVertical();

            undoArray.push({ Id: shapeState.Id });
        }

        UpdateActiveDrawing();
        UndoManager.register(undefined, UndoFlipVertical, undoArray, '', undefined, UndoFlipVertical, undoArray, '');
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.FlipVertical", e);
    }
}

function FlipHorizontal()
{
    try
    {
        var undoArray = new Array();
        var selectedShapesStates = MyShapesState.Public_GetAllSelectedMovableShapeStates(true);

        if (selectedShapesStates.length === 0)
            return;

        for (var i = 0; i < selectedShapesStates.length; i++)
        {
            //if (selectedShapesStates[i].Movable == false)
            //    continue;

            var shapeState = selectedShapesStates[i];
            shapeState.FlipShapeHorizontal();

            undoArray.push({ Id: shapeState.Id });
        }

        UpdateActiveDrawing();
        UndoManager.register(undefined, UndoFlipHorizontal, undoArray, '', undefined, UndoFlipHorizontal, undoArray, '');
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.FlipHorizontal", e);
    }
}

//#endregion

//#region Color Filters
function FilterColorMode(mode)
{
    try
    {
        if (mode == "url(#)")
            return;

        var undoArray = new Array();
        var redoArray = new Array();
        var selectedShapesStates = MyShapesState.Public_GetAllSelectedMovableShapeStates(false);

        if (selectedShapesStates.length === 0)
            return;

        for (var i = 0; i < selectedShapesStates.length; i++)
        {
            //if (selectedShapesStates[i].Movable == false)
            //    continue;

            var shapeState = selectedShapesStates[i];
            undoArray.push({ Id: shapeState.Id, Mode: shapeState.FilterColorMode });
            shapeState.FilterColorMode = mode;
            redoArray.push({ Id: shapeState.Id, Mode: shapeState.FilterColorMode });
        }

        UpdateActiveDrawing();
        UndoManager.register(undefined, UndoFilterColorMode, undoArray, '', undefined, UndoFilterColorMode, redoArray, '');
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.FilterColorMode", e);
    }
}

function UndoFilterColorMode()
{
    try
    {
        MyShapesState.Public_ClearAllSelectedShapes();
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Selected);

        for (var i = 0; i < arguments.length; i++)
        {
            var id = arguments[i].Id;
            var mode = arguments[i].Mode;
            var shape = MyShapesState.Public_GetShapeStateById(id);

            shape.FilterColorMode = mode;
            MyShapesState.Public_SelectShape($("#" + id));

        }

        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoFilterColorMode", e);
    }
}
//#endregion

//#region Item Locking

// NOT IN USE YET - abs 2/5/15
function LockSelected()
{
    SetLockState(true);
}
function UnlockSelected()
{
    SetLockState(false);
}
function SetLockState(mode)
{
    try
    {
        var undoArray = new Array();
        var redoArray = new Array();
        var selectedShapesStates = MyShapesState.Public_GetAllSelectedShapeStates();

        if (selectedShapesStates.length === 0)
            return;

        for (var i = 0; i < selectedShapesStates.length; i++)
        {
            var shapeState = selectedShapesStates[i];
            undoArray.push({ Id: shapeState.Id, Mode: shapeState.IsLocked });
            shapeState.SetLockState(mode);
            redoArray.push({ Id: shapeState.Id, Mode: shapeState.IsLocked });
        }

        UpdateActiveDrawing();
        UndoManager.register(undefined, UndoSetLockState, undoArray, '', undefined, UndoSetLockState, redoArray, '');
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SetLockState", e);
    }
}

function UndoSetLockState()
{
    try
    {
        MyShapesState.Public_ClearAllSelectedShapes();
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Selected);

        for (var i = 0; i < arguments.length; i++)
        {
            var id = arguments[i].Id;
            var mode = arguments[i].Mode;
            var shape = MyShapesState.Public_GetShapeStateById(id);

            shape.SetLockState(mode);
            MyShapesState.Public_SelectShape($("#" + id));

        }

        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoSetLockState", e);
    }
}

//#endregion

//#region Keyboard Scale

function QuickShapeScale(scale)
{
    try
    {
        var selectedShapes = MyShapesState.Public_GetAllSelectedMovableShapeStates(true);
        var undoArray = new Array();
        var redoArray = new Array();

        if (selectedShapes.length == 0)
            return;

        for (var i = 0; i < selectedShapes.length; i++)
        {
            //if (selectedShapes[i].Movable == false)
            //    continue;

            var activeShape = selectedShapes[i];
            var oldScaleX = activeShape.ScaleX;
            var oldScaleY = activeShape.ScaleY;

            activeShape.ChangeScale(scale);

            var newScaleX = activeShape.ScaleX;
            var newScaleY = activeShape.ScaleY;


            undoArray.push({ Id: activeShape.Id, ScaleX: oldScaleX, ScaleY: oldScaleY });
            redoArray.push({ Id: activeShape.Id, ScaleX: newScaleX, ScaleY: newScaleY });
        }

        UndoManager.register(undefined, UndoShapeResize, undoArray, '', undefined, UndoShapeResize, redoArray, '');
        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.QuickShapeScale", e);
    }

}

//#endregion

//#region Keyboard Move

function QuickShapeMove(x, y)
{
    try
    {
        var undoArray = new Array();
        var redoArray = new Array();

        var selectedShapes = MyShapesState.Public_GetAllSelectedMovableShapeStates(true);
        if (selectedShapes.length == 0)
            return;


        for (var i = 0; i < selectedShapes.length; i++)
        {
            //if (selectedShapes[i].Movable == false)
            //    continue;

            selectedShapes[i].MoveDistance(x, y);
            undoArray.push({ Id: selectedShapes[i].Id, X: (x * -1), Y: (y * -1) });
            redoArray.push({ Id: selectedShapes[i].Id, X: x, Y: y });
        }

        UndoManager.register(undefined, UndoShapeMoveArray, undoArray, '', undefined, UndoShapeMoveArray, redoArray, '');
        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.QuickShapeMove", e);
    }
}

//#endregion

//#region Text Manipulation

function InitializeFontSelector()
{
    try
    {
        var fontsArray = [
            'Coustard',
            'Creepster',
            'Francois One',
            'Germania One',
            'Komika Text',
            'Lobster Two',
            'Lora',
            'Montserrat Alternates',
            'OpenDyslexic',
            'Roboto',
        ];
        var prettyFontsArray =
            [
                'Coustard',
                'Creepster',
                'Francois One',
                'Germania One',
                'Komika',
                'Lobster Two',
                'Lora',
                'Montserrat',
                'Open Dyslexic',
                'Roboto',
            ];

        for (var i = 0; i < ExtraFonts.length; i++)
        {
            fontsArray.push(ExtraFonts[i].Css);
            prettyFontsArray.push(ExtraFonts[i].Name);

        }
        //if (FontSelection.Agsana)
        //{
        //    fontsArray.push('angsana new');
        //    prettyFontsArray.push(FontAgsana);
        //}
        //if (FontSelection.Batang)
        //{
        //    fontsArray.push('batang');
        //    prettyFontsArray.push(FontBatang);
        //}

        //if (FontSelection.Himilaya)
        //{
        //    fontsArray.push('microsoft himalaya');
        //    prettyFontsArray.push(FontHimalaya);
        //}
        //if (FontSelection.Meiryo)
        //{
        //    fontsArray.push('meiryo');
        //    prettyFontsArray.push(FontMeiryo);
        //}
        //if (FontSelection.MsMincho)
        //{
        //    fontsArray.push('ms mincho');
        //    prettyFontsArray.push(FontMsMincho);
        //}
        //if (FontSelection.NomNa)
        //{
        //    fontsArray.push('nom na tong');
        //    prettyFontsArray.push(FontNomNa);
        //}
        //if (FontSelection.SimSun)
        //{
        //    fontsArray.push('simsun');
        //    prettyFontsArray.push(FontSimSun);
        //}

        if (UseQuill == false && UseSummerNote==false)
        {
            MyPointers.Controls_TextableControls_FontSelector.fontSelector({
                'hide_fallbacks': true,
                'initial': 'Courier New,Courier New,Courier,monospace',
                'selected': FontSelectionChange,
                'fonts': fontsArray,
                'PrettyFonts': prettyFontsArray,
            });
        }
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.InitializeFontSelector", e);
    }
}

function FontSelectionChange(style)
{
    try
    {
        var shape = MyShapesState.Public_GetFirstSelectedShapeState();
        if (shape == null)
            return;

        var oldFont = shape.GetFontFace();

        SetFontSelection(style, shape.Id);

        $("#textableText").focus();

        var newFont = shape.GetFontFace();

        UndoManager.register(undefined, UndoFontFaceChange, [shape.Id, oldFont], '', undefined, UndoFontFaceChange, [shape.Id, newFont], '')

        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.FontSelectionChange", e);
    }
}


function SetFontSelection(fontName, shapeId)
{
    try
    {
        var shape = MyShapesState.Public_GetShapeStateById(shapeId);

        if (shape == null)
            return;

        shape.SetFontFace(fontName);
        shape.UpdateDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SetFontSelection", e);
    }
}


function UpdateFontColor(color)
{
    try
    {
        var shape = MyShapesState.Public_GetFirstSelectedShapeState();
        if (shape == null)
            return;

        //e.stopPropagation();

        var oldColor = shape.GetSavedFontColor();
        if (oldColor == color.toHexString())
            return;

        UndoManager.register(undefined, UndoFontColor, [shape.Id, oldColor], '', undefined, UndoFontColor, [shape.Id, color.toHexString()], '')
        shape.SetFontColor(color.toHexString(), false);

        shape.UpdateDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UpdateFontColor", e);
    }
}

function PreviewUpdateFontColor(color)
{
    try
    {
        var shape = MyShapesState.Public_GetFirstSelectedShapeState();
        if (shape == null)
            return;

        shape.SetFontColor(color.toHexString(), true);
        shape.UpdateDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.PreviewUpdateFontColor", e);
    }
}

function UpdateFontColorHidden(e)
{
    try
    {
        var shape = MyShapesState.Public_GetFirstSelectedShapeState();

        if (shape == null)
            return;

        shape.ResetFontColor();
        shape.UpdateDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UpdateFontColorHidden", e);
    }
}

function UpdateFontSize(e)
{
    try
    {
        var shape = MyShapesState.Public_GetFirstSelectedShapeState();
        if (shape == null)
            return;

        e.stopPropagation();
        var newSize = $("#sizeSelector").val();
        var oldSize = shape.GetFontSize();
        if (oldSize == newSize)
            return;

        UndoManager.register(undefined, UndoFontSize, [shape.Id, oldSize], '', undefined, UndoFontSize, [shape.Id, newSize], '');
        shape.SetFontSize(newSize);

        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UpdateFontSize", e);
    }
}


function UpdateTextAlignment(align)
{
    try
    {
        var shape = MyShapesState.Public_GetFirstSelectedShapeState();
        if (shape == null)
            return;

        var newValue = align;
        var oldValue = shape.GetTextAlignment();
        if (oldValue == newValue)
            return;

        UndoManager.register(undefined, UndoTextAlignment, [shape.Id, oldValue], '', undefined, UndoTextAlignment, [shape.Id, newValue], '');
        shape.SetTextAlignment(newValue);

        MyPointers.Controls_TextableControls_TextAlignmentSelectors.removeClass("active");
        MyPointers.Controls_TextableControls_TextAlignmentSelectors.filter("." + newValue).addClass("active");

        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UpdateTextAlignment", e);
    }
}



function SetTextableText_Quill(a, b, c, d, e)
{
    try
    {
        var shapeState = MyShapesState.Public_GetFirstSelectedShapeState();
        if (shapeState == null)
            return;


        var newQuillDeltas = quill.getContents().ops;
        if (SbtLib.DeepCompareEquality(shapeState.TextState.Public_GetQuillDeltas(), newQuillDeltas) == false)
        {
            var oldQuill = shapeState.TextState.Public_GetQuillDeltas();
            shapeState.TextState.Public_SetQuillDeltas(newQuillDeltas);

            //shapeState.AddText_Quill();

            UndoManager.register(undefined, UndoTextChangeQuill, [shapeState.Id, oldQuill], '', undefined, UndoTextChangeQuill, [shapeState.Id, newQuillDeltas], '')
            UpdateActiveDrawing();

            //backwardss compability
            shapeState.SetText(quill.getText());
            quill.history.clear();

            SbtQuillHelper.HandleWhiteText();
        }

        //if (oldText != newText)
        //{
        //    shape.SetText(newText);
        //    
        //}
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SetTextableText", e);
    }
}
function SetTextableText(e)
{
    try
    {
        var shape = MyShapesState.Public_GetFirstSelectedShapeState();
        if (shape == null)
            return;

        if (e != null)
        {
            e.stopPropagation();
        }

        var newText = $("#textableText").val();
        var oldText = shape.GetText();

        if (oldText != newText)
        {
            shape.SetText(newText);
            UndoManager.register(undefined, UndoTextChange, [shape.Id, oldText], '', undefined, UndoTextChange, [shape.Id, newText], '')
            UpdateActiveDrawing();
        }
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SetTextableText", e);
    }
}

//#endregion

//#region Undo

function Undo(e)
{
    try
    {
        if (CheckForActiveDialogs())
            return;

        UndoManager.undo()
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.Undo", e);
    }
}

function Redo(e)
{
    try
    {
        UndoManager.redo()
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.Redo", e);
    }
}

//#endregion

//#region Touch Events

function TouchyShapeSelected(event, phase, $target, data)
{
    try
    {
        if (CheckForActiveDialogs())
            return;

        var action = ShapeActionEnum.Selected;
        $target.attr("id");

        if (MyShapesState.Property_SelectedCount() > 0)
        {
            var activeShape = MyShapesState.Public_GetFirstSelectedShape();
            if (activeShape.attr("id") == $(this).attr("id"))
            {
                return;
            }
        }
        ClearActiveState();

        MyShapesState.Public_UpdateSingleShapeAndAction($target, action);

        MyShapesState.Public_GetFirstSelectedShapeState();

        UpdateActiveDrawing();

        // SEBC 2014-01-12 - I do not understand why I have to do this, but if I don't, I cannot select another shape, after selecting and interacting with a first object?!?
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Nothing);
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.TouchyShapeSelected", e);
    }
}

var _TouchyRotateStarted = false;
function HandleTouchyRotate(event, phase, $target, data)
{
    try
    {
        if (CheckForActiveDialogs())
            return;

        if (MyShapesState.Property_SelectedCount() == 0)
        {
            return;
        }

        if (data.startPoint == null)
        {
            return;
        }

        if (data.movePoint == null)
        {
            return;
        }


        var shapeState = MyShapesState.Public_GetFirstSelectedShapeState();
        var currentX = PageXtoStoryboardX(data.movePoint.x);//StoryboardContainer.GetCalculatedOffsetX(data.movePoint.x);
        var currentY = PageYtoStoryboardY(data.movePoint.Y);//StoryboardContainer.GetCalculatedOffsetY(data.movePoint.y);

        switch (phase)
        {
            case 'start':
                _TouchyRotateStarted = true;
                HideControlsMenu();

                MyRotateAction.ResetRotateImageAction(shapeState, { 'pageX': data.movePoint.x, 'pageY': data.movePoint.y });
                LogUndo = true;
                shapeState.UpdateDrawing();
                break;

            case 'move':
                if (!_TouchyRotateStarted)
                {
                    return;
                }
                var angleDelta = MyRotateAction.CalculateRotationAngle({ 'pageX': data.movePoint.x, 'pageY': data.movePoint.y });
                shapeState.RotateShape(angleDelta);
                shapeState.UpdateDrawing();
                break;

            case 'end':
                if (!_TouchyRotateStarted)
                {
                    return;
                }
                _TouchyRotateStarted = false;
                HandleMouseStopRotating();
                DrawControlsMenu();

                // SEBC 2014-01-12 - I do not understand why I have to do this, but if I don't, I cannot select another shape, after selecting and interacting with a first object?!?
                MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Nothing);
                break;
        }
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.HandleTouchyRotate", e);
    }
}

var _TouchyDragStarted = false;
function HandleTouchyDrag(event, phase, $target, data)
{
    try
    {
        if (CheckForActiveDialogs())
            return;

        if (MyShapesState.Property_SelectedCount() == 0)
        {
            return;
        }

        if (skipNextDrag)
        {
            skipNextDrag = false;
            return;
        }

        var shapeState = MyShapesState.Public_GetFirstSelectedShapeState();

        var deltaX = data.movePoint.x - data.lastMovePoint.x;
        var deltaY = data.movePoint.y - data.lastMovePoint.y;

        switch (phase)
        {
            case 'start':
                _TouchyDragStarted = true;
                HideControlsMenu();

                MyMoveShapeAction.Public_ClearAction();
                LogUndo = true;
                MyMoveShapeAction.Public_UpdateUndos(0, 0);

                MyMoveShapeAction.Public_UpdateMouseMoveOffsets(deltaX, deltaY);
                shapeState.MoveDistance(deltaX, deltaY);
                shapeState.UpdateDrawing();

                break;

            case 'move':
                if (!_TouchyDragStarted)
                {
                    return;
                }
                MyMoveShapeAction.Public_UpdateMouseMoveOffsets(deltaX + MyMoveShapeAction.MouseMoveOffsetX, deltaY + MyMoveShapeAction.MouseMoveOffsetY);
                shapeState.MoveDistance(deltaX, deltaY);
                shapeState.UpdateDrawing();
                break;

            case 'end':
                if (!_TouchyDragStarted)
                {
                    return;
                }
                _TouchyDragStarted = false;
                HandleShapeStopMove();
                DrawControlsMenu();

                // SEBC 2014-01-12 - I do not understand why I have to do this, but if I don't, I cannot select another shape, after selecting and interacting with a first object?!?
                MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Nothing);
                break;
        }
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.HandleTouchyDrag", e);
    }
}

var _TouchyPinchStarted = false;
function HandleTouchyPinch(event, phase, $target, data)
{
    try
    {
        if (CheckForActiveDialogs())
            return;

        if (MyShapesState.Property_SelectedCount() == 0)
        {
            return;
        }

        // Grab the shape currently being manipulated
        var shapeState = MyShapesState.Public_GetFirstSelectedShapeState();
        switch (phase)
        {
            case 'start':
                _TouchyPinchStarted = true;
                // Hide control menu while the operation is in progress
                HideControlsMenu();

                // Initiate resize, to track current shape position for UR stack
                MyResizeActions.Public_StartResize(shapeState, shapeState.Id);

                break;

            case 'move':
                if (!_TouchyPinchStarted)
                {
                    return;
                }
                // Handle pinch data to perform the resize operation
                MyResizeActions.ResizeViaPinch(data);

                break;

            case 'end':
                if (!_TouchyPinchStarted)
                {
                    return;
                }
                _TouchyPinchStarted = false;
                // Conclude the resize operation, which will log data to the UR stack for undo support
                HandleShapeStopResizing();
                // And show control menu again
                DrawControlsMenu();

                // SEBC 2014-01-12 - I do not understand why I have to do this, but if I don't, I cannot select another shape, after selecting and interacting with a first object?!?
                MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Nothing);
                break;

        }
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.HandleTouchyPinch", e);
    }
}

//#endregion

//#region Coloring
function ColorableHelper_GetRegionFromId(id)
{
    try
    {
        var region = id.replace("ColorSelector_", "");
        var region = region.replace("div_", "");
        region = region.substring(0, region.indexOf("_"));

        return region;
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.ColorableHelper_GetRegionFromId", e);
    }
}

function UndoColorChange(id, region, color)
{
    try
    {
        MyShapesState.Public_ClearAllSelectedShapes();
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Selected);

        var shape = MyShapesState.Public_GetShapeStateById(id);
        MyShapesState.Public_SelectShape($("#" + id));
        shape.Public_SetColorForRegion(region, color, false, true, false);

        shape.UpdateDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoColorChange", e);
    }
}

function UpdateColorRegionFromColorPicker(color)
{
    try
    {
        var region = ColorableHelper_GetRegionFromId(this.id);
        var selectedColor = color.toRgbString();

        var shapeState = MyShapesState.Public_GetFirstSelectedShapeState();
        if (shapeState != null)
        {
            shapeState.Public_SetColorForRegion(region, selectedColor, false, false, true);
        }
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UpdateColorRegionFromColorPicker", e);
    }
}

function UpdateColorRegionFromColorPickerPreview(color)
{
    try
    {
        var region = ColorableHelper_GetRegionFromId(this.id);
        var selectedColor = color.toRgbString();

        var shapeState = MyShapesState.Public_GetFirstSelectedShapeState();
        if (shapeState != null)
        {
            shapeState.Public_SetColorForRegion(region, selectedColor, true, false, false);
        }
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UpdateColorRegionFromColorPickerPreview", e);
    }
}

function UpdateColorRegionFromColorPickerHide(e)
{
    try
    {
        var shapeState = MyShapesState.Public_GetFirstSelectedShapeState();

        var region = ColorableHelper_GetRegionFromId(this.id);
        if (shapeState != null)
        {
            shapeState.Public_SetColorForRegion(region, shapeState.Public_GetColorForRegion(region), true, false, false);
        }
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UpdateColorRegionFromColorPickerHide", e);
    }
}

function UpdateColorRegion(e)
{
    try
    {
        var shapeState = MyShapesState.Public_GetFirstSelectedShapeState();
        var selectedColorBox = $("#" + e.target.id);
        var selectedColor = selectedColorBox.css("background-color");

        var region = ColorableHelper_GetRegionFromId(e.target.id);

        shapeState.Public_SetColorForRegion(region, selectedColor, false, true, true);
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UpdateColorRegion", e);
    }
}

function WhiteOutShape()
{
    BlankOutShape("rgb(255, 255, 255)", "#fff", WhiteOutShape);
}

function BlackOutShape()
{
    BlankOutShape("rgb(0, 0, 0)", "#000", BlackOutShape);
}

// ------------------------------ ArtPen Function -------------------------------------

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
            color.length > 7 ? parseInt(color.substr(7, 2), 16)/255 : 1];
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
} 
 
function colorValues(color)
{
    var x = getcolorValues(color);
    var conv_col = 0;

    if( x != undefined )
        conv_col = Math.round( (x[0] * 0.2126 + x[1] * 0.7152 + x[2] * 0.0722 ) );
//return (x[0]+ x[1] + x[2] ) / 3;


    return Math.round( Math.sqrt(conv_col / 255.0)*255.0);
}

function ApplyArtPen( selObj )
{
    var max_col = colorValues('#000000'), min_col =colorValues('#ffffff');
    var rrType=['path','polygon','rect','ellipse','circle','line']; 

    for( var j = 0 ; j < rrType.length; j++ )
    {
        var iterms = selObj.getElementsByTagName(rrType[j]);
        for (var i = 0; i < iterms.length ; i++) {
            //iterms[i].style("stroke-width", 6);
            //console.log( iterms[i] );

            if( iterms[i].getAttributeNS( null , 'fill' ) == null || iterms[i].getAttributeNS( null , 'fill' ) == 'none' || iterms[i].getAttributeNS(null,'fill').substr(0,3) =="url" ) 
                continue;

            var old_strokewidth  = iterms[i].getAttributeNS( null , 'stroke-width' );
            var old_stroke      = iterms[i].getAttributeNS( null , 'stroke' );

            iterms[i].setAttributeNS(null , 'stroke-width' , 4 );
            iterms[i].setAttributeNS(null , 'stroke' , 'rgb(12,12,12)');

            var y = colorValues( iterms[i].getAttributeNS( null , 'fill' ) );

            var oldColor = iterms[i].getAttributeNS( null , 'fill' );
            oldColor = ((oldColor == null || oldColor == "") ? "#000" : oldColor);

            iterms[i].setAttributeNS( null , "old_fill", oldColor);
            iterms[i].setAttributeNS( null , "fill", 'rgb('+y+','+y+','+y+')' );

            iterms[i].setAttributeNS( null , "old_strokewidth", old_strokewidth);
            iterms[i].setAttributeNS( null , "old_stroke", old_stroke);            

            //console.log( iterms[i].getAttributeNS( null, 'fill' ) );
        }
    } 
};

function ArtpenShape()
{
    try
    {
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Selected);

        var selectedShapes = MyShapesState.Public_GetAllSelectedShapeStates();
        if( selectedShapes.length == 0 ) return;

        var undoColorsCollect = [];

        for (var t = 0; t < selectedShapes.length; t++)
        {
            var activeShape = selectedShapes[t];
            var svgImage = GetGlobalById( activeShape.Id );
            var regionList = activeShape.Public_GetColorRegions();
            var undoColors = [];
            if (regionList != null)
            {
                for (var i = 0; i < regionList.length; i++)
                {
                    if (regionList[i] == "")
                        continue;

                    undoColors.push({ Region: regionList[i], Color: activeShape.Public_GetColorForRegion(regionList[i]) });
    
                    var currentColor = activeShape.Public_GetColorForRegion(regionList[i]);
    
                    var y = colorValues(currentColor);
                    activeShape.Public_SetColorForRegion(regionList[i],  'rgb('+y+','+y+','+y+')', false, false, false);
                }
            }

            var preFilterColorMode = activeShape.FilterColorMode;
            activeShape.FilterColorMode = "url(#grayscale)";
            
            ApplyArtPen(document.getElementById(activeShape.Id + '_natural'));
            
            undoColorsCollect.push({ id: activeShape.Id , undoColors:undoColors , preFilterColorMode:preFilterColorMode});
        }

        UndoManager.register( undefined, UndoBlankOut, [ undoColorsCollect ], '', undefined, ArtpenShape,
          [null, undoColorsCollect], '' );

        DrawControlsMenu();
        UpdateActiveDrawing();

        // if doing an undo, undomanager won't let you add another undo!
        //UndoManager.register(undefined, UndoBlankOut, [activeShape.Id, undoColors], '', undefined, redoFunction, [null, activeShape.Id], '');
        //DrawControlsMenu();
    }
    catch (e)
    {
 
         LogErrorMessage("SvgManip.ArtpenShape", e);;
   }
}

function BlankOutShape(rgbColor, hexColor, redoFunction)
{
    try
    {
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Selected);

        var selectedShapes = MyShapesState.Public_GetAllSelectedShapeStates();
        if( selectedShapes.length == 0 ) return;

        var undoColorsCollect = [];

        for (var t = 0; t < selectedShapes.length; t++)
        {
            var activeShape = selectedShapes[t];
            var regionList = activeShape.Public_GetColorRegions();

            var undoColors = [];
            if (regionList != null)
            {
                for (var i = 0; i < regionList.length; i++)
                {
                    if (regionList[i] == "")
                        continue;

                    undoColors.push({ Region: regionList[i], Color: activeShape.Public_GetColorForRegion(regionList[i]) });
                    activeShape.Public_SetColorForRegion(regionList[i], rgbColor, false, false, false);
                }
            }

            var svgImage = $("#" + activeShape.Id);
            FadeToBlankOut(svgImage, hexColor);
            undoColorsCollect.push({ id: activeShape.Id , undoColors:undoColors});
        }
        UndoManager.register(undefined, UndoBlankOut, [undoColorsCollect] , '', undefined, redoFunction, [null, undoColorsCollect], '');

        DrawControlsMenu();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.BlankOutShape", e);
    }
}

function FadeToBlankOut(svgPart, newColor)
{
    try
    {
        var skip = false;

        // skip outer white line, and skip no fill
        if (svgPart.attr("fill") == "#FFFFFC" || svgPart.attr("fill") == "none")
            skip = true;

        if (svgPart.attr("opacity") != null)
            skip = true;

        if (svgPart.is("g") || svgPart.is("svg") || svgPart.is("defs"))
            skip = true;

        if (skip == false)
        {
            //if (svgPart.attr("fill") == "white")
            //    svgPart.attr("stroke", "black");
            var oldColor = svgPart.attr("fill");
            oldColor = ((oldColor == null || oldColor == "") ? "#000" : oldColor);

            svgPart.attr("old_fill", oldColor);
            svgPart.attr("fill", newColor); //use RGB so shows up in color selector

        }
        for (var i = 0; i < svgPart.children().length; i++)
        {
            FadeToBlankOut($(svgPart.children()[i]), newColor);
        }
    } catch (e)
    {
        LogErrorMessage("SvgManip.FadeToBlankOut", e);
    }
}



function UndoBlankOut(undoColorsCollect)
{
    try
    { 
        MyShapesState.Public_ClearAllSelectedShapes();
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Selected);
        for( var t = 0 ; t < undoColorsCollect.length ; t++ )
        {
            var shape = MyShapesState.Public_GetShapeStateById(undoColorsCollect[t].id);
            MyShapesState.Public_SelectShape($("#" + undoColorsCollect[t].id));

            var svgImage = $("#" + undoColorsCollect[t].id);
            UndoFadeToBlankOutHelper(svgImage);

            for (var i = 0; i < undoColorsCollect[t].undoColors.length; i++)
            {
                shape.Public_SetColorForRegion(undoColorsCollect[t].undoColors[i].Region, undoColorsCollect[t].undoColors[i].Color, false, false, false);
            }

            
            if( undoColorsCollect[t].preFilterColorMode != null && undoColorsCollect[t].preFilterColorMode != 'undefined' )
                shape.FilterColorMode = undoColorsCollect[t].preFilterColorMode;

            shape.UpdateDrawing();
        }
        
        DrawControlsMenu();

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoFadeToWhiteOut", e);
    }

}

function UndoFadeToBlankOutHelper(svgPart)
{
    try
    {
        if (svgPart.attr("old_fill") != null && svgPart.attr("old_fill") != "")
        {
            svgPart.attr("fill", svgPart.attr("old_fill"));
            svgPart.attr("old_fill", "");
        }
        if (svgPart.attr("old_stroke") != null && svgPart.attr("old_stroke") != "")
        {
            svgPart.attr("stroke", svgPart.attr("old_stroke"));
            svgPart.attr("old_stroke", "");
        }
        if (svgPart.attr("old_strokewidth") != null && svgPart.attr("old_strokewidth") != "")
        {
            svgPart.attr("stroke-width", svgPart.attr("old_strokewidth"));
            svgPart.attr("old_strokewidth", "");
        }
        
        for (var i = 0; i < svgPart.children().length; i++)
        {
            UndoFadeToBlankOutHelper($(svgPart.children()[i]))
        }
    } catch (e)
    {
        LogErrorMessage("SvgManip.UndoFadeToBlankOutHelper", e);
    }
}
//#endregion

//#endregion

//#region Undo Commands

function UndoDeleteShape()
{
    try
    {
        MyShapesState.Public_ClearAllSelectedShapes();
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Selected);

        // we need several passes because we add an item to it's parent, but hte parent may not have been added yet.. YUCK - abs 8/12/13
        var needExtraPasses = true;
        for (var j = 0; j < arguments.length + 1; j++)
        {
            if (needExtraPasses === false)
                break;

            needExtraPasses = false;
            for (var i = 0; i < arguments.length; i++)
            {
                var id = arguments[i].Id;
                var shapeState = arguments[i].ShapeState;
                var beforeShape = arguments[i].NextShapeId;
                var detached = arguments[i].Detached;


                if (detached.parent().length === 0)
                {
                    $("#" + beforeShape).before(detached);


                    if (detached.parent().length > 0)
                    {
                        MyShapesState.Public_SetShapeState(id, shapeState);
                        MyShapesState.Public_SelectShape($("#" + id));
                    }
                    else
                    {
                        needExtraPasses = true;
                    }
                }
            }
        }

        // could be smarter, but this won't be called that often
        StoryboardContainer.UpdateImageAttributions();


        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoDeleteShape", e);
    }
}

function UndoShapeAdd()
{
    try
    {
        MyShapesState.Public_ClearAllSelectedShapes();
 
        for (var i = 0; i < arguments.length; i++)
        {
            var id = arguments[i].Id;
            if( arguments[i].content ) // title or description of cell
            {
                if( arguments[i].content.cell_title_id )
                {
                    var O = MyShapesState.Public_GetShapeStateById(arguments[i].content.cell_title_id);
                    O.TextState.CopyFontStyles(arguments[i].content.cell_title_txt);
                    O.ColorableState.Public_CopyColorStyles(arguments[i].content.cell_title_color);
                    O.UpdateDrawing();
                }

                if( arguments[i].content.cell_description_id )
                {
                    var O = MyShapesState.Public_GetShapeStateById(arguments[i].content.cell_description_id);                    
                    O.TextState.CopyFontStyles(arguments[i].content.cell_description_txt);
                    O.ColorableState.Public_CopyColorStyles(arguments[i].content.cell_description_color);
                    O.UpdateDrawing();
                }

            } else {
                $("#" + id).detach();
                MyShapesState.Public_RemoveShapeStateById(id);
            }
        }

        HideControlsMenu();

        // could be smarter, but this won't be called that often
        StoryboardContainer.UpdateImageAttributions();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoShapeAdd", e);
    }
}

function UndoShapeIndexBefore(shapeId, moveBeforeId)
{
    try
    {
        var shapeToMove = $("#" + shapeId).detach();
        $("#" + moveBeforeId).before(shapeToMove);
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoShapeIndexBefore", e);
    }
}

function UndoShapeIndexAfter(shapeId, moveAfterId)
{
    try
    {
        var shapeToMove = $("#" + shapeId).detach();
        $("#" + moveAfterId).after(shapeToMove);
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoShapeIndexAfter", e);
    }
}

function UndoTextChange(id, text)
{
    try
    {
        var shape = MyShapesState.Public_GetShapeStateById(id);
        shape.SetText(text);
        $("#textableText").val(text);

        shape.UpdateDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoTextChange", e);
    }
}

function UndoTextChangeQuill(id, deltas)
{
    try
    {
        var shapeState = MyShapesState.Public_GetShapeStateById(id);

        if (shapeState == null)
        {
            LogErrorMessage("SvgManip.UndoTextChangeQuill - ShapeState is Null - ID: " + id);
            return;
        }

            shapeState.TextState.Public_SetQuillDeltas(deltas);
        quill.setContents(deltas);
        if (quill.getLength() == 1)
        {
            SbtQuillHelper.ResetToDefaults();
        }
        shapeState.UpdateDrawing();
        shapeState.SetText(quill.getText());

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoTextChangeQuill", e);
    }
}


function UndoFontFaceChange(id, font)
{
    try
    {
        var shape = MyShapesState.Public_GetShapeStateById(id);
        SetFontSelection(font, id);

        shape.UpdateDrawing(); // update the font in the SVG file
        UpdateActiveDrawing();// update the text selector
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoFontFaceChange", e);
    }

}

function UndoFontColor(id, color)
{
    try
    {
        var shape = MyShapesState.Public_GetShapeStateById(id);

        shape.SetFontColor(color);
        MyPointers.Controls_TextableControls_ColorSelector.spectrum("set", color);
        //GetGlobalById('colorSelector').color.fromString(color);

        shape.UpdateDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoFontColor", e);
    }
}

function UndoFontSize(id, size)
{
    try
    {
        var shape = MyShapesState.Public_GetShapeStateById(id);

        shape.SetFontSize(size);
        $("#sizeSelector").val(size);

        shape.UpdateDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoFontSize", e);
    }

}

function UndoTextAlignment(id, val)
{
    try
    {
        var shape = MyShapesState.Public_GetShapeStateById(id);

        shape.SetTextAlignment(val);
        MyPointers.Controls_TextableControls_TextAlignmentSelectors.removeClass("active");
        MyPointers.Controls_TextableControls_TextAlignmentSelectors.filter("." + val).addClass("active");

        shape.UpdateDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoTextAlignment", e);
    }

}

function UndoFlipVertical()
{
    try
    {
        MyShapesState.Public_ClearAllSelectedShapes();
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Selected);

        for (var i = 0; i < arguments.length; i++)
        {
            var id = arguments[i].Id;
            var shape = MyShapesState.Public_GetShapeStateById(id);

            shape.FlipShapeVertical();
            MyShapesState.Public_SelectShape($("#" + id));
        }

        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoFlipVertical", e);
    }
}

function UndoFlipHorizontal()
{
    try
    {
        MyShapesState.Public_ClearAllSelectedShapes();
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Selected);

        for (var i = 0; i < arguments.length; i++)
        {
            var id = arguments[i].Id;
            var shape = MyShapesState.Public_GetShapeStateById(id);

            shape.FlipShapeHorizontal();
            MyShapesState.Public_SelectShape($("#" + id));

        }

        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoFlipHorizontal", e);
    }
}

function UndoShapeRotate()
{
    try
    {
        MyShapesState.Public_ClearAllSelectedShapes();
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Selected);

        for (var i = 0; i < arguments.length; i++)
        {
            var id = arguments[i].Id;
            var angle = arguments[i].Angle;
            var shape = MyShapesState.Public_GetShapeStateById(id);

            shape.RotateShape(angle);

            MyShapesState.Public_SelectShape($("#" + id));
        }

        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoShapeRotate", e);
    }
}

function UndoShapeMoveArray()// arguments are passed "dynamagically" so review the arguments array
{
    try
    {
        MyShapesState.Public_ClearAllSelectedShapes();
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Selected);

        for (var i = 0; i < arguments.length; i++)
        {
            var id = arguments[i].Id;
            var x = arguments[i].X;
            var y = arguments[i].Y;

            var shape = MyShapesState.Public_GetShapeStateById(id);
            shape.MoveDistance(x, y);

            MyShapesState.Public_SelectShape($("#" + id));

        }

        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoShapeMoveArray", e);
    }
}

function UndoShapeResize()
{
    try
    {
        MyShapesState.Public_ClearAllSelectedShapes();
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Selected);

        for (var i = 0; i < arguments.length; i++)
        {
            var id = arguments[i].Id;
            var scaleX = arguments[i].ScaleX;
            var scaleY = arguments[i].ScaleY;

            var shape = MyShapesState.Public_GetShapeStateById(id);
            shape.SetScale(scaleX, scaleY);

            MyShapesState.Public_SelectShape($("#" + id));
        }

        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoShapeResize", e);
    }
}

function UndoShapeResizeWithMove()
{
    try
    {
        MyShapesState.Public_ClearAllSelectedShapes();
        MyShapesState.Property_SetCurrentShapeAction(ShapeActionEnum.Selected);

        for (var i = 0; i < arguments.length; i++)
        {
            var id = arguments[i].Id;
            var shape = MyShapesState.Public_GetShapeStateById(id);

            if (arguments[i].IsSpringable)
            {
                if (arguments[i].UseClipping)
                {
                    shape.ClipHeight = arguments[i].ClipHeight;
                    shape.ClipWidth = arguments[i].ClipWidth;
                }

                MyResizeActions.UndoSpringableResize(arguments[i]);

            }
            else
            {
                shape.SetScale(arguments[i].ScaleX, arguments[i].ScaleY);
            }


            shape.MoveTo(arguments[i].MoveX, arguments[i].MoveY);

            MyShapesState.Public_SelectShape($("#" + id));
        }

        UpdateActiveDrawing();
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoShapeResizeWithMove", e);
    }
}

function UndoCrop(id, useClipping, clipX, clipY, clipWidth, clipHeight , CropPolygonPoint , CropType)
{
    try
    {
        var shape = MyShapesState.Public_GetShapeStateById(id);

        shape.UseClipping = useClipping;
        shape.ClipX = clipX;
        shape.ClipY = clipY;
        shape.ClipWidth = clipWidth;
        shape.ClipHeight = clipHeight;
        shape.CropType = CropType;
        shape.CropPolygonPointJson = JSON.stringify(CropPolygonPoint);
        shape.CropPolygonPoint = JSON.parse(shape.CropPolygonPointJson);
        
        
        shape.UpdateCropping();
        shape.UpdateDrawing();

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.UndoCrop", e);
    }
}






//#endregion

//#region Save


//#region "Save timer warnings"
// this Code is WAY TO complicated for a simple popup... written a LONG time ago and needs more cleaning up

var _SaveWarningNextHandler;
var _SaveWarningTimeOut
function ResetSaveWarning()
{
    if (_SaveWarningTimeOut != null)
    {
        clearTimeout(_SaveWarningTimeOut);
    }
    _SaveWarningTimeOut = setInterval(ShowSaveWarning, 15 * 60 * 1000);
    _SaveWarningNextHandler = SaveWarning15Minutes;
};

function ShowSaveWarning()
{
    if (_SaveWarningNextHandler != null)
        _SaveWarningNextHandler();
}
function SaveWarning15Minutes()
{
    try
    {
        var message = MyLangMap.GetText("warning-please-save-15");

        if (StoryboardSetup.EnableAutoSave == false)
            message += "\r\n\r\n" + MyLangMap.GetText("warning-please-save-auto-save");

        swal({ title: MyLangMap.GetText("warning-please-save"), text: message, type: "info", confirmButtonText: MyLangMap.GetText("warning-ok-button") });


        _SaveWarningNextHandler = SaveWarning30Minutes;
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SaveWarning15Minutes", e);
    }
}

function SaveWarning30Minutes()
{
    try
    {
        var message = MyLangMap.GetText("warning-please-save-30");

        if (StoryboardSetup.EnableAutoSave == false)
            message += "\r\n\r\n" + MyLangMap.GetText("warning-please-save-auto-save");

        swal({ title: MyLangMap.GetText("warning-please-save"), text: message, type: "warning", confirmButtonText: MyLangMap.GetText("warning-ok-button") });
        _SaveWarningNextHandler = SaveWarning45Minutes;
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SaveWarning30Minutes", e);
    }
}

function SaveWarning45Minutes()
{
    try
    {
        var message = MyLangMap.GetText("warning-please-save-45");

        if (StoryboardSetup.EnableAutoSave == false)
            message += "\r\n\r\n" + MyLangMap.GetText("warning-please-save-auto-save");

        swal({ title: MyLangMap.GetText("warning-please-save"), text: message, type: "error", confirmButtonText: MyLangMap.GetText("warning-ok-button") });
        _SaveWarningNextHandler = null;
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.SaveWarning45Minutes", e);
    }
}

//#endregion 

//#endregion

//#region "Misc backend"

function FindOrphans()
{
    try
    {

        var children = MyPointers.CoreSvg.children();
        var foundIssues = 0;
        for (var i = 0; i < children.length; i++)
        {
            try
            {
                var element = children[i];
                var id = element.getAttribute("id");
                if (id == null || id.indexOf("sbt_") < 0)
                    continue;

                if (MyShapesState.Public_GetShapeStateById(id) == undefined)
                {

                    var item = $("#" + id);
                    item.off("mousedown").on("mousedown", ShapeSelected);
                    item.off("mouseup").on("mouseup", HandleMouseExit);
                    //item.mousedown(ShapeSelected);
                    //item.mouseup(HandleMouseExit);

                    var shapeState = new SvgState(id);
                    shapeState.Public_RecreateFromOrphan();
                    MyShapesState.Public_SetShapeState(id, shapeState);
                    foundIssues++;
                }
            }
            catch (e)
            {
                DebugLine("Find Orphans [item]: " + e);
            }

        }

        if (foundIssues > 0)
        {
            LogOrphans(foundIssues);
            swal({ title: "", text: MyLangMap.GetTextLineBreaks("warning-load-failed-orphans"), type: "error", confirmButtonText: MyLangMap.GetText("warning-ok-button") });

        }

    }
    catch (e)
    {

        LogErrorMessage("SvgManip.Orphans", e);
    }
}

function GetStoryboardSize()
{
    try
    {
        var totalShapes = MyShapesState.Public_GetAllShapeStates().length;
        if (totalShapes < 30)
            return;

        if (totalShapes > 30)
        {

            var svgById = GetGlobalById("CoreSvg");
            var svg_xml = (new XMLSerializer()).serializeToString(svgById);
            var storyboardSize = svg_xml.length;

            if (storyboardSize > 3750000)
            {
                var errorMessage = MyLangMap.GetTextLineBreaks("warning-storyboard-too-big")
                errorMessage = errorMessage.replace("{totalShapes}", totalShapes);
                errorMessage = errorMessage.replace("{totalSize}", storyboardSize);


                swal({ title: "", text: errorMessage, type: "warning", confirmButtonText: MyLangMap.GetText("warning-ok-button") });
            }
        }

    }
    catch (e)
    {
        LogErrorMessage("GetStoryboardSize", e);
    }

}

//#endregion

//#region "Advanced buttons"
function ShowAdvancedButtons()
{
    var titleModifiersEnabled = CellConfiguration.HasTitle;
    var descriptionModifiersEnabled = CellConfiguration.HasDescription;

    $("#title-caps-btn").prop("disabled", !titleModifiersEnabled);
    $("#title-emphasis-btn").prop("disabled", !titleModifiersEnabled);
    $("#advanced-title-text-size").prop("disabled", !titleModifiersEnabled);

    $("#description-emphasis-btn").prop("disabled", !descriptionModifiersEnabled);
    $("#advanced-description-text-size").prop("disabled", !descriptionModifiersEnabled);

    MyPointers.Dialog_AdvancedButtons.modal();

    //
}
//#endregion

//#region Grid Lines

function ToggleGridLines()
{
    CloseModal(MyPointers.Dialog_AdvancedButtons);


    if (HasGridLines())
    {
        $('#gridlines-btn').toggleClass("btn-default").toggleClass("btn-danger");
        RemoveGridLines();
    }
    else
    {
        $('#gridlines-btn').toggleClass("btn-default").toggleClass("btn-danger");
        AddGridLines();
    }
}
function HasGridLines()
{
    return MyPointers.CoreSVG_SvgTop.children().length > 0;
}



function AddGridLines()
{

    RemoveGridLines();

    var gridColor1 = "Gray";
    var gridColor2 = "gainsboro";

    var lines = 10;
    for (var rows = 0; rows < StoryboardContainer.Rows; rows++)
    {
        for (var cols = 0; cols < StoryboardContainer.Cols; cols++)
        {
            var cellPosition = CellConfiguration.GetCellPartPosition(StoryboardPartTypeEnum.StoryboardCell, rows, cols);

            var gridHeight = cellPosition.Height / lines;
            var gridWidth = cellPosition.Width / lines;

            for (var i = 1; i < lines; i++)
            {
                var id = "grid_" + rows + "_" + cols + "_";
                var x = cellPosition.X + (i * gridWidth);
                var y = cellPosition.Y + (i * gridHeight);

                var strokeWidth = (i == 5 ? 1.5 : .5);
                MyPointers.CoreSVG_SvgTop.append(SvgCreator.AddLine(x, cellPosition.Y, x, cellPosition.Y + cellPosition.Height, "stroke:" + gridColor1 + "; stroke-width:" + strokeWidth + ";", id + "_a"));
                MyPointers.CoreSVG_SvgTop.append(SvgCreator.AddLine(x, cellPosition.Y, x, cellPosition.Y + cellPosition.Height, "stroke:" + gridColor2 + " ; stroke-dasharray: 5,5; stroke-width:" + strokeWidth + ";", id + "_a"));

                MyPointers.CoreSVG_SvgTop.append(SvgCreator.AddLine(cellPosition.X, y, cellPosition.X + cellPosition.Width, y, "stroke:" + gridColor1 + " ; stroke-width:" + strokeWidth + ";", id + "_c"));
                MyPointers.CoreSVG_SvgTop.append(SvgCreator.AddLine(cellPosition.X, y, cellPosition.X + cellPosition.Width, y, "stroke:" + gridColor2 + " ; stroke-dasharray: 5,5; stroke-width:" + strokeWidth + ";", id + "_c"));
            }
        }
    }
}

function RemoveGridLines()
{
    MyPointers.CoreSVG_SvgTop.children().remove();
}

//#endregion

//#region "Keyboards"

function AddKeypadSymbol(key)
{
    if (UseQuill)
    {
        SbtQuillHelper.JamText(key);
    }
    else if (UseSummerNote)
    {
        SbtSummerNoteHelper.JamText(key);
    }
    else
    {
        var field = $('#textableText');
        $.keypad.insertValue(field, key);
        SetTextableText();
        field.focus();
    }
}

//#endregion

//#region "Silhouttes"



function Silhoutte(svgId)
{
    var svgImage = $("#" + svgId)
    FadeToSilhoutte(svgImage);

}

function FadeToSilhoutte(svgPart)
{
    var skip = false;
    if (svgPart.attr("fill") == "white" || svgPart.attr("fill") == "#FFF" || svgPart.attr("fill") == "#FFFFFF" || svgPart.attr("fill") == "#FFFFFC")
        skip = true;

    if (svgPart.attr("fill") == "none")
        skip = true;

    if (skip == false)
    {
        if (svgPart.attr("fill") == "white")
            svgPart.attr("stroke", "black");

        svgPart.attr("fill", "black");
    }
    for (var i = 0; i < svgPart.children().length; i++)
    {
        FadeToSilhoutte($(svgPart.children()[i]))
    }
}
//#endregion

// #region Cell Layout Configuration 

function AddExtraLayoutCells(addRow, addCol)
{
    if (addRow)
    {
        if (StoryboardContainer.MaxRows == 10)
        {
            swal({ title: "", text: MyLangMap.GetTextLineBreaks("warning-limit-rows"), type: "info", confirmButtonText: MyLangMap.GetText("warning-ok-button") });
            return;
        }
        StoryboardContainer.MaxRows++;
    }
    if (addCol)
    {
        if (StoryboardContainer.MaxCols == 10)
        {
            swal({ title: "", text: MyLangMap.GetTextLineBreaks("warning-limit-cols"), type: "info", confirmButtonText: MyLangMap.GetText("warning-ok-button") });
            return;
        }
        StoryboardContainer.MaxCols++;

    }
    UpdateChangeCellCountSelector();

}

function UpdateChangeCellCountSelector()
{
    var layoutArea = $("#LayoutButtonHolder");
    var selectedRows = parseInt(MyPointers.Dialog_ChangeLayout.attr('rows'));
    var selectedCols = parseInt(MyPointers.Dialog_ChangeLayout.attr('cols'));



    StoryboardContainer.MaxRows = Math.max(StoryboardContainer.MaxRows, StoryboardContainer.Rows);
    StoryboardContainer.MaxCols = Math.max(StoryboardContainer.MaxCols, StoryboardContainer.Cols);

    layoutArea.css("width", (StoryboardContainer.MaxCols * 60) + "px");

    layoutArea.children().remove();

    for (var row = 1; row <= StoryboardContainer.MaxRows; row++)
    {
        for (var col = 1; col <= StoryboardContainer.MaxCols; col++)
        {
            var css = "ChangeLayoutButton ";

            if (row <= StoryboardContainer.Rows && col <= StoryboardContainer.Cols)
                css += "used ";

            if (row <= selectedRows && col <= selectedCols)
                css += " added";

            layoutArea.append("<a id='changelayoutcell_" + row + "" + col + "' class='" + css + "' onclick='ConfigureStoryboardCells(" + row + "," + col + ")'>" + col + " x " + row + "</a> ");
        }
        layoutArea.append("<br>")
    }

    //for (var i = 1; i <= StoryboardContainer.MaxCols; i++)
    //{
    //    layoutArea.append("<a id='changelayoutcell_" + StoryboardContainer.MaxRows + "" + i + "' class='ChangeLayoutButton' onclick='ConfigureStoryboardCells(" + StoryboardContainer.MaxRows + "," + i + ")'>" + i + " x " + StoryboardContainer.MaxRows + "</a> ");

    //}
    //layoutArea.append("<br>")

}

function PrepareChangeLayoutDialog()
{
    try
    {
        UpdateChangeCellCountSelector();
        // Reset warning message, first
        //MyPointers.Dialog_ChangeLayout.find('.warning').text('This operation cannot be undone.');

        $("#change-cell-count-too-many").hide();
        $("#change-cell-lose-content").hide();

        var i, j;
        MyPointers.Dialog_ChangeLayout.find('a.ChangeLayoutButton').removeClass('used added');
        for (i = 0; i < StoryboardContainer.Rows; i++)
        {
            for (j = 0; j < StoryboardContainer.Cols; j++)
            {
                $('#changelayoutcell_' + (i + 1) + (j + 1)).addClass('used added');
            }
        }
        MyPointers.Dialog_ChangeLayout.attr('rows', StoryboardContainer.Rows.toString()).attr('cols', StoryboardContainer.Cols.toString())
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.PrepareChangeLayoutDialog", e);
    }
};

function ConfigureStoryboardCells(rows, cols)
{
    try
    {
        var i, j;
        MyPointers.Dialog_ChangeLayout.attr('rows', rows.toString()).attr('cols', cols.toString());
        MyPointers.Dialog_ChangeLayout.find('a.ChangeLayoutButton').removeClass('added');
        for (i = 0; i < rows; i++)
        {
            for (j = 0; j < cols; j++)
            {
                $('#changelayoutcell_' + (i + 1) + (j + 1)).addClass('added');
            }
        }

        var droppedCells = MyPointers.Dialog_ChangeLayout.find('a.ChangeLayoutButton.used:not(.added)').length;
        $("#change-cell-count-too-many-message").text(droppedCells + ' ');

        $("#change-cell-lose-content").hide();
        if (droppedCells > 0)
        {
            $("#change-cell-lose-content").show();
        }

        $("#change-cell-count-too-many").hide();
        if (rows * cols > 24)
        {
            $("#change-cell-count-too-many").show();
        }
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.ConfigureStoryboardCells", e);
    }
}

function CancelChangeLayout()
{
    MyPointers.Dialog_ChangeLayout.modal('hide');
}

function ConfirmChangeLayout()
{
    try
    {
        var rows = parseInt(MyPointers.Dialog_ChangeLayout.attr('rows'));
        var cols = parseInt(MyPointers.Dialog_ChangeLayout.attr('cols'));

        MyPointers.Dialog_ChangeLayout.modal('hide');

        // Don't do anythign if the layout hasn't changed
        if ((rows === StoryboardContainer.Rows) && (cols === StoryboardContainer.Cols))
        {
            return;
        }

        // Make sure we are allowed to change the layout to what the user requested (might require a login, and then a purchase, too)
        CheckForLayoutAccessPreRefresh(rows, cols, true);

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.ConfirmChangeLayout", e);
    }
};

function ChangeLayoutPostAccessCheck(rows, cols)
{
    try
    {
        // JIRA-WEB-33 - Added check so that alert is only given if the user is going to lose content - we'll ignore shrink orders that would only remove blank cells
        if ((rows < StoryboardContainer.Rows || cols < StoryboardContainer.Cols) && StoryboardContainer.Public_FindOutOfBoundContent(rows, cols).length > 0)
        {
            if (confirm(MyLangMap.GetText("warning-shrinking-storyboard")) == false)
            {
                return;
            }
        }

        StoryboardContainer.CreateRowsAndCells(rows, cols);
        StoryboardContainer.UpdateImageAttributions();

        if (HasGridLines())
        {
            AddGridLines();
        }
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.ChangeLayoutPostAccessCheck", e);
    }
}



function CheckForLayoutAccessPreRefresh(rows, cols, promptForLogon)
{
    try
    {
        if (StoryboardContainer.IsFreeLayoutConfiguration(rows, cols))
        {
            ChangeLayoutPostAccessCheck(rows, cols);
            return;
        }

        if (MyUserPermissions.EnableAllCellOptions)
        {
            ChangeLayoutPostAccessCheck(rows, cols);
            return;
        }

        MyUserPermissions.Public_RefreshPermissions(false, function () { CheckForLayoutAccessPostRefresh(rows, cols, promptForLogon); });
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.CheckForLayoutAccessOnLayoutChange", e);
    }
}

function CheckForLayoutAccessPostRefresh(rows, cols, promptForLogon)
{
    try
    {
        if (MyUserPermissions.EnableAllCellOptions)
        {
            ChangeLayoutPostAccessCheck(rows, cols);
            return;
        }

        if (MyUserPermissions.IsLoggedOn == false)
        {
            if (promptForLogon)
            {
                HandleLoginCloseFunction = function () { CheckForLayoutAccessPreRefresh(rows, cols, false); };
                showLogonDialog();
                return;
            }
        }

        MyPointers.Dialog_PurchasePopForMoreLayouts.modal();

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.CheckForUploadAccessPostRefresh", e);
    }
}


function CheckForLayoutAccessOnStoryboardCopy(rows, cols, promptForLogon)
{
    try
    {
        if (StoryboardContainer.IsFreeLayoutConfiguration(rows, cols))
            return;

        if (MyUserPermissions.EnableAllCellOptions)
            return;

        MyUserPermissions.Public_RefreshPermissions(false, function () { CheckForLayoutAccessOnCopyPostRefresh(rows, cols, promptForLogon); });
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.CheckForLayoutAccessOnStoryboardCopy", e);
    }
}

function CheckForLayoutAccessOnCopyPostRefresh(rows, cols, promptForLogon)
{
    try
    {
        if (MyUserPermissions.EnableAllCellOptions)
        {
            ChangeLayoutPostAccessCheck(rows, cols);
            return;
        }

        if (MyUserPermissions.IsLoggedOn == false)
        {
            if (promptForLogon)
            {
                HandleLoginCloseFunction = function () { CheckForLayoutAccessOnStoryboardCopy(rows, cols, false); };
                showLogonDialog();
                return;
            }
        }

        MyPointers.Dialog_PurchasePopForMoreLayoutsOnCopy.modal();

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.CheckForLayoutAccessOnCopyPostRefresh", e);
    }
}




//#endregion
//#region "Layout Types"

function ChangeCellLayoutType(layout, enableTitle, enableDescription)
{
    try
    {
        if (layout == null)
            layout = StoryboardContainer.GetLayoutType();

        if (layout == StoryboardLayoutType.StoryboardGrid || MyUserPermissions.EnableAllCellOptions)
        {
            ChangeCellLayoutTypePostCheck(layout, enableTitle, enableDescription);
            return;
        }

        CheckForChangeCellLayoutTypePreRefresh(layout, enableTitle, enableDescription, true)
    } catch (e)
    {
        LogErrorMessage("SvgManip.ChangeCellLayoutType", e);
    }
}


function CheckForChangeCellLayoutTypePreRefresh(layout, enableTitle, enableDescription, promptForLogon)
{
    try
    {
        MyUserPermissions.Public_RefreshPermissions(false, function () { CheckForChangeCellLayoutTypePostRefresh(layout, enableTitle, enableDescription, promptForLogon); });
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.CheckForChangeCellLayoutTypePreRefresh", e);
    }
}

function CheckForChangeCellLayoutTypePostRefresh(layout, enableTitle, enableDescription, promptForLogon)
{
    try
    {
        if (MyUserPermissions.EnableAllCellOptions)
        {
            ChangeCellLayoutTypePostCheck(layout, enableTitle, enableDescription);
            return;
        }

        if (MyUserPermissions.IsLoggedOn == false)
        {
            if (promptForLogon)
            {
                HandleLoginCloseFunction = function () { CheckForChangeCellLayoutTypePreRefresh(layout, enableTitle, enableDescription, false) };
                showLogonDialog();
                return;
            }
        }

        MyPointers.Dialog_PurchasePopForMoreStoryboardLayouts.modal();

    }
    catch (e)
    {
        LogErrorMessage("SvgManip.CheckForUploadAccessPostRefresh", e);
    }
}

// NOTE: these checks should probably live in the layouts that are being transitioned to...
function ChangeCellLayoutTypePostCheck(layout, enableTitle, enableDescription)
{
    StoryboardContainer.SetCoreSvgDimensions();

    var layoutConfig = null;

    var isTitleEnabled = CellConfiguration.HasTitle;
    var isDescriptionEnabled = CellConfiguration.HasDescription;
    var oldLayoutType = StoryboardContainer.GetLayoutType();

    // if values aren't supplied use previous value - and YUCK is that hard to read
    layout = layout || oldLayoutType;
    enableTitle = (enableTitle != null) ? enableTitle : isTitleEnabled;
    enableDescription = (enableDescription != null) ? enableDescription : isDescriptionEnabled;

    var scale = CellConfiguration.GetScale();

    if (VerifyChangeCellLayout(layout, oldLayoutType) == false)
        return;

    // for spider to frayer only convert to grid before transitioning to frayer - i suspect we made need to use this hack on other formats :( abs 2/26/15
    if (layout == StoryboardLayoutType.Frayer && (CellConfiguration.LayoutType == StoryboardLayoutType.Spider || CellConfiguration.LayoutType == StoryboardLayoutType.Cycle))
    {
        var tempCellConfiguration = MyLayoutFactory.GetLayout(StoryboardLayoutType.StoryboardGrid, enableTitle, enableDescription, scale, layoutConfig);
        SwapCellConfigurations(tempCellConfiguration);

        if (VerifyChangeCellLayout(layout) == false)
            return;
    }


    $('#addcell-btn').html("<span style=\"background:none\" aria-hidden=\"true\" class=\"icon isbt-addcell\"></span> " + MyLangMap.GetText("button-add-cells"));
    $('#addcell-btn').prop("disabled", false);
    // make this generic at some point!
    if (layout == StoryboardLayoutType.Frayer)
    {
        ChangeLayoutToFrayerPreSetup();
    }
    if (layout == StoryboardLayoutType.Timeline)
    {
        scale = ChangeLayoutToTimelinePreSetup(scale);
        layoutConfig = new Object();
        layoutConfig.TimelineDates = TimelineDateManager.GetSelectedDates(StoryboardContainer.Cols);
    }
    if (layout == StoryboardLayoutType.Spider || layout == StoryboardLayoutType.Cycle)
    {
        scale = ChangeLayoutToSpiderPreSetup(scale);
    }

    var newCellConfiguration = MyLayoutFactory.GetLayout(layout, enableTitle, enableDescription, scale, layoutConfig);
    SwapCellConfigurations(newCellConfiguration);

    if (HasGridLines())
    {
        AddGridLines();
    }

    //MyPointers.Dialog_ChangeLayout2.modal('hide');
    MyPointers.Dialog_StoryboardType.modal('hide');

    if (layout == StoryboardLayoutType.Timeline && oldLayoutType != StoryboardLayoutType.Timeline)
        ChangeLayoutDialog();

    if (layout == StoryboardLayoutType.Movie && oldLayoutType != StoryboardLayoutType.Movie)
        SwapSceneCategory(true);

    if (oldLayoutType == StoryboardLayoutType.Movie && layout != StoryboardLayoutType.Movie)
        SwapSceneCategory(false);


    UndoManager.register(undefined, ChangeCellLayoutType, [oldLayoutType, isTitleEnabled, isDescriptionEnabled], undefined, '', ChangeCellLayoutType, [layout, enableTitle, enableDescription]);
}

function SwapCellConfigurations(newCellConfiguration)
{
    StoryboardContainer.ChangeCellConfiguration_MoveShapes(CellConfiguration, newCellConfiguration);

    CellConfiguration = newCellConfiguration;

    StoryboardContainer.ChangeCellCellLayout();
    StoryboardContainer.SetLayoutType();
    StoryboardContainer.UpdateImageAttributions();
}

function ChangeLayoutToFrayerPreSetup()
{
    StoryboardContainer.CreateRowsAndCells(2, 2);
    $('#addcell-btn').prop("disabled", true);
}
function ChangeLayoutToTimelinePreSetup(scale)
{
    scale = ChangeLayoutFlattenAndShrink(scale);
    $('#addcell-btn').html("<i class=\"icon isbt-addcell\"></i> " + MyLangMap.GetText("button-timeline-dates"))

    return scale;
}
function ChangeLayoutToSpiderPreSetup(scale)
{
    return ChangeLayoutFlattenAndShrink(scale);
}

function SwapSceneCategory(showMovie)
{
    var normalScenesTab = $("#parent-category-14")
    var normalScenesTabLink = $("#parent-category-a-14")

    var movieScenesTab = $("#parent-category-96")
    var movieScenesTabLink = $("#parent-category-a-96")

    normalScenesTab.toggle();
    movieScenesTab.toggle();

    if (showMovie)
    {
        movieScenesTabLink.trigger("click");
    }
    else
    {
        normalScenesTabLink.trigger("click");
    }

}

function ChangeLayoutFlattenAndShrink(scale)
{
    if (scale == 1)
    {
        scale = 316 / 372;
        ExpandCells(scale, scale, false);
    }

    if (StoryboardContainer.Rows > 1)
    {
        var oldCols = StoryboardContainer.Cols;
        var totalCols = Math.min(10, StoryboardContainer.Rows * StoryboardContainer.Cols);
        StoryboardContainer.CreateRowsAndCells(StoryboardContainer.Rows, totalCols);

        var moveList = []
        for (var row = 1; row < StoryboardContainer.Rows; row++)
        {
            for (var col = 0; col < oldCols; col++)
            {
                moveList.push({ 'oldCol': col, 'oldRow': row, 'newCol': (row * oldCols) + col, 'newRow': 0 });
            }
        }

        MoveCellHelper.RearrangeCells(moveList);
        StoryboardContainer.CreateRowsAndCells(1, totalCols);
    }
    if (StoryboardContainer.Cols < 3)
        StoryboardContainer.CreateRowsAndCells(1, 3);

    return scale;
}

function VerifyChangeCellLayout(newLayout, oldLayout)
{
    if (newLayout == StoryboardLayoutType.Frayer)
    {
        if (StoryboardContainer.Public_FindOutOfBoundContent(2, 2).length > 0)
        {
            return confirm('Changing to a Frayer Model will make your storyboard 2x2.\r\n\r\nYou will lose all content outside of the window.  Are you sure you want to change layout type?');
        }
    }

    if (newLayout == StoryboardLayoutType.Spider)
    {
        if (StoryboardContainer.Rows * StoryboardContainer.Cols > 10)
        {
            return confirm('Changing to a Spider Map will remove cells in excess of 10.  Are you sure you want to do this?');
        }
    }
    if (newLayout == StoryboardLayoutType.Cycle)
    {
        if (StoryboardContainer.Rows * StoryboardContainer.Cols > 10) {
            return confirm('Changing to a Cycle will remove cells in excess of 10.  Are you sure you want to do this?');
        }
    }
    if (newLayout == StoryboardLayoutType.Timeline)
    {
        if (StoryboardContainer.Rows * StoryboardContainer.Cols > 10)
        {
            return confirm('Changing to a Timeline remove cells in excess of 10.  Are you sure you want to do this?');
        }
    }

    if (oldLayout == StoryboardLayoutType.Movie && newLayout != oldLayout)
    {
        return confirm('Changing from a 16x9 layout may cause items to be out of the cell.  Are you sure you want to do this?');

    }
    return true;
}

function ChangeCellCountForSpider(cols, layoutEnum)
{
    if (cols < StoryboardContainer.Cols)
    {
        if (confirm('Reducing the amount of cells in a Spider Map may result in losing content.  There is no undo.\r\nAre you sure you want to remove cells?') == false)
        {
            return;
        }
    }

    var newCellConfiguration = MyLayoutFactory.GetLayout(StoryboardLayoutType.StoryboardGrid, CellConfiguration.HasTitle, CellConfiguration.HasDescription, CellConfiguration.GetScale(), null);
    SwapCellConfigurations(newCellConfiguration);

    StoryboardContainer.CreateRowsAndCells(1, cols);

    var newCellConfiguration = MyLayoutFactory.GetLayout(StoryboardLayoutType.Spider, CellConfiguration.HasTitle, CellConfiguration.HasDescription, CellConfiguration.GetScale(), null);
    SwapCellConfigurations(newCellConfiguration);


    CloseBasicDialog('ChangeCellCountSpider');
}

function ChangeCellCountForCycle(cols) {
    if (cols < StoryboardContainer.Cols) {
        if (confirm('Reducing the amount of cells in a Cycle Map may result in losing content.  There is no undo.\r\nAre you sure you want to remove cells?') == false) {
            return;
        }
    }

    var newCellConfiguration = MyLayoutFactory.GetLayout(StoryboardLayoutType.StoryboardGrid, CellConfiguration.HasTitle, CellConfiguration.HasDescription, CellConfiguration.GetScale(), null);
    SwapCellConfigurations(newCellConfiguration);

    StoryboardContainer.CreateRowsAndCells(1, cols);

    var newCellConfiguration = MyLayoutFactory.GetLayout(StoryboardLayoutType.Cycle, CellConfiguration.HasTitle, CellConfiguration.HasDescription, CellConfiguration.GetScale(), null);
    SwapCellConfigurations(newCellConfiguration);


    CloseBasicDialog('ChangeCellCountCycle');
}

function ChangeDatesForTimeline()
{
    if (TimelineDateManager.Cols < StoryboardContainer.Cols)
    {
        if (confirm('Reducing the amount of cells in a Timeline may result in losing content.  There is no undo.\r\nAre you sure you want to remove cells?') == false)
        {
            return;
        }
    }



    //var newCellConfiguration = MyLayoutFactory.GetLayout(StoryboardLayoutType.StoryboardGrid, CellConfiguration.HasTitle, CellConfiguration.HasDescription, CellConfiguration.GetScale(), null);
    //SwapCellConfigurations(newCellConfiguration);

    //StoryboardContainer.CreateRowsAndCells(1, TimelineDateManager.Cols);
    StoryboardContainer.Cols = TimelineDateManager.Cols;

    var layoutConfig = new Object();
    layoutConfig.TimelineDates = layoutConfig.TimelineDates = TimelineDateManager.GetSelectedDates(StoryboardContainer.Cols);

    var newCellConfiguration = MyLayoutFactory.GetLayout(StoryboardLayoutType.Timeline, CellConfiguration.HasTitle, CellConfiguration.HasDescription, CellConfiguration.GetScale(), layoutConfig);
    SwapCellConfigurations(newCellConfiguration);

    CloseBasicDialog('ChangeCellCountTimeline');
}
//#endregion

function HideKeyboard()
{
    $("#textableText").toggle();
    $("#expandKeyboard").toggle();
    $("#collapseKeyboard").toggle();
}

function CloseModal(modalWindow)
{
    try
    {
        if (modalWindow.hasClass('in'))
            modalWindow.modal('toggle')
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.CloseModal", e);
    }
}

//random method to help fix a summer note issue, but could be useful elsehwere
function ClearSelections()
{
    try 
    {
        if (window.getSelection)
        {
            if (window.getSelection().empty)
            { // Chrome 
                window.getSelection().empty();
            } else if (window.getSelection().removeAllRanges)
            { // Firefox 
                window.getSelection().removeAllRanges();
            }
        } else if (document.selection)
        { // IE? 
            document.selection.empty();
        }
    }
    catch (e)
    {
        LogErrorMessage("SvgManip.ClearSelections", e);

    }   
 
}

//#region "Degug"
function ShowDimensions()
{
    var storyboardContainerWrapper = $("#storyboard-container-outer-div");
    var windowWidth = MyPointers.Tabs.width();
    var windowHeight = window.innerHeight - (MyPointers.Tabs.outerHeight() + MyPointers.BottomControls.outerHeight());

    //var minWindowHeight = CellConfiguration.GetMinimumStoryboardHeight();

    //if (windowHeight < minWindowHeight)
    //    windowHeight = minWindowHeight;

    var coreSvgClientRect = GetGlobalById("CoreSvg").getBoundingClientRect();
    var svgWidth = (coreSvgClientRect.width - 2);
    var svgHeight = (coreSvgClientRect.height - 2);


    var message = "Window width: " + windowWidth + "\r\n";
    message += "Window height: " + windowHeight + "\r\n";

    message += "\r\n";

    message += "Wrapper Width: " + storyboardContainerWrapper.width() + "\r\n";
    message += "Wrapper Height: " + storyboardContainerWrapper.height() + "\r\n";

    message += "\r\n";
    message += "svgContainer width: " + MyPointers.SvgContainer.width() + "\r\n";
    message += "svgContainer height: " + MyPointers.SvgContainer.height() + "\r\n";
    //message += "min Window Height: " + minWindowHeight + "\r\n";



    message += "\r\n";

    message += "svg Width: " + svgWidth + "\r\n";
    message += "svg Height: " + svgHeight + "\r\n";

    message += "\r\n";

    message += "svg Margin: " + MyPointers.CoreSvg.css("margin") + "\r\n";
    message += "svg Overflow: " + MyPointers.CoreSvg.css("overflow") + "\r\n";



    alert(message);

}


//#endregion


