package com.example.dyunicafe.activities;


import android.app.Activity;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Build;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import com.example.dyunicafe.R;
import com.example.dyunicafe.api.RetrofitClient;
import com.example.dyunicafe.models.GetPictureResponse;
import com.example.dyunicafe.models.LoginResponse;
import com.example.dyunicafe.models.User;
import com.example.dyunicafe.storage.SharedPrefManager;
import com.example.dyunicafe.utils.CheckInternet;
import com.example.dyunicafe.utils.MyProgressDialog;
import com.facebook.shimmer.ShimmerFrameLayout;
import com.opensooq.supernova.gligar.GligarPicker;
import com.squareup.picasso.Picasso;

import java.io.File;

import de.hdodenhof.circleimageview.CircleImageView;
import okhttp3.MediaType;
import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ProfileActivity extends AppCompatActivity {

    //retrofit object
    Call<LoginResponse> call;
    //loading thingy
    MyProgressDialog progressDialog;
    CheckInternet checkInternet;
    SharedPrefManager manager;

    //initialize views
    EditText passwordTxt1, passwordTxt2, passwordTxt3, phone_number;

    TextView driver_name, driver_phone, driver_email;
    CircleImageView img;


    private static final int PICKER_REQUEST_CODE = 100;
    File imgFile;
    Call<GetPictureResponse> callImage;
    SharedPrefManager sharedPrefManager;
    ShimmerFrameLayout shimmerFrameLayout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);
        //hooks
        passwordTxt1 = findViewById(R.id.current_pwd);
        passwordTxt2 = findViewById(R.id.new_pwd);
        passwordTxt3 = findViewById(R.id.con_pwd);
        driver_email = findViewById(R.id.profile_driver_email);
        driver_phone = findViewById(R.id.profile_driver_phone);
        driver_name = findViewById(R.id.profile_driver_name);
        phone_number = findViewById(R.id.new_phone);
        img = findViewById(R.id.profile_user_pic);
        progressDialog = new MyProgressDialog(this);
        checkInternet = new CheckInternet(this);

        shimmerFrameLayout = findViewById(R.id.shimmer_view_containerProfile);
        shimmerFrameLayout.startShimmer();

        sharedPrefManager = new SharedPrefManager(getApplicationContext());


        //stored user
        User user = SharedPrefManager.getInstance(getApplicationContext()).getUser();
        driver_name.setText(user.getFullname());
        driver_phone.setText(user.getPhone());
        driver_email.setText(user.getEmail());

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            phone_number.isFocusedByDefault();
            passwordTxt1.isFocusedByDefault();
            passwordTxt2.isFocusedByDefault();
            passwordTxt3.isFocusedByDefault();
        }

        setProfileImage();
    }

    public void pickProfileImagex(View view) {
        new GligarPicker().limit(1).requestCode(PICKER_REQUEST_CODE).withActivity(this).show();

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
                    img.setImageBitmap(myBitmap);
                    //check if there is an internet connection
                    changeProfile();


                }
                break;
            }
        }
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
//        if(call != null){
//            call.cancel();
//        }
    }

    @Override
    protected void onStop() {
        super.onStop();
//        if(call != null){
//            call.cancel();
//        }
    }

    //change driver account password
    public void changePassword(View view) {

        String password1 = passwordTxt1.getText().toString().trim();
        String password2 = passwordTxt2.getText().toString().trim();
        String password3 = passwordTxt3.getText().toString().trim();

        //validate the fields
        if (password1.isEmpty()) {
            passwordTxt1.setError("Password is required");
            passwordTxt1.requestFocus();
            return;
        }

        if (password2.isEmpty()) {
            passwordTxt2.setError("Password is required");
            passwordTxt2.requestFocus();
            return;
        }
        if (password2.length() < 6) {
            passwordTxt2.setError("Minimum password length is 6 characters long");
            passwordTxt2.requestFocus();
            return;
        }
        if (password3.isEmpty()) {
            passwordTxt3.setError("Password is required");
            passwordTxt3.requestFocus();
            return;
        }

        if (!password2.equals(password3)) {
            passwordTxt3.setError("Passwords do not match");
            passwordTxt2.requestFocus();
            passwordTxt3.requestFocus();
            return;
        }

//        loadingDialog.showDialog();
//        //stored user
        User user = SharedPrefManager.getInstance(getApplicationContext()).getUser();
        int user_id = user.getUser_id();
        call = RetrofitClient.getInstance().getApi().changePassword(user_id, password1, password2);

        if (checkInternet.isInternetConnected(getApplicationContext())) {
            progressDialog.showDialog("Changing...");
            call.enqueue(new Callback<LoginResponse>() {
                @Override
                public void onResponse(Call<LoginResponse> call, Response<LoginResponse> response) {
                    LoginResponse loginResponse = response.body();
                    progressDialog.closeDialog();
                    if (!(loginResponse == null)) {
                        if (!loginResponse.isError()) {
                            progressDialog.showSuccessAlert(loginResponse.getMessage());
                        } else {
                            progressDialog.showDangerAlert(loginResponse.getMessage());
                        }

                    } else {
                        progressDialog.showDangerAlert("An error occured, try again lat2er!");
                    }
                }

                @Override
                public void onFailure(Call<LoginResponse> call, Throwable t) {
                    try {
                        progressDialog.closeDialog();
                        progressDialog.showDangerAlert("An error occured, please try again!");
                    } catch (Exception e) {
                        e.printStackTrace();
                    }
                }
            });
        } else {
            progressDialog.showDangerAlert("Internet connection unavailable!");
        }

    }

    public void changePhone(View view) {
        String new_phone = phone_number.getText().toString().trim();
        //validate the fields
        if (new_phone.isEmpty()) {
            phone_number.setError("Phone Number is required");
            phone_number.requestFocus();
            return;
        }

        if (new_phone.length() < 10) {
            phone_number.setError("Phone should have atleast 10 digits");
            phone_number.requestFocus();
            return;
        }

        if (checkInternet.isInternetConnected(getApplicationContext())) {
            progressDialog.showDangerAlert("Changing...");
            //stored user
            User user = SharedPrefManager.getInstance(getApplicationContext()).getUser();
            int user_id = user.getUser_id();
            call = RetrofitClient.getInstance().getApi().changePhone(user_id, new_phone);
            call.enqueue(new retrofit2.Callback<LoginResponse>() {
                @Override
                public void onResponse(Call<LoginResponse> call, Response<LoginResponse> response) {
                    progressDialog.closeDialog();
                    LoginResponse response1 = response.body();
                    if (!(response1 == null)) {
                        if (!response1.isError()) {
                            //save user
                            SharedPrefManager sharedPrefManager = new SharedPrefManager(getApplicationContext());
                            sharedPrefManager.saveUser(response1.getUser());
                            progressDialog.showSuccessAlert(response1.getMessage());
                        } else {
                            progressDialog.showDangerAlert(response1.getMessage());
                        }
                    } else {
                        progressDialog.showDangerAlert("An error occured, try again later!");
                    }
                }

                @Override
                public void onFailure(Call<LoginResponse> call, Throwable t) {
                    try {
                        progressDialog.closeDialog();
                        progressDialog.showDangerAlert("An error occured, try again later!");
                    } catch (Exception e) {
                        e.printStackTrace();
                    }
                }
            });

        } else {
            progressDialog.showDangerAlert("Internet Connection unavalaibale!");
        }


    }

    public void backMenu(View view) {
        finish();
    }

    //upload profile picture
    public void changeProfile() {
        if (checkInternet.isInternetConnected(getApplicationContext())) {
            //save user


            int user_id = sharedPrefManager.getUser().getUser_id();
            progressDialog.showDialog("Uploading, please wait...");
            RequestBody reqBody = RequestBody.create(MediaType.parse("multipart/form-file"), imgFile);
            MultipartBody.Part partImage = MultipartBody.Part.createFormData("file[]", imgFile.getName(), reqBody);
            callImage = RetrofitClient.getInstance().getApi().uploadProfileImage(partImage, user_id);

            callImage.enqueue(new Callback<GetPictureResponse>() {
                @Override
                public void onResponse(Call<GetPictureResponse> call, Response<GetPictureResponse> response) {
                    GetPictureResponse loginResponse = response.body();
                    progressDialog.closeDialog();
                    if (!(loginResponse == null)) {
                        if (!loginResponse.isError()) {
                            progressDialog.showSuccessAlert(loginResponse.getMessage());
                            String image = loginResponse.getPhoto();
                            String imageUri = RetrofitClient.BASE_URL2 + "images/" + image;

                            Picasso.get().load(imageUri)
                                    .into(img, new com.squareup.picasso.Callback() {
                                        @Override
                                        public void onSuccess() {
//                                            img.setVisibility(View.VISIBLE);
                                        }

                                        @Override
                                        public void onError(Exception e) {
//                                            img.setVisibility(View.GONE);
                                        }
                                    });
                        } else {
                            progressDialog.showDangerAlert(loginResponse.getMessage());
                        }
                    } else {
                        progressDialog.showDangerAlert("Got no response");
                    }

                }

                @Override
                public void onFailure(Call<GetPictureResponse> call, Throwable t) {
                    progressDialog.closeDialog();
                    try {
                        progressDialog.showDangerAlert("An error occured, try again later!");
                        Log.e("e",t.getMessage());
                    } catch (Exception e) {

                    }
                }
            });
        } else {
            checkInternet.showInternetDialog(this);
        }
    }

    //get profile picture
    private void setProfileImage() {
        //check internet
        if (checkInternet.isInternetConnected(this)) {
            //get license from server
            callImage = RetrofitClient.getInstance().getApi().getPicture(sharedPrefManager.getUser().getUser_id(), "profile");
            callImage.enqueue(new Callback<GetPictureResponse>() {
                @Override
                public void onResponse(Call<GetPictureResponse> call, Response<GetPictureResponse> response) {
                    shimmerFrameLayout.stopShimmer();
                    shimmerFrameLayout.hideShimmer();
                    if (!(response.body() == null)) {
                        GetPictureResponse response1 = response.body();

                        if (!response1.isError()) {
                            String image = response1.getPhoto();
                            String imageUri = RetrofitClient.BASE_URL2 + "images/" + image;

                            Picasso.get().load(imageUri)
                                    .placeholder(R.drawable.daeyang_logo)
                                    .error(R.drawable.daeyang_logo)
                                    .into(img);
                        } else {
                            progressDialog.showDangerAlert(response1.getMessage());
                        }
                    } else {
                        progressDialog.showDangerAlert("An error occured, try again!");
                    }
                }

                @Override
                public void onFailure(Call<GetPictureResponse> call, Throwable t) {
                    try {
                        shimmerFrameLayout.stopShimmer();
                        progressDialog.showDangerAlert("An error occured, try again!");
                    } catch (Exception e) {

                    }
                }
            });
        } else {
            checkInternet.showInternetDialog(this);
        }

    }

}