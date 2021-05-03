package com.example.dyunicafe.models.room_db;

import androidx.room.ColumnInfo;
import androidx.room.Entity;
import androidx.room.PrimaryKey;

@Entity
public class Meal {
    @PrimaryKey(autoGenerate = true)
    int room_menu_id;
    @ColumnInfo(name = "menu_id")
    int menu_id;
    @ColumnInfo(name = "meal_id")
    int meal_id;
    @ColumnInfo(name = "meal_type")
    String meal_type;
    @ColumnInfo(name = "menu_expiry_date")
    String menu_expiry_date;
    @ColumnInfo(name = "date_created")
    String date_created;
    @ColumnInfo(name = "meal_name")
    String meal_name;
    @ColumnInfo(name = "price")
    String meal_price;
    @ColumnInfo(name = "img_url")
    String img_url;

    public Meal(int menu_id, int meal_id, String meal_type, String menu_expiry_date, String date_created, String meal_name, String meal_price, String img_url) {
        this.menu_id = menu_id;
        this.meal_id = meal_id;
        this.meal_type = meal_type;
        this.menu_expiry_date = menu_expiry_date;
        this.date_created = date_created;
        this.meal_name = meal_name;
        this.meal_price = meal_price;
        this.img_url = img_url;
    }

    public int getMenu_id() {
        return menu_id;
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

    public String getDate_created() {
        return date_created;
    }

    public String getMeal_name() {
        return meal_name;
    }

    public String getPrice() {
        return meal_price;
    }

    public String getImg_url() {
        return img_url;
    }
}
