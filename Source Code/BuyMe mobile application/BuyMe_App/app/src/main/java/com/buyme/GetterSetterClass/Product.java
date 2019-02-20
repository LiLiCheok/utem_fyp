package com.buyme.GetterSetterClass;

import android.graphics.Bitmap;

/**
 * Created by ll_cheok on 7/25/2016.
 */
public class Product {

    public void setProductImage(Bitmap productImage) {
        this.productImage = productImage;
    }

    public void setProductID(String productID) {
        this.productID = productID;
    }

    public void setProductName(String productName) {
        this.productName = productName;
    }

    public void setProductPrice(String productPrice) {
        this.productPrice = productPrice;
    }

    public String getProductPrice() {
        return productPrice;
    }

    public String getProductName() {
        return productName;
    }

    public Bitmap getProductImage() {
        return productImage;
    }

    public String getProductID() {
        return productID;
    }

    public String getShopName() {
        return shopName;
    }

    public void setShopName(String shopName) {
        this.shopName = shopName;
    }

    public Bitmap productImage;
    public String productID;
    public String productName;
    public String productPrice;
    public String shopName;
}
