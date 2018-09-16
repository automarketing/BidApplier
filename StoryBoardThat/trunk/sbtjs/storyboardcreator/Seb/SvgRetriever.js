﻿var SvgRetriever = (function ()
{
    var my = {};

  
    var uploadCallbackContext = {};

    my.initiateUpload = function (onitemadded, oncomplete)
    {
        uploadCallbackContext = { 'node': $('#cliplib-upload-content'), 'onitemadded': onitemadded, 'oncomplete': oncomplete };
        ShowUploadDialog();
    }

    my.uploadCallback = function (data)
    {
        AddSvg.AddSvgToTabs(uploadCallbackContext.node, MyBrowserProperties.ClipartDisplayWidth, MyBrowserProperties.ClipartDisplayHeight, data, false, uploadCallbackContext.onitemadded);
        if (typeof (uploadCallbackContext.oncomplete) == FUNCTION_KEYWORD)
        {
            uploadCallbackContext.oncomplete();
        }
    };

    my.getClipartContent = function (categoryId, onitemadded, oncomplete)
    {
        // Only retrieve data if we haven't already loaded it!
        if ($('#cliplib-' + categoryId + '-content .waiting').length > 0)
        {
            _getClipartContentForPage(categoryId, 1, onitemadded, oncomplete);
        }
    };

    var _getClipartContentForPage = function (categoryId, page, onitemadded, oncomplete)
    {
        // Retrieve the first page...
        $.getJSON(CreatorUrls.LibraryImages + '?svg_category_id=' + categoryId + '&page=' + page + "&time=" + TimeStamp).success(
            (function (catId, pageIdx, onitemaddedHandler, oncompleteHandler)
            {
                return function (response)
                {

                    // Process server response
                    _onGetClipartContentComplete(catId, response, onitemaddedHandler);

                    // And recursively load the next page... (until the last one: page 4)
                    if (pageIdx < 1)
                    {
                        _getClipartContentForPage(catId, pageIdx + 1, onitemaddedHandler, oncompleteHandler);
                    }
                    else
                    {
                        if (typeof (oncompleteHandler) === FUNCTION_KEYWORD)
                        {
                            oncompleteHandler();
                        }
                    }
                };
            }(categoryId, page, onitemadded, oncomplete)
            )
        );
    };

    var _onGetClipartContentComplete = function (categoryId, response, onitemadded)
    {
        $('#cliplib-' + categoryId + '-content .waiting').remove();
        var targetContentPanel = $('#cliplib-' + categoryId + '-content');

        // This is a bit nasty and will need to be redone when we add another scene category!
        categoryId = parseInt(categoryId);
        var isSceneItem = ((categoryId >= 18 && categoryId <= 24)
            || categoryId == 38
            || categoryId == 39
            || categoryId == 42
            || (categoryId >= 79 && categoryId <= 82)
            || (categoryId >= 94 && categoryId <= 110)
            || categoryId == 139
            || categoryId == 140
            || categoryId == 156
            );
        var is16x9 = (categoryId >= 94 && categoryId <= 110) || categoryId==140;

        for (var i = 2; i < response.length; i++) // skip first 2 items, which we don't need anymore
        {
            if(is16x9)
                AddSvg.AddSvgToTabs(targetContentPanel, MyBrowserProperties.ClipartDisplayWidth16x9Scene, MyBrowserProperties.ClipartDisplayHeight, response[i], isSceneItem, onitemadded);
            else if (isSceneItem)
                AddSvg.AddSvgToTabs(targetContentPanel, MyBrowserProperties.ClipartDisplayWidthScene, MyBrowserProperties.ClipartDisplayHeight, response[i], isSceneItem, onitemadded);
            else
                AddSvg.AddSvgToTabs(targetContentPanel, MyBrowserProperties.ClipartDisplayWidth, MyBrowserProperties.ClipartDisplayHeight, response[i], isSceneItem, onitemadded);
        }

    }

    return my;

}());
