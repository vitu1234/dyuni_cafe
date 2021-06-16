package com.example.dyunicafe.fragments;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.example.dyunicafe.R;
import com.example.dyunicafe.activities.SearchActivity;
import com.example.dyunicafe.adapters.MealsDashAdapter;
import com.example.dyunicafe.adapters.MostOrderedMealsAdapter;
import com.example.dyunicafe.api.RetrofitClient;
import com.example.dyunicafe.models.DiscountedProducts;
import com.example.dyunicafe.models.GetMealsResponse;
import com.example.dyunicafe.models.GetOrdersResponse;
import com.example.dyunicafe.models.room_db.AppDatabase;
import com.example.dyunicafe.models.room_db.Meal;
import com.example.dyunicafe.models.room_db.Order;
import com.example.dyunicafe.utils.CheckInternet;
import com.example.dyunicafe.utils.MyProgressDialog;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class DashboardFragment extends Fragment {

    Call<GetMealsResponse> call;
    Call<GetOrdersResponse> ordersCall;

    CheckInternet checkInternet;
    MyProgressDialog progressDialog;
    AppDatabase room_db;

    List<Meal> mealList;
    List<Order> orderList;

    RecyclerView discountRecyclerView, recentlyViewedRecycler;
    MostOrderedMealsAdapter mostOrderedMealsAdapter;
    List<DiscountedProducts> discountedProductsList;


    MealsDashAdapter mealsDashAdapter;
    TextView textViewmoreMeals;

    TextView editTextSearch;


    public DashboardFragment() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_dashboard, container, false);
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        checkInternet = new CheckInternet(getContext());
        progressDialog = new MyProgressDialog(getContext());
        room_db = AppDatabase.getDbInstance(getContext());

        discountRecyclerView = view.findViewById(R.id.discountedRecycler);

        editTextSearch = view.findViewById(R.id.editText);
        editTextSearch.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getContext(), SearchActivity.class));
            }
        });
        recentlyViewedRecycler = view.findViewById(R.id.recently_item);
        textViewmoreMeals = view.findViewById(R.id.moreMeals);
        textViewmoreMeals.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                displayFragment(new MealsListFragment());
            }
        });

//        allCategory.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View view) {
//                Intent i = new Intent(getContext(), AllCategory.class);
//                startActivity(i);
//            }
//        });

        // adding data to model
        discountedProductsList = new ArrayList<>();
        discountedProductsList.add(new DiscountedProducts(1, "Sausage", "K1,200", R.drawable.sausage));
        discountedProductsList.add(new DiscountedProducts(2, "Chips & Chicken", "K800", R.drawable.chips_chicken));
