$(document).ready(function ()
{
    //if ($('#sliding') != null && $('#sliding').length>0)
    //{
    //    $('#sliding').roundabout();
    //}


    // For iOS Home Screen apps, we need to force links to remain within the confines of the hosted environment and NOT open safari!
    // Note: we run a test to only do in when in standalone mode, so we don't alter the site in any other condition!
    if (window.navigator.standalone)
    {
        $('a').click(function ()
        {
            if ($(this).attr('href').indexOf('javascript:') < 0)
            {
                document.location = $(this).attr('href');
                return false;
            }
        });
    }

    if ($('#toc_content') != null && $('#toc_content').length > 0)
    {
        $('#toc_content').toc();
    }

    LoadCloudAdminUI();
});

function GetQSParameterByName(name)
{
    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}

//#region Cloud Admin



function LoadCloudAdminUI()
{
    // if we have a cloudadmin sidenav
    if ($('#menu > ul > li > a').length > 0)
    {
        $('#menu > ul > li > a').click(function ()
        {
            $('#menu li').removeClass('active');
            $(this).closest('li').addClass('active');
            var checkElement = $(this).next();
            if ((checkElement.is('ul')) && (checkElement.is(':visible')))
            {
                $(this).closest('li').removeClass('active');
                checkElement.slideUp('normal');
            }
            if ((checkElement.is('ul')) && (!checkElement.is(':visible')))
            {
                $('#menu ul ul:visible').slideUp('normal');
                checkElement.slideDown('normal');
            }
            if ($(this).closest('li').find('ul').children().length == 0)
            {
                return true;
            } else
            {
                return false;
            }
        });
    }

    if ($('#mob-nav').length > 0)
    {
        $('#mob-nav').click(function ()
        {
            if ($('aside.open').length > 0)
            {
                $("aside").animate({ left: "-320px" }, 500).removeClass('open');
            } else
            {
                $("aside").animate({ left: "0px" }, 500).addClass('open');
            }
        });
    }
}
//#endregion


//#region Powerpoints / Image Packs


function CreateImagePack(url)
{

    if (RequestedImagePack)
    {
        swal(ImagePackMessage_AlreadyRequested);
        return;
    }

    RequestedImagePack = true;

    location.href = url;
    swal(ImagePackMessage_DownloadStart_Title, ImagePackMessage_DownloadStart_Blurb);

    $("#DownloadOptions").modal('hide');
}

//#endregion


//#region "Pricing"
function ChangeCurrency(currency, guid)
{
    //currency selectors
    $("[id*=-currency-label-]").removeClass("active");
    $("[id*=-currency-label-" + currency + "]").addClass("active");

    //various places we show prices
    $("[id*=-pricing-table]").css("display", "none")
    $("[id*=-pricing-starting-at-]").css("display", "none")


    $("[id*=-pricing-table-" + currency + "]").css("display", "")
    $("[id$=-pricing-starting-at-" + currency + "]").css("display", "")

    if (guid != null)
        $("#cs-" + guid + "-currency-label-" + currency).removeClass("active"); // the onclick toggles active so if we add it, it goes away
}

//#region Stripe

function PopStripeNotLoggedOn_ShowDialog(description, amount, frequency, users, currency)
{
    if (IsUserLoggedOn)
    {
        PopStripe(description, amount, frequency, users, '', currency);
        return;
    }

    HandleLoginCloseFunction = function ()
    {
        PopStripeNotLoggedOn_PostLogonDialog(description, amount, frequency, users, currency);
    };

    showLogonDialog();
}

function PopStripeNotLoggedOn_PostLogonDialog(description, amount, frequency, users, currency)
{
    HandleLoginCloseFunction = null;

    UpdateIsLoggedOn();
    if (IsUserLoggedOn)
    {
        PopStripe(description, amount, frequency, users, '', currency);
        return;
    }
    else
    {
        swal("In order to purchase Storyboard That you need to logon to your account.");
    }
}

