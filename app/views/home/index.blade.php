@extends('layouts/default')

@section('content')

<section id="home" name="home"></section>
	<div id="headerwrap">
	    <div class="container">
	    	<div class="row centered">
	    		<div class="col-lg-12">
					<h1>Welcome To <b>{{ Setting::meta_data('general', 'name')->value }}</b></h1>
					<h3>Show your product with this handsome theme.</h3>
					<br>
	    		</div>
	    		
	    		<div class="col-lg-2">
	    			<h5>Amazing Results</h5>
	    			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	    			<img class="hidden-xs hidden-sm hidden-md" src="{{ Theme::asset('img/arrow1.png') }}">
	    		</div>
	    		<div class="col-lg-8">
	    			<img class="img-responsive" src="{{ Theme::asset('img/app-bg.png') }}" alt="">
	    		</div>
	    		<div class="col-lg-2">
	    			<br>
	    			<img class="hidden-xs hidden-sm hidden-md" src="{{ Theme::asset('img/arrow2.png') }}">
	    			<h5>Awesome Design</h5>
	    			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
	    		</div>
	    	</div>
	    </div> <!--/ .container -->
	</div><!--/ #headerwrap -->


	<section id="desc" name="desc"></section>
	<!-- INTRO WRAP -->
	<div id="intro">
		<div class="container">
			<div class="row centered">
				<h1>Designed To Excel</h1>
				<br>
				<br>
				<div class="col-lg-4">
					<img src="{{ Theme::asset('img/intro01.png') }}" alt="">
					<h3>Community</h3>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
				</div>
				<div class="col-lg-4">
					<img src="{{ Theme::asset('img/intro02.png') }}" alt="">
					<h3>Schedule</h3>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
				</div>
				<div class="col-lg-4">
					<img src="{{ Theme::asset('img/intro03.png') }}" alt="">
					<h3>Monitoring</h3>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
				</div>
			</div>
			<br>
			<hr>
	    </div> <!--/ .container -->
	</div><!--/ #introwrap -->
	
	<!-- FEATURES WRAP -->
	<div id="features">
		<div class="container">
			<div class="row">
				<h1 class="centered">What's New?</h1>
				<br>
				<br>
				<div class="col-lg-6 centered">
					<img class="centered" src="{{ Theme::asset('img/mobile.png') }}" alt="">
				</div>
				
				<div class="col-lg-6">
					<h3>Some Features</h3>
					<br>
				<!-- ACCORDION -->
		            <div class="accordion ac" id="accordion2">
		                <div class="accordion-group">
		                    <div class="accordion-heading">
		                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
		                        First Class Design
		                        </a>
		                    </div><!-- /accordion-heading -->
		                    <div id="collapseOne" class="accordion-body collapse in">
		                        <div class="accordion-inner">
								Great Framework
								</div><!-- /accordion-inner -->
		                    </div><!-- /collapse -->
		                </div><!-- /accordion-group -->
		                <br>
		
		                <div class="accordion-group">
		                    <div class="accordion-heading">
		                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
		                        Retina Ready Theme
		                        </a>
		                    </div>
		                    <div id="collapseTwo" class="accordion-body collapse">
		                        <div class="accordion-inner">
								<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
								</div><!-- /accordion-inner -->
		                    </div><!-- /collapse -->
		                </div><!-- /accordion-group -->
		                <br>
		
		                 <div class="accordion-group">
		                    <div class="accordion-heading">
		                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
		                        Awesome Support
		                        </a>
		                    </div>
		                    <div id="collapseThree" class="accordion-body collapse">
		                        <div class="accordion-inner">
								<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
								</div><!-- /accordion-inner -->
		                    </div><!-- /collapse -->
		                </div><!-- /accordion-group -->
		                <br>
		                
		                 <div class="accordion-group">
		                    <div class="accordion-heading">
		                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
		                        Responsive Design
		                        </a>
		                    </div>
		                    <div id="collapseFour" class="accordion-body collapse">
		                        <div class="accordion-inner">
								<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
								</div><!-- /accordion-inner -->
		                    </div><!-- /collapse -->
		                </div><!-- /accordion-group -->
		                <br>			
					</div><!-- Accordion -->
				</div>
			</div>
		</div><!--/ .container -->
	</div><!--/ #features -->
	
	
	<section id="showcase" name="showcase"></section>
	<div id="showcase">
		<div class="container">
			<div class="row">
				<h1 class="centered">Some Screenshots</h1>
				<br>
				<div class="col-lg-8 col-lg-offset-2">
					<div id="carousel-example-generic" class="carousel slide">
					  <!-- Indicators -->
					  <ol class="carousel-indicators">
					    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
					    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
					  </ol>
					
					  <!-- Wrapper for slides -->
					  <div class="carousel-inner">
					    <div class="item active">
					      <img src="{{ Theme::asset('img/item-01.png') }}" alt="">
					    </div>
					    <div class="item">
					      <img src="{{ Theme::asset('img/item-02.png') }}" alt="">
					    </div>
					  </div>
					</div>
				</div>
			</div>
			<br>
			<br>
			<br>	
		</div><!-- /container -->
	</div>	

@stop