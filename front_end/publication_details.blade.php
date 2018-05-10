<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>NIRF Dashboard</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

     {{-- <script src="https://cdn.anychart.com/js/8.0.1/anychart-core.min.js"></script>
      <script src="https://cdn.anychart.com/js/8.0.1/anychart-pie.min.js"></script> --}}
    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
   {{--  <style type="text/css">
        html, body, #container {
          width: 100%;
          height: 100%;
          margin: 0;
          padding: 0;
        }
    </style> --}}
    <script type="text/javascript">
        // anychart.onDocumentReady(function() {

        //   // set the data
        //   var data = [
        //       {x: "Students", value:  },
        //       {x: "Faculty", value:  }
        //   ];

        //   // create the chart
        //   var chart = anychart.pie();


        //   // add the data
        //   chart.data(data);

        //   // display the chart in the container
        //   chart.container('container');
        //   chart.draw();

        // });

window.onload = function() {

var chart1 = new CanvasJS.Chart("chartContainer1", {
    animationEnabled: true,
    title: {
        text: "{{$selected_college}}"
    },
    data: [{
        type: "pie",
        startAngle: 240,
        // yValueFormatString: "#/%",
        indexLabel: "{label} {y}",
        dataPoints: [
            {y: {{$a2}}, label: "Scopus"},
            {y: {{$a1}}, label: "Web of Science"},
        ]
    }]
});
var chart2 = new CanvasJS.Chart("chartContainer2", {
    animationEnabled: true,
    title: {
        text: "{{$selected_college}}"
    },
    data: [{
        type: "pie",
        startAngle: 240,
        // yValueFormatString: "#/%",
        indexLabel: "{label} {y}",
        dataPoints: [
            {y: {{$a4}}, label: "Scopus"},
            {y: {{$a3}}, label: "Web of Science"},
        ]
    }]
});

chart1.render();
chart2.render();

}


    </script>
   
</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="main-logo.png">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="main" class="simple-text" >
                    <img style="width: 275px;margin-left: -30px;" src="nirf1.png">
                    NIRF Dashboard

                </a>
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="main">
                        <i class="pe-7s-news-paper"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="user.html">
                        <i class="pe-7s-user"></i>
                        <p>User Profile</p>
                    </a>
                </li>
                <li>
                    <a href="college_paper_details">
                        <i class="pe-7s-note2"></i>
                        <p>Research Papers</p>
                    </a>
                </li>
                <li>
                    <a href="compare_limit">
                        <i class="pe-7s-graph"></i>
                        <p>Compare</p>
                    </a>
                </li>
                
				
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Dashboard</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-dashboard"></i>
								<p class="hidden-lg hidden-md">Dashboard</p>
                            </a>
                        </li>
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-globe"></i>
                                    <b class="caret hidden-lg hidden-md"></b>
									<p class="hidden-lg hidden-md">
										5 Notifications
										<b class="caret"></b>
									</p>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Notification 1</a></li>
                                <li><a href="#">Notification 2</a></li>
                                <li><a href="#">Notification 3</a></li>
                                <li><a href="#">Notification 4</a></li>
                                <li><a href="#">Another notification</a></li>
                              </ul>
                        </li>
                        <li>
                           <a href="">
                                <i class="fa fa-search"></i>
								<p class="hidden-lg hidden-md">Search</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                           <a href="">
                               <p>Account</p>
                            </a>
                        </li>
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <p>
										Dropdown
										<b class="caret"></b>
									</p>

                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                              </ul>
                        </li>
                        <li>
                            <a href="login">
                                <p>Log out</p>
                            </a>
                        </li>
						<li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>


        
           
                    <div style="margin-right: 100px; margin-top: 90px;">

                    
                        
                          
                          <form action="college_paper_selected">
                              <select name="selected_college" style="margin-top: -100px;margin-left: 50px;" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" >
                              @foreach($college_names as $college_name)
                                  <option name= "selected_college" value={{$college_name[0]}}>{{$college_name[0]}}</option>
                              @endforeach
                              </select>
                                <input type="submit" style="margin-top: -100px;margin-left: 10px;" class="btn btn-primary" name="submit">

                       
                          </form>
                        
              
        </div>

        <div style="margin-top: -35px;margin-left: 190px; margin-top: 30px;">
        
        <div class="col-md-4">
                        <div class="card" style="position: absolute;">

                            <div class="header" >
                                <h4 class="title" style="position: relative; margin-left: 10px;">Publication Details</h4>
                                <p class="category">Publication Details</p>
                            </div>
                            <div class="content" style="margin-top: -40px;">
                                <div id="chartContainer1" style="height: 300px; width: 100%;"></div>

                                <div class="footer" style="margin-top: -10px;">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> Scopus
                                        <i class="fa fa-circle text-danger"></i> Web of Science
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


        </div>

        <div style="margin-top: -35px;margin-left: 150px;">
            <div class="col-md-4">
                        <div class="card" style="position: absolute;">

                            <div class="header" >
                                <h4 class="title" style="position: relative; margin-left: 10px;">Citation Details</h4>
                                <p class="category">Citation Details</p>
                            </div>
                            <div class="content" style="margin-top: -40px;">
                                <div id="chartContainer2" style="height: 300px; width: 100%;"></div>

                                <div class="footer" style="margin-top: -10px;">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i>  Scopus
                                        <i class="fa fa-circle text-danger"></i>Web of Science
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
        </div>

</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>

	<script type="text/javascript">
    	$(document).ready(function(){

        	demo.initChartist();

        	$.notify({
            	icon: 'pe-7s-gift',
            	message: "Welcome to <b>NIRF Dashboard</b> ."

            },{
                type: 'info',
                timer: 4000
            });

    	});
	</script>

</html>
