package com.buyme.Adapter;

import android.app.Activity;
import android.content.Context;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import com.buyme.DatabaseController.WebServiceCall;
import com.buyme.GetterSetterClass.Order;
import com.buyme.R;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by ll_cheok on 7/28/2016.
 */
public class OrderAdapter extends ArrayAdapter<Order> {

    private ArrayList<Order> orders;
    private LayoutInflater li;
    int Resource;
    private ViewHolder holder;

    Activity activity;
    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    public OrderAdapter(Activity activity, Context context, int resource, ArrayList<Order> objects) {
        super(context, resource, objects);
        this.activity = activity;
        li = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        Resource = resource;
        orders = objects;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {

        if(convertView == null) {

            convertView = li.inflate(Resource, null);

            holder = new ViewHolder();
            holder.order_id = (TextView) convertView.findViewById(R.id.order_id);
            holder.order_time = (TextView) convertView.findViewById(R.id.order_time);
            holder.order_status = (TextView) convertView.findViewById(R.id.order_status);

            convertView.setTag(holder);

        } else {
            holder = (ViewHolder) convertView.getTag();
        }

        Order o = orders.get(position);
        holder.order_id.setText(o.getOrderID().toString());
        holder.order_time.setText(o.getOrderTime().toString());

        final String order_id = holder.order_id.getText().toString();
        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnSetOrderStatus));
                params1.add(new BasicNameValuePair("order_id", order_id));
                try {
                    final String not_settle = "not_settle";
                    final String settle = "settle";
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    activity.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            if(not_settle.equals(jsnObj.optString("order_status"))) {
                                holder.order_status.setText("Waiting");
                            } else if(settle.equals(jsnObj.optString("order_status"))) {
                                holder.order_status.setText("Received");
                            }
                        }
                    });
                } catch (Exception e) {
                    e.printStackTrace();
                    Log.d("SetOrderStatus", "Error!");
                }
            }
        };

        Thread thr = new Thread(run);
        thr.start();

        return convertView;
    }

    private static class ViewHolder {
        public TextView order_id;
        public TextView order_time;
        public TextView order_status;
    }
}
