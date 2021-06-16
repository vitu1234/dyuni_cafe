package com.example.dyunicafe.api;

import com.example.dyunicafe.models.GetMealsResponse;
import com.example.dyunicafe.models.GetOrdersResponse;
import com.example.dyunicafe.models.LoginResponse;

import okhttp3.MultipartBody;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.Multipart;
import retrofit2.http.POST;
import retrofit2.http.Part;


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

    //MAKE PAYMENT NORMAL
    @FormUrlEncoded
    @POST("make_payment_normal")
    //what kind of response? use ResponseBody if you don't know the kind of response that you will get'nonce', 'amount'
    Call<LoginResponse> makePaymentStudent(
            @Field("user_id") int user_id,
            @Field("meal_id") int product_id,
            @Field("qty") int qty
    );

    //MAKE PAYMENT VISA/CARD/PAYPAL
    @FormUrlEncoded
    @POST("make_payment_visa")
    //what kind of response? use ResponseBody if you don't know the kind of response that you will get'nonce', 'amount'
    Call<LoginResponse> makePayment(
            @Field("nonce") String nonce,
            @Field("amount") String amount,
            @Field("user_id") int user_id,
            @Field("product_id") int product_id,
            @Field("qty") int qty
    );


    @FormUrlEncoded
    @POST("checkout_payment")
        //what kind of response? use ResponseBody if you don't know the kind of response that you will get
    Call<LoginResponse> checkoutPayment(
            @Field("nonce") String nonce,
            @Field("amount") String amount
    );


    //GET METHODS
    @GET("get_menu_items")
    Call<GetMealsResponse>getMealsResponse(
    );

    @GET("get_dash_menu_items")
    Call<GetMealsResponse>getMealsDashResponse(
    );
    @GET("dashboard_orders")
    Call<GetOrdersResponse>getMostOrderMeals(
    );

    //get braintree token
    @GET("get_braintree_token")
    Call<LoginResponse> getBrainTreeToken(
    );


}
