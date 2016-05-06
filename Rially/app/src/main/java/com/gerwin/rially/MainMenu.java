package com.gerwin.rially;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;

import java.io.File;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;
import android.Manifest;
import android.widget.Button;

public class MainMenu extends AppCompatActivity {

    static final int REQUEST_TAKE_PHOTO = 1;
    String mCurrentPhotoPath;
    Button btnViewOpdrachten;
    Button btnNewOpdracht;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main_menu);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        // The buttons
        btnViewOpdrachten = (Button) findViewById(R.id.btnViewOpdrachten);
        btnNewOpdracht = (Button) findViewById(R.id.btnNewOpdracht);

        // View opdrachten click event
        btnViewOpdrachten.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View view) {
                //Launching all opdrachten activity
                Intent i = new Intent(getApplicationContext(), ShowOpdrachten.class);
                startActivity(i);
            }
        });

        //Add opdracht click event
        btnNewOpdracht.setOnClickListener(new View.OnClickListener(){

            @Override
            public void onClick(View view) {
                //Launching create new opdracht activity
                Intent i = new Intent(getApplicationContext(), AddOpdracht.class);
                startActivity(i);
            }
        });
    }

    public void dispatchTakePictureIntent(View view) {
        Intent takePictureIntent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);

        if (takePictureIntent.resolveActivity(getPackageManager()) != null) {
            File photoFile = null;
            try {
                photoFile = createImageFile();
            } catch (IOException e) {
                e.printStackTrace();
            }
            if (photoFile != null) {
                takePictureIntent.putExtra(MediaStore.EXTRA_OUTPUT,
                        Uri.fromFile(photoFile));
                startActivityForResult(takePictureIntent, REQUEST_TAKE_PHOTO);
            }
        }
    }

    private File createImageFile() throws IOException {
        //Create an image file name
        String timeStamp = new SimpleDateFormat("yyyyMMdd_HHmmss").format(new Date());
        String imageFileName = "JPEG" + timeStamp + "_";
        File storageDir = Environment.getExternalStoragePublicDirectory(Environment.DIRECTORY_PICTURES);
        File image = File.createTempFile(
                imageFileName,
                ".jpg",
                storageDir
        );

        //Save a file: path for use with ACTION_VIEW() intents
        mCurrentPhotoPath = "file:" + image.getAbsolutePath();
        return image;
    }



}
