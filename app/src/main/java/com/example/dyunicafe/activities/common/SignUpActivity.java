package com.example.dyunicafe.activities.common;

import androidx.appcompat.app.AppCompatActivity;

import android.app.ActivityOptions;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.util.Log;
import android.util.Pair;
import android.view.View;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.Toast;

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

public class SignUpActivity extends AppCompatActivity {

    //objects
    TextInputLayout textInputLayout1Email, textInputLayoutPhone, textInputLayoutPass1, textInputLayoutPass2, textInputLayoutName;
    CheckInternet checkInternet;

    //    variables
    Call<LoginResponse> call;
    //dialog
    MyProgressDialog progressDialog = new MyProgressDialog(this);
    RadioGroup radioGroup;
    RadioButton radbut1, radbut2, radioButton3;
    String password = "", email = "", phonen = "", fullname = "", role = "";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sign_up);

        textInputLayout1Email = findViewById(R.id.emailSignup);
        textInputLayoutPass1 = findViewById(R.id.pass1Signup);
        textInputLayoutPass2 = findViewById(R.id.pass2Signup);
        textInputLayoutPhone = findViewById(R.id.phoneSignup);
        textInputLayoutName = findViewById(R.id.fullnameSignup);

        radioGroup = findViewById(R.id.roleGroup);
        radbut1 = findViewById(R.id.radioBtnStudent);
        radbut1 = findViewById(R.id.radioBtnMember);
        checkInternet = new CheckInternet(this);

    }

    public void goOptionScreen(View view) {
        Intent intent = new Intent(getApplicationContext(), UserTypeSelectActivity.class);

        //add shared animation
        Pair[] pairs = new Pair[1];//number of elements to be animated
        pairs[0] = new Pair<View, String>(view.findViewById(R.id.backBtnSignup), "loginTransition");
        if (android.os.Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            ActivityOptions options = ActivityOptions.makeSceneTransitionAnimation(this, pairs);
            startActivity(intent, options.toBundle());
        } else {
            startActivity(intent);
        }
    }

    public void toLogin(View view) {
        Intent intent = new Intent(getApplicationContext(), LoginActivity.class);

        //add shared animation
        Pair[] pairs = new Pair[1];//number of elements to be animated
        pairs[0] = new Pair<View, String>(view.findViewById(R.id.toLoginsignUpBtn), "loginTransition");
        if (android.os.Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            ActivityOptions options = ActivityOptions.makeSceneTransitionAnimation(this, pairs);
            startActivity(intent, options.toBundle());
        } else {
            startActivity(intent);
        }
    }

    public void signUp(View view) {
//        Toast.makeText(this, "Nothing yet", Toast.LENGTH_SHORT).show();
        //check if there is an active net
        if (!checkInternet.isInternetConnected(this)) {
            checkInternet.showInternetDialog(this);
            return;
        }


        //check if there is an active net
        if (!checkInternet.isInternetConnected(this)) {
            checkInternet.showInternetDialog(this);
            return;
        }

        //validations
        if (!validatePassword() | !validateEmail() | !validatePhone() | !validateRole() | !validateName()) {
            return;
        }


        progressDialog.showDialog("Creating your account...");
        call = RetrofitClient.getInstance().getApi().createUser(email, fullname, phonen, password, role);
        call.enqueue(new Callback<LoginResponse>() {
            @Override
            public void onResponse(Call<LoginResponse> call, Response<LoginResponse> response) {
                progressDialog.closeDialog();
                //response from server
                LoginResponse loginResponse = response.body();
                if (!loginResponse.isError()) {
                    Toast.makeText(SignUpActivity.this, loginResponse.getMessage(), Toast.LENGTH_SHORT).show();
                    //save user
                    SharedPrefManager sharedPrefManager = new SharedPrefManager(getApplicationContext());
                    sharedPrefManager.saveUser(loginResponse.getUser());

                    Intent intent = new Intent(getApplicationContext(), MainActivity.class);
                    intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                    startActivity(intent);
                } else {
                    Toast.makeText(SignUpActivity.this, loginResponse.getMessage(), Toast.LENGTH_SHORT).show();
                }

            }

            @Override
            public void onFailure(Call<LoginResponse> call, Throwable t) {
                try {
                    progressDialog.closeDialog();
                    Toast.makeText(SignUpActivity.this, "An error occured!", Toast.LENGTH_SHORT).show();
//                    Log.e("hehe",t.getMessage());
                } catch (Exception e) {
                    Toast.makeText(SignUpActivity.this, "Server unrecheable!", Toast.LENGTH_SHORT).show();
                }
            }
        });


    }

    private boolean validatePassword() {
        String pass1 = textInputLayoutPass1.getEditText().getText().toString();
        String pass2 = textInputLayoutPass2.getEditText().getText().toString();

        if (pass1.isEmpty()) {
            textInputLayoutPass1.setError("Enter password");
            return false;
        } else {

            if (pass2.isEmpty()) {
                textInputLayoutPass2.setError("Enter password");
                return false;
            } else {
                textInputLayoutPass2.setError(null);
                textInputLayoutPass2.setErrorEnabled(false);

                textInputLayoutPass1.setError(null);
                textInputLayoutPass1.setErrorEnabled(false);
                password = pass1;
                return true;
            }


        }


    }

    //validation functions
    private boolean validateEmail() {
        //get data and validate
        String mail = textInputLayout1Email.getEditText().getText().toString();
        String check_spaces = "[a-zA-Z0-9._-]+@[a-z]+\\.+[a-z]+";
        if (mail.isEmpty()) {
            textInputLayout1Email.setError("Enter Email");
            return false;
        } else {
            if (!mail.matches(check_spaces)) {
                textInputLayout1Email.setError("White spaces not allowed!");
                return false;
            } else {
                textInputLayout1Email.setError(null);
                textInputLayout1Email.setErrorEnabled(false);
                email = mail;
                return true;
            }


        }
    }

    //validation functions
    private boolean validatePhone() {
        //get data and validate
        String phone = textInputLayoutPhone.getEditText().getText().toString();
        String check_spaces = "^[+]?[0-9]{10,13}$";
        if (phone.isEmpty()) {
            textInputLayoutPhone.setError("Enter your phone number!");
            return false;
        } else {
            if (phone.length() >= 10) {
                if (!phone.matches(check_spaces)) {
                    textInputLayoutPhone.setError("Phone is invalid!");
                    return false;
                } else {
                    textInputLayoutPhone.setError(null);
                    textInputLayoutPhone.setErrorEnabled(false);
                    phonen = phone;
                    return true;
                }
            } else {
                textInputLayoutPhone.setError("Phone length is invalid!");
                return false;
            }


        }
    }

    private boolean validateRole() {

        if (radioGroup.getCheckedRadioButtonId() == -1) {
//            radbut1.setError("Choose an option!");
//            radbut2.setError(" ");
            Toast.makeText(this, "User can be a student, staff member or visitor", Toast.LENGTH_SHORT).show();
            return false;
        } else {
            //get selected id
            int selectedId = radioGroup.getCheckedRadioButtonId();
            radioButton3 = findViewById(selectedId);

            Toast.makeText(this, "" + radioButton3.getText(), Toast.LENGTH_SHORT).show();

//            String txt = ra
            if ("Student".equals(radioButton3.getText().toString())) {
                role = "student";
//                radbut1.setError(null);
//                radbut2.setError(null);
                return true;
            } else {
                role = "visitor_staff";
//                radbut1.setError(null);
//                radbut2.setError(null);
                return true;
            }
        }


    }

    private boolean validateName() {

        String name = textInputLayoutName.getEditText().getText().toString();
        if (name.isEmpty()) {
            textInputLayoutName.setError("Name cannot be empty!");
            return false;
        } else {
            textInputLayoutName.setError(null);
            textInputLayoutName.setErrorEnabled(false);
            fullname = name;
            return true;

        }


    }


}