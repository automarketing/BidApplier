var SvgSearch = function ()
{
    var _SearchTabPartsEnum =
        {
            "Title": 1,
            "Content": 2,
            "More": 3,
        };

    var SearchResultTab;
    var SearchString;
    var SearchNavBase;


    var _GetSearchTabPartId = function (searchTabBaseId, searchTabPartsEnum)
    {
        switch (searchTabPartsEnum)
        {
            case _SearchTabPartsEnum.Title:
                return "search-tab-" + searchTabBaseId + "-title";

            case _SearchTabPartsEnum.Content:
                return "search-tab-" + searchTabBaseId + "-content";

            case _SearchTabPartsEnum.More:
                return "search-tab-" + searchTabBaseId + "-more";
        }
    };

    var getSearchTabNavLink = function (searchString)
    {
        return SearchNavBase.find('li a[title=\'' + searchString + '\']');
    };

    var getSearchTabContentList = function (searchString)
    {
        //yuuck, ugly!
        var tab = getSearchTabNavLink(searchString);

        var contentId = _GetSearchTabPartId(tab.data("SearchTabBaseId"), _SearchTabPartsEnum.Content);

        return $('#' + contentId);
    };


    var _GetSearchResultsTabHtml = function (searchTabBaseId, searchTerm)
    {
        var outer = "";
        var innerChild = "";

        outer += '<li class="active">';
        outer += '   <a id="' + _GetSearchTabPartId(searchTabBaseId, _SearchTabPartsEnum.Title) + '" title="' + searchTerm + '">' + searchTerm + '</a>';
        outer += '</li>';

        innerChild += '<div id="' + _GetSearchTabPartId(searchTabBaseId, _SearchTabPartsEnum.Content) + '" class="content-list">';
        innerChild += '     <div class="waiting">' + MyLangMap.GetText("text-search-loading")+ '</div>';
        innerChild += '     <div class="search-more"><a id="' + _GetSearchTabPartId(searchTabBaseId, _SearchTabPartsEnum.More) + '">' + MyLangMap.GetText("text-search-more") + '</a></div>';
        innerChild += '</div>';

        return [outer, innerChild];
    };


    var _AddSearchTab = function (searchString)
    {
        var contentWrapper = $('#tab-search-results-content-container');
        SearchNavBase.find('li.active').removeClass('active');
        contentWrapper.find('.content-list').addClass('hidden');

        var searchTabBaseId = 's-' + SearchNavBase.find('li').length;
        var searchResultTabParts = _GetSearchResultsTabHtml(searchTabBaseId, searchString);

        SearchNavBase.append(searchResultTabParts[0]);
        contentWrapper.append(searchResultTabParts[1]);

        var titleLink = $("#" + _GetSearchTabPartId(searchTabBaseId, _SearchTabPartsEnum.Title));
        titleLink.data("SearchTabBaseId", searchTabBaseId);

        var moreSearch = $("#" + _GetSearchTabPartId(searchTabBaseId, _SearchTabPartsEnum.More));
        moreSearch.click(this.SearchMore);
        moreSearch.data("SearchString", searchString);
        moreSearch.data("Page", 1);

        //this makes the tab active - abs 2/15/16
        SearchResultTab.removeClass('hidden').find('a').trigger('click');

        TabRoller.RefreshRollers_PostChangeTab("tab-search-results-content-container");

        $(".subcategory-ul").resize(); // force a jiggle of extra content for tabdrop
        setTimeout(StoryboardContainer.JiggleSvgSize, 500); // tabdrop has a built in 100ms delay... so way 150ms...

        return $('#' + _GetSearchTabPartId(searchTabBaseId, _SearchTabPartsEnum.Content));
    };

    function ChangeTab(e)
    {
        if ($(e.target).hasClass("dropdown-toggle"))
            return;

        // Don't change the hash to #!
        e.preventDefault();

        // We use a single handler on the UL and hit-check: this is more efficient than 1 handler per link, and also allows links to be dynamically added/removed!
        var liNode = isLIHit(e.target, this);
        if (liNode == null)
        {
            return false;
        }
        var tab = $(liNode).find('a');

        // Set active status to the clicked link
        $(this).find('li').removeClass('active');
        $(liNode).addClass('active');

        
        TabRoller.RefreshRollers_PostChangeTab("tab-search-results-content-container");
        

        // Show the appropriate content list
        $('#tab-search-results-content-container .content-list').addClass('hidden');

        var contentId = _GetSearchTabPartId(tab.data("SearchTabBaseId"), _SearchTabPartsEnum.Content);

        $('#' + contentId).removeClass('hidden');
    };

    function ProcessSearchResultsList(response, container)
    {
        container.data("ItemsToDownload", response.length);

        if (response.length == 0)
        {
            if (container.find(".ClipartItemPanel").length==0)
            {
                container.append("<div class='no-results'>" + MyLangMap.GetText("text-search-no-results")+ "</div>");
            }
            else
            {
                container.append("<div class='no-results'>" + MyLangMap.GetText("text-search-no-more-results") + "</div>");
            }

            container.find('.waiting').hide();
            return;
        }

        for (var i = 0; i < response.length; i++)
        {
            if (response[i].startsWith("/search") || response[i].indexOf("storyboardsearch") > 0)
            {
                $.ajax({
                    type: 'GET',
                    url: response[i],
                    //contentType: 'application/json',
                    //dataType: 'json',
                    success: ProcessSearchResultItem_Closure(container),
                    error: function (data)
                    { 
                    }
                });
            }
            if (response[i].startsWith("swal:"))
            {
                var itemsToDownload = container.data("ItemsToDownload") - 1;
                container.data("ItemsToDownload", itemsToDownload);

                var message = response[i].substring(5);
                swal(MyLangMap.GetText("text-search-tip"), message);
            }
        }
    };

    function ProcessSearchResultItem_Closure(container)
    {
        return function (data)
        {
            var itemsToDownload = container.data("ItemsToDownload") - 1;
            container.data("ItemsToDownload", itemsToDownload);

            if (data != null  && data.svg!=null && data.svg!="")
            {
                AddSvg.AddSvgToTabs(container, MyBrowserProperties.ClipartDisplayWidth, MyBrowserProperties.ClipartDisplayHeight, data.svg, false, null);
            }

            if (itemsToDownload == 0)
            {
                //ClipartTab_ModuleRef.ForceFilter();
                container.find('.waiting').hide();
                container.find('.search-more').show();
            }
        };
    };


    function PerformSearch(e)
    {
        var searchString = SearchString.cleanupInput({ 'noquotes': true }).fixedVal();
        if (searchString === EMPTY_STRING)
            return;

        searchString = searchString.toUpperCase();

        var searchTabNavLink = getSearchTabNavLink(searchString);

        if (searchTabNavLink.length === 0)
        {
            var container = _AddSearchTab(searchString);
            container.find('.waiting').show();
            container.find('.search-more').hide();
            
            GetSearchResultList(searchString, 1,
                function (response) { ProcessSearchResultsList(response, container); },
                function (){});
        }
        else
        {
            SearchResultTab.find('a').trigger('click');
            searchTabNavLink.trigger('click');
        }

    };

    this.SearchMore = function (e)
    {
        var page = parseInt($(this).data("Page")) + 1;
        $(this).data("Page", page);

        var searchString = $(this).data("SearchString");

        var container = getSearchTabContentList(searchString);

        container.find('.waiting').show();
        container.find('.search-more').hide();

        GetSearchResultList(searchString, page,
            function (response) { ProcessSearchResultsList(response, container); },
            function () { });
    };

    function GetSearchResultList(searchString, page, onComplete, onError)
    {
        $.getJSON('/search2/searchweb?page=' + page + '&searchstring=' + searchString +  "&photosForClass=" + ExtraSetup.PhotosForClassSearchType)
            .success(onComplete)
            .error(onError);
    };

    var SvgSearchObject = new Object();

    SvgSearchObject.Load = function ()
    {
        SearchResultTab = $('#searchResultTab');
        SearchString = $('#cliplib-search-txt');
        SearchNavBase = $('#tab-search-results-tab-list');
        
        // Search Tab and form
        $('#tab-search-results-tab-list').click(ChangeTab);

        // Prevent propagation of all keys (and specifically arrows) when interacting inside the search box (otherwise, shapes on the Storyboard would move instead of the cursor in the textbox!)
        SearchString.keydown(function (e) { e.stopPropagation(); });

        // Deal with data entry inside the search field: if the user hits 'Enter', we trigger a click on the search button
        SearchString.keypress(function (e)
        {
            e.stopPropagation();
            if (e.which == 13)
            {
                if ($(this).cleanupInput({ 'noquotes': true }).fixedVal() !== EMPTY_STRING)
                {
                    $('#cliplib-search-btn').trigger('click');
                }
            }
        });

        // Handles clicks on the search button: validates the search term input and runs the search
        $('#cliplib-search-btn').click(PerformSearch);
    };

    return SvgSearchObject;

}();