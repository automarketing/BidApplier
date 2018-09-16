var AdminHelper = function ()
{
    var AdminHelperObject = new Object();

    AdminHelperObject.DescriptionStandards = function ()
    {
        GestureHelper.DescriptionEmphasis();

    };

    AdminHelperObject.TitleStandards = function ()
    {
        GestureHelper.TitleEmphasis();

    };

    AdminHelperObject.CapitalizeTitles = function ()
    {
        GestureHelper.CapitalizeTitles();
    };

    function PerformTranslation(language)
    {
        var shapeStates = MyShapesState.Public_GetAllShapeStates();
        for (var i = 0; i < shapeStates.length; i++)
        {
            var shapeState = shapeStates[i];


            if (UseSummerNote)
            {
                var deltas = shapeState.TextState.Public_GetQuillDeltas();
                if (deltas == null)
                    continue;

                for (var j = 0; j < deltas.length; j++)
                {
                    if (deltas[j].insert != null && deltas[j].insert.trim() != "")
                    {
                        var postData = { language: language, text: deltas[j].insert, shape_state_id: shapeState.Id, index: j };

                        $.post("/langmap/translatestoryboardtext", postData, function (data)
                        {

                            //direct access, to avoid race conditions
                            MyShapesState.Public_GetShapeStateById(data.ShapeStateId).TextState._QuillDeltas[data.index].insert = data.Translation;
                            MyShapesState.Public_GetShapeStateById(data.ShapeStateId).TextState._QuillDeltas[data.index].attributes.font = GetLocalizedFont(language, MyShapesState.Public_GetShapeStateById(data.ShapeStateId).TextState._QuillDeltas[data.index].attributes.font);
                            MyShapesState.Public_GetShapeStateById(data.ShapeStateId).UpdateDrawing(true);
                        });
                    }
                }
            }
            else
            {
                if (shapeState.TextState.Text != "")
                {
                    shapeState.SetFontFace(GetLocalizedFont(language, shapeState.GetFontFace()));

                    var postData = { language: language, text: shapeState.TextState.Text, shape_state_id: shapeState.Id };

                    $.post("/langmap/translatestoryboardtext", postData, function (data)
                    {
                        MyShapesState.Public_GetShapeStateById(data.ShapeStateId).SetText(data.Translation);
                        MyShapesState.Public_GetShapeStateById(data.ShapeStateId).UpdateDrawing(true);
                    });
                }
            }
        }
        window.setTimeout(AdminHelper.UpdateFontPlacement, 5 * 1000);
    };

    function PerformFontReplacementsOnly(language)
    {
        var shapeStates = MyShapesState.Public_GetAllShapeStates();
        for (var i = 0; i < shapeStates.length; i++)
        {
            var shapeState = shapeStates[i];

            if (shapeState.TextState.Text != "")
            {
                for (var j = 0; j < shapeState.TextState._QuillDeltas.length; j++)
                {
                    var localizeFont = GetLocalizedFont(language, shapeState.TextState._QuillDeltas[j].attributes.font);
                    shapeState.TextState._QuillDeltas[j].attributes.font = localizeFont;
                }

                shapeState.UpdateDrawing(true);

            }
        }

        window.setTimeout(AdminHelper.UpdateFontPlacement, 5 * 1000);


    }

    function GetLocalizedFont(language, font)
    {
        font = font.replaceAll("\'", "\"");
        var fontsMap = [];
        fontsMap["Coustard"] = [];
        fontsMap["Coustard"]["he"] = "Tinos";
        fontsMap["Coustard"]["ar"] = "Lateef";
        fontsMap["Coustard"]["hi"] = "\"Noto Sans\"";
        fontsMap["Coustard"]["ru"] = "Lora"
        fontsMap["Coustard"]["bg"] = "Lora"
        fontsMap["Coustard"]["ro"] = "\"Suez One\"";
        fontsMap["Coustard"]["pl"] = "\"Suez One\"";
        fontsMap["Coustard"]["cs"] = "\"Suez One\"";
        fontsMap["Coustard"]["tr"] = "\"Suez One\"";
        fontsMap["Coustard"]["sk"] = "\"Suez One\"";
        fontsMap["Coustard"]["hu"] = "\"Suez One\"";
        fontsMap["Coustard"]["hr"] = "\"Suez One\"";
        fontsMap["Coustard"]["lt"] = "\"Suez One\"";
        fontsMap["Coustard"]["sl"] = "\"Suez One\"";
        fontsMap["Coustard"]["lv"] = "\"Suez One\"";
        fontsMap["Coustard"]["et"] = "\"Suez One\"";

        fontsMap["Creepster"] = [];
        fontsMap["Creepster"]["he"] = "\"Suez One\"";
        fontsMap["Creepster"]["ar"] = "Lalezar";
        fontsMap["Creepster"]["hi"] = "\"Palanquin Dark\"";
        fontsMap["Creepster"]["ru"] = "\"Noto Sans\""
        fontsMap["Creepster"]["bg"] = "\"Noto Sans\""
        fontsMap["Creepster"]["ro"] = "Dekko";
        fontsMap["Creepster"]["pl"] = "Dekko";
        fontsMap["Creepster"]["cs"] = "Dekko";
        fontsMap["Creepster"]["tr"] = "Dekko";
        fontsMap["Creepster"]["sk"] = "Dekko";
        fontsMap["Creepster"]["hr"] = "Dekko";
        fontsMap["Creepster"]["hu"] = "Dekko";
        fontsMap["Creepster"]["lt"] = "Dekko";
        fontsMap["Creepster"]["sl"] = "Dekko";
        fontsMap["Creepster"]["lv"] = "Dekko";
        fontsMap["Creepster"]["et"] = "Dekko";

        fontsMap["Dekko"] = [];
        fontsMap["Dekko"]["ru"] = "Roboto";

        fontsMap["\"Francois One\""] = [];
        fontsMap["\"Francois One\""]["he"] = "\"Suez One\"";
        fontsMap["\"Francois One\""]["ar"] = "Lalezar";
        fontsMap["\"Francois One\""]["hi"] = "\"Palanquin Dark\"";
        fontsMap["\"Francois One\""]["ru"] = "Roboto"
        fontsMap["\"Francois One\""]["bg"] = "Roboto"
        fontsMap["\"Francois One\""]["ro"] = "\"Palanquin Dark\"";
        fontsMap["\"Francois One\""]["pl"] = "\"Palanquin Dark\"";
        fontsMap["\"Francois One\""]["cs"] = "\"Palanquin Dark\"";
        fontsMap["\"Francois One\""]["tr"] = "\"Palanquin Dark\"";
        fontsMap["\"Francois One\""]["sk"] = "\"Palanquin Dark\"";
        fontsMap["\"Francois One\""]["hr"] = "\"Palanquin Dark\"";
        fontsMap["\"Francois One\""]["hu"] = "\"Palanquin Dark\"";
        fontsMap["\"Francois One\""]["lt"] = "\"Palanquin Dark\"";
        fontsMap["\"Francois One\""]["sl"] = "\"Palanquin Dark\"";
        fontsMap["\"Francois One\""]["lv"] = "\"Palanquin Dark\"";
        fontsMap["\"Francois One\""]["et"] = "\"Palanquin Dark\"";

        fontsMap["\"Germania One\""] = [];
        fontsMap["\"Germania One\""]["he"] = "\"Suez One\"";
        fontsMap["\"Germania One\""]["ar"] = "Lateef";
        fontsMap["\"Germania One\""]["hi"] = "\"Palanquin Dark\"";
        fontsMap["\"Germania One\""]["ru"] = "\"Noto Sans\""
        fontsMap["\"Germania One\""]["bg"] = "\"Noto Sans\""
        fontsMap["\"Germania One\""]["ro"] = "\"Suez One\"";
        fontsMap["\"Germania One\""]["tr"] = "\"Suez One\"";
        fontsMap["\"Germania One\""]["pl"] = "\"Suez One\"";
        fontsMap["\"Germania One\""]["cs"] = "\"Suez One\"";
        fontsMap["\"Germania One\""]["sk"] = "\"Suez One\"";
        fontsMap["\"Germania One\""]["hr"] = "\"Suez One\"";
        fontsMap["\"Germania One\""]["hu"] = "\"Suez One\"";
        fontsMap["\"Germania One\""]["lt"] = "\"Suez One\"";
        fontsMap["\"Germania One\""]["sl"] = "\"Suez One\"";
        fontsMap["\"Germania One\""]["lv"] = "\"Suez One\"";
        fontsMap["\"Germania One\""]["et"] = "\"Suez One\"";


        fontsMap["\"Komika Text\""] = [];
        fontsMap["\"Komika Text\""]["he"] = "\"Varela Round\"";
        fontsMap["\"Komika Text\""]["ar"] = "Lemonada";
        fontsMap["\"Komika Text\""]["hi"] = "Dekko";
        fontsMap["\"Komika Text\""]["ru"] = "\"Noto Sans\"";
        fontsMap["\"Komika Text\""]["bg"] = "\"Noto Sans\"";
        fontsMap["\"Komika Text\""]["ro"] = "Dekko";
        fontsMap["\"Komika Text\""]["pl"] = "Dekko";
        fontsMap["\"Komika Text\""]["cs"] = "Dekko";
        fontsMap["\"Komika Text\""]["tr"] = "Dekko";
        fontsMap["\"Komika Text\""]["sk"] = "Dekko";
        fontsMap["\"Komika Text\""]["hr"] = "Dekko";
        fontsMap["\"Komika Text\""]["hu"] = "Dekko";
        fontsMap["\"Komika Text\""]["lt"] = "Dekko";
        fontsMap["\"Komika Text\""]["sl"] = "Dekko";
        fontsMap["\"Komika Text\""]["lv"] = "Dekko";
        fontsMap["\"Komika Text\""]["et"] = "Dekko";


        fontsMap["Lalezar"] = [];
        fontsMap["Lalezar"]["ru"] = "Roboto";
        fontsMap["Lalezar"]["bg"] = "Roboto";

        fontsMap["Lateef"] = [];
        fontsMap["Lateef"]["ru"] = "Tinos";
        fontsMap["Lateef"]["bg"] = "Tinos";
        fontsMap["Lateef"]["sk"] = "Tinos";
        fontsMap["Lateef"]["hr"] = "Tinos";
        fontsMap["Lateef"]["hu"] = "Tinos";
        fontsMap["Lateef"]["lt"] = "Tinos";
        fontsMap["Lateef"]["sl"] = "Tinos";
        fontsMap["Lateef"]["lv"] = "Tinos";
        fontsMap["Lateef"]["et"] = "Tinos";

        fontsMap["Lemonada"] = [];
        fontsMap["Lemonada"]["ru"] = "\"Noto Sans\"";
        fontsMap["Lemonada"]["bg"] = "\"Noto Sans\"";

        fontsMap["\"Lobster Two\""] = [];
        fontsMap["\"Lobster Two\""]["he"] = "Tinos";
        fontsMap["\"Lobster Two\""]["ar"] = "Lemonada";
        fontsMap["\"Lobster Two\""]["hi"] = "Dekko";
        fontsMap["\"Lobster Two\""]["ru"] = "\"Noto Sans\""
        fontsMap["\"Lobster Two\""]["bg"] = "\"Noto Sans\""
        fontsMap["\"Lobster Two\""]["ro"] = "Lemonada";
        fontsMap["\"Lobster Two\""]["pl"] = "Lemonada";
        fontsMap["\"Lobster Two\""]["cs"] = "Lemonada";
        fontsMap["\"Lobster Two\""]["tr"] = "Lemonada";

        fontsMap["Lora"] = [];
        fontsMap["Lora"]["he"] = "Tinos";
        fontsMap["Lora"]["ar"] = "Lateef";
        fontsMap["Lora"]["hi"] = "\"Noto Sans\"";
        fontsMap["Lora"]["ro"] = "Lemonada";
        fontsMap["Lora"]["pl"] = "Lemonada";
        fontsMap["Lora"]["cs"] = "Lemonada";
        fontsMap["Lora"]["tr"] = "Lemonada";

        fontsMap["\"Montserrat Alternates\""] = [];
        fontsMap["\"Montserrat Alternates\""]["he"] = "\"Varela Round\"";
        fontsMap["\"Montserrat Alternates\""]["ar"] = "Lemonada";
        fontsMap["\"Montserrat Alternates\""]["hi"] = "Dekko";
        fontsMap["\"Montserrat Alternates\""]["ru"] = "Tinos";
        fontsMap["\"Montserrat Alternates\""]["bg"] = "Tinos";
        fontsMap["\"Montserrat Alternates\""]["ro"] = "\"Palanquin Dark\"";
        fontsMap["\"Montserrat Alternates\""]["pl"] = "\"Palanquin Dark\"";
        fontsMap["\"Montserrat Alternates\""]["cs"] = "\"Palanquin Dark\"";
        fontsMap["\"Montserrat Alternates\""]["tr"] = "\"Palanquin Dark\"";
        fontsMap["\"Montserrat Alternates\""]["sk"] = "\"Palanquin Dark\"";
        fontsMap["\"Montserrat Alternates\""]["hr"] = "\"Palanquin Dark\"";
        fontsMap["\"Montserrat Alternates\""]["hu"] = "\"Palanquin Dark\"";
        fontsMap["\"Montserrat Alternates\""]["lt"] = "\"Palanquin Dark\"";
        fontsMap["\"Montserrat Alternates\""]["sl"] = "\"Palanquin Dark\"";
        fontsMap["\"Montserrat Alternates\""]["lv"] = "\"Palanquin Dark\"";
        fontsMap["\"Montserrat Alternates\""]["et"] = "\"Palanquin Dark\"";

        fontsMap["OpenDyslexic"] = [];
        fontsMap["OpenDyslexic"]["he"] = "\"Varela Round\"";
        fontsMap["OpenDyslexic"]["ar"] = "Lemonada";
        fontsMap["OpenDyslexic"]["hi"] = "Dekko";
        fontsMap["OpenDyslexic"]["ru"] = "Roboto"
        fontsMap["OpenDyslexic"]["bg"] = "Roboto"

        fontsMap["\"Palenquin Dark\""] = [];
        fontsMap["\"Palenquin Dark\""]["ru"] = "Roboto";
        fontsMap["\"Palenquin Dark\""]["bg"] = "Roboto";

        fontsMap["Roboto"] = [];
        fontsMap["Roboto"]["he"] = "\"Varela Round\"";
        fontsMap["Roboto"]["ar"] = "Lemonada";
        fontsMap["Roboto"]["hi"] = "\Noto Sans\"";
        fontsMap["Roboto"]["ro"] = "\"Varela Round\"";

        fontsMap["Tinos"] = [];

        fontsMap["\"Varela Round\""] = [];
        fontsMap["\"Varela Round\""]["ru"] = "Tinos";
        fontsMap["\"Varela Round\""]["bg"] = "Tinos";
        fontsMap["\"Varela Round\""]["sk"] = "Tinos";
        fontsMap["\"Varela Round\""]["hr"] = "Tinos";
        fontsMap["\"Varela Round\""]["hu"] = "Tinos";
        fontsMap["\"Varela Round\""]["lt"] = "Tinos";
        fontsMap["\"Varela Round\""]["sl"] = "Tinos";
        fontsMap["\"Varela Round\""]["lv"] = "Tinos";
        fontsMap["\"Varela Round\""]["et"] = "Tinos";





        if (fontsMap[font] == null)
            return font;

        if (fontsMap[font][language] == null)
            return font;

        return fontsMap[font][language];




    }

    AdminHelperObject.TranslateText = function ()
    {
        var language = $("#admin-language-selector").val();

        PerformTranslation(language);
    };

    AdminHelperObject.UpdateFonts = function ()
    {
        var language = GetQSParameterByName("fonts");
        if (language == null)
            return;

        PerformFontReplacementsOnly(language);
    };

    AdminHelperObject.AutoTranslate = function ()
    {
        var language = GetQSParameterByName("translate");
        if (language == null)
            return;

        PerformTranslation(language);
    };

    AdminHelperObject.UpdateFontPlacement = function ()
    {


        var shapeStates = MyShapesState.Public_GetAllShapeStates();
        for (var i = 0; i < shapeStates.length; i++)
        {
            shapeStates[i].UpdateDrawing(true);

        }
    }
    return AdminHelperObject;
}();



