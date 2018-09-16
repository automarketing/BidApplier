/// <reference path="../../SvgManip.js" />


function CharacterSwapLibrary(existingLibrary)
{
    this.Private_Library = new Object();
    this.Private_XmlSerializer = new XMLSerializer();

    this.Private_ClearUnused = function (myShapeStates)
    {
        var imageIds = new Array();
        var cleanupIds = new Array();
        var shapeStates = myShapeStates.Public_GetAllMovableShapeStates(false);
        for (var i = 0; i < shapeStates.length; i++)
        {
            imageIds.push(shapeStates[i].GlobalImageId);
        }
        for (var key in this.Private_Library)
        {
            if (this.Private_Library.hasOwnProperty(key))
            {
                if (SbtLib.IndexOf(imageIds, key) < 0)
                {
                    cleanupIds.push(key);
                }
            }
        }
        for(i=0; i<cleanupIds.length; i++)
        {
            this.Private_Library[cleanupIds[i]] = null;
        }
    };

    this.Private_HandleLoad = function (existingLibrary)
    {
        if (existingLibrary == null)
            return;

        this.Private_Library = existingLibrary;
    };

    this.Public_SetSwap = function (character, position, pose, poseData)
    {
        if (this.Private_Library[character] == null)
        {
            this.Private_Library[character] = new Object();
        }
        if (this.Private_Library[character][position] == null)
        {
            this.Private_Library[character][position] = new Object();
        }
        var html = this.Private_XmlSerializer.serializeToString(poseData[0]); // WTF - needed for ie vs poseData.html();
        this.Private_Library[character][position][pose] = html;
        //this.Private_Library[character][position][pose] = poseData;
    }

    this.Public_GetSwap = function (character, position, pose)
    {
        try
        {
            return this.Private_Library[character][position][pose];
        } catch (e)
        {

        }
    }
   
   
    this.Public_GetJSON = function (myShapeStates)
    {
        this.Private_ClearUnused(myShapeStates);
        return JSON.stringify(this.Private_Library);
    };

    this.Private_HandleLoad(existingLibrary)
}
