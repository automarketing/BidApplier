<?php
if (!isset($idNameCountry))
    $idNameCountry = \App\Repository\CountryRepository::idList('country_name');
?>

<!-- Modal -->
<div class="modal fade" id="home-login-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-login-dialog">
        <div class="modal-content">
            <div class="modal-header thbg-color">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-login-title">Login</h4>
                <span class="modal-login-title-right-msg">Don't have an account?
                                                        <a href="javascript:void(0);" data-toggle="modal"
                                                           data-target="#myModal">Register here</a>
                                                </span>
            </div>
            <div class="modal-body">
                <form id="home-login-modal-form" class="kode-loginform"
                      onsubmit="SJ.USER.loginValidation(this.id);return false;">
                    <p><span>Email address</span> <input type="text" placeholder="Enter your email" name="email"/></p>
                    <p><span>Password</span> <input type="password" placeholder="Enter your password" name="password"/>
                    </p>
                    <!-- p><label><input type="checkbox"><span>Remember Me</span></label></p -->
                    <p class="kode-submit">
                        <input class="thbg-colortwo btn-home-login" type="submit" value="Login">
                    </p>
                    <p>
                                                                <span class="btn-home-forgot">
                                                                        <a href="javascript:void(0);"
                                                                           data-toggle="modal"
                                                                           data-target="#home-forgot-password-modal">Forgot Password?</a>
                                                                </span>
                    </p>
                    <div class="tagline"><span>OR</span></div>
                    <div class="col-md-6 social_but">
                        <a class="btn btn-block btn-social btn-facebook"
                           href="{{ route('social.login', ['facebook']) }}">
                            <span class="fa fa-facebook"></span> Facebook
                        </a>
                    </div>
                    <div class="col-md-6 social_but">
                        <a class="btn btn-block btn-social btn-twitter" href="{{ route('social.login', ['twitter']) }}">
                            <span class="fa fa-twitter"></span> Twitter
                        </a>
                    </div>
                    <div class="col-md-6 social_but">
                        <a class="btn btn-block btn-social btn-google" href="{{ route('social.login', ['google']) }}">
                            <span class="fa fa-google-plus"></span> Google
                        </a>
                    </div>
                    <div class="col-md-6 social_but">
                        <a class="btn btn-block btn-social btn-linkedin"
                           href="{{ route('social.login', ['linkedin']) }}">
                            <span class="fa fa-linkedin"></span> LinkedIn
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header thbg-color">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title sj-modal-title">Register</h4>
            </div>
            <div class="modal-body popNewWrpa">
               <!-- <p>About Organization and User some text to popular belief, Lorem Ipsum is not simply random text. It
                    has roots in a piece of classical
                    Latin literature from BC, </p>-->
                <div class="col-lg-6 col-md-6 orgUserBox">
                    <img src="/themes/sportsjun/images/Organization_ico.png">
                    <h1>Organization</h1>
                    <h6>We are Organization (School, College, Corporate, Association, Event management Company) and
                        wanting to create an account to manage our Sports Events Oragnization and tournament's with
                        SportsJun.com</h6>
                    <a href="#" data-toggle="modal" data-target="#myModa10" class="continueBt">Continue</a>
                </div>
                <div class="col-lg-6 col-md-6 orgUserBox">
                    <img src="/themes/sportsjun/images/user_iocn.png">
                    <h1>User</h1>
                    <h6>I am a Player, Coach, Umpire, Parent, Follower and would like to maintain my Sports, Coach,
                        Umpire profile and find my schedule and as well follow events of great<br> talent on
                        SportsJun.com</h6>
                    <a href="#" data-toggle="modal" data-target="#user" class="continueBt orgC">Continue</a>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModa10" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header thbg-color">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title sj-modal-title">Register Organization</h4>
            </div>
            <div class="modal-body popNewWrpa">
                <div class="col-lg-12 orgUserBox naBorder">
                    <img src="/themes/sportsjun/images/Organization_ico.png">
                    <h1>Organization</h1>
                    <!--<h6></h6>-->
                    <div class="registerWrap">
                        <form method="POST" action="/auth/register-organization"  class="kode-loginform"
                              enctype="multipart/form-data"
                              onsubmit="SJ.USER.ajaxSubmitModalRegister(this);return false;"
                        >
                            {{csrf_field()}}
                            <h3>Organization Name</h3>
                            <input name="org_name" class="regPop" placeHolder="Organization Name" type="text">
                            <h3>Organization Type</h3>
                            {!! Form::select('org_type',config('constants.ENUM.ORGANIZATION.ORGANIZATION_TYPE'),null,['class'=>'regPop','placeholder'=>'Organization Type']) !!}

                            <h3>Subdomain</h3>
                            <div>
                                <span class="reg-subdomain">http://</span><input name="subdomain" class="reg-subdomain" placeholder="" type="text"/><span class="reg-subdomain">.{{ config('app.domain') }}</span>
                            </div>

                            <h3>Organization Logo</h3>
                            <input name="org_logo" class="regPop" type="file">
                            <h3>About</h3>
                            <textarea name="org_about" class="regPop" rows="4"></textarea>
                            <!-- -->
                            <h3>First Name</h3>
                            <input name="name" class="regPop" placeHolder="First Name" type="text">
                            <h3>Last Name</h3>
                            <input name="lastname" class="regPop" placeHolder="Last Name" type="text">
                            <h3>Email</h3>
                            <input name="email" class="regPop" placeHolder="Email" type="text">
                            <h3>Password</h3>
                            <input name="password" class="regPop" placeHolder="Password" type="password">
                            <h3>Retype Password</h3>
                            <input name="password_confirmation" class="regPop" placeHolder="Password" type="password">

                            <h3>Address</h3>
                            <input name="address" class="regPop" placeHolder="Address" type="text">

                            <h3>Country</h3>
                            {!! Form::select('country_id',$idNameCountry,null,['class'=>'regPop','onChange'=>'ajaxLoadOption(this)',
                            'data-url'=>route('data.states'),'data-target'=>"#reg_state_id",'data-name'=>'state','placeholder'=>'Select country']) !!}
                            <h3>State</h3>
                            <select id="reg_state_id" name="state_id" class="regPop" onchange="ajaxLoadOption(this);"
                                    data-url="{{route('data.cities')}}" data-target="#reg_city_id" data-name="city"></select>
                            <h3>City</h3>
                            <select id="reg_city_id" name="city_id" class="regPop"></select>
                            <input name="password_confirmation" class="regPop" placeHolder="Password" type="text">
                            <span class="capcha"> {!!Captcha::img('flat')!!}</span> <a href="javascript:void(0)"
                                                                                       onclick="SJ.USER.refreshCaptcha('home-register-modal-form');"
                                                                                       class="captcha-refresh"><img
                                        src="{{ asset('/images/refresh.png') }}"
                                        alt="Refresh Captcha Image"/></a><br/>
                            <input type="text" name="captcha" class="captcha-input regPop"
                                   placeholder="Enter the above captcha">
                            <div class="form-group">
                                <label class="">I agree to the
                                    <a href="/terms-and-conditions.html" target="_blank">terms and conditions</a> of
                                    this site
                                </label>
                                <input name="terms_accept" type="checkbox">
                            </div>

                            <input type="submit" class="continueBt" value="Sign up"/>
                        </form>
                    </div>

                    <div class="clear"></div>


                </div>

                <div class="clear"></div>

            </div>
        </div>
    </div>


