///  <reference path="../../SvgManip.js" />

function GlobalSwapLibrary()
{
    this.Private_Library = new Object();

   
    this.Private_LoadLibrary=function()//data, globalSwapLibrary)
    {
     //   var startTime = Date.now();

        this.Private_ParseGlobalLibrary(SbtDataEnum.GlobalLibraryFacesFrontId, "Front");
        this.Private_ParseGlobalLibrary(SbtDataEnum.GlobalLibraryFacesSideId, "Side");

        $("#global_library_load").remove();

       // console.log("Faces Load Time: " + (Date.now() - startTime));
    }

    this.Private_ParseGlobalLibrary = function (libraryId, position)
    {
        
        this.Private_Library[position] = new Object();

        MyShapeMetaData.LookForMetaData(libraryId);

        var library = $("#" + libraryId);
        var metaData = $("#" + libraryId).find("sbtdata");
        var swapLibrary = metaData.find("swaplibrary");
        var swapLibraryOptions = swapLibrary.find("swaplibraryoption");
        

        library.attr("display", "inline");
        for (var i = 0; i < swapLibraryOptions.length; i++)  
        {
            
            var swapLibraryOption = swapLibraryOptions[i];
            var swapLibraryId = GetSafeAttributeNS(swapLibraryOption, SbtDataEnum.Attribute_LibrarySwapOption_SwapId);
            

            

            var libraryImage = library.find("#" + swapLibraryId).remove();
            this.Private_Library[position][swapLibraryId] = libraryImage;
            
        }
    };

    this.Public_GetSvgById = function (id, position)
    {
        if (position == null)
        {
            position = "Front";
        }
        return this.Private_Library[position][id];    // long term - be a LOT smarter
    };

    this.Private_LoadLibrary();
}