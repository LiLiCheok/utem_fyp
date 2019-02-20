package com.buyme.Interface;


import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.location.Address;
import android.location.Geocoder;
import android.location.LocationManager;
import android.os.Build;
import android.os.Bundle;
import android.provider.Settings;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentTransaction;
import android.text.TextUtils;
import android.util.Base64;
import android.util.Log;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.buyme.DatabaseController.WebServiceCall;
import com.buyme.GetterSetterClass.SpecificProduct;
import com.buyme.R;
import com.google.android.gms.maps.model.LatLng;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

/**
 * A simple {@link Fragment} subclass.
 */
public class SpecificProductFragment extends Fragment implements View.OnClickListener {

    View v;
    Button sp_add_to_cart_btn;
    ImageView sp_image;
    LinearLayout sp_shopadd_layout, sp_shoploc_layout, sp_shopdelinfo_layout, daily_layout, mon_sun_layout;
    TextView sp_name, sp_description, sp_price, sp_category, sp_id, who_post;
    TextView sp_shopname, sp_shopdesc, sp_shopcon, sp_shopadd, sp_shoploc, sp_shopdel, sp_shopdelinfo;
    TextView day, start, end;
    TextView monday, monstart, monend;
    TextView tuesday, tuestart, tueend;
    TextView wednesday, wedstart, wedend;
    TextView thursday, thurstart, thurend;
    TextView friday, fristart, friend;
    TextView saturday, satstart, satend;
    TextView sunday, sunstart, sunend;

    String login_id = MainActivity.login_id;
    String login_email = MainActivity.login_email;
    String login_name = MainActivity.login_name;
    int num_cart = 0;

    ArrayList<SpecificProduct> specificProducts;
    LatLng p1 = null;
    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    public SpecificProductFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        getActivity().setTitle("BuyMe");

        // Inflate the layout for this fragment
        v = inflater.inflate(R.layout.fragment_specific_product, container, false);

        specificProducts = new ArrayList<SpecificProduct>();

        sp_shopadd_layout = (LinearLayout) v.findViewById(R.id.sp_shopadd_layout);
        sp_shoploc_layout = (LinearLayout) v.findViewById(R.id.sp_shoploc_layout);
        sp_shopdelinfo_layout = (LinearLayout) v.findViewById(R.id.sp_shopdelinfo_layout);
        daily_layout = (LinearLayout) v.findViewById(R.id.daily_layout);
        mon_sun_layout = (LinearLayout) v.findViewById(R.id.mon_sun_layout);
        sp_add_to_cart_btn = (Button) v.findViewById(R.id.sp_add_to_cart_btn);
        sp_category = (TextView) v.findViewById(R.id.sp_category);
        sp_image = (ImageView) v.findViewById(R.id.sp_image);
        sp_id = (TextView) v.findViewById(R.id.sp_id);
        sp_name = (TextView) v.findViewById(R.id.sp_name);
        sp_description = (TextView) v.findViewById(R.id.sp_description);
        sp_price = (TextView) v.findViewById(R.id.sp_price);
        sp_shopname = (TextView) v.findViewById(R.id.sp_shopname);
        sp_shopdesc = (TextView) v.findViewById(R.id.sp_shopdesc);
        sp_shopcon = (TextView) v.findViewById(R.id.sp_shopcon);
        day = (TextView) v.findViewById(R.id.day);
        start = (TextView) v.findViewById(R.id.start);
        end = (TextView) v.findViewById(R.id.end);
        monday = (TextView) v.findViewById(R.id.monday);
        monstart = (TextView) v.findViewById(R.id.monstart);
        monend = (TextView) v.findViewById(R.id.monend);
        tuesday = (TextView) v.findViewById(R.id.tuesday);
        tuestart = (TextView) v.findViewById(R.id.tuestart);
        tueend = (TextView) v.findViewById(R.id.tueend);
        wednesday = (TextView) v.findViewById(R.id.wednesday);
        wedstart = (TextView) v.findViewById(R.id.wedstart);
        wedend = (TextView) v.findViewById(R.id.wedend);
        thursday = (TextView) v.findViewById(R.id.thursday);
        thurstart = (TextView) v.findViewById(R.id.thurstart);
        thurend = (TextView) v.findViewById(R.id.thurend);
        friday = (TextView) v.findViewById(R.id.friday);
        fristart = (TextView) v.findViewById(R.id.fristart);
        friend = (TextView) v.findViewById(R.id.friend);
        saturday = (TextView) v.findViewById(R.id.saturday);
        satstart = (TextView) v.findViewById(R.id.satstart);
        satend = (TextView) v.findViewById(R.id.satend);
        sunday = (TextView) v.findViewById(R.id.sunday);
        sunstart = (TextView) v.findViewById(R.id.sunstart);
        sunend = (TextView) v.findViewById(R.id.sunend);
        sp_shopadd = (TextView) v.findViewById(R.id.sp_shopadd);
        sp_shoploc = (TextView) v.findViewById(R.id.sp_shoploc);
        sp_shopdel = (TextView) v.findViewById(R.id.sp_shopdel);
        sp_shopdelinfo = (TextView) v.findViewById(R.id.sp_shopdelinfo);
        who_post = (TextView) v.findViewById(R.id.who_posted);

