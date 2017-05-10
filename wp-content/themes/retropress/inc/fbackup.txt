<?php global $SMTheme;?>
  
    </div>
    </div>
</div>
<div id='content-bottom'></div>
<?php	
if ($SMTheme->get( 'social', 'showsocial')) {
	$SMTheme->block_social();
}
?>
<div id='footer'>
		<div class='container clearfix'>
		<?php if ($SMTheme->get("layout","footerwidgets")) { ?>
		<div class='footer-widgets-container'><div class='footer-widgets'>
			<div class='widgetf'>
				<?php if ( !function_exists("dynamic_sidebar") || !dynamic_sidebar("footer_1") ) : ?>
				<?php
					$SMTheme->go_func("footer_1");
				?>
				<?php endif; ?>
			</div>
			
			<div class='widgetf'>
				<?php if ( !function_exists("dynamic_sidebar") || !dynamic_sidebar("footer_2") ) : ?>
				<?php
					$SMTheme->go_func("footer_2");
				?>
				<?php endif; ?>
			</div>
			
			<div class='widgetf widgetf_last'>
				<?php if ( !function_exists("dynamic_sidebar") || !dynamic_sidebar("footer_3") ) : ?>
				<?php
					$SMTheme->go_func("footer_3");
				?>
				<?php endif; ?>
			</div>
		</div></div>
		<?php } ?>
		
		</div>
<?php wp_footer(); ?>
<div class='footer_txt'><div class='container'>
			<?php
                    if ($SMTheme->get( "layout","footertext" )) {
                        echo $SMTheme->get( "layout","footertext" );
                    } else { 
                        ?>Copyright &copy; <?php echo date("Y"); ?>  <a href="<?php echo home_url(); ?>"><?php bloginfo("name"); ?></a><?php
						echo (get_bloginfo('description'))?' - '.get_bloginfo('description'):'';
                    }
                ?> 
				<?php /* 
					All links in the tag <div class='smthemes'> are attribution of the theme developers and should remain intact. 
					It's protected by Creative Commons License (http://creativecommons.org/licenses/by/3.0/).
					Warning! Your site will not be able to work if these links are edited or deleted.
					You can buy this theme without footer links online at http://smthemes.com/buy/retropress/
				*/ ?>
				<div class='smthemes'>Designed by <a href='http://jothika-online.com/' target='_blank'>HcG injections</a>, thanks to: <a href='http://www.ghoshalshreya.com/' target='_blank'>lipotropic b12</a>, <a href='http://www.technology-and-transformation.com/' target='_blank'>http://www.technology-and-transformation.com/</a> and <a href='http://www.szpoem.net/' target='_blank'>http://www.szpoem.net/</a></div>
		</div></div>
</div>
<?php
	echo $SMTheme->get( "integration","footercode" );
?>
</div>
</body>
</html>