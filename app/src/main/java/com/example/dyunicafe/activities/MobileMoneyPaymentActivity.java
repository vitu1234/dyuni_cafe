package com.example.dyunicafe.activities;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.widget.ImageView;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import com.example.dyunicafe.R;
import com.example.dyunicafe.api.RetrofitClient;
import com.example.dyunicafe.models.LoginResponse;
import com.example.dyunicafe.storage.SharedPrefManager;
import com.example.dyunicafe.utils.CheckInternet;
import com.example.dyunicafe.utils.MyProgressDialog;
import com.facebook.shimmer.ShimmerFrameLayout;
import com.opensooq.supernova.gligar.GligarPicker;

import java.io.File;

import okhttp3.MediaType;
import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MobileMoneyPaymentActivity extends AppCompatActivity {
    ImageView imageView, imageViewLicense;
    private static final int PICKER_REQUEST_CODE = 100;
    File imgFile;
    Call<LoginResponse> call;
    MyProgressDialog progressDialog;
    CheckInternet checkInternet;
    SharedPrefManager sharedPrefManager;
    ShimmerFrameLayout shimmerFrameLayout;
    String token, amount;
    int product_id, qty;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_mobile_money_payment);

        imageView = findViewById(R.id.imgProfile);
        imageViewLicense = findViewById(R.id.imageLicense);
        progressDialog = new MyProgressDialog(this);
        checkInternet = new CheckInternet(this);
        shimmerFrameLayout = findViewById(R.id.shimmer_view_containerLicense);
        shimmerFrameLayout.startShimmer();

        sharedPrefManager = new SharedPrefManager(getApplicationContext());

        Intent intent = this.getIntent();
        product_id = intent.getIntExtra("product_id", -1);
        qty = intent.getIntExtra("product_quantity", -1);
        amount = intent.getStringExtra("amount");
    }

    public void backToome(View view) {
        onBackPressed();
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (resultCode != Activity.RESULT_OK) {
            return;
        }
        switch (requestCode) {
            case PICKER_REQUEST_CODE: {
                String pathsList[] = data.getExtras().getStringArray(GligarPicker.IMAGES_RESULT); // return list of selected images paths.
//                Toast.makeText(this, "Images: "+pathsList.length, Toast.LENGTH_SHORT).show();
//                imagesCount.text = "Number of selected Images: " + pathsList.length;
                imgFile = new File(pathsList[0]);
                if (imgFile.exists()) {

                    Bitmap myBitmap = BitmapFactory.decodeFile(imgFile.getAbsolutePath());
                    imageView.setImageBitmap(myBitmap);
                    //check if there is an internet connection
                    upload();


                }
                break;
            }
        }
    }

    public void pickTransactionImage(View view) {
        new GligarPicker().limit(1).requestCode(PICKER_REQUEST_CODE).withActivity(this).show();
    }

    private void upload() {
        if (checkInternet.isInternetConnected(getApplicationContext())) {
            //save user


            int user_id = sharedPrefManager.getUser().getUser_id();
            progressDialog.showDialog("Uploading, please wait...");
            RequestBody reqBody = RequestBody.create(MediaType.parse("multipart/form-file"), imgFile);
            MultipartBody.Part partImage = MultipartBody.Part.createFormData("file[]", imgFile.getName(), reqBody);
            call = RetrofitClient.getInstance().getApi().payMobile(partImage, user_id, product_id, qty);

            call.enqueue(new Callback<LoginResponse>() {
                @Override
                public void onResponse(Call<LoginResponse> call, Response<LoginResponse> response) {
                    LoginResponse loginResponse = response.body();
                    progressDialog.closeDialog();
                    if (!(loginResponse == null)) {
                        if (!loginResponse.isError()) {
                            progressDialog.showSuccessAlert(loginResponse.getMessage());

                            //delay
                            new Handler().postDelayed(new Runnable() {
                                @Override
                                public void run() {
                                    startActivity(new Intent(getApplicationContext(), MyOrdersHistoryActivity.class));
                                    finish();
                                }
                            }, 1000);

                        } else {
                            progressDialog.showDangerAlert(loginResponse.getMessage());
                        }
                    } else {
                        progressDialog.showDangerAlert("Got no response");
                    }

                }

                @Override
                public void onFailure(Call<LoginResponse> call, Throwable t) {
                    progressDialog.closeDialog();
                    try {
                        progressDialog.showDangerAlert("An error occured, try again later!");
                    } catch (Exception e) {

                    }
                }
            });
        } else {
            checkInternet.showInternetDialog(this);
        }
    }

}