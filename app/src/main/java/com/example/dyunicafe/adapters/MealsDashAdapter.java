package com.example.dyunicafe.adapters;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.recyclerview.widget.RecyclerView;

import com.example.dyunicafe.activities.ProductDetails;
import com.example.dyunicafe.R;
import com.example.dyunicafe.api.RetrofitClient;
import com.example.dyunicafe.models.RecentlyViewed;
import com.example.dyunicafe.models.room_db.Meal;
import com.squareup.picasso.Picasso;

import java.util.List;

public class MealsDashAdapter extends RecyclerView.Adapter<MealsDashAdapter.RecentlyViewedViewHolder> {

    Context context;
    List<Meal> recentlyViewedList;

    public MealsDashAdapter(Context context, List<Meal> recentlyViewedList) {
        this.context = context;
        this.recentlyViewedList = recentlyViewedList;
    }

    @NonNull
    @Override
    public RecentlyViewedViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.recently_viewed_items, parent, false);

        return new RecentlyViewedViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull RecentlyViewedViewHolder holder, final int position) {

        holder.name.setText(recentlyViewedList.get(position).getMeal_name());
        holder.price.setText(recentlyViewedList.get(position).getPrice());
        holder.description.setText(recentlyViewedList.get(position).getMeal_type());
        //setpicture
        String image = recentlyViewedList.get(position).getImg_url();
        String imageUri = RetrofitClient.BASE_URL2 + "images/" + image;

        Picasso.get().load(imageUri)
                .placeholder(R.drawable.daeyang_logo)
                .error(R.drawable.daeyang_logo)
                .into(holder.imageView);

        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                Intent i = new Intent(context, ProductDetails.class);
                i.putExtra("name", recentlyViewedList.get(position).getMeal_name());
                i.putExtra("image", recentlyViewedList.get(position).getImg_url());
                i.putExtra("price", recentlyViewedList.get(position).getPrice());
                i.putExtra("desc", recentlyViewedList.get(position).getMeal_type());
                i.putExtra("product_id", recentlyViewedList.get(position).getMeal_id());
                context.startActivity(i);

            }
        });

    }

    @Override
    public int getItemCount() {
        return recentlyViewedList.size();
    }

    public static class RecentlyViewedViewHolder extends RecyclerView.ViewHolder {

        TextView name, description, price, qty, unit;
        ConstraintLayout bg;
        ImageView imageView;

        public RecentlyViewedViewHolder(@NonNull View itemView) {
            super(itemView);

            name = itemView.findViewById(R.id.product_name);
            description = itemView.findViewById(R.id.description);
            price = itemView.findViewById(R.id.price);
            qty = itemView.findViewById(R.id.qty);
            unit = itemView.findViewById(R.id.unit);
            bg = itemView.findViewById(R.id.recently_layout);
            imageView = itemView.findViewById(R.id.roundedImageView);

        }
    }

}
