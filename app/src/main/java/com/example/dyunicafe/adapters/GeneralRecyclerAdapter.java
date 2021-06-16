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
import com.example.dyunicafe.api.RetrofitClient;
import com.example.dyunicafe.models.RecentlyViewed;
import com.example.dyunicafe.models.room_db.Meal;
import com.squareup.picasso.Picasso;

import java.util.List;

public class GeneralRecyclerAdapter extends RecyclerView.Adapter<GeneralRecyclerAdapter.MyViewHolder> {

    Context context;
    List<Meal> recentlyViewedList;

    public GeneralRecyclerAdapter(Context context, List<Meal> recentlyViewedList) {
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


        holder.name.setText(recentlyViewedList.get(position).getMeal_name());
        holder.description.setText(recentlyViewedList.get(position).getMeal_type());
        holder.price.setText("K " +recentlyViewedList.get(position).getPrice());

        //setpicture
        String image = recentlyViewedList.get(position).getImg_url();
        String imageUri = RetrofitClient.BASE_URL2 + "images/" + image;

        Picasso.get().load(imageUri)
                .placeholder(R.drawable.daeyang_logo)
                .error(R.drawable.daeyang_logo)
                .into(holder.imageView);


//        holder.imageView.setImageResource(recentlyViewedList.get(position).getBigimageurl());

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
