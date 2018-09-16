var TimelineDateManager = function ()
{
    var _GetDatePart = function (cellNumber, datePart, minNumber, maxNumber, defaultValue)
    {
        try
        {
            var dateVal = $("#timeline-" + datePart + "-cell-" + cellNumber).val();
            if (dateVal == null || dateVal.length == 0)
                return defaultValue;

            var retVal = parseInt(dateVal);

            if (retVal < minNumber || retVal > maxNumber)
                return defaultValue;

            return retVal;
        }
        catch (e)
        {
            LogErrorMessage("TimelineDateManager._GetDatePart", e);
        }

        return defaultValue;
    }

    var _ToggleDisplay = function (timeUnit, display)
    {
        $("#timeline-use-" + timeUnit).prop('checked', display);

        if (display)
        {
            $(".timeline-" + timeUnit).css("display", "");
        }

        else
        {
            $(".timeline-" + timeUnit).css("display", "none");
        }

        if (display == true)
        {
            if (timeUnit == "second")
                _ToggleDisplay("minute", true);

            if (timeUnit == "minute")
                _ToggleDisplay("hour", true);

            if (timeUnit == "hour")
                _ToggleDisplay("day", true);

            if (timeUnit == "day")
                _ToggleDisplay("month", true);
        }
        if (display == false)
        {
            if (timeUnit == "month")
                _ToggleDisplay("day", false);
            if (timeUnit == "day")
                _ToggleDisplay("hour", false);

            if (timeUnit == "hour")
                _ToggleDisplay("minute", false);

            if (timeUnit == "minute")
                _ToggleDisplay("second", false);
        }
    };

    var _AddCell = function ()
    {
        if (TimelineDateManagerObject.Cols == 10)
        {
            swal({ title: "", text: MyLangMap.GetTextLineBreaks("warning-timeline-max-size"), type: "info", confirmButtonText: MyLangMap.GetText("warning-ok-button") });
            return;
        }

        $("#timeline-row-cell-" + TimelineDateManagerObject.Cols).css("display", "");

        TimelineDateManagerObject.Cols++;


    };

    var _RemoveCell = function ()
    {

        if (TimelineDateManagerObject.Cols == 3)
        {
            swal({ title: "", text: MyLangMap.GetTextLineBreaks("warning-timeline-min-size"), type: "info", confirmButtonText: MyLangMap.GetText("warning-ok-button") });
            return;
        }
        TimelineDateManagerObject.Cols--;
        $("#timeline-row-cell-" + TimelineDateManagerObject.Cols).css("display", "none");


    };

    var _InitializePopup = function ()
    {
        $("#timeline-use-month").click(function () { _ToggleDisplay("month", $("#timeline-use-month").prop("checked")) });
        $("#timeline-use-day").click(function () { _ToggleDisplay("day", $("#timeline-use-day").prop("checked")) });
        $("#timeline-use-hour").click(function () { _ToggleDisplay("hour", $("#timeline-use-hour").prop("checked")) });
        $("#timeline-use-minute").click(function () { _ToggleDisplay("minute", $("#timeline-use-minute").prop("checked")) });
        $("#timeline-use-second").click(function () { _ToggleDisplay("second", $("#timeline-use-second").prop("checked")) });

        $("#timeline-add-cell").click(_AddCell);
        $("#timeline-remove-cell").click(_RemoveCell);

        _ToggleDisplay("hour", false);
        _ToggleDisplay("minute", false);
        _ToggleDisplay("second", false);
      
    };

    var TimelineDateManagerObject = new Object();
    TimelineDateManagerObject.Cols = 0;

    TimelineDateManagerObject.GetSelectedDates = function (cols)
    {
        var dates = [];

        for (var i = 0; i < cols; i++)
        {
            var year = _GetDatePart(i, "year", -250000, 250000, 2000);
            var month = _GetDatePart(i, "month", 1, 12, 1) - 1;// month 0 is Jan.
            var day = _GetDatePart(i, "day", 1, 31, 1);
            var hour = _GetDatePart(i, "hour", 1, 12, 0);
            var minute = _GetDatePart(i, "minute", 0, 59, 0);
            var second = _GetDatePart(i, "second", 0, 59, 0);

            year = parseInt($("#timeline-year-era-cell-" + i).val()) * year;
            hour = (hour == 12 ? 0 : hour) + parseInt($("#timeline-hour-am-cell-" + i).val());

            var timelineDate = new Date(year, month, day, hour, minute, second);
            timelineDate.setFullYear(year); //dates with 2 digits get fucked up and turned to 19xx
            dates.push(timelineDate);
        }
        dates = dates.sort(function (a, b) { return a > b });

        return dates;
    };

    TimelineDateManagerObject.PreparePopup = function (dates)
    {
        TimelineDateManagerObject.Cols = StoryboardContainer.Cols;

        var hasSeconds = false;
        var hasMinutes = false;
        var hasHours = false;

        var hasDays = false;
        var hasMonths = false;

        $("[id^=timeline-row-cell-]").css("display", "");
        for (var col = StoryboardContainer.Cols; col < 10; col++)
        {
            $("#timeline-row-cell-" + col).css("display", "none");
        }

        $("#timeline-cell-count").val(StoryboardContainer.Cols);

        if (dates != null)
        {
            for (var i = 0; i < dates.length; i++)
            {
                var yearIndex = dates[i].getFullYear() > 0 ? 1 : 2;
                var hourIndex = dates[i].getHours() < 12 ? 1 : 2;
                var hours = dates[i].getHours();
                if (hours > 12)
                    hours -= 12;
                if (hours == 0)
                    hours = 12;

                $("#timeline-year-cell-" + i).val(Math.abs(dates[i].getFullYear()));
                $("#timeline-year-era-cell-" + i + " :nth-child(" + yearIndex + ")").prop('selected', true);

                $("#timeline-month-cell-" + i).val(dates[i].getMonth() + 1);
                $("#timeline-day-cell-" + i).val(dates[i].getDate());

                $("#timeline-hour-cell-" + i).val(hours);
                $("#timeline-hour-am-cell-" + i + " :nth-child(" + hourIndex + ")").prop('selected', true);

                $("#timeline-minute-cell-" + i).val(dates[i].getMinutes());
                $("#timeline-second-cell-" + i).val(dates[i].getSeconds());

                if (dates[i].getMonth() > 0)
                    hasMonths = true;
                if (dates[i].getDate() > 1)
                    hasDays = true;
                if (dates[i].getHours() > 0)
                    hasHours = true;
                if (dates[i].getMinutes() > 0)
                    hasMinutes = true;
                if (dates[i].getSeconds() > 0)
                    hasSeconds = true;
            }
        }

        _ToggleDisplay("month", hasMonths);
        _ToggleDisplay("day", hasDays);
        _ToggleDisplay("hour", hasHours);
        _ToggleDisplay("minute", hasMinutes);
        _ToggleDisplay("second", hasSeconds);
    };

    _InitializePopup()

    
   

    return TimelineDateManagerObject;

}();