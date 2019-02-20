package com.buyme.PopActivity;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.TextView;

import com.buyme.Adapter.SpecificOrderAdapter;
import com.buyme.DatabaseController.WebServiceCall;
import com.buyme.GetterSetterClass.SpecificOrder;
import com.buyme.Interface.MainActivity;
import com.buyme.R;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by ll_cheok on 7/29/2016.
 */
public class ViewOrderActivity extends AppCompatActivity implements AdapterView.OnItemSelectedListener {

    TextView so_id, so_time, shop_total;
    Spinner spinner_shop;

    Double subtotal = 0.00;
    Double total = 0.00;
    String login_user_id = MainActivity.login_id;
    public static String order_id;
    String order_time, order_total, shop_name;
    ArrayList<SpecificOrder> specificOrders;
    ArrayAdapter soadapter;
    ListView solist;
    ArrayList<String> shops;
    ArrayAdapter adapter;

    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    @Override
    public void onBackPressed() {
        ViewOrderActivity.this.finish();
        Intent intent = new Intent(ViewOrderActivity.this, MainActivity.class);
        String openOrder = "openOrder";
        Bundle args = new Bundle();
        args.putString("openOrder", openOrder);
        intent.putExtras(args);
        intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
        startActivity(intent);
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_order);

        so_id = (TextView) findViewById(R.id.so_id);
        so_time = (TextView) findViewById(R.id.so_time);
        shop_total = (TextView) findViewById(R.id.shop_total);
        spinner_shop = (Spinner) findViewById(R.id.spinner_shop);

        order_id = getIntent().getExtras().getString("order_id");
        order_time = getIntent().getExtras().getString("order_time");
        order_total = getIntent().getExtras().getString("order_total");

        so_id.setText(order_id);
        so_time.setText(order_time);

        shops = new ArrayList<String>();
        getShops();

        specificOrders = new ArrayList<SpecificOrder>();
        solist = (ListView) findViewById(R.id.specific_order);

        spinner_shop.setOnItemSelectedListener(this);
    }

    private void getShops() {
        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnOrderFrom));
                params1.add(new BasicNameValuePair("user_id", login_user_id));
                params1.add(new BasicNameValuePair("order_id", order_id));
                try {
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    JSONArray data = jsnObj.getJSONArray("data");
                    shops.add("-- Reviewing receipt according shop --");
                    for(int index=0; index<data.length(); index++) {
                        JSONObject obj = data.getJSONObject(index);
                        shops.add(obj.optString("shop_name").trim());
                    }
                } catch (Exception e) {
                    e.printStackTrace();
                    Log.d("OrderFrom", "Error!");
                }
                runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        adapter = new ArrayAdapter(ViewOrderActivity.this, android.R.layout.simple_dropdown_item_1line, shops);
                        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                        spinner_shop.setAdapter(adapter);
                    }
                });
            }
        };
        Thread thread = new Thread(run);
        thread.start();
    }

    @Override
    public void onItemSelected(final AdapterView<?> adapterView, View view, final int i, long l) {
        shop_name = spinner_shop.getSelectedItem().toString();
        if (specificOrders.size() > 0) {
            runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    soadapter.clear();
                    solist.setAdapter(null);
                    subtotal=0.00;
                    total=0.00;
                    shop_total.setText("");
                    if(solist.getAdapter()==null) {
                        show();
                    }
                }
            });
        } else {
            show();
        }
