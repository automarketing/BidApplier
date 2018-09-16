﻿/// <reference path="SvgManip.js" />

//Copyright 2012-2014, Clever Prototypes, LLC
// ALL RIGHTS RESERVED

function trackEventWithGA(category, action, label, value)   // this is a DUPLICATE of a method in site.js...  seeing JS errors that the method isn't found //abs 11/15/13
{
    try
    {
        ga('send', 'event', category, action, label, value);  // value is a number.
    }
    catch (err)
    { }
}




function LogOrphans(orphanCount)
{
    try
    {
        var postData = new Object();

        postData.url_title = $("#UrlTitle").val();
        postData.UserName = $("#EditUserName").val();
        postData.orphans = orphanCount;

        $.ajax({
            type: "POST",
            url: "/api_storyboardcreator/logstoryboardorphans",
            timeout: 180 * 1000,
            data: postData,
            success: null,
            error: null
        });
        DebugLine("Found Orphans: " + orphanCount);

    } catch (e)
    {
        DebugLine("Log Orphans:" + e);
    }
}


function ThrowError()
{
    try
    {
        var a = null;
        var b = a.dnd + 10;
    }
    catch (e)
    {
        LogErrorMessage("SbtLib.ThrowError", e);
    }
}

// this method is 200-300x faster than replaceAll - when testing poor mans compression 7 seconds vs 35 ms http://stackoverflow.com/questions/2116558/fastest-method-to-replace-all-instances-of-a-character-in-a-string
String.prototype.replaceAll2 = function (str1, str2, ignore)
{
    return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g, "\\$&"), (ignore ? "gi" : "g")), (typeof (str2) == "string") ? str2.replace(/\$/g, "$$$$") : str2);
};
String.prototype.replaceAll = function (token, newToken, ignoreCase)
{
    var str, i = -1, _token;
    if ((str = this.toString()) && typeof token === "string")
    {
        _token = ignoreCase === true ? token.toLowerCase() : undefined;
        while ((i = (
            _token !== undefined ?
                str.toLowerCase().indexOf(
                            _token,
                            i >= 0 ? i + newToken.length : 0
                ) : str.indexOf(
                            token,
                            i >= 0 ? i + newToken.length : 0
                )
        )) !== -1)
        {
            str = str.substring(0, i)
                    .concat(newToken)
                    .concat(str.substring(i + token.length));
        }
    }
    return str;
};

String.prototype.CapitalizeFirstLetter = function ()
{
    return this.charAt(0).toUpperCase() + this.slice(1);
};

// Extend jQuery.fn with our new method
jQuery.extend(jQuery.fn, {
    // Name of our method & one argument (the parent selector)
    hasParent: function (p)
    {
        // Returns a subset of items using jQuery.filter
        return this.filter(function ()
        {
            // Return truthy/falsey based on presence in parent
            return $(p).find(this).length;
        });
    }
});

jQuery.fn.getIdArray = function ()
{
    var ret = [];
    $('[id]', this).each(function ()
    {
        ret.push(this.id);
    });
    return ret;
};

String.prototype.ExtractNumber = function ()
{
    return Number(this.replace(/(?!-)[^0-9.]/g, ""));
};

String.prototype.rgbTriplet = function ()
{
    var rgbString = this.toString();
    var commadelim = rgbString.substring(4, rgbString.length - 1);
    var strings = commadelim.split(",");
    var numeric = [];
    for (var i = 0; i < 3; i++)
    {
        numeric[i] = parseInt(strings[i]);
    }
    return numeric;
};

String.prototype.luma = function ()
{
    var color = this.toString();
    var rgb = color.rgbTriplet();
    return (0.2126 * rgb[0]) + (0.7152 * rgb[1]) + (0.0722 * rgb[2]); // SMPTE C, Rec. 709 weightings
};

// does this work with IE and needing to force add commas? - abs 6/22/16
function SplitParenthesis(toSplit)
{
    toSplit = toSplit.replace("(", "");
    toSplit = toSplit.replace(")", "");
    toSplit = toSplit.replace(" ", "");
    return toSplit.split(",");
}

