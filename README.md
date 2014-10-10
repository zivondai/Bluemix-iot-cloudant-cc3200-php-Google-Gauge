Dynamic Google Gauge - Sourced by data from Cloudant running on Bluemix 

![Google Gauge](http://dynamicgooglegauge-b14e17ca-c5ba-405c-ab33-0a7b6261d05c.mybluemix.net/images/gauge.png "Google Gauge")

Sample application demonstrating how to build a Bluemix application that displays a Google Gauge with data sourced from a Cloudant database. 
The application will read your VCAP_SERVICES environment variable and build a connection to a Cloudant database. Once connected to the database
it will read a document that contains the value for the Google Gauge. 

You can see an example of the application running at:
http://dynamicgooglegauge-b14e17ca-c5ba-405c-ab33-0a7b6261d05c.mybluemix.net/

Once you deploy the code to your instance of Bluemix, you will need to configure a Cloudant
service and create the database by following these simple steps. 

1.) Deploy the DynamicGoogleGauge demo code from JazzHub.

2.) Add a Cloudant service to the application and enter your Cloudant connection details. 
    The connection details will be stored within the VCAP_SERVICES environment variable, which
    we will pull into our code inside the index.php page. 

3.) Create a NEW database called "gauge"

4.) Within your "gauge" database create a new document called "Gauge-Data". Copy the JSON data below and save this as a new document. 
    
    {
	  "_id": "Gauge-Data",
  	  "id": "Gauge-Data",
  	  "GaugeValue": "550"
    }
    
5.) Save the document.

6.) Run your app by clicking on the URL provided in your Bluemix dashboard for the application.

You can then modify the GaugeValue in Cloudant and run your app to see the gauge change. 

Note: To see the code used to connect to the database and display the Google Gauge take a look at the index.php file.

