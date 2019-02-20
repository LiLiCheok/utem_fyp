package com.buyme.PopActivity;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.buyme.DatabaseController.WebServiceCall;
import com.buyme.Interface.MainActivity;
import com.buyme.R;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by ll_cheok on 8/6/2016.
 */
public class RegisterAddressActivity extends AppCompatActivity implements View.OnClickListener {

    Button update_address_btn, cancel_update_btn;
    EditText address, postcode, city, state;

    String login_id = MainActivity.login_id;
    String ototal;

    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    @Override
    public void onBackPressed() {}

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register_address);

        ototal = getIntent().getExtras().getString("order_total");

        update_address_btn = (Button) findViewById(R.id.update_address_btn);
        cancel_update_btn = (Button) findViewById(R.id.cancel_update_btn);
        address = (EditText) findViewById(R.id.update_address);
        postcode = (EditText) findViewById(R.id.update_postcode);
        city = (EditText) findViewById(R.id.update_city);
        state = (EditText) findViewById(R.id.update_state);
        update_address_btn.setOnClickListener(this);
        cancel_update_btn.setOnClickListener(this);
    }

    @Override
    public void onClick(View view) {
        if(view.getId()==R.id.update_address_btn) {
            if(address.getText().equals("")||postcode.getText().equals("")||city.getText().equals("")||state.getText().equals("")) {
                Toast.makeText(RegisterAddressActivity.this, "Please fill in the required information", Toast.LENGTH_LONG).show();
            } else {
                Runnable run = new Runnable() {
                    @Override
                    public void run() {
                        final List<NameValuePair> param = new ArrayList<NameValuePair>();
                        param.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnUpdateAddress));
                        param.add(new BasicNameValuePair("user_id", login_id));
                        param.add(new BasicNameValuePair("address", address.getText().toString()));
                        param.add(new BasicNameValuePair("postcode", postcode.getText().toString()));
                        param.add(new BasicNameValuePair("city", city.getText().toString()));
                        param.add(new BasicNameValuePair("state", state.getText().toString()));
                        try {
                            String result = "updated";
                            jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, param);
                            if(result.equals(jsnObj.optString("updated"))) {
                                runOnUiThread(new Runnable() {
                                    @Override
                                    public void run() {
                                        RegisterAddressActivity.this.finish();
                                        Intent intent = new Intent(RegisterAddressActivity.this, CheckoutActivity.class);
                                        Bundle args = new Bundle();
                                        args.putString("order_total", ototal);
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
        }
        if(view.getId()==R.id.cancel_update_btn) {
            RegisterAddressActivity.this.finish();
            Intent intent = new Intent(RegisterAddressActivity.this, CheckoutActivity.class);
            Bundle args = new Bundle();
            args.putString("order_total", ototal);
            intent.putExtras(args);
            intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
        }
    }
}
