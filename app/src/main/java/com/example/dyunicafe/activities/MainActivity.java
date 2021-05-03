package com.example.dyunicafe.activities;
import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;

import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.example.dyunicafe.R;
import com.example.dyunicafe.activities.common.UserTypeSelectActivity;
import com.example.dyunicafe.fragments.AboutAppFragment;
import com.example.dyunicafe.fragments.DashboardFragment;
import com.example.dyunicafe.fragments.MealsListFragment;
import com.example.dyunicafe.fragments.MyOrdersFragment;
import com.example.dyunicafe.fragments.NeedHelpFragment;
import com.example.dyunicafe.fragments.UserProfileFragment;
import com.example.dyunicafe.storage.SharedPrefManager;
import com.google.android.material.navigation.NavigationView;


public class
MainActivity extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener {

    //    ?DRAWER MENU
    static final float END_SCALE = 0.7f;
    DrawerLayout drawerLayout;
    NavigationView navigationView;
    ImageView menu_icon;
    LinearLayout contentView;
    TextView textVietitle;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
//        HOOKS
//        menu hooks
        drawerLayout = findViewById(R.id.drawer_layout);
        navigationView = findViewById(R.id.design_navigation_view);
        menu_icon = findViewById(R.id.menu_icon_btn);
        textVietitle = findViewById(R.id.app_title);

        contentView = findViewById(R.id.content);
//        changeAppTitleText("Magik Rentals");

        //opena navigation drawer
        openNavigationDrawer();

        displayFragment(new DashboardFragment());

        //check received any data
//        if (savedInstanceState == null) {
//            Bundle extras = getIntent().getExtras();
//            Intent intent = getIntent();
//            if (extras != null) {
//                if (intent.hasExtra("car_details_id") && !extras.getString("car_details_id").equals(null)) {
//                    Bundle bundle = new Bundle();
//                    bundle.putString("car_id_view", extras.getString("car_details_id"));
//                    //start the activity
//                    Fragment co = new CarDetailsFragment();
//                    co.setArguments(bundle);
//                    getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, co, null).commit();
//                } else if (intent.hasExtra("toCarList") && !extras.getString("toCarList").equals(null)) {
//                    //start the activity
//                    Fragment co = new MealsListFragment();
//                    getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, co, null).commit();
//                }
//            }
//        }

        //hide some menu items if logged in or not
        loginMenuSetting();
    }

    //    NAVIGATION DRAWER
    private void openNavigationDrawer() {
        navigationView.bringToFront();
        navigationView.setNavigationItemSelectedListener(this);
        navigationView.setCheckedItem(R.id.nav_home);
        MenuItem item = navigationView.getCheckedItem();

        menu_icon.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (drawerLayout.isDrawerVisible(GravityCompat.START)) {
                    drawerLayout.closeDrawer(GravityCompat.START);
                } else {
                    drawerLayout.openDrawer(GravityCompat.START);
                }
            }
        });
//        Animating the navigation drawer
        animateNavigationDrawer();

    }

    //        Animating the navigation drawer
    private void animateNavigationDrawer() {
        drawerLayout.setScrimColor(getResources().getColor(R.color.drawerOpacity));


        drawerLayout.addDrawerListener(new DrawerLayout.DrawerListener() {
            @Override
            public void onDrawerSlide(@NonNull View drawerView, float slideOffset) {
                //scALE the view based on the current slide offset
                final float diffScaledOffset = slideOffset * (1 - END_SCALE);
                final float offsetScale = 1 - diffScaledOffset;
                contentView.setScaleX(offsetScale);
                contentView.setScaleY(offsetScale);

                //translate the view, accounting for the scaled width
                final float xOffset = drawerView.getWidth() * slideOffset;
                final float xOffsetDiff = contentView.getWidth() * diffScaledOffset / 2;
                final float xTranslation = xOffset - xOffsetDiff;
                contentView.setTranslationX(xTranslation);

            }

            @Override
            public void onDrawerOpened(@NonNull View drawerView) {

            }

            @Override
            public void onDrawerClosed(@NonNull View drawerView) {

            }

            @Override
            public void onDrawerStateChanged(int newState) {

            }
        });
    }

    //prevent closing drawer if back button is pressed
    @Override
    public void onBackPressed() {
        if (drawerLayout.isDrawerVisible(GravityCompat.START)) {
            drawerLayout.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @Override
    public boolean onNavigationItemSelected(@NonNull MenuItem item) {

        drawerLayout.closeDrawers();
        switch (item.getItemId()) {

            case R.id.nav_car_list:
                displayFragment(new MealsListFragment());
                break;
            case R.id.nav_logout:
                logout();
                break;
            case R.id.nav_login:
                startActivity(new Intent(this, UserTypeSelectActivity.class));
                break;
            case R.id.nav_home:
                displayFragment(new DashboardFragment());
                break;

            case R.id.nav_needHelp:
                displayFragment(new NeedHelpFragment());
                break;

            case R.id.nav_about_app:
                displayFragment(new AboutAppFragment());
                break;
            case R.id.nav_profile:
                displayFragment(new UserProfileFragment());
                break;

            case R.id.nav_order_history:
                displayFragment(new MyOrdersFragment());
                break;
        }


        return true;
    }
    //logout the person from the app
    private void logout() {
        //get stored data
        SharedPrefManager sharedPrefManager = new SharedPrefManager(getApplicationContext());
        sharedPrefManager.logoutUser();
        //closee all existing activities to avoid showing them once user is logged in
        Intent intent = new Intent(getApplicationContext(), MainActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
    }

    //hooking fragments
    private void displayFragment(Fragment fragment) {
        getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, fragment, null).commit();
    }

    //changing view items when logged in or not
    private void loginMenuSetting(){
        Menu menu = navigationView.getMenu();
        SharedPrefManager sharedPrefManager = new SharedPrefManager(getApplicationContext());
        if (sharedPrefManager.isLoggedIn()) {
            menu.findItem(R.id.nav_login).setVisible(false);
            menu.findItem(R.id.nav_logout).setVisible(true);
            menu.findItem(R.id.nav_profile).setVisible(true);
            menu.findItem(R.id.nav_order_history).setVisible(true);
        }else{
            menu.findItem(R.id.nav_logout).setVisible(false);
            menu.findItem(R.id.nav_profile).setVisible(false);
            menu.findItem(R.id.nav_order_history).setVisible(false);
            menu.findItem(R.id.nav_login).setVisible(true);
        }



    }

//    public void changeAppTitleText(String title){
//        textVietitle.setText(title);
//    }


}