</div>

<!----user-profile---->
<div class="modal fade" id="user" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header thbg-color">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title sj-modal-title">Register User</h4>
            </div>
            <div class="modal-body popNewWrpa">

                <div class="col-lg-12 orgUserBox naBorder">

                    <img src="/themes/sportsjun/images/user_iocn.png" width="129" height="92">
                    <h1>User</h1>
                    <!--<h6></h6>-->
                    <div class="registerWrap">
                        <div class="col-md-6 social_but">
                            <a class="btn btn-block btn-social btn-facebook" href="{{ route('social.login', ['facebook']) }}">
                                <span class="fa fa-facebook"></span> Facebook
                            </a>
                        </div>
                        <div class="col-md-6 social_but">
                            <a class="btn btn-block btn-social btn-twitter" href="{{ route('social.login', ['twitter']) }}">
                                <span class="fa fa-twitter"></span> Twitter
                            </a>
                        </div>
                        <div class="col-md-6 social_but">
                            <a class="btn btn-block btn-social btn-google" href="{{ route('social.login', ['google']) }}">
                                <span class="fa fa-google-plus"></span> Google
                            </a>
                        </div>
                        <div class="col-md-6 social_but">
                            <a class="btn btn-block btn-social btn-linkedin" href="{{ route('social.login', ['linkedin']) }}">
                                <span class="fa fa-linkedin"></span> LinkedIn
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="tagline" style="margin:40px auto 20px auto;width:95%;"><span>OR</span></div>
                        <form id="home-register-modal-form" class="kode-loginform" method="POST" action="/auth/register"
                              enctype="multipart/form-data"
                              onsubmit="SJ.USER.ajaxSubmitModalRegister(this);return false;">
                            {{csrf_field()}}
                            <h3>First Name</h3>
                            <input name="firstname" class="regPop" placeHolder="First Name" type="text">
                            <h3>Last Name</h3>
                            <input name="lastname" class="regPop" placeHolder="Last Name" type="text">
                            <h3>Email</h3>
                            <input name="email" class="regPop" placeHolder="Email" type="text">
                            <h3>Password</h3>
                            <input name="password" class="regPop" placeHolder="Password" type="text">
                            <h3>Retype Password</h3>
                            <input name="password_confirmation" class="regPop" placeHolder="Password" type="text">
                            <span class="capcha"> {!!Captcha::img('flat')!!}</span> <a href="javascript:void(0)"
                                                                                       onclick="SJ.USER.refreshCaptcha('home-register-modal-form');"
                                                                                       class="captcha-refresh"><img
                                        src="{{ asset('/images/refresh.png') }}"
                                        alt="Refresh Captcha Image"/></a><br/>
                            <input type="text" name="captcha" class="captcha-input regPop"
                                   placeholder="Enter the above captcha">

                            <div class="form-group"><h3><input name="tos" type="checkbox"
                                                               checked="checked">I agree to the <a
                                            href="{{ url('/terms-and-conditions.html') }}" target="_blank">terms and
                                        conditions</a> of this site.</h3></div>

                            <div class="form-group"><h3><input name="newsletter" type="checkbox"
                                                               checked="checked"> I wish to receive the weekly bulletin
                                </h3>
                            </div>
                            <input class="continueBt" type="submit" value="Sign Up"></p>
                        </form>
                    </div>

                    <div class="clear"></div>


                </div>

                <div class="clear"></div>

            </div>
        </div>
    </div>


