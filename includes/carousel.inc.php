<?php 



function printCarousel()
{

print <<< EOT

<div class="panel panel-default">
  <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="8000">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
      <li data-target="#myCarousel" data-slide-to="4"></li>
      <li data-target="#myCarousel" data-slide-to="5"></li>
      <li data-target="#myCarousel" data-slide-to="6"></li>
      <li data-target="#myCarousel" data-slide-to="7"></li>
      <li data-target="#myCarousel" data-slide-to="8"></li>
      <li data-target="#myCarousel" data-slide-to="9"></li>
      <li data-target="#myCarousel" data-slide-to="10"></li>
     <!-- <li data-target="#myCarousel" data-slide-to="11"></li> -->
    </ol>
    
    <style>
      div.item img {
         width: 400px !important;
         height: 400px !important;
      }
    </style>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="images/1-xcimage.png" alt="XC">
      </div>

      <div class="item">
        <img src="images/2-batman.jpg" alt="Runners">
      </div>

      <div class="item">
        <img src="images/3-day.jpg" alt="Runners">
      </div>

      <div class="item">
        <img src="images/4-FinishOnEmpty.jpg" alt="Runners">
      </div>

      <div class="item">
        <img src="images/5-mo.jpg" alt="Runners">
      </div>

      <div class="item">
        <img src="images/6-Pre.jpg" alt="Runners">
      </div>

      <div class="item">
        <img src="images/7-runFun.jpg" alt="Runners">
      </div>

      <div class="item">
        <img src="images/8-RunXCTheySaid.jpg" alt="Runners">
      </div>

      <div class="item">
        <img src="images/9-xcphilosophy.jpg" alt="Runners">
      </div>

      <div class="item">
        <img src="images/10-PreSuicidePace.jpg" alt="Runners">
      </div>

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

}

printCarousel();

?>