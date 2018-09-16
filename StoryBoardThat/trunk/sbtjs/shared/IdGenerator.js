function IdGenerator()
{
    this.GenerateDescriptionCellId = function (row, col)
    {
        return "c_descr_R" + row + "C" + col;
    };

    this.GenerateTitleCellId = function (row, col)
    {
        return "c_title_R" + row + "C" + col;
    };

    this.GenerateCellId = function (row, col)
    {
        return "cell_R" + row + "C" + col;
    };

    this.GenerateStoryboardTitleId = function (row, col)
    {
        return "c_storyboardTitle_" + row + "_" + col;
    }

    this.GenerateAttibutionAreaId = function ()
    {
        return "c_attribution_area";
    }

    this.GenerateCellOverlayId=function(row,col, part)
    {
        return "cell-overlay-r" + row + "c" + col + "p" + part;
    }
}