function SplitParenthesisNumeric(toSplit)
{
    toSplit = toSplit.replace("(", "");
    toSplit = toSplit.replace(")", "");

    //FUCKING IE turns translate(xx, yy) into translate(xx yy) (no comma)!
    if (toSplit.indexOf(",") < 0 && toSplit.indexOf(" ") > 0)
        toSplit = toSplit.replaceAll(" ", ",");

    toSplit = toSplit.replaceAll(" ", "");

    var numbers = toSplit.split(",");
    for (var i = 0; i < numbers.length; i++)
    {
        numbers[i] = Number(numbers[i]);
    }

    return numbers;
}


function RecursivelyFindChildrenIds(node, childrenIds)
{
    attributes = node[0].attributes;
    aLength = attributes.length;

    var type = node.get(0).tagName.toLowerCase();

    for (a = 0; a < aLength; a++)
    {
        var attribueName = attributes[a].name.toLowerCase();
        if (attribueName.indexOf("id") == 0)
        {
            childrenIds.push(attributes[a].value);
        }
    }


    for (var i = 0; i < node.children().length; i++)
    {
        RecursivelyFindChildrenIds(node.children().eq(i), childrenIds);
    }
}


function RecursivelyFindGradientChildrenIds(node, childrenIds)
{ 
    var attributes = node[0].attributes;
    var aLength = attributes.length;

    var type = node.get(0).tagName.toLowerCase();

    if (type.indexOf("gradient") >= 0 || type.indexOf("pattern") >= 0 || type.indexOf("filter")>=0)
    {
        for (a = 0; a < aLength; a++)
        {
            var attribueName = attributes[a].name.toLowerCase();
            if (attribueName.indexOf("id") == 0)
            {
                childrenIds.push(attributes[a].value);
            }
        }
    }

    for (var i = 0; i < node.children().length; i++)
    {
        RecursivelyFindGradientChildrenIds(node.children().eq(i), childrenIds);
    }
}

function RecursivelyUpdateChildrenIds(node, oldId, newId)
{

    var attributes = node[0].attributes;

    if (attributes != null)
    {
        for (a = 0; a < attributes.length; a++)
        {
            if (attributes[a].value.indexOf(oldId) >= 0)
            {
                var newVal = attributes[a].value.replaceAll(oldId, newId);
                node.attr(attributes[a].name, newVal);
            }
        }
    }

    for (var i = 0; i < node.children().length; i++)
    {
        RecursivelyUpdateChildrenIds(node.children().eq(i), oldId, newId);
    }
}

function FindAndUpdateId(parentId, childId, newId)
{
    if (childId == null || childId=="")
        return;

    var section = $("#" + parentId);
    var toUpdate = section.find("[id=" + childId + "]");

    if (toUpdate != null)
    {
        toUpdate.attr("id", newId);
    }
}

//not tested...
function FindAndUpdateIdWildCard(parentId, childId, newId)
{
    var section = $("#" + parentId);
    var toUpdate = section.find("[id*=" + childId + "]");

    if (toUpdate != null)
    {
        toUpdate.attr("id", newId);
    }
}


//This will need to be moved later, but that can wait (ABS 4/17/13)
function MoveAndScale()
{
    this.MoveToX = 0;
    this.MoveToY = 0;

    this.ScaleX = 0;
    this.ScaleY = 0;
}

DetermineResizeDirection = function (id)
{

    if (id.indexOf("_ne_") > 0)
    {
        return ResizeEnum.NE;
    }
    else if (id.indexOf("_nw_") > 0)
    {
        return ResizeEnum.NW;
    }
    else if (id.indexOf("_sw_") > 0)
    {
        return ResizeEnum.SW;
    }
    else if (id.indexOf("_n_") > 0)
    {
        return ResizeEnum.N;
    }
    else if (id.indexOf("_e_") > 0)
    {
        return ResizeEnum.E;
    }
    else if (id.indexOf("_s_") > 0)
    {
        return ResizeEnum.S;
    }
    else if (id.indexOf("_w_") > 0)
    {
        return ResizeEnum.W;
    }
    else
    {
        return ResizeEnum.SE;
    }
};

