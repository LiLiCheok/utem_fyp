package com.buyme.Interface;


import android.graphics.PorterDuff;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentTransaction;
import android.util.Log;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.buyme.DatabaseController.WebServiceCall;
import com.buyme.R;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;
import java.util.regex.Pattern;

/**
 * A simple {@link Fragment} subclass.
 */
public class RegisterFragment extends Fragment implements View.OnClickListener  {

    View v;
    Button register_btn, cancel_btn;
    EditText create_name, create_ic, create_contact, create_email, create_password, create_confirm_password;

    String user_name, ic_no, contact_no, user_email, user_password,  confirm_password;

    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    public RegisterFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        getActivity().setTitle("Register");

        // Inflate the layout for this fragment
        v = inflater.inflate(R.layout.fragment_register, container, false);

        register_btn = (Button) v.findViewById(R.id.register_btn);
        cancel_btn = (Button) v.findViewById(R.id.cancel_btn);
        create_name = (EditText) v.findViewById(R.id.create_name);
        create_ic = (EditText) v.findViewById(R.id.create_ic);
        create_contact = (EditText) v.findViewById(R.id.create_contact);
        create_email = (EditText) v.findViewById(R.id.create_email);
        create_password = (EditText) v.findViewById(R.id.create_password);
        create_confirm_password = (EditText) v.findViewById(R.id.create_confirm_password);

        register_btn.setOnClickListener(this);
        cancel_btn.setOnClickListener(this);

        return v;
    }

    @Override
    public void onClick(View view) {

        if(view.getId()==R.id.register_btn) {

            user_name = create_name.getText().toString().trim();
            ic_no = create_ic.getText().toString().trim();
            contact_no = create_contact.getText().toString().trim();
            user_email = create_email.getText().toString().trim();
            user_password = create_password.getText().toString().trim();
            confirm_password = create_confirm_password.getText().toString().trim();

            if (user_name.equals("") || ic_no.equals("") || contact_no.equals("") || user_email.equals("") || user_password.equals("") || confirm_password.equals("")) {
                Toast.makeText(getActivity(), "Please fill in the required information", Toast.LENGTH_LONG).show();
            } else {
                if (user_password.equals(confirm_password)) {
                    if(checkEmail(user_email)) {
                        Runnable run = new Runnable() {
                            @Override
                            public void run() {
                                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnUserRegister));
                                params1.add(new BasicNameValuePair("user_name", user_name));
                                params1.add(new BasicNameValuePair("ic_no", ic_no));
                                params1.add(new BasicNameValuePair("contact_no", contact_no));
                                params1.add(new BasicNameValuePair("user_email", user_email));
                                params1.add(new BasicNameValuePair("user_password", user_password));
                                try {
                                    String created = "created";
                                    String exist = "exist";
                                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                                    if (created.equals(jsnObj.optString("created"))) {
                                        getActivity().runOnUiThread(new Runnable() {
                                            @Override
                                            public void run() {
                                                Toast.makeText(getActivity(), "Your account has been registered.", Toast.LENGTH_LONG).show();
                                                Fragment newFragment = new LoginFragment();
                                                FragmentTransaction transaction = getActivity().getSupportFragmentManager().beginTransaction();
                                                transaction.replace(R.id.fragment_container, newFragment);
                                                transaction.addToBackStack(null);
                                                transaction.commit();
                                            }
                                        });
                                    } else if (exist.equals(jsnObj.optString("exist"))) {
                                        getActivity().runOnUiThread(new Runnable() {
                                            @Override
                                            public void run() {
                                                Toast.makeText(getActivity(), "This e-mail is registered.", Toast.LENGTH_LONG).show();
                                                create_email.getBackground().setColorFilter(getResources().getColor(R.color.colorWrong), PorterDuff.Mode.SRC_IN);
                                            }
                                        });
                                    } else {
                                        getActivity().runOnUiThread(new Runnable() {
                                            @Override
                                            public void run() {
                                                Toast.makeText(getActivity(), jsnObj.optString("error"), Toast.LENGTH_LONG).show();
                                            }
                                        });
                                    }

                                } catch (Exception e) {
                                    e.printStackTrace();
                                    Log.d("UserRegister", "Error!");

                                }
                            }
                        };

                        Thread thread = new Thread(run);
                        thread.start();
                    } else {
                        create_email.getBackground().setColorFilter(getResources().getColor(R.color.colorWrong), PorterDuff.Mode.SRC_IN);
                        Toast.makeText(getActivity(), "Please fill in a valid e-mail.", Toast.LENGTH_LONG).show();
                    }
                } else {
                    Toast.makeText(getActivity(), "Both entered password is different.", Toast.LENGTH_LONG).show();
                    create_password.setText("");
                    create_confirm_password.setText("");
                    create_password.getBackground().setColorFilter(getResources().getColor(R.color.colorWrong), PorterDuff.Mode.SRC_IN);
                    create_confirm_password.getBackground().setColorFilter(getResources().getColor(R.color.colorWrong), PorterDuff.Mode.SRC_IN);
                }
            }
        }

        if(view.getId()==R.id.cancel_btn) {
            Fragment newFragment = new HomeFragment();
            FragmentTransaction transaction = getActivity().getSupportFragmentManager().beginTransaction();
            transaction.replace(R.id.fragment_container, newFragment);
            transaction.addToBackStack(null);
            transaction.commit();
        }
    }

    public static final Pattern EMAIL_ADDRESS_PATTERN = Pattern.compile(
        "[a-zA-Z0-9\\+\\.\\_\\%\\-\\+]{1,256}" +
        "\\@" +
        "[a-zA-Z0-9][a-zA-Z0-9\\-]{0,64}" +
        "(" +
        "\\." +
        "[a-zA-Z0-9][a-zA-Z0-9\\-]{0,25}" +
        ")+"
    );

    private boolean checkEmail(String email) {
        return EMAIL_ADDRESS_PATTERN.matcher(email).matches();
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
