package com.example.dyunicafe.activities;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import com.braintreepayments.api.dropin.DropInActivity;
import com.braintreepayments.api.dropin.DropInRequest;
import com.braintreepayments.api.dropin.DropInResult;
import com.braintreepayments.api.models.PaymentMethodNonce;
import com.example.dyunicafe.R;
import com.example.dyunicafe.activities.common.LoginActivity;
import com.example.dyunicafe.api.RetrofitClient;
import com.example.dyunicafe.models.LoginResponse;
import com.example.dyunicafe.storage.SharedPrefManager;
import com.example.dyunicafe.utils.CheckInternet;
import com.example.dyunicafe.utils.MyProgressDialog;

import java.util.HashMap;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class Payment1Activity extends AppCompatActivity {
    final int REQUEST_CODE = 1;
    //    final String get_token = RetrofitClient.BASE_URL + "braintreepayments/main.php";
//    final String send_payment_details = RetrofitClient.BASE_URL + "braintreepayments/checkout.php";
    String token, amount;
    HashMap<String, String> paramHash;

    Button btnPay;
    LinearLayout llHolder;

    MyProgressDialog progressDialog;
    CheckInternet checkInternet;
    SharedPrefManager sharedPrefManager;
    TextView textViewAmt;
    Call<LoginResponse> callGetToken, checkOutPayment, call;

    int product_id, qty;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_payment1);

        llHolder = (LinearLayout) findViewById(R.id.llHolder);
        llHolder.setVisibility(View.GONE);
        btnPay = (Button) findViewById(R.id.btnPay);
        progressDialog = new MyProgressDialog(this);
        checkInternet = new CheckInternet(this);
        sharedPrefManager = new SharedPrefManager(this);
        textViewAmt = findViewById(R.id.payAmount);
        btnPay.setOnClickListener(v -> onBraintreeSubmit());

        Intent intent = this.getIntent();
        product_id = intent.getIntExtra("product_id", -1);
        qty = intent.getIntExtra("product_quantity", -1);
        amount = intent.getStringExtra("amount");

        textViewAmt.setText("K " + (qty * Integer.parseInt(amount)));


        if (sharedPrefManager.isLoggedIn()) {
            getToken();
        } else {
            startActivity(new Intent(this, LoginActivity.class));
            finish();
        }


    }


    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if (requestCode == REQUEST_CODE) {
            if (resultCode == RESULT_OK) {
                DropInResult result = data.getParcelableExtra(DropInResult.EXTRA_DROP_IN_RESULT);
                String paymentMethodNonce = result.getPaymentMethodNonce().getNonce();
                // send paymentMethodNonce to your server
                Log.e("ddf","ehe : Nonce "+paymentMethodNonce);
                sendPaymentDetails(String.valueOf(qty * Integer.parseInt(amount)),paymentMethodNonce);
            } else if (resultCode == RESULT_CANCELED) {
                // canceled
                Log.e("ddf","cancel");
                Toast.makeText(this, "You cancelled the process", Toast.LENGTH_SHORT).show();
            } else {
                // an error occurred, checked the returned exception
                Exception exception = (Exception) data.getSerializableExtra(DropInActivity.EXTRA_ERROR);
                Log.e("sdfd",exception.getMessage());
            }
        }
    }


    private void sendPaymentDetails(String amount, String nonce) {
        progressDialog.showDialog("Processing payment...");

        checkOutPayment = RetrofitClient.getInstance().getApi().checkoutPayment(nonce, amount);
        checkOutPayment.enqueue(new Callback<LoginResponse>() {
            @Override
            public void onResponse(Call<LoginResponse> call, retrofit2.Response<LoginResponse> response) {
                LoginResponse response1 = response.body();
                progressDialog.closeDialog();
                if (response1 != null) {
                    if (!response1.isError()) {
                        String message = response1.getMessage();
                        if (message.equals("success")) {
                            payWithCashWithCard(nonce, amount);
                            Toast.makeText(Payment1Activity.this, "Transaction successful", Toast.LENGTH_LONG).show();
                        } else {
                            Toast.makeText(Payment1Activity.this, "Transaction failed", Toast.LENGTH_LONG).show();
                            Log.e("mylog", "Final Response: " + response.toString());
                        }
                    } else {
                        progressDialog.showDangerAlert("An error occured on our servers, please try again later!");
                    }
                } else {
                    progressDialog.showDangerAlert("An error occured, please try again later!");
                }
            }

            @Override
            public void onFailure(Call<LoginResponse> call, Throwable t) {
                try {
                    Log.e("e", "erroe " + t.getMessage());
                } finally {
                    progressDialog.closeDialog();
                    progressDialog.showDangerAlert("An error occured on our servers or timeout, please try again later!");
                }
            }
        });

    }

    public void onBraintreeSubmit() {
//        DropInRequest dropInRequest = new DropInRequest()
//                .tokenizationKey("sandbox_x6jgq4jn_nskdd9vk7ks6bhhf");

//        startActivityForResult.launch(dropInRequest.getIntent(this));
        DropInRequest dropInRequest = new DropInRequest()
                .clientToken(token);

        startActivityForResult(dropInRequest.getIntent(this), REQUEST_CODE);
    }

 /*   ActivityResultLauncher<Intent> startActivityForResult = registerForActivityResult(
            new ActivityResultContracts.StartActivityForResult(),
            result -> {
                Intent data = result.getData();
                System.out.println(result.getResultCode() + "ffdd");
                if (result.getResultCode() == REQUEST_CODE) {
//                    Intent data = result.getData();
                    // ...
                    DropInResult resultc = data.getParcelableExtra(DropInResult.EXTRA_DROP_IN_RESULT);
                    PaymentMethodNonce nonce = resultc.getPaymentMethodNonce();
                    String stringNonce = nonce.getNonce();
                    Log.e("mylog", "Result: " + stringNonce);
                    // Send payment price with the nonce
                    // use the result to update your UI and send the payment method nonce to your server
                    if (!amount.isEmpty()) {

                        paramHash = new HashMap<>();
                        paramHash.put("amount", String.valueOf(2));
                        paramHash.put("nonce", stringNonce);
                        sendPaymentDetails(String.valueOf(2), stringNonce);
                    }
                }else if (result.getResultCode() == AppCompatActivity.RESULT_CANCELED) {
                    // the user canceled
                    Log.e("mylog", "user canceled");
                } else {

                    // handle errors here, an exception may be available in
                    Exception error = (Exception) data.getSerializableExtra(DropInActivity.EXTRA_ERROR);
                    Log.e("mylogkjnkj", "Error : " + error.getMessage());
                }
            });*/

    public void getToken() {

        if (checkInternet.isInternetConnected(this)) {
            progressDialog.showDialog("We are contacting our servers for token, please wait...");
            callGetToken = RetrofitClient.getInstance().getApi().getBrainTreeToken();
            callGetToken.enqueue(new Callback<LoginResponse>() {
                @Override
                public void onResponse(Call<LoginResponse> call, retrofit2.Response<LoginResponse> response) {
                    progressDialog.closeDialog();
                    LoginResponse response1 = response.body();
                    if (response1 != null) {
                        if (!response1.isError()) {
                            token = response1.getMessage();
                            Log.e("token",token);
                            llHolder.setVisibility(View.VISIBLE);
                        } else {
                            progressDialog.showDangerAlert("An error occured on our servers!");
                        }
                    } else {
                        progressDialog.showDangerAlert("Sorry, failed getting token!");
                    }
                }

                @Override
                public void onFailure(Call<LoginResponse> call, Throwable t) {
                    try {

                    } catch (Exception e) {

                    } finally {
                        progressDialog.closeDialog();
                        progressDialog.showDangerAlert("An error occured, please try again later!");
//                        Toast.makeText(Payment1Activity.this, "", Toast.LENGTH_SHORT).show();
                    }
                }
            });
        } else {
            checkInternet.showInternetDialog(this);
        }

    }

    private void payWithCashWithCard(String nonce, String amount) {


        if (sharedPrefManager.isLoggedIn()) {
            int user_id = sharedPrefManager.getUser().getUser_id();
            if (checkInternet.isInternetConnected(this)) {
                progressDialog.showDialog("One more thing, please wait...");

                Log.e("final_processing","amount "+amount+" nonce: "+nonce+ "product_id: "+product_id+" qty "+qty);

                call = RetrofitClient.getInstance().getApi().makePayment(nonce, amount, user_id, product_id, qty);
                call.enqueue(new Callback<LoginResponse>() {
                    @Override
                    public void onResponse(Call<LoginResponse> call, Response<LoginResponse> response) {
                        LoginResponse response1 = response.body();
                        progressDialog.closeDialog();
                        if (response1 != null) {
                            if (!response1.isError()) {
                                progressDialog.showSuccessAlert(response1.getMessage());
                                Log.e("continues","continuing");
                                new Handler().postDelayed(() -> {
                                    Intent intent = new Intent(Payment1Activity.this, MyOrdersHistoryActivity.class);
                                    startActivity(intent);

                                }, 800);
                            } else {
                                progressDialog.showDangerAlert(response1.getMessage());
                            }
                        } else {
                            progressDialog.showDangerAlert("An error occured, try again later");
                        }
                    }

                    @Override
                    public void onFailure(Call<LoginResponse> call, Throwable t) {
                        try {
                            progressDialog.closeDialog();
                            progressDialog.showDangerAlert("An error occured, try again later");
                        } catch (Exception e) {

                        } finally {
                            progressDialog.closeDialog();
                        }
                    }
                });
            } else {
                checkInternet.showInternetDialog(this);
            }
        } else {
            startActivity(new Intent(Payment1Activity.this, LoginActivity.class));
            finish();
        }

    }
}