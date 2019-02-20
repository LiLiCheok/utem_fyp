package com.buyme.PopActivity;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

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
 * Created by ll_cheok on 8/6/2016.
 */
public class CheckoutActivity extends AppCompatActivity implements View.OnClickListener {

    Button order_btn, cancel_order_btn;
    TextView order_total;

    String login_id = MainActivity.login_id;
    String ototal;

    ArrayList<SpecificOrder> specificOrders;
    ArrayAdapter soadapter;
    ListView solist;

    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    @Override
    public void onBackPressed() {}

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_checkout);

        ototal = getIntent().getExtras().getString("order_total");

        order_btn = (Button) findViewById(R.id.order_btn);
        cancel_order_btn = (Button) findViewById(R.id.co_btn);
        order_total = (TextView) findViewById(R.id.co_gtotal);
        order_total.setText(ototal);
        order_btn.setOnClickListener(this);
        cancel_order_btn.setOnClickListener(this);

        specificOrders = new ArrayList<SpecificOrder>();
        solist = (ListView) findViewById(R.id.co_sshop);
        getCurrentCart();
    }

    private void getCurrentCart() {
        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> param = new ArrayList<NameValuePair>();
                param.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnGetCurrentCart));
                param.add(new BasicNameValuePair("user_id", login_id));
                try {
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, param);
                    JSONArray data = jsnObj.getJSONArray("data");
                    if(data.length()==0) {

                    } else {
                        for (int index = 0; index < data.length(); index++) {
                            SpecificOrder so = new SpecificOrder();
                            JSONObject obj = data.getJSONObject(index);
                            so.setProductName(obj.optString("product_name"));
                            so.setQuantity(obj.optString("quantity"));
                            so.setSubtotal(obj.optString("subtotal"));
                            so.setChosenDelivery(obj.optString("del_charge"));
                            so.setStatus("");
                            specificOrders.add(so);
                        }
                        runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                soadapter = new SpecificOrderAdapter(CheckoutActivity.this, getApplicationContext(), R.layout.specific_order, specificOrders);
                                solist.setAdapter(soadapter);
                                soadapter.notifyDataSetChanged();
                            }
                        });
                    }
                } catch(Exception e) {
                    Log.d("GetSpecificOrder", "Error!");
                }
            }
        };
        Thread thr = new Thread(run);
        thr.start();
    }

    @Override
    public void onClick(View view) {
        if(view.getId()==R.id.order_btn) {
            Runnable run = new Runnable() {
                @Override
                public void run() {
                    final List<NameValuePair> param = new ArrayList<NameValuePair>();
                    param.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnCheckAddress));
                    param.add(new BasicNameValuePair("user_id", login_id));
                    try {
                        String result = "yes";
                        String result1 = "no";
                        jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, param);
                        if(result.equals(jsnObj.optString("yes"))) {
                            runOnUiThread(new Runnable() {
                                @Override
                                public void run() {
                                    AlertDialog.Builder builder;
                                    AlertDialog alert;
                                    builder = new AlertDialog.Builder(CheckoutActivity.this);

                                    builder.setTitle("Confirm Order?");
                                    builder.setMessage("Are you sure you want to order those items?");

                                    builder.setPositiveButton("Yes",new DialogInterface.OnClickListener() {

                                        @Override
                                        public void onClick(DialogInterface dialog, int which) {
                                            confirmOrder();
                                        }

                                    });

                                    builder.setNegativeButton("No",new DialogInterface.OnClickListener() {

                                        @Override
                                        public void onClick(DialogInterface dialog, int which) {
                                            dialog.cancel();
                                        }
                                    });

                                    alert = builder.create();
                                    alert.show();
                                }
                            });
                        } else if(result1.equals(jsnObj.optString("no"))) {
                            runOnUiThread(new Runnable() {
                                @Override
                                public void run() {
                                    CheckoutActivity.this.finish();
                                    Intent intent = new Intent(CheckoutActivity.this, RegisterAddressActivity.class);
                                    Bundle args = new Bundle();
                                    args.putString("order_total", order_total.getText().toString());
                                    intent.putExtras(args);
                                    intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
                                    startActivity(intent);
                                }
                            });
                        } else {}
                    } catch (Exception e) {
                        Log.d("UpdateAddress", "Error!");
                    }
                }
            };

            Thread thr = new Thread(run);
            thr.start();
        }
        if(view.getId()==R.id.co_btn) {
            CheckoutActivity.this.finish();
            Intent intent = new Intent(CheckoutActivity.this, MainActivity.class);
            String openCart = "openCart";
            Bundle args = new Bundle();
            args.putString("openCart", openCart);
            intent.putExtras(args);
            startActivity(intent);
        }
    }

    private void confirmOrder() {
        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> param = new ArrayList<NameValuePair>();
                param.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnCreateOrder));
                param.add(new BasicNameValuePair("user_id", login_id));
                param.add(new BasicNameValuePair("order_total", order_total.getText().toString()));
                try {
                    String result = "sent";
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, param);
                    if(result.equals(jsnObj.optString("sent"))) {
                        runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(CheckoutActivity.this, "Your order has been sent. Please check in 'My Order' for more details.", Toast.LENGTH_LONG).show();
                                CheckoutActivity.this.finish();
                                Intent intent = new Intent(CheckoutActivity.this, MainActivity.class);
                                String openOrder = "openOrder";
                                Bundle args = new Bundle();
                                args.putString("openOrder", openOrder);
                                intent.putExtras(args);
                                startActivity(intent);
                            }
                        });
                    } else {}
                } catch (Exception e) {
                    Log.d("CreateOrder", "Error!");
                }
            }
        };

        Thread thr = new Thread(run);
        thr.start();
    }
}
