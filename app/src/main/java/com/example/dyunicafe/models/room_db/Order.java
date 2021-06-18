package com.example.dyunicafe.models.room_db;

import androidx.room.ColumnInfo;
import androidx.room.Entity;
import androidx.room.PrimaryKey;

@Entity
public class Order {
    @PrimaryKey(autoGenerate = true)
    int room_order_id;
    @ColumnInfo(name = "order_id")
    int order_id;
    @ColumnInfo(name = "user_id")
    int user_id;
    @ColumnInfo(name = "payment_id")
    int payment_id;
    @ColumnInfo(name= "qty")
    int qty;
    @ColumnInfo(name = "order_status")
    int order_status;
    @ColumnInfo(name = "date_created")
    String date_created;
    @ColumnInfo(name = "meal_id")
    int meal_id;

    @ColumnInfo(name = "meal_name")
    String meal_name;
    @ColumnInfo(name = "meal_price")
    String meal_price;
    @ColumnInfo(name = "img_url")
    String img_url;

    @ColumnInfo(name = "payment_type")
    String payment_type;
    @ColumnInfo(name = "screenshot")
    String screenshot;

    public Order(int order_id, int user_id, int payment_id, int qty, int order_status, String date_created, int meal_id, String meal_name, String meal_price, String img_url, String payment_type, String screenshot) {
        this.order_id = order_id;
        this.user_id = user_id;
        this.payment_id = payment_id;
        this.qty = qty;
        this.order_status = order_status;
        this.date_created = date_created;
        this.meal_id = meal_id;
        this.meal_name = meal_name;
        this.meal_price = meal_price;
        this.img_url = img_url;
        this.payment_type = payment_type;
        this.screenshot = screenshot;
    }

    public int getRoom_order_id() {
        return room_order_id;
    }

    public void setRoom_order_id(int room_order_id) {
        this.room_order_id = room_order_id;
    }

    public int getOrder_id() {
        return order_id;
    }

    public void setOrder_id(int order_id) {
        this.order_id = order_id;
    }

    public int getUser_id() {
        return user_id;
    }

    public void setUser_id(int user_id) {
        this.user_id = user_id;
    }

    public int getPayment_id() {
        return payment_id;
    }

    public void setPayment_id(int payment_id) {
        this.payment_id = payment_id;
    }

    public int getQty() {
        return qty;
    }

    public void setQty(int qty) {
        this.qty = qty;
    }

    public int getOrder_status() {
        return order_status;
    }

    public void setOrder_status(int order_status) {
        this.order_status = order_status;
    }

    public String getDate_created() {
        return date_created;
    }

    public void setDate_created(String date_created) {
        this.date_created = date_created;
    }

    public int getMeal_id() {
        return meal_id;
    }

    public void setMeal_id(int meal_id) {
        this.meal_id = meal_id;
    }

    public String getMeal_name() {
        return meal_name;
    }

    public void setMeal_name(String meal_name) {
        this.meal_name = meal_name;
    }

    public String getMeal_price() {
        return meal_price;
    }

    public void setMeal_price(String meal_price) {
        this.meal_price = meal_price;
    }

    public String getImg_url() {
        return img_url;
    }

    public void setImg_url(String img_url) {
        this.img_url = img_url;
    }

    public String getPayment_type() {
        return payment_type;
    }

    public void setPayment_type(String payment_type) {
        this.payment_type = payment_type;
    }

    public String getScreenshot() {
        return screenshot;
    }

    public void setScreenshot(String screenshot) {
        this.screenshot = screenshot;
    }
}
