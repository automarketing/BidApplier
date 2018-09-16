/// <reference path="../svgManip.js" />
function UserPermissions(initialUserPermissions, isLoggedOn)
{
    this.IsLoggedOn = isLoggedOn;
    
    this.EnableAllCellOptions = initialUserPermissions.EnableAllCellOptions;
    this.EnableUploads = initialUserPermissions.EnableUploads;
    this.UseCompression = initialUserPermissions.UseCompression;
    this.MagicToken = initialUserPermissions.MagicToken;

    this.AllowNewSave = false;
    this.AllowEditSave = false;
    this.SaveMessage = "";

    this.PortalFolders = null;


    this.Public_RefreshPermissions = function (logResult, callback)
    {
        try
        {
            var checkEnabledUrl = "/api_storyboardcreator/userstoryboardaccess?logresult=" + logResult + "&magictoken=" + this.MagicToken + "&time=" + TimeStamp;
            
            var userPermissions = this;
            jQuery.ajax(
            {
                type: 'GET',
                url: checkEnabledUrl,
                async: true,
                cache: false,
                timeout: 180 * 1000,
                error: function (jqXHR, textStatus, errorThrown)
                {
                    swal({ title: "", text: MyLangMap.GetTextLineBreaks("Error-Save-Internet"), type: "Error", confirmButtonText: MyLangMap.GetText("warning-ok-button") });
                    $.unblockUI();
                    var errorData = new Object();
                    try
                    {
                        errorData.message =textStatus + " : " + errorThrown.name + " : " + errorThrown.message;
                        errorData.stack = errorThrown.stack;
                    }
                    catch(e)
                    {
                        LogErrorMessage("UserPermissions.Public_RefreshPermissions_load_error", e);
                    }

                    LogErrorMessage("UserPermissions.Public_RefreshPermissions", errorData);

                },
                success: function (result, data)
                {
                    userPermissions.AllowNewSave = result.AllowNewSave;
                    userPermissions.AllowEditSave = result.AllowEditSave;
                    
                    userPermissions.EnableUploads = result.EnableUploads;
                    userPermissions.EnableAllCellOptions = result.EnableAllCellOptions;
                    
                    userPermissions.IsLoggedOn = result.LoggedOn;
                    
                    userPermissions.SaveMessage = result.SaveMessage;
                    //userPermissions.SaveWarningType = result.SaveWarningType;
                    //userPermissions.UseCompression = result.UseCompression;

                    userPermissions.PortalFolders = result.PortalFolders;
                    userPermissions.FolderTitle = result.FolderTitle;

                    userPermissions.MagicToken = result.MagicToken;

                    callback();
                },
                

            });
        }
        catch (e)
        {
            LogErrorMessage("SvgManip.UpdateUserPermissions", e);
        }
    };


}
