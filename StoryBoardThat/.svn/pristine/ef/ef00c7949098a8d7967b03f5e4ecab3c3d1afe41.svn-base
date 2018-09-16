///  <reference path="../../SvgManip.js" />

function CharacterPosistionLibrary()
{
    this.Private_Library = new Object();

    this.Private_Populate = function ()
    {
    };

    this.GetCharacterPositions = function(guid, callback)
    {
        if (this.Private_Library.hasOwnProperty(guid))
        {
            callback(this.Private_Library[guid])
            //callback(null);
            return;
        }
        this.Private_LoadCharacter(guid, callback);
        //callback(null);
        //return this.Private_Library[guid];
    };

    this.GetCharacterPosition = function (guid, position)
    {
        if (this.Private_Library.hasOwnProperty(guid)==false)
        {
            return null;
        }

        for (var i = 0; i < this.Private_Library[guid].length; i++)
        {
            var positionObject = this.Private_Library[guid][i];

            if (positionObject == null)
                continue;

            if (positionObject.Position == position)
                return this.Private_Library[guid][i];
        }

        return null;
    };

    this.Private_LoadCharacter = function (guid, callback)
    {
        
        var closureThis = this;

        $.ajax({
            //type: 'POST',
            timeout: 120 * 1000,
            url: CreatorUrls.CharacterPositions + "?guid=" + guid + "&time=" + TimeStamp,

            error: function (jqXHR, textStatus, errorThrown)
            {
                callback(null);
            },
            success: function (result, data)
            {
                closureThis.Private_Library[guid] = new Array();
                if (result == null)
                {
                    closureThis.Private_Library[guid] = null;
                    callback(null);
                    return;
                }
                for (var i = 0; i < result.length; i++)
                {
                    closureThis.Private_Library[guid][result[i].Order] = result[i];
                }
                callback(closureThis.Private_Library[guid])
            },

            cache: false
        });
    }




    this.Private_Populate();
}