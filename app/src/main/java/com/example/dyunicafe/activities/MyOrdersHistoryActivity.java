package com.example.dyunicafe.activities;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.example.dyunicafe.R;
import com.example.dyunicafe.activities.common.AccountDirectActivity;
import com.example.dyunicafe.adapters.MyOrdersAdapter;
import com.example.dyunicafe.api.RetrofitClient;
import com.example.dyunicafe.models.MyOrdersResponse;
import com.example.dyunicafe.models.room_db.AppDatabase;
import com.example.dyunicafe.models.room_db.Order;
import com.example.dyunicafe.storage.SharedPrefManager;
import com.example.dyunicafe.utils.CheckInternet;
import com.example.dyunicafe.utils.MyProgressDialog;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MyOrdersHistoryActivity extends AppCompatActivity {

    RecyclerView recyclerViewOrders;
    List<Order> orderList;
    Call<MyOrdersResponse> call;
    CheckInternet checkInternet;
    MyProgressDialog progressDialog;
    AppDatabase room_db;
    MyOrdersAdapter myOrdersAdapter;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_my_orders_history);
        recyclerViewOrders = findViewById(R.id.recyclerOrders);
        checkInternet = new CheckInternet(this);
        room_db = AppDatabase.getDbInstance(this);
        progressDialog = new MyProgressDialog(this);
        if (!SharedPrefManager.getInstance(this).isLoggedIn()) {
            startActivity(new Intent(this, AccountDirectActivity.class));
            finish();
        }

        getOrders();
    }

    private void getOrders() {
        if (checkInternet.isInternetConnected(this)) {
            progressDialog.showDialog("Please wait...");
            int user_id = SharedPrefManager.getInstance(this).getUser().getUser_id();
            call = RetrofitClient.getInstance().getApi().getMyOrders(user_id);
            call.enqueue(new Callback<MyOrdersResponse>() {
                @Override
                public void onResponse(Call<MyOrdersResponse> call, Response<MyOrdersResponse> response) {
                    MyOrdersResponse response1 = response.body();
                    progressDialog.closeDialog();
                    if (response1 != null) {
                        if (!response1.isError()) {
                            room_db.orderDao().deleteAllOrders();
                            for (int i = 0; i < response1.getOrders().size(); i++) {
                                room_db.orderDao().insertOrder(response1.getOrders().get(i));
                            }
                            Log.e("dd",response1.getOrders().size()+" thats the size");

                            setOrdersRecycler(response1.getOrders());
                        } else {
                            progressDialog.showDangerAlert(response1.getMessage());
                        }
                    } else {
                        progressDialog.showDangerAlert("No server response!");
                    }
                }

                @Override
                public void onFailure(Call<MyOrdersResponse> call, Throwable t) {
                    try {
                        progressDialog.closeDialog();
                        progressDialog.showDangerAlert("Error communicationg with our servers");
                    } catch (Exception e) {

                    }
                }
            });
        } else {
            checkInternet.showInternetDialog(this);
        }
    }

    private void setOrdersRecycler(List<Order> myOrdersDataList) {
        RecyclerView.LayoutManager layoutManager = new LinearLayoutManager(MyOrdersHistoryActivity.this, LinearLayoutManager.VERTICAL, false);
        recyclerViewOrders.setLayoutManager(layoutManager);
        recyclerViewOrders.addItemDecoration(new DividerItemDecoration(MyOrdersHistoryActivity.this, DividerItemDecoration.VERTICAL));//line between items
        myOrdersAdapter = new MyOrdersAdapter(MyOrdersHistoryActivity.this, myOrdersDataList);
        recyclerViewOrders.setAdapter(myOrdersAdapter);
    }

    public void goNs(View view) {
        onBackPressed();
    }
}