function LoadAdminSettings()
{
    $('#admin-button-title-standards').click(AdminHelper.TitleStandards);
    $('#admin-button-description-standards').click(AdminHelper.DescriptionStandards);
    $('#admin-button-title-case').click(AdminHelper.CapitalizeTitles);
    $('#admin-button-translate').click(AdminHelper.TranslateText);

    AdminHelper.AutoTranslate();
    AdminHelper.UpdateFonts();
}
window.setTimeout(LoadAdminSettings, 5 * 1000);

function DebugLine(message)
{
    try
    {
        console.log(message);
    } catch (e) // this way IE won't crash
    {

    }
}


function ThinSecondTabs(textHeight, navBarHeight)
{
    //$(".second-category").css("line-height", textHeight);
    $("[class^=cliplib]").css("line-height", textHeight);
    $(".subcategories").css("min-height", navBarHeight);

    StoryboardContainer.JiggleSvgSize();
    StoryboardContainer.SetCoreSvgDimensions();
}

function ChangeColors()
{
    //behind Canvas
    $(".svgContainer").css("background-color", "#E0E1DC");

    //Core Svg
    MyPointers.CoreSvg.css("background-color", "white");
    MyPointers.CoreSvg.css("box-shadow", "none");
    MyPointers.CoreSvg.css("webkit-box-shadow", "none");

    //tabs
    $("#myTab").find("a").css("color", "#252525");
    $("#myTab li.active a.tab-link").css("background-color", "#C0C0BE")
    $("#myTab li.active a.tab-link").css("color", "white")


    $(".subcategories").css("background-color", "#efefef");

    $(".subcategory-ul").find("a").css("color", "#3C3C3C")

    $(".subcategory-ul").find(".active").find("a").css("background-color", "white")
    $(".subcategory-ul").find(".active").find("a").css("color", "#0A889D")

    $(".content-wrapper").css("background-color", "white");


    //buttons
    $(".btn-primary").css("background-color", "#07889B");
    $(".btn-primary").css("background-image", "none");
    $(".btn-primary").css("border", "none");
    $(".btn-primary").css("box-shadow", "none");
    $(".btn-primary").css("webkit-box-shadow", "none");

    //CTA
    $(".Upgrade-Bar").css("background-color", "#E37222");
    $(".Upgrade-Bar").css("color", "white");
}

function ChangeFont()
{
    $("body").css("font-family", 'Roboto');
}

function HideAdminButtons()
{
    $("#admin-buttons").toggle();
    $("#admin-ui-buttons").toggle();
    $(".Upgrade-Bar").toggle();

    StoryboardContainer.JiggleSvgSize();
    StoryboardContainer.SetCoreSvgDimensions();
}

function PositionTabRoller()
{
    var tabRoller = $("#tab-roller");
    var topNavDiv = $("#top-nav-div");

    tabRoller.css("top", topNavDiv.height());
}

//window.setTimeout(PositionTabRoller, 1500);






