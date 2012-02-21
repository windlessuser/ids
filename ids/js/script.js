/* Author: 
 * Marc Byfield & Matthew Budram.
 */
 
var map = new google.maps.Map(document.getElementById("map_canvas"));
function initialize() {
	var latlng = new google.maps.LatLng(18.00779442656203, -76.79786682128906);
	var myOptions = {
	  zoom: 12,
	  center: latlng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

	loadControlDoc();
	addMarker();
}

var xmlhttp;
function loadControlDoc() {
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = populateControlDiv;
	xmlhttp.open("GET","control.php",true);
	xmlhttp.send();
}

function populateControlDiv() {
	if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		document.getElementById("control").innerHTML=xmlhttp.responseText;
	}
}

function addMarker(){
	ajaxGetRequest("http://localhost/ids/home/markers", handleMarker);
	}

	function ajaxGetRequest(url, callback)
	{
  	    var aobj = getXMLHttpObject();
	    aobj.onreadystatechange = function()
  	    {
	        if(aobj.readyState == 4 && aobj.status == 200)
   	        {
      	            if(aobj.responseText)
                           {
        		         callback(aobj); // See Step 4 slide*
                             //  aobj.close();
                           }
                     }
  	    }
  	    aobj.open("GET", url, true);
  	    aobj.send(null);
	}

	function getXMLHttpObject()
	{
	    var xmlhttp = null;

	    if(window.XMLHttpRequest)
	        xmlhttp = new XMLHttpRequest();
	    else if (window.ActiveXObject)
	        xmlhttp = new
			       ActiveXObject("Microsoft.XMLHTTP");

	    return xmlhttp;
	}

	function handleMarker(xmlobj){
		resp = JSON.parse(xmlobj.responseText);
		var i = 0;
		var lat, crop, lon,loc, parish,marker;
 		for(i=0; i<10; i++){
			lat = resp.prices[i].Price.Ycoord;
			lon = resp.prices[i].Price.Xcoord;
			crop = resp.prices[i].Price.CropType;
			parish = resp.prices[i].Price.Parish;
			loc = new google.maps.LatLng(lat,lon);
	   		marker = createMarker(loc,crop+ " " +parish);			
			marker.setMap(map);
		}
	}

	function createMarker(point,message) {
  	  var marker =   marker = new google.maps.Marker({
    position: point});
         return marker;
       }
