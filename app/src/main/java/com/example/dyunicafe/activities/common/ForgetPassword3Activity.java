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

public class ForgetPassword3Activity extends AppCompatActivity {

    TextInputLayout textInputLayoutPass1, textInputLayoutPass2;
    TextInputLayout textInputLayout;
    Call<LoginResponse> call;
    CheckInternet checkInternet;
    MyProgressDialog progressDialog;
    String email = "";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_forget_password3);

        textInputLayoutPass1 = findViewById(R.id.pass1);
        textInputLayoutPass2 = findViewById(R.id.pass2);

        progressDialog = new MyProgressDialog(this);
        checkInternet = new CheckInternet(this);

        Intent intent = this.getIntent();
        email = intent.getStringExtra("email");

    }

    public void goOptionScreen(View view) {
        onBackPressed();
    }

    public void resetAccountFinish(View view) {
        String pass1 = textInputLayoutPass1.getEditText().getText().toString(), pass2 = textInputLayoutPass2.getEditText().getText().toString();
        if (pass1.isEmpty()) {
            textInputLayoutPass1.setErrorEnabled(true);
            textInputLayoutPass1.setError("Cannot be empty");
            return;
        } else {
            textInputLayoutPass1.setErrorEnabled(false);
        }

        if (pass2.isEmpty()) {
            textInputLayoutPass2.setErrorEnabled(true);
            textInputLayoutPass2.setError("Cannot be empty");
            return;
        } else {
            textInputLayoutPass2.setErrorEnabled(false);
        }

        if (pass1.equals(pass2)) {
            progressDialog.showDialog("Processing, please wait!");
            call = RetrofitClient.getInstance().getApi().resetPass3(email, pass1, pass2);
            call.enqueue(new Callback<LoginResponse>() {
                @Override
                public void onResponse(Call<LoginResponse> call, Response<LoginResponse> response) {
                    progressDialog.closeDialog();
                    LoginResponse response1 = response.body();
                    if (response != null) {
                        if (!response1.isError()) {
                            progressDialog.showSuccessAlert(response1.getMessage());
                            Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
                            //add shared animation
                            Pair[] pairs = new Pair[1];//number of elements to be animated
                            pairs[0] = new Pair<View, String>(findViewById(R.id.finishResetBtn1c), "loginTransition");
                            if (android.os.Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
                                ActivityOptions options = ActivityOptions.makeSceneTransitionAnimation(ForgetPassword3Activity.this, pairs);
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
        } else {
//            textInputLayoutPass1.setErrorEnabled(true);
            textInputLayoutPass2.setErrorEnabled(true);
            textInputLayoutPass2.setError("Not equal");
        }
    }
}