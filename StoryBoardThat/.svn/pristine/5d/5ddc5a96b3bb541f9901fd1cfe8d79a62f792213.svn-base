/// <reference path="../svgManip.js" />

function Point(x, y)
{
    this.X = x || 0;
    this.Y = y || 0;
};

Point.prototype.ToString = function () {
    return this.X + "," + this.Y;
};

Point.prototype.Mult = function (value) {
    var newPoint = new Point(this.X, this.Y);
    newPoint.X *= value;
    newPoint.Y *= value;

    return newPoint;
}

// Static readonly variables.
Point.Up = Object.freeze(new Point(0, -1));
Point.Down = Object.freeze(new Point(0, 1));
Point.Left = Object.freeze(new Point(-1, 0));
Point.Right = Object.freeze(new Point(1, 0));

Point.CubicBezierCircleUnit = Object.freeze(new Number(-0.55191502449)); //http://spencermortensen.com/articles/bezier-circle/