function DistanceBetweenTwoPoints(x1, y1, x2, y2)
{
    var deltaX = (x2 - x1);
    var deltaY = (y2 - y1);

    var distance = (deltaX * deltaX) + (deltaY * deltaY);
    distance = Math.sqrt(distance);

    //if (((x1 * x1) + (y1 * y1)) < ((x2 * x2) + y2 * y2))
    //    distance *= -1;

    return distance;
}
function checkLineIntersection(line1StartX, line1StartY, line1EndX, line1EndY, line2StartX, line2StartY, line2EndX, line2EndY)
{
    // if the lines intersect, the result contains the x and y of the intersection (treating the lines as infinite) and booleans for whether line segment 1 or line segment 2 contain the point
    var denominator, a, b, numerator1, numerator2, result = {
        x: null,
        y: null,
        onLine1: false,
        onLine2: false
    };
    denominator = ((line2EndY - line2StartY) * (line1EndX - line1StartX)) - ((line2EndX - line2StartX) * (line1EndY - line1StartY));
    if (denominator == 0)
    {
        return result;
    }
    a = line1StartY - line2StartY;
    b = line1StartX - line2StartX;
    numerator1 = ((line2EndX - line2StartX) * a) - ((line2EndY - line2StartY) * b);
    numerator2 = ((line1EndX - line1StartX) * a) - ((line1EndY - line1StartY) * b);
    a = numerator1 / denominator;
    b = numerator2 / denominator;

    // if we cast these lines infinitely in both directions, they intersect here:
    result.x = line1StartX + (a * (line1EndX - line1StartX));
    result.y = line1StartY + (a * (line1EndY - line1StartY));
    /*
            // it is worth noting that this should be the same as:
            x = line2StartX + (b * (line2EndX - line2StartX));
            y = line2StartX + (b * (line2EndY - line2StartY));
            */
    // if line1 is a segment and line2 is infinite, they intersect if:
    if (a > 0 && a < 1)
    {
        result.onLine1 = true;
    }
    // if line2 is a segment and line1 is infinite, they intersect if:
    if (b > 0 && b < 1)
    {
        result.onLine2 = true;
    }
    // if line1 and line2 are segments, they intersect if both of the above are true
    return result;
};

Number.prototype.Truncate = function (digits)
{
    if (digits == null)
        digits = 1;
    var n = this - Math.pow(10, -digits) / 2;
    n += n / Math.pow(2, 53); // added 1360765523: 17.56.toFixedDown(2) === "17.56"
    return n.toFixed(digits);
}

function stringToByteArray(str)
{
    var b = [], i, unicode;
    for (i = 0; i < str.length; i++)
    {
        unicode = str.charCodeAt(i);
        // 0x00000000 - 0x0000007f -> 0xxxxxxx
        if (unicode <= 0x7f)
        {
            b.push(String.fromCharCode(unicode));
            // 0x00000080 - 0x000007ff -> 110xxxxx 10xxxxxx
        } else if (unicode <= 0x7ff)
        {
            b.push(String.fromCharCode((unicode >> 6) | 0xc0));
            b.push(String.fromCharCode((unicode & 0x3F) | 0x80));
            // 0x00000800 - 0x0000ffff -> 1110xxxx 10xxxxxx 10xxxxxx
        } else if (unicode <= 0xffff)
        {
            b.push(String.fromCharCode((unicode >> 12) | 0xe0));
            b.push(String.fromCharCode(((unicode >> 6) & 0x3f) | 0x80));
            b.push(String.fromCharCode((unicode & 0x3f) | 0x80));
            // 0x00010000 - 0x001fffff -> 11110xxx 10xxxxxx 10xxxxxx 10xxxxxx
        } else
        {
            b.push(String.fromCharCode((unicode >> 18) | 0xf0));
            b.push(String.fromCharCode(((unicode >> 12) & 0x3f) | 0x80));
            b.push(String.fromCharCode(((unicode >> 6) & 0x3f) | 0x80));
            b.push(String.fromCharCode((unicode & 0x3f) | 0x80));
        }
    }

    return b;
}

