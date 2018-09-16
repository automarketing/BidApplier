function ImageAttribution(attribution)
{
    this.HasAttribution = false;
    this.Title = "";
    this.Author = "";
    this.ImageUrl = "";
    this.License = "";
    this.PhotoId = "";

    if ( attribution == undefined || attribution == null || attribution.length == 0)
        return;

    this.HasAttribution = true;

    this.Title = attribution.getAttribute("title");
    this.Author = attribution.getAttribute("author");
    this.ImageUrl = attribution.getAttribute("imageurl");
    this.License = attribution.getAttribute("license");
    this.PhotoId = attribution.getAttribute("photoid");
 
}