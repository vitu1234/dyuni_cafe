package com.example.dyunicafe.models;

public class DiscountedProducts {


    Integer id;
    Integer imageurl;
    String food_name, discount_percent;

    public DiscountedProducts(Integer id, String food_name, String discount_percent, Integer imageurl) {
        this.id = id;
        this.imageurl = imageurl;
        this.discount_percent = discount_percent;
        this.food_name = food_name;
    }

    public String getFood_name() {
        return food_name;
    }

    public void setFood_name(String food_name) {
        this.food_name = food_name;
    }

    public String getDiscount_percent() {
        return discount_percent;
    }

    public void setDiscount_percent(String discount_percent) {
        this.discount_percent = discount_percent;
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Integer getImageurl() {
        return imageurl;
    }

    public void setImageurl(Integer imageurl) {
        this.imageurl = imageurl;
    }
}
