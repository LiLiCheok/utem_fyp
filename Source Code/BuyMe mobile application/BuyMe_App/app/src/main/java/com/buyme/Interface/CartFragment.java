package com.buyme.Interface;


import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentTransaction;
import android.util.Base64;
import android.util.Log;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.buyme.Adapter.CartAdapter;
import com.buyme.Adapter.ProductAdapter;
import com.buyme.DatabaseController.WebServiceCall;
import com.buyme.GetterSetterClass.Cart;
import com.buyme.PopActivity.CheckoutActivity;
import com.buyme.PopActivity.UpdateCartActivity;
import com.buyme.PopActivity.UpdateEmailActivity;
import com.buyme.R;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONObject;

import java.lang.reflect.Array;
import java.util.ArrayList;
import java.util.List;

/**
 * A simple {@link Fragment} subclass.
 */
public class CartFragment extends Fragment implements View.OnClickListener {

    View v;
    Button cshop_now_btn, checkout_btn;
    LinearLayout cart_layout, no_cart_layout;
    TextView num_cart, cart_total;
    double total = 0.00, st=0.00, c=0.00, subtotal=0.00;

    ListView cart_list;
    ArrayList<Cart> carts;
    CartAdapter cartAdapter;
    String login_user_id = MainActivity.login_id;

    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    public CartFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        getActivity().setTitle("My Cart");

        // Inflate the layout for this fragment
        v = inflater.inflate(R.layout.fragment_cart, container, false);

        cshop_now_btn = (Button) v.findViewById(R.id.cshop_now_btn);
        cart_layout = (LinearLayout) v.findViewById(R.id.cart_layout);
        no_cart_layout = (LinearLayout) v.findViewById(R.id.no_cart_layout);
        num_cart = (TextView) v.findViewById(R.id.num_cart);
        cart_total = (TextView) v.findViewById(R.id.cart_total);
        checkout_btn = (Button) v.findViewById(R.id.checkout_btn);

        cshop_now_btn.setOnClickListener(this);
        checkout_btn.setOnClickListener(this);

        cart_list = (ListView) v.findViewById(R.id.cart_list);
        carts = new ArrayList<Cart>();

        getCartNo(login_user_id);
        getCart(login_user_id);

