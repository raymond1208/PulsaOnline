<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pratt - Free Bootstrap 3 Theme">
    <meta name="author" content="Alvarez.is - BlackTie.co">
    <link rel="shortcut icon" href="{{ Theme::asset('img/favicon.ico') }}">

    <title>{{ Setting::meta_data('general', 'name')->value }} - {{ Setting::meta_data('general', 'tag_line')->value }}</title>

    <!-- Bootstrap core CSS -->
    {{ HTML::style(Theme::asset('css/bootstrap.min.css')) }}
    {{ HTML::style(Theme::asset('css/bootstrap-theme.min.css')) }}

    <!-- Custom styles for this template -->
    {{ HTML::style(Theme::asset('css/main.css')) }}

    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
    
    {{ HTML::script(Theme::asset('js/jquery.min.js')) }}
    {{ HTML::script(Theme::asset('js/smoothscroll.js')) }}

</head>

<body data-spy="scroll" data-offset="0" data-target="#navigation">

    <!-- Fixed navbar -->
    <div id="navigation" class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><b>Pratt</b></a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#home" class="smothscroll">Home</a></li>
        <li><a href="#desc" class="smothscroll">Description</a></li>
        <li><a href="#showcase" class="smothScroll">Showcase</a></li>
        <li><a href="#contact" class="smothScroll">Contact</a></li>
    </ul>
</div><!--/.nav-collapse -->
</div>
</div>

@yield('content')

<section id="contact" name="contact"></section>
<div id="footerwrap">
    <div class="container">
        <div class="col-lg-5">
            <h3>Address</h3>
            <p>
                Av. Greenville 987,<br/>
                New York,<br/>
                90873<br/>
                United States
            </p>
        </div>

        <div class="col-lg-7">
            <h3>Drop Us A Line</h3>
            <br>
            <form role="form" action="#" method="post" enctype="plain"> 
              <div class="form-group">
                <label for="name1">Your Name</label>
                <input type="name" name="Name" class="form-control" id="name1" placeholder="Your Name">
            </div>
            <div class="form-group">
                <label for="email1">Email address</label>
                <input type="email" name="Mail" class="form-control" id="email1" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label>Your Text</label>
                <textarea class="form-control" name="Message" rows="3"></textarea>
            </div>
            <br>
            <button type="submit" class="btn btn-large btn-success">SUBMIT</button>
        </form>
    </div>
</div>
</div>
<div id="c">
    <div class="container">
        <p>Created by <a href="http://www.blacktie.co">BLACKTIE.CO</a></p>
        
    </div>
</div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    {{ HTML::script(Theme::asset('js/bootstrap.min.js')) }}

    <script>
        $('.carousel').carousel({
          interval: 3500
      })
    </script>
</body>
</html>