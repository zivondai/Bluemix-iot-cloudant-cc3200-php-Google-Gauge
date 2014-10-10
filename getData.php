<?php
     //We need to pull in the Sag PHP library. SAG is an open API used to connect to the 
     //Cloudant database. 
     //We only need to do this once!
     require('sag-master/src/Sag.php');

	//Get Connection Variables from VCAPS_SERVICES. We first need to pull in our Cloudant database 
	//connection variables from the VCAPS_SERVICES environment variable. This environment variable 
	//will be put in your project by Bluemix once you add the Cloudant database to your Bluemix
	//application. 
	
	//This URL was a big help with learning how to extract the VCAPS_SERVICES
	// https://docs.appfog.com/services/mysql
	
	// vcap_services Extraction 
	$services_json = json_decode(getenv('VCAP_SERVICES'),true);
	$VcapSvs = $services_json["cloudantNoSQLDB"][0]["credentials"];

	//Debug: If you want to see all the variables returned you can use this line of code. 
	//var_dump($services_json); 

	// Extract the VCAP_SERVICES variables for Cloudant connection.  
	 $myUsername = $VcapSvs["username"];
	 $myPassword = $VcapSvs["password"];

	 //$myUsername = "10f5c671-87fd-4ff6-8bec-8a60049bb747-bluemix";
	 //$myPassword = "433c4b21d87f31b3d717ac860a47054b7cf7142f1975aa662fdd49148536d4ef";

	 //Create the URL for the SAG PHP utlity. 
	 $myUrl = ($myUsername . ".cloudant.com");

    // Let's connect to the database. 
    try {
      // Here is the connection information to conect to the Cloudant database. 
      //$sag = new Sag('<yourCloudantUsername>.cloudant.com');
      //$sag->login('<CloudantUserName>', '<CloudantPassword>');
 
      $sag = new Sag($myUrl);
      $sag->login($myUsername, $myPassword);
      
      // Now that we are connected, we need to tell SAG what database to connect to. For our
      // example we should have created a new database in Cloudant called 'gauge'.
      $sag->setDatabase('gauge');
  
      // We are now going to read a document from our cloudant database. We are going
      // to retrieve the Gauge-Value from the body of the document. The SAG PHP library takes
      // care of all the gory details and only retrieves the value.
      $lastId = $sag->get("_changes?descending=true&limit=1")->body->results[0]->id;
      $resp = $sag->get($lastId);
      $resp = explode(":",($resp->body->payload));
 	  echo $resp[1];  
             
	  // Assuming everything above was executed without error, we now are connected to the 
	  // database and have retrieved the value for the gauge.  We will use this to populate
	  // the google gauge in the JavaScript below. 
	  
	  //NOTE: Since we have a connection to the database, we can query the database for other
	  //      documents and retrieve other variables at a later time. We do not need to connect 
	  //      to the database again. 

    }
      catch(Exception $e) {
      //We sent something to Sag that it didn't expect.
      echo '<p>YO - There Was an Error Getting Data from Cloudant!!!  </p>';
      echo $e->getMessage();
    }
?>