function PopStripe(description, amount, frequency, users, portalType, currency)
{
    var individualPopup = $("#individualPricing");
    if (individualPopup != null && individualPopup.length > 0)//without this STRIPE doesn't work in IE
    {
        individualPopup.modal('hide');
    }

    $("#frequency").val(frequency);
    $("#users").val(users);
    $("#portalType").val(portalType);
    $("#currency").val(currency);
    //$("#price").val(amount);

    var token = function (res)
    {
        var $input = $('<input type=hidden name=stripeToken />').val(res.id);
        $("#purchase_form").append($input).submit();
    };

    //key:         'pk_test_augjH7STxuNLq644czAlKBnj',
    //key:        'pk_live_XJJF9ZNxKZAVtu0F6ILLvokx',
    StripeCheckout.open(
        {
            key: StripeJSKey,
            address: true,
            amount: amount,
            currency: currency,
            name: 'Storyboard That',
            description: description,
            panelLabel: 'Checkout',
            image: 'https://www.storyboardthat.com/content/site_images/logos/storyboard-that-logo-128x128.png',
            token: token
        });

    return false;
}

//#endregion Stripe
//#endregion

function ToggleArea(area)
{
    $("#" + area).toggle();
    //$("#Hide" + area).toggle();

    var hideButton = $("#Hide" + area);
    if (hideButton.text().trim() == "(Hide)")
    {
        hideButton.text("(Show More)");
    }
    else
    {
        hideButton.text("(Hide)");
    }
}


//#region "Test code"

//function SpellCheck()
//{
//    var ta = document.createElement('textarea');
//    var s = document.createAttribute('style');
//    s.nodeValue = 'width:100%;height:100em;';
//    ta.setAttributeNode(s);
//    ta.appendChild(document.createTextNode(document.body.innerText));
//    document.body.appendChild(ta);
//    ta.focus();
//    for (var i = 1; i <= ta.value.length; i++)
//        ta.setSelectionRange(i, i);
//}

//#endregion

//#region "Email Validation"

