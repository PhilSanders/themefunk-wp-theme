
<!--sidebar-footer-->

<?php if ( is_active_sidebar( 'footer-widget-area' ) ) { ?>

    <ul class="xoxo">

        <?php dynamic_sidebar( 'footer-widget-area' ); ?>

    </ul>

<?php } else { ?>

		<ul class="xoxo">

            <li class="widget-container">

                <h3 class="widget-title">Sample Meta</h3>

                <ul>
                
                    <li>Site Admin</li>

                    <li>Log out</li>

                    <li>Entries <abbr title="Really Simple Syndication">RSS</abbr></li>

                    <li>Comments <abbr title="Really Simple Syndication">RSS</abbr></li>

                    <li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress.org</a></li>

                </ul>	

            </li>	

        </ul>				

<?php } ?>

<br class="clear" />
