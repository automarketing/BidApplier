

//#region Logon Code
function UpdateIsLoggedOn()
{
    if (IsUserLoggedOn)
        return;

    if (document.cookie.indexOf("loggedIn=true") >= 0)
    {
        IsUserLoggedOn = true;
    }
}


function showLogonDialog()
{
    showLogonDialogBS();    // the entire code base doesn't need to know we are calling a new version... //abs 12/20/13
}


//#region Bootstrap Logon Code

function ForgotPasswordBS()
{
    var a = $("#forgot_password_username");
    var username = a.val();
    if (username.length == 0)
    {
        swal("Please enter your username or email, and we will email you a new password.");
        return;
    }
    $.post("/account/forgotpassword?username=" + username,
        function (data)
        {
            swal(data.Message);
        });
}


function HandleLogonPasswordKeyPress(e)
{
    if (e.which == 13)
    {
        HandleLogon();
    }
}

function HandleRegisterPasswordKeyPress(e)
{
    if (e.which == 13)
    {
        HandleRegister();
    }
}



function PerformLogonViaFullPage()
{
    CleanupLogonForm();
    $("#LogonForm").attr("action", "/account/handlelogon");
    $("#LogonForm").attr("method", "post");
    $("#LogonForm").submit();

}

function PerformLogonViaPopBS()
{
    CleanupLogonForm();
    $.post('/account/handlelogon', $("#LogonForm").serialize(),
    function (data)
    {
        $('#login-content').html(data);
    });
}

function CleanupLogonForm()
{
    //rename due to how razor renders double models...
    $("#LogOnModel_LogonReturnUrl").attr("name", "LogonReturnUrl");
    $("#LogOnModel_LogonIsPopup").attr("name", "LogonIsPopup");
    $("#LogOnModel_LogonPassword").attr("name", "LogonPassword");
    $("#LogOnModel_LogonUserName").attr("name", "LogonUserName");
    $("#LogOnModel_LogonRememberMe").attr("name", "LogonRememberMe");

}

function PerformRegisterViaFullPage()
{
    if (CheckTermsAndCondtions() == false)
        return;

    CleanupRegisterForm();
    $("#RegistrationForm").attr("action", "/account/handleregister");
    $("#RegistrationForm").attr("method", "post");
    $("#RegistrationForm").submit();
}

function PerformRegisterViaPopBS()
{
    if (CheckTermsAndCondtions() == false)
        return;

    CleanupRegisterForm();
    $.post('/account/handleregister', $("#RegistrationForm").serialize(),
   function (data)
   {
       $('#login-content').html(data);
   });
}

function HandleRegisterSSO(checkToc)
{

    if (checkToc)
    {
        if (CheckTermsAndCondtionsSSO() == false)
            return false  ;
    }
    return true;

}

function CheckTermsAndCondtions()
{
    if ($("#RegisterModel_AcceptsTerms").prop("checked") == false)
    {
        $("#accept-terms-warning").css("display", "block");
        $("#accept-terms-warning-div").css("background", "rgb(255, 226, 226)");
        
        return false;
    }
    return true;
}

function CheckTermsAndCondtionsSSO()
{
    if ($("#accept-terms-social").prop("checked") == false)
    {
        $("#accept-terms-warning-social").css("display", "block");
        $("#accept-terms-warning-social-div").css("background", "rgb(255, 226, 226)");
        return false;
    }
    return true;
}

function CleanupRegisterForm()
{
    $("#RegisterModel_RegisterUserName").attr("name", "RegisterUserName");
    $("#RegisterModel_RegisterEmail").attr("name", "RegisterEmail");

    $("#RegisterModel_RegisterPassword").attr("name", "RegisterPassword");
    $("#RegisterModel_RegisterConfirmPassword").attr("name", "RegisterConfirmPassword");

    $("#RegisterModel_RegisterSbtEmails").attr("name", "RegisterSbtEmails");
    $("#RegisterModel_RegisterPartnerEmails").attr("name", "RegisterPartnerEmails");

    $("#RegisterModel_RegisterReturnUrl").attr("name", "RegisterReturnUrl");

    $("#RegisterModel_AcceptsTerms").attr("name", "AcceptsTerms");
}

function UpdateIsLoggedOnButton(notLoggedInCallbackFunction)
{
    var url = "/account/isloggedon?time=" + new Date().getTime();
    jQuery.ajax({
        type: 'POST',
        url: url,
        async: false,
        cache: false,
        dataType: "json",
        error: function (data, b, c)
        {
        },
        success: function (result, resultCode)
        {
            if (result.IsLoggedOn)
            {
                IsUserLoggedOn = true;
                $('#nav-logoff-button').attr("style", "");
                $('#nav-logon-button').attr("style", "display: none");

                try
                {
                    $('#logon-pop-modal').modal('hide');
                }
                catch (e) { }
                try
                {
                    HandleLoginCloseFunction();
                }
                catch (e) { }
            }
            else
            {
                $('#nav-logoff-button').attr("style", "display: none");
                $('#nav-logon-button').attr("style", "");

                if (notLoggedInCallbackFunction != null)
                    notLoggedInCallbackFunction();
            }
        },

    });
}

function showLogonDialogBS()
{
    UpdateIsLoggedOnButton(LoadLogonPop);   // if the user is not logged in - show login pop!
}

function LoadLogonPop()
{
    $("#divLogon").children().remove();
    $('#divLogon').load("/account/logonpopbs");
}

function signOutBS()
{
    var logoffUrl = "/account/LogoffPartialBS?uid=" + (new Date).getTime();// prevent caching
    $.post(logoffUrl);

    if (SpecialSignOut != null)
    {
        window.location.href = SpecialSignOut;
    }

    $('#nav-logon-button').attr("style", "");
    $('#nav-logoff-button').attr("style", "display: none");
}

function SignInAndCloseLoginPop()
{
    UpdateIsLoggedOnButton(null, null);
}

function SsoPopupWindow(form)
{
    var ssoPopupWindow = window.open('', 'ssoPopup', 'width=600,height=600,resizeable,scrollbars');
    form.target = 'ssoPopup';
    ssoPopupWindow.onbeforeunload = function ()
    {
        //SignInAndCloseLoginPop();
    };
}

//#endregion
//#endregion

