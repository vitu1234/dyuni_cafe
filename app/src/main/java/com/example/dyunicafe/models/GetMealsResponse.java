package com.example.dyunicafe.models;

import com.example.dyunicafe.models.room_db.Meal;

import java.util.List;

public class GetMealsResponse {
    boolean error;
    String message;
    List<Meal> meals;

    public GetMealsResponse(boolean error, String message, List<Meal> meals) {
        this.error = error;
        this.message = message;
        this.meals = meals;
    }

    public boolean isError() {
        return error;
    }

    public String getMessage() {
        return message;
    }

    public List<Meal> getMeals() {
        return meals;
    }
}
