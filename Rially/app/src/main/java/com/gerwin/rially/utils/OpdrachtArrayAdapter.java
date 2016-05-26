package com.gerwin.rially.utils;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.CheckBox;
import android.widget.TextView;

import com.gerwin.rially.R;

import java.util.List;

/**
 * Created by Gerwin on 25-5-2016.
 */
public class OpdrachtArrayAdapter extends ArrayAdapter<Opdracht> {

    private LayoutInflater inflater;

    public OpdrachtArrayAdapter(Context context, List<Opdracht> opdrachtList ) {
        super( context, R.layout.list_item, R.id.opdracht, opdrachtList);
        inflater = LayoutInflater.from(context);
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        Opdracht opdracht = this.getItem(position);

        CheckBox checkBox;
        TextView textViewID;
        TextView textViewOpdracht;

        if (convertView == null) {
            convertView  = inflater.inflate(R.layout.list_item, null);

            //find the childviews
            textViewID = (TextView) convertView.findViewById(R.id.oid);
            textViewOpdracht = (TextView) convertView.findViewById(R.id.opdracht);
            checkBox = (CheckBox) convertView.findViewById(R.id.checkOpdracht);

            convertView.setTag(new OpdrachtViewHolder(textViewOpdracht, textViewID, checkBox));

            //if checkbox is toggled, update the opdracht
            checkBox.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    CheckBox cb = (CheckBox) view;
                    Opdracht opdracht = (Opdracht) cb.getTag();
                    opdracht.setChecked(cb.isChecked());
                }
            });
        } else {
            OpdrachtViewHolder viewHolder = (OpdrachtViewHolder) convertView.getTag();
            checkBox = viewHolder.getCheckBox();
            textViewID = viewHolder.getTextViewID();
            textViewOpdracht = viewHolder.getTextViewOpdracht();
        }

        checkBox.setTag(opdracht);

        checkBox.setChecked(opdracht.isChecked());
        textViewID.setText(Integer.toString(opdracht.getId()));
        textViewOpdracht.setText(opdracht.getOpdracht());

        return convertView;
    }
}