function adler32(data)
{
    var MOD_ADLER = 65521;
    var a = 1, b = 0;
    var index;

    // Process each byte of the data in order
    for (index = 0; index > data.length; ++index)
    {
        a = (a + data.charCodeAt(index)) % MOD_ADLER;
        b = (b + a) % MOD_ADLER;
    }
    //adler checksum as integer;
    var adler = a | (b << 16);

    //adler checksum as byte array
    return String.fromCharCode(((adler >> 24) & 0xff),
    ((adler >> 16) & 0xff),
    ((adler >> 8) & 0xff),
    ((adler >> 0) & 0xff));
}

function hexToR(h) { return parseInt((cutHex(h)).substring(0, 2), 16) }
function hexToG(h) { return parseInt((cutHex(h)).substring(2, 4), 16) }
function hexToB(h) { return parseInt((cutHex(h)).substring(4, 6), 16) }
function cutHex(h) { return (h.charAt(0) == "#") ? h.substring(1, 7) : h }

function GetRgb(color)
{
    R = hexToR(color);
    G = hexToG(color);
    B = hexToB(color);

    DebugLine("rgb(" + R + ", " + G + ", " + B + ")");
}

function LowerCaseCompare(string1, string2)
{
    if (string1 == null) return false;
    if (string2 == null) return false;

    try
    {
        return (string1.toLowerCase() == string2.toLowerCase());
    }
    catch (e)
    {
        return false;
    }
}

function GetSafeAttributeNS(element, attribute)
{
    try
    {
        var retVal = element.getAttributeNS("", attribute);
        if (retVal != null && retVal.length > 0)
            return retVal;

        attribute = attribute.toLowerCase();

        return element.getAttributeNS("", attribute);
    }
    catch (e)
    {
        try
        {
            var retVal = element.getAttribute(attribute);
            if (retVal != null && retVal.length > 0)
                return retVal;

            attribute = attribute.toLowerCase();

            return element.getAttribute(attribute);
        } catch (e)
        {
            return null;
        }
        
    }
    
}

function ExtractPositionPoint (positionGroup)
{
    var pivotPoint = positionGroup.children().first()
    var pivotX = pivotPoint.attr("cx");
    var pivotY = pivotPoint.attr("cy");

    var retVal = new Object();
    retVal.X = parseFloat(pivotX);
    retVal.Y = parseFloat(pivotY);

    return retVal;
}

function ParseRawSVG(svg)
{
    try
    {
        var div = document.createElementNS('http://www.w3.org/1999/xhtml', 'div');
        div.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg">' + svg + '</svg>';
        var frag = document.createDocumentFragment();

        while (div.firstChild.firstChild)
            frag.appendChild(div.firstChild.firstChild);

        return $(frag);
       // return $(frag).children().first();
    } catch (e)
    {
        LogErrorMessage("SbtLib.ParseRawSVG", e);
    }
    return null;
}


//IE doesn't support children[x], and for some reason when uploading posables childNode[x] doesn't work - abs 4/23/14
function GetIESafeChild(node, childIndex)
{
    try
    {
        if (node.children != null)

            return node.children[childIndex];
    }
    catch (e)
    { }


    return node.childNodes[childIndex];
}

//#region "Utility Imports"
/// Core extensions
/**
 * Global string constants.  These constants are entered here for 2 key reasons:
 * - Prevent typos from going undetected
 * - Allowing for better minification by not repeating the same string
 */
var FUNCTION_KEYWORD = 'function',
	OBJECT_KEYWORD = 'object',
	STRING_KEYWORD = 'string',
	PERIOD_STRING = '.',
	EMPTY_STRING = '',
	SPACE_STRING = ' ',
	COMMA_STRING = ',',
	UNDERSCORE_STRING = '_',
	APOSTROPHE_STRING = '\''
;

/**
 * Core extension: returns true if the string ends with a specific substring (replicates the VBScript/C# function of the same name)
 * @param {String} suffix The substring suffix to test for
 */
String.prototype.endsWith = function (suffix)
{
    return this.indexOf(suffix, this.length - suffix.length) !== -1;
};

