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
import android.widget.CheckBox;
import android.widget.EditText;

import com.gerwin.rially.utils.JSONTags;
import com.gerwin.rially.utils.ServerConfig;
import com.gerwin.rially.utils.Utils;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedOutputStream;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.URL;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.ArrayList;
import java.util.List;

public class AddUser extends AppCompatActivity {

    private EditText usernameField;
    private EditText passwordField;
    private Button addUser;
    private CheckBox isAdminBox;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_user);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        usernameField = (EditText) findViewById(R.id.createUsername);
        passwordField = (EditText) findViewById(R.id.createPassword);
        addUser = (Button) findViewById(R.id.createUser);
        isAdminBox = (CheckBox) findViewById(R.id.isAdminCheck);

        addUser.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                new AddUserEx().execute();
                addUser.setClickable(false);
            }
        });
    }

    private static final String url_create_user = ServerConfig.getAddUser();
    private ProgressDialog progressDialog;

    class AddUserEx extends AsyncTask<String, String, String> {

        private String username = usernameField.getText().toString();
        private String hpassword = hashPassword();
        private boolean isChecked = isAdminBox.isChecked();
        private int isCheckedInt = 0;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            progressDialog = new ProgressDialog(AddUser.this);
            progressDialog.setMessage("Adding user");
            progressDialog.setIndeterminate(false);
            progressDialog.setCancelable(true);
            progressDialog.show();
        }

        @Override
        protected String doInBackground(String... args) {
            List<Pair<String, String>> params = new ArrayList<>();
            HttpURLConnection connection = null;

            if (isChecked) {
                isCheckedInt = 1;
            }

            try {
                params.add(new Pair("username", username));
                params.add(new Pair("hpassword", hpassword));
                params.add(new Pair("isAdmin", Integer.toString(isCheckedInt)));
                URL url = new URL(url_create_user);
                connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setRequestProperty("username", username);
                connection.setRequestProperty("hpassword", hpassword);
                connection.setRequestProperty("isAdmin", Integer.toString(isCheckedInt));

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
                    //Intent i = new Intent(getApplicationContext(), MainMenu.class);
                    //startActivity(i);
                    finish();
                }
            } catch (IOException | JSONException e) {
                e.printStackTrace();
            } finally {
                if (connection != null) {
                    connection.disconnect();
                }
            }
            return null;
        }

        @Override
        protected void onPostExecute(String file_url) { progressDialog.dismiss(); }
    }

    private String hashPassword() {
        try {
            MessageDigest md = MessageDigest.getInstance("SHA-256");
            md.update(passwordField.getText().toString().getBytes());

            byte byteDat[] = md.digest();

            //convert the byte to hex format
            StringBuffer sb = new StringBuffer();
            for (int i = 0; i < byteDat.length; i++) {
                sb.append(Integer.toString((byteDat[i] & 0xff) + 0x100, 16).substring(1));
            }
            return sb.toString();
        } catch (NoSuchAlgorithmException e) {

        }
        return "";
    }
}
