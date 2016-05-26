package com.gerwin.rially.utils;

import android.widget.CheckBox;
import android.widget.TextView;

import org.w3c.dom.Text;

/**
 * Created by Gerwin on 25-5-2016.
 */
public class OpdrachtViewHolder {

    private CheckBox checkBox;
    private TextView textViewOpdracht;
    private TextView textViewID;

    public OpdrachtViewHolder(TextView textViewOpdracht, TextView textViewID, CheckBox checkBox) {
        this.checkBox = checkBox;
        this.textViewID = textViewID;
        this.textViewOpdracht = textViewOpdracht;
    }

    public CheckBox getCheckBox() {
        return this.checkBox;
    }

    public void setCheckBox(CheckBox checkBox) {
        this.checkBox = checkBox;
    }

    public TextView getTextViewOpdracht() {
        return this.textViewOpdracht;
    }

    public void setTextViewOpdracht(TextView textViewOpdracht) {
        this.textViewOpdracht = textViewOpdracht;
    }

    public TextView getTextViewID() {
        return this.textViewID;
    }

    public void setTextViewID(TextView textViewID) {
        this.textViewID = textViewID;
    }
}