//            Runnable run = new Runnable() {
//                @Override
//                public void run() {
//                    final List<NameValuePair> param = new ArrayList<NameValuePair>();
//                    param.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnGetSpecificShop));
//                    param.add(new BasicNameValuePair("user_id", login_user_id));
//                    param.add(new BasicNameValuePair("order_id", order_id));
//                    param.add(new BasicNameValuePair("shop_name", shop_name));
//                    try {
//                        jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, param);
//                        JSONArray data = jsnObj.getJSONArray("data");
//                        if (data.length() == 0) {
//
//                        } else {
//                            for (int index = 0; index < data.length(); index++) {
//                                SpecificOrder so = new SpecificOrder();
//                                JSONObject obj = data.getJSONObject(index);
//                                so.setProductName(obj.optString("product_name"));
//                                so.setQuantity(obj.optString("quantity"));
//                                so.setSubtotal(obj.optString("subtotal"));
//                                so.setChosenDelivery(obj.optString("del_charge"));
//                                so.setStatus(obj.optString("status"));
//                                specificOrders.add(so);
//                            }
//                            runOnUiThread(new Runnable() {
//                                @Override
//                                public void run() {
//                                    for (int i = 0; i < specificOrders.size(); i++) {
//                                        if (specificOrders.get(i).getChosenDelivery().equals("null")) {
//                                            subtotal = (Double.parseDouble(specificOrders.get(i).getSubtotal()));
//                                        } else {
//                                            subtotal = (Double.parseDouble(specificOrders.get(i).getSubtotal())) +
//                                                    ((Double.parseDouble(specificOrders.get(i).getSubtotal())) *
//                                                            (Double.parseDouble(specificOrders.get(i).getChosenDelivery())) / 100);
//                                        }
//                                        total += subtotal;
//                                    }
//                                    shop_total.setText(String.format("%.2f", total));
//                                    soadapter = new SpecificOrderAdapter(ViewOrderActivity.this, getApplicationContext(), R.layout.specific_order, specificOrders);
//                                    solist.setAdapter(soadapter);
//                                    soadapter.notifyDataSetChanged();
//                                }
//                            });
//                        }
//                    } catch (Exception e) {
//                        Log.d("GetSpecificShop", "Error!");
//                    }
//                }
//            };
//            Thread thr = new Thread(run);
//            thr.start();
//        }
    }

    private void show() {
        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> param = new ArrayList<NameValuePair>();
                param.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnGetSpecificShop));
                param.add(new BasicNameValuePair("user_id", login_user_id));
                param.add(new BasicNameValuePair("order_id", order_id));
                param.add(new BasicNameValuePair("shop_name", shop_name));
                try {
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, param);
                    JSONArray data = jsnObj.getJSONArray("data");
                    if (data.length() == 0) {

                    } else {
                        for (int index = 0; index < data.length(); index++) {
                            SpecificOrder so = new SpecificOrder();
                            JSONObject obj = data.getJSONObject(index);
                            so.setProductName(obj.optString("product_name"));
                            so.setQuantity(obj.optString("quantity"));
                            so.setSubtotal(obj.optString("subtotal"));
                            so.setChosenDelivery(obj.optString("del_charge"));
                            so.setStatus(obj.optString("status"));
                            specificOrders.add(so);
                        }
                        runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                for (int i = 0; i < specificOrders.size(); i++) {
                                    if (specificOrders.get(i).getChosenDelivery().equals("null")) {
                                        subtotal = (Double.parseDouble(specificOrders.get(i).getSubtotal()));
                                    } else {
                                        subtotal = (Double.parseDouble(specificOrders.get(i).getSubtotal())) +
                                                ((Double.parseDouble(specificOrders.get(i).getSubtotal())) *
                                                        (Double.parseDouble(specificOrders.get(i).getChosenDelivery())) / 100);
                                    }
                                    total += subtotal;
                                }
                                shop_total.setText(String.format("%.2f", total));
                                soadapter = new SpecificOrderAdapter(ViewOrderActivity.this, getApplicationContext(), R.layout.specific_order, specificOrders);
                                solist.setAdapter(soadapter);
                                soadapter.notifyDataSetChanged();
                            }
                        });
                    }
                } catch (Exception e) {
                    Log.d("GetSpecificShop", "Error!");
                }
            }
        };
        Thread thr = new Thread(run);
        thr.start();
    }

    @Override
    public void onNothingSelected(AdapterView<?> adapterView) {}
}