        sp_shopadd.setOnClickListener(this);
        sp_shoploc.setOnClickListener(this);
        sp_add_to_cart_btn.setOnClickListener(this);

        final String product_id = getArguments().getString("product_id");
        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnGetSpecificProduct));
                params1.add(new BasicNameValuePair("product_id", product_id));
                try {
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    JSONArray data = jsnObj.getJSONArray("data");
                    for(int index=0; index<data.length(); index++) {
                        SpecificProduct specificProduct = new SpecificProduct();
                        JSONObject obj = data.getJSONObject(index);
                        specificProduct.setCategoryName(obj.optString("category_name"));
                        final String encodedString1 = obj.getString("product_image");
                        final String pureBase64Encoded1 =
                                encodedString1.substring(encodedString1.indexOf(",")  + 1);
                        final byte[] decodedBytes1 =
                                Base64.decode(pureBase64Encoded1, Base64.DEFAULT);
                        Bitmap decodedBitmap1 =
                                BitmapFactory.decodeByteArray(decodedBytes1, 0, decodedBytes1.length);
                        int h1 = 300; // height in pixels
                        int w1 = 300; // width in pixels
                        Bitmap photoBitMap1 = Bitmap.createScaledBitmap(decodedBitmap1,h1, w1, true);
                        specificProduct.setProductImage(photoBitMap1);
                        specificProduct.setProductID(obj.optString("product_id"));
                        specificProduct.setProductName(obj.optString("product_name"));
                        specificProduct.setProductPrice(obj.optString("product_price"));
                        specificProduct.setProductDescription(obj.optString("product_desc"));
                        specificProduct.setShopName(obj.optString("shop_name"));
                        specificProduct.setShopDescription(obj.optString("shop_desc"));
                        specificProduct.setShopContact(obj.optString("shop_contact"));
                        specificProduct.setBusinessHour(obj.optString("business_hour"));
                        String address = obj.optString("address")+" "+obj.optString("postcode")+" "+obj.optString("city")+" "+obj.optString("state");
                        specificProduct.setShopAddress(address);
                        specificProduct.setShopLocation(obj.optString("shop_location"));
                        specificProduct.setDeliveryService(obj.optString("delivery_service"));
                        specificProduct.setDeliveryInfo(obj.optString("delivery_info"));
                        specificProduct.setUserName(obj.optString("user_name"));
                        specificProduct.setPostAt(obj.optString("post_at"));
                        specificProducts.add(specificProduct);
                    }
                    getActivity().runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            if(specificProducts.size()>0) {
                                for(int i=0; i<specificProducts.size(); i++) {
                                    sp_category.setText(specificProducts.get(i).getCategoryName());
                                    sp_image.setImageBitmap(specificProducts.get(i).getProductImage());
                                    sp_id.setText(specificProducts.get(i).getProductID());
                                    sp_name.setText(specificProducts.get(i).getProductName());
                                    sp_description.setText(specificProducts.get(i).getProductDescription());
                                    sp_price.setText(specificProducts.get(i).getProductPrice());
                                    sp_shopname.setText(specificProducts.get(i).getShopName());
                                    sp_shopdesc.setText(specificProducts.get(i).getShopDescription());
                                    sp_shopcon.setText(specificProducts.get(i).getShopContact());
                                    String business_hour = specificProducts.get(i).getBusinessHour().toString();
                                    String days = business_hour.substring(0, business_hour.indexOf("(,1)"));
                                    String starts = business_hour.substring(business_hour.indexOf("(,1)")+4, business_hour.indexOf("(-1)"));
                                    String ends = business_hour.substring(business_hour.indexOf("(-1)")+4, business_hour.indexOf("(.1)"));
                                    if(days.equals("Daily")) {
                                        daily_layout.setVisibility(LinearLayout.VISIBLE);
                                        day.setText(days);
                                        start.setText(starts);
                                        end.setText(ends);
                                    } else {
                                        String tuesdays = business_hour.substring(business_hour.indexOf("(.1)")+4, business_hour.indexOf("(,2)"));
                                        String tuestarts = business_hour.substring(business_hour.indexOf("(,2)")+4, business_hour.indexOf("(-2)"));
                                        String tueends = business_hour.substring(business_hour.indexOf("(-2)")+4, business_hour.indexOf("(.2)"));
                                        String wednesdays = business_hour.substring(business_hour.indexOf("(.2)")+4, business_hour.indexOf("(,3)"));
                                        String wedstarts = business_hour.substring(business_hour.indexOf("(,3)")+4, business_hour.indexOf("(-3)"));
                                        String wedends = business_hour.substring(business_hour.indexOf("(-3)")+4, business_hour.indexOf("(.3)"));
                                        String thursdays = business_hour.substring(business_hour.indexOf("(.3)")+4, business_hour.indexOf("(,4)"));
                                        String thurstarts = business_hour.substring(business_hour.indexOf("(,4)")+4, business_hour.indexOf("(-4)"));
                                        String thurends = business_hour.substring(business_hour.indexOf("(-4)")+4, business_hour.indexOf("(.4)"));
                                        String fridays = business_hour.substring(business_hour.indexOf("(.4)")+4, business_hour.indexOf("(,5)"));
                                        String fristarts = business_hour.substring(business_hour.indexOf("(,5)")+4, business_hour.indexOf("(-5)"));
                                        String friends = business_hour.substring(business_hour.indexOf("(-5)")+4, business_hour.indexOf("(.5)"));
                                        String saturdays = business_hour.substring(business_hour.indexOf("(.5)")+4, business_hour.indexOf("(,6)"));
                                        String satstarts = business_hour.substring(business_hour.indexOf("(,6)")+4, business_hour.indexOf("(-6)"));
                                        String satends = business_hour.substring(business_hour.indexOf("(-6)")+4, business_hour.indexOf("(.6)"));
                                        String sundays = business_hour.substring(business_hour.indexOf("(.6)")+4, business_hour.indexOf("(,7)"));
                                        String sunstarts = business_hour.substring(business_hour.indexOf("(,7)")+4, business_hour.indexOf("(-7)"));
                                        String sunends = business_hour.substring(business_hour.indexOf("(-7)")+4, business_hour.indexOf("(.7)"));
                                        mon_sun_layout.setVisibility(LinearLayout.VISIBLE);
                                        monday.setText(days);
                                        monstart.setText(starts);
                                        monend.setText(ends);
                                        tuesday.setText(tuesdays);
                                        tuestart.setText(tuestarts);
                                        tueend.setText(tueends);
                                        wednesday.setText(wednesdays);
                                        wedstart.setText(wedstarts);
                                        wedend.setText(wedends);
                                        thursday.setText(thursdays);
                                        thurstart.setText(thurstarts);
                                        thurend.setText(thurends);
                                        friday.setText(fridays);
                                        fristart.setText(fristarts);
                                        friend.setText(friends);
                                        saturday.setText(saturdays);
                                        satstart.setText(satstarts);
                                        satend.setText(satends);
                                        sunday.setText(sundays);
                                        sunstart.setText(sunstarts);
                                        sunend.setText(sunends);
                                    }
                                    String loc = specificProducts.get(i).getShopLocation().toString();
                                    if(loc.equals("null")) {
                                        sp_shopadd_layout.setVisibility(LinearLayout.VISIBLE);
                                        sp_shopadd.setText(specificProducts.get(i).getShopAddress());
                                    } else {
                                        sp_shoploc_layout.setVisibility(LinearLayout.VISIBLE);
                                        sp_shoploc.setText(specificProducts.get(i).getShopLocation());
                                    }
                                    sp_shopdel.setText(specificProducts.get(i).getDeliveryService());
                                    String ds = specificProducts.get(i).getDeliveryService().toString();
                                    if(ds.equals("yes")) {
                                        sp_shopdelinfo_layout.setVisibility(LinearLayout.VISIBLE);
                                        sp_shopdelinfo.setText(specificProducts.get(i).getDeliveryInfo());
                                    } else {}
                                    who_post.setText("posted by "+specificProducts.get(i).getUserName()+" on "+specificProducts.get(i).getPostAt());
                                }
                            } else {}
                        }
                    });
                } catch (Exception e) {
                    e.printStackTrace();
                    Log.d("GetSpecificProduct", "Error!");
                }
            }
        };
        Thread thread = new Thread(run);
        thread.start();

        return v;
    }

    @Override
    public void onResume() {
        super.onResume();
        getView().setFocusableInTouchMode(true);
        getView().requestFocus();
        getView().setOnKeyListener( new View.OnKeyListener() {
            @Override
            public boolean onKey(View v, int keyCode, KeyEvent event) {
                if (event.getAction() == KeyEvent.ACTION_UP &&
                        keyCode == KeyEvent.KEYCODE_BACK) {
                    Fragment newFragment = new HomeFragment();
                    FragmentTransaction transaction =
                            getFragmentManager().beginTransaction();
                    transaction.replace(R.id.fragment_container, newFragment);
                    transaction.addToBackStack(null);
                    transaction.commit();
                    return true;
                }
                return false;
            }
        });
    }

    public static boolean isLocationEnabled(Context context) {
        int locationMode = 0;
        String locationProviders;

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT){
            try {
                locationMode = Settings.Secure.getInt(context.getContentResolver(), Settings.Secure.LOCATION_MODE);

            } catch (Settings.SettingNotFoundException e) {
                e.printStackTrace();
            }

            return locationMode != Settings.Secure.LOCATION_MODE_OFF;

        }else{
            locationProviders = Settings.Secure.getString(context.getContentResolver(), Settings.Secure.LOCATION_PROVIDERS_ALLOWED);
            return !TextUtils.isEmpty(locationProviders);
        }
    }

    @Override
    public void onClick(View view) {

        if(view.getId()==R.id.sp_shopadd) {
            boolean check_loc = isLocationEnabled(getContext());
            if(check_loc==true) {
                getLocationFromAddress(getContext(), sp_shopadd.getText().toString().trim());

                if(p1==null) {
                    Toast.makeText(getActivity(), "Null Location.", Toast.LENGTH_SHORT).show();
                } else {
                    String latlong = p1.toString().trim();
                    latlong = latlong.replace(latlong.substring(0,latlong.indexOf("(")), "");

                    Intent mapIntent = new Intent(getContext(), MapsActivity.class);
                    mapIntent.putExtra("location", latlong);
                    startActivity(mapIntent);
                }
            } else {
                AlertDialog.Builder builder;
                AlertDialog alert;
                builder = new AlertDialog.Builder(getActivity());

                builder.setTitle("Location Services Not Active");
                builder.setMessage("Please enable Location Services and GPS.");

                builder.setNeutralButton("Ok", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int i) {
                        dialog.cancel();
                    }
                });

                alert = builder.create();
                alert.show();
            }
        }

        if(view.getId()==R.id.sp_shoploc) {
            Intent mapIntent = new Intent(getContext(), MapsActivity.class);
            mapIntent.putExtra("location", sp_shoploc.getText());
            startActivity(mapIntent);
        }

        if(view.getId()==R.id.sp_add_to_cart_btn) {
            if(login_id==null && login_email==null && login_name==null) {
                HomeFragment.openLoginMsg();
            } else {
                checkCart();
            }
        }
    }

    private void checkCart() {
        final String product_id = sp_id.getText().toString().trim();
        final String product_price = sp_price.getText().toString().trim();
        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnCheckCart));
                params1.add(new BasicNameValuePair("user_id", login_id));
                params1.add(new BasicNameValuePair("product_id", product_id));
                try {
                    String result = "exist", result1 = "not_exist";
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    if (result.equals(jsnObj.optString("exist"))){
                        getActivity().runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(getActivity(), "This product is exist in your cart.", Toast.LENGTH_LONG).show();
                            }
                        });
                    } else if (result1.equals(jsnObj.optString("not_exist"))) {
                        addToCart(product_id, product_price);
                    } else {}
                }  catch (Exception e) {
                    e.printStackTrace();
                    Log.d("CheckCart", "Error!");
                }
            }
        };

        Thread thr = new Thread(run);
        thr.start();
    }

    private void addToCart(final String pro_id, final String pro_price) {
        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnAddToCart));
                params1.add(new BasicNameValuePair("user_id", login_id));
                params1.add(new BasicNameValuePair("product_id", pro_id));
                params1.add(new BasicNameValuePair("product_price", pro_price));
                try {
                    String result = "added", result1 = "again";
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    if (result.equals(jsnObj.optString("added"))) {
                        getActivity().runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(getActivity(), "Added to cart.", Toast.LENGTH_LONG).show();
                                num_cart = Integer.parseInt(MainActivity.num_cart.getText().toString()) + 1;
                                MainActivity.num_cart.setText(String.valueOf(num_cart));
                            }
                        });
                    } else if (result1.equals(jsnObj.optString("again"))) {
                        addToCartAgain(pro_id, pro_price);
                    } else {}
                }  catch (Exception e) {
                    e.printStackTrace();
                    Log.d("AddToCart", "Error!");
                }
            }
        };

        Thread thr = new Thread(run);
        thr.start();
    }

    private void addToCartAgain(final String apro_id, final String apro_price) {
        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnAddToCartAgain));
                params1.add(new BasicNameValuePair("user_id", login_id));
                params1.add(new BasicNameValuePair("product_id", apro_id));
                params1.add(new BasicNameValuePair("product_price", apro_price));
                try {
                    String added = "added";
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    if (added.equals(jsnObj.optString("added"))) {
                        getActivity().runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(getActivity(), "Added to cart.", Toast.LENGTH_LONG).show();
                                num_cart = Integer.parseInt(MainActivity.num_cart.getText().toString()) + 1;
                                MainActivity.num_cart.setText(String.valueOf(num_cart));
                            }
                        });
                    } else {
                    }
                }  catch (Exception e) {
                    e.printStackTrace();
                    Log.d("AddToCartAgain", "Error!");
                }
            }
        };

        Thread thr = new Thread(run);
        thr.start();
    }

    /**
     * Get location from address
     * @param context
     * @param strAddress
     * @return lat and long
     */
    public LatLng getLocationFromAddress(Context context, String strAddress) {

        Geocoder coder = new Geocoder(context);
        List<Address> address;
        p1 = null;

        try {
            address = coder.getFromLocationName(strAddress, 5);
            if (address == null) {
                return null;
            }
            Address location = address.get(0);
            location.getLatitude();
            location.getLongitude();

            p1 = new LatLng(location.getLatitude(), location.getLongitude() );

        } catch (Exception ex) {

            ex.printStackTrace();
        }

        return p1;
    }
}
