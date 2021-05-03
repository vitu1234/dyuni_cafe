package com.example.dyunicafe.models.room_db;

import androidx.room.Dao;
import androidx.room.Delete;
import androidx.room.Insert;
import androidx.room.Query;

import java.util.List;

@Dao
public interface MealDao {
    @Query("SELECT * FROM meal")
    List<Meal> getAllMeals();

    @Insert
    void insertMeal(Meal... meals);

    @Delete
    void delete(Meal meal);
}
