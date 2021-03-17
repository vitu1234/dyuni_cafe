package com.example.dyunicafe.api;

import com.example.dyunicafe.models.LoginResponse;

import okhttp3.MultipartBody;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.Multipart;
import retrofit2.http.POST;
import retrofit2.http.PUT;
import retrofit2.http.Part;
import retrofit2.http.Path;


public interface Api {

    //POST METHODS
    //login user
    @FormUrlEncoded
    @POST("userlogin")
    //what kind of response? use ResponseBody if you don't know the kind of response that you will get
    Call<LoginResponse> loginUser(
            @Field("email") String email,
            @Field("password") String password
    );

    //register user
    @FormUrlEncoded
    @POST("createuser")
    //what kind of response? use ResponseBody if you don't know the kind of response that you will get
    Call<LoginResponse> createUser(
            @Field("email") String email,
            @Field("name") String name,
            @Field("phone") String phone,
            @Field("password") String password,
            @Field("user_type") String role
    );

    //upload licence
    @Multipart
    @POST("upload_license.php")
    Call<LoginResponse> uploadLicense(
            @Part MultipartBody.Part file,
            @Part("user_id") int user_id
    );

    //remove license from server
    @FormUrlEncoded
    @POST("delete_license")
    //what kind of response? use ResponseBody if you don't know the kind of response that you will get
    Call<LoginResponse> clearLicense(
            @Field("user_id") int user_id
    );


    //GET METHODS


}
