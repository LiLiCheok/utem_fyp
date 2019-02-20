package com.buyme.Interface;


import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
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
import com.buyme.GetterSetterClass.Profile;
import com.buyme.PopActivity.UpdateEmailActivity;
import com.buyme.PopActivity.UpdatePasswordActivity;
import com.buyme.R;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

/**
 * A simple {@link Fragment} subclass.
 */
public class ProfileFragment extends Fragment implements View.OnClickListener {

    View v;
    Button update_btn;
    EditText update_name, update_ic, update_contact, update_email, update_password;
    EditText create_address, create_postcode, create_city, create_state;

    ArrayList<Profile> profiles;
    String login_user_id = MainActivity.login_id;

    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    public ProfileFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        getActivity().setTitle("My Profile");

        // Inflate the layout for this fragment
        v = inflater.inflate(R.layout.fragment_profile, container, false);

        profiles = new ArrayList<Profile>();

        update_btn = (Button) v.findViewById(R.id.update_btn);
        update_name = (EditText) v.findViewById(R.id.update_name);
        update_ic = (EditText) v.findViewById(R.id.update_ic);
        update_contact = (EditText) v.findViewById(R.id.update_contact);
        update_email = (EditText) v.findViewById(R.id.update_email);
        update_password = (EditText) v.findViewById(R.id.update_password);

        create_address = (EditText) v.findViewById(R.id.create_address);
        create_postcode = (EditText) v.findViewById(R.id.create_postcode);
        create_city = (EditText) v.findViewById(R.id.create_city);
        create_state = (EditText) v.findViewById(R.id.create_state);

        update_email.setFocusable(false);
        update_email.setClickable(true);
        update_email.setOnClickListener(this);

        update_password.setFocusable(false);
        update_password.setClickable(true);
        update_password.setOnClickListener(this);

        create_state.setFocusable(false);

        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnGetUserProfile));
                params1.add(new BasicNameValuePair("user_id", login_user_id));
                try {
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    JSONArray data = jsnObj.getJSONArray("data");
                    for (int index = 0; index < data.length(); index++) {
                        Profile profile = new Profile();
                        JSONObject obj = data.getJSONObject(index);
                        profile.setUserID(obj.optString("user_id"));
                        profile.setUserEmail(obj.optString("user_email"));
                        profile.setUserName(obj.optString("user_name"));
                        profile.setUserPassword(obj.optString("user_password"));
                        profile.setIcNo(obj.optString("ic_no"));
                        profile.setContactNo(obj.optString("contact_no"));
                        profile.setAddress(obj.optString("address"));
                        profile.setPostcode(obj.optString("postcode"));
                        profile.setCity(obj.optString("city"));
                        profile.setState(obj.optString("state"));
                        profiles.add(profile);
                    }
                    getActivity().runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            if(profiles.size()>0) {
                                for (int i = 0; i < profiles.size(); i++) {
                                    update_name.setText(profiles.get(i).getUserName());
                                    update_ic.setText(profiles.get(i).getIcNo());
                                    update_contact.setText(profiles.get(i).getContactNo());
                                    update_email.setText(profiles.get(i).getUserEmail());
                                    update_password.setText(profiles.get(i).getUserPassword());
                                    create_address.setText(profiles.get(i).getAddress());
                                    create_postcode.setText(profiles.get(i).getPostcode());
                                    create_city.setText(profiles.get(i).getCity());
                                    create_state.setText(profiles.get(i).getState());
                                }
                            } else {}

                        }
                    });
                } catch (Exception e) {
                    e.printStackTrace();
                    Log.d("GetUserProfile", "Error!");
                }
            }
        };
        Thread thread = new Thread(run);
        thread.start();

        update_btn.setOnClickListener(this);

        return v;
    }

    private void updateUserProfile() {
        Runnable runnable = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnUpdateUserProfile));
                params1.add(new BasicNameValuePair("user_id", login_user_id));
                params1.add(new BasicNameValuePair("user_name", update_name.getText().toString()));
                params1.add(new BasicNameValuePair("ic_no", update_ic.getText().toString()));
                params1.add(new BasicNameValuePair("contact_no", update_contact.getText().toString()));
                params1.add(new BasicNameValuePair("address", create_address.getText().toString()));
                params1.add(new BasicNameValuePair("postcode", create_postcode.getText().toString()));
                params1.add(new BasicNameValuePair("city", create_city.getText().toString()));
                params1.add(new BasicNameValuePair("state", create_state.getText().toString()));
                try {
                    String updated = "updated";
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    if (updated.equals(jsnObj.optString("updated"))) {
                        getActivity().runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(getActivity(), "Your profile has been updated.", Toast.LENGTH_LONG).show();
                                HomeFragment.openProfileFrag();
                            }
                        });
                    } else {}
                } catch (Exception e) {
                    e.printStackTrace();
                    Log.d("UpdateUserProfile", "Error!");
                }
            }
        };

        Thread thr = new Thread(runnable);
        thr.start();
    }

    @Override
    public void onClick(View view) {

        if(view.getId()==R.id.update_email) {
            Intent intent = new Intent(getActivity(), UpdateEmailActivity.class);
            Bundle args = new Bundle();
            args.putString("user_email", update_email.getText().toString());
            intent.putExtras(args);
            intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
            getActivity().finish();
        }

        if(view.getId()==R.id.update_password) {
            Intent intent = new Intent(getActivity(), UpdatePasswordActivity.class);
            intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
            getActivity().finish();
        }

        if(view.getId()==R.id.update_btn) {
            if(update_name.getText().toString().equals("")||update_ic.getText().toString().equals("")||
                update_contact.getText().toString().equals("")||create_address.getText().toString().equals("")||
                create_postcode.getText().toString().equals("")||create_city.getText().toString().equals("")) {
                Toast.makeText(getActivity(), "Please fill in the empty field.", Toast.LENGTH_LONG).show();
            } else {
                updateUserProfile();
            }
        }
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