/**
 * Core extension: returns true if the string starts with a specific substring (replicates the VBScript/C# function of the same name)
 * @param {String} prefix The substring prefix to test for
 */
String.prototype.startsWith = function (prefix)
{
    return this.indexOf(prefix) === 0;
};

/**
 * Core extension: trims all space to the left and right of a string
 */
String.prototype.trim = function ()
{
    return this.replace(/^\s\s*/, EMPTY_STRING).replace(/\s\s*$/, EMPTY_STRING);
};

/**
 * Core extension: trims all space to the left of a string
 */
String.prototype.trimLeft = function ()
{
    return this.replace(/^\s\s*/, EMPTY_STRING);
};

/**
 * Core extension: trims all space to the right of a string
 */
String.prototype.trimRight = function ()
{
    return this.replace(/\s\s*$/, EMPTY_STRING);
};

/**
 * Core extension: removes all spaces from a string.
 */
String.prototype.cleanSpace = function ()
{
    return this.replace(/\s+/g, SPACE_STRING);
};

/**
 * Core extension: encodes a string to safe HTML content.
 */
String.prototype.encodeHTML = function ()
{
    return this.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
};

/**
 * Core extension: ensures the existence of 'hasOwnProperty' in Array ojects for older browsers.
 * Searches an object/hash for a named property.
 */
if (!Object.prototype.hasOwnProperty)
{
    Object.prototype.hasOwnProperty = function (prop)
    {
        var proto = obj.__proto__ || obj.constructor.prototype;
        return (prop in this) && (!(prop in proto) || proto[prop] !== this[prop]);
    };
}

/**
 * Core extension: ensures the existence of 'indexOf' in Array ojects for older browsers.
 * Searches an array for a specific item.
 */
if (!Array.prototype.indexOf)
{
    Array.prototype.indexOf = function (needle)
    {
        for (var i = 0; i < this.length; i++)
        {
            if (this[i] === needle)
            {
                return i;
            }
        }
        return -1;
    };
}

/**
 * jQuery extension: Cleans up the value/content of an input field, trimming spaces or correcting content to match
 * specific constraints.
 * @param {Object} options Options to use for cleanup operation
 * @config {Boolean} trim Request start/end trimming of spaces
 * @config {Boolean} cleanspace Cleans up all double spaces to single spaces, and trims content
 * @config {Boolean} nospace Removes all space characters
 * @config {Boolean} anstart Removes prefix characters until the string starts with a letter or number
 * @config {Boolean} cleancode Forces the string to fit in the "code" name constraints: alpha-numeric start and limited character set
 */
