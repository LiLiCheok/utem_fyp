package com.buyme.PopActivity;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.PorterDuff;
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
 * Created by ll_cheok on 7/27/2016.
 */
public class UpdatePasswordActivity extends AppCompatActivity implements View.OnClickListener {

    Button change_password_btn, cancel_password_btn;
    EditText old_password, new_password, confirm_password;

    String login_user_id = MainActivity.login_id;

    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    @Override
    public void onBackPressed() {}

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_update_password);

        change_password_btn = (Button) findViewById(R.id.change_password_btn);
        cancel_password_btn = (Button) findViewById(R.id.cancel_password_btn);
        old_password = (EditText) findViewById(R.id.old_password);
        new_password = (EditText) findViewById(R.id.new_password);
        confirm_password = (EditText) findViewById(R.id.new_repassword);
        change_password_btn.setOnClickListener(this);
        cancel_password_btn.setOnClickListener(this);
    }

    @Override
    public void onClick(View view) {
        if(view.getId()==R.id.change_password_btn) {
            if(old_password.getText().toString().equals("")&&new_password.getText().toString().equals("")&&
                confirm_password.getText().toString().equals("")) {
                Toast.makeText(UpdatePasswordActivity.this, "Please fill in the empty field.", Toast.LENGTH_LONG).show();
            } else {
                if(new_password.getText().toString().equals(confirm_password.getText().toString())) {
                    updatePassword();
                } else {
                    Toast.makeText(UpdatePasswordActivity.this, "Both password is different.", Toast.LENGTH_LONG).show();
                    new_password.getBackground().setColorFilter(getResources().getColor(R.color.colorWrong), PorterDuff.Mode.SRC_IN);
                    confirm_password.getBackground().setColorFilter(getResources().getColor(R.color.colorWrong), PorterDuff.Mode.SRC_IN);
                }
            }
        }
        if(view.getId()==R.id.cancel_password_btn) {
            UpdatePasswordActivity.this.finish();
            Intent intent = new Intent(UpdatePasswordActivity.this, MainActivity.class);
            String openProfile = "openProfile";
            Bundle args = new Bundle();
            args.putString("openProfile", openProfile);
            intent.putExtras(args);
            intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
        }
    }

    private void updatePassword() {
        Runnable runnable = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnUpdateUserPassword));
                params1.add(new BasicNameValuePair("user_id", login_user_id));
                params1.add(new BasicNameValuePair("old_password", old_password.getText().toString()));
                params1.add(new BasicNameValuePair("new_password", confirm_password.getText().toString()));
                try {
                    String updated = "updated";
                    String incorrect = "incorrect";
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    if (updated.equals(jsnObj.optString("updated"))) {
                        runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(UpdatePasswordActivity.this, "Your may need to login again with new password.", Toast.LENGTH_LONG).show();
                                MainActivity.greeting_msg.setText("Welcome to BuyMe");
                                MainActivity.greeting_email.setText("melaka.buyme2016@gmail.com");

                                SharedPreferences myPrefs = getSharedPreferences(WebServiceCall.prefs_login, Context.MODE_PRIVATE);
                                SharedPreferences.Editor editor = myPrefs.edit();
                                editor.remove(WebServiceCall.prefs_login_id_key);
                                editor.remove(WebServiceCall.prefs_login_email_key);
                                editor.remove(WebServiceCall.prefs_login_name_key);
                                editor.commit();

                                UpdatePasswordActivity.this.finish();
                                Intent intent = new Intent(UpdatePasswordActivity.this, MainActivity.class);
                                String openLogin = "openLogin";
                                Bundle args = new Bundle();
                                args.putString("openLogin", openLogin);
                                intent.putExtras(args);
                                startActivity(intent);
                            }
                        });
                    } else if(incorrect.equals(jsnObj.optString("incorrect"))) {
                        runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(UpdatePasswordActivity.this, "Wrong Old Password", Toast.LENGTH_LONG).show();
                                old_password.getBackground().setColorFilter(getResources().getColor(R.color.colorWrong), PorterDuff.Mode.SRC_IN);
                            }
                        });
                    } else {}
                } catch (Exception e) {
                    Log.d("JSON call Error", "Error!");
                }
            }
        };

        Thread thr = new Thread(runnable);
        thr.start();
    }
}
