package com.example.dyunicafe.activities.common;

import android.app.ActivityOptions;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.util.Pair;
import android.view.View;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.example.dyunicafe.R;
import com.example.dyunicafe.activities.MainActivity;
import com.example.dyunicafe.api.RetrofitClient;
import com.example.dyunicafe.models.LoginResponse;
import com.example.dyunicafe.storage.SharedPrefManager;
import com.example.dyunicafe.utils.CheckInternet;
import com.example.dyunicafe.utils.MyProgressDialog;
import com.google.android.material.textfield.TextInputLayout;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class LoginActivity extends AppCompatActivity {

    //    variables
    Call<LoginResponse> call;
    CheckInternet checkInternet = new CheckInternet(this);
    TextInputLayout textEmail, textPassword;
    //dialog
    MyProgressDialog progressDialog = new MyProgressDialog(this);

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        //hooks
        textEmail = findViewById(R.id.emailLogin);
        textPassword = findViewById(R.id.pwdLogin);
    }

    //open login activity
    public void loginUser(View view) {

        //check if there is an active net
        if (!checkInternet.isInternetConnected(this)) {
            checkInternet.showInternetDialog(this);
            return;
        }
        //get values
        String email = textEmail.getEditText().getText().toString().trim();
        String password = textPassword.getEditText().getText().toString().trim();
        //getting token from shared preferences
        //validations
        if (!validatePassword() | !validateEmail()) {
            return;
        }

        progressDialog.showDialog("Checking...");
        //login the person
        call = RetrofitClient.getInstance().getApi().loginUser(email, password);
        call.enqueue(new Callback<LoginResponse>() {
            @Override
            public void onResponse(Call<LoginResponse> call, Response<LoginResponse> response) {
                LoginResponse response1 = response.body();
                if (!response1.isError()) {
                    Toast.makeText(LoginActivity.this, response1.getMessage(), Toast.LENGTH_SHORT).show();
                    //save user
                    SharedPrefManager sharedPrefManager = new SharedPrefManager(getApplicationContext());
                    sharedPrefManager.saveUser(response1.getUser());
                    progressDialog.closeDialog();
                    Intent intent = new Intent(getApplicationContext(), MainActivity.class);
                    intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                    startActivity(intent);
//                    finish();

                } else {
                    progressDialog.closeDialog();
                    Toast.makeText(LoginActivity.this, response1.getMessage(), Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<LoginResponse> call, Throwable t) {
                try {
                    progressDialog.closeDialog();
                    Toast.makeText(LoginActivity.this, "An error occured!", Toast.LENGTH_SHORT).show();
                } catch (Exception e) {
                    Toast.makeText(LoginActivity.this, "An error occured, on server side, try again!", Toast.LENGTH_SHORT).show();
                }
            }
        });
    }

    //open create account
    public void openCreateAccount(View view) {
        Intent intent = new Intent(getApplicationContext(), SignUpActivity.class);

        //add shared animation
        Pair[] pairs = new Pair[1];//number of elements to be animated
        pairs[0] = new Pair<View, String>(view.findViewById(R.id.signUpBtn), "signupTransition");
        if (android.os.Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            ActivityOptions options = ActivityOptions.makeSceneTransitionAnimation(this, pairs);
            startActivity(intent, options.toBundle());
        } else {
            startActivity(intent);
        }
    }

    //go back
    public void gotoMenu(View view) {

        Intent intent = new Intent(getApplicationContext(), UserTypeSelectActivity.class);

        //add shared animation
        Pair[] pairs = new Pair[1];//number of elements to be animated
        pairs[0] = new Pair<View, String>(view.findViewById(R.id.backBtnLogin), "loginTransition");
        if (android.os.Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            ActivityOptions options = ActivityOptions.makeSceneTransitionAnimation(this, pairs);
            startActivity(intent, options.toBundle());
        } else {
            startActivity(intent);
        }

//        startActivity(new Intent(this, UserTypeSelectActivity.class));
    }

    private boolean validatePassword() {
        String password = textPassword.getEditText().getText().toString().trim();
        if (password.isEmpty()) {
            textPassword.setError("Enter password");
            return false;
        } else {
            textPassword.setError(null);
            textPassword.setErrorEnabled(false);
            return true;

        }


    }

    //validation functions
    private boolean validateEmail() {
        String mail = textEmail.getEditText().getText().toString().trim();
        String check_spaces = "[a-zA-Z0-9._-]+@[a-z]+\\.+[a-z]+";
        if (mail.isEmpty()) {
            textEmail.setError("Enter Email");
            return false;
        } else {
            if (!mail.matches(check_spaces)) {
                textEmail.setError("White spaces not allowed!");
                return false;
            } else {
                textEmail.setError(null);
                textEmail.setErrorEnabled(false);
                return true;
            }


        }
    }

    public void gotoForget(View view) {
        Intent intent = new Intent(getApplicationContext(), ForgetPassword1Activity.class);
        //add shared animation
        Pair[] pairs = new Pair[1];//number of elements to be animated
        pairs[0] = new Pair<View, String>(findViewById(R.id.forgetBtn), "signupTransition");
        if (android.os.Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            ActivityOptions options = ActivityOptions.makeSceneTransitionAnimation(LoginActivity.this, pairs);
            startActivity(intent, options.toBundle());
        } else {
            startActivity(intent);
        }
    }
}