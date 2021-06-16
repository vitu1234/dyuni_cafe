package com.example.dyunicafe.activities;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.View;

import com.example.dyunicafe.R;

public class MobileMoneyPaymentActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_mobile_money_payment);
    }

    public void backToome(View view) {
        onBackPressed();
    }

    public void pickTransactionImage(View view) {
    }
}