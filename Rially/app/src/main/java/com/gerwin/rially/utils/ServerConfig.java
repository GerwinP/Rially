package com.gerwin.rially.utils;

/**
 * Created by Gerwin on 19-5-2016.
 */
public class ServerConfig {

    private static final String serveradress = "130.89.161.72";
    private static final String thuisAddress = "192.168.2.10";
    private static final String laptopAddress = "192.168.2.15";
    private static final String localadress = "10.0.2.2";
    private static final String local = "127.0.0.1";
    private static final String HTTP = "http://";
    private static final String LINK = "/rially/own_android_connect/";


    private static final String getAllOpdrachten = "http://" + laptopAddress + "/rially/own_android_connect/get_all_opdrachten.php";
    private static final String createOpdracht = "http://" + laptopAddress + "/rially/own_android_connect/create_opdracht.php";
    private static final String logIn = "http://" + laptopAddress + "/rially/own_android_connect/login.php";
    private static final String addUser = "http://" + laptopAddress + "/rially/own_android_connect/create_user.php";
    private static final String uploadImage = "http://" + laptopAddress + "/rially/own_android_connect/upload_image.php";

    public static String getGetAllOpdrachten () { return getAllOpdrachten; }

    public static String getCreateOpdracht () { return createOpdracht; }

    public static String getLogIn () { return logIn; }

    public static String getAddUser () { return addUser; }

    public static String getUploadImage () { return uploadImage; }
}
