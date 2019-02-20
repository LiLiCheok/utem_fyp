package com.buyme.GetterSetterClass;

/**
 * Created by ll_cheok on 7/29/2016.
 */
public class SpecificOrder {

    private String chosenDelivery;
    private String productName;
    private String quantity;
    private String subtotal;
    private String status;

    public String getSubtotal() {
        return subtotal;
    }

    public void setSubtotal(String subtotal) {
        this.subtotal = subtotal;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public String getQuantity() {
        return quantity;
    }

    public void setQuantity(String quantity) {
        this.quantity = quantity;
    }

    public String getProductName() {
        return productName;
    }

    public void setProductName(String productName) {
        this.productName = productName;
    }

    public String getChosenDelivery() {
        return chosenDelivery;
    }

    public void setChosenDelivery(String chosenDelivery) {
        this.chosenDelivery = chosenDelivery;
    }
}
