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

import com.example.dyunicafe.R;
import com.example.dyunicafe.activities.MyOrderDetailsActivity;
import com.example.dyunicafe.activities.ProductDetails;
import com.example.dyunicafe.api.RetrofitClient;
import com.example.dyunicafe.models.room_db.Order;
import com.squareup.picasso.Picasso;

import java.util.List;

public class MyOrdersAdapter extends RecyclerView.Adapter<MyOrdersAdapter.MyViewHolder>{
    Context context;
    List<Order> ordersList;

    public MyOrdersAdapter(Context context, List<Order> ordersList) {
        this.context = context;
        this.ordersList = ordersList;
    }

    @NonNull
    @Override
    public MyOrdersAdapter.MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.recycler_line, parent, false);

        return new MyOrdersAdapter.MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        holder.name.setText(ordersList.get(position).getMeal_name());
        holder.description.setText(ordersList.get(position).getDate_created());
        holder.price.setText("K " +ordersList.get(position).getMeal_price());

        //setpicture
        String image = ordersList.get(position).getImg_url();
        String imageUri = RetrofitClient.BASE_URL2 + "images/" + image;

        Picasso.get().load(imageUri)
                .placeholder(R.drawable.daeyang_logo)
                .error(R.drawable.daeyang_logo)
                .into(holder.imageView);


//        holder.imageView.setImageResource(ordersList.get(position).getBigimageurl());

        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                Intent i = new Intent(context, MyOrderDetailsActivity.class);
                i.putExtra("name", ordersList.get(position).getMeal_name());
                i.putExtra("image", ordersList.get(position).getImg_url());
                i.putExtra("price", ordersList.get(position).getMeal_price());
                i.putExtra("desc", ordersList.get(position).getDate_created());
                i.putExtra("product_id", ordersList.get(position).getMeal_id());
                i.putExtra("order_id", ordersList.get(position).getOrder_id());
                context.startActivity(i);

            }
        });
    }

    @Override
    public int getItemCount() {
        return ordersList.size();
    }

    public class MyViewHolder extends  RecyclerView.ViewHolder{
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
