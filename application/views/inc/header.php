<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Waggle">
    <meta name="author" content="Runwei Qiang">

    <title>Waggle</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet">
    <style type="text/css">
        body {padding-top: 70px; }
    </style>

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>

<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
<div class="container">
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="#">Waggle</a>
</div>
<div class="navbar-collapse collapse">
<ul class="nav navbar-nav">
<li><a href="<?= site_url('competition/index') ?>">Competition</a></li>
</ul>
<ul class="nav navbar-nav navbar-right">
<?php if($this->session->userdata('sid')): ?>
<li><a href="#"><?= $this->session->userdata('sid') ?></a></li>
<li><a href="<?= site_url('user/logout') ?>">Logout</a></li>
<?php else: ?>
<li><a href="<?= site_url('user/login') ?>">Login</a></li>
<li><a href="<?= site_url('user/signup') ?>">Signup</a></li>
<?php endif; ?>
</ul>
</div><!--/.nav-collapse -->
</div>
</div>

<div class="container">      
<?php if(isset($flash_message)): ?>
<div class="row">
<div class="col-md-12">
<div class="alert alert-info">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<?= $flash_message ?>
</div>
</div>
</div>
<?php endif; ?>
