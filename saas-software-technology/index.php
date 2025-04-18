<?php
/**
 * The template for displaying home page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package SAAS Software Technology
 */
get_header(); ?>

<main id="main" role="main" class="theme-main-box pt-5">
	<div class="container">
        <?php
        $saas_software_technology_left_right = get_theme_mod( 'saas_software_technology_theme_options','Right Sidebar');
        if($saas_software_technology_left_right == 'Left Sidebar'){ ?>
            <div class="row">
                <div class="col-lg-4 col-md-4"><?php get_sidebar(); ?></div>
                <div class="col-lg-8 col-md-8">
                    <?php if( get_theme_mod( 'saas_software_technology_navigation_hide',true) != '') { ?>
                        <?php if( get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'top' || get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'both')  { ?>
                            <div class="navigation my-3">
                                <?php saas_software_technology_post_navigation();?>
                                <div class="clearfix"></div>
                            </div>
                        <?php }?>
                    <?php }?>
                    <?php if ( have_posts() ) :
                        /* Start the Loop */
                      
                        while ( have_posts() ) : the_post();

                            get_template_part( 'template-parts/content' ); 
                      
                        endwhile;
                        wp_reset_postdata();
                        else :

                            get_template_part( 'no-results' ); 

                        endif; 
                    ?>
                    <?php if( get_theme_mod( 'saas_software_technology_navigation_hide',true) != '') { ?>
                        <?php if( get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'bottom' || get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'both')  { ?>
                            <div class="navigation my-3">
                                <?php saas_software_technology_post_navigation();?>
                                <div class="clearfix"></div>
                            </div>
                        <?php }?>
                    <?php }?>
                </div>
            </div>
            <div class="clearfix"></div>
        <?php }else if($saas_software_technology_left_right == 'Right Sidebar'){ ?>
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <?php if( get_theme_mod( 'saas_software_technology_navigation_hide',true) != '') { ?>
                        <?php if( get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'top' || get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'both')  { ?>
                            <div class="navigation my-3">
                                <?php saas_software_technology_post_navigation();?>
                                <div class="clearfix"></div>
                            </div>
                        <?php }?>
                    <?php }?>
                    <?php if ( have_posts() ) :
                        /* Start the Loop */
                          
                        while ( have_posts() ) : the_post();

                            get_template_part( 'template-parts/content'); 
                          
                        endwhile;
                        wp_reset_postdata();
                        else :

                            get_template_part( 'no-results' ); 

                        endif; 
                    ?>
                    <?php if( get_theme_mod( 'saas_software_technology_navigation_hide',true) != '') { ?>
                        <?php if( get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'bottom' || get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'both')  { ?>
                            <div class="navigation my-3">
                                <?php saas_software_technology_post_navigation();?>
                                <div class="clearfix"></div>
                            </div>
                        <?php }?>
                    <?php }?>
                </div>
                <div class="col-lg-4 col-md-4"><?php get_sidebar(); ?></div>
            </div>
        <?php }else if($saas_software_technology_left_right == 'One Column'){ ?>
            <?php if( get_theme_mod( 'saas_software_technology_navigation_hide',true) != '') { ?>
                <?php if( get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'top' || get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'both')  { ?>
                    <div class="navigation my-3">
                        <?php saas_software_technology_post_navigation();?>
                        <div class="clearfix"></div>
                    </div>
                <?php }?>
            <?php }?>
            <?php if ( have_posts() ) :
                /* Start the Loop */
                  
                while ( have_posts() ) : the_post();

                    get_template_part( 'template-parts/content'); 
                  
                endwhile;
                wp_reset_postdata();
                else :

                    get_template_part( 'no-results' ); 

                endif; 
            ?>
          <?php if( get_theme_mod( 'saas_software_technology_navigation_hide',true) != '') { ?>
                <?php if( get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'bottom' || get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'both')  { ?>
                    <div class="navigation my-3">
                        <?php saas_software_technology_post_navigation();?>
                        <div class="clearfix"></div>
                    </div>
                <?php }?>
            <?php }?>
        <?php }else if($saas_software_technology_left_right == 'Three Columns'){ ?>
            <div class="row">
                <div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar( 'sidebar-1' ); ?></div>
                <div class="col-lg-6 col-md-6">
                    <?php if( get_theme_mod( 'saas_software_technology_navigation_hide',true) != '') { ?>
                        <?php if( get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'top' || get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'both')  { ?>
                            <div class="navigation my-3">
                                <?php saas_software_technology_post_navigation();?>
                                <div class="clearfix"></div>
                            </div>
                        <?php }?>
                    <?php }?>
                    <?php if ( have_posts() ) :
                        /* Start the Loop */
                          
                        while ( have_posts() ) : the_post();

                            get_template_part( 'template-parts/content'); 
                          
                        endwhile;
                        wp_reset_postdata();
                        else :

                            get_template_part( 'no-results' ); 

                        endif; 
                    ?>
                    <?php if( get_theme_mod( 'saas_software_technology_navigation_hide',true) != '') { ?>
                        <?php if( get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'bottom' || get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'both')  { ?>
                            <div class="navigation my-3">
                                <?php saas_software_technology_post_navigation();?>
                                <div class="clearfix"></div>
                            </div>
                        <?php }?>
                    <?php }?>
                </div>
                <div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar( 'sidebar-2' ); ?></div>
            </div>
        <?php }else if($saas_software_technology_left_right == 'Four Columns'){ ?>
            <div class="row">
                <div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar( 'sidebar-1' ); ?></div>
                <div class="col-lg-3 col-md-3">
                    <?php if( get_theme_mod( 'saas_software_technology_navigation_hide',true) != '') { ?>
                        <?php if( get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'top' || get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'both')  { ?>
                            <div class="navigation my-3">
                                <?php saas_software_technology_post_navigation();?>
                                <div class="clearfix"></div>
                            </div>
                        <?php }?>
                    <?php }?>
                    <?php if ( have_posts() ) :
                        /* Start the Loop */
                          
                        while ( have_posts() ) : the_post();

                            get_template_part( 'template-parts/content'); 
                          
                        endwhile;
                        wp_reset_postdata();
                        else :

                            get_template_part( 'no-results' ); 

                        endif; 
                    ?>
                    <?php if( get_theme_mod( 'saas_software_technology_navigation_hide',true) != '') { ?>
                        <?php if( get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'bottom' || get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'both')  { ?>
                            <div class="navigation my-3">
                                <?php saas_software_technology_post_navigation();?>
                                <div class="clearfix"></div>
                            </div>
                        <?php }?>
                    <?php }?>
                </div>
                <div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar( 'sidebar-2' ); ?></div>
                <div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar( 'sidebar-3' ); ?></div>
            </div>
        <?php }else if($saas_software_technology_left_right == 'Grid Layout'){ ?>
            <div class="row">
                <?php if( get_theme_mod( 'saas_software_technology_navigation_hide',true) != '') { ?>
                    <?php if( get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'top' || get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'both')  { ?>
                        <div class="navigation my-3">
                            <?php saas_software_technology_post_navigation();?>
                            <div class="clearfix"></div>
                        </div>
                    <?php }?>
                <?php }?>
                <?php if ( have_posts() ) :
                    /* Start the Loop */
                      
                    while ( have_posts() ) : the_post();

                        get_template_part( 'template-parts/grid-layout' ); 
                      
                    endwhile;
                    wp_reset_postdata();
                    else :

                        get_template_part( 'no-results' ); 

                    endif; 
                ?> 
                <?php if( get_theme_mod( 'saas_software_technology_navigation_hide',true) != '') { ?>
                    <?php if( get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'bottom' || get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'both')  { ?>
                        <div class="navigation my-3">
                            <?php saas_software_technology_post_navigation();?>
                            <div class="clearfix"></div>
                        </div>
                    <?php }?>
                <?php }?>
            </div >
        <?php }else {?>
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <?php if( get_theme_mod( 'saas_software_technology_navigation_hide',true) != '') { ?>
                        <?php if( get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'top' || get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'both')  { ?>
                            <div class="navigation my-3">
                                <?php saas_software_technology_post_navigation();?>
                                <div class="clearfix"></div>
                            </div>
                        <?php }?>
                    <?php }?>
                    <?php if ( have_posts() ) :
                        /* Start the Loop */
                          
                        while ( have_posts() ) : the_post();

                            get_template_part( 'template-parts/content'); 
                          
                        endwhile;
                        wp_reset_postdata();
                        else :

                            get_template_part( 'no-results' ); 

                        endif; 
                    ?>
                    <?php if( get_theme_mod( 'saas_software_technology_navigation_hide',true) != '') { ?>
                        <?php if( get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'bottom' || get_theme_mod( 'saas_software_technology_post_navigation_position','bottom') == 'both')  { ?>
                            <div class="navigation my-3">
                                <?php saas_software_technology_post_navigation();?>
                                <div class="clearfix"></div>
                            </div>
                        <?php }?>
                    <?php }?>
                </div>
                <div class="col-lg-4 col-md-4"><?php get_sidebar(); ?></div>
            </div>
        <?php } ?>
    </div>
</main>

<?php get_footer(); ?>