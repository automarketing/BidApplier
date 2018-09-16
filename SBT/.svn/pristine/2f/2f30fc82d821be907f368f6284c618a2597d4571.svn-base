var StoryboardCreatorLibrary = function ()
{
    var StoryboardCreatorLibraryObject = new Object();

    StoryboardCreatorLibraryObject.ParseAndUpdateIds = function (containerId, preFix, idList)
    {
        if (idList == null || idList == "")
            return [];

        var splitIds = idList.split(",");
        var newIds = [];
        for (var i = 0; i < splitIds.length; i++)
        {
            var trimmedId = splitIds[i].trim();
            var newId = preFix + trimmedId;

            FindAndUpdateId(containerId, trimmedId, newId);
            newIds.push(newId);
        }

        return newIds;
    };


    return StoryboardCreatorLibraryObject;

}();