function IsEmail(email)
{
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

function ValidateAndCleanEmail(inputId)
{
    var email = $("#" + inputId).val();
    if (email == null || email == "")
        return;

    if (email.indexOf("<") > 0)
    {
        email = email.substring(email.indexOf("<"));
        email = email.replace("<", "");
        email = email.replace(">", "");
    }
    if (email.indexOf("(") > 0)
    {
        email = email.substring(email.indexOf("("));
        email = email.replace("(", "");
        email = email.replace(")", "");
    }

    email = email.replace(" ", "");
    email = email.replace(",", "");
    email = email.replace(";", "");

    $("#" + inputId).val(email);

}
//#endregion

//#region SlideShow
function AddExtraFonts(svgId)
{
    var svg = $("#" + svgId);
    var html = svg.html();

    html = html.toLowerCase();
    if (html.indexOf("varela round"))
    {
        $('head').append('<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Varela+Round" type="text/css" />');
    }
    if (html.indexOf("tinos"))
    {
        $('head').append('<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Tinos" type="text/css" />');
    }
    if (html.indexOf("suez"))
    {
        $('head').append('<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Suez+One" type="text/css" />');
    }
    if (html.indexOf("lemonada"))
    {
        $('head').append('<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Lemonada" type="text/css" />');
    }
    if (html.indexOf("lateef"))
    {
        $('head').append('<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Lateef" type="text/css" />');
    }
    if (html.indexOf("lalezar"))
    {
        $('head').append('<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Lalezar" type="text/css" />');
    }
    if (html.indexOf("dekko"))
    {
        $('head').append('<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Dekko" type="text/css" />');
    }
    if (html.indexOf("noto"))
    {
        $('head').append('<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans" type="text/css" />');
    }
    if (html.indexOf("palanquin"))
    {
        $('head').append('<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Palanquin+Dark" type="text/css" />');
    }
}
//#endregion

//#region SlideShow


var currentSlideShowColumn = 0;
var currentSlideShowRow = 0;


var StoryboardDimensions = null;



function LoadSlideShowDiv(url)
{
    $('body').append('<div id="slide-show-div"></div>');
    $.ajax({
        url: url,
        success: function (data)
        {
            $('#slide-show-div').html(data);
        }
    });
}

function CloseSlideShow()
{
    $(window).unbind("resize");
    $(document).unbind("keyup");
    $("#slide-show-div").remove();
}

function LoadSlideShowSvg(svgPath)
{
    var url = GeoServer + "/storyboardimages/loadstoryboardsvg?url=" + svgPath;
    $.ajax({
        type: 'GET',
        timeout: 120 * 1000,
        url: url,
        contentType: "application/json",
        dataType: 'json',
        success: LoadSlideShowSvg_success,
        cache: false
    });

}

function CalculateRowsAndCols(svg)
{
    var myIdGenerator = new IdGenerator();

    var storyboardSize = new Object();
    storyboardSize.Rows = 1;
    storyboardSize.Cols = 1;
    storyboardSize.SvgPointer = svg;

    for (var col = 1; col < 100; col++)
    {
        var cell = svg.find("#" + myIdGenerator.GenerateCellId(0, col));
        if (cell.length > 0)
            storyboardSize.Cols = col + 1;
        else
            break;
    }

    for (var row = 1; row < 100; row++)
    {
        var cell = svg.find("#" + myIdGenerator.GenerateCellId(row, 0));
        if (cell.length > 0)
            storyboardSize.Rows = row + 1;
        else
            break;
    }

    storyboardSize.HasTitles = myIdGenerator.GenerateTitleCellId(0, 0).length > 0;
    storyboardSize.HasDescriptions = myIdGenerator.GenerateDescriptionCellId(0, 0).length > 0;

    return storyboardSize;
}

function LoadSlideShowSvg_success(data)
{
    var svgContainer = $("#svg-slideshow-inner-container");

    svgContainer.append(data.svg);
    var svg = svgContainer.children().first();
    StoryboardDimensions = CalculateRowsAndCols(svg);

    $("#CoreSvg").css("background-color", "");

    $(window).resize(SetSlideShowScale);

    $(document).keyup(function (e)
    {

        if (e.keyCode == 27) { CloseSlideShow(); }   // esc
        if (e.keyCode == 37) { MoveSlideShowLeft(); }
        if (e.keyCode == 39) { MoveSlideShowRight(); }
    });

    $("#svg-slideshow-container").click(HandleSlideShowClick);
    $("#black-out-screen").click(HandleSlideShowClick);

    currentSlideShowColumn = 0;
    currentSlideShowRow = 0;

    AddExtraFonts("svg-slideshow-inner-container");

    SlideShowMoveCell(0, 0);
    window.scrollTo(0, 0);
}

function MoveSlideShowLeft()
{
    if (currentSlideShowColumn > 0)
    {
        currentSlideShowColumn--;
    }
    else if (currentSlideShowRow > 0)
    {
        currentSlideShowColumn = StoryboardDimensions.Cols - 1;
        currentSlideShowRow--;
    }
    else
    {
        currentSlideShowColumn = StoryboardDimensions.Cols - 1;
        currentSlideShowRow = StoryboardDimensions.Rows - 1;
    }

    SlideShowMoveCell(currentSlideShowRow, currentSlideShowColumn);
};

function MoveSlideShowRight()
{
    if (currentSlideShowColumn < StoryboardDimensions.Cols - 1)
    {
        currentSlideShowColumn++;
    }
    else if (currentSlideShowRow < StoryboardDimensions.Rows - 1)
    {
        currentSlideShowColumn = 0;
        currentSlideShowRow++;
    }
    else
    {
        currentSlideShowColumn = 0;
        currentSlideShowRow = 0;
    }

    SlideShowMoveCell(currentSlideShowRow, currentSlideShowColumn);
};

function GetTextAreaDimensions(cell)
{
    var cellDetails = new Object();
    try
    {
        var trans = "translate(";
        var translate = cell.attr("transform");

        translate = translate.substring(translate.indexOf(trans) + trans.length, 100)
        translate = translate.substring(0, translate.indexOf(")"));

        try
        {
            var cords = translate.split(",");
            cellDetails.X = parseFloat(cords[0].trim());
            cellDetails.Y = parseFloat(cords[1].trim());
        } catch (e)
        {
            //ie 9 uses a space not a ,    abs 2/3/15
            var cords = translate.split(" ");
            cellDetails.X = parseFloat(cords[0].trim());
            cellDetails.Y = parseFloat(cords[1].trim());
        }


        var textBox = cell.find("rect").first();
        cellDetails.Width = parseFloat(textBox.attr("width"));
        cellDetails.Height = parseFloat(textBox.attr("height"));

        return cellDetails;
    } catch (e)
    {

    }
    return null;

}

function GetFullCellDimensions(row, col)
{
    var box = new Object();
    var myIdGenerator = new IdGenerator();

    var cell = StoryboardDimensions.SvgPointer.find("#" + myIdGenerator.GenerateCellId(row, col));
    box.X = parseFloat(cell.attr("x"));
    box.Y = parseFloat(cell.attr("y"));
    box.Width = parseFloat(cell.attr("width"));
    box.Height = parseFloat(cell.attr("height"));

    if (StoryboardDimensions.HasTitles)
    {
        var titleCell = StoryboardDimensions.SvgPointer.find("#" + myIdGenerator.GenerateTitleCellId(row, col));
        if (titleCell != null)
        {
            var titleDimensions = GetTextAreaDimensions(titleCell);
            if (titleDimensions != null)
            {
                box.Height = (box.Y - titleDimensions.Y) + box.Height;
                box.Y = titleDimensions.Y;
            }
        }
    }


    if (StoryboardDimensions.HasDescriptions)
    {
        var descriptionCell = StoryboardDimensions.SvgPointer.find("#" + myIdGenerator.GenerateDescriptionCellId(row, col));
        if (descriptionCell != null)
        {
            var descriptionDimensions = GetTextAreaDimensions(descriptionCell);
            if (descriptionDimensions != null)
            {
                box.Height = (descriptionDimensions.Y - box.Y) + descriptionDimensions.Height;
            }
        }
    }

    // add stroke offsets and a bit to spare - should be 3px total, but firefox is taking 10 .. ABS 2/3/15
    box.Height += 10;
    box.Width += 10;
    box.X -= 5;
    box.Y -= 5;

    box.Type = "CellDimensions";
    return box;
}

function SlideShowMoveCell(row, col)
{
    var box = GetFullCellDimensions(row, col);

    var cords = box.X + " " + box.Y + " " + box.Width + " " + box.Height;
    var core = GetGlobalById("svg-slideshow-inner-container").children[0];

    SetSlideShowScale(box);
    core.setAttributeNS(null, "viewBox", cords);
    core.setAttributeNS(null, "width", box.Width);
    core.setAttributeNS(null, "height", box.Height);

}

function SetSlideShowScale(box)
{
    if (box == null || box.Type == null || box.Type != "CellDimensions")
    {
        box = GetFullCellDimensions(currentSlideShowRow, currentSlideShowColumn);
    }

    var container = $("#svg-slideshow-container");
    var slideShowControls = $("#slide-show-controls");
    var width = $(window).width() - 20;
    var height = ($(window).height()) - (2 * slideShowControls.height()) - 100;

    var scale = Math.min(width / (box.Width), height / (box.Height));

    var svgContainer = GetGlobalById("svg-slideshow-inner-container");
    svgContainer.setAttributeNS(null, "transform", "scale(" + scale + ")");

    var outerContainer = $("#svg-slideshow-container-outermost-svg");
    outerContainer.attr("width", (box.Width * scale) + "px");
    outerContainer.attr("height", (box.Height * scale) + "px");
}

function HandleSlideShowClick(e)
{
    if (e.target.id === "svg-slideshow-container" || e.target.id === "black-out-screen")
    {
        CloseSlideShow();
    }
    else
    {
        MoveSlideShowRight();
    }
}


//#endregion 



function inheritPrototype(childObject, parentObject)
{
    // As discussed above, we use the Crockford’s method to copy the properties and methods from the parentObject onto the childObject​ So the copyOfParent object now has everything the parentObject has ​
    var copyOfParent = Object.create(parentObject.prototype);

    //Then we set the constructor of this new object to point to the childObject.​ Why do we manually set the copyOfParent constructor here, see the explanation immediately following this code block.​
    copyOfParent.constructor = childObject;

    // Then we set the childObject prototype to copyOfParent, so that the childObject can in turn inherit everything from copyOfParent (from parentObject)​
    childObject.prototype = copyOfParent;
}


function LogErrorMessage(method, error)
{
    try
    {
        //console.log(method + " "  + error)
        if (error == null)
        {
            error = new Object();
            error.message = "";
            error.stack = "";
        }



        try
        {
            var svnRev = "3379";
            var rev = "$WCMOD"
            method = "V:" + SvnRevision + " - " + method;
        }
        catch (e)
        {

        }
        var postData = new Object();

        postData.Url = window.location.href;
        postData.Method = method;
        postData.ErrorMessage = error.message;
        postData.StackTrace = error.stack;

        //var extraDebug = false;
        //if (window.ExtraDebug )

        if ("ExtraDebug" in window && ExtraDebug == true)
        {
            DebugLine(postData);
            DebugLine(postData.ErrorMessage);
            DebugLine(postData.StackTrace);
        }


        $.ajax({
            type: "POST",
            url: "/api_storyboardcreator/logstoryboardjserror",
            timeout: 180 * 1000,
            data: postData,
            success: null,
            error: null
        });


    } catch (e)
    {
        DebugLine("Log Error Message:" + e);
    }
}

function DebugLine(message)
{
    try
    {
        console.log(message);
    } catch (e) // this way IE won't crash
    {

    }
}

//http://stackoverflow.com/questions/133925/javascript-post-request-like-a-form-submit
function FakePost(path, params)
{
    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", path);

    for (var key in params)
    {
        if (params.hasOwnProperty(key))
        {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);
    form.submit();
}

String.prototype.replaceAll2 = function (str1, str2, ignore)
{
    return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g, "\\$&"), (ignore ? "gi" : "g")), (typeof (str2) == "string") ? str2.replace(/\$/g, "$$$$") : str2);
}

