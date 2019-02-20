package com.buyme.Interface;

import android.Manifest;
import android.app.Dialog;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.location.Location;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.FragmentActivity;
import android.util.Log;
import android.widget.TextView;

import com.buyme.Adapter.DirectionsJSONParser;
import com.buyme.R;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.maps.CameraUpdate;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.LatLngBounds;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.android.gms.maps.model.PolylineOptions;

import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

public class MapsActivity extends FragmentActivity implements GoogleMap.OnMyLocationChangeListener, OnMapReadyCallback {

    private GoogleMap mMap; // Might be null if google play services apk is not available
    private LatLngBounds.Builder builder;
    private CameraUpdate cu;
    private ArrayList<LatLng> markerPoints;
    private String shopLoc;
    private TextView MyTextView;
    private double before, after;

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        MapsActivity.this.finish();
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_maps);

        MyTextView = (TextView) findViewById(R.id.MyTextView);

        if (savedInstanceState == null) {
            Bundle extras = getIntent().getExtras();
            if (extras == null) {
                shopLoc = null;
            } else {
                shopLoc = extras.getString("location");
            }
        } else {
            shopLoc = (String) savedInstanceState.getSerializable("location");
        }

        shopLoc = shopLoc.replace("(", "");
        shopLoc = shopLoc.replace(")", "");

        int index = shopLoc.indexOf(',');
        before = Double.parseDouble(shopLoc.substring(0, index).trim());
        after = Double.parseDouble(shopLoc.substring(index + 1).trim());

        googlePlayServiceCheck();

    }

    private void googlePlayServiceCheck() {

        // Getting Google Play availability status
        int status = GooglePlayServicesUtil.isGooglePlayServicesAvailable(getBaseContext());

        // Showing status
        if (status != ConnectionResult.SUCCESS) {
            int requestCode = 10;
            Dialog dialog = GooglePlayServicesUtil.getErrorDialog(status, this, requestCode);
            dialog.show();
        } else { // Google Play Services are available

            // Getting reference to the SupportMapFragment of activity_maps.xml
            SupportMapFragment fm = (SupportMapFragment)
                    getSupportFragmentManager().findFragmentById(R.id.map);

            // Getting GoogleMap object from the fragment
            fm.getMapAsync(this);
        }
    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;
        if (ActivityCompat.checkSelfPermission(
                this, Manifest.permission.ACCESS_FINE_LOCATION) !=
                PackageManager.PERMISSION_GRANTED &&
                ActivityCompat.checkSelfPermission(
                        this, Manifest.permission.ACCESS_COARSE_LOCATION)
                        != PackageManager.PERMISSION_GRANTED) {
            // TODO: Consider calling
            //    ActivityCompat#requestPermissions
            // here to request the missing permissions, and then overriding
            //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
            //                                          int[] grantResults)
            // to handle the case where the user grants the permission. See the documentation
            // for ActivityCompat#requestPermissions for more details.
            return;
        }
        mMap.setMyLocationEnabled(true);
        mMap.getUiSettings().setMapToolbarEnabled(true);
        mMap.setOnMyLocationChangeListener(this);
    }

    /**
     * Method to set map view.
     * @param latLng
     */
    private void mSetUpMap(LatLng latLng) {

        // clear the map before redraw to them
        mMap.clear();

        LatLng slatLng = new LatLng(before, after);

        List<Marker> markersList = new ArrayList<Marker>();
        Marker myLoc = mMap.addMarker(new MarkerOptions()
                .position(latLng)
                .title("You are here!"));
        Marker shopLoc = mMap.addMarker(new MarkerOptions()
                .position(slatLng)
                .title("We are here!"));

        // Put all the markers into arraylist
        markersList.add(myLoc);
        markersList.add(shopLoc);

        // Put the point to get the route
        // Initializing array List
        markerPoints = new ArrayList<LatLng>();
        markerPoints.add(latLng);
        markerPoints.add(slatLng);
        if(markerPoints.size()>=2) {
            LatLng origin = markerPoints.get(0);
            LatLng dest = markerPoints.get(1);
            String url = getDirectionsUrl(origin, dest);

            DownloadTask downloadTask = new DownloadTask();

            downloadTask.execute(url);
        }

    }

    /**
     * Detect the current location.
     * @param location
     */
    @Override
    public void onMyLocationChange(Location location) {
        double latitude = location.getLatitude();
        double longitude = location.getLongitude();
        LatLng latLng = new LatLng(latitude, longitude);

        // call the map to set up
        mSetUpMap(latLng);

    }

    private String getDirectionsUrl(LatLng origin, LatLng dest){

        // Origin of route
        String str_origin = "origin="+origin.latitude+","+origin.longitude;

        // Destination of route
        String str_dest = "destination="+dest.latitude+","+dest.longitude;

        // Sensor enabled
        String sensor = "sensor=false";

        // Building the parameters to the web service
        String parameters = str_origin+"&"+str_dest+"&"+sensor;

        // Output format
        String output = "json";

        String url = "https://maps.googleapis.com/maps/api/directions/"+output+"?"+parameters;

        return url;
    }

    private String downloadUrl(String strUrl) throws IOException {
        String data = "";
        InputStream iStream = null;
        HttpURLConnection urlConnection = null;
        try{
            URL url = new URL(strUrl);

            urlConnection = (HttpURLConnection) url.openConnection();

            // Connecting to url
            urlConnection.connect();

            // Reading data from url
            iStream = urlConnection.getInputStream();

            BufferedReader br = new BufferedReader(new InputStreamReader(iStream));

            StringBuffer sb  = new StringBuffer();

            String line = "";
            while( ( line = br.readLine())  != null){
                sb.append(line);
            }

            data = sb.toString();

            br.close();

        }catch(Exception e){
            Log.d("Downloading url Error",e.toString());
        }finally{
            iStream.close();
            urlConnection.disconnect();
        }
        return data;
    }

    // Fetches data from url passed
    private class DownloadTask extends AsyncTask<String, Void, String> {

        // Downloading data in non-ui thread
        @Override
        protected String doInBackground(String... url) {

            // For storing data from web service
            String data = "";

            try{
                // Fetching the data from web service
                data = downloadUrl(url[0]);
            }catch(Exception e){
                Log.d("Background Task",e.toString());
            }
            return data;
        }

        // Executes in UI thread, after the execution of
        // doInBackground()
        @Override
        protected void onPostExecute(String result) {
            super.onPostExecute(result);

            ParserTask parserTask = new ParserTask();

            // Invokes the thread for parsing the JSON data
            parserTask.execute(result);
        }
    }


    private class ParserTask extends AsyncTask<String, Integer, List<List<HashMap<String,String>>>> {

        @Override
        protected List<List<HashMap<String, String>>> doInBackground(String... jsonData) {

            JSONObject jObject;
            List<List<HashMap<String, String>>> routes = null;

            try{
                jObject = new JSONObject(jsonData[0]);
                DirectionsJSONParser parser = new DirectionsJSONParser();

                // Starts parsing data
                routes = parser.parse(jObject);
            }catch(Exception e){
                e.printStackTrace();
            }
            return routes;
        }

        @Override
        protected void onPostExecute(List<List<HashMap<String, String>>> result) {
            ArrayList<LatLng> points = null;
            PolylineOptions lineOptions = null;
            MarkerOptions markerOptions = new MarkerOptions();

            String distance = "";
            String duration = "";

            // Traversing through all the routes
            for(int i=0;i<result.size();i++){
                points = new ArrayList<LatLng>();
                lineOptions = new PolylineOptions();

                // Fetching i-th route
                List<HashMap<String, String>> path = result.get(i);

                // Fetching all the points in i-th route
                for(int j=0;j<path.size();j++){
                    HashMap<String,String> point = path.get(j);

                    if (j == 0) { // Get distance from the list
                        distance = (String) point.get("distance");
                        continue;
                    } else if (j == 1) { // Get duration from the list
                        duration = (String) point.get("duration");
                        continue;
                    }

                    double lat = Double.parseDouble(point.get("lat"));
                    double lng = Double.parseDouble(point.get("lng"));
                    LatLng position = new LatLng(lat, lng);

                    points.add(position);
                }

                MyTextView.setText("Distance:" + distance + ", Duration:"
                        + duration);

                // Adding all the points in the route to LineOptions
                lineOptions.addAll(points);
                lineOptions.width(5);
                lineOptions.color(Color.MAGENTA);
            }

            // Drawing polyline in the Google Map for the i-th route
            mMap.addPolyline(lineOptions);

            builder = new LatLngBounds.Builder();
            for(LatLng point : points) {
                builder.include(point);
            }

            LatLngBounds bounds = builder.build();
            int padding = 20; // offset from edges of the map in pixels
            cu = CameraUpdateFactory.newLatLngBounds(bounds,
                    padding);
//            mMap.moveCamera(cu);
            mMap.animateCamera(cu, 2000, null);

        }
    }

}
