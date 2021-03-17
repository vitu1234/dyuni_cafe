package com.example.dyunicafe.fragments;

import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.example.dyunicafe.R;
import com.example.dyunicafe.adapters.GeneralRecyclerAdapter;
import com.example.dyunicafe.adapters.RecentlyViewedAdapter;
import com.example.dyunicafe.models.RecentlyViewed;

import java.util.ArrayList;
import java.util.List;


public class MyOrdersFragment extends Fragment {

    GeneralRecyclerAdapter generalRecyclerAdapter;
    List<RecentlyViewed> myOrdersList;

    RecyclerView recyclerViewOrders;


    public MyOrdersFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_my_orders, container, false);
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        recyclerViewOrders = view.findViewById(R.id.orders_list_recycler);


        // adding data to model
        myOrdersList = new ArrayList<>();
        myOrdersList.add(new RecentlyViewed("Chips & Chicken",  "K800", "Lunch - Collected", R.drawable.chips_chicken));
        myOrdersList.add(new RecentlyViewed("Rice & Beef",  "K700", "Supper - Collected", R.drawable.beef_rice));
        myOrdersList.add(new RecentlyViewed("Spaghetti & Mince Meat",  "K800", "Lunch - Collected", R.drawable.spaghetti));
        myOrdersList.add(new RecentlyViewed("Chips & Quarter Chicken", "K1,200", "Supper - ready", R.drawable.chicken_image));


        setMyOrdersRecycler(myOrdersList);

    }

    private void setMyOrdersRecycler(List<RecentlyViewed> myOrdersDataList) {
        RecyclerView.LayoutManager layoutManager = new LinearLayoutManager(getContext(), LinearLayoutManager.VERTICAL, false);
        recyclerViewOrders.setLayoutManager(layoutManager);
        generalRecyclerAdapter = new GeneralRecyclerAdapter(getContext(), myOrdersDataList);
        recyclerViewOrders.setAdapter(generalRecyclerAdapter);
    }
}