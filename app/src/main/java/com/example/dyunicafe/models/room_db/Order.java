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
    @ColumnInfo(name= "qty")
    int qty;
    @ColumnInfo(name = "order_status")
    int order_status;
    @ColumnInfo(name = "date_created")
    String date_created;
    @ColumnInfo(name = "meal_id")
    int meal_id;
    @ColumnInfo(name = "meal_type")
    String meal_type;
    @ColumnInfo(name = "menu_expiry_date")
    String menu_expiry_date;
    @ColumnInfo(name = "meal_name")
    String meal_name;
    @ColumnInfo(name = "meal_price")
    String meal_price;
    @ColumnInfo(name = "img_url")
    String img_url;

    public Order(int order_id, int user_id, int qty, int order_status, String date_created, int meal_id, String meal_type, String menu_expiry_date, String meal_name, String meal_price, String img_url) {
        this.order_id = order_id;
        this.user_id = user_id;
        this.qty = qty;
        this.order_status = order_status;
        this.date_created = date_created;
        this.meal_id = meal_id;
        this.meal_type = meal_type;
        this.menu_expiry_date = menu_expiry_date;
        this.meal_name = meal_name;
        this.meal_price = meal_price;
        this.img_url = img_url;
    }

    public int getRoom_order_id() {
        return room_order_id;
    }

    public int getOrder_id() {
        return order_id;
    }

    public int getUser_id() {
        return user_id;
    }

    public int getQty() {
        return qty;
    }

    public int getOrder_status() {
        return order_status;
    }

    public String getDate_created() {
        return date_created;
    }

    public int getMeal_id() {
        return meal_id;
    }

    public String getMeal_type() {
        return meal_type;
    }

    public String getMenu_expiry_date() {
        return menu_expiry_date;
    }

    public String getMeal_name() {
        return meal_name;
    }

    public String getMeal_price() {
        return meal_price;
    }

    public String getImg_url() {
        return img_url;
    }
}
