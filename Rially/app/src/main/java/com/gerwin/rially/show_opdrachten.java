package com.gerwin.rially;

import android.app.ListActivity;
import android.app.ProgressDialog;
import android.content.ContentValues;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Pair;
import android.view.View;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.SimpleAdapter;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import org.json.JSONTokener;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.Reader;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URI;
import java.net.URISyntaxException;
import java.net.URL;
import java.net.URLConnection;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

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

        opdrachtenList = new ArrayList<>();

        new LoadAllOpdrachten().execute();

        ListView lv = getListView();

    }

    private ProgressDialog progressDialog;

    JSONObject jsonObject = new JSONObject();

    ArrayList<HashMap<String, String>> opdrachtenList;

    private static String url_all_opdrachten = "http://localhost/rially/own_android_connect/get_all_opdrachten.php";

    //JSON Node names
    private static final String TAG_SUCCESS = "success";
    private static final String TAG_OPDRACHTEN = "opdrachten";
    private static final String TAG_ID = "id";
    private static final String TAG_OPDRACHT = "opdracht";

    // products JSONArray
    JSONArray opdrachten = null;

    class LoadAllOpdrachten extends AsyncTask<String, String, String> {

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            progressDialog = new ProgressDialog(show_opdrachten.this);
            progressDialog.setMessage("Loading opdrachten: Please wait...");
            progressDialog.setIndeterminate(false);
            progressDialog.setCancelable(false);
            progressDialog.show();
        }

        protected String doInBackground(String... args) {
            //alternative to namevaluepair
            //List<Pair<String, String>> params = new ArrayList<>();
            //params.add(new Pair<>("username", username));
            //params.add(new Pair<>("password", password));
            List<Pair<String, String>> params = new ArrayList<>();

            try {
                URL url = new URL(url_all_opdrachten);
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.connect();
                int response = connection.getResponseCode();
                InputStream inputStream = connection.getInputStream();
                String contentAsString = readIt(inputStream);
                JSONObject json = new JSONObject(contentAsString);
                int success = (int) json.get(TAG_SUCCESS);
                if (success == 1) {
                    opdrachten = json.getJSONArray(TAG_OPDRACHTEN);

                    for (int i = 0; i < opdrachten.length(); i++) {
                        JSONObject c = opdrachten.getJSONObject(i);

                        String id = c.getString(TAG_ID);
                        String opdracht = c.getString(TAG_OPDRACHT);

                        HashMap<String, String> map = new HashMap<>();
                        map.put(TAG_ID, id);
                        map.put(TAG_OPDRACHT, opdracht);
                        opdrachtenList.add(map);
                    }
                } else {
                    // no products found
                    // Eventually launch Add new Opdracht actvity
                }
            } catch (IOException | JSONException e) {
                e.printStackTrace();
            }
            return null;
        }

        protected void onPostExecute(String file_url) {
            progressDialog.dismiss();
            runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    ListAdapter adapter = new SimpleAdapter(
                            show_opdrachten.this, opdrachtenList,
                            R.layout.list_item, new String[] {TAG_ID, TAG_OPDRACHT} ,
                            new int[] {R.id.oid, R.id.opdracht}
                    );
                    setListAdapter(adapter);
                }
            });
        }
    }

    private String readIt(InputStream is) throws IOException {
        BufferedReader reader = null;
        reader = new BufferedReader(new InputStreamReader(is, "UTF-8"));
        StringBuilder responseStrBuilder = new StringBuilder();
        String inputStr;
        while ((inputStr = reader.readLine()) != null) {
            responseStrBuilder.append(inputStr);
        }
        return responseStrBuilder.toString();
    }

}