        return v;
    }

    private void getCart(final String login_user_id) {
        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnGetCart));
                params1.add(new BasicNameValuePair("user_id", login_user_id));
                try {
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    JSONArray data = jsnObj.getJSONArray("data");
                    if(data.length()==0) {
                        getActivity().runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                no_cart_layout.setVisibility(LinearLayout.VISIBLE);
                            }
                        });
                    } else {
                        for (int index = 0; index < data.length(); index++) {
                            Cart cart = new Cart();
                            JSONObject obj = data.getJSONObject(index);
                            cart.setCartID(obj.optString("cart_id"));
                            cart.setProductID(obj.optString("product_id"));
                            cart.setProductName(obj.optString("product_name"));
                            final String encodedString1 = obj.getString("product_image");
                            final String pureBase64Encoded1 =
                                    encodedString1.substring(encodedString1.indexOf(",") + 1);
                            final byte[] decodedBytes1 =
                                    Base64.decode(pureBase64Encoded1, Base64.DEFAULT);
                            Bitmap decodedBitmap1 =
                                    BitmapFactory.decodeByteArray(decodedBytes1, 0, decodedBytes1.length);
                            int h1 = 300; // height in pixels
                            int w1 = 300; // width in pixels
                            Bitmap photoBitMap1 = Bitmap.createScaledBitmap(decodedBitmap1, h1, w1, true);
                            cart.setProductImage(photoBitMap1);
                            cart.setProductPrice(obj.optString("product_price"));
                            cart.setQuantity(obj.optString("quantity"));
                            cart.setSubtotal(obj.optString("subtotal"));
                            cart.setDelCharge(obj.optString("del_charge"));
                            cart.setShopID(obj.optString("shop_id"));
                            cart.setShopName(obj.optString("shop_name"));
                            cart.setDeliveryService(obj.optString("delivery_service"));
                            cart.setDeliveryInfo(obj.optString("delivery_info"));
                            carts.add(cart);
                        }
                        getActivity().runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                if(carts.size()>0) {
                                    for(int i=0; i<carts.size(); i++) {
                                        if(carts.get(i).getDelCharge().equals("null")) {
                                            subtotal = Double.parseDouble(carts.get(i).getSubtotal());
                                        } else {
                                            st = Double.parseDouble(carts.get(i).getSubtotal());
                                            c = Double.parseDouble(carts.get(i).getDelCharge());
                                            subtotal = st+(st*c/100);
                                        }
                                        total += subtotal;
                                        cart_layout.setVisibility(LinearLayout.VISIBLE);
                                        cartAdapter = new CartAdapter(getActivity(), getActivity().getApplicationContext(), R.layout.cart_list, carts);
                                        cart_list.setAdapter(cartAdapter);
                                        cart_list.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                                            @Override
                                            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                                                Intent intent = new Intent(getActivity(), UpdateCartActivity.class);
                                                Bundle args = new Bundle();
                                                args.putString("cart_id", carts.get(i).getCartID().toString());
                                                args.putString("product_id", carts.get(i).getProductID());
                                                args.putString("product_name", carts.get(i).getProductName());
                                                args.putParcelable("product_image", carts.get(i).getProductImage());
                                                args.putString("product_price", carts.get(i).getProductPrice());
                                                args.putString("quantity", carts.get(i).getQuantity());
                                                args.putString("subtotal", carts.get(i).getSubtotal());
                                                args.putString("shop_id", carts.get(i).getShopID());
                                                args.putString("shop_name", carts.get(i).getShopName());
                                                args.putString("del_charge", carts.get(i).getDelCharge());
                                                args.putString("delivery_service", carts.get(i).getDeliveryService());
                                                args.putString("delivery_info", carts.get(i).getDeliveryInfo());
                                                intent.putExtras(args);
                                                intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
                                                startActivity(intent);
                                                getActivity().finish();
                                            }
                                        });
                                        cart_total.setText(String.format("%.2f", total));
                                        cartAdapter.notifyDataSetChanged();
                                    }
                                } else {}
                            }
                        });
                    }
                } catch (Exception e) {
                    e.printStackTrace();
                    Log.d("GetCart", "Error!");
                }
            }
        };

        Thread thr = new Thread(run);
        thr.start();
    }

    private void getCartNo(final String login_user_id) {
        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnGetCartOrderNo));
                params1.add(new BasicNameValuePair("user_id", login_user_id));
                try {
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    final String cart_num = jsnObj.optString("num_cart");
                    getActivity().runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            if(jsnObj.optString("num_cart").equals("1")) {
                                num_cart.setText(cart_num + " item is added.");
                            } else {
                                num_cart.setText(jsnObj.optString("num_cart") + " items is added.");
                            }
                        }
                    });
                } catch (Exception e) {
                    e.printStackTrace();
                    Log.d("GetCartOrderNo", "Error!");
                }
            }
        };
        Thread thr = new Thread(run);
        thr.start();
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

    @Override
    public void onClick(View view) {
        if(view.getId()==R.id.cshop_now_btn) {
            Fragment newFragment = new HomeFragment();
            FragmentTransaction transaction =
                    getFragmentManager().beginTransaction();
            transaction.replace(R.id.fragment_container, newFragment);
            transaction.addToBackStack(null);
            transaction.commit();
        }
        if(view.getId()==R.id.checkout_btn) {
            Intent intent = new Intent(getActivity(), CheckoutActivity.class);
            Bundle args = new Bundle();
            args.putString("order_total", cart_total.getText().toString());
            intent.putExtras(args);
            intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
            getActivity().finish();
        }
    }
}