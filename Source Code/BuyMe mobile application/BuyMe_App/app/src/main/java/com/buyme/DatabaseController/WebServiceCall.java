package com.buyme.DatabaseController;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.client.utils.URLEncodedUtils;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.List;

/**
 * Created by ll_cheok on 7/23/2016.
 */
public class WebServiceCall {

    // WebServiceCall url variables
//    public static final String MSERVER_ADDRESS = "10.131.79.127:82"; // 360 share wifi
    public static final String MSERVER_ADDRESS = "192.168.1.3:82"; // mobile data
    public static final String DIRECTORY = "BuyMe/app";
    public static final String PHP_FILE = "webservice.php";

    // WebServiceCall method
    public static final String REQUEST_METHOD = "POST";
    public static final String FN = "fn";
    public static final String fnUserLogin = "fnUserLogin";
    public static final String fnUserRegister = "fnUserRegister";
    public static final String fnForgotPassword = "fnForgotPassword";
    public static final String fnGetCategory = "fnGetCategory";
    public static final String fnGetProduct = "fnGetProduct";
    public static final String fnGetSpecificProduct = "fnGetSpecificProduct";
    public static final String fnGetUserProfile = "fnGetUserProfile";
    public static final String fnUpdateUserProfile = "fnUpdateUserProfile";
    public static final String fnUpdateUserEmail = "fnUpdateUserEmail";
    public static final String fnUpdateUserPassword = "fnUpdateUserPassword";
    public static final String fnCheckCart = "fnCheckCart";
    public static final String fnAddToCart = "fnAddToCart";
    public static final String fnAddToCartAgain = "fnAddToCartAgain";
    public static final String fnGetCart = "fnGetCart";
    public static final String fnGetCartOrderNo = "fnGetCartOrderNo";
    public static final String fnDeleteCart = "fnDeleteCart";
    public static final String fnGetOrder = "fnGetOrder";
    public static final String fnSetOrderStatus = "fnSetOrderStatus";
    public static final String fnOrderFrom = "fnOrderFrom";
    public static final String fnGetTotalOrderFromShop = "fnGetTotalOrderFromShop";
    public static final String fnUpdateQuantity = "fnUpdateQuantity";
    public static final String fnUpdateCart = "fnUpdateCart";
    public static final String fnUpdateAddress = "fnUpdateAddress";
    public static final String fnCheckAddress = "fnCheckAddress";
    public static final String fnCreateOrder = "fnCreateOrder";
    public static final String fnGetCurrentCart = "fnGetCurrentCart";
    public static final String fnGetSpecificShop = "fnGetSpecificShop";

    // SharedPreferences file and operating mode
    public static final String prefs_login = "prefs_login"; // file name
    public static final String prefs_login_id_key = "prefs_login_id_key"; // operating mode
    public static final String prefs_login_email_key = "prefs_login_email_key"; // operating mode
    public static final String prefs_login_name_key = "prefs_login_name_key"; // operating mode

    private JSONObject jsonObj;
    private String strUrl = "";

    public WebServiceCall()
    {
        jsonObj = null;
        strUrl = "http://" + MSERVER_ADDRESS + "/" + DIRECTORY + "/" + PHP_FILE;
    }

    public String getURL()
    {
        return strUrl;
    }

    public JSONObject makeHttpRequest(String url, String method, List<NameValuePair> params)
    {

        // To hold byte data from http request
        InputStream is = null;
        JSONObject jObj = null;
        String json = "";

        try
        {

            // check for request method
            if(method.equals("POST"))
            {
                // request method is POST
                // defaultHttpClient
                DefaultHttpClient httpClient = new DefaultHttpClient();
                HttpPost httpPost = new HttpPost(url);
                httpPost.setEntity(new UrlEncodedFormEntity(params));

                HttpResponse httpResponse = httpClient.execute(httpPost);
                HttpEntity httpEntity = httpResponse.getEntity();
                is = httpEntity.getContent();

            }
            else if(method.equals("GET"))
            {
                // request method is GET
                DefaultHttpClient httpClient = new DefaultHttpClient();
                String paramString = URLEncodedUtils.format(params, "utf-8");
                url += "?" + paramString;
                HttpGet httpGet = new HttpGet(url);

                HttpResponse httpResponse = httpClient.execute(httpGet);
                HttpEntity httpEntity = httpResponse.getEntity();
                is = httpEntity.getContent();

            }

            BufferedReader reader = new BufferedReader(new InputStreamReader(
                    is, "iso-8859-1"), 8);
            StringBuilder sb = new StringBuilder();
            String line = null;

            while((line = reader.readLine()) != null)
            {
                sb.append(line + "\n");
            }

            is.close();
            json = sb.toString();

            jObj = new JSONObject(json);

        }
        catch(Exception e)
        {
            e.printStackTrace();
        }

        // return JSONObject
        return jObj;

    }
}
