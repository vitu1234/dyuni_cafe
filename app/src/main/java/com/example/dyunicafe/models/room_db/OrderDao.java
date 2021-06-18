package com.example.dyunicafe.models.room_db;

import androidx.room.Dao;
import androidx.room.Delete;
import androidx.room.Insert;
import androidx.room.Query;

import java.util.List;

@Dao
public interface OrderDao {

    @Query("SELECT * FROM `order`")
    List<Order> getAllOrders();

    @Query("SELECT * FROM `order` WHERE order_id =:id ")
    Order getSingleOrders(int id);

    @Insert
    void insertOrder(Order... orders);

    @Query("DELETE  FROM `order`")
    Void deleteAllOrders();

    @Delete
    void delete(Order order);
}