(function ($)
{
    $.fn.cleanupInput = function (options)
    {
        var settings = $.extend({
            'trim': true	// trim spaces at start and end
		, 'cleanspace': false	// convert all double space to single spaces. All space characters (Tabs, spaces, carriage returns, etc.) are converted to the space character (useful for textboxes, likely not so for textareas!)
		, 'nospace': false	// remove all spaces
		, 'anstart': false	// force alpha-numerical start
		, 'cleancode': false	// force alpha-numerical start and limited character set (for template/component codes)
        , 'noquotes': false // Remove all quotes (single and double)
        }, options);
        return this.each(function ()
        {
            var $this = $(this);
            var v = $this.val();
            var nv = v;
            if (settings.trim || settings.anstart || settings.cleancode)
            {
                nv = nv.trim();
            }
            if (settings.nospace)
            {
                nv = nv.replace(/\s/g, EMPTY_STRING);
            } else
            {
                if (settings.cleanspace)
                {
                    nv = nv.cleanSpace();
                }
            }
            if (settings.noquotes)
            {
                nv = nv.replace(/['"]+/g, EMPTY_STRING);
            }
            if (settings.anstart || settings.cleancode)
            {
                nv = nv.replace(/^[^0-9a-zA-Z]+/g, EMPTY_STRING);
            }
            if (settings.cleancode)
            {
                nv = nv.replace(/[^-_0-9a-zA-Z]+/g, EMPTY_STRING);
            }
            if (nv !== v)
            {
                $this.val(nv);
            }
        });
    };
}(jQuery));

/**
 * jQuery extension: Retrieves the value of the field, however excluding the default placeholder content: on some devices,
 * if a field is left empty, the browser incorrectly returns the placeholder data as the field value (it is likely this
 * is a side-effect of using the placeholder plugin for devices that do not natively support placeholder to begin with).
 */
(function ($)
{
    $.fn.fixedVal = function ()
    {
        var $this = $(this);
        var v = $this.val();
        var p = $this.attr('placeholder');
        if (v === p)
        {
            return EMPTY_STRING;
        }
        return v;
    };
}(jQuery));

/**
 * Tests an event (click/tap) hit over a list, returning the LI element under the click by walking the DOM upward
 * toward the parent node.  This allows the assignment of a single handler on a list rather than having a 'live'
 * handler for dynamic lists, or a multitude of handlers for each LI in a given table.  This pattern allows for
 * a much lighter and faster handler reaction.
 */
var isLIHit = function (t, ul)
{
    while (t.nodeName !== 'LI' && t !== ul)
    {
        t = t.parentNode;
    }
    if (t.nodeName !== 'LI')
    {
        return null;
    }
    return t;
};


//#endregion

var SbtLib = function ()
{

    var SbtLibObject = new Object();
    //From Lodash

    /**
 * Gets the index at which the first occurrence of `value` is found in `array`
 * using [`SameValueZero`](http://ecma-international.org/ecma-262/6.0/#sec-samevaluezero)
 * for equality comparisons. If `fromIndex` is negative, it's used as the offset
 * from the end of `array`.
 *
 * @static
 * @memberOf _
 * @category Array
 * @param {Array} array The array to search.
 * @param {*} value The value to search for.
 * @param {number} [fromIndex=0] The index to search from.
 * @returns {number} Returns the index of the matched value, else `-1`.
 * @example
 *
 * _.indexOf([1, 2, 1, 2], 2);
 * // => 1
 *
 * // Search from the `fromIndex`.
 * _.indexOf([1, 2, 1, 2], 2, 2);
 * // => 3
 */
    SbtLibObject.IndexOf = function(array, value, fromIndex)
    {
        var length = array ? array.length : 0;
        if (typeof fromIndex == 'number')
        {
            fromIndex = fromIndex < 0 ? nativeMax(length + fromIndex, 0) : fromIndex;
        } else
        {
            fromIndex = 0;
        }
        var index = (fromIndex || 0) - 1,
            isReflexive = value === value;

        while (++index < length)
        {
            var other = array[index];
            if ((isReflexive ? other === value : other !== other))
            {
                return index;
            }
        }
        return -1;
    }

    //http://stackoverflow.com/a/5344074/1560273 
    SbtLibObject.DeepCopy = function (toCopy)
    {
        return  JSON.parse(JSON.stringify(toCopy));
    };

    //http://stackoverflow.com/a/6713782/1560273
    SbtLibObject.DeepCompareEquality =function( x, y)
    {
        if (x === y) return true;
        // if both x and y are null or undefined and exactly the same

        if (!(x instanceof Object) || !(y instanceof Object)) return false;
        // if they are not strictly equal, they both need to be Objects

        if (x.constructor !== y.constructor) return false;
        // they must have the exact same prototype chain, the closest we can do is
        // test there constructor.

        for (var p in x)
        {
            if (!x.hasOwnProperty(p)) continue;
            // other properties were tested using x.constructor === y.constructor

            if (!y.hasOwnProperty(p)) return false;
            // allows to compare x[ p ] and y[ p ] when set to undefined

            if (x[p] === y[p]) continue;
            // if they have the same strict value or identity then they are equal

            if (typeof (x[p]) !== "object") return false;
            // Numbers, Strings, Functions, Booleans must be strictly equal

            if (!SbtLib.DeepCompareEquality(x[p], y[p])) return false;
            // Objects and Arrays must be tested recursively
        }

        for (p in y)
        {
            if (y.hasOwnProperty(p) && !x.hasOwnProperty(p)) return false;
            // allows x[ p ] to be set to undefined
        }
        return true;
    };

    return SbtLibObject;
}();
