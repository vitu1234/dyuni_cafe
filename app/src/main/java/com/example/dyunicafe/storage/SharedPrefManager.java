package com.example.dyunicafe.storage;

import android.content.Context;
import android.content.SharedPreferences;

import com.example.dyunicafe.models.User;

public class SharedPrefManager {
    private static String SHARED_PREF_NAME ="USER_DATA";
    private Context context;
    private static SharedPrefManager mInstance;

    public SharedPrefManager(Context context) {
        this.context = context;
    }

    public static synchronized SharedPrefManager getInstance(Context context){
        if (mInstance == null){
            mInstance = new SharedPrefManager(context);
        }
        return mInstance;
    }

    //store user into the pref
    public void saveUser(User user){
        SharedPreferences sharedPreferences = context.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();

        editor.putInt("user_id",user.getUser_id());
        editor.putInt("account_status",user.getAccount_status());
        editor.putString("fullname",user.getFullname());
        editor.putString("email",user.getEmail());
        editor.putString("user_role",user.getUser_role());
        editor.putString("phone",user.getPhone());
        editor.putString("account_balance",user.getAccount_balance());
        editor.apply();
    }

    public boolean isLoggedIn(){
        SharedPreferences sharedPreferences = context.getSharedPreferences(SHARED_PREF_NAME,Context.MODE_PRIVATE);

        //if value = -1 that means not logged in
        if(sharedPreferences.getInt("user_id", -1) != -1){
            return true;
        }else{
            return false;
        }
    }
    //    int user_id, int user_status, String fullname, String email, String phone, String gender, String dob, String role
    public User getUser(){
        SharedPreferences sharedPreferences = context.getSharedPreferences(SHARED_PREF_NAME,Context.MODE_PRIVATE);
        User user = new User(
                sharedPreferences.getInt("user_id",-1),
                sharedPreferences.getInt("account_status",-1),
                sharedPreferences.getString("fullname",null),
                sharedPreferences.getString("email",null),
                sharedPreferences.getString("phone",null),
                sharedPreferences.getString("user_role",null),
                sharedPreferences.getString("account_balance",null)
        );
        return user;

    }

    public void logoutUser(){
        SharedPreferences sharedPreferences = context.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();

        editor.clear();
        editor.apply();
    }

}