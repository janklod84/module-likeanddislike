<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
</head>
<body>
	   <nav class="navbar navbar-inverse navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="/">Like / Dislike</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
				         <li><a href="?p=index&user=1">User 1</a></li>
                 <li><a href="?p=index&user=2"">User 2</a></li>
                 <li><a href="?p=index&user=3"">User 3</a></li>
				         <?php if(isset($_SESSION['user_id'])): ?>
                  <li><a href="?p=logout">Se Deconnecter</a></li>
                 <?php endif; ?>
              </ul>
            </div>
          </div>
        </nav>
 
  	  <div class="container" style="padding:30px;">

          <?= $content; ?>
          
          <!-- debug -->
          <div class="clearfix"></div>
          <h1>Session</h1>
          <?php debug($_SESSION); ?>

      </div><!-- end container -->

    <!-- Module important a include avec JS -->
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

  <script src="/assets/js/app.js"></script>
</body>
</html>

