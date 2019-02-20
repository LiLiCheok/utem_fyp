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
import com.buyme.Interface.RegisterFragment;
import com.buyme.R;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by ll_cheok on 7/27/2016.
 */
public class UpdateEmailActivity extends AppCompatActivity implements View.OnClickListener {

    Button change_email_btn, cancel_email_btn;
    EditText old_email, new_email;
    String user_email;
    String login_user_id = MainActivity.login_id;

    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    @Override
    public void onBackPressed() {}

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_update_email);

        change_email_btn = (Button) findViewById(R.id.change_email_btn);
        cancel_email_btn = (Button) findViewById(R.id.cancel_email_btn);
        old_email = (EditText) findViewById(R.id.old_email);
        new_email = (EditText) findViewById(R.id.new_email);
        change_email_btn.setOnClickListener(this);
        cancel_email_btn.setOnClickListener(this);

        String user_email = getIntent().getExtras().getString("user_email");
        old_email.setText(user_email);
        old_email.setFocusable(false);
    }

    @Override
    public void onClick(View view) {
        if(view.getId()==R.id.change_email_btn) {
            user_email = new_email.getText().toString();
            if(checkEmail(user_email)) {
                updateEmail(user_email);
            } else {
                new_email.getBackground().setColorFilter(getResources().getColor(R.color.colorWrong), PorterDuff.Mode.SRC_IN);
                Toast.makeText(UpdateEmailActivity.this, "Please fill in a valid e-mail.", Toast.LENGTH_LONG).show();
            }
        }
        if(view.getId()==R.id.cancel_email_btn) {
            UpdateEmailActivity.this.finish();
            Intent intent = new Intent(UpdateEmailActivity.this, MainActivity.class);
            String openProfile = "openProfile";
            Bundle args = new Bundle();
            args.putString("openProfile", openProfile);
            intent.putExtras(args);
            intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
        }
    }

    private void updateEmail(final String user_email) {
        Runnable runnable = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnUpdateUserEmail));
                params1.add(new BasicNameValuePair("user_id", login_user_id));
                params1.add(new BasicNameValuePair("user_email", user_email));
                try {
                    String updated = "updated";
                    String exist = "exist";
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    if (updated.equals(jsnObj.optString("updated"))) {
                        runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(UpdateEmailActivity.this, "Your may need to login again with new email.", Toast.LENGTH_LONG).show();
                                MainActivity.greeting_msg.setText("Welcome to BuyMe");
                                MainActivity.greeting_email.setText("melaka.buyme2016@gmail.com");

                                SharedPreferences myPrefs = getSharedPreferences(WebServiceCall.prefs_login, Context.MODE_PRIVATE);
                                SharedPreferences.Editor editor = myPrefs.edit();
                                editor.remove(WebServiceCall.prefs_login_id_key);
                                editor.remove(WebServiceCall.prefs_login_email_key);
                                editor.remove(WebServiceCall.prefs_login_name_key);
                                editor.commit();

                                UpdateEmailActivity.this.finish();
                                Intent intent = new Intent(UpdateEmailActivity.this, MainActivity.class);
                                String openLogin = "openLogin";
                                Bundle args = new Bundle();
                                args.putString("openLogin", openLogin);
                                intent.putExtras(args);
                                startActivity(intent);
                            }
                        });
                    } else if (exist.equals(jsnObj.optString("exist"))) {
                        runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                new_email.getBackground().setColorFilter(getResources().getColor(R.color.colorWrong), PorterDuff.Mode.SRC_IN);
                                Toast.makeText(UpdateEmailActivity.this, "This e-mail is registered at BuyMe.", Toast.LENGTH_LONG).show();
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

    private boolean checkEmail(String email) {
        return RegisterFragment.EMAIL_ADDRESS_PATTERN.matcher(email).matches();
    }
}