function SwalLineBreaks(text)
{
    return text.replaceAll2("<br>", "\r\n");
}

function find_duplicates(arr)
{
    var len = arr.length,
        out = [],
        counts = {};

    for (var i = 0; i < len; i++)
    {
        var item = arr[i];
        counts[item] = counts[item] >= 1 ? counts[item] + 1 : 1;
        if (counts[item] === 2)
        {
            out.push(item);
        }
    }

    return out.sort();
}


function GetScriptIfNotLoaded(scriptLocationAndName)
{
    var len = $('script[src*="' + scriptLocationAndName +'"]').length;

    if (len === 0)
    {
        var head = document.getElementsByTagName('head')[0];
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = scriptLocationAndName;
        head.appendChild(script);
    }

}

SbtUIHelper = function ()
{
    var SbtUIHelperObject = new Object();
    
    SbtUIHelperObject.ScrollToId = function (scrollTo, offset)
    {
        if ($("#" + scrollTo).css("display") != "none")
        {
            $(window).scrollTop($('#' + scrollTo).offset().top - offset);
        }
    };

    return SbtUIHelperObject;
}();

function getElementOffset(element)
{
    var de = document.documentElement;
    var box = element.getBoundingClientRect();
    var top = box.top + window.pageYOffset - de.clientTop;
    var left = box.left + window.pageXOffset - de.clientLeft;
    return { top: top, left: left };
}