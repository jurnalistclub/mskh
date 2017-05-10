<?php
	global $SMTheme;
	if ( isset($_POST['ajaxpage'])&&$_POST['ajaxpage']=='1' ) {
		ob_start();
		get_template_part('theloop');
		get_template_part('navigation');
		$return['content']=ob_get_contents();
		ob_end_clean();
		header('Content-type: application/json');
		echo json_encode($return);
		die();
	}
	$SMTheme->get_layout();

echo '<!DOCTYPE html>'."\r\n";
?>
<html <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( false ); ?></title>	
	<?php	$SMTheme->seo(); ?>

	<?php
		
		if(
			(is_archive()&&is_day()&&$SMTheme->get( 'seo', 'day' ))||
			(is_archive()&&is_month()&&$SMTheme->get( 'seo', 'month' ))||
			(is_archive()&&is_year()&&$SMTheme->get( 'seo', 'year' ))||
			(is_category()&&$SMTheme->get( 'seo', 'category' ))||
			(is_tag()&&$SMTheme->get( 'seo', 'tag' ))||
			(is_author()&&$SMTheme->get( 'seo', 'author' ))||
			(is_search()&&$SMTheme->get( 'seo', 'search' ))
		) {
			?><meta name="robots" content="noindex" /><?php
		}
		
	?>

	<?php if ( is_singular() ) { wp_enqueue_script( 'comment-reply' ); } ?>
	
	<?php  wp_head(); ?>
	
	<style type="text/css">
		<?php echo $SMTheme->get( 'integration','css' )?>
	</style>
	<?php
		echo $SMTheme->get( 'integration','headcode' );
	?>
	<script type="text/javascript">
		jQuery(document).ready(function() {

			<?php
				$SMTheme->block_slider_config();
			?>
			jQuery(".menus .children").addClass('sub-menu');
			
			<?php
				$SMTheme->block_menu_config("menus");
			?>
			jQuery('textarea[name="comment"]').each(function(){
				jQuery(this).attr('name','<?php echo $_SESSION['commentinput']; ?>');
			});
			jQuery('.feedback input').each(function(){
				jQuery(this).attr('name','<?php echo $_SESSION['commentinput']; ?>['+jQuery(this).attr('name')+']');
			});
			jQuery('.feedback textarea').each(function(){
				jQuery(this).attr('name','<?php echo $_SESSION['commentinput']; ?>['+jQuery(this).attr('name')+']');
			});
		});
	</script>
</head>
<body <?php 
	$class=$SMTheme->block_slider_css();
	$class.=' '.$SMTheme->sidebars_type;
	body_class( $class ); 
	?> layout='<?php echo $SMTheme->layout; ?>'>
<div id='scrollUp'><img src='<?php echo get_template_directory_uri().'/images/smt/arrow-up.png';?>' alt='Up' title='Scroll window up' /></div>
<div id='header'>
	<div class='container clearfix'>
		
		
		<div id='secondarymenu-container'>
			<div id="logo">
				<?php $SMTheme->block_logo();?>
			</div>
			
			<div class="menusearch" title="">
				<?php get_search_form(); ?>
			</div>
			
			<div id='menu-box'>
			<div id='secondarymenu'>
				<?php wp_nav_menu('depth=0&theme_location=sec-menu&container_class=menu-topmenu-container&menu_class=menus menu-topmenu&fallback_cb=block_sec_menu');	?>
			</div>
			</div>
			
		</div>
		
		
		<?php smt_mobile_menu('sec-menu'); ?>
		<?php smt_mobile_menu('main-menu'); ?>
		
		<div id='mainmenu-container'>
			<div id='mainmenu'>
				<?php $nav_menu_params=array(
					'depth'=>0,
					'theme_location'=>'main-menu',
					'menu_class'=>'menus menu-primary',
					'fallback_cb'=>'block_main_menu'
				);
				wp_nav_menu($nav_menu_params); ?>
			</div>
		</div>
			<?php
			if ((is_front_page()&&$SMTheme->get( 'slider', 'homepage'))||(!is_front_page()&&$SMTheme->get( 'slider', 'innerpage'))) {?>
				<div class='slider-container'>
					<?php $SMTheme->block_slider();	?>
				</div><?php
			}?>
		
		
		
		
	</div>
</div>
<marquee scrollamount="10" style="font-family: Arial;color: #6666FF;width: 70%;margin-left: 15%;"><font face="Arial Unicode" color="#FFFFFF" size="2"><b style="
    font-size: 30px;
    color: #c05749;
">Բարի գալուստ<font face="Arial Unicode" color="#333333" size="2" style="
    color: #41689d;
    font-size: 30px;
"> Լրագրողների ակումբ<br><font face="Arial Unicode" color="#333333" size="2" style="
    color: #bc5445;
    font-size: 20px;
    margin-left: 8%;
">«Մխիթար Սեբաստացի» կրթահամալիր</font></font></b></font></marquee>
<div id='content-top' class='container'></div>
<div id='content'>
	<div class='container clearfix'>
		<?php get_sidebar(); ?> 
		<div id="main_content">