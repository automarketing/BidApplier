var TabRoller = function ()
{
    var TabRollerObject = new Object();

    var TabRollerStateEnum =
        {
            Up: 1,
            Normal: 2,
            Down: 3
        };

    var Props = new Object();
    Props.TabRollerState = TabRollerStateEnum.Normal;
    Props.ContentPanelHeight = 0;
    Props.ActiveTabId = null;

    TabRollerObject.Up = function ()
    {
        if (Props.TabRollerState == TabRollerStateEnum.Down)
            RollTabs_Normal();
        else
            RollTabs_Up();
    };

    TabRollerObject.Normal = function ()
    {
        RollTabs_Normal();
    };

    TabRollerObject.Down = function ()
    {
        if (Props.TabRollerState == TabRollerStateEnum.Up)
            RollTabs_Normal();
        else
            RollTabs_Down();
    };


    TabRollerObject.RefreshRollers_PostResize = function ()
    {
        switch (Props.TabRollerState)
        {
            case TabRollerStateEnum.Up:
                {
                    RollTabs_Up();
                    return;
                }
            case TabRollerStateEnum.Normal:
                {
                    RollTabs_Normal();
                    return;
                }
            case TabRollerStateEnum.Down:
                {
                    RollTabs_Down();
                    return;
                }
        }
    };


    TabRollerObject.RefreshRollers_PostChangeTab = function (activeTabId)
    {
        Props.ActiveTabId = activeTabId;
        switch (Props.TabRollerState)
        {
            case TabRollerStateEnum.Up:
            case TabRollerStateEnum.Normal:
                {
                    RollTabs_Normal();
                    return;
                }
            case TabRollerStateEnum.Down:
                {
                    RollTabs_Down();
                    return;
                }
        }
    };

    TabRollerObject.RefreshRollers_PostAdd = function ()
    {
        if (Props.TabRollerState != TabRollerStateEnum.Down)
            return;

        var currentContentPanelHeight = $("#" + Props.ActiveTabId).height();
        if (currentContentPanelHeight != Props.ContentPanelHeight)
            TabRoller.Down();
    };



    function RollTabs_Up()
    {
        Props.TabRollerState = TabRollerStateEnum.Up;

        $(".content-wrapper").css("display", "none");

        UpdateTabs();
    };

    function RollTabs_Normal()
    {
        Props.TabRollerState = TabRollerStateEnum.Normal;

        $(".content-wrapper").css("display", "block");
        $(".content-wrapper").css("white-space", "nowrap");
        $(".content-wrapper").css("max-height", "none");

        $(".content-wrapper").css("overflow-x", "scroll");
        $(".content-wrapper").css("overflow-y", "auto");

        UpdateTabs();
    };

    function RollTabs_Down()
    {
        Props.TabRollerState = TabRollerStateEnum.Down;

        Props.ContentPanelHeight = $("#" + Props.ActiveTabId).height();

        svgContainerHeight = parseInt(MyPointers.SvgContainer.css("height"))
        svgHeight = parseInt(MyPointers.CoreSvg.css("height"));


        //var minExpandHeight = 225;
        var expandHeight = Math.max(Props.ContentPanelHeight + svgContainerHeight - svgHeight - 50, 225);

        $(".content-wrapper").css("display", "block");
        $(".content-wrapper").css("white-space", "normal");
        $(".content-wrapper").css("max-height", expandHeight + "px");

        $(".content-wrapper").css("overflow-x", "auto");
        $(".content-wrapper").css("overflow-y", "scroll");

        Props.ContentPanelHeight = $("#" + Props.ActiveTabId).height();

        UpdateTabs();
    };

    function UpdateTabs()
    {
        StoryboardContainer.JiggleSvgSize();
        StoryboardContainer.SetCoreSvgDimensions();
        PositionTabRoller();
    };

    function PositionTabRoller()
    {

        if (Props.ActiveTabId == null)
        {
            //FUCK THIS IS UGLY!  really need to re-write all the crazy seb code to avoid shit like this! ABS 1/26/17
            if ($(".content-wrapper").length > 0)
                Props.ActiveTabId = $(".content-wrapper").first().attr("id");
        }

        var tabRoller = $("#tab-roller");
        var topNavDiv = $("#top-nav-div");

        tabRoller.css("top", topNavDiv.height());
        tabRoller.css("display", "block");
    };

    //PositionTabRoller();
    return TabRollerObject;
} ();