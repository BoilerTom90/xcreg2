<?php

$image_files = array(
	"jpg1.jpg", "jpg2.jpg", "jpg3.jpg", "jpg4.jpg", "jpg5.jpg", "jpg6.jpg",
	"jpg9.jpg", "jpg10.jpg", "png1.png"
	);

print <<< EOT
	<div class="panel panel-default">
  		<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="8000">
    		<!-- Indicators -->
    		<ol class="carousel-indicators">
EOT;

$count = 0;
foreach ($image_files as $f)
{
	$classActive = "";
	if ($count == 0) {
		$classActive = "class=\"active\"";
	}
	echo "<li data-target=\"#myCarousel\" data-slide-to=\"$count\" $classActive></li>\n";
	$count++;
}

print <<< EOT
			</ol>
			<!-- Wrapper for slides -->
    		<div class="carousel-inner" role="listbox">
EOT;

$count = 0;
foreach ($image_files as $f)
{
	$active = "";
	if ($count == 0) {
		$active = "active";
	}
	$count++;
	print <<< EOT
    		<div class="item $active">
        		<img src="carousel_images/$f" alt="Running Image">
      		</div>
EOT;
}

print <<< EOT
    		</div>

	    	<!-- Left and right controls -->
	    	<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
	     		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	      		<span class="sr-only">Previous</span>
	    	</a>
	    	<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
	      		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	      		<span class="sr-only">Next</span>
	    	</a>
  		</div>
 	</div>

EOT;

?>

