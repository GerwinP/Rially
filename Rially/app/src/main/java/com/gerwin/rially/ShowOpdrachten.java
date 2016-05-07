package com.gerwin.rially;

import android.app.ListActivity;
import android.app.ProgressDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.google.gson.JsonParser;

public class ShowOpdrachten extends ListActivity {

    // Progress dialog
    private ProgressDialog pDialog;

    // Creating JSON Parser object
    JsonParser jParser = new JsonParser();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_show_opdrachten);
    }
}
