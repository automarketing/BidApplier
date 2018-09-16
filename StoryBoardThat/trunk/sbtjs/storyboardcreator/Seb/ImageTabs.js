﻿/**
 * Backs clicpart library retrieval
 */


function UglyUploadCallback(data)
{
    if (data == null || data.length == 0)
        return;

    SvgRetriever.uploadCallback(data);
}


var _prevent_menu_double_select_mask = 0;

var ClipartTab_ModuleRef = (function ()
{
    var my = {};

    var TabContent;
    var UploadTab;
    var UploadTabContent;

    var FilterWrapper;
    


    var addCategoryTab2 = function (parentCategory, active)
    {
        //var tabId = data[0]
        //, children = data[3]
        //;
        if (parentCategory == null || parentCategory.ImageSubCategories == null)
            return;

        var parentTabId = "parent-category-" + parentCategory.ImageCategoryId;
        var parentTabHrefId = "parent-category-a-" + parentCategory.ImageCategoryId;
        var parentTab = "";
        parentTab += '<li id=\"' + parentTabId + '\" ' + (parentCategory.HideOnLoad ? ' style=display:none' : '') + (active ? ' class="active"' : '') + '>';
        //parentTab += '  <a href="#cliplib-' + parentCategory.ImageCategoryId + '" data-toggle="tab" class="tab-link content-tab" title="' + parentCategory.HoverText + '">' + parentCategory.Title + '</a>';
        parentTab += '  <a id=\"' + parentTabHrefId + '\" href="#cliplib-' + parentCategory.ImageCategoryId + '" data-toggle="tab" class="tab-link content-tab" title="' + parentCategory.HoverText + '">' + parentCategory.Title + '</a>';
        parentTab += '</li>';

        UploadTab.before(parentTab);

        var subcategoryNavBar = "";
        subcategoryNavBar += '<div class="cliplib-pane tab-pane' + (active ? ' in active' : '') + '" id="cliplib-' + parentCategory.ImageCategoryId + '">'
        subcategoryNavBar += '  <nav class="navbar navbar-default subcategories" style="box-shadow:none" role="navigation">';
        subcategoryNavBar += '      <div class="navbar-content">';
        subcategoryNavBar += '          <ul class="nav navbar-nav nav-sm subcategory-ul">';

        var tabContent1 = [subcategoryNavBar];
        var contentWrapperId = "content-wrapper-" + parentCategory.ImageCategoryId;
        var tabContent2 = ['<div class="content-wrapper" id=\"' + contentWrapperId + '\">'];


        for (var i = 0; i < parentCategory.ImageSubCategories.length; i++)
        {
            var tabs = getSubTabCode2(parentCategory.ImageSubCategories[i], i === 0);
            tabContent1.push(tabs[0]);
            tabContent2.push(tabs[1]);
        }
        tabContent1.push('</ul></div></nav>');
        tabContent2.push('</div></div>');
        UploadTabContent.before(tabContent1.join('') + tabContent2.join(''));

        $("#" + parentTabHrefId).click(HandleParentCategoryClick);
    };

    var HandleParentCategoryClick = function (e)
    {
        e.preventDefault();

        // Show the tab (this will hide the other tabs)
        $(this).tab('show');

        // Go click whatever sub-category is visible by default (in general this will be the first one, or the last one we saw within the tab). If the content hasn't been loaded yet, the click will trigger this load, otherwise, it'll simply do nothing.
        if ($(this).hasClass('content-tab'))
        {
            $($(this).attr('href') + ' nav ul.nav li.active a').trigger('click');
        }

        $(".subcategory-ul").resize(); // force a jiggle of extra content for tabdrop
        setTimeout(TabRoller.RefreshRollers_PostResize, 500); // tabdrop has a built in 100ms delay... so way 150ms...
    }


    var getSubTabCode2 = function (category, active, isSearch)
    {
        var outer = "";
        var innerChild = "";

        outer += '<li ' + (active ? ' class="active"' : '') + ' id=\"category-' + category.ImageCategoryId + '\">';
        outer += '     <a href="javascript:void(0)" class="cliplib-' + category.ImageCategoryId + '" title="' + category.HoverText + '">' + category.Title + '</a>'
        outer += '</li>';


        innerChild += '<div id="cliplib-' + category.ImageCategoryId + '-content" class="content-list' + (active ? '' : ' hidden') + '">';
        innerChild += '     <div class="waiting">Loading...</div>'

        if (isSearch)
            innerChild += '     <div class="search-more"><a href="javascript:void(0)" class="1">More...</a></div>';

        innerChild += '</div>';

        return [outer, innerChild];
    };




    // Use this to filter images in selector
    //my.ForceFilter = function (parentNode)
    //{
    //    var filter = FilterWrapper[0].className;
    //    if (parentNode == null)
    //    {
    //        parentNode = TabContent;
    //    }
    //    parentNode.find('svg.ClipartLibrary g svg').css('filter', (filter === 'color') ? '' : 'url(#' + filter + ')');
    //};


    /**
     * Initializes the tab. Called as part of document.ready
     */
    my.load = function ()
    {
        TabContent = $('#myTabContent');

        UploadTab = $('#uploadTab');
        UploadTabContent = $('#cliplib-upload');



        FilterWrapper = $('#clipart-filter-wrapper');


        var i;
        //for (i = 1; i < clipartLibraryCategoryMap.length; i++)
        //{
        //    addCategoryTab(clipartLibraryCategoryMap[i], i === 1);
        //}

        for (i = 0; i < allCategories.length; i++)
        {
            addCategoryTab2(allCategories[i], i === 0);
        }

        // Do not allow filters for Safari5 as those can corrupt the document!
        if (MyBrowserProperties.IsSafari5 || MyBrowserProperties.IsOldIE)
        {
            // Hide the filter drop-down in the clipart tabs
            $('#clipart-filter-wrapper').hide();

            // Strip any filter declarations (for instance, on new boards)
            StoryboardContainer.RemoveFilters();
        }
        else
        {
            // Build filter list from dynamic declaration
            var list = $(SVGFilterDeclaration.replace(/inkscape\:/gi, EMPTY_STRING));
            var filters = [];
            list.children('filter').each(function (index, ui)
            {
                var $item = $(ui);
                var id = $item.attr('id');
                var label = $item.attr('label');
                var tooltip = $item.attr('menu-tooltip');
                var enabled = !($item.attr('disabled') === 'disabled');

                if (label === "divider")
                {
                    filters.push("<li role=\"separator\" id=\"divider-" + id + "\" class=\"divider\"></li>")
                    enabled = false;
                }

                if (enabled === false)
                    return;



                var lookupKey = label;
                label = MyLangMap.GetText("text-filter-label-" + lookupKey);
                tooltip = MyLangMap.GetText("text-filter-tooltip-" + lookupKey);

                var filter = "";
                filter += "<li>";
                filter += '<a href="javascript: void (0)" class="' + id + '" title="' + tooltip + '">';
                filter += '<span class="MenuFilter MenuFilter' + id + '" title="' + label + '">';
                filter += '<img height="16" width="16" src="/content/menu/blank.gif" class="' + id + '">';
                filter += '</span> ' + label + '</a>';
                filter += "</li>";

                filters.push(filter);

                //filters.push(');

            });

            FilterWrapper.find('ul.dropdown-menu').append(filters.join(''));
            $(' #filters-multi-select, #filters-single-select').append(filters.join(''));

            // Manages the color filter dropdown
            //FilterWrapper.find('ul.dropdown-menu').click(function (e)
            //{
            //    // Don't change the hash to #!
            //    e.preventDefault();

            //    // We use a single handler on the UL and hit-check: this is more efficient than 1 handler per link, and also allows links to be dynamically added/removed!
            //    var liNode = isLIHit(e.target, this);
            //    if (liNode == null)
            //    {
            //        return false;
            //    }
            //    var $_aItem = $(liNode).find('a');

            //    // Change the label of the dropdown to match the selection
            //    FilterWrapper.find('button.btn.btn-label').html($_aItem.html() + ' <span class="caret"></span>');

            //    // Add active class to selected item
            //    FilterWrapper.find('ul.dropdown-menu li').removeClass('active');
            //    $_aItem.parent().addClass('active');

            //    // Tag drop down wrapper with the filter as a class name
            //    FilterWrapper[0].className = $_aItem[0].className;

            //    // Apply the filter to all library items
            //  //  ClipartTab_ModuleRef.ForceFilter();

            //});

            // Manages the color filter dropdown
            $('#filters-multi-select, #filters-single-select').click(function (e)
            {  
                if( _prevent_menu_double_select_mask == 1 )
                {
                    _prevent_menu_double_select_mask = 0;
                    return;
                }

                // Don't change the hash to #!
                e.preventDefault();

                // We use a single handler on the UL and hit-check: this is more efficient than 1 handler per link, and also allows links to be dynamically added/removed!
                var liNode = isLIHit(e.target, this);
                if (liNode == null)
                {
                    return false;
                }
                var selectedFilter = $(liNode).find('a');

              
                FilterColorMode((selectedFilter[0].className === 'color') ? EMPTY_STRING : 'url(#' + selectedFilter[0].className + ')');

            });

            $(".remove-colors").click(function(e)
            {
                _prevent_menu_double_select_mask = 1;
                 e.preventDefault();
                 WhiteOutShape();
            });

            $(".artpen-colors").click(function(e)
            {
                _prevent_menu_double_select_mask = 1;
                 e.preventDefault();
                 ArtpenShape();
            });

            $(".black-out").click(function(e)
            {
                _prevent_menu_double_select_mask = 1;
                 e.preventDefault();
                 BlackOutShape();
            });
        }


        // Load the first category
        SvgRetriever.getClipartContent(allCategories[0].ImageSubCategories[0].ImageCategoryId, null, null);

        // And then allow the scroll indicator to be visible (on mobile) - note: we do not use "show", but instead, simply remove the element's display attribute, so classes on the item kick in place.
        $('#myTabContent .scroll-indicator').css('display', '');



        // Handles clicks on sub-category links
        $('#myTabContent .cliplib-pane nav.navbar ul.nav').click(function (e)
        {
            // this means it is our drop down of extra options
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
            var $_aItem = $(liNode).find('a');

            // Change content list
            var targetContentList = '#' + $_aItem[0].className + '-content';
            $(this).parents('div.cliplib-pane').find('.content-wrapper div.content-list').addClass('hidden');
            $(targetContentList).removeClass('hidden');

            // Change nav item active status
            $(this).find('li').removeClass('active');
            $(liNode).addClass('active');

            activeTabId = $(targetContentList).parent().attr("id")
            TabRoller.RefreshRollers_PostChangeTab(activeTabId);

            // And load content...
            var $_targetContentList = $_aItem[0].className.replace('cliplib-', '');
            SvgRetriever.getClipartContent($_targetContentList, null, null);
        });






        $("#upload-btn").click(function (e)
        {
            SvgRetriever.initiateUpload(null, null);
        });

    };

    return my;
} ());
