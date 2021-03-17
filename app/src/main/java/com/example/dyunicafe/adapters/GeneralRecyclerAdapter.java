package com.example.dyunicafe.adapters;

import android.content.Context;
import android.content.Intent;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.recyclerview.widget.RecyclerView;

import com.example.dyunicafe.R;
import com.example.dyunicafe.activities.ProductDetails;
import com.example.dyunicafe.models.RecentlyViewed;

import java.util.List;

public class GeneralRecyclerAdapter extends RecyclerView.Adapter<GeneralRecyclerAdapter.MyViewHolder> {

    Context context;
    List<RecentlyViewed> recentlyViewedList;

    public GeneralRecyclerAdapter(Context context, List<RecentlyViewed> recentlyViewedList) {
        this.context = context;
        this.recentlyViewedList = recentlyViewedList;
    }

    @NonNull
    @Override
    public GeneralRecyclerAdapter.MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.recycler_line, parent, false);

        return new GeneralRecyclerAdapter.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull GeneralRecyclerAdapter.MyViewHolder holder, int position) {
//        Log.e("try12", recentlyViewedList.get(position).getName());


        holder.name.setText(recentlyViewedList.get(position).getName());
        holder.description.setText(recentlyViewedList.get(position).getDescription());
        holder.price.setText(recentlyViewedList.get(position).getPrice());
        holder.imageView.setImageResource(recentlyViewedList.get(position).getBigimageurl());

        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                Intent i = new Intent(context, ProductDetails.class);
                i.putExtra("name", recentlyViewedList.get(position).getName());
                i.putExtra("image", recentlyViewedList.get(position).getBigimageurl());
                i.putExtra("price", recentlyViewedList.get(position).getPrice());
                i.putExtra("desc", recentlyViewedList.get(position).getDescription());
                context.startActivity(i);

            }
        });
    }

    @Override
    public int getItemCount() {

        return recentlyViewedList.size();
    }

    public static class MyViewHolder extends RecyclerView.ViewHolder {

        TextView name, description, price;
        ConstraintLayout bg;
        ImageView imageView;


        public MyViewHolder(@NonNull View itemView) {
            super(itemView);

            name = itemView.findViewById(R.id.mealName);
            description = itemView.findViewById(R.id.mealType);
            price = itemView.findViewById(R.id.mealPrice);
            imageView = itemView.findViewById(R.id.mealImage);

        }
    }
}
