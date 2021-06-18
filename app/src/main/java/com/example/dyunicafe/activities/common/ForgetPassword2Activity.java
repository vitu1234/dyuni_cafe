package com.example.dyunicafe.activities.common;

import android.app.ActivityOptions;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.util.Pair;
import android.view.View;

import androidx.appcompat.app.AppCompatActivity;

import com.example.dyunicafe.R;
import com.example.dyunicafe.api.RetrofitClient;
import com.example.dyunicafe.models.LoginResponse;
import com.example.dyunicafe.utils.CheckInternet;
import com.example.dyunicafe.utils.MyProgressDialog;
import com.google.android.material.textfield.TextInputLayout;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ForgetPassword2Activity extends AppCompatActivity {
    TextInputLayout textInputLayoutCode;
    Call<LoginResponse> call;
    CheckInternet checkInternet;
    MyProgressDialog progressDialog;
    String email = "";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_forget_password2);
        progressDialog = new MyProgressDialog(this);
        checkInternet = new CheckInternet(this);
        textInputLayoutCode = findViewById(R.id.codeForget);

        Intent intent = this.getIntent();
        email = intent.getStringExtra("email");
    }

    public void goOptionScreen(View view) {
        onBackPressed();
    }

    public void resetAccount(View view) {
        String code2 = textInputLayoutCode.getEditText().getText().toString();
        if (code2.isEmpty()) {
            textInputLayoutCode.setErrorEnabled(true);
            textInputLayoutCode.setError("Enter verification code sent to your email!");
            return;
        } else {
            textInputLayoutCode.setErrorEnabled(false);
        }

            progressDialog.showDialog("Processing, please wait!");
            call = RetrofitClient.getInstance().getApi().resetPass2(email,code2);
            call.enqueue(new Callback<LoginResponse>() {
                @Override
                public void onResponse(Call<LoginResponse> call, Response<LoginResponse> response) {
                    progressDialog.closeDialog();
                    LoginResponse response1 = response.body();
                    if (response != null) {
                        if (!response1.isError()) {
                            progressDialog.showSuccessAlert(response1.getMessage());
                            Intent intent = new Intent(getApplicationContext(), ForgetPassword3Activity.class);
                            intent.putExtra("email", email);
                            //add shared animation
                            Pair[] pairs = new Pair[1];//number of elements to be animated
                            pairs[0] = new Pair<View, String>(findViewById(R.id.finishResetBtn1), "loginTransition");
                            if (android.os.Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
                                ActivityOptions options = ActivityOptions.makeSceneTransitionAnimation(ForgetPassword2Activity.this, pairs);
                                startActivity(intent, options.toBundle());
                            } else {
                                startActivity(intent);
                            }
                            finish();
                        } else {
                            progressDialog.showDangerAlert(response1.getMessage());
                        }
                    } else {
                        progressDialog.showDangerAlert("No response from server!");
                    }
                }

                @Override
                public void onFailure(Call<LoginResponse> call, Throwable t) {
                    try {
                        progressDialog.closeDialog();
                        progressDialog.showDangerAlert("Error communicating withe server!");
                    } catch (Exception e) {

                    }
                }
            });


    }
}