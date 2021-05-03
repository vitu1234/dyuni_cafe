package com.example.dyunicafe.models.room_db;

import android.content.Context;

import androidx.room.Database;
import androidx.room.Room;
import androidx.room.RoomDatabase;

@Database(entities = {Meal.class, Order.class}, version  = 2)
public abstract class AppDatabase extends RoomDatabase {

    public abstract MealDao mealDao();
    public abstract OrderDao orderDao();

    private static AppDatabase INSTANCE;

    public static AppDatabase getDbInstance(Context context) {
        String DB_NAME = "ROOMDB";
        if(INSTANCE == null) {
            INSTANCE = Room.databaseBuilder(context.getApplicationContext(), AppDatabase.class, DB_NAME)
                    .allowMainThreadQueries()
                    .build();

        }
        return INSTANCE;
    }
}