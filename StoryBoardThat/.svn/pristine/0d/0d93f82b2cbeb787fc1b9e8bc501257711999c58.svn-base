///  <reference path="../SvgManip.js" />
///  <reference path="ColorWheel.js" />


function ColorWheels()
{

    //backwards compability for color groups we removed...
    this.SanitizeColor = function (region)
    {
        var tempRegion = region.toLowerCase();


        if (tempRegion == "paws") return "BrightColor1";
        if (tempRegion == "ears") return "BrightColor2";
        if (tempRegion == "color1") return "PrimaryColor";
        if (tempRegion == "color2") return "PrimaryColor2";
        if (tempRegion == "color3") return "PrimaryColorAccent";
        if (tempRegion == "darkcolors") return "DarkColor";
        if (tempRegion == "basiccolors") return "PrimaryColor";
        if (tempRegion == "brightcolors1") return "BrightColor1";
        if (tempRegion == "brightcolors2") return "BrightColor2";
        if (tempRegion == "brightcolors3") return "BrightColor3";
        if (tempRegion == "brightcolors4") return "BrightColor4";
        if (tempRegion == "softcolors") return "PaleColor";
        if (tempRegion == "arrows") return "PaleColor";
        if (tempRegion == "shapes") return "LightColor";
        if (tempRegion == "shapes3d") return "PaleColor";

        return region;
    }


    this.Skin = new ColorWheel("Skin", "Skin", MyColors.White, MyColors.PaleTan, MyColors.PeachyTan, MyColors.Tan, MyColors.DarkTan, MyColors.SoftBrown);
    this.Hair = new ColorWheel("Hair", "Hair", MyColors.White, MyColors.Blonde, MyColors.Orange, MyColors.Brown, MyColors.MediumGrey, MyColors.Black);
    this.Hair2 = new ColorWheel("Hair2", "Hair", MyColors.White, MyColors.Blonde, MyColors.Orange, MyColors.Brown, MyColors.MediumGrey, MyColors.Black);
    this.Eyes = new ColorWheel("Eyes", "Eyes", MyColors.White, MyColors.BlueEye, MyColors.OliveGreen, MyColors.SoftBrown, MyColors.Red, MyColors.Black);
    this.Makeup = new ColorWheel("Makeup", "Makeup", MyColors.LightBlue, MyColors.LightRed, MyColors.LightGreen, MyColors.BrightYellow, MyColors.BrightViolet, MyColors.BrightGray);

    this.Pants = new ColorWheel("Pants", "Pants", MyColors.Parchment, MyColors.SoftBrown, MyColors.BlueEye, MyColors.VeryDarkGrayBlue, MyColors.DarkGray, MyColors.Black);
    this.Shirt = new ColorWheel("Shirt", "Shirt", MyColors.White, MyColors.LightRed, MyColors.LightBlue, MyColors.LightGreen, MyColors.LightYellow, MyColors.LightGray);

    this.Shorts = new ColorWheel("Shorts", "Shorts", MyColors.White, MyColors.Red, MyColors.Blue, MyColors.Green, MyColors.Yellow, MyColors.Gray);
    this.Dress = new ColorWheel("Dress", "Dress", MyColors.White, MyColors.PaleRed, MyColors.PaleBlue, MyColors.PaleGreen, MyColors.PaleYellow, MyColors.PaleGray);

    this.Skirt = new ColorWheel("Skirt", "Skirt", MyColors.White, MyColors.BrightRed, MyColors.BrightBlue, MyColors.BrightGreen, MyColors.BrightYellow, MyColors.BrightGray);

    this.Shoes = new ColorWheel("Shoes", "Shoes", MyColors.White, MyColors.VeryDarkRed, MyColors.VeryDarkBlue, MyColors.VeryDarkGreen, MyColors.VeryDarkYellow, MyColors.Black);
    this.Tie = new ColorWheel("Tie", "Tie", MyColors.White, MyColors.VeryDarkRed, MyColors.VeryDarkBlue, MyColors.VeryDarkGreen, MyColors.VeryDarkYellow, MyColors.Black);
    this.Jacket = new ColorWheel("Jacket", "Jacket", MyColors.White, MyColors.DarkRed, MyColors.DarkBlue, MyColors.DarkGreen, MyColors.DarkYellow, MyColors.DarkGray);


    this.PrimaryColor = new ColorWheel("PrimaryColor", "Color", MyColors.White, MyColors.Red, MyColors.Blue, MyColors.Green, MyColors.Yellow, MyColors.Gray);
    this.PrimaryColor2 = new ColorWheel("PrimaryColor2", "Color 2", MyColors.White, MyColors.Red, MyColors.Blue, MyColors.Green, MyColors.Yellow, MyColors.Gray);
    this.PrimaryColor3 = new ColorWheel("PrimaryColor3", "Color 3", MyColors.White, MyColors.Red, MyColors.Blue, MyColors.Green, MyColors.Yellow, MyColors.Gray);
    this.PrimaryColor4 = new ColorWheel("PrimaryColor4", "Color 4", MyColors.White, MyColors.Red, MyColors.Blue, MyColors.Green, MyColors.Yellow, MyColors.Gray);
    this.PrimaryColor5 = new ColorWheel("PrimaryColor5", "Color 5", MyColors.White, MyColors.Red, MyColors.Blue, MyColors.Green, MyColors.Yellow, MyColors.Gray);
    this.PrimaryColor6 = new ColorWheel("PrimaryColor6", "Color 6", MyColors.White, MyColors.Red, MyColors.Blue, MyColors.Green, MyColors.Yellow, MyColors.Gray);
    this.PrimaryColor7 = new ColorWheel("PrimaryColor7", "Color 7", MyColors.White, MyColors.Red, MyColors.Blue, MyColors.Green, MyColors.Yellow, MyColors.Gray);
    this.PrimaryColor8 = new ColorWheel("PrimaryColor8", "Color 8", MyColors.White, MyColors.Red, MyColors.Blue, MyColors.Green, MyColors.Yellow, MyColors.Gray);

    this.PrimaryColorAccent = new ColorWheel("PrimaryColorAccent", "Color 2", MyColors.White, MyColors.DarkRed, MyColors.DarkBlue, MyColors.DarkGreen, MyColors.DarkYellow, MyColors.DarkGray);

    this.PrimaryColorWhiteAndBlack = new ColorWheel("PrimaryColorWhiteAndBlack", "Color", MyColors.White, MyColors.Red, MyColors.Blue, MyColors.Green, MyColors.Yellow, MyColors.Black);
    this.PrimaryColorWhiteAndBlack2 = new ColorWheel("PrimaryColorWhiteAndBlack2", "Color 2", MyColors.White, MyColors.Red, MyColors.Blue, MyColors.Green, MyColors.Yellow, MyColors.Black);
    this.PrimaryColorNoWhite = new ColorWheel("PrimaryColor", "Color", MyColors.Red, MyColors.Blue, MyColors.Green, MyColors.Yellow, MyColors.DarkViolet, MyColors.Black);

    this.DarkColor = new ColorWheel("DarkColor", "Color", MyColors.DarkGray, MyColors.DarkRed, MyColors.VeryDarkYellow, MyColors.VeryDarkGreen, MyColors.VeryDarkGrayBlue, MyColors.VeryDarkBrown);
    this.VeryDarkColor = new ColorWheel("VeryDarkColor", "Color", MyColors.VeryDarkRed, MyColors.VeryDarkBlue, MyColors.VeryDarkGreen, MyColors.VeryDarkYellow, MyColors.VeryDarkViolet, MyColors.VeryDarkOrange);

    this.BrightColor1 = new ColorWheel("BrightColor1", "Color", MyColors.BrightRed, MyColors.BrightBlue, MyColors.BrightYellow, MyColors.BrightOrange, MyColors.BrightViolet, MyColors.BrightGreen);
    this.BrightColor2 = new ColorWheel("BrightColor2", "Color 2", MyColors.BrightRed, MyColors.BrightBlue, MyColors.BrightYellow, MyColors.BrightOrange, MyColors.BrightViolet, MyColors.BrightGreen);
    this.BrightColor3 = new ColorWheel("BrightColor3", "Color 3", MyColors.BrightRed, MyColors.BrightBlue, MyColors.BrightYellow, MyColors.BrightOrange, MyColors.BrightViolet, MyColors.BrightGreen);
    this.BrightColor4 = new ColorWheel("BrightColor4", "Color 4", MyColors.BrightRed, MyColors.BrightBlue, MyColors.BrightYellow, MyColors.BrightOrange, MyColors.BrightViolet, MyColors.BrightGreen);

    this.LightColor = new ColorWheel("LightColor", "Color", MyColors.LightBlue, MyColors.LightRed, MyColors.LightGreen, MyColors.BrightYellow, MyColors.BrightViolet, MyColors.BrightGray);

    this.PaleColor = new ColorWheel("PaleColor", "Color", MyColors.PaleRed, MyColors.PaleBlue, MyColors.PaleGreen, MyColors.PaleYellow, MyColors.PaleViolet, MyColors.PaleOrange);
    this.PaleColorWithWhite = new ColorWheel("PaleColorWithWhite", "Color", MyColors.White, MyColors.PaleRed, MyColors.PaleBlue, MyColors.PaleGreen, MyColors.PaleYellow, MyColors.PaleViolet);

    this.HandColor = new ColorWheel("HandColor", "Hand", MyColors.HandBlue, MyColors.PaleTan, MyColors.PeachyTan, MyColors.Tan, MyColors.DarkTan, MyColors.SoftBrown);
    this.HandColor2 = new ColorWheel("HandColor2", "Hand 2", MyColors.HandBlue, MyColors.PaleTan, MyColors.PeachyTan, MyColors.Tan, MyColors.DarkTan, MyColors.SoftBrown);

    this.Turban = new ColorWheel("Turban", "Turban", MyColors.White, MyColors.Red, MyColors.Blue, MyColors.Green, MyColors.Yellow, MyColors.Black);

    this.Fur = new ColorWheel("Fur", "Fur", MyColors.Brown, MyColors.LightBrown, MyColors.PaleBrown, MyColors.Gray, MyColors.DarkGray, MyColors.LightRed);
    this.Fur2 = new ColorWheel("Fur2", "Fur 2", MyColors.VeryDarkBrown, MyColors.LightBrown, MyColors.PaleBrown, MyColors.Black, MyColors.LightGray, MyColors.PaleRed);

    this.Victorian = new ColorWheel("Victorian", "Color", MyColors.VeryDarkRed, MyColors.VeryDarkTeal, MyColors.DarkGrayViolet, MyColors.SoftBrown, MyColors.PaleBrown, MyColors.DarkGold);

    this.Sky = new ColorWheel("Sky", "Sky", MyColors.SkyPaleBlue, MyColors.SkyLightBlue, MyColors.SkyBlue, MyColors.SkyCloudy, MyColors.SkyNight, MyColors.SkyDarkNight);
    this.Furniture = new ColorWheel("Furniture", "Furniture", MyColors.White, MyColors.PaleBrown, MyColors.BrightBrown, MyColors.DarkBrown, MyColors.VeryDarkBrown, MyColors.Gray);
    this.Textables = new ColorWheel("Textables", "Textables", MyColors.White, MyColors.SbtPaleBlue, MyColors.PaleGrayBrown, MyColors.SbtBlue, MyColors.MutedYellow, MyColors.Parchment);
    this.CoolColor1 = new ColorWheel("CoolColor1", "Color 1", MyColors.SbtBlue, MyColors.MutedGray, MyColors.SbtPaleBlue, MyColors.SbtDarkBlue, MyColors.White, MyColors.PaleGray);
    this.CoolColor2 = new ColorWheel("CoolColor2", "Color 2", MyColors.SbtBlue, MyColors.MutedGray, MyColors.SbtPaleBlue, MyColors.SbtDarkBlue, MyColors.White, MyColors.PaleGray);
    this.CoolColor3 = new ColorWheel("CoolColor3", "Color 3", MyColors.SbtBlue, MyColors.MutedGray, MyColors.SbtPaleBlue, MyColors.SbtDarkBlue, MyColors.White, MyColors.PaleGray);
    this.CoolColor4 = new ColorWheel("CoolColor4", "Color 4", MyColors.SbtBlue, MyColors.MutedGray, MyColors.SbtPaleBlue, MyColors.SbtDarkBlue, MyColors.White, MyColors.PaleGray);

    this.Pavement = new ColorWheel("Pavement", "Pavement", MyColors.LightGray, MyColors.LightPavement, MyColors.Pavement, MyColors.DarkPavement, MyColors.VeryDarkPavement, MyColors.Black);
    this.Grass = new ColorWheel("Grass", "Grass", MyColors.White, MyColors.GrassPaleGreen, MyColors.GrassLightGreen, MyColors.GrassGreen, MyColors.GrassDarkGreen, MyColors.GrassVeryDarkGreen);

    //NOT DONE
    this.Claws = new ColorWheel("Claws", "Claws", MyColors.White, "rgb(232, 193, 132)", "rgb(210, 140, 101)", "rgb(204, 181, 158)", "rgb(188, 190, 192)", "rgb(234, 203, 198)");

    this.Clothes = new ColorWheel("Clothes", "Color", MyColors.OffWhite, MyColors.GreenKelly, MyColors.BlueBright, MyColors.RedShaded, MyColors.YellowLight, MyColors.Black);
    this.ClothesMuted = new ColorWheel("ClothesMuted", "Color", MyColors.OffWhite, MyColors.GreenArmy, MyColors.BlueGrey, MyColors.GreyMedium, MyColors.YellowLight, MyColors.BrownLight);

    this.Venitian = new ColorWheel("Venitian", "Clothing", MyColors.BlueOcean, MyColors.PurplePlum, MyColors.RedRose, MyColors.GreenLeaf, MyColors.YellowButtercup, MyColors.BrownLeather);
    this.Silhouette = new ColorWheel("Silhouette", "Silhouette", MyColors.Black, MyColors.GreySteel, MyColors.RedRust, MyColors.GreyGrey, MyColors.GreenMachine, MyColors.PurpleSil);

    this.MythicSkin = new ColorWheel("MythicSkin", "Skin", MyColors.White, MyColors.DarkGreen, MyColors.BrownLeather, MyColors.GreySteel, MyColors.LightYellow, MyColors.Red);

    this.House = new ColorWheel("House", "House", MyColors.White, MyColors.BrownGray, MyColors.BarnRed, MyColors.ButterYellow, MyColors.LightPavement, MyColors.Sand);

    this.Water = new ColorWheel("Water", "Water", MyColors.White, MyColors.LightWater, MyColors.Water, MyColors.LightBrown, MyColors.VeryDarkBrown, MyColors.Black);
    this.Metal = new ColorWheel("Metal", "Metal", MyColors.Silver, MyColors.Pewter, MyColors.GoldCoin, MyColors.MutedGold, MyColors.BrightGold, MyColors.GreenMetal);

    this.Retro1 = new ColorWheel("Retro1", "Color 1", MyColors.White, MyColors.AvocadoGreen, MyColors.SunflowerYellow, MyColors.Aqua, MyColors.PumpkinOrange, MyColors.BubblegumPink);
    this.Retro2 = new ColorWheel("Retro2", "Color 2", MyColors.White, MyColors.AvocadoGreen, MyColors.SunflowerYellow, MyColors.Aqua, MyColors.PumpkinOrange, MyColors.BubblegumPink);

    this.EarthyTones = new ColorWheel("EarthyTones", "Earthy Tones", MyColors.ButterYellow, MyColors.ArmyGreen, MyColors.Sand, MyColors.DarkTan, MyColors.VeryDarkBrown, MyColors.VeryDarkGray)
    this.Modern = new ColorWheel("Modern", "Color 1", MyColors.DesertSage, MyColors.DriedHerb, MyColors.OakBuff, MyColors.Marsala, MyColors.StormyWeather, MyColors.ClassicBlue);
    this.AlternateModern = new ColorWheel("AlternateModern", "Color 2", MyColors.BiscayBay, MyColors.ReflectingPond, MyColors.CadmiumOrange, MyColors.CashmereRose, MyColors.AmethystOrchid, MyColors.ToastedAlmond);

    //8 pallettes added 1/25/16
    this.HairDyes = new ColorWheel("HairDyes", "Color", MyColors.HotHotPink, MyColors.NeonElectricLizard, MyColors.ShockingBlue, MyColors.Wildfire, MyColors.ElectricTigerLily, MyColors.PurpleHaze, MyColors.OfficeTones);
    this.OfficeTones = new ColorWheel("OfficeTones", "Color", MyColors.Aleutian, MyColors.Alabaster, MyColors.UrbanPutty, MyColors.AquaSphere, MyColors.TempeStar, MyColors.PurplePassage);
    this.AlternateEarthyTones = new ColorWheel("AlternateEarthyTones", "Color", MyColors.BabyBrown, MyColors.MossyGlossGreen, MyColors.SailorBlue, MyColors.TitaniumGrey, MyColors.Hemetite, MyColors.DarkOakBrown);
    this.AlternateHouse = new ColorWheel("AlternateHouse", "Color", MyColors.TornadoSeason, MyColors.Yogi, MyColors.CherryCola, MyColors.Charismatic, MyColors.Camelot, MyColors.Spearmints);

    this.BrightModern = new ColorWheel("BrightModern", "Color", MyColors.RoseQuartz, MyColors.PeachEcho, MyColors.Serenity, MyColors.SnorkelBlue, MyColors.Buttercup, MyColors.CandyPink);
    this.BrightModern2 = new ColorWheel("BrightModern2", "Color", MyColors.LimpetShell, MyColors.LilacGray, MyColors.Fiesta, MyColors.IcedCoffee, MyColors.GreenFlash, MyColors.Creamsicle);
    this.Nautical = new ColorWheel("Nautical", "Color", MyColors.Aleutian, MyColors.Naval, MyColors.RenwickOlive, MyColors.CrabbyApple, MyColors.MorrisRoomGrey, MyColors.RoycroftPewter);
    this.ModernInterior = new ColorWheel("ModernInterior", "Color", MyColors.BowString, MyColors.Celadon, MyColors.Coralette, MyColors.Stratus, MyColors.IvoryKeys, MyColors.Opus);

    this.Technology = new ColorWheel("Technology", "Color", MyColors.White, MyColors.PaleGray, MyColors.Silver, MyColors.Gray, MyColors.DarkGray, MyColors.Black);

    this.Infographic1 = new ColorWheel("Infographic1", "Color", MyColors.DarkTeal, MyColors.PoppyOrange, MyColors.AquaMarine, MyColors.RetroGreen, MyColors.RetroLightGray, MyColors.RetroDarkGray);
    this.Infographic2 = new ColorWheel("Infographic2", "Color", MyColors.DarkTeal, MyColors.PoppyOrange, MyColors.AquaMarine, MyColors.RetroGreen, MyColors.RetroLightGray, MyColors.RetroDarkGray);
    this.Infographic3 = new ColorWheel("Infographic3", "Color", MyColors.DarkTeal, MyColors.PoppyOrange, MyColors.AquaMarine, MyColors.RetroGreen, MyColors.RetroLightGray, MyColors.RetroDarkGray);
    this.Infographic4 = new ColorWheel("Infographic4", "Color", MyColors.DarkTeal, MyColors.PoppyOrange, MyColors.AquaMarine, MyColors.RetroGreen, MyColors.RetroLightGray, MyColors.RetroDarkGray);
    this.Infographic5 = new ColorWheel("Infographic5", "Color", MyColors.DarkTeal, MyColors.PoppyOrange, MyColors.AquaMarine, MyColors.RetroGreen, MyColors.RetroLightGray, MyColors.RetroDarkGray);
    this.Infographic6 = new ColorWheel("Infographic6", "Color", MyColors.DarkTeal, MyColors.PoppyOrange, MyColors.AquaMarine, MyColors.RetroGreen, MyColors.RetroLightGray, MyColors.RetroDarkGray);


}