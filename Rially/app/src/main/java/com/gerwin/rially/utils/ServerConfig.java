package com.gerwin.rially.utils;

/**
 * Created by Gerwin on 19-5-2016.
 */
public class ServerConfig {

    private static final String serveraddress = "130.89.161.72";
    private static final String piAddress = "130.89.160.236";
    private static final String thuisAddress = "192.168.2.10";
    private static final String laptopAddress = "192.168.2.15";
    private static final String localaddress = "10.0.2.2";
    private static final String local = "127.0.0.1";
    private static final String[] addresses = {piAddress, serveraddress, thuisAddress, laptopAddress, localaddress, local};
    private static final int x = 0;

    public static String getGetAllOpdrachten () { return "http://" + addresses[x] + "/rially/android/get_all_opdrachten.php"; }

    public static String getCreateOpdracht () { return "http://" + addresses[x] + "/rially/android/create_opdracht.php"; }

    public static String getLogIn () { return "http://" + addresses[x] + "/rially/android/login.php"; }

    public static String getAddUser () { return "http://" + addresses[x] + "/rially/android/create_user.php"; }

    public static String getUploadImage () { return "http://" + addresses[x] + "/rially/android/upload_image.php"; }
}
