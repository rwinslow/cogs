<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="The Center for Effective Global Action (CEGA) is the University of California's premiere center for research on global development. CEGA's faculty affiliates use two powerful techniques—rigorous evaluation and economic analysis—to measure the impacts of large-scale social and economic development projects.">
	<link rel="shortcut icon" href="/favicon.ico">
    <link rel="icon" type="image/png" href="/favicon.png">

	<!-- Google Web Fonts -->    
	<link href='http://fonts.googleapis.com/css?family=Merriweather:400,300' rel='stylesheet' type='text/css'>
    
	<!-- Styles -->
    <link rel="stylesheet" type="text/css" href="/styles/screen.css">

	<!--[if lt IE 7]>
    <link rel="stylesheet" type="text/css" href="/styles/ie6.css">
	<![endif]-->
    
    <!-- jQuery -->
    <script type="text/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js">
    </script>
    
    <script type="text/javascript">
	$(document).ready(function() {
		$("a[href^='http:'], a[href^='https:']").not("[href*='"+document.domain+"']").attr('target','_blank');
		$('a[href$=".pdf"], a[href$=".ppt"], a[href$=".txt"], a[href$=".rtf"]').attr('target', '_blank');
	});
    </script>
    
    <!-- Google Analytics -->
	<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-22634736-1']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	</script>
    
    <title><?php if (isset($_page_title)) echo $_page_title; ?></title>
</head>
<body>
<div id="fb-root"></div>

	<?php
	if (isset($hero) && ! empty($hero))
	{
		?>
		<div id="hero" style="background-image:url(<?php echo $hero->output_file_with_prefix('hero_', $hero->image); ?>);">
		<div id="mask">
		<?php
	}
	?>
	
	<div id="easel">
		<div id="micro-nav">
			<a id="micro-nav-listserv" target="_blank" href="http://berkeley.us2.list-manage.com/subscribe/?u=c1cf21359d4f08392a3e939c6&id=ff25dd6df8">Subscribe to E-Bulletin</a>
			<a id="micro-nav-donate" href="/donate/">Donate to CEGA</a>
		</div>

		<div id="header">
			<a id="logo" href="/">University of California Center for Effective Global Action</a>
		</div>
		
		<div id="nav">
			<ul>
				<li><a href="/about/">About</a></li>
				<li><a href="/faculty/">People</a></li>
				<li><a href="/research/">Research</a></li>
				<li><a href="/programs/">Programs</a></li>
				<li><a href="/events/">Events</a></li>
				<li><a href="/opportunities/">Opportunities</a></li>
				<li><a href="/tools/">Tools</a></li>
			</ul>
			
			<form id="site-search" action="http://www.google.com/cse">
				<input type="hidden" name="cx" value="018346605655182335427:rfcqegwgfyw">
				<input type="hidden" name="ie" value="UTF-8">
				<input type="text" id="site-search-query" name="q" placeholder="Search">
				<button type="submit" id="site-search-submit" name="sa" value="Search" ><img src="/styles/images/search_submit_icon.gif" alt="Find"></button>
				<script type="text/javascript" src="//www.google.com/cse/brand?form=cse-search-box&lang=en"></script>
			</form>
		</div>
		
		<div id="content">
			<?php include Cogs::$view; ?>
		</div>

		<div id="footer">
			<ul id="end-nav">
				<li><a href="/our-publications/">Our Publications</a></li>
				<li><a href="/news/">News</a></li>
				<li><a href="/advising/">Advising</a></li>
				<li><a target="_blank" href="http://cegablog.org/">Blog</a></li>
				<li><a target="_blank" href="http://berkeley.us2.list-manage.com/subscribe/?u=c1cf21359d4f08392a3e939c6&id=ff25dd6df8">Subscribe to E-Bulletin</a></li>
				<li><a href="/donate/">Donate to CEGA</a></li>
			</ul>
			<div id="contact-info">
				<div id="footer-copyright" class="column">
					<b>Center for Effective Global Action</b><br>
					&copy; <?php echo date('Y'); ?>
				</div>
				<div id="footer-address" class="column">
					<?php if ( ! empty($contact_info->institution)) { echo '<b>' . $contact_info->institution . '</b><br>'; } ?>
					<?php echo nl2br($contact_info->street_address); ?><br>
					<?php echo $contact_info->city; ?>, <?php echo $contact_info->state_abbreviation; ?> <?php echo $contact_info->zip_code; ?><br>
					<?php if ( ! empty($contact_info->country)) { echo $contact_info->country; } ?>
				</div>
				<div id="footer-econtact" class="column">
					<b>Email:</b> <a href="mailto:<?php echo $contact_info->email; ?>"><?php echo $contact_info->email; ?></a><br>
					<b>Phone:</b> <?php echo $contact_info->phone; ?><br>
					<b>Fax:</b> <?php echo $contact_info->fax; ?>
				</div>
				<div id="footer-social" class="column">
					<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>
					
					Like us on <a class="bold" target="_blank" href="https://www.facebook.com/CenterforEffectiveGlobalAction">Facebook</a>!
					<div class="fb-like" data-href="http://www.facebook.com/CenterforEffectiveGlobalAction" data-send="false" data-layout="button_count" data-width="420" data-show-faces="false"></div>
					<br><a class="youtube-link" target="_blank" href="http://www.youtube.com/user/CEGAVideos">View videos on</a>
				</div>
			</div>
		</div>
	</div>
	<gcse:searchbox></gcse:searchbox>

	<?php
	if (isset($hero) && ! empty($hero))
	{
		?>
		</div>
		</div>
		<?php
	}
	?>

</body>
</html>