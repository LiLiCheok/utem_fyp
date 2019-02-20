package com.buyme.PopActivity;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.graphics.PorterDuff;
import android.media.Image;
import android.os.Bundle;
import android.os.Handler;
import android.support.annotation.CheckResult;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.buyme.DatabaseController.WebServiceCall;
import com.buyme.Interface.MainActivity;
import com.buyme.R;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;
import org.w3c.dom.Text;

import java.util.ArrayList;
import java.util.List;
import java.util.jar.Attributes;

/**
 * Created by ll_cheok on 7/29/2016.
 */
public class UpdateCartActivity extends AppCompatActivity implements View.OnClickListener, TextWatcher, CompoundButton.OnCheckedChangeListener {

    Button update_order_btn, plus_btn, minus_btn;
    CheckBox pchoosedelivery;
    EditText pquantity;
    ImageView pimage;
    LinearLayout checkeddelivery;
    TextView pid, pname, pprice, sname, dservice, psubtotal;
    TextView total_pross1, total_pross2, cp_pluscharge;
    LinearLayout total_pro_same_shop;

    Double sub = 0.00;
    Double unit_price = 0.00;
    int qty = 0;
    String item_total, product_name, cart_id, product_id, product_price, shop_id;
    String shop_name, del_charge, delivery_service, delivery_info, quantity, subtotal, total_order, delcharge;
    Bitmap product_image;

    String login_user_id = MainActivity.login_id;

    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    @Override
    public void onBackPressed() {

    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_update_cart);

        // Get variables from cart fragment
        cart_id = getIntent().getExtras().getString("cart_id");
        product_id = getIntent().getExtras().getString("product_id");
        product_name = getIntent().getExtras().getString("product_name");
        product_image = getIntent().getExtras().getParcelable("product_image");
        product_price = getIntent().getExtras().getString("product_price");
        quantity = getIntent().getExtras().getString("quantity");
        subtotal = getIntent().getExtras().getString("subtotal");
        shop_id = getIntent().getExtras().getString("shop_id");
        shop_name = getIntent().getExtras().getString("shop_name");
        del_charge = getIntent().getExtras().getString("del_charge");
        delivery_service = getIntent().getExtras().getString("delivery_service");
        delivery_info = getIntent().getExtras().getString("delivery_info");

        // Set variables
        plus_btn = (Button) findViewById(R.id.plus_btn);
        minus_btn = (Button) findViewById(R.id.minus_btn);
        update_order_btn = (Button) findViewById(R.id.update_order_btn);
        pchoosedelivery = (CheckBox) findViewById(R.id.sp_checkdelivery);
        pimage = (ImageView) findViewById(R.id.cp_image);
        pid = (TextView) findViewById(R.id.cp_id);
        pname = (TextView) findViewById(R.id.cp_name);
        pprice = (TextView) findViewById(R.id.cp_price);
        pquantity = (EditText) findViewById(R.id.cp_quantity);
        psubtotal = (TextView) findViewById(R.id.cp_subtotal);
        sname = (TextView) findViewById(R.id.cp_sname);
        dservice = (TextView) findViewById(R.id.cp_sdeliveryinfo);
        total_pro_same_shop = (LinearLayout) findViewById(R.id.to_ss);
        checkeddelivery = (LinearLayout) findViewById(R.id.show_delivery_layout);
        total_pross1 = (TextView) findViewById(R.id.total_pross1);
        total_pross2 = (TextView) findViewById(R.id.total_pross2);
        cp_pluscharge = (TextView) findViewById(R.id.cp_pluscharge);

        pimage.setImageBitmap(product_image);
        pname.setText(product_name);
        pid.setText(product_id);
        pprice.setText(product_price);
        sname.setText(shop_name);
        pquantity.setText(quantity);
        psubtotal.setText(subtotal);

        if(delivery_service.equals("yes")) {
            checkeddelivery.setVisibility(LinearLayout.VISIBLE);
            total_pro_same_shop.setVisibility(LinearLayout.VISIBLE);
            dservice.setText(delivery_info);
        } else {
            dservice.setText("No delivery service.");
        }

