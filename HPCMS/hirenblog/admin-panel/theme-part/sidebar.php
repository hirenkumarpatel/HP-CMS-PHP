 
            <div class="page-sidebar ">


                <!-- MAIN MENU - START -->
                <div class="page-sidebar-wrapper" id="main-menu-wrapper"> 

                    <!-- USER INFO - START -->
                    <div class="profile-info row">

                        <div class="profile-image col-md-4 col-sm-4 col-xs-4">
                            <a href="ui-profile.php">
                                <img src="<?php if($profilePicture!=''){echo $profilePicture;}else{echo'data/profile/user_not_found_male.png';}?>" class="img-responsive img-circle">
                            </a>
                        </div>

                        <div class="profile-details col-md-8 col-sm-8 col-xs-8">

                            <h3>
                                <a href="user-profile.php"><?php if($displayName!=''){echo $displayName;}?></a>
                               

                                <!-- Available statuses: online, idle, busy, away and offline -->
                                <span class="profile-status online"></span>
                            </h3>

                             <p class="profile-title"><?php echo $environment['blog_name'];?></p>

                        </div>

                    </div>
                    <!-- USER INFO - END -->



                    <ul class='wraplist'>	

                        <li class="open">
                            <a href="index.php">
                                <i class="fa fa-dashboard"></i>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>
                        
                        <li class="">
                            <a href="javascript:;">
                                <i class="fa fa-newspaper-o"></i>
                                <span class="title">Posts</span><span class="arrow "></span>
                            </a>
                            <ul class="sub-menu" >
                                <li>
                                    <a class="" href="post-list.php">All Posts</a>
                                </li>
                                <li>
                                    <a class="" href="post-new.php">New Post</a>
                                </li>
                                
                            </ul>
                        </li>
                       
                        <li class="">
                            <a href="media.php">
                                <i class="fa fa-bars"></i>
                                <span class="title">Media</span>
                            </a>
                            
                        </li>
                        <li class="">
                            <a href="javascript:;">
                                <i class="fa fa-file"></i>
                                <span class="title">Pages</span><span class="arrow "></span>
                            </a>
                            <ul class="sub-menu" >
                                <li>
                                    <a class="" href="page-list.php">All Pages</a>
                                </li>
                                <li>
                                    <a class="" href="page-new.php">New Page</a>
                                </li>
                                
                            </ul>
                        </li>
                        
                        
                        
                        <li class="">
                            <a href="javascript:;">
                                <i class="fa fa-desktop"></i>
                                <span class="title">Appearance</span><span class="arrow "></span>
                            </a>
                            <ul class="sub-menu" >
                                <li>
                                    <a class="" href="theme.php">Theme</a>
                                </li>
                                
                               <!--  <li>
                                    <a class="" href="">Menu</a>
                                </li>-->
                                 <li>
                                    <a class="" href="customize.php">Customize</a>
                                </li>
                                                             
                            </ul>
                        </li>
<!--                        <li class="">
                            <a href="javascript:;">
                                <i class="fa fa-user"></i>
                                <span class="title">Users</span><span class="arrow "></span>
                            </a>
                            <ul class="sub-menu" >
                                <li>
                                    <a class="" href="">All Users</a>
                                </li>
                                
                                 <li>
                                    <a class="" href="">New User</a>
                                </li>
                                                                                 
                            </ul>
                        </li>-->
                        
                        
<!--                        <li class="">
                            <a href="javascript:;">
                                <i class="fa fa-cogs"></i>
                                <span class="title">Settings</span><span class="arrow "></span>
                            </a>
                            <ul class="sub-menu" >
                                <li>
                                    <a class="" href="">Posts</a>
                                </li>
                                
                                 <li>
                                    <a class="" href="">Comments</a>
                                </li>
                                <li>
                                    <a class="" href="">Media</a>
                                </li>
                                
                                                                                 
                            </ul>
                        </li>-->
                        
                        

                    </ul>

                </div>
                <!-- MAIN MENU - END -->



                <div class="project-info">

                    <div class="block1">
                        <div class="data">
                            <span class='title'>New&nbsp;Orders</span>
                            <span class='total'>2,345</span>
                        </div>
                        <div class="graph">
                            <span class="sidebar_orders">...</span>
                        </div>
                    </div>

                    <div class="block2">
                        <div class="data">
                            <span class='title'>Visitors</span>
                            <span class='total'>345</span>
                        </div>
                        <div class="graph">
                            <span class="sidebar_visitors">...</span>
                        </div>
                    </div>

                </div>



            </div>
            