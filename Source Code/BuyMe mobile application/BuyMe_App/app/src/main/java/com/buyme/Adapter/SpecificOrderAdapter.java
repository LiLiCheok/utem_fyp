package com.buyme.Adapter;

import android.app.Activity;
import android.content.Context;
import android.graphics.PorterDuff;
import android.media.Image;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.CheckBox;
import android.widget.ImageView;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;

import com.buyme.GetterSetterClass.SpecificOrder;
import com.buyme.R;

import org.json.JSONObject;

import java.util.ArrayList;

/**
 * Created by ll_cheok on 7/30/2016.
 */
public class SpecificOrderAdapter extends ArrayAdapter<SpecificOrder> {

    private ArrayList<SpecificOrder> specificOrders;
    private LayoutInflater li;
    int Resource;
    private ViewHolder holder;
    Activity activity;

    public SpecificOrderAdapter(Activity activity, Context context, int resource, ArrayList<SpecificOrder> objects) {
        super(context, resource, objects);
        this.activity = activity;
        li = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        Resource = resource;
        specificOrders = objects;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {

        if(convertView == null) {

            convertView = li.inflate(Resource, null);

            holder = new ViewHolder();

            holder.name = (TextView) convertView.findViewById(R.id.so_pname);
            holder.price = (TextView) convertView.findViewById(R.id.so_pprice);
            holder.quantity = (TextView) convertView.findViewById(R.id.so_pquantity);
            holder.charge = (TextView) convertView.findViewById(R.id.so_charge);
            holder.subtotal = (TextView) convertView.findViewById(R.id.so_psubtotal);
            holder.so_tblayout = (TableLayout) convertView.findViewById(R.id.so_tblayout);
            holder.so_tblrow = (TableRow) holder.so_tblayout.findViewById(R.id.so_tblrow);
            holder.checked = (ImageView) convertView.findViewById(R.id.checked);
            holder.not_checked = (ImageView) convertView.findViewById(R.id.not_checked);

            convertView.setTag(holder);

        } else {
            holder = (ViewHolder) convertView.getTag();
        }

        SpecificOrder so = specificOrders.get(position);
        holder.name.setText(so.getProductName());
        Double curr_price = (Double.parseDouble(so.getSubtotal()))/(Integer.parseInt(so.getQuantity()));
        holder.price.setText(String.format("%.2f", curr_price));
        holder.quantity.setText(so.getQuantity());
        if(so.getChosenDelivery().equals("null")) {
            holder.checked.setVisibility(View.GONE);
            holder.not_checked.setVisibility(View.VISIBLE);
            holder.charge.setVisibility(View.GONE);
            holder.sub = (Double.parseDouble(so.getSubtotal()));
        } else {
            holder.checked.setVisibility(View.VISIBLE);
            holder.not_checked.setVisibility(View.GONE);
            holder.charge.setVisibility(View.VISIBLE);
            holder.charge.setText("("+so.getChosenDelivery()+"%)");
            holder.sub = (Double.parseDouble(so.getSubtotal())) +
                    ((Double.parseDouble(so.getSubtotal()))*(Double.parseDouble(so.getChosenDelivery()))/100);
        }
        holder.subtotal.setText(String.format("%.2f", holder.sub));

        if(so.getStatus().equals("")) {
//            holder.so_tblrow.setBackgroundColor(activity.getResources().getColor(android.R.color.white));
        } else {
            if (so.getStatus().equalsIgnoreCase("In Progress")) {
                holder.so_tblrow.setBackgroundColor(activity.getResources().getColor(R.color.colorProgress));
            } else if (so.getStatus().equalsIgnoreCase("Taken/Sent")) {
                holder.so_tblrow.setBackgroundColor(activity.getResources().getColor(R.color.colorTaken));
            }else {}
        }

        return convertView;
    }

    private static class ViewHolder {
        public TextView name;
        public TextView price;
        public TextView quantity;
        public ImageView checked;
        public ImageView not_checked;
        public TextView charge;
        public TextView subtotal;
        public TableLayout so_tblayout;
        public TableRow so_tblrow;
        public Double sub=0.00;
    }
}