        if(delivery_info.equals("")) {

        } else {
            item_total = delivery_info.substring(delivery_info.indexOf("RM")+2, delivery_info.indexOf(" and"));
            getTotalOrderFromShop();
        }

        if(del_charge.equals("null")) {
            pchoosedelivery.setChecked(false);
        } else {
            pchoosedelivery.setChecked(true);
            psubtotal.setText(subtotal + "+" + del_charge + "%");
        }

        plus_btn.setOnClickListener(this);
        minus_btn.setOnClickListener(this);
        update_order_btn.setOnClickListener(this);
        pquantity.addTextChangedListener(this);
        pchoosedelivery.setOnCheckedChangeListener(this);
    }

    private void getTotalOrderFromShop() {
        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnGetTotalOrderFromShop));
                params1.add(new BasicNameValuePair("user_id", login_user_id));
                params1.add(new BasicNameValuePair("shop_id", shop_id));
                try {
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    total_order = jsnObj.optString("total_order");
                    runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            total_pross1.setText("*** Total amount that ordered from " + shop_name + " : ***");
                            if(total_order.equals("null")) {
                                total_pross2.setText(total_order);
                            } else {
                                if (Double.parseDouble(total_order) >= Double.parseDouble(item_total.trim())) {
                                    pchoosedelivery.setEnabled(true);
                                    pchoosedelivery.setText("Yes, I want delivery service.");
                                } else {
                                    pchoosedelivery.setEnabled(false);
                                    pchoosedelivery.setText("Your total quantity of items in " + shop_name + " is not enough for delivery.");
                                    if(pchoosedelivery.isChecked()) {
                                        pchoosedelivery.setChecked(false);
                                    } else {}
                                }
                                total_pross2.setText(total_order);
                            }
                        }
                    });
                } catch (Exception e) {
                    e.printStackTrace();
                    Log.d("GetTotalOrderFromShop", "Error!");
                }
            }
        };
        Thread thr = new Thread(run);
        thr.start();
    }

    @Override
    public void onClick(View view) {
        if(view.getId()==R.id.plus_btn) {
            int qty = Integer.parseInt(pquantity.getText().toString());
            qty+=1;
            pquantity.setText(String.valueOf(qty));
        }
        if(view.getId()==R.id.minus_btn) {
            int qty = Integer.parseInt(pquantity.getText().toString());
            qty -= 1;
            if(qty==0) {
                pquantity.getBackground().setColorFilter(getResources().getColor(R.color.colorWrong), PorterDuff.Mode.SRC_IN);
                qty=1;
                pquantity.setText(String.valueOf(qty));
            } else {
                pquantity.setText(String.valueOf(qty));
            }
        }
        if(view.getId()==R.id.update_order_btn) {
            if(pquantity.getText().equals("0")) {
                pquantity.getBackground().setColorFilter(getResources().getColor(R.color.colorWrong), PorterDuff.Mode.SRC_IN);
            } else {
                pquantity.getBackground().clearColorFilter();
                if(pchoosedelivery.isChecked()) {
                    String dc = delivery_info.substring(0, delivery_info.indexOf("delivery"));
                    if(dc.trim().equals("Free")) {
                        delcharge="0";
                    } else {
                        String dc1 = delivery_info.substring(0, delivery_info.indexOf("%"));
                        delcharge=dc1;
                    }
                } else {
                    delcharge="";
                }
                Runnable run = new Runnable() {
                    @Override
                    public void run() {
                        final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                        params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnUpdateCart));
                        params1.add(new BasicNameValuePair("cart_id", cart_id));
                        params1.add(new BasicNameValuePair("user_id", login_user_id));
                        params1.add(new BasicNameValuePair("shop_id", shop_id));
                        params1.add(new BasicNameValuePair("quantity", pquantity.getText().toString()));
                        params1.add(new BasicNameValuePair("subtotal", psubtotal.getText().toString()));
                        params1.add(new BasicNameValuePair("del_charge", delcharge));
                        try {
                            String result="updated";
                            jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                            if (result.equals(jsnObj.optString("result"))) {
                                runOnUiThread(new Runnable() {
                                    @Override
                                    public void run() {
                                        Toast.makeText(UpdateCartActivity.this, "Updated", Toast.LENGTH_LONG).show();
                                        UpdateCartActivity.this.finish();
                                        Intent intent = new Intent(UpdateCartActivity.this, MainActivity.class);
                                        String openCart = "openCart";
                                        Bundle args = new Bundle();
                                        args.putString("openCart", openCart);
                                        intent.putExtras(args);
                                        startActivity(intent);
                                    }
                                });
                            }
                        } catch (Exception e) {
                            e.printStackTrace();
                            Log.d("UpdateCart", "Error!");
                        }
                    }
                };
                Thread thr = new Thread(run);
                thr.start();
            }
        }
    }

    @Override
    public void beforeTextChanged(CharSequence charSequence, int start, int before, int count) {}

    @Override
    public void onTextChanged(CharSequence charSequence, int start, int before, int count) {
        if(pquantity.length()>0) {
            pquantity.getBackground().clearColorFilter();
            unit_price = Double.parseDouble(pprice.getText().toString());
            qty = Integer.parseInt(pquantity.getText().toString());
            sub = unit_price * qty;
        } else {
            pquantity.getBackground().setColorFilter(getResources().getColor(R.color.colorWrong), PorterDuff.Mode.SRC_IN);
        }
    }

    @Override
    public void afterTextChanged(Editable editable) {
        if (pquantity.length() > 0) {
            psubtotal.setText(String.format("%.2f", sub));
            Runnable run = new Runnable() {
                @Override
                public void run() {
                    final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                    params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnUpdateQuantity));
                    params1.add(new BasicNameValuePair("product_id", product_id));
                    params1.add(new BasicNameValuePair("cart_id", cart_id));
                    params1.add(new BasicNameValuePair("quantity", pquantity.getText().toString()));
                    params1.add(new BasicNameValuePair("product_price", pprice.getText().toString()));
                    try {
                        String result = "ordered";
                        jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                        if (result.equals(jsnObj.optString("result"))) {
                            runOnUiThread(new Runnable() {
                                @Override
                                public void run() {
                                    final int intervalTime = 3000; // 3 sec
                                    Handler handler = new Handler();
                                    handler.postDelayed(new Runnable() {
                                        @Override
                                        public void run() {
                                            Intent intent = new Intent(UpdateCartActivity.this, UpdateCartActivity.class);
                                            Bundle args = new Bundle();
                                            args.putString("cart_id", cart_id);
                                            args.putString("product_id", product_id);
                                            args.putString("product_name", product_name);
                                            args.putParcelable("product_image", product_image);
                                            args.putString("product_price", product_price);
                                            args.putString("quantity", pquantity.getText().toString());
                                            args.putString("subtotal", psubtotal.getText().toString());
                                            args.putString("shop_id", shop_id);
                                            args.putString("shop_name", shop_name);
                                            args.putString("del_charge", del_charge);
                                            args.putString("delivery_service", delivery_service);
                                            args.putString("delivery_info", delivery_info);
                                            intent.putExtras(args);
                                            intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
                                            startActivity(intent);
                                            UpdateCartActivity.this.finish();
                                        }
                                    }, intervalTime);
                                }
                            });
                        } else {
                        }
                    } catch (Exception e) {
                        e.printStackTrace();
                        Log.d("UpdateQuantity", "Error!");
                    }
                }
            };
            Thread thr = new Thread(run);
            thr.start();
        } else {}
    }

    @Override
    public void onCheckedChanged(CompoundButton compoundButton, boolean b) {
        if(pchoosedelivery.isChecked()) {
            cp_pluscharge.setVisibility(View.VISIBLE);
            if(del_charge.equals("null")) {
                if(delivery_info.equals("")) {
                    cp_pluscharge.setVisibility(View.GONE);
                } else {
                    String dc = delivery_info.substring(0, delivery_info.indexOf("delivery"));
                    if(dc.trim().equals("Free")) {
                        cp_pluscharge.setText("+ 0%");
                    } else {
                        String dc1 = delivery_info.substring(0, delivery_info.indexOf("%"));
                        cp_pluscharge.setText("+ "+dc1+"%");
                    }
                }
            } else {
                cp_pluscharge.setText("+ "+del_charge+"%");
            }
        } else {
            cp_pluscharge.setVisibility(View.GONE);
        }
    }
}
