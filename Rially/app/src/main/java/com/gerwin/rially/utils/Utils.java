package com.gerwin.rially.utils;

import android.util.Pair;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.List;

/**
 * Created by Gerwin on 23-5-2016.
 */
public class Utils {

    /**
     * Reads an InputStream and returns it as a String
     * @param is
     * @return returns the String of the content of the InputStream
     * @throws IOException
     */
    public static String readIt(InputStream is) throws IOException {
        BufferedReader reader = null;
        reader = new BufferedReader(new InputStreamReader(is, "UTF-8"));
        StringBuilder responseStrBuilder = new StringBuilder();
        String inputStr;
        while ((inputStr = reader.readLine()) != null) {
            responseStrBuilder.append(inputStr);
        }
        return responseStrBuilder.toString();
    }

    /**
     * Builds a String query from a list of pairs.
     * @param params, the list of pairs containing the query parameters
     * @return the full query as a String
     * @throws UnsupportedEncodingException
     */
    public static String getQuery(List<Pair<String, String>> params) throws UnsupportedEncodingException {
        StringBuilder result = new StringBuilder();
        boolean first = true;
        for (Pair pair : params) {
            if (first) {
                first = false;
            } else {
                result.append("&");
            }
            result.append(URLEncoder.encode((String)pair.first, "UTF-8"));
            result.append("=");
            result.append(URLEncoder.encode((String)pair.second, "UTF-8"));
        }

        return result.toString();
    }
}
