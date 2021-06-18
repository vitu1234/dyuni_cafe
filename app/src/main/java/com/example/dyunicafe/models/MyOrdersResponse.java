package com.example.dyunicafe.models;

import com.example.dyunicafe.models.room_db.Order;

import java.util.List;

public class MyOrdersResponse {
    boolean error;
    String message;
    List<Order> orders;

    public MyOrdersResponse(boolean error, String message, List<Order> orders) {
        this.error = error;
        this.message = message;
        this.orders = orders;
    }

    public boolean isError() {
        return error;
    }

    public String getMessage() {
        return message;
    }

    public List<Order> getOrders() {
        return orders;
    }
}