</div>


<!-- Modal -->
<div class="modal fade" id="home-forgot-password-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header thbg-color">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title sj-modal-title">Lost Your Password</h4>
            </div>
            <div class="modal-body">
                <form id="home-forgot-password-modal-form" class="kode-loginform"
                      onsubmit="SJ.USER.forgotPasswordValidation(this.id);return false;">
                    <p><span>Email address</span> <input type="text" placeholder="Enter your email" name="email"/></p>
                    <p class="kode-submit">
                        <input class="thbg-colortwo" type="submit" value="Submit">
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<!-- Modal -->
<div class="modal fade" id="home-email-verify-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header thbg-color">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title  sj-modal-title">Thank you!</h4>
            </div>
            <div class="modal-body verify-msg">
                The activation link has been sent to your email <span id="verify-email-id"></span><br/>
                Please check your email and click on the link to activate your account.<br/>
                <a class="kode-modren-btn thbg-colortwo" href="javascript:void(0);" data-toggle="modal"
                   data-target="#home-login-modal">Login</a>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<div class="modal fade" id="pricing_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header thbg-color">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title sj-modal-title">Contact Us</h4>
            </div>
            <div class="modal-body">
                <p><strong>All sports event organizers (School's, Colleges, corporate's, Organizations, Individual
                        Organizers)</strong></p>
                <p>Contact us now for pricing your sports events (tournaments/leagues)</p>
                <p><span class="contact-email"><a href="mailto:contact@sportsjun.com"><strong>contact@sportsjun
                                .com</strong></a></span></p>
            </div>
        </div>
    </div>
</div>