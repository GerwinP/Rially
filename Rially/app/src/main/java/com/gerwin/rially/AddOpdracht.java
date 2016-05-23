package com.gerwin.rially;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Pair;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

import com.gerwin.rially.utils.JSONTags;
import com.gerwin.rially.utils.ServerConfig;
import com.gerwin.rially.utils.Utils;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedOutputStream;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.List;

public class AddOpdracht extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_opdracht);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        inputOpdracht = (EditText) findViewById(R.id.opdrachtText);

        final Button createOpdracht = (Button) findViewById(R.id.createOpdracht);

        createOpdracht.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                new AddOpdrachtEx().execute();
                createOpdracht.setClickable(false);
            }
        });

        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Snackbar.make(view, "Replace with your own action", Snackbar.LENGTH_LONG)
                        .setAction("Action", null).show();
            }
        });
    }

    private static final String url_create_opdracht = ServerConfig.getCreateOpdracht();

    private ProgressDialog progressDialog;

    JSONObject jsonObject = new JSONObject();

    EditText inputOpdracht;

    class AddOpdrachtEx extends AsyncTask<String, String, String> {

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            progressDialog = new ProgressDialog(AddOpdracht.this);
            progressDialog.setMessage("Creating opdracht...");
            progressDialog.setIndeterminate(false);
            progressDialog.setCancelable(true);
            progressDialog.show();
        }

        String opdracht = inputOpdracht.getText().toString();

        @Override
        protected String doInBackground(String... args) {
            //String opdracht = inputOpdracht.getText().toString();

            List<Pair<String, String>> params = new ArrayList<>();
            HttpURLConnection connection = null;
            try {
                params.add(new Pair("opdracht", opdracht));
                URL url = new URL(url_create_opdracht);
                connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setRequestProperty("opdracht", opdracht);
                connection.setDoOutput(true);

                OutputStream outputpost = new BufferedOutputStream(connection.getOutputStream());
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(outputpost, "UTF-8"));
                writer.write(Utils.getQuery(params));
                writer.flush();
                writer.close();
                outputpost.close();
                connection.connect();
                int response = connection.getResponseCode();

                InputStream inputStream = connection.getInputStream();
                String contentAsString = Utils.readIt(inputStream);
                JSONObject json = new JSONObject(contentAsString);
                int success = (int)json.get(JSONTags.TAG_SUCCESS.tag());
                if (success == 1) {
                    Intent i = new Intent(getApplicationContext(), show_opdrachten.class);
                    startActivity(i);
                    finish();
                }

            } catch (IOException e) {
                e.printStackTrace();
            } catch (JSONException e) {
                e.printStackTrace();
            } finally {
                if (connection != null) {
                    connection.disconnect();
                }
            }
            return null;
        }

        protected  void onPostExecute(String file_url) {
            progressDialog.dismiss();
        }
    }
}
