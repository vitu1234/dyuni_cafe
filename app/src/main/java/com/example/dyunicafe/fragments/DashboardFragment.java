package com.example.dyunicafe.fragments;

import android.content.Intent;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.example.dyunicafe.R;
import com.example.dyunicafe.activities.AllCategory;
import com.example.dyunicafe.adapters.CategoryAdapter;
import com.example.dyunicafe.adapters.DiscountedProductAdapter;
import com.example.dyunicafe.adapters.RecentlyViewedAdapter;
import com.example.dyunicafe.models.Category;
import com.example.dyunicafe.models.DiscountedProducts;
import com.example.dyunicafe.models.RecentlyViewed;

import java.util.ArrayList;
import java.util.List;

public class DashboardFragment extends Fragment {


    RecyclerView discountRecyclerView, categoryRecyclerView, recentlyViewedRecycler;
    DiscountedProductAdapter discountedProductAdapter;
    List<DiscountedProducts> discountedProductsList;

    CategoryAdapter categoryAdapter;
    List<Category> categoryList;

    RecentlyViewedAdapter recentlyViewedAdapter;
    List<RecentlyViewed> recentlyViewedList;

    TextView allCategory;


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

        discountRecyclerView = view.findViewById(R.id.discountedRecycler);
        categoryRecyclerView = view.findViewById(R.id.categoryRecycler);
        allCategory = view.findViewById(R.id.allCategoryImage);
        recentlyViewedRecycler = view.findViewById(R.id.recently_item);


        allCategory.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(getContext(), AllCategory.class);
                startActivity(i);
            }
        });

        // adding data to model
        discountedProductsList = new ArrayList<>();
        discountedProductsList.add(new DiscountedProducts(1, "Sausage", "K1,200" , R.drawable.sausage));
        discountedProductsList.add(new DiscountedProducts(2, "Chips & Chicken", "K800", R.drawable.chips_chicken));
//        discountedProductsList.add(new DiscountedProducts(3, "Bread Sandwich Omelette", "K500",R.drawable.egg_cheese_bread_omelette));
        discountedProductsList.add(new DiscountedProducts(4, "Fried Beef","K1,200", R.drawable.fried_beef));
        discountedProductsList.add(new DiscountedProducts(4, "Nsima & Beans", "K500", R.drawable.nsima_beans_rape));

        // adding data to model
        categoryList = new ArrayList<>();
        categoryList.add(new Category(1, R.drawable.ic_home_fruits));


        // adding data to model
        recentlyViewedList = new ArrayList<>();
        recentlyViewedList.add(new RecentlyViewed("Chips & Chicken",  "K800", "Lunch", R.drawable.chips_chicken));
        recentlyViewedList.add(new RecentlyViewed("Rice & Beef",  "K700", "Supper", R.drawable.beef_rice));
        recentlyViewedList.add(new RecentlyViewed("Spaghetti & Mince Meat",  "K800", "Lunch", R.drawable.spaghetti));
        recentlyViewedList.add(new RecentlyViewed("Chips & Quarter Chicken", "K1,200", "Supper", R.drawable.chicken_image));

        setDiscountedRecycler(discountedProductsList);
        setCategoryRecycler(categoryList);
        setRecentlyViewedRecycler(recentlyViewedList);
    }

    private void setDiscountedRecycler(List<DiscountedProducts> dataList) {
        RecyclerView.LayoutManager layoutManager = new LinearLayoutManager(getContext(), LinearLayoutManager.HORIZONTAL, false);
        discountRecyclerView.setLayoutManager(layoutManager);
        discountedProductAdapter = new DiscountedProductAdapter(getContext(), dataList);
        discountRecyclerView.setAdapter(discountedProductAdapter);
    }


    private void setCategoryRecycler(List<Category> categoryDataList) {
        RecyclerView.LayoutManager layoutManager = new LinearLayoutManager(getContext(), LinearLayoutManager.HORIZONTAL, false);
        categoryRecyclerView.setLayoutManager(layoutManager);
        categoryAdapter = new CategoryAdapter(getContext(), categoryDataList);
        categoryRecyclerView.setAdapter(categoryAdapter);
    }

    private void setRecentlyViewedRecycler(List<RecentlyViewed> recentlyViewedDataList) {
        RecyclerView.LayoutManager layoutManager = new LinearLayoutManager(getContext(), LinearLayoutManager.HORIZONTAL, false);
        recentlyViewedRecycler.setLayoutManager(layoutManager);
        recentlyViewedAdapter = new RecentlyViewedAdapter(getContext(), recentlyViewedDataList);
        recentlyViewedRecycler.setAdapter(recentlyViewedAdapter);
    }
    //Now again we need to create a adapter and model class for recently viewed items.
    // lets do it fast.
}