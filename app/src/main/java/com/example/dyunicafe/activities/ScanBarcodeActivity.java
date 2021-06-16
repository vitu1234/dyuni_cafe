package com.example.dyunicafe.activities;

import android.Manifest;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.util.SparseArray;
import android.view.SurfaceHolder;
import android.view.SurfaceView;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;

import com.example.dyunicafe.R;
import com.example.dyunicafe.api.RetrofitClient;
import com.example.dyunicafe.models.LoginResponse;
import com.example.dyunicafe.storage.SharedPrefManager;
import com.example.dyunicafe.utils.MyProgressDialog;
import com.google.android.gms.vision.CameraSource;
import com.google.android.gms.vision.Detector;
import com.google.android.gms.vision.barcode.Barcode;
import com.google.android.gms.vision.barcode.BarcodeDetector;

import java.io.IOException;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ScanBarcodeActivity extends AppCompatActivity {

    SurfaceView surfaceView;
    TextView txtBarcodeValue;
    private BarcodeDetector barcodeDetector;
    private CameraSource cameraSource;
    private static final int REQUEST_CAMERA_PERMISSION = 201;
    String intentData = "";

    int product_id, product_quantity,amount;
    MyProgressDialog progressDialog;

    Call<LoginResponse> call;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_scan_barcode);
        progressDialog = new MyProgressDialog(this);

        Intent intent = getIntent();
        product_id = intent.getIntExtra("product_id", -1);
        product_quantity = intent.getIntExtra("product_quantity", -1);
        amount = intent.getIntExtra("amount", -1);

        initViews();
        initialiseDetectorsAndSources();
    }

    private void initViews() {
        txtBarcodeValue = findViewById(R.id.txtBarcodeValue);
        surfaceView = findViewById(R.id.surfaceView);
    }

    private void initialiseDetectorsAndSources() {

        Toast.makeText(getApplicationContext(), "Barcode scanner started", Toast.LENGTH_SHORT).show();

        barcodeDetector = new BarcodeDetector.Builder(this)
                .setBarcodeFormats(Barcode.ALL_FORMATS)
                .build();

        cameraSource = new CameraSource.Builder(this, barcodeDetector)
                .setRequestedPreviewSize(1920, 1080)
                .setAutoFocusEnabled(true) //you should add this feature
                .build();

        surfaceView.getHolder().addCallback(new SurfaceHolder.Callback() {
            @Override
            public void surfaceCreated(SurfaceHolder holder) {
                try {
                    if (ActivityCompat.checkSelfPermission(ScanBarcodeActivity.this, Manifest.permission.CAMERA) == PackageManager.PERMISSION_GRANTED) {
                        cameraSource.start(surfaceView.getHolder());
                    } else {
                        ActivityCompat.requestPermissions(ScanBarcodeActivity.this, new
                                String[]{Manifest.permission.CAMERA}, REQUEST_CAMERA_PERMISSION);
                    }

                } catch (IOException e) {
                    e.printStackTrace();
                }


            }

            @Override
            public void surfaceChanged(SurfaceHolder holder, int format, int width, int height) {
            }

            @Override
            public void surfaceDestroyed(SurfaceHolder holder) {
                cameraSource.stop();
            }
        });


        barcodeDetector.setProcessor(new Detector.Processor<Barcode>() {
            @Override
            public void release() {
                Toast.makeText(getApplicationContext(), "To prevent memory leaks barcode scanner has been stopped", Toast.LENGTH_SHORT).show();
            }

            @Override
            public void receiveDetections(Detector.Detections<Barcode> detections) {
                final SparseArray<Barcode> barcodes = detections.getDetectedItems();
                if (barcodes.size() != 0) {


                    txtBarcodeValue.post(() -> {

                        intentData = barcodes.valueAt(0).displayValue;
                        txtBarcodeValue.setText(intentData);
                        surfaceView.setVisibility(View.GONE);
                        cameraSource.stop();
                        new Handler(Looper.getMainLooper()).postDelayed(() -> {
                            progressDialog.closeDialog();
//                                    addProduct(intentData);
                            makeOrder(intentData);
                        }, 1000);


                    });

                }
            }
        });
    }


    public void goback(View view) {
        onBackPressed();
    }

    @Override
    protected void onPause() {
        super.onPause();
        cameraSource.release();
        if (call != null) {
            call.cancel();
        }
    }

    @Override
    protected void onResume() {
        super.onResume();


    }

    @Override
    protected void onStop() {
        super.onStop();
        cameraSource.release();
        cameraSource.stop();
        if (call != null) {
            call.cancel();
        }
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        cameraSource.release();
        cameraSource.stop();
        if (call != null) {
            call.cancel();
        }
    }

    private void makeOrder(String textFromQr) {
        cameraSource.stop();
        if (textFromQr.equals("DYUNI_CAFE_BY_JACK")) {
            int user_id = SharedPrefManager.getInstance(this).getUser().getUser_id();
            progressDialog.showDialog("Placing order, please wait...");
            call = RetrofitClient.getInstance().getApi().makePaymentStudent(user_id, product_id, product_quantity);
            call.enqueue(new Callback<LoginResponse>() {
                @Override
                public void onResponse(Call<LoginResponse> call, Response<LoginResponse> response) {
                    LoginResponse response1 = response.body();
                    progressDialog.closeDialog();
                    if (response1 != null) {
                        if (!response1.isError()) {
                            progressDialog.showSuccessAlert(response1.getMessage());
                            //delay
                            new Handler().postDelayed(new Runnable() {
                                @Override
                                public void run() {
                                    startActivity(new Intent(getApplicationContext(), MyOrdersHistoryActivity.class));
                                    finish();
                                }
                            }, 2000);
                        } else {
                            progressDialog.showDangerAlert(response1.getMessage());
                        }
                    } else {
                        Toast.makeText(ScanBarcodeActivity.this, "No response from server!", Toast.LENGTH_SHORT).show();
                    }
                }

                @Override
                public void onFailure(Call<LoginResponse> call, Throwable t) {
                    try {
                        progressDialog.closeDialog();
                        Toast.makeText(getApplication(), "An error occured connecting to server, try again later", Toast.LENGTH_SHORT).show();
                    } catch (Exception e) {

                    }
                }
            });
        } else {

        }
    }
}