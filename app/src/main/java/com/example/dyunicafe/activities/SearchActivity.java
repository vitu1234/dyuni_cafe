package com.example.dyunicafe.activities;

import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.SearchView;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.example.dyunicafe.R;
import com.example.dyunicafe.adapters.GeneralRecyclerAdapter;
import com.example.dyunicafe.api.RetrofitClient;
import com.example.dyunicafe.models.GetMealsResponse;
import com.example.dyunicafe.models.RecentlyViewed;
import com.example.dyunicafe.models.room_db.AppDatabase;
import com.example.dyunicafe.models.room_db.Meal;
import com.example.dyunicafe.utils.CheckInternet;
import com.example.dyunicafe.utils.MyProgressDialog;

import java.util.List;

import cn.pedant.SweetAlert.SweetAlertDialog;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class SearchActivity extends AppCompatActivity {

    Call<GetMealsResponse> call;
    CheckInternet checkInternet;
    MyProgressDialog progressDialog;
    SweetAlertDialog sweetAlertDialog;
    AppDatabase room_db;
    SearchView searchView;

    GeneralRecyclerAdapter generalRecyclerAdapter;
    List<RecentlyViewed> myOrdersList;
    List<Meal> mealList;
    RecyclerView recyclerViewOrders;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_search);

        checkInternet = new CheckInternet(this);
        progressDialog = new MyProgressDialog(this);
        sweetAlertDialog = new SweetAlertDialog(this);
        room_db = AppDatabase.getDbInstance(this);
        searchView = findViewById(R.id.searchView);
        searchView.setFocusable(true);
        searchView.hasFocus();

        recyclerViewOrders = findViewById(R.id.recyclerSearchMeals);

        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String query) {
                getMeals(query);
                searchView.setSubmitButtonEnabled(false);
                return false;
            }

            @Override
            public boolean onQueryTextChange(String newText) {
                return false;
            }
        });

    }

    private void setMealsRecycler(List<Meal> myOrdersDataList) {
        RecyclerView.LayoutManager layoutManager = new LinearLayoutManager(this, LinearLayoutManager.VERTICAL, false);
        recyclerViewOrders.setLayoutManager(layoutManager);
        recyclerViewOrders.addItemDecoration(new DividerItemDecoration(this, DividerItemDecoration.VERTICAL));//line between items
        generalRecyclerAdapter = new GeneralRecyclerAdapter(this, myOrdersDataList);
        recyclerViewOrders.setAdapter(generalRecyclerAdapter);
    }

    private void getMeals(String query) {
        searchView.clearFocus();
        //check Internet
        if (checkInternet.isInternetConnected(this)) {
            progressDialog.showDialog("Searching, please wait");

            call = RetrofitClient.getInstance().getApi().getSearchedMeals(query);
            call.enqueue(new Callback<GetMealsResponse>() {
                @Override
                public void onResponse(Call<GetMealsResponse> call, Response<GetMealsResponse> response) {
                    progressDialog.closeDialog();
                    searchView.setSubmitButtonEnabled(false);
                    if (response != null) {
                        GetMealsResponse response1 = response.body();
                        if (!response1.isError()) {
                            room_db = AppDatabase.getDbInstance(SearchActivity.this);
                            mealList = response1.getMeals();

                            for (int i = 0; i < mealList.size(); i++) {
//                            Log.e("meals", String.valueOf(mealList.get(i)));
                                room_db.mealDao().insertMeal(mealList.get(i));
                                Log.e("price", mealList.get(i).getPrice());

                            }
                            setMealsRecycler(mealList);
                            Log.e("size", String.valueOf(room_db.mealDao().getAllMeals().size()));


//                        db.userDao().insertUser(user);
                        } else {
                            progressDialog.showDangerAlert(response1.getMessage());


                        }
                    } else {
                        progressDialog.showDangerAlert("No server response!");
                    }

                }

                @Override
                public void onFailure(Call<GetMealsResponse> call, Throwable t) {
                    progressDialog.closeDialog();
                    searchView.setSubmitButtonEnabled(false);
                    try {
                        progressDialog.showDangerAlert("An error occured communicating with server, try again later;;");
                        Log.e("error", t.getMessage());
                    } catch (Exception e) {

                    }
                }
            });
        } else {
            progressDialog.showDangerAlert("Internet connection not available");
        }
    }

    public void gobaxj(View view) {
        onBackPressed();
    }
}