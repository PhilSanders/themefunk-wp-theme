<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="no-js ie6" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7 ]><html class="no-js ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8 ]><html class="no-js ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title(' | ', true, 'right'); echo " - " . get_bloginfo('description'); ?></title>
<link rel="icon" href="favicon-16.png?v=1.5" sizes="16x16"> 
<link rel="icon" href="favicon-32.png?v=1.5" sizes="32x32"> 
<link rel="icon" href="favicon-48.png?v=1.5" sizes="48x48">
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

    <div class="off-canvas-wrap" data-offcanvas>

        <div class="inner-wrap">

            <nav class="tab-bar show-for-small">
              <section class="right-small"> <a class="right-off-canvas-toggle menu-icon" href="#"><span></span></a> </section>
            </nav>

            <aside class="right-off-canvas-menu show-for-small">
              <label>Navigation</label>
            <?php

                $is_nav = '' ;
                $defaults = array(
                    'theme_location'  => 'top',
                    'menu'            => '',
                    'container'       => false,
                    'container_class' => '',
                    'container_id'    => '',
                    'menu_class'      => '',
                    'menu_id'         => 'off-canvas-nav',
                    'echo'            => false,
                    'fallback_cb'     => '',
                    'before'          => '',
                    'after'           => '',
                    'link_before'     => '',
                    'link_after'      => '',
                    'items_wrap'      => '<ul class="off-canvas-list">%3$s</ul>',
                    'depth'           => 0,
                    'walker'          => ''
                );

                $is_nav = wp_nav_menu( $defaults );
                if ($is_nav == '') {
                    netfunktheme_default_navigation();
                 } else {
                    echo ($is_nav);
                }
            ?>

            </aside>

            <section class="main-section">
                <div id="wrapper" class="hfeed">

                <header class="contain-to-grid fixed">
                  <div class="row">
                    <div class="small-12 columns clearfix">
                    <nav class="top-bar" data-topbar role="navigation">
                      <ul class="title-area">
                        <li class="logo-icon">
                          <?php
                            $header_image = get_header_image();
                            if ( !empty( $header_image ) ) { ?>
                                <div id="logo" class="left"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <img src="<?php header_image(); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
                                </a></div>
                            <?php
                            } else { ?>
                                <div id="logo2"><a href="<?php echo esc_url(home_url()); ?>"><?php bloginfo( 'name' ); ?></a></div><!--logo end-->
                            <?php } ?>
                        </li>
                        <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
                        <!--li class="toggle-topbar menu-icon">
                          <a href="#"><span></span></a>
                        </li-->
                      </ul>

                      <section class="top-bar-section hide-for-small">
                        <!-- right nav section -->
                        <?php do_action('netfunktheme_navigation_menu'); ?>
                        <!-- left vav section -->
                        <?php do_action ('netfunktheme_user_menu') ?>
                      </section>
                    </nav>
                    </div>

                  </div><!-- top-bar -->
                </header>
