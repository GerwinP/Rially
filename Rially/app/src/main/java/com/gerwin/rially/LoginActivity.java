package com.gerwin.rially;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Pair;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

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

public class LoginActivity extends AppCompatActivity {

    private Button loginButton;
    private EditText usernameField;
    private EditText passwordField;
    public TextView wrongpasswordtext;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        //Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        //setSupportActionBar(toolbar);

        loginButton = (Button) findViewById(R.id.submit);
        usernameField = (EditText) findViewById(R.id.username);
        passwordField = (EditText) findViewById(R.id.password);
        wrongpasswordtext = (TextView) findViewById(R.id.wrongpasswordtext);

        loginButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //-Temp: if there is no user in the db, it skips the login check-//
                //Intent i = new Intent(getApplicationContext(), MainMenu.class);
                //startActivity(i);
                //---
                new LogIn().execute();
            }
        });
    }

    private ProgressDialog progressDialog;

    private static String url_login = ServerConfig.getLogIn();

    class LogIn extends AsyncTask<String, String, String> {

        private String username = usernameField.getText().toString();
        private int success = 0;
        boolean isAdmin = false;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            progressDialog = new ProgressDialog(LoginActivity.this);
            progressDialog.setMessage("Logging in");
            progressDialog.setIndeterminate(false);
            progressDialog.setCancelable(false);
            progressDialog.show();
        }

        @Override
        protected String doInBackground(String... args) {
            List<Pair<String, String>> params = new ArrayList<>();
            HttpURLConnection connection = null;
            try {
                String hpassword = hashPassword();
                params.add(new Pair("username", username));
                params.add(new Pair("hpassword", hpassword));
                URL url = new URL(url_login);
                connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setRequestProperty("username", username);
                connection.setRequestProperty("hpassword", hpassword);
                connection.setDoOutput(true);

                OutputStream outputpost = new BufferedOutputStream(connection.getOutputStream());
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(outputpost, "UTF-8"));
                writer.write(Utils.getQuery(params));
                writer.flush();
                writer.close();
                outputpost.close();

                connection.connect();

                InputStream inputStream = connection.getInputStream();
                String contentAsString = Utils.readIt(inputStream);
                JSONObject json = new JSONObject(contentAsString);
                success = (int)json.get(JSONTags.TAG_SUCCESS.tag());
                if (success == 1) {
                    int isAdminint = Integer.parseInt((String)json.get(JSONTags.TAG_ADMIN.tag()));
                    //System.out.println("The isAdmin is: " + isAdminint.toString());
                    if (isAdminint != 0) {
                        isAdmin = true;
                    }
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
        protected void onPostExecute(String file_url) {
            progressDialog.dismiss();
            if (success == 1) {
                Intent i = new Intent(getApplicationContext(), MainMenu.class);
                i.putExtra("username", username);
                i.putExtra("isAdmin", isAdmin);
                startActivity(i);
                finish();
            } else {
                wrongpasswordtext.setVisibility(View.VISIBLE);
            }
        }

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