//        discountedProductsList.add(new DiscountedProducts(3, "Bread Sandwich Omelette", "K500",R.drawable.egg_cheese_bread_omelette));
        discountedProductsList.add(new DiscountedProducts(4, "Fried Beef", "K1,200", R.drawable.fried_beef));
        discountedProductsList.add(new DiscountedProducts(4, "Nsima & Beans", "K500", R.drawable.nsima_beans_rape));

        getMostOrder();
        getMeals();
    }

    private void displayFragment(Fragment fragment) {
        getActivity().getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, fragment, null).commit();
    }

    private void setMostOrderdRecycler(List<Order> dataList) {
        RecyclerView.LayoutManager layoutManager = new LinearLayoutManager(getContext(), LinearLayoutManager.HORIZONTAL, false);
        discountRecyclerView.setLayoutManager(layoutManager);
        mostOrderedMealsAdapter = new MostOrderedMealsAdapter(getContext(), dataList);
        discountRecyclerView.setAdapter(mostOrderedMealsAdapter);
    }


    private void setDashboardMeals(List<Meal> recentlyViewedDataList) {
        RecyclerView.LayoutManager layoutManager = new LinearLayoutManager(getContext(), LinearLayoutManager.HORIZONTAL, false);
        recentlyViewedRecycler.setLayoutManager(layoutManager);
        mealsDashAdapter = new MealsDashAdapter(getContext(), recentlyViewedDataList);
        recentlyViewedRecycler.setAdapter(mealsDashAdapter);
    }

    //get meals
    private void getMeals() {
        //check Internet
        if (checkInternet.isInternetConnected(getContext())) {
//            progressDialog.showDialog("Please wait");

            call = RetrofitClient.getInstance().getApi().getMealsDashResponse();
            call.enqueue(new Callback<GetMealsResponse>() {
                @Override
                public void onResponse(Call<GetMealsResponse> call, Response<GetMealsResponse> response) {
                    progressDialog.closeDialog();
                    GetMealsResponse response1 = response.body();
                    if (!response1.isError()) {
//                        progressDialog.showSuccessAlert(response1.getMessage());
                        room_db = AppDatabase.getDbInstance(getContext());
                        mealList = response1.getMeals();

                        for (int i = 0; i < mealList.size(); i++) {
//                            Log.e("meals", String.valueOf(mealList.get(i)));
                            room_db.mealDao().insertMeal(mealList.get(i));
                            Log.e("price", mealList.get(i).getPrice());

                        }
                        setDashboardMeals(mealList);
                        Log.e("size", String.valueOf(room_db.mealDao().getAllMeals().size()));


//                        db.userDao().insertUser(user);
                    } else {
//                        progressDialog.showDangerAlert(response1.getMessage());
                        Toast.makeText(getActivity(), response1.getMessage(), Toast.LENGTH_SHORT).show();

                    }
                }

                @Override
                public void onFailure(Call<GetMealsResponse> call, Throwable t) {
                    progressDialog.closeDialog();
                    try {
                        progressDialog.showDangerAlert("An error occured, try again later;;");
                        Log.e("error", t.getMessage());
                    } catch (Exception e) {

                    }
                }
            });
        } else {
            progressDialog.showDangerAlert("Internet connection not available");
        }
    }

    //get most ordered meals
    private void getMostOrder() {
        //check Internet
        if (checkInternet.isInternetConnected(getContext())) {
//            progressDialog.showDialog("Please wait");

            ordersCall = RetrofitClient.getInstance().getApi().getMostOrderMeals();
            ordersCall.enqueue(new Callback<GetOrdersResponse>() {
                @Override
                public void onResponse(Call<GetOrdersResponse> call, Response<GetOrdersResponse> response) {
//                    progressDialog.closeDialog();
                    GetOrdersResponse response1 = response.body();
                    if (response1 != null){
                    if (!response1.isError()) {
//                        progressDialog.showSuccessAlert(response1.getMessage());
                        room_db = AppDatabase.getDbInstance(getContext());
                        orderList = response1.getOrders();

                        for (int i = 0; i < orderList.size(); i++) {
//                            Log.e("meals", String.valueOf(mealList.get(i)));
                            room_db.orderDao().insertOrder((orderList.get(i)));
//                            Log.e("price", mealList.get(i).getPrice());

                        }
                        setMostOrderdRecycler(orderList);
                        Log.e("size", String.valueOf(room_db.mealDao().getAllMeals().size()));


//                        db.userDao().insertUser(user);
                    } else {
//                        progressDialog.showDangerAlert(response1.getMessage());


                    }}else{
                        Toast.makeText(getActivity(), "No server response", Toast.LENGTH_SHORT).show();
                    }
                }

                @Override
                public void onFailure(Call<GetOrdersResponse> call, Throwable t) {
//                    progressDialog.closeDialog();
                    try {
//                        progressDialog.showDangerAlert("An error occured, try again later;;");
                        Log.e("error", t.getMessage());
                    } catch (Exception e) {

                    }
                }
            });
        } else {
//            progressDialog.showDangerAlert("Internet connection not available");
        }
    }

}