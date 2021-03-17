package com.example.dyunicafe.models;

import android.graphics.drawable.Drawable;

public class RecentlyViewed {

    String name;
    String price, description;
    int bigimageurl;

    public RecentlyViewed(String name, String price, String description, int bigimageurl) {
        this.name = name;
        this.price = price;
        this.bigimageurl = bigimageurl;
        this.description = description;
    }

    public int getBigimageurl() {
        return bigimageurl;
    }

    public void setBigimageurl(int bigimageurl) {
        this.bigimageurl = bigimageurl;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public String getPrice() {
        return price;
    }

    public void setPrice(String price) {
        this.price = price;
    }


}
