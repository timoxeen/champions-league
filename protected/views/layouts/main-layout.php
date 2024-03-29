<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css"> 

    <?php /*
 	  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/offcanvas.css" media="screen, projection" />
    */ ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

    <!-- some more headers... -->
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <?php /*
    <!-- Custom styles for this template -->
    <link href="offcanvas.css" rel="stylesheet">
    */ ?>

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
      /*
       * Style tweaks
       * --------------------------------------------------
       */
      html,
      body {
        overflow-x: hidden; /* Prevent scroll on narrow devices */
      }
      body {
        padding-top: 70px;
      }
      footer {
        padding: 30px 0;
      }

      /*
       * Off Canvas
       * --------------------------------------------------
       */
      @media screen and (max-width: 767px) {
        .row-offcanvas {
          position: relative;
          -webkit-transition: all .25s ease-out;
             -moz-transition: all .25s ease-out;
                  transition: all .25s ease-out;
        }

        .row-offcanvas-right {
          right: 0;
        }

        .row-offcanvas-left {
          left: 0;
        }

        .row-offcanvas-right
        .sidebar-offcanvas {
          right: -50%; /* 6 columns */
        }

        .row-offcanvas-left
        .sidebar-offcanvas {
          left: -50%; /* 6 columns */
        }

        .row-offcanvas-right.active {
          right: 50%; /* 6 columns */
        }

        .row-offcanvas-left.active {
          left: 50%; /* 6 columns */
        }

        .sidebar-offcanvas {
          position: absolute;
          top: 0;
          width: 50%; /* 6 columns */
        }
      }
    </style>
  </head>

  <body>
    <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo $this->createUrl('/league'); ?>">Main</a>
        </div>

        <div class="collapse navbar-collapse">
        <?php /*
          <ul class="nav navbar-nav">
            <li class="active"><a href="<?php echo $this->createUrl('/league'); ?>">League</a></li>
            <li><a href="<?php echo $this->createUrl('/team'); ?>">Teams</a></li>
          </ul>
        */ ?>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </div><!-- /.navbar -->

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">

        <?php echo $content; ?>

      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Company 2014</p>
      </footer>

    </div><!--/.container-->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>
    	$(document).ready(function () {
		  $('[data-toggle=offcanvas]').click(function () {
		    $('.row-offcanvas').toggleClass('active')
		  });
		});
    </script>
  </body>
</html>