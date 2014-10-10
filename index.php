<!DOCTYPE html>

<html lang="en">
  <head>
   	<meta http-equiv="X-UA-Compatible" content="IE=edge" >
    <meta charset="utf-8">
	<link href="css/style.css" media="screen" rel="stylesheet" type="text/css" />
	<script src='js/vendor/jquery-1.11.1.min.js'></script>  
    <script src='https://www.google.com/jsapi'></script>
    <script>
    function DataChart(elem,data,options) {
    	this.data = data;
    	this.elem = elem;
    	this.options = options;
    	this.inited = false;
    }
    DataChart.prototype.init = function(){
    	this.data = google.visualization.arrayToDataTable(this.data);
    	this.chart = new google.visualization.Gauge(this.elem);
    	this.chart.draw(this.data, options);
    	this.inited = true;
    }
    DataChart.prototype.draw = function(){
    	var that=this;
    	if(!this.inited){
    		this.init();
    	}
    	$.ajax({
    		'url':'getData.php',
    		'type':'GET',
    		'dataType':'html'
    	}).success(function(respData){
    		that.data.setValue(0, 1, respData);
    		that.chart.draw(that.data, that.options);
    	}).complete(function(){
    		setTimeout(function(){
    			that.draw();
    		},that.options.refreshRate);
    	});
    }
    var dataChart,
    data = [
      ['Label', 'Value'],
      ['Temp', 0]
    ],
    options = {
      width: 400, height: 400,
      redFrom: 80, redTo: 100,
      yellowFrom:50, yellowTo: 80,
      greenFrom: 0, greenTo: 50,
      minorTicks: 5, 
      refreshRate: 2000
    };

    google.load('visualization', '1', {packages:['gauge']});
    google.load('visualization', '1', {packages:['corechart']});
    google.setOnLoadCallback(function() {
      $(function() {
    	dataChart = new DataChart($('#Gauge')[0],data,options);
    	dataChart.draw();
      });
    });
    </script>
  </head>
  <body>
    <div id="Gauge" align="center"></div>
	<div id="Info">
		<ul>
			<li>Chart Data is pulled from Cloudant: <a href="http://www.cloudant.com" target="_blank">Cloudant</a></li>
			<li>App is running on IBM Bluemix: <a href="http://www.bluemix.net" target="_blank">BlueMix</a></li>
			<li>Graphing API: <a href="https://developers.google.com/chart/interactive/docs/gallery" target="_blank">Google Charts</a></li>
		</ul>
	</div>
  </body>
</html>