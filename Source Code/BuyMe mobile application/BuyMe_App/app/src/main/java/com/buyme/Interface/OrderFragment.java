package com.buyme.Interface;


import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentTransaction;
import android.util.Log;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;

import com.buyme.Adapter.OrderAdapter;
import com.buyme.DatabaseController.WebServiceCall;
import com.buyme.GetterSetterClass.Order;
import com.buyme.PopActivity.UpdateCartActivity;
import com.buyme.PopActivity.ViewOrderActivity;
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
public class OrderFragment extends Fragment implements View.OnClickListener {

    View v;
    Button oshop_now_btn;
    LinearLayout order_layout, no_order_layout;
    TextView num_order;

    ListView order_list;
    ArrayList<Order> orders;
    ArrayAdapter oadapter;
    String login_user_id = MainActivity.login_id;

    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    public OrderFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        getActivity().setTitle("My Order");

        // Inflate the layout for this fragment
        v = inflater.inflate(R.layout.fragment_order, container, false);

        oshop_now_btn = (Button) v.findViewById(R.id.oshop_now_btn);
        order_layout = (LinearLayout) v.findViewById(R.id.order_layout);
        no_order_layout = (LinearLayout) v.findViewById(R.id.no_order_layout);
        num_order = (TextView) v.findViewById(R.id.num_order);

        oshop_now_btn.setOnClickListener(this);

        order_list = (ListView) v.findViewById(R.id.order_list);
        orders = new ArrayList<Order>();

        getOrderNo(login_user_id);
        getOrder(login_user_id);

        return v;
    }

    private void getOrderNo(final String login_user_id) {
        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnGetCartOrderNo));
                params1.add(new BasicNameValuePair("user_id", login_user_id));
                try {
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    final String order_num = jsnObj.optString("num_order");
                    getActivity().runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            if(order_num.equals("1")) {
                                num_order.setText(order_num + " order");
                            } else {
                                num_order.setText(order_num + " orders");
                            }
                        }
                    });
                } catch (Exception e) {
                    e.printStackTrace();
                    Log.d("GetCartOrderNo", "Error!");
                }
            }
        };
        Thread thr = new Thread(run);
        thr.start();
    }

    private void getOrder(final String login_user_id) {
        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnGetOrder));
                params1.add(new BasicNameValuePair("user_id", login_user_id));
                try {
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    JSONArray data = jsnObj.getJSONArray("data");
                    if(data.length()==0) {
                        getActivity().runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                no_order_layout.setVisibility(LinearLayout.VISIBLE);
                            }
                        });
                    } else {
                        for (int index = 0; index < data.length(); index++) {
                            Order order = new Order();
                            JSONObject obj = data.getJSONObject(index);
                            order.setOrderID(obj.optString("order_id"));
                            order.setOrderTime(obj.optString("order_time"));
                            order.setOrderTotal(obj.optString("order_total"));
                            orders.add(order);
                        }
                        getActivity().runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                order_layout.setVisibility(LinearLayout.VISIBLE);
                                oadapter = new OrderAdapter(getActivity(), getContext(), R.layout.order_list, orders);
                                order_list.setAdapter(oadapter);
                                order_list.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                                    @Override
                                    public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                                        Intent intent = new Intent(getActivity(), ViewOrderActivity.class);
                                        Bundle args = new Bundle();
                                        args.putString("order_id", orders.get(i).getOrderID().toString());
                                        args.putString("order_time", orders.get(i).getOrderTime().toString());
                                        args.putString("order_total", orders.get(i).getOrderTotal().toString());
                                        intent.putExtras(args);
                                        intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
                                        startActivity(intent);
                                        getActivity().finish();
                                    }
                                });
                                oadapter.notifyDataSetChanged();

                            }
                        });
                    }
                } catch (Exception e) {
                    e.printStackTrace();
                    Log.d("GetOrder", "Error!");
                }
            }
        };
        Thread thr = new Thread(run);
        thr.start();
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

    @Override
    public void onClick(View view) {
        if(view.getId()==R.id.oshop_now_btn) {
            Fragment newFragment = new HomeFragment();
            FragmentTransaction transaction =
                    getFragmentManager().beginTransaction();
            transaction.replace(R.id.fragment_container, newFragment);
            transaction.addToBackStack(null);
            transaction.commit();
        }
    }
}
