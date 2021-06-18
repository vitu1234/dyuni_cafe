package com.example.dyunicafe.fragments;

import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
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


public class MealsListFragment extends Fragment {

    Call<GetMealsResponse> call;
    CheckInternet checkInternet;
    MyProgressDialog progressDialog;
    SweetAlertDialog sweetAlertDialog;
    AppDatabase room_db;


    GeneralRecyclerAdapter generalRecyclerAdapter;
    List<RecentlyViewed> myOrdersList;
    List<Meal> mealList;


    RecyclerView recyclerViewOrders;

    public MealsListFragment() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_meals_list, container, false);
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        checkInternet = new CheckInternet(getContext());
        progressDialog = new MyProgressDialog(getContext());
        sweetAlertDialog = new SweetAlertDialog(getContext());
        room_db = AppDatabase.getDbInstance(getContext());

        recyclerViewOrders = view.findViewById(R.id.meals_list_recycler);

        // adding data to model
//        myOrdersList = new ArrayList<>();
//        myOrdersList.add(new RecentlyViewed("Chips & Chicken", "K800", "Lunch", R.drawable.chips_chicken));
//        myOrdersList.add(new RecentlyViewed("Rice & Beef", "K700", "Supper", R.drawable.beef_rice));
//        myOrdersList.add(new RecentlyViewed("Spaghetti & Mince Meat", "K800", "Lunch", R.drawable.spaghetti));
//        myOrdersList.add(new RecentlyViewed("Chips & Quarter Chicken", "K1,200", "Supper", R.drawable.chicken_image));

//        setMealsRecycler(myOrdersList);
        getMeals();
    }

    private void setMealsRecycler(List<Meal> myOrdersDataList) {
        RecyclerView.LayoutManager layoutManager = new LinearLayoutManager(getContext(), LinearLayoutManager.VERTICAL, false);
        recyclerViewOrders.setLayoutManager(layoutManager);
        recyclerViewOrders.addItemDecoration(new DividerItemDecoration(getActivity(), DividerItemDecoration.VERTICAL));//line between items
        generalRecyclerAdapter = new GeneralRecyclerAdapter(getContext(), myOrdersDataList);
        recyclerViewOrders.setAdapter(generalRecyclerAdapter);
    }

    private void getMeals() {
        //check Internet
        if (checkInternet.isInternetConnected(getContext())) {
            progressDialog.showDialog("Please wait");

            call = RetrofitClient.getInstance().getApi().getMealsResponse();
            call.enqueue(new Callback<GetMealsResponse>() {
                @Override
                public void onResponse(Call<GetMealsResponse> call, Response<GetMealsResponse> response) {
                    progressDialog.closeDialog();
                    GetMealsResponse response1 = response.body();
                    if (!response1.isError()) {
                        room_db = AppDatabase.getDbInstance(getContext());
                        mealList = response1.getMeals();

                        for (int i = 0; i < mealList.size(); i++) {
//                            Log.e("meals", String.valueOf(mealList.get(i)));
                            room_db.mealDao().insertMeal(mealList.get(i));
                            Log.e("price",mealList.get(i).getPrice());

                        }
                        setMealsRecycler(mealList);
                        Log.e("size", String.valueOf(room_db.mealDao().getAllMeals().size()));


//                        db.userDao().insertUser(user);
                    } else {
                        progressDialog.showDangerAlert(response1.getMessage());


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
}