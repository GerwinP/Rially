package com.gerwin.rially.utils;

/**
 * Created by Gerwin on 19-5-2016.
 * Enum for the JSON tags
 */
public enum JSONTags {
    TAG_SUCCESS ("success"),
    TAG_OPDRACHTEN ("opdrachten"),
    TAG_ID ("id"),
    TAG_OPDRACHT ("opdracht"),
    TAG_USERS ("users"),
    TAG_UID ("uid"),
    TAG_NAME ("username"),
    TAG_PASSWORD ("password"),
    TAG_MESSAGE ("message"),
    TAG_ADMIN ("isAdmin");

    private final String tag;

    JSONTags(String tag) {
        this.tag = tag;
    }

    public String tag() { return this.tag; };

}

