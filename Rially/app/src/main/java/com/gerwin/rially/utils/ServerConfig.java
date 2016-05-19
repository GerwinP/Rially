package com.gerwin.rially.utils;

/**
 * Created by Gerwin on 19-5-2016.
 */
public class ServerConfig {

    private static final String getAllOpdrachten = "http://10.0.2.2/rially/own_android_connect/get_all_opdrachten.php";
    private static final String createOpdracht = "http://10.0.2.2/rially/own_android_connect/create_opdracht.php";

    public static String getGetAllOpdrachten () { return getAllOpdrachten; }

    public static String getCreateOpdracht () { return createOpdracht; }
}
