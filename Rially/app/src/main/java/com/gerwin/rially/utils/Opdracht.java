package com.gerwin.rially.utils;

/**
 * Created by Gerwin on 25-5-2016.
 */
public class Opdracht {

    private String opdracht = "";
    private int id;
    boolean checked = false;

    public Opdracht (String opdracht, int id) {
        this.opdracht = opdracht;
        this.id = id;
    }

    public String getOpdracht () {
        return this.opdracht;
    }

    public int getId () {
        return this.id;
    }

    public boolean isChecked() {
        return checked;
    }

    public void setChecked(boolean checked) {
        this.checked = checked;
    }

    public void toggleChecked() {
        checked = !checked;
        System.out.println("Toggled opdracht " + getOpdracht() + " to checked");
    }
}
