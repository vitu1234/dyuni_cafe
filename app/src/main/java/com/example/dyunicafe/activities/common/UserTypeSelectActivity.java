package com.example.dyunicafe.activities.common;

import androidx.appcompat.app.AppCompatActivity;

import android.app.ActivityOptions;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.util.Pair;
import android.view.View;

import com.example.dyunicafe.R;

public class UserTypeSelectActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_user_type_select);
    }

    public void openLoginActivity(View view) {
        Intent intent = new Intent(getApplicationContext(), LoginActivity.class);

        //add shared animation
        Pair[] pairs = new Pair[1];//number of elements to be animated
        pairs[0] = new Pair<View, String>(view.findViewById(R.id.loginBtnDirect), "loginTransition");
        if (android.os.Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            ActivityOptions options = ActivityOptions.makeSceneTransitionAnimation(this, pairs);
            startActivity(intent, options.toBundle());
        } else {
            startActivity(intent);
        }
    }

    public void openSignupActivity(View view) {
        Intent intent = new Intent(getApplicationContext(), SignUpActivity.class);

        //add shared animation
        Pair[] pairs = new Pair[1];//number of elements to be animated
        pairs[0] = new Pair<View, String>(view.findViewById(R.id.signUpBtnDirect), "loginTransition");
        if (android.os.Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            ActivityOptions options = ActivityOptions.makeSceneTransitionAnimation(this, pairs);
            startActivity(intent, options.toBundle());
        } else {
            startActivity(intent);
        }
    }
}