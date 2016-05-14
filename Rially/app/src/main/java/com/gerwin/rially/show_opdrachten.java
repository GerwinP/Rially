package com.gerwin.rially;

import android.app.ListActivity;
import android.app.ProgressDialog;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;

import org.json.JSONArray;
import org.json.JSONObject;

public class show_opdrachten extends ListActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_show_opdrachten);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        //setSupportActionBar(toolbar);

        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Snackbar.make(view, "Replace with your own action", Snackbar.LENGTH_LONG)
                        .setAction("Action", null).show();
            }
        });
    }

    private ProgressDialog progressDialog;

    JSONObject jsonObject = new JSONObject();

    private static String url_all_opdrachten = "http://localhost/rially/own_android_connect/get_all_opdrachten.php";

    //JSON Node names
    private static final String TAG_SUCCESS = "success";
    private static final String TAG_OPDRACHTEN = "opdrachten";
    private static final String TAG_ID = "id";
    private static final String TAG_OPDRACHT = "opdracht";

    // products JSONArray
    JSONArray opdrachten = null;


}