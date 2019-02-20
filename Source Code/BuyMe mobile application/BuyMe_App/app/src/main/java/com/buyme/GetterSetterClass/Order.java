package com.buyme.GetterSetterClass;

/**
 * Created by ll_cheok on 7/28/2016.
 */
public class Order {

    private String orderID;
    private String orderTime;
    private String orderTotal;

    public String getOrderTotal() {
        return orderTotal;
    }

    public void setOrderTotal(String orderTotal) {
        this.orderTotal = orderTotal;
    }

    public String getOrderID() {
        return orderID;
    }

    public void setOrderID(String orderID) {
        this.orderID = orderID;
    }

    public String getOrderTime() {
        return orderTime;
    }

    public void setOrderTime(String orderTime) {
        this.orderTime = orderTime;
    }
}
