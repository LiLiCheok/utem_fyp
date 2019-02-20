package com.buyme.PopActivity;

import android.app.Activity;
import android.graphics.PorterDuff;
import android.os.Bundle;
import android.util.DisplayMetrics;
import android.util.Log;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.buyme.DatabaseController.WebServiceCall;
import com.buyme.Interface.RegisterFragment;
import com.buyme.R;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class ForgotPassword extends Activity implements View.OnClickListener {

    Button send_email_btn;
    EditText send_email;
    String user_email;

    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    @Override
    public void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);

        setContentView(R.layout.forgot_password);

        // Display pop window
        DisplayMetrics dm = new DisplayMetrics();
        getWindowManager().getDefaultDisplay().getMetrics(dm);
        int width = dm.widthPixels;
        int height = dm.heightPixels;
        getWindow().setLayout((int)(width*.8), (int)(height*.5));

        // Dim background
        WindowManager.LayoutParams windowManager = getWindow().getAttributes();
        windowManager.dimAmount = 0.75f;
        getWindow().addFlags(WindowManager.LayoutParams.FLAG_DIM_BEHIND);

        send_email_btn = (Button) findViewById(R.id.send_email_btn);
        send_email = (EditText) findViewById(R.id.send_email);
        send_email_btn.setOnClickListener(this);
    }

    private boolean checkEmail(String email) {
        return RegisterFragment.EMAIL_ADDRESS_PATTERN.matcher(email).matches();
    }

    @Override
    public void onClick(View view) {
        if(view.getId()==R.id.send_email_btn) {
            user_email = send_email.getText().toString().trim();
            if(checkEmail(user_email)) {
                Runnable run = new Runnable() {
                    @Override
                    public void run() {
                        final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                        params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnForgotPassword));
                        params1.add(new BasicNameValuePair("user_email", user_email));
                        try {
                            String sent = "sent";
                            String no = "no";
                            jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                            if (sent.equals(jsnObj.optString("sent"))) {
                                runOnUiThread(new Runnable() {
                                    @Override
                                    public void run() {
                                        Toast.makeText(ForgotPassword.this, "E-mail Sent. Please check your e-mail.", Toast.LENGTH_LONG).show();
                                        ForgotPassword.this.finish();
                                    }
                                });
                            } else if (no.equals(jsnObj.optString("no"))) {
                                runOnUiThread(new Runnable() {
                                    @Override
                                    public void run() {
                                        Toast.makeText(ForgotPassword.this, "This e-mail is not registered on BuyMe.", Toast.LENGTH_LONG).show();
                                        send_email.getBackground().setColorFilter(getResources().getColor(R.color.colorWrong), PorterDuff.Mode.SRC_IN);
                                    }
                                });
                            } else {
                                runOnUiThread(new Runnable() {
                                    @Override
                                    public void run() {
                                        Toast.makeText(ForgotPassword.this, jsnObj.optString("error"), Toast.LENGTH_LONG).show();
                                    }
                                });
                            }

                        } catch (Exception e) {

                            Log.d("JSON call Error", "Error!");
                        }
                    }
                };

                Thread thread = new Thread(run);
                thread.start();

            } else {

                send_email.getBackground().setColorFilter(getResources().getColor(R.color.colorWrong), PorterDuff.Mode.SRC_IN);
                Toast.makeText(this, "Please fill in a valid e-mail.", Toast.LENGTH_LONG).show();
            }
        }
    }
}
