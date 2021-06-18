package com.example.dyunicafe.activities;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.example.dyunicafe.R;
import com.example.dyunicafe.activities.common.LoginActivity;
import com.example.dyunicafe.api.RetrofitClient;
import com.example.dyunicafe.fragments.PaymentOptionsBottomSheetFragment;
import com.example.dyunicafe.models.room_db.AppDatabase;
import com.example.dyunicafe.storage.SharedPrefManager;
import com.squareup.picasso.Picasso;

public class MyOrderDetailsActivity extends AppCompatActivity {
    ImageView img, back, imageViewScrnsht;
    TextView proName, proPrice, proDesc, proQty, proUnit, orderQtyTextView, payTextView;

    String name, price, desc, qty, unit, image;

    SharedPrefManager sharedPrefManager;

    int newOrderQty = 1, product_id, order_id;
    int amount;

    AppDatabase room_db;

    LinearLayout linearLayout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_my_order_details);
        sharedPrefManager = SharedPrefManager.getInstance(this);
        room_db = AppDatabase.getDbInstance(this);

        linearLayout = findViewById(R.id.linearPaymentMethod);

        Intent i = getIntent();


        name = i.getStringExtra("name");
        image = i.getStringExtra("image");
        price = i.getStringExtra("price");
        desc = i.getStringExtra("desc");
        product_id = i.getIntExtra("product_id", -1);
        order_id = i.getIntExtra("order_id", -1);
        amount = Integer.parseInt(price);
        qty = String.valueOf("Order Quantity: " + room_db.orderDao().getSingleOrders(order_id).getQty()+" | ");

//         unit = i.getStringExtra("unit");

        proName = findViewById(R.id.productName);
        proDesc = findViewById(R.id.prodDesc);
        proPrice = findViewById(R.id.prodPrice);
        img = findViewById(R.id.big_image);
        back = findViewById(R.id.back2);
        proQty = findViewById(R.id.qty);
        proUnit = findViewById(R.id.unit);
        orderQtyTextView = findViewById(R.id.orderingQuantity);
        payTextView = findViewById(R.id.payMethod);
        imageViewScrnsht = findViewById(R.id.imageScreenShot);
        String status = "";
        if (room_db.orderDao().getSingleOrders(order_id).getOrder_status() == 1) {
            status = "Not Collected";
        } else {
            status = "Collected";
        }


        proName.setText(name);
        proPrice.setText("Meal Price: K" + price);
        proDesc.setText("Ordered on:" + desc + " Status: " + status);
        proQty.setText(qty);
        proUnit.setText("Total Order: K" + (room_db.orderDao().getSingleOrders(order_id).getQty() * Integer.parseInt(price)));
        payTextView.setText("Payment Type: " + room_db.orderDao().getSingleOrders(order_id).getPayment_type());

        if (room_db.orderDao().getSingleOrders(order_id).getPayment_type().contains("Mobile")) {
            linearLayout.setVisibility(View.VISIBLE);
            String imageUri = RetrofitClient.BASE_URL2 + "images/" + room_db.orderDao().getSingleOrders(order_id).getScreenshot();

            Picasso.get().load(imageUri)
                    .placeholder(R.drawable.daeyang_logo)
                    .error(R.drawable.daeyang_logo)
                    .into(imageViewScrnsht);
        }

//        img.setImageResource(image);
        String imageUri = RetrofitClient.BASE_URL2 + "images/" + image;

        Picasso.get().load(imageUri)
                .placeholder(R.drawable.daeyang_logo)
                .error(R.drawable.daeyang_logo)
                .into(img);


        back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                onBackPressed();

            }
        });

    }

    public void makeOrder(View view) {
        //check if logged in
        if (sharedPrefManager.isLoggedIn()) {
            if (sharedPrefManager.getUser().getUser_role().equals("student")) {
                Intent intent = new Intent(this, ScanBarcodeActivity.class);
                intent.putExtra("product_quantity", newOrderQty);
                intent.putExtra("product_id", product_id);
                intent.putExtra("amount", price);
                startActivity(intent);
            } else {
                PaymentOptionsBottomSheetFragment bottomSheetFragment = new PaymentOptionsBottomSheetFragment();
                Bundle bundle = new Bundle();
                bundle.putInt("product_id", product_id);
                bundle.putInt("product_quantity", newOrderQty);
                bundle.putString("amount", price);
                bottomSheetFragment.setArguments(bundle);
                bottomSheetFragment.show(getSupportFragmentManager(), bottomSheetFragment.getTag());
            }
        } else {
            startActivity(new Intent(this, LoginActivity.class));
        }

    }

    public void reduceQuantity(View view) {
        String qtyNow = orderQtyTextView.getText().toString();
        if (Integer.parseInt(qtyNow) > 1) {
            newOrderQty = Integer.parseInt(qtyNow) - 1;
            orderQtyTextView.setText(String.valueOf(newOrderQty));
            proPrice.setText("K " + (Integer.parseInt(price) * newOrderQty));

        } else {
            Toast.makeText(this, "Minimum order quantity is 1", Toast.LENGTH_SHORT).show();
        }
    }

    public void addQuantity(View view) {
        String qtyNow = orderQtyTextView.getText().toString();
        if (Integer.parseInt(qtyNow) <= 10) {
            newOrderQty = Integer.parseInt(qtyNow) + 1;
            orderQtyTextView.setText(String.valueOf(newOrderQty));
            proPrice.setText("K " + (Integer.parseInt(price) * newOrderQty));
        } else {
            Toast.makeText(this, "Maximum order quantity is 10", Toast.LENGTH_SHORT).show();
        }
    }

    public void openHistoryActivity(View view) {
        startActivity(new Intent(this, MyOrdersHistoryActivity.class));
    }


    // this tutorial has been completed
    // see you in the next.
}