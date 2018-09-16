var SaveHelper = function ()
{
    var SaveHelperObject = new Object();
    var Props = new Object();

    Props.NewStoryboardUrl = CreatorUrls.GeoServer + "/geosavestoryboard/savenewstoryboard";  // /storyboardcreator/savenewstoryboard
    Props.EditStoryboardUrl = CreatorUrls.GeoServer + "/geosavestoryboard/saveeditstoryboard"; // /storyboardcreator/saveeditstoryboard
    Props.AutoStoryboardUrl = CreatorUrls.GeoServer + "/geosavestoryboard/autosavestoryboard"; // /storyboardcreator/saveeditstoryboard

    SaveHelperObject.SaveStoryboard = function (saveAndContinueParam, promptForLogon, isEdit)
    {
        $("#SaveChoicesDialog").modal('hide');
        saveAndContinue = saveAndContinueParam;
        try
        {
            var shapeCount = MyShapesState.Property_GetShapeStatesCount();
            if (shapeCount < 1)
            {
                swal(MyLangMap.GetText("warning-add-more"));
                return;
            }

            $.blockUI();

            MyUserPermissions.Public_RefreshPermissions(true, SaveImagePostRefreshClosure(saveAndContinue, promptForLogon, isEdit));


        }
        catch (e)
        {
            LogErrorMessage("SaveHelper.SaveStoryboard", e);
        }
    };

    SaveHelperObject.SaveStoryboard_PostLogon = function ()
    {
        try
        {
            warnOnExit = false;
            HideControlsMenu();
            //RemoveGridLines();
            ClearActiveState();

            $.blockUI();
            //trackEventWithGA('Storyboard Creator', 'Save', 'New Storyboard', 0);
            var storyboardData = SaveDataHelper.GetSaveData(SaveDataHelper.NewStoryboard);


            if (MyBrowserProperties.EnableCompression())
            {
                CompressData(storyboardData, Props.NewStoryboardUrl)
            }

            else
            {
                PostStoryboard(storyboardData, Props.NewStoryboardUrl);
            }


        }
        catch (e)
        {
            LogErrorMessage("SaveHelper.SaveStoryboard_PostLogon", e);
        }
    };

    SaveHelperObject.AutoSave = function ()
    {
        if (StoryboardSetup.EnableAutoSave == false)
            return;

        MyUserPermissions.Public_RefreshPermissions(true, AutoSavePostRefreshClosure());


    };

    // many nested callbacks
    function CompressData(storyboardData, postUrl)
    {
       // var start = new Date().getTime();

        var my_lzma = new LZMA("/scripts/lzma_worker.js");
        my_lzma.compress(storyboardData.Svg, MyBrowserProperties.CompressionRatio, function (res)
        {
            storyboardData.Svg = Iuppiter.Base64.encode(res);
            storyboardData.SvgLength = storyboardData.Svg.length;

            var my_lzma2 = new LZMA("/scripts/lzma_worker.js");
            my_lzma2.compress(storyboardData.CharacterSwapLibrary, MyBrowserProperties.CompressionRatio, function (res)
            {
                storyboardData.CharacterSwapLibrary = Iuppiter.Base64.encode(res);
                storyboardData.CharacterSwapLibraryLength = storyboardData.CharacterSwapLibrary.length;

                storyboardData.UseCompression = 1;

              //  var end = new Date().getTime();
              //  var time = end - start;
              //  DebugLine('Execution time: ' + time);

                PostStoryboard(storyboardData, postUrl);
            });
        });
    }

    function SaveAsEdit()
    {
        try
        {
            if (MyUserPermissions.AllowEditSave == false)
            {
                $("#SaveDialogSorryContent").children().remove();
                $("#SaveDialogSorryContent").html("");
                $("#SaveDialogSorryContent").append(MyUserPermissions.SaveMessage);
                $("#SaveDialogSorry").modal();
                return;
            }

            warnOnExit = false;
            HideControlsMenu();
            //RemoveGridLines();
            ClearActiveState();

            // trackEventWithGA('Storyboard Creator', 'Save', 'Edit Storyboard', 0);
            $.blockUI();
            var storyboardData = SaveDataHelper.GetSaveData(SaveDataHelper.EditStoryboard);

            if (MyBrowserProperties.EnableCompression())
            {
                CompressData(storyboardData, Props.EditStoryboardUrl)
            }

            else
            {
                PostStoryboard(storyboardData, Props.EditStoryboardUrl);
            }


        }
        catch (e)
        {
            LogErrorMessage("SaveHelper.SaveAsEdit", e);
        }
    };




    //#region "Private functions"
    function SaveAsNew_PrepareDialog()
    {
        try
        {
            if (MyUserPermissions.AllowNewSave == false)
            {
                $("#SaveDialogSorryContent").children().remove();
                $("#SaveDialogSorryContent").html("");
                $("#SaveDialogSorryContent").append(MyUserPermissions.SaveMessage);
                $("#SaveDialogSorry").modal();
                return;
            }

            var messageArea = $("#save-dialog-message");
            messageArea.children().remove();
            messageArea.append(MyUserPermissions.SaveMessage);

            var folderArea = $("#save-dialog-folders");
            folderArea.children().remove();


            if (MyUserPermissions.PortalFolders == null)
            {
                folderArea.append("<input type=hidden id=\"portal_folder_id\" value=\"0\">");
            }
            else
            {
                var foldersPrompt = "";
                foldersPrompt += MyUserPermissions.FolderTitle + ":<br />";
                foldersPrompt += "<select id=\"portal_folder_id\" style=\"margin-bottom:15px\">";
                foldersPrompt += "<option value=\"0\">--- No " + MyUserPermissions.FolderTitle + "  ---</option>";
                for (var i = 0; i < MyUserPermissions.PortalFolders.length; i++)
                {
                    foldersPrompt += "<option value=\"" + MyUserPermissions.PortalFolders[i].FolderId + "\">" + MyUserPermissions.PortalFolders[i].FolderName + "</option>";
                }
                foldersPrompt += "</select>";
                foldersPrompt += "</br>";

                folderArea.append(foldersPrompt);
            }

            $("#SaveDialog").modal();

        }
        catch (e)
        {
            LogErrorMessage("SvgManip.SaveAsNew_PrepareDialog", e);
        }
    }

    function CheckCellLimitOnSave()
    {
        try
        {
            if (StoryboardContainer.IsFreeLayoutConfiguration(StoryboardContainer.Rows, StoryboardContainer.Cols))
                return true;

            if (MyUserPermissions.EnableAllCellOptions == false)
            {
                MyPointers.Dialog_PurchasePopForMoreLayouts.modal();
                return false;
            }

            return true;
        }
        catch (e)
        {
            LogErrorMessage("SvgManip.CheckCellLimitOnSave", e);
        }
    };

    function PostStoryboard(storyboardData, url)
    {
        try
        {
            var end = +new Date();  // log end timestamp
            storyboardData.SaveDuration = end - storyboardData.SaveDuration;

            $.ajax({
                type: "POST",
                url: url,
                timeout: 300 * 1000,
                data: storyboardData,
                success: HandleSaveSuccessClosure(),
                error: HandleSaveFailureClosure(storyboardData, url)

            });
        }
        catch (e)
        {
            LogErrorMessage("SaveHelper.PostSaveNewStoryboard", e);
        }
    };


    //#region save closures
    function AutoSavePostRefreshClosure()
    {
        return function ()
        {
            if (MyUserPermissions.IsLoggedOn == false)
                return;

            if (MyUserPermissions.AllowEditSave == false)
                return;

            var storyboardData = SaveDataHelper.GetSaveData(SaveDataHelper.AutoSave);

            try
            {
                var end = +new Date();  // log end timestamp
                storyboardData.SaveDuration = end - storyboardData.SaveDuration;

                $.ajax({
                    type: "POST",
                    url: Props.AutoStoryboardUrl,
                    timeout: 300 * 1000,
                    data: storyboardData,
                    success: function (data)
                    {
                        if (data.Error != null && data.Error)
                            return;

                        var autoSaveCallout = $("#show-auto-saved");
                        autoSaveCallout.toggle();
                        setTimeout(function () { autoSaveCallout.toggle(); }, 5000);
                    },
                    error: function (data)
                    {
                        try
                        {
                            //this was commented out, too much spam!?!?! or a buggy log? ABS 4/ 27 / 17
                            var e = new Object()
                            e.message = data.statusText;
                            e.stack = data.responseText;
                            LogErrorMessage("SaveHelper.HandleSaveFailureClosure error:", e);
                        } catch (ex)
                        {
                            LogErrorMessage("SaveHelper.HandleSaveFailureClosure error logger", ex);
                        }
                        
                        
                    }
                });
            }
            catch (e)
            {
                LogErrorMessage("SaveHelper.AutoSavePostRefreshClosure", e);
            }
        }
    }
    function SaveImagePostRefreshClosure(saveAndContinue, promptForLogon, isEdit)
    {
        return function ()
        {
            try
            {
                $.unblockUI();

                if (MyUserPermissions.IsLoggedOn == false)
                {
                    if (promptForLogon)
                    {
                        HandleLoginCloseFunction = function () { SaveHelper.SaveStoryboard(saveAndContinue, false, isEdit); };
                        showLogonDialog();
                        return;
                    }

                    swal("You must be logged in to save your storyboard.  Please login and try again.");   // not sure if this will ever be called, but better safe than sorry
                    return; // don't let people go any further without logging in
                }

                if (CheckCellLimitOnSave() == false)
                    return;

                ClearActiveState();
                if (HasGridLines())
                    ToggleGridLines();


                StoryboardContainer.RemoveFilters();
                MyShapesState.Public_ClearDefaults();

                if (isEdit)
                {
                    SaveAsEdit();
                }
                else
                {
                    SaveAsNew_PrepareDialog();
                }
            }
            catch (e)
            {
                LogErrorMessage("SaveHelper.SaveImagePostRefreshClosure", e);
            }
        }
    }

    function HandleSaveSuccessClosure()
    {
        return function (data)
        {
            try
            {
                if (data.Error != null)
                {
                    if (data.Error == "Timeout")
                    {
                        MyUserPermissions.UseCompression = true;
                        swal({ title: "", text: MyLangMap.GetTextLineBreaks("Error-Save-Time-Out"), type: "Error", confirmButtonText: MyLangMap.GetText("warning-ok-button") });

                    }
                    else if (data.Error == "NoXml")
                    {
                        MyUserPermissions.UseCompression = true;
                        swal({ title: "", text: MyLangMap.GetTextLineBreaks("Error-Save-No-Xml"), type: "Error", confirmButtonText: MyLangMap.GetText("warning-ok-button") });
                    }
                    else if (data.ErrorId == "ErrorMessage")
                    {
                        swal({ title: "", text: MyLangMap.GetTextLineBreaks(data.ErrorId), type: "Error", confirmButtonText: MyLangMap.GetText("warning-ok-button") });
                        swal(data.ErrorMessage);
                    }
                    else
                    {
                        swal(data.Error);
                    }
                    $.unblockUI();
                    return;
                }

                // JIRA-WEB-18 Check if this is a Save & Continue operation, if so, we won't redirect after saving.
                if (saveAndContinue)
                {
                    ResetSaveWarning();
                    $.unblockUI();
                    return;
                }

                // All other cases: we redirect
                window.location.href = data.RedirectUrl;

            }
            catch (e)
            {
                LogErrorMessage("SaveHelper.HandleSaveSuccessClosure", e);
            }
        }
    }

    function HandleSaveFailureClosure(storyboardData, url)
    {
        return function (data)
        {
            try
            {
                try
                {
                    if (storyboardData.SaveTry<10)
                    {
                        MyUserPermissions.UseCompression = true;
                        
                        var totalTime = new Date() - Date.parse(storyboardData.RequestStart);
                        if (totalTime < 45*1000)
                        {
                            storyboardData.SaveTry++;

                            // if the storyboard is not compressed and they can support it, compress it!
                            if (MyBrowserProperties.EnableCompression() && storyboardData.UseCompression==0)
                            {
                                CompressData(storyboardData, url)
                            }
                            else
                            {
                                PostStoryboard(storyboardData, url);
                            }

                            return;
                        }
                    }
                }
                catch(e)
                {
                    LogErrorMessage("SaveHelper.HandleSaveFailureClosure.retry", e);
                }
                $.unblockUI();
                trackEventWithGA('Storyboard Creator', 'Save', 'SAVE FAILED', 0);
                if (data.statusText == "timeout")
                {
                    MyUserPermissions.UseCompression = true;
                    swal("Your storyboard timed out while saving - Uh Oh ", "If you see this error multiple times please email support@storyboardthat.com and include this message.\r\n\r\nWe will try to use compression the next time you save.");

                }
                else if (data.statusText == "Internal Server Error")
                {
                    swal("Our server was unable to save your storyboard, please try to save again.", "If you see this error repeatedly, please email us at support@storyboardthat.com.");
                }
                else
                {
                    MyUserPermissions.UseCompression = true;
                    swal("Your storyboard timed out while saving :(", "If you see this error multiple times please email support@storyboardthat.com and include this message.\r\n\r\nWe will try to use compression the next time you save.");

                }

                var e = new Object()
                e.message = data.statusText;
                e.stack = data.responseText;
                LogErrorMessage("SaveHelper.HandleSaveFailureClosure error:", e);
            }
            catch (e)
            {
                LogErrorMessage("SaveHelper.HandleSaveFailureClosure", e);
            }
        }
    }

    //#endregion
    //#endregion

    return SaveHelperObject;
}();

//#region Handle save posts 







//#endregion




//


