var Sorters = function ()
{
    var SorterObject = new Object();

    SorterObject.SortShapeStatesByIndex = function (lhs, rhs)
    {
        try
        {
            if ($("#" + lhs.Id).index() > $("#" + rhs.Id).index())
                return 1;
            else
                return -1;
        }
        catch (e)
        {
            LogErrorMessage("Sorters.SortShapeStatesByIndex", e);
        }
    };

    //http://stackoverflow.com/questions/1129216/sort-array-of-objects-by-string-property-value-in-javascript
    SorterObject.SortShapesByVisibleX = function (lhs, rhs)
    {
        return lhs.Property_VisibleX() == rhs.Property_VisibleX() ? 0 : +(lhs.Property_VisibleX() > rhs.Property_VisibleX()) || -1;
    };

    SorterObject.SortShapesByVisibleY = function (lhs, rhs)
    {
        return lhs.Property_VisibleY() == rhs.Property_VisibleY() ? 0 : +(lhs.Property_VisibleY() > rhs.Property_VisibleY()) || -1;
    };

    return SorterObject;
}();