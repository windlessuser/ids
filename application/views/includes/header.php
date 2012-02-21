<html>  

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --> 
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <title> <?php echo $title; ?></title>
  <meta name="description" content="">
  <meta name="author" content="Marc Byfield">

  <!--  Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href=" <?php echo site_url('favicon.ico'); ?>">
  <link rel="apple-touch-icon" href="<?php echo site_url('apple-touch-icon.png'); ?>">


  <!-- CSS : implied media="all" -->
    <link href="<?php echo site_url('css/screen.css'); ?>" media="screen, projection" rel="stylesheet" type="text/css" />
  	<link href="<?php echo site_url('css/print.css'); ?>" media="print" rel="stylesheet" type="text/css" />
  <!--[if IE]>
      <link href="/css/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
  <![endif]-->

  <!-- Uncomment if you are specifically targeting less enabled mobile browsers
  <link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">  -->
 
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="js/libs/modernizr-1.6.min.js"></script>

</head>

<body>


    <header>
     <?php echo anchor(site_url('admin'),'<img src ="http://caribtechjm.com/sites/default/files/theme165_logo.png" />');
	$user = $this->session->userdata('user');
	if(strlen($user)): 
	?>
      	<user_data>
	 	<?php echo 'Welcome ' . $this->session->userdata('user') . " "; echo anchor(site_url('admin/logout'),'Logout'); ?>
		<br>
		 <?php echo'Current zone: ' .anchor(site_url('zone'), $this->session->userdata('zone')); ?>
	</user_data>
	<?php endif; ?>
    </header>
    <?php flush(); ?>
