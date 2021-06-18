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

public class ForgetPassword1Activity extends AppCompatActivity {

    TextInputLayout textInputLayout;
    Call<LoginResponse> call;
    CheckInternet checkInternet;
    MyProgressDialog progressDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_forget_password1);
        textInputLayout = findViewById(R.id.emailForget);

        progressDialog = new MyProgressDialog(this);
        checkInternet = new CheckInternet(this);
    }

    public void goOptionScreen(View view) {
        onBackPressed();
    }

    //validation functions
    private boolean validateEmail() {
        //get data and validate
        String mail = textInputLayout.getEditText().getText().toString();
        String check_spaces = "[a-zA-Z0-9._-]+@[a-z]+\\.+[a-z]+";
        if (mail.isEmpty()) {
            textInputLayout.setError("Enter an Email");
            return false;
        } else {
            if (!mail.matches(check_spaces)) {
                textInputLayout.setError("White spaces not allowed!");
                return false;
            } else {
                textInputLayout.setError(null);
                textInputLayout.setErrorEnabled(false);
                return true;
            }


        }
    }

    public void resetEmail(View view) {
        if (checkInternet.isInternetConnected(this)) {
            if (validateEmail()) {
                sendVerificationCode();
            } else {
                progressDialog.showDangerAlert("Email seems to be invalid, please check format!");
            }
        } else {
            checkInternet.showInternetDialog(this);
        }
    }

    private void sendVerificationCode() {
        progressDialog.showDialog("Processing, please wait!");
        String email = textInputLayout.getEditText().getText().toString().trim();
        call = RetrofitClient.getInstance().getApi().resetPass1(email);
        call.enqueue(new Callback<LoginResponse>() {
            @Override
            public void onResponse(Call<LoginResponse> call, Response<LoginResponse> response) {
                LoginResponse response1 = response.body();
                progressDialog.closeDialog();
                if (response != null) {
                    if (!response1.isError()) {
                        Intent intent = new Intent(getApplicationContext(), ForgetPassword2Activity.class);
                        intent.putExtra("email",email);
                        //add shared animation
                        Pair[] pairs = new Pair[1];//number of elements to be animated
                        pairs[0] = new Pair<View, String>(findViewById(R.id.nextFrgtBtn1), "signupTransition");
                        if (android.os.Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
                            ActivityOptions options = ActivityOptions.makeSceneTransitionAnimation(ForgetPassword1Activity.this, pairs);
                            startActivity(intent, options.toBundle());
                        } else {
                            startActivity(intent);
                        }
                        finish();
                    } else {
                        progressDialog.showDangerAlert(response1.getMessage());
                    }
                } else {
                    progressDialog.showDangerAlert("No server response!");
                }
            }

            @Override
            public void onFailure(Call<LoginResponse> call, Throwable t) {
                try {
                    progressDialog.closeDialog();
                    progressDialog.showDangerAlert("Failed communicating with server!");
                } catch (Exception e) {

                }
            }
        });

    }

    @Override
    protected void onStop() {
        super.onStop();
        if (call != null) {
            call.cancel();
        }
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        if (call != null) {
            call.cancel();
        }
    }
}