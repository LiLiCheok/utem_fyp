package com.buyme.Adapter;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.buyme.DatabaseController.WebServiceCall;
import com.buyme.GetterSetterClass.Cart;
import com.buyme.Interface.HomeFragment;
import com.buyme.Interface.MainActivity;
import com.buyme.R;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by ll_cheok on 7/28/2016.
 */
public class CartAdapter extends ArrayAdapter<Cart> {

    private ArrayList<Cart> carts;
    private LayoutInflater li;
    int Resource;
    private ViewHolder holder;

    String login_id = MainActivity.login_id;

    Activity activity;
    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    public CartAdapter(Activity activity, Context context, int resource, ArrayList<Cart> objects) {
        super(context, resource, objects);
        this.activity = activity;
        li = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        Resource = resource;
        carts = objects;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {

        if(convertView == null) {

            convertView = li.inflate(Resource, null);

            holder = new ViewHolder();
            holder.shop_name = (TextView) convertView.findViewById(R.id.cshop_name);
            holder.product_image = (ImageView) convertView.findViewById(R.id.cproduct_image);
            holder.product_name = (TextView) convertView.findViewById(R.id.cproduct_name);
            holder.product_price = (TextView) convertView.findViewById(R.id.cproduct_price);
            holder.quantity = (TextView) convertView.findViewById(R.id.cquantity);
            holder.subtotal = (TextView) convertView.findViewById(R.id.csubtotal);
            holder.delete_cart_btn = (ImageView) convertView.findViewById(R.id.delete_cart_btn);
            holder.delete_cart_btn.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    int pos = (Integer)view.getTag();
                    Cart c = carts.get(pos);
                    String id = c.getProductID();
                    String id1 = c.getShopID();
                    String info = c.getDeliveryInfo();
                    String info1="";
                    if(info.equals("")) {
                        info1="";
                    } else {
                        info1 = info.substring(info.indexOf("RM") + 2, info.indexOf(" and"));
                    }
                    deleteCart(id, id1, info1);
                }
            });
            holder.delivery_layout = (LinearLayout) convertView.findViewById(R.id.delivery_layout);

            convertView.setTag(holder);

        } else {
            holder = (ViewHolder) convertView.getTag();
        }

        Cart c = carts.get(position);
        holder.delivery_info = c.getDeliveryInfo();
        holder.shop_id = c.getShopID();
        holder.cart_id = c.getCartID();
        holder.product_id = c.getProductID();
        holder.shop_name.setText(c.getShopName());
        holder.product_image.setImageBitmap(c.getProductImage());
        holder.product_name.setText(c.getProductName().toString());
        holder.product_price.setText(c.getProductPrice().toString());
        holder.quantity.setText(c.getQuantity());
        holder.delete_cart_btn.setTag(position);
        holder.num_cart = 0;
        if(c.getDelCharge().equals("null")) {
            holder.subtotal.setText(c.getSubtotal());
            holder.delivery_layout.setVisibility(LinearLayout.GONE);
        } else {
            holder.subtotal.setText(c.getSubtotal()+" + "+c.getDelCharge()+"%");
            holder.delivery_layout.setVisibility(LinearLayout.VISIBLE);
        }

        return convertView;
    }

    private void deleteCart(final String id, final String id1, final String info1) {
        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnDeleteCart));
                params1.add(new BasicNameValuePair("user_id", login_id));
                params1.add(new BasicNameValuePair("product_id", id));
                params1.add(new BasicNameValuePair("shop_id", id1));
                params1.add(new BasicNameValuePair("shop_item", info1));
                try {
                    final String result="deleted";
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    activity.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            if(jsnObj.optString("result").equals(result)) {
                                activity.finish();
                                Intent intent = new Intent(activity, MainActivity.class);
                                String openCart = "openCart";
                                Bundle args = new Bundle();
                                args.putString("openCart", openCart);
                                intent.putExtras(args);
                                activity.startActivity(intent);
                                holder.num_cart = Integer.parseInt(MainActivity.num_cart.getText().toString()) - 1;
                                MainActivity.num_cart.setText(String.valueOf(holder.num_cart));
                            } else {}
                        }
                    });
                } catch (Exception e) {
                    e.printStackTrace();
                    Log.d("DeleteCart", "Error!");
                }
            }
        };

        Thread thr = new Thread(run);
        thr.start();
    }

    private static class ViewHolder {
        public String delivery_info;
        public String shop_id;
        public String cart_id;
        public String product_id;
        public ImageView product_image;
        public TextView product_name;
        public TextView product_price;
        public TextView quantity;
        public TextView subtotal;
        public ImageView delete_cart_btn;
        public int num_cart;
        public LinearLayout delivery_layout;
        public TextView shop_name;
    }
}

