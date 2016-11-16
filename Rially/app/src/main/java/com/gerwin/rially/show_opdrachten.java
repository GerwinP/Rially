package com.gerwin.rially;

import android.app.Activity;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.app.SharedElementCallback;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.provider.MediaStore;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Base64;
import android.util.Log;
import android.util.Pair;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.gerwin.rially.utils.Opdracht;
import com.gerwin.rially.utils.OpdrachtArrayAdapter;
import com.gerwin.rially.utils.OpdrachtViewHolder;
import com.gerwin.rially.utils.ServerConfig;
import com.gerwin.rially.utils.JSONTags;
import com.gerwin.rially.utils.Utils;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.ByteArrayOutputStream;
import java.io.DataOutputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.lang.reflect.Array;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Hashtable;
import java.util.List;
import java.util.Map;
import java.util.jar.Manifest;

public class show_opdrachten extends AppCompatActivity {

    private ArrayAdapter<Opdracht> opdrachtAdapter;
    List<Opdracht> opdrachtenAdapterList;
    private ListView opdrachtList;
    private Button btnChooseImage;
    private Button uploadFoto;
    private ImageView imageView;
    private static final int SELECT_PICTURE = 100;
    private static final String TAG = "show_opdrachten";
    private String username = "";
    private Bitmap bitmap;
    private String modifierids = "";
    private TextView noOpdrachten;
    private FloatingActionButton fab;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_show_opdrachten);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);

        fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                uploadImage();
            }
        });

        Bundle extras = getIntent().getExtras();
        if (extras != null) {
            username = extras.getString("username");
        }

        opdrachtenList = new ArrayList<>();

        AsyncTask<String, String, String> task = new LoadAllOpdrachten();
        task.execute();

        imageView = (ImageView) findViewById(R.id.imageView);
        btnChooseImage = (Button) findViewById(R.id.buttonChooseImage);
        btnChooseImage.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                openImageChooser();
            }
        });
        noOpdrachten = (TextView) findViewById(R.id.noopdrachtentext);
        uploadFoto = (Button) findViewById(R.id.uploadImage);
        uploadFoto.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                uploadImage();
            }
        });

    }

    public void setItemClickListeners() {
        show_opdrachten.this.opdrachtList = (ListView) findViewById(R.id.opdrachtenList);
        show_opdrachten.this.opdrachtList.setAdapter(opdrachtAdapter);
        opdrachtList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View item, int position, long id) {
                Opdracht opdracht = opdrachtAdapter.getItem(position);
                opdracht.toggleChecked();
                OpdrachtViewHolder viewHolder = (OpdrachtViewHolder) item.getTag();
                viewHolder.getCheckBox().setChecked(opdracht.isChecked());
            }
        });
    }

    private void openImageChooser() {
        int MY_PERMISSIONS_REQUEST_READ_EXTERNAL_STORAGE = 1;
        Intent intent = new Intent();
        intent.setType("image/*");
        intent.setAction(Intent.ACTION_GET_CONTENT);
        if (Build.VERSION.SDK_INT == 23 &&
                checkSelfPermission(android.Manifest.permission.READ_EXTERNAL_STORAGE) != PackageManager.PERMISSION_GRANTED) {
            if (shouldShowRequestPermissionRationale(android.Manifest.permission.READ_EXTERNAL_STORAGE)) {

            }

            requestPermissions(new String[]{android.Manifest.permission.READ_EXTERNAL_STORAGE},
                    MY_PERMISSIONS_REQUEST_READ_EXTERNAL_STORAGE);

        }
        startActivityForResult(Intent.createChooser(intent, "Select Picture"), SELECT_PICTURE);
    }

    public void onActivityResult(int requestcode, int resultcode, Intent data) {
        int scaleFactor = 6;
        if (resultcode == RESULT_OK) {
            if (requestcode == SELECT_PICTURE) {
                Uri selectedImageUri = data.getData();
                if (null != selectedImageUri) {
                    String path = getPathFromURI(selectedImageUri);
                    try {
                        BitmapFactory.Options bitmapOptions = new BitmapFactory.Options();
                        bitmapOptions.inSampleSize = scaleFactor;
                        InputStream inputStream = getContentResolver().openInputStream(selectedImageUri);
                        bitmap = BitmapFactory.decodeStream(inputStream, null, bitmapOptions);
                    } catch (IOException e) {
                        System.out.println("Something with the image went wrong");
                    }
                    Log.i(TAG, "Image Path: " + path);
                    imageView.setImageBitmap(bitmap);
                    btnChooseImage.setVisibility(View.GONE);
                    opdrachtList.setVisibility(View.VISIBLE);
                    //uploadFoto.setVisibility(View.VISIBLE);
                    fab.setVisibility(View.VISIBLE);
                }
            }
        }
    }

    private String url_upload_image = ServerConfig.getUploadImage();

    private String KEY_IMAGE = "image";
    private String KEY_USERNAME = "username";
    private String KEY_OPDRACHTIDS = "opdracht_ids";
    private String KEY_MODIFIERIDS = "modifier_ids";

    private void uploadImage() {
        //Showing the progress dialog
        final ProgressDialog loading = ProgressDialog.show(this,"Uploading...","Please wait...",false,false);
        StringRequest stringRequest = new StringRequest(Request.Method.POST, url_upload_image,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String s) {

                        String message = "";

                        try {
                            JSONObject jobj = new JSONObject(s);
                            String jmessage = jobj.getString("message");
                            message = jmessage.toString();
                        } catch (JSONException e){
                            e.printStackTrace();
                        }

                        //Dismissing the progress dialog
                        loading.dismiss();
                        //Showing toast message of the response
                        System.out.println("RESPONSE: " + s);
                        Toast.makeText(show_opdrachten.this, message , Toast.LENGTH_LONG).show();
                        finish();
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError volleyError) {
                        //Dismissing the progress dialog
                        loading.dismiss();
                        //Showing toast
                        Toast.makeText(show_opdrachten.this, "Er is iets niet goed gegaan", Toast.LENGTH_LONG).show();
                    }
                }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                //Converting Bitmap to String
                String image = getStringImage(bitmap);

                //Creating parameters
                Map<String,String> params = new Hashtable<>();

                //Adding parameters
                params.put(KEY_IMAGE, image);
                params.put(KEY_OPDRACHTIDS, getOpdrachtIDs());
                params.put(KEY_USERNAME, username);
                params.put(KEY_MODIFIERIDS, modifierids);

                //returning parameters
                return params;
            }
        };
        //Creating a Request Queue
        RequestQueue requestQueue = Volley.newRequestQueue(this);

        //Adding request to the queue
        requestQueue.add(stringRequest);
    }


    private ProgressDialog progressDialog;

    ArrayList<HashMap<String, String>> opdrachtenList;

    private static String url_all_opdrachten = ServerConfig.getGetAllOpdrachten();

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

        boolean setVisibility = false;

        protected String doInBackground(String... args) {

            HttpURLConnection connection = null;
            try {
                URL url = new URL(url_all_opdrachten);
                connection = (HttpURLConnection) url.openConnection();
                connection.connect();
                int response = connection.getResponseCode();
                InputStream inputStream = connection.getInputStream();
                String contentAsString = Utils.readIt(inputStream);
                JSONObject json = new JSONObject(contentAsString);
                int success = (int) json.get(JSONTags.TAG_SUCCESS.tag());
                if (success == 1) {
                    opdrachten = json.getJSONArray(JSONTags.TAG_OPDRACHTEN.tag());

                    for (int i = 0; i < opdrachten.length(); i++) {
                        JSONObject c = opdrachten.getJSONObject(i);

                        String id = c.getString(JSONTags.TAG_ID.tag());
                        String opdracht = c.getString(JSONTags.TAG_OPDRACHT.tag());

                        HashMap<String, String> map = new HashMap<>();
                        map.put(JSONTags.TAG_ID.tag(), id);
                        map.put(JSONTags.TAG_OPDRACHT.tag(), opdracht);
                        opdrachtenList.add(map);
                    }
                } else {
                    setVisibility = true;
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

        protected void onPostExecute(String file_url) {
            progressDialog.dismiss();
            opdrachtenAdapterList = new ArrayList<>();
            for (HashMap<String, String> opdracht : opdrachtenList) {
                int id = -1;
                String opdrachtString = null;
                for (Map.Entry<String, String> mapentry : opdracht.entrySet()) {
                    String key = mapentry.getKey();
                    if (key.equals(JSONTags.TAG_ID.tag())) {
                        id = Integer.parseInt(mapentry.getValue());
                    } else if (key.equals(JSONTags.TAG_OPDRACHT.tag())) {
                        opdrachtString = mapentry.getValue();
                    }
                }
                if (id != -1 && opdrachtString != null) {
                    Opdracht tempOpdracht = new Opdracht(opdrachtString, id);
                    opdrachtenAdapterList.add(tempOpdracht);
                }
            }
            if (setVisibility) {
                noOpdrachten.setVisibility(View.VISIBLE);
            }
            show_opdrachten.this.opdrachtAdapter = new OpdrachtArrayAdapter(show_opdrachten.this, opdrachtenAdapterList);
            show_opdrachten.this.setItemClickListeners();
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

    public String getStringImage(Bitmap bitmap) {
        ByteArrayOutputStream baos = new ByteArrayOutputStream();
        bitmap.compress(Bitmap.CompressFormat.JPEG, 100, baos);
        byte[] imageBytes = baos.toByteArray();
        String encodedImage = Base64.encodeToString(imageBytes, Base64.DEFAULT);
        return encodedImage;
    }

    public String getOpdrachtIDs () {
        StringBuilder sb = new StringBuilder();
        int i;
        for (i = 0; i < opdrachtAdapter.getCount(); i++) {
            Opdracht tempOpdracht = opdrachtAdapter.getItem(i);
            if (tempOpdracht.isChecked()) {
                sb.append(tempOpdracht.getId());
                if (i != opdrachtAdapter.getCount()-1) {
                    sb.append(",");
                }
            }
        }
        String ids = sb.toString();
        if (ids.length() > 1 && ids.charAt(ids.length()-1) == ',') {
            ids = ids.substring(0, ids.length()-1);
        }
        return ids;
    }
}
