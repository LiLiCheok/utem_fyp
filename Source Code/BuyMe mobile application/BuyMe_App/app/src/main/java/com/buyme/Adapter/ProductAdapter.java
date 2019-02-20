package com.buyme.Adapter;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.SharedPreferences;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentTransaction;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.buyme.DatabaseController.WebServiceCall;
import com.buyme.GetterSetterClass.Product;
import com.buyme.Interface.HomeFragment;
import com.buyme.Interface.LoginFragment;
import com.buyme.Interface.MainActivity;
import com.buyme.R;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by ll_cheok on 7/25/2016.
 */
public class ProductAdapter extends ArrayAdapter<Product> {

    private ArrayList<Product> products;
    private LayoutInflater li;
    int Resource;
    private ViewHolder holder;

    String login_id = MainActivity.login_id;
    String login_email = MainActivity.login_email;
    String login_name = MainActivity.login_name;

    Activity activity;
    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    public ProductAdapter(Activity activity, Context context, int resource, ArrayList<Product> objects) {
        super(context, resource, objects);
        this.activity = activity;
        li = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        Resource = resource;
        products = objects;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {

        if(convertView == null) {

            convertView = li.inflate(Resource, null);

            holder = new ViewHolder();
            holder.product_image = (ImageView) convertView.findViewById(R.id.product_image);
            holder.product_name = (TextView) convertView.findViewById(R.id.product_name);
            holder.product_price = (TextView) convertView.findViewById(R.id.product_price);
            holder.shop_name = (TextView) convertView.findViewById(R.id.shop_name);
            holder.add_to_cart_btn = (Button) convertView.findViewById(R.id.add_to_cart_btn);
            holder.add_to_cart_btn.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {

                    if(login_id==null && login_email==null && login_name==null) {
                        HomeFragment.openLoginMsg();
                    } else {
                        int pos = (Integer)view.getTag();
                        Product p = products.get(pos);
                        String id = p.getProductID().toString();
                        String price = p.getProductPrice().toString();
                        checkCart(id, price);
                    }
                }
            });

            convertView.setTag(holder);

        } else {
            holder = (ViewHolder) convertView.getTag();
        }

        Product p = products.get(position);
        holder.product_id = p.getProductID();
        holder.product_image.setImageBitmap(p.getProductImage());
        holder.product_name.setText(p.getProductName().toString());
        holder.product_price.setText(p.getProductPrice().toString());
        holder.shop_name.setText(p.getShopName());
        holder.add_to_cart_btn.setTag(position);
        holder.num_cart = 0;

        return convertView;
    }

    private void checkCart(final String product_id, final String product_price) {
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
                        activity.runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(activity, "This product is exist in your cart.", Toast.LENGTH_LONG).show();
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
                        activity.runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(activity, "Added to cart.", Toast.LENGTH_LONG).show();
                                holder.num_cart = Integer.parseInt(MainActivity.num_cart.getText().toString()) + 1;
                                MainActivity.num_cart.setText(String.valueOf(holder.num_cart));
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
                        activity.runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(activity, "Added to cart.", Toast.LENGTH_LONG).show();
                                holder.num_cart = Integer.parseInt(MainActivity.num_cart.getText().toString()) + 1;
                                MainActivity.num_cart.setText(String.valueOf(holder.num_cart));
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

    private static class ViewHolder {
        public String product_id;
        public ImageView product_image;
        public TextView product_name;
        public TextView product_price;
        public Button add_to_cart_btn;
        public TextView shop_name;
        public int num_cart;
    }
}
