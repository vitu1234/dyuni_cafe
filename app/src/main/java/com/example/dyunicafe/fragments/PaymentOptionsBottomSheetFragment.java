package com.example.dyunicafe.fragments;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;

import com.example.dyunicafe.R;
import com.example.dyunicafe.activities.Payment1Activity;
import com.example.dyunicafe.storage.SharedPrefManager;
import com.example.dyunicafe.utils.CheckInternet;
import com.example.dyunicafe.utils.MyProgressDialog;
import com.google.android.material.bottomsheet.BottomSheetDialogFragment;

import java.util.List;

import retrofit2.Call;


public class PaymentOptionsBottomSheetFragment extends BottomSheetDialogFragment {

    LinearLayout linearLayoutCash, linearLayoutNetsoft, linearLayoutPaypal;
    int qty, product_id;
    String amount;

    SharedPrefManager sharedPrefManager;

    CheckInternet checkInternet;
    MyProgressDialog progressDialog;

    public PaymentOptionsBottomSheetFragment() {
        // Required empty public constructor
    }


    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
            product_id = getArguments().getInt("product_id", -1);
            qty = getArguments().getInt("product_quantity", -1);
            amount = getArguments().getString("amount");
        } else {
            getActivity().finish();
        }
        Log.e("am",amount);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_payment_options_bottom_sheet, container, false);
        progressDialog = new MyProgressDialog(this.getContext());
        checkInternet = new CheckInternet(this.getContext());
        sharedPrefManager = new SharedPrefManager(this.getContext());

        linearLayoutNetsoft = view.findViewById(R.id.linearMobile);
        linearLayoutPaypal = view.findViewById(R.id.linearVisa);

        linearLayoutNetsoft.setOnClickListener(v -> payWithMobileMoney());
        linearLayoutPaypal.setOnClickListener(v -> payWithPaypal());

        return view;
    }

    private void payWithMobileMoney() {
    }

    private void payWithPaypal() {
        Intent intent = new Intent(getActivity(), Payment1Activity.class);
        intent.putExtra("amount", amount);
        intent.putExtra("product_id", product_id);
        intent.putExtra("product_quantity", qty);
        Log.e("ee", String.valueOf(amount));
        startActivity(intent);
    }

}