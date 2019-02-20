package com.buyme.GetterSetterClass;

import android.graphics.Bitmap;

/**
 * Created by ll_cheok on 7/28/2016.
 */
public class Cart {

    private String cartID;
    private Bitmap productImage;
    private String productID;
    private String productName;
    private String productPrice;
    private String quantity;
    private String subtotal;
    private String shopID;
    private String shopName;
    private String deliveryService;
    private String deliveryInfo;

    public String getDelCharge() {
        return delCharge;
    }

    public void setDelCharge(String delCharge) {
        this.delCharge = delCharge;
    }

    private String delCharge;

    public String getShopID() {
        return shopID;
    }

    public void setShopID(String shopID) {
        this.shopID = shopID;
    }

    public String getDeliveryInfo() {
        return deliveryInfo;
    }

    public Bitmap getProductImage() {
        return productImage;
    }

    public void setProductImage(Bitmap productImage) {
        this.productImage = productImage;
    }

    public void setDeliveryInfo(String deliveryInfo) {
        this.deliveryInfo = deliveryInfo;
    }

    public String getCartID() {
        return cartID;
    }

    public void setCartID(String cartID) {
        this.cartID = cartID;
    }

    public String getDeliveryService() {
        return deliveryService;
    }

    public void setDeliveryService(String deliveryService) {
        this.deliveryService = deliveryService;
    }

    public String getProductID() {
        return productID;
    }

    public void setProductID(String productID) {
        this.productID = productID;
    }

    public String getProductName() {
        return productName;
    }

    public void setProductName(String productName) {
        this.productName = productName;
    }

    public String getProductPrice() {
        return productPrice;
    }

    public void setProductPrice(String productPrice) {
        this.productPrice = productPrice;
    }

    public String getQuantity() {
        return quantity;
    }

    public void setQuantity(String quantity) {
        this.quantity = quantity;
    }

    public String getShopName() {
        return shopName;
    }

    public void setShopName(String shopName) {
        this.shopName = shopName;
    }

    public String getSubtotal() {
        return subtotal;
    }

    public void setSubtotal(String subtotal) {
        this.subtotal = subtotal;
    }

}
