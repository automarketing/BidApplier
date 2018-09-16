///  <reference path="SvgManip.js" />
function BrowserProperties()
{
    this.ClipartDisplayWidth = 66;
    this.ClipartDisplayHeight = 95;

    this.ClipartDisplayWidthScene = 105;
    this.ClipartDisplayWidth16x9Scene = 169;
    //this.ShapesPerPanel = 18;

    this.CompressionRatio = 1;

    this.IsSafari5 = false;
    this.IsMobile = false;
    this.IsIE9 = false;
    this.IsOldIE = false;
    this.IsChrome = false;

    this.Private_DefaultFont = "";

    this.Public_GetDefaultFont = function ()
    {
        if (this.Private_DefaultFont.length > 0)
            return this.Private_DefaultFont;

        this.Private_DefaultFont = "'Francois One'";
        try
        {
            //http://www.lingoes.net/en/translator/langcode.htm
            var language = window.navigator.userLanguage || window.navigator.language;
            if (language.indexOf("ca") !== -1 ||
                language.indexOf("da") !== -1 ||
                language.indexOf("de") !== -1 ||
                language.indexOf("en") !== -1 ||
                language.indexOf("es") !== -1 ||
                language.indexOf("fi") !== -1 ||
                language.indexOf("fr") !== -1 ||
                language.indexOf("it") !== -1 ||
                language.indexOf("nb") !== -1 ||
                language.indexOf("nl") !== -1 ||
                language.indexOf("pl") !== -1 ||
                language.indexOf("sv") !== -1 ||
                language.indexOf("se") !== -1)
            {
                this.Private_DefaultFont = "'Francois One'";
            }
            else if (language.indexOf("he") !== -1)
            {
                this.Private_DefaultFont = "'Varela Round'";
            }
           
        } catch (e)
        {
            //DebugLine("Unable to determine language " + e);
        }
        return this.Private_DefaultFont;
    };
    /**
     * Returns false if the browser doesn't support SVG,
     * or if the browser is known to have problems.
     * @returns {Boolean}
     */
    this.SupportsSvg = function ()
    {
        try
        {
            if (document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure", "1.1") === false)
            {
                return false;
            }

            var userAgent = navigator.userAgent;


            if (userAgent.indexOf("Safari/533") > 0)
            {
                return false;
            }
            if (userAgent.indexOf("Safari/531") > 0)
            {
                return false;
            }
            if (userAgent.indexOf("MSIE 8.0") > 0)
            {
                return false;
            }
            if (userAgent.indexOf("Firefox/3.6") > 0)
            {
                return false;
            }
            if (userAgent.indexOf("Mozilla/4.0") >= 0)
            {
                return false;
            }
            //UCWEB/2.0 (MIDP-2.0; U; Adr 4.2.2; id; ADVAN_S4A) U2/1.0.0 UCBrowser/10.9.0.946 U2/1.0.0 Mobile
            if (userAgent.indexOf("UCBrowser") >= 0 || userAgent.indexOf("UCWEB") >= 0 )
            {

                if (Modernizr.svg == false)
                {
                    LogErrorMessage("Supports Svg - UCBrowser - FALSE - " + userAgent);
                    return false;
                }
                else if (userAgent.indexOf("10.") || userAgent.indexOf("9."))
                {
                    LogErrorMessage("Supports Svg - UCBrowser - Manual Rejection - " + userAgent);
                    return false;
                }
                else
                {
                    LogErrorMessage("Supports Svg - UCBrowser - TRUE - " + userAgent);
                }

            }

            if (userAgent.indexOf("MSIE 9.0") > 0)
            {
                swal({ title: "", text: MyLangMap.GetTextLineBreaks("warning-upgrade-ie9"), type: "error", confirmButtonText: MyLangMap.GetText("warning-ok-button") });
            }

        }
        catch (err)
        {
            return false;
        }
        return true;
    };

    //this.UpdateShapesPerPanel = function ()
    //{
    //    var windowWidth = ($(window).width() * paddingOffset) - 100;
    //    if (windowWidth < 850)
    //        windowWidth = 850;
    //    this.ShapesPerPanel = Math.floor(windowWidth / (this.ClipartDisplayWidth + 2));
    //};

    this.EnableCompression = function ()
    {
        if (MyUserPermissions.UseCompression == false)    //don't compress US, western Europe
            return false;

        return this.SupportsWebWorkers();
    };

    this.SupportsWebWorkers = function ()
    {
        try
        {
            return Modernizr.webworkers;
        } catch (e)
        {
            return false;
        }

    };

    this.DetermineBrowserInfo = function ()
    {

        if (navigator.userAgent.indexOf("Safari/534") > 0)
            this.IsSafari5 = true;

        if (navigator.userAgent.indexOf("Chrome") > 0)
            this.IsChrome = true;

        if ($('#ieversion span').is('.ie8'))
        {
            this.IsOldIE = true;
        }
        if ($('#ieversion span').is('.ie9'))
        {
            this.IsOldIE = true;
            this.IsIE9 = true;
        }
        // IE 10 doesn't support conditional HTML injection under the argument that it (and later versions) are now standards-following browsers

        this.IsMobile = this._DetermineMobile();


        if (this.IsMobile)
        {
            $("#toggle-keyboard-controls").toggle();

            //make bigger tab rollers arrows bigger on ipad
            $("#tab-roller").css("font-size", "18px")
        }
    };

    this._DetermineMobile = function ()
    {
        if (Modernizr.touch == false)
            return false;


        var platform = navigator.platform.toLowerCase();
        if (platform.indexOf("win") >= 0 || platform.indexOf("mac") >= 0)
        {
            swal({
                title: MyLangMap.GetText("Text-Smartboard-Title"),
                text: MyLangMap.GetText("Text-Smartboard-Text"),
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: MyLangMap.GetText("Text-Smartboard-Option-Mouse"),
                cancelButtonText: MyLangMap.GetText("Text-Smartboard-Option-Touch"),
                closeOnConfirm: true,
                closeOnCancel: true
            },
                function (isConfirm)
                {
                    if (isConfirm)
                    {
                        MyBrowserProperties.SetSmartBoard(false);
                    } else
                    {
                        MyBrowserProperties.SetSmartBoard(true);
                    }
                });
            return false;
        }


        var ua = navigator.userAgent;
        if (/iPad/i.test(ua) || /iPhone/i.test(ua) || /iPod/i.test(ua) || /Android/i.test(ua))
        { // if iPad or iOS device, or Android, we're good to go
            return true;
        }

        // Otherwise, confirm, in case this is a WIndows device with both touch and mouse support...
        return window.confirm(MyLangMap.GetText("Text-Confirm-Mobile"));
    };

    this.SetSmartBoard = function (isSmartBoard)
    {
        MyBrowserProperties.IsMobile = isSmartBoard;
        $.touchyOptions.useDelegation = isSmartBoard;

        if (isSmartBoard)
        {
            $("#toggle-keyboard-controls").css("display", "");
        }
        else
        {
            $("#toggle-keyboard-controls").css("display", "none");
        }

        ValidateUILayout();
    };
}