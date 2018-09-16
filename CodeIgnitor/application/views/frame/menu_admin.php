      <aside id="leftsidebar" class="sidebar">
	        <!--  admin title  -->
			<div class="sidebar-title">KAWNAIN<sup>TM</sup></div>
            <!-- User Info -->
            <div class="user-info" style="padding-left: 10px;">
                <div class="image" style="float:left;">
                    <img src="<?php echo base_url(); ?>includes/AdminBSB/images/user.png" alt="User" />
                </div>
				<div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#ffffff;position:absolute;top:84%;font-weight:bold;">John Doe</div>
                <div class="info-container" style="float:left;">
                    <div class="email" style="color:#bfd5d9;">john.doe@example.com</div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="position:absolute;margin-top:-28px;left:0;color:#bfd5d9;">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="<?php echo site_url('admin/login/logout'); ?>"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <?php
                $menuSelect = $this->session->userdata("menuSelect");
                if(empty($menuSelect)){
                    $menuSelect = "dashboard/index";
                }
            ?>
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li<?php if(!strcmp($menuSelect, "dashboard/index")){ ?> class="active"<?php } ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">home</i><span>Dashboard</span>
                        </a>
                        <ul class="ml-menu">
                            <li<?php if(!strcmp($menuSelect, "dashboard/index")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/dashboard/index'); ?>" >
                                    <span>Dashboard</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li<?php if(!strcmp($menuSelect, "subscriber/index") || !strcmp($menuSelect, "subscriber/mobile") || !strcmp($menuSelect, "subscriber/website")){ ?> class="active"<?php } ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">people</i><span>Subscriber</span>
                        </a>
                        <ul class="ml-menu">
                            <li<?php if(!strcmp($menuSelect, "subscriber/index")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/subscriber/index'); ?>">TV Box</a>
                            </li>
                            <li<?php if(!strcmp($menuSelect, "subscriber/mobile")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/subscriber/mobile'); ?>">Mobile</a>
                            </li>
                            <li<?php if(!strcmp($menuSelect, "subscriber/website")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/subscriber/website'); ?>">Website</a>
                            </li>
                        </ul>
                    </li>
                    <li<?php if(!strcmp($menuSelect, "payment/tvbox_payment") || !strcmp($menuSelect, "payment/mobile_payment") || !strcmp($menuSelect, "payment/website_payment") || !strcmp($menuSelect, "payment/payment_history") || !strcmp($menuSelect, "payment/suspend")){ ?> class="active"<?php } ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">payment</i><span>Payment</span>
                        </a>
                        <ul class="ml-menu">
                            <li<?php if(!strcmp($menuSelect, "payment/tvbox_payment")){ ?> class="active"<?php } ?>>
                              <a href="<?php echo site_url('admin/payment/tvbox_payment'); ?>">TV Box</a>
                            </li>
                            <li<?php if(!strcmp($menuSelect, "payment/mobile_payment")){ ?> class="active"<?php } ?>>
                              <a href="<?php echo site_url('admin/payment/mobile_payment'); ?>">Mobile</a>
                            </li>
                            <li<?php if(!strcmp($menuSelect, "payment/website_payment")){ ?> class="active"<?php } ?>>
                              <a href="<?php echo site_url('admin/payment/website_payment'); ?>">Website</a>
                            </li>
                            <li<?php if(!strcmp($menuSelect, "payment/payment_history")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/payment/payment_history'); ?>">History</a>
                            </li>
                            <li<?php if(!strcmp($menuSelect, "payment/suspend")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/payment/suspend'); ?>">Suspend</a>
                            </li>
                        </ul>
                    </li>
                    <li<?php if(!strcmp($menuSelect, "ticket/open") || !strcmp($menuSelect, "ticket/active") || !strcmp($menuSelect, "ticket/closed") || !strcmp($menuSelect, "ticket/ticket_questions")){ ?> class="active"<?php } ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">style</i><span>Ticket</span>
                        </a>
                        <ul class="ml-menu">
                            <li<?php if(!strcmp($menuSelect, "ticket/open")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/ticket/open'); ?>">Open</a>
                            </li>
                            <li<?php if(!strcmp($menuSelect, "ticket/active")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/ticket/active'); ?>">Active</a>
                            </li>
                            <li<?php if(!strcmp($menuSelect, "ticket/closed")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/ticket/closed'); ?>">Closed</a>
                            </li>
                            <li<?php if(!strcmp($menuSelect, "ticket/ticket_questions")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/ticket/ticket_questions'); ?>">Ticket Questions</a>
                            </li>
                        </ul>
                    </li>
                    <li<?php if(!strcmp($menuSelect, "channelvod/country") || !strcmp($menuSelect, "channelvod/category") || !strcmp($menuSelect, "channelvod/company") || !strcmp($menuSelect, "channelvod/language") || !strcmp($menuSelect, "channelvod/channel")){ ?> class="active"<?php } ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">video_library</i><span>Channel</span>
                        </a>
                        <ul class="ml-menu">
                            <li<?php if(!strcmp($menuSelect, "channelvod/country")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/channelvod/country'); ?>">Country</a>
                            </li>
                            <li<?php if(!strcmp($menuSelect, "channelvod/category")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/channelvod/category'); ?>">Category</a>
                            </li>
                            <li<?php if(!strcmp($menuSelect, "channelvod/company")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/channelvod/company'); ?>">Company</a>
                            </li>
                            <li<?php if(!strcmp($menuSelect, "channelvod/language")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/channelvod/language'); ?>">Language</a>
                            </li>
                            <li<?php if(!strcmp($menuSelect, "channelvod/channel")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/channelvod/channel'); ?>">Live Channel</a>
                            </li>
                        </ul>
                    </li>
                    <li<?php if(!strcmp($menuSelect, "channelvod/platformcategory") || !strcmp($menuSelect, "channelvod/platformvod")){ ?> class="active"<?php } ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">refresh</i><span>VOD</span>
                        </a>
                        <ul class="ml-menu">
                            <li<?php if(!strcmp($menuSelect, "channelvod/platformcategory")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/channelvod/platformcategory'); ?>">Category</a>
                            </li>
                            <li<?php if(!strcmp($menuSelect, "channelvod/platformvod")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/channelvod/platformvod'); ?>">VOD</a>
                            </li>
                        </ul>
                    </li>
                    <li<?php if(!strcmp($menuSelect, "masjid/video_list")){ ?> class="active"<?php } ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">videocam</i><span>Masjid Video</span>
                        </a>
                        <ul class="ml-menu">
                            <li<?php if(!strcmp($menuSelect, "masjid/video_list")){ ?> class="active"<?php } ?>>
                                <a href="<?php echo site_url('admin/masjid/video_list'); ?>">Video List</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">assignment</i><span>Front Page Organization</span>
                        </a>
                        <ul class="ml-menu">
                          <li<?php if(!strcmp($menuSelect, "frontpage")){ ?> class="active"<?php } ?>>
                              <a href="<?php echo site_url('admin/frontpage'); ?>">Frontpage</a>
                          </li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!-- #Menu -->
        </aside>
