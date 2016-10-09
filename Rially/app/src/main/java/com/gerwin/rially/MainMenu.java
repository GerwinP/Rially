package com.gerwin.rially;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.database.Cursor;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;

import java.io.File;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;
import android.Manifest;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.RelativeLayout;

import com.gerwin.rially.testActivities.testActivity;

public class MainMenu extends AppCompatActivity {

    Button btnViewOpdrachten;
    Button btnNewOpdracht;
    Button btnRegels;
    Button createUser;
    private Button btnTest;
    ImageView imageTestView;
    private RelativeLayout adminLayout;
    private String username = "";
    private boolean isAdmin = false;
    private static final int SELECT_PICTURE = 100;
    private static final String TAG = "MainMenu";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main_menu);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        //Get the values from the login screen
        Bundle extras = getIntent().getExtras();
        if (extras != null) {
            username = extras.getString("username");
            isAdmin = extras.getBoolean("isAdmin");
        }

        // The buttons
        btnViewOpdrachten = (Button) findViewById(R.id.btnViewOpdrachten);
        btnNewOpdracht = (Button) findViewById(R.id.btnNewOpdracht);
        btnRegels = (Button) findViewById(R.id.btnRegels);
        btnTest = (Button) findViewById(R.id.btnTest);
        createUser = (Button) findViewById(R.id.createUserButton);
        adminLayout = (RelativeLayout) findViewById(R.id.adminLayout);

        // If there is no admin, uncomment
        //isAdmin = true;

        enableButtons(isAdmin);

        btnRegels.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(getApplicationContext(), Rules.class);
                startActivity(i);
            }
        });

        btnNewOpdracht.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(getApplicationContext(), AddOpdracht.class);
                startActivity(i);
            }
        });

        //view opdrachten click event
        btnViewOpdrachten.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(getApplicationContext(), show_opdrachten.class);
                i.putExtra("username", username);
                startActivity(i);
            }
        });

        createUser.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(getApplicationContext(), AddUser.class);
                startActivity(i);
            }
        });

        btnTest.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(getApplicationContext(), testActivity.class);
                startActivity(i);
            }
        });
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_main, menu);
        MenuItem userItem = (MenuItem) menu.findItem(R.id.action_bar_user_name);
        MenuItem bugsItem = (MenuItem) menu.findItem(R.id.action_settings);
        userItem.setTitle(username);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem menuItem) {
        switch (menuItem.getItemId()) {
            case R.id.action_settings:
                Intent i = new Intent(getApplicationContext(), BugsAndIssues.class);
                startActivity(i);
                return true;
            default:
                return super.onOptionsItemSelected(menuItem);
        }
    }

    private void enableButtons(boolean isAdmin) {
        if (isAdmin) {
            //btnNewOpdracht.setVisibility(View.VISIBLE);
            //createUser.setVisibility(View.VISIBLE);
            adminLayout.setVisibility(View.VISIBLE);
        }
    }

    private void openImageChooser() {
        Intent intent = new Intent();
        intent.setType("image/*");
        intent.setAction(Intent.ACTION_GET_CONTENT);
        startActivityForResult(Intent.createChooser(intent, "Select Picture"), SELECT_PICTURE);
    }

    public void onActivityResult(int requestcode, int resultcode, Intent data) {
        if (resultcode == RESULT_OK) {
            if (requestcode == SELECT_PICTURE) {
                Uri selectedImageUri = data.getData();
                if (null != selectedImageUri) {
                    String path = getPathFromURI(selectedImageUri);
                    Log.i(TAG, "Image Path: : " + path);
                    imageTestView.setImageURI(selectedImageUri);
                }
            }
        }
    }

    public String getPathFromURI(Uri contentUri) {
        String res = null;
        String[] proj = {MediaStore.Images.Media.DATA};
        Cursor cursor = getContentResolver().query(contentUri, proj, null, null, null);
        if (cursor.moveToFirst()) {
            int column_index = cursor.getColumnIndexOrThrow(MediaStore.Images.Media.DATA);
            res = cursor.getString(column_index);
        }
        cursor.close();
        return res;
    }
}
