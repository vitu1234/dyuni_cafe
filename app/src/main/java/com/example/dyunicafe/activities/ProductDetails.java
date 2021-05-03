package com.example.dyunicafe.activities;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.dyunicafe.R;
import com.example.dyunicafe.api.RetrofitClient;
import com.squareup.picasso.Picasso;

public class ProductDetails extends AppCompatActivity {

    ImageView img, back;
    TextView proName, proPrice, proDesc, proQty, proUnit;

    String name, price, desc, qty, unit, image;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_product_details);

        Intent i = getIntent();

         name = i.getStringExtra("name");
         image = i.getStringExtra("image");
         price = i.getStringExtra("price");
         desc = i.getStringExtra("desc");
//         qty = i.getStringExtra("qty");
//         unit = i.getStringExtra("unit");

         proName = findViewById(R.id.productName);
         proDesc = findViewById(R.id.prodDesc);
         proPrice = findViewById(R.id.prodPrice);
         img = findViewById(R.id.big_image);
         back = findViewById(R.id.back2);
         proQty = findViewById(R.id.qty);
         proUnit = findViewById(R.id.unit);

         proName.setText(name);
         proPrice.setText("K "+price);
         proDesc.setText(desc);
         proQty.setText(qty);
         proUnit.setText(unit);


//        img.setImageResource(image);
        String imageUri = RetrofitClient.BASE_URL2 + "images/" + image;

        Picasso.get().load(imageUri)
                .placeholder(R.drawable.daeyang_logo)
                .error(R.drawable.daeyang_logo)
                .into(img);


        back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                Intent i = new Intent(ProductDetails.this, MainActivity.class);
                startActivity(i);
                finish();

            }
        });

    }


   // this tutorial has been completed
    // see you in the next.
}
