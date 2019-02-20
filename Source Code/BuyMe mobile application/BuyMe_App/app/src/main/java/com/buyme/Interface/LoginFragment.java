package com.buyme.Interface;


import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.PorterDuff;
import android.os.Bundle;
import android.support.design.widget.NavigationView;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentTransaction;
import android.util.Log;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.buyme.DatabaseController.WebServiceCall;
import com.buyme.PopActivity.ForgotPasswordActivity;
import com.buyme.R;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

/**
 * A simple {@link Fragment} subclass.
 */
public class LoginFragment extends Fragment implements View.OnClickListener {

    View v;
    Button login_btn, forgot_pass_btn;
    EditText login_email, login_password;
    TextView greeting_msg, greeting_email;

    String user_email, user_password, user_id, user_name;

    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    public LoginFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        getActivity().setTitle("Log In");

        // Inflate the layout for this fragment
        v = inflater.inflate(R.layout.fragment_login, container, false);

        login_btn = (Button) v.findViewById(R.id.login_btn);
        forgot_pass_btn = (Button) v.findViewById(R.id.forgot_pass_btn);
        login_email = (EditText) v.findViewById(R.id.login_email);
        login_password = (EditText) v.findViewById(R.id.login_password);

        login_btn.setOnClickListener(this);
        forgot_pass_btn.setOnClickListener(this);

        return v;
    }

    @Override
    public void onClick(View view) {

        if(view.getId()==R.id.login_btn) {

            user_email = login_email.getText().toString().trim();
            user_password = login_password.getText().toString().trim();

            if(user_email.equals("")||user_password.equals("")) {
                Toast.makeText(getActivity(), "Please enter the required information", Toast.LENGTH_LONG).show();
            } else {
                if(checkEmail(user_email)) {
                    Runnable run = new Runnable() {
                        @Override
                        public void run() {
                            final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                            params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnUserLogin));
                            params1.add(new BasicNameValuePair("user_email", user_email));
                            params1.add(new BasicNameValuePair("user_password", user_password));
                            try {
                                String not_match = "not_match";
                                String match = "match";
                                jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                                if (not_match.equals(jsnObj.optString("not_match"))) {
                                    getActivity().runOnUiThread(new Runnable() {
                                        @Override
                                        public void run() {
                                            Toast.makeText(getActivity(), "Incorrect Email/Password", Toast.LENGTH_LONG).show();
                                        }
                                    });
                                } else if (match.equals(jsnObj.optString("match"))) {
                                    getActivity().runOnUiThread(new Runnable() {
                                        @Override
                                        public void run() {
                                            user_name = jsnObj.optString("user_name");
                                            user_id = jsnObj.optString("user_id");
                                            user_email = jsnObj.optString("user_email");
                                            greeting_msg = (TextView) getActivity().findViewById(R.id.greeting_msg);
                                            greeting_msg.setText("Welcome, "+user_name);
                                            greeting_email = (TextView) getActivity().findViewById(R.id.greeting_email);
                                            greeting_email.setText(user_email);

                                            // store user login id using SharedPreferences
                                            SharedPreferences settings;
                                            SharedPreferences.Editor editor;
                                            settings = getContext().getSharedPreferences(WebServiceCall.prefs_login, Context.MODE_PRIVATE);
                                            editor = settings.edit();
                                            editor.putString(WebServiceCall.prefs_login_id_key, user_id);
                                            editor.putString(WebServiceCall.prefs_login_email_key, user_email);
                                            editor.putString(WebServiceCall.prefs_login_name_key, user_name);
                                            editor.commit();

                                            // hide and show menu item
                                            NavigationView navigationView = (NavigationView) getActivity().findViewById(R.id.nav_view);
                                            Menu menu = navigationView.getMenu();
                                            menu.findItem(R.id.nav_login).setVisible(false);
                                            menu.findItem(R.id.nav_register).setVisible(false);
                                            menu.findItem(R.id.nav_cart).setVisible(true);
                                            menu.findItem(R.id.nav_order).setVisible(true);
                                            menu.findItem(R.id.nav_profile).setVisible(true);
                                            menu.findItem(R.id.nav_logout).setVisible(true);

                                            getActivity().finish();
                                            Intent intent = new Intent(getActivity(), MainActivity.class);
                                            intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
                                            startActivity(intent);
                                        }
                                    });
                                } else {
                                    getActivity().runOnUiThread(new Runnable() {
                                        @Override
                                        public void run() {
                                            Toast.makeText(getActivity(), "This email is registered as seller.", Toast.LENGTH_LONG).show();
                                        }
                                    });
                                }

                            } catch (Exception e) {
                                e.printStackTrace();
                                Log.d("UserLogin", "Error!");
                            }
                        }
                    };

                    Thread thread = new Thread(run);
                    thread.start();
                } else {
                    login_email.getBackground().setColorFilter(getResources().getColor(R.color.colorWrong), PorterDuff.Mode.SRC_IN);
                    Toast.makeText(getActivity(), "Please fill in a valid e-mail.", Toast.LENGTH_LONG).show();
                }
            }
        }

        if(view.getId()==R.id.forgot_pass_btn) {
            Intent intent = new Intent(getActivity(), ForgotPasswordActivity.class);
            startActivity(intent);
        }
    }

    private boolean checkEmail(String email) {
        return RegisterFragment.EMAIL_ADDRESS_PATTERN.matcher(email).matches();
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
}
