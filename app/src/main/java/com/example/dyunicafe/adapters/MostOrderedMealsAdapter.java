package com.example.dyunicafe.adapters;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.dyunicafe.R;
import com.example.dyunicafe.activities.ProductDetails;
import com.example.dyunicafe.api.RetrofitClient;
import com.example.dyunicafe.models.room_db.Order;
import com.squareup.picasso.Picasso;

import java.util.List;

public class MostOrderedMealsAdapter extends RecyclerView.Adapter<MostOrderedMealsAdapter.DiscountedProductViewHolder> {

    Context context;
    List<Order> discountedProductsList;

    public MostOrderedMealsAdapter(Context context, List<Order> discountedProductsList) {
        this.context = context;
        this.discountedProductsList = discountedProductsList;
    }

    @NonNull
    @Override
    public DiscountedProductViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {

        View view = LayoutInflater.from(context).inflate(R.layout.discounted_row_items, parent, false);
        return new DiscountedProductViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull DiscountedProductViewHolder holder, int position) {

        holder.textMealName.setText(discountedProductsList.get(position).getMeal_name());
        holder.textPrice.setText(discountedProductsList.get(position).getMeal_price());
        holder.textType.setText(discountedProductsList.get(position).getMeal_type());
        //setpicture
        String image = discountedProductsList.get(position).getImg_url();
        String imageUri = RetrofitClient.BASE_URL2 + "images/" + image;

        Picasso.get().load(imageUri)
                .placeholder(R.drawable.daeyang_logo)
                .error(R.drawable.daeyang_logo)
                .into(holder.discountImageView);

        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                Intent i = new Intent(context, ProductDetails.class);
                i.putExtra("name", discountedProductsList.get(position).getMeal_name());
                i.putExtra("image", discountedProductsList.get(position).getImg_url());
                i.putExtra("price", discountedProductsList.get(position).getMeal_price());
                i.putExtra("desc", discountedProductsList.get(position).getMeal_type());
                i.putExtra("product_id", discountedProductsList.get(position).getMeal_id());
                context.startActivity(i);

            }
        });
    }

    @Override
    public int getItemCount() {
        return discountedProductsList.size();
    }

    public static class DiscountedProductViewHolder extends  RecyclerView.ViewHolder{

        ImageView discountImageView;
        TextView textMealName, textPrice,textType;

        public DiscountedProductViewHolder(@NonNull View itemView) {
            super(itemView);

            discountImageView = itemView.findViewById(R.id.discountImage);
            textMealName = itemView.findViewById(R.id.most_ordered_meal_name);
            textPrice = itemView.findViewById(R.id.most_ordered_price);
            textType = itemView.findViewById(R.id.most_ordered_type);

        }
